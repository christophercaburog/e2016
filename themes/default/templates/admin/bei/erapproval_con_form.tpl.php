<div class="themeFieldsetDiv01">
<fieldset class="themeFieldset01">
<legend class="themeLegend01">ER Confirmation Form</legend>
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

<table style="width: 100%;" border="0" cellpadding="0"
 cellspacing="0">
  <tbody>
   
    <tr>
      <td>
      <b><?php
      if (($_GET['action'] == 'addverify')) {
      	echo "SYSTEM REF ID: SYS00001";
      }
      ?></b>
      </td>
    </tr>
    <tr>
      <td bgcolor="#f8f8f8">
      <table style="width: 100%;" class="tdNoLine"
 border="0" cellpadding="3">
        <tbody>
          <tr>
            <td width="50%"><strong>REGION</strong></td>
            <td width="50%"><strong>PROVINCE</strong></td>
          </tr>
          <tr>
          	<td bgcolor="#FFFFFF"><?=$_SESSION['admin_session_obj']['user_data']['region_name']?></td>
          	<td bgcolor="#FFFFFF"><?=$_SESSION['admin_session_obj']['user_data']['province_name']?></td>
          </tr>
          <tr>
            <td><strong>CITY/MUNICIPALITY </strong></td>
            <td><strong>POLLING PLACE</strong></td>
          </tr>
          <tr>
          	<td bgcolor="#FFFFFF"><?=$_SESSION['admin_session_obj']['user_data']['municipal_name']?></td>
          	<td bgcolor="#FFFFFF"><?=$_SESSION['admin_session_obj']['user_data']['pollingplaces_name']?></td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
 <tr>
      <td bgcolor="#f8f8f8">
      <table style="width: 100%;" cellpadding="2" cellspacing="2" class="tdNoLine"
 border="0">
        <tbody>
          <tr>
            <td align="left" width="20%"><b>Precinct No:</b></td>
            <td><input name="precinct_id" class="boxA" id="precinct_id"></td>
            <td align="left">&nbsp;<!--<b>Total no. of Registered Voters</b>--></td>
            <td>&nbsp;<!--<label><input name="total_no_registeredvoters"
 class="boxD" id="total_no_registeredvoters" value=""
 type="text"></label>--> </td>
          </tr>
<!--          <tr>
            <td align="left"><b>Congressional District</b></td>
            <td>
            <input name="evotesdata_cd" class="boxD" id="evotesdata_cd" value="" type="text">
            </td>
            <td align="left" ></td>
            <td></td>
          </tr>
-->        </tbody>
      </table>
      </td>
    </tr>
    <tr>
      <td><hr>
      </td>
    </tr>
    <tr>
      <td>
      
      <table border="0" cellpadding="2" cellspacing="2" width="100%">
	      <tr>
	      	<td width="50">&nbsp;</td>
	      	<td width="250">&nbsp;</td>
	      	<td width="200">&nbsp;</td>
	      	<td>&nbsp;</td>
	      </tr>
      <?php
      foreach ($arrListOfCandidates as $aLOCkey => $aLOCvalue) {
      ?>
	      <tr>
	      	<td colspan="4"><b><?=$aLOCvalue['acpData']['candidate_post_desc']?></b></td>
	      </tr>
	      <?php
	      	$candidateCtr = 1;
	      	foreach ($aLOCvalue['polCandidates'] as $pCkey => $pCvalue) {
	      ?>
	      <tr>
	      	<td><?=$candidateCtr++;?></td>
	      	<td><?=$pCvalue['political_candidates_name']?></td>
	      	<td><?=$pCvalue['political_candidates_alias']?></td>
	      	<td><input type="text" name="votes[<?=$aLOCkey?>][<?=$pCvalue['political_candidates_id']?>]"></td>
	      </tr>
	      <?php
	      	}
	      ?>
      <?
      }
      ?>
      </table>
      </td>
    </tr>
    <tr>
      <td><hr>
      </td>
    </tr>
    <tr>
      <td>
      Human Access Verification:
      <input type="text">
      </td>
    </tr>
    <tr>
      <td><img src="<?=$themeImagesPath?>admin/captcha.jpg"></td>
    </tr>
    <tr>
      <td>&nbsp;
      </td>
    </tr>
    <tr>
      <td><input name="Submit"
 class="register" value="Confirm" type="submit">
      <?php
      if (($_GET['action'] == 'addverify')) {
     	?>
     	<input type="button" value="Print">
     	<?php
      }
      ?>
      </td>
    </tr>
    <tr>
      <td></td>
    </tr>
  </tbody>
</table>


</form>
</fieldset>
</div>