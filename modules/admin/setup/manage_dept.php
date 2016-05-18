<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
//require_once(SYSCONFIG_CLASS_PATH.'application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/setup/manage_dept.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"default" => "manage_dept.tpl.php",
"add" => "manage_dept_form.tpl.php",
"edit" => "manage_dept_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Setup' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Manage Department');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/setup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsManageDept = new clsManageDept($dbconn);

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['Manage Department'] = 'setup.php?statpos=managedept';
		$arrbreadCrumbs['Add New'] = "";
		if (count($_POST)>0) {
			// save add new
			if(!$objClsManageDept->doValidateData($_POST)){
				$objClsManageDept->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsManageDept->Data);
//				printa($objClsManageDept->Data);
			}else {
				$objClsManageDept->doPopulateData($_POST);
				$objClsManageDept->doSaveAdd();
				header("Location: setup.php?statpos=managedept");
				exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['Manage Department'] = 'setup.php?statpos=managedept';
		$arrbreadCrumbs['Edit'] = "";
		if (count($_POST)>0) {
			// update
			if(!$objClsManageDept->doValidateData($_POST)){
				$objClsManageDept->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsManageDept->Data);
//				printa($objClsManageDept->Data);
			}else {
				$objClsManageDept->doPopulateData($_POST);
				$objClsManageDept->doSaveEdit();
				header("Location: setup.php?statpos=managedept");
				exit;
			}
		}else{
			$oData = $objClsManageDept->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
		
	case "delete":
		$objClsManageDept->doDelete($_GET['delete']);
		header("Location: setup.php?statpos=managedept");
		exit;		
		break;

	default:
		$arrbreadCrumbs['Manage Department'] = "";
		$centerPanelBlock->assign('tblDataList',$objClsManageDept->getTableList());
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