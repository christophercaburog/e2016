<?php
//include("configurations/config.php");
include("../../../../configurations/adminconfig.php");
include_once(SYSCONFIG_CLASS_PATH."admin/application.class.php");
include_once(SYSCONFIG_CLASS_PATH."util/phpexcelClasses/PHPExcel.php");
include_once(SYSCONFIG_CLASS_PATH."util/phpexcelClasses/PHPExcel/IOFactory.php");

$dbconn = Application::db_open();

//echo "testing";
$arrCellColumnLabel = array("a","b","c","d","e","f","g","h","i","j","k","l");

$tvar = exec("pwd");
$dmun = dir($tvar);

$objReader = PHPExcel_IOFactory::createReader('Excel5');
$sTime = microtime(true);

while(false !== ($emunicipal = $dmun->read())){
    if($emunicipal != 'candidateparser.php' && $emunicipal != '.' && $emunicipal != '..'){
        //echo "$emunicipal\n";
        
        $exp_municipal = explode("-",$emunicipal);
        echo $tprov = trim($exp_municipal[0]);
        //echo "<br />";

        $objPHPExcel = $objReader->load($emunicipal);
        echo $workSheetCnt = $objPHPExcel->getSheetCount();
        echo "\n";

        $tMunicipal = "";
        $candidateCtr = 0;
        
        foreach ($objPHPExcel->getWorksheetIterator() as $objWorksheet){

            $rowCnt = $objWorksheet->getHighestRow();
            for($rowCtr = 1;$rowCtr < $rowCnt; $rowCtr++){
                $arrDataInsert = array();
                for($ctrCellColumnLabel = 0;$ctrCellColumnLabel<count($arrCellColumnLabel);$ctrCellColumnLabel++){
                    ${"tprec_".$arrCellColumnLabel[$ctrCellColumnLabel]} = $objWorksheet->getCellByColumnAndRow($ctrCellColumnLabel, $rowCtr)->getValue();
                    $arrDataInsert["tprec_".$arrCellColumnLabel[$ctrCellColumnLabel]] = ${"tprec_".$arrCellColumnLabel[$ctrCellColumnLabel]};
                }

                if(!empty($tprec_b) && empty($tprec_a) && empty($tprec_c) && empty($tprec_d)){
                    $tMunicipal = $tprec_b;
                    //$arrDataInsert['tprec_municipal'] = $tMunicipal;
                }


                if(/*!empty($tprec_a) &&*/ !empty($tprec_b) && !empty($tprec_c)){
                    //$arrDataInsert['rgn_id'] = 1; // region 1;
                    
                    $arrDataInsert['tprec_prov'] = $tprov;
                    $aXMunicipal = explode(",", $tMunicipal);
                    $arrDataInsert['tprec_municipal'] = trim($aXMunicipal[0]);

                    //printa($arrDataInsert);
                    //echo implode("| ",$arrDataInsert)."\n";

                    $flds = array();
                    foreach ($arrDataInsert as $keyADI => $valADI){
                        if(empty($valADI)){
                            $valADI = "NULL";
                            $flds[] = "$keyADI = ".$valADI."";
                        }else{
                            $valADI = addslashes(trim(utf8_encode($valADI)));
                            $flds[] = "$keyADI = CONVERT('".$valADI."' USING latin1)";
                        }

                    }
                    $fields = implode(",",$flds);

                    $sql = "insert into temp_candidates set $fields";
                    $dbconn->Execute($sql);
                    echo ".";
                    $candidateCtr++;
                }


            }  // <-- row counter end
           
        } // <-- worksheet iterator end

        echo "\ncandidate count: $candidateCtr\n\n";
    } // <-- muncipal condition statement end
    
}

$eTime = microtime(true);

echo round($eTime - $sTime,2)."\n";
?>