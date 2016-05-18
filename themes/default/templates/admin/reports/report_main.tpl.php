<?php

//printa($report_menu);

?>


<script type="text/javascript" src="<?=$themeJQueryPath?>ui/ui.core.js"></script>
<script type="text/javascript" src="<?=$themeJQueryPath?>ui/ui.accordion.js"></script>
<link href="<?=$themeJQueryPath?>ui/css/ui.all.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">

$(function() {
		$("#accordion").accordion({
			collapsible: true
            ,fillSpace: false
		});
	});


</script>

<div class="themeFieldsetDiv01">

    <fieldset class="themeFieldset01">

    <legend class="themeLegend01">Reports</legend>

    <div class="ui-state-highlight ui-notify-pad5">
        <ul>
            <li><a href="reports.php?statpos=main&action=discrepancy&all=0" style="color:blue;font-weight:bold;">View Verified Discrepancy Report</a></li>
            <li><a href="reports.php?statpos=main&action=discrepancy&all=1" style="color:blue;">View All Discrepancy Report</a></li>
        </ul>


    </div>

        <div id="accordion">
            <?php foreach($report_menu as $election_level =>$candidate_post){?>

                        <h3><a href="#"><?php echo $election_level;?></a></h3>
                        <div  style="padding:0px; margin:0px;">
                            <ul>
                                <?php for($a=0;$a<count($candidate_post);$a++){?>
                                		<?php if($election_level == "Local") {?>

                                            <li><a href="reports.php?statpos=view_report&lm=<?php echo $candidate_post[$a]['candidate_post_id'];?>"><?php echo $candidate_post[$a]['candidate_post_name'];?></a></li>

                                		<?php }elseif($election_level == "Provincial"){?>

                                            <li><a href="reports.php?statpos=view_report&pr=<?php echo $candidate_post[$a]['candidate_post_id'];?>"><?php echo $candidate_post[$a]['candidate_post_name'];?></a></li>
                                            
                                        <?php }else { ?>
                                		
                                            <li><a href="reports.php?statpos=view_report&view=<?php echo $candidate_post[$a]['candidate_post_id'];?>"><?php echo $candidate_post[$a]['candidate_post_name'];?></a></li>
                                            
                                        <?php } ?>
                                <?php }?>
                            </ul>
                        </div>
            <?php }?>
             
        </div>

    </fieldset><!-- end  <fieldset class="themeFieldset01"> -->

</div><!-- end div themeFieldsetDiv01 -->

