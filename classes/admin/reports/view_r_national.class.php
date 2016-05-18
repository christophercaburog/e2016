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
class clsViewRnational{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsViewRnational object
	 */
	function clsViewRnational($dbconn_ = null){
		$this->conn =& $dbconn_;
	
	}

    function fetchCandidatePostName($cpi=null){

        $sql = "SELECT  ccp.candidate_post_name
                FROM    comelec_candidate_post ccp
                WHERE   ccp.candidate_post_id={$cpi}";

        $res = $this->conn->Execute($sql);

        if(!$res->EOF){
            return $res->fields['candidate_post_name'];
        }

    }

    function initCandidates($rgn_id=null,$cpi=null,$mun_id=null){

        $candidates = $this->fetchCandidates($cpi);

        $candidate_votes = $this->fetchCandidateVotesPerMunicipality($cpi,$rgn_id,$mun_id);
//printa($candidate_votes);
        $total_count = array();

        foreach($candidates['candidate'] as $candidate_id => $candidate_name){

            $total_count[$candidate_id]= $candidate_votes[$candidate_id];
//            $total_count[$candidate_id]= $candidate_votes[$candidate_id]['vote_val'];

        }

        $candidates['total_votes'] = $total_count;

//        printa($candidates);
        return $candidates;
    }

    function fetchCandidates($cpi=null){

        $sql = "SELECT  	cpc. political_candidates_id,
                            cpc.political_candidates_name

                FROM 		comelec_political_candidates cpc
                WHERE		cpc.candidate_post_id = ?";

        $res = $this->conn->Execute($sql,array($cpi));

        while(!$res->EOF){

            $retVal['candidate'][$res->fields['political_candidates_id']] = $res->fields['political_candidates_name'];

            $res->MoveNext();

        }
        return $retVal;
    }

    function fetchPrecincts($mun_id=null){
//        $brgy=$this->fetchBrgyAndPrecincts($mun_id);
//		printa($brgy);exit;
		$sql = "select cp.precincts_number 
					   ,cb.barangay_name
					   ,cb.barangay_id
					   ,cp.precints_id
				from comelec_barangay cb 
				left join comelec_precincts cp on cb.barangay_id = cp.barangay_id
				where cp.mun_id = {$_GET['mun_id']}
				order by cb.barangay_name";
		$res = $this->conn->Execute($sql);
		while(!$res->EOF){
            $precinct[$res->fields['barangay_id']]['brgy'] = $res->fields['barangay_name'];
            $precinct[$res->fields['barangay_id']]['precincts'][$res->fields['precints_id']]['precinct_number'] = $res->fields['precincts_number'];
            $res->MoveNext();
        }
//        printa($precinct);exit;
        return $precinct;
    }

    function fetchCandidateVotesPerMunicipality($cpi = null,$rgn_id = null,$mun_id=null){

        $qry[] = "cpc.candidate_post_id='$cpi'";
//        $qry[] = "cprov.rgn_id='$rgn_id'";
//        $qry[] = "cm.mun_id='$mun_id'";
        if(isset($_GET['verified'])){
            $qry[] = "cp.precincts_status=40";
        }else{
            $qry[] = "cp.precincts_status=10";
        }
        

        $criteria = " WHERE ".implode(' and ',$qry);

        $sql = "SELECT 		ccv.candidates_id,
                            SUM(ccv.cvotes_value) as vote_val

                FROM  		comelec_candidate_votes ccv
                LEFT JOIN comelec_political_candidates cpc
                    on cpc.political_candidates_id=ccv.candidates_id
                LEFT JOIN 	comelec_precincts cp ON (cp.mun_id = $mun_id)
                {$criteria}
                GROUP BY 	cpc.political_candidates_id";

//                printa($sql);

        $res = $this->conn->Execute($sql);

        while(!$res->EOF){
            $retVal[$res->fields['candidates_id']] = $res->fields['vote_val']+0;
            $res->MoveNext();
        }
//printa($retVal);
        return $retVal;
    }

    function initReport($cpi=null,$rgn_id=null,$mun_id=null){

        $brgy =  $this->fetchBrgyAndPrecincts($mun_id);
//        return $brgy;
//
        

//        $brgy_count = $this->fetchBrgyCount($cpi,$rgn_id,$mun_id);
//
// //       printa($brgy_count);exit;
//        
//
//        for($a=0;$a<count($brgy_count);$a++){
//        	
//            
////            $brgy[$brgy_count[$a]['barangay_id']][$brgy[$brgy_count[$a]['barangay_id']]['brgy']][$brgy_count[$a]['political_candidates_id']]['Pcos Machine'] = $brgy_count[$a]['vote_ppius'];
////            $brgy[$brgy_count[$a]['barangay_id']][$brgy[$brgy_count[$a]['barangay_id']]['brgy']][$brgy_count[$a]['political_candidates_id']]['Ground ER'] = $brgy_count[$a]['vote_val'];
////            $brgy[$brgy_count[$a]['barangay_id']][$brgy[$brgy_count[$a]['barangay_id']]['brgy']][$brgy_count[$a]['political_candidates_id']]['Comelec'] = $brgy_count[$a]['vote_comelec'];
//
////            $brgy[$brgy_count[$a]['barangay_id']]['precincts'] = $brgy[$brgy_count[$a]['barangay_id']]['precincts'];
////			  if($brgy_count[$a]['precints_id'] == $brgy[$brgy_count[$a]['barangay_id']]['precincts'][$brgy_count[$a]['precints_id']]['precincts_id']){
////			  	  $brgy[$brgy_count[$a]['barangay_id']]['precincts'][$brgy_count[$a]['precints_id']]['candidates']['ground_er'] = $brgy_count[$a]['vote_val'];
////			  	  $brgy[$brgy_count[$a]['barangay_id']]['precincts'][$brgy_count[$a]['precints_id']]['candidates']['comelec'] = $brgy_count[$a]['vote_comelec'];
////			  	  $brgy[$brgy_count[$a]['barangay_id']]['precincts'][$brgy_count[$a]['precints_id']]['candidates']['ppius'] = $brgy_count[$a]['vote_ppius'];
////			  }
//			  
//        }

//        $precinct_count = $this->fetchPrecinctCount($cpi,$mun_id);
//        printa($precinct_count);exit;

//        for($b=0;$b<count($precinct_count);$b++){
//            $newArr[$precinct_count[$b]['barangay_id']]['precincts'][] ='';
//            $newArr__[$precinct_count[$b]['barangay_id']]['precincts'][$newArr[$precinct_count[$b]['barangay_id']]['precincts'][$precinct_count[$b]['precints_id']]][$precinct_count[$b]['political_candidates_id']]['Pcos Machine'] = $precinct_count[$b]['vote_ppius'];
//            $newArr__[$precinct_count[$b]['barangay_id']]['precincts'][$newArr[$precinct_count[$b]['barangay_id']]['precincts'][$precinct_count[$b]['precints_id']]][$precinct_count[$b]['political_candidates_id']]['Ground ER'] = $precinct_count[$b]['vote_val'];
//            $newArr__[$precinct_count[$b]['barangay_id']]['precincts'][$newArr[$precinct_count[$b]['barangay_id']]['precincts'][$precinct_count[$b]['precints_id']]][$precinct_count[$b]['political_candidates_id']]['Comelec'] = $precinct_count[$b]['vote_comelec'];

//          $newArr__[$precinct_count[$b]['barangay_id']]['precincts'][$precinct_count[$b]['precincts_number']][$precinct_count[$b]['political_candidates_id']]['Pcos Machine'] = $precinct_count[$b]['vote_ppius'];
//          $newArr__[$precinct_count[$b]['barangay_id']]['precincts'][$precinct_count[$b]['precincts_number']][$precinct_count[$b]['political_candidates_id']]['Ground ER'] = $precinct_count[$b]['vote_val'];
//          $newArr__[$precinct_count[$b]['barangay_id']]['precincts'][$precinct_count[$b]['precincts_number']][$precinct_count[$b]['political_candidates_id']]['Comelec'] = $precinct_count[$b]['vote_comelec'];

//          $newArr__[$precinct_count[$b]['precincts_number']][$precinct_count[$b]['political_candidates_id']]['Pcos Machine'] = $precinct_count[$b]['vote_ppius'];
//          $newArr__[$precinct_count[$b]['precincts_number']][$precinct_count[$b]['political_candidates_id']]['Ground ER'] = $precinct_count[$b]['vote_val'];
//          $newArr__[$precinct_count[$b]['precincts_number']][$precinct_count[$b]['political_candidates_id']]['Comelec'] = $precinct_count[$b]['vote_comelec'];

//            $brgy[$precinct_count[$b]['barangay_id']]['precincts'][$precinct_count[$b]['precints_id']][$precinct_count[$b]['political_candidates_id']]['Pcos Machine'] = $precinct_count[$b]['vote_ppius'];
//            $brgy[$precinct_count[$b]['barangay_id']]['precincts'][$precinct_count[$b]['precints_id']][$precinct_count[$b]['political_candidates_id']]['Ground ER'] = $precinct_count[$b]['vote_val'];
//            $brgy[$precinct_count[$b]['barangay_id']]['precincts'][$precinct_count[$b]['precints_id']][$precinct_count[$b]['political_candidates_id']]['Comelec'] = $precinct_count[$b]['vote_comelec'];
//            $newArr[$precinct_count[$b]['barangay_id']]['precincts'] = $newArr__;
//          
//        }

//        printa($brgy);
//
//  exit;
        return $brgy;
        
    }

    function fetchPrecinctCount($cpi,$mnu_id){

        $sql ="SELECT     cpc.political_candidates_id
           	                     ,cpc.political_candidates_name
                                ,COALESCE(SUM(ccv.cvotes_value),0) as vote_val
                                ,COALESCE(SUM(ccv.cvotes_comelec),0) as vote_comelec
                                ,COALESCE(SUM(ccv.cvotes_pcos),0) as vote_ppius
                                ,cp.precints_id
								,cp.precincts_number
                                ,cb.barangay_id

                 FROM            comelec_candidate_votes ccv
                 RIGHT JOIN      comelec_political_candidates cpc  ON (ccv.candidates_id = cpc.political_candidates_id)
                 LEFT JOIN       comelec_precincts cp ON (cp.precints_id = ccv.precints_id)
                 LEFT JOIN      comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                LEFT JOIN 	comelec_barangay cb ON (cb.mun_id = cm.mun_id)
                 where cpc.candidate_post_id  = ? and cm.mun_id  = ? and cp.precincts_status = 40
                 GROUP BY cp.precints_id,cpc.political_candidates_id
                ";

        $res = $this->conn->Execute($sql,array($cpi,$mnu_id));
        $retVal = array();
        while(!$res->EOF){
            $retVal[] = $res->fields;
            $res->MoveNext();
        }

        return $retVal;


    }



    function fetchBrgyAndPrecincts($mun_id = null){
        if(isset($_GET['verified'])){
            $subQryCriteria = " and cp.precincts_status = 40";
        }
        $sql ="select        	cb.barangay_id
                                ,cb.barangay_name
                                ,cp.precints_id
                                ,CONCAT('(',cp.precincts_cgroupno,') ',cp.precincts_number) as precincts_number
                                ,ccv.cvotes_value
                                ,ccv.cvotes_comelec
                                ,ccv.cvotes_pcos
                                ,cpc.political_candidates_name
                                ,cpc.political_candidates_id
                FROM 		comelec_barangay cb
                inner JOIN 	comelec_precincts cp ON (cb.barangay_id = cp.barangay_id)
                inner JOIN	comelec_candidate_votes ccv on (ccv.precints_id = cp.precints_id)
                inner JOIN 	comelec_political_candidates cpc ON (cpc.political_candidates_id = ccv.candidates_id)
                WHERE   	cb.mun_id =? and cpc.candidate_post_id = {$_GET['cpi']} $subQryCriteria";
//                printa($sql);
        $res = $this->conn->Execute($sql,array($mun_id));

//        ;exit;

        $retVal = array();
        while(!$res->EOF){
//            $retVal[$res->fields['barangay_id']]['brgy'] = $res->fields['barangay_name'];
//            
//            $retVal[$res->fields['barangay_id']]['precincts'][$res->fields['precints_id']]['precincts_id'] = $res->fields['precints_id'];
//            $retVal[$res->fields['barangay_id']]['precincts'][$res->fields['precints_id']]['precinct_number'] = $res->fields['precincts_number'];
//            $retVal[$res->fields['barangay_id']]['precincts'][$res->fields['precincts_number']] = array();
//			printa($res->fields);
			$retVal[$res->fields['political_candidates_id']][$res->fields['precints_id']]['ground_er'] = $res->fields['cvotes_value'];
			$retVal[$res->fields['political_candidates_id']][$res->fields['precints_id']]['comelec'] = $res->fields['cvotes_comelec'];
			$retVal[$res->fields['political_candidates_id']][$res->fields['precints_id']]['pcos'] = $res->fields['cvotes_pcos'];
            $res->MoveNext();
        }
//        exit;

        return $retVal;
        
    }

    function fetchBrgyCount($cpi=null,$rgn_id=null,$mun_id=null){

        $sql = "SELECT          cpc.political_candidates_id,
                                cpc.political_candidates_name,
                                SUM(ccv.cvotes_value) as vote_val,
                                SUM(ccv.cvotes_comelec) as vote_comelec,
                                SUM(ccv.cvotes_pcos) as vote_ppius,
                                cm.mun_id,
                                cm.municipal_name,
                                cp.precints_id,
                                cb.barangay_id
                FROM            comelec_candidate_votes ccv
                RIGHT JOIN      comelec_political_candidates cpc  ON (ccv.candidates_id = cpc.political_candidates_id)
                LEFT JOIN       comelec_precincts cp ON (cp.precints_id = ccv.precints_id)
                LEFT JOIN       comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                LEFT JOIN       comelec_barangay cb ON (cb.mun_id = cm.mun_id)
                WHERE           cpc.candidate_post_id='{$cpi}' and cm.mun_id={$mun_id} and cp.precincts_status =10
                GROUP BY        cb.barangay_id,cpc.political_candidates_id,cp.precints_id";


//printa($sql);
        $res = $this->conn->Execute($sql);

        while(!$res->EOF){
            $retVal[] = $res->fields;
            $res->MoveNext();
        }
//		printa($retVal);exit;
        return $retVal;
    }

   function fetchBrgyPrec($mun_id){

        $sql = "select
        		cb.barangay_id
				,cb.barangay_name
				,cp.precints_id
				,CONCAT('(',cp.precincts_cgroupno,') ',cp.precincts_number) as precincts_number
				from comelec_barangay cb
				LEFT JOIN comelec_precincts cp ON (cb.barangay_id = cp.barangay_id)
				WHERE   cb.mun_id ={$mun_id}
				";
//                printa($sql);
        $res = $this->conn->Execute($sql);

        $a=0;
        $retVal = array();
        while(!$res->EOF){

            $rets[] = $res->fields;
			//temp removed (municipality name)
		    $retVal[$res->fields['barangay_id']][$res->fields['barangay_name']] = 1;
		    $retVal[$res->fields['barangay_id']]['precincts'][$res->fields['precints_id']] = $res->fields['precincts_number'];

            $res->MoveNext();

        }
//        printa($rets);
//            printa($retVal);exit;
        return $retVal;

    }
    
    
    function fetchCount($mun_id,$cpi){
        
			$qry = array();
			$qry[] = "cpc.candidate_post_id  = $cpi";
			$qry[] = "cm.mun_id  = $mun_id";
			$qry[] = "cp.precincts_status = 40";
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
        $res = $this->conn->Execute($sql);
	  	$retValue = array();
		

		$retval =$this->fetchBrgyPrec($mun_id);
	  	
  		while(!$res->EOF){
			  
			 	$retValue[$res->fields['precints_id']][$res->fields['political_candidates_id']]['Pcos Machine'] =  $res->fields['vote_comelec'];
			 	$retValue[$res->fields['precints_id']][$res->fields['political_candidates_id']]['Ground ER'] =  $res->fields['vote_val'];
			 	$retValue[$res->fields['precints_id']][$res->fields['political_candidates_id']]['Comelec'] =  $res->fields['vote_comelec'];

         $res->MoveNext();
	
        }
        
        return $retValue;
        
    }



}
