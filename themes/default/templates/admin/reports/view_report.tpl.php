<?php

    $arrMapLabel = array('1'=>'Pcos Machine','2'=>'Ground ER','Comelec');
//    $arrMapLabel = array(''=>'Pcos Machine');

//    printa($candidate_post_name);
//
//    printa($regions);
//
//    printa($regional_data);

?>
<br>
<div align="center">Parallel Count   ( <?php echo $candidate_post_name;?> )</div>

<!--<div style="border:solid 1px #BFBFBF; padding:2px; margin-top:1px;">Bread Crumbs goes here! </div>-->
<br>
<br>
<style>

   body{
       font-size:11px;
   }
#table__ {
    border-collapse:separate !important;
    /*border: solid 1px;*/

}
    #table__ td {
        border:solid 1px #AFAFAF;
        font-size:10px;
        padding:2px;
    }
</style>


<table cellspacing="0" cellpadding="0" border="0" width="3800" id="table__">

    <tr>
        <?php foreach($regions['regions'] as $key_reg =>$val_reg){?>
            <?php if($key_reg =='National'){?>
                <td align="center" colspan="3"><b><?php echo $val_reg;?></b></td>
            <?php }elseif($key_reg !='label'){?>
                <td align="center" colspan="3">
                    <b><a href="reports.php?statpos=view_region&rgn_id=<?php echo $key_reg;?>&cpi=<?php echo $_GET['view'];?>"><?php echo $val_reg;?></a></b>
                </td>
                
            <?php }else{?>
                <td></td>
            <?php }?>
        <?php }?>
    </tr>

<?php $rowCtr = 0;foreach($regions['rgn_data'] as $key=>$value){ $rowCtr++;?>

    <tr class="<?=((($rowCtr % 2)==0)?"theme-tr-odd":"")?>" >

        <?php foreach($regions['regions'] as $key_reg =>$val_reg){?>

            <?php if($key_reg != 'label'){?>
                
                        <td align="center" colspan="3"><?php echo $value[$key_reg];?></td>

            <?php }else{ ?>
            
                <td align="left"><b><?php echo $value[$key_reg];?></b></td>
                
            <?php }?>
                

        <?php }?>

    </tr>
        
<?php } ?>

<tr>
    <td style="border:none;"><br></td>
</tr>

    <tr>
        <td>&nbsp;</td>
        <?php for($a=0;$a<count($regions['regions']) - 1;$a++){
                for($b=1;$b<=3;$b++){
        ?>
                <td style="width:64px;" align="center"><b><?php echo $arrMapLabel[$b];?></b></td>
        <?php }}?>
    </tr>
    <?php foreach($candidates_names as $candidate=>$name){?>
        <tr>
            <td><b><?php echo $name['political_candidates_name'];?></b></td>
            
                 <?php foreach($regions['regions'] as $key_reg =>$val_reg){
                     if($key_reg == 'National'){
                 ?>
                
                       <td align="right"><?php echo !empty($regional_data['National'][$candidate]['t_pcos_machine']) ? number_format($regional_data['National'][$candidate]['t_pcos_machine'],null) : '';?></td>
                       <td align="right"><?php echo !empty($regional_data['National'][$candidate]['t_ground_er']) ? number_format($regional_data['National'][$candidate]['t_ground_er'],null) : '';?></td>
                       <td align="right"><?php echo !empty($regional_data['National'][$candidate]['t_comelec']) ? number_format($regional_data['National'][$candidate]['t_comelec'],null) : '';?></td>

                    <?php }elseif($key_reg !='label'){?>

                        <td align="right"><?php echo !empty($regional_data[$candidate][$key_reg]['pcos_machine']) ? number_format($regional_data[$candidate][$key_reg]['pcos_machine'],null) :'' ;?></td>
                        <td align="right"><?php echo !empty($regional_data[$candidate][$key_reg]['ground_er']) ? number_format($regional_data[$candidate][$key_reg]['ground_er'],null) :'' ;?></td>
                        <td align="right"><?php echo !empty($regional_data[$candidate][$key_reg]['vote_comelec']) ? number_format($regional_data[$candidate][$key_reg]['vote_comelec'],null) :'' ;?></td>

                    <?php }?>

                <?php }?>

        </tr>

    <?php }?>

</table>

<br>
