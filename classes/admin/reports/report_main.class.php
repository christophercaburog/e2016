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
class clsReportMain{

	var $conn;
	var $fieldMap;
	var $Data;

	/**
	 * Class Constructor
	 *
	 * @param object $dbconn_
	 * @return clsReportMain object
	 */
	function clsReportMain($dbconn_ = null){
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

    /**
     * method to fetch Election levels on table `comelec_election_level`
     * @param no params
     * @return returns an array containing election level details
     * 
     */
    function fetchElectionLevels(){

        $sql = "SELECT      cel.election_level_id,
                            cel.election_level_name


                FROM        comelec_election_level cel
                /* WHERE       cel.election_level_id !=3 */
                ORDER BY    cel.election_level_order";

        $res = $this->conn->Execute($sql);

        $retVal = array();

        while(!$res->EOF){

            $retVal[] = $res->fields;

            $res->MoveNext();
        }

        return $retVal;
    }

    /**
     * method to fetch candidate position details for a certain election level id
     * @param int $election_level_id
     * @return array containing candidate post
     */
    function fetchCandidatePost($election_level_id){

        $sql = "SELECT  ccp.candidate_post_id,
                        ccp.candidate_post_name

                FROM    comelec_candidate_post ccp
                WHERE   ccp.election_level_id=?";

        $res = $this->conn->Execute($sql,$election_level_id);

        $retVal = array();

        while(!$res->EOF){

            $retVal[] = $res->fields;

            $res->MoveNext();
        }

        return $retVal;
    }



        /**
     * method to fetch all menu needed for generating reports
     * @params null
     * @return returns a formatted array containing report menus with parent and child relationship
       uses submethods  fetchElectionLevels() and fetchCandidatePost()
     */
   function fetchReportMenu(){

        $election_levels = $this->fetchElectionLevels();

        $retVal = array();

        for($a=0;$a<count($election_levels);$a++){
            $retVal[$election_levels[$a]['election_level_name']] = $this->fetchCandidatePost($election_levels[$a]['election_level_id']);
        }


        return $retVal;
   }

   function getDiscrepancyReport($isAll_ = 1){

       $flds = array();
       $flds[] = "cprec.precints_id";
       $flds[] = "cprec.precincts_status";
       $flds[] = "reg.region_name";
       $flds[] = "prov.province_name";
       $flds[] = "mun.municipal_name";
       $flds[] = "brgy.barangay_name";
       $flds[] = "cv.precincts_code";
       $flds[] = "cprec.precincts_number";
       $flds[] = "ccp.candidate_post_name";
       $flds[] = "cv.candidates_id";
       $flds[] = "cpc.political_candidates_name";
       $flds[] = "cv.cvotes_value as ground_er";
       $flds[] = "cv.cvotes_pcos as pcos";
       $fields = implode(",",$flds);

       $qry = array();
       $qry[] = "cv.precincts_code > 0";
       $qry[] = "cv.cvotes_value != cv.cvotes_pcos";
       $qry[] = "cv.cvotes_value > 0";
       $qry[] = "cv.cvotes_pcos > 0";
       if(!$isAll_){
           $qry[] = "cprec.precincts_status  = 40";
       }
       $criteria = " where ".implode(" and ", $qry);

       $sql = "SELECT $fields
            FROM comelec_candidate_votes cv
            inner join comelec_precincts cprec on cprec.precints_id =  cv.precints_id
            inner join comelec_barangay brgy on brgy.barangay_id = cprec.barangay_id
            inner join comelec_municipal mun on mun.mun_id = brgy.mun_id
            inner join comelec_province prov on prov.prov_id = mun.prov_id
            inner join comelec_region reg on reg.rgn_id = prov.rgn_id
            inner join comelec_political_candidates cpc on cpc.political_candidates_id = cv.candidates_id
            inner join comelec_candidate_post ccp on ccp.candidate_post_id = cpc.candidate_post_id
            $criteria
            order by reg.region_ord, prov.province_name, mun.municipal_name, brgy.barangay_name, cv.precincts_code, ccp.candidate_post_order ,cv.candidates_id";
       $arrData = array();
       //$this->conn->debug = 1;
       $rsResult = $this->conn->Execute($sql);
       while(!$rsResult->EOF){
           $arrData[] = $rsResult->fields;
           $rsResult->MoveNext();
       }

       return $arrData;

   }

}

?>