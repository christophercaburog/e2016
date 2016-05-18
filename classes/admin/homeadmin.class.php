<?php
/**
 * Initial Declaration
 */

$arrPrecinctStatus = array(
   /*10 => "Open"
  ,*/20 => "Processing"
  ,25 => "For Verification"
  ,30 => "Pending Error"
  /*,40 => "Verified"*/
);

/**
 * Class Module
 *
 * @author  Arnold P. Orbista
 * 
 */
class clsHomeAdmin{
	
	var $conn;
	var $fieldMap;
	var $Data;
	
	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsHomeAdmin object
	 */
	function clsHomeAdmin($dbconn_ = null){
		$this->conn =& $dbconn_;
		$this->fieldMap = array(
		"mnu_name" => "mnu_name",
		"mnu_desc" => "mnu_desc",
		"mnu_parent" => "mnu_parent",
		"mnu_icon" => "mnu_icon",
		"mnu_ord" => "mnu_ord",
		"mnu_status" => "mnu_status",
		"mnu_link_info" => "mnu_link_info"
		);
	}
	
	/**
	 * Get the records from the database
	 *
	 * @param string $id_
	 * @return array
	 */
	function dbFetch($id_ = ""){
		$sql = "";
		$rsResult = $this->conn->Execute($sql,array($id_));
		if(!$rsResult->EOF){
			return $rsResult->fields;
		}
	}
	/**
	 * Populate array parameters to Data Variable
	 *
	 * @param array $pData_
	 * @return bool
	 */
	function doPopulateData($pData_ = array()){
		if(count($pData_)>0){
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
	function doValidateData($pData_ = array()){
		$isValid = true;
		
//		$isValid = false;
		
		return $isValid;
	}
	
	/**
	 * Save New
	 *
	 */
	function doSaveAdd(){
		$flds = array();
		foreach ($this->Data as $keyData => $valData) {
			$flds[] = "$keyData='$valData'";
		}
		$fields = implode(", ",$flds);
		
		$sql = "insert into app_modules set $fields";
		$this->conn->Execute($sql);
		
		$_SESSION['eMsg']="Successfully Added.";
	}
	
	/**
	 * Save Update
	 *
	 */
	function doSaveEdit(){
		$id = $_GET['edit'];
		
		$flds = array();
		foreach ($this->Data as $keyData => $valData) {
			$flds[] = "$keyData='$valData'";
		}
		$fields = implode(", ",$flds);
		
		$sql = "update app_modules set $fields where mnu_id=$id";
		$this->conn->Execute($sql);
		$_SESSION['eMsg']="Successfully Updated.";
	}
	
	/**
	 * Delete Record
	 *
	 * @param string $id_
	 */
	function doDelete($id_ = ""){
		$sql = "delete from app_modules where mnu_id=?";
		$this->conn->Execute($sql,array($id_));
		$_SESSION['eMsg']="Successfully Deleted.";
	}
	
	/**
	 * Get all the Table Listings
	 *
	 * @return array
	 */
	function getTableList( $user_id_ = null, $rgn_id_ = null){
		// Process the query string and exclude querystring named "p"
		if (!empty($_SERVER['QUERY_STRING'])) {
			$qrystr = explode("&",$_SERVER['QUERY_STRING']);
			foreach ($qrystr as $value) {
				$qstr = explode("=",$value);
				if ($qstr[0]!="p" && $qstr[0]!="tab") {
					$arrQryStr[] = implode("=",$qstr);
				}
			}
			$aQryStr = $arrQryStr;
			$aQryStr[] = "p=@@&tab=1";
			$queryStr = implode("&",$aQryStr);
		}else{
            $queryStr = "p=@@&tab=1";
        }

		//bby: search module
		$qry = array();
		if (isset($_REQUEST['search_field'])) {

			// lets check if the search field has a value
			if (strlen($_REQUEST['search_field'])>0) {
				// lets assign the request value in a variable
				$search_field = $_REQUEST['search_field'];

				// create a custom criteria in an array
				$qry[] = "(prec.precincts_number like '%$search_field%'
                          or rgn.region_name like '%$search_field%'
                          or prov.province_name like '%$search_field%'
                          or mun.municipal_name like '%$search_field%'
                          or brgy.barangay_name like '%$search_field%')
                        ";

			}
		}

        $qry[] = "prec.precincts_status = 10";
        if(!is_null($rgn_id_)){
            $qry[] = "rgn.rgn_id = '$rgn_id_'";
        }
        $urgn_id = AppUser::getData("rgn_id");
        $uprov_id = AppUser::getData("prov_id");
        $umun_id = AppUser::getData("mun_id");

        if(!empty($umun_id)){
            $qry[] = "mun.mun_id = '$umun_id'";
        }elseif(!empty($uprov_id)){
            $qry[] = "prov.prov_id = '$uprov_id'";
        }elseif(!empty($urgn_id)){
            $qry[] = "rgn.rgn_id = '$urgn_id'";
        }

        // added region, province, municipal filter
        if(!empty($_GET['rgn_id'])){
            $qry[] = "rgn.rgn_id = '{$_GET['rgn_id']}'";
        }elseif(!empty($_GET['rgn'])){   //region
            $qry[]="rgn.region_name LIKE '%{$_GET['rgn']}%'";
        }
        if(!empty($_GET['prn_id'])){
            $qry[] = "prov.prov_id = '{$_GET['prn_id']}'";
        }elseif(!empty($_GET['prn'])){   //province
            $qry[]="prov.province_name LIKE '%{$_GET['prn']}%'";
        }
        if(!empty($_GET['mun_id'])){
            $qry[] = "mun.mun_id = '{$_GET['mun_id']}'";
        }elseif(!empty($_GET['mun'])){   //municipal
            $qry[]="mun.municipal_name LIKE '%{$_GET['mun']}%'";
        }
        if(!empty($_GET['brg_id'])){
            $qry[] = "brgy.barangay_id = '{$_GET['brg_id']}'";
        }elseif(!empty($_GET['brg'])){   //barangay
            $qry[]="brgy.barangay_name LIKE '%{$_GET['brg']}%'";
        }
        if(!empty($_GET['ppl'])){   //polling place
            $qry[]="prec.precincts_polling_place LIKE '%{$_GET['ppl']}%'";
        }
        if(!empty($_GET['clu'])){   //clustered precincts
            $qry[]="prec.precincts_number LIKE '%{$_GET['clu']}%'";
        }

		// put all query array into one criteria string
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

		// Sort field mapping
		$arrSortBy = array(
		 "region_name"=>"rgn.region_name"
		,"province_name"=>"prov.province_name"
		,"municipal_name"=>"mun.municipal_name"
		,"barangay_name"=>"brgy.barangay_name"
		,"precincts_polling_place"=>"prec.precincts_polling_place"
		,"precincts_cgroupno"=>"prec.precincts_cgroupno"
		,"precincts_number"=>"prec.precincts_number"
		,"precincts_numberofvoters"=>"prec.precincts_numberofvoters"
		);

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}

		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
        $securityKey = "53cr3t";
		$viewLink = "";

        if(AppUser::getData("user_type") == "volenc" || AppUser::getData("user_type") == "supvolenc"){
    		$editLink = "<a href=\"encoder.php?r=',sha1(concat(prec.precints_id,'$securityKey',rgn.rgn_id,prov.prov_id)),'&statpos=erentry&action=erp&e=',prec.precints_id,'&g=',rgn.rgn_id,'&v=',prov.prov_id,' class=\"ui-state-highlight\" title=\"Enter Votes\" \">Enter Votes</a>";
        }
		//$delLink = "<a href=\"?statpos=precinct&delete=',am.precints_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

        $flds = array();
        $flds[] = "concat('<span title=\"',(case prec.precincts_qastatus when 5 then 'Precinct unverified' else 'Precinct Verified' end),'\" class=\"ui-icon ',(case prec.precincts_qastatus when 5 then 'ui-icon-help' else 'ui-icon-check' end),' floatLeft theme-cursor-pointer\" ></span><span title=\"',prec.precincts_number,'\" class=\"hide-overflow\">',coalesce(prec.precincts_number,''),'</span>') as precincts_number";
        $flds[] = "prec.precincts_numberofvoters";
        $flds[] = "concat('<span title=\"',prec.precincts_polling_place,'\" class=\"ui-icon ui-icon-info floatLeft theme-cursor-pointer\" ></span><span title=\"',prec.precincts_polling_place,'\" class=\"hide-overflow\">',coalesce(prec.precincts_polling_place,''),'</span>') as precincts_polling_place";
        $flds[] = "prec.precincts_cgroupno";
        $flds[] = "brgy.barangay_name";
        $flds[] = "concat('<span title=\"',prov.province_name,'\" class=\"ui-icon ui-icon-info floatLeft theme-cursor-pointer\" ></span><span title=\"',prov.province_name,'\" class=\"hide-overflow\">',coalesce(prov.province_name,''),'</span>') as province_name";
        $flds[] = "mun.municipal_name";
        $flds[] = "rgn.region_name";
        $flds[] = "CONCAT('$viewLink','$editLink','$delLink') as viewdata";
        $fields = implode(",",$flds);

		// SqlAll Query
		$sql = "select  $fields
						from comelec_precincts prec
                        left join comelec_barangay brgy on brgy.barangay_id = prec.barangay_id
                        left join comelec_municipal mun on mun.mun_id = prec.mun_id
                        /*left join comelec_pollingplaces poll on poll.pollingplaces_id = prec.pollingplaces_id*/
                        left join comelec_province prov on prov.prov_id = mun.prov_id
                        left join comelec_region rgn on rgn.rgn_id = prov.rgn_id
						$criteria
						$strOrderBy";

		// Sql query for paginator list
		// @note no need to use this. it replaced by sql function "FOUND_ROWS()"
		//$sqlcount = "select count(*) as mycount from app_modules $criteria";

		// Field and Table Header Mapping
		$arrFields = array(
		 "region_name"=>"Region"
		,"province_name"=>"Province"
		,"municipal_name"=>"Municipal"
		,"barangay_name"=>"Barangay"
		,"precincts_polling_place"=>"Polling Place"
		,"precincts_cgroupno"=>"No."
		,"precincts_number"=>"Clustered Precinct"
		,"precincts_numberofvoters"=>"RV"
		,"viewdata"=>"&nbsp;"
		);

		// Column (table data) User Defined Attributes
		$arrAttribs = array(
		"precincts_polling_place"=>" width='250'",
		"precincts_cgroupno"=>" align='right'",
		"precincts_numberofvoters"=>" align='right' width='50'",
		"precints_number"=>" align='right'",
		"viewdata"=>"width='80' align='center'"
		);

		// Process the Table List
		$tblDisplayList = new clsTableList($this->conn);
		$tblDisplayList->arrFields = $arrFields;
		$tblDisplayList->paginator->linkPage = "?$queryStr";
		$tblDisplayList->sqlAll = $sql;
		$tblDisplayList->sqlCount = $sqlcount;

		return $tblDisplayList->getTableList($arrAttribs);
	}

	/**
	 * Get all the Table Listings for On Process Status
	 *
	 * @return array
	 */
	function getOnProcessList($prec_status_ = 20, $user_id_ = null, $rgn_id_ = null){
		// Process the query string and exclude querystring named "p"
		if (!empty($_SERVER['QUERY_STRING'])) {
			$qrystr = explode("&",$_SERVER['QUERY_STRING']);
			foreach ($qrystr as $value) {
				$qstr = explode("=",$value);
				if ($qstr[0]!="p2" && $qstr[0]!="tab" ) {
					$arrQryStr[] = implode("=",$qstr);
				}
			}
			$aQryStr = $arrQryStr;
			$aQryStr[] = "p2=@@&tab=2";
			$queryStr = implode("&",$aQryStr);
		}else{
            $queryStr = "p2=@@&tab=2";
        }

		//bby: search module
		$qry = array();
        if (isset($_REQUEST['search_field2'])) {

            // lets check if the search field has a value
            if (strlen($_REQUEST['search_field2'])>0) {
                // lets assign the request value in a variable
                $search_field = $_REQUEST['search_field2'];

                // create a custom criteria in an array
                $qry[] = "(prec.precincts_number like '%$search_field%'
                          or mun.municipal_name like '%$search_field%'
                          or brgy.barangay_name like '%$search_field%')
                        ";

            }
        }
        

        if($prec_status_ == 40){
            $qry[] = "prec.precincts_status  = '$prec_status_'";
        }else{
            $qry[] = "prec.precincts_status between $prec_status_ and 30";
        }
        
        if(!is_null($rgn_id_)){
            $qry[] = "rgn.rgn_id = '$rgn_id_'";
        }


        if(AppUser::getData("user_type") == "volenc" || AppUser::getData("user_type") == "supvolenc"){
            $qry[] = "prec.user_id = '".AppUser::getData("user_id")."'";
        }

        // added region, province, municipal filter
        if(!empty($_GET['rgn_id2'])){
            $qry[] = "rgn.rgn_id = '{$_GET['rgn_id2']}'";
        }elseif(!empty($_GET['rgn2'])){   //region
            $qry[]="rgn.region_name LIKE '%{$_GET['rgn2']}%'";
        }
        if(!empty($_GET['prn_id2'])){
            $qry[] = "prov.prov_id = '{$_GET['prn_id2']}'";
        }elseif(!empty($_GET['prn2'])){   //province
            $qry[]="prov.province_name LIKE '%{$_GET['prn2']}%'";
        }
        if(!empty($_GET['mun_id2'])){
            $qry[] = "mun.mun_id = '{$_GET['mun_id2']}'";
        }elseif(!empty($_GET['mun2'])){   //municipal
            $qry[]="mun.municipal_name LIKE '%{$_GET['mun2']}%'";
        }
        if(!empty($_GET['brg_id2'])){
            $qry[] = "brgy.barangay_id = '{$_GET['brg_id2']}'";
        }elseif(!empty($_GET['brg2'])){   //barangay
            $qry[]="brgy.barangay_name LIKE '%{$_GET['brg2']}%'";
        }
        if(!empty($_GET['ppl2'])){   //polling place
            $qry[]="prec.precincts_polling_place LIKE '%{$_GET['ppl2']}%'";
        }
        if(!empty($_GET['clu2'])){   //clustered precincts
            $qry[]="prec.precincts_number LIKE '%{$_GET['clu2']}%'";
        }
        if(!empty($_GET['pcos'])){   //clustered precincts
            $qry[]="prec.precincts_encoded_pcosid = '{$_GET['pcos']}'";
        }

        if(!empty($_GET['pstat'])){   //status
            $qry[]="prec.precincts_status = '{$_GET['pstat']}'";
        }

		// put all query array into one criteria string
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

		// Sort field mapping
		$arrSortBy = array(
		 "region_name"=>"rgn.region_name"
		,"province_name"=>"prov.province_name"
		,"municipal_name"=>"mun.municipal_name"
		,"barangay_name"=>"brgy.barangay_name"
		,"precincts_polling_place"=>"prec.precincts_polling_place"
		,"precincts_cgroupno"=>"prec.precincts_cgroupno"
		,"precincts_encoded_pcosid"=>"prec.precincts_encoded_pcosid"
		,"precincts_number"=>"prec.precincts_number"
		,"precincts_numberofvoters"=>"prec.precincts_numberofvoters"
		,"precincts_encoded_actualvotedvoters"=>"prec.precincts_encoded_actualvotedvoters"
		,"precincts_status"=>"precincts_status"
		);

		if(isset($_GET['sortby2'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby2']]." ".$_GET['sortof2'].", prec.precincts_updatewhen desc";
		}else{
            $strOrderBy = " order by prec.precincts_updatewhen desc";
        }

        $isVolEnc = (AppUser::getData("user_type")=="volenc")?"true":"false";
        $isVolVal = (AppUser::getData("user_type")=="volval" || AppUser::getData("user_type")=="svolval")?"true":"false";
		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
        $securityKey = "53cr3t";
		$viewLink = "";
		$editLink = "<a href=\"encoder.php?r=',sha1(concat(prec.precints_id,'$securityKey',rgn.rgn_id,prov.prov_id)),'&statpos=erentry&action=er&e=',prec.precints_id,'&g=',rgn.rgn_id,'&v=',prov.prov_id,'\">Open </a>";
		$viewLink = "<a href=\"encoder.php?r=',sha1(concat(prec.precints_id,'$securityKey',rgn.rgn_id,prov.prov_id)),'&statpos=erentry&action=viewER&e=',prec.precints_id,'&g=',rgn.rgn_id,'&v=',prov.prov_id,'\">View </a>";
		$approveLink = "<input type=\"checkbox\" class=\"chksel\" id=\"ck\" name=\"chk[',prec.precints_id,']\" >";
		//$delLink = "<a href=\"?statpos=precinct&delete=',am.precints_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

        $flds = array();
        $flds[] = "prec.precincts_numberofvoters";
        $flds[] = "concat('<span title=\"',prec.precincts_polling_place,'\" class=\"ui-icon ui-icon-info floatLeft theme-cursor-pointer\" ></span><span title=\"',prec.precincts_polling_place,'\" class=\"hide-overflow\">',coalesce(prec.precincts_polling_place,''),'</span>') as precincts_polling_place";
        $flds[] = "prec.precincts_cgroupno";
        $flds[] = "prec.precincts_encoded_actualvotedvoters";
        $flds[] = "brgy.barangay_name";
        $flds[] = "concat('<span title=\"',prov.province_name,'\" class=\"ui-icon ui-icon-info floatLeft theme-cursor-pointer\" ></span><span title=\"',prov.province_name,'\" class=\"hide-overflow\">',coalesce(prov.province_name,''),'</span>') as province_name";
        $flds[] = "concat('<span title=\"',(case prec.precincts_qastatus when 5 then 'Precinct unverified' else 'Precinct Verified' end),'\" class=\"ui-icon ',(case prec.precincts_qastatus when 5 then 'ui-icon-help' else 'ui-icon-check' end),' floatLeft theme-cursor-pointer\" ></span><span title=\"',prec.precincts_number,'\" class=\"hide-overflow\">',coalesce(prec.precincts_number,''),'</span>') as precincts_number";
        $flds[] = "mun.municipal_name";
        $flds[] = "rgn.region_name";
        $flds[] = "prec.precincts_encoded_pcosid";
        $flds[] = "case prec.precincts_status when 20 then 'Processing' when 25 then 'For Verification' when 30 then 'Pending Error' else 'Verified' end as precincts_status";
        $flds[] = "case prec.precincts_status when 20 then if($isVolEnc,CONCAT('$editLink'),'') when 25 then if($isVolVal,CONCAT('$editLink'),'') when 30 then if($isVolVal,CONCAT('$editLink'),'') else CONCAT('$editLink') end as viewdata";
        $flds[] = "case prec.precincts_status when 20 then CONCAT('') when 25 then if($isVolVal,CONCAT('$approveLink'),'') when 30 then CONCAT('') else CONCAT('') end as appdata";
        $flds[] = "concat('<span title=\"',au.user_name,' ',prec.precincts_updatewhen,'\" class=\"ui-icon ui-icon-person floatLeft theme-cursor-pointer\" ></span><span title=\"',prec.precincts_updatewhen,'\" class=\"hide-overflow\">','','</span>') as updatewho";
        $flds[] = "CONCAT('$viewLink') as viewLink";
        //$flds[] = "CONCAT('$viewLink','$editLink','$delLink') as viewdata";
        $fields = implode(",",$flds);

		// SqlAll Query
		$sql = "select  $fields
						from comelec_precincts prec
                        left join comelec_barangay brgy on brgy.barangay_id = prec.barangay_id
                        left join comelec_municipal mun on mun.mun_id = prec.mun_id
                        /*left join comelec_pollingplaces poll on poll.pollingplaces_id = prec.pollingplaces_id*/
                        left join comelec_province prov on prov.prov_id = mun.prov_id
                        left join comelec_region rgn on rgn.rgn_id = prov.rgn_id
                        left join app_users au on au.user_id=prec.user_id
						$criteria
						$strOrderBy";

		// Sql query for paginator list
		// @note no need to use this. it replaced by sql function "FOUND_ROWS()"
		//$sqlcount = "select count(*) as mycount from app_modules $criteria";

		// Field and Table Header Mapping
		$arrFields = array(
		 "region_name"=>"Region"
		,"province_name"=>"Province"
		,"municipal_name"=>"Municipal"
		,"barangay_name"=>"Barangay"
		,"precincts_polling_place"=>"Polling Place"
		,"precincts_encoded_pcosid"=>"PCOS ID"
		,"precincts_cgroupno"=>"No."
		,"precincts_number"=>"Clustered Precinct"
		,"precincts_numberofvoters"=>"RV"
		,"precincts_encoded_actualvotedvoters"=>"VV"
		,"precincts_status"=>"Status"
		,"updatewho"=>"&nbsp;"
		,"viewdata"=>"&nbsp;"
		,"viewLink"=>"&nbsp;"
        ,"appdata"=>"&nbsp;"
		);

		// Column (table data) User Defined Attributes
		$arrAttribs = array(
		"precincts_polling_place"=>" width='250'",
		"precincts_cgroupno"=>" align='right'",
		"precincts_numberofvoters"=>" align='right'",
		"precincts_encoded_actualvotedvoters"=>" align='right'",
		"precints_number"=>" align='right'",
		"updatewho"=>"width='10' align='center'",
		"viewdata"=>"width='40' align='center'",
		"appdata"=>"width='15' align='center'",
		"viewLink"=>"width='40' align='center'"
		);

		// Process the Table List
		$tblDisplayList = new clsTableList2($this->conn);
		$tblDisplayList->arrFields = $arrFields;
		$tblDisplayList->paginator->linkPage = "?$queryStr";
		$tblDisplayList->sqlAll = $sql;
		$tblDisplayList->sqlCount = $sqlcount;

		return $tblDisplayList->getTableList2($arrAttribs);
	}

	/**
	 * Get all the Table Listings for On Process Status
	 *
	 * @return array
	 */
	function getOnVerifiedList($prec_status_ = 20, $user_id_ = null, $rgn_id_ = null){
		// Process the query string and exclude querystring named "p"
		if (!empty($_SERVER['QUERY_STRING'])) {
			$qrystr = explode("&",$_SERVER['QUERY_STRING']);
			foreach ($qrystr as $value) {
				$qstr = explode("=",$value);
				if ($qstr[0]!="p3" && $qstr[0]!="tab") {
					$arrQryStr[] = implode("=",$qstr);
				}
			}
			$aQryStr = $arrQryStr;
			$aQryStr[] = "p3=@@&tab=3";
			$queryStr = implode("&",$aQryStr);
		}else{
            $queryStr = "p3=@@&tab=3";
        }

		//bby: search module
		$qry = array();
        if (isset($_REQUEST['search_field3'])) {

            // lets check if the search field has a value
            if (strlen($_REQUEST['search_field3'])>0) {
                // lets assign the request value in a variable
                $search_field = $_REQUEST['search_field3'];

                // create a custom criteria in an array
                $qry[] = "(prec.precincts_number like '%$search_field%'
                          or mun.municipal_name like '%$search_field%'
                          or brgy.barangay_name like '%$search_field%')
                        ";

            }
        }
        

        if($prec_status_ == 40){
            $qry[] = "prec.precincts_status  = '$prec_status_'";
        }else{
            $qry[] = "prec.precincts_status between $prec_status_ and 30";
        }

        if(!is_null($rgn_id_)){
            $qry[] = "rgn.rgn_id = '$rgn_id_'";
        }

        if(AppUser::getData("user_type") == "volenc" || AppUser::getData("user_type") == "supvolenc"){
            $qry[] = "prec.user_id = '".AppUser::getData("user_id")."'";
        }

        // added region, province, municipal filter
        if(!empty($_GET['rgn_id3'])){
            $qry[] = "rgn.rgn_id = '{$_GET['rgn_id3']}'";
        }elseif(!empty($_GET['rgn3'])){   //region
            $qry[]="rgn.region_name LIKE '%{$_GET['rgn3']}%'";
        }
        if(!empty($_GET['prn_id3'])){
            $qry[] = "prov.prov_id = '{$_GET['prn_id3']}'";
        }elseif(!empty($_GET['prn3'])){   //province
            $qry[]="prov.province_name LIKE '%{$_GET['prn3']}%'";
        }
        if(!empty($_GET['mun_id3'])){
            $qry[] = "mun.mun_id = '{$_GET['mun_id3']}'";
        }elseif(!empty($_GET['mun3'])){   //municipal
            $qry[]="mun.municipal_name LIKE '%{$_GET['mun3']}%'";
        }
        if(!empty($_GET['brg_id3'])){
            $qry[] = "brgy.barangay_id = '{$_GET['brg_id3']}'";
        }elseif(!empty($_GET['brg3'])){   //barangay
            $qry[]="brgy.barangay_name LIKE '%{$_GET['brg3']}%'";
        }
        if(!empty($_GET['ppl3'])){   //polling place
            $qry[]="prec.precincts_polling_place LIKE '%{$_GET['ppl3']}%'";
        }
        if(!empty($_GET['clu3'])){   //clustered precincts
            $qry[]="prec.precincts_number LIKE '%{$_GET['clu3']}%'";
        }

		// put all query array into one criteria string
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

		// Sort field mapping
		$arrSortBy = array(
		 "region_name"=>"rgn.region_name"
		,"province_name"=>"prov.province_name"
		,"municipal_name"=>"mun.municipal_name"
		,"barangay_name"=>"brgy.barangay_name"
		,"precincts_polling_place"=>"prec.precincts_polling_place"
		,"precincts_cgroupno"=>"prec.precincts_cgroupno"
		,"precincts_encoded_pcosid"=>"prec.precincts_encoded_pcosid"
		,"precincts_encoded_actualvotedvoters"=>"prec.precincts_encoded_actualvotedvoters"
		,"precincts_number"=>"prec.precincts_number"
		,"precincts_numberofvoters"=>"prec.precincts_numberofvoters"
		,"precincts_status"=>"precincts_status"
		);

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'].", prec.precincts_updatewhen desc";
		}else{
            $strOrderBy = " order by prec.precincts_updatewhen desc";
        }

        $isVolEnc = (AppUser::getData("user_type")=="volenc")?"true":"false";
        $isVolVal = (AppUser::getData("user_type")=="volval")?"true":"false";
		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
        $securityKey = "53cr3t";
		$viewLink = "";
		$editLink = "<a href=\"encoder.php?r=',sha1(concat(prec.precints_id,'$securityKey',rgn.rgn_id,prov.prov_id)),'&statpos=erentry&action=er&e=',prec.precints_id,'&g=',rgn.rgn_id,'&v=',prov.prov_id,'\">Open Votes</a>";
        $viewLink = "<a href=\"encoder.php?r=',sha1(concat(prec.precints_id,'$securityKey',rgn.rgn_id,prov.prov_id)),'&statpos=erentry&action=viewER&e=',prec.precints_id,'&g=',rgn.rgn_id,'&v=',prov.prov_id,'\">View</a>";
		//$delLink = "<a href=\"?statpos=precinct&delete=',am.precints_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

        $flds = array();
        $flds[] = "prec.precincts_numberofvoters";
        $flds[] = "concat('<span title=\"',prec.precincts_polling_place,'\" class=\"ui-icon ui-icon-info floatLeft theme-cursor-pointer\" ></span><span title=\"',prec.precincts_polling_place,'\" class=\"hide-overflow\">',coalesce(prec.precincts_polling_place,''),'</span>') as precincts_polling_place";
        $flds[] = "prec.precincts_cgroupno";
        $flds[] = "prec.precincts_encoded_actualvotedvoters";
        $flds[] = "brgy.barangay_name";
        $flds[] = "concat('<span title=\"',prov.province_name,'\" class=\"ui-icon ui-icon-info floatLeft theme-cursor-pointer\" ></span><span title=\"',prov.province_name,'\" class=\"hide-overflow\">',coalesce(prov.province_name,''),'</span>') as province_name";
        $flds[] = "concat('<span title=\"',(case prec.precincts_qastatus when 5 then 'Precinct unverified' else 'Precinct Verified' end),'\" class=\"ui-icon ',(case prec.precincts_qastatus when 5 then 'ui-icon-help' else 'ui-icon-check' end),' floatLeft theme-cursor-pointer\" ></span><span title=\"',prec.precincts_number,'\" class=\"hide-overflow\">',coalesce(prec.precincts_number,''),'</span>') as precincts_number";
        $flds[] = "mun.municipal_name";
        $flds[] = "rgn.region_name";
        $flds[] = "prec.precincts_encoded_pcosid";
        $flds[] = "case prec.precincts_status when 20 then 'Processing' when 25 then 'For Verification' when 30 then 'Pending Error' else 'Verified' end as precincts_status";
        $flds[] = "case prec.precincts_status when 20 then if($isVolEnc,CONCAT('$editLink'),'') when 25 then if($isVolVal,CONCAT('$editLink'),'') when 30 then if($isVolVal,CONCAT('$editLink'),'') else CONCAT('$viewLink') end as viewdata";
        $flds[] = "concat('<span title=\"',au.user_name,' ',prec.precincts_updatewhen,'\" class=\"ui-icon ui-icon-person floatLeft theme-cursor-pointer\" ></span>','','</span>') as updatewho";
        //$flds[] = "CONCAT('$viewLink','$editLink','$delLink') as viewdata";
        $fields = implode(",",$flds);

		// SqlAll Query
		$sql = "select  $fields
						from comelec_precincts prec
                        left join comelec_barangay brgy on brgy.barangay_id = prec.barangay_id
                        left join comelec_municipal mun on mun.mun_id = prec.mun_id
                        /*left join comelec_pollingplaces poll on poll.pollingplaces_id = prec.pollingplaces_id*/
                        left join comelec_province prov on prov.prov_id = mun.prov_id
                        left join comelec_region rgn on rgn.rgn_id = prov.rgn_id
                        left join app_users au on au.user_id=prec.precincts_updatewho
						$criteria
						$strOrderBy";

		// Sql query for paginator list
		// @note no need to use this. it replaced by sql function "FOUND_ROWS()"
		//$sqlcount = "select count(*) as mycount from app_modules $criteria";

		// Field and Table Header Mapping
		$arrFields = array(
		 "region_name"=>"Region"
		,"province_name"=>"Province"
		,"municipal_name"=>"Municipal"
		,"barangay_name"=>"Barangay"
		,"precincts_polling_place"=>"Polling Place"
		,"precincts_encoded_pcosid"=>"PCOS ID"
		,"precincts_cgroupno"=>"No."
		,"precincts_number"=>"Clustered Precinct"
		,"precincts_numberofvoters"=>"RV"
		,"precincts_encoded_actualvotedvoters"=>"VV"
		,"updatewho"=>""
		//,"precincts_status"=>"Status"
		,"viewdata"=>"&nbsp;"
		);

		// Column (table data) User Defined Attributes
		$arrAttribs = array(
		"precincts_polling_place"=>" width='250'",
		"precincts_cgroupno"=>" align='right'",
		"precincts_numberofvoters"=>" align='right'",
		"precincts_encoded_actualvotedvoters"=>" align='right'",
		"precints_number"=>" align='right'",
		"viewdata"=>"width='50' align='center'"
		);

		// Process the Table List
		$tblDisplayList = new clsTableList3($this->conn);
		$tblDisplayList->arrFields = $arrFields;
		$tblDisplayList->paginator->linkPage = "?$queryStr";
		$tblDisplayList->sqlAll = $sql;
		$tblDisplayList->sqlCount = $sqlcount;

		return $tblDisplayList->getTableList3($arrAttribs);
	}

	function doSavePrecinctsUpdateStatus($precints_id_ = null,  $precincts_status_ = 40, $precincts_remarks_ = null) {
        $flds = array();
        $flds[] = "precincts_status='$precincts_status_'";
        if(!is_null($precincts_remarks_)){
            $flds[] = "precincts_encoded_remarks='".addslashes($precincts_remarks_)."'";
        }
        $fields = implode(",", $flds);
        $sql = "update comelec_precincts set $fields where precints_id = '$precints_id_'";
        $this->conn->Execute($sql);
        switch ($precincts_status_){
            case 20:
                $_SESSION['eMsgOpenStatus'] = "Precinct successfully set as FOR VERIFICATION.";
                break;
            case 30:
                $_SESSION['eMsgOpenStatus'] = "Precinct successfully set as PENDING ERROR.";
                break;
            case 40:
                $_SESSION['eMsgOpenStatus'] = "Precinct successfully set as VERIFIED.";
                break;
        }
    }

}

?>