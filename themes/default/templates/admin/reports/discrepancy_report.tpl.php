<h3><?=($_GET['all']?" All Encoded Precinct ":"Verified Precinct ")?>Discrepancy Report as of <?=date("Y-m-d H:i");?></h3>

<?php
        if(count($arrData) > 0) {
?>
<table bgcolor="black" cellpadding="2" cellspacing="1">
    <thead>
        <th  style="background-color: white;">&nbsp;</th>
        <th  style="background-color: white;">REGION</th>
        <th  style="background-color: white;">PROVINCE</th>
        <th  style="background-color: white;">MUNICIPAL</th>
        <th  style="background-color: white;">BARANGAY</th>
        <th  style="background-color: white;">CODE</th>
        <th  style="background-color: white;">PRECINCT NUMBER</th>
        <th  style="background-color: white;">POSITION</th>
        <th  style="background-color: white;">CANDIDATE</th>
        <th  style="background-color: white;">GND ER</th>
        <th  style="background-color: white;">PCOS</th>
        <th  style="background-color: white;">DIFF</th>
    </thead>
    <tbody>
    <?php
            $xCtr = 0;
                foreach ($arrData as $keyData => $valData) {
    ?>
        <tr <?=(($valData['precincts_status']==40 && $_GET['all'])?"style=\"color:blue;\"":"")?>>
            <td style="background-color: white;" align="right"><?=++$xCtr?></td>
            <td style="background-color: white;"><?=$valData['region_name']?></td>
            <td style="background-color: white;"><?=$valData['province_name']?></td>
            <td style="background-color: white;"><?=$valData['municipal_name']?></td>
            <td style="background-color: white;"><?=$valData['barangay_name']?></td>
            <td style="background-color: white;"><?=$valData['precincts_code']?></td>
            <td style="background-color: white;"><?=$valData['precincts_number']?></td>
            <td style="background-color: white;"><?=$valData['candidate_post_name']?></td>
            <td style="background-color: white;"><?=$valData['political_candidates_name']?></td>
            <td style="background-color: white;" align="right"><?=$valData['ground_er']?></td>
            <td style="background-color: white;" align="right"><?=$valData['pcos']?></td>
            <td style="background-color: white;" align="right"><?=$valData['ground_er']-$valData['pcos']?></td>
        </tr>
    <?php
                }
    ?>
    </tbody>
</table>
<?php
        }
?>




