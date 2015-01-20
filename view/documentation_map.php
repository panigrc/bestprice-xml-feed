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

/* @var \skroutz\menu_pages\panels\generate $callee */
/* @var \skroutz\views $this */

?>
<div class="row">
	<h3><?php echo $this->__( 'Field Map Settings' ); ?></h3>
	<dl class="">

		<dt><?php echo $this->__( 'Product ID' ); ?></dt>
		<dd>
			Specify the product ID as it will be included in XML file.
			<div class="alert alert-warning" style="font-size: 1.2em; line-height: 1.1em">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
						class="sr-only">Close</span></button>
				<span class="glyphicon glyphicon-warning-sign pull-left" role="alert"
				      style="font-size: 2.4em; margin-right: 10px"></span>
				<?php echo $this->__( 'This identifier should be specified once and before submitting the file in Skroutz.' ); ?>
				<?php echo $this->__( 'Once Skroutz starts to classify your products this identifier must never change again.' ); ?>
			</div>
		</dd>

		<dt>Product Manufacturer Field</dt>
		<dd>
			<?php echo $this->__( 'This option let you specify the source of product manufacturer.' ); ?>
			<?php echo $this->__( 'Some users may use categories, others may use custom attributes.' ); ?>
			<?php echo $this->__( 'Make a selection according to your setup.' ); ?>
		</dd>

		<dt><?php echo $this->__( 'Product Manufacturer SKU' ); ?></dt>
		<dd>
			<?php echo $this->__( 'Set the source of the SKU that is used by the manufacturer.' ); ?>
			<?php echo $this->__( 'This field is required according to Skroutz XML specs so if you haven\'t set this already, do so before submitting your XML.' ); ?>
			<?php echo $this->__( 'Of course your product ID and manufacturer SKU can be the same in case this is real, no limitation on this.' ); ?>
		</dd>

		<dt><?php echo $this->__( 'Product Name' ); ?></dt>
		<dd>
			<?php echo $this->__( 'Usually this is the product title. You can select custom attributes in case you need so.' ); ?>
		</dd>

		<dt><?php echo $this->__( 'Append SKU to Product Name' ); ?></dt>
		<dd>
			<?php echo $this->__( 'This should be on by default, Skroutz suggests that product SKU should be defined in product name.' ); ?>
			<?php echo $this->__( 'Disable this if you already have included SKU in product name.' ); ?>
		</dd>

		<dt><?php echo $this->__( 'Product Image' ); ?></dt>
		<dd>
			<?php echo $this->__( 'For now there is one and only one option.' ); ?>
			<?php echo $this->__( 'In future releases we may introduce some other functionalities for this field.' ); ?>
		</dd>

		<dt><?php echo $this->__( 'Product Link' ); ?></dt>
		<dd>
			<?php echo $this->__( 'For now there is one and only one option.' ); ?>
			<?php echo $this->__( 'In future releases we may introduce some other functionalities for this field.' ); ?>
		</dd>

		<dt><?php echo $this->__( 'Product Price' ); ?></dt>
		<dd>
			<?php echo $this->__( 'This should be left to regular price.' ); ?>
			<?php echo $this->__( 'Change this if regular price doesn\'t reflect the actual price tax included.' ); ?>
		</dd>

		<dt><?php echo $this->__( 'Product Categories' ); ?></dt>
		<dd>
			<?php echo $this->__( 'Choose this according to your setup.' ); ?>
			<?php echo $this->__( 'Categories should be descriptive and classify your products.' ); ?>
		</dd>

		<dt><?php echo $this->__( 'This Store Contains Fashion Products' ); ?></dt>
		<dd>
			<?php echo $this->__( 'Check this if you are selling products that have sizes and/or colors (shoes, clothing etc)' ); ?>
		</dd>

		<dt><?php echo $this->__( 'Product Sizes and Colors' ); ?></dt>
		<dd>
			<?php echo $this->__( 'In these fields you can choose the attributes that you are using to specify product attributes-variations.' ); ?>
			<?php echo $this->__( 'If the check box next to the multiselect fields are not checked then selected attributes will have no effect on XML generation.' ); ?>
		</dd>

	</dl>
</div>

<script type="text/javascript">
	(function ($) {
		$('.documentation').click(function (e) {
			$('.close').click(function () {
				$(this).parent().hide();
			});
		});
	})(jQuery);
</script>