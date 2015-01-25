<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 16/10/2014
 * Time: 3:10 μμ
 */

namespace bestprice;

if ( ! defined( 'WPINC' ) ) {
	exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );
}

/**
 * Class bestprice
 * @package bestprice
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since 150120
 */
class bestprice extends framework {
	public $doDebugRun = false;
	/**
	 * @var int
	 */
	protected $progress = 0;
	/**
	 * @var int
	 */
	protected $progressUpdateInterval = 5;

	protected $is_fashion_store = false;
	protected $is_book_store = false;

	public function __construct( $instance ) {
		parent::__construct( $instance );

		$this->is_fashion_store = (bool) $this->©option->get( 'is_fashion_store' );
		$this->is_book_store    = (bool) $this->©option->get( 'is_book_store' );
	}

	/**
	 * @param $post_id
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	public function update_woo_product( $post_id ) {
		// If this is just a revision, don't send the email.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		$product = new \WC_Product( (int) $post_id );

		if ( ! $product->is_purchasable() || ! $product->is_visible() || ! $product->is_in_stock() ) {
			return;
		}

		$this->©xml->parseArray( array( $this->getProductArray( $product ) ) );
	}

	/**
	 * @return int
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	public function do_your_woo_stuff() {
		$sTime = microtime( true );
		ignore_user_abort( true );

		$this->©option->update( array( 'log' => array() ) );

		$this->©diagnostic->forceDBLog( 'product', array(), '<strong>BestPrice XML generation started at ' . date( 'd M, Y H:i:s' ) . '</strong>' );

		$productsArray = $this->createProductsArray();
		if ( ! $this->©xml->parseArray( $productsArray ) ) {
			$this->©notice->enqueue( 'There was an error generating XML for bestprice.gr at ' . $this->©env->time_details() . '. Please check your settings.' );
		}

		$this->©diagnostic->forceDBLog( 'product', array(), '<strong>BestPrice XML generation finished at ' . date( 'd M, Y H:i:s' ) . '</strong><br>Time taken: ' . round( microtime( true ) - $sTime, 2 ) . ' sec<br>Mem details: ' . $this->©env->memory_details() );

		return count( $productsArray );
	}

	/**
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	public function generate_and_print() {
		$schedules = wp_get_schedules();

		if ( isset( $schedules[ $this->©option->get( 'xml_interval' ) ] ) ) {
			$interval         = $schedules[ $this->©option->get( 'xml_interval' ) ]['interval'];
			$xmlCreation      = $this->©xml->getFileInfo();
			$createdTime      = strtotime( $xmlCreation['File Creation Datetime'] );
			$nextCreationTime = $interval + $createdTime;
			$time             = time();
			if ( $time > $nextCreationTime ) {
				$this->do_your_woo_stuff();
			}
		}

		$this->©xml->printXML();
		exit( 0 );
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	public function createProductsArray() {
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => - 1
		);
		$loop = new \WP_Query( $args );

		$mem = max( ceil( $loop->post_count * 0.4 ), 128 );
		ini_set( 'memory_limit', $mem . 'M' );
		$time = max( ceil( $loop->post_count * 0.5 ), 30 );
		set_time_limit( $time );

		$this->©diagnostic->forceDBLog( 'product', array(), 'Memory set to ' . $mem . 'M for current session<br>Time set to ' . $time . ' sec for current session' );

		$this->updateXMLGenerationProgress( 0 );
		$products = array();
		if ( $loop->have_posts() ) {
			$products = array();
			while ( $loop->have_posts() ) {
				$loop->the_post();

				$product = WC()->product_factory->get_product( (int) $loop->post->ID );

				if ( ! is_object( $product ) || ! ( $product instanceof \WC_Product ) ) {
					$this->©diagnostic->forceDBLog( 'product', $product, 'Product failed in ' . __METHOD__ );
					continue;
				}

				if ( ! $product->is_purchasable() || ! $product->is_visible() || $this->getAvailabilityString( $product ) === false ) {
					$reason = array();
					if ( ! $product->is_purchasable() ) {
						$reason[] = 'product is not purchasable';
					}
					if ( ! $product->is_visible() ) {
						$reason[] = 'product is not visible';
					}
					if ( $this->getAvailabilityString( $product ) === false ) {
						$reason[] = 'product is unavailable';
					}
					$this->©diagnostic->forceDBLog( 'product', array(
						'id'             => $product->id,
						'SKU'            => $product->get_sku(),
						'is_purchasable' => $product->is_purchasable(),
						'is_visible'     => $product->is_visible(),
						'availability'   => $this->getAvailabilityString( $product )
					), 'Product <strong>' . $product->get_formatted_name() . '</strong> failed. Reason(s) is(are): ' . implode( ', ', $reason ) );
					continue;
				}

				$products[] = $this->getProductArray( $product );
				$this->updateXMLGenerationProgress( count( $products ) / $loop->found_posts );
			}
		}
		wp_reset_postdata();

		$this->updateXMLGenerationProgress( 110 );

		return $products;
	}

	/**
	 * @param int $value
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function updateXMLGenerationProgress( $value ) {
		if ( $value < $this->progress + $this->progressUpdateInterval ) {
			return;
		}
		$this->progress = $value;
		$this->©option->update( array( 'xml.progress' => $this->progress ) );
	}

	/**
	 * @param \WC_Product $product
	 *
	 * @return array
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getProductArray( \WC_Product &$product ) {
		$out = array();

		$out['productId']  = $this->getProductId( $product );
		$out['title']      = $this->getProductName( $product );
		$out['productURL'] = $this->getProductLink( $product );
		// TODO Images may be an array. Check specs
		$out['imageURL'] = $this->getProductImageLink( $product );
		$out['price']    = $this->getProductPrice( $product );
		// TODO <categoryID>123<categoryID>
		// TODO This differs from skroutz <categoryPath>Υπολογιστές->Περιφερειακά->Εκτυπωτές</categoryPath>
		$out['categoryPath'] = $this->getProductCategories( $product );
		$out['brand']        = $this->getProductManufacturer( $product );
		$out['stock']        = $this->isInStock( $product );
		$out['availability'] = $this->getAvailabilityString( $product );
		$out['ΕΑΝ']          = $this->getProductMPN( $product );
		// TODO <netprice>1.500,30</netprice>
		// TODO <isBundle>Y</isBundle>

		$out['mpn'] = $this->getProductMPN( $product );

		if ( $product->product_type == 'variable' && $this->is_fashion_store ) {
			$variableProduct = new \WC_Product_Variable( $product );

			$colors = $this->getProductColors( $variableProduct );
			$sizes  = $this->getProductSizes( $variableProduct );

			if ( ! empty( $colors ) ) {
				$out['color'] = $colors;
			}

			if ( ! empty( $sizes ) ) {
				$out['size'] = $sizes;
			}
		} elseif ( $this->is_book_store ) {
			$isbn = $this->getProductISBN( $product );
			if ( $isbn ) {
				$out['ISBN'] = $isbn;
			}
		}

		return $out;
	}

	/**
	 * @param \WC_Product_Variable $product
	 *
	 * @return string
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getProductColors( \WC_Product_Variable &$product ) {
		if ( ! (bool) $this->©option->get( 'map_color_use' ) ) {
			return null;
		}

		$map    = $this->©option->get( 'map_color' );
		$colors = array();
		foreach ( $map as $attrId ) {
			$taxonomy = $this->getTaxonomyById( $attrId );

			if ( ! $taxonomy ) {
				break;
			}

			foreach ( $product->get_available_variations() as $variation ) {
				$key = 'attribute_' . wc_attribute_taxonomy_name( $taxonomy->attribute_name );
				if ( isset( $variation['attributes'][ $key ] ) && $variation['is_in_stock'] && $variation['is_purchasable'] ) {
					$color = $this->sanitizeVariationString( $variation['attributes'][ $key ] );
					if ( ! empty( $color ) ) {
						$colors[] = $color;
					}
				}
			}
		}

		$colors = array_unique( $colors );

		return implode( ', ', $colors );
	}

	/**
	 * @param \WC_Product $product
	 *
	 * @return null|string
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getProductISBN( \WC_Product &$product ) {
		$map = $this->©option->get( 'map_isbn' );
		if ( $map == 0 ) {
			return $product->get_sku();
		}

		return $this->getProductAttrValue( $product, $map, false );
	}

	/**
	 * @param $taxonomyId
	 *
	 * @return null
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getTaxonomyById( $taxonomyId ) {
		foreach ( wc_get_attribute_taxonomies() as $taxonomy ) {
			if ( $taxonomyId == $taxonomy->attribute_id ) {
				return $taxonomy;
			}
		}

		return null;
	}

	/**
	 * @param \WC_Product $product
	 *
	 * @return string
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getProductSizes( \WC_Product &$product ) {
		if ( ! (bool) $this->©option->get( 'map_size_use' ) ) {
			return null;
		}

		$map   = $this->©option->get( 'map_size' );
		$sizes = array();
		foreach ( $map as $attrId ) {
			$taxonomy = $this->getTaxonomyById( $attrId );

			if ( ! $taxonomy ) {
				break;
			}

			foreach ( $product->get_available_variations() as $variation ) {
				$key = 'attribute_' . wc_attribute_taxonomy_name( $taxonomy->attribute_name );
				if ( isset( $variation['attributes'][ $key ] ) && $variation['is_in_stock'] && $variation['is_purchasable'] ) {
					$size = $this->sanitizeVariationString( $variation['attributes'][ $key ] );
					if ( $this->isValidSizeString( $size ) ) {
						$sizes[] = $size;
					}
				}
			}
		}
		$sizes = array_unique( $sizes );

		return implode( ', ', $sizes );
	}

	/**
	 * @param $string
	 *
	 * @return mixed|string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function sanitizeVariationString( $string ) {
		$string = preg_replace( "/[^A-Za-z0-9 ]/", '.', strip_tags( trim( $string ) ) );
		$string = strtoupper( $string );

		return $string;
	}

	/**
	 * @param \WC_Product $product
	 *
	 * @return null|string
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getProductManufacturer( \WC_Product &$product ) {
		$option = $this->©option->get( 'map_manufacturer' );

		$manufacturer = '';
		if ( is_numeric( $option ) ) {
			$manufacturer = $this->getProductAttrValue( $product, $option, '' );
		}
		if ( empty( $manufacturer ) ) {
			$manufacturer = $this->getFormatedTextFromTerms( $product, $option );
		}

		return $manufacturer;
	}

	/**
	 * @param \WC_Product $product
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function isInStock( \WC_Product &$product ) {
		return $product->is_in_stock() ? 'Y' : 'N';
	}

	/**
	 * @param \WC_Product $product
	 *
	 * @return string
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getProductPrice( \WC_Product &$product ) {
		$option = $this->©option->get( 'map_price_with_vat' );

		switch ( $option ) {
			case 1:
				$price = $product->get_sale_price();
				break;
			case 2:
				$price = $product->get_price_excluding_tax();
				break;
			default:
				$price = $product->get_price();
				break;
		}
		// Fallback to product price in case other options return empty string
		if ( empty( $price ) ) {
			$price = $product->get_price();
		}

		return $price;
	}

	/**
	 * @param \WC_Product $product
	 *
	 * @return null|string
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getProductCategories( \WC_Product &$product ) {
		$option     = $this->©option->get( 'map_category' );
		$categories = '';
		if ( is_numeric( $option ) ) {
			$categories = $this->getProductAttrValue( $product, $option, '' );
		}
		if ( empty( $categories ) ) {
			$categories = $this->getFormatedTextFromTerms( $product, $option );
		}

		return $categories;
	}

	/**
	 * @param \WC_Product $product
	 *
	 * @return string
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getProductImageLink( \WC_Product &$product ) {
		$option = $this->©option->get( 'map_image' );

		// Maybe we will implement some additional functionality in the future
		$imageLink = '';
		if ( true || $option == 0 ) {
			$imageLink = wp_get_attachment_image_src( $product->get_image_id() );
			$imageLink = is_array( $imageLink ) ? $imageLink[0] : '';
		}

		return urldecode( $imageLink );
	}

	/**
	 * @param \WC_Product $product
	 *
	 * @return int|string
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getProductId( \WC_Product &$product ) {
		$option = $this->©option->get( 'map_id' );
		if ( $option == 0 ) {
			return $product->get_sku();
		} else {
			return $product->id;
		}
	}

	/**
	 * @param \WC_Product $product
	 *
	 * @return null|string
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getProductMPN( \WC_Product &$product ) {
		$option = $this->©option->get( 'map_mpn' );

		if ( $option == 0 ) {
			return $product->get_sku();
		}

		return $this->getProductAttrValue( $product, $option, $product->get_sku() );
	}

	/**
	 * @param \WC_Product $product
	 *
	 * @return string
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getProductLink( \WC_Product &$product ) {
		$option = $this->©option->get( 'map_link' );

		// Maybe we will implement some additional functionality in the future
		$link = '';
		if ( true || $option == 0 ) {
			$link = $product->get_permalink();
		}


		return urldecode( $link );
	}

	/**
	 * @param \WC_Product $product
	 *
	 * @return null|string
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getProductName( \WC_Product &$product ) {
		$option    = $this->©option->get( 'map_name' );
		$appendSKU = $this->©option->get( 'map_name_append_sku' );
		$name      = '';

		if ( $option != 0 ) {
			$name = $this->getProductAttrValue( $product, $option, '' );
		}

		if ( empty( $name ) ) {
			$name = $product->get_title();
		}

		$name = trim( $name );
		$pid  = $this->getProductId( $product );
		if ( $appendSKU && ! empty( $pid ) && ! is_numeric( strpos( $product->get_title(), $pid ) ) ) {
			$name .= ' ' . $pid;
		}

		return $name;
	}

	/**
	 * @param \WC_Product $product
	 * @param $attrId
	 * @param null $defaultValue
	 *
	 * @return null|string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getProductAttrValue( \WC_Product &$product, $attrId, $defaultValue = null ) {
		$return = $product->get_attribute( $this->getAttributeNameFromId( $attrId ) );

		return empty( $return ) ? $defaultValue : $return;
	}

	/**
	 * @param $attrId
	 *
	 * @return bool|string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getAttributeNameFromId( $attrId ) {
		foreach ( wc_get_attribute_taxonomies() as $taxonomy ) {
			if ( $taxonomy->attribute_id == $attrId ) {
				return trim( $taxonomy->attribute_name );
			}
		}

		return false;
	}

	/**
	 * @param \WC_Product $product
	 *
	 * @return bool
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getAvailabilityString( \WC_Product &$product ) {
		// If product is in stock
		if ( $product->is_in_stock() ) {
			return $this->©option->availOptions[ $this->©option->get( 'avail_inStock' ) ];
		} elseif ( $product->backorders_allowed() ) {
			// if product is out of stock and no backorders then return false
			if ( $this->©option->get( 'avail_backorders' ) == count( $this->©option->availOptions ) ) {
				return false;
			}

			// else return value
			return $this->©option->availOptions[ $this->©option->get( 'avail_backorders' ) ];
		} elseif ( $this->©option->get( 'avail_outOfStock' ) != count( $this->©option->availOptions ) ) {
			// no stock, no backorders but must include product. Return value
			return $this->©option->availOptions[ $this->©option->get( 'avail_outOfStock' ) ];
		}

		return false;
	}

	/**
	 * @param $string
	 *
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function formatSizeColorStrings( $string ) {
		if ( is_array( $string ) ) {
			array_walk( $string, function ( $item, $key ) {
				return $this->formatSizeColorStrings( $item );
			} );

			return implode( ',', $string );
		}

		$patterns        = array();
		$patterns[0]     = '/\|/';
		$patterns[1]     = '/\s+/';
		$replacements    = array();
		$replacements[2] = ',';
		$replacements[1] = '';

		return preg_replace( $patterns, $replacements, $string );
	}

	/**
	 * @param \WC_Product $product
	 * @param $term
	 *
	 * @return string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function getFormatedTextFromTerms( \WC_Product &$product, $term ) {
		$terms = get_the_terms( $product->id, $term );
		$out   = array();
		if ( is_array( $terms ) ) {
			foreach ( $terms as $k => $term ) {
				$name  = rtrim( ltrim( $term->name ) );
				$out[] = $name;
			}
		}

		return implode( ' - ', array_unique( $out ) );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	public function debug() {
		echo "<strong>not real mem usage: </strong>" . ( memory_get_peak_usage( false ) / 1024 / 1024 ) . " MiB<br>";
		echo "<strong>real mem usage: </strong>" . ( memory_get_peak_usage( true ) / 1024 / 1024 ) . " MiB<br>";
		$sTime     = microtime( true );
		$prodArray = $this->createProductsArray();
		$this->©xml->parseArray( $prodArray );
		echo "<strong>time: </strong>" . ( microtime( true ) - $sTime ) . " sec<br><br>";
		var_dump( $prodArray );
		die;
	}

	/**
	 * @param $string
	 *
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function isValidSizeString( $string ) {
		if ( is_numeric( $string ) ) {
			return true;
		}

		$validStrings = array(
			'XXS',
			'XS',
			'S',
			'M',
			'L',
			'XL',
			'XXL',
			'XXXL',
			'Extra Small',
			'Small',
			'Medium',
			'Large',
			'Extra Large'
		);

		return in_array( $string, $validStrings );
	}
} 