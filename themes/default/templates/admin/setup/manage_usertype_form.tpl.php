<div class="themeFieldsetDiv01">
<fieldset class="themeFieldset01">
<legend class="themeLegend01">Manage User Type Form</legend>
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
      <td>Usertype </td>
      <td><input name="user_type" type="text" id="user_type" value="<?=$oData['user_type']?>" size="35" maxlength="30" /></td>
    </tr>
     <tr>
      <td>Name </td>
      <td><input name="user_type_name" type="text" id="user_type_name" value="<?=$oData['user_type_name']?>" size="35" maxlength="30" /></td>
    </tr>
     <tr>
      <td>Order </td>
      <td><input name="user_type_ord" type="text" id="user_type_ord" value="<?=$oData['user_type_ord']?>" size="35" maxlength="30" /></td>
    </tr>
     <tr>
      <td>Status </td>
      <td><select name="user_type_status" id="user_type_status">
      <?=html_options($lstStatus,$oData['user_type_status'])?>
      </select></td>
    </tr>
    
     <tr>
       <td valign="top">&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td valign="top">&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td valign="top">Department</td>
       <td><?php 
		foreach($lstUserDept as $Key => $Value){
			if(isset($oData) and is_array($oData))
			$xKey = array_search($Value['ud_id'],$oData['user_type_dept']);
			$xKey = empty($xKey)?0:$xKey;
		?>
		<input name="user_type_dept[]" type="checkbox" id="user_type_dept[]" value="<?=$Value['ud_id']?>" <?=(($oData['user_type_dept'][$xKey]==$Value['ud_id'])?"checked":"")?> /><?=$Value['ud_name']?><br />
			</option>
		<?php }?>&nbsp;</td>
     </tr>
     <tr>
       <td valign="top">Users Access </td>
       <td><?=$UserAccessModules?>&nbsp;</td>
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