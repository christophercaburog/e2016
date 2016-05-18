<?php

require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/reports/view_report.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
//"view" => "view_report.tpl.php"   // uncomment this to view parallel counts with pcos & comelec
"view" => "ground_er_view.tpl.php" // 
,"viewloc" => "view_report.tpl.php"
,"lm" => "local_municipality.tpl.php"
,"pr" => "provincial_listings.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(

);

$cmapKey = isset($_GET['view'])?"view":$cmapKey;
$cmapKey = isset($_GET['lm'])?"lm":$cmapKey;
$cmapKey = isset($_GET['pr'])?"pr":$cmapKey;


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

$objClsViewReport = new clsViewReport($dbconn);

switch ($cmapKey) {
	
	case "lm":
			$centerPanelBlock->assign('tblDataList',$objClsViewReport->getTableList());
		break;

	case "pr":
		$arrbreadCrumbs['Provincial'] = '';
			$centerPanelBlock->assign('tblDataList',$objClsViewReport->getProvincialTableListings($_GET['pr']));
            $mainBlock->templateFile = "index.tpl.php";
		break;

	case 'view':
        
		$arrbreadCrumbs[''] = 'reports.php?statpos=view_report';
        
		$arrbreadCrumbs['Edit'] = "";

		$centerPanelBlock->assign('candidate_post_name',$objClsViewReport->fetchCandidatePost($_GET['view']));

		$centerPanelBlock->assign('regions',$objClsViewReport->fetchRegions());

		$centerPanelBlock->assign('candidates_names',$objClsViewReport->fetchCandidates($_GET['view']));
        
		$centerPanelBlock->assign('regional_data',$objClsViewReport->fetchRegionalCount($_GET['view']));
        
		break;

	default:
		$arrbreadCrumbs[''] = "";
		$centerPanelBlock->assign('tblDataList',$objClsViewReport->getTableList());
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