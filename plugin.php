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

/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/gpl-3.0.txt>.
 */

/* -- WordPress® -------------------------------------------------------------------------------------------------------

Version: 151228
Stable tag: 151228
Tested up to: 4.6.1
Requires at least: 4.0

Requires at least Apache version: 2.1
Tested up to Apache version: 2.4.7

Requires at least PHP version: 5.5
Tested up to PHP version: 5.5.9

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

-- end section for WordPress®. -------------------------------------------------------------------------------------- */

namespace bestprice {

	if ( ! defined( 'WPINC' ) ) {
		die;
	}
	require_once dirname( __FILE__ ) . '/includes/SimpleXMLExtended.php';

	require_once dirname( __FILE__ ) . '/classes/bestprice/framework.php';
}
