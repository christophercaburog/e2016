<?php

/**
 * Filename: config.php
 * use this file to include on all php file
 * 
 * @author  Arnold Orbista
 */

/**
 * @var string Absolute path of the application root with trailing slash. eg. /home/htdocs/ or c:/htdocs/
 */
define('SYSCONFIG_ROOT_PATH', str_replace("\\","/",realpath(dirname(__FILE__).'/../').'/'));

/**
 * @var string Absolute path of the 'classes' directory with trailing slash.
 */
define('SYSCONFIG_CLASS_PATH', SYSCONFIG_ROOT_PATH.'classes/');

/**
 * @var string Absolute path of 3rdparty libraries. includes trailing slash
 */
define('SYSCONFIG_3RDPARTY_PATH', SYSCONFIG_ROOT_PATH.'configuration/');

/**
 * @var string Absolute path of the 'resources' directory with trailing slash.
 */
define('SYSCONFIG_RESOURCE_PATH', SYSCONFIG_ROOT_PATH.'resource/');

/**
 * @var string Absolute path of the 'modules' directory with trailing slash.
 */
define('SYSCONFIG_MODULE_PATH', SYSCONFIG_ROOT_PATH.'modules/');

/**
 * @var string Absolute path of the smarty libraries. includes trailing slash
 */
define('SMARTY_DIR', SYSCONFIG_3RDPARTY_PATH.'smarty/');

/**
 * @var string hostname of application, w/o proto scheme. eg. dswd.gov.ph
 */
define('SYSCONFIG_URL_HOST', $_SERVER['SERVER_ADDR']);

/**
 * @var string dir path of the application url with trailing slash. eg. /otsfs/
 */
define('SYSCONFIG_URL_PATH',str_replace('\\','/',dirname($_SERVER['PHP_SELF'])).((substr(dirname($_SERVER['PHP_SELF']),strlen(dirname($_SERVER['PHP_SELF']))-1,1)!='\\')?"/":""). "../");

/**
 * @var string Absolute URL path of the images directory with trailing slash.
 */
define('SYSCONFIG_IMAGE_PATH', SYSCONFIG_URL_PATH.'images/');

/**
 * @var string Absolute path of the 'modules' directory with trailing slash.
 */
define('SYSCONFIG_THEME_PATH', SYSCONFIG_ROOT_PATH.'themes/');
define('SYSCONFIG_THEME_URLPATH', SYSCONFIG_URL_PATH.'themes/');

/**
 * @var bool if the application will use SSL for secured pages
 */
define('SYSCONFIG_USE_SSL', false);

/**
 * @var string server's http port
 */
define('SYSCONFIG_PORT_HTTP', 80);

/**
 * @var string server's https (ssl) port
 */
define('SYSCONFIG_PORT_HTTPS', 443);

define('APPCONFIG_DEFAULT_THEME','default');

/**
 * @var int Timeout for idle application session (in seconds)
 */
/*define('APPCONFIG_IDLE_TIMEOUT', 60*60*3); // 3 hours
define('SYSCONFIG_MAX_IDLETIME', 60*30); // default of 30 minutes
*/
define('APPCONFIG_IDLE_TIMEOUT', 60*30); // 1 hour
define('SYSCONFIG_MAX_IDLETIME', 60*30); // default of 1 hr

/**
 * @var string Default date format
 */
define('APPCONFIG_FORMAT_DATE', 'Y-m-d');
define('APPCONFIG_FORMAT_TIME', 'g:i A'); // g:i A T

/**
 * @var string Default date-time format
 */
define('APPCONFIG_FORMAT_DATETIME', APPCONFIG_FORMAT_DATE.' '.APPCONFIG_FORMAT_TIME);
define('APPCONFIG_FORMAT_DATETIME_24H', APPCONFIG_FORMAT_DATE.' H:i:s');

/**
 * @var string default date time format for sql parameter input
 */
define('APPCONFIG_FORMAT_DATETIME_SQL', '%Y-%m-%d %H:%i:%s');

/**
 * @var Restrict User Multiple Login
 */
define('SYSCONFIG_USER_MULTILOGIN', TRUE);

include("common.config.php");

// locale settings
//date_default_timezone_set('Asia/Manila'); 
//setlocale(LC_ALL,'Asia/Manila'); 


//$ADODB_CACHE_DIR = SYSCONFIG_ROOT_PATH.SYSCONFIG_THEME_PATH.SYSCONFIG_THEME.'/compile';
ini_set('magic_quotes_gpc', false);


?>