<?php
ini_set('display_errors',0);

$arrMapLabel = array('1'=>'Pcos Machine','2'=>'Ground ER','3'=>'Comelec');

//    printa($municipalities);
//printa($candidates);

//printa($report_details);
//printa($provintial_data);
?>
<?php// printa($report_details);?>
<div align="center">Parallel Count</div>
<style>
    #table__ {
    border-collapse:separate !important;
    /*border: solid 1px;*/

}
    #table__ td {
        border:solid 1px #AFAFAF;
        font-size:11px;
        padding:2px;
    }
</style>

<table cellspacing="0" cellpadding="0" border="0" width="100%" id="table__">
    <tr >
        <td width="100"></td>
        <?php foreach($candidates['candidate'] as $candidate_id => $candidate_name){?>
                <td align="center" colspan="3"><b><?php echo $candidate_name;?></b></td>
        <?php }?>
    </tr>
<!--    <tr>

    	<td>Total # of Precincts</td>
    	<td></td>
    </tr>
    <tr>
    	<td>Precincts Reported</td>
    	<td  align="center" colspan="3"></td>
    </tr>
    <tr>
    	<td>Total # of Registered Voters</td>
    	<td  align="center" colspan="3"></td>
    </tr>
    <tr>
--> <tr>
    	<td>Voters Voted</td>
        <?php if(count($candidates['total_votes']) !=0) {?>
	        <?php foreach($candidates['total_votes'] as $candidate_id => $total_vote){?>
	                <td align="center" colspan="3"><b><?=$total_vote?></b></td>
	        <?php }?>
        <?php }?>
    </tr>
    <tr>
        <td style="border:none;"><br></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <?php foreach($candidates['candidate'] as $candidate_id =>$candidate_name){
                for($b=1;$b<=3;$b++){
        ?>
            <td style="width:64px;" align="center"><b><?php echo $arrMapLabel[$b];?></b></td>

        <?php }}?>
    </tr>
    <?php
    $ctr=1;
    //printa($precincts);
    foreach($precincts as $key => $val){
        if($ctr==1){?>
        <tr>
            <td><b><?=$val['brgy']?></b></td>
        </tr>
        <?php }?>
        <?php foreach($val['precincts'] as $prec => $precval){?>
        <tr>
            <td><?=$precval['precinct_number']?></td>
            <?php foreach($candidates['candidate'] as $candidate_id => $candidate_name){?>
            <?php 
            	$pcos = number_format($report_details[$candidate_id][$prec]['pcos'], null);
            	$grounder = number_format($report_details[$candidate_id][$prec]['ground_er'], null);
            	$comelec = number_format($report_details[$candidate_id][$prec]['comelec'], null);
            	if($pcos == 0){
            		$pcos = "";
            	}
            	if($grounder == 0){
            		$grounder = "";
            	}
            	if($comelec == 0){
            		$comelec = "";
            	}
            ?>
                <td align="right" colspan="1"><?=$pcos?></td>
                <td align="right" colspan="1"><?=$grounder?></td>
                <td align="right" colspan="1"><?=$comelec?></td>
        	<?php }?>
    
        </tr>
    	<?php }?>
    <?php }?>
    
    
    
    </table>

<br>
