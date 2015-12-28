<?php
/**
 * User: vagenas
 * Date: 9/11/14
 * Time: 9:53 PM
 *
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @copyright 2015 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */

namespace bestprice;

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once dirname( dirname( dirname( __FILE__ ) ) ) . '/core/stub.php';

/**
 * Class framework
 *
 * @package bestprice
 * @since   150120
 *
 * @assert ($GLOBALS[__NAMESPACE__])
 *
 * @property \bestprice\xml       $©xml
 * @method \bestprice\xml          ©xml()
 *
 * @property \bestprice\bestprice $©bestprice
 * @method \bestprice\bestprice      ©bestprice()
 */
class framework extends \xd__framework {
}

$GLOBALS[ __NAMESPACE__ ] = new framework(
	array(
		'plugin_root_ns' => __NAMESPACE__, // The root namespace
		'plugin_var_ns'  => 'bsp',
		'plugin_cap'     => 'manage_options',
		'plugin_name'    => 'BestPrice.gr XML Feed',
		'plugin_version' => '151228',
		'plugin_site'    => 'https://github.com/panvagenas/bestprice-xml-feed',
		'plugin_dir'     => dirname( dirname( dirname( __FILE__ ) ) ) // Your plugin directory.

	)
);