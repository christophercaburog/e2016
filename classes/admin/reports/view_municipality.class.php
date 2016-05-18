<?php
ini_set('display_errors',1);
/**
 * Initial Declaration
 */

/**
 * Class Module
 *
 * @author  Arnold P. Orbista
 *
 */
class clsViewMunicipality{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsViewRegion object
	 */
	function clsViewMunicipality($dbconn_ = null){
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

//        $this->conn->debug = 1;
	}

    function fetchCandidates($candidate_post_id, $mun_id){

		$qry = array();
		$qry[] = "cpc.candidate_post_id  = $candidate_post_id";
		$qry[] = "cm.mun_id  = $mun_id";
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";
		$sql = "select 
					cpc.political_candidates_id
					,cpc.political_candidates_name
		
					FROM	comelec_political_candidates cpc 
					LEFT JOIN comelec_municipal cm ON (cpc.mun_id = cm.mun_id)
					LEFT  JOIN comelec_precincts cp ON (cm.mun_id = cp.mun_id)
					$criteria
					GROUP BY cpc.political_candidates_id 
				";
//		printa($sql);
        $res = $this->conn->Execute($sql);

        $retVal = array();

        while(!$res->EOF){
			
            $retVal['name'][$res->fields['political_candidates_id']] = $res->fields['political_candidates_name'];
		
            $res->MoveNext();

        }

        return $retVal;
    }

    
    function fetchCandidatesTotalCount($candidate_post_id, $mun_id){

		$qry = array();
		$qry[] = "cpc.candidate_post_id  = $candidate_post_id";
		$qry[] = "cm.mun_id  = $mun_id";
//		$qry[] = "cp.precincts_status = 40";
		$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";
		
        $sql = "SELECT 		cpc.political_candidates_id
                            ,SUM(ccv.cvotes_value) as vote_val
		
                FROM  		comelec_candidate_votes ccv
                RIGHT JOIN 	comelec_political_candidates cpc  ON (ccv.candidates_id = cpc.political_candidates_id)
                LEFT JOIN 	comelec_precincts cp ON (cp.precints_id = ccv.precints_id)
                LEFT JOIN 	comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                $criteria
                GROUP BY 	cpc.political_candidates_id
        ";

        $res = $this->conn->Execute($sql);

        $retVal = array();

        while(!$res->EOF){
            $retVal[] = $res->fields;
//            $retVal['total_votes'][$res->fields['political_candidates_id']] = $res->fields['vote_val'];

            $res->MoveNext();

        }
        
//        printa($retVal);
//        exit();
//
        return $retVal;
    }
    function fetchBrgyPrec($mun_id){


        $sql = "select 
        		cb.barangay_id
				,cb.barangay_name
				,cp.precints_id
				,cp.precincts_number
				,cp.precincts_cgroupno
				from comelec_barangay cb
				LEFT JOIN comelec_precincts cp ON (cb.barangay_id = cp.barangay_id)
				WHERE   cb.mun_id ={$mun_id}
				";

        
        $res = $this->conn->Execute($sql);

        $a=0;
        $retVal = array();
        while(!$res->EOF){

            $rets[] = $res->fields;
			//temp removed (municipality name)
		    $retVal[$res->fields['barangay_id']] = $res->fields['barangay_name'];
		
	         $retVal[$res->fields['precints_id']] = "(". $res->fields['precincts_cgroupno']. ") ".$res->fields['precincts_number'];
       	    
            $res->MoveNext();
            

        }
        
//        printa($rets);
//        exit();

        return $retVal;
        
    }

	function fetchCount($mun_id,$cpi){
			$qry = array();
			$qry[] = "cpc.candidate_post_id  = $cpi";
			$qry[] = "cm.mun_id  = $mun_id";
//			$qry[] = "cp.precincts_status = 40";
			$criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";

              $sql = "SELECT     cpc.political_candidates_id
           	                     ,cpc.political_candidates_name
                                ,COALESCE(SUM(ccv.cvotes_value),0) as vote_val
                                ,COALESCE(SUM(ccv.cvotes_comelec),0) as vote_comelec
                                ,COALESCE(SUM(ccv.cvotes_pcos),0) as vote_ppius
                                ,cp.precints_id
								,cp.precincts_number
								
                 FROM            comelec_candidate_votes ccv
                 RIGHT JOIN      comelec_political_candidates cpc  ON (ccv.candidates_id = cpc.political_candidates_id)
                 LEFT JOIN       comelec_precincts cp ON (cp.precints_id = ccv.precints_id) 
                 LEFT JOIN 	comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                $criteria
                 GROUP BY cp.precincts_number,cpc.political_candidates_id
                ";

//        printa($sql);
        $res = $this->conn->Execute($sql);
	  	$retValue = array();
		

		$retval =$this->fetchBrgyPrec($mun_id);
	  	
  		while(!$res->EOF){
                                // removed this data assignment 
			 	//$retValue[$res->fields['precints_id']][$res->fields['political_candidates_id']]['Pcos Machine'] =  $res->fields['vote_comelec'];
			 	$retValue[$res->fields['precints_id']][$res->fields['political_candidates_id']]['Ground ER'] =  $res->fields['vote_val'];
			 	$retValue[$res->fields['precints_id']][$res->fields['political_candidates_id']]['Comelec'] =  $res->fields['vote_comelec'];

//			printa($a);
         $res->MoveNext();
	
        }
        
//        printa($retValue);
//        printa($res);exit();
        return $retValue;
        
    }
 	function initReport($cpi,$mun_id){

        $precint = $this->fetchBrgyPrec($_GET['mun_id']);
        
		$precint_votes = $this->fetchCount($_GET['mun_id'],$_GET['lm']);
	
        $retVal = array();

        foreach($precint as $prec_id=>$prec_name){

            $retVal[$prec_name] = $precint_votes[$prec_id];
		
        }

        return $retVal;

    }
 	function initCandidates($cpi=null,$mun_id){

        $candidate_names = $this->fetchCandidates($cpi,$mun_id);

        $candidate_counts = $this->fetchCandidatesTotalCount($cpi,$mun_id);

        $total_count = array();
		$precint_total_count = array();
        for($a=0;$a<count($candidate_counts);$a++){

            $total_count[$candidate_counts[$a]['political_candidates_id']]= $candidate_counts[$a]['vote_val'];
//            $total_count[$candidate_counts[$a]['political_candidates_id']]= $candidate_counts[$a]['precincts_numberofvoters'];
            
        }
        


        $candidate_names['total_votes'] = $total_count;

        return $candidate_names;

		
    }
}
?>