<?php include_once("erentry_precinct_info.tpl.php");?>



<form method="post" action="">
    <fieldset class="themeFieldset01_notopborder">
<div class="tselector theme-cursor-pointer ui-state-defaultdark floatLeft" style="width:49.50%;">
    <table width="100%"><tr><td width="70%">VCM ID</td><td align="right"><input type="text" name="precincts_encoded_pcosid" value="<?=$arrPrecinctInfo['precincts_encoded_pcosid']?>" maxlength="16" size="15" class="txtInputs" style="text-align:right;"/></td></tr></table>
</div>
<div class="tselector theme-cursor-pointer ui-state-defaultdark floatLeft" style="width:49.50%;">
    <table width="100%"><tr><td width="70%">Voters Who Voted</td><td align="right"><input type="text" name="precincts_encoded_actualvotedvoters" value="<?=$arrPrecinctInfo['precincts_encoded_actualvotedvoters']?>" maxlength="4" size="5" class="txtInput" style="text-align:right;"/></td></tr></table>
</div>
<div class="tselector theme-cursor-pointer ui-state-defaultdark floatLeft" style="width:49.50%;">
    <table width="100%"><tr><td width="70%">No. Registered Voters</td><td align="right"><input type="text" name="precincts_encoded_numberofvoters" value="<?=$arrPrecinctInfo['precincts_encoded_numberofvoters']?>" maxlength="4" size="5" class="txtInput" style="text-align:right;"/></td></tr></table>
</div>
<div class="tselector theme-cursor-pointer ui-state-defaultdark floatLeft" style="width:49.50%;">
    <table width="100%"><tr><td width="70%">Valid Ballots Count</td><td align="right"><input type="text" name="precincts_encoded_totalvalidballot" value="<?=$arrPrecinctInfo['precincts_encoded_totalvalidballot']?>" maxlength="4" size="5" class="txtInput" style="text-align:right;"/></td></tr></table>
</div>


        <?php /*table width="100%" class="tdNoLine" border="0" cellpadding="1" cellspacing="0">
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left"><strong>DATA ON VOTERS AND BALLOTS </strong></td>
                    <td align="right"><strong>TOTAL NUMBER</strong></td>
                </tr>
                <tr class="theme-tr-odd">
                    <td width="2%">1</td>
                    <td width="79%">NUMBER OF VOTERS REGISTERED IN THE PRECINCT </td>
                    <td width="19%" align="right"><input type="text" name="precincts_encoded_numberofvoters" value="<?=$arrPrecinctInfo['precincts_encoded_numberofvoters']?>" maxlength="4" size="5" class="txtInput" style="text-align:right;"/></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>NUMBER OF VOTERS WHO ACTUALLY VOTED </td>
                    <td align="right"><input type="text" name="precincts_encoded_actualvotedvoters" value="<?=$arrPrecinctInfo['precincts_encoded_actualvotedvoters']?>" maxlength="4" size="5" class="txtInput" style="text-align:right;"/></td>
                </tr>
                <tr class="theme-tr-odd">
                    <td>3</td>
                    <td>BALLOTS FOUND IN THE COMPARTMENT FOR VALID BALLOTS </td>
                    <td align="right"><input type="text" name="precincts_encoded_totalvalidballot" value="<?=$arrPrecinctInfo['precincts_encoded_totalvalidballot']?>" maxlength="4" size="5" class="txtInput" style="text-align:right;"/></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>PCOS ID</td>
                    <td align="right"><input type="text" name="precincts_encoded_pcosid" value="<?=$arrPrecinctInfo['precincts_encoded_pcosid']?>" maxlength="4" size="5" class="txtInput" style="text-align:right;"/></td>
                </tr>
                <!--tr>
                    <td>4</td>
                    <td>VALID BALLOTS WITHDRAWN FROM THE COMPARTMENT FOR SPOILED BALLOTS HAVING BEEN MISTAKENLY PLACED THEREIN </td>
                    <td align="right"><input type="text" name="precincts_encoded_withdrawnvalidballot" value="<?=$arrPrecinctInfo['precincts_encoded_withdrawnvalidballot']?>"  maxlength="4" size="5" class="txtInput" style="text-align:right;"/></td>
                </tr>
                <tr class="theme-tr-odd">
                    <td>5</td>
                    <td>EXCESS BALLOTS (BALLOTS FOUND INSIDE THE COMPARTMENT FOR VALID BALLOTS IN EXCESS OF THE NUMBER OF VOTERS WHO VOTED) </td>
                    <td align="right"><input type="text" name="precincts_encoded_excess_ballot" value="<?=$arrPrecinctInfo['precincts_encoded_excess_ballot']?>" maxlength="4" size="5" class="txtInput" style="text-align:right;"/></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>REJECTED BALLOTS (BALLOTS REJECTED BY THE BOARD FOR BEING FOUND FOLDED TOGETHER OR FOR BEING DECLARED BY THE BOARD AS MARKED) </td>
                    <td align="right"><input type="text" name="precincts_encoded_excess_ballot" value="<?=$arrPrecinctInfo['precincts_encoded_excess_ballot']?>"  maxlength="4" size="5" class="txtInput" style="text-align:right;"/></td>
                </tr-->
            </tbody>
        </table */ ?>

    </fieldset>
    <fieldset class="themeFieldset01_notopborder">
        <div class="floatRight">
            <?php
                    if($arrPrecinctInfo['precincts_status'] < 40){
            ?>
            <input type="submit" value="Save and Next" name="submit_savenext">
            <?php
                    }
            if((!empty($arrPrecinctInfo['precincts_encoded_numberofvoters']) && !empty($arrPrecinctInfo['precincts_encoded_actualvotedvoters'])) || $arrPrecinctInfo['precincts_status'] == 40){
            ?>
            <input type="submit" value="Skip Save" name="submit_skipsave">
            <?php
            }
            ?>
        </div>
    </fieldset>
</form>

<script type="text/javascript">
    $(".txtInput").keypress(function(event){
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

    <?php
        if($arrPrecinctInfo['precincts_status'] == 40){
    ?>
        $(".txtInput").attr("readonly","true");
    <?php
        }
    ?>
        
    $(".tselector").hover(function(){
        //console.log($($($(this).children().children().children().children()[1]).children()));
        $(this).removeClass("ui-state-defaultdark");
        $(this).addClass("ui-state-defaultdarkhover");
    }, function(){
        $(this).removeClass("ui-state-defaultdarkhover");
        $(this).addClass("ui-state-defaultdark");
    }).click(function(){
        $($($(this).children().children().children().children()[1]).children()).focus();
    });

</script>
