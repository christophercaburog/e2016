<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/classes/setup/barangay.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"default" => "popup_barangay.tpl.php"
,"add" => "popup_barangay_form.tpl.php"
,"edit" => "popup_barangay_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Change This!!!' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Popup Barangay');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/popup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsBarangay = new clsBarangay($dbconn);

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['Popup Barangay'] = 'popup.php?statpos=popup_barangay';
		$arrbreadCrumbs['Add New'] = "";
		if (count($_POST)>0) {
			// save add new
			if(!$objClsBarangay->doValidateData($_POST)){
				$objClsBarangay->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsBarangay->Data);
//				printa($objClsBarangay->Data);
			}else {
				$objClsBarangay->doPopulateData($_POST);
				$objClsBarangay->doSaveAdd();
				header("Location: popup.php?statpos=popup_barangay");
				exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['Popup Barangay'] = 'popup.php?statpos=popup_barangay';
		$arrbreadCrumbs['Edit'] = "";
		if (count($_POST)>0) {
			// update
			if(!$objClsBarangay->doValidateData($_POST)){
				$objClsBarangay->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsBarangay->Data);
//				printa($objClsBarangay->Data);
			}else {
				$objClsBarangay->doPopulateData($_POST);
				$objClsBarangay->doSaveEdit();
				header("Location: popup.php?statpos=popup_barangay");
				exit;
			}
		}else{
			$oData = $objClsBarangay->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
		
	case "delete":
		$objClsBarangay->doDelete($_GET['delete']);
		header("Location: popup.php?statpos=popup_barangay");
		exit;		
		break;

	default:
		$arrbreadCrumbs['Popup Barangay'] = "";
		$centerPanelBlock->assign('tblDataList',$objClsBarangay->getTableList());
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