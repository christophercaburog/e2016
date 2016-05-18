<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'{*classpath_filename*}');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"default" => "{*template_filename*}"
,"add" => "{*templateform_filename*}"
,"edit" => "{*templateform_filename*}"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Change This!!!' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','{*PageTitle*}');
$mainBlock->templateDir .= "{*mainblockpath*}";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "{*centerpanelblockpath*}";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

${*omodule_name*} = new {*classname*}($dbconn);

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['{*mnu_parent*}'] = '{*mnu_link*}';
		$arrbreadCrumbs['Add New'] = "";
		if (count($_POST)>0) {
			// save add new
			if(!${*omodule_name*}->doValidateData($_POST)){
				${*omodule_name*}->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",${*omodule_name*}->Data);
//				printa(${*omodule_name*}->Data);
			}else {
				${*omodule_name*}->doPopulateData($_POST);
				${*omodule_name*}->doSaveAdd();
				header("Location: {*mnu_link*}");
				exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['{*mnu_parent*}'] = '{*mnu_link*}';
		$arrbreadCrumbs['Edit'] = "";
		if (count($_POST)>0) {
			// update
			if(!${*omodule_name*}->doValidateData($_POST)){
				${*omodule_name*}->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",${*omodule_name*}->Data);
//				printa(${*omodule_name*}->Data);
			}else {
				${*omodule_name*}->doPopulateData($_POST);
				${*omodule_name*}->doSaveEdit();
				header("Location: {*mnu_link*}");
				exit;
			}
		}else{
			$oData = ${*omodule_name*}->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
		
	case "delete":
		${*omodule_name*}->doDelete($_GET['delete']);
		header("Location: {*mnu_link*}");
		exit;		
		break;

	default:
		$arrbreadCrumbs['{*mnu_name*}'] = "";
		$centerPanelBlock->assign('tblDataList',${*omodule_name*}->getTableList());
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