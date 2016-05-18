<?php
ini_set('display_errors',0);

$arrMapLabel = array('1'=>'Pcos Machine','2'=>'Ground ER','3'=>'Comelec');

//printa($report_details);
//echo count($candidates['candidate']);
// printa($candidates);
?>
<div align="center">Parallel Count</div>
<style>
#table__ {
    border-collapse:separate !important;
    border: solid 1px;
}
#table__ td {
    border:solid 1px #AFAFAF;
    font-size:10px;
    padding:2px;
}  
</style>

<table cellspacing="0" cellpadding="0" border="0" id="table__">
    <tr>
        <td>&nbsp;</td>
        <?php foreach($candidates['candidate'] as $candidate_id =>$candidate_name){?>
                <td align="center" colspan="3"><b><?php echo $candidate_name;?></b></td>
        <?php }?>
    </tr>
    <tr>
        <td>&nbsp;</td>

        <?php if(count($candidates['total_votes']) > 0){?>
            
            <?php foreach($candidates['total_votes'] as $candidate_id=>$total_vote){?>
                    <td align="right" colspan="3"><?php echo $total_vote;?></td>
            <?php }?>

        <?php }else{?>
        
            <?php for($a=0;$a<count($candidates['candidate']);$a++){?>
                    <td align="right" colspan="3">&nbsp;</td>
            <?php }?>
        
        <?php }?>

    </tr>
    <tr>
        <td style="border:none;"><br></td>
    </tr>


<tr>
        <td>&nbsp;</td>
        <?php for($a=0;$a<count($candidates['candidate']);$a++){?>
                <?php for($b=1;$b<=3;$b++){?>
                    <td><b><?php echo $arrMapLabel[$b];?></b></td>
                <?php }?>

        <?php }?>
    </tr>

    <?php if(count($report_details['province'])>0){?>

            <?php foreach($report_details['province'] as $prov_id=>$rpt_details){?>
                
                <?php foreach($rpt_details as $prov_name=>$rpt_data){?>
                    

                        <?php if($prov_name !='municipal'){?>
                            <tr>
                                <td><b><?php echo $prov_name;?></b></td>

                                <?php foreach($candidates['candidate'] as $candidate_id =>$candidate_name){?>
                                        <?php for($b=1;$b<=3;$b++){?>
                                            <td><?php echo $rpt_data[$candidate_id][$arrMapLabel[$b]];?></td>
                                        <?php }?>

                                <?php }?>
                            </tr>
                        <?php }else{?>
                        
                            <?php foreach($rpt_data as $mun_id=>$mun_details){?>
                                <tr>
                                    <td style="padding-left:15px;"><a href="reports.php?statpos=view_r_national&rgn_id=<?php echo $_GET['rgn_id'];?>&cpi=<?php echo $_GET['cpi'];?>&mun_id=<?php echo $mun_id;?>"><?php echo $mun_details['municipal_name'];?></a></td>
                                    <!--<td style="padding-left:15px;"><?php echo $mun_details['municipal_name'];?></td> -->
                                    
                                        <?php foreach($candidates['candidate'] as $candidate_id =>$candidate_name){?>
                                                <?php for($b=1;$b<=3;$b++){?>
                                                    <td><?php echo $mun_details[$candidate_id][$arrMapLabel[$b]];?></td>
                                                <?php }?>
                                        <?php }?>

                                   
                                </tr>
                            <?php }?>

                        
                            
                        <?php }?>
                    

                <?php }?>

            <?php }?>
    <?php }?>


</table>

<br>


