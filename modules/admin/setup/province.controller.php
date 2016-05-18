<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/setup/province.class.php');

Application::app_initialize();

$dbconn = Application::db_open();
//$dbconn->debug = true;
$cmap = array(
"default" => "province.tpl.php"
,"add" => "province_form.tpl.php"
,"edit" => "province_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Setup' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Manage Province');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/setup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsProvince = new clsProvince($dbconn);

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['Manage Province'] = 'setup.php?statpos=province';
		$arrbreadCrumbs['Add New'] = "";
		if (count($_POST)>0) {
			// save add new
			if(!$objClsProvince->doValidateData($_POST)){
				$objClsProvince->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsProvince->Data);
//				printa($objClsProvince->Data);
			}else {
				$objClsProvince->doPopulateData($_POST);
				$objClsProvince->doSaveAdd();
				header("Location: setup.php?statpos=province");
				exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['Manage Province'] = 'setup.php?statpos=province';
		$arrbreadCrumbs['Edit'] = "";
		if (count($_POST)>0) {
			// update
			if(!$objClsProvince->doValidateData($_POST)){
				$objClsProvince->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsProvince->Data);
//				printa($objClsProvince->Data);
			}else {
				$objClsProvince->doPopulateData($_POST);
				$objClsProvince->doSaveEdit();
				header("Location: setup.php?statpos=province");
				exit;
			}
		}else{
			$oData = $objClsProvince->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
		
	case "delete":
		$objClsProvince->doDelete($_GET['delete']);
		header("Location: setup.php?statpos=province");
		exit;		
		break;

	default:
		$arrbreadCrumbs['Manage Province'] = "";
		$centerPanelBlock->assign('tblDataList',$objClsProvince->getTableList());
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