<link href="<?=$themeJQueryPath?>ui/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script src="<?=$themeJQueryPath?>ui/ui.core.js" type="text/javascript"></script>
<script src="<?=$themeJQueryPath?>ui/ui.dialog.js" type="text/javascript"></script>
<script src="<?=$themeJQueryPath?>ui/ui.draggable.js" type="text/javascript"></script>
<script src="<?=$themeJQueryPath?>ui/ui.resizable.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$themeJQueryPath?>ui/jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?=$themeJQueryPath?>/ui/jquery.jgrow.js"></script>
<script type="text/javascript" src="<?=$themeJQueryPath?>ui/effects.core.js"></script>
<script type="text/javascript" src="<?=$themeJQueryPath?>ui/effects.pulsate.js"></script>
<script type="text/javascript" src="<?=$themeJQueryPath?>ui/ui.datepicker.js"></script>
<script type="text/javascript" src="<?=$themeJQueryPath?>ui/ui.tabs.js"></script>


<script type="text/javascript">
    $(document).ready(function(){
        var action = '<?=$_GET['edit']?>'
        if(action != ""){
            $("#province_id").attr('disabled', '');
            $("#province_name").attr('disabled', '');
            $("#mun_id").attr('disabled', '');
            $("#municipal_name").attr('disabled', '');
            $("#barangay_id").attr("disabled", "");
            $("#barangay_name").attr("disabled", "");
        }
        $("#region_name").autocomplete("setup.php?statpos=precinct&action=region",{
            cacheLength:0
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
            $("#region_id").val(data[1]);
            $("#region_name").val(data[2]);
            $("#province_id").attr('disabled', '');
            $("#province_name").attr('disabled', '');
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#region_id").val('');
                $("#region_name").val('');
                $("#province_id").val('');
                $("#province_name").val('');
                $("#province_id").attr('disabled', 'disabled');
                $("#province_name").attr('disabled', 'disabled');
            }
        });

        $("#province_name").autocomplete("setup.php?statpos=precinct&action=province",{
            cacheLength:0
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                rgnid:function(){
                    return $('#region_id').val();
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
            $("#province_id").val(data[1]);
            $("#province_name").val(data[2]);
            $("#mun_id").attr('disabled', '');
            $("#municipal_name").attr('disabled', '');
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#province_id").val('');
                $("#province_name").val('');
                $("#mun_id").val('');
                $("#municipal_name").val('');
                $("#mun_id").attr('disabled', 'disabled');
                $("#municipal_name").attr('disabled', 'disabled');
            }
        });

        $("#municipal_name").autocomplete("setup.php?statpos=precinct&action=mun",{
            cacheLength:0
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                provid:function(){
                    return $('#province_id').val();
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
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#mun_id").val('');
                $("#municipal_name").val('');
            }
        });

        $("#user_name").blur(function(){
            $("#user_email").val($(this).val());
        });

    });
</script>

<div class="themeFieldsetDiv01">
    <fieldset class="themeFieldset01">
        <legend class="themeLegend01">Manage User Form</legend>
        <?php
        if(isset($eMsg)) {
            if (is_array($eMsg)) {
                ?>
        <div class="tblListErrMsg">
            <b>Check the following error(s) below:</b><br>
                    <?php
                    foreach ($eMsg as $key => $value) {
                        ?>
            &nbsp;&nbsp;&bull;&nbsp;<?=$value?>
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
            <?//php printa($oData)?>
            <table width="100%" border="0" cellspacing="0" cellpadding="1">
                <tr>
                    <td width="200">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Username </td>
                    <td><input name="user_name" type="text" id="user_name" value="<?=$oData['user_name']?>" size="35" maxlength="130" /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input name="user_password" type="text" id="user_password" value="<?=$oData['user_password']?>" size="20" maxlength="15" /></td>
                    <td>
                        
                        <?php //if(isset($_GET['edit'])){ ?>
                        <!--<input type="submit" name="resetpwd" value="Reset Password">-->
                        <?php //}else{ ?>
                        <!--<i>'Password is Auto Generated and will be Sent to your Email Account'</i>-->
                        <?php //} ?>
                    </td>
                </tr>
                <tr>
                    <td>User type </td>
                    <td><select name="user_type" id="user_type">
                            <?=html_options_2d($lstUserType,'user_type','user_type_name', $oData['user_type'],false)?>
                        </select></td>
                </tr>
                <!--tr>
                    <td>Department</td>
                    <td>
                        <select name="ud_id" id="ud_id">
                            <?//=html_options_2d($lstDepartment,'ud_id','ud_name', $oData['ud_id'],false)?>
                        </select></td>
                </tr-->
                <tr>
                    <td>Email: </td>
                    <td><input name="user_email" type="text" id="user_email" value="<?=$oData['user_email']?>" size="20" maxlength="30" /></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><select name="user_status" id="user_status">
                            <?=html_options($lstStatus,$oData['user_status'])?>
                        </select></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><strong>User Personal Information</strong> </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><input name="user_fullname" type="text" id="user_fullname" value="<?=$oData['user_fullname']?>" size="64" maxlength="255" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Region</td>
                    <td>
                        <input type="hidden" name="region_id" id="region_id" value="<?=$oData['rgn_id']?>">
                        <input type="text" name="region_name" id="region_name" value="<?=$oData['region_name']?>">
                    </td>
                </tr>
                <tr>
                    <td>Province</td>
                    <td>
                        <input type="hidden" name="province_id" id="province_id" value="<?=$oData['prov_id']?>" disabled>
                        <input type="text" name="province_name" id="province_name" value="<?=$oData['province_name']?>" disabled>
                    </td>
                </tr>
                <tr>
                    <td>Municipal</td>
                    <td>
                        <input type="hidden" name="mun_id" id="mun_id" value="<?=$oData['mun_id']?>" disabled>
                        <input type="text" name="municipal_name" id="municipal_name" value="<?=$oData['municipal_name']?>" disabled>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="Submit" value="Submit" class="themeInputButton" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>