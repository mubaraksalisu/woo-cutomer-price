<?php
/*
Plugin Name: woo-customer-price
Plugin URI: https://codecanyon.net/user/bentbreed
Description: With this plugin it becomes possible to negotiate with all customers that visit your woocommerce store.
Version: 1.0
Author: Bentbreed
Author URI: https://codecanyon.net/user/bentbreed
Text Domain:  woo-customer-price
*/

// If this file is called directly, abort!!!
defined('ABSPATH') or die('you cannot access this file');

require_once('inc/Init.php');

// Initialize all core classes of the plugin.
if(class_exists('Init')){
  Init::register_services();
}