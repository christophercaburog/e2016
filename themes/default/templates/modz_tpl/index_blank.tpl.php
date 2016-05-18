<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=SYSCONFIG_TITLE?></title>
<style type="text/css">
<!--

@import url("<?=$themeCSSPath?>admin.css.php?thpath=<?=SYSCONFIG_THEME_URLPATH.SYSCONFIG_THEME?>");
@import url("../includes/jscript/ThemeOffice/theme.css");
/*
@import url("../css/default.css");
*/
-->
.left{
clear:none;
float:left;
}

.right{
clear:none;
float:right;
}

}
</style>

<script type="text/javascript" src="../includes/jscript/bbyscript.js"></script></head>

<body>
	
	<?php
			if(is_object($centerPanel))
			print $centerPanel->fetchBlock();
	?> 
</body>
</html>
