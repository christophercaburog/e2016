<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/setup/precint.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"default" => "popup_precint.tpl.php"
,"add" => "popup_precint_form.tpl.php"
,"edit" => "popup_precint_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Popup' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Popup Precint');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/popup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsPrecinct = new clsPrecinct($dbconn);

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['Popup Precint'] = 'popup.php?statpos=popup_precint';
		$arrbreadCrumbs['Add New'] = "";
		if (count($_POST)>0) {
			// save add new
			if(!$objClsPrecinct->doValidateData($_POST)){
				$objClsPrecinct->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsPrecinct->Data);
//				printa($objClsPrecinct->Data);
			}else {
				$objClsPrecinct->doPopulateData($_POST);
				$objClsPrecinct->doSaveAdd();
				header("Location: popup.php?statpos=popup_precint");
				exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['Popup Precint'] = 'popup.php?statpos=popup_precint';
		$arrbreadCrumbs['Edit'] = "";
		if (count($_POST)>0) {
			// update
			if(!$objClsPrecinct->doValidateData($_POST)){
				$objClsPrecinct->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsPrecinct->Data);
//				printa($objClsPrecinct->Data);
			}else {
				$objClsPrecinct->doPopulateData($_POST);
				$objClsPrecinct->doSaveEdit();
				header("Location: popup.php?statpos=popup_precint");
				exit;
			}
		}else{
			$oData = $objClsPrecinct->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
		
	case "delete":
		$objClsPrecinct->doDelete($_GET['delete']);
		header("Location: popup.php?statpos=popup_precint");
		exit;		
		break;

	default:
		$arrbreadCrumbs['Popup Precint'] = "";
		$mainBlock->templateFile = "index_blank.tpl.php";
		$centerPanelBlock->assign('tblDataList',$objClsPrecinct->getTableList_popup());
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