<link href="../includes/jquery/ui/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../includes/jquery/themes/base/ui.all.css">
<script src="../includes/jquery/jquery-1.3.2.js" type="text/javascript"></script>
<script src="../includes/jquery/ui/ui.core.js" type="text/javascript"></script>
<script src="../includes/jquery/ui/ui.dialog.js" type="text/javascript"></script>
<script src="../includes/jquery/ui/ui.draggable.js" type="text/javascript"></script>
<script src="../includes/jquery/ui/ui.resizable.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/jquery/ui/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../includes/jquery/ui/jquery.jgrow.js"></script>
<script type="text/javascript" src="../includes/jquery/ui/effects.core.js"></script>
<script type="text/javascript" src="../includes/jquery/ui/effects.pulsate.js"></script>
<script src="../includes/jquery/ui/ui.datepicker.js"></script>
<script src="../includes/jquery/ui/ui.tabs.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        var action = '<?=$_GET['edit']?>'
        if(action != ""){
            $("#prov_id").attr('disabled', '');
            $("#province_name").attr('disabled', '');
            $("#mun_id").attr('disabled', '');
            $("#municipal_name").attr('disabled', '');
            $("#barangay_id").attr("disabled", "");
            $("#barangay_name").attr("disabled", "");
        }
        $("#region_name").autocomplete("setup.php?statpos=precinct&action=region",{
            cacheLength:1
            ,selectFirst: true
            ,width: 200
            ,formatItem: function(row){
                return row[2];
            }
            ,formatResult: function(row){
                return row[2].replace(/(<.+?>)/gi, '');
            }
        }).result(function(event, data, formatted){
            //            console.log(data);
            $("#rgn_id").val(data[1]);
            $("#region_name").val(data[2]);
            $("#prov_id").attr('disabled', '');
            $("#province_name").attr('disabled', '');
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#rgn_id").val('');
                $("#region_name").val('');
                $("#prov_id").val('');
                $("#province_name").val('');
                $("#prov_id").attr('disabled', 'disabled');
                $("#province_name").attr('disabled', 'disabled');
            }
        });

        $("#province_name").autocomplete("setup.php?statpos=precinct&action=province",{
            cacheLength:1
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                rgnid:function(){
                    return $('#rgn_id').val();
                }
            }
            ,formatItem: function(row){
                return row[2];
            }
            ,formatResult: function(row){
                return row[2].replace(/(<.+?>)/gi, '');
            }
        }).result(function(event, data, formatted){
            //            console.log(data);
            $("#prov_id").val(data[1]);
            $("#province_name").val(data[2]);
            $("#mun_id").attr('disabled', '');
            $("#municipal_name").attr('disabled', '');
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#prov_id").val('');
                $("#province_name").val('');
                $("#mun_id").val('');
                $("#mun_name").val('');
                $("#mun_id").attr('disabled', 'disabled');
                $("#municipal_name").attr('disabled', 'disabled');
            }
        });

        $("#municipal_name").autocomplete("setup.php?statpos=precinct&action=mun",{
            cacheLength:1
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                provid:function(){
                    return $('#prov_id').val();
                }
            }
            ,formatItem: function(row){
                return row[2];
            }
            ,formatResult: function(row){
                return row[2].replace(/(<.+?>)/gi, '');
            }
        }).result(function(event, data, formatted){
            $("#mun_id").val(data[1]);
            $("#municipal_name").val(data[2]);
            $("#barangay_id").attr("disabled", "");
            $("#barangay_name").attr("disabled", "");
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#mun_id").val('');
                $("#municipal_name").val('');
                $("#barangay_id").val('');
                $("#barangay_name").val('');
                $("#barangay_id").attr("disabled", "disabled");
                $("#barangay_name").attr("disabled", "disabled");
            }
        });

        $("#barangay_name").autocomplete("setup.php?statpos=precinct&action=barangay",{
            cacheLength:1
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                munid:function(){
                    return $('#mun_id').val();
                }
            }
            ,formatItem: function(row){
                return row[2];
            }
            ,formatResult: function(row){
                return row[2].replace(/(<.+?>)/gi, '');
            }
        }).result(function(event, data, formatted){
            //            console.log(data);
            $("#barangay_id").val(data[1]);
            $("#barangay_name").val(data[2]);
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#barangay_id").val('');
                $("#barangay_name").val('');
            }
        });

        
    });
</script>
<div class="themeFieldsetDiv01">
    <fieldset class="themeFieldset01">
        <legend class="themeLegend01">Manage Precinct Form</legend>
        <?php
        if(isset($eMsg)) {
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
            <table>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Region: </td>
                    <td>
                        <input name="rgn_id" id="rgn_id" value="<?=$oData['rgn_id']?>" size="30" type="hidden">
                        <input name="region_name" id="region_name" value="<?=$oData['region_name']?>" size="30" type="text">
                    </td>
                </tr>
                <tr>
                    <td>Province: </td>
                    <td>
                        <input name="prov_id" id="prov_id" value="<?=$oData['prov_id']?>" size="30" type="hidden" disabled>
                        <input name="province_name" id="province_name" value="<?=$oData['province_name']?>" size="30" type="text" disabled>
                    </td>
                </tr>
                <tr>
                    <td>Municipality: </td>
                    <td>
                        <input name="mun_id" id="mun_id" value="<?=$oData['mun_id']?>" size="30" type="hidden" disabled>
                        <input name="municipal_name" id="municipal_name" value="<?=$oData['municipal_name']?>" size="30" type="text" disabled>
                    </td>
                </tr>
                <tr>
                    <td>Barangay: </td>
                    <td>
                        <input name="barangay_id" id="barangay_id" value="<?=$oData['barangay_id']?>" size="30" type="hidden" disabled>
                        <input name="barangay_name" id="barangay_name" value="<?=$oData['barangay_name']?>" size="30" type="text" disabled>
                    </td>
                </tr>
                <tr>
                    <td>Precints no.: </td>
                    <td><input name="precincts_number" id="precincts_number" value="<?=$oData['precincts_number']?>" size="30" type="text"></td>
                </tr>
                <tr>
                    <td>Total Number of Voters: </td>
                    <td><input name="precincts_numberofvoters" id="precincts_numberofvoters" value="<?=$oData['precincts_numberofvoters']?>" size="30" type="text"></td>
                </tr>
                <tr>
                    <td width="25%">Clustered Group no:</td>
                    <td width="81%"><input name="precincts_cgroupno" id="precincts_cgroupno" value="<?=$oData['precincts_cgroupno']?>" size="30" type="text"></td>
                </tr>
                <tr>
                    <td width="25%">Group no:</td>
                    <td width="81%"><input name="precincts_groupno" id="precincts_groupno" value="<?=$oData['precincts_groupno']?>" size="30" type="text"></td>
                </tr>
                <tr>
                    <td width="25%">Total # of Voters After Clustering:</td>
                    <td width="81%"><input name="precincts_regvoterafterc" id="precincts_regvoterafterc" value="<?=$oData['precincts_regvoterafterc']?>" size="30" type="text"></td>
                </tr>
                <tr>
                    <td width="25%">Precincts Polling Place:</td>
                    <td width="81%">
                        <textarea name="precincts_polling_place" id="precincts_polling_place" cols="40" rows="2"><?=$oData['precincts_polling_place']?></textarea>
                    </td>
                </tr>
                <tr>
                    <td width="25%"><div align="left">Precinct Status:</div></th>
                    <td width="81%">
                        <select name="precincts_status">
                            <option value="10" <?php if($oData['precincts_status']=="5") {echo "selected";}?>>Open</option>
                            <option value="20" <?php if($oData['precincts_status']=="20") {echo "selected";}?>>Processing</option>
                            <option value="25" <?php if($oData['precincts_status']=="25") {echo "selected";}?>>For Verification</option>
                            <option value="30" <?php if($oData['precincts_status']=="30") {echo "selected";}?>>Pending Error</option>
                            <option value="40" <?php if($oData['precincts_status']=="40") {echo "selected";}?>>Verified</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="25%"><div align="left">Q.A. Status:</div></th>
                    <td width="81%">
                        <select name="precincts_qastatus">
                            <option value="5" <?php if($oData['precincts_qastatus']=="5") {echo "selected";}?>>Open</option>
                            <option value="10" <?php if($oData['precincts_qastatus']=="10") {echo "selected";}?>>Unverified</option>
                            <option value="15" <?php if($oData['precincts_qastatus']=="15") {echo "selected";}?>>Verified</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>User ID:</td>
                    <td><input type="text" name="user_id" value="<?=$oData['user_id']?>"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2"><input name="Submit" value="Save" type="submit">
                        <input name="Submit2" value="Reset" type="reset"></td>
            </table>
        </form>
    </fieldset>
</div>