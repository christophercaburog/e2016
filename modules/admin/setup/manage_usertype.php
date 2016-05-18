<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
//require_once(SYSCONFIG_CLASS_PATH.'application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/setup/manage_usertype.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"default" => "manage_usertype.tpl.php",
"add" => "manage_usertype_form.tpl.php",
"edit" => "manage_usertype_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Setup' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Manage User Type');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/setup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsUserType = new clsUserType($dbconn);

switch ($cmapKey) {
	case 'add':
		$arrbreadCrumbs['Manage User Type'] = 'setup.php?statpos=manageusertype';
		$arrbreadCrumbs['Add New'] = "";
		$centerPanelBlock->assign("lstStatus",$arrStatus);
		
		$UserAccessModules = clsUserType::getModulesList($dbconn,clsUserType::getModulesParent($dbconn));
		$centerPanelBlock->assign("UserAccessModules",$UserAccessModules);
		$centerPanelBlock->assign("lstUserDept",$objClsUserType->getUserTypeDept());
		if (count($_POST)>0) {
			// save add new
			if(!$objClsUserType->doValidateData($_POST)){
				$objClsUserType->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsUserType->Data);
//				printa($objClsUserType->Data);
				
//				print implode("),(ud_id,user_type_id,",$_POST['user_type_access']);
			}else {
				$objClsUserType->doPopulateData($_POST);
				$objClsUserType->doSaveAdd();
				header("Location: setup.php?statpos=manageusertype");
				exit;
			}
		}
		break;

	case 'edit':
		$arrbreadCrumbs['Manage User Type'] = 'setup.php?statpos=manageusertype';
		$arrbreadCrumbs['Edit'] = "";
		$centerPanelBlock->assign("lstStatus",$arrStatus);
		if (count($_POST)>0) {
			// update
			if(!$objClsUserType->doValidateData($_POST)){
				$objClsUserType->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsUserType->Data);
//				printa($objClsUserType->Data);
			}else {
				$objClsUserType->doPopulateData($_POST);
				$objClsUserType->doSaveEdit();
				header("Location: setup.php?statpos=manageusertype");
				exit;
			}
		}else{
			$oData = $objClsUserType->dbFetch($_GET['edit']);
			$centerPanelBlock->assign("oData",$oData);
			$UserAccessModules = clsUserType::getModulesList($dbconn,clsUserType::getModulesParent($dbconn),false,0,$oData['user_type_access']);
			$centerPanelBlock->assign("UserAccessModules",$UserAccessModules);
			$centerPanelBlock->assign("lstUserDept",$objClsUserType->getUserTypeDept());
		}
		break;

	case "delete":
		$objClsUserType->doDelete($_GET['delete']);
		header("Location: setup.php?statpos=manageusertype");
		exit;
		break;

	default:
		$arrbreadCrumbs['Manage User Type'] = "";
		$centerPanelBlock->assign('tblDataList',$objClsUserType->getTableList());
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