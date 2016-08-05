<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
?>
<HTML>
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
<style media="print">
.btnback {
	display:none;
	vertical-align:top;
}
</style>
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

<?php if($_REQUEST["OrganizeCode"]){ ?>
<div><b>หน่วยงาน: </b><?php echo $get->getOrgName($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]); ?></div>
<?php } ?>

<?php if($_REQUEST["ExType"]){ ?>
<div><b>แหล่งงบประมาณ: </b>
<?php
switch($_REQUEST["ExType"]){
	case "Internal":
		echo "งบแผ่นดิน";
	break;
	case "External":
		echo "เงินนอกงบ";
		if($_REQUEST["SourceExId"]){
			echo " (".$get->getSourceExName($_REQUEST["SourceExId"]).")";
		}
	break;
}
?>	
</div>
<?php } ?>


<table width="100%" border="0" class="tbl-list"  cellspacing="0" cellpadding="0">
  <tr>
    <th rowspan="2" style="width:30px;">ลำดับ</th>
    <th rowspan="2" nowrap="nowrap">ชื่อแผนงาน/โครงการ/กิจกรรม</th>
    <th rowspan="2" style="width:80px;">งบประมาณ<br />(บาท)</th>
    <th colspan="3">ไตรมาส1</th>
    <th colspan="3">ไตรมาส2</th>
    <th colspan="3">ไตรมาส3</th>
    <th colspan="3">ไตรมาส4</th>
    </tr>
  <tr>
    <th style="width:6%;">ต.ค</th>
    <th style="width:6%;">พ.ย</th>
    <th style="width:6%;">ธ.ค</th>
    <th style="width:6%;">ม.ค</th>
    <th style="width:6%;">ก.พ</th>
    <th style="width:6%;">มี.ค</th>
    <th style="width:6%;">เม.ย</th>
    <th style="width:6%;">พ.ค</th>
    <th style="width:6%;">มิ.ย</th>
    <th style="width:6%;">ก.ค</th>
    <th style="width:6%;">ส.ค</th>
    <th style="width:6%;">ก.ย</th>
  </tr>




  <!--วน loop แผนงาน สช.-->
  <?php
  $nPlan = 1; 
  $recPlan = $get->getPItemRecordSet();//ltxt::print_r($recPlan);
  foreach($recPlan as $recPlanRow){ 
  	foreach($recPlanRow as $a=>$b){
		${$a} = $b;
	}
	$SumCostMonth=$get->getTotalPrjMonth($PItemCode);
	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjMonth($PItemCode,0,0,10);
	$SumCostMonth11=$get->getTotalPrjMonth($PItemCode,0,0,11);
	$SumCostMonth12=$get->getTotalPrjMonth($PItemCode,0,0,12);
	
	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjMonth($PItemCode,0,0,1);
	$SumCostMonth2=$get->getTotalPrjMonth($PItemCode,0,0,2);
	$SumCostMonth3=$get->getTotalPrjMonth($PItemCode,0,0,3);
	
	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjMonth($PItemCode,0,0,4);
	$SumCostMonth5=$get->getTotalPrjMonth($PItemCode,0,0,5);
	$SumCostMonth6=$get->getTotalPrjMonth($PItemCode,0,0,6);
	
	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjMonth($PItemCode,0,0,7);
	$SumCostMonth8=$get->getTotalPrjMonth($PItemCode,0,0,8);
	$SumCostMonth9=$get->getTotalPrjMonth($PItemCode,0,0,9);	

  ?>
  
  <tr class="cate" style="vertical-align:top; font-weight:bold;">
    <td style="text-align:center;"><?php echo $nPlan; ?></td>
    <td><?php echo $PItemName; ?></td>
    <td class="sum-total" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td class="sum-total" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td class="sum-total" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td class="sum-total" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
    <td class="sum-total" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td class="sum-total" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td class="sum-total" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
    <td class="sum-total" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td class="sum-total" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td class="sum-total" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
    <td class="sum-total" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td class="sum-total" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td class="sum-total" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
  </tr>
  
  
  
  
  
  
<!-- วนลูปโครงการ --> 
  <?php
  $nProject = 1; 
  $recProject = $get->getProjectRecordSet($PItemCode);//ltxt::print_r($recPlan);
  foreach($recProject as $recProjectRow){ 
  	foreach($recProjectRow as $m=>$d){
		${$m} = $d;
	}
	$SumCostMonth=$get->getTotalPrjMonth($PItemCode,$PrjDetailId);
	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,0,10);
	$SumCostMonth11=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,0,11);
	$SumCostMonth12=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,0,12);
	
	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,0,1);
	$SumCostMonth2=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,0,2);
	$SumCostMonth3=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,0,3);
	
	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,0,4);
	$SumCostMonth5=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,0,5);
	$SumCostMonth6=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,0,6);
	
	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,0,7);
	$SumCostMonth8=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,0,8);
	$SumCostMonth9=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,0,9);	

  ?>
  
  <tr class="cate" style="vertical-align:top;">
    <td style="text-align:center;"><?php echo $nPlan.".".$nProject; ?></td>
    <td><?php echo $PrjName; ?></td>
    <td class="sum-total" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td class="sum-total" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td class="sum-total" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td class="sum-total" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
    <td class="sum-total" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td class="sum-total" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td class="sum-total" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
    <td class="sum-total" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td class="sum-total" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td class="sum-total" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
    <td class="sum-total" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td class="sum-total" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td class="sum-total" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
  </tr>
  
  
  <!-- วนลูปกิจกรรม --> 
  <?php
  $nAct = 1; 
  $recAct = $get->getActRecordSet($PrjDetailId);//ltxt::print_r($recPlan);
  foreach($recAct as $recActRow){ 
  	foreach($recActRow as $w=>$q){
		${$w} = $q;
	}
	$SumCostMonth=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId);
	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId,10);
	$SumCostMonth11=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId,11);
	$SumCostMonth12=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId,12);
	
	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId,1);
	$SumCostMonth2=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId,2);
	$SumCostMonth3=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId,3);
	
	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId,4);
	$SumCostMonth5=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId,5);
	$SumCostMonth6=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId,6);
	
	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId,7);
	$SumCostMonth8=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId,8);
	$SumCostMonth9=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId,9);	

  ?>
  
  <tr class="cate" style="vertical-align:top;">
    <td style="text-align:center;">&nbsp;</td>
    <td>- <?php echo $PrjActName; ?></td>
    <td class="sum-total" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td class="sum-total" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td class="sum-total" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td class="sum-total" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
    <td class="sum-total" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td class="sum-total" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td class="sum-total" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
    <td class="sum-total" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td class="sum-total" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td class="sum-total" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
    <td class="sum-total" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td class="sum-total" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td class="sum-total" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
  </tr>
  <?php 
  $nAct++;
  } 
  ?>
<!--END วนลูปกิจกรรม-->

  
  
  
  
  
  
  <?php 
  $nProject++;
  } 
  ?>
<!--END วนลูปโครงการ-->
  
  
  
  
  
  
  
  
  
  <?php 
  $nPlan++;
  } 
  ?>
  <!--END วน loop หมวดงบรายจ่าย-->

<?php
	$SumCostMonth=$get->getTotalPrjMonth();

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjMonth(0,0,0,10);
	$SumCostMonth11=$get->getTotalPrjMonth(0,0,0,11);
	$SumCostMonth12=$get->getTotalPrjMonth(0,0,0,12);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjMonth(0,0,0,1);
	$SumCostMonth2=$get->getTotalPrjMonth(0,0,0,2);
	$SumCostMonth3=$get->getTotalPrjMonth(0,0,0,3);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjMonth(0,0,0,4);
	$SumCostMonth5=$get->getTotalPrjMonth(0,0,0,5);
	$SumCostMonth6=$get->getTotalPrjMonth(0,0,0,6);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjMonth(0,0,0,7);
	$SumCostMonth8=$get->getTotalPrjMonth(0,0,0,8);
	$SumCostMonth9=$get->getTotalPrjMonth(0,0,0,9);
?>  
  
  
  
  <tr style="vertical-align:top; font-weight:bold;">
    <td colspan="2" style="text-align:right;">รวมทั้งสิ้น</td>
    <td class="sum-total" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td class="sum-total" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td class="sum-total" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td class="sum-total" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
    <td class="sum-total" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td class="sum-total" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td class="sum-total" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
    <td class="sum-total" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td class="sum-total" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td class="sum-total" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
    <td class="sum-total" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td class="sum-total" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td class="sum-total" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
  </tr>
</table>

<div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div>  


<div style="text-align:center; margin-top:20px;">
  <input class="btnback" type="button" name="back" value="ย้อนกลับ" onClick="window.history.go(-1);" />
</div>

<script>
window.print();
</script>

</BODY>

</HTML>