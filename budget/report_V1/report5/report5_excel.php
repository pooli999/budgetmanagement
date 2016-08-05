<?php
header("Content-type: text/html; charset=tis-620");
header("Content-Disposition: attachment; filename=Plan-report5_".date("d-m-Y").".xls");
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

<?php if($_REQUEST["ScreenLevel"]){ ?>
<div><b>ขั้นตอนจัดทำแผนปฏิบัติงาน: </b><?php echo $get->getScreenName($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"]); ?></div>
<?php } ?>

<?php if($_REQUEST["PItemCode"]){ ?>
<div><b>ชื่อแผนงาน สช.: </b><?php echo $get->getPItemName($_REQUEST["BgtYear"],$_REQUEST["PItemCode"]); ?></div>
<?php } ?>


<?php $source2=$get->getSourceYear($_REQUEST["BgtYear"]); ?>
<table width="100%" border="0" class="tbl-list"  cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">ลำดับ</th>
    <th nowrap="nowrap">ชื่อหน่วยงาน</th>
   <th style="width:10%;">งบประมาณ</th>
    <th style="width:10%;">งบ พ.ร.บ</th>
<?php
$h=1;
foreach( $source2 as $prow2 ){
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
?>
<th style="width:10%;"><?php echo $SourceExName; ?></th>
<?php 
	$h++;
} 
?>        
</tr>




  <!--วน loop แผนงาน สช.-->
  <?php
  $nPlan = 1; 
  $recPlan = $get->getOrgRecordSet();//ltxt::print_r($recPlan);
  foreach($recPlan as $recPlanRow){ 
  	foreach($recPlanRow as $a=>$b){
		${$a} = $b;
	}
	$SumCostMonth=$get->getTotalPrjMonth($OrganizeCode);
	$SumCostInternal=0;
	if($SumCostMonth){
		$SumCostInternal=$get->getTotalPrjMonthInternal($OrganizeCode);
	}

  ?>
  
  <tr class="cate" style="vertical-align:top;">
    <td style="text-align:center;"><?php echo $nPlan; ?></td>
    <td><?php echo $OrgName; ?></td>
    <td class="sum-total" title="งบประมาณ"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td class="sum-total" title="งบ พ.ร.บ"><?php echo ($SumCostInternal > 0)?number_format($SumCostInternal,2):"-"; ?></td>
<?php 
$h=1;
foreach( $source2 as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostExternal=0;
	if($SumCostMonth){
		$SumCostExternal=$get->getTotalPrjMonthExternal($OrganizeCode,$SourceExId);
	}
?>
<td class="sum-total" title="<?php echo $SourceExName; ?>"><?php echo ($SumCostExternal)?number_format($SumCostExternal,2):'-'; ?></td>
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

<?php
	$SumCostMonth=$get->getTotalPrjMonth();
	$SumCostInternal=0;
	if($SumCostMonth){
		$SumCostInternal=$get->getTotalPrjMonthInternal();
	}
?>  
  
  
  
  <tr style="vertical-align:top; font-weight:bold;">
    <td colspan="2" style="text-align:right;">รวมทั้งสิ้น</td>
    <td class="sum-total" title="งบประมาณ"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td class="sum-total" title="งบ พ.ร.บ"><?php echo ($SumCostInternal > 0)?number_format($SumCostInternal,2):"-"; ?></td>
<?php 
$h=1;
foreach( $source2 as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostExternal=0;
	if($SumCostMonth){
		$SumCostExternal=$get->getTotalPrjMonthExternal(0,$SourceExId);
	}
?>
<td class="sum-total" title="<?php echo $SourceExName; ?>"><?php echo ($SumCostExternal)?number_format($SumCostExternal,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    
    </tr>
</table>



<div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div>  

</BODY>

</HTML>


