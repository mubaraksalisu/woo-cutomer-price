<?php
/**
* @package woo-customer-price
*/
require_once('SettingsTabContent.php');

class SettingsTab extends SettingsTabContent{

  // To register hooks
  public function register(){

    add_filter( 'woocommerce_settings_tabs_array', array( $this, 'customer_price_tab' ), 50 );
    add_action( 'woocommerce_settings_tabs_woo_customer_price', array( $this, 'settings_tab' ) );
    add_action( 'woocommerce_update_options_woo_customer_price', array( $this, 'update_settings' ) );

  }

    /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
  public function customer_price_tab($settings_tabs){

    $settings_tabs['woo_customer_price'] = __('Customer Price', ' woo-customer-price');
    return $settings_tabs;

  }


    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
  public function settings_tab() {
    woocommerce_admin_fields( $this->get_settings() );
  }


    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
  public function update_settings() {
    woocommerce_update_options( $this->get_settings() );
  }


}