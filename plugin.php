<?php
/**
 * ${FILE_NAME}
 * User: vagenas
 * Date: 9/11/14
 * Time: 9:51 PM
 *
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @copyright 9/11/14 XDaRk.eu <xdark.eu@gmail.com>
 * @link http://xdark.eu
 */

/* -- WordPress® --------------------------------------------------------------------------------------------------------------------------

Version: 141017
Stable tag: 141017
Tested up to: 4.1
Requires at least: 3.5.1

Requires at least Apache version: 2.1
Tested up to Apache version: 2.4.7

Requires at least PHP version: 5.3.1
Tested up to PHP version: 5.5.12

Copyright: © 2014 XDaRk.eu
License: GNU General Public License
Contributors: XDaRk.eu

Author: Panagiotis Vagenas <pan.vagenas@gmail.com>
Author URI: http://xdark.eu

Text Domain: skroutz-xml-feed
Domain Path: /translations

Plugin Name: Skroutz.gr XML Feed
Plugin URI: http://interad.gr

Description: Generate XML sheet according to skroutz.gr specs
Tags: skroutz, skroutz.gr, XML, generate XML, price comparison
Kudos: WebSharks™ http://www.websharks-inc.com

-- end section for WordPress®. --------------------------------------------------------------------------------------------------------- */

namespace skroutz {

	if ( ! defined( 'WPINC' ) ) {
		die;
	}
	require_once dirname( __FILE__ ) . '/includes/SimpleXMLExtended.php';

	require_once dirname( __FILE__ ) . '/classes/skroutz/framework.php';
}