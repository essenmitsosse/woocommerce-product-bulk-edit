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

	public static $calc_rules;

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

	public function __construct() {
		add_action( 'admin_menu', array( "Woocoomerce_Product_Bulk_Edit", 'bulk_edit_menu' ) );

	}

	public static function bulk_edit_menu() {
		add_submenu_page( 'woocommerce', 'Bulk Edit', 'Bulk Edit Products', 'manage_options', 'product_bluk_edit', array( "Woocoomerce_Product_Bulk_Edit", 'bulk_edit_options' ) ); 
	}

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

			require_once( "products/" . $_REQUEST[ "name" ] .  ".php" );
			global $calc_rules;

			self::$calc_rules = $calc_rules;

			if ( self::$calc_rules[ "id"] == $id ) {
				$product = get_product( $id );



				if ( $product->product_type == 'variable') {
					self::getProduct( $product );
				} else {
					echo "product is not a variable product";
				}	
			} else {
				echo "wrong product id. given: " . $id . ". should be: " . self::$calc_rules[ "id" ];
			}
					
		} else {
			echo "no ID specified";
		}
	}

	public static function get_available_variations ( $product ) {
		$available_variations = array();

		$args = array(
			'post_parent' => $product->id,
			'post_type'   => 'product_variation',
			'orderby'     => 'menu_order',
			'order'       => 'ASC',
			'fields'      => 'ids',
			'post_status' => array( 'private', 'publish' ),
			'numberposts' => -1
		);

		$posts = get_posts( $args );

		foreach ( $posts as $child_id ) {
			$variation = $product->get_child( $child_id );
			$available_variations[] = $product->get_available_variation( $variation );
		}

		return $available_variations;
	}

	public static function getProduct ( $product ) {
		$variations = self::get_available_variations( $product );
		$attributes = self::findAttributes( $variations[ 0 ] );

		usort( $variations, array( 'Woocoomerce_Product_Bulk_Edit', 'sortVariations' ) );	

		echo "<form action=\"" . $_SERVER['PHP_SELF'] . "?page=product_bluk_edit" . "\" method=\"post\">";
		echo "<h1>" . $product->post->post_title . "</h1>";
		echo "<table>";
		
		self::getTableHead();

		self::loopVariations( $variations );

		echo "</table>";
		echo "<input type=\"submit\" value=\"Submit\">";
		echo "<input type=\"hidden\" name=\"id\" value=\"" . $product->id . "\">";
		echo "<input type=\"hidden\" name=\"name\" value=\"" . $_REQUEST[ "name" ] . "\">";
		echo "<input type=\"hidden\" name=\"update\" value=\"TRUE\">";
		echo "</form>";
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

	public static function findAttributes ( $variation ) {
		foreach ( $variation[ "attributes" ] as $key => $value ) {
			self::$attributes[ $key ] = str_replace( "attribute_pa_", "", $key );
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

		// new Values
		echo "<th>NEW active</th>";
		foreach ( self::$calc_rules[ "values_to_change" ] as $key => $value ) {
			echo "<th>NEW " . $key . "</th>";
			// echo "<th>" . "new Price-Calculation" . "</th>";
		}
		echo "<th>NEW thumb url</th>";
		echo "<th>NEW thumb id</th>";
		echo "</tr>";
	}

	public static function loopVariations ( $variations ) {
		
		foreach ( $variations as $variation ) {
			echo "<tr>";
			self::getAttributes( $variation[ "attributes" ] );
			foreach ( self::$tableCols as $key => $value ) {
				self::getValue( $variation, $key, $value );
			}

			$is_possible = self::check_possibility( $variation );
			foreach ( self::$calc_rules[ "values_to_change" ] as $key => $value ) {
				self::newValue( $variation, $key, $value );
			}
			self::newThumb( $variation );
			echo "</tr>";
			// print_r($value);
		}
	}

	public static function check_possibility ( $variation ) {
		$attributes = $variation[ "attributes" ];
		$is_possible = true;

		if( array_key_exists( "rule_out", self::$calc_rules ) ) :
			foreach ( self::$calc_rules[ "rule_out" ] as $rule ) :
				$match = true;
				foreach ( $rule as $key => $value ) :
					if ( $attributes[ "attribute_pa_" . $key ] !== $value ) :
						$match = false;
					endif;
				endforeach;
				if( $match ) :
					$is_possible = false;
				endif; 
			endforeach;
		endif;

		if( array_key_exists( "rule_in", self::$calc_rules ) ) :
			foreach ( self::$calc_rules[ "rule_in" ] as $rule ) :
				if ( $is_possible ) :
					if ( $attributes[ "attribute_pa_" . $rule[ "attribute" ] ] === $rule[ "value" ] ) :
						$is_possible = false;
						foreach ( $rule[ "only_values" ] as $value ) :
							if ( $attributes[ "attribute_pa_" . $rule[ "only_attribute" ] ] === $value ) :
								$is_possible = true;
							endif;
						endforeach;
					endif;
				endif;
			endforeach;
		endif;

		self::addCell( $is_possible ? "yes" : "no" );

		$post_id = $variation[ "variation_id" ];
		if( self::$update && $post_id > 0 ) {
			echo $post_id . " = " . ( $is_possible ? "publish" : "private" ) . "<br>";
			wp_update_post( array( "ID" => $post_id, "post_status" => $is_possible ? "publish" : "private" ) );
		}
	}

	public static function newThumb ( $variation ) {
		$urlBase = "http://betoniu.dev/wp-content/uploads/";
		$urlVariationValues = array();
		$urlEnding = ".jpg";

		if( 
			array_key_exists( "base", self::$calc_rules ) &&
			array_key_exists( "img", self::$calc_rules[ "base"] ) 
		) {
			$urlVariationValues[] = self::$calc_rules[ "base"][ "img" ];
		}

		$attributes = $variation[ "attributes" ];
		$id = $variation[ "variation_id" ];

		$calc_rules = self::$calc_rules;

		foreach ( self::$calc_rules[ "image_name_parts" ] as $imgValue ) {
			$img_attr_name = "attribute_pa_".$imgValue;
			if ( array_key_exists( $img_attr_name, $attributes ) ) {
				$currentValue = $attributes[ $img_attr_name ];

				if ( 
					array_key_exists( $imgValue, $calc_rules ) &&
					array_key_exists( $currentValue, $calc_rules[ $imgValue ] ) &&
					array_key_exists( "img", $calc_rules[ $imgValue ][ $currentValue ] )
				) {
					$urlVariationValues[] = $calc_rules[ $imgValue ][ $currentValue ][ "img" ];
				}
				
			}
		}
		

		$url = implode( "-", $urlVariationValues ) . $urlEnding;
		$img_id = self::getImageIdFromUrl( $urlBase . $url );

		self::addCell( $url );
		self::addCell( $img_id );

		self::add_values_to_the_database( $variation,$img_id, "_thumbnail_id" );
	}

	public static function newValue ( $variation, $what, $database_names ) {
		$calc_rules = self::$calc_rules;
		$attributes = self::$attributes;
		$valueParts = array();

		if ( 
			array_key_exists( "base", $calc_rules ) &&
			array_key_exists( $what, $calc_rules[ "base" ] )
		) {
			$base = $calc_rules[ "base" ][ $what ];
		} else {
			$base = 0;
		}
		

		$valueParts[] = $base;

		foreach ( $variation[ "attributes" ] as $key => $value ) {
			$shortAttributeName = $attributes[ $key ];
			if ( 
				array_key_exists( $shortAttributeName, $calc_rules ) && 
				array_key_exists( $value, $calc_rules[ $shortAttributeName ] ) && 
				array_key_exists( $what, $calc_rules[ $shortAttributeName ][ $value ] ) 
			) {
				$valueParts[] = $calc_rules[ $shortAttributeName ][ $value ][ $what ];
			} else {
				$valueParts[] = "x";
			}
		}

		$newValue = array_sum( $valueParts );
		self::addCell( $newValue );
		if( self::$show_calculations ) {
			self::addCell( implode( " + ", $valueParts ) );
		}

		self::add_values_to_the_database( $variation, $newValue, $database_names );
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
		$style = "";
		if ( $value === 0 || $value === "0" ) {
			$style = " style=\"color:#f00;font-weight:bold;\" ";
		}
		echo "<td" . $style . ">" . $value . "</td>";
	}

	public static function add_values_to_the_database ( $variation, $newValue, $database_names ) {
		$id = $variation[ "variation_id" ];
		if( self::$update && $id > 0 ) :
			if ( $newValue > 0 ) :
				if ( is_array( $database_names ) ) :
					foreach( $database_names as $database_name ) :
						self::add_single_value_to_the_database( $id, $newValue, $database_name );
					endforeach;
				else :
					self::add_single_value_to_the_database( $id, $newValue, $database_names );
				endif;
				
			else :
				if ( is_array( $database_names ) ) :
					echo "<strong stlye=\"color:#f00;\">something wrong with " . implode( ", ", $database_names ) . " of ID: " . $id . "</strong></br>";
				else :
					echo "<strong stlye=\"color:#f00;\">something wrong with " . $database_names . " of ID: " . $id . "</strong></br>";
				endif;
			endif;
		endif;
	}

	public static function add_single_value_to_the_database ( $id, $newValue, $database_name ) {
		// echo $id . ": " . $database_name . " = " . $newValue . "</br>";
		update_post_meta( $id, $database_name, $newValue );
	}

	public static function getImageIdFromUrl ( $image_url ) {
		global $wpdb;
		$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
		if( array_key_exists( 0 , $attachment ) ) {
			return $attachment[0];
		} else {
			return 0;
		}
		 
	}

} // end class

if ( class_exists( "Woocoomerce_Product_Bulk_Edit" ) ) {

	add_action( "plugins_loaded", array( "Woocoomerce_Product_Bulk_Edit", "get_instance" ) );

}