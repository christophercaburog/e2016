<script type="text/javascript" src="<?=$themeJQueryPath?>ui/ui.core.js"></script>
<script type="text/javascript" src="<?=$themeJQueryPath?>ui/ui.tabs.js"></script>

<?php include_once("erentry_precinct_info.tpl.php");?>

<fieldset class="themeFieldset01_notopborder">
    <?php include_once("erentry_precinct_details.tpl.php");?>
</fieldset>

<form action="" method="post">
<input type="hidden" name="precincts_code" value="<?=$arrPrecinctInfo['precincts_code']?>">
<?php
if(isset($eMsg)){
?>
<fieldset class="themeFieldset01_notopborder">
<?php
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
<?php
	}
?>
</fieldset>
<?php
}
?>
<fieldset class="themeFieldset01_notopborder">
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1"><b>National</b></a></li>
            <li><a href="#tabs-3"><b>Provincial</b></a></li>
            <li><a href="#tabs-4"><b>Local</b></a></li>
            <li><a href="#tabs-2"><b>Party List (optional)</b></a></li>
        </ul>

        <div id="tabs-1">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <?php
            //printa($arrNationalCandidates);
            foreach ($arrNationalCandidates as $keyNationalCandidates => $valNationalCandidates) {
                ob_start();
            ?>
                <tr>
                    <td>
                    <?php
                        $sumVotes = 0;
                        foreach ($valNationalCandidates['candidates'] as $keyCandidates => $valCandidates) {
                            $sumVotes += $arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value'];
                    ?>

                    <div class="candidateselector ui-state-defaultdark floatLeft theme-cursor-pointer" style="width:24.45%;">
                        <table border="0" width="100%">
                            <tr>
                                <td height="55" align="left" valign="middle" style="font-size:100%;">
                                    <span class="ui-state-highlight"><?=$valCandidates['political_candidates_order']?></span> <?=$valCandidates['political_candidates_name']?> <?=$valCandidates['political_candidates_alias']?>
                                </td>
                                <td width="20%" align="center" valign="middle">
                                    <?php if($arrPrecinctInfo['precincts_status'] < 40){?>
                                    <input type="text" size="5" style="text-align:right;" maxlength="5" class="candidateinputsel" name="candidatevotes[<?=$valCandidates['political_candidates_id']?>]" value="<?=$arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value']?>">
                                    <?php }else{ ?>
                                    <div class="ui-state-highlight" style="text-align:right;"><?=$arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value']?></div>
                                    <?php }?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <?php
                        }
                    ?>
                    </td>
                </tr>
                <?php
                        $obCandidateList = ob_get_clean();
                ?>
                <tr>
                    <td align="left" >
                        <div class="theme-candidatepost-label floatLeft" style="width: 77.80%;">&nbsp;<?=$valNationalCandidates['cpost']['candidate_post_name']?></div>
                        <div class="theme-candidatepost-label floatLeft" style="width: 20%;"><span class="floatLeft" style="text-align:left;">SUM:</span><span class="floatRight" style="text-align:right;"><?=$sumVotes?></span></div>
                    </td>
                </tr>
                <?=$obCandidateList?>
            <?php
            }
            ?>
            </table>
        </div>

        <div id="tabs-2">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <?php
            //printa($arrNationalCandidates);
            foreach ($arrPartyListCandidates as $keyPartyListCandidates => $valPartyListCandidates) {
                ob_start();
            ?>
                <tr>
                    <td>
                    <?php
                        $sumVotes = 0;
                        foreach ($valPartyListCandidates['candidates'] as $keyCandidates => $valCandidates) {
                            $sumVotes += $arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value'];
                    ?>

                    <div class="candidateselector ui-state-defaultdark floatLeft theme-cursor-pointer" style="width:24.45%;">
                        <table border="0" width="100%">
                            <tr>
                                <td height="55" align="left" valign="middle" style="font-size:100%;">
                                    <span class="ui-state-highlight"><?=$valCandidates['political_candidates_order']?></span> <?=$valCandidates['political_candidates_name']?> <?=$valCandidates['political_candidates_alias']?>
                                </td>
                                <td width="20%" align="center" valign="middle">
                                    <?php if($arrPrecinctInfo['precincts_status'] < 40){?>
                                    <input type="text" size="5" style="text-align:right;" maxlength="5" class="candidateinputsel" name="candidatevotes[<?=$valCandidates['political_candidates_id']?>]" value="<?=$arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value']?>">
                                    <?php }else{ ?>
                                    <div class="ui-state-highlight" style="text-align:right;"><?=$arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value']?></div>
                                    <?php }?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <?php
                        }
                    ?>
                    </td>
                </tr>
                <?php
                        $obCandidateList = ob_get_clean();
                ?>
                <tr>
                    <td align="left" >
                        <div class="theme-candidatepost-label floatLeft" style="width: 77.80%;">&nbsp;<?=$valPartyListCandidates['cpost']['candidate_post_name']?></div>
                        <div class="theme-candidatepost-label floatLeft" style="width: 20%;"><span class="floatLeft" style="text-align:left;">SUM:</span><span class="floatRight" style="text-align:right;"><?=$sumVotes?></span></div>
                    </td>
                </tr>
                <?=$obCandidateList?>
            <?php
            }
            ?>
            </table>
        </div>
        
        <div id="tabs-3">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <?php
            foreach ($arrProvincialCandidates as $keyProvincialCandidates => $valProvincialCandidates) {
                ob_start();
            ?>
                <tr>
                    <td>
                    <?php
                        $sumVotes = 0;
                        foreach ($valProvincialCandidates['candidates'] as $keyCandidates => $valCandidates) {
                            $sumVotes += $arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value'];
                    ?>

                    <div class="candidateselector ui-state-defaultdark floatLeft theme-cursor-pointer" style="width:24.45%;">
                        <table border="0" width="100%">
                            <tr>
                                <td height="55" align="left" valign="middle" style="font-size:100%;">
                                    <span class="ui-state-highlight"><?=$valCandidates['political_candidates_order']?></span> <?=$valCandidates['political_candidates_name']?> <?=$valCandidates['political_candidates_alias']?>
                                </td>
                                <td width="20%" align="center" valign="middle">
                                    <?php if($arrPrecinctInfo['precincts_status'] < 40){?>
                                    <input type="text" size="5" style="text-align:right;" maxlength="5" class="candidateinputsel" name="candidatevotes[<?=$valCandidates['political_candidates_id']?>]" value="<?=$arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value']?>">
                                    <?php }else{ ?>
                                    <div class="ui-state-highlight" style="text-align:right;"><?=$arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value']?></div>
                                    <?php }?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <?php
                        }
                    ?>
                    </td>
                </tr>
                <?php
                        $obCandidateList = ob_get_clean();
                ?>
                <tr>
                    <td align="left" >
                        <div class="theme-candidatepost-label floatLeft" style="width: 77.80%;">&nbsp;<?=$valProvincialCandidates['cpost']['candidate_post_name']?></div>
                        <div class="theme-candidatepost-label floatLeft" style="width: 20%;"><span class="floatLeft" style="text-align:left;">SUM:</span><span class="floatRight" style="text-align:right;"><?=$sumVotes?></span></div>
                    </td>
                </tr>
                <?=$obCandidateList?>
            <?php
            }
            ?>
            </table>
        </div>

        
        <div id="tabs-4">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <?php
            foreach ($arrMunicipalCandidates as $keyMunicipalCandidates => $valMunicipalCandidates) {
                ob_start();


            ?>
                <tr>
                    <td>
                    <?php
                        $sumVotes = 0;
                        foreach ($valMunicipalCandidates['candidates'] as $keyCandidates => $valCandidates) {
                            $sumVotes += $arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value'];
                    ?>

                    <div class="candidateselector ui-state-defaultdark floatLeft theme-cursor-pointer" style="width:24.45%;">
                        <table border="0" width="100%">
                            <tr>
                                <td height="55" align="left" valign="middle" style="font-size:100%;">
                                    <span class="ui-state-highlight"><?=$valCandidates['political_candidates_order']?></span> <?=$valCandidates['political_candidates_name']?> <?=$valCandidates['political_candidates_alias']?>
                                </td>
                                <td width="20%" align="center" valign="middle">
                                    <?php if($arrPrecinctInfo['precincts_status'] < 40){?>
                                    <input type="text" size="5" style="text-align:right;" maxlength="5" class="candidateinputsel" name="candidatevotes[<?=$valCandidates['political_candidates_id']?>]" value="<?=$arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value']?>">
                                    <?php }else{ ?>
                                    <div class="ui-state-highlight" style="text-align:right;"><?=$arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value']?></div>
                                    <?php }?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <?php
                        }
                    ?>
                    </td>
                </tr>
                <?php
                        $obCandidateList = ob_get_clean();
                ?>
                <tr>
                    <td align="left" >
                        <div class="theme-candidatepost-label floatLeft" style="width: 77.80%;">&nbsp;<?=$valMunicipalCandidates['cpost']['candidate_post_name']?></div>
                        <div class="theme-candidatepost-label floatLeft" style="width: 20%;"><span class="floatLeft" style="text-align:left;">SUM:</span><span class="floatRight" style="text-align:right;"><?=$sumVotes?></span></div>
                    </td>
                </tr>
                <?=$obCandidateList?>
            <?php
            }
            ?>
            </table>
        </div>
        
    </div>
</fieldset>

<?php if($arrPrecinctInfo['precincts_status'] < 40){?>
<fieldset class="themeFieldset01_notopborder">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center"><input type="submit" name="submit_save" id="submit_save" value="Save Changes"></td>
        </tr>
        <tr>
            <td><img alt="" src="<?=$themeImagesPath?>spacer.gif" width="10" height="5"></td>
        </tr>
    </table>
</fieldset>
</form>
<?php } ?>

<?php if(count($arrCandidateVotesData) > 0){?>
<form method="post" action="">
<input type="hidden" name="precincts_code" value="<?=$arrPrecinctInfo['precincts_code']?>">
<fieldset class="themeFieldset01_notopborder">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td  align="center">
                <?php
                        if($arrPrecinctInfo['precincts_status'] == 20){
                ?>
                <div class="ui-state-highlight ui-notify-pad5">
                    <input type="checkbox" name="precincts_status" id="precincts_status_submit_verification" value="20"> I reviewed all data entry and ready to submit for verification.<br /><br />
                    <input type="submit" name="submit_verification" id="submit_verification" class="ui-state-disabled" disabled="disabled" value="Submit for Verification">
                </div>
                <?php
                        }elseif(($arrPrecinctInfo['precincts_status'] == 25 || $arrPrecinctInfo['precincts_status'] == 30) && ($_SESSION['admin_session_obj']['user_type'] == 'volval' || $_SESSION['admin_session_obj']['user_type'] == 'svolval') ) {
                ?>
                <div class="ui-state-highlight ui-notify-pad5 floatLeft" style="width:48%;height: 80px;">
                    <input type="checkbox" name="precincts_status_submit_verified" id="precincts_status_submit_verified" value="40"> I reviewed all data entry and set this precinct as verified.<br /><br />
                    <input type="submit" name="submit_verified" id="submit_verified" disabled="disabled" class="ui-state-disabled" value="Submit as Verified">
                </div>
                <div class="ui-state-error ui-notify-pad5 floatLeft" style="width:48%;height: 80px;">
                    <input type="hidden" name="precincts_status_submit_pendingerror" id="precincts_status_submit_pendingerror" value="30">
                    <textarea cols="60" rows="1" name="precincts_encoded_remarks" id="precincts_encoded_remarks"><?=(empty($arrPrecinctInfo['precincts_encoded_remarks'])?"Remarks":$arrPrecinctInfo['precincts_encoded_remarks'])?></textarea>
                    <br /><br />
                    <input type="submit" name="submit_pendingerror" id="submit_pendingerror" value="Submit as Pending">
                </div>
                <?php }else{
                    if($arrPrecinctInfo['precincts_status'] == 40){?>
                            <div class="ui-state-error ui-notify-pad5"><span class="ui-icon ui-icon-flag floatLeft"></span><b>VERIFIED</b></div>
                        <?php
                            }elseif($arrPrecinctInfo['precincts_status'] == 30){?>
                            <div class="ui-state-error ui-notify-pad5"><span class="ui-icon ui-icon-flag floatLeft"></span><b>PENDING ERROR</b></div>
                            <div class="ui-state-error ui-notify-pad5"><span class="ui-icon ui-icon-alert floatLeft"></span><b><?=$arrPrecinctInfo['precincts_encoded_remarks']?></b></div>
                        <?php
                            }elseif($arrPrecinctInfo['precincts_status'] == 25){?>
                            <div class="ui-state-error ui-notify-pad5"><span class="ui-icon ui-icon-flag floatLeft"></span><b>FOR VERIFICATION</b></div>
                        <?php
                            }elseif($arrPrecinctInfo['precincts_status'] == 20){?>
                            <div class="ui-state-error ui-notify-pad5"><span class="ui-icon ui-icon-flag floatLeft"></span><b>PROCESSING</b></div>
                        <?php
                            }
                     } ?>
            </td>
        </tr>
    </table>
</fieldset>
</form>
<?php } ?>

<script type="text/javascript">
	$().ready(function() {
		$("#tabs").tabs();
	});
    
        var lastInputObj = false;

    $(".candidateselector").hover(function(){
        //console.log($($($(this).children().children().children().children()[1]).children()));        
        $(this).removeClass("ui-state-defaultdark");
        $(this).addClass("ui-state-defaultdarkhover");
    }, function(){
        $(this).removeClass("ui-state-defaultdarkhover");
        $(this).addClass("ui-state-defaultdark");
    }).click(function(){
        $($($(this).children().children().children().children()[1]).children()).focus();
    });
    $(".candidateinputsel").keypress(function(event){
        //if(event.which == 46){return ($(this).val().length > 0 && $(this).val().indexOf(".", 0) <= 0)}
        return ((event.which >= 48) && (event.which <= 57) || (event.which == 8 || event.which ==0))
    }).focus(function(){
        $(this).addClass("theme-input-focus");
        $($(this).parent().parent().parent().parent().parent()).addClass("ui-state-defaultdarksel");
        //console.log($($(this).parent().parent().parent().parent().parent()));
    }).blur(function(){
        $(this).removeClass("theme-input-focus");
        $($(this).parent().parent().parent().parent().parent()).removeClass("ui-state-defaultdarksel");
    });

    $("#submit_save").click(function(){
        return confirm("Are you sure you want to save changes?");
    });
    
    $("#submit_verification").click(function(){
        return confirm("Are you sure you want to submit data for verification?");
    });
    $("#submit_verified").click(function(){
        return confirm("Are you sure you want to set precinct as verified?");
    });
    $("#submit_pendingerror").click(function(){
        return confirm("Are you sure you want to set precinct as pending error?");
    });

    $("#precincts_status_submit_verification").click(function(){
        if($(this).attr("checked")){
            $("#submit_verification").removeAttr("disabled").removeClass("ui-state-disabled");
        }else{
            $("#submit_verification").attr("disabled","disabled").addClass("ui-state-disabled");
        }
    });
    
    $("#precincts_status_submit_verified").click(function(){
        if($(this).attr("checked")){
            $("#submit_verified").removeAttr("disabled").removeClass("ui-state-disabled");
        }else{
            $("#submit_verified").attr("disabled","disabled").addClass("ui-state-disabled");
        }
    });
</script>
