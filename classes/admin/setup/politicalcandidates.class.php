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
class clsPoliticalCandidates{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsPoliticalCandidates object
	 */
	function clsPoliticalCandidates($dbconn_ = null){
		$this->conn =& $dbconn_;
		$this->fieldMap = array(
		 "candidate_post_id" => "candidate_post_id"
		,"political_candidates_name" => "political_candidates_name"
		,"political_candidates_alias" => "political_candidates_alias"
		,"political_candidates_year" => "political_candidates_year"
		,"political_candidates_qastatus" => "political_candidates_qastatus"
		,"political_candidates_order" => "political_candidates_order"
		);
	}

	/**
	 * Get the records from the database
	 *
	 * @param string $id_
	 * @return array
	 */
	function dbFetch($id_ = ""){
		$sql = "SELECT * FROM comelec_political_candidates WHERE political_candidates_id=$id_";
		$rsResult = $this->conn->Execute($sql);
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
                if($pData_['candidate_post_id'] <= 5){

                    if(empty($pData_['political_candidates_name'])){
                         $isValid = false;
                         $_SESSION['eMsg'][] = "Political Candidates Full Name  is Required";
                    }
                     if(empty($pData_['political_candidates_alias'])){
                         $isValid = false;
                         $_SESSION['eMsg'][] = "Political Candidates Alias   is Required";
                    }
                    if(empty($pData_['political_candidates_order'])){
                         $isValid = false;
                         $_SESSION['eMsg'][] = "Political Order Number   is Required";
                    }
                }else if($pData_['candidate_post_id'] >= 5){
                    if(empty($pData_['municipality_name'])){
                         $isValid = false;
                         $_SESSION['eMsg'][] = "Municipality is Required";
                    }
                  /*   if(empty($pData_['barangay_name'])){
                         $isValid = false;
                         $_SESSION['eMsg'][] = "Barangay is Required";
                    }*/
                    if(empty($pData_['political_candidates_name'])){
                         $isValid = false;
                         $_SESSION['eMsg'][] = "Political Candidates Full Name  is Required";
                    }
                     if(empty($pData_['political_candidates_alias'])){
                         $isValid = false;
                         $_SESSION['eMsg'][] = "Political Candidates Alias   is Required";
                    }
                    if(empty($pData_['political_candidates_order'])){
                         $isValid = false;
                         $_SESSION['eMsg'][] = "Political Order Number   is Required";
                    }
                }


		return $isValid;
	}

	/**
	 * Save New
	 *
	 */
	function doSaveAdd($post){


                $sqls = "SELECT election_level_id FROM comelec_candidate_post WHERE candidate_post_id ={$post['candidate_post_id']}";

                 $objData = $this->conn->Execute($sqls);

                 if(!$objData->EOF) {
                    $rsult = $objData->fields['election_level_id'];

                 }

                $flds = array();
		$flds[] = "mun_id = '{$post['municipality_id']}'";
                $flds[] = "prov_id = '{$post['select_province']}'";
                $flds[] = "election_level_id = '{$rsult}'";
                $flds[] = "candidate_post_id = '{$post['candidate_post_id']}'";
                $flds[] = "political_candidates_name = '{$post['political_candidates_name']}'";
                $flds[] = "political_candidates_alias = '{$post['political_candidates_alias']}'";
                $flds[] = "political_candidates_year = '{$post['political_candidates_year']}'";
                $flds[] = "political_candidates_order = '{$post['political_candidates_order']}'";
                $flds[] = "political_candidates_qastatus= '{$post['political_candidates_qastatus']}'";
                $flds[] = "political_candidates_district = '{$post['district_name']}'";

                $fields = implode(", ",$flds);

		$sql = "insert into comelec_political_candidates set $fields";
		
                $this->conn->Execute($sql);

		$_SESSION['eMsg']="Successfully Added.";
	}

	/**
	 * Save Update
	 *
	 */
	function doSaveEdit($post){
		$id = $_GET['edit'];

                 $sqls = "SELECT election_level_id FROM comelec_candidate_post WHERE candidate_post_id ={$post['candidate_post_id']}";

                 $objData = $this->conn->Execute($sqls);

                 if(!$objData->EOF) {
                    $rsult = $objData->fields['election_level_id'];

                 }

		$flds = array();
		$flds[] = "mun_id = '{$post['municipality_id']}'";
                $flds[] = "prov_id = '{$post['select_province']}'";
                $flds[] = "election_level_id = '{$rsult}'";
                $flds[] = "candidate_post_id = '{$post['candidate_post_id']}'";
                $flds[] = "political_candidates_name = '{$post['political_candidates_name']}'";
                $flds[] = "political_candidates_alias = '{$post['political_candidates_alias']}'";
                $flds[] = "political_candidates_year = '{$post['political_candidates_year']}'";
                $flds[] = "political_candidates_order = '{$post['political_candidates_order']}'";
                $flds[] = "political_candidates_qastatus= '{$post['political_candidates_qastatus']}'";
                $flds[] = "political_candidates_district = '{$post['district_name']}'";

                $fields = implode(", ",$flds);

		$sql = "update comelec_political_candidates set $fields where political_candidates_id=$id";
		
                $this->conn->Execute($sql);
		$_SESSION['eMsg']="Successfully Updated.";
	}

	/**
	 * Delete Record
	 *
	 * @param string $id_
	 */
	function doDelete($id_ = ""){
		$sql = "delete from comelect_political_candidates where political_candidates_id=?";
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
		 "political_candidates_name"=>"political_candidates_name"
		,"political_candidates_alias"=>"political_candidates_alias"
		,"mnu_ord"=>"mnu_ord"
		);

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}

		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
		$viewLink = "";
		$editLink = "<a href=\"?statpos=politicalcandidates&edit=',am.political_candidates_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
		//$delLink = "<a href=\"?statpos=politicalcandidates&delete=',am.political_candidates_id,'\" onclick=\"return confirm(\'Are you sure, you want to delete?\');\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/trash.gif\" title=\"Delete\" hspace=\"2px\"  border=0></a>";

		// SqlAll Query
		$sql = "select am.*, CONCAT('$viewLink','$editLink','$delLink') as viewdata, candidate_post_name
						FROM
    							comelec_candidate_post cp
    					INNER JOIN comelec_political_candidates am
        					ON (cp.candidate_post_id = am.candidate_post_id)
						$criteria
						$strOrderBy";

		// Sql query for paginator list
		// @note no need to use this. it replaced by sql function "FOUND_ROWS()"
		//$sqlcount = "select count(*) as mycount from app_modules $criteria";

		// Field and Table Header Mapping
		$arrFields = array(
		 "political_candidates_name"=>"Political Candidates Name"
		,"political_candidates_alias"=>"Political A.K.A."
		,"candidate_post_name"=>"Candidates Position"
		,"political_candidates_year"=>"Election Term"
		,"political_candidates_order"=>"Political Order Number"
		,"viewdata"=>"&nbsp;"
		);

		// Column (table data) User Defined Attributes
		$arrAttribs = array(
		"political_candidates_name"=>" align='left'",
		"political_candidates_alias"=>" align='left'",
		"political_candidates_year"=>" align='left'",
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
	 * Get Election Level Categories
	 * @return arrCandPost
	 */
	function getRecCandPost(){
		
		$sqls = "SELECT * FROM comelec_candidate_post";
		$objData = $this->conn->Execute($sqls);
		
		
		$cResult = array();
		while ( !$objData->EOF ) {       	
			$cResult[] = $objData->fields;        	
        	$objData->MoveNext();
        }        
           
        return $cResult;
		
	}

        function getRegionPost(){

		$sqls = "SELECT rgn_id,region_name FROM comelec_region order by region_ord ASC";
                
		$objData = $this->conn->Execute($sqls);


		$cResult = array();
		while ( !$objData->EOF ) {
			$cResult[] = $objData->fields;
        	$objData->MoveNext();
        }

        return $cResult;

	}

        function fetchProvinces($rgn_id){

            $sql = "SELECT prov_id, province_name FROM comelec_province WHERE rgn_id=?";

            $res = $this->conn->Execute($sql,array($rgn_id));

            $str = '';
            while(!$res->EOF){
                $str .="<option value=\"{$res->fields['prov_id']}\">{$res->fields['province_name']}</option>";
                $res->MoveNext();
            }

            return $str;
        }

         function getProvinces(){

            $sqls = "SELECT prov_id, province_name FROM comelec_province ";

            $objData = $this->conn->Execute($sqls);

            $cResult = array();
            while ( !$objData->EOF ) {
                   $cResult[] = $objData->fields;
                 $objData->MoveNext();
            }

             return $cResult;
        }


         function fetchProvMun($prov_id){

            $sql = "SELECT prov_id, province_name FROM comelec_province WHERE prov_id=?";

            $res = $this->conn->Execute($sql,array($rgn_id));

            $str = '';

             if(!$res->EOF) {
                    $str =" <input type=\"text\" name=\"municipality_name\" id=\"municipality_name\" value=\"{$res->fields['prov_id']}\">";
             }
            return $str;
        }

         function getMunicipal($q_,$provid) {

                $qry = $flds =  array();


                if(!is_null($q_)) {
                    $qry[] = "municipal_name like '%$q_%'";
                    $qry[] = "prov_id = $provid";
                }else{
                    $qry[] = "prov_id = $provid";
                }

                    

                $criteria = count($qry) > 0 ? " where ".implode(" and ", $qry):"";


                $flds[] = "mun_id";
                $flds[] = "municipal_name";

                $fields = implode(",", $flds);

                $sql = "select $fields from
                        comelec_municipal
                    $criteria limit 100";
//                echo $sql;
                $rsResult = $this->conn->Execute($sql);
                $strData = "";
                while(!$rsResult->EOF) {
                    $strData .= "|".$rsResult->fields['mun_id']."|".utf8_encode($rsResult->fields['municipal_name'])."\n";
                    $rsResult->MoveNext();
                }

                unset($flds);

                return $strData;
    }

    function getBarangay($q_,$munid){

             $qry = $flds =  array();



                if(!is_null($q_)) {
                    $qry[] = "barangay_name like '%$q_%'";
                    $qry[] = "mun_id = $munid";
                }else{
                    $qry[] = "mun_id = $munid";
                }



                $criteria = count($qry) > 0 ? " where ".implode(" and ", $qry):"";


                $flds[] = "barangay_id";
                $flds[] = "barangay_name";

                $fields = implode(",", $flds);

                $sql = "select $fields from
                        comelec_barangay
                    $criteria limit 100";
               // echo $sql;
                $rsResult = $this->conn->Execute($sql);
                $strData = "";
                while(!$rsResult->EOF) {
                    $strData .= "|".$rsResult->fields['barangay_id']."|".$rsResult->fields['barangay_name']."\n";
                    $rsResult->MoveNext();
                }

                unset($flds);

                return $strData;


    }

    function getHasDistrict($cp_id){

        $sqls = "SELECT candidate_post_id FROM comelec_candidate_post WHERE candidate_post_id =? and candidate_post_hasdistrict = 1";
     
        $objData = $this->conn->Execute($sqls,array($cp_id));

         if(!$objData->EOF) {
            $rsult = $objData->fields['candidate_post_id'];

         }
         return $rsult;
    }

    function getPolitiCalcandidates($get){

        $sqls = "SELECT b.*, a.rgn_id,c.municipal_name FROM comelec_political_candidates b
            LEFT JOIN comelec_province a
            ON a.prov_id = b.prov_id
             LEFT JOIN comelec_municipal c
            ON c.mun_id = b.mun_id
            WHERE political_candidates_id =? ";

        $objData = $this->conn->Execute($sqls,array($get));

         if(!$objData->EOF) {
            $rsult = $objData->fields;

         }
         return $rsult;
    }
}

?>