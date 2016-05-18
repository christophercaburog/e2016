<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/encoder/bei-erapprovalentry.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
//"default" => "bei-erapprovalentry.tpl.php"
"default" => "bei-erapprovalentry_form.tpl.php"
,"add" => "bei-erapprovalentry_form.tpl.php"
,"edit" => "bei-erapprovalentry_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Task' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','BEI-ER Approval Entry');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/encoder";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsBEIERApprovalEntry = new clsBEIERApprovalEntry($dbconn);

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['BEI-ER Approval Entry'] = 'encoder.php?statpos=bei-erapprovalentry';
		$arrbreadCrumbs['Add New'] = "";
		if (count($_POST)>0) {
			// save add new
			if(!$objClsBEIERApprovalEntry->doValidateData($_POST)){
				$objClsBEIERApprovalEntry->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsBEIERApprovalEntry->Data);
//				printa($objClsBEIERApprovalEntry->Data);
			}else {
				$objClsBEIERApprovalEntry->doPopulateData($_POST);
				$objClsBEIERApprovalEntry->doSaveAdd();
				header("Location: encoder.php?statpos=bei-erapprovalentry");
				exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['BEI-ER Approval Entry'] = 'encoder.php?statpos=bei-erapprovalentry';
		$arrbreadCrumbs['Edit'] = "";
		if (count($_POST)>0) {
			// update
			if(!$objClsBEIERApprovalEntry->doValidateData($_POST)){
				$objClsBEIERApprovalEntry->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsBEIERApprovalEntry->Data);
//				printa($objClsBEIERApprovalEntry->Data);
			}else {
				$objClsBEIERApprovalEntry->doPopulateData($_POST);
				$objClsBEIERApprovalEntry->doSaveEdit();
				header("Location: encoder.php?statpos=bei-erapprovalentry");
				exit;
			}
		}else{
			$oData = $objClsBEIERApprovalEntry->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
		
	case "delete":
		$objClsBEIERApprovalEntry->doDelete($_GET['delete']);
		header("Location: encoder.php?statpos=bei-erapprovalentry");
		exit;		
		break;

	default:
		$arrbreadCrumbs['BEI-ER Approval Entry'] = "";
//		echo "fdsafasf";
//		//$centerPanelBlock->assign('tblDataList',$objClsBEIERApprovalEntry->getTableList());
//		if($_POST['sysrefno']!='' && $_POST['precinctno']!='' && $_POST['erseries']!='' && $_POST['beipasscode']!='' && $_POST['capcha']!=''){
//			$encoding =false;
//			$centerPanelBlock->assign("oData",$_POST);
//		}
//		else
//			$encoding =true;
//		
//		$centerPanelBlock->assign("encoding",$encoding);
		break;
}

		//$centerPanelBlock->assign('tblDataList',$objClsBEIERApprovalEntry->getTableList());
		if($_POST['sysrefno']!='' && $_POST['precinctno']!='' && $_POST['erseries']!='' && $_POST['beipasscode']!='' && $_POST['capcha']!=''){
			$encoding =false;
			$centerPanelBlock->assign("oData",$_POST);
		}
		else
			$encoding =true;
		
		$centerPanelBlock->assign("encoding",$encoding);

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