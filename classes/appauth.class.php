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
	}
	
	/**
	 * @param string $user
	 * @param string $pass
	 * @return int the user's member_id
	 * @static
	 */
	function doAuth($user,$pass) {
//		$sql = "SELECT user_id, user_name, user_password, user_type, user_fullname 
//						FROM app_users WHERE user_name=? AND user_password=? LIMIT 1";
		$sql = "select  f.user_id, f.user_name, f.user_password, f.user_type, f.user_fullname, a.region_id, a.region_name, b.province_id, b.province_name, 
						c.municipal_id, c.municipal_name, d.barangay_id, d.barangay_name, e.pollingplaces_id, e.pollingplaces_name 
					from comelec_region a 
					inner join comelec_province b on a.region_id = b.region_id 
					inner join comelec_municipal c on a.region_id = c.region_id and b.province_id = c.province_id 
					inner join comelec_barangay d on c.id = d.municipal_id 
					inner join comelec_pollingplaces e on d.barangay_id = e.barangay_id 
					right join app_users f on e.pollingplaces_id = f.pollingplaces_id 
					where user_name=? AND user_password=?
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
				$sql = "select * from app_modules where mnu_parent=? order by mnu_ord asc";
				$rsResult = $dbconn_->Execute($sql,array($value['mnu_id']));
				
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
	
}

?>