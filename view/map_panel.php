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

/* @var \bestprice\menu_pages\panels\map $callee */
/* @var \xd_v141226_dev\views $this */

$attrTaxonomies = wc_get_attribute_taxonomies();

?>

<div class="form-horizontal" role="form">
    <div class="form-group">

        <div class="form-group row">
            <label for="map-id" class="col-md-3 control-label"><?php echo $this->__( 'Product ID' ); ?></label>

            <div class="col-sm-7">
                <?php

                $options = array();

                $options[] = array(
                    'label' => $this->__( 'Use Product SKU' ),
                    'value' => '0'
                );
                $options[] = array(
                    'label' => $this->__( 'Use Product ID' ),
                    'value' => '1'
                );

                $inputOptions = array(
                    'type'        => 'select',
                    'name'        => '[map_id]',
                    'title'       => $this->__( 'Product Link' ),
                    'placeholder' => $this->__( 'Choose from where the product id should be taken' ),
                    'required'    => true,
                    'id'          => 'map-id',
                    'attrs'       => '',
                    'classes'     => 'form-control',
                    'options'     => $options
                );
                echo $callee->menu_page->option_form_fields->markup( $this->©option->get( 'map_id' ), $inputOptions );
                ?>
            </div>

        </div>

        <div class="form-group row">
            <label for="map-manufacturer"
                   class="col-md-3 control-label"><?php echo $this->__( 'Product Manufacturer Field' ); ?></label>

            <div class="col-sm-7">
                <?php

                $options = array();

                $options[] = array(
                    'label' => $this->__( 'Use Product Categories' ),
                    'value' => 'product_cat'
                );

                $options[] = array(
                    'label' => $this->__( 'Use Product Tags' ),
                    'value' => 'product_tag'
                );
                global $wp_taxonomies;

                foreach ( $attrTaxonomies as $taxonomies ) {
                    $options[] = array(
                        'label' => $taxonomies->attribute_label,
                        'value' => $taxonomies->attribute_id
                    );
                }

                if ( $this->©bestprice->hasBrandsPlugin() && ( $brandsTax = $this->©bestprice->getBrandsPluginTaxonomy() ) ) {
                    $options[] = array(
                        'label' => 'Use WooCommerce Brands Plugin',
                        'value' => $brandsTax->name
                    );
                }

                $inputOptions = array(
                    'type'        => 'select',
                    'name'        => '[map_manufacturer]',
                    'title'       => $this->__( 'Product Manufacturer Field' ),
                    'placeholder' => $this->__( 'Choose from where the product manufacturer should be taken' ),
                    'required'    => true,
                    'id'          => 'map-manufacturer',
                    'attrs'       => '',
                    'classes'     => 'form-control',
                    'options'     => $options
                );
                echo $callee->menu_page->option_form_fields->markup( $this->©option->get( 'map_manufacturer' ),
                    $inputOptions );
                ?>
            </div>

        </div>

        <div class="form-group row">
            <label for="map-mpn"
                   class="col-md-3 control-label"><?php echo $this->__( 'Product Manufacturer SKU' ); ?></label>

            <div class="col-sm-7">
                <?php

                $options = array();

                $options[] = array(
                    'label' => $this->__( 'Use Product SKU' ),
                    'value' => '0'
                );
                foreach ( $attrTaxonomies as $taxonomies ) {
                    $options[] = array(
                        'label' => $taxonomies->attribute_label,
                        'value' => $taxonomies->attribute_id
                    );
                }

                $inputOptions = array(
                    'type'        => 'select',
                    'name'        => '[map_mpn]',
                    'title'       => $this->__( 'Product Manufacturer SKU' ),
                    'placeholder' => $this->__( 'Choose from where the product manufacturer SKU should be taken' ),
                    'required'    => true,
                    'id'          => 'map-mpn',
                    'attrs'       => '',
                    'classes'     => 'form-control',
                    'options'     => $options
                );
                echo $callee->menu_page->option_form_fields->markup( $this->©option->get( 'map_mpn' ), $inputOptions );
                ?>
            </div>

        </div>

        <div class="form-group row">
            <label for="map-name" class="col-md-3 control-label"><?php echo $this->__( 'Product Name' ); ?></label>

            <div class="col-sm-3">
                <?php

                $options = array();

                $options[] = array(
                    'label' => $this->__( 'Use Product Name' ),
                    'value' => '0'
                );

                foreach ( $attrTaxonomies as $taxonomies ) {
                    $options[] = array(
                        'label' => $taxonomies->attribute_label,
                        'value' => $taxonomies->attribute_id
                    );
                }

                $inputOptions = array(
                    'type'        => 'select',
                    'name'        => '[map_name]',
                    'title'       => $this->__( 'Product Name' ),
                    'placeholder' => $this->__( 'Which field should be used for generating the product name' ),
                    'required'    => true,
                    'id'          => 'map-name',
                    'attrs'       => '',
                    'classes'     => 'form-control',
                    'options'     => $options
                );
                echo $callee->menu_page->option_form_fields->markup( $this->©option->get( 'map_name' ), $inputOptions );
                ?>
            </div>

            <label for="map-name-append-sku"
                   class="col-md-3 control-label"><?php echo $this->__( 'Append SKU to Product Name' ); ?></label>

            <div class="col-sm-2">
                <?php

                $inputOptions = array(
                    'type'    => 'checkbox',
                    'name'    => '[map_name_append_sku]',
                    'title'   => $this->__( 'If you check this the product SKU will be appended to product name. If no SKU is set then product ID will be used' ),
                    'id'      => 'map-name-append-sku',
                    'classes' => 'form-control',
                );
                echo $callee->menu_page->option_form_fields->markup( $this->©option->get( 'map_name_append_sku' ),
                    $inputOptions );
                ?>
            </div>
        </div>

        <div class="form-group row">
            <label for="map-image" class="col-md-3 control-label"><?php echo $this->__( 'Product Image' ); ?></label>

            <div class="col-sm-7">
                <?php

                $options = array(
                    array(
                        'label' => $this->__( 'Thumbnail' ),
                        'value' => '0'
                    ),
                    array(
                        'label' => $this->__( 'Medium' ),
                        'value' => '1'
                    ),
                    array(
                        'label' => $this->__( 'Large' ),
                        'value' => '2'
                    ),
                    array(
                        'label' => $this->__( 'Full' ),
                        'value' => '3'
                    )
                );

                $inputOptions = array(
                    'type'        => 'select',
                    'name'        => '[map_image]',
                    'title'       => $this->__( 'Product Image' ),
                    'placeholder' => $this->__( 'Choose from where the product image should be taken' ),
                    'required'    => true,
                    'id'          => 'map-image',
                    'attrs'       => '',
                    'classes'     => 'form-control',
                    'options'     => $options
                );
                echo $callee->menu_page->option_form_fields->markup( $this->©option->get( 'map_image' ),
                    $inputOptions );
                ?>
            </div>

        </div>

        <div class="form-group row">
            <label for="map-link" class="col-md-3 control-label"><?php echo $this->__( 'Product Link' ); ?></label>

            <div class="col-sm-7">
                <?php

                $options = array();

                $options[] = array(
                    'label' => $this->__( 'Use Product Permalink' ),
                    'value' => '0'
                );

                $inputOptions = array(
                    'type'        => 'select',
                    'name'        => '[map_link]',
                    'title'       => $this->__( 'Product Image' ),
                    'placeholder' => $this->__( 'Choose from where the product image should be taken' ),
                    'required'    => true,
                    'id'          => 'map-link',
                    'attrs'       => '',
                    'classes'     => 'form-control',
                    'options'     => $options
                );
                echo $callee->menu_page->option_form_fields->markup( $this->©option->get( 'map_link' ), $inputOptions );
                ?>
            </div>

        </div>

        <div class="form-group row">
            <label for="map-price-with-vat"
                   class="col-md-3 control-label"><?php echo $this->__( 'Product Price' ); ?></label>

            <div class="col-sm-7">
                <?php

                $options = array(
                    array(
                        'label' => $this->__( 'Regular Price' ),
                        'value' => '0'
                    ),
                    array(
                        'label' => $this->__( 'Sales Price' ),
                        'value' => '1'
                    ),
                    array(
                        'label' => $this->__( 'Price Without Tax' ),
                        'value' => '2'
                    )
                );

                $inputOptions = array(
                    'type'        => 'select',
                    'name'        => '[map_price_with_vat]',
                    'title'       => $this->__( 'Product Price' ),
                    'placeholder' => $this->__( 'Choose the price you want to use in XML' ),
                    'required'    => true,
                    'id'          => 'map-price-with-vat',
                    'attrs'       => '',
                    'classes'     => 'form-control',
                    'options'     => $options
                );
                echo $callee->menu_page->option_form_fields->markup( $this->©option->get( 'map_price_with_vat' ),
                    $inputOptions );
                ?>
            </div>

        </div>

        <div class="form-group row">
            <label for="map-category"
                   class="col-md-3 control-label"><?php echo $this->__( 'Product Categories' ); ?></label>

            <div class="col-sm-3">
                <?php

                $options = array();

                $options[] = array(
                    'label' => $this->__( 'Categories' ),
                    'value' => 'product_cat'
                );

                $options[] = array(
                    'label' => $this->__( 'Tags' ),
                    'value' => 'product_tag'
                );

                foreach ( $attrTaxonomies as $taxonomies ) {
                    $options[] = array(
                        'label' => $taxonomies->attribute_label,
                        'value' => $taxonomies->attribute_id
                    );
                }

                $inputOptions = array(
                    'type'        => 'select',
                    'name'        => '[map_category]',
                    'title'       => $this->__( 'Product Categories' ),
                    'placeholder' => $this->__( 'Which taxonomy describes best your products' ),
                    'required'    => true,
                    'id'          => 'map-category',
                    'attrs'       => '',
                    'classes'     => 'form-control',
                    'options'     => $options
                );
                echo $callee->menu_page->option_form_fields->markup( $this->©option->get( 'map_category' ),
                    $inputOptions );
                ?>
            </div>

            <?php
            $hide = 'style="' . ( is_numeric( $this->©option->get( 'map_category' ) ) ? 'display:none;' : '' ) . '"';
            ?>
            <label for="map-category-tree" <?php echo $hide; ?>
                   class="col-md-3 control-label hide-if-not-product-tax"><?php echo $this->__( 'Include full path to product category' ); ?></label>

            <div class="col-sm-3 hide-if-not-product-tax" <?php echo $hide; ?>>
                <?php
                $mapCategoryTree = $this->©option->get( 'map_category_tree' );

                $inputOptions = array(
                    'type'    => 'checkbox',
                    'name'    => '[map_category_tree]',
                    'title'   => $this->__( 'Include full path to product category' ),
                    'id'      => 'map-category-tree',
                    'classes' => 'form-control'
                );

                echo $callee->menu_page->option_form_fields->markup( $mapCategoryTree, $inputOptions );
                ?>
            </div>

        </div>

        <div class="form-group row">
            <label for="is-fashion-store"
                   class="col-md-3 control-label"><?php echo $this->__( 'This Store Contains Fashion Products' ); ?></label>

            <div class="col-sm-3">
                <?php
                $isFashionStore = $this->©option->get( 'is_fashion_store' );

                $inputOptions = array(
                    'type'        => 'checkbox',
                    'name'        => '[is_fashion_store]',
                    'title'       => $this->__( 'This Store Contains Fashion Products' ),
                    'placeholder' => $this->__( 'Check this if your store has fashion products' ),
                    'id'          => 'is-fashion-store',
                    'classes'     => 'form-control'
                );
                if ( ! empty( $attrTaxonomies ) ) {
                    echo $callee->menu_page->option_form_fields->markup( $isFashionStore, $inputOptions );
                } else {
                    echo '<p class="bg-danger">' . $this->__( 'If your store contains fashion products please add some product attributes to specify color and sizes' ) . '</p>';
                }
                ?>
            </div>

        </div>
        <div id="fashion-store-fields" <?php if ( ! $isFashionStore ) {
            echo 'style="display:none;"';
        } ?>>
            <div class="form-group row">
                <label for="map-size" class="col-md-3 control-label"><?php echo $this->__( 'Product Sizes' ); ?></label>

                <div class="col-sm-3">
                    <?php

                    $options = array();

                    foreach ( $attrTaxonomies as $taxonomies ) {
                        $options[] = array(
                            'label' => $taxonomies->attribute_label,
                            'value' => $taxonomies->attribute_id
                        );
                    }

                    $inputOptions = array(
                        'type'        => 'select',
                        'multiple'    => true,
                        'name'        => '[map_size]',
                        'title'       => $this->__( 'Product Sizes' ),
                        'placeholder' => $this->__( 'Select the attribute that describes product sizes' ),
                        'required'    => (bool) $this->©option->get( 'is_fashion_store' ),
                        'id'          => 'map-size',
                        'attrs'       => '',
                        'classes'     => 'form-control',
                        'options'     => $options
                    );
                    if ( ! empty( $attrTaxonomies ) ) {
                        echo $callee->menu_page->option_form_fields->markup( $this->©option->get( 'map_size' ),
                            $inputOptions );
                    }
                    ?>
                </div>

            </div>

            <div class="form-group row">
                <label for="map-color"
                       class="col-md-3 control-label"><?php echo $this->__( 'Product Colors' ); ?></label>

                <div class="col-sm-3">
                    <?php

                    $options = array();

                    foreach ( $attrTaxonomies as $taxonomies ) {
                        $options[] = array(
                            'label' => $taxonomies->attribute_label,
                            'value' => $taxonomies->attribute_id
                        );
                    }

                    $inputOptions = array(
                        'type'        => 'select',
                        'multiple'    => true,
                        'name'        => '[map_color]',
                        'title'       => $this->__( 'Product Colors' ),
                        'placeholder' => $this->__( 'Select the attribute that describes product colors' ),
                        'id'          => 'map-color',
                        'attrs'       => '',
                        'classes'     => 'form-control',
                        'options'     => $options
                    );
                    if ( ! empty( $attrTaxonomies ) ) {
                        echo $callee->menu_page->option_form_fields->markup( $this->©option->get( 'map_color' ),
                            $inputOptions );
                    }
                    ?>
                </div>

            </div>
        </div>

        <div class="form-group row">
            <label for="is-book-store"
                   class="col-md-3 control-label"><?php echo $this->__( 'Are You Selling Books' ); ?></label>

            <div class="col-sm-3">
                <?php
                $isBookStore = $this->©option->get( 'is_book_store' );

                $inputOptions = array(
                    'type'        => 'checkbox',
                    'name'        => '[is_book_store]',
                    'title'       => $this->__( 'Are You Selling Books' ),
                    'placeholder' => $this->__( 'Check this if you are selling books. In this case you must set the ISBN of each book.' ),
                    'id'          => 'is-book-store',
                    'classes'     => 'form-control'
                );
                echo $callee->menu_page->option_form_fields->markup( $isBookStore, $inputOptions );
                ?>
            </div>

        </div>

        <div id="book-store-fields" <?php if ( ! $isBookStore ) {
            echo 'style="display:none;"';
        } ?>>
            <div class="form-group row">
                <label for="map-isbn" class="col-md-3 control-label"><?php echo $this->__( 'ISBN' ); ?></label>

                <div class="col-sm-7">
                    <?php

                    $options = array();

                    $options[] = array(
                        'label' => $this->__( 'Use Product SKU' ),
                        'value' => '0'
                    );

                    foreach ( $attrTaxonomies as $taxonomies ) {
                        $options[] = array(
                            'label' => $taxonomies->attribute_label,
                            'value' => $taxonomies->attribute_id
                        );
                    }

                    $inputOptions = array(
                        'type'        => 'select',
                        'name'        => '[map_isbn]',
                        'title'       => $this->__( 'ISBN' ),
                        'placeholder' => $this->__( 'Choose the field that contains books ISBN' ),
                        'id'          => 'map-isbn',
                        'attrs'       => '',
                        'classes'     => 'form-control',
                        'options'     => $options
                    );
                    echo $callee->menu_page->option_form_fields->markup( $this->©option->get( 'map_isbn' ),
                        $inputOptions );
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    jQuery('document').ready(function ($) {
        $('#is-fashion-store').change(function () {
            if (this.checked) {
                $('#fashion-store-fields').slideDown({duration: 'fast', easing: 'swing'});
            } else {
                $('#fashion-store-fields').slideUp({duration: 'fast', easing: 'swing'});
            }
        });

        $('#is-book-store').change(function () {
            if (this.checked) {
                $('#book-store-fields').slideDown({duration: 'fast', easing: 'swing'});
            } else {
                $('#book-store-fields').slideUp({duration: 'fast', easing: 'swing'});
            }
        });
    });
</script>