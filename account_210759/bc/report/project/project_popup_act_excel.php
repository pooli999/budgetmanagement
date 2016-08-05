<?php
header("Content-type: text/html; charset=tis-620");
header("Content-Disposition: attachment; filename=".$_REQUEST["PrjCode"]."_".date("d-m-Y").".xls");
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
?>


<html xmlns:o="urn:schemas-microsoft-com:office:office"

xmlns:x="urn:schemas-microsoft-com:office:excel"

xmlns="http://www.w3.org/TR/REC-html40">


<HEAD>

<meta http-equiv="Content-type" content="text/html;charset=utf-8" />

</HEAD><BODY>


 <div style="font-weight:bold; font-size:24px;"><?php echo $get->getPrjCodeName($_REQUEST["PrjCode"]); ?></div>

<?php 
$n=0;
$selectAct = $get->getProjectDetailActRecordSet($_REQUEST['PrjDetailId']);
foreach($selectAct as $r){
    foreach( $r as $k=>$v){ ${$k} = $v;} 
?>
  
<div style="font-weight:bold; color:#990000; font-size:16px;"><?php echo $PrjActName; ?></div>

<table>
    <tr>
      <td>&nbsp;</td>
  </tr>
</table> 
 

<table  width="3540" border="1" cellspacing="0" cellpadding="0" class="tbl-cost"  id="exmonth0">
  <tr>
    <th rowspan="3" style="width:80px" >รหัสกิจกรรม<br>(PrjActCode)</th>
    <th rowspan="3">รหัสค่าใช้จ่าย<br>(CostItemCode)</th>
    <th rowspan="3">รายการค่าใช้จ่าย</th>
    <th colspan="3" rowspan="2" style="width:10px;">งบประมาณ(บาท)</th>
    <th colspan="9">ไตรมาส1</th>
    <th colspan="9">ไตรมาส2</th>
    <th colspan="9">ไตรมาส3</th>
    <th colspan="9">ไตรมาส4</th>
  </tr>
  <tr>
    <th colspan="3" style="width:80px;">ต.ค</th>
    <th colspan="3" style="width:80px;">พ.ย</th>
    <th colspan="3" style="width:80px;">ธ.ค</th>
    <th colspan="3" style="width:80px;">ม.ค</th>
    <th colspan="3" style="width:80px;">ก.พ</th>
    <th colspan="3" style="width:80px;">มี.ค</th>
    <th style="width:80px;">&nbsp;</th>
    <th style="width:80px;">&nbsp;</th>
    <th style="width:80px;">เม.ย</th>
    <th colspan="3" style="width:80px;">พ.ค</th>
    <th colspan="3" style="width:80px;">มิ.ย</th>
    <th colspan="3" style="width:80px;">ก.ค</th>
    <th colspan="3" style="width:80px;">ส.ค</th>
    <th colspan="3" style="width:80px;">ก.ย</th>
  </tr>
  
  <tr class="cate">
    <td style="text-align:right; width:80px;" title="ต.ค">งบตามแผน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบเบิกจ่าย</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบผูกพัน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบตามแผน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบเบิกจ่าย</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบผูกพัน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบตามแผน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบเบิกจ่าย</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบผูกพัน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบตามแผน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบเบิกจ่าย</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบผูกพัน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบตามแผน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบเบิกจ่าย</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบผูกพัน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบตามแผน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบเบิกจ่าย</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบผูกพัน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบตามแผน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบเบิกจ่าย</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบผูกพัน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบตามแผน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบเบิกจ่าย</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบผูกพัน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบตามแผน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบเบิกจ่าย</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบผูกพัน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบตามแผน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบเบิกจ่าย</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบผูกพัน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบตามแผน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบเบิกจ่าย</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบผูกพัน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบตามแผน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบเบิกจ่าย</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบผูกพัน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบตามแผน</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบเบิกจ่าย</td>
    <td style="text-align:right; width:80px;" title="ต.ค">งบผูกพัน</td>
  </tr>
  
  
  
  <!--วน loop รายการงบรายจ่าย ระดับที่ 3-->
   <?php
  $NumLevel3 = 1; 
  $BGLevel3 = $get->getCostItemActivity($PrjActId);
  foreach($BGLevel3 as $BGLevel3Row){ 
  	foreach($BGLevel3Row as $g=>$h){
		${$g} = $h;
	}
	
	//$SumTotalCost = $get->getTotalPrjInternalX4(0,0,0,0,$PrjActId,0,0,$CostItemCode,0,0,0,0);
	
	
			$SumCostMonth=$get->getTotalPrjInternalMonth(0,0,0,0,0,$PrjActId,0,0,$CostItemCode);
		
			//ไตรมาสที่ 1	
			$SumCostMonth10=$get->getTotalPrjInternalMonth(0,0,0,0,0,$PrjActId,0,0,$CostItemCode,0,0,0,0,10,0);
			$SumCostMonth11=$get->getTotalPrjInternalMonth(0,0,0,0,0,$PrjActId,0,0,$CostItemCode,0,0,0,0,11,0);
			$SumCostMonth12=$get->getTotalPrjInternalMonth(0,0,0,0,0,$PrjActId,0,0,$CostItemCode,0,0,0,0,12,0);
		
			//ไตรมาสที่ 2	
			$SumCostMonth1=$get->getTotalPrjInternalMonth(0,0,0,0,0,$PrjActId,0,0,$CostItemCode,0,0,0,0,1,0);
			$SumCostMonth2=$get->getTotalPrjInternalMonth(0,0,0,0,0,$PrjActId,0,0,$CostItemCode,0,0,0,0,2,0);
			$SumCostMonth3=$get->getTotalPrjInternalMonth(0,0,0,0,0,$PrjActId,0,0,$CostItemCode,0,0,0,0,3,0);
		
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjInternalMonth(0,0,0,0,0,$PrjActId,0,0,$CostItemCode,0,0,0,0,4,0);
			$SumCostMonth5=$get->getTotalPrjInternalMonth(0,0,0,0,0,$PrjActId,0,0,$CostItemCode,0,0,0,0,5,0);
			$SumCostMonth6=$get->getTotalPrjInternalMonth(0,0,0,0,0,$PrjActId,0,0,$CostItemCode,0,0,0,0,6,0);
		
			//ไตรมาสที่ 4	
			$SumCostMonth7=$get->getTotalPrjInternalMonth(0,0,0,0,0,$PrjActId,0,0,$CostItemCode,0,0,0,0,7,0);
			$SumCostMonth8=$get->getTotalPrjInternalMonth(0,0,0,0,0,$PrjActId,0,0,$CostItemCode,0,0,0,0,8,0);
			$SumCostMonth9=$get->getTotalPrjInternalMonth(0,0,0,0,0,$PrjActId,0,0,$CostItemCode,0,0,0,0,9,0);		
  ?>
  <tr class="level3">
    <td><?php echo $PrjActCode; ?></td>
    <td style="text-align:center;"><?php echo $CostItemCode; ?></td> 
    <td><?php echo $CostName; ?></td>
    <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td style="text-align:right;" title="งบเดือน/ไตรมาส">&nbsp;</td>
    <td style="text-align:right;" title="งบเดือน/ไตรมาส">&nbsp;</td>
    <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td style="text-align:right;" title="ต.ค">&nbsp;</td>
    <td style="text-align:right;" title="ต.ค">&nbsp;</td>
    <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ย">&nbsp;</td>
    <td style="text-align:right;" title="พ.ย">&nbsp;</td>
    <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
    <td style="text-align:right;" title="ธ.ค">&nbsp;</td>
    <td style="text-align:right;" title="ธ.ค">&nbsp;</td>
    <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td style="text-align:right;" title="ม.ค">&nbsp;</td>
   <td style="text-align:right;" title="ม.ค">&nbsp;</td>
   <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
   <td style="text-align:right;" title="ก.พ">&nbsp;</td>
    <td style="text-align:right;" title="ก.พ">&nbsp;</td>
    <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
    <td style="text-align:right;" title="มี.ค">&nbsp;</td>

    <td style="text-align:right;" title="มี.ค">&nbsp;</td>
    <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td style="text-align:right;" title="เม.ย">&nbsp;</td>
   <td style="text-align:right;" title="เม.ย">&nbsp;</td>
   <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
   <td style="text-align:right;" title="พ.ค">&nbsp;</td>
    <td style="text-align:right;" title="พ.ค">&nbsp;</td>
    <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
    <td style="text-align:right;" title="มิ.ย">&nbsp;</td>
    <td style="text-align:right;" title="มิ.ย">&nbsp;</td>
    <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.ค">&nbsp;</td>
   <td style="text-align:right;" title="ก.ค">&nbsp;</td>
   <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
   <td style="text-align:right;" title="ส.ค">&nbsp;</td>
    <td style="text-align:right;" title="ส.ค">&nbsp;</td>
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.ย">&nbsp;</td>
    <td style="text-align:right;" title="ก.ย">&nbsp;</td>
    </tr>

  
  <?php 
		  $NumLevel3++;
	  } 
  ?>


</table>

<table>
  <tr>
    <td>&nbsp;</td>
  </tr>
    <tr>
      <td>&nbsp;</td>
  </tr>
</table>


<?php  } ?>

</BODY>

</HTML>
