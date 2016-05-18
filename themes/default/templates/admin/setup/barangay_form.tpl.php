<div class="themeFieldsetDiv01">
<fieldset class="themeFieldset01">
<legend class="themeLegend01">Manage Barangay Form</legend>
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
<link href="../includes/jquery/ui/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script src="../includes/jquery/jquery-1.3.2.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/jquery/ui/jquery.autocomplete.js"></script>
<form method="post" action="">

<table width="100%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td colspan="2">&nbsp;</td>
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
            <input name="province_name" id="province_name" value="<?=$oData['province_name']?>" size="30" type="text" >
        </td>
    </tr>
    <tr>
        <td>Municipality: </td>
        <td>
            <input name="mun_id" id="mun_id" value="<?=$oData['mun_id']?>" size="30" type="hidden">
            <input name="municipal_name" id="municipal_name" value="<?=$oData['municipal_name']?>" size="30" type="text">
        </td>
    </tr>
  <tr>
    <td>Barangay Name </td>
    <td><input name="barangay_name" type="text" id="barangay_name" value="<?=$oData['barangay_name'];?>"  /></td>
  </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    <td colspan="2"><input type="submit" name="Submit" value="Submit" class="themeInputButton" /></td>
    </tr>
</table>
</form>
</fieldset>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        
        
        if($("#rgn_id").val().length == 0){
            $("#province_name").attr('disabled', 'disabled');
        }
        if($("#prov_id").val().length == 0){
            $('#municipal_name').attr('disabled', 'disabled');
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
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#rgn_id").val('');
                $("#region_name").val('');
                $("#prov_id").val('');
                $("#province_name").val('');
            }
            if($("#region_name").val().length > 0){
                $('#province_name').removeAttr("disabled");
            }
            if($("#region_name").val().length == 0){
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
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#prov_id").val('');
                $("#province_name").val('');
                $("#mun_id").val('');
                $("#mun_name").val('');
            }
            if($("#province_name").val().length > 0){
                $('#municipal_name').removeAttr("disabled");
            }
            if($("#province_name").val().length == 0){
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
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#mun_id").val('');
                $("#municipal_name").val('');
            }
        });

    });
</script>