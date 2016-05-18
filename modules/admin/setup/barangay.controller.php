<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/setup/barangay.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"default" => "barangay.tpl.php"
,"add" => "barangay_form.tpl.php"
,"edit" => "barangay_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Setup' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Manage Barangay');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/setup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsBarangay = new clsBarangay($dbconn);

switch ($cmapKey) {
	case 'add': 
		$arrbreadCrumbs['Manage Barangay'] = 'setup.php?statpos=barangay';
		$arrbreadCrumbs['Add New'] = "";
		if (count($_POST)>0) {
			// save add new
			if(!$objClsBarangay->doValidateData($_POST)){
				$objClsBarangay->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsBarangay->Data);
//				printa($objClsBarangay->Data);
			}else {
				$objClsBarangay->doPopulateData($_POST);
				$objClsBarangay->doSaveAdd($_POST);
				header("Location: setup.php?statpos=barangay");
				exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['Manage Barangay'] = 'setup.php?statpos=barangay';
		$arrbreadCrumbs['Edit'] = "";
		if (count($_POST)>0) {
			// update
			if(!$objClsBarangay->doValidateData($_POST)){
				$objClsBarangay->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsBarangay->Data);
//				printa($objClsBarangay->Data);
			}else {
				$objClsBarangay->doPopulateData($_POST);
				$objClsBarangay->doSaveEdit($_POST);
				header("Location: setup.php?statpos=barangay");
				exit;
			}
		}else{
			$oData = $objClsBarangay->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
		
	case "delete":
		$objClsBarangay->doDelete($_GET['delete']);
		header("Location: setup.php?statpos=barangay");
		exit;		
		break;

	default:
		$arrbreadCrumbs['Manage Barangay'] = "";
        if(isset($_POST['src'])){
            header("Location: setup.php?statpos=barangay&rgn={$_POST['rgn']}&rgn_id={$_POST['rgn_id']}&prn={$_POST['prn']}&prn_id={$_POST['prn_id']}&mun={$_POST['mun']}&mun_id={$_POST['mun_id']}&brg={$_POST['brg']}&brg_id={$_POST['brg_id']}");
            exit;
        }
		$centerPanelBlock->assign('tblDataList',$objClsBarangay->getTableList());
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