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
class clsManageDept{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsManageDept object
	 */
	function clsManageDept($dbconn_ = null){
		$this->conn =& $dbconn_;
		$this->fieldMap = array(
		"ud_name" => "ud_name",
		"ud_desc" => "ud_desc"
		);
	}

	/**
	 * Get the records from the database
	 *
	 * @param string $id_
	 * @return array
	 */
	function dbFetch($id_ = ""){
		$sql = "select * from app_userdept where ud_id=?";
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

		$sql = "insert into app_userdept set $fields";
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

		$sql = "update app_userdept set $fields where ud_id=$id";
		$this->conn->Execute($sql);
		$_SESSION['eMsg']="Successfully Updated.";
	}

	/**
	 * Delete Record
	 *
	 * @param string $id_
	 */
	function doDelete($id_ = ""){
		$sql = "delete from app_userdept where ud_id=?";
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
		if (isset($_REQUEST['search_field'])) {

			// lets check if the search field has a value
			if (strlen($_REQUEST['search_field'])>0) {
				// lets assign the request value in a variable
				$search_field = $_REQUEST['search_field'];

				// create a custom criteria in an array
				$qry[] = "ud.ud_name like '%$search_field%'";

				// put all query array into one string criteria
				$criteria = " where ".implode(" or ",$qry);

			}
		}

		$arrSortBy = array(
		"ud_name"=>"ud_name",
		"ud_desc"=>"ud_desc",
		"user_status"=>"au.user_status",
		);

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}

		$viewLink = "";
		$editLink = "<a href=\"?statpos=managedept&edit=',ud.ud_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
		$delLink = "<a href=\"?statpos=managedept&delete=',ud.ud_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

		$sql = "select ud.*, CONCAT('$viewLink','$editLink','$delLink') as viewdata from app_userdept ud $criteria $strOrderBy";

		$sqlcount = "select count(*) as mycount from app_userdept ud $criteria";

		$arrFields = array(
		"ud_name"=>"Department Name",
		"ud_desc"=>"Description",
		"viewdata"=>"&nbsp;"
		);

		$arrAttribs = array(
		"viewdata"=>"width='50' align='center'"
		);

		$tblDisplayList = new clsTableList($this->conn);
		$tblDisplayList->arrFields = $arrFields;
		$tblDisplayList->paginator->linkPage = "?$queryStr";
		$tblDisplayList->sqlAll = $sql;
		$tblDisplayList->sqlCount = $sqlcount;

		return $tblDisplayList->getTableList($arrAttribs);
	}

}

?>