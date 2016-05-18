<div class="themeFieldsetDiv01">
<fieldset class="themeFieldset01">
<legend class="themeLegend01">Manage Department Form</legend>
<?php 
if(isset($eMsg)){
	if (is_array($eMsg)) {
?>
	<div class="tblListErrMsg">
	<b>Check the following error(s) below:</b><br>
	<?php
	foreach ($eMsg as $key => $value) {
	?>
	&nbsp;&nbsp;&bull;&nbsp;<?=$value?>
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

<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr>
    <td width="200">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Department Name </td>
    <td><input name="ud_name" type="text" id="ud_name" value="<?=$oData['ud_name']?>" size="35" maxlength="30" /></td>
  </tr>
  <tr>
    <td align="left" valign="top">Description</td>
    <td><textarea name="ud_desc" cols="30" rows="3" id="ud_desc"><?=$oData['ud_desc']?>
    </textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Submit" class="themeInputButton" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>
</fieldset>
</div>