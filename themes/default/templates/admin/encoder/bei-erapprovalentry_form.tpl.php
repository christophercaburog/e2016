<div class="themeFieldsetDiv01">
<fieldset class="themeFieldset01">
<legend class="themeLegend01">BEI-ER Approval Confirmation</legend>
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
<?php 
if ($encoding){
?>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <th width="26%" align="left" scope="row">System Reference No.</th>
      <td width="1%">&nbsp;</td>
      <td width="25%"><input type="text" name="sysrefno" id="sysrefno" /></td>
      <td width="48%">&nbsp;</td>
    </tr>
    <tr>
      <th align="left" scope="row">Precinct No.</th>
      <td>&nbsp;</td>
      <td><input type="text" name="precinctno" id="precinctno" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="left" scope="row">ER-Series </th>
      <td>&nbsp;</td>
      <td><input type="text" name="erseries" id="erseries" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="left" scope="row">BEI   Pairing Pass  code</th>
      <td>&nbsp;</td>
      <td><input type="password" name="beipasscode" id="beipasscode" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="left" scope="row">&nbsp;</th>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="left" scope="row">Human Access Verification</th>
      <td>&nbsp;</td>
      <td><input type="text" name="capcha" id="capcha" /></td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <th align="left" scope="row">&nbsp;</th>
      <td>&nbsp;</td>
      <td>&nbsp;<img src="his/hisview.php"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="left" scope="row">&nbsp;</th>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Confirm" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <?php
  } else {
  ?>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <th width="26%" align="left" scope="row">System Reference No.</th>
      <td width="1%">&nbsp;</td>
      <td width="25%"><?=$oData['sysrefno']?></td>
      <td width="48%">&nbsp;</td>
    </tr>
    <tr>
      <th align="left" scope="row">Precinct No.</th>
      <td>&nbsp;</td>
      <td><?=$oData['precinctno']?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="left" scope="row">ER-Series </th>
      <td>&nbsp;</td>
      <td><?=$oData['erseries']?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="left" scope="row">BEI   Paring Pass  code</th>
      <td>&nbsp;</td>
      <td><?=$oData['beipasscode']?></td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <th colspan="4" align="left" scope="row"><h2>Successfully Confirmed!</h2></th>
      </tr>
  </table>
   <?php
  } 
  ?>
  <p>&nbsp;</p>
  </form>
</fieldset>
</div>