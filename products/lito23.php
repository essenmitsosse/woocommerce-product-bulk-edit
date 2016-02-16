<?php 

global $calc_rules;

$calc_rules = array(
	"gestell" => array(
		"blutorange" => array( 
			"img"    => "blutorange"
		),
		"blau" => array( 
			"img"    => "blau"
		),
		"schwarz" => array(
			"img"    => "schwarz"
		),
		"metall" => array(
			"img"    => "metall"
		)
	),
	"form" => array(
		"lito-2" => array(
			"weight" => 18,
			"height" => 36,
			"price"  => 398,
			"img"    => "2"
		),
		"lito-3" => array(
			"weight" => 11,
			"height" => 35,
			"price"  => 398,
			"img"    => "3"
		),
		"2er-set" => array(
			"weight" => 11,
			"height" => 35,
			"price"  => 690,
			"img"    => "3"
		),
		"4er-set" => array(
			"weight" => 18,
			"height" => 36,
			"price"  => 1298,
			"img"    => "2"
		)
	),
	"base" => array(
		"img"    => "lito",
	),
	"id" => 1051,
	"image_name_parts" => array( "form", "gestell" ),
	"values_to_change" => array(
		"price" => array( "_regular_price", "_price" ),
		"weight" => array( "_weight" ),
		"width" => array( "_width" ),
		"height" => array( "_height" ),
		"length" => array( "_length" )
	)
);