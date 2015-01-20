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
if ( ! defined( 'WPINC' ) )
	exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );

/* @var \bestprice\menu_pages\panels\info $callee */
/* @var \xd_v141226_dev\views $this */
/* @var array $info */

if(empty($info)){
	echo $this->__('File not generated yet. Please use the <i>Generate XML Now</i> button to generate a new file');
} else {
	?>
	<ul class="list-group">
		<?php
		foreach ( $info as $k => $v ) {
			echo '<li class="list-group-item">'.$k.': <strong>'.$v.'</strong></li>';
		}
		echo '<li class="list-group-item">';
		echo '<a class="btn btn-primary btn-sm" href="'.$info['File Url'].'" target="_blank" role="button">Open Cached File</a>';
		echo '<a class="pull-right btn btn-primary btn-sm copy-gen-url" href="' . home_url() . '/?'.$this->©option->get('xml_generate_var').'='.$this->©option->get('xml_generate_var_value').'" target="_blank" role="button">Open Generate URL</a>';
		echo '</li>';
		?>
	</ul>
	<?php
}

$getGenUrlButton = array(
	// Required.
	'type'    => 'button',
	'name'    => 'getGenUrl',
	// Common, but optional.
	'title'   => 'Get XML Generation URL',
	// Custom classes.
	'classes' => 'btn btn-primary getGenUrl col-md-12',
);
echo $callee->menu_page->©form_field->markup( $this->__( 'Get XML Generation URL' ), $getGenUrlButton );
?>
<script>
	(function($){
		var urlChanged = false;

		$('#xml-generate-var, #xml-generate-var-val').change(function(){
			urlChanged = true;
		});

		$('.getGenUrl').click(function(e){
			e.preventDefault();
			if(urlChanged){
				alert('<?php echo $this->__('Please save your current options first'); ?>');
				return false;
			}
			SKZHelper.prototype.copyToClipboard('<?php echo get_home_url(); ?>' + '?'+ $('#xml-generate-var').val() + '=' + $('#xml-generate-var-val').val());
		});
	})(jQuery);
</script>