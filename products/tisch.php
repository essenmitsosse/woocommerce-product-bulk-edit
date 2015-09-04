<?php 

global $calc_rules;

$calc_rules = array(
	"farbe" => array(		
		"hellgrau" => array( 
			"img"    => "hellgrau"
		),
		"dunkelgrau" => array( 
			"img"    => "dunkelgrau",
			"price"  => 100
		),
		"weiss" => array(
			"img"    => "weiss",
			"price"  => 100
		)
	),
	"versiegelung" => array(		
		"gewachst" => array(
			"price"  => 80 
		),
		"nanoclear" => array(
			"price"  => 80
		)
	),
	"gestell" => array(
		"kein-gestell" => array(),
		"blau"         => array(
			"height"   => 90,
			"weight"   => 7,
			"price"    => 200,
			"img"      => "blau"
		),
		"weiss"         => array(
			"height"   => 90,
			"weight"   => 7,
			"price"    => 200,
			"img"      => "weiss"
		),
		"schwarz"         => array(
			"height"   => 90,
			"weight"   => 7,
			"price"    => 200,
			"img"      => "schwarz"
		),
		"blutorange"         => array(
			"height"   => 90,
			"weight"   => 7,
			"price"    => 200,
			"img"      => "blutorange"
		),
		"metall"         => array(
			"height"   => 90,
			"weight"   => 7,
			"price"    => 200,
			"img"      => "metall"
		)
	),
	"plattengroesse" => array(
		"100x100cm" => array(
			"weight" => 90,
			"width"  => 100,
			"length" => 100,
			"height" => 4,
			"price"  => 598,
			"img"    => "100"
		),
		"160x80cm" => array(
			"weight" => 110,
			"width"  => 80,
			"length" => 160,
			"height" => 4,
			"price"  => 698,
			"img"    => "160"
		),
		"180x90cm" => array(
			"weight" => 135,
			"width"  => 90,
			"length" => 180,
			"height" => 4,
			"price"  => 798,
			"img"    => "180"
		),
		"200x100cm" => array(
			"weight" => 170,
			"width"  => 100,
			"length" => 200,
			"height" => 4,
			"price"  => 898,
			"img"    => "200"
		),
		"240x100cm" => array(
			"weight" => 192,
			"width"  => 100,
			"length" => 240,
			"height" => 4,
			"price"  => 1298,
			"img"    => "240"
		)
	),
	"base" => array(
		"img"    => "tisch"
	),
	// "rule_out" => array(
	// 	array(
	// 		"gestellgroesse"   => "240x100cm",
	// 		"gestell" => array( "schwarz", "blau", "weiss", "blutorange", "metall" )
	// 	)
	// ),
	"rule_in" => array(
		array(
			"attribute"       => "plattengroesse",
			"value"           => "240x100cm",
			"only_attribute"  => "gestell",
			"only_values"     => array( "kein-gestell" )
		),
	),
	"id" => 532,
	"image_name_parts" => array( "gestell", "farbe", "plattengroesse" ),
	"values_to_change" => array(
		"price" => array( "_regular_price", "_price" ),
		"weight" => array( "_weight" ),
		"width" => array( "_width" ),
		"height" => array( "_height" ),
		"length" => array( "_length" )
	)
);