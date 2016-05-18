<?php
header("Content-Type: text/css");
?>

body {
	font-family:Tahoma, Arial, Helvetica, sans-serif;
	margin:0px;
	font-size:11px;
}


.themeMenuItem{
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px;
	color:#474B8E;
	font-weight:bold;
	padding-left:5px;
	text-decoration:none;
}

.themeMenuItem:hover{
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px;
	color:#00AEFF;
	font-weight:bold;
	padding-left:5px;
	text-decoration:none;
}

.themeMenuItemSub{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#474B8E;
	font-weight:bold;
	padding-left:5px;
	text-decoration:none;
}

.themeMenuItemSub:hover{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#00AEFF;
	font-weight:bold;
	padding-left:5px;
	text-decoration:none;
}

.themeMenuItemSubTD{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#00AEFF;
	background-color:#FFFFFF;	
	font-weight:bold;
	text-decoration:none;
	background-color:#EFFAFE;
}

.themeMenuItemSubSelected{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#00AEFF;
	background-color:#FFFFFF;	
	font-weight:bold;
	text-decoration:none;
	padding-left:5px;
}

.themeMenuItemSubSelectedA{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#D20008;
	background-color:#FFFFFF;	
	font-weight:bold;
	text-decoration:none;
}
.themeMenuItemSubSelectedA:hover{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#D20008;
	background-color:#FFFFFF;	
	font-weight:bold;
	text-decoration:none;
}

.themeWelcome{
font-size:28px;
font-family:Trebuchet MS, verdana, arial;]
font-weight:bold;
color:#00B0FF;
}

.themeWelcomeMsg{
padding-height:5px;
font-size:12px;
}


td.themeMainMenu{
background-color:#0183C1;
color:#FFFFFF;
font-weight:bold;
font-size:14px;
}

td.themePageTitleStyle{
padding-left:10px;
padding-right:10px;
background-color:#f0f0f0;
color:#0183C1;
font-weight:bold;
font-size:18px;
}

a{
color:blue;
text-decoration:none;
}

a:hover{
color:darkblue;
text-decoration:underline;
}

a.themeMainMenuLink{
font-family: arial;
color:#FFFFFF;
font-weight:bold;
font-size:14px;
text-decoration:none;
}

a.themeMainMenuLink:hover{
color:#FFF5C0;
}

td.themeFooter{
	background-color:#f0f0f0;
}

td.themeFooterLink{
	font-size:10px;
}

.themeSubTitle{
font-size:14px;
font-weight:bold;
}

.themeSubTitleOrange{
font-family: trebuchet ms, verdana, arial, tahoma;
font-size:12pt;
font-weight:bold;
color:darkorange;
}

.themeNews1Date{
color:#909090;
font-size:11px;
padding-left:5px;
}

.themeNews1Title{
color:#666666;
font-size:11px;
font-weight:bold;
padding-left:5px;
}

.themeNews1{
color:#666666;
font-size:11px;
padding-left:5px;
}

.themeSearchInput{
font-family: verdana, arial;
border:1px solid #c0c0c0;
font-size:11px;
}

.themeInputDefault{
font-family: verdana, arial;
border:1px solid #c0c0c0;
font-size:11px;
}

.themeInputButton{
font-family: verdana, arial;
border:1px solid #c0c0c0;
background-color:#d4f1ff;
font-size:11px;
}

input,textarea, select{
font-family:trebuchet ms, arial, tahoma;
font-size:11px;
border:1px solid #c0c0c0;
}

.themeRegFormHeaderECE{
font-weight:bold;
font-size:10pt;
color:darkblue;
background-color:#FFF3B0;
padding-left:5px;
}

.themeRegFormContentECE{
background-color:#FFFCEA;
}

.themeRegFormHeaderGS{
font-weight:bold;
font-size:10pt;
color:darkblue;
background-color:#FFE7E6;
padding-left:5px;
}

.themeRegFormContentGS{
background-color:#FFF3F2;
}

.themeRegFormHeaderHS{
font-weight:bold;
font-size:10pt;
color:darkblue;
background-color:#C6E8FF;
padding-left:5px;
}

.themeRegFormContentHS{
background-color:#ECF8FF;
}


.year{
}
.yearname{
}
.yearnavigation{
}
.month{
	width:540px;
	background-color:#68C5F0;
}
.monthname{
font-weight:bold;
height:30px;
padding-left:5px;
}
.monthnavigation{
font-weight:bold;
}
.dayname{
font-weight:bold;
background-color:#D4F1FF;
text-align:center;
width:74px;
}
.datepicker{
}
.datepickerform{
}
.monthpicker{
}
.yearpicker{
}
.pickerbutton{
}
.monthday{
background-color:#ffffff;
text-align:center;
height:50px;
width:74px;
}
.nomonthday{
font-weight:bold;
text-align:center;
background-color:#f8f8f8;
}
.today{
text-align:center;
background-color:#ffFFcc;
}
.selectedday{
}
.sunday{
text-align:center;
width:74px;
background-color:#FFDCD3;
}
.saturday{
text-align:center;
width:74px;
background-color:#f0f0f0;
}
.event{
text-align:center;
background-color:#F4F7E4;
text-decoration:none;
font-weight:bold;
}
.event{
text-align:center;
background-color:#F4F7E4;
}
.selected{
}
.todayevent{
text-align:center;
}
.eventcontent{
}


<?php
/**
 * @var int width of day cell
 */
$daywidth = 30;
/**
 * @var int height of day cell
 */
$dayHeight = 20;

?>
.smallyear{
}
.smallyearname{
}
.smallyearnavigation{
}
.smallmonth{
	width:100%;
	/*background-color:#fafafa;*/
}
.smallmonthname{
font-size:12px;
font-weight:bold;
padding-left:5px;
	height:25px;
border-bottom:solid 1px black;
}
.smallmonthnavigation{
font-weight:bold;
}
.smalldayname{
font-size:11px;
font-weight:bold;
background-color:#D4F1FF;
text-align:center;
width:<?=$daywidth?>px;
height:<?=$dayHeight?>px;
}
.smalldatepicker{
}
.smalldatepickerform{
}
.smallmonthpicker{
}
.smallyearpicker{
}
.smallpickerbutton{
}
.smallmonthday{
font-size:11px;
background-color:#f8f8f8;
text-align:center;
width:<?=$daywidth?>px;
height:<?=$dayHeight?>px;
}
.smallnomonthday{
background-color:#ebebeb;
width:<?=$daywidth?>px;
height:<?=$dayHeight?>px; 
}
.smalltoday{
font-size:11px;text-align:center;
background-color:#ffFFcc;
width:<?=$daywidth?>px;
height:<?=$dayHeight?>px; 
}
.smallselectedday{
}
.smallsunday{
font-size:11px;
text-align:center;
background-color:#FFECE8;
width:<?=$daywidth?>px;
height:<?=$dayHeight?>px; 
}
.smallsaturday{
font-size:11px;
text-align:center;
background-color:#f0f0f0;
width:<?=$daywidth?>px;
height:<?=$dayHeight?>px; 
}
.smallevent{
font-size:11px;
text-align:center;
background-color:#F4F7E4;
text-decoration:none;
font-weight:bold;
}
.smallselected{
}
.smalltodayevent{
font-size:11px;
text-align:center;
}
.smalleventcontent{
}
