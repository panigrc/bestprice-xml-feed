<?php

/**
 * User: vagenas
 * Date: 9/11/14
 * Time: 11:33 PM
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
class installer extends \xd_v141226_dev\installer {

	/**
	 * Any additional activation routines.
	 *
	 * @extenders This should be overwritten by class extenders (when/if needed).
	 *
	 * @return boolean TRUE if all routines were successful, else FALSE if there were any failures.
	 */
	public function activations() {
		return true; // Indicate success.
	}

	/**
	 * Any additional deactivation routines.
	 *
	 * @extenders This should be overwritten by class extenders (when/if needed).
	 *
	 * @return boolean TRUE if all routines were successful, else FALSE if there were any failures.
	 */
	public function deactivations() {
		return true; // Indicate success.
	}

	/**
	 * Any additional uninstall routines.
	 *
	 * @extenders This should be overwritten by class extenders (when/if needed).
	 *
	 * @return boolean TRUE if all routines were successful, else FALSE if there were any failures.
	 */
	public function uninstallations() {
		return true; // Indicate success.
	}

}
