<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/reports/view_region.class.php');

Application::app_initialize();

$dbconn = Application::db_open();
//$dbconn->debug =1;
$cmap = array(
//"rgn_id" => "view_region.tpl.php"
"rgn_id" => "ground_er_view_region.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Change This!!!' => ''
);

$cmapKey = isset($_GET['rgn_id'])?"rgn_id":$cmapKey;

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

$objClsViewRegion = new clsViewRegion($dbconn);

switch ($cmapKey) {
    
	case 'rgn_id':
        
		$arrbreadCrumbs[''] = 'reports.php?statpos=view_region';
        
		$arrbreadCrumbs['Edit'] = "";
        
        $centerPanelBlock->assign('candidates',$objClsViewRegion->initCandidates($_GET['cpi'],$_GET['rgn_id']));

		$centerPanelBlock->assign('report_details',$objClsViewRegion->initReport($_GET['cpi'],$_GET['rgn_id']));

    break;

	default:
		$arrbreadCrumbs[''] = "";
		$centerPanelBlock->assign('tblDataList',$objClsViewRegion->getTableList());
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