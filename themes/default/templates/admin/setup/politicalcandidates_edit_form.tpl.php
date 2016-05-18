<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<link href="../includes/jquery/ui/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../includes/jquery/themes/base/ui.all.css">
<script src="../includes/jquery/jquery-1.3.2.js" type="text/javascript"></script>
<script src="../includes/jquery/ui/ui.core.js" type="text/javascript"></script>
<script src="../includes/jquery/ui/ui.dialog.js" type="text/javascript"></script>
<script src="../includes/jquery/ui/ui.draggable.js" type="text/javascript"></script>
<script src="../includes/jquery/ui/ui.resizable.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/jquery/ui/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../includes/jquery/ui/jquery.jgrow.js"></script>
<script type="text/javascript" src="../includes/jquery/ui/effects.core.js"></script>
<script type="text/javascript" src="../includes/jquery/ui/effects.pulsate.js"></script>
<script src="../includes/jquery/ui/ui.datepicker.js"></script>
<script src="../includes/jquery/ui/ui.tabs.js"></script>


<script type="text/javascript">
    $(document).ready(function(){

       $("#candidate_post_id").change(function(){

            ($(this).val() >=5) ? $("#disRegion").show() : $("#disRegion").hide();
             $("#disProvince").hide()
             $("#disMunicipality").hide();
             $("#disBarangay").hide();

              cp_id = $(this).val();

            $.get('setup.php?statpos=politicalcandidates&action=hasdistrict&cp_id='+cp_id,null, function(data){
                 (data != "") ? $("#disDistrict").show() : $("#disDistrict").hide();

            });

       });

       $("#region_post_id").change(function(){
           $("#disProvince").show()
           $("#disMunicipality").hide();
           $("#disBarangay").hide();
            rgn_id = $(this).val();
            $.get('setup.php?statpos=politicalcandidates&action=ajaxpro&rgn_id='+rgn_id,null, function(data){
                //$('#select_province').html(data);
            });

           if($(this).val().length != 0){
                $("#district_name").val('');
            }

       });
        $("#select_province").change(function(){
           $("#disMunicipality").show();
            $("#disBarangay").hide();

             if($(this).val().length != 0){
                $("#municipality_name").val('');
                 $("#barangay_name").val('');
                 $("#district_name").val('');
            }


       });

        $("#municipality_name").keyup(function(){
          // $("#disBarangay").show();
           $("#barangay_name").val('');

       });


         $("#municipality_name").autocomplete("setup.php?statpos=politicalcandidates&action=municipality",{
             cacheLength:1
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                provid:function(){
                    return $('#select_province').val();
                }
            }
            ,formatItem: function(row){
                return row[2];
            }
            ,formatResult: function(row){
                return row[2].replace(/(<.+?>)/gi, '');
            }
        }).result(function(event, data, formatted){
            $("#municipality_id").val(data[1]);
            $("#municipality_name").val(data[2]);
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#municipality_id").val('');
                $("#municipality_name").val('');
            }
        });

         $("#barangay_name").autocomplete("setup.php?statpos=politicalcandidates&action=barangay",{
             cacheLength:1
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                munid:function(){
                    return $('#municipality_id').val();
                }
            }
          ,formatItem: function(row){
                return row[2];
            }
            ,formatResult: function(row){
                return row[2].replace(/(<.+?>)/gi, '');
            }
        }).result(function(event, data, formatted){
            $("#barangay_id").val(data[1]);
            $("#barangay_name").val(data[2]);
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#barangay_id").val('');
                $("#barangay_name").val('');
            }
        });



    });
</script>
<style>
/*#disRegion{
        display: none;
}
#disProvince{
        display: none;
}
#disMunicipality{
        display: none;
}
#disBarangay{
        display: none;
}
#disDistrict{
        display: none;
}*/


</style>
<div class="themeFieldsetDiv01">
<fieldset class="themeFieldset01">
<legend class="themeLegend01">Political Candidates Form</legend>
<?php
if(isset($eMsg)){
	if (is_array($eMsg)) {
?>
	<div class="tblListErrMsg">
	<b>Check the following error(s) below:</b><br>
	<?php
	foreach ($eMsg as $key => $value) {
	?>
	&nbsp;&nbsp;&bull;&nbsp;<?=$value?><br>
	<?php
	}
	?>
	</div>
<?php
	}else {
?>
	<div class="tblListErrMsg">
	<?=$eMsg?>
	</div>
<?
	}
}
//print_r($oRecPolCan);

?>
<form method="post" action="">
  <table width="100%" border="0" cellpadding="0" cellspacing="3">
    <tr>
      <td width="12%" scope="row">&nbsp;</td>
      <th width="26%"><div align="left">Candidate Position Title </div></th>
      <td width="62%"><select name="candidate_post_id" id="candidate_post_id">
          <?php foreach($oRecCandPost as $key => $value){?>
          <option value="<?=$value['candidate_post_id']?>" <?=($value['candidate_post_id']==$oData['candidate_post_id']?'selected':'')?>>
            <?=$value['candidate_post_name']?>
            </option>
          <?php }?>
      </select></td>
    </tr>
    <tr id="disRegion">
      <td width="12%" scope="row">&nbsp;</td>
      <th width="26%"><div align="left">Region </div></th>
      <td width="62%"><select name="region_post_id" id="region_post_id" style=" width: 114px;">
        <?php echo html_options_2d($oRecRegionPost,'rgn_id','region_name',$oRecPolCan['rgn_id'],false);?>
      </select></td>
    </tr>
     <tr id="disProvince">
      <td width="12%" scope="row">&nbsp;</td>
      <th width="26%"><div align="left">Province </div></th>
      <td width="62%"><select id="select_province" name="select_province">
                     <?php echo html_options_2d($oRecProvincePost,'prov_id','province_name',$oRecPolCan['prov_id'],false);?>
            </select></td>
    </tr>
    <tr id="disDistrict">
      <td width="12%" scope="row">&nbsp;</td>
      <th width="26%"><div align="left">District </div></th>
      <td width="62%" >
          <input type="text" name="district_name" id="district_name" value="<?=$oData['political_candidates_district']?>">

      </td>
    </tr>
     <tr id="disMunicipality">
      <td width="12%" scope="row">&nbsp;</td>
      <th width="26%"><div align="left">Municipality </div></th>
      <td width="62%">
           <input type="hidden" name="municipality_id" id="municipality_id" value="<?=$oRecPolCan['mun_id']?>">
          <input type="text" name="municipality_name" id="municipality_name" value="<?=$oRecPolCan['municipal_name']?>">

      </td>
    </tr>
  <!--   <tr id="disBarangay">
      <td width="12%" scope="row">&nbsp;</td>
      <th width="26%"><div align="left">Barangay </div></th>
      <td width="62%">
           <input type="hidden" name="barangay_id" id="barangay_id" value="">
          <input type="text" name="barangay_name" id="barangay_name" value="">

      </td>
    </tr>-->

    <tr>
      <td scope="row">&nbsp;</td>
      <th><div align="left">Political Candidates Full Name </div></th>
      <td>
          <textarea name="political_candidates_name" id="political_candidates_name" cols="40" rows="1"><?=$oData['political_candidates_name']?></textarea>
      </td>
    </tr>
    <tr>
      <td height="22" scope="row">&nbsp;</td>
      <th><div align="left">Political Candidates Alias </div></th>
      <td>
          <textarea name="political_candidates_alias" id="political_candidates_alias" cols="40" rows="1"><?=$oData['political_candidates_alias']?></textarea>
      </td>
    </tr>
    <tr>
      <td scope="row">&nbsp;</td>
      <th><div align="left">Candidates Term(Year) </div></th>
      <td><input name="political_candidates_year" type="text" id="political_candidates_year" value="<?=$oData['political_candidates_year']?>" /></td>
    </tr>
    <tr>
      <td scope="row">&nbsp;</td>
      <th><div align="left">Political Order Number</div></th>
      <td><input name="political_candidates_order" type="text" id="political_candidates_order" value="<?=$oData['political_candidates_order']?>" /></td>
    </tr>
    <tr>
      <td scope="row">&nbsp;</td>
      <th><div align="left">Q.A. Status</div></th>
      <td>
          <select name="political_candidates_qastatus">
              <option value="5" <?php if($oData['political_candidates_qastatus']=="5"){echo "selected";}?>>Open</option>
              <option value="10" <?php if($oData['political_candidates_qastatus']=="10"){echo "selected";}?>>Unverified</option>
              <option value="15" <?php if($oData['political_candidates_qastatus']=="15"){echo "selected";}?>>Verified</option>
          </select>
      </td>
    </tr>
    <tr>
      <td scope="row">&nbsp;</td>
      <th><input type="submit" name="Submit" value="Submit" /></th>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</fieldset>
</div>