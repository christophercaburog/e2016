<div class="themeFieldsetDiv01">
<fieldset class="themeFieldset01">
<legend class="themeLegend01">Candidate Position Form</legend>
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
?>
<form method="post" action="">
  <table width="100%" border="0" cellpadding="0" cellspacing="2">
    <tr>
      <td width="12%" scope="row">&nbsp;</td>
      <th width="26%"><div align="left">Election Level Categories </div></th>
      <td width="62%"><select name="election_level_id" id="election_level_id">
	      <?php foreach($oRecElecLev as $key => $value){?>
        <option value="<?=$value['election_level_id']?>" <?=($value['election_level_id']==$oData['election_level_id']?'selected':'')?>><?=$value['election_level_name']?></option>
		 <?php }?>
        </select></td>
    </tr>
    <tr>
      <td scope="row">&nbsp;</td>
      <th><div align="left">Candidate Position Title </div></th>
      <td><input name="candidate_post_name" type="text" id="candidate_post_name" value="<?=$oData[candidate_post_name];?>" /></td>
    </tr>
    <tr>
      <td height="75" scope="row">&nbsp;</td>
      <th><div align="left">Description</div></th>
      <td><textarea name="candidate_post_desc" cols="35" rows="5" id="candidate_post_desc"><?=$oData[candidate_post_desc];?>
</textarea></td>
    </tr>
    <tr>
      <td scope="row">&nbsp;</td>
      <th><div align="left">Order</div></th>
      <td><input name="candidate_post_order" type="text" id="candidate_post_order" value="<?=$oData[candidate_post_order];?>" /></td>
    </tr>
    <tr>
      <td scope="row">&nbsp;</td>
      <th>&nbsp;</th>
      <td>&nbsp;</td>
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