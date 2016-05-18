<?php
/**
 * Initial Declaration
 */
$arrStatus = array(
    1 => "Public",
    2 => "Inactive"
);
require(SYSCONFIG_CLASS_PATH.'util/phpmailer/'.'class.phpmailer.php');
/**
 * Class Module
 *
 * @author  Arnold P. Orbista
 *
 */
class clsManageUser {

    var $conn;
    var $fieldMap;
    var $Data;

    /**
     * Class Constructor
     *
     * @param object $dbconn_
     * @return clsManageUser object
     */
    function clsManageUser($dbconn_ = null) {
        $this->conn =& $dbconn_;
        $this->fieldMap = array(
            "user_name" => "user_name",
            "user_fullname" => "user_fullname",
            "user_type" => "user_type",
            "user_password" => "user_password",
            //   "ud_id" => "ud_id",
            "user_status" => "user_status",
            "rgn_id" => "region_id",
            "mun_id" => "mun_id",
            "prov_id" => "province_id",
            "user_email" => "user_email",
        );
    }

    /**
     * Get the records from the database
     *
     * @param string $id_
     * @return array
     */
    function dbFetch($id_ = "") {
        $sql = "select am.*, mun.municipal_name,
                                prov.province_name, 
                                reg.region_name
				  
					from app_users am 
					left JOIN comelec_municipal mun
						ON (mun.mun_id=am.mun_id)
					left JOIN comelec_province prov
						ON (prov.prov_id=am.prov_id)
					left JOIN comelec_region reg
						ON (reg.rgn_id=am.rgn_id)
					where am.user_id=?";
        $rsResult = $this->conn->Execute($sql,array($id_));
        if(!$rsResult->EOF) {
            $rsResult->fields['user_password'] = $this->generatePassword();
            return $rsResult->fields;
        }
    }
    /**
     * Populate array parameters to Data Variable
     *
     * @param array $pData_
     * @return bool
     */
    function doPopulateData($pData_ = array()) {
        if(count($pData_)>0) {
            foreach ($this->fieldMap as $key => $value) {
                $this->Data[$key] = $pData_[$value];
            }
            return true;
        }
        return false;
    }

    /**
     * Validation function
     *
     * @param array $pData_
     * @return bool
     */
    function doValidateData($pData_ = array()) {
        $isValid = true;
        $regexEmail = "'^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6}$'";

        //		$isValid = false;
        //		$_SESSION['eMsg'][] = "test message";
/*        if(!empty($pData_['user_email'])) {
            if(!preg_match($regexEmail, $pData_['user_email'])) {
                $isValid = false;
                $_SESSION['eMsg'][] = "Please enter a valid Email";
            }
        }
*/
//        if(!empty($pData_['user_name'])) {
//            if(!preg_match($regexEmail, $pData_['user_name'])) {
//                $isValid = false;
//                $_SESSION['eMsg'][] = "Please enter a valid User Name";
//            }
//        }
//        if(empty($pData_['user_email'])) {
//            $isValid = false;
//            $_SESSION['eMsg'][] = "Email is Required";
//        }
        if(empty($pData_['user_name'])) {
            $isValid = false;
            $_SESSION['eMsg'][] = "User Name is Required";
        }
        if(empty($pData_['user_fullname'])) {
            $isValid = false;
            $_SESSION['eMsg'][] = "Full Name is Required";
        }
        

        return $isValid;
    }

    /**
     * Save New
     *
     */
//    	function doSaveAdd(){
//		$flds = array();
//		foreach ($this->Data as $keyData => $valData) {
//			if($keyData == "user_password") $valData = md5(trim($valData));
//			$flds[] = "$keyData='$valData'";
//		}
//		$fields = implode(", ",$flds);
//
//		$sql = "insert into app_users set $fields";
//		$this->conn->Execute($sql);
//
//		$_SESSION['eMsg']="Successfully Added.";
    function doSaveAdd() {
        $flds = array();
        //$password = $this->generatePassword();
        //$passwordhashed = md5($password);
        foreach ($this->Data as $keyData => $valData) {
                   if($keyData == "user_password") $valData = md5($valData);
            $flds[] = "$keyData='$valData'";
        }
        $fields = implode(", ",$flds);
        //$flds[] = "user_password = '{$passwordhashed}'";
        $flds[] = "user_addwhen = NOW()";
        $flds[] = "ud_id = '2'";
        $flds[] = "user_addwho = '{$_SESSION[admin_session_obj][user_data][user_fullname]}'";
        $fields = implode(", ",$flds);

        $sql = "insert into app_users set $fields";
        $this->conn->Execute($sql);
        //$this->resetPassword($_POST['user_email'], $_POST['user_name'],$_POST['municipal_name'],$_POST['province_name'],$_POST['region_name'], $password);
        $_SESSION['eMsg']="Successfully Added.";
    }

    /**
     * Save Update
     *
     */
    function doSaveEdit() {
        $id = $_GET['edit'];
        //        $password = $this->generatePassword();
        //        $password = md5($password);

        $flds = array();
        foreach ($this->Data as $keyData => $valData) {
         if($keyData == "user_password") $valData = md5($valData);
            $flds[] = "$keyData='$valData'";
        }
         //$flds[] = "user_password = '{$password}'";
        $flds[] = "user_updatewhen = NOW()";
        $flds[] = "user_updatewho = '{$_SESSION[admin_session_obj][user_data][user_fullname]}'";
        $fields = implode(", ",$flds);

        $sql = "update app_users set $fields where user_id=$id";
        $this->conn->Execute($sql);
        $_SESSION['eMsg']="Successfully Updated.";
    }

    /**
     * Delete Record
     *
     * @param string $id_
     */
    function doDelete($id_ = "") {
        $sql = "delete from app_users where user_id=?";
        $this->conn->Execute($sql,array($id_));
        $_SESSION['eMsg']="Successfully Deleted.";
    }

    /**
     * Get all the Table Listings
     *
     * @return array
     */
    function getTableList() {
        
    // Process the query string and exclude querystring named "p"
        if (!empty($_SERVER['QUERY_STRING'])) {
            $qrystr = explode("&",$_SERVER['QUERY_STRING']);
            foreach ($qrystr as $value) {
                $qstr = explode("=",$value);
                if ($qstr[0]!="p") {
                    $arrQryStr[] = implode("=",$qstr);
                }
            }
            $aQryStr = $arrQryStr;
            $aQryStr[] = "p=@@";
            $queryStr = implode("&",$aQryStr);
        }

        //bby: search module
        if (isset($_REQUEST['search_field'])) {

        // lets check if the search field has a value
            if (strlen($_REQUEST['search_field'])>0) {
            // lets assign the request value in a variable
                $search_field = $_REQUEST['search_field'];

                // create a custom criteria in an array
                $qry[] = "au.user_name like '%$search_field%' || au.user_fullname like '%$search_field%'";

                // put all query array into one string criteria
                $criteria = " and (".implode(" or ",$qry).")";

            }
        }

        $arrSortBy = array(
            "user_name"=>"au.user_name",
            "user_fullname"=>"au.user_fullname",
            "user_type"=>"au.user_type",
            "ud_name"=>"aud.ud_name",
            "user_status"=>"au.user_status",
        );

        if(isset($_GET['sortby'])) {
            $strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
        }
//        printa($_SESSION[admin_session_obj]);exit;
        if($_SESSION[admin_session_obj][user_data][mun_id] != "" && $_SESSION[admin_session_obj][user_data][mun_id] != "0"){
            $filter = "au.mun_id = {$_SESSION[admin_session_obj][user_data][mun_id]}";
        }elseif($_SESSION[admin_session_obj][user_data][prov_id] != "" && $_SESSION[admin_session_obj][user_data][prov_id] != "0"){
            $filter = "au.prov_id = {$_SESSION[admin_session_obj][user_data][prov_id]}";
        }elseif($_SESSION[admin_session_obj][user_data][rgn_id] != "" && $_SESSION[admin_session_obj][user_data][rgn_id] != "0"){
            $filter = "au.rgn_id = {$_SESSION[admin_session_obj][user_data][rgn_id]}";
        }else{
            $filter = "1 = 1";
        }

        $viewLink = "";
        $resetLink = "<a href=\"?statpos=manageuser&action=resetPassword&id=',au.user_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/new_ico.gif\" title=\"Reset Password\" hspace=\"2px\" border=0></a>";
        $editLink = "<a href=\"?statpos=manageuser&edit=',au.user_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
        $delLink = "<a href=\"?statpos=manageuser&delete=',au.user_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

        $sql =
            "select au.*,
             cr.region_name,
             cp.province_name,
             cm.municipal_name,
             CONCAT('$viewLink','$editLink','$delLink','$resetLink') as viewdata
		from app_users au
                left join comelec_region cr on cr.rgn_id = au.rgn_id
                left join comelec_province cp on cp.prov_id = au.prov_id
                left join comelec_municipal cm on cm.mun_id = au.mun_id
            where $filter $criteria
            $strOrderBy";

        $sqlcount = "select count(*) as mycount from app_users au $criteria";

        $arrFields = array(
            "region_name"=>"Region",
            "province_name"=>"Province",
            "municipal_name"=>"Municipal",
            "user_name"=>"User Name",
            "user_fullname"=>"Full Name",
            "user_type"=>"User Type",
            "user_status"=>"Status",
            "viewdata"=>"&nbsp;"
        );

        $arrAttribs = array(
            "viewdata"=>"width='80' align='center'"
        );

        $tblDisplayList = new clsTableList($this->conn);
        $tblDisplayList->arrFields = $arrFields;
        $tblDisplayList->paginator->linkPage = "?$queryStr";
        $tblDisplayList->sqlAll = $sql;
        $tblDisplayList->sqlCount = $sqlcount;

        return $tblDisplayList->getTableList($arrAttribs);
    }

    function getUserTypes($utype=null) {

        if($utype=='mu'){
            $sql = "select * from app_usertype where user_type_status=1 and user_type='volenc' or user_type='volval' order by user_type_ord";
        }else{
            $sql = "select * from app_usertype where user_type_status=1 order by user_type_ord";

        }
        $rsResult = $this->conn->Execute($sql);
        $arrData = array();
        while (!$rsResult->EOF) {
            $arrData[] = $rsResult->fields;
            $rsResult->MoveNext();
        }
        if (count($arrData)==0) return $arrData;
        return $arrData;
    }

    function getDepartment() {
        $sql = "select * from app_userdept order by ud_name";
        $rsResult = $this->conn->Execute($sql);
        $arrData = array();
        while (!$rsResult->EOF) {
            $arrData[] = $rsResult->fields;
            $rsResult->MoveNext();
        }
        if (count($arrData)==0) return $arrData;
        return $arrData;
    }

    function getProvince($q_="", $rgnid="") {
        $qry = $flds =  array();

        $flds[] = "prov_id";
        $flds[] = "province_name";


        if(!is_null($q_)) {
            $qry[] = "province_name like '%$q_%'";
            $qry[] = "rgn_id = $rgnid";
        }

        $criteria = count($qry) > 0 ? " where ".implode(" and ", $qry):"";
        $fields = implode(",", $flds);

        $sql = "select $fields from
                comelec_province
            $criteria limit 100";
        $rsResult = $this->conn->Execute($sql);
        $strData = "";
        while(!$rsResult->EOF) {
            $strData .= "|".$rsResult->fields['prov_id']."|".$rsResult->fields['province_name']."\n";
            $rsResult->MoveNext();
        }

        unset($flds);

        return $strData;
    }
    function getRegion($q_="") {
        $qry = $flds =  array();

        $flds[] = "rgn_id";
        $flds[] = "region_name";


        if(!is_null($q_)) {
            $qry[] = "region_name like '%$q_%'";
        }

        $criteria = count($qry) > 0 ? " where ".implode(" and ", $qry):"";
        $fields = implode(",", $flds);

        $sql = "select $fields from
                comelec_region
            $criteria limit 100";
        $rsResult = $this->conn->Execute($sql);
        $strData = "";
        while(!$rsResult->EOF) {
            $strData .= "|".$rsResult->fields['rgn_id']."|".$rsResult->fields['region_name']."\n";
            $rsResult->MoveNext();
        }

        unset($flds);

        return $strData;
    }
    function getMunicipal($q_="", $provid = "") {
        $qry = $flds =  array();

        $flds[] = "mun_id";
        $flds[] = "municipal_name";


        if(!is_null($q_)) {
            $qry[] = "municipal_name like '%$q_%'";
            $qry[] = "prov_id = $provid";
        }

        $criteria = count($qry) > 0 ? " where ".implode(" and ", $qry):"";
        $fields = implode(",", $flds);

        $sql = "select $fields from
                comelec_municipal
            $criteria limit 100";
        $rsResult = $this->conn->Execute($sql);
        $strData = "";
        while(!$rsResult->EOF) {
            $strData .= "|".$rsResult->fields['mun_id']."|".$rsResult->fields['municipal_name']."\n";
            $rsResult->MoveNext();
        }

        unset($flds);

        return $strData;
    }

    function generatePassword($length=6, $strength=8) {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '23456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%&(){}[]';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }

    function resetPassword($email="", $username="", $municipal="", $province="", $region="",$pwd="") {
        if($pwd == "") {
            $password = $this->generatePassword();
            $hashedpwd = md5($password);
        }else {
            $password = $pwd;
        }
        $userArr = explode("@", $username);
        $username = $userArr[0];
        unset($userArr);
        $date = date('Y-m-d');
        $sql = "update app_users set user_password = '{$hashedpwd}' where user_id = {$_GET['edit']}";
        $this->conn->Execute($sql);
        //        require("class.phpmailer.php");
        $mailer = new PHPMailer();
        $mailer->IsSMTP();
        $mailer->Host = 'localhost';
        //        $mailer->SMTPAuth = false;
        //        $mailer->Username = 'ohmel@localhost';  // Change this to your gmail adress
        //        $mailer->Password = 'test';  // Change this to your gmail password
        $mailer->From = 'noreply@namfrel.com.ph';  // This HAVE TO be your gmail adress
        $mailer->FromName = 'Namfrel Systems'; // This is the from name in the email, you can put anything you like here
        $mailer->Body = "
        DEAR {$username},
        Your password has been reset as of {$date}. Your new account details are as follows: \n
        \n
        Username: {$email}
        Password: {$password}      \n
        \n
        Municipal: {$municipal} \n
        Provice: {$province} \n
        Region: {$region} \n
        \n
        To login, please visit this page: http://www.xinapse.net/namfrel2010 \n
        \n
        All the best,\n
        NAMFREL Systems Team
            ";
        $mailer->Subject = 'Password Reset Information';
        $mailer->AddAddress($email);  // This is where you put the email adress of the person you want to mail
        $mailer->AddBCC('jrloja@xinapse.net', 'Yna Loja');
        $mailer->AddBCC('mgdomingo@xinapse.net', 'Minco Domingo');
        $mailer->AddBCC('namfrel2010@gmail.com', 'Namfrel Systems Team');
        if(!$mailer->Send()) {
            $_SESSION['eMsg']="Mailer Error: " . $mailer->ErrorInfo;
        }
        else {
            $_SESSION['eMsg']="Successfully Reset Password.";
        }
    }

}

?>
