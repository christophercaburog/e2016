<div align="center">
    <br />&nbsp;
    <br />&nbsp;
    <br />&nbsp;
    <br />&nbsp;
    <br />&nbsp;
    <br />&nbsp;
    <br />&nbsp;
    <br />&nbsp;
  <table width="450" border="0" cellpadding="2" cellspacing="0" bgcolor="#ffffff" style="border:1px solid #5a5a5a;" class="ui-corner-all">
    <tr>
        <td height="30" align="center">
            <?php
            if(!empty($errMsg)){
            ?>
            <div class="ui-state-error" style="padding:4px;"><?=$errMsg?></div>
            <?php
            }
            ?>
        </td>
    </tr>
    <tr>
      <td style="padding-right:20px;"><table width="100%" border="0" cellspacing="2" cellpadding="0">

        <tr>
          <td width="30%" rowspan="2" align="center" valign="middle"><img src="<?=$themeImagesPath?>admin/logo01.png"  /></td>
          <td width="70%" class="themeLoginFont">Security log-in</td>
        </tr>
        <tr>
            <td align="left"><table width="95%" border="0" cellpadding="0" cellspacing="2" bgcolor="#f8f8f8" class="ui-corner-all ui-state-highlight">
					<form method="post" action="">
            <tr>
              <td width="5%">&nbsp;</td>
              <td width="31%">&nbsp;</td>
              <td width="64%">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><strong>Username</strong></td>
              <td><input name="user_name" type="text" id="user_name" size="20" class="themeTextInput"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><strong>Password</strong></td>
              <td><input name="user_password" type="password" id="user_password" size="20" class="themeTextInput"></td>
            </tr>
            <tr>
                <td colspan="3"><img src="<?=$themeImagesPath?>spacer.gif" height="2" alt=""></td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                    <table>
                        <tr>
                            <td>Enter CAPTCHA</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><img src="his/hisview.php" alt="" height="45"></td>
                            <td>here:<br /><input type="text" name="hashkey" value="" size="5"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><input type="submit" name="Submit" value="Login" class="themeSubmitInput"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
						</form>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
        <td height="30">&nbsp;</td>
    </tr>
  </table>
</div>


<?php /*div id="lastresultid"></div>
<script type="text/javascript">
    $().ready(function(){
        $.ajax({ url: "http://www.xinapse.net/namfrel2010/admin/open_report.php?statpos=view_top",
            success: function(data){
                $("#lastresultid").html(data);
            }
          });
    });
</script */ ?>