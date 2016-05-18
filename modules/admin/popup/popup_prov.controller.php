<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/setup/province.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"default" => "popup_region.tpl.php"
,"add" => "region_form.tpl.php"
,"edit" => "region_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Setup' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Manage Region');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/popup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsProvince = new clsProvince($dbconn);

switch ($cmapKey) {
	default:
		$mainBlock->templateFile = "index_blank.tpl.php";
		$centerPanelBlock->assign('tblDataList',$objClsProvince->getTableList_popup($_GET['var']));
		break;
}

if(isset($_SESSION['eMsg'])){
	$centerPanelBlock->assign('eMsg',$_SESSION['eMsg']);
	unset($_SESSION['eMsg']);
}

/*-!-!-!-!-!-!-!-!-*/

$mainBlock->assign('centerPanel',$centerPanelBlock);
$mainBlock->setBreadCrumbs($arrbreadCrumbs);
$mainBlock->assign('breadCrumbs',$mainBlock->breadCrumbs);
$mainBlock->displayBlock();


?>