<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 17/10/2014
 * Time: 3:39 μμ
 */

namespace bestprice\menu_pages;

if ( ! defined( 'WPINC' ) ) {
	exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );
}

/**
 * Menu Page.
 *
 * @package randomizer\menu_pages
 * @since   140914
 *
 * @assert ($GLOBALS[__NAMESPACE__])
 */
class settings extends menu_page {
	public $updates_options = true;

	/**
	 * Constructor.
	 *
	 * @param object|array $instance Required at all times.
	 *                               A parent object instance, which contains the parent's ``$instance``,
	 *                               or a new ``$instance`` array.
	 */
	public function __construct( $instance ) {
		parent::__construct( $instance );

		$this->heading_title           = $this->__( 'Main Settings' );
		$this->sub_heading_description = sprintf( $this->__( 'Configure main settings for %1$s' ),
			esc_html( $this->©plugin->instance->plugin_name ) );
	}

	/**
	 * Displays HTML markup producing content panels for this menu page.
	 */
	public function display_content_panels() {
		$this->add_content_panel( $this->©menu_pages__panels__main_settings( $this ), true );
		$this->add_content_panel( $this->©menu_pages__panels__map( $this ), true );
		$this->add_content_panel( $this->©menu_pages__panels__log( $this ), true );

		$this->display_content_panels_in_order();
	}

	/**
	 * Displays HTML markup producing sidebar panels for this menu page.
	 *
	 * @extenders Can be overridden by class extenders (i.e. by each menu page),
	 *    so that custom sidebar panels can be displayed by this routine.
	 */
	public function display_sidebar_panels() {
		parent::display_sidebar_panels();
	}

	/**
	 * Displays HTML markup for notices, for this menu page.
	 *
	 */
	public function display_notices() {
	}
}