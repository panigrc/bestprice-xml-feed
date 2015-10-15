<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 17/10/2014
 * Time: 3:38 μμ
 */

namespace bestprice\menu_pages;

if ( ! defined( 'WPINC' ) ) {
	exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );
}

/**
 *
 * @package randomizer\menu_pages
 * @author  pan.vagenas <pan.vagenas@gmail.com>
 */
class menu_page extends \xd_v141226_dev\menu_pages\menu_page {

	/**
	 * @var string Heading/title for this menu page.
	 * @extenders Should be overridden by class extenders.
	 */
	public $heading_title = '';

	/**
	 * @var string Sub-heading/description for this menu page.
	 * @extenders Should be overridden by class extenders.
	 */
	public $sub_heading_description = '';

	/**
	 * @var boolean Should sidebar panels share a global order?
	 * @extenders Can be overridden by class extenders.
	 */
	public $sidebar_panels_share_global_order = true;

	/**
	 * @var boolean Should sidebar panels share a global state?
	 * @extenders Can be overridden by class extenders.
	 */
	public $sidebar_panels_share_global_state = true;

	/**
	 * @var boolean Defaults to FALSE. Does this menu page update options?
	 *    When TRUE, each menu page is wrapped with a form tag that calls `©options.®update`.
	 *    In addition, `$this->option_fields` will be populated, for easy access to a `©form_fields` instance.
	 *    In addition, each menu page will have a `Save All Options` button.
	 *
	 * @note      This comes in handy, when a menu page is dedicated to updating options.
	 *    Making it possible for a site owner to update all options (i.e. from all panels), in one shot.
	 *    The `Save All Options` button at the bottom will facilitate this.
	 *
	 * @extenders Can easily be overridden by class extenders.
	 */
	public $updates_options = false;

	/**
	 * Displays HTML markup for notices, for this menu page.
	 *
	 * @extenders Can be overridden by class extenders (e.g. by each menu page),
	 *    so that custom notices could be displayed in certain cases.
	 */
	public function display_notices() {
	}

	/**
	 * Displays HTML markup producing content panels for this menu page.
	 *
	 * @extenders Should be overridden by class extenders (e.g. by each menu page),
	 *    so that custom content panels can be displayed by this routine.
	 */
	public function display_content_panels() {
		$this->display_content_panels_in_order();
	}

	/**
	 * Displays HTML markup producing sidebar panels for this menu page.
	 *
	 * @extenders Can be overridden by class extenders (i.e. by each menu page),
	 *    so that custom sidebar panels can be displayed by this routine.
	 */
	public function display_sidebar_panels() {
		$this->add_sidebar_panel( $this->©menu_pages__panels__donations( $this ), true );
		$this->add_sidebar_panel( $this->©menu_pages__panels__info( $this ), true );
		$this->add_sidebar_panel( $this->©menu_pages__panels__generate( $this ), true );

		$this->display_sidebar_panels_in_order();
	}

	/**
	 * Displays HTML markup for controls in a menu page header.
	 */
	public function display_header_controls() {
		$this->display_header_control__restore_default_options();
		$this->display_header_control__import_export_options();
		$this->display_header_control__toggle_all_panels();
	}
}