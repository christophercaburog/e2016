<?php if(!isset($_GET['verified'])){?>
<a href="reports.php?statpos=view_report&view=<?=$_GET['view']?>&verified=1">Toggle Verified Report On</a>
<?php }else{?>
<a href="reports.php?statpos=view_report&view=<?=$_GET['view']?>">Toggle Verified Report Off</a>
<?php
}
?>
<pre>
<!--
Unofficial Sample SMS OQC Template
PC  => Precinct Code
RV  => Registered Voters
VV  => Voters who actually Voted
VBC => Valid Ballot Cast-->
[PC] [RV] [VV] [VBC] / 110 120 130 140 150 / 101 102 103 104 105 106

REG 
VOT 
REP 

VCM 7654321 binay 123

</pre>

<style>
    #test > span {display: block;}
    #test > span.green {background-color:green;}
    .right {text-align: right;}
</style>

<!--<table width="500" id="test">
    <tr>
        <td></td>
        <td></td>
        <th>Ground ER</th>
        <th>Public</th>
    </tr>
    <tr>
        <td>Binay, Jejomar</td>
        <td><span class="green">&nbsp;</span></td>
        <td class="right">100</td>
        <td class="right">101</td>
    </tr>
</table>-->


<?php
//    $arrMapLabel = array('1'=>'Pcos Machine','2'=>'Ground ER','Comelec');
    $arrMapLabel = array('2'=>'Ground ER');

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


<table cellspacing="0" cellpadding="0" border="0" width=100%" id="table__">

    <tr>
        <?php foreach($regions['regions'] as $key_reg =>$val_reg){?>
            <?php if($key_reg =='National'){?>
                <td align="center"><b><?php echo $val_reg;?></b></td>
            <?php }elseif($key_reg !='label'){?>
                <td align="center" >
                    <b><a href="reports.php?statpos=view_region&rgn_id=<?php echo $key_reg;?>&cpi=<?php echo $_GET['view'];?><?=((isset($_GET['verified']))?"&verified=1":"")?>"><?php echo $val_reg;?></a></b>
                </td>

            <?php }else{?>
                <td></td>
            <?php }?>
        <?php }?>
    </tr>

<?php $rowCtr = 0; foreach($regions['rgn_data'] as $key=>$value){ $rowCtr++; ?>

    <tr class="<?=((($rowCtr % 2)==0)?"theme-tr-odd":"")?>">

        <?php foreach($regions['regions'] as $key_reg =>$val_reg){?>

            <?php if($key_reg != 'label'){?>

                        <td align="right" ><?php echo $value[$key_reg];?></td>

            <?php }else{ ?>

                <td align="left"><b><?php echo $value[$key_reg];?></b></td>

            <?php }?>

        <?php }?>

    </tr>

<?php } ?>

<tr>
    <td style="border:none;"><br></td>
</tr>

    <?php $rowCtr = 0; foreach($candidates_names as $candidate=>$name){ $rowCtr++;?>
        <tr class="<?=((($rowCtr % 2)==0)?"theme-tr-odd":"")?>">
            <td><b><?php echo $name['political_candidates_name'];?></b></td>

                 <?php foreach($regions['regions'] as $key_reg =>$val_reg){
                     if($key_reg == 'National'){
                 ?>

                       <td align="right"><?php echo !empty($regional_data['National'][$candidate]['t_ground_er']) ? number_format($regional_data['National'][$candidate]['t_ground_er'],null) : '';?></td>

                    <?php }elseif($key_reg !='label'){?>

                        <td align="right"><?php echo !empty($regional_data[$candidate][$key_reg]['ground_er']) ? number_format($regional_data[$candidate][$key_reg]['ground_er'],null) :'' ;?></td>

                    <?php }?>

                <?php }?>

        </tr>

    <?php }?>

</table>

<br>
