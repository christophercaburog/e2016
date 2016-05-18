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
class clsViewRegion{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsViewRegion object
	 */
	function clsViewRegion($dbconn_ = null){
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

    function fetchCandidatesTotalCount($candidate_post_id, $rgn_id){

        $sql = "SELECT 		cpc.political_candidates_id,
                            cpc.political_candidates_name,
                            SUM(ccv.cvotes_value) as vote_val

                FROM  		comelec_candidate_votes ccv
                RIGHT JOIN 	comelec_political_candidates cpc  ON (ccv.candidates_id = cpc.political_candidates_id)
                LEFT JOIN 	comelec_precincts cp ON (cp.precints_id = ccv.precints_id)
                LEFT JOIN 	comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                LEFT JOIN 	comelec_province cprov ON (cm.prov_id = cprov.prov_id)

                WHERE		cpc.candidate_post_id={$candidate_post_id} and cprov.rgn_id={$rgn_id}
                GROUP BY 	cpc.political_candidates_id";

                printa($sql);

        $res = $this->conn->Execute($sql);

        $retVal = array();

        while(!$res->EOF){

            $retVal['name'][$res->fields['political_candidates_id']] = $res->fields['political_candidates_name'];

            $retVal['total_votes'][$res->fields['political_candidates_id']] = $res->fields['vote_val'];

            $res->MoveNext();

        }

        return $retVal;
    }

    function fetchProvincesAndMunicipalities($rgn_id){

        $sql = "SELECT 		cprov.prov_id,
                            cprov.province_name,
                            cm.mun_id,
                            cm.municipal_name
                FROM 		comelec_province cprov
                LEFT JOIN 	comelec_municipal cm ON (cm.prov_id = cprov.prov_id)
                LEFT JOIN 	comelec_region cr ON (cr.rgn_id = cprov.rgn_id)
                WHERE		cr.rgn_id=?";

//                printa($sql);

        $res = $this->conn->Execute($sql,array($rgn_id));

        $a=0;
        
        while(!$res->EOF){

            $tmp[$res->fields['prov_id']][$res->fields['mun_id']]['municipal_name'] = $res->fields['municipal_name'];
            
            $retVal['province'][$res->fields['prov_id']][$res->fields['province_name']]= array();
            $retVal['province'][$res->fields['prov_id']]['municipal']= $tmp[$res->fields['prov_id']];
    
            $res->MoveNext();
            
        }
        
        return $retVal;
        
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

    function fetchCandidateVotesPerRegion($cpi,$rgn_id){

        $qry[] = "cpc.candidate_post_id=?";
        $qry[] = "cprov.rgn_id=?";
        if(isset($_GET['verified'])){
            $qry[] = "cp.precincts_status=40";
        }
//        $qry[] = "cp.precincts_status=40";

        $criteria = " WHERE ".implode(' and ',$qry);
        
        $sql = "SELECT 		cpc.political_candidates_id,
                            cpc.political_candidates_name,
                            SUM(ccv.cvotes_value) as vote_val

                FROM  		comelec_candidate_votes ccv
                RIGHT JOIN 	comelec_political_candidates cpc  ON (ccv.candidates_id = cpc.political_candidates_id)
                LEFT JOIN 	comelec_precincts cp ON (cp.precints_id = ccv.precints_id)
                LEFT JOIN 	comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                LEFT JOIN 	comelec_province cprov ON (cm.prov_id = cprov.prov_id)

                {$criteria}
                GROUP BY 	cpc.political_candidates_id";

//                printa($sql);

        $res = $this->conn->Execute($sql,array($cpi,$rgn_id));

        while(!$res->EOF){
            $retVal[] = $res->fields;
            $res->MoveNext();
        }

        return $retVal;
    }

    function initCandidates($cpi, $rgn_id){

        $candidates = $this->fetchCandidates($cpi);

        $candidate_votes = $this->fetchCandidateVotesPerRegion($cpi, $rgn_id);

        $total_count = array();

        for($a=0;$a<count($candidate_votes);$a++){

            $total_count[$candidate_votes[$a]['political_candidates_id']]= $candidate_votes[$a]['vote_val'];

        }

        $candidates['total_votes'] = $total_count;
        

        return $candidates;
        
    }

    function initReport($cpi,$rgn_id){

        $provinces = $this->fetchProvincesAndMunicipalities($rgn_id);

        $provincial_count = $this->fetchProvincialCount($cpi,$rgn_id);

        for($a=0;$a<count($provincial_count);$a++){
            $provinces['province'][$provincial_count[$a]['prov_id']][$provincial_count[$a]['province_name']][$provincial_count[$a]['political_candidates_id']]['Pcos Machine'] = $provincial_count[$a]['vote_ppius'];
            $provinces['province'][$provincial_count[$a]['prov_id']][$provincial_count[$a]['province_name']][$provincial_count[$a]['political_candidates_id']]['Ground ER'] = $provincial_count[$a]['vote_val'];
            $provinces['province'][$provincial_count[$a]['prov_id']][$provincial_count[$a]['province_name']][$provincial_count[$a]['political_candidates_id']]['Comelec'] = $provincial_count[$a]['vote_comelec'];
        }
//        printa($provinces);
        $municipal_count = $this->fetchProvincialAndMunicipalitiesCount($cpi,$rgn_id);

        for($b=0;$b<count($municipal_count);$b++){

            $provinces['province'][$municipal_count[$b]['prov_id']]['municipal'][$municipal_count[$b]['mun_id']][$municipal_count[$b]['political_candidates_id']]['Pcos Machine'] = $municipal_count[$b]['vote_ppius'];
            $provinces['province'][$municipal_count[$b]['prov_id']]['municipal'][$municipal_count[$b]['mun_id']][$municipal_count[$b]['political_candidates_id']]['Ground ER'] = $municipal_count[$b]['vote_val'];
            $provinces['province'][$municipal_count[$b]['prov_id']]['municipal'][$municipal_count[$b]['mun_id']][$municipal_count[$b]['political_candidates_id']]['Comelec'] = $municipal_count[$b]['vote_comelec'];

        }
        
        return $provinces;

    }

    function fetchProvincialCount($cpi,$rgn_id){

        $qry = array();
        
        $qry[] = "cpc.candidate_post_id=?";
        $qry[] = "cprov.rgn_id =?";
        if(isset($_GET['verified'])){
            $qry[] = "cp.precincts_status =40";
        }
//        $qry[] = "cp.precincts_status =40";

        $criteria = " WHERE ".implode(' and ',$qry);

        $sql ="SELECT           cpc.political_candidates_id,
                                cpc.political_candidates_name,
                                SUM(ccv.cvotes_value) as vote_val,
                                SUM(ccv.cvotes_comelec) as vote_comelec,
                                SUM(ccv.cvotes_pcos) as vote_ppius,

                                cprov.province_name,
                                cprov.prov_id


                FROM            comelec_candidate_votes ccv
                RIGHT JOIN      comelec_political_candidates cpc  ON (ccv.candidates_id = cpc.political_candidates_id)
                LEFT JOIN       comelec_precincts cp ON (cp.precints_id = ccv.precints_id)
                LEFT JOIN       comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                LEFT JOIN       comelec_province cprov ON (cm.prov_id = cprov.prov_id)
                {$criteria}
                GROUP BY        cprov.prov_id,cpc.political_candidates_id ";

         $res = $this->conn->Execute($sql,array($cpi,$rgn_id));

//         printa($res);

         $retVal = array();
         while(!$res->EOF){
            $retVal[] = $res->fields;
            $res->MoveNext();
         }

         return $retVal;
    }

    function fetchProvincialAndMunicipalitiesCount($cpi, $rgn_id){
        
        $qry = array();

        $qry[] = "cpc.candidate_post_id=?";
        $qry[] = "cprov.rgn_id =?";
        if(isset($_GET['verified'])){
            $qry[] = "cp.precincts_status =40";
        }
//        $qry[] = "cp.precincts_status =40";

        $criteria = " WHERE ".implode(' and ',$qry);

        $sql = "SELECT          cpc.political_candidates_id,
                                cpc.political_candidates_name,
                                SUM(ccv.cvotes_value) as vote_val,
                                SUM(ccv.cvotes_comelec) as vote_comelec,
                                SUM(ccv.cvotes_pcos) as vote_ppius,

                                cprov.province_name,
                                cprov.prov_id,
                                cm.mun_id,
                                cm.municipal_name

                FROM            comelec_candidate_votes ccv
                RIGHT JOIN      comelec_political_candidates cpc  ON (ccv.candidates_id = cpc.political_candidates_id)
                LEFT JOIN       comelec_precincts cp ON (cp.precints_id = ccv.precints_id)
                LEFT JOIN       comelec_municipal cm ON (cm.mun_id = cp.mun_id)
                LEFT JOIN       comelec_province cprov ON (cm.prov_id = cprov.prov_id)

                {$criteria}
                GROUP BY        cm.mun_id,cprov.prov_id,cpc.political_candidates_id ";

//                printa($sql);
        $res = $this->conn->Execute($sql,array($cpi,$rgn_id));

        while(!$res->EOF){
            
            $retVal[] = $res->fields;
//            $retVal[$res->['']]
            $res->MoveNext();
        }
//        printa($retVal);
//        exit;
        return $retVal;
        
//
//        printa($sql);
//        exit;

    }

}
?>