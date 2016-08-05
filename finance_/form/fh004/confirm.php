<?php
include("config.php");
include("data.php");
//ltxt::print_r($_REQUEST);
?>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th>เลขที่ สช.น</th>
    <td><b><?php echo $_POST["DocCode"]; ?></b></td>
  </tr>
  <tr>
    <th>วันที่เอกสาร</th>
    <td><?php echo ShowDate($_POST["DocDate"]);?></td>
  </tr>

  <?php if($_POST["DocCode"]){ ?>
  <tr>
    <th>เลขที่ สช.น</th>
    <td><?php echo $_POST["DocCode"]; ?></td>
  </tr>
  <?php } ?>

  <tr>
    <th>เรื่อง</th>
    <td><?php echo $_POST["Topic"]; ?></td>
  </tr>  
    
  <tr>
    <th>ชื่อการปฏิบัติงาน</th>
    <td><?php echo $_POST["Title"]; ?></td>
  </tr>  
    
  <tr>
    <th>เรียน</th>
    <td><?php echo ($_POST["DocTo"])?$_POST["DocTo"]:'เลขาธิการคณะกรรมการสุขภาพแห่งชาติ (ผ่าน ผอ., ผอ.สอ.)'; ?></td>
  </tr>

<?php  if(count($_REQUEST["AttachCode"])){ ?>  
   <tr style="vertical-align:top;">
    <th>เอกสารแนบ</th>
    <td style="padding:5px;">
<style>
.tbl-list-attach td {
	border:none;
}
</style>
    
<table  width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list-attach">
<?php 
$no=1;
for($i=0;$i<count($_REQUEST["AttachCode"]);$i++){
?>    

    <tr style="vertical-align:top;">
        <td><?php echo $no; ?>) <?php echo $get->getAttachName($_REQUEST["AttachCode"][$i]); ?></td>
  	</tr>
    
<?php 
	$no++;
 }
 ?>
</table>
   
    </td>
  </tr> 
<?php } ?>  
  
  <tr>
    <th valign="top">มีความประสงค์จะ</th>
    <td valign="top">
	<?php 
   	$textDetail = str_replace( "<p>", "", $_POST["Detail"]);
	$textDetail = str_replace( "</p>", "", $textDetail);
   echo $textDetail; 
   ?>
    </td>
  </tr>


  <tr>
    <th colspan="2">รายละเอียดการขอเบิกค่ารักษาพยาบาล</th>
  </tr>
  
    <tr>
    <td colspan="2" style="padding:10px;">
 <style>
 .blog-relate {
	padding:10px; 
	border:1px solid #999; 
	border-radius:10px; 
	background-color:#CCC; 
	margin-bottom:10px;
 }
 </style>   
 <!--กรณีข้าพเจ้า-->   
 <div class="blog-relate" <?php if($_POST["Person1"] != 7){ ?> style="display:none;" <?php } ?>>
 <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
   <tr>
    <th colspan="2" style="background-color:#9CC;">กรณีข้าพเจ้า</th>
  </tr>
  <tr>
    <th>ป่วยเป็นโรค</th>
    <td><?php echo $_POST["Disease1"]; ?></td>
  </tr>
    <tr>
    <th>ชื่อสถานพยาบาล</th>
    <td>
<?php 
switch($_POST["HospitalType1"]){
	case "affair":
		echo "ทางราชการ";
		break;
	case "private":
		echo "เอกชน";
		break;
}
echo " <b>ระบุ</b> ".$_POST["HospitalName1"]; 
?>    
</td>
  </tr>
    <tr style="vertical-align:top;">
    <th>ตั้งแต่วันที่</th>
  	<td><?php echo dateFormat($_POST["OPDStartDate1"]); ?><b> ถึง </b><?php echo dateFormat($_POST["OPDEndDate1"]); ?></td>
  </tr> 
</table>
 </div>
 <!--END กรณีข้าพเจ้า-->      
 
 
 <!--กรณีคู่สมรส-->
<div class="blog-relate" <?php if($_POST["Person2"] != 1){ ?> style="display:none;" <?php } ?>>
<?php
$welfare = $get->getRelateData($RQPersonalCode,1);//ltxt::print_r($welfare);
foreach($welfare as $welfarerow){
	foreach($welfarerow as $mm=>$yy){
		${$mm} = $yy;
	}
}
?>
 <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
 <tr>
    <th colspan="2" style="background-color:#9CC;">กรณีคู่สมรส</th>
  </tr>
  <tr>
    <th>ชื่อ-นามสกุล</th>
    <td><?php echo $_POST["FullName2"]; ?></td>
  </tr>
  <tr>
    <th>ป่วยเป็นโรค</th>
    <td><?php echo $_POST["Disease2"]; ?></td>
  </tr>
    <tr>
    <th>ชื่อสถานพยาบาล</th>
    <td>
<?php 
switch($_POST["HospitalType2"]){
	case "affair":
		echo "ทางราชการ";
		break;
	case "private":
		echo "เอกชน";
		break;
}
echo " <b>ระบุ</b> ".$_POST["HospitalName2"]; 
?>    
</td>
  </tr>
    <tr style="vertical-align:top;">
    <th>ตั้งแต่วันที่</th>
  	<td><?php echo dateFormat($_POST["OPDStartDate2"]); ?><b> ถึง </b><?php echo dateFormat($_POST["OPDEndDate2"]); ?></td>
  </tr> 
</table>
 </div>
 <!--END กรณีคู่สมรส-->      
 
 
 <!--กรณีบิดา--> 
<div class="blog-relate" <?php if($_POST["Person3"] != 2){ ?> style="display:none;" <?php } ?>>
<?php
$welfare = $get->getRelateData($RQPersonalCode,2);//ltxt::print_r($welfare);
foreach($welfare as $welfarerow){
	foreach($welfarerow as $mm=>$yy){
		${$mm} = $yy;
	}
}
?>
 <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
 <tr>
    <th colspan="2" style="background-color:#9CC;">กรณีบิดา</th>
  </tr>
  <tr>
    <th>ชื่อ-นามสกุล</th>
    <td><?php echo $_POST["FullName3"]; ?></td>
  </tr>
  <tr>
    <th>ป่วยเป็นโรค</th>
    <td><?php echo $_POST["Disease3"]; ?></td>
  </tr>
    <tr>
    <th>ชื่อสถานพยาบาล</th>
    <td>
<?php 
switch($_POST["HospitalType3"]){
	case "affair":
		echo "ทางราชการ";
		break;
	case "private":
		echo "เอกชน";
		break;
}
echo " <b>ระบุ</b> ".$_POST["HospitalName3"]; 
?>    
</td>
  </tr>
    <tr style="vertical-align:top;">
    <th>ตั้งแต่วันที่</th>
  	<td>	<?php echo dateFormat($_POST["OPDStartDate3"]); ?><b> ถึง </b><?php echo dateFormat($_POST["OPDEndDate3"]); ?></td>
  </tr> 
</table>
 </div>
 <!--END กรณีบิดา-->      
 
 
 <!--กรณีมารดา--> 
<div class="blog-relate" <?php if($_POST["Person4"] != 3){ ?> style="display:none;" <?php } ?>>
<?php
$welfare = $get->getRelateData($RQPersonalCode,3);//ltxt::print_r($welfare);
foreach($welfare as $welfarerow){
	foreach($welfarerow as $mm=>$yy){
		${$mm} = $yy;
	}
}
?>
 <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
 <tr>
    <th colspan="2" style="background-color:#9CC;">กรณีมารดา</th>
  </tr>
  <tr>
    <th>ชื่อ-นามสกุล</th>
    <td><?php echo $_POST["FullName4"]; ?></td>
  </tr>
  <tr>
    <th>ป่วยเป็นโรค</th>
    <td><?php echo $_POST["Disease4"]; ?></td>
  </tr>
    <tr>
    <th>ชื่อสถานพยาบาล</th>
    <td>
<?php 
switch($_POST["HospitalType4"]){
	case "affair":
		echo "ทางราชการ";
		break;
	case "private":
		echo "เอกชน";
		break;
}
echo " <b>ระบุ</b> ".$_POST["HospitalName4"]; 
?>    
</td>
  </tr>
    <tr style="vertical-align:top;">
    <th>ตั้งแต่วันที่</th>
  	<td><?php echo dateFormat($_POST["OPDStartDate4"]); ?><b> ถึง </b><?php echo dateFormat($_POST["OPDEndDate4"]); ?></td>
  </tr> 
</table>
 </div>
 <!--END กรณีมารดา-->      
 
 <!--กรณีบุตรคนที่ 1-->   
 <div class="blog-relate" <?php if($_POST["Person5"] != 4){ ?> style="display:none; "<?php } ?>>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
    <th colspan="2" style="background-color:#9CC;">กรณีบุตรคนที่ 1</th>
  </tr>
  <tr>
    <th>ชื่อ-นามสกุล</th>
    <td><?php echo $_POST["FullName5Per1"]; ?></td>
  </tr>
    <tr>
  	<th>เกิดเมื่อ</th>
    <td><?php echo dateFormat($_POST["BirthDay5Per1"]); ?> <b>อายุ</b> <?php echo $_POST["Age5Per1"]; ?> <b>ปี</b></td>
 </tr>
  <tr>
  	<th>&nbsp;</th>
    <td>
      
  <div style="padding-top:5px; padding-bottom:5px;">    
  <?php 
$tc=1;
$tchild = $get->getChildTypeList();//ltxt::print_r($data);
foreach($tchild as $tchildrow){
	foreach($tchildrow as $gg=>$qq){
		${$gg} = $qq;
	}
?>    
  <input type="checkbox"  <?php if($_POST["TChildId5Per1"][$tc]){ ?> checked="checked" <?php } ?> disabled="disabled" />&nbsp;<?php echo $TChildName; ?>&nbsp;&nbsp;
  <?php 
	if($tc%3==0){
		echo '</div><div style="padding-bottom:5px;">';
	}
	$tc++;
 }
 ?>   
    </div>   
      
    </td>
 </tr> 
  <tr>
    <th>ป่วยเป็นโรค</th>
    <td><?php echo $_POST["Disease5Per1"]; ?></td>
  </tr>
    <tr>
    <th>ชื่อสถานพยาบาล</th>
    <td>
<?php 
switch($_POST["HospitalType5Per1"]){
	case "affair":
		echo "ทางราชการ";
		break;
	case "private":
		echo "เอกชน";
		break;
}
echo " <b>ระบุ</b> ".$_POST["HospitalName5Per1"]; 
?>    
</td>
  </tr>
    <tr style="vertical-align:top;">
    <th>ตั้งแต่วันที่</th>
    <td><?php echo dateFormat($_POST["OPDStartDate5Per1"]); ?><b> ถึง </b><?php echo dateFormat($_POST["OPDEndDate5Per1"]); ?></td>
  </tr> 
</table>
 </div>
 <!--END กรณีบุตรคนที่ 1-->      
 
 
  <!--กรณีบุตรคนที่ 2-->   
 <div class="blog-relate" <?php if($_POST["Person6"] != 5){ ?> style="display:none; "<?php } ?>>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
    <th colspan="2" style="background-color:#9CC;">กรณีบุตรคนที่ 2</th>
  </tr>
  <tr>
    <th>ชื่อ-นามสกุล</th>
    <td><?php echo $_POST["FullName5Per2"]; ?></td>
  </tr>
    <tr>
  	<th>เกิดเมื่อ</th>
    <td><?php echo dateFormat($_POST["BirthDay5Per2"]); ?> <b>อายุ</b> <?php echo $_POST["Age5Per2"]; ?> <b>ปี</b></td>
 </tr>
  <tr>
  	<th>&nbsp;</th>
    <td>
      
  <div style="padding-top:5px; padding-bottom:5px;">    
  <?php 
$tc=1;
$tchild = $get->getChildTypeList();//ltxt::print_r($data);
foreach($tchild as $tchildrow){
	foreach($tchildrow as $gg=>$qq){
		${$gg} = $qq;
	}
?>    
  <input type="checkbox"  <?php if($_POST["TChildId5Per2"][$tc]){ ?> checked="checked" <?php } ?> disabled="disabled" />&nbsp;<?php echo $TChildName; ?>&nbsp;&nbsp;
  <?php 
	if($tc%3==0){
		echo '</div><div style="padding-bottom:5px;">';
	}
	$tc++;
 }
 ?>   
    </div>   
      
    </td>
 </tr> 
  <tr>
    <th>ป่วยเป็นโรค</th>
    <td><?php echo $_POST["Disease5Per2"]; ?></td>
  </tr>
    <tr>
    <th>ชื่อสถานพยาบาล</th>
    <td>
<?php 
switch($_POST["HospitalType5Per2"]){
	case "affair":
		echo "ทางราชการ";
		break;
	case "private":
		echo "เอกชน";
		break;
}
echo " <b>ระบุ</b> ".$_POST["HospitalName5Per2"]; 
?>    
</td>
  </tr>
    <tr style="vertical-align:top;">
    <th>ตั้งแต่วันที่</th>
    <td><?php echo dateFormat($_POST["OPDStartDate5Per2"]); ?><b> ถึง </b><?php echo dateFormat($_POST["OPDEndDate5Per2"]); ?></td>
  </tr> 
</table>
 </div>
 <!--END กรณีบุตรคนที่ 2-->      
 
 
 
   <!--กรณีบุตรคนที่ 3-->   
 <div class="blog-relate" style="margin-bottom:0px; <?php if($_POST["Person7"] != 6){ ?> display:none; <?php } ?>">
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
    <th colspan="2" style="background-color:#9CC;">กรณีบุตรคนที่ 3</th>
  </tr>
  <tr>
    <th>ชื่อ-นามสกุล</th>
    <td><?php echo $_POST["FullName5Per3"]; ?></td>
  </tr>
    <tr>
  	<th>เกิดเมื่อ</th>
    <td><?php echo dateFormat($_POST["BirthDay5Per3"]); ?> <b>อายุ</b> <?php echo $_POST["Age5Per3"]; ?> <b>ปี</b></td>
 </tr>
  <tr>
  	<th>&nbsp;</th>
    <td>
      
  <div style="padding-top:5px; padding-bottom:5px;">    
  <?php 
$tc=1;
$tchild = $get->getChildTypeList();//ltxt::print_r($data);
foreach($tchild as $tchildrow){
	foreach($tchildrow as $gg=>$qq){
		${$gg} = $qq;
	}
?>    
  <input type="checkbox"  <?php if($_POST["TChildId5Per3"][$tc]){ ?> checked="checked" <?php } ?> disabled="disabled" />&nbsp;<?php echo $TChildName; ?>&nbsp;&nbsp;
  <?php 
	if($tc%3==0){
		echo '</div><div style="padding-bottom:5px;">';
	}
	$tc++;
 }
 ?>   
    </div>   
      
    </td>
 </tr> 
  <tr>
    <th>ป่วยเป็นโรค</th>
    <td><?php echo $_POST["Disease5Per3"]; ?></td>
  </tr>
    <tr>
    <th>ชื่อสถานพยาบาล</th>
    <td>
<?php 
switch($_POST["HospitalType5Per3"]){
	case "affair":
		echo "ทางราชการ";
		break;
	case "private":
		echo "เอกชน";
		break;
}
echo " <b>ระบุ</b> ".$_POST["HospitalName5Per3"]; 
?>    
</td>
  </tr>
    <tr style="vertical-align:top;">
    <th>ตั้งแต่วันที่</th>
    <td><?php echo dateFormat($_POST["OPDStartDate5Per3"]); ?><b> ถึง </b><?php echo dateFormat($_POST["OPDEndDate5Per3"]); ?></td>
  </tr> 
</table>
 </div>
 <!--END กรณีบุตรคนที่ 3-->      

 
 
 
    </td>
	</tr>


       <tr>
    <th colspan="2">รายการค่าใช้จ่าย</th>
  </tr>  
 
<tr>
	<th>ปีงบประมาณ</th>
	<td><?php echo $_REQUEST["BgtYear"]; ?></td>
</tr>
<tr>
	<th>ชื่อแผนงาน สช.</th>
	<td><?php echo $get->getPItemName($_REQUEST["BgtYear"],$_REQUEST["PItemCode"]); ?></td>
</tr>
<tr style="vertical-align:top;">
	<th>โครงการ</th>
	<td><?php echo $get->getPrjDetailName($_REQUEST["PrjDetailId"]); ?></td>
</tr>
  <tr style="vertical-align:top;">
    <th>กิจกรรม</th>
    <td><?php echo $get->getPrjActName($_REQUEST["PrjActCode"]); ?></td>
  </tr>  
  <tr style="vertical-align:top;">
    <th>แหล่งงบประมาณ</th>
    <td><?php echo $get->getSourceExName($_REQUEST["SourceExId"]); ?></td>
  </tr>   
  
  
  

<tr>
 <td colspan="2">



<!--รายการค่าใช้จ่าย-->



<table width="100%" border="1" class="tbl-list"  cellspacing="1" cellpadding="0">
  <tr>
    <th nowrap="nowrap">หมวดงบ/รายการค่าใช้จ่าย</th>
    <th style="width:80px; text-align:right;">งบตามแผน</th>
    <th style="width:80px; text-align:right;">งบรับโอน</th>
    <th style="width:80px; text-align:right;">งบโอนออก</th>
    <th style="width:100px; text-align:right;">งบแผนรวมโอน</th>
    <th style="width:80px; text-align:right;">งบหลักการ</th>
    <th style="width:80px; text-align:right;">งบผูกพัน</th>
    <th style="width:80px; text-align:right;">งบเบิกจ่าย</th>
    <th style="width:80px; text-align:right;">งบคงเหลือ</th>
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
	$SumPlan=$get->getSumPlan($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId);
	$SumTferIn=$get->getSumTferIn($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId);
	$SumTferOut=$get->getSumTferOut($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId);
	$SumPlanNet = $SumPlan+$SumTferIn-$SumTferOut;
	if($SumPlanNet){ //check หมวดงบประมาณ\$SumHold=$get->getSumHold($CostTypeId);
		$SumHold=$get->getSumHold($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId);
		$SumChain=$get->getSumChain($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId);
		$SumPay=$get->getSumPay($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId);
		$SumRemain = $SumPlanNet-$SumHold-$SumChain-$SumPay;
  ?>
  
  <tr class="cate" style="vertical-align:top; font-weight:bold; background-color:#EEE;">
    <td><?php echo $NumCateMonth; ?>. <?php echo $CostTypeName; ?></td>
    <td class="sum-total" title="งบตามแผน"><?php echo ($SumPlan > 0)?number_format($SumPlan,2):"-"; ?></td>
    <td class="sum-total" title="งบรับโอน"><?php echo ($SumTferIn > 0)?number_format($SumTferIn,2):"-"; ?></td>
    <td class="sum-total" title="งบโอนออก"><?php echo ($SumTferOut > 0)?number_format($SumTferOut,2):"-"; ?></td>
    <td class="sum-total" title="งบแผนรวมโอน"><?php echo ($SumPlanNet > 0)?number_format($SumPlanNet,2):"-"; ?></td>
    <td class="sum-total" title="งบหลักการ"><?php echo ($SumHold > 0)?number_format($SumHold,2):"-"; ?></td>
    <td class="sum-total" title="งบผูกพัน"><?php echo ($SumChain > 0)?number_format($SumChain,2):"-"; ?></td>
    <td class="sum-total" title="งบเบิกจ่าย"><?php echo ($SumPay > 0)?number_format($SumPay,2):"-"; ?></td>
    <td class="sum-total" title="งบคงเหลือ"><?php echo ($SumRemain > 0)?number_format($SumRemain,2):"-"; ?></td>
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
	$SumPlan=$get->getSumPlan($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumTferIn=$get->getSumTferIn($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumTferOut=$get->getSumTferOut($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumPlanNet = $SumPlan+$SumTferIn-$SumTferOut;
	if($SumPlanNet){ //check รายการค่าใช้จ่าย level1
		$SumHold=$get->getSumHold($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumChain=$get->getSumChain($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumPay=$get->getSumPay($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumRemain = $SumPlanNet-$SumHold-$SumChain-$SumPay;
  ?>

    <tr class="level1" style="vertical-align:top;">
      <td ><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></td>
      <td class="sum-total" title="งบตามแผน"><?php echo ($SumPlan > 0)?number_format($SumPlan,2):"-"; ?></td>
    <td class="sum-total" title="งบรับโอน"><?php echo ($SumTferIn > 0)?number_format($SumTferIn,2):"-"; ?></td>
    <td class="sum-total" title="งบโอนออก"><?php echo ($SumTferOut > 0)?number_format($SumTferOut,2):"-"; ?></td>
    <td class="sum-total" title="งบแผนรวมโอน"><?php echo ($SumPlanNet > 0)?number_format($SumPlanNet,2):"-"; ?></td>
    <td class="sum-total" title="งบหลักการ"><?php echo ($SumHold > 0)?number_format($SumHold,2):"-"; ?></td>
    <td class="sum-total" title="งบผูกพัน"><?php echo ($SumChain > 0)?number_format($SumChain,2):"-"; ?></td>
    <td class="sum-total" title="งบเบิกจ่าย"><?php echo ($SumPay > 0)?number_format($SumPay,2):"-"; ?></td>
    <td class="sum-total" title="งบคงเหลือ"><?php echo ($SumRemain > 0)?number_format($SumRemain,2):"-"; ?></td>
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
	$SumPlan=$get->getSumPlan($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumTferIn=$get->getSumTferIn($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumTferOut=$get->getSumTferOut($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumPlanNet = $SumPlan+$SumTferIn-$SumTferOut;
	if($SumPlanNet){ //check รายการค่าใช้จ่าย level2
		$SumHold=$get->getSumHold($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumChain=$get->getSumChain($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumPay=$get->getSumPay($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumRemain = $SumPlanNet-$SumHold-$SumChain-$SumPay;
  ?>
 
    <tr class="level2" style="vertical-align:top;">
      <td style="padding-left:15px;"><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></td>
      <td class="sum-total" title="งบตามแผน"><?php echo ($SumPlan > 0)?number_format($SumPlan,2):"-"; ?></td>
    <td class="sum-total" title="งบรับโอน"><?php echo ($SumTferIn > 0)?number_format($SumTferIn,2):"-"; ?></td>
    <td class="sum-total" title="งบโอนออก"><?php echo ($SumTferOut > 0)?number_format($SumTferOut,2):"-"; ?></td>
    <td class="sum-total" title="งบแผนรวมโอน"><?php echo ($SumPlanNet > 0)?number_format($SumPlanNet,2):"-"; ?></td>
    <td class="sum-total" title="งบหลักการ"><?php echo ($SumHold > 0)?number_format($SumHold,2):"-"; ?></td>
    <td class="sum-total" title="งบผูกพัน"><?php echo ($SumChain > 0)?number_format($SumChain,2):"-"; ?></td>
    <td class="sum-total" title="งบเบิกจ่าย"><?php echo ($SumPay > 0)?number_format($SumPay,2):"-"; ?></td>
    <td class="sum-total" title="งบคงเหลือ"><?php echo ($SumRemain > 0)?number_format($SumRemain,2):"-"; ?></td>
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
	$SumPlan=$get->getSumPlan($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumTferIn=$get->getSumTferIn($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumTferOut=$get->getSumTferOut($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumPlanNet = $SumPlan+$SumTferIn-$SumTferOut;
	if($SumPlanNet){ //check รายการค่าใช้จ่าย level3
		$SumHold=$get->getSumHold($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumChain=$get->getSumChain($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumPay=$get->getSumPay($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumRemain = $SumPlanNet-$SumHold-$SumChain-$SumPay;
  ?>

    <tr class="level3" style="vertical-align:top;">
      <td style="padding-left:25px;"><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?></td>
      <td class="sum-total" title="งบตามแผน"><?php echo ($SumPlan > 0)?number_format($SumPlan,2):"-"; ?></td>
    <td class="sum-total" title="งบรับโอน"><?php echo ($SumTferIn > 0)?number_format($SumTferIn,2):"-"; ?></td>
    <td class="sum-total" title="งบโอนออก"><?php echo ($SumTferOut > 0)?number_format($SumTferOut,2):"-"; ?></td>
    <td class="sum-total" title="งบแผนรวมโอน"><?php echo ($SumPlanNet > 0)?number_format($SumPlanNet,2):"-"; ?></td>
    <td class="sum-total" title="งบหลักการ"><?php echo ($SumHold > 0)?number_format($SumHold,2):"-"; ?></td>
    <td class="sum-total" title="งบผูกพัน"><?php echo ($SumChain > 0)?number_format($SumChain,2):"-"; ?></td>
    <td class="sum-total" title="งบเบิกจ่าย"><?php echo ($SumPay > 0)?number_format($SumPay,2):"-"; ?></td>
    <td class="sum-total" title="งบคงเหลือ"><?php echo ($SumRemain > 0)?number_format($SumRemain,2):"-"; ?></td>
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
	$SumPlan=$get->getSumPlan($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"]);
	$SumTferIn=$get->getSumTferIn($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"]);
	$SumTferOut=$get->getSumTferOut($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"]);
	$SumPlanNet = $SumPlan+$SumTferIn-$SumTferOut;
	$SumHold=$get->getSumHold($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"]);
	$SumChain=$get->getSumChain($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"]);
	$SumPay=$get->getSumPay($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"]);
	$SumRemain = $SumPlanNet-$SumHold-$SumChain-$SumPay;
?>  
  
  
  
  <tr style="vertical-align:top; font-weight:bold; background-color:#CCC;">
    <td style="text-align:right;">รวมทั้งสิ้น</td>
    <td class="sum-total" title="งบตามแผน"><?php echo ($SumPlan > 0)?number_format($SumPlan,2):"-"; ?></td>
    <td class="sum-total" title="งบรับโอน"><?php echo ($SumTferIn > 0)?number_format($SumTferIn,2):"-"; ?></td>
    <td class="sum-total" title="งบโอนออก"><?php echo ($SumTferOut > 0)?number_format($SumTferOut,2):"-"; ?></td>
    <td class="sum-total" title="งบแผนรวมโอน"><?php echo ($SumPlanNet > 0)?number_format($SumPlanNet,2):"-"; ?></td>
    <td class="sum-total" title="งบหลักการ"><?php echo ($SumHold > 0)?number_format($SumHold,2):"-"; ?></td>
    <td class="sum-total" title="งบผูกพัน"><?php echo ($SumChain > 0)?number_format($SumChain,2):"-"; ?></td>
    <td class="sum-total" title="งบเบิกจ่าย"><?php echo ($SumPay > 0)?number_format($SumPay,2):"-"; ?></td>
    <td class="sum-total" title="งบคงเหลือ"><?php echo ($SumRemain > 0)?number_format($SumRemain,2):"-"; ?></td>
  </tr>
</table>

</td>
</tr>

<?php
$BGWelfare 			= $_POST["BGWelfare"];
$BGWelfarePay		= $_POST["BGWelfarePay"];
$BGWelfareRemain	= $BGWelfare-$BGWelfarePay;
if(str_replace(",","",$_POST["TotalCost"]) > $BGWelfareRemain){
	$txtRed = "Y";
	$BGInValid = "Y";
}
?>  
    <tr>
    <th>สวัสดิการค่ารักษาพยาบาล</th>
    <td><div style="width:100px; float:left; text-align:right;"><?php echo number_format($BGWelfare,2); ?></div>&nbsp;<b>บาท/ปี</b></td>
  </tr>  
    <tr>
    <th>เบิกจ่ายแล้ว</th>
    <td><div style="width:100px; float:left; text-align:right;"><?php echo number_format($BGWelfarePay,2); ?></div>&nbsp;<b>บาท</b></td>
  </tr>  
    <tr>
    <th>คงเหลือ</th>
    <td ><div style="width:100px; float:left; text-align:right; <?php if($txtRed == "Y"){ ?> color:#FF0000; <?php } ?>"><?php echo number_format($BGWelfareRemain,2); ?></div>&nbsp;<b>บาท</b></td>
  </tr>  
  <tr>
    <th>จำนวนใบเสร็จรับเงิน</th>
    <td><div style="width:100px; float:left; text-align:right;"><?php echo $_POST["AmountBill"]; ?></div>&nbsp;<b>ฉบับ</b></td>
  </tr>



<tr>
<td colspan="2">



<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list-sub">
<thead>
  		<tr>
  		  <td style="text-align:center; width:30px;">ลำดับ</td>
    		<td  style="text-align:center;">รายการค่าใช้จ่าย/รายการชี้แจง</td>
            <td  style="width:100px; text-align:right;">งบประมาณ</td>
            <td  style="width:100px; text-align:right;">งบขออนุมัติ</td>
            <td  style="width:50px;">&nbsp;</td>
          </tr>            
</thead>        
<?php 

$nc=0;
$gCostItemCode = array_unique($_REQUEST["CostItemCode"]);
for($m=0; $m <= count($gCostItemCode);$m++){
	for($i=0; $i<count($_POST["DetailCost"]);$i++){
		if($_POST["DetailCost"][$i] != ""){
			if($_POST["CostItemCode"][$i] == $gCostItemCode[$m]){
				$_POST["SumCost"][$i] = str_replace(",","",$_POST["SumCost"][$i]);
				$sumSumCost[$m] = $sumSumCost[$m] + $_POST["SumCost"][$i];
			}
		}
	}
}

for($m=0; $m <= count($gCostItemCode);$m++){
	if($gCostItemCode[$m]){
		$SumBGPlan[$m]=$get->getSumPlan($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],0,0,0,"",$gCostItemCode[$m]);
		$TotalSumBGPlan = $TotalSumBGPlan+$SumBGPlan[$m];
		$txtRed = "";
		if($sumSumCost[$m] > $SumBGPlan[$m]){
			$txtRed = "Y";
			$BGInValid = "Y";
		}
?>
<tr style="font-weight:bold;">
  <td style="text-align:center;"><?php echo ($nc+1); ?></td>
	<td ><?php echo $get->getCostItemName($gCostItemCode[$m]);?></td>
	<td  style="text-align:right" ><?php echo number_format($SumBGPlan[$m],2);?></td>
	<td  style="text-align:right; <?php if($txtRed == "Y"){ ?> color:#FF0000; <?php } ?>" ><?php echo number_format($sumSumCost[$m],2);?></td>
	<td>&nbsp;</td>
        </tr>



<?php
	for($i=0; $i<count($_POST["DetailCost"]);$i++){
		if($_POST["DetailCost"][$i] != ""){
			if($_POST["CostItemCode"][$i] == $gCostItemCode[$m]){
?>
        <tr>
          <td >&nbsp;</td>
        <td >- <?php echo $_POST["DetailCost"][$i];?></td>
        <td  style="text-align:right;" >&nbsp;</td>
        <td  style="text-align:right;" ><?php echo number_format($_POST["SumCost"][$i],2);?></td>
        <td  style="text-align:right;" >&nbsp;</td>
        </tr>
<?php 
				}
			}
		} 
		$nc++;
	}
}
?>
<?php 
if($gCostItemCode[0] != ""){
$_POST["TotalCost"] = str_replace(",","",$_POST["TotalCost"]);
?>
          <tr style="font-weight:bold;">
            <td style="text-align:right;">&nbsp;</td>
            <td style="text-align:right;">รวมเป็นค่าใช้จ่ายทั้งสิ้น</td>
            <td style="text-align:right;"><?php echo number_format($TotalSumBGPlan,2);?></td>
            <td  style="text-align:right;" ><?php echo number_format($_POST["TotalCost"],2);?></td>
            <td >บาท</td>
        </tr>
<?php }else{ ?>     
	<tr>
    	<td colspan="5" style="text-align:center;">-ไม่พบรายการ-</td>
    </tr> 
<?php } ?>        
	</table>    



<!--END รายการค่าใช้จ่าย-->


 
</td>
</tr>


    <tr>
    <th colspan="2">ไฟล์เอกสารแนบ</th>
  </tr>  

<tr>
 <td colspan="2">
<?php
$ArrDoc = explode(",",$_POST["MultiDocId"]);
if(count($ArrDoc) > 1){
	foreach($ArrDoc as $val){
		if($val != 0){
			echo '<div style="padding-left:10px;">- '.$get->getDocName($val).'</div>';
		}
	}	
}else{
	echo '<div style="text-align:center;">-ไม่พบรายการ-</div>';
}

 ?>
</td>
</tr>




  <tr>
    <th colspan="2">ข้อมูลผู้ขออนุมัติ</th>
  </tr>  
  <tr>
    <th>ปีงบประมาณ-คำสั่งที่</th>
    <td><?php echo $_REQUEST["RQOrgRoundCode"]; ?></td>
  </tr>    
  <tr>
    <th>หน่วยงานปฏิบัติงาน</th>
    <td><?php echo $get->getOrganizeName($_REQUEST["RQOrganizeCode"]); ?></td>
  </tr>  
  <tr>
    <th>ชื่อผู้ปฏิบัติงาน</th>
    <td><?php echo $get->fn_getFullNameByPersonalCode($_REQUEST["RQPersonalCode"]); ?></td>
  </tr>
  <tr>
    <th>ตำแหน่งปฏิบัติงาน</th>
    <td><?php echo $get->getPositionName($_REQUEST["RQPositionId"]); ?></td>
  </tr> 
  
  
  
  
  
  
  <tr>
    <th>&nbsp;</th>
    <td>
    <input type="button" name="button4" id="button4" value="กลับไปแก้ไข" class="btn" onclick="toggleView();" />
    <input type="button" class="btnActive" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
      <input type="button" name="button3" id="button3" value=" ยกเลิก " class="btn" onclick="Cancel('adminForm');" /></td>
  </tr>
</table>

<input type="hidden" id="BGInValid" name="BGInValid" value="<?php echo $BGInValid; ?>" />