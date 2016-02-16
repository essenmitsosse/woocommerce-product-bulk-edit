<?php 

global $calc_rules;

$calc_rules = array(
	"glasfarbe" => array(
		"klar" => array( 
			"img"    => "klar"
		),
		"topas" => array( 
			"img"    => "topas"
		)
	),
	"form" => array(
		"929" => array(
			"weight" => 2.3,
			"width"  => 9,
			"length" => 9,
			"height" => 29,
			"price"  => 178,
			"img"    => "9-29"
		),
		"932" => array(
			"weight" => 2.9,
			"width"  => 9,
			"length" => 9,
			"height" => 32,
			"price"  => 188,
			"img"    => "9-32"
		),
		"936" => array(
			"weight" => 3.9,
			"width"  => 9,
			"length" => 9,
			"height" => 36,
			"price"  => 198,
			"img"    => "9-36"
		),
		"1723" => array(
			"weight" => 4.5,
			"width"  => 17,
			"length" => 17,
			"height" => 23,
			"price"  => 248,
			"img"    => "17-23"
		),
		"1730" => array(
			"weight" => 5.6,
			"width"  => 17,
			"length" => 17,
			"height" => 30,
			"price"  => 278,
			"img"    => "17-30"
		),
		"2526" => array(
			"weight" => 4.8,
			"width"  => 25,
			"length" => 25,
			"height" => 26,
			"price"  => 348,
			"img"    => "25-26"
		)
	),
	"base" => array(
		"img"    => "tara",
	),
	"id" => 1082,
	"image_name_parts" => array( "form", "glasfarbe" ),
	"values_to_change" => array(
		"price" => array( "_regular_price", "_price" ),
		"weight" => array( "_weight" ),
		"width" => array( "_width" ),
		"height" => array( "_height" ),
		"length" => array( "_length" )
	)
);