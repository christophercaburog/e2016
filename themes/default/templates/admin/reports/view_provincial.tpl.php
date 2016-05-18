<?php
ini_set('display_errors',0);

$arrMapLabel = array('1'=>'Pcos Machine','2'=>'Ground ER','3'=>'Comelec');

//printa($candidates);

//printa($report_details);

//printa($provintial_data);
?>
<div align="center">Parallel Count</div>
<style>
#table__ {
    border-collapse:separate !important;
    border: solid 1px;

}
#table__ td {
    border:solid 1px #AFAFAF;
    font-size:11px;
    padding:2px;
}
</style>

<table cellspacing="0" cellpadding="0" border="0" width="100%s" id="table__">
    <tr>
        <td></td>
        <?php foreach($candidates['candidate'] as $candidate_id =>$candidate_name){?>
                <td align="center" colspan="3"><b><?php echo $candidate_name;?></b></td>
        <?php }?>
    </tr>
    <tr>
        <td></td>
        <?php foreach($candidates['total_votes'] as $candidate_id=>$total_vote){?>
                <td align="right" colspan="3"><?php echo $total_vote;?></td>
        <?php }?>
    </tr>
    <tr>
        <td style="border:none;"><br></td>
    </tr>

    <tr>
        <td></td>
        <?php foreach($candidates['candidate'] as $candidate_id =>$candidate_name){
                for($b=1;$b<=3;$b++){
        ?>
            <td style="width:64px;" align="center"><b><?php echo $arrMapLabel[$b];?></b></td>

        <?php }}?>
    </tr>

    <?php foreach($report_details as $muni_name=>$rpt_details){?>
        
        <tr>
        
            <td><a href="reports.php?statpos=view_municipality&lm=<?php echo $_GET['cpi'];?>&mun_id=<?php echo $rpt_details['mun_id'];?>"><?php echo $muni_name;?></a></td>
            
            <?php foreach($candidates['candidate'] as $candidate_id =>$candidate_name){?>
                    <?php if(count($rpt_details['municipal_reports'][$candidate_id]) >0){?>
                        <?php foreach($rpt_details['municipal_reports'][$candidate_id] as $t=>$b){?>
                            <td align="right"><?php echo !empty($b) ? $b : '&nbsp;';?></td>
                        <?php }?>
                    <?php }else{?>

                        <?php for($aa=1;$aa<=3;$aa++){?>

                            <td>&nbsp;</td>

                        <?php }?>
                    
                    <?php }?>

            <?php }?>

        </tr>

    <?php }?>

</table>

<br>
