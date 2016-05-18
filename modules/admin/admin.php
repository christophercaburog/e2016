<?php
include_once(SYSCONFIG_CLASS_PATH."admin/application.class.php");
include_once(SYSCONFIG_CLASS_PATH."admin/appauth.class.php");
include_once(SYSCONFIG_CLASS_PATH."blocks/mainblock.class.php");
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist2.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist3.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/homeadmin.class.php');
include_once(SYSCONFIG_CLASS_PATH."util/ddate.class.php");
include 'his/captcha.class.php';

//Application::app_initialize(array("login_required"=> true));
Application::app_initialize();

$dbconn = Application::db_open();
//$dbconn->debug = true;
$authResult = true;
if(count($_POST)>0){
    $captcha = new Captcha($options);
	$userAuth = new AppAuth($dbconn);
	$authResult = $userAuth->doAuth($_POST['user_name'],md5($_POST['user_password']),($captcha->isKeyRight($_POST['hashkey'])?true:false));
	if($authResult){
		$_SESSION['admin_session_obj']['user_id'] = $userAuth->userID;
		$_SESSION['admin_session_obj']['user_name'] = $userAuth->userName;
		$_SESSION['admin_session_obj']['user_type'] = $userAuth->userType;
		$_SESSION['admin_session_obj']['user_data'] = $userAuth->Data;
        $_SESSION['admin_session_obj']['user_last_login'] = AppUser::getData("user_lastlogin");
        $_SESSION['admin_session_obj']['user_last_login_human'] = dDate::getHumanTimeSince(dDate::parseDateTime($_SESSION['admin_session_obj']['user_last_login']));
		
		$sql = 
		"select * from app_modules dm 
		inner join app_userstypeaccess du on dm.mnu_id = du.mnu_id
		inner join app_users au on du.ud_id = au.ud_id 
		where du.user_type = ? and au.user_id=?
		and dm.mnu_status=1
		and dm.mnu_parent not in (select mnu_id from app_modules) order by mnu_ord asc";
		$rsUserMenu = $dbconn->Execute($sql,array($_SESSION['admin_session_obj']['user_type'],$_SESSION['admin_session_obj']['user_id']));
		
	$arrMainMenu = array();
	while(!$rsUserMenu->EOF){
		$arrMainMenu[] = $rsUserMenu->fields;
		$rsUserMenu->MoveNext();
	}
	$mnuArr = "";
	if(count($arrMainMenu)>0)
	$mnuArr = $userAuth->getModules($dbconn,$arrMainMenu);
//	print "<pre>";
//	print_r($arrMainMenu);
//	print "<pre>";
	

	$mnuScript = "<script type='text/javascript'>\n";
	$mnuScript .= "var myMenu = [$mnuArr];\n";
	$mnuScript .= "cmDraw ('myMenuID', myMenu, 'hbr', '', 'ThemeOffice');\n";
	$mnuScript .= "</script>";
	
	$_SESSION['admin_session_obj']['user_menu'] = $mnuScript;	

    $userAuth->updateLastUserLogin();
    
	header("Location: index.php");
	exit;
	}
}

//print_r($userAuth);
$mainBlock = new MainBlock();
$mainBlock->templateDir .= "admin";
if(!isset($_SESSION['admin_session_obj']['user_id'])){
  $mainBlock->templateFile = "index_login.tpl.php";
  $centerPanelBlock = new BlockBasePHP();
  $centerPanelBlock->templateDir .= "admin";
  $centerPanelBlock->templateFile = "login.tpl.php";
	if(!$authResult){
		$centerPanelBlock->assign("errMsg","Invalid username and password!");
	}
	$mainBlock->assign("centerPanel",$centerPanelBlock);
	$mainBlock->displayBlock();	
	
}else{

    AppSession::checkidle();
    
    $objHomeAdmin = new clsHomeAdmin($dbconn);
    $centerPanelBlock = new BlockBasePHP();
    $centerPanelBlock->templateDir .= "admin";
    $centerPanelBlock->templateFile = "homeadmin.tpl.php";

    $hasViewGrant = (strtolower($_SESSION['admin_session_obj']['user_type']) != "rptv01" 
            && strtolower($_SESSION['admin_session_obj']['user_type']) != "administrator"
            && strtolower($_SESSION['admin_session_obj']['user_type']) != "canvalidator"
            )?true:false;
    $centerPanelBlock->assign("hasViewGrant", $hasViewGrant);

    if($hasViewGrant){
        $centerPanelBlock->assign('tblDataList',$objHomeAdmin->getTableList());

        $centerPanelBlock->assign('tblOnProcess',$objHomeAdmin->getOnProcessList());

        $centerPanelBlock->assign('tblVerified',$objHomeAdmin->getOnVerifiedList(40));

        if(count($_POST)>0){
            
            if(isset($_POST['verify'])){
                if(count($_POST['chk'])>0){
                    foreach($_POST['chk'] as $key => $val){
                         $objHomeAdmin->doSavePrecinctsUpdateStatus($key);
                    }
                    header("Location: index.php");
                    exit;
                }else{
                    $_SESSION['eMsgOpenStatus'] ="Please select an item to submit.";
                }
            }
        }
        //$centerPanelBlock->assign('tblVerified',$objHomeAdmin->getOnProcessList(40));
    }
    
    $centerPanelBlock->assign('arrPrecinctStatus',$arrPrecinctStatus);
    
    $mainBlock->assign('indexErrMsg',$indexErrMsg);
    $mainBlock->assign("centerPanel",$centerPanelBlock);
    $mainBlock->displayBlock();
}

?>