<!--<div style="padding-top:5px;">
<img src="<?=$themeImagesPath?>admin/add.png" border="0" align="absbottom">&nbsp;<a href="../setup/setup.php?statpos=region&amp;action=add">Add New</a><br />
</div>

<br>-->
<br />
<?php 
if(isset($eMsg)){
	if (is_array($eMsg)) {
?>
	<div class="tblListErrMsg">
	<b>Check the following error(s) below:</b><br>
	<?php
	foreach ($eMsg as $key => $value) {
	?>
	&nbsp;&nbsp;&bull;&nbsp;<?=$Value?>
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
<table width="100%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td colspan="2"><strong><!--REGION--></strong></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?=$tblDataList?><br />