<div style="padding-top:5px;">
<img src="<?=$themeImagesPath?>admin/add.png" border="0" align="absbottom">&nbsp;<a href="setup.php?statpos=barangay&action=add">Add New</a><br />
</div>

<br>

<?php 
if(isset($eMsg)){
	if (is_array($eMsg)) {
?>
	<div class="tblListErrMsg">
	<b>Check the following error(s) below:</b><br>
	<?php
	foreach ($eMsg as $key => $value) {
	?>
	&nbsp;&nbsp;&bull;&nbsp;<?=$Value?>
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
<link href="<?=$themeJQueryPath?>ui/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$themeJQueryPath?>ui/jquery.autocomplete.js"></script>
<form method="post">
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
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="src" id="src" value="Search"></td>
    </tr>
</table>
</form>
<?=$tblDataList?>
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
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#rgn_id").val('');
                $("#rgn").val('');
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
        }).keyup(function(){
            if($(this).val().length == 0){
                $("#prn_id").val('');
                $("#prn").val('');
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
    });
</script>