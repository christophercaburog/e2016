<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/reports/view_provincial.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"prov_id" => "view_provincial.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Change This!!!' => ''
);

$cmapKey = isset($_GET['prov_id'])?"prov_id":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','');
$mainBlock->templateDir .= "admin/";
$mainBlock->templateFile = "index_blank.tpl.php";



// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/reports";
$centerPanelBlock->templateFile = $cmap[$cmapKey];


/*-!-!-!-!-!-!-!-!-*/

$objClsViewProvincial = new clsViewProvincial($dbconn);


switch ($cmapKey) {

    case 'prov_id':

		$centerPanelBlock->assign('candidates',$objClsViewProvincial->initCandidates($_GET['cpi'],$_GET['prov_id']));

        $centerPanelBlock->assign('report_details',$objClsViewProvincial->initReport($_GET['cpi'],$_GET['prov_id']));


        break;

	default:

		$centerPanelBlock->assign('tblDataList',$objClsViewProvincial->getTableList());
        
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