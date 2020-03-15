<?php
/**
* @package woo-customer-price
*/
require_once('FrontEnd.php');
require_once('metabox/ProductMetabox.php');
require_once('settings/SettingsTab.php');

final class Init {

  public static function get_services(){

    return array( ProductMetabox::class, SettingsTab::class, FrontEnd::class );
  }

  public static function register_services(){
    foreach (self::get_services() as $class) {
      $service = self::instantiate($class);

      if(method_exists($service, 'register') ){
        $service->register();
      }
    }
  }

  private static function instantiate( $class ){
    $service = new $class();

    return $service;
  }
}