<div class="themeFieldsetDiv01">
<fieldset class="themeFieldset01">
<legend class="themeLegend01">Module Form</legend>
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
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr>
    <td><input name="chkmenu" type="checkbox" id="chkmenu" value="1" checked="checked" />      <strong>Menu </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="200" align="left">Name </td>
    <td><input name="mnu_name" type="text" id="mnu_name" size="50" maxlength="255" value="<?=$oData['mnu_name']?>"/></td>
  </tr>
  <tr>
    <td align="left" valign="top">Description</td>
    <td><textarea name="mnu_desc" cols="30" rows="3" id="mnu_desc"><?=$oData['mnu_desc']?></textarea></td>
  </tr>
  <tr>
    <td align="left">Icon Filename </td>
    <td><input name="mnu_icon" type="text" id="mnu_icon" size="50" maxlength="255" value="<?=$oData['mnu_icon']?>"/></td>
  </tr>
  <tr>
    <td align="left">Parent </td>
    <td>
		<select name="mnu_parent" id="mnu_parent">
			<?php /*=html_options_2d($lstParent,'mnu_id','mnu_name', $oData['mnu_parent'],false)*/?>
			<?=$lstParents?>
		</select>
		</td>
  </tr>
  <tr>
    <td align="left">Order</td>
    <td><input name="mnu_ord" type="text" id="mnu_ord" size="10" maxlength="10" value="<?=$oData['mnu_ord']?>" /></td>
  </tr>
  <tr>
    <td align="left">Status</td>
    <td>
		<select name="mnu_status" id="mnu_status">
			<?=html_options($lstStatus,$oData['mnu_status'])?>
		</select>
		</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>
      Link Information </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Link Page </td>
    <td><input name="linkpage" type="text" id="linkpage" value="<?=$oData['mnu_link_info']['linkpage']?>" />
      ?statpos=
      <input name="statpos" type="text" id="statpos" value="<?=$oData['mnu_link_info']['statpos']?>" /></td>
  </tr>
  <tr>
    <td>Additional querystring </td>
    <td><input name="querystring" type="text" id="querystring" size="50" maxlength="255" value="<?=$oData['mnu_link_info']['querystring']?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>
      <input name="chkmain" type="checkbox" id="chkmain" value="1" class="checkbox"/>
      Main Controller</strong></td>
    <td><?=$SYSCONFIG_ROOT_PATH?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="maincontroller" type="text" id="maincontroller" size="50" maxlength="255" value="<?=$oData['mnu_link_info']['maincontroller']?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Default Controller </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="default_controller" type="text" id="default_controller" size="50" maxlength="255" value="<?=$oData['mnu_link_info']['default_controller']?>" /></td>
  </tr>
  <tr>
    <td><strong>
      <input name="chkcontroller" type="checkbox" id="chkcontroller" value="1" class="checkbox"/>
      Controller</strong></td>
    <td><?=$SYSCONFIG_MODULE_PATH?></td></tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="controller_filename" type="text" id="controller_filename" size="50" maxlength="255" value="<?=$oData['mnu_link_info']['controller_filename']?>" /></td>
  </tr>
  <tr>
    <td><strong>
      <input name="chkclass" type="checkbox" id="chkclass" value="1" class="checkbox"/>
      Class</strong></td>
    <td><?=$SYSCONFIG_CLASS_PATH?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="class_filename" type="text" id="class_filename" size="50" maxlength="255" value="<?=$oData['mnu_link_info']['class_filename']?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Class Name</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="class_name" type="text" id="class_name" size="50" maxlength="255" value="<?=$oData['mnu_link_info']['class_name']?>" /></td>
  </tr>
  <tr>
    <td><strong>
      <input name="chktemplate" type="checkbox" id="chktemplate" value="1" class="checkbox"/>
      Template</strong></td>
    <td><?=$themePath."templates/"?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="template_filename" type="text" id="template_filename" size="50" maxlength="255" value="<?=$oData['mnu_link_info']['template_filename']?>" /></td>
  </tr>
  <tr>
    <td><strong>
      <input name="chktemplateform" type="checkbox" id="chktemplateform" value="1" class="checkbox"/>
      Template Form</strong></td>
    <td><?=$themePath."templates/"?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="templateform_filename" type="text" id="templateform_filename" size="50" maxlength="255" value="<?=$oData['mnu_link_info']['templateform_filename']?>" /></td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Submit" class="themeInputButton" /></td>
  </tr>
</table>
</form>
</fieldset>
</div>
