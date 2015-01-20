<?php
/**
 * Project: core
 * File: ${FILE_NAME}
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 4/12/2014
 * Time: 8:39 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2014 Panagiotis Vagenas
 */

namespace xd_v141226_dev;
{

	if ( ! defined( 'WPINC' ) ) {
		exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );
	}

	class ajax extends framework {
		/**
		 * @doNotExtend
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		public function bind_ajax_core_actions(){
			if($this->©edd_updater->isEDD()){
				$this->bind_edd_actions();
			}
			$this->bind_ajax_actions();
		}

		/**
		 * @extend
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		protected function bind_ajax_actions(){
			return true;
		}

		/**
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		protected function bind_edd_actions(){
			$this->add_action( 'wp_ajax_activateEddLicense', '©ajax.activateEddLicense' );
			$this->add_action( 'wp_ajax_deactivateEddLicense', '©ajax.deactivateEddLicense' );
		}

		/**
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		public function deactivateEddLicense(){
			if ( ! $this->©user->is_super_admin() ) {
				$this->sendJSONError( 'Authorization failed', 401 );
			}
			$lic = isset($_POST['license']) ? (string)$_POST['license'] : '';
			if(empty($lic)){
				$licData = false;
			} else {
				$licData = $this->©edd_updater->deactivateLicense($lic);
			}
			$licData = $licData === false ? array('license' => 'invalid') : $licData;
			$this->sendJSONSuccess( array( 'licenseData' => $licData ) );
		}

		/**
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		public function activateEddLicense(){
			if ( ! $this->©user->is_super_admin() ) {
				$this->sendJSONError( 'Authorization failed', 401 );
			}
			$lic = isset($_POST) ? (string)$_POST['license'] : '';
			if(empty($lic)){
				$licData = false;
			} else {
				$licData = $this->©edd_updater->activateLicense($lic);
			}
			$licData = $licData === false ? array('license' => 'invalid') : $licData;
			$this->sendJSONSuccess( array( 'licenseData' => $licData ) );
		}

		/**
		 * @param $response
		 * @param int $responseCode
		 *
		 * @throws exception
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		public function sendJSONResult($response, $responseCode = 200){
			$this->©header->clean_status_type( $responseCode, 'application/json' );
			echo json_encode( $response );
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
				wp_die();
			else
				die;
		}

		/**
		 * @param $data
		 * @param int $responseCode
		 *
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		public function sendJSONError($data, $responseCode = 400){
			$this->sendJSONResult(array('data' => $data, 'success' => false), $responseCode);
		}

		/**
		 * @param $data
		 * @param int $responseCode
		 *
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		public function sendJSONSuccess($data, $responseCode = 200){
			$this->sendJSONResult(array('data' => $data, 'success' => true), $responseCode);
		}
	}

}
