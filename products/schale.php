<?php 

global $calc_rules;

$calc_rules = array(
	"farbe" => array(
		"dunkelgrau" => array( 
			"img"    => "dunkelgrau"
		),
		"hellgrau" => array( 
			"img"    => "hellgrau"
		),
		"weiss" => array(
			"img"    => "weiss"
		)
		),
	"groesse" => array(
		"12cm" => array(
			"weight" => 0.26,
			"width"  => 12,
			"length" => 12,
			"height" => 5,
			"price"  => 29,
			"img"    => "12"
		),
		"14cm" => array(
			"weight" => 0.4,
			"width"  => 14,
			"length" => 14,
			"height" => 6,
			"price"  => 34,
			"img"    => "14"
		),
		"16cm" => array(
			"weight" => 0.67,
			"width"  => 16,
			"length" => 16,
			"height" => 7,
			"price"  => 38,
			"img"    => "16"
		),
		"18cm" => array(
			"weight" => 1,
			"width"  => 18,
			"length" => 18,
			"height" => 8.5,
			"price"  => 42,
			"img"    => "18"
		),
		"28cm" => array(
			"weight" => 4,
			"width"  => 28,
			"length" => 28,
			"height" => 13,
			"price"  => 148,
			"img"    => "28"
		),
		"34cm" => array(
			"weight" => 5.9,
			"width"  => 34,
			"length" => 34,
			"height" => 15,
			"price"  => 198,
			"img"    => "34"
		),
		"43cm" => array(
			"weight" => 9.5,
			"width"  => 43,
			"length" => 43,
			"height" => 19,
			"price"  => 298,
			"img"    => "43"
		),
		"3er-set" => array(
			"img"    => "set",
			"weight" => 1.5,
			"width"  => 12,
			"length" => 12,
			"price"  => 89,
			"height" => 5
		),
		"gewuerzschalen-set" => array(
			"img"    => "gewuerz",
			"weight" => 0.13,
			"width"  => 6.5,
			"length" => 6.5,
			"price"  => 49,
			"height" => 2.5
		),
	),
	"base" => array(
		"img"    => "schale"
	),
	"id" => 422,
	"image_name_parts" => array( "groesse", "farbe" ),
	"values_to_change" => array(
		"price" => array( "_regular_price", "_price" ),
		"weight" => array( "_weight" ),
		"width" => array( "_width" ),
		"height" => array( "_height" ),
		"length" => array( "_length" )
	)
);