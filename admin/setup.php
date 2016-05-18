<?php
//include("configurations/config.php");
include("../configurations/adminconfig.php");
include_once(SYSCONFIG_CLASS_PATH."admin/application.class.php");

Application::app_initialize(array('login_required'=>true));

// Controller Map
$cMap = array(
"default" => "setup.php"
,"manageuser" => "manage_user.php"
,"manageusertype" => "manage_usertype.php"
,"managemodule" => "manage_modules.php"
,"electionlevel" => "electionlevel.controller.php"
,"candidateposition" => "candidateposition.controller.php"
,"politicalcandidates" => "politicalcandidates.controller.php"
,"region" => "region.controller.php"
,"province" => "province.controller.php"
,"municipal" => "municipal.controller.php"
,"barangay" => "barangay.controller.php"
,"precinct" => "precinct.controller.php"
,"mpollingplace_precinctrelation" => "mpollingplace_precinctrelation.controller.php"
);

$cmapKey = isset($_GET['statpos'])?$_GET['statpos']:'default';

if(isset($_GET['statpos']) && !empty($_GET['statpos']) && array_key_exists($_GET['statpos'],$cMap)){
	include(SYSCONFIG_MODULE_PATH."admin/setup/".$cMap[$cmapKey]);
}else {
	$indexErrMsg = 'Controller for "'.$_SERVER['PHP_SELF'].((isset($_GET['statpos']))?"?statpos=".$_GET['statpos']:"")."\" - does not exist.";
	$indexErrMsg .= "<br> Please check the <b>\$cMap</b> on <b>$cMap[default]</b>";
	include(SYSCONFIG_MODULE_PATH."admin/admin.php");
}


?>