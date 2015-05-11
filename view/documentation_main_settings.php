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

?>
<div>
	<h3><?php echo $this->__( 'Main settings' ); ?></h3>
	<dl>
		<dt>
			<?php echo $this->__( 'XML File Generation Interval' ); ?>
		</dt>
		<dd>
			<?php echo $this->__( 'This option specifies the generation interval of the XML file.' ); ?>
			<?php echo $this->__( 'BestPrice.gr requires the file to be generated daily, but you can specify lower intervals.' ); ?>
			<cite class="text-info">
				<?php echo $this->__( 'Please beware that generating the XML file consumes system resources' ); ?>
			</cite>.
		</dd>

		<dt>
			<?php echo $this->__( 'Availability options' ); ?>
		</dt>
		<dd>
			<?php echo $this->__( 'BestPrice uses a fixed set of availability descriptions that will be crosslinked to the ones provided in your feed.' ); ?>
			<dl class="dl-horizontal">
				<dt>Available</dt>
				<dd><?php echo $this->__( 'refers to products that are available for pick up at your outlet' ); ?></dd>
				<dt>1 to 3 days</dt>
				<dd><?php echo $this->__( 'refers to products that can be delivered to your customer within 1 to 3 days' ); ?></dd>
				<dt>4 to 7 days</dt>
				<dd><?php echo $this->__( 'refers to products that can be delivered to your customer within 4 to 7 days' ); ?></dd>
				<dt>7+ days</dt>
				<dd><?php echo $this->__( 'refers to products that will be delivered in 7 days or more' ); ?></dd>
				<dt>Upon order</dt>
				<dd><?php echo $this->__( 'refers to products that are ordered upon customer request' ); ?></dd>
				<dt>Pre-order</dt>
				<dd><?php echo $this->__( 'refers to products that can be ordered before the actual release' ); ?></dd>
			</dl>
		</dd>

	</dl>
	<h4><?php echo $this->__( 'Advanced options' ); ?></h4>
	<dl>
		<dt>XML Generate Request Variable</dt>
		<dd>
			<?php echo $this->__( 'The variable name to use in XML generation request' ); ?>
		</dd>

		<dt>XML Generate Request Variable Value</dt>
		<dd>
			<?php echo $this->__( 'XML request variable value. Please use a unique alphanumeric string at least 12 chars long.' ); ?>
		</dd>

		<dt>Cached XML Filename</dt>
		<dd>
			<?php echo $this->__( 'Enter the name of the generated file. The XML file name must always have an .xml extension and not containing spaces.' ); ?>
		</dd>

		<dt><?php echo $this->__( 'Cached XML File Location' ); ?></dt>
		<dd>
			<?php echo $this->__( 'File location is relative to your WordPress install directory' ); ?>.
			<?php echo $this->__( 'eg to generate the file under the WordPress install dir enter "/", to generate it under uploads dir enter "/wp-content/uploads"' ); ?>
		</dd>
	</dl>
</div>
