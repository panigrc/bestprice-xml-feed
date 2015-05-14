<?php
/**
 * plugin.php
 * User: vagenas
 * Date: 9/11/14
 * Time: 9:51 PM
 *
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @copyright 2015 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */

/* -- WordPress® --------------------------------------------------------------------------------------------------------------------------

Version: 150120
Stable tag: 150120
Tested up to: 4.2.2
Requires at least: 3.5.1

Requires at least Apache version: 2.1
Tested up to Apache version: 2.4.7

Requires at least PHP version: 5.3.1
Tested up to PHP version: 5.5.12

Copyright: © 2015 Panagiotis Vagenas <pan.vagenas@gmail.com>
License: GNU General Public License
Contributors: pan.vagenas

Author: Panagiotis Vagenas <pan.vagenas@gmail.com>
Author URI: http://gr.linkedin.com/in/panvagenas

Text Domain: bestprice-xml-feed
Domain Path: /translations

Plugin Name: BestPrice.gr XML Feed
Plugin URI: https://github.com/panvagenas/bestprice-xml-feed

Description: Generate XML sheet according to bestprice.gr specs
Tags: bestprice, bestprice.gr, XML, generate XML, price comparison
Kudos: WebSharks™ http://www.websharks-inc.com

-- end section for WordPress®. --------------------------------------------------------------------------------------------------------- */

namespace bestprice {

	if ( ! defined( 'WPINC' ) ) {
		die;
	}
	require_once dirname( __FILE__ ) . '/includes/SimpleXMLExtended.php';

	require_once dirname( __FILE__ ) . '/classes/bestprice/framework.php';
}