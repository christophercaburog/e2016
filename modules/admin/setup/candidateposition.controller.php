<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/setup/candidateposition.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"default" => "candidateposition.tpl.php"
,"add" => "candidateposition_form.tpl.php"
,"edit" => "candidateposition_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Setup' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Candidate Position');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/setup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsCandidatePosition = new clsCandidatePosition($dbconn);

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['Candidate Position'] = 'setup.php?statpos=candidateposition';
		$arrbreadCrumbs['Add New'] = "";
		$centerPanelBlock->assign("oRecElecLev",$objClsCandidatePosition->getRecElectionLevel());
		if (count($_POST)>0) {
			// save add new
			if(!$objClsCandidatePosition->doValidateData($_POST)){
				$objClsCandidatePosition->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsCandidatePosition->Data);
//				printa($objClsCandidatePosition->Data);
			}else {
				$objClsCandidatePosition->doPopulateData($_POST);
				$objClsCandidatePosition->doSaveAdd();
				header("Location: setup.php?statpos=candidateposition");
				exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['Candidate Position'] = 'setup.php?statpos=candidateposition';
		$arrbreadCrumbs['Edit'] = "";
		$centerPanelBlock->assign("oRecElecLev",$objClsCandidatePosition->getRecElectionLevel());
		if (count($_POST)>0) {
			// update
			if(!$objClsCandidatePosition->doValidateData($_POST)){
				$objClsCandidatePosition->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsCandidatePosition->Data);
//				printa($objClsCandidatePosition->Data);
			}else {
				$objClsCandidatePosition->doPopulateData($_POST);
				$objClsCandidatePosition->doSaveEdit();
				header("Location: setup.php?statpos=candidateposition");
				exit;
			}
		}else{
			$oData = $objClsCandidatePosition->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
		
	case "delete":
		$objClsCandidatePosition->doDelete($_GET['delete']);
		header("Location: setup.php?statpos=candidateposition");
		exit;		
		break;

	default:
		$arrbreadCrumbs['Candidate Position'] = "";
		$centerPanelBlock->assign('tblDataList',$objClsCandidatePosition->getTableList());
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