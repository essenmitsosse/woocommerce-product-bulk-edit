<?php

global $calc_rules;

$whitedarkprice = array(
	"_base" => 0,
	'plattengroesse' => array(
		'160x80cm' => 84.8,
		'180x90cm' => 107.8,
		'200x100cm' => 129.8,
	)
);

$calc_rules = array(
	'farbe' => array(
		'hellgrau' => array(
			'img'    => 'hellgrau',
		),
		'dunkelgrau' => array(
			'img'    => 'dunkelgrau',
			'price'  => $whitedarkprice,
		),
		'weiss' => array(
			'img'    => 'weiss',
			'price'  => $whitedarkprice,
		),
	),
	'gestell' => array(
		'blau'         => array(
			'height'   => 72,
			'weight'   => 7,
			'price'    => 270,
			'img'      => 'blau',
		),
		'weiss'         => array(
			'height'   => 72,
			'weight'   => 7,
			'price'    => 270,
			'img'      => 'weiss',
		),
		'schwarz'         => array(
			'height'   => 72,
			'weight'   => 7,
			'price'    => 270,
			'img'      => 'schwarz',
		),
		'blutorange'         => array(
			'height'   => 72,
			'weight'   => 7,
			'price'    => 270,
			'img'      => 'blutorange',
		),
		'chrom'         => array(
			'height'   => 72,
			'weight'   => 7,
			'price'    => 300,
			'img'      => 'metall',
		),
	),
	'plattengroesse' => array(
		'160x80cm' => array(
			'weight' => 110,
			'width'  => 80,
			'length' => 160,
			'height' => 4,
			'price'  => 848,
			'img'    => '160',
		),
		'180x90cm' => array(
			'weight' => 135,
			'width'  => 90,
			'length' => 180,
			'height' => 4,
			'price'  => 1078,
			'img'    => '180',
		),
		'200x100cm' => array(
			'weight' => 170,
			'width'  => 100,
			'length' => 200,
			'height' => 4,
			'price'  => 1298,
			'img'    => '200',
		),
	),
	'base' => array(
		'img'    => 'tisch',
	),
	'id' => 22478,
	'image_name_parts' => array( 'gestell', 'farbe' ),
	'values_to_change' => array(
		'price' => array( '_regular_price', '_price' ),
		'weight' => array( '_weight' ),
		'width' => array( '_width' ),
		'height' => array( '_height' ),
		'length' => array( '_length' ),
	)
);
