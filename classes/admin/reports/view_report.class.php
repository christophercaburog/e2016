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
class clsViewReport{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsViewReport object
	 */
	function clsViewReport($dbconn_ = null){
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

    function fetchRegions(){

        if(isset($_GET['verified'])){
            $subQryCriteria  = " and cp.precincts_status = 40";
            $mainQryCriteria = "";
        }
        $sql = "SELECT 		/*count(cp.precints_id) total_precicnts,*/
                            reg.region_name,
                            /*SUM(cp.precincts_numberofvoters) as precincts_numberofvoters,*/
                            reg.rgn_id,
                            (SELECT SUM(cp.precincts_numberofvoters)
                                FROM 		comelec_precincts cp
                                LEFT JOIN 	comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                                LEFT JOIN 	comelec_province cprov ON (cprov.prov_id = cm.prov_id)
                                WHERE 		cprov.rgn_id=reg.rgn_id
                            ) as precincts_numberofvoters,
                            (SELECT COUNT(cp.precints_id)
                                FROM 		comelec_precincts cp
                                LEFT JOIN 	comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                                LEFT JOIN 	comelec_province cprov ON (cprov.prov_id = cm.prov_id)
                                WHERE 		cprov.rgn_id=reg.rgn_id
                            ) as total_precicnts
                            ,(SELECT COUNT(cp.precints_id)
                                FROM 		comelec_precincts cp
                                LEFT JOIN 	comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                                LEFT JOIN 	comelec_province cprov ON (cprov.prov_id = cm.prov_id)
                                WHERE 		cprov.rgn_id=reg.rgn_id and cp.user_id > 0 $subQryCriteria
                            ) as precincts_reported
                            ,(SELECT SUM(cp.precincts_encoded_actualvotedvoters)
                                FROM 		comelec_precincts cp
                                LEFT JOIN 	comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                                LEFT JOIN 	comelec_province cprov ON (cprov.prov_id = cm.prov_id)
                                WHERE 		cprov.rgn_id=reg.rgn_id and cp.user_id > 0 $subQryCriteria
                            ) as precincts_vv
                FROM 		/*comelec_precincts cp
                INNER JOIN 	comelec_municipal muni ON (cp.mun_id = muni.mun_id)
                INNER JOIN 	comelec_province prov ON (muni.prov_id = prov.prov_id)
                INNER JOIN */	comelec_region reg /*ON (reg.rgn_id = prov.rgn_id)*/
                GROUP BY 	reg.rgn_id
                order by reg.region_ord";

//        printa($sql);

        $res = $this->conn->Execute($sql);

        $retVal = array();

        $national_tp =0;
        $national_tpr = 0;
        $national_pr = 0;
        $national_trv =0;
        while(!$res->EOF){
            $retVal['regions']['label'] = '';

            $retVal['regions'][$res->fields['rgn_id']] = $res->fields['region_name'];

            $retVal['rgn_data']['tp']['label'] = 'Total # Precincts';
            $retVal['rgn_data']['tp'][$res->fields['rgn_id']] = number_format($res->fields['total_precicnts'],null);
            
            $retVal['rgn_data']['pr']['label'] = 'Total Precincts Reported';
            $retVal['rgn_data']['pr'][$res->fields['rgn_id']] = number_format($res->fields['precincts_reported'],null);
            
            $retVal['rgn_data']['ppr']['label'] = '% Precincts Reported';

            $ppr = (($res->fields['precincts_reported'] / $res->fields['total_precicnts']) * 100);
            $retVal['rgn_data']['ppr'][$res->fields['rgn_id']] = number_format($ppr,2);

            $retVal['rgn_data']['rv']['label'] = 'Total Registered Voters';
            $retVal['rgn_data']['rv'][$res->fields['rgn_id']] = number_format($res->fields['precincts_numberofvoters'],null);

            $retVal['rgn_data']['vv']['label'] = 'Total Voters Voted';
            $retVal['rgn_data']['vv'][$res->fields['rgn_id']] = number_format($res->fields['precincts_vv'],null);

            $ppv = (($res->fields['precincts_vv'] / $res->fields['precincts_numberofvoters']) * 100);
            $retVal['rgn_data']['pvv']['label'] = '% Voters Voted';
            $retVal['rgn_data']['pvv'][$res->fields['rgn_id']] = number_format($ppv,2);

            $national_tp+=$res->fields['total_precicnts'];
            $national_tpr+=$res->fields['precincts_reported'];
            $national_pr+=$ppr;
            $national_trv+=$res->fields['precincts_numberofvoters'];
            $national_tvv+=$res->fields['precincts_vv'];

            $res->MoveNext();
            $a++;
        }

//        printa($national_tp);
//        printa($national_tpr);
//        printa($national_pr);
//        printa($national_trv);
        $a=0;
        
        foreach($retVal['regions'] as $rgn_id=>$region_name){

            if($a == 1){

                $newArr['National']='National';
                $newArr[$rgn_id] = $region_name;
                
            }else{
                $newArr[$rgn_id] = $region_name;
            }
            $a++;
        }
        
        $b=0;
        foreach($retVal['rgn_data']['tp'] as $rgn_id=>$tp){
            if($b == 1){
                $newArr_tp['National']=number_format($national_tp,null);
                $newArr_tp[$rgn_id] = $tp;

            }else{
                $newArr_tp[$rgn_id] = $tp;
            }

            $b++;
        }
        
        $c=0;
        foreach($retVal['rgn_data']['pr'] as $rgn_id=>$pr){
            if($c == 1){
                $newArr_pr['National']=number_format($national_tpr,null);
                $newArr_pr[$rgn_id] = $pr;

            }else{
                $newArr_pr[$rgn_id] = $pr;
            }

            $c++;
        }

//        $d=0;
//        foreach($retVal['rgn_data']['ppr'] as $rgn_id=>$ppr){
//
//            if($d == 1){
//                $newArr_ppr['National']=number_format($national_pr,4);
//                $newArr_ppr[$rgn_id] = $ppr;
//
//            }else{
//                $newArr_ppr[$rgn_id] = $ppr;
//            }
//
//            $d++;
//        }
        
        $e=0;
        foreach($retVal['rgn_data']['rv'] as $rgn_id=>$rv){

            if($e == 1){
                $newArr_tpr['National']=number_format($national_trv,null);
                $newArr_tpr[$rgn_id] = $rv;

            }else{
                $newArr_tpr[$rgn_id] = $rv;
            }

            $e++;
        }


        $retVal['regions'] = $newArr;
        $retVal['rgn_data']['tp'] = $newArr_tp;
        $retVal['rgn_data']['pr'] = $newArr_pr;
        $retVal['rgn_data']['ppr']['National'] = number_format(($national_tpr / $national_tp) * 100, 2);
//        $retVal['rgn_data']['ppr'] = $newArr_ppr;
        $retVal['rgn_data']['rv']['National']=number_format($national_trv,null);
        $retVal['rgn_data']['vv']['National']=number_format($national_tvv,null);
        $retVal['rgn_data']['pvv']['National']=number_format(($national_tvv / $national_trv) * 100, 2);
//        printa($retVal);
//        exit;
        return $retVal;


    }

    function fetchCandidates($candidate_post_id){

        $sql = "SELECT 		cpc.political_candidates_id,
                            cpc.political_candidates_name

                FROM  		comelec_candidate_votes ccv
                RIGHT JOIN 	comelec_political_candidates cpc  ON (ccv.candidates_id = cpc.political_candidates_id)
                LEFT JOIN 	comelec_precincts cp ON (cp.precints_id = ccv.precints_id)
                LEFT JOIN 	comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                LEFT JOIN 	comelec_province cprov ON (cm.prov_id = cprov.prov_id)

                WHERE		candidate_post_id=?
                GROUP BY 	cpc.political_candidates_id";

        $res = $this->conn->Execute($sql,$candidate_post_id);
        $retVal = array();

        while(!$res->EOF){

            $retVal[$res->fields['political_candidates_id']] = $res->fields;
            $res->MoveNext();
            
        }
        return $retVal;
    }

    function fetchRegionalCount($candidate_post_id){

        $qry = array();

        $qry[] = "cpc.candidate_post_id=?";
        if(isset($_GET['verified'])){
            $qry[] = "cp.precincts_status = 40";
        }
//        $qry[] = "cp.precincts_status = 40";

        $criteria = " WHERE ".implode(' and ',$qry);
        
        $sql = "SELECT 		cpc.political_candidates_id,
                            cpc.political_candidates_name,
                            SUM(ccv.cvotes_value) as vote_val,
                            SUM(ccv.cvotes_comelec) as vote_comelec,
                            SUM(ccv.cvotes_pcos) as vote_ppius,
                            cprov.rgn_id

                FROM  		comelec_candidate_votes ccv
                RIGHT JOIN 	comelec_political_candidates cpc  ON (ccv.candidates_id = cpc.political_candidates_id)
                LEFT JOIN 	comelec_precincts cp ON (cp.precints_id = ccv.precints_id)
                LEFT JOIN 	comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                LEFT JOIN 	comelec_province cprov ON (cm.prov_id = cprov.prov_id)

                {$criteria}
                GROUP BY 	cprov.rgn_id,cpc.political_candidates_id";

//printa($sql);

        $res = $this->conn->Execute($sql,$candidate_post_id);
        
        $retVal = array();

       
        while(!$res->EOF){

            $retVal[$res->fields['political_candidates_id']][$res->fields['rgn_id']]['ground_er'] = $res->fields['vote_val'];
            $retVal[$res->fields['political_candidates_id']][$res->fields['rgn_id']]['vote_comelec'] = $res->fields['vote_comelec'];
            $retVal[$res->fields['political_candidates_id']][$res->fields['rgn_id']]['pcos_machine'] = $res->fields['vote_ppius'];

           
            $res->MoveNext();

        }
        
//        printa($retVal);
//        exit;
        $a=0;

        foreach($retVal as $candidate_id=>$rpt_info){

            foreach($rpt_info as $region_id){

                $newArr_[$candidate_id]['t_ground_er']+=$region_id['ground_er'];
                $newArr_[$candidate_id]['t_pcos_machine']+=$region_id['pcos_machine'];
                $newArr_[$candidate_id]['t_comelec']+=$region_id['vote_comelec'];
            }
            
        }

        
        foreach($retVal as $candidate_id => $rpt_info){

            if($a== 0){
              $newArr['National'] = $newArr_;
                $newArr[$candidate_id] = $rpt_info;
            }else{
                $newArr[$candidate_id] = $rpt_info;
            }
            $a++;
        }
//
//        printa($newArr);
//        exit;
        return $newArr;
    }

		/**
	 * Get all the Table Listings
	 *
	 * @return array
	 */
	function getTableList( $user_id_ = null, $rgn_id_ = null){
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
			$aQryStr[] = "p=@@#tabs-1";
			$queryStr = implode("&",$aQryStr);
		}else{
            $queryStr = "p=@@#tabs-1";
        }

		//bby: search module
		$qry = array();
		if (isset($_REQUEST['search_field'])) {

			// lets check if the search field has a value
			if (strlen($_REQUEST['search_field'])>0) {
				// lets assign the request value in a variable
				$search_field = $_REQUEST['search_field'];

				// create a custom criteria in an array
				$qry[] = "prec.precincts_number like '%$search_field%'
                          or mun.municipal_name like '%$search_field%'
                          or brgy.barangay_name like '%$search_field%'
                        ";

			}
		}

		//	rview01
		//rview02
//     sen_partylist
//	
//	localtaguig
//	03vpmarikina
//	05vpmarikina

        $qry[] = "prec.precincts_status = 10";

        $user = AppUser::getData("user_name");
        if (AppUser::getData("user_name") == "rview01" || "rview02" || "sen_partylist" || "localtaguig" || "03vpmarikina" || "05vpmarikina") {
	        $urgn_id = AppUser::getData("rgn_id");
	        $uprov_id = AppUser::getData("prov_id");
	        $umun_id = AppUser::getData("mun_id");
		        if(!empty($umun_id)){
		            $qry[] = "mun.mun_id = '$umun_id'";
		        }elseif(!empty($uprov_id)){
		            $qry[] = "prov.prov_id = '$uprov_id'";
		        }elseif(!empty($urgn_id)){
		            $qry[] = "rgn.rgn_id = '$urgn_id'";
		        }
        }else{
            if(!is_null($rgn_id_)){
            	$qry[] = "rgn.rgn_id = '$rgn_id_'";
        	}
        }
        

		// put all query array into one criteria string
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

		// Sort field mapping
		$arrSortBy = array(
		 "region_name"=>"rgn.region_name"
		,"province_name"=>"prov.province_name"
		,"municipal_name"=>"mun.municipal_name"		
		);

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}

		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...
        $securityKey = "53cr3t";
		$viewLink = "";
		$getLM = $_GET['lm'];
		$editLink = "<a href=\"reports.php?statpos=view_municipality&lm=$getLM&mun_id=',mun.mun_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/find.gif\" title=\"View\" hspace=\"2px\" border=0></a>";
//		$editLink = "<a href=\"encoder.php?r=',sha1(concat(prec.precints_id,'$securityKey',rgn.rgn_id,prov.prov_id)),'&statpos=erentry&action=erp&e=',prec.precints_id,'&g=',rgn.rgn_id,'&v=',prov.prov_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";
		
        $flds = array();

		$flds[] = "distinct mun.municipal_name";
		$flds[] = "concat('<span title=\"', prov.province_name,'\" class=\"ui-icon ui-icon-info floatLeft theme-cursor-pointer\" ></span><span title=\"',prov.province_name,'\" class=\"hide-overflow\">',coalesce(prov.province_name,''),'</span>') as province_name";
        $flds[] = "rgn.region_name";
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
     *
     * @param <type> $cpi // candidate_post_id
     * @return <type> formatted HTML string containig table listings
     * makmakulet - may 06, 2010 ;)
     */
    function getProvincialTableListings($cpi = null){


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
			$aQryStr[] = "p=@@#tabs-1";
			$queryStr = implode("&",$aQryStr);
		}else{
            $queryStr = "p=@@#tabs-1";
        }

		//bby: search module
		$qry = array();
		if (isset($_REQUEST['search_field'])) {

			// lets check if the search field has a value
			if (strlen($_REQUEST['search_field'])>0) {
				// lets assign the request value in a variable
				$search_field = $_REQUEST['search_field'];

				// create a custom criteria in an array
				$qry[] = "prec.precincts_number like '%$search_field%'

                          or brgy.barangay_name like '%$search_field%'
                        ";

			}
		}

        $qry[] = "prec.precincts_status = 10";
        

		if (AppUser::getData("user_name") == "rview01" || "rview02" || "sen_partylist" || "localtaguig" || "03vpmarikina" || "05vpmarikina") {
	        $urgn_id = AppUser::getData("rgn_id");
	        $uprov_id = AppUser::getData("prov_id");
	        $umun_id = AppUser::getData("mun_id");

	        if(!empty($umun_id)){
	            $qry[] = "mun.mun_id = '$umun_id'";
	        }elseif(!empty($uprov_id)){
	            $qry[] = "prov.prov_id = '$uprov_id'";
	        }elseif(!empty($urgn_id)){
	            $qry[] = "rgn.rgn_id = '$urgn_id'";
	        }
		}else{
	        if(!is_null($rgn_id_)){
				$qry[] = "rgn.rgn_id = '$rgn_id_'";
	        }			
		}

		// put all query array into one criteria string
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

		// Sort field mapping
		$arrSortBy = array(
		 "region_name"=>"rgn.region_name"
		,"province_name"=>"prov.province_name"
		);

		if(isset($_GET['sortby'])){
			$strOrderBy = " order by ".$arrSortBy[$_GET['sortby']]." ".$_GET['sortof'];
		}

		// Add Option for Image Links or Inline Form eg: Checkbox, Textbox, etc...


		$editLink = "<a href=\"reports.php?statpos=view_provincial&cpi={$cpi}&prov_id=',prov.prov_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/find.gif\" title=\"View\" hspace=\"2px\" border=0></a>";
//		$editLink = "<a href=\"encoder.php?r=',sha1(concat(prec.precints_id,'$securityKey',rgn.rgn_id,prov.prov_id)),'&statpos=erentry&action=erp&e=',prec.precints_id,'&g=',rgn.rgn_id,'&v=',prov.prov_id,'\"><img src=\"".SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME."/images/admin/edit.gif\" title=\"Edit\" hspace=\"2px\" border=0></a>";


        $sql = "select  	DISTINCT rgn.region_name

                    		,concat('',coalesce(prov.province_name,''),'') as province_name

                            ,CONCAT('{$editLink}') as viewdata

                from 		comelec_precincts prec

                left join 	comelec_barangay brgy on brgy.barangay_id = prec.barangay_id                                                                           

                left join 	comelec_municipal mun on mun.mun_id = prec.mun_id

                left join 	comelec_province prov on prov.prov_id = mun.prov_id

                left join 	comelec_region rgn on rgn.rgn_id = prov.rgn_id

                $criteria

                $strOrderBy";


//                        printa($sql);
		// Sql query for paginator list
		// @note no need to use this. it replaced by sql function "FOUND_ROWS()"
		//$sqlcount = "select count(*) as mycount from app_modules $criteria";

		// Field and Table Header Mapping
		$arrFields = array(
		 "region_name"=>"Region"
		,"province_name"=>"Province"
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

    function fetchCandidatePost($cpi){

        $sql = "SELECT 	ccp.candidate_post_name
                FROM    comelec_candidate_post ccp
                WHERE   ccp.candidate_post_id=?";

        $res = $this->conn->Execute($sql,array($cpi));

        if(!$res->EOF){
            return $res->fields['candidate_post_name'];
        }
    }
}
?>