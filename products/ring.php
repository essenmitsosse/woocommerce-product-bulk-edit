<?php 

global $calc_rules;

$calc_rules = array(
	"farbe" => array(
		"weiss" => array( 
			"img"    => "weiss"
		),
		"hellgrau" => array( 
			"img"    => "grau"
		),
		"anthrazit" => array(
			"img"    => "anthrazit"
		)
		),
	"form" => array(
		"simplest-ring" => array(
			"weight" => 0.02,
			"price"  => 80,
			"img"    => "simple"
		),
		"town-house-ring" => array(
			"weight" => 0.03,
			"price"  => 90,
			"img"    => "town-house"
		),
		"pyramid-ring" => array(
			"weight" => 0.03,
			"price"  => 100,
			"img"    => "pyramid"
		)
	),
	"base" => array(
		"img"    => "ring"
	),
	"id" => 1085,
	"image_name_parts" => array( "form", "farbe" ),
	"values_to_change" => array(
		"price" => array( "_regular_price", "_price" ),
		"weight" => array( "_weight" ),
		"width" => array( "_width" ),
		"height" => array( "_height" ),
		"length" => array( "_length" )
	)
);