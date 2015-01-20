<?php
/**
 * Created by PhpStorm.
 * User: Vagenas Panagiotis <pan.vagenas@gmail.com>
 * Date: 17/10/2014
 * Time: 10:11 μμ
 */

namespace skroutz;

if ( ! defined( 'WPINC' ) )
	exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );

/**
 * Class ajax
 * @package skroutz
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @since 141017
 */
class ajax extends \xd_v141226_dev\ajax {
	/**
	 * Generates skroutz.xml
	 * @important AJAX HOOKED
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 141017
	 */
	public function generateSkroutzXML() {
		if ( ! $this->©user->is_super_admin() ) {
			$this->sendJSONError( 'Authorization failed', 401 );
		}
		if(!$this->©edd_updater()->getLicenseStatus()){
			$this->sendJSONError( 'License Is Not Valid', 401 );
		}

		$foundProducts = $this->©skroutz->do_your_woo_stuff();
		if($foundProducts > 0){
			$this->sendJSONSuccess( array( 'result' => true, 'productsUpdated' => $foundProducts ) );
		} else {
			$this->sendJSONError($this->__('No products found'), 200);
		}
	}

	/**
	 * AJAX out XML generation progress
	 * @important AJAX HOOKED
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 141017
	 */
	public function generateSkroutzXMLProgress() {
		if ( ! $this->©user->is_super_admin() ) {
			$this->sendJSONError( 'Authorization failed', 401 );
		}
		$this->sendJSONSuccess( array( 'progress' => (float) $this->©option->get( 'xml.progress' ) ) );
	}

	/**
	 * Binds AJAX actions
	 * @important This is called from initializer so no need to directly call it
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 141017
	 */
	public function bind_ajax_actions() {
		$this->add_action( 'wp_ajax_generateSkroutzXML', '©ajax.generateSkroutzXML' );
		$this->add_action( 'wp_ajax_generateSkroutzXMLProgress', '©ajax.generateSkroutzXMLProgress' );
	}
} 