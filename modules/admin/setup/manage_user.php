<?php
//ini_set('display_errors',1);
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
//require_once(SYSCONFIG_CLASS_PATH.'application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/setup/manage_user.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
    "default" => "manage_user.tpl.php",
    "resetPassword" => "manage_user.tpl.php",
    "add" => "manage_user_form.tpl.php",
    "edit" => "manage_user_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
    'Setup' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Manage User');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/setup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsManageUser = new clsManageUser($dbconn);

switch ($cmapKey) {
    case 'resetPassword':
        $oData = $objClsManageUser->dbFetch($_GET['id']);
//        printa($oData);
//        exit;
        $objClsManageUser->resetPassword($oData['user_email'], $oData['user_name'], $oData['municipal_name'], $oData['province_name'], $oData['region_name']);
        header("Location: setup.php?statpos=manageuser");
        exit;
        break;
    case 'region':
        echo $objClsManageUser->getRegion($_GET['q']);
        exit;
    case 'province':
        echo $objClsManageUser->getProvince($_GET['q'], $_GET['rgnid']);
        exit;
    case 'barangay':
        echo $objClsManageUser->getBarangay($_GET['q'], $_GET['munid']);
        exit;
    case 'mun':
        echo $objClsManageUser->getMunicipal($_GET['q'], $_GET['provid']);
        exit;
    case 'add':
//        printa($_SESSION[admin_session_obj]);
        $arrbreadCrumbs['Manage User'] = 'setup.php?statpos=manageuser';
        $arrbreadCrumbs['Add New'] = "";
        $centerPanelBlock->assign("lstStatus",$arrStatus);
        $utype=$_SESSION['admin_session_obj']['user_type'];
        $centerPanelBlock->assign("lstUserType",$objClsManageUser->getUserTypes($utype));
        $centerPanelBlock->assign("lstDepartment",$objClsManageUser->getDepartment());
        if (count($_POST)>0) {
        // save add new
            if(!$objClsManageUser->doValidateData($_POST)) {
                $objClsManageUser->doPopulateData($_POST);
                $centerPanelBlock->assign("oData",$objClsManageUser->Data);
                
                $_SESSION['eMsg'][] = "Please check";
            //				printa($objClsManageUser->Data);
            }else {
                $objClsManageUser->doPopulateData($_POST);
                $objClsManageUser->doSaveAdd();
                header("Location: setup.php?statpos=manageuser");
                exit;
            }
        }
        $centerPanelBlock->assign("oData",array('user_password'=>$objClsManageUser->generatePassword()));
        
        break;

    case 'edit':
        $arrbreadCrumbs['Manage User'] = 'setup.php?statpos=manageuser';
        $arrbreadCrumbs['Edit'] = "";
        $centerPanelBlock->assign("lstStatus",$arrStatus);
        $centerPanelBlock->assign("lstUserType",$objClsManageUser->getUserTypes());
        $centerPanelBlock->assign("lstDepartment",$objClsManageUser->getDepartment());
        if (count($_POST)>0) {
            if($_POST['resetpwd']){
                $objClsManageUser->resetPassword($_POST['user_email'], $_POST['user_name'], $_POST['mun_id'], $_POST['province_id'], $_POST['region_id']);
                header("Location: setup.php?statpos=manageuser");
                exit;
            }
        // update
            if(!$objClsManageUser->doValidateData($_POST)) {
                $objClsManageUser->doPopulateData($_POST);
                $centerPanelBlock->assign("oData",$objClsManageUser->Data);
            //				printa($objClsManageUser->Data);
            }else {
                $objClsManageUser->doPopulateData($_POST);
                $objClsManageUser->doSaveEdit();
                header("Location: setup.php?statpos=manageuser");
                exit;
            }
        }else {
            $oData = $objClsManageUser->dbFetch($_GET['edit']);
            $centerPanelBlock->assign("oData",$oData);
        }
        break;

    case "delete":
        $objClsManageUser->doDelete($_GET['delete']);
        header("Location: setup.php?statpos=manageuser");
        exit;
        break;

    default:
        $arrbreadCrumbs['Manage User'] = "";
        $centerPanelBlock->assign('tblDataList',$objClsManageUser->getTableList());
        break;
}

if(isset($_SESSION['eMsg'])) {
    $centerPanelBlock->assign('eMsg',$_SESSION['eMsg']);
    unset($_SESSION['eMsg']);
}

/*-!-!-!-!-!-!-!-!-*/

$mainBlock->assign('centerPanel',$centerPanelBlock);
$mainBlock->setBreadCrumbs($arrbreadCrumbs);
$mainBlock->assign('breadCrumbs',$mainBlock->breadCrumbs);
$mainBlock->displayBlock();


?>