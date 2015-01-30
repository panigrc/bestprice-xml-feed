<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 16/10/2014
 * Time: 3:46 μμ
 */

namespace bestprice;

use xd_v141226_dev\exception;

if ( ! defined( 'WPINC' ) ) {
	exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );
}

class options extends \xd_v141226_dev\options {
	/**
	 * @var array Availability options for bestprice.gr
	 */
	public $availOptions = array(
		'Available',
		'1 to 3 days',
		'4 to 7 days',
		'7+ days',
		'Upon order',
		'Pre-order'
	);

	/**
	 * Sets up default options and validators.
	 *
	 * @extenders Can be overridden by class extenders (i.e. to override the defaults/validators);
	 *    or to add additional default options and their associated validators.
	 *
	 * @param array $defaults An associative array of default options.
	 * @param array $validators An array of validators (can be a combination of numeric/associative keys).
	 *
	 * @return array The current array of options.
	 *
	 * @throws exception If invalid types are passed through arguments list.
	 * @throws exception If `count($defaults) !== count($validators)`.
	 */
	public function setup( $defaults, $validators ) {
		$bestpriceDefaults = array(
			'encryption.key'                             => 'jkiabOKBNJO89347KJBKJBasfd',
			'support.url'                                => 'http://erp.xdark.eu/documentation/get-help/',
			'styles.front_side.theme'                    => 'yeti',
			'crons.config'                               => array(),
			'menu_pages.theme'                           => 'yeti',
			'captchas.google.public_key'                 => '6LeCANsSAAAAAIIrlB3FrXe42mr0OSSZpT0pkpFK',
			'captchas.google.private_key'                => '6LeCANsSAAAAAGBXMIKAirv6G4PmaGa-ORxdD-oZ',
			'url_shortener.default_built_in_api'         => 'goo_gl',
			'url_shortener.custom_url_api'               => '',
			'url_shortener.api_keys.goo_gl'              => '',
			'menu_pages.panels.email_updates.action_url' => '',
			'menu_pages.panels.community_forum.feed_url' => '',
			'menu_pages.panels.news_kb.feed_url'         => '',
			'menu_pages.panels.videos.yt_playlist'       => '',
			/***********************************************
			 * License
			 ***********************************************/
			'edd.update'                                 => 1,
			'edd.store_url'                              => 'http://erp.xdark.eu',
			'edd_license'                                => '',
			/*********************
			 * XML File relative
			 ********************/
			// Internal, indicates XML generation progress
			'xml.progress'                               => 0,
			// File location
			'xml_location'                               => '/wp-content/uploads',
			// File name
			'xml_fileName'                               => 'bestprice.xml',
			// Generation interval
			'xml_interval'                               => 'daily',
			// XML Generate Request Var
			'xml_generate_var'                           => 'bestprice',
			// XML Generate Request Var Value
			'xml_generate_var_value'                     => '',
			/*********************
			 * Products relative
			 ********************/
			// Include products
			'products_include'                           => array( 'product' ),
			// Availability when products in stock
			'avail_inStock'                              => 1,
			// Availability when products out stock
			'avail_outOfStock'                           => 3,
			// Availability when products out stock and backorders are allowed
			'avail_backorders'                           => count( $this->availOptions ),
			/*********************
			 * Custom fields
			 ********************/
			'map_id'                                     => 0,
			'map_name'                                   => 0,
			'map_name_append_sku'                        => 1,
			'map_link'                                   => 0,
			'map_image'                                  => 0,
			'map_category'                               => 'product',
			'map_price_with_vat'                         => 0,
			'map_manufacturer'                           => 0,
			'map_mpn'                                    => 0,
			'map_size'                                   => array(),
			'map_size_use'                               => 1,
			'map_color'                                  => array(),
			'map_color_use'                              => 0,
			/***********************************************
			 * Fashion store
			 ***********************************************/
			'is_fashion_store'                           => 0,
			/***********************************************
			 * ISBN
			 ***********************************************/
			'map_isbn'                                   => 0,
			'is_book_store'                              => 0,
		);

		$bestpriceDefaultsValidators = array(
			// Internal
			'xml.progress'           => array( 'string:numeric >=' => 0 ),
			/***********************************************
			 * Main Option Validators
			 ***********************************************/
			'xml_location'           => array( 'string:!empty' ),
			'xml_fileName'           => array( 'string:!empty' ),
			'xml_generate_var'       => array( 'string:!empty' ),
			'xml_generate_var_value' => array( 'string:!empty' ),
			'xml_interval'           => array(
				'string:in_array' => array(
					'every30m',
					'hourly',
					'twicedaily',
					'daily'
				)
			),
			'products_include'       => array( 'array' ), // TODO Not implemented yet
			'avail_inStock'          => array(
				'string:numeric >=' => 0,
				'string:numeric <=' => count( $this->availOptions ) - 1
			),
			'avail_outOfStock'       => array(
				'string:numeric >=' => 0,
				'string:numeric <=' => count( $this->availOptions )
			),
			'avail_backorders'       => array(
				'string:numeric >=' => 0,
				'string:numeric <=' => count( $this->availOptions )
			),
			'map_id'                 => array( 'string:numeric >=' => 0 ),
			'map_name'               => array( 'string:numeric >=' => 0 ),
			'map_name_append_sku'    => array( 'string:numeric >=' => 0, 'string:numeric <=' => 1 ),
			'map_link'               => array( 'string:numeric >=' => 0 ),
			'map_image'              => array( 'string:numeric >=' => 0 ),
			'map_category'           => array( 'string' ),
			'map_price_with_vat'     => array( 'string:numeric >=' => 0, 'string:numeric <=' => 3 ),
			'map_manufacturer'       => array( 'string' ),
			'map_mpn'                => array( 'string:numeric >=' => 0 ),
			'map_size'               => array( 'array' ),
			'map_size_use'           => array( 'string:numeric >=' => 0, 'string:numeric <=' => 1 ),
			'map_color'              => array( 'array' ),
			'map_color_use'          => array( 'string:numeric >=' => 0, 'string:numeric <=' => 1 ),
			'is_fashion_store'       => array( 'string:numeric >=' => 0, 'string:numeric <=' => 1 ),
			'map_isbn'               => array( 'string' ),
			'is_book_store'          => array( 'string:numeric >=' => 0, 'string:numeric <=' => 1 ),
		);

		$defaults   = array_merge( $defaults, $bestpriceDefaults );
		$validators = array_merge( $validators, $bestpriceDefaultsValidators );

		$this->_setup( $defaults, $validators );
	}

	/**
	 * Get current license string
	 * @return array|string
	 * @throws exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	public function getLic() {
		return $this->©edd_updater->getLicense();
	}

	public function getLicenseStatus() {
		return $this->©edd_updater->getLicenseStatus();
	}

	/**
	 * @param string $lic
	 *
	 * @return int 2 for WP_Error, 1 for valid, 0 for invalid
	 * @throws exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150120
	 */
	public function chkLicense( $lic = '' ) {
		return $this->©edd_updater->chkLicense( $lic );
	}

	public function activateLicense( $license ) {
		return $this->©edd_updater->activateLicense( $license );
	}

	public function deactivateLicense( $license ) {
		return $this->©edd_updater->deactivateLicense( $license );
	}

	public function getLicenseDataFromServer( $licenseAction = 'check_license', $license = '' ) {
		return $this->©edd_updater->getLicenseDataFromServer( $licenseAction, $license );
	}

	/**
	 * Fires when new options are saved. Then based on plugin page we use the appropriate method.
	 * Always call the parent at the end.
	 *
	 * @param array $new_options
	 */
	public function ®update( $new_options = array() ) {
		$bools = array( 'is_fashion_store', 'map_name_append_sku', 'map_color_use', 'map_size_use' );
		foreach ( $bools as $v ) {
			if ( ! isset( $new_options[ $v ] ) ) {
				$new_options[ $v ] = 0;
			}
		}

		// Delete old file if XML file path changed
		if ( isset( $new_options['xml_location'] ) && ( $new_options['xml_location'] != $this->get( 'xml_location' ) || $new_options['xml_fileName'] != $this->get( 'xml_fileName' ) ) ) {
			$this->©file->delete( $this->©xml->getFileLocation() );
		}

		parent::®update( $new_options );
	}
}