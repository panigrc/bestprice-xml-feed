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
	 * @var array
	 */
	protected $skzXMLFields = array(
		'id',
		'name',
		'link',
		'image',
		'category',
		'price_with_vat',
		'instock',
		'availability',
		'manufacturer',
		'mpn',
		'isbn',
		'size',
		'color',
	);

	/**
	 * @var array
	 */
	protected $skzXMLFieldsLengths = array(
		'id'             => 200,
		'name'           => 300,
		'link'           => 1000,
		'image'          => 400,
		'category'       => 250,
		'price_with_vat' => 0,
		'instock'        => 0,
		'availability'   => 60,
		'manufacturer'   => 100,
		'mpn'            => 80,
		'isbn' => 80,
		'size'           => 500,
		'color'          => 100,
	);

	/**
	 * @var array
	 */
	protected $skzXMLRequiredFields = array(
		'id',
		'name',
		'link',
		'image',
		'category',
		'price_with_vat',
		'instock',
		'availability',
		'manufacturer',
		'mpn',
	);

	/**
	 * @var \SimpleXMLExtended
	 */
	public $simpleXML = null;

	/**
	 * Absolute file path
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
	public $createdAtName = 'created_at';

	/**
	 * @var string
	 */
	protected $rootElemName = 'mywebstore';
	/**
	 * @var string
	 */
	protected $productsElemWrapper = 'products';
	/**
	 * @var string
	 */
	protected $productElemName = 'product';

	/**
	 * @param array $array
	 *
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	public function parseArray( Array $array ) {
		// init simple xml if is not initialized already
		if ( ! $this->simpleXML ) {
			$this->initSimpleXML();
		}

		// get products node
		$products = $this->simpleXML->children();

		// parse array
		foreach ( $array as $k => $v ) {
			$validated = $this->validateArrayKeys( $v );

			if ( empty( $validated ) ) {
				unset( $array[ $k ] );
			} else {
				/* @var \SimpleXMLExtended $product */
				$product = $products->addChild( $this->productElemName );

				foreach ( $validated as $key => $value ) {
					if ( $this->isValidXmlName( $value ) ) {
						$product->addChild( $key, $value );
					} else {
						$product->$key = null;
						$product->$key->addCData( $value );
					}
				}
			}
		}

		return !empty($array) && $this->saveXML();
	}

	/**
	 * @return $this
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function initSimpleXML() {
		if ( ! $this->loadXML() ) {
			$this->simpleXML = new \SimpleXMLExtended( '<?xml version="1.0" encoding="UTF-8"?><' . $this->rootElemName . '></' . $this->rootElemName . '>' );
		}

		// TODO We must update the created at child
		/**
		 * For now we recreate the XML file everytime so no need to check for updates
		 */
//		$createdAt =  $this->attribute( $this->simpleXML, $this->createdAtName );

		// check for child nodes
		$products = $this->simpleXML;

		if ( !isset( $this->simpleXML->products ) ) {
			$this->simpleXML->addChild( $this->productsElemWrapper );
		};

		return $this;
	}

	/**
	 * @param array $array
	 *
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function validateArrayKeys( Array $array ) {
		foreach ( $this->skzXMLRequiredFields as $fieldName ) {
			if ( ! isset( $array[ $fieldName ] ) || empty($array[ $fieldName ])) {
				$name = isset($array['name']) ? $array['name'] : (isset($array['id']) ? 'with id ' . $array['id'] : '');
				$this->©diagnostic->forceDBLog('product', $array, 'Product <strong>'.$name.'</strong> not included in XML file because field '.$fieldName.' is missing or is invalid');
				return array();
			} else {
				$array[ $fieldName ] = $this->trimField( $array[ $fieldName ], $fieldName );
				if ( is_string( $array[ $fieldName ] ) ) {
					$array[ $fieldName ] = mb_convert_encoding( $array[ $fieldName ], "UTF-8" );
				}
			}
		}

		foreach ( $array as $k => $v ) {
			if ( ! in_array( $k, $this->skzXMLFields ) ) {
				unset( $array[ $k ] );
			}
		}

		return $array;
	}

	protected function isValidXmlName( $name ) {
		try {
			new \DOMElement( $name );

			return true;
		} catch ( \DOMException $e ) {
			return false;
		}
	}

	/**
	 * @param $value
	 * @param $fieldName
	 *
	 * @return bool|string
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function trimField( $value, $fieldName ) {
		if ( ! isset( $this->skzXMLFieldsLengths[ $fieldName ] ) ) {
			return false;
		}

		if ( $this->skzXMLFieldsLengths[ $fieldName ] === 0 ) {
			return $value;
		}

		return substr( (string) $value, 0, $this->skzXMLFieldsLengths[ $fieldName ] );
	}


	/**
	 * @return bool
	 * @throws exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function loadXML() {
		/**
		 * For now we write it from scratch EVERY TIME
		 */
		$this->fileLocation = $this->getFileLocation();

//		if(file_exists($this->fileLocation)){
//			$this->simpleXML = new \SimpleXMLExtended(simplexml_load_file($this->fileLocation)->asXML());
//			return true;
//		}

		return false;

		try {
			$locate = $this->©dirs_files->locate( $fileLocation, get_home_path() );
		} catch ( exception $e ) {
			return false;
		}

		if ( ! empty( $locate ) && file_exists( $locate ) && is_readable( $locate ) ) {
			$this->simpleXML = simplexml_load_file( $locate );
			if ( $this->simpleXML !== false ) {
				$this->fileLocation = $locate;

				return true;
			}
		} else {
			// Assuming ABSPATH is writable
			$this->fileLocation = $this->getFileLocation;
		}

		return false;
	}

	/**
	 * @param $prodId
	 * @param array $newValues
	 *
	 * @return bool|mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	public function updateProductInXML($prodId, Array $newValues){
		$newValues = $this->validateArrayKeys($newValues);
		if(empty($newValues)){
			return false;
		}
		// init simple xml if is not initialized already
		if ( ! $this->simpleXML ) {
			$this->initSimpleXML();
		}

		$p = $this->locateProductNode($prodId);
		if(!$p){
			$p = $this->simpleXML->products->addChild($this->productElemName);
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
	 * @since 150120
	 */
	protected function locateProductNode($nodeId){
		if(!($this->simpleXML instanceof \SimpleXMLElement)){
			return false;
		}

		foreach ( $this->simpleXML->products->product as $k => $p ) {
			if($p->id == $nodeId){
				return $p;
			}
		}
		return false;
	}

	/**
	 * @return bool|mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function saveXML() {
		$dir = dirname($this->fileLocation);
		if(!file_exists($dir)){
			mkdir($dir, 0755, true);
		}

		if ( $this->simpleXML && ! empty( $this->fileLocation ) && (is_writable( $this->fileLocation ) || is_writable($dir) ) ) {
			if(is_file($this->fileLocation)){
				unlink($this->fileLocation);
			}
			$this->simpleXML->addChild( $this->createdAtName, date( 'Y-m-d H:i' ) );
			return $this->simpleXML->asXML( $this->fileLocation );
		}

		return false;
	}

	/**
	 * @param $sxi
	 * @param null $key
	 * @param null $tmp
	 *
	 * @return null
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function sxiToXpath( $sxi, $key = null, &$tmp = null ) {
		$keys_arr = array();
		//get the keys count array
		for ( $sxi->rewind(); $sxi->valid(); $sxi->next() ) {
			$sk = $sxi->key();
			if ( array_key_exists( $sk, $keys_arr ) ) {
				$keys_arr[ $sk ] += 1;
				$keys_arr[ $sk ] = $keys_arr[ $sk ];
			} else {
				$keys_arr[ $sk ] = 1;
			}
		}
		//create the xpath
		for ( $sxi->rewind(); $sxi->valid(); $sxi->next() ) {
			$sk = $sxi->key();
			if ( ! isset( $$sk ) ) {
				$$sk = 1;
			}
			if ( $keys_arr[ $sk ] >= 1 ) {
				$spk             = $sk . '[' . $$sk . ']';
				$keys_arr[ $sk ] = $keys_arr[ $sk ] - 1;
				$$sk ++;
			} else {
				$spk = $sk;
			}
			$kp = $key ? $key . '/' . $spk : '/' . $sxi->getName() . '/' . $spk;
			if ( $sxi->hasChildren() ) {
				$this->sxiToXpath( $sxi->getChildren(), $kp, $tmp );
			} else {
				$tmp[ $kp ] = strval( $sxi->current() );
			}
			$at = $sxi->current()->attributes();
			if ( $at ) {
				$tmp_kp = $kp;
				foreach ( $at as $k => $v ) {
					$kp .= '/@' . $k;
					$tmp[ $kp ] = $v;
					$kp         = $tmp_kp;
				}
			}
		}

		return $tmp;
	}

	/**
	 * Transform an SimpleXMLElement to Xpath and return it
	 *
	 * @param $xml
	 *
	 * @return null|array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	public function xmlToXpath( $xml ) {
		$sxi = new \SimpleXmlIterator( $xml );

		return $this->sxiToXpath( $sxi );
	}

	/**
	 * Print SimpleXMLElement $this->simpleXML to screen
	 *
	 * @throws exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	public function printXML() {
		if(headers_sent()) return;

		if ( ! ( $this->simpleXML instanceof \SimpleXMLExtended )) {
			$fileLocation = $this->getFileLocation();
			if ( !$this->existsAndReadable( $fileLocation ) ) {
				return;
			}
			$this->simpleXML = simplexml_load_file( $fileLocation );
		}

		header ("Content-Type:text/xml");

		echo $this->simpleXML->asXML();

		exit(0);
	}

	/**
	 * Returns the file location based on settings (even if it isn't exists)
	 *
	 * @return string
	 * @throws exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	public function getFileLocation() {
		$location = $this->©options->get( 'xml_location' );
		$fileName = $this->©options->get( 'xml_fileName' );

		$location = empty($location) || $location == '/' ? '' : (trim($location, '\\/') . '/');

		return rtrim( ABSPATH, '\\/' ) . '/' . $location . trim($fileName, '\\/');
	}

	/**
	 * Get XML file info
	 *
	 * @return array|null
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	public function getFileInfo() {
		$fileLocation = $this->getFileLocation();

		if ( $this->existsAndReadable( $fileLocation ) ) {
			$info = array();

			$sXML = simplexml_load_file( $fileLocation );
			$cratedAtName = $this->createdAtName;

			$info[ 'File Creation Datetime' ] = end( $sXML->$cratedAtName );
			$info['Products Count']       = $this->countProductsInFile( $sXML );
			$info['File Path']            = $fileLocation;
			$info['File Url']             = $this->©url->to_wp_site_uri( str_replace( ABSPATH, '', $fileLocation ) );
			$info['File Size']            = filesize( $fileLocation );

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
	 * @since 150120
	 */
	public function countProductsInFile( $file ) {
		if ( $this->existsAndReadable( $file ) ) {
			$sXML = simplexml_load_file( $file );
		} elseif ( $file instanceof \SimpleXMLElement || $file instanceof \SimpleXMLExtended ) {
			$sXML = &$file;
		} else {
			return 0;
		}

		if ( $sXML->getName() == $this->productsElemWrapper ) {
			return $sXML->count();
		}elseif ( $sXML->getName() == $this->rootElemName ) {
			return $sXML->children( )->children()->count();
		}

		return 0;
	}

	/**
	 * Checks if file exists and is readable
	 *
	 * @param $file string File location
	 *
	 * @return bool
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	protected function existsAndReadable( $file ) {
		return is_string( $file ) && file_exists( $file ) && is_readable( $file );
	}
} 