<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/setup/politicalcandidates.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"default" => "politicalcandidates.tpl.php"
,"add" => "politicalcandidates_form.tpl.php"
,"edit" => "politicalcandidates_edit_form.tpl.php"
,"ajaxpro" => "politicalcandidates_form.tpl.php"
,"municipality" => "politicalcandidates_form.tpl.php"
,"barangay" => "politicalcandidates_form.tpl.php"
,"hasdistrict" => "politicalcandidates_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Setup' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;
$cmapKey = isset($_GET['ajaxpro'])?"ajaxpro":$cmapKey;
$cmapKey = isset($_GET['municipality'])?"municipality":$cmapKey;
$cmapKey = isset($_GET['barangay'])?"barangay":$cmapKey;
$cmapKey = isset($_GET['hasdistrict'])?"hasdistrict":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Political Candidates');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/setup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsPoliticalCandidates = new clsPoliticalCandidates($dbconn);

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['Political Candidates'] = 'setup.php?statpos=politicalcandidates';
		$arrbreadCrumbs['Add New'] = "";
		$centerPanelBlock->assign("oRecCandPost",$objClsPoliticalCandidates->getRecCandPost());
                $centerPanelBlock->assign("oRecRegionPost",$objClsPoliticalCandidates->getRegionPost());
		if (count($_POST)>0) {
			// save add new
			if(!$objClsPoliticalCandidates->doValidateData($_POST)){
				$objClsPoliticalCandidates->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsPoliticalCandidates->Data);
//				printa($objClsPoliticalCandidates->Data);
			}else {
				//$objClsPoliticalCandidates->doPopulateData($_POST);
				$objClsPoliticalCandidates->doSaveAdd($_POST);
				header("Location: setup.php?statpos=politicalcandidates");
				exit;
			}
		}
		break;
       case 'ajaxpro':
                 echo $objClsPoliticalCandidates->fetchProvinces($_GET['rgn_id']);
                 exit;
               break;
      
       case 'municipality':
                 echo $objClsPoliticalCandidates->getMunicipal($_GET['q'], $_GET['provid']);
                 exit;
               break;

       case 'barangay':
                 echo $objClsPoliticalCandidates->getBarangay($_GET['q'], $_GET['munid']);
                exit;
              break;

       case 'hasdistrict':
                echo $objClsPoliticalCandidates->getHasDistrict($_GET['cp_id']);
                exit;
              break;

       case 'edit':
		$arrbreadCrumbs['Political Candidates'] = 'setup.php?statpos=politicalcandidates';
		$arrbreadCrumbs['Edit'] = "";
		$centerPanelBlock->assign("oRecCandPost",$objClsPoliticalCandidates->getRecCandPost());
                $centerPanelBlock->assign("oRecRegionPost",$objClsPoliticalCandidates->getRegionPost());
                $centerPanelBlock->assign("oRecProvincePost",$objClsPoliticalCandidates->getProvinces());
                $centerPanelBlock->assign("oRecPolCan",$objClsPoliticalCandidates->getPolitiCalcandidates($_GET['edit']));
		if (count($_POST)>0) {
			// update
			if(!$objClsPoliticalCandidates->doValidateData($_POST)){
				$objClsPoliticalCandidates->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsPoliticalCandidates->Data);
//				printa($objClsPoliticalCandidates->Data);
			}else {
				$objClsPoliticalCandidates->doPopulateData($_POST);
				$objClsPoliticalCandidates->doSaveEdit($_POST);
				header("Location: setup.php?statpos=politicalcandidates");
				exit;
			}
		}else{
			$oData = $objClsPoliticalCandidates->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
		
	case "delete":
		$objClsPoliticalCandidates->doDelete($_GET['delete']);
		header("Location: setup.php?statpos=politicalcandidates");
		exit;		
		break;

	default:
		$arrbreadCrumbs['Political Candidates'] = "";
		$centerPanelBlock->assign('tblDataList',$objClsPoliticalCandidates->getTableList());
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