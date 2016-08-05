<?php
header("Content-type: text/html; charset=tis-620");
header("Content-Disposition: attachment; filename=Plan-report11_".date("d-m-Y").".xls");
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

<?php if($_REQUEST["OrganizeCode"]){ ?>
<div><b>หน่วยงาน: </b><?php echo $get->getOrgName($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]); ?></div>
<?php } ?>

<?php if($_REQUEST["PrjDetailId"]){ ?>
<div><b>โครงการ: </b><?php echo $get->getPrjName($_REQUEST["PrjDetailId"]); ?></div>
<?php } ?>

<?php if($_REQUEST["PrjActId"]){ ?>
<div><b>กิจกรรม: </b><?php echo $get->getPrjActName($_REQUEST["PrjActId"]); ?></div>
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
    <th rowspan="2" nowrap="nowrap">หมวดงบ/รายการค่าใช้จ่าย</th>
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




  <!--วน loop หมวดงบรายจ่าย-->
  <?php
  $NumCateMonth = 1; 
  $BGCateMonth = $get->getCostTypeRecordSet();
 // ltxt::print_r($BGCateMonth);
  foreach($BGCateMonth as $BGCateMonthRow){ 
  	foreach($BGCateMonthRow as $a=>$b){
		${$a} = $b;
	}
	$SumCostMonth=$get->getTotalPrjMonth($CostTypeId);
	if($SumCostMonth){ //check หมวดงบประมาณ
		//ไตรมาสที่ 1	
		$SumCostMonth10=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,10);
		$SumCostMonth11=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,11);
		$SumCostMonth12=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,12);
	
		//ไตรมาสที่ 2	
		$SumCostMonth1=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,1);
		$SumCostMonth2=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,2);
		$SumCostMonth3=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,3);
	
		//ไตรมาสที่ 3
		$SumCostMonth4=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,4);
		$SumCostMonth5=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,5);
		$SumCostMonth6=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,6);
	
		//ไตรมาสที่ 4	
		$SumCostMonth7=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,7);
		$SumCostMonth8=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,8);
		$SumCostMonth9=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,9);	

  ?>
  
  <tr class="cate" style="vertical-align:top; font-weight:bold;">
    <td><?php echo $NumCateMonth; ?>. <?php echo $CostTypeName; ?></td>
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
    <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
    <?php
  $NumLevel1 = 1; 
  $BGLevel1 = $get->getCostItemRecordSet($CostTypeId);
 //ltxt::print_r($BGLevel1);
  foreach($BGLevel1 as $BGLevel1Row){ 
  	foreach($BGLevel1Row as $c=>$d){
		${$c} = $d;
	}
	$SumCostMonth=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	if($SumCostMonth){ //check รายการค่าใช้จ่าย level1
		//ไตรมาสที่ 1	
		$SumCostMonth10=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,10);
		$SumCostMonth11=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,11);
		$SumCostMonth12=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,12);
	
		//ไตรมาสที่ 2	
		$SumCostMonth1=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,1);
		$SumCostMonth2=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,2);
		$SumCostMonth3=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,3);
	
		//ไตรมาสที่ 3
		$SumCostMonth4=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,4);
		$SumCostMonth5=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,5);
		$SumCostMonth6=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,6);
	
		//ไตรมาสที่ 4	
		$SumCostMonth7=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,7);
		$SumCostMonth8=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,8);
		$SumCostMonth9=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,9);


  ?>

    <tr class="level1" style="vertical-align:top;">
      <td><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></td>
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
    
    <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->
    <?php if($HasChild == Y){ ?>
    <!--วน loop รายการงบรายจ่าย ระดับที่ 2-->
    <?php
  $NumLevel2 = 1; 
  $BGLevel2 = $get->getCostItemRecordSet($CostTypeId,2,$CostItemCode);
  foreach($BGLevel2 as $BGLevel2Row){ 
  	foreach($BGLevel2Row as $e=>$f){
		${$e} = $f;
	}
	$SumCostMonth=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	if($SumCostMonth){ //check รายการค่าใช้จ่าย level2
		//ไตรมาสที่ 1	
		$SumCostMonth10=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,10);
		$SumCostMonth11=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,11);
		$SumCostMonth12=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,12);
	
		//ไตรมาสที่ 2	
		$SumCostMonth1=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,1);
		$SumCostMonth2=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,2);
		$SumCostMonth3=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,3);
	
		//ไตรมาสที่ 3
		$SumCostMonth4=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,4);
		$SumCostMonth5=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,5);
		$SumCostMonth6=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,6);
	
		//ไตรมาสที่ 4	
		$SumCostMonth7=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,7);
		$SumCostMonth8=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,8);
		$SumCostMonth9=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,9);
  ?>
 
    <tr class="level2" style="vertical-align:top;">
      <td><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></td>
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
<!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->
<?php if($HasChild == Y){ ?>
<!--วน loop รายการงบรายจ่าย ระดับที่ 3-->
<?php
$NumLevel3 = 1; 
$BGLevel3 = $get->getCostItemRecordSet($CostTypeId,3,$CostItemCode);
foreach($BGLevel3 as $BGLevel3Row){ 
	foreach($BGLevel3Row as $g=>$h){
		${$g} = $h;
	}
	$SumCostMonth=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	if($SumCostMonth){ //check รายการค่าใช้จ่าย level3
		//ไตรมาสที่ 1	
		$SumCostMonth10=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,10);
		$SumCostMonth11=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,11);
		$SumCostMonth12=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,12);
	
		//ไตรมาสที่ 2	
		$SumCostMonth1=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,1);
		$SumCostMonth2=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,2);
		$SumCostMonth3=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,3);
	
		//ไตรมาสที่ 3
		$SumCostMonth4=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,4);
		$SumCostMonth5=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,5);
		$SumCostMonth6=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,6);
	
		//ไตรมาสที่ 4	
		$SumCostMonth7=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,7);
		$SumCostMonth8=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,8);
		$SumCostMonth9=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,9);
  ?>

    <tr class="level3" style="vertical-align:top;">
      <td><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?></td>
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
  $NumLevel3++;
  } ?>
    <!--END วน loop รายการงบรายจ่าย ระดับที่ 3-->
    <?php } ?>
    <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->
    
 
    
    <?php 
  $NumLevel2++;
  } ?>
    <!--END วน loop รายการงบรายจ่าย ระดับที่ 2-->
<?php } //check รายการค่าใช้จ่าย level3?>
     
    
    <?php } ?>
    <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->
<?php } //check รายการค่าใช้จ่าย level2?>    
    

    <?php 
  $NumLevel1++;
  } ?>
    <!--END วน loop รายการงบรายจ่าย ระดับที่ 1-->
<?php } //check รายการค่าใช้จ่าย level1?>

    
  <?php 
  $NumCateMonth++;
  } ?>
<?php } //check หมวดงบประมาณ?>  
  <!--END วน loop หมวดงบรายจ่าย-->
  
<?php
	$SumCostMonth=$get->getTotalPrjMonth();

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjMonth(0,0,0,0,0,10);
	$SumCostMonth11=$get->getTotalPrjMonth(0,0,0,0,0,11);
	$SumCostMonth12=$get->getTotalPrjMonth(0,0,0,0,0,12);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjMonth(0,0,0,0,0,1);
	$SumCostMonth2=$get->getTotalPrjMonth(0,0,0,0,0,2);
	$SumCostMonth3=$get->getTotalPrjMonth(0,0,0,0,0,3);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjMonth(0,0,0,0,0,4);
	$SumCostMonth5=$get->getTotalPrjMonth(0,0,0,0,0,5);
	$SumCostMonth6=$get->getTotalPrjMonth(0,0,0,0,0,6);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjMonth(0,0,0,0,0,7);
	$SumCostMonth8=$get->getTotalPrjMonth(0,0,0,0,0,8);
	$SumCostMonth9=$get->getTotalPrjMonth(0,0,0,0,0,9);
?>  
  
  
  
  <tr style="vertical-align:top; font-weight:bold;">
    <td style="text-align:right;">รวมทั้งสิ้น</td>
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

</BODY>

</HTML>


