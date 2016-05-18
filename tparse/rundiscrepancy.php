<?php
//include("configurations/config.php");
include("../configurations/adminconfig.php");
include_once(SYSCONFIG_CLASS_PATH."admin/application.class.php");

$dbconn = Application::db_open("namfrel2010_db");

//
//printa($dbconn);


//$myFile = "precinct_mar.txt";
//$fh = fopen($myFile, 'ax') or die("can't open file");

$flds = array();
$flds[]  = "b.code";
$flds[]  = "b.region";
$flds[]  = "b.province";
$flds[]  = "b.municipal";
$flds[]  = "b.brgy";
$flds[]  = "b.precicnt";
$flds[]  = "a.f04";
$flds[]  = "a.f06";
$flds[]  = "a.f07";
$flds[]  = "a.f08";
$flds[]  = "a.f09";
$flds[]  = "a.f10";
$flds[]  = "a.f11";


$fields = implode(",",$flds);

$sql = "select $fields
        from temp_parsedata a
        inner join precincts_list b on a.f02 = b.code
        where a.f04 in ('BINAY, Jejomar C.', 'ROXAS, Manuel A.')
        group by b.code, a.f04
        ";
//$dbconn->debug =1;
$rsResult = $dbconn->Execute($sql);

$xCtr = 0;

while(!$rsResult->EOF){

    
    $sqlUpdate = "";
    //$dbconn->Execute($sqlUpdate);
    $rsResult->MoveNext();
}

//$stringData = "New Stuff 2\n";
//fwrite($fh, $stringData);
//
//fclose($fh);


?>