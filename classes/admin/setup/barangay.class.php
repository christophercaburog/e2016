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
class clsBarangay{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsBarangay object
	 */
	function clsBarangay($dbconn_ = null){
		$this->conn =& $dbconn_;
		$this->fieldMap = array(
		 "municipal_id" => "municipal_id"
		,"barangay_name" => "barangay_name"
		);
	}

	/**
	 * Get the records from the database
	 *
	 * @param string $id_
	 * @return array
	 */
	function dbFetch($id_ = ""){
		$sql = "SELECT cb.barangay_name, cb.barangay_id, cm.mun_id,cm.municipal_name
                            ,cp.prov_id, cp.province_name, cr.rgn_id, cr.region_name
                        FROM comelec_barangay cb
                        INNER JOIN comelec_municipal cm ON ( cm.mun_id = cb.mun_id )
                        INNER JOIN comelec_province cp ON ( cp.prov_id = cm.prov_id )
                        INNER JOIN comelec_region cr ON ( cr.rgn_id = cp.rgn_id )
                        WHERE cb.barangay_id =?";
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
        
        if(empty($pData_['mun_id'])){
            $_SESSION['eMsg'][]="Municipal Name required";
            $isValid=false;
        }
        if(empty($pData_['barangay_name'])){
            $_SESSION['eMsg'][]="Barangay Name required";
            $isValid=false;
        }

		return $isValid;
	}

	/**
	 * Save New
	 *
	 */
	function doSaveAdd($pData=array()){
		$flds = array();

        $flds[]="mun_id='{$pData['mun_id']}'";
        $flds[]="barangay_name='{$pData['barangay_name']}'";
		$fields = implode(", ",$flds);

		$sql = "insert into comelec_barangay set $fields";
		$this->conn->Execute($sql);

		$_SESSION['eMsg']="Successfully Added.";
	}

	/**
	 * Save Update
	 *
	 */
	function doSaveEdit($pData=array()){
		$id = $_GET['edit'];

		$flds = array();
		$flds[]="mun_id='{$pData['mun_id']}'";
        $flds[]="barangay_name='{$pData['barangay_name']}'";
		$fields = implode(", ",$flds);

		$sql = "update comelec_barangay set $fields where barangay_id=$id";
		$this->conn->Execute($sql);
		$_SESSION['eMsg']="Successfully Updated.";
	}

	/**
	 * Delete Record
	 *
	 * @param string $id_
	 */
	function doDelete($id_ = ""){
		$sql = "delete from comelec_barangay where barangay_id=?";
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
				$qry[] = "cb.barangay_name like '%$search_field%'";

			}
		}

        // added region, province, municipal filter
        if(!empty($_GET['rgn'])){   //region
            $qry[]="cr.region_name LIKE '%{$_GET['rgn']}%'";
        }
        if(!empty($_GET['prn'])){   //province
            $qry[]="cp.province_name LIKE '%{$_GET['prn']}%'";
        }
        if(!empty($_GET['mun'])){   //municipal
            $qry[]="cm.municipal_name LIKE '%{$_GET['mun']}%'";
        }
        if(!empty($_GET['brg'])){   //barangay
            $qry[]="cb.barangay_name LIKE '%{$_GET['brg']}%'";
        }
        
		// put all query array into one criteria string
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

		// Sort field mapping
		$arrSortBy = array(
		 "barangay_name"=>"barangay_name" 
		,"municipal_name"=>"municipal_name"
		,"province_name"=>"province_name"
		,"region_name"=>"region_name"
		);

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}

		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
		$viewLink = "";
		$editLink = "<a href=\"?statpos=barangay&edit=',cb.barangay_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
		$delLink = "<a href=\"?statpos=barangay&delete=',cb.barangay_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

		// SqlAll Query
		$sql = "select cb.barangay_id, cb.barangay_name, cm.municipal_name, cp.province_name, cr.region_name, CONCAT('$viewLink','$editLink','$delLink') as viewdata
						from comelec_barangay cb
						inner join comelec_municipal cm on (cm.mun_id = cb.mun_id)
						inner join comelec_province cp on (cp.prov_id = cm.prov_id)
						inner join comelec_region cr on (cr.rgn_id = cp.rgn_id)
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

		
		
		// put all query array into one criteria string
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

		// Sort field mapping
		$arrSortBy = array(
		 "barangay_name"=>"barangay_name" 
		,"municipal_name"=>"municipal_name"
		,"province_name"=>"province_name"
		,"region_name"=>"region_name"
		);

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}
		else {
			$strOrderBy = "order by municipal_name";
		}

		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
		$viewLink = "";
		$editLink = "<a href=\"?statpos=municipal&edit=',cm.mun_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
		$delLink = "<a href=\"?statpos=municipal&delete=',cm.mun_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";
		
		$idLinkBegin = "<a href=\"javascript:void(0);\" onclick=\"opener.document.getElementById(\'municipal_id\').value=\'',cm.mun_id,'\';
						opener.document.getElementById(\'municipal_name\').value=\'',cm.municipal_name,'\'; 
						window.close();\">',cm.municipal_name,'</a>";


		// SqlAll Query
		$sql = "select cm.*,  cp.province_name, cr.region_name, CONCAT('$idLinkBegin') as municipal_name
						from comelec_barangay am					
						INNER JOIN comelec_municipal cm 
							ON (cm.mun_id = am.mun_id)
						INNER JOIN comelec_province cp 
							ON (cp.prov_id = cm.prov_id)
						INNER JOIN comelec_region cr 
							ON (cr.rgn_id = cp.rgn_id)
						$criteria
						$strOrderBy";

		// Sql query for paginator list
		// @note no need to use this. it replaced by sql function "FOUND_ROWS()"
		//$sqlcount = "select count(*) as mycount from app_modules $criteria";

		// Field and Table Header Mapping
		$arrFields = array(
		 "barangay_name"=>"Barangay" 
		,"municipal_name"=>"Municipal"
		,"province_name"=>"Province"
		,"region_name"=>"Region"
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