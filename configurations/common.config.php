<?php
// Error display
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', false);

/**
 * define the dbconnectivity
 */
  define('SYSCONFIG_ISLOCALCONN',true);
  	
/**
 * @var array Database credentials. Use user/pass/tnsname
 */

if(SYSCONFIG_ISLOCALCONN){
/*
	define('SYSCONFIG_DBUSER', 'namfrel');
	define('SYSCONFIG_DBPASS', 'n@mfrel591$');
	define('SYSCONFIG_DBNAME', 'namfrel2010_db');
	define('SYSCONFIG_DBHOST', 'localhost');
*/
        define('SYSCONFIG_DBUSER', 'root');
        define('SYSCONFIG_DBPASS', 'r00tb33r');
        define('SYSCONFIG_DBNAME', 'election2k16_db');
        define('SYSCONFIG_DBHOST', 'localhost');


/*
	define('SYSCONFIG_DBUSER', 'xinapse_namfrel');
	define('SYSCONFIG_DBPASS', 'letmein591$');
	define('SYSCONFIG_DBNAME', 'xinapse_namfrel10');
	define('SYSCONFIG_DBHOST', 'localhost');
*/
}else{
	define('SYSCONFIG_DBUSER', 'root');
	define('SYSCONFIG_DBPASS', 'bilCub.ot2');
	define('SYSCONFIG_DBNAME', 'comelec_db');
	define('SYSCONFIG_DBHOST', '192.168.0.100');
}

/**
 * Define the Project Title
 */
define('SYSCONFIG_TITLE','2016 PARALLEL COUNT');
define('SYSCONFIG_COMPANY','');

/**
 * @var  string Default Theme
 */
define('SYSCONFIG_THEME', 'default');
//define('SYSCONFIG_THEME', 'oldtheme');


function printa($arr = array()){
	print "<pre>";
	print_r($arr);
	print "</pre>";
}


?>
