<?php
/**
 * User: vagenas
 * Date: 9/11/14
 * Time: 10:10 PM
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @copyright 9/11/14 XDaRk.eu <xdark.eu@gmail.com>
 * @link http://xdark.eu
 */

namespace skroutz;

if (!defined('WPINC')) {
	die;
}

/**
 *
 * @package skroutz
 * @author pan.vagenas <pan.vagenas@gmail.com>
 */
class initializer extends \xd_v141226_dev\initializer
{

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 141015
	 */
	public function after_setup_theme_hooks()
	{
		if ($this->©edd_updater->getLicenseStatus()) {
			$this->add_action('wp_loaded', '©initializer.wp_loaded', 100000);
			$this->add_action('init', '©initializer.init_hook');
		} else {
			$this->©crons->delete(true);
		}
	}

	/**
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 141015
	 */
	public function wp_loaded()
	{
		$cron_jobs = array(
			array(
				'©class.method' =>
					'©skroutz.do_your_woo_stuff',
				'schedule'      => $this->©option->get('xml_interval')
			)
		);
		$this->©crons->config($cron_jobs);
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 141015
	 */
	public function init_hook()
	{
		$generateVar = $this->©option->get('xml_generate_var');
		if(empty($generateVar)){
			$generateVar = 'skroutz_' . $this->©string->random(12, false, false);
			$this->©option->update(array('xml_generate_var' => $generateVar));
		}

		$generateVarVal = $this->©option->get('xml_generate_var_value');
		if(empty($generateVarVal)){
			$generateVarVal = $this->©string->random(24, false, false);
			$this->©option->update(array('xml_generate_var_value' => $generateVarVal));
		}

		$parsed = $this->©url->parse($this->©url->current());
		if(isset($parsed['query'])){
			parse_str($parsed['query']);
		}

		if (isset($$generateVar) && $$generateVar == $generateVarVal) {
			$this->add_action('wp_loaded', '©skroutz.generate_and_print', PHP_INT_MAX);
		}
	}
}