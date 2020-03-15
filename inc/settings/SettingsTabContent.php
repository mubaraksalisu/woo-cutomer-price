<?php
/**
* @package woo-customer-price
*/

class SettingsTabContent{

  /**
   * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
   *
   * @return array Array of settings for @see woocommerce_admin_fields() function.
   */
public function get_settings() {

  $pages = get_pages();

  $settings = array(
    'section_title' => array(
      'name'     => __( 'Content Settings', 'woo-customer-price' ),
      'type'     => 'title',
      'desc'     => 'Setup the front end look of your customer price content',
      'id'       => 'woo_customer_price_title'
    ),

    'lebel' => array(
      'name' => __( 'Customer price lebel', 'woo-customer-price' ),
      'type' => 'text',
      'placeholder' => 'Lebel text',
      'desc_tip' => __('This is the lebel of the text box where customer will enter their price', 'woo-customer-price' ),
      'id'   => 'woo_customer_price_lebel'
    ),

    'button_caption' => array(
      'name' => __( 'Add to cart button caption on product page', 'woo-customer-price' ),
      'type' => 'text',
      'placeholder' => 'Button caption',
      'desc_tip' => __('Whatever you enter here will override the add to cart button text on product page', 'woo-customer-price' ),
      'id'   => 'woo_customer_price_button_caption'
    ),

    'min_error' => array(
      'name' => __( 'Below min. price error message', 'woo-customer-price' ),
      'type' => 'text',
      'placeholder' => 'Minimum price error message',
      'desc_tip' => __('Whatever you enter here will be displayed when customer enter price below your specified minimum price', 'woo-customer-price' ),
      'id'   => 'woo_customer_price_min_error'
    ),

    'max_error' => array(
      'name' => __( 'Above max. price error message', 'woo-customer-price' ),
      'type' => 'text',
      'placeholder' => 'Maximum price error message',
      'desc_tip' => __('Whatever you enter here will be displayed when customer enter price above your specified maximum price', 'woo-customer-price' ),
      'id'   => 'woo_customer_price_max_error'
    ),

    'shop_button_caption' => array(
      'name' => __( 'Add to cart button caption on shop page', 'woo-customer-price' ),
      'type' => 'text',
      'placeholder' => 'Button caption',
      'desc_tip' => __('Whatever you enter here will override the add to cart button text on shop page', 'woo-customer-price' ),
      'id'   => 'woo_customer_price_shop_button_caption'
    ),

    'page_redirect' => array(
      'type'     => 'select',
      'id'       => 'woo_customer_price_redirect',
      'name'     => __( 'Page redirect after add to cart', 'woo-customer-price' ),
      'options'  => array(
        'shop'     => __( 'Shop', 'woo-customer-price' ),
        'cart_page'     => __( 'Cart page', 'woo-customer-price' ),
        'checkout_page' => __( 'Checkout page', 'woo-customer-price' ),
        'product_page'  => __( 'Same product page', 'woo-customer-price' ),
      ),
      'class'    => 'wc-enhanced-select',
      'desc_tip' => __( 'Choose which page customers should be redirected to after adding the product to cart', 'woo-customer-price' ),
      'default'  => 'product_page',
    ),

    'section_end' => array(
      'type' => 'sectionend',
      'id' => 'woo_customer_price_section_end'
    )
  );

  return apply_filters( 'wc_settings_tab_wcp_settings', $settings );

  }

}