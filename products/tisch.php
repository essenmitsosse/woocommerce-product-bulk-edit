<?php 

global $calc_rules;

$shipping = 148;

$calc_rules = array(
	"farbe" => array(		
		"hellgrau" => array( 
			"img"    => "hellgrau"
		),
		"dunkelgrau" => array( 
			"img"    => "dunkelgrau",
			"price"  => 98
		),
		"weiss" => array(
			"img"    => "weiss",
			"price"  => 98
		)
	),
	"versiegelung" => array(
		"lithofin" => array(
			"price"  => 48
		),
		"gewachst" => array(
			"price"  => 98 
		),
		"nanoclear" => array(
			"price"  => 98
		)
	),
	"gestell" => array(
		"kein-gestell" => array(
			"img"      => "platte"
		),
		"blau"         => array(
			"height"   => 72,
			"weight"   => 7,
			"price"    => 300,
			"img"      => "blau"
		),
		"weiss"         => array(
			"height"   => 72,
			"weight"   => 7,
			"price"    => 300,
			"img"      => "weiss"
		),
		"schwarz"         => array(
			"height"   => 72,
			"weight"   => 7,
			"price"    => 300,
			"img"      => "schwarz"
		),
		"blutorange"         => array(
			"height"   => 72,
			"weight"   => 7,
			"price"    => 300,
			"img"      => "blutorange"
		),
		"metall"         => array(
			"height"   => 72,
			"weight"   => 7,
			"price"    => 300,
			"img"      => "metall"
		)
	),
	"plattengroesse" => array(
		"100x100cm" => array(
			"weight" => 90,
			"width"  => 100,
			"length" => 100,
			"height" => 4,
			"price"  => 598 + $shipping,
			"img"    => "100"
		),
		"160x80cm" => array(
			"weight" => 110,
			"width"  => 80,
			"length" => 160,
			"height" => 4,
			"price"  => 698 + $shipping,
			"img"    => "160"
		),
		"180x90cm" => array(
			"weight" => 135,
			"width"  => 90,
			"length" => 180,
			"height" => 4,
			"price"  => 798 + $shipping,
			"img"    => "180"
		),
		"200x100cm" => array(
			"weight" => 170,
			"width"  => 100,
			"length" => 200,
			"height" => 4,
			"price"  => 989 + $shipping,
			"img"    => "200"
		),
		"240x100cm" => array(
			"weight" => 192,
			"width"  => 100,
			"length" => 240,
			"height" => 4,
			"price"  => 1298 + $shipping,
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
	"image_name_parts" => array( "gestell", "farbe" ),
	"values_to_change" => array(
		"price" => array( "_regular_price", "_price" ),
		"weight" => array( "_weight" ),
		"width" => array( "_width" ),
		"height" => array( "_height" ),
		"length" => array( "_length" )
	)
);