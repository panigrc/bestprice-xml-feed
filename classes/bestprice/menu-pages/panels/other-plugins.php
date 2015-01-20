<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 17/10/2014
 * Time: 3:46 μμ
 */

namespace bestprice\menu_pages\panels;

use xd_v141226_dev\menu_pages\panels\panel;

if (!defined('WPINC'))
	exit('Do NOT access this file directly: ' . basename(__FILE__));

/**
 * Menu Page Panel.
 *
 * @package WebSharks\Core
 * @since 140914
 *
 * @assert ($GLOBALS[__NAMESPACE__])
 */
class other_plugins extends panel
{
	/**
	 * Constructor.
	 *
	 * @param object|array $instance Required at all times.
	 *    A parent object instance, which contains the parent's ``$instance``,
	 *    or a new ``$instance`` array.
	 *
	 * @param \xd_v141226_dev\menu_pages\menu_page
	 *    $menu_page A menu page class instance.
	 */
	public function __construct($instance, $menu_page)
	{
		parent::__construct($instance, $menu_page);

		$this->heading_title = $this->__('Other Plugins From XDaRk.eu');

		$this->content_body =
			'';
	}
}