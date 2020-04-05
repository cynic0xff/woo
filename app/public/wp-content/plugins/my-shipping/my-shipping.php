<?php
/**
 * Plugin Name: Myshipping
 * Description: Create a woocommerce custom shipping method plugin
 */
if (!defined('WPINC')) {
    die('security by preventing any direct access to your plugin file');
}
if ( ! defined( 'WPINC' ) ) {
 
    die;
 
}
 
/*
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
    function my_shipping_method() {
        if ( ! class_exists( 'My_Shipping_Method' ) ) {
            class My_Shipping_Method extends WC_Shipping_Method {
               
                public function __construct() {
                    $this->id                 = 'my'; 
                    $this->method_title       = __( 'TMy Shipping', 'my' );  
                    $this->method_description = __( 'Custom Shipping Method', 'my' ); 
 
                    // Availability & Countries
                    $this->availability = 'including';
                    $this->countries = array(
                        'US', // Unites States of America
                        'CA', // Canada
                        'DE', // Germany
                        'GB', // United Kingdom
                        'IT',   // Italy
                        'ES', // Spain
                        'HR'  // Croatia
                        );
 
                    $this->init();
 
                    $this->enabled = isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'yes';
                    $this->title = isset( $this->settings['title'] ) ? $this->settings['title'] : __( 'MyShipping', 'my' );
                }
 
           
              function init() {
                    // Load the settings API
                    $this->init_form_fields(); 
                    $this->init_settings(); 
 
                    // Save settings in admin if you have any defined
                    add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }
 
            
                function init_form_fields() { 
 
                    $this->form_fields = array(
 
                     'enabled' => array(
                          'title' => __( 'Enable', 'my' ),
                          'type' => 'checkbox',
                          'description' => __( 'Enable this shipping.', 'my' ),
                          'default' => 'yes'
                          ),
 
                     'title' => array(
                        'title' => __( 'Title', 'my' ),
                          'type' => 'text',
                          'description' => __( 'Title to be display on site', 'my' ),
                          'default' => __( 'MyShipping', 'my' )
                          ),
 
                     'weight' => array(
                        'title' => __( 'Weight (kg)', 'my' ),
                          'type' => 'number',
                          'description' => __( 'Maximum allowed weight', 'my' ),
                          'default' => 100
                          ),
 
                     );
 
                }
 
                /**
                 * This function is used to calculate the shipping cost. Within this function we can check for weights, dimensions and other parameters.
               */
                public function calculate_shipping( $package ) {
                    
                    $weight = 0;
                    $cost = 0;
                    $country = $package["destination"]["country"];
 
                    foreach ( $package['contents'] as $item_id => $values ) 
                    { 
                        $_product = $values['data']; 
                        $weight = $weight + $_product->get_weight() * $values['quantity']; 
                    }
 
                    $weight = wc_get_weight( $weight, 'kg' );
 
                    if( $weight <= 10 ) {
 
                        $cost = 0;
 
                    } elseif( $weight <= 30 ) {
 
                        $cost = 5;
 
                    } elseif( $weight <= 50 ) {
 
                        $cost = 10;
 
                    } else {
 
                        $cost = 20;
 
                    }
 
                    $countryZones = array(
                        'HR' => 0,
                        'US' => 3,
                        'GB' => 2,
                        'CA' => 3,
                        'ES' => 2,
                        'DE' => 1,
                        'IT' => 1
                        );
 
                    $zonePrices = array(
                        0 => 10,
                        1 => 30,
                        2 => 50,
                        3 => 70
                        );
 
                    $zoneFromCountry = $countryZones[ $country ];
                    $priceFromZone = $zonePrices[ $zoneFromCountry ];
 
                    $cost += $priceFromZone;

                    //TODO: get the value from the API
                    $cost = 123;
 
                    $rate = array(
                        'id' => $this->id,
                        'label' => $this->title,
                        'cost' => $cost
                    );
 
                    $this->add_rate( $rate );
                    
                }
            }
        }
    }
 
    add_action( 'woocommerce_shipping_init', 'my_shipping_method' );
 
    function add_my_shipping_method( $methods ) {
        $methods[] = 'My_Shipping_Method';
        return $methods;
    }
 
    add_filter( 'woocommerce_shipping_methods', 'add_my_shipping_method' );
 
    function my_validate_order( $posted )   {
 
        $packages = WC()->shipping->get_packages();
 
        $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
         
        if( is_array( $chosen_methods ) && in_array( 'my', $chosen_methods ) ) {
             
            foreach ( $packages as $i => $package ) {
 
                if ( $chosen_methods[ $i ] != "my" ) {
                             
                    continue;
                             
                }
 
                $My_Shipping_Method = new My_Shipping_Method();
                $weightLimit = (int) $My_Shipping_Method->settings['weight'];
                $weight = 0;
 
                foreach ( $package['contents'] as $item_id => $values ) 
                { 
                    $_product = $values['data']; 
                    $weight = $weight + $_product->get_weight() * $values['quantity']; 
                }
 
                $weight = wc_get_weight( $weight, 'kg' );
                
                if( $weight > $weightLimit ) {
 
                        $message = sprintf( __( 'Sorry, %d kg exceeds the maximum weight of %d kg for %s', 'my' ), $weight, $weightLimit, $My_Shipping_Method->title );
                             
                        $messageType = "error";
 
                        if( ! wc_has_notice( $message, $messageType ) ) {
                         
                            wc_add_notice( $message, $messageType );
                      
                        }
                }
            }       
        } 
    }
 
    add_action( 'woocommerce_review_order_before_cart_contents', 'my_validate_order' , 10 );
    add_action( 'woocommerce_after_checkout_validation', 'my_validate_order' , 10 );
}

