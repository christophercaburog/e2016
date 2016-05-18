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
class clsMunicipal{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsMunicipal object
	 */
	function clsMunicipal($dbconn_ = null){
		$this->conn =& $dbconn_;
		$this->conn->debug=false;
		$this->fieldMap = array(
		 "region_id" => "region_id"
		,"province_id" => "province_id"
		,"municipal_id" => "municipal_id"
		,"municipal_name" => "municipal_name"
		,"precints_count" => "precints_count"
		,"precints_reported" => "precints_reported"
		,"voters_registered" => "voters_registered"
		);
	}

	/**
	 * Get the records from the database
	 *
	 * @param string $id_
	 * @return array
	 */
	function dbFetch($id_ = ""){
		$sql = "Select am.*, prov.province_name as province_name 
					from comelec_municipal am 
					INNER JOIN comelec_province prov
						ON (prov.prov_id=am.prov_id)
					where am.mun_id=?";
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

		$sql = "insert into comelec_municipal set $fields";
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

		$sql = "update comelec_municipal set $fields where id=$id";
		$this->conn->Execute($sql);
		$_SESSION['eMsg']="Successfully Updated.";
	}

	/**
	 * Delete Record
	 *
	 * @param string $id_
	 */
	function doDelete($id_ = ""){
		$sql = "delete from comelec_municipal where id=?";
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
				$qry[] = "am.municipal_name like '%$search_field%' or reg.region_name like '%$search_field%'";

			}
		}

		// put all query array into one criteria string
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

		// Sort field mapping
		$arrSortBy = array(
		 "municipal_name" => "municipal_name"
		,"precints_count" => "precints_count"
		,"voters_registered" => "voters_registered"
		,"province_name" => "Province"
		,"region_name" => "Region"
		);

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}
//		else {
//			$strOrderBy = "order by municipal_name";
//		}

		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
		$viewLink = "";
		$editLink = "<a href=\"?statpos=municipal&edit=',am.mun_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
		$delLink = "<a href=\"?statpos=municipal&delete=',am.mun_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

		// SqlAll Query
		$sql = "select am.*, prov.province_name as province_name, reg.region_name as region_name,
				CONCAT('$viewLink','$editLink','$delLink') as viewdata
						from comelec_municipal am
						INNER JOIN comelec_province prov
							ON (prov.prov_id=am.prov_id)
						INNER JOIN comelec_region reg
							ON (reg.rgn_id=prov.rgn_id)
						$criteria
						$strOrderBy";

		// Sql query for paginator list
		// @note no need to use this. it replaced by sql function "FOUND_ROWS()"
		//$sqlcount = "select count(*) as mycount from app_modules $criteria";

		// Field and Table Header Mapping
		$arrFields = array(
		 "region_name" => "Region"
		,"province_name" => "Province"
		,"municipal_name" => "Municipal Name"
		,"precincts_count" => "Precincts"
		,"voters_registered" => "Registered Voters."
		,"viewdata"=>""
		);

		// Column (table data) User Defined Attributes
		$arrAttribs = array(
		"precincts_count"=>" align='right'",
		"voters_registered"=>" align='right'",
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
 * Enter description here...
 *
 * @return unknown
 */
	function getTableList_popup($id){
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
				$qry[] = "cm.municipal_name like '%$search_field%'";

			}
		}
		
		if($id==""){
		//@note: fillter province...
		$qry[]="cm.province_id='".$id."'";
		}
		// put all query array into one criteria string
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

		// Sort field mapping
		$arrSortBy = array(
		 "municipal_name" => "Municipal Name"
		,"precints_count" => "Precints Count"
		,"voters_registered" => "Registered Voter"
		,"province_name" => "Province"
		,"region_name" => "Region"
		);

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}
		else {
			$strOrderBy = "order by municipal_name";
		}

		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
		$viewLink = "";
		$editLink = "<a href=\"?statpos=municipal&edit=',cm.id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
		$delLink = "<a href=\"?statpos=municipal&delete=',cm.id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";
		
		$idLinkBegin = "<a href=\"javascript:void(0);\" onclick=\"opener.document.getElementById(\'municipal_id\').value=\'',cm.id,'\'; opener.document.getElementById(\'municipal_name\').value=\'',cm.municipal_name,'\'; window.close();\">',cm.municipal_name,'</a>";


		// SqlAll Query
		$sql = "select cm.*,  cp.province_name, cr.region_name, CONCAT('$idLinkBegin') as municipal_name
						from comelec_municipal cm
						inner join comelec_province cp on (cp.id = cm.province_id)
						inner join comelec_region cr on (cr.region_id = cp.region_id)
						$criteria
						$strOrderBy";

		// Sql query for paginator list
		// @note no need to use this. it replaced by sql function "FOUND_ROWS()"
		//$sqlcount = "select count(*) as mycount from app_modules $criteria";

		// Field and Table Header Mapping
		$arrFields = array(
		 "municipal_name" => "Municipal Name"
		,"precints_count" => "Precints Count"
		,"voters_registered" => "Registered Voter"
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