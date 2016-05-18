<?php
//include("configurations/config.php");
include("../configurations/adminconfig.php");
include_once(SYSCONFIG_CLASS_PATH."admin/application.class.php");

Application::app_initialize(array('login_required'=>true));

// Controller Map
$cMap = array(
 "popup_region" => "popup_region.controller.php"
,"popup_municipal" => "popup_municipal.controller.php"
,"popup_pollingplaces" => "popup_pollingplaces.controller.php"

,"popup_prov" => "popup_prov.controller.php"
,"popup_barangay" => "popup_barangay.controller.php"

,"popup_precint" => "popup_precint.controller.php"
,"popup_barangay" => "popup_barangay.controller.php"

);

$cmapKey = isset($_GET['statpos'])?$_GET['statpos']:'default';

if(isset($_GET['statpos']) && !empty($_GET['statpos']) && array_key_exists($_GET['statpos'],$cMap)){
	include(SYSCONFIG_MODULE_PATH."admin/popup/".$cMap[$cmapKey]);
}else {
	$indexErrMsg = 'Controller for "'.$_SERVER['PHP_SELF'].((isset($_GET['statpos']))?"?statpos=".$_GET['statpos']:"")."\" - does not exist.";
	$indexErrMsg .= "<br> Please check the <b>\$cMap</b> on <b>$cMap[default]</b>";
	include(SYSCONFIG_MODULE_PATH."admin/admin.php");
}


?>