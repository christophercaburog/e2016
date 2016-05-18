<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/reports/report_main.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

$cmap = array(
"default" => "report_main.tpl.php"
,"eli" => "report_eli.tpl.php"
,"edit" => "reportmain_form.tpl.php"
,"discrepancy" => "discrepancy_report.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
    'Election Level'=>'reports.php?statpos=main'
);

$cmapKey = isset($_GET['eli'])?"eli":$cmapKey;



// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Reports');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/reports";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsReportMain = new clsReportMain($dbconn);

switch ($cmapKey) {
    case 'discrepancy':
        set_time_limit(0);
        $mainBlock->templateFile = "index_blank.tpl.php";
        $centerPanelBlock->assign('arrData',$objClsReportMain->getDiscrepancyReport($_GET['all']));
        break;
	default:
			$centerPanelBlock->assign('report_menu',$objClsReportMain->fetchReportMenu());
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