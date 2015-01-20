<?php
/**
 * Created by PhpStorm.
 * User: Vagenas Panagiotis <pan.vagenas@gmail.com>
 * Date: 17/10/2014
 * Time: 8:53 μμ
 */

namespace bestprice;

if(!defined('WPINC'))
	exit('Do NOT access this file directly: '.basename(__FILE__));

class scripts extends \xd_v141226_dev\scripts
{
	/**
	 * Builds the initial set of front-side components.
	 *
	 * @extenders Can be extended to add additional front-side components.
	 *
	 * @return array An array of any additional front-side components.
	 */
	public function front_side_components()
	{
		$this->register(array(
			$this->instance->plugin_root_ns_with_dashes . '--front-side' => array(
				'deps' => array('jquery', $this->instance->plugin_root_ns_with_dashes . '--stand-alone'),
				'url' => $this->©url->to_plugin_dir_file('templates/client-side/scripts/front-side.min.js'),
				'ver' => $this->instance->plugin_version_with_dashes,
				'in_footer' => true
			)
		));

		return array(
			$this->instance->plugin_root_ns_with_dashes . '--front-side'
		); // Not implemented by core.
	}

	/**
	 * Builds the initial set of stand-alone components.
	 *
	 * @extenders Can be extended to add additional stand-alone components.
	 *
	 * @return array An array of any additional stand-alone components.
	 */
	public function stand_alone_components()
	{
		$this->register(array(
			$this->instance->plugin_root_ns_with_dashes . '--stand-alone' => array(
				'deps' => array('jquery'),
				'url' => $this->©url->to_plugin_dir_file('templates/client-side/scripts/stand-alone.min.js'),
				'ver' => $this->instance->plugin_version_with_dashes,
				'in_footer' => true
			),
		));

		return array(
			$this->instance->plugin_root_ns_with_dashes . '--stand-alone'
		); // Not implemented by core.
	}

	/**
	 * Builds the initial set of menu page components.
	 *
	 * @extenders Can be extended to add additional menu page components.
	 *
	 * @return array An array of any additional menu page components.
	 */
	public function menu_page_components()
	{
		$scripts = array(
			$this->instance->plugin_root_ns_with_dashes . '--stand-alone'
		); // Not implemented by core.

		return $scripts;
	}
}