
    <table width="100%" class="tdNoLine" border="0" cellpadding="1" cellspacing="0">
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left"><strong>DATA ON VOTERS AND BALLOTS </strong></td>
                    <td align="right"><strong>TOTAL NUMBER</strong></td>
                </tr>
                <tr class="theme-tr-odd">
                    <td width="2%">1</td>
                    <td width="79%">NUMBER OF VOTERS REGISTERED IN THE PRECINCT </td>
                    <td width="19%" align="right"><?=$arrPrecinctInfo['precincts_encoded_numberofvoters']?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>NUMBER OF VOTERS WHO ACTUALLY VOTED </td>
                    <td align="right"><?=$arrPrecinctInfo['precincts_encoded_actualvotedvoters']?></td>
                </tr>
                <tr class="theme-tr-odd">
                    <td>3</td>
                    <td>BALLOTS FOUND IN THE COMPARTMENT FOR VALID BALLOTS </td>
                    <td align="right"><?=$arrPrecinctInfo['precincts_encoded_totalvalidballot']?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>VCM ID</td>
                    <td align="right"><?=$arrPrecinctInfo['precincts_encoded_pcosid']?></td>
                </tr>
                <!--tr>
                    <td>4</td>
                    <td>VALID BALLOTS WITHDRAWN FROM THE COMPARTMENT FOR SPOILED BALLOTS HAVING BEEN MISTAKENLY PLACED THEREIN </td>
                    <td align="right"><input type="text" name="precincts_encoded_withdrawnvalidballot" value="<?=$oData['precincts_encoded_withdrawnvalidballot']?>"  maxlength="4" size="5" class="txtInput" style="text-align:right;"/></td>
                </tr>
                <tr class="theme-tr-odd">
                    <td>5</td>
                    <td>EXCESS BALLOTS (BALLOTS FOUND INSIDE THE COMPARTMENT FOR VALID BALLOTS IN EXCESS OF THE NUMBER OF VOTERS WHO VOTED) </td>
                    <td align="right"><input type="text" name="precincts_encoded_excess_ballot" value="<?=$oData['precincts_encoded_excess_ballot']?>" maxlength="4" size="5" class="txtInput" style="text-align:right;"/></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>REJECTED BALLOTS (BALLOTS REJECTED BY THE BOARD FOR BEING FOUND FOLDED TOGETHER OR FOR BEING DECLARED BY THE BOARD AS MARKED) </td>
                    <td align="right"><input type="text" name="precincts_encoded_excess_ballot" value="<?=$oData['precincts_encoded_excess_ballot']?>"  maxlength="4" size="5" class="txtInput" style="text-align:right;"/></td>
                </tr-->
            </tbody>
        </table>