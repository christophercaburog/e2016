<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/setup/municipal.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"default" => "popup_municipal.tpl.php"
,"add" => "popup_municipal_form.tpl.php"
,"edit" => "popup_municipal_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Popup' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Popup Municipal');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/popup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsMunicipal = new clsMunicipal($dbconn);

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['Popup Municipal'] = 'popup.php?statpos=popup_municipal';
		$arrbreadCrumbs['Add New'] = "";
		if (count($_POST)>0) {
			// save add new
			if(!$objClsMunicipal->doValidateData($_POST)){
				$objClsMunicipal->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsMunicipal->Data);
//				printa($objClsMunicipal->Data);
			}else {
				$objClsMunicipal->doPopulateData($_POST);
				$objClsMunicipal->doSaveAdd();
				header("Location: popup.php?statpos=popup_municipal");
				exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['Popup Municipal'] = 'popup.php?statpos=popup_municipal';
		$arrbreadCrumbs['Edit'] = "";
		if (count($_POST)>0) {
			// update
			if(!$objClsMunicipal->doValidateData($_POST)){
				$objClsMunicipal->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsMunicipal->Data);
//				printa($objClsMunicipal->Data);
			}else {
				$objClsMunicipal->doPopulateData($_POST);
				$objClsMunicipal->doSaveEdit();
				header("Location: popup.php?statpos=popup_municipal");
				exit;
			}
		}else{
			$oData = $objClsMunicipal->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
		
	case "delete":
		$objClsMunicipal->doDelete($_GET['delete']);
		header("Location: popup.php?statpos=popup_municipal");
		exit;		
		break;

	default:
		$arrbreadCrumbs['Popup Municipal'] = "";
		$mainBlock->templateFile = "index_blank.tpl.php";
		$centerPanelBlock->assign('tblDataList',$objClsMunicipal->getTableList_popup($_GET['var']));
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