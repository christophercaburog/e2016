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
class clsViewTop{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsViewTop object
	 */
   
	function clsViewTop($dbconn_ = null){
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

    function initTopRankingReport(){

        $candidate_post = $this->fetchNationalElectionLevel();
        
        foreach($candidate_post as $cp_id=>$cp_name){
            $retVal[$cp_name] = $this->fetchTopFiveRanking($cp_id);
        }

        return $retVal;
        
    }

    function fetchNationalElectionLevel(){

        $sql = "SELECT 	    ccp.candidate_post_id,
                            ccp.candidate_post_name

                FROM 		comelec_candidate_post ccp
                INNER JOIN 	comelec_election_level cel ON (ccp.election_level_id = cel.election_level_id)

                WHERE 		cel.election_level_id=1";

        $res = $this->conn->Execute($sql);

        while(!$res->EOF){
            $retVal[$res->fields['candidate_post_id']] = $res->fields['candidate_post_name'];
            $res->MoveNext();
        }

        return $retVal;
        
    }

    function fetchTopFiveRanking($cpi= null){

        if($cpi == 3){
            $limit = 15;
        }else{
            $limit =5;
        }
        $sql = "SELECT 		SUM(ccv.cvotes_value) as vote_val,
                            cpc.political_candidates_name,
                            (SUM(ccv.cvotes_value) / (SELECT 		SUM(ccv.cvotes_value) as total_count
                            FROM 			comelec_candidate_votes ccv
                            LEFT JOIN 		comelec_political_candidates cpc ON (cpc.political_candidates_id = ccv.candidates_id)
                            LEFT JOIN 		comelec_candidate_post ccp ON (ccp.candidate_post_id = cpc.candidate_post_id)
                            WHERE 			ccp.candidate_post_id = {$cpi})) * 100 as percentage


                FROM  		comelec_candidate_votes ccv
                RIGHT JOIN 	comelec_political_candidates cpc  ON (ccv.candidates_id = cpc.political_candidates_id)
                LEFT JOIN 	comelec_precincts cp ON (cp.precints_id = ccv.precints_id)
                LEFT JOIN 	comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                LEFT JOIN 	comelec_province cprov ON (cm.prov_id = cprov.prov_id)

                WHERE		cpc.candidate_post_id={$cpi}
                GROUP BY 	cpc.political_candidates_id
                ORDER BY 	vote_val DESC, cpc.political_candidates_name
                LIMIT {$limit}";



//        printa($sql);
       

        $res = $this->conn->Execute($sql);
        
        while(!$res->EOF){
            $retVal[$res->fields['political_candidates_name']] = $res->fields['percentage'];
            $res->MoveNext();
        }


        return $retVal;
    }

}

?>