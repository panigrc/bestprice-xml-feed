<?php
/**
 * Created by PhpStorm.
 * User: Vagenas Panagiotis <pan.vagenas@gmail.com>
 * Date: 17/10/2014
 * Time: 8:25 μμ
 */
if ( ! defined( 'WPINC' ) ) {
	exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );
}

/* @var \bestprice\menu_pages\panels\generate $callee */
/* @var \xd_v141226_dev\views $this */

$genNowBtnOpts = array(
	// Required.
	'type'    => 'button',
	'name'    => 'generate',
	// Common, but optional.
	'title'   => 'Generate XML Now',
	// Custom classes.
	'classes' => 'btn btn-primary generate-now col-md-12',
	// Custom attributes.
	'attrs'   => 'readonly data-target="#generateNowModal" data-toggle="xd-v141226-dev-modal"'
);
?>
<p class=""><?php echo $this->__( 'You can generate the XML file right now by clicking the following button' ); ?></p>
<?php
echo $callee->menu_page->©form_field->markup( $this->__( 'Generate XML Now' ), $genNowBtnOpts );
?>


<!-- Modal -->
<div class="modal fade" id="generateNowModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"><?php echo $this->__( 'Generating XML File' ); ?></h4>
			</div>
			<div class="modal-body">
				<!--				<div class="progress">-->
				<!--					<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0"-->
				<!--					     aria-valuemin="0" aria-valuemax="100" style="width: 0%">-->
				<!--					</div>-->
				<!--				</div>-->
			</div>
		</div>
	</div>
</div>