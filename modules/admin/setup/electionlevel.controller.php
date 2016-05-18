<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/setup/electionlevel.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"default" => "electionlevel.tpl.php"
,"add" => "electionlevel_form.tpl.php"
,"edit" => "electionlevel_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Change This!!!' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Election Level');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/setup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsElectionLevel = new clsElectionLevel($dbconn);

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['Election Level'] = 'setup.php?statpos=electionlevel';
		$arrbreadCrumbs['Add New'] = "";
		if (count($_POST)>0) {
			// save add new
			if(!$objClsElectionLevel->doValidateData($_POST)){
				$objClsElectionLevel->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsElectionLevel->Data);
//				printa($objClsElectionLevel->Data);
			}else {
				$objClsElectionLevel->doPopulateData($_POST);
				$objClsElectionLevel->doSaveAdd();
				header("Location: setup.php?statpos=electionlevel");
				exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['Election Level'] = 'setup.php?statpos=electionlevel';
		$arrbreadCrumbs['Edit'] = "";
		if (count($_POST)>0) {
			// update
			if(!$objClsElectionLevel->doValidateData($_POST)){
				$objClsElectionLevel->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsElectionLevel->Data);
//				printa($objClsElectionLevel->Data);
			}else {
				$objClsElectionLevel->doPopulateData($_POST);
				$objClsElectionLevel->doSaveEdit();
				header("Location: setup.php?statpos=electionlevel");
				exit;
			}
		}else{
			$oData = $objClsElectionLevel->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
		
	case "delete":
		$objClsElectionLevel->doDelete($_GET['delete']);
		header("Location: setup.php?statpos=electionlevel");
		exit;		
		break;

	default:
		$arrbreadCrumbs['Election Level'] = "";
		$centerPanelBlock->assign('tblDataList',$objClsElectionLevel->getTableList());
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