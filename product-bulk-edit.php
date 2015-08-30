<?php
/**
 * Plugin Name:     WooCommerce Product Bulk Edit
 * Description:     Creates Bulk Edit Pages for Products
 * Author:          essenmitsosse
 * Version:         1.0.0
 * Author URI:      http://essenmitsosse.de
 * Text Domain:     woocommerce-product-bulk-edit
 * Upgrade Check:   none
 * Last Change:     30.08.2015 4:00
 */

if ( ! defined( "ABSPATH" ) ) {
	exit; // Exit if accessed directly
}

class Woocoomerce_Product_Bulk_Edit {

	/**
     * Plugin version
     * @var string
     */
    static public $version = "1.0.0";

	/**
     * Singleton object holder
     * @var mixed
     */
    static private $instance = NULL;

    public function __construct() {
    	
	}

	/**
	* Creates an Instance of this Class
	*
	* @access public
	* @since 1.0.0
	* @return Woocommerce_Variations_With_Radio_Buttons
	*/
	public static function get_instance() {

		if ( NULL === self::$instance )
			self::$instance = new self;

		return self::$instance;
	}

} // end class

if ( class_exists( "Woocoomerce_Product_Bulk_Edit" ) ) {

	add_action( "plugins_loaded", array( "Woocoomerce_Product_Bulk_Edit", "get_instance" ) );

}