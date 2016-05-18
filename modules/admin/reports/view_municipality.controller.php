<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/reports/view_municipality.class.php');

Application::app_initialize();

$dbconn = Application::db_open();
//$dbconn->debug =1;
$cmap = array(
"mun_id" => "view_municipality.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Change This!!!' => ''
);

$cmapKey = isset($_GET['mun_id'])?"mun_id":$cmapKey;


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

$objClsViewMuni = new clsViewMunicipality($dbconn);

switch ($cmapKey) {
    
	case 'mun_id':
        
		$arrbreadCrumbs[''] = 'reports.php?statpos=view_municipality';
		$arrbreadCrumbs['Edit'] = "";
//		$centerPanelBlock->assign('reportBreadCrumbs',$mainBlock->breadCrumbs);

//		$centerPanelBlock->assign('candidate_data',$objClsViewMuni->fetchCandidates($_GET['lm'],$_GET['mun_id']));
//        $centerPanelBlock->assign('brgyprec_data',$objClsViewMuni->fetchBrgyPrec($_GET['mun_id']));
//
//        $centerPanelBlock->assign('TotalCount',$objClsViewMuni->fetchCandidatesTotalCount($_GET['lm'],$_GET['mun_id']));
//        	$centerPanelBlock->assign('SubCount',$objClsViewMuni->fetchCount($_GET['mun_id'],$_GET['lm']));

        	$centerPanelBlock->assign('candidates',$objClsViewMuni->initCandidates($_GET['lm'],$_GET['mun_id']));
            
        	$centerPanelBlock->assign('report_details',$objClsViewMuni->initReport($_GET['lm'],$_GET['mun_id']));
            
		break;
    
	default:
		$arrbreadCrumbs[''] = "";
		$centerPanelBlock->assign('tblDataList',$objClsViewMuni->getTableList());
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