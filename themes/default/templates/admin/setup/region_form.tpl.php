<div class="themeFieldsetDiv01">
<fieldset class="themeFieldset01">
<legend class="themeLegend01">Manage Region Form</legend>
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
  <table width="100%" border="0" cellpadding="1" cellspacing="1">
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="14%">Region Name:</td>
      <td width="86%"><input type="text" name="region_name" id="region_name" value="<?=$oData['region_name']?>" /></td>
    </tr>
    <tr>
      <td valign="top">Description:</td>
      <td><textarea name="region_desc" id="region_desc" cols="40" rows="3"><?=$oData['region_desc']?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" name="Submit" value="Save New Region" />
        <input type="reset" name="Submit2" value="Reset" /></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      </tr>
  </table>
</form>
</fieldset>
</div>