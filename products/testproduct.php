<?php

global $calc_rules;

$calc_rules = array(
	"farbe" => array(
		"dunkelgrau" => array(
			"price"  => 9,
			"img"    => "dunkelgrau"
		),
		"hellgrau" => array(
			"price"  => 0,
			"img"    => "hellgrau"
		),
		"weiss" => array(
			"price"  => 1,
			"img"    => "weiss"
		)
		),
	"groesse" => array(
		"13cm" => array(
			"width"  => 12,
			"img"    => "12"
		),
		"17cm" => array(
			"width"  => 12,
			"img"    => "12"
		),
		"21cm" => array(
			"weight" => 100,
			"price"  => 100,
			"width"  => 43,
			"img"    => "43"
		)
	),
	"base" => array(
		"price"  => 1000,
		"weight" => 2.5,
		"width"  => 0,
		"height" => 10,
		"length" => 10,
		"img"    => "schale"
	),
	"rule_out" => array(
		array(
			"farbe"   => "weiss",
			"groesse" => "21cm"
		)
	),
	"rule_in" => array(
		array(
			"attribute"       => "farbe",
			"value"           => "dunkelgrau",
			"only_attribute"  => "groesse",
			"only_values"     => array( "13cm", "17cm" )
		),
	),
	"id" => 26,
	"image_name_parts" => array( "groesse", "farbe" ),
	"values_to_change" => array(

		"price" => array( "_regular_price", "_price" ),
		"weight" => array( "_weight" ),
		"width" => array( "_width" ),
		"height" => array( "_height" ),
		"length" => array( "_length" )
	)
);
