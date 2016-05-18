<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/encoder/erprint.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/bei/erapproval.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/englishdecimalformat.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/encoder/erentry.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"default" => "erprint.tpl.php"
,"add" => "erprint_form.tpl.php"
,"edit" => "erprint_form.tpl.php"
,"print" => "erprint_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Task' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;
$cmapKey = isset($_GET['print'])?"print":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','ER Printing');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/encoder";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsERPrint = new clsERPrint($dbconn);
$objClsERApproval = new clsERApproval($dbconn);
$objClsEREntry = new clsEREntry($dbconn);
$edfOBJ = new EnglishDecimalFormat();

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['ER Printing'] = 'encoder.php?statpos=erprint';
		$arrbreadCrumbs['Add New'] = "";
		if (count($_POST)>0) {
			// save add new
			if(!$objClsERPrint->doValidateData($_POST)){
				$objClsERPrint->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsERPrint->Data);
//				printa($objClsERPrint->Data);
			}else {
				$objClsERPrint->doPopulateData($_POST);
				$objClsERPrint->doSaveAdd();
				header("Location: encoder.php?statpos=erprint");
				exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['ER Printing'] = 'encoder.php?statpos=erprint';
		$arrbreadCrumbs['Edit'] = "";
		if (count($_POST)>0) {
			// update
			if(!$objClsERPrint->doValidateData($_POST)){
				$objClsERPrint->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsERPrint->Data);
//				printa($objClsERPrint->Data);
			}else {
				$objClsERPrint->doPopulateData($_POST);
				$objClsERPrint->doSaveEdit();
				header("Location: encoder.php?statpos=erprint");
				exit;
			}
		}else{
			$oData = $objClsERPrint->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
		
	case "delete":
		$objClsERPrint->doDelete($_GET['delete']);
		header("Location: encoder.php?statpos=erprint");
		exit;		
		break;
	case "print":
		$mainBlock->templateFile = "index_blank.tpl.php";
			
		$oData = $objClsEREntry->dbFetch($_GET['print']);
		$centerPanelBlock->assign("arrListOfPrecincts",$objClsEREntry->getPrecincts($_SESSION['admin_session_obj']['user_data']['pollingplaces_id']));
		$centerPanelBlock->assign("arrListOfCandidates",$objClsEREntry->getListOfCandidates());
		$centerPanelBlock->assign("edfOBJ",$edfOBJ);
		$centerPanelBlock->assign("oData",$oData);
		break;
	default:
		$arrbreadCrumbs['ER Printing'] = "";
		$centerPanelBlock->assign('tblDataList',$objClsERPrint->getTableList());
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