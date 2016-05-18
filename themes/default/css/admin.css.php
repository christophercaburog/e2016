<?php header("Content-Type: text/css");?>

body { font-family:trebuchet ms, Tahoma, Arial, Helvetica, sans-serif; margin:0px; font-size:10pt; background-color:#fdfdfd;}

body.login {background-color:#8B8B8B;}

.adminHeader{font-size:18pt;height:50px;background-color:#f0f0f0;border-bottom:solid 5px #dadada;padding-left:5px;}

.adminLoginStatus{font-size:10pt;}

.themeLoginFont{text-align:left;font-family:trebuchet ms, tahoma, verdana, arial;font-size:16pt;color:#008CEA;}

.themeErrorMsgStyle{color:#DF1000;font-size:12pt;}

.tblListErrMsg{color:#FFFFFF;padding:5px;border:1px solid #000000;background:#B00714 none repeat scroll 0 0;}

.tblListErrMsg B{color:#ffd700;}

.themeMenuItem{ font-family:Arial, Helvetica, sans-serif; font-size:18pt; color:#474B8E; font-weight:bold; padding-left:5px; text-decoration:none;}

.themeMenuItem:hover{ font-family:Arial, Helvetica, sans-serif; font-size:18pt; color:#00AEFF; font-weight:bold; padding-left:5px; text-decoration:none;}

.themeMenuItemSub{ font-family:Arial, Helvetica, sans-serif; font-size:14pt; color:#474B8E; font-weight:bold; padding-left:5px; text-decoration:none;}

.themeMenuItemSub:hover{ font-family:Arial, Helvetica, sans-serif; font-size:14pt; color:#00AEFF; font-weight:bold; padding-left:5px; text-decoration:none;}

.themeMenuItemSubTD{ font-family:Arial, Helvetica, sans-serif; font-size:14pt; color:#00AEFF; background-color:#FFFFFF; font-weight:bold; text-decoration:none; background-color:#EFFAFE;}

.themeMenuItemSubSelected{ font-family:Arial, Helvetica, sans-serif; font-size:14pt; color:#00AEFF; background-color:#FFFFFF; font-weight:bold; text-decoration:none; padding-left:5px;}

.themeMenuItemSubSelectedA{ font-family:Arial, Helvetica, sans-serif; font-size:14pt; color:#D20008; background-color:#FFFFFF; font-weight:bold; text-decoration:none;}
.themeMenuItemSubSelectedA:hover{ font-family:Arial, Helvetica, sans-serif; font-size:14pt; color:#D20008; background-color:#FFFFFF; font-weight:bold; text-decoration:none;}

.themeWelcome{font-size:28pt;font-family:Trebuchet MS, verdana, arial;]
font-weight:bold;color:#00B0FF;}

.themeWelcomeMsg{padding-height:5px;font-size:12pt;}


td.themeMainMenu{background-color:#0183C1;color:#FFFFFF;font-weight:bold;font-size:14pt;}

td.themePageTitleStyle{padding-left:10px;padding-right:10px;background-color:#f0f0f0;color:#0183C1;font-weight:bold;font-size:18pt;}

a{color:blue;text-decoration:none;}

a:hover{color:darkblue;text-decoration:underline;}

a.themeMainMenuLink{font-family: arial;color:#FFFFFF;font-weight:bold;font-size:14pt;text-decoration:none;}

a.themeMainMenuLink:hover{color:#FFF5C0;}

td.themeFooter{ background-color:#f0f0f0;}

td.themeFooterLink{ font-size:10pt;}

.themeSubTitle{font-size:14pt;font-weight:bold;}

.themeSubTitleOrange{font-family: trebuchet ms, verdana, arial, tahoma;font-size:12pt;font-weight:bold;color:darkorange;}

.themeNews1Date{color:#909090;font-size:11pt;padding-left:5px;}

.themeNews1Title{color:#666666;font-size:11pt;font-weight:bold;padding-left:5px;}

.themeNews1{color:#666666;font-size:11pt;padding-left:5px;}

.themeSearchInput{font-family: verdana, arial;border:1px solid #c0c0c0;font-size:11pt;}

.themeInputDefault{font-family: verdana, arial;border:1px solid #c0c0c0;font-size:11pt;}

.themeInputButton, input[type="submit"], input[type="reset"], input[type="button"]{ border:1px solid #FFFFFF; cursor:pointer;   outline: 1px solid #00A5EF;    background-color:#AAE4FE; }

.themeInputButton:hover, input[type="submit"]:hover, input[type="reset"]:hover, input[type="button"]:hover{ outline: 1px solid #0198DC;  color:#202020;  background-color:#8EDDFF;}

input, textarea, select{font-family:trebuchet ms, arial, tahoma;font-size:10pt;border:1px solid #c0c0c0;}

.checkbox{margin:0px;border:1px solid #c0c0c0;}

.themeRegFormHeaderECE{font-weight:bold;font-size:10pt;color:darkblue;background-color:#FFF3B0;padding-left:5px;}

.themeRegFormContentECE{background-color:#FFFCEA;padding-left:5px;}

.themeRegFormHeaderGS{font-weight:bold;font-size:10pt;color:darkblue;background-color:#FFE7E6;padding-left:5px;}

.themeRegFormContentGS{background-color:#FFF3F2;padding-left:5px;}

.themeRegFormHeaderHS{font-weight:bold;font-size:10pt;color:darkblue;background-color:#C6E8FF;padding-left:5px;}

.themeRegFormContentHS{background-color:#ECF8FF;padding-left:5px;}


.year{}
.yearname{}
.yearnavigation{}
.month{ width:540px; background-color:#68C5F0;}
.monthname{font-weight:bold;height:30px;padding-left:5px;}
.monthnavigation{font-weight:bold;}
.dayname{font-weight:bold;background-color:#D4F1FF;text-align:center;width:74px;}
.datepicker{}
.datepickerform{}
.monthpicker{}
.yearpicker{}
.pickerbutton{}
.monthday{background-color:#ffffff;text-align:center;height:50px;width:74px;}
.nomonthday{font-weight:bold;text-align:center;background-color:#f8f8f8;}
.today{text-align:center;background-color:#ffFFcc;}
.selectedday{}
.sunday{text-align:center;width:74px;background-color:#FFDCD3;}
.saturday{text-align:center;width:74px;background-color:#f0f0f0;}
.event{text-align:center;background-color:#F4F7E4;text-decoration:none;font-weight:bold;}
.event{text-align:center;background-color:#F4F7E4;}
.selected{}
.todayevent{text-align:center;}
.eventcontent{}


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
.smallyear{}
.smallyearname{}
.smallyearnavigation{}
.smallmonth{ width:100%; }
.smallmonthname{font-size:12px;font-weight:bold;padding-left:5px; height:25px;border-bottom:solid 1px black;}
.smallmonthnavigation{font-weight:bold;}
.smalldayname{font-size:11px;font-weight:bold;background-color:#D4F1FF;text-align:center;width:<?=$daywidth?>px;height:<?=$dayHeight?>px;}
.smalldatepicker{}
.smalldatepickerform{}
.smallmonthpicker{}
.smallyearpicker{}
.smallpickerbutton{}
.smallmonthday{font-size:11px;background-color:#f8f8f8;text-align:center;width:<?=$daywidth?>px;height:<?=$dayHeight?>px;}
.smallnomonthday{background-color:#ebebeb;width:<?=$daywidth?>px;height:<?=$dayHeight?>px;}
.smalltoday{font-size:11px;text-align:center;background-color:#ffFFcc;width:<?=$daywidth?>px;height:<?=$dayHeight?>px;}
.smallselectedday{}
.smallsunday{font-size:11px;text-align:center;background-color:#FFDCD3;width:<?=$daywidth?>px;height:<?=$dayHeight?>px;}
.smallsaturday{font-size:11px;text-align:center;background-color:#f0f0f0;width:<?=$daywidth?>px;height:<?=$dayHeight?>px;}
.smallevent{font-size:11px;text-align:center;background-color:#F4F7E4;text-decoration:none;font-weight:bold;}
.smallselected{}
.smalltodayevent{font-size:11px;text-align:center;}
.smalleventcontent{}

/* ----------admin header--------------------- */



/*-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-*/

.themeFieldsetDiv01{ width:950px;padding:5px;}

.themeFieldsetDiv02{background-color:#FFFFFF;width:745px;padding:5px;}

fieldset, .themeFieldset01{ border-top:1px solid #808080; border-bottom:1px solid #808080; border-left:2px solid #808080; border-right:2px solid #808080;  }

.themeFieldset01_notopborder{ border-top:0 none; border-bottom:1px solid #808080; border-left:2px solid #808080; border-right:2px solid #808080;  padding-top:10px;}

legend, .themeLegend01{ font-family:'Trebuchet MS',Tahoma, Verdana, 'Times New Roman', Times, serif; background-color:#E4F5FF; border:1px solid #7F9EFF; font-weight:bold; font-size:12px; padding-left:5px; padding-right:5px; padding-top:3px; padding-bottom:3px;  }

/*-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-*/

.divTblList{/*background-color:#3B96BF;*/ background-color:#3a3a3a;}

.divTblListTD{font-size:10pt;padding:1px;border-top:1px solid #ffffff;border-left:1px solid #ffffff;}

.divTblListTR{background-color:#fdfdfd;font-size:10pt;}

.divTblListTR:hover{background-color:#ffffaa;font-size:10pt;}

.divTblListTH{padding-left:4px;/*background-color:#AFE6FF; font-weight:bold;font-size:10pt;border-top:1px solid #fafafa;border-left:1px solid #fafafa;*/}
.divTblListTH a {color:#ffffff; font-weight:bold;}

.ui-widget-content .divTblListTH a {color:#ffffff; font-weight:bold;}

.divTblContent{background-color:inherit;padding-top:2px;padding-bottom:2px;margin-bottom:4px;}


.srch_border{ border:1px solid #e0e0e0; background-color:#ffffff;}
.srch_border input{ border:1px solid #f8f8f8; font-size:8pt;}


/* ----------Home Content--------------------- */
.divMenuTblList{background-color:#56caff;font-family:sans, trebuchet ms, verdana, arial;}

.divMenuTblListTD{font-size:12pt; border-top:1px solid #ffffff;border-left:1px solid #ffffff;height:30px;cursor:hand;}

.divMenuTblListTD a{text-decoration:none;color:black;}

.divMenuTblListTR{background-color:#e0f5ff;font-size:10pt;}

.divMenuTblListTR:hover{background-color:#ffffaa;font-size:10pt;}

<?php
$mainMenuHeight = '45px';$mainMenuFontSize = '12pt';?>
.salesandtrading, .inventory, .procurement{ background-color:#be0000; height:<?=$mainMenuHeight?>;}
.salesandtrading:hover, .inventory:hover, .procurement:hover { background-color:#e61616;text-shadow:1px 1px 1px #505050;}
.salesandtrading a, .inventory a, .procurement a{ color:#f8f8f8; font-weight:bold; font-size:<?=$mainMenuFontSize?>; text-decoration:none;}
.production, .farmmonitoring{ background-color:#0d57a2; height:<?=$mainMenuHeight?>;}
.production:hover, .farmmonitoring:hover{ background-color:#3b8cdf;text-shadow:1px 1px 1px #505050;}
.production a, .farmmonitoring a{ color:#f8f8f8; font-weight:bold; font-size:<?=$mainMenuFontSize?>; text-decoration:none;}
.warehouse, .mrp, .accountingandfinance{ background-color:#cb9609; height:<?=$mainMenuHeight?>;}
.warehouse:hover, .mrp:hover, .accountingandfinance:hover{ background-color:#ecb82d;text-shadow:1px 1px 1px #505050;}
.warehouse a, .mrp a, .accountingandfinance a{ color:#f8f8f8; font-weight:bold; font-size:<?=$mainMenuFontSize?>; text-decoration:none;}
.hris{ background-color:#08c5b1; height:<?=$mainMenuHeight?>;}
.hris:hover{ background-color:#17dbc6;text-shadow:1px 1px 1px #505050;}
.hris a{ color:#f8f8f8; font-weight:bold; font-size:<?=$mainMenuFontSize?>; text-decoration:none;}
.payroll{ background-color:#08c5b1; height:<?=$mainMenuHeight?>;}
.payroll:hover{ background-color:#17dbc6;text-shadow:1px 1px 1px #505050;}
.payroll a{ color:#f8f8f8; font-weight:bold; font-size:<?=$mainMenuFontSize?>; text-decoration:none;}

.loginwbg{ background-color:#ffffff;}
.loginwbggray{ background-color:#e8e8e8;}
.bordergone {border:none;}
.loginleftrightborder { border-left:solid #000000 1px; border-right:solid #000000 1px;}
.logintopbgline {  background-image:url('../images/admin/login_azt_bgline.gif');
}
.logintopborder { border-top:solid #000000 1px;}
.loginbotborder { border-bottom:solid #000000 1px;}
.loginleftborderw { border-left:solid #ffffff 1px;}

.theme-cursor-pointer{ cursor:pointer;}

.theme-last-login {font-family:courier new; font-size:11px; color:#606060;}

.theme-code {font-family:'courier new'; font-size:18px; font-weight:bold; color:#DE7A00;}

.theme-info-label {font-size:11px; color:#606060;}
.theme-info-content {font-size:14px; font-weight:bold; color:#001043;}

.ui-notify-pad2 {padding:2px;}
.ui-notify-pad5 {padding:5px;}

.floatLeft {float:left;}
.floatRight {float:right;}

.theme-tr-odd {background-color:#d0d0d0;}
.theme-tr-odd2 {background-color:#f0f0f0;}
.theme-candidatepost-label {background-color:#101010;color:#fafafa;font-size:14px;font-weight:bold;text-transform:uppercase;padding:8px 2px 0px 2px;}

.hide-overflow { overflow:hidden; display:block; height:1.3em; }

.theme-input-focus { background-color:#FFF1A8; }