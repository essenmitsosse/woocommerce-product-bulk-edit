<?php 

global $calc_rules;

$calc_rules = array(
	"farbe" => array(
		"weiss" => array( 
			"img"    => "weiss"
		),
		"hellgrau" => array( 
			"img"    => "hellgrau"
		),
		"dunkelgrau" => array(
			"img"    => "dunkelgrau"
		),
		"terrakotta" => array(
			"img"    => "terrakotta"
		)
	),
	"kabelfarbe" => array(
		"weiss" => array( 
			"img"    => "weiss"
		),
		"rot" => array( 
			"img"    => "rot"
		)
	),
	"form" => array(
		"small" => array(
			"weight" => 2,
			"width"  => 13,
			"length" => 13,
			"height" => 13,
			"price"  => 374,
			"img"    => "small"
		),
		"medium" => array(
			"weight" => 2.5,
			"width"  => 17,
			"length" => 17,
			"height" => 15,
			"price"  => 412,
			"img"    => "medium"
		),
		"large" => array(
			"weight" => 7.5,
			"width"  => 29,
			"length" => 29,
			"height" => 23,
			"price"  => 468,
			"img"    => "large"
		),
		"tall" => array(
			"weight" => 4,
			"width"  => 16,
			"length" => 16,
			"height" => 29,
			"price"  => 468,
			"img"    => "tall"
		)
	),
	"base" => array(
		"img"    => "heavy-light"
	),
	"id" => 1048,
	"image_name_parts" => array( "form", "farbe", "kabelfarbe" ),
	"values_to_change" => array(
		"price" => array( "_regular_price", "_price" ),
		"weight" => array( "_weight" ),
		"width" => array( "_width" ),
		"height" => array( "_height" ),
		"length" => array( "_length" )
	)
);