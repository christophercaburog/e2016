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


class clsViewProvincial{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsViewProvincial object
	 */
	function clsViewProvincial($dbconn_ = null){
        
		$this->conn =& $dbconn_;
        
	}

    function fetchCandidates($cpi=null,$prov_id){

       $sql = "SELECT 		cpc.political_candidates_id,
                            cpc.political_candidates_name

                FROM 		comelec_political_candidates cpc


                WHERE		cpc.candidate_post_id=? and cpc.prov_id=?";

//        printa($sql);

        $res = $this->conn->Execute($sql,array($cpi,$prov_id));

        while(!$res->EOF){

            $retVal['candidate'][$res->fields['political_candidates_id']] = $res->fields['political_candidates_name'];
            $res->MoveNext();

        }

        return $retVal;
    }


    function fetchMunicipalities($prov_id){
		$qry = array();
        if (AppUser::getData("user_name") == "rview01" || "rview02" || "sen_partylist" || "localtaguig" || "03vpmarikina" || "05vpmarikina") {
	        $umun_id = AppUser::getData("mun_id");
	
	        
	        if(!empty($umun_id)){
	            $qry[] = "cm.mun_id = '$umun_id'";
	        }
        }
            $qry[] = "cm.prov_id = '$prov_id'";
        
        	

        $criteria = (count($qry)>0)?" where ".implode(" and ",$qry):"";
        
        $sql = "SELECT		cm.mun_id
                            ,cm.municipal_name
                FROM 		comelec_municipal cm
                $criteria;
                ";


        
        $res = $this->conn->Execute($sql);

        while(!$res->EOF){

//            $retVal[] = $res->fields;
            $retVal[$res->fields['mun_id']] = $res->fields['municipal_name'];

            $res->MoveNext();

        }

        return $retVal;
        
    }

    function fetchMinucipalVotes($cpi,$prov_id){
        
        $sql = "SELECT 		cpc.political_candidates_id,
                            SUM(ccv.cvotes_value) as vote_val,
                            SUM(ccv.cvotes_comelec) as vote_comelec,
                            SUM(ccv.cvotes_pcos) as vote_pcos,
                            cm.mun_id

                FROM  		comelec_candidate_votes ccv
                RIGHT JOIN 	comelec_political_candidates cpc  ON (ccv.candidates_id = cpc.political_candidates_id)
                LEFT JOIN 	comelec_precincts cp ON (cp.precints_id = ccv.precints_id)
                LEFT JOIN 	comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                LEFT JOIN 	comelec_province cprov ON (cm.prov_id = cprov.prov_id)

                WHERE		cpc.candidate_post_id=? and cprov.prov_id=?
                GROUP BY 	cm.mun_id,cpc.political_candidates_id";

        $res = $this->conn->Execute($sql,array($cpi,$prov_id));

        while(!$res->EOF){
//            $retVal[] = $res->fields;
            $retVal[$res->fields['mun_id']][$res->fields['political_candidates_id']]['Pcos Machine'] = $res->fields['vote_pcos'];
            $retVal[$res->fields['mun_id']][$res->fields['political_candidates_id']]['Ground ER'] = $res->fields['vote_val'];
            $retVal[$res->fields['mun_id']][$res->fields['political_candidates_id']]['Comelec'] = $res->fields['vote_comelec'];

            $res->MoveNext();
        }
        
        return $retVal;
    }

    function initReport($cpi,$prov_id){

        $municipalities = $this->fetchMunicipalities($prov_id);

        $municipal_votes = $this->fetchMinucipalVotes($cpi,$prov_id);

        $retVal = array();

        foreach($municipalities as $mun_id=>$mun_name){

            $retVal[$mun_name]['mun_id'] = $mun_id;
            $retVal[$mun_name]['municipal_reports'] = $municipal_votes[$mun_id];
//            $retVal[$mun_name] = $municipal_votes[$mun_id];

        }

        return $retVal;

    }

    function fetchProvincialCount($cpi=null,$prov_id){

        $sql = "SELECT 		cpc.political_candidates_id,
                            SUM(ccv.cvotes_value) as vote_val

                FROM 		comelec_political_candidates cpc
                RIGHT JOIN 	comelec_candidate_votes ccv ON (ccv.candidates_id = cpc.political_candidates_id)
                LEFT JOIN 	comelec_precincts cp ON (cp.precints_id = ccv.precints_id)
                LEFT JOIN 	comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                LEFT JOIN 	comelec_province cprov ON (cm.prov_id = cprov.prov_id)
                WHERE		cpc.candidate_post_id=? and cm.prov_id=?
                GROUP BY 	cpc.political_candidates_id";

        $res = $this->conn->Execute($sql,array($cpi,$prov_id));

        while(!$res->EOF){

            $retVal[] = $res->fields;
            $res->MoveNext();

        }
            
        return $retVal;


    }

    function initCandidates($cpi=null,$prov_id){

        $candidate_names = $this->fetchCandidates($cpi,$prov_id);

        $candidate_counts = $this->fetchProvincialCount($cpi,$prov_id);

        $total_count = array();

        for($a=0;$a<count($candidate_counts);$a++){

            $total_count[$candidate_counts[$a]['political_candidates_id']]= $candidate_counts[$a]['vote_val'];
            
        }


        $candidate_names['total_votes'] = $total_count;

        return $candidate_names;

        
    }

}
?>