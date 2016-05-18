<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/setup/precinct.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
    "default" => "precinct.tpl.php"
    ,"add" => "precinct_form.tpl.php"
    ,"edit" => "precinct_form.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
    'Setup' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Manage Precinct');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/setup";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsPrecinct = new clsPrecinct($dbconn);

switch ($cmapKey) {
    case 'region':
        echo $objClsPrecinct->getRegion($_GET['q']);
        exit;
    case 'province':
        echo $objClsPrecinct->getProvince($_GET['q'], $_GET['rgnid']);
        exit;
    case 'barangay':
        echo $objClsPrecinct->getBarangay($_GET['q'], $_GET['munid']);
        exit;
    case 'mun':
        echo $objClsPrecinct->getMunicipal($_GET['q'], $_GET['provid']);
        exit;
    case 'add':
        $arrbreadCrumbs['Manage Precinct'] = 'setup.php?statpos=precinct';
        $arrbreadCrumbs['Add New'] = "";
        if (count($_POST)>0) {
        // save add new
            if(!$objClsPrecinct->doValidateData($_POST)) {
                $objClsPrecinct->doPopulateData($_POST);
                $centerPanelBlock->assign("oData",$objClsPrecinct->Data);
            //				printa($objClsPrecinct->Data);
            }else {
                $objClsPrecinct->doPopulateData($_POST);
                $objClsPrecinct->doSaveAdd();
                header("Location: setup.php?statpos=precinct");
                exit;
            }
        }
        break;

    case 'edit':
        $arrbreadCrumbs['Manage Precinct'] = 'setup.php?statpos=precinct';
        $arrbreadCrumbs['Edit'] = "";
        if (count($_POST)>0) {
        // update
            if(!$objClsPrecinct->doValidateData($_POST)) {
                $objClsPrecinct->doPopulateData($_POST);
                $centerPanelBlock->assign("oData",$objClsPrecinct->Data);
            //				printa($objClsPrecinct->Data);
            }else {
                $objClsPrecinct->doPopulateData($_POST);
                $objClsPrecinct->doSaveEdit();
                header("Location: setup.php?statpos=precinct");
                exit;
            }
        }else {
            $oData = $objClsPrecinct->dbFetch($_GET['edit']);
            $centerPanelBlock->assign("oData",$oData);
        }
        break;

    case "delete":
        $objClsPrecinct->doDelete($_GET['delete']);
        header("Location: setup.php?statpos=precinct");
        exit;
        break;

    default:
        $arrbreadCrumbs['Manage Precinct'] = "";
        if(isset($_POST['src'])){
            header("Location: setup.php?statpos=precinct&rgn={$_POST['rgn']}&rgn_id={$_POST['rgn_id']}&prn={$_POST['prn']}&prn_id={$_POST['prn_id']}&mun={$_POST['mun']}&mun_id={$_POST['mun_id']}&brg={$_POST['brg']}&brg_id={$_POST['brg_id']}&ppl={$_POST['ppl']}&ppl_id={$_POST['ppl_id']}&clu={$_POST['clu']}&clu_id={$_POST['clu_id']}");
            exit;
        }
        
        $centerPanelBlock->assign('tblDataList',$objClsPrecinct->getTableList());

        
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