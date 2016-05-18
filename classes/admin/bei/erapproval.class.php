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
class clsERApproval{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsERApproval object
	 */
	function clsERApproval($dbconn_ = null){
		$this->conn =& $dbconn_;
		$this->fieldMap = array(
		 "mnu_name" => "mnu_name"
		,"mnu_desc" => "mnu_desc"
		,"mnu_parent" => "mnu_parent"
		,"mnu_icon" => "mnu_icon"
		,"mnu_ord" => "mnu_ord"
		,"mnu_status" => "mnu_status"
		,"mnu_link_info" => "mnu_link_info"
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
			$valData = addslashes($valData);
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
		//$editLink = "<a href=\"?statpos=erapproval&edit=',am.mnu_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
		//$delLink = "<a href=\"?statpos=erapproval&delete=',am.mnu_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

		$confirmationLink = "<a href=\"?statpos=erapproval&confirmation=',vt_id,'\">',vt_id,'</a>";
		
		// SqlAll Query
		$sql = "SELECT
				    CONCAT('$confirmationLink')  AS vt_id
				    , comelec_votes_trans.vt_datestamp AS datestamp
				    , comelec_votes_trans.precincts_number AS pricincts_no
				    , comelec_region.region_id AS r
				    , comelec_region.region_name AS region
				    , comelec_province.province_id AS p
				    , comelec_province.province_name AS province
				    ,comelec_municipal.municipal_id AS m
				    ,comelec_municipal.municipal_name AS municipal
				    , comelec_barangay.barangay_name AS barangay
				    , comelec_pollingplaces.pollingplaces_name AS pollingplace
				    ,CONCAT('$viewLink','$editLink','$delLink') as viewdata
				FROM
				    comelec_db.comelec_barangay
				    INNER JOIN comelec_pollingplaces 
				        ON (comelec_barangay.barangay_id = comelec_pollingplaces.barangay_id)
				    INNER JOIN comelec_municipal 
				        ON (comelec_municipal.id = comelec_barangay.municipal_id)
				    INNER JOIN comelec_region 
				        ON (comelec_region.region_id = comelec_municipal.region_id)
				    INNER JOIN comelec_province 
				        ON (comelec_province.province_id = comelec_municipal.province_id) AND (comelec_province.region_id = comelec_region.region_id)
				    INNER JOIN comelec_precincts_relation 
				        ON (comelec_precincts_relation.pollingplaces_id = comelec_pollingplaces.pollingplaces_id)
				    INNER JOIN comelec_precincts 
				        ON (comelec_precincts_relation.precints_id = comelec_precincts.precints_id)
				    INNER JOIN comelec_votes_trans 
				        ON (comelec_votes_trans.pollingplaces_id = comelec_pollingplaces.pollingplaces_id) AND (comelec_votes_trans.precincts_id = comelec_precincts.precints_id)
						$criteria
						$strOrderBy";

		// Sql query for paginator list
		// @note no need to use this. it replaced by sql function "FOUND_ROWS()"
		//$sqlcount = "select count(*) as mycount from app_modules $criteria";

		// Field and Table Header Mapping
		$arrFields = array(
		 "vt_id"=>"id"
		,"r"=>"r"
		,"region"=>"region"
		,"p"=>"p"
		,"province"=>"province"
		,"m"=>"m"
		,"municipal"=>"Municipal"
		,"barangay"=>"Barangay"
		,"pollingplace"=>"Polling Places"
		,"pricincts_no"=>"Pricincts No."
		,"viewdata"=>"&nbsp;"
		);

		// Column (table data) User Defined Attributes
		$arrAttribs = array(
		"mnu_name"=>"width='50' align='center'"
		,"mnu_ord"=>" align='right'"
		,"viewdata"=>"width='50' align='center'"
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
	
}

?>