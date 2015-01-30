<?php
/**
 * Created by PhpStorm.
 * User: Vagenas Panagiotis <pan.vagenas@gmail.com>
 * Date: 17/10/2014
 * Time: 8:25 μμ
 */
if (!defined('WPINC'))
	exit('Do NOT access this file directly: '.basename(__FILE__));

/* @var \xd_v141226_dev\menu_pages\panels\edd_license $callee */
/* @var \xd_v141226_dev\views $this */

if(!$this->©edd_updater->isEDD()){
	echo 'No valid license params. Please set edd.update = 1 and enter a valid url in edd.store_url option.';
	return;
}

$license   = $this->©edd_updater->getLicenseDataFromServer();
$activeLic = isset($license->license) && $license->license == 'valid';
?>
	<ul class="list-group">
		<li class="list-group-item">
			Status: <?php echo ($activeLic ? '<strong class="text-success">Active</strong>' : '<strong class="text-danger">Inactive</strong>'); ?>
		</li>
		<li class="list-group-item">
			Expiry Date: <strong><?php if($license->expires) echo date('d M, Y',strtotime($license->expires)); else echo 'No data'; ?></strong>
		</li>
		<li class="list-group-item">
			Licensed to: <strong><?php if($license->customer_email) echo $license->customer_email; else echo 'No data'; ?></strong>
		</li>
		<li class="list-group-item">
			Times Activated: <strong><?php if($license->site_count) echo $license->site_count; else echo '0'; ?></strong>
		</li>
		<li class="list-group-item">
			Activations Left: <strong><?php if($license->activations_left) echo $license->activations_left; else echo 'None'; ?></strong>
		</li>
	</ul>

	<div class="form-horizontal" role="form">
		<div class="form-group row">
			<label for="license" class="col-md-3 control-label"><?php echo $this->__('License'); ?></label>

			<div class="col-sm-7">
				<?php
				$inputOptions = array(
					'type'        => 'text',
					'name'        => '[license_input]',
					'title'       => $this->__('License'),
					'placeholder' => $this->__('Enter a valid license key'),
					'required'    => true,
					'id'          => 'license',
					'attrs'       => '',
					'classes'     => 'form-control col-md-9 license-input'
				);
				echo $callee->menu_page->option_form_fields->markup($this->©option->get('edd_license'), $inputOptions);
				?>
			</div>
		</div>
	</div>
<?php
$btnOpts = array(
	// Required.
	'type'    => 'button',
	'name'    => 'deactivate',
	// Common, but optional.
	'title'   => 'Deactivate License',
	// Custom classes.
	'classes' => 'btn btn-danger deactivate-lic col-md-5',
	// Custom attributes.
	'attrs'   => 'readonly data-target="#" '.($activeLic ? '' : 'disabled')
);
echo $callee->menu_page->©form_field->markup($this->__('Deactivate'), $btnOpts);

$btnOpts = array(
	// Required.
	'type'    => 'button',
	'name'    => 'activate',
	// Common, but optional.
	'title'   => 'Activate License',
	// Custom classes.
	'classes' => 'btn btn-success activate-lic col-md-5 col-md-offset-2',
	// Custom attributes.
	'attrs'   => 'readonly data-target="#" '.($activeLic ? 'disabled' : '')
);
echo $callee->menu_page->©form_field->markup($this->__('Activate'), $btnOpts);


