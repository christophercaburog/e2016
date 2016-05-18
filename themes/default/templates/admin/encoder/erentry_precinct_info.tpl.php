<fieldset>
    <table width="100%;" border="0" cellpadding="0" cellspacing="1">
    <tbody>
        <tr>
            <td width="50%" class="theme-info-label"><strong>REGION</strong></td>
            <td width="50%" class="theme-info-label"><strong>PROVINCE</strong></td>
        </tr>
        <tr>
            <td class="theme-info-content"><?=$arrPrecinctInfo['region_name']?></td>
            <td class="theme-info-content"><?=$arrPrecinctInfo['province_name']?></td>
        </tr>
        <tr>
            <td class="theme-info-label"><strong>CITY/MUNICIPALITY </strong></td>
            <td class="theme-info-label"><strong>VOTING PLACE</strong></td>
        </tr>
        <tr>
            <td class="theme-info-content"><?=$arrPrecinctInfo['municipal_name']?></td>
            <td class="theme-info-content"><?=$arrPrecinctInfo['precincts_polling_place']?></td>
        </tr>
        <tr>
            <td class="theme-info-label"><strong>BARANGAY</strong></td>
            <td class="theme-info-label"><strong>PRECINT NO. </strong></td>
        </tr>
        <tr>
            <td class="theme-info-content"><?=$arrPrecinctInfo['barangay_name']?><?php /*input type="text" <?=$selectDisabled?> name="vt_erseriesno" value="<?=$oData['vt_erseriesno']?>" class="txtInput" */?></td>
            <td><span class="theme-code"><?=$arrPrecinctInfo['precincts_number']?></span></td>
        </tr>
    </tbody>
</table>
</fieldset>