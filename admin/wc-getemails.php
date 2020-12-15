<?php

/**
 * Integration Demo.
 *
 * @package  Woocommerce Getemails
 * @category Integration
 * @author   Getemails.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Define plugin constants
 */
define( 'GETEMAILS_PATH', trailingslashit( plugin_dir_path(__FILE__) ) );

/**
 * Include files
 */
require_once GETEMAILS_PATH . '/inc/cart-script.php';
require_once GETEMAILS_PATH . '/inc/order-script.php';


if ( ! class_exists( 'WC_Getemails_plugin' ) ) :
  class WC_Getemails_plugin extends WC_Integration {

    /**
     * Init and hook in the integration.
     */
    public function __construct() {
      global $woocommerce;
      $this->id                 = 'getemails-integration';
      $this->method_title       = __( 'Getemails Integration');
      $this->method_description = __( 'Getemails Integration.');

      // Load the settings.
      $this->init_form_fields();
      $this->init_settings();

      // Define user set variables.
      $this->add_to_cart_available = $this->get_option( 'add_to_cart_available' );
      $this->order_available       = $this->get_option( 'order_available' );
      
      // Actions.
      add_action( 'woocommerce_update_options_integration_' .  $this->id, array( $this, 'process_admin_options' ) );
      add_action( 'woocommerce_after_add_to_cart_button', 'call_add_to_cart_script' );
      add_action( 'woocommerce_order_status_completed', 'call_order_script', 10, 1);
    }
    
    /**
     * Initialize integration settings form fields.
     */
    public function init_form_fields() {
      $this->form_fields = array(
        'add_to_cart_available' => array(
            'title'             => __( 'Add to cart' ),
            'type'              => 'checkbox',
            'description'       => __( 'Add to cart' ),
            'desc_tip'          => true,
            'default'           => false
        ),
        'order_available' => array(
            'title'             => __( 'Track Orders' ),
            'type'              => 'checkbox',
            'description'       => __( 'Track Orders' ),
            'desc_tip'          => true,
            'default'           => false
        ),
      );
    }

    public function call_add_to_cart_script(){
      if ( $this->add_to_cart_available ) {
        add_action('wp_footer', 'cart_script_template');
      }
    }

    public function call_order_script(){
      if ( $this->order_available ) {
        add_action('wp_footer', 'order_script_template');
      }
    }

  }
endif;