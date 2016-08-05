<?php
header("Content-type: text/html; charset=tis-620");
header("Content-Disposition: attachment; filename=Plan-report9_".date("d-m-Y").".xls");
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

?>


<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
<style>
body {
	 font-family:TH SarabunPSK; 
	 font-size: 14px; 
	 margin:20px;
}
.tbl-list {
	border-collapse:collapse;
	font-family:TH SarabunPSK; 
	font-size: 14px; 
}
.tbl-list th {
	border:1px solid #999;
	padding-left:3px;
	padding-right:3px;
}
.tbl-list td {
	border:1px solid #999;
	padding-left:3px;
	padding-right:3px;
}
.sum-total {
	text-align:right;
}
</style>
</HEAD>
<BODY>


<div style="font-weight:bold; text-decoration:underline;">เงื่อนไขการแสดงรายงาน</div>
<?php if($_REQUEST["BgtYear"]){ ?>
<div><b>ปีงบประมาณ: </b><?php echo $_REQUEST["BgtYear"]; ?></div>
<?php } ?>

<?php if($_REQUEST["PItemCode"]){ ?>
<div><b>ชื่อแผนงาน สช.: </b><?php echo $get->getPItemName($_REQUEST["BgtYear"],$_REQUEST["PItemCode"]); ?></div>
<?php } ?>



<?php $screen=$get->getScreenYear($_REQUEST["BgtYear"]); ?>
<table width="100%" border="0" class="tbl-list"  cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">ลำดับ</th>
    <th nowrap="nowrap">แหล่งงบประมาณ</th>
   <?php
$h=1;
foreach( $screen as $prow2 ){
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
?>
<th style="width:10%;" nowrap="nowrap"><?php echo $ScreenName; ?></th>
<?php 
	$h++;
} 
?>        
</tr>


<!--งบแผ่นดิน-->
  <tr class="cate" style="vertical-align:top;">
    <td style="text-align:center;">1</td>
    <td>งบ พ.ร.บ</td>
    <?php 
$h=1;
foreach( $screen as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostScreen=$get->getTotalPrjMonthInternal($ScreenLevel);
?>
<td class="sum-total" title="<?php echo $ScreenName; ?>"><?php echo ($SumCostScreen)?number_format($SumCostScreen,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    
    </tr>
<!--END งบแผ่นดิน-->


  <!--วน loop แผนงาน สช.-->
  <?php
  $nPlan = 2; 
  $recPlan = $get->getSourceRecordSet();//ltxt::print_r($recPlan);
  foreach($recPlan as $recPlanRow){ 
  	foreach($recPlanRow as $a=>$b){
		${$a} = $b;
	}
  ?>
  
  <tr class="cate" style="vertical-align:top;">
    <td style="text-align:center;"><?php echo $nPlan; ?></td>
    <td><?php echo $SourceExName; ?></td>
    <?php 
$h=1;
foreach( $screen as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostScreen=$get->getTotalPrjMonthExternal($SourceExId,$ScreenLevel);
?>
<td class="sum-total" title="<?php echo $ScreenName; ?>"><?php echo ($SumCostScreen)?number_format($SumCostScreen,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    
    </tr>
  
  
  
  
  
  <?php 
  $nPlan++;
  } 
  ?>
  <!--END วน loop หมวดงบรายจ่าย-->

  
  <tr style="vertical-align:top; font-weight:bold;">
    <td colspan="2" style="text-align:right;">รวมทั้งสิ้น</td>
    <?php 
$h=1;
foreach( $screen as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostScreen=$get->getTotalPrjMonth(0,$ScreenLevel);
?>
<td class="sum-total" title="<?php echo $ScreenName; ?>"><?php echo ($SumCostScreen)?number_format($SumCostScreen,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    
    </tr>
</table>



<div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div>  

</BODY>

</HTML>


