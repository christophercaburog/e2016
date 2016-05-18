<div class="divTblMainList">
<?php
if (!empty($_SERVER['QUERY_STRING'])) {
	$qrystr = explode("&",$_SERVER['QUERY_STRING']);
	foreach ($qrystr as $value) {
		$qstr = explode("=",$value);
		if ($qstr[0]!="sortby" && $qstr[0]!="sortof" && $qstr[0]!="tab" ) {
			$arrQryStr[] = implode("=",$qstr);
		}
		if ($qstr[0]!="search_field" && $qstr[0]!="p") {
			$qryFrm[] = "<input type='hidden' name='$qstr[0]' value='$qstr[1]'>";
		}
	}
	$aQryStr = $arrQryStr;
	$aQryStr[] = "p=@@";
	$qryForms = (count($qryFrm)>0)? implode(" ",$qryFrm) : '';
}

$srchFormAction = $_SERVER['PHP_SELF']."?$queryStr";

?>
	<div class="divTblPagingContent">
		<form method="GET" action="">
		  <div class="right srch_border">
		  &nbsp;<img src="<?=$themeImagesPath?>/icon-search.gif" align="absmiddle" title="Search"> <input type="text" name="search_field" size="30" value="<?=$_GET['search_field']?>">
		  <input type="submit" value="go">
		  <?=$qryForms?>
		  </div>
	  </form>
	  <div class="divTblContent"><?=$resultsInfo?></div>
  </div>
  <div class="divTblList">
  <table width="100%" border="0" cellspacing="1" cellpadding="2">
  <tr>
		<?php
		foreach($tblFields as $fkey => $fvalue){
			$aQryStr = $arrQryStr;
            if(!isset($_GET['tab'])){
                $aQryStr[] = "tab=1";
            }elseif(isset($_GET['tab'])){
                $aQryStr[] = "tab=1";
            }
			$aQryStr[] = "sortby=$fkey";
			$aQryStr[] = "sortof=".((isset($_GET['sortof']) && $_GET['sortof']=="asc")?"desc":"asc");
			$queryStr = implode("&",$aQryStr);
			$fvalue = (empty($fvalue))?"":"<a href='?$queryStr'>$fvalue</a>";
			$sortimg = isset($_GET['sortof'])?(($_GET['sortof']=="asc")?"asc.gif":"dsc.gif"):"";
			$sortimg = ($fkey==$_GET['sortby'])?" <img src='$themeImagesPath/$sortimg' align='absmiddle'>":"";
		?>
    <td class="divTblListTH"><?=$fvalue.$sortimg?></td>
		<?php
		}
		?>
  </tr>
  <?php
	if(count($tblData) > 0){
  foreach ($tblData as $dkey => $dvalue){
  ?>
  <tr class="divTblListTR">
		<?php
		foreach($tblFields as $fkey => $fvalue){
		?>
    <td class="divTblListTD" <?=(isset($attribs[$fkey])?$attribs[$fkey]:"")?> ><?=$dvalue[$fkey]?></td>
		<?php
		}
		?>
  </tr>
  <?php
	}
	}else{
  ?>
	<tr class="divTblListTR">
	<td colspan="<?=count($tblFields)?>" class="divTblListTD" >No record found.</td>
	</tr>
	<?php
	}
	?>
	</table>
	</div>
  <div class="divTblPagingContent"><?=$resultsInfo?></div>
</div>
