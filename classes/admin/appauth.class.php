<?php

class AppAuth {
	
	var $userID;
	var $userType;
	var $userName;
	var $conn;
	var $Data;

	var $error;
	
	function AppAuth(&$conn) {
		$this->conn = $conn;
        $this->sessionID = $_COOKIE[session_name()];
        $this->authTime = dDate::getDate("Y-m-d H:i:s",dDate::getTime());
	}

	/**
	 * @param string $user
	 * @param string $pass
	 * @return int the user's member_id
	 * @static
	 */
	function doAuth($user,$pass,$captcha_ = false) {
//		$this->conn->debug = true;
		/*$sql = "SELECT au.user_id, au.user_name, au.user_password, au.user_type, au.user_fullname, aud.ud_name, aut.user_type_name 
		FROM app_users au 
		inner join app_userdept aud on au.ud_id = aud.ud_id 
		inner join app_usertype aut on au.user_type = aut.user_type
		WHERE au.user_name=? AND au.user_password=? LIMIT 1";*/
		
$sql = "select  f.user_id, f.user_name, f.user_password, f.user_type, f.user_fullname, aut.user_type_name
                , coalesce(f.user_lastsessionid,'".$this->sessionID."') as user_lastsessionid
                ,f.user_email, f.rgn_id, f.prov_id, f.mun_id
                ,coalesce(f.user_lastlogin,NOW()) as user_lastlogin
                from  app_users f
                inner join app_usertype aut on f.user_type = aut.user_type
                where user_name=? AND user_password=? and $captcha_ and f.user_status = 1
                group by f.user_id";
		$rs = $this->conn->Execute($sql, array($user,$pass));
		if ( $rs === false || $rs->EOF ) {
			$this->error = 404;			
			return false;
		}
		
		$this->userID = $rs->fields['user_id'];
		$this->userType = $rs->fields['user_type'];
		$this->userName = $rs->fields['user_name'];

		$this->Data = $rs->fields;
		
		return true;
	}
	
	function getModules($dbconn_ = null,$arrMenu_ = array(), $isChild_ = false, $level = 0){
		if(count($arrMenu_) > 0){
			$arrCtr = 0;
			foreach ($arrMenu_ as $key => $value) {
				$sql = "select * from app_modules appmod 
				inner join app_userstypeaccess auta on appmod.mnu_id = auta.mnu_id 
				inner join app_users au on au.ud_id = auta.ud_id
				where appmod.mnu_status=1 and appmod.mnu_parent=? and auta.user_type=? and au.user_id=? 
				order by appmod.mnu_ord asc";
				$rsResult = $dbconn_->Execute($sql,array($value['mnu_id'],$_SESSION['admin_session_obj']['user_type'],$_SESSION['admin_session_obj']['user_id']));
				
				if($isChild_ && $level > 0)
				$mnuData .= ",";
				
				$mnuIcon = empty($value['mnu_icon'])?"null":"'$value[mnu_icon]'";
				$mnuLink = empty($value['mnu_link'])?"null":"'$value[mnu_link]'";
	
				$mnuData .= "[$mnuIcon, '$value[mnu_name]', $mnuLink, null, 'P$value[mnu_id]'";
				
				$arrMenuIn = array();
				while(!$rsResult->EOF){
					$arrMenuIn[] = $rsResult->fields;
					$rsResult->MoveNext();
				}
				if(count($arrMenuIn) > 0){
					$mnuData .= $this->getModules($dbconn_,$arrMenuIn,true,$level + 1);
				}
				$mnuData .= "]";
				if(!$isChild_ && (count($arrMenu_)-1) > $arrCtr++)
				$mnuData .= ",\n";
			}
			
		}
		return "$mnuData";
	}

    function updateLastUserLogin($paramDBName_ = ""){
        $dbName =  (strlen($paramDBName_)>0)?"$paramDBName_.":SYSCONFIG_DBNAME.".";

        // before update must clear the current session
        $user_lastsessionid = AppUser::getData("user_lastsessionid");
        if($this->sessionID != $user_lastsessionid){
            $tSessionSavePath = session_save_path();
            if(empty($tSessionSavePath)) {$tSessionSavePath = "/tmp";}
            
            $_SESSION['testing'] = $tSessionFName = $tSessionSavePath."/sess_$user_lastsessionid";
            IF(SYSCONFIG_USER_MULTILOGIN)
            @unlink($tSessionFName);
        }

        $flds = array();
        $flds[] = "user_lastlogin='".$this->authTime."'";
        $flds[] = "user_lastsessionid='".$this->sessionID."'";
        $fields = implode(",", $flds);

		$sql = "update {$dbName}app_users set $fields where user_id=".$this->userID;

		$rsResult = $this->conn->Execute($sql);
    }

}

?>