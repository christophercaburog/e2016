<?php
require_once(SYSCONFIG_CLASS_PATH.'blocks/mainblock.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/application.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/tablelist.class.php');
require_once(SYSCONFIG_CLASS_PATH.'admin/encoder/erentry.class.php');
require_once(SYSCONFIG_CLASS_PATH.'util/englishdecimalformat.class.php');
//include(SYSCONFIG_CLASS_PATH.'util/captcha.class.php');

Application::app_initialize();

$dbconn = Application::db_open();

//$dbconn->debug = 1;
Debug::setVerbosity(9);

$cmap = array(
"default" => "erentry.tpl.php"
,"add" => "erentry_form.tpl.php"
,"addverify" => "erentry_form.tpl.php"
,"edit" => "erentry_form.tpl.php"
,"er" => "erentry_form_step01.tpl.php"
,"erx" => "erentry_form_step02.tpl.php"
,"viewER" => "erentry_form_view.tpl.php"
);

$cmapKey = (isset($_GET['action']))?$_GET['action']:"default";
$arrbreadCrumbs = array(
'Encoder' => ''
);

$cmapKey = isset($_GET['edit'])?"edit":$cmapKey;
$cmapKey = isset($_GET['delete'])?"delete":$cmapKey;
$cmapKey = isset($_GET['his'])?"his":$cmapKey;

// Instantiate the MainBlock Class
$mainBlock = new MainBlock();
$mainBlock->assign('PageTitle','Election Returns Entry');
$mainBlock->templateDir .= "admin";


// Instantiate the BlockBasePHP for Center Panel Display
$centerPanelBlock = new BlockBasePHP();
$centerPanelBlock->templateDir  .= "admin/encoder";
$centerPanelBlock->templateFile = $cmap[$cmapKey];

/*-!-!-!-!-!-!-!-!-*/

$objClsEREntry = new clsEREntry($dbconn);
$edfOBJ = new EnglishDecimalFormat();


switch ($cmapKey) {
	case 'his':
//		$options['sessionName'] = 'vihash';
//		$options['fontPath'] = '.';
//		$options['fontFile'] = 'anonymous.gdf';
//		$options['imageWidth'] = 150;
//		$options['imageHeight'] = 50;
//		$options['allowedChars'] = '1234567890';
//		$options['stringLength'] = 4;
//		$options['charWidth'] = 40;
//		$options['blurRadius'] = 3.0;
//		$options['secretKey'] = 'mySecRetkEy';
//		
//		$captcha = new Captcha($options);
//		$captcha->getCaptcha();
		exit;

    case "erx":
        /*
         * security check starts here...
         * hash explaination
         * $securityKey = '53cr3t'; <-- as defined on homeadmin.class.php
         * e -> er_id
         * g -> region id (rgn_id)
         * v -> province id (prov_id)
         * has value = md5( e + securityKey + g + v )
         */
        //echo  $_GET['rx'] . ' - ' . sha1($_GET['ex'] . '53cr3t' . $_GET['gx'].$_GET['vx']);


        $arrCandidateVotesData = $objClsEREntry->getCandidateVotesDataByPrecinct($_GET['ex']);
        //Debug::Arr($arrCandidateVotesData,"arrCandidateVotesData");
        //Debug::Arr($_SESSION,"SessioN");
        $centerPanelBlock->assign("arrCandidateVotesData", $arrCandidateVotesData);

        // check post data
        if(count($_POST) > 0){
            //Debug::Arr($_POST,"POST");
            if(isset($_POST['submit_verified'])){
                $objClsEREntry->doSavePrecinctsUpdateStatus($_GET['ex'],$_POST['precincts_code']);
                header("Location: index.php");
            }elseif(isset($_POST['submit_pendingerror'])){
                $objClsEREntry->doSavePrecinctsUpdateStatus($_GET['ex'],$_POST['precincts_code'], 30, $_POST['precincts_encoded_remarks']);
                header("Location: index.php");
            }elseif(isset($_POST['submit_verification'])){
                $objClsEREntry->doSavePrecinctsUpdateStatus($_GET['ex'],$_POST['precincts_code'],25);
                header("Location: index.php");
            }else{ // save data
                $objClsEREntry->doSaveCandidateVotes($_GET['ex'], $_POST, $arrCandidateVotesData);
                header("Location: encoder.php?rx={$_GET['rx']}&statpos=erentry&action=erx&ex={$_GET['ex']}&gx={$_GET['gx']}&vx={$_GET['vx']}");
            }
            exit;
        }

        // get precinct information
        $arrPrecinctInfo = $objClsEREntry->getPrecinctInfo($_GET['ex']);
        //Debug::Arr($arrPrecinctInfo,"arrPrecinctInfo");
        $centerPanelBlock->assign("arrPrecinctInfo", $arrPrecinctInfo);

        
        
        // get all national candidates
        $centerPanelBlock->assign("arrNationalCandidates", $objClsEREntry->getCandidateListNational());

        // get all partylist candidates
        $centerPanelBlock->assign("arrPartyListCandidates", $objClsEREntry->getCandidateListPartylist());

        // get all provincial candidates
        $centerPanelBlock->assign("arrProvincialCandidates", $objClsEREntry->getCandidateListProvincial($arrPrecinctInfo['prov_id']));

        // get all municipal/local candidates
        $centerPanelBlock->assign("arrMunicipalCandidates", $objClsEREntry->getCandidateListMunicipal($arrPrecinctInfo['prov_id'],$arrPrecinctInfo['mun_id']));



        break;

    case "viewER":
        //$centerPanelBlock->templateDir  .= "admin/encoder";
        //$mainBlock->templateFile = "index_blank.tpl.php";

        $arrCandidateVotesData = $objClsEREntry->getCandidateVotesDataByPrecinct($_GET['e']);
        //Debug::Arr($arrCandidateVotesData,"arrCandidateVotesData");
        //Debug::Arr($_SESSION,"SessioN");
        $centerPanelBlock->assign("arrCandidateVotesData", $arrCandidateVotesData);

        // get precinct information
        $arrPrecinctInfo = $objClsEREntry->getPrecinctInfo($_GET['e']);
        //Debug::Arr($arrPrecinctInfo,"arrPrecinctInfo");
        $centerPanelBlock->assign("arrPrecinctInfo", $arrPrecinctInfo);

        // get all national candidates
        $centerPanelBlock->assign("arrNationalCandidates", $objClsEREntry->getCandidateListNational());

        // get all partylist candidates
        $centerPanelBlock->assign("arrPartyListCandidates", $objClsEREntry->getCandidateListPartylist());

        // get all provincial candidates
        $centerPanelBlock->assign("arrProvincialCandidates", $objClsEREntry->getCandidateListProvincial($arrPrecinctInfo['prov_id']));

        // get all municipal/local candidates
        $centerPanelBlock->assign("arrMunicipalCandidates", $objClsEREntry->getCandidateListMunicipal($arrPrecinctInfo['prov_id'],$arrPrecinctInfo['mun_id']));


        break;
    
    case "er": # 
        /*
         * security check starts here...
         * hash explaination
         * $securityKey = '53cr3t'; <-- as defined on homeadmin.class.php
         * e -> er_id
         * g -> region id (rgn_id)
         * v -> province id (prov_id)
         * has value = md5( e + securityKey + g + v )
         */
        //echo  $_GET['r'] . ' - ' . sha1($_GET['e'] . '53cr3t' . $_GET['g'].$_GET['v']);

        // check post data
        if(count($_POST) > 0){
            if(isset($_POST['submit_savenext'])){
                $objClsEREntry->doSavePrecinctsHeader($_GET['e'], $_POST);
            }
            header("Location: encoder.php?rx={$_GET['r']}&statpos=erentry&action=erx&ex={$_GET['e']}&gx={$_GET['g']}&vx={$_GET['v']}");
            exit;
        }

        // get precinct information
        $centerPanelBlock->assign("arrPrecinctInfo", $objClsEREntry->getPrecinctInfo($_GET['e']));
        
        break;

    case "erp": # navigation will fall in here when the precinct item was clicked from the homepage
        /*
         * security check starts here...
         * hash explaination
         * $securityKey = '53cr3t'; <-- as defined on homeadmin.class.php
         * e -> er_id
         * g -> region id (rgn_id)
         * v -> province id (prov_id)
         * has value = md5( e + securityKey + g + v )
         */
        //echo  $_GET['r'] . ' - ' . sha1($_GET['e'] . '53cr3t' . $_GET['g'].$_GET['v']);

        // check if the current precinct is not yet in use by the other encoders

        //$dbconn->debug =1;
        // set current encoder login info as owner of the selected precinct
        if($objClsEREntry->isPrecinctTaken($_GET['e']) === FALSE){
            $objClsEREntry->setPrecinctTaken($_GET['e']);
        }else{
            $arrPrecinctInfo = $objClsEREntry->getPrecinctInfo($_GET['e']);
            Debug::Arr($arrPrecinctInfo,"");
            $_SESSION['eMsgOpenStatus'] = "Precinct \"{$arrPrecinctInfo['precincts_number']}\" was already taken.";
            header("Location: index.php");
            exit;
        }

        // then redirect to form page
        header("Location: encoder.php?r={$_GET['r']}&statpos=erentry&action=er&e={$_GET['e']}&g={$_GET['g']}&v={$_GET['v']}");
        exit;
        
        break;

/*
	case 'add': 
		$arrbreadCrumbs['Election Returns Entry'] = '';
		$arrbreadCrumbs['Add New'] = "";

		if (count($_POST)>0) {
			//$centerPanelBlock->assign("voteinfo_Post",$_POST);
			
			// save add new
			if(!$objClsEREntry->doValidateData($_POST)){
				$objClsEREntry->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsEREntry->Data);
				$centerPanelBlock->assign("edfOBJ",$edfOBJ);
//				printa($_POST);
//				printa($objClsEREntry->Data);
			}else {
	//			$objClsEREntry->doPopulateData($_POST);
				$iEdit = $objClsEREntry->doSaveAdd($_POST);
				header("Location: encoder.php?statpos=erentry&edit=$iEdit");
				exit;
			}
		}
		$centerPanelBlock->assign("arrListOfCandidates",$objClsEREntry->getListOfCandidates());
		$centerPanelBlock->assign("arrListOfPrecincts",$objClsEREntry->getPrecincts($_SESSION['admin_session_obj']['user_data']['pollingplaces_id']));
		
//		printa($objClsEREntry->getListOfCandidates());
		
		
		break;

	case 'addverify': 
		
		$centerPanelBlock->assign("arrListOfPrecincts",$objClsEREntry->getPrecincts($_SESSION['admin_session_obj']['user_data']['pollingplaces_id']));
	
		$mainBlock->templateFile = "index_blank.tpl.php";

		$arrbreadCrumbs['Election Returns Entry'] = '';
		$arrbreadCrumbs['ER Submission Verification'] = "";
		if (count($_POST)>0) {
			// save add new
			if(!$objClsEREntry->doValidateData($_POST)){
				$objClsEREntry->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsEREntry->Data);
				//printa($objClsEREntry->Data);
			}else {
				$objClsEREntry->doPopulateData($_POST);
				$objClsEREntry->doSaveAdd();
				header("Location: encoder.php?statpos=erentry&action=addverify");
				exit;
			}
		}
		$centerPanelBlock->assign("arrListOfCandidates",$objClsEREntry->getListOfCandidates());
//		printa($objClsEREntry->getListOfCandidates());
		break;

	case 'edit':
		$arrbreadCrumbs['Election Returns Entry'] = 'encoder.php?statpos=erentry&action=add';
		$arrbreadCrumbs['Edit'] = "";
		if (count($_POST)>0) {
			// update
			if(!$objClsEREntry->doValidateData($_POST)){
				$objClsEREntry->doPopulateData($_POST);
				$centerPanelBlock->assign("oData",$objClsEREntry->Data);
//				printa($objClsEREntry->Data);
			}else {
				$objClsEREntry->doPopulateData($_POST);
				$objClsEREntry->doSaveEdit();
				header("Location: encoder.php?statpos=erentry");
				exit;
			}
		}else{
			$oData = $objClsEREntry->dbFetch($_GET['edit']);
			//printa($oData);
			$centerPanelBlock->assign("arrListOfPrecincts",$objClsEREntry->getPrecincts($_SESSION['admin_session_obj']['user_data']['pollingplaces_id']));
			$centerPanelBlock->assign("arrListOfCandidates",$objClsEREntry->getListOfCandidates());
			$centerPanelBlock->assign("edfOBJ",$edfOBJ);
			$centerPanelBlock->assign("oData",$oData);
		}
		break;
		
	case "delete":
		$objClsEREntry->doDelete($_GET['delete']);
		header("Location: encoder.php?statpos=erentry");
		exit;		
		break;
*/
	default:
		$arrbreadCrumbs['Election Returns Entry'] = "";
		$centerPanelBlock->assign('tblDataList',$objClsEREntry->getTableList());
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
