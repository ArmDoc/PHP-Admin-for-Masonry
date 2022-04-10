<?php

global $mysqli;

$database = [
	'host'		=> 'localhost',
	'username'	=> 'root',
	'password'	=> 'root',
	'database'	=> 'masonry',
];

$mysqli = new mysqli(
	$database['host'],
	$database['username'],
	$database['password'],
	$database['database'],
);