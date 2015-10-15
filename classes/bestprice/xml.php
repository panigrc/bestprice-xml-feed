<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 16/10/2014
 * Time: 12:03 μμ
 */

namespace bestprice;

use xd_v141226_dev\exception;

if ( ! defined( 'WPINC' ) ) {
	exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );
}

class xml extends \xd_v141226_dev\xml {
	/**
	 * @var \SimpleXMLExtended
	 */
	public $simpleXML = null;
	/**
	 * Absolute file path
	 *
	 * @var string
	 */
	public $fileLocation = '';
	/**
	 * @var null
	 */
	public $createdAt = null;
	/**
	 * @var string
	 */
	public $createdAtName = 'date';
	/**
	 * @var array
	 */
	protected $bspXMLFields = array(
		'productId',
		'title',
		'productURL',
		'imageURL',
		'price',
		'categoryID',
		'categoryPath',
		'brand',
		'ISBN',
		'size',
		'stock',
		'availability',
		'description',
		'oldPrice',
		'shipping',
		'color',
		'features',
		'EAN',
		'netprice',
		'isBundle',
	);
	/**
	 * @var array
	 */
	protected $bspXMLFieldsLengths = array(
		'productId'    => 128,
		'title'        => 250,
		'productURL'   => 250,
		'imageURL'     => 250,
		'categoryID'   => 64,
		'categoryPath' => 250,
		'brand'        => 128,
		'size'         => 256,
		'stock'        => 1,
		'availability' => 64,
		'color'        => 128,
		'EAN'          => 128,
		'isBundle'     => 1,
	);
	/**
	 * @var array
	 */
	protected $bspXMLRequiredFields = array(
		'productId',
		'title',
		'productURL',
		'imageURL',
		'price',
		'categoryID',
		'categoryPath',
		'brand',
		'ISBN',
		'size',
		'stock',
		'availability',
	);
	/**
	 * @var string
	 */
	protected $rootElemName = 'store';
	/**
	 * @var string
	 */
	protected $productsElemWrapperName = 'products';
	/**
	 * @var string
	 */
	protected $productElemName = 'product';

	public function __construct( $instance ) {
		parent::__construct( $instance );

		$d = array();
		if ( ! (bool) $this->©option->get( 'is_fashion_store' ) ) {
			$d[] = 'size';
		}

		if ( ! (bool) $this->©option->get( 'is_book_store' ) ) {
			$d[] = 'ISBN';
		}
		$this->bspXMLRequiredFields = array_diff( $this->bspXMLRequiredFields, $d );
	}

	/**
	 * @param array $array
	 *
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	public function parseArray( Array $array ) {
		// init simple xml if is not initialized already
		if ( ! $this->simpleXML ) {
			$this->initSimpleXML();
		}

		// parse array
		foreach ( $array as $k => $v ) {
			$this->appendProduct( $v );
		}

		return ! empty( $array ) && $this->saveXML();
	}

	/**
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	protected function initSimpleXML() {
		$this->fileLocation = $this->getFileLocation();

		$this->simpleXML = new \SimpleXMLExtended( '<?xml version="1.0" encoding="UTF-8"?><' . $this->rootElemName . '></' . $this->rootElemName . '>' );
		$this->simpleXML->addChild( $this->productsElemWrapperName );

		return $this;
	}

	/**
	 * Returns the file location based on settings (even if it isn't exists)
	 *
	 * @return string
	 * @throws exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	public function getFileLocation() {
		$location = $this->©options->get( 'xml_location' );
		$fileName = $this->©options->get( 'xml_fileName' );

		$location = empty( $location ) || $location == '/' ? '' : ( trim( $location, '\\/' ) . '/' );

		return rtrim( ABSPATH, '\\/' ) . '/' . $location . trim( $fileName, '\\/' );
	}

	/**
	 * @param array $p
	 *
	 * @return int
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	public function appendProduct( Array $p ) {
		if ( ! $this->simpleXML ) {
			$this->initSimpleXML();
		}

		$products = $this->simpleXML->children();

		$validated = $this->validateArrayKeys( $p );

		if ( ! empty( $validated ) ) {
			$product = $products->addChild( $this->productElemName );

			foreach ( $validated as $key => $value ) {
				$this->addChildNode( $key, $value, $product );
			}

			return 1;
		}

		return 0;
	}

	/**
	 * @param array $array
	 *
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	protected function validateArrayKeys( Array $array ) {
		foreach ( $this->bspXMLRequiredFields as $fieldName ) {
			if ( ! isset( $array[ $fieldName ] ) || empty( $array[ $fieldName ] ) ) {
				$fields = array();
				foreach ( $this->bspXMLRequiredFields as $f ) {
					if ( ! isset( $array[ $f ] ) || empty( $array[ $f ] ) ) {
						array_push( $fields, $f );
					}
				}
				$name = isset( $array['title'] )
					? $array['title']
					: ( isset( $array['productId'] )
						? 'with id ' . $array['productId']
						: '' );
				$this->©error->forceDBLog(
					'product',
					$array,
					'Product <strong>' . $name . '</strong> not included in XML file because field(s) ' . implode( ', ',
						$fields ) . ' is/are missing or is invalid'
				);

				return array();
			} else {
				$array[ $fieldName ] = $this->trimField( $array[ $fieldName ], $fieldName );
				if ( is_string( $array[ $fieldName ] ) ) {
					$array[ $fieldName ] = mb_convert_encoding( $array[ $fieldName ], "UTF-8" );
				}
			}
		}

		foreach ( $array as $k => $v ) {
			if ( ! in_array( $k, $this->bspXMLFields ) ) {
				unset( $array[ $k ] );
			}
		}

		return $array;
	}

	/**
	 * @param $value
	 * @param $fieldName
	 *
	 * @return bool|string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	protected function trimField( $value, $fieldName ) {
		if ( ! isset( $this->bspXMLFieldsLengths[ $fieldName ] ) || ! is_string( $value ) || $this->bspXMLFieldsLengths[ $fieldName ] === 0 ) {
			return $value;
		}

		if ( is_array( $value ) ) {
			foreach ( $value as $k => $v ) {
				$value[ $k ] = $this->trimField( $v, $fieldName );
			}

			return $value;
		}

		return mb_substr( (string) $value, 0, $this->bspXMLFieldsLengths[ $fieldName ] );
	}

	/**
	 * @param                   $key
	 * @param                   $value
	 * @param \SimpleXMLElement $node
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	protected function addChildNode( $key, $value, \SimpleXMLElement $node ) {
		if ( is_array( $value ) ) {
			$n = $node->addChild( $key );
			foreach ( $value as $k => $v ) {
				$this->addChildNode( $k, $v, $n );
			}
		} else if ( $this->isValidXmlName( $value ) ) {
			$node->addChild( $key, $value );
		} else {
			if ( ! isset( $node->$key ) ) {
				$node->addChild( $key );
			}
			$node->$key->addCData( $value );
		}
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	protected function isValidXmlName( $name ) {
		try {
			new \DOMElement( $name );

			return true;
		} catch ( \DOMException $e ) {
			return false;
		}
	}

	/**
	 * @return bool|mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	public function saveXML() {
		if ( ! ( $this->simpleXML instanceof \SimpleXMLExtended ) ) {
			return false;
		}
		$dir = dirname( $this->fileLocation );
		if ( ! file_exists( $dir ) ) {
			mkdir( $dir, 0755, true );
		}

		if ( $this->simpleXML && ! empty( $this->fileLocation ) && ( is_writable( $this->fileLocation ) || is_writable( $dir ) ) ) {
			if ( is_file( $this->fileLocation ) ) {
				unlink( $this->fileLocation );
			}
			$this->simpleXML->addChild( $this->createdAtName, date( 'Y-m-d H:i' ) );

			return $this->simpleXML->asXML( $this->fileLocation );
		}

		return false;
	}

	/**
	 * @param       $prodId
	 * @param array $newValues
	 *
	 * @return bool|mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	public function updateProductInXML( $prodId, Array $newValues ) {
		$newValues = $this->validateArrayKeys( $newValues );
		if ( empty( $newValues ) ) {
			return false;
		}
		// init simple xml if is not initialized already
		if ( ! $this->simpleXML ) {
			$this->initSimpleXML();
		}

		$p = $this->locateProductNode( $prodId );
		if ( ! $p ) {
			$p = $this->simpleXML->products->addChild( $this->productElemName );
		}
		foreach ( $newValues as $key => $value ) {
			if ( $this->isValidXmlName( $value ) ) {
				$p->addChild( $key, $value );
			} else {
				$p->$key = null;
				$p->$key->addCData( $value );
			}
		}

		return $this->saveXML();
	}

	/**
	 * @param $nodeId
	 *
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	protected function locateProductNode( $nodeId ) {
		if ( ! ( $this->simpleXML instanceof \SimpleXMLElement ) ) {
			return false;
		}

		foreach ( $this->simpleXML->products->product as $k => $p ) {
			if ( $p->id == $nodeId ) {
				return $p;
			}
		}

		return false;
	}

	/**
	 * Print SimpleXMLElement $this->simpleXML to screen
	 *
	 * @throws exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	public function printXML() {
		if ( headers_sent() ) {
			return;
		}

		if ( ! ( $this->simpleXML instanceof \SimpleXMLExtended ) ) {
			$fileLocation = $this->getFileLocation();
			if ( ! $this->existsAndReadable( $fileLocation ) ) {
				return;
			}
			$this->simpleXML = simplexml_load_file( $fileLocation );
		}

		header( "Content-Type:text/xml" );

		echo $this->simpleXML->asXML();

		exit( 0 );
	}

	/**
	 * Checks if file exists and is readable
	 *
	 * @param $file string File location
	 *
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	protected function existsAndReadable( $file ) {
		return is_string( $file ) && file_exists( $file ) && is_readable( $file );
	}

	/**
	 * Get XML file info
	 *
	 * @return array|null
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	public function getFileInfo() {
		$fileLocation = $this->getFileLocation();

		if ( $this->existsAndReadable( $fileLocation ) ) {
			$info = array();

			$sXML         = simplexml_load_file( $fileLocation );
			$cratedAtName = $this->createdAtName;

			$info[ $this->createdAtName ] = array(
				'value' => end( $sXML->$cratedAtName ),
				'label' => 'Cached File Creation Datetime'
			);

			$info['productCount'] = array(
				'value' => $this->countProductsInFile( $sXML ),
				'label' => 'Number of Products Included'
			);

			$info['cachedFilePath'] = array( 'value' => $fileLocation, 'label' => 'Cached File Path' );

			$info['url'] = array(
				'value' => $this->©url->to_wp_site_uri( str_replace( ABSPATH, '', $fileLocation ) ),
				'label' => 'Cached File Url'
			);

			$info['size'] = array( 'value' => filesize( $fileLocation ), 'label' => 'Cached File Size' );

			return $info;
		} else {
			return null;
		}
	}

	/**
	 * Counts total products in file
	 *
	 * @param $file string|\SimpleXMLExtended|\SimpleXMLElement
	 *
	 * @return int Total products in file
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	public function countProductsInFile( $file ) {
		if ( $this->existsAndReadable( $file ) ) {
			$sXML = simplexml_load_file( $file );
		} elseif ( $file instanceof \SimpleXMLElement || $file instanceof \SimpleXMLExtended ) {
			$sXML = &$file;
		} else {
			return 0;
		}

		if ( $sXML->getName() == $this->productsElemWrapperName ) {
			return $sXML->count();
		} elseif ( $sXML->getName() == $this->rootElemName ) {
			return $sXML->children()->children()->count();
		}

		return 0;
	}
} 