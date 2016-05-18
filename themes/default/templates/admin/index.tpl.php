<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=SYSCONFIG_TITLE?></title>
<style type="text/css">
<!--

@import url("<?=$themeCSSPath?>admin.css.php?thpath=<?=SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME?>");
@import url("<?=$themeCSSPath?>jquery-ui/base/ui.all.css");
@import url("../includes/jscript/ThemeOffice/theme.css");
/*
@import url("../css/default.css");
*/
-->
.divLeftHeader{
text-align:left;
width:200px;
float:left;
}
#divHeadRight{
margin-top:2px;
text-align:right;
float:right;
}
#divHeadText{
font-size:8pt;
font-weight:bold;
padding:1px;
text-align:left;
width:300px;
}
#divHeader{
padding-top:5px;
background-color:#f8f8f8;
border-bottom:2px solid #3B4DA1;
height:40px;
}
#divHeadTitle{
margin-top:15px;
line-height:18px;
font-family:Verdana, Arial, Helvetica, sans-serif;
font-weight:bold;
font-size:20px;
color:#343497;
width:600px;
}
#divHeadAppTitle{
font-family:'trebuchet ms', arial, verdana;
font-weight:bold;
font-size:18pt;
}
#mnuContent{
height:25px;
background-color:#C1E6FC;
border-bottom:1px solid #79CCFE;
}
#divMainContent{
border-top:1px solid #F3F9FE;
padding:2px;
}

#myMenuID{
margin-top:0px;
margin-left:2px;
height:25px;
}
.left{
clear:none;
float:left;
}

.right{
clear:none;
float:right;
}

.breadCrumbs01{
font-size:10pt;
font-weight:bold;
color:#EF6B00;
}

.breadCrumbs01 a{
font-size:10pt;
font-weight:bold;
color:#EF6B00;
}
</style>

<script type="text/javascript" src="../includes/jscript/JSCookMenu.js"></script>
<script type="text/javascript" src="../includes/jscript/bbyscript.js"></script>
<script type="text/javascript" src="<?=$themeJQueryPath?>jquery-latest-min.js"></script>
<script type="text/javascript" src="ajax_server.php?client=all&stub=clsAJAX_Server"></script>

</head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
		<div id="divHeader">
            <div  id="divHeadLeft" class="left">
                <!--<div class="left"><img src="<?=$themeImagesPath?>admin/logo01.png" alt="Logo" hspace="10" height="40px" /></div>-->
                <!--div id="divHeadTitle"><?=SYSCONFIG_COMPANY?></div-->
                <div id="divHeadAppTitle"><?=SYSCONFIG_TITLE?></div>
            </div>

	  <?php
		 if(isset($_SESSION['admin_session_obj']['user_id'])){
            ?>
        <div id="divHeadRight" class="right">
            <div id="divHeadText"><img src="<?=$themeImagesPath?>admin/user.gif" width="16" height="16" align="absmiddle" hspace="5" alt="" title="<?=$_SESSION['admin_session_obj']['user_data']['user_type_name']?>" /><?=$_SESSION['admin_session_obj']['user_data']['user_fullname']?> | <img src="<?=$themeImagesPath?>admin/ico_logout.gif" width="16" height="16" align="absmiddle" hspace="5" /><a href="index.php?statpos=logout">Logout</a></div>
			<!--div id="divHeadText"><img src="<?=$themeImagesPath?>admin/star.png" width="16" height="16" align="absmiddle" hspace="5" /><?=$_SESSION['admin_session_obj']['user_data']['user_type_name']?></div-->
			<!--div id="divHeadText"><img src="<?=$themeImagesPath?>admin/star_blue.png" width="16" height="16" align="absmiddle" hspace="5" /><?=$_SESSION['admin_session_obj']['user_data']['ud_name']?></div-->
			<div id="divHeadText"><img src="<?=$themeImagesPath?>admin/time.gif" width="16" height="16" align="absmiddle" hspace="5" />Last Logged in <?=$_SESSION['admin_session_obj']['user_last_login_human']?> ago</div>
		</div>
		<?php
		 }
		?>
		</div>
		</td>
  </tr>
    <tr>
        <td>
            <div id="mnuContent">
                <?php
                if(isset($_SESSION['admin_session_obj']['user_menu'])) {
                    ?>
                    <div id="myMenuID"></div>
                    <?php echo $_SESSION['admin_session_obj']['user_menu'];?>
                <?php
                }
                ?>
            </div>
        </td>
    </tr>
  <tr>
    <td>
	<div id="divMainContent">

	<?php
	if(!empty($breadCrumbs)){
	?>
	<div class="breadCrumbs01">
	<img src="<?=$themeImagesPath?>admin/folder.gif" width="16" height="16" align="absbottom" vspace="2" /> <?=$breadCrumbs;?>
	</div><br />
	<?php
	}
			if(is_object($centerPanel))
			print $centerPanel->fetchBlock();
	?>
	<div><?=$indexErrMsg?></div>
	</div>
		</td>
  </tr>
</table>

<script type="text/javascript">
    $("#divHeadText > a").click(function(){
        if($(this).attr("href") == "index.php?statpos=logout"){
            var cres = confirm("Are you sure you want to logout?");
            if(cres){
                return true;
            }else{
                return false;
            }
        }
    });
</script>

</body>
</html>
