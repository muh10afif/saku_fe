<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'postgres',
	'password' => 'm0n0w4ll',
	// 'database' => 'lbs_upload',
	'database' => 'lbs_saku',
	// 'hostname' => '178.128.24.68',
	// 'username' => 'postgres',
	// 'password' => 's0lusid1g',
	// // 'database' => 'lbs_upload',
	// 'database' => 'saku',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'development'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
