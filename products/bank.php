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
		"hocker" => array(
			"weight" => 28,
			"length"  => 40,
			"width" => 40,
			"height" => 45,
			"price"  => array(
				"_base" => 358,
				"farbe" => array( "hellgrau" => -30 )
			),
			"img"    => "hocker"
		),
		"110cm" => array(
			"weight" => 120,
			"length"  => 110,
			"width" => 40,
			"height" => 45,
			"price"  => array(
				"_base" => 698,
				"farbe" => array( "hellgrau" => -50 )
			),
			"img"    => "110"
		),
		"140cm" => array(
			"weight" => 150,
			"length"  => 140,
			"width" => 40,
			"height" => 45,
			"price"  => array(
				"_base" => 848,
				"farbe" => array( "hellgrau" => -50 )
			),
			"img"    => "140"
		),
		"170cm" => array(
			"weight" => 180,
			"length"  => 170,
			"width" => 40,
			"height" => 45,
			"price"  => array(
				"_base" => 998,
				"farbe" => array( "hellgrau" => -100 )
			),
			"img"    => "170"
		),
	),
	"base" => array(
		"img"    => "bank",
		"price"  => 50
	),
	"id" => 1055,
	"image_name_parts" => array( "groesse", "farbe" ),
	"values_to_change" => array(
		"price" => array( "_regular_price", "_price" ),
		"weight" => array( "_weight" ),
		"width" => array( "_width" ),
		"height" => array( "_height" ),
		"length" => array( "_length" )
	)
);