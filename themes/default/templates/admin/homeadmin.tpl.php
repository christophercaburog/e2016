<fieldset>
    <div class="floatLeft ui-state-error ui-notify-pad5"><span class="floatLeft ui-icon ui-icon-alert"></span>To browse project of precinct list <a href="../pop/" style="color:blue;" target="_new">click HERE</a>.</div>
</fieldset>
<?php
        if($hasViewGrant){
?>
<link href="<?=$themeJQueryPath?>ui/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$themeJQueryPath?>ui/jquery.autocomplete.js"></script>

<script type="text/javascript" src="<?=$themeJQueryPath?>ui/ui.core.js"></script>
<script type="text/javascript" src="<?=$themeJQueryPath?>ui/ui.tabs.js"></script>

<!--fieldset>
    <table>
        <tr>
            <td>Region</td>
            <td>Province</td>
            <td>Municipal</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><select></select></td>
            <td><select></select></td>
            <td><select></select></td>
            <td><input type="submit" value="Filter"></td>
        </tr>
    </table>
</fieldset-->

<br />
<?php
if (!empty($_SERVER['QUERY_STRING'])) {
    $qryFrm=array();
	$qrystr = explode("&",$_SERVER['QUERY_STRING']);
	foreach ($qrystr as $value) {
		$qstr = explode("=",$value);
		if ($qstr[0]!="sortby" && $qstr[0]!="sortof" ) {
			$arrQryStr[] = implode("=",$qstr);
		}
		if ($qstr[0]!="rgn_id" && $qstr[0]!="rgn" && $qstr[0]!="prn_id" && $qstr[0]!="prn" && 
                $qstr[0]!="mun_id" && $qstr[0]!="mun" && $qstr[0]!="brg_id" && $qstr[0]!="brg" && $qstr[0]!="ppl_id" && $qstr[0]!="ppl" && 
                $qstr[0]!="clu_id" && $qstr[0]!="clu" && $qstr[0]!="tab" && $qstr[0]!="p" ) {
			$qryFrm[] = "<input type='hidden' name='$qstr[0]' value='".urldecode($qstr[1])."'>";
		}
		if ($qstr[0]!="rgn_id2" && $qstr[0]!="rgn2" && $qstr[0]!="prn_id2" && $qstr[0]!="prn2" &&
                $qstr[0]!="mun_id2" && $qstr[0]!="mun2" && $qstr[0]!="brg_id2" && $qstr[0]!="brg2" && $qstr[0]!="ppl_id2" && $qstr[0]!="ppl2" &&
                $qstr[0]!="clu_id2" && $qstr[0]!="clu2" && $qstr[0]!="pcos" && $qstr[0]!="tab" && $qstr[0]!="pstat"  && $qstr[0]!="p2") {
			$qryFrm2[] = "<input type='hidden' name='$qstr[0]' value='".urldecode($qstr[1])."'>";
		}
		if ($qstr[0]!="rgn_id3" && $qstr[0]!="rgn3" && $qstr[0]!="prn_id3" && $qstr[0]!="prn3" &&
                $qstr[0]!="mun_id3" && $qstr[0]!="mun3" && $qstr[0]!="brg_id3" && $qstr[0]!="brg3" && $qstr[0]!="ppl_id3" && $qstr[0]!="ppl3" &&
                $qstr[0]!="clu_id3" && $qstr[0]!="clu3" && $qstr[0]!="tab"  && $qstr[0]!="p3" ) {
			$qryFrm3[] = "<input type='hidden' name='$qstr[0]' value='".urldecode($qstr[1])."'>";
		}

	}
	$aQryStr = $arrQryStr;
    $qryForms = (count($qryFrm)>0)? implode(" ",$qryFrm) : '';
    $qryForms2 = (count($qryFrm2)>0)? implode(" ",$qryFrm2) : '';
    $qryForms3 = (count($qryFrm3)>0)? implode(" ",$qryFrm3) : '';
}
?>
<?php
        if(isset($_SESSION['eMsgOpenStatus'])){
            echo "<div class='tblListErrMsg'>".$_SESSION['eMsgOpenStatus']."</div>";
            unset($_SESSION['eMsgOpenStatus']);
        }
?>

<div id="tabs">
        <ul>
            <li><a href="#tabs-1"><b>Open Status</b></a></li>
            <li><a href="#tabs-2"><b>On Process</b></a></li>
            <li><a href="#tabs-3"><b>Verified</b></a></li>
        </ul>

    <div id="tabs-1">
        <form method="get" action="">
        <?=$qryForms?>
        <input type="hidden" name="tab" value="1">
        <table width="70%" border="0" cellspacing="0" cellpadding="1">
            <tr>
                <td>Region</td>
                <td>
                    <input type="hidden" name="rgn_id" id="rgn_id" value="<?=$_GET['rgn_id']?>">
                    <input type="text" name="rgn" id="rgn" value="<?=$_GET['rgn']?>">
                </td>
                <td>Province</td>
                <td>
                    <input type="hidden" name="prn_id" id="prn_id" value="<?=$_GET['prn_id']?>">
                    <input type="text" name="prn" id="prn" value="<?=$_GET['prn']?>">
                </td>
                <td>Municipal</td>
                <td>
                    <input type="hidden" name="mun_id" id="mun_id" value="<?=$_GET['mun_id']?>">
                    <input type="text" name="mun" id="mun" value="<?=$_GET['mun']?>">
                </td>
            </tr>
            <tr>
                <td>Barangay</td>
                <td>
                    <input type="hidden" name="brg_id" id="brg_id" value="<?=$_GET['brg_id']?>">
                    <input type="text" name="brg" id="brg" value="<?=$_GET['brg']?>">
                </td>
                <td>Polling Place</td>
                <td>
                    <input type="hidden" name="ppl_id" id="ppl_id" value="<?=$_GET['ppl_id']?>">
                    <input type="text" name="ppl" id="ppl" value="<?=$_GET['ppl']?>">
                </td>
                <td>Clustered Precinct</td>
                <td>
                    <input type="hidden" name="clu_id" id="clu_id" value="<?=$_GET['clu_id']?>">
                    <input type="text" name="clu" id="clu" value="<?=$_GET['clu']?>">
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" id="src" value="Search"> <a class="themeInputButton" style="padding: 1px 5px 1px 5px;" href="?tab=1">Reset</a></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        </form>
        <?=$tblDataList?>
    </div>
    <div id="tabs-2">
        <form method="get" action="">
        <?=$qryForms2?>
            <input type="hidden" name="tab" value="2">
        <table width="90%" border="0" cellspacing="0" cellpadding="1">
            <tr>
                <td>Region</td>
                <td>
                    <input type="hidden" name="rgn_id2" id="rgn_id2" value="<?=$_GET['rgn_id2']?>">
                    <input type="text" name="rgn2" id="rgn2" value="<?=$_GET['rgn2']?>">
                </td>
                <td>Province</td>
                <td>
                    <input type="hidden" name="prn_id2" id="prn_id2" value="<?=$_GET['prn_id2']?>">
                    <input type="text" name="prn2" id="prn2" value="<?=$_GET['prn2']?>">
                </td>
                <td>Municipal</td>
                <td>
                    <input type="hidden" name="mun_id2" id="mun_id2" value="<?=$_GET['mun_id2']?>">
                    <input type="text" name="mun2" id="mun2" value="<?=$_GET['mun2']?>">
                </td>
            </tr>
            <tr>
                <td>Barangay</td>
                <td>
                    <input type="hidden" name="brg_id2" id="brg_id2" value="<?=$_GET['brg_id2']?>">
                    <input type="text" name="brg2" id="brg2" value="<?=$_GET['brg2']?>">
                </td>
                <td>Polling Place</td>
                <td>
                    <input type="hidden" name="ppl_id2" id="ppl_id" value="<?=$_GET['ppl_id2']?>">
                    <input type="text" name="ppl2" id="ppl" value="<?=$_GET['ppl2']?>">
                </td>
                <td>Clustered Precinct</td>
                <td>
                    <input type="hidden" name="clu_id2" id="clu_id2" value="<?=$_GET['clu_id2']?>">
                    <input type="text" name="clu2" id="clu2" value="<?=$_GET['clu2']?>">
                </td>
                <td>PCOS ID</td>
                <td>
                    <input type="text" name="pcos" id="pcos" value="<?=$_GET['pcos']?>">
                </td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    <select name="pstat">
                        <option value="0">All On Process</option>
                        <?=html_options($arrPrecinctStatus, $_GET['pstat'])?>
                    </select>
                </td>
                <td></td>
                <td><input type="submit" name="src2" id="src2" value="Search"> <a class="themeInputButton" style="padding: 1px 5px 1px 5px;" href="?tab=2">Reset</a></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        </form>
        <form method="post" action="" >
        <?=$tblOnProcess?>
        <?php if(AppUser::getData("user_type")=="volval" || AppUser::getData("user_type")=="svolval"){
            echo "<div align='right'><input type='submit' name='verify' id='subsel' value='Submit Selected for Verification'onclick=\"return confirm('Are you sure you want to submit this for verification?');\" ></div>";
        }
        ?>
        </form>
    </div>
    <div id="tabs-3">
        <form method="get" action="">
        <?=$qryForms3?>
            <input type="hidden" name="tab" value="3">
        <table width="70%" border="0" cellspacing="0" cellpadding="1">
            <tr>
                <td>Region</td>
                <td>
                    <input type="hidden" name="rgn_id3" id="rgn_id3" value="<?=$_GET['rgn_id3']?>">
                    <input type="text" name="rgn3" id="rgn3" value="<?=$_GET['rgn3']?>">
                </td>
                <td>Province</td>
                <td>
                    <input type="hidden" name="prn_id3" id="prn_id3" value="<?=$_GET['prn_id3']?>">
                    <input type="text" name="prn3" id="prn3" value="<?=$_GET['prn3']?>">
                </td>
                <td>Municipal</td>
                <td>
                    <input type="hidden" name="mun_id3" id="mun_id3" value="<?=$_GET['mun_id3']?>">
                    <input type="text" name="mun3" id="mun3" value="<?=$_GET['mun3']?>">
                </td>
            </tr>
            <tr>
                <td>Barangay</td>
                <td>
                    <input type="hidden" name="brg_id3" id="brg_id3" value="<?=$_GET['brg_id3']?>">
                    <input type="text" name="brg3" id="brg3" value="<?=$_GET['brg3']?>">
                </td>
                <td>Polling Place</td>
                <td>
                    <input type="hidden" name="ppl_id3" id="ppl_id3" value="<?=$_GET['ppl_id3']?>">
                    <input type="text" name="ppl3" id="ppl3" value="<?=$_GET['ppl3']?>">
                </td>
                <td>Clustered Precinct</td>
                <td>
                    <input type="hidden" name="clu_id3" id="clu_id3" value="<?=$_GET['clu_id3']?>">
                    <input type="text" name="clu3" id="clu3" value="<?=$_GET['clu3']?>">
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="src3" id="src3" value="Search"> <a class="themeInputButton" style="padding: 1px 5px 1px 5px;" href="?tab=3">Reset</a></td>
            </tr>
        </table>
        </form>
        <?=$tblVerified?>
    </div>
</div>


<script type="text/javascript">
	$().ready(function() {
        <?php
                $strSelTab = "";
                if(isset($_GET['tab'])){
                    $strSelTab = "selected:".($_GET['tab'] - 1);
                }
        ?>
		$("#tabs").tabs({<?=$strSelTab?>});
	});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        
        $("#rgn").autocomplete("setup.php?statpos=precinct&action=region",{
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
            $("#rgn_id").val(data[1]);
            $("#rgn").val(data[2]);
            $("#prn_id").attr('disabled', '');
            $("#prn").attr('disabled', '');
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#rgn_id").val('');
                $("#rgn").val('');
                $("#prn_id").val('');
                $("#prn").val('');
            }
        });

        $("#prn").autocomplete("setup.php?statpos=precinct&action=province",{
            cacheLength:0
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                rgnid:function(){
                    if($('#rgn_id').val().length != 0){
                        return $('#rgn_id').val();
                    }
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
            $("#prn_id").val(data[1]);
            $("#prn").val(data[2]);
            $("#mun_id").attr('disabled', '');
            $("#mun").attr('disabled', '');
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#prn_id").val('');
                $("#prn").val('');
                $("#mun_id").val('');
                $("#mun").val('');
            }
        });
        
        $("#mun").autocomplete("setup.php?statpos=precinct&action=mun",{
            cacheLength:0
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                provid:function(){
                    if($('#prn_id').val().length != 0){
                        return $('#prn_id').val();
                    }
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
            $("#mun").val(data[2]);
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#mun_id").val('');
                $("#mun").val('');
            }
        });
        
        $("#brg").autocomplete("setup.php?statpos=precinct&action=barangay",{
            cacheLength:0
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                munid:function(){
                    if($('#mun_id').val().length != 0){
                        return $('#mun_id').val();
                    }
                }
            }
            ,formatItem: function(row){
                return row[2];
            }
            ,formatResult: function(row){
                return row[2].replace(/(<.+?>)/gi, '');
            }
        }).result(function(event, data, formatted){
            $("#brg_id").val(data[1]);
            $("#brg").val(data[2]);
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#brg_id").val('');
                $("#brg").val('');
            }
        });

        $("#rgn2").autocomplete("setup.php?statpos=precinct&action=region",{
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
            $("#rgn_id2").val(data[1]);
            $("#rgn2").val(data[2]);
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#rgn_id2").val('');
                $("#rgn2").val('');
            }
        });

        $("#prn2").autocomplete("setup.php?statpos=precinct&action=province",{
            cacheLength:0
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                rgnid:function(){
                    if($('#rgn_id2').val().length != 0){
                        return $('#rgn_id2').val();
                    }
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
            $("#prn_id2").val(data[1]);
            $("#prn2").val(data[2]);
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#prn_id2").val('');
                $("#prn2").val('');
            }
        });

        $("#mun2").autocomplete("setup.php?statpos=precinct&action=mun",{
            cacheLength:0
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                provid:function(){
                    if($('#prn_id2').val().length != 0){
                        return $('#prn_id2').val();
                    }
                }
            }
            ,formatItem: function(row){
                return row[2];
            }
            ,formatResult: function(row){
                return row[2].replace(/(<.+?>)/gi, '');
            }
        }).result(function(event, data, formatted){
            $("#mun_id2").val(data[1]);
            $("#mun2").val(data[2]);
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#mun_id2").val('');
                $("#mun2").val('');
            }
        });

        $("#brg2").autocomplete("setup.php?statpos=precinct&action=barangay",{
            cacheLength:0
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                munid:function(){
                    if($('#mun_id2').val().length != 0){
                        return $('#mun_id2').val();
                    }
                }
            }
            ,formatItem: function(row){
                return row[2];
            }
            ,formatResult: function(row){
                return row[2].replace(/(<.+?>)/gi, '');
            }
        }).result(function(event, data, formatted){
            $("#brg_id2").val(data[1]);
            $("#brg2").val(data[2]);
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#brg_id2").val('');
                $("#brg2").val('');
            }
        });

        $("#rgn3").autocomplete("setup.php?statpos=precinct&action=region",{
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
            $("#rgn_id3").val(data[1]);
            $("#rgn3").val(data[2]);
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#rgn_id3").val('');
                $("#rgn3").val('');
            }
        });

        $("#prn3").autocomplete("setup.php?statpos=precinct&action=province",{
            cacheLength:0
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                rgnid:function(){
                    if($('#rgn_id3').val().length != 0){
                        return $('#rgn_id3').val();
                    }
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
            $("#prn_id3").val(data[1]);
            $("#prn3").val(data[2]);
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#prn_id3").val('');
                $("#prn3").val('');
            }
        });

        $("#mun3").autocomplete("setup.php?statpos=precinct&action=mun",{
            cacheLength:0
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                provid:function(){
                    if($('#prn_id3').val().length != 0){
                        return $('#prn_id3').val();
                    }
                }
            }
            ,formatItem: function(row){
                return row[2];
            }
            ,formatResult: function(row){
                return row[2].replace(/(<.+?>)/gi, '');
            }
        }).result(function(event, data, formatted){
            $("#mun_id3").val(data[1]);
            $("#mun3").val(data[2]);
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#mun_id3").val('');
                $("#mun3").val('');
            }
        });

        $("#brg3").autocomplete("setup.php?statpos=precinct&action=barangay",{
            cacheLength:0
            ,selectFirst: true
            ,width: 200
            ,extraParams: {
                munid:function(){
                    if($('#mun_id3').val().length != 0){
                        return $('#mun_id3').val();
                    }
                }
            }
            ,formatItem: function(row){
                return row[2];
            }
            ,formatResult: function(row){
                return row[2].replace(/(<.+?>)/gi, '');
            }
        }).result(function(event, data, formatted){
            $("#brg_id3").val(data[1]);
            $("#brg3").val(data[2]);
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#brg_id3").val('');
                $("#brg3").val('');
            }
        });

//        var ck =document.getElementByID('ck');
//
//        alert(ck);

//        $('.chksel').click(function(){
//            b = $('.chksel').attr('checked');
//
//            //alert(b);
//            alert(ck);
//
//            if(b===true){
//                $('#subsel').attr('disabled','');
//            }else{
//                $('#subsel').attr('disabled','disabled');
//            }
//        });

//        $("#checkall").click(function(){
//
//        var checked_status = this.checked;
//		$("input[type=checkbox]").each(function()
//		{
//			this.checked = checked_status;
//		});
//
//        });
        
    });


</script>
<?php
        }
?>
