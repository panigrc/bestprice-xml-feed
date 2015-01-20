<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 17/10/2014
 * Time: 3:35 μμ
 */

namespace skroutz;

if ( ! defined( 'WPINC' ) ) {
	exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );
}

/**
 *
 * @package randomizer
 * @author pan.vagenas <pan.vagenas@gmail.com>
 */
class menu_pages extends \xd_v141226_dev\menu_pages {

	/**
	 * Handles WordPress® `admin_menu` hook.
	 *
	 * @extenders Should be overridden by class extenders, if a plugin has menu pages.
	 *
	 * @attaches-to WordPress® `admin_menu` hook.
	 * @hook-priority Default is fine.
	 *
	 * @return null Nothing.
	 */
	public function admin_menu() {
		add_options_page(
			$this->instance->plugin_name . ' Settings',
			$this->instance->plugin_name,
			$this->instance->plugin_cap,
			$this->instance->plugin_root_ns.'--'.$this->©menu_pages__settings->slug,
			array($this, '©menu_pages__settings.display')
		);
	}

	/**
	 * Handles WordPress® `network_admin_menu` hook.
	 *
	 * @extenders Should be overridden by class extenders, if a plugin has menu pages.
	 *
	 * @attaches-to WordPress® `network_admin_menu` hook.
	 * @hook-priority Default is fine.
	 *
	 * @return null Nothing.
	 */
	public function network_admin_menu() {
		/**
		 * No global preferences so display admin menu
		 */
		$this->admin_menu();
	}

	/**
	 * Default (core-driven) menu pages.
	 *
	 * @return array Default (core-driven) menu pages.
	 *
	 * @see add() for further details about how to add menu pages.
	 */
	public function default_menu_pages() {
		return array();
	}
}