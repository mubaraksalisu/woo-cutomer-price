<?php
/**
* @package woo-customer-price
*/
require_once('MetaContent.php');

class ProductMetabox extends MetaContent{

  public function register()
  {

    //the hook for adding content to the general tab in product data page
    add_action( 'woocommerce_product_options_general_product_data', array( $this, 'bentbreed_meta_options_product_tab_content' ), 99);

    // Hook for saving information collected from fields of the custom product data tab created above
    add_action( 'woocommerce_process_product_meta', array( $this, 'bentbreed_meta_option_fields' ) );

  }

  public function bentbreed_meta_option_fields($post_id){

    $bentbreed_enable_woo_customer_price = isset($_POST['_bentbreed_enable_woo_customer_price']) ? 'yes' : 'no';
    update_post_meta($post_id, '_bentbreed_enable_woo_customer_price', $bentbreed_enable_woo_customer_price);

    if(isset($_POST['_min_price'])){
        update_post_meta( $post_id, '_min_price', absint($_POST['_min_price'] ) );
    }

    if(isset($_POST['_max_price'])){
        update_post_meta( $post_id, '_max_price', absint($_POST['_max_price'] ) );
    }

  }

}