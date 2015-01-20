<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 17/10/2014
 * Time: 3:42 μμ
 */

namespace skroutz\menu_pages\panels;

use xd_v141226_dev\menu_pages\panels\panel;

if ( ! defined( 'WPINC' ) )
	exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );

/**
 * Menu Page Panel.
 *
 * @package WebSharks\Core
 * @since 140914
 *
 * @assert ($GLOBALS[__NAMESPACE__])
 */
class donations extends panel {
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
	public function __construct( $instance, $menu_page ) {
		parent::__construct( $instance, $menu_page );

		$this->heading_title = $this->__( 'Donations Welcome' );

		$form_fields = $this->©form_fields(); // Object instance.

		$this->content_body = // Donations (form field selection).

			'<form' .
			' method="post"' .
			' target="_blank"' .
			' action="https://www.paypal.com/cgi-bin/webscr"' .
			'>' .

			$form_fields->markup( $form_fields->¤value( '_s-xclick' ), array(
				'type' => 'hidden',
				'name' => 'cmd'
			) ) .
			$form_fields->markup( $form_fields->¤value( 'WLGJ8L3ZJTFQQ' ), array(
				'type' => 'hidden',
				'name' => 'hosted_button_id'
			) ) .
			$form_fields->markup( $form_fields->¤value( 'Your site URL' ), array(
				'type' => 'hidden',
				'name' => 'on1'
			) ) .
			'<div class="form-group">' .
			'<div class="input-group select-input-group">' .
			'<span class="input-group-addon"><i class="fa fa-location-arrow fa-fw"></i></span>' .
			$form_fields->markup( $form_fields->¤value( $this->©urls->to_wp_home_uri() ), array(
				'type' => 'text',
				'name' => 'os1'
			) ) .
			'</div>' .
			'</div>' .
			$form_fields->markup( $form_fields->¤value( 'EUR' ), array(
				'type' => 'hidden',
				'name' => 'currency_code'
			) ) .
			'<div class="form-group">' .
			'<div class="input-group select-input-group">' .
			'<span class="input-group-addon"><i class="fa fa-heart fa-fw"></i></span>' .
			$form_fields->markup(
				$form_fields->¤value( 5 ),
				array(
					'required' => true,
					'type'     => 'select',
					'name'     => 'os0',
					'options'  => array(
						array(
							'label' => $this->__( '€2.00 EUR' ),
							'value' => '2'
						),
						array(
							'label' => $this->__( '€5.00 EUR' ),
							'value' => '5'
						),
						array(
							'label' => $this->__( '€8.00 EUR' ),
							'value' => '8'
						),
						array(
							'label' => $this->__( '€10.00 EUR' ),
							'value' => '10'
						),
						array(
							'label' => $this->__( '€15.00 EUR' ),
							'value' => '15'
						),
						array(
							'label' => $this->__( '€20.00 EUR' ),
							'value' => '20'
						),
						array(
							'label' => $this->__( '€30.00 EUR' ),
							'value' => '30'
						),
						array(
							'label' => $this->__( '€40.00 EUR' ),
							'value' => '40'
						),
						array(
							'label' => $this->__( '€60.00 EUR' ),
							'value' => '60'
						),
						array(
							'label' => $this->__( '€100.00 EUR' ),
							'value' => '100'
						)
					)
				)
			) .
			'</div>' .
			'</div>' .

			'<div class="form-group no-b-margin">' .
			$form_fields->markup(
				'<i class="fa fa-gift"></i> ' . $this->__( 'Donate' ) . ' <i class="fa fa-external-link"></i>',
				array(
					'type' => 'submit',
					'name' => 'submit'
				)
			) .
			'</div>' .

			'</form>';
	}
}