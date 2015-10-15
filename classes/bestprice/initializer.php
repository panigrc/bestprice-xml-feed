<?php
/**
 * User: vagenas
 * Date: 9/11/14
 * Time: 10:10 PM
 *
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @copyright 2015 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */

namespace bestprice;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 *
 * @package bestprice
 * @author  pan.vagenas <pan.vagenas@gmail.com>
 */
class initializer extends \xd_v141226_dev\initializer {

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	public function after_setup_theme_hooks() {
		$this->add_action( 'init', '©initializer.init_hook' );
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since  150120
	 */
	public function init_hook() {
		$generateVar = $this->©option->get( 'xml_generate_var' );
		if ( empty( $generateVar ) ) {
			$generateVar = 'bestprice_' . $this->©string->random( 12, false, false );
			$this->©option->update( array( 'xml_generate_var' => $generateVar ) );
		}

		$generateVarVal = $this->©option->get( 'xml_generate_var_value' );
		if ( empty( $generateVarVal ) ) {
			$generateVarVal = $this->©string->random( 24, false, false );
			$this->©option->update( array( 'xml_generate_var_value' => $generateVarVal ) );
		}

		$parsed = $this->©url->parse( $this->©url->current() );
		if ( isset( $parsed['query'] ) ) {
			parse_str( $parsed['query'] );
		}

		if ( isset( $$generateVar ) && $$generateVar == $generateVarVal ) {
			$this->add_action( 'wp_loaded', '©bestprice.generate_and_print', PHP_INT_MAX );
		}
	}
}