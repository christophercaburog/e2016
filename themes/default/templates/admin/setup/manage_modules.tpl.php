<div style="padding-top:5px;">
<img src="<?=$themeImagesPath?>admin/add.png" border="0" align="absbottom">&nbsp;<a href="setup.php?statpos=managemodule&action=add">Add New</a><br />
</div>

<br>

<?php 
if(isset($eMsg)){
?>
<div class="tblListErrMsg">
<?=$eMsg?>
</div>
<?
}
?>

<?=$tblDataList?>