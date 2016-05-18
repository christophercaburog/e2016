<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/reports/view_r_national.class.php');


ini_set('display_errors',1);

Application::app_initialize();
//$dbconn->debug=1;
$dbconn = Application::db_open();

$cmap = array(
"default" => "view_r_national.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Change This!!!' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','');
$mainBlock->templateDir .= "admin/";
$mainBlock->templateFile = "index_blank.tpl.php";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/reports";
//$centerPanelBlock->templateFile = 'view_r_national.tpl.php';
$centerPanelBlock->templateFile = 'ground_er_r_national.tpl.php';

/*-!-!-!-!-!-!-!-!-*/

$objClsViewRnational = new clsViewRnational($dbconn);

$centerPanelBlock->assign('candidate_name',$objClsViewRnational->fetchCandidatePostName($_GET['cpi']));

$precincts=$objClsViewRnational->fetchPrecincts($_GET['mun_id']);

$centerPanelBlock->assign('precincts',$precincts);

$candidates=$objClsViewRnational->initCandidates($_GET['rgn_id'],$_GET['cpi'],$_GET['mun_id']);

$centerPanelBlock->assign('candidates',$candidates);

$centerPanelBlock->assign('report_details',$objClsViewRnational->initReport($_GET['cpi'],$_GET['rgn_id'],$_GET['mun_id']));


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