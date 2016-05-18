<div style="padding-top:5px;">
<!--<img src="<?=$themeImagesPath?>admin/add.png" border="0" align="absbottom">&nbsp;<a href="popup.php?statpos=popup_precint&action=add">Add New</a><br />-->
</div>

<br>

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

<?=$tblDataList?>