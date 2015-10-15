<?php
/**
 * Project: bestprice.gr-xml-feed
 * File: info_panel.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 23/10/2014
 * Time: 11:04 μμ
 * Since: 150120
 * Copyright: 2014 Panagiotis Vagenas
 */
if ( ! defined( 'WPINC' ) ) {
	exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );
}

/* @var \bestprice\menu_pages\panels\log $callee */
/* @var \xd_v141226_dev\views $this */

$this->©diagnostic->loadDBLog();
$messages = $this->©diagnostic->get_messages( 'product' );

//var_dump( $this->©diagnostic->get_messages_as_markup('product'));
if ( empty( $messages ) ) {
	echo '<p>Log is empty</p>';
} else {
	$ids = array();
	foreach ( $messages as $k => $message ) {
//		$message['data'] = json_decode($message['data']);
		switch ( $message['type'] ) {
			case 'error':
				$msgClass = 'alert alert-danger';
				break;
			case 'message':
				$msgClass = 'alert alert-warning';
				break;
			case 'success':
				$msgClass = 'alert alert-success';
				break;
			default:
			case 'diagnostic':
				$msgClass = 'alert alert-info';
				break;
		}
		?>
		<div class="<?php echo $msgClass; ?>">
			<?php echo $message['msg']; ?>
		</div>
		<?php
	}
}