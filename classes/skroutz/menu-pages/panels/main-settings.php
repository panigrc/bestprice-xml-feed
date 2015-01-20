<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 17/10/2014
 * Time: 3:44 μμ
 */

namespace skroutz\menu_pages\panels;


use xd_v141226_dev\menu_pages\panels\panel;

if(!defined('WPINC'))
	exit('Do NOT access this file directly: '.basename(__FILE__));

/**
 *
 * @package randomizer\menu_pages\panels
 * @author pan.vagenas <pan.vagenas@gmail.com>
 */
class main_settings extends panel{
	/**
	 * @var string Heading/title for this panel.
	 * @extenders Should be overridden by class extenders.
	 */
	public $heading_title = 'Main settings';

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
		$this->content_body = $this->©views->view($this, 'main_settings_panel.php');

		// Documentation
		$this->documentation = $this->©views->view($this, 'documentation_main_settings.php');
	}
}