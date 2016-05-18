<script type="text/javascript" src="<?=$themeJQueryPath?>ui/ui.core.js"></script>
<script type="text/javascript" src="<?=$themeJQueryPath?>ui/ui.tabs.js"></script>

<?php include_once("erentry_precinct_info.tpl.php");?>

<fieldset class="themeFieldset01_notopborder">
    <?php include_once("erentry_precinct_details.tpl.php");?>
</fieldset>

<?php if(count($arrCandidateVotesData) > 0){
        if($arrPrecinctInfo['precincts_status'] == 40){?>
<fieldset class="themeFieldset01_notopborder">
    <div class="ui-state-error ui-notify-pad5"><span class="ui-icon ui-icon-flag floatLeft"></span><b>VERIFIED</b></div>
</fieldset>
<?php
        }elseif($arrPrecinctInfo['precincts_status'] == 30){?>
<fieldset class="themeFieldset01_notopborder">
    <div class="ui-state-error ui-notify-pad5"><span class="ui-icon ui-icon-flag floatLeft"></span><b>PENDING ERROR</b></div>
    <div class="ui-state-error ui-notify-pad5"><span class="ui-icon ui-icon-alert floatLeft"></span><b><?=$arrPrecinctInfo['precincts_encoded_remarks']?></b></div>
</fieldset>
<?php
        }elseif($arrPrecinctInfo['precincts_status'] == 25){?>
<fieldset class="themeFieldset01_notopborder">
    <div class="ui-state-error ui-notify-pad5"><span class="ui-icon ui-icon-flag floatLeft"></span><b>FOR VERIFICATION</b></div>
</fieldset>
<?php
        }elseif($arrPrecinctInfo['precincts_status'] == 20){?>
<fieldset class="themeFieldset01_notopborder">
    <div class="ui-state-error ui-notify-pad5"><span class="ui-icon ui-icon-flag floatLeft"></span><b>PROCESSING</b></div>
</fieldset>
<?php
        }
    }
?>

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
                                    <div class="ui-state-highlight" style="text-align:right;"><?=$arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value']?></div>
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
                                    <div class="ui-state-highlight" style="text-align:right;"><?=$arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value']?></div>
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
                                    <div class="ui-state-highlight" style="text-align:right;"><?=$arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value']?></div>
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
                                    <div class="ui-state-highlight" style="text-align:right;"><?=$arrCandidateVotesData[$valCandidates['political_candidates_id']]['cvotes_value']?></div>
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
</fieldset>

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
