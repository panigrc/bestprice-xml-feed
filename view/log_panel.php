<?php
/**
 * Project: skroutz.gr-xml-feed
 * File: info_panel.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 23/10/2014
 * Time: 11:04 μμ
 * Since: 141017
 * Copyright: 2014 Panagiotis Vagenas
 */
if ( ! defined( 'WPINC' ) ) {
	exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );
}

/* @var \skroutz\menu_pages\panels\log $callee */
/* @var \xd_v141226_dev\views $this */
$this->©diagnostic->loadDBLog();
$messages = $this->©diagnostic->get_messages('product');

//var_dump( $this->©diagnostic->get_messages_as_markup('product'));

if(empty($messages)){
	echo '<p>Log is empty</p>';
} else {
//	$messages = array_reverse($messages);
	$ids = array();
	foreach ( $messages as $k => $message ) {
//		$message['data'] = json_decode($message['data']);
//		if(in_array($message['data']->id, $ids)) continue;
//		$ids[] = $message['data']->id;
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo $message['msg']; ?>
			</div>
		</div>
		<?php
	}
}