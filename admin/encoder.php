<?php
//include("configurations/config.php");
include("../configurations/adminconfig.php");
include_once(SYSCONFIG_CLASS_PATH."admin/application.class.php");
include_once(SYSCONFIG_CLASS_PATH."util/Debug.class.php");

Application::app_initialize(array('login_required'=>true));

// Controller Map
$cMap = array(
"default" => "encoder.php"
,"erentry" => "erentry.controller.php"
,"erprint" => "erprint.controller.php"
,"bei-erapprovalentry" => "bei-erapprovalentry.controller.php"
);

$cmapKey = isset($_GET['statpos'])?$_GET['statpos']:'default';

if(isset($_GET['statpos']) && !empty($_GET['statpos']) && array_key_exists($_GET['statpos'],$cMap)){
	include(SYSCONFIG_MODULE_PATH."admin/encoder/".$cMap[$cmapKey]);
}else {
	$indexErrMsg = 'Controller for "'.$_SERVER['PHP_SELF'].((isset($_GET['statpos']))?"?statpos=".$_GET['statpos']:"")."\" - does not exist.";
	$indexErrMsg .= "<br> Please check the <b>\$cMap</b> on <b>$cMap[default]</b>";
	include(SYSCONFIG_MODULE_PATH."admin/admin.php");
}

Debug::Display();
?>