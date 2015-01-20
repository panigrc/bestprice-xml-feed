<?php
/**
 * Created by PhpStorm.
 * User: Vagenas Panagiotis <pan.vagenas@gmail.com>
 * Date: 17/10/2014
 * Time: 8:20 μμ
 */

namespace skroutz\menu_pages\panels;

if ( ! defined( 'WPINC' ) )
	exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );

use xd_v141226_dev\menu_pages\panels\panel;

class log extends panel{
	/**
	 * @var string Heading/title for this panel.
	 * @extenders Should be overridden by class extenders.
	 */
	public $heading_title = 'Last XML Generation Log';

	/**
	 * @var string Content/body for this panel.
	 * @extenders Should be overridden by class extenders.
	 */
	public $content_body = '';

	/**
	 * @var string Additional documentation for this panel.
	 * @extenders Can be overridden by class extenders.
	 */
	public $documentation = '';

	public function __construct( $instance, $menu_page ) {
		parent::__construct( $instance, $menu_page );
		/**
		 * Add the content
		 */
		$this->content_body = $this->©views->view($this, 'log_panel.php');
	}
} 