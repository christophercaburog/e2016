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
class clsCandidatePosition{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsCandidatePosition object
	 */
	function clsCandidatePosition($dbconn_ = null){
		$this->conn =& $dbconn_;
		$this->fieldMap = array(
		 "precints_id" => "precints_id"
		,"pollingplaces_id" => "pollingplaces_id"
		,"precinctsrelation_status" => "precinctsrelation_status"
		);
	}

	/**
	 * Get the records from the database
	 *
	 * @param string $id_
	 * @return array
	 */
	function dbFetch($id_ = ""){
		$sql = "select * FROM comelec_precincts_relation cpr
			    LEFT JOIN comelec_precincts  cp ON (cpr.precints_id = cp.precints_id)
			    LEFT JOIN comelec_pollingplaces  cpp ON (cpr.pollingplaces_id = cpp.pollingplaces_id)
			    LEFT JOIN comelec_barangay  cb ON (cpp.barangay_id = cb.barangay_id)
			    LEFT JOIN comelec_municipal cm ON (cb.municipal_id = cm.id)
			    where cpr.precintsrelation_id=?";
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

		$sql = "insert into comelec_precincts_relation set $fields";
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

		$sql = "update comelec_precincts_relation set $fields where precintsrelation_id=$id";
		$this->conn->Execute($sql);
		$_SESSION['eMsg']="Successfully Updated.";
	}

	/**
	 * Delete Record
	 *
	 * @param string $id_
	 */
	function doDelete($id_ = ""){
		$sql = "delete from comelec_precincts_relation where precintsrelation_id=?";
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
				$qry[] = "cpp.pollingplaces_name like '%$search_field%'";
				$qry[] = "cp.precints_number like '%$search_field%'";

			}
		}

		// put all query array into one criteria string
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

		// Sort field mapping
		$arrSortBy = array(
		 "precints_number"=>"precints_number"
		,"pollingplaces_name"=>"pollingplaces_name"
		,"barangay_name"=>"barangay_name"
		,"municipal_name"=>"municipal_name"
		//,"precinctsrelation_status"=>"precinctsrelation_status"
		);

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}

		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
		$viewLink = "";
		$editLink = "<a href=\"?statpos=mpollingplace_precinctrelation&edit=',cpr.precintsrelation_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
		$delLink = "<a href=\"?statpos=mpollingplace_precinctrelation&delete=',cpr.precintsrelation_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

		// SqlAll Query
		$sql = "select cpr.precintsrelation_id, cp.precints_number, cpp.pollingplaces_name, cb.barangay_name, cm.municipal_name, 
					CONCAT('$viewLink','$editLink','$delLink') as viewdata 
				FROM comelec_precincts_relation cpr
			    LEFT JOIN comelec_precincts  cp ON (cpr.precints_id = cp.precints_id)
			    LEFT JOIN comelec_pollingplaces  cpp ON (cpr.pollingplaces_id = cpp.pollingplaces_id)
			    LEFT JOIN comelec_barangay  cb ON (cpp.barangay_id = cb.barangay_id)
			    LEFT JOIN comelec_municipal cm ON (cb.municipal_id = cm.id)
				$criteria
				$strOrderBy";

		// Sql query for paginator list
		// @note no need to use this. it replaced by sql function "FOUND_ROWS()"
		//$sqlcount = "select count(*) as mycount from app_modules $criteria";

		// Field and Table Header Mapping
		$arrFields = array(
		 "precints_number"=>"Precint Number"
		,"pollingplaces_name"=>"Polling Place"
		,"barangay_name"=>"Barangay"
		,"municipal_name"=>"Municipal"
		//,"precinctsrelation_status"=>"Status"
		,"viewdata"=>"&nbsp;"
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