<div class="themeFieldsetDiv01">
<fieldset class="themeFieldset01">
<legend class="themeLegend01">Manage Province Form</legend>
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
      <td>Region Name: </td>
      <td><input name="region_name" id="region_name" value="<?=$oData['region_name']?>" type="text" size="30" />
	  <input name="region_id" type="hidden" id="region_id" value="<?=$oData['region_id']?>" />
            <a href="javascript:;" onclick="javascript: window.open('popup.php?statpos=popup_region', 'searchwindow', 'toolbar=0,scrollbars=1,location=1,statusbar=0,menubar=0,resizable=1,width=700,height=400,left = 390,top = 230');"><img src="<?=$themeImagesPath?>/admin/find.gif" alt="Search" border="0" align="absmiddle" /></a></td>
    </tr>
    
    <tr>
      <td width="19%">Province Name:</td>
      <td width="81%"><input name="province_name" id="province_name" value="<?=$oData['province_name']?>" type="text" size="30" /></td>
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