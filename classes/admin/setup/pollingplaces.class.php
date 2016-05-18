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
class clsPopup_PollingPlaces{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsRegion object
	 */
	function clsPopup_PollingPlaces($dbconn_ = null){
		$this->conn =& $dbconn_;
		$this->conn->debug=false;
		$this->fieldMap = array(
		 "barangay_id" => "barangay_id"
		,"pollingplaces_name" => "pollingplaces_name"
		);
	}

	/**
	 * Get the records from the database
	 *
	 * @param string $id_
	 * @return array
	 */
	function dbFetch($id_ = ""){
		$sql = "Select * from comelec_pollingplaces cpp
						inner join comelec_barangay cb on (cb.barangay_id = cpp.barangay_id)
						inner join comelec_municipal cm on (cm.id = cb.municipal_id)
						inner join comelec_province cp on (cp.id = cm.province_id)
						inner join comelec_region cr on (cr.region_id = cp.region_id) 
						where cpp.pollingplaces_id=?";
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

		$sql = "insert into comelec_pollingplaces set $fields";
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

		$sql = "update comelec_pollingplaces set $fields where pollingplaces_id=$id";
		$this->conn->Execute($sql);
		$_SESSION['eMsg']="Successfully Updated.";
	}

	/**
	 * Delete Record
	 *
	 * @param string $id_
	 */
	function doDelete($id_ = ""){
		$sql = "delete from comelec_pollingplaces where pollingplaces_id=?";
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

			}
		}

		// put all query array into one criteria string
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

		// Sort field mapping
		$arrSortBy = array(
		 "pollingplaces_name" => "pollingplaces_name"
		,"barangay_name" => "barangay_name"
		,"municipal_name" => "municipal_name"
		,"province_name" => "province_name"
		,"region_name" => "region_name"
		);

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}
		else {
			$strOrderBy = "order by region_ord";
		}

		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
		$viewLink = "";
		$editLink = "<a href=\"?statpos=region&edit=',cpp.pollingplaces_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
		$delLink = "<a href=\"?statpos=region&delete=',cpp.pollingplaces_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

		// SqlAll Query
		$sql = "select cpp.*, cb.barangay_name, cm.municipal_name, cp.province_name, cr.region_name, 
						CONCAT('$viewLink','$editLink','$delLink') as viewdata
						from comelec_pollingplaces cpp
						inner join comelec_barangay cb on (cb.barangay_id = cpp.barangay_id)
						inner join comelec_municipal cm on (cm.id = cb.municipal_id)
						inner join comelec_province cp on (cp.id = cm.province_id)
						inner join comelec_region cr on (cr.region_id = cp.region_id)
						$criteria
						$strOrderBy";

		// Sql query for paginator list
		// @note no need to use this. it replaced by sql function "FOUND_ROWS()"
		//$sqlcount = "select count(*) as mycount from app_modules $criteria";

		// Field and Table Header Mapping
		$arrFields = array(
		 "pollingplaces_name" => "Polling Place"
		,"barangay_name" => "Barangay"
		,"municipal_name" => "Municipal"
		,"province_name" => "Province"
		,"region_name" => "Region"
		,"viewdata"=>""
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
	
	/**
	 * Get all the Table Listings for POPUP.
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
				$qry[] = "cpp.pollingplaces_name like '%$search_field%'";

			}
		}

		// put all query array into one criteria string
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

		// Sort field mapping
		$arrSortBy = array(
		"pollingplaces_name" => "pollingplaces_name"
		,"barangay_name" => "barangay_name"
		,"municipal_name" => "municipal_name"
		,"province_name" => "province_name"
		,"region_name" => "region_name"
		);

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}

		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
		$viewLink = "";
		$editLink = "";
		$delLink = "";
		$reg_link = "<a href=\"javascript:void(0);\" onclick=\"javascript:opener.document.getElementById(\'pollingplaces_id\').value=\'',cpp.pollingplaces_id,'\';
						opener.document.getElementById(\'pollingplaces_name\').value=\'',cpp.pollingplaces_name,'\';
						window.close();\">";
		$reg_close = "</a>";
						
		// SqlAll Query
		$sql = "select cpp.*, cb.barangay_name, cm.municipal_name, cp.province_name, cr.region_name,
				CONCAT('$reg_link',cpp.pollingplaces_name,'$reg_close') as pollingplaces_name, 
				CONCAT('$viewLink','$editLink','$delLink') as viewdata
						from comelec_pollingplaces cpp
						inner join comelec_barangay cb on (cb.barangay_id = cpp.barangay_id)
						inner join comelec_municipal cm on (cm.id = cb.municipal_id)
						inner join comelec_province cp on (cp.id = cm.province_id)
						inner join comelec_region cr on (cr.region_id = cp.region_id)
						$criteria
						$strOrderBy";

		// Sql query for paginator list
		// @note no need to use this. it replaced by sql function "FOUND_ROWS()"
		//$sqlcount = "select count(*) as mycount from app_modules $criteria";

		// Field and Table Header Mapping
		$arrFields = array(
		 "pollingplaces_name" => "Polling Place"
		,"barangay_name" => "Barangay"
		,"municipal_name" => "Municipal"
		,"province_name" => "Province"
		,"region_name" => "Region"
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