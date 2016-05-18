<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/setup/manage_modules.class.php');

Application::app_initialize();

$dbconn = Application::db_open();
//$dbconn->debug = true;

$cmap = array(
"default" => "manage_modules.tpl.php",
"add" => "modules_form.tpl.php",
"edit" => "modules_form.tpl.php"
);

	
$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Setup' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Setup');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/setup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$oManageModules = new clsManageModules($dbconn);

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['Manage Modules'] = 'setup.php?statpos=managemodule';
		$arrbreadCrumbs['Add New Module'] = "";
		$centerPanelBlock->assign("lstStatus",$arrStatus);
		$centerPanelBlock->assign("lstParent",$oManageModules->getParents());
		$centerPanelBlock->assign('lstParents',clsManageModules::getModuleChildren($dbconn,clsManageModules::getModuleParent($dbconn),""));
		
		if (count($_POST)>0) {
			// save new user info
			if(!$oManageModules->doValidateData($_POST)){
				$oManageModules->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$oManageModules->Data);
				printa($oManageModules->Data);
			}else {
				$oManageModules->doPopulateData($_POST);
				$oManageModules->doSaveAdd();
//				$centerPanelBlock->assign("oData",$oManageModules->Data);
//				printa($oManageModules->Data);
			header("Location: setup.php?statpos=managemodule");
			exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['Manage Modules'] = 'setup.php?statpos=managemodule';
		$arrbreadCrumbs['Edit Module'] = "";
		$centerPanelBlock->assign("lstStatus",$arrStatus);
		$centerPanelBlock->assign("lstParent",$oManageModules->getParents());
		if (count($_POST)>0) {
			// update user info
			if(!$oManageModules->doValidateData($_POST)){
				$oManageModules->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$oManageModules->Data);
//				printa($oManageModules->Data);
			}else {
				$oManageModules->doPopulateData($_POST);
				$oManageModules->doSaveEdit();
				header("Location: setup.php?statpos=managemodule");
				exit;
			}
		}else{
			$oData = $oManageModules->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
//			$xxx = clsManageModules::getModuleParent($dbconn);
//			printa($xxx);
			$centerPanelBlock->assign('lstParents',clsManageModules::getModuleChildren($dbconn,clsManageModules::getModuleParent($dbconn),$oData['mnu_parent']));
//			printa($oData);
		}
		break;
	
	case "delete":
		$oManageModules->doDelete($_GET['delete']);
		header("Location: setup.php?statpos=managemodule");
		exit;		
		break;

	default:
		$arrbreadCrumbs['Manage Modules'] = ""; 
		$centerPanelBlock->assign('tblDataList',$oManageModules->getTableList());
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
