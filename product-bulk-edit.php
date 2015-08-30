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

	/**
     * Singleton object holder
     * @var mixed
     */
    static private $instance = NULL;

    public function __construct() {
		add_action( 'admin_menu', array( "Woocoomerce_Product_Bulk_Edit", 'bulk_edit_menu' ) );
		
	}

	public static function bulk_edit_menu() {
		add_submenu_page( 'woocommerce', 'Bulk Edit', 'Bulk Edit Products', 'manage_options', 'product_bluk_edit', array( "Woocoomerce_Product_Bulk_Edit", 'bulk_edit_options' ) ); 
	}

	public static $tableCols = array(
		"variation_id"          => array(
				"niceName"           => "ID"
			),
		"variation_is_active"   => array(
				"niceName"           => "is Active"
			),
		"display_price"         => array(
				"niceName"           => "Price",
				"input"              => "number"
			),
		"weight"                => array(
				"niceName"           => "Weight",
				"func"               => "get_weight"
			),
		"dimensions"            => array(
				"niceName"           => "Dimensions"
			)
	);

	public static $attributes = array();
	public static $update = false;
	public static $show_calculations = false;

	public static function printer ( $obj ) {
		echo "<pre>";
		print_r($obj);
		echo "</pre>";
	}

	public static function bulk_edit_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		if ( array_key_exists( "id", $_REQUEST ) ) {
			$id = $_REQUEST[ "id" ];
			if ( array_key_exists( "update", $_POST ) ) {
				self::$update = $_POST[ "update" ] === "TRUE";
				echo "has been updated!";
			}
			$product = get_product( $_REQUEST[ "id" ] );

			if ( $product->product_type == 'variable') {
				self::getProduct( $product );
			} else {
				echo "product is not a variable product";
			}			
		} else {
			echo "no ID specified";
		}
	}

	public static function getTableHead () {
		echo "<tr>";
		foreach ( self::$attributes as $key => $value ) {
			echo "<th>" . $value . "</th>";
		}
		foreach ( self::$tableCols as $key => $value ) {
			echo "<th>" . $value[ "niceName" ] . "</th>";
		}
		foreach ( self::$newValues as $key => $value ) {
			echo "<th>NEW " . $key . "</th>";
			// echo "<th>" . "new Price-Calculation" . "</th>";
		}
		echo "<th>thumb url</th>";
		echo "<th>thumb id</th>";
		echo "</tr>";
	}

	public static function sortVariations ( $a, $b ) {
		$A = $a['attributes'];
		$B = $b['attributes'];
		foreach ( self::$attributes as $key => $value ) {
			$compare = strcmp( $A[ $key ], $B[ $key ] );
			if ( $compare !== 0 ) {
				return $compare;
			}
		}

		return 0;
	}	

	public static function getProduct ( $product ) {
		$variations = $product->get_available_variations();
		$attributes = self::findAttributes( $variations[ 0 ] );

		usort( $variations, array( 'Woocoomerce_Product_Bulk_Edit', 'sortVariations' ) );

		echo "<form action=\"" . $_SERVER['PHP_SELF'] . "?page=product_bluk_edit" . "\" method=\"post\">";
		echo "<table>";
		
		self::getTableHead();

		self::loopVariations( $variations );

		echo "</table>";
		echo "<input type=\"submit\" value=\"Submit\">";
		echo "<input type=\"hidden\" name=\"id\" value=\"" . $product->id. "\">";
		echo "<input type=\"hidden\" name=\"update\" value=\"TRUE\">";
		echo "</form>";
	}

	public static function findAttributes ( $variation ) {
		foreach ( $variation[ "attributes" ] as $key => $value ) {
			self::$attributes[ $key ] = str_replace( "attribute_pa_", "", $key );
		}
	}

	public static function loopVariations ( $variations ) {
		
		foreach ( $variations as $variation ) {
			echo "<tr>";
			self::getAttributes( $variation[ "attributes" ] );
			foreach ( self::$tableCols as $key => $value ) {
				self::getValue( $variation, $key, $value );
			}
			foreach ( self::$newValues as $key => $value ) {
				self::newValue( $variation, $key, $value );
			}
			self::newThumb( $variation );
			echo "</tr>";
			// print_r($value);
		}
	}

	public static $imgValues = array( "farbe" );

	public static $newValues = array(
		"price" => array( "_regular_price", "_price" ),
		"weight" => array( "_weight" ),
		"width" => array( "_width" ),
		"height" => array( "_height" ),
		"length" => array( "_length" )
	);

	public static $valueCalc = array(
		"farbe" => array(
			"dunkelgrau" => array( 
				"price" => 9
			),
			"hellgrau" => array( 
				"price" => 0,
				"width" => 10
			),
			"weiss" => array( 
				"price" => 1,
				"weight" => 1000
			)
			),
		"groesse" => array(
			"13cm" => array(
				"weight" => 10
			),
			"17cm" => array(
				"weight" => 20,
				"width" => 5
			),
			"21cm" => array( 
				"weight" => 100,
				"price" => 100 
			)
		),
		"base" => array(
			"price" => 1000,
			"width" => 10,
			"height" => 10,
			"length" => 10
		)
	);

	public static function newThumb ( $variation ) {
		$urlBase = "http://betoniu.dev/wp-content/uploads/";
		$urlFileBase = "schale-43-";
		$urlVariationValues = array();
		$urlEnding = ".jpg";

		$attributes = $variation[ "attributes" ];
		$id = $variation[ "variation_id" ];

		foreach ( self::$imgValues as $imgValue ) {
			$img_attr_name = "attribute_pa_" . $imgValue;
			if ( array_key_exists( $img_attr_name, $attributes ) ) {
				$urlVariationValues[] = $attributes[ $img_attr_name ];
			}
		}
		

		$url = $urlFileBase . implode( "-", $urlVariationValues ) . $urlEnding;
		$img_id = self::getImageIdFromUrl( $urlBase . $url );

		self::addCell( $url );
		self::addCell( $img_id );

		if( self::$update && $id > 0 ) {
			if ( $img_id > 0 ) {
				update_post_meta( $id, "_thumbnail_id", $img_id );
		
			} else {
				"no image found with url " . $url;
			}
		}
	}

	public static function newValue ( $variation, $what, $database_names ) {
		$valueCalc = self::$valueCalc;
		$attributes = self::$attributes;
		$valueParts = array();

		if ( 
			array_key_exists( "base", $valueCalc ) &&
			array_key_exists( $what, $valueCalc[ "base" ] )
		) {
			$base = $valueCalc[ "base" ][ $what ];
		} else {
			$base = 0;
		}
		

		$valueParts[] = $base;

		foreach ( $variation[ "attributes" ] as $key => $value ) {
			$shortAttributeName = $attributes[ $key ];
			if ( 
				array_key_exists( $shortAttributeName, $valueCalc ) && 
				array_key_exists( $value, $valueCalc[ $shortAttributeName ] ) && 
				array_key_exists( $what, $valueCalc[ $shortAttributeName ][ $value ] ) 
			) {
				$valueParts[] = $valueCalc[ $shortAttributeName ][ $value ][ $what ];
			} else {
				$valueParts[] = "x";
			}
		}

		$newValue = array_sum( $valueParts );
		self::addCell( $newValue );
		if( self::$show_calculations ) {
			self::addCell( implode( " + ", $valueParts ) );
		}

		$id = $variation[ "variation_id" ];

		if( self::$update && $id > 0 ) {
			if ( $newValue > 0 ) {
				foreach( $database_names as $database_name ) {
					echo "<p>" . $id . ": " . $database_name . " = " . $newValue . "</p>";
					update_post_meta( $id, $database_name, $newValue );
				}
			} else {
				echo "<p>something wrong with " . $newValue . " of ID: " . $id . "</p>";
			}
		}
	}

	public static function getValue ( $variation, $name, $args ) {
		if ( array_key_exists( "func", $args ) ) {
			$vari = get_product( $variation[ "variation_id" ] );
			$value = $vari->$args[ "func" ]();
		} else {
			$value = $variation[ $name ];
		}

		self::addCell( $value );
		
	}

	public static function getAttributes ( $attr ) {
		foreach ( $attr as $key => $value ) {
			self::addCell( $value );
		}
	}

	public static function addCell ( $value ) {
		echo "<td>" . $value . "</td>";
	}

	public static function getImageIdFromUrl ( $image_url ) {
		global $wpdb;
		$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
		if( array_key_exists( 0 , $attachment ) ) {
			return $attachment[0];
		} else {
			return "&mdash;";
		}
		 
	}

} // end class

if ( class_exists( "Woocoomerce_Product_Bulk_Edit" ) ) {

	add_action( "plugins_loaded", array( "Woocoomerce_Product_Bulk_Edit", "get_instance" ) );

}