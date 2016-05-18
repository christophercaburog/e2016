<?php
/**
 * Initial Declaration
 */


/**
 * Class Module
 *
 * @author  Arnold P. Orbista
 *
 */
class clsPrecinct {

    var $conn;
    var $fieldMap;
    var $Data;

    /**
     * Class Constructor
     *
     * @param object $dbconn_
     * @return clsPrecinct object
     */
    function clsPrecinct($dbconn_ = null) {
        $this->conn =& $dbconn_;
        $this->conn->debug = false;
        $this->fieldMap = array(
            "precincts_number" => "precincts_number"
            ,"precincts_numberofvoters" => "precincts_numberofvoters"
            ,"precincts_cgroupno" => "precincts_cgroupno"
            ,"precincts_groupno" => "precincts_groupno"
            ,"precincts_regvoterafterc" => "precincts_regvoterafterc"
            ,"precincts_polling_place" => "precincts_polling_place"
            ,"precincts_status" => "precincts_status"
            ,"precincts_qastatus" => "precincts_qastatus"
            ,"barangay_id" => "barangay_id"
            ,"mun_id" => "mun_id"
            ,"user_id" => "user_id"
        );
    }

    /**
     * Get the records from the database
     *
     * @param string $id_
     * @return array
     */
    function dbFetch($id_ = "") {
        $sql = "SELECT cpr.*
                ,cb.barangay_id
                ,cb.barangay_name
                ,cm.mun_id
                ,cm.municipal_name
                ,cp.prov_id
                ,cp.province_name
                ,cr.rgn_id
                ,cr.region_name
                , cpr.user_id
                            FROM comelec_precincts cpr
                            left join comelec_municipal cm on cm.mun_id = cpr.mun_id
                            left join comelec_barangay cb on cb.barangay_id = cpr.barangay_id
                            left join comelec_province cp on cp.prov_id = cm.prov_id
                            left join comelec_region cr on cr.rgn_id = cp.rgn_id
                            WHERE precints_id=?";
        $rsResult = $this->conn->Execute($sql,array($id_));
        if(!$rsResult->EOF) {
            return $rsResult->fields;
        }
    }
    function getBarangay($q_="", $munid="") {
        $qry = $flds =  array();

        $flds[] = "barangay_id";
        $flds[] = "barangay_name";

        if(!is_null($q_)) {
            $qry[] = "barangay_name like '%$q_%'";
        }
        if(!is_null($munid)) {
            $qry[] = "mun_id = $munid";
        }

        $criteria = count($qry) > 0 ? " where ".implode(" and ", $qry):"";
        $fields = implode(",", $flds);

        $sql = "select $fields from
                comelec_barangay
            $criteria limit 100";
        $rsResult = $this->conn->Execute($sql);
        $strData = "";
        while(!$rsResult->EOF) {
            $strData .= "|".$rsResult->fields['barangay_id']."|".$rsResult->fields['barangay_name']."\n";
            $rsResult->MoveNext();
        }

        unset($flds);

        return $strData;
    }
    
    function getProvince($q_="", $rgnid="") {
        $qry = $flds =  array();

        $flds[] = "prov_id";
        $flds[] = "province_name";


        if(!is_null($q_)) {
            $qry[] = "province_name like '%$q_%'";
        }
        
        if(!is_null($rgnid)) {
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
            $qry[] = "region_name like '$q_%'";
        }

        $criteria = count($qry) > 0 ? " where ".implode(" and ", $qry):"";
        $fields = implode(",", $flds);

        $sql = "select $fields from
                comelec_region
            $criteria order by region_ord limit 100";
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
        }
        if(!is_null($provid)) {
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
    /**
     * Populate array parameters to Data Variable
     *
     * @param array $pData_
     * @param boolean $isForm_
     * @return bool
     */
    function doPopulateData($pData_ = array(),$isForm_ = false) {
        if(count($pData_)>0) {
            foreach ($this->fieldMap as $key => $value) {
                if ($isForm_) {
                    $this->Data[$value] = $pData_[$value];
                }else {
                    $this->Data[$key] = $pData_[$value];
                }
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

        //		$isValid = false;

        return $isValid;
    }

    /**
     * Save New
     *
     */
    function doSaveAdd() {
        $flds = array();
        foreach ($this->Data as $keyData => $valData) {
            $valData = addslashes($valData);
            $flds[] = "$keyData='$valData'";
        }
        $fields = implode(", ",$flds);

        $sql = "insert into comelec_precincts set $fields";

        $this->conn->Execute($sql);

        $_SESSION['eMsg']="Successfully Added.";
    }

    /**
     * Save Update
     *
     */
    function doSaveEdit() {
        $id = $_GET['edit'];

        $flds = array();
        foreach ($this->Data as $keyData => $valData) {
            $valData = addslashes($valData);
            $flds[] = "$keyData='$valData'";
        }
        $fields = implode(", ",$flds);

        $sql = "update comelec_precincts set $fields where precints_id=$id";
        $this->conn->Execute($sql);
        $_SESSION['eMsg']="Successfully Updated.";
    }

    /**
     * Delete Record
     *
     * @param string $id_
     */
    function doDelete($id_ = "") {
        $sql = "delete from comelec_precincts where precints_id=?";
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
        $qry = array();
        if (isset($_REQUEST['search_field'])) {

        // lets check if the search field has a value
            if (strlen($_REQUEST['search_field'])>0) {
            // lets assign the request value in a variable
                $search_field = $_REQUEST['search_field'];

                // create a custom criteria in an array
                $qry[] = "precincts_polling_place like '%$search_field%'";
                $qry[] = "precincts_number like '%$search_field%'";
                $qry[] = "region_name like '%$search_field%'";
                $qry[] = "province_name like '%$search_field%'";
                $qry[] = "barangay_name like '%$search_field%'";

            }
        }

        // added region, province, municipal filter
        if(!empty($_GET['rgn'])){   //region
            $qry[]="rgn.region_name LIKE '%{$_GET['rgn']}%'";
        }
        if(!empty($_GET['prn'])){   //province
            $qry[]="prov.province_name LIKE '%{$_GET['prn']}%'";
        }
        if(!empty($_GET['mun'])){   //municipal
            $qry[]="mun.municipal_name LIKE '%{$_GET['mun']}%'";
        }
        if(!empty($_GET['brg'])){   //barangay
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
//        $arrSortBy = array(
//            "precints_number"=>"precints_number"
//            ,"precints_numberofvoters"=>"precints_numberofvoters"
//            ,"precincts_cgroupno"=>"precincts_cgroupno"
//            ,"precincts_groupno"=>"precincts_groupno"
//            ,"municipal_name"=>"municipal_name"
//            ,"region_name"=>"region_name"
//            ,"province_name"=>"province_name"
//            ,"barangay_name"=>"barangay_name"
//        );

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
		,"precincts_status"=>"precincts_status"
		);

        if(isset($_GET['sortby'])) {
            $strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
        }

        // Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
        $viewLink = "";
        $editLink = "<a href=\"?statpos=precinct&edit=',prec.precints_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
       // $delLink = "<a href=\"?statpos=precinct&delete=',am.precints_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

        // SqlAll Query
//        $sql = "select am.*
//                ,CONCAT('$viewLink','$editLink','$delLink') as viewdata
//                ,cm.municipal_name
//                ,cr.region_name
//                ,cp.province_name
//                ,cb.barangay_name
//						from comelec_precincts am
//                                                left join comelec_municipal cm on cm.mun_id = am.mun_id
//                                                left join comelec_barangay cb on cb.barangay_id = am.barangay_id
//                                                left join comelec_province cp on cp.prov_id = cm.prov_id
//                                                left join comelec_region cr on cr.rgn_id = cp.rgn_id
//            $criteria
//            $strOrderBy";
//
//        // Sql query for paginator list
//        // @note no need to use this. it replaced by sql function "FOUND_ROWS()"
//        //$sqlcount = "select count(*) as mycount from app_modules $criteria";
//
//        // Field and Table Header Mapping
//        $arrFields = array(
//            "region_name"=>"Region"
//            ,"province_name"=>"Province"
//            ,"municipal_name"=>"Municipal"
//            ,"barangay_name"=>"Barangay"
//            ,"precincts_numberofvoters"=>"Total Voters"
//            ,"precincts_cgroupno"=>"No."
//            ,"viewdata"=>"&nbsp;"
//        );

        $flds = array();
        $flds[] = "prec.precincts_numberofvoters";
        $flds[] = "concat('<span title=\"',prec.precincts_polling_place,'\" class=\"ui-icon ui-icon-info floatLeft theme-cursor-pointer\" ></span><span title=\"',prec.precincts_polling_place,'\" class=\"hide-overflow\">',coalesce(prec.precincts_polling_place,''),'</span>') as precincts_polling_place";
        $flds[] = "prec.precincts_cgroupno";
        $flds[] = "brgy.barangay_name";
        $flds[] = "concat('<span title=\"',prov.province_name,'\" class=\"ui-icon ui-icon-info floatLeft theme-cursor-pointer\" ></span><span title=\"',prov.province_name,'\" class=\"hide-overflow\">',coalesce(prov.province_name,''),'</span>') as province_name";
        $flds[] = "concat('<span title=\"',(case prec.precincts_qastatus when 5 then 'Precinct unverified' else 'Precinct Verified' end),'\" class=\"ui-icon ',(case prec.precincts_qastatus when 5 then 'ui-icon-help' else 'ui-icon-check' end),' floatLeft theme-cursor-pointer\" ></span><span title=\"',prec.precincts_number,'\" class=\"hide-overflow\">',coalesce(prec.precincts_number,''),'</span>') as precincts";
        $flds[] = "mun.municipal_name";
        $flds[] = "prec.precincts_number";
        $flds[] = "rgn.region_name";
        $flds[] = "prec.precincts_encoded_pcosid";
        $flds[] = "case prec.precincts_status when 20 then 'Processing' when 25 then 'For Verification' when 30 then  'Pending Error' when 40 then 'Verified' else 'Open'  end as precincts_status";
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
//		,"precincts_encoded_pcosid"=>"PCOS ID"
		,"precincts_cgroupno"=>"No."
		,"precincts"=>"Clustered Precinct"
		,"precincts_numberofvoters"=>"RV"
		,"precincts_status"=>"Status"
		,"viewdata"=>"&nbsp;"
		);

        // Column (table data) User Defined Attributes
        $arrAttribs = array(
            "precints_number"=>" align='right'",
            "viewdata"=>"width='50' align='center'"
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
     * getTableList_popup
     *
     * @return array
     */
    function getTableList_popup() {
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
        $qry = array();
        if (isset($_REQUEST['search_field'])) {

        // lets check if the search field has a value
            if (strlen($_REQUEST['search_field'])>0) {
            // lets assign the request value in a variable
                $search_field = $_REQUEST['search_field'];

                // create a custom criteria in an array
                $qry[] = "cpprecints_number like '%$search_field%'";

            }
        }

        // put all query array into one criteria string
        $criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

        // Sort field mapping
        $arrSortBy = array(
            "precints_number"=>"precints_number"
            ,"precints_numberofvoters"=>"precints_numberofvoters"
            ,"precincts_cgroupno"=>"precincts_cgroupno"
            ,"precincts_groupno"=>"precincts_groupno"
        );

        if(isset($_GET['sortby'])) {
            $strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
        }

        // Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
        $viewLink = "";
        $editLink = "<a href=\"?statpos=precinct&edit=',cp.precints_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
        $delLink = "<a href=\"?statpos=precinct&delete=',cp.precints_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

        $idLinkBegin = "<a href=\"javascript:void(0); onclick=\"javascript:opener.document.getElementById(\'precints_id\').value=\'',cp.precints_id,'\'; opener.document.getElementById(\'precint_number\').value=\'',cp.precint_number,'\'; window.close();\>',cp.precint_number,'</a>";

        // SqlAll Query
        $sql = "select cp.*, CONCAT('$idLinkBegin') as viewdata
						from comelec_precincts cp
            $criteria
            $strOrderBy";

        // Sql query for paginator list
        // @note no need to use this. it replaced by sql function "FOUND_ROWS()"
        //$sqlcount = "select count(*) as mycount from app_modules $criteria";

        // Field and Table Header Mapping
        $arrFields = array(
            "precints_number"=>"Precincts #"
            ,"precints_numberofvoters"=>"Total Voters"
            ,"precincts_cgroupno"=>"Clustered Group"
            ,"precincts_groupno"=>"precincts_groupno"
            ,"precincts_regvoterafterc"=>"precincts_regvoterafterc"
        );

        // Column (table data) User Defined Attributes
        $arrAttribs = array(
            "viewdata"=>"width='50' align='center'"
        );

        // Process the Table List
        $tblDisplayList = new clsTableList($this->conn);
        $tblDisplayList->arrFields = $arrFields;
        $tblDisplayList->paginator->linkPage = "?$queryStr";
        $tblDisplayList->sqlAll = $sql;
        $tblDisplayList->sqlCount = $sqlcount;

        return $tblDisplayList->getTableList($arrAttribs);
    }

}

?>