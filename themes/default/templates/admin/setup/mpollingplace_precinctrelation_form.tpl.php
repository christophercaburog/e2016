<div class="themeFieldsetDiv01">
<fieldset class="themeFieldset01">
<legend class="themeLegend01">Manage Polling Place & Precints Relation Form</legend>
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
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="22%">Polling Place</td>
    <td width="78%"><input name="pollingplaces_name" type="text" id="pollingplaces_name"  value="<?=$oData['pollingplaces_name'];?>" />
      <input type="hidden" name="pollingplaces_id" id="pollingplaces_id" value="<?=$oData['pollingplaces_id'];?>" />
      <a href="javascript:;" onclick="javascript: window.open('popup.php?statpos=popup_pollingplaces', 'searchwindow', 'toolbar=0,scrollbars=1,location=1,statusbar=0,menubar=0,resizable=1,width=700,height=400,left = 390,top = 230');"><img src="<?=$themeImagesPath?>/admin/find.gif" alt="Search" border="0" align="absmiddle" /></a></td>
  </tr>
  <tr>
    <td> Precint</td>
    <td><input name="precints_number" type="text" id="precints_number"  value="<?=$oData['precints_number'];?>" />
      <input type="hidden" name="precints_id" id="precints_id" value="<?=$oData['precints_id'];?>" />
      <a href="javascript:;" onclick="javascript: window.open('popup.php?statpos=popup_precint', 'searchwindow', 'toolbar=0,scrollbars=1,location=1,statusbar=0,menubar=0,resizable=1,width=700,height=400,left = 390,top = 230');"><img src="<?=$themeImagesPath?>/admin/find.gif" alt="Search" border="0" align="absmiddle" /></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="submit" name="Submit" value="Submit" class="themeInputButton" /></td>
    <td>&nbsp;</td>
  </tr>
</table>


</form>
</fieldset>
</div>