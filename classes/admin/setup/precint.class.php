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
class clsPrecinct{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsPrecinct object
	 */
	function clsPrecinct($dbconn_ = null){
		$this->conn =& $dbconn_;
		$this->conn->debug = false;
		$this->fieldMap = array(
		 "precints_number" => "precints_number"
		,"precints_numberofvoters" => "precints_numberofvoters"
		,"precincts_cgroupno" => "precincts_cgroupno"
		,"precincts_groupno" => "precincts_groupno"
		,"precincts_regvoterafterc" => "precincts_regvoterafterc"
		);
	}

	/**
	 * Get the records from the database
	 *
	 * @param string $id_
	 * @return array
	 */
	function dbFetch($id_ = ""){
		$sql = "SELECT * FROM comelec_precints WHERE precints_id=?";
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

		$sql = "insert into comelec_precincts set $fields";

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

		$sql = "update comelec_precincts set $fields where precints_id=$id";
		$this->conn->Execute($sql);
		$_SESSION['eMsg']="Successfully Updated.";
	}

	/**
	 * Delete Record
	 *
	 * @param string $id_
	 */
	function doDelete($id_ = ""){
		$sql = "delete from comelec_precincts where precints_id=?";
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
				$qry[] = "precints_number like '%$search_field%'";

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

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}

		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
		$viewLink = "";
		$editLink = "<a href=\"?statpos=precinct&edit=',am.precints_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
		$delLink = "<a href=\"?statpos=precinct&delete=',am.precints_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

		// SqlAll Query
		$sql = "select am.*, CONCAT('$viewLink','$editLink','$delLink') as viewdata
						from comelec_precincts am
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
		,"precincts_groupno"=>"Group No."
		,"precincts_regvoterafterc"=>"precincts_regvoterafterc"
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
	function getTableList_popup(){
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
				$qry[] = "cp.precints_number like '%$search_field%'";

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

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}

		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
		$viewLink = "";
		$editLink = "<a href=\"?statpos=precinct&edit=',cp.precints_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
		$delLink = "<a href=\"?statpos=precinct&delete=',cp.precints_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";
		
		$idLinkBegin = "<a href=\"javascript:void(0); onclick=\"javascript:opener.document.getElementById(\'precints_id\').value=\'',cp.precints_id,'\'; opener.document.getElementById(\'precints_number\').value=\'',cp.precints_number,'\'; window.close();\>',cp.precints_number,'</a>";

		// SqlAll Query
		$sql = "select cp.*, CONCAT('$idLinkBegin') as precints_number
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
		,"precincts_groupno"=>"Group No"
		,"precincts_regvoterafterc"=>"Registered Voter"
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