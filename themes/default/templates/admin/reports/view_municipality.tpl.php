<?php
ini_set('display_errors',0);

//$arrMapLabel = array('1'=>'Pcos Machine','2'=>'Ground ER','3'=>'Comelec');
$arrMapLabel = array('2'=>'ER','3'=>'TS');

//    printa($municipalities);
//printa($candidates);

//printa($report_details);
//printa($provintial_data);
?>
<div align="center">Parallel Count</div>
<style>
#table__ {
    border-collapse:separate !important;
    /*border: #f0f0f0 solid 1px;*/

}
    #table__ td {
        border:solid 1px #f0f0f0;
        font-size:11px;
        padding:2px;
    }
</style>

<table cellspacing="0" cellpadding="0" border="0" width="100%" id="table__">
    <tr>
        <td></td>
        <?php foreach($candidates['name'] as $candidate_id =>$candidate_name){?>
                <td align="center" colspan="2"><b><?php echo $candidate_name;?></b></td>
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
-->    
    	<td>Voters Voted</td>
        <?php if(count($candidates['total_votes']) !=0) { ?>
	        <?php foreach($candidates['total_votes'] as $candidate_id=>$total_vote){?>
	                <td align="center" colspan="2"><b>
	                <?php echo number_format($total_vote,null);?></b></td>
	                
	        <?php }?>
        <?php }else{?>
        	<?php foreach($candidates['name'] as $candidate_id =>$candidate_name){?>
        		<td align="center" colspan="2"><b>0</b></td>
        	<?php } ?>
        <?php } ?>
    </tr>
    <tr>
        <td style="border:none;"><br></td>
    </tr>
<?php ob_start();?>
    <tr>
        <td></td>
        <?php foreach($candidates['name'] as $candidate_id =>$candidate_name){
                for($b=2;$b<=3;$b++){
        ?>
            <td style="width:64px;" align="center"><b><?php echo $arrMapLabel[$b];?></b></td>

        <?php }}?>
    </tr>
<?php $repeatableRowHeader = ob_get_clean();?>
<?php echo $repeatableRowHeader;?>
    
    <?php foreach($report_details as $muni_name=>$rpt_details){?>
        
        <tr>
        
            <td><?php  echo $muni_name;?></td>
            
            <?php foreach($candidates['name'] as $candidate_id =>$candidate_name){?>
                    <?php if(count($rpt_details[$candidate_id]) >0){?>
                        <?php foreach($rpt_details[$candidate_id] as $t=>$b){?>
                           <td align="right"><?php echo !empty($b) ? number_format($b,null) : '&nbsp;';?></td>
                        <?php }?>
                    <?php }else{?>

                        <?php for($aa=2;$aa<=3;$aa++){?>

                            <td>&nbsp;</td>

                        <?php }?>
                    
                    <?php }?>

            <?php }?>

        </tr>

    <?php }?>

</table>

<br>
