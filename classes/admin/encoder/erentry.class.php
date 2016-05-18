<?php
/**
 * Initial Declaration
 */

define("ELECTION_LEVEL_NATIONAL", 1);
define("ELECTION_LEVEL_PROVINCIAL", 2);
define("ELECTION_LEVEL_MUNICIPAL", 3);
define("ELECTION_LEVEL_PARTYLIST", 4);

/**
 * Class Module
 *
 * @author  Arnold P. Orbista
 *
 */
class clsEREntry{

	var $conn;
	var $fieldMap;
	var $fieldMapCVotes;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsEREntry object
	 */
	function clsEREntry($dbconn_ = null){
		$this->conn =& $dbconn_;
//		$this->conn->debug = true;
		$this->fieldMap = array(
		 "precinct_id" => "precinct_id"
		,"vt_erseriesno" => "vt_erseriesno"
		,"vt_vr" => "vt_vr"
		,"vt_vv" => "vt_vv"
		,"vt_validballots" => "vt_validballots"
		,"vt_spoiledballots" => "vt_spoiledballots"
		,"vt_excessballots" => "vt_excessballots"
		,"vt_excessballots" => "vt_excessballots"
		,"vit_rejectedballots" => "vit_rejectedballots"
		,"candidatevotes" => "candidatevotes"
		);
	}

	/**
	 * Get the records from the database
	 *
	 * @param string $id_
	 * @return array
	 */
	function dbFetch($id_ = ""){
		$sql = "select * from comelec_votes_trans where vt_id = ?";
		$rsResult = $this->conn->Execute($sql,array($id_));
		if(!$rsResult->EOF){
			$tData = $rsResult->fields;
			
			$sql = "select * from comelec_votes_trans_details where vt_id = ?";
			$rsSubResult = $this->conn->Execute($sql,array($id_));
			$tData['candidatevotes'] = array();
			while (!$rsSubResult->EOF) {
				$tData['candidatevotes'][$rsSubResult->fields['political_candidates_id']] = $rsSubResult->fields['vtd_vote'];
				$rsSubResult->MoveNext();
			}
			return $tData;
		}
	}
	/**
	 * Populate array parameters to Data Variable
	 *
	 * @param array $pData_
	 * @param boolean $isForm_
	 * @return bool
	 */
	function doPopulateData($pData_ = array(),$isForm_ = false){
		if(count($pData_)>0){
			
			foreach ($this->fieldMap as $key => $value) {
				if ($isForm_) {
					$this->Data[$value] = $pData_[$value];
				}else {
					$this->Data[$key] = $pData_[$value];
				}
			}
			
			foreach ($pData_['votes'] as $vKey => $vValue) {
				foreach ($vValue as $vvkey => $vvValue) {
					$this->Data['candidatevotes'][$vvkey] = $vvValue;
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
	function doValidateData($pData_ = array()){
		$isValid = true;
//		$isValid = false;

		if ($pData_['precinct_id']==0) {
			$isValid = false;
			$_SESSION['eMsg'][] = "Please select precint.";
		}

		if (strlen($pData_['vt_erseriesno'])==0) {
			$isValid = false;
			$_SESSION['eMsg'][] = "Please enter ER Series Number.";
		}
		
		if (strlen($pData_['vt_vr'])==0) {
			$isValid = false;
			$_SESSION['eMsg'][] = "Please voters registered on this precint.";
		}

		return $isValid;
	}

	/**
	 * Save New
	 *
	 */
	function doSaveAdd($xPost){
	/*	table name:
		Field             Type                 Collation          Null    Key     
		----------------  -------------------  -----------------  ------  ------  
		vt_id             bigint(15) unsigned  NULL                       PRI     
		user_id           int(11)              NULL               YES            
		precincts_id      int(11)              NULL               YES            
		vt_remotehost     varchar(25)          latin1_general_ci  YES            
		vt_datestamp      datetime             NULL               YES            
		precincts_number  varchar(16)          latin1_swedish_ci  YES            
		pollingplaces_id  int(11)              NULL               YES            
	*/
		
//		$flds = array();
//		foreach ($this->Data as $keyData => $valData) {
//			$valData = addslashes($valData);
//			$flds[] = "$keyData='$valData'";
//		}
//		$fields = implode(", ",$flds);
//
//		$sql = "insert into comelec_votes_trans set $fields";
//		$this->conn->Execute($sql);
		
		$sql = "INSERT INTO 
					comelec_votes_trans 
				SET  
					user_id='".$_SESSION['admin_session_obj']['user_id']."'
					,precincts_id='$xPost[precinct_id]'
					,vt_remotehost='$_SERVER[HTTP_HOST]'
					,vt_datestamp='now()'
					,pollingplaces_id='" . $_SESSION['admin_session_obj']['user_data']['pollingplaces_id'] . "'
					,vt_vr='$xPost[vt_vr]'
					,vt_vv='$xPost[vt_vv]'
					,vt_validballots='$xPost[vt_validballots]'
					,vt_spoiledballots='$xPost[vt_spoiledballots]'
					,vt_excessballots='$xPost[vt_excessballots]'
					,vit_rejectedballots='$xPost[vit_rejectedballots]'
					,vt_erseriesno='$xPost[vt_erseriesno]'
				";
		$this->conn->Execute($sql);
		
		//$rsResult = $this->conn->Execute("SELECT LAST_INSERT_ID() as Insert_ID");
		//echo $rsResult->fields['Insert_ID'];
		
		$vt_id_ = $this->conn->Insert_ID();
		//echo $vt_id_;
		//exit();
//		table name =comelec_votes_trans_details
//		Field                    Type                 Collation  Null    Key     Default
//		vtd_id                   bigint(20) unsigned  (NULL)     NO      PRI     (NULL) 
//		vt_id                    bigint(20)           (NULL)     YES             (NULL) 
//		political_candidates_id  int(5)               (NULL)     YES             (NULL) 
//		vtd_vote                 int(5)               (NULL)     YES             (NULL) 
		
		foreach($xPost['votes'] as $ikey => $idesc) {
			foreach($idesc as $sikey => $sidesc) {
				$sql = "INSERT INTO 
							comelec_votes_trans_details 
						SET
							vt_id=$vt_id_
							,political_candidates_id=$sikey
							,vtd_vote=$sidesc
						";	
				$this->conn->Execute($sql);
			}
		}
		$_SESSION['eMsg']="Successfully Added.";
		return $vt_id_;
	}

	/**
	 * Save Update
	 *
	 */
	function doSaveEdit(){
		$id = $_GET['edit'];

		$flds = array();
		foreach ($this->Data as $keyData => $valData) {
			$valData = addslashes($valData);
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
		$sql = "delete from /*app_modules*/ where mnu_id=?";
		$this->conn->Execute($sql,array($id_));
		$_SESSION['eMsg']="Successfully Deleted.";
	}

	/**
	 * Get all the Table Listings
	 *
	 * @return array
	 */
	function getTableList(){
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
				$qry[] = "mnu_name like '%$search_field%'";

			}
		}

		// put all query array into one criteria string
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

		// Sort field mapping
		$arrSortBy = array(
		 "mnu_name"=>"mnu_name"
		,"mnu_link"=>"mnu_link"
		,"mnu_ord"=>"mnu_ord"
		);

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}

		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
		$viewLink = "";
		$editLink = "<a href=\"?statpos=erentry&edit=',am.mnu_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
		$delLink = "<a href=\"?statpos=erentry&delete=',am.mnu_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

		// SqlAll Query
		$sql = "select am.*, CONCAT('$viewLink','$editLink','$delLink') as viewdata
						from app_modules am
						$criteria
						$strOrderBy";

		// Sql query for paginator list
		// @note no need to use this. it replaced by sql function "FOUND_ROWS()"
		//$sqlcount = "select count(*) as mycount from app_modules $criteria";

		// Field and Table Header Mapping
		$arrFields = array(
		 "mnu_name"=>"Module Name"
		,"mnu_link"=>"Link"
		,"mnu_ord"=>"Order"
		,"viewdata"=>"&nbsp;"
		);

		// Column (table data) User Defined Attributes
		$arrAttribs = array(
		"mnu_ord"=>" align='right'",
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
	
	function getCandidatePost(){
		$sql = "select * from comelec_candidate_post order by election_level_id, candidate_post_order";
		$rsResult = $this->conn->Execute($sql);
		$arrData = array();
		while (!$rsResult->EOF) {
			$arrData[] = $rsResult->fields;
			$rsResult->MoveNext();
		}
		if (count($arrData)==0) return $arrData;
		return $arrData;		
	}
	
	
	function getListOfCandidates(){
		$arrCandidatePost = $this->getCandidatePost();
		$arrListOfCandidates = array();
		foreach ($arrCandidatePost as $acpkey => $acpvalue) {
			$arrListOfCandidates[$acpvalue['candidate_post_id']]['acpData'] = $arrCandidatePost[$acpkey];
			$sql = "select * from comelec_political_candidates where candidate_post_id = ?";

			$rsResult = $this->conn->Execute($sql,array($acpvalue['candidate_post_id']));
			$arrData = array();
			while (!$rsResult->EOF) {
				$arrData[] = $rsResult->fields;
				$rsResult->MoveNext();
			}
			$arrListOfCandidates[$acpvalue['candidate_post_id']]['polCandidates'] = $arrData;
		}

		return $arrListOfCandidates;
	}

	function getCandidateListNational($level_id_ = 1){
		$arrListOfCandidates = array();
        $arrListOfCandidates = $this->getCandidateListPerLevel($level_id_);
		return $arrListOfCandidates;
	}

	function getCandidateListProvincial($prov_id_ = null, $level_id_ = 2){
		$arrListOfCandidates = array();
        $arrListOfCandidates = $this->getCandidateListPerLevel($level_id_, $prov_id_);
		return $arrListOfCandidates;
	}

	function getCandidateListMunicipal($prov_id_ = null, $mun_id_ = null, $level_id_ = 3){

        $arrListOfCandidates = $this->getCandidateListPerLevelMun($level_id_, $prov_id_, $mun_id_);
		return $arrListOfCandidates;
	}

	function getCandidateListPartylist($level_id_ = 4){
		$arrListOfCandidates = array();
        $arrListOfCandidates = $this->getCandidateListPerLevel($level_id_);
		return $arrListOfCandidates;
	}


	function getCandidateListPerLevel($level_id_ = null, $prov_id_ = null, $mun_id_ = null) {
		$flds = array();
		$flds[] = "a.candidate_post_id";
		$flds[] = "a.candidate_post_name";
		$fields = implode(",",$flds);

		$qry = array();
		$qry[] = "a.election_level_id='$level_id_'";



		$criteria = " where ".implode(" and ", $qry);

		$sql = "select $fields
                from comelec_candidate_post a
                $criteria
                order by a.candidate_post_order";

		$rsResult = $this->conn->Execute($sql);
		$arrData = array();
		$xCtr = 0;
		while(!$rsResult->EOF){
			$arrData[$xCtr]['cpost'] = $rsResult->fields;
			$arrData[$xCtr]['candidates'] = $this->getCandidateListPerPost($rsResult->fields['candidate_post_id'], $prov_id_, $mun_id_);
			$xCtr++;
			$rsResult->MoveNext();
		}
		return $arrData;

	}

	//caburog
	function getCandidateListPerLevelMun($level_id_ = null, $prov_id_ = null, $mun_id_ = null) {
		$flds = array();
		$flds[] = "a.candidate_post_id";
		$flds[] = "a.candidate_post_name";
		$fields = implode(",",$flds);

		$qry = array();
		$qry[] = "a.election_level_id='$level_id_'";
		$qry[] = "a.candidate_post_name LIKE '%zamboanga city%'";



		$criteria = " where ".implode(" and ", $qry);

		$sql = "select $fields
                from comelec_candidate_post a
                $criteria
                order by a.candidate_post_order";

		$rsResult = $this->conn->Execute($sql);
		$arrData = array();
		$xCtr = 0;
		while(!$rsResult->EOF){
			$arrData[$xCtr]['cpost'] = $rsResult->fields;
			$arrData[$xCtr]['candidates'] = $this->getCandidateListPerPost($rsResult->fields['candidate_post_id'], $prov_id_, $mun_id_);
			$xCtr++;
			$rsResult->MoveNext();
		}
		return $arrData;

	}
    
    function getCandidateListPerPost($candidate_post_id_ = null, $prov_id_ = null, $mun_id_ = null) {
        $flds = array();
        $flds[] = "a.political_candidates_id";
        $flds[] = "a.political_candidates_name";
        $flds[] = "a.political_candidates_alias";
        $flds[] = "a.political_candidates_order";
        $fields = implode(",",$flds);

        $qry = array();
        $qry[] = "a.candidate_post_id='$candidate_post_id_'";

        if(!is_null($prov_id_)){
            $qry[] = "a.prov_id='$prov_id_'";
        }
        if(!is_null($mun_id_)){
            $qry[] = "a.mun_id='$mun_id_'";
        }

        $criteria = " where ".implode(" and ", $qry);

        $sql = "select $fields
                from comelec_political_candidates a
                $criteria
                order by  a.political_candidates_name /*a.political_candidates_order*/";

        $rsResult = $this->conn->Execute($sql);
        $arrData = array();
        while(!$rsResult->EOF){
            $arrData[] = $rsResult->fields;
            $rsResult->MoveNext();
        }
        return $arrData;

    }
	//caburog
	function getCandidateListPerPostMun($candidate_post_id_ = null, $prov_id_ = null, $mun_id_ = null) {
		$flds = array();
		$flds[] = "a.political_candidates_id";
		$flds[] = "a.political_candidates_name";
		$flds[] = "a.political_candidates_alias";
		$flds[] = "a.political_candidates_order";
		$fields = implode(",",$flds);

		$qry = array();
		$qry[] = "a.candidate_post_id='$candidate_post_id_'";

		if(!is_null($prov_id_)){
			$qry[] = "a.prov_id='$prov_id_'";
		}
		if(!is_null($mun_id_)){
			$qry[] = "a.mun_id='$mun_id_'";
		}

		$criteria = " where ".implode(" and ", $qry);

		$sql = "select $fields
                from comelec_political_candidates a
                $criteria
                order by  a.political_candidates_name /*a.political_candidates_order*/";

		$rsResult = $this->conn->Execute($sql);
		$arrData = array();
		while(!$rsResult->EOF){
			$arrData[] = $rsResult->fields;
			$rsResult->MoveNext();
		}
		return $arrData;

	}

    function getPrecinctInfo($prec_id_ = null) {
        $flds = array();
        $flds[] = "prec.precints_id";
        $flds[] = "prec.precincts_code";
        $flds[] = "prec.precincts_number";
        $flds[] = "prec.precincts_numberofvoters";
        $flds[] = "concat('<span title=\"',prec.precincts_polling_place,'\" class=\"ui-icon ui-icon-info floatLeft theme-cursor-pointer\" ></span><span title=\"',prec.precincts_polling_place,'\" class=\"hide-overflow\">',coalesce(prec.precincts_polling_place,''),'</span>') as precincts_polling_place";
        $flds[] = "brgy.barangay_name";
        $flds[] = "mun.municipal_name";
        $flds[] = "mun.mun_id";
        $flds[] = "prov.province_name";
        $flds[] = "prov.prov_id";
        $flds[] = "rgn.region_name";
        $flds[] = "prec.precincts_encoded_numberofvoters";
        $flds[] = "prec.precincts_encoded_actualvotedvoters";
        $flds[] = "prec.precincts_encoded_totalvalidballot";
        $flds[] = "prec.precincts_encoded_pcosid";
        $flds[] = "prec.precincts_encoded_remarks";
        $flds[] = "prec.precincts_status";
        $flds[] = "prec.precincts_code";
        $fields = implode(",",$flds);

        $qry = array();
        $qry[] = "prec.precints_id='$prec_id_'";

        $criteria = " where ".implode(" and ", $qry);

        $sql = "select  $fields
                from comelec_precincts prec
                left join comelec_barangay brgy on brgy.barangay_id = prec.barangay_id
                left join comelec_municipal mun on mun.mun_id = prec.mun_id
                left join comelec_province prov on prov.prov_id = mun.prov_id
                left join comelec_region rgn on rgn.rgn_id = prov.rgn_id
                $criteria";

        $rsResult = $this->conn->Execute($sql);
        if(!$rsResult->EOF){
            return $rsResult->fields;
        }
        return array();
    }
	
	function getPrecincts($pollingplaces_id=0){
		if($pollingplaces_id>0) {
		$crit  = "WHERE 
					cpp.pollingplaces_id=$pollingplaces_id and cvt.precincts_id is null";
		}
		$sql = "select 
					cp.precints_number
					,cp.precints_id
				FROM
					comelec_pollingplaces cpp
					INNER JOIN comelec_precincts_relation cpr
						ON (cpp.pollingplaces_id = cpr.pollingplaces_id)
					INNER JOIN comelec_precincts cp
						ON (cpr.precints_id = cp.precints_id)
					left join comelec_votes_trans cvt
						on (cvt.precincts_id = cp.precints_id)
				$crit";
		$rsResult = $this->conn->Execute($sql);
		$arrData = array();
		while (!$rsResult->EOF) {
			$arrData[] = $rsResult->fields;
			$rsResult->MoveNext();
		}
		if (count($arrData)==0) return $arrData;
		return $arrData;		
	}

    function setPrecinctTaken($precints_id_ = null) {
        $flds = array();
        $flds[] = "user_id='".AppUser::getData("user_id")."'";
        $flds[] = "precincts_updatewho='".AppUser::getData("user_id")."'";
        $flds[] = "precincts_updatewhen=NOW()";
        $flds[] = "precincts_status='20'";
        $fields = implode(",",$flds);
        $sql  = "update comelec_precincts set $fields where precints_id = '$precints_id_'";
        $this->conn->Execute($sql);
    }
    
    function isPrecinctTaken($precints_id_ = null) {
        $sql = "select a.user_id from comelec_precincts a where a.precints_id = '$precints_id_'";
        $rsResult = $this->conn->Execute($sql);
        if(!$rsResult->EOF){
            if(empty($rsResult->fields['user_id'])){
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }

    function doSavePrecinctsHeader($precints_id_ = null,  $pData_ = array()) {
        $flds = array();
        $flds[] = "precincts_encoded_numberofvoters='".$pData_['precincts_encoded_numberofvoters']."'";
        $flds[] = "precincts_encoded_actualvotedvoters='".$pData_['precincts_encoded_actualvotedvoters']."'";
        $flds[] = "precincts_encoded_totalvalidballot='".$pData_['precincts_encoded_totalvalidballot']."'";
        $flds[] = "precincts_encoded_pcosid='".$pData_['precincts_encoded_pcosid']."'";
        $flds[] = "precincts_updatewho='".AppUser::getData("user_id")."'";
        $flds[] = "precincts_updatewhen=NOW()";
        $fields = implode(",",$flds);
        
        $sql = "update comelec_precincts set $fields where precints_id = '$precints_id_'";
        $this->conn->Execute($sql);
    }


    function getAllPCOSVotesDataPerCandidate($precincts_code_ = null){
        if(is_null($precincts_code_)) return array();
        $flds = array();
        $flds[] = "f06";

        $fields = implode(",",$flds);
        $sql = "select $fields from temp_parsedata where f02 = '$precincts_code_'";
        $rsResult = $this->conn->Execute($sql);
        $arrData = array();
        while(!$rsResult->EOF){
            $arrData[$rsResult->fields['f12']] = $rsResult->fields;
            $rsResult->MoveNext();
        }
        return $arrData;
    }

    function doSaveCandidateVotes($precints_id_ = null, $pData_ = array(), $pValData_ = array()) {
        //if($this->checkPrecinctDataVotes($precints_id_)){
        // get all pcos data from temp_parsedata per precinct_code
        $arrAllPCOSVotesDataPerPrecinct = $this->getAllPCOSVotesDataPerCandidate($pData_['precincts_code']);

            foreach ($pData_['candidatevotes'] as $keyCandidateVotes => $valCandidateVotes) {
                $flds = array();
                $flds[] = "precints_id='{$precints_id_}'";
                $flds[] = "candidates_id='{$keyCandidateVotes}'";
                $flds[] = "cvotes_value='{$valCandidateVotes}'";
                $flds[] = "cvotes_pcos='".$arrAllPCOSVotesDataPerPrecinct[$keyCandidateVotes]['f06']."'";
                $flds[] = "cvotes_updatewho='".AppUser::getData("user_name")."'";
                $flds[] = "cvotes_updatewhen=NOW()";
                $flds[] = "precincts_code='".$pData_['precincts_code']."'";
                

                if(!key_exists($keyCandidateVotes, $pValData_)){
                    $flds[] = "cvotes_addwho='".AppUser::getData("user_name")."'";
                    $fields = implode(",",$flds);
                    $sql = "insert into comelec_candidate_votes set $fields ";
                }else{
                    $fields = implode(",",$flds);
                    $sql = "update comelec_candidate_votes set $fields where precints_id = '$precints_id_' and candidates_id = '$keyCandidateVotes'";
                }
                $this->conn->Execute($sql);
            }
        //}
        $_SESSION['eMsg'] = "Successfully updated.";
    }

    function checkPrecinctDataVotes($precints_id_ = null){
      $sql = "select a.precints_id from comelec_candidate_votes a where a.precints_id = '$precints_id_' limit 1";
      $rsResult = $this->conn->Execute($sql);
      if(!$rsResult->EOF){
          return true;
      }else{
          return false;
      }
    }
    
    function doSavePrecinctsUpdateStatus($precints_id_ = null, $precincts_code_ = 0,  $precincts_status_ = 40, $precincts_remarks_ = null) {
        $flds = array();
        $flds[] = "precincts_status='$precincts_status_'";
        if(!is_null($precincts_remarks_)){
            $flds[] = "precincts_encoded_remarks='".addslashes($precincts_remarks_)."'";
        }
        $flds[] = "precincts_updatewho='".AppUser::getData("user_id")."'";
        $flds[] = "precincts_updatewhen=NOW()";
        $fields = implode(",", $flds);
        $sql = "update comelec_precincts set $fields where precints_id = '$precints_id_'";
        $this->conn->Execute($sql);
        $sql = "update comelec_candidate_votes set precincts_code='".$precincts_code_."' where precints_id = '$precints_id_' and precincts_code=0";
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

    function getCandidateVotesDataByPrecinct($precints_id_ = null,$rgn_id_ = null, $prov_id_ = null, $mun_id_ = null) {
        $flds = array();
        $flds[] = "a.precints_id";
        $flds[] = "a.candidates_id";
        $flds[] = "a.cvotes_value";
        
        $fields = implode(",",$flds);
        $qry = array();
        $qry[] = "a.precints_id = '$precints_id_'";
        
        $criteria = " where ".implode(" and ",$qry);
        $sql = "select $fields 
                from comelec_candidate_votes a
                $criteria";
        $rsResult = $this->conn->Execute($sql);
        $arrData = array();
        while(!$rsResult->EOF){
            $arrData[$rsResult->fields['candidates_id']] = $rsResult->fields;
            $rsResult->MoveNext();
        }
        return $arrData;
    }

}

?>