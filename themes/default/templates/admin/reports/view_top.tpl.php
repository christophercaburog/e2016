<!--
iframe source code::

 ** to do**::  replace the source with the proper address
 
<iframe src ="http://localhost/namfrel/admin/open_report.php?statpos=view_top" width="320" height="360">
  <p>Your browser does not support iframes.</p>
</iframe>


<?php

//printa($top_ranks);

//ini_set('display_errors',1);
?>
-->
<script type="text/javascript" src="<?=$themeJQueryPath?>jquery-latest-min.js"></script>
<script type="text/javascript" src="<?=$themeJQueryPath?>ui/ui.core.js"></script>
<script type="text/javascript" src="<?=$themeJQueryPath?>ui/ui.progressbar.js"></script>
<link href="<?=$themeJQueryPath?>ui/css/ui.all.css" rel="stylesheet" type="text/css" />

<style>
body{
    font-size:9px;
}
.odd{
    background:#EFEFEF;
}
</style>
<table style="width:280px;">
<!--
    <tr>
        <td align="center" colspan="2"><b>Sample Tally</b></td>
    </tr> -->
    <?php $a=0;foreach($top_ranks as $position=>$rank_details){?>a
        <tr>
            <td colspan="2" style="text-align:center; padding:4px 0px;"> <b><?php echo strtoupper($position);?></b></td>
        </tr>
            <?php $b=1;foreach($rank_details as $candidate_name=>$ranking){  $class = ($a%2==0) ? 'odd' : '';?>
                <tr  class="<?php echo $class;?>">
                    <td>
                        <span style="padding-right:1px;"><?php echo $b;?></span>    
                        <?php echo $candidate_name;?>
                    </td>
                    <td>

                        <div id="rank_<?php echo $a;?>" style="height:12px; width:70px; float:left;"></div>
                        <div style="float:left; padding-left:4px; font-size:9px;"><?php echo number_format($ranking,2,'.',null);?>%</div>
                        <div style="clear:both;"></div>
                        <script>
                            $('#rank_<?php echo $a;?>').progressbar({
                                value: <?php echo $ranking;?>
                            });
                        </script>

                     </td>
                </tr>

                <?php $b++;$a++;}?>
    <?php }?>

    <tr>
        <td colspan="2" align="right"><br><a target="_blank" href="http://124.105.167.123/namfrel2010/admin/reports.php?statpos=view_report&view=1">more..</a></td>
        
    </tr>
</table>