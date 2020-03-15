<?php
/**
* @package woo-customer-price
*/

class MetaContent{
  /**
   *  call back function for adding product data tab content/fields
   *  @return html
   */
  public function bentbreed_meta_options_product_tab_content() {

         woocommerce_wp_checkbox(
           array(
                  'id' => '_bentbreed_enable_woo_customer_price',
                  'label' => __('Enabled/Disabled', 'woocommerce'),
                  'description' => __('Enables woo customer price for this product.', 'woocommerce')
              ));

          woocommerce_wp_text_input( array(
          'id'				=> '_min_price',
          'label'				=> __( 'Minimum Price', 'woocommerce' ),
          'desc_tip'			=> 'true',
          'description'		=> __( 'Enter the minimum price for this product', 'woocommerce' ),
          'type' 				=> 'number',
          'placeholder' => 'Minimum price',
          'custom_attributes'	=> array(
          'min'	=> '1',
          'step'	=> '1',
          ),

          ) );

          woocommerce_wp_text_input( array(
          'id'				=> '_max_price',
          'label'				=> __( 'Maximum Price', 'woocommerce' ),
          'desc_tip'			=> 'true',
          'description'		=> __( 'Enter the maximum price for this product', 'woocommerce' ),
          'type' 				=> 'number',
          'placeholder' => 'Maximum price',
          'custom_attributes'	=> array(
          'min'	=> '1',
          'step'	=> '1',
          ),
          ) );


      }

}