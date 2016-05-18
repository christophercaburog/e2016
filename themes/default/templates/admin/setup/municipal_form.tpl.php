<div class="themeFieldsetDiv01">
<fieldset class="themeFieldset01">
<legend class="themeLegend01">Manage Municipal Form</legend>
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
      <td>Province Name: </td>
      <td><input name="province_name" id="province_name" value="<?=$oData['province_name']?>" type="text" size="30" />
	  <input name="province_id" type="hidden" id="province_id" value="<?=$oData['province_id']?>" />
            <a href="javascript:;" onclick="javascript: window.open('popup.php?statpos=popup_prov', 'searchwindow', 'toolbar=0,scrollbars=1,location=1,statusbar=0,menubar=0,resizable=1,width=700,height=400,left = 390,top = 230');"><img src="<?=$themeImagesPath?>/admin/find.gif" alt="Search" border="0" align="absmiddle" /></a></td>
    </tr>
    <tr>
      <td width="19%">Monicipalities Name:</td>
      <td width="81%"><input name="municipal_name" id="municipal_name" value="<?=$oData['municipal_name']?>" type="text" size="30" /></td>
    </tr>
    <tr>
      <td>Precint Count: </td>
      <td><input name="precints_count" id="precints_count" value="<?=$oData['precints_count']?>" type="text" size="30" /></td>
    </tr>
    <tr>
      <td>Precints Reported: </td>
      <td><input name="precints_reported" id="precints_reported" value="<?=$oData['precints_reported']?>" type="text" size="30" /></td>
    </tr>
    <tr>
      <td>Registered Voters: </td>
      <td><input name="voters_registered" id="voters_registered" value="<?=$oData['voters_registered']?>" type="text" size="30" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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