<style>
.txtInput{
	text-align:right;
}
</style>
<div class="themeFieldsetDiv01">
<fieldset class="themeFieldset01">
<legend class="themeLegend01">Election Returns Entry Form</legend>
<?php 
if (isset($_GET['print'])) {
	$textFldParam = "readonly";
}

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

<table style="width: 100%;" border="0" cellpadding="0"
 cellspacing="0">
  <tbody>
   
    <tr>
      <td>
      <b><?php
      if (isset($_GET['print'])) {
      	echo "SYSTEM REF ID: $_GET[print]";
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
            <td><strong>VOTING PLACE</strong></td>
          </tr>
          <tr>
          	<td bgcolor="#FFFFFF"><?=$_SESSION['admin_session_obj']['user_data']['municipal_name']?></td>
          	<td bgcolor="#FFFFFF"><?=$_SESSION['admin_session_obj']['user_data']['pollingplaces_name']?></td>
          </tr>
          <tr>
            <td><strong>PRECINT NO. </strong></td>
            <td><strong>ER SERIES NO.</strong></td>
          </tr>
          <tr>
          	<td bgcolor="#FFFFFF">
						<?php
            	if(isset($_GET['edit'])){
            		$selectDisabled = "disabled";
          	?>
            <?php
            	}
           	?>                 	
           	<select name="precinct_id" id="precinct_id" <?=$selectDisabled?> > 
            		<option value="0">-</option>
            		<?=html_options_2d($arrListOfPrecincts,'precints_id','precints_number',$oData['precincts_id'],false)?>
            	</select>
 	          	</td>
          	<td bgcolor="#FFFFFF"><input type="text" <?=$selectDisabled?> name="vt_erseriesno" value="<?=$oData['vt_erseriesno']?>" class="txtInput"></td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>

    <tr>
      <td><hr>
      </td>
    </tr>
	
	
	
	<tr>
      <td bgcolor="#f8f8f8">
      <table style="width: 100%;" class="tdNoLine"
 border="0" cellpadding="3">
        <tbody>
          <tr>
            <td>&nbsp;</td>
            <td align="center"><strong>DATA ON VOTERS AND BALLOTS </strong></td>
            <td align="center"><strong> TOTAL NUMBER</strong></td>
          </tr>
          <tr>
            <td width="2%">1</td>
            <td width="79%">NUMBER OF VOTERS REGISTERED IN THE PRECINCT </td>
            <td width="19%" align="center"><input type="text" name="vt_vr" value="<?=$oData['vt_vr']?>" class="txtInput" size="5" maxlength="3"/></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">2</td>
          	<td bgcolor="#FFFFFF">NUMBER OF VOTERS WHO ACTUALLY VOTED </td>
          	<td bgcolor="#FFFFFF" align="center"><input type="text" name="vt_vv" value="<?=$oData['vt_vv']?>" class="txtInput" size="5" maxlength="3"/></td>
          </tr>
          <tr>
            <td>3</td>
            <td>BALLOTS FOUND IN THE COMPARTMENT FOR VALID BALLOTS </td>
            <td align="center"><input type="text" name="vt_validballots" value="<?=$oData['vt_validballots']?>" class="txtInput" size="5" maxlength="3"/></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">4</td>
            <td bgcolor="#FFFFFF">VALID BALLOTS WITHDRAWN FROM THE COMPARTMENT FOR SPOILED BALLOTS HAVING BEEN MISTAKENLY PLACED THEREIN </td>
            <td bgcolor="#FFFFFF" align="center"><input type="text" name="vt_spoiledballots" value="<?=$oData['vt_spoiledballots']?>" size="5" class="txtInput" maxlength="3"/></td>
          </tr>
          <tr>
            <td>5</td>
            <td>EXCESS BALLOTS (BALLOTS FOUND INSIDE THE COMPARTMENT FOR VALID BALLOTS IN EXCESS OF THE NUMBER OF VOTERS WHO VOTED) </td>
            <td align="center"><input type="text" name="vt_excessballots" value="<?=$oData['vt_excessballots']?>" class="txtInput" size="5" maxlength="3"/></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">6</td>
          	<td bgcolor="#FFFFFF">REJECTED BALLOTS (BALLOTS REJECTED BY THE BOARD FOR BEING FOUND FOLDED TOGETHER OR FOR BEING DECLARED BY THE BOARD AS MARKED) </td>
          	<td bgcolor="#FFFFFF" align="center"><input type="text" name="vit_rejectedballots" value="<?=$oData['vit_rejectedballots']?>"  size="5" class="txtInput" maxlength="3"/></td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
 <tr>
      <td bgcolor="#f8f8f8">&nbsp;</td>
    </tr>
    <tr>
      <td><hr>
      </td>
    </tr>
	
	
	
    <tr>
      <td>
      
      <table border="0" cellpadding="0" cellspacing="1" width="100%">
	      <tr>
	      	<td width="50">&nbsp;</td>
	      	<td width="250">&nbsp;</td>
	      	<td width="200">&nbsp;</td>
	      	<td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
      <?php
      foreach ($arrListOfCandidates as $aLOCkey => $aLOCvalue) {
      ?>
	      <tr>
	      	<td colspan="5"><b><?=$aLOCvalue['acpData']['candidate_post_desc']?></b></td>
	      </tr>
	      <?php
	      	$candidateCtr = 1;
	      	foreach ($aLOCvalue['polCandidates'] as $pCkey => $pCvalue) {
	      ?>
	      <tr class="divTblListTR">
	      	<td class="divTblListTD"><?=$candidateCtr++;?></td>
	      	<td class="divTblListTD"><?=$pCvalue['political_candidates_name']?></td>
	      	<td class="divTblListTD"><?=$pCvalue['political_candidates_alias']?></td>
	      	<td class="divTblListTD"><input <?=$textFldParam?> type="text" name="votes[<?=$aLOCkey?>][<?=$pCvalue['political_candidates_id']?>]" size="5" maxlength="3" value="<?=$oData['candidatevotes'][$pCvalue['political_candidates_id']]?>"  class="txtInput"/></td>
	        <td class="divTblListTD">&nbsp;
	        <?php
	        	if (isset($_GET['edit']) || isset($_GET['confirmation']) || isset($_GET['print'])) {
	        		echo $edfOBJ->Convert($oData['candidatevotes'][$pCvalue['political_candidates_id']]);
	        	}
	        ?>
	        </td>
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
    </tr>
    <tr>
      <td>
      </td>
    </tr>
    <!--<tr>
      <td>
      Human Access Verification:
      <input type="text">
      </td>
    </tr>
    <tr>
      <td><img src="his/hisview.php"></td>
    </tr>
    <tr>
      <td>&nbsp;
      </td>
    </tr>
    <tr>
      <td>
      <b><?php
      if (isset($_GET['confirmation'])) {
      ?>
      ENTER 6 DIGIT PASSCODE:<input type="text">
      <?php
      }
      ?></b>
      </td>
    </tr>-->
    <tr>
      <td><!--<input name="Submit"
 class="register" value="Print" type="button" onclick="javascript:document.print">
      <?php
      if (isset($_GET['edit'])) {
     	?>
     	<input type="button" value="Print">
     	<?php
      }
      ?>-->
      </td>
    </tr>
    <tr>
      <td></td>
    </tr>
  </tbody>
</table>

<script language="javascript">
	document.print();
</script>


</fieldset>
</div>