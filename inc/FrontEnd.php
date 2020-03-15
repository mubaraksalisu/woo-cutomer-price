<?php
/**
* @package woo-customer-price
*/

class FrontEnd{

  public function register() {

    add_action( 'woocommerce_before_add_to_cart_button', array($this, 'bentbreed_text_field'), 9 );

    add_filter('woocommerce_product_single_add_to_cart_text', array($this, 'bentbreed_custom_cart_button_text') );

    add_filter('woocommerce_loop_add_to_cart_link', array($this, 'bentbreed_shop_custom_cart_button_text'), 10, 2 );

    add_filter( 'woocommerce_add_to_cart_validation', array($this, 'bentbreed_validate_custom_field'), 10, 3 );

    add_filter( 'woocommerce_add_cart_item_data', array($this, 'bentbreed_price_update'), 10, 4 );

    add_action( 'woocommerce_before_calculate_totals', array($this, 'bentbreed_before_calculate_totals'), 10, 1 );

  }
  /**
  * Display input on single product page
  * @return html
  */
  public function bentbreed_text_field(){
    global $post;

    $product = wc_get_product( $post->ID );
    $check = $product->get_meta( '_bentbreed_enable_woo_customer_price' );
    $title = get_settings( 'woo_customer_price_lebel' );

    if ( $check == 'yes') {

      if( $title != '' ){
        $label = $title;

      }else{ $label = 'State Your Price'; }

      echo '<p class = "form-row-wide">';

      printf(
        '<div class="bentbreed-custom-field-wrapper"><label for="bentbreed-title-field">%s</label><input type="text" id="bentbreed-title-field" name="bentbreed-title-field" value=""></div>',
        esc_html( $label . ':  ' )
        );

      echo '<p>';

    }
  }

  /**
   *  Overrides Add to cart button text on product page
   *  @return String
   */
  public function bentbreed_custom_cart_button_text() {

    global $post;

    $product = wc_get_product( $post->ID );
    $check = $product->get_meta( '_bentbreed_enable_woo_customer_price' );

    $button = get_settings( 'woo_customer_price_button_caption' );

    if( $button != "" && $check == 'yes'){

      return __( $button, 'woocommerce' );

    }
    else{

      return __( 'Add to cart', 'woocommerce' );

    }
  }

  /**
   *  Overrides Add to cart button text on shop page
   *  @return String
   */
  public function bentbreed_shop_custom_cart_button_text( $button, $product ) {

    $check = $product->get_meta( '_bentbreed_enable_woo_customer_price' );

    $button_caption = get_settings( 'woo_customer_price_shop_button_caption' );

    if($button_caption != '' && $check == 'yes'){

      $button_text = __($button_caption, 'woocommerce');
      $button = '<a class="button" href="' . $product->get_permalink() . '">' . $button_text . '</a>';
      return $button;

    }elseif($button_caption == '' && $check == 'yes'){

      $button_text = __('Add to cart', 'woocommerce');
      $button = '<a class="button" href="' . $product->get_permalink() . '">' . $button_text . '</a>';
      return $button;

    }else{ return $button; }


  }

    /**
   * Validate the text field
   * @param Array 		$passed					Validation status.
   * @param Integer   $product_id     Product ID.
   * @param Boolean  	$quantity   		Quantity
   */
  public function bentbreed_validate_custom_field( $passed, $product_id, $quantity ) {

    $min = get_post_meta( $product_id, '_min_price', true);
    $max = get_post_meta( $product_id, '_max_price', true);

    $min_error = get_option( 'woo_customer_price_min_error', true );
    $max_error = get_option( 'woo_customer_price_max_error', true );

    $value =  $_POST['bentbreed-title-field'];

    if( empty( $value ) ) {

      // passed validation
      $passed = true;

    }
    elseif( is_numeric( $value ) ){

      if( $value < $min ){

        if( $min_error != '' ){

          $message = $min_error;

        }else{

          $message = 'Price offer too low';

        }

        // Fails validation
        $passed = false;
        wc_add_notice( __( $message, 'woo-customer-price' ), 'error' );

      }
      elseif( $value > $max ){

        if( $max_error != '' ){

          $message = $max_error;

        }else{

          $message = 'Price offer too high';

        }

        // Fails validation
        $passed = false;
        wc_add_notice( __( $message, 'woo-customer-price' ), 'error' );

      }


    }
    elseif( !is_numeric( $value ) ){

      // Fails validation
      $passed = false;

      wc_add_notice( __( 'Please enter just the figure you want to pay into the text field. Just number, no text', 'woo-customer-price' ), 'error' );

    }


    add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'bentbreed_add_to_cart_redirect' ) );

    return $passed;

  }

  /**
   * Redirect users after add to cart.
   */
  function bentbreed_add_to_cart_redirect( $url ) {

    $redirect = get_option( 'woo_customer_price_redirect', true );

    if( empty( $redirect ) ){

      return $url;

    }elseif( !empty( $redirect ) && $redirect == 'checkout_page' ){

    	$url = WC()->cart->get_checkout_url(); // since WC 2.5.0
    	return $url;

    }elseif( !empty( $redirect ) && $redirect == 'cart_page' ){

    	$url = WC()->cart->get_cart_url();
    	return $url;

    }elseif( !empty( $redirect ) && $redirect == 'shop' ){

      return get_permalink( wc_get_page_id( 'shop' ) );

    }elseif( !empty( $redirect ) && $redirect == 'product_page' ){

      return $url;

    }

  }

    /**
   * Add the text field as item data to the cart object
   * @since 1.0.0
   * @param Array 		$cart_item_data Cart item meta data.
   * @param Integer   $product_id     Product ID.
   * @param Integer   $variation_id   Variation ID.
   * @param Boolean  	$quantity   		Quantity
   */
  public function bentbreed_price_update( $cart_item_data, $product_id, $variation_id, $quantity ) {

    if( ! empty( $_POST['bentbreed-title-field'] ) ) {

      // Add the item data
      $cart_item_data['title_field'] = $_POST['bentbreed-title-field'];
      $product = wc_get_product( $product_id );
      $price = $_POST['bentbreed-title-field'];
      $cart_item_data['total_price'] = $price;

     }

     return $cart_item_data;

  }

    /**
   * Update the price in the cart
   * @since 1.0.0
   */
  public function bentbreed_before_calculate_totals( $cart_obj ) {

    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
      return;
    }
    // Iterate through each cart item
    foreach( $cart_obj->get_cart() as $key=>$value ) {

      if( isset( $value['total_price'] ) ) {

        $price = $value['total_price'];
        $value['data']->set_price( ( $price ) );

      }
    }
  }


}