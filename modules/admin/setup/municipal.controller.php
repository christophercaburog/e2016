<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/setup/municipal.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"default" => "municipal.tpl.php"
,"add" => "municipal_form.tpl.php"
,"edit" => "municipal_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Setup' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Manage Municipal');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/setup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsMunicipal = new clsMunicipal($dbconn);

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['Manage Municipal'] = 'setup.php?statpos=municipal';
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
				header("Location: setup.php?statpos=municipal");
				exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['Manage Municipal'] = 'setup.php?statpos=municipal';
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
				header("Location: setup.php?statpos=municipal");
				exit;
			}
		}else{
			$oData = $objClsMunicipal->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
		
	case "delete":
		$objClsMunicipal->doDelete($_GET['delete']);
		header("Location: setup.php?statpos=municipal");
		exit;		
		break;

	default:
		$arrbreadCrumbs['Manage Municipal'] = "";
		$centerPanelBlock->assign('tblDataList',$objClsMunicipal->getTableList());
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