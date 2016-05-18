<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/bei/erapproval.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/englishdecimalformat.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/encoder/erentry.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
	"default" => "erapproval.tpl.php"
	,"add" => "erapproval_form.tpl.php"
	,"edit" => "erapproval_form.tpl.php"
	,"confirmation" => "../encoder/erentry_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'BEI APPROVAL ' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;
$cmapKey = isset($_GET['confirmation'])?"confirmation":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','ER Approval');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/bei";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsERApproval = new clsERApproval($dbconn);
$objClsEREntry = new clsEREntry($dbconn);
$edfOBJ = new EnglishDecimalFormat();

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['ER Approval'] = 'bei.php?statpos=erapproval';
		$arrbreadCrumbs['Add New'] = "";
		if (count($_POST)>0) {
			// save add new
			if(!$objClsERApproval->doValidateData($_POST)){
				$objClsERApproval->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsERApproval->Data);
//				printa($objClsERApproval->Data);
			}else {
				$objClsERApproval->doPopulateData($_POST);
				$objClsERApproval->doSaveAdd();
				header("Location: bei.php?statpos=erapproval");
				exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['ER Approval'] = 'bei.php?statpos=erapproval';
		$arrbreadCrumbs['Edit'] = "";
		if (count($_POST)>0) {
			// update
			if(!$objClsERApproval->doValidateData($_POST)){
				$objClsERApproval->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsERApproval->Data);
//				printa($objClsERApproval->Data);
			}else {
				$objClsERApproval->doPopulateData($_POST);
				$objClsERApproval->doSaveEdit();
				header("Location: bei.php?statpos=erapproval");
				exit;
			}
		}else{
			$oData = $objClsERApproval->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
	case 'confirmation':
		$mainBlock->templateFile = "index_blank.tpl.php";
		
	
	
		$oData = $objClsEREntry->dbFetch($_GET['confirmation']);
		$centerPanelBlock->assign("arrListOfPrecincts",$objClsEREntry->getPrecincts($_SESSION['admin_session_obj']['user_data']['pollingplaces_id']));
		$centerPanelBlock->assign("arrListOfCandidates",$objClsEREntry->getListOfCandidates());
		$centerPanelBlock->assign("edfOBJ",$edfOBJ);
		$centerPanelBlock->assign("oData",$oData);
		break;
	case "delete":
		$objClsERApproval->doDelete($_GET['delete']);
		header("Location: bei.php?statpos=erapproval");
		exit;		
		break;

	default:
		$arrbreadCrumbs['ER Approval'] = "";
		$centerPanelBlock->assign('tblDataList',$objClsERApproval->getTableList());
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