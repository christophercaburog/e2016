<div class="themeFieldsetDiv01">
<fieldset class="themeFieldset01">
<legend class="themeLegend01">Election Level Form</legend>
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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="12%" scope="row">&nbsp;</td>
    <th width="17%"><div align="left">Election Level </div></th>
    <td width="71%"><input name="election_level_name" type="text" id="election_level_name" value="<?=$oData[election_level_name];?>" size="35" /></td>
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