<?php
ini_set('display_errors',0);

//$arrMapLabel = array('1'=>'Pcos Machine','2'=>'Ground ER','3'=>'Comelec');

$arrMapLabel = array('2'=>'Ground ER');

//printa($report_details);
//echo count($candidates['candidate']);
// printa($candidates);
?>
<div align="center">Parallel Count</div>
<style>
#table__ {
    border-collapse:separate !important;
    /*border: solid 1px;*/
}
#table__ td {
    border:solid 1px #f0f0f0;
    font-size:10px;
    padding:2px;
}
</style>

<table cellspacing="0" cellpadding="0" border="0" id="table__">
    <tr>
        <td>&nbsp;</td>
        <?php foreach($candidates['candidate'] as $candidate_id =>$candidate_name){?>
                <td align="center" ><b><?php echo $candidate_name;?></b></td>
        <?php }?>
    </tr>
    <tr>
        <td><b>Total</b></td>

        <?php if(count($candidates['total_votes']) > 0){?>

            <?php foreach($candidates['total_votes'] as $candidate_id=>$total_vote){?>
                    <td align="right" ><?php echo !empty($total_vote) ? number_format($total_vote,null) : '';?></td>
            <?php }?>

        <?php }else{?>

            <?php for($a=0;$a<count($candidates['candidate']);$a++){?>
                    <td align="right" >&nbsp;</td>
            <?php }?>

        <?php }?>

    </tr>
    <tr>
        <td style="border:none;"><br></td>
    </tr>




    <?php if(count($report_details['province'])>0){?>

            <?php foreach($report_details['province'] as $prov_id=>$rpt_details){?>

                <?php foreach($rpt_details as $prov_name=>$rpt_data){?>


                        <?php if($prov_name !='municipal'){?>
                            <tr class="theme-tr-odd">
                                <td><b><?php echo $prov_name;?></b></td>

                                <?php foreach($candidates['candidate'] as $candidate_id =>$candidate_name){?>
                                        <?php for($b=1;$b<=count($arrMapLabel);$b++){?>
                                            <td><?php echo $rpt_data[$candidate_id][$arrMapLabel[$b]];?></td>
                                        <?php }?>

                                <?php }?>
                            </tr>
                        <?php }else{?>

                            <?php $rowCtr=0;foreach($rpt_data as $mun_id=>$mun_details){ $rowCtr++;?>
                                <tr class="<?php //=((($rowCtr % 2)==0)?"theme-tr-odd2":"")?>">
                                    <td style="padding-left:15px;"><a href="reports.php?statpos=view_r_national&rgn_id=<?php echo $_GET['rgn_id'];?>&cpi=<?php echo $_GET['cpi'];?>&mun_id=<?php echo $mun_id;?>"><?php echo $mun_details['municipal_name'];?></a></td>
                                    <!--<td style="padding-left:15px;"><?php echo $mun_details['municipal_name'];?></td> -->

                                        <?php foreach($candidates['candidate'] as $candidate_id =>$candidate_name){?>

                                                    <td align="right"><?php echo !empty($mun_details[$candidate_id]['Ground ER']) ? number_format($mun_details[$candidate_id]['Ground ER'],null) : '';?></td>
                                        <?php }?>

                                </tr>
                            <?php }?>

                        <?php }?>
                <?php }?>

            <?php }?>
    <?php }?>


</table>

<br>


