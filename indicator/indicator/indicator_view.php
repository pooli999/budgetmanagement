<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));

$this->DOC->setPathWays(array(
	array(
		'text' => 'จัดการข้อมูลพื้นฐาน',
		'link' => '?mod=budget.init.startup',
	),
	array(
		'text' => $MenuName,
	),
));

$project = $get->getProject($_REQUEST["PrjDetailId"]);//ltxt::print_r($project);
foreach($project as $detailprj){
	foreach($detailprj as $k=>$v){
		${$k} = $v;
	}
}



?>


<script  type="text/javascript">
function Save(form){	
	if(validateSubmit()){
		form.submit();
	}
}

function validateSubmit(){
	//% ความก้าวหน้า
	/*if(JQ('#Progress').val()==""){
		alert("กรุณากรอก % ความก้าวหน้า");
		JQ('Progress').focus();
		return false
	}*/
	
	return true;
}

function toPage(MonthNo){
	window.location.href='?mod=<?php echo lurl::dotPage("indicator_add");?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"];?>&MonthNo='+MonthNo;
}

	
</script>



<div class="sysinfo">
  <div class="sysname">จัดการข้อมูลตัวชี้วัด</div>
  <div class="sysdetail">ปรับปรุงแก้ไขรายละเอียดตัวชี้วัด</div>
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-tab">
  <tr>
    <td class="current">ตัวชี้วัดโครงการ</td>
    <td class="notcurrent"><a href="?mod=<?php echo LURL::dotPage('indicator_plan_list'); ?>&BgtYear=<?php echo ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543); ?>">ตัวชี้วัดแผนงาน</a></td>
    <td class="notcurrent"><a href="?mod=<?php echo LURL::dotPage('indicator_longplan_list'); ?>">ตัวชี้วัดแผนหลัก</a></td>
    <td class="line">&nbsp;</td>
  </tr>
</table>



<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#eeebac;">
  <tr>
    <td style="padding:5px;">
    <a href="javascript:saveToWord()" class="ico print">พิมพ์</a>&nbsp;
    <a href="javascript:saveToWord()" class="icon-word">ส่งออกเป็น Word</a>
    </td>
  </tr>
</table>



<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
<tr>
    <th>ปีงบประมาณ</th>
    <td><?php echo $BgtYear; ?></td>
</tr>
<tr>
    <th>ชื่อโครงการ</th>
    <td style="font-weight:bold;">(<?php echo $PrjCode; ?>) <?php echo $PrjName; ?></td>
</tr>
<tr>
    <th>ความถี่ในการรายงาน</th>
    <td>
    <?php if($PrjMethods == "monthly"){ echo 'รายเดือน'; } ?>
	<?php if($PrjMethods == "quarterly"){ echo 'รายไตรมาส'; } ?>
    </td>
</tr>


</table>



<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">ตัวชี้วัดความสำเร็จโครงการ</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
<tr>
    <td colspan="3" style="vertical-align:top;">
    
    
    
    
    <table width="1870" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
        <thead>
          <tr>
            <td rowspan="4" style="width:30px; text-align:center">ลำดับ</td>
            <td rowspan="4" style="width:100px; text-align:center">รหัสตัวชี้วัด</td>
            <td rowspan="4" style="width:500px; text-align:center">ชื่อตัวชี้วัดโครงการ</td>
            <td rowspan="4" style="width:80px; text-align:center">ค่าเป้าหมาย</td>
            <td rowspan="4" style="width:80px; text-align:center">หน่วยนับ</td>
            <td colspan="24" style="text-align:center">ค่าเป้าหมายเดือน/ไตรมาส</td>
            <td rowspan="4" style="width:80px; text-align:center">ผลดำเนินงาน</td>
            <td rowspan="4" style="width:40px; text-align:center">สี</td>
          </tr>
          <tr>
            <td colspan="6" style="text-align:center;">ไตรมาสที่ 1</td>
            <td colspan="6" style="text-align:center;">ไตรมาสที่ 2</td>
            <td colspan="6" style="text-align:center;">ไตรมาสที่ 3</td>
            <td colspan="6" style="text-align:center;">ไตรมาสที่ 4</td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:center;">ต.ค</td>
            <td colspan="2" style="text-align:center;">พ.ย</td>
            <td colspan="2" style="text-align:center;">ธ.ค</td>
            <td colspan="2" style="text-align:center;">ม.ค</td>
            <td colspan="2" style="text-align:center;">ก.พ</td>
            <td colspan="2" style="text-align:center;">มี.ค</td>
            <td colspan="2" style="text-align:center;">เม.ย</td>
            <td colspan="2" style="text-align:center;">พ.ค</td>
            <td colspan="2" style="text-align:center;">มิ.ย</td>
            <td colspan="2" style="text-align:center;">ก.ค</td>
            <td colspan="2" style="text-align:center;">ส.ค</td>
            <td colspan="2" style="text-align:center;">ก.ย</td>
          </tr>
          <tr>
            <td style="width:40px; text-align:center">แผน</td>
            <td style="width:40px; text-align:center">ผล</td>
            <td style="width:40px; text-align:center">แผน</td>
            <td style="width:40px; text-align:center">ผล</td>
            <td style="width:40px; text-align:center">แผน</td>
            <td style="width:40px; text-align:center">ผล</td>
            <td style="width:40px; text-align:center">แผน</td>
            <td style="width:40px; text-align:center">ผล</td>
            <td style="width:40px; text-align:center">แผน</td>
            <td style="width:40px; text-align:center">ผล</td>
            <td style="width:40px; text-align:center">แผน</td>
            <td style="width:40px; text-align:center">ผล</td>
            <td style="width:40px; text-align:center">แผน</td>
            <td style="width:40px; text-align:center">ผล</td>
            <td style="width:40px; text-align:center">แผน</td>
            <td style="width:40px; text-align:center">ผล</td>
            <td style="width:40px; text-align:center">แผน</td>
            <td style="width:40px; text-align:center">ผล</td>
            <td style="width:40px; text-align:center">แผน</td>
            <td style="width:40px; text-align:center">ผล</td>
            <td style="width:40px; text-align:center">แผน</td>
            <td style="width:40px; text-align:center">ผล</td>
            <td style="width:40px; text-align:center">แผน</td>
            <td style="width:40px; text-align:center">ผล</td>
          </tr>
        </thead>
        
        
        
<?php
$d=1;
$indicator = $get->getProjectIndicator($PrjDetailId);//ltxt::print_r($indicator);
foreach($indicator as $r_indicator){
	foreach($r_indicator as $m=>$p){
		${$m} = $p;
	}
	
	$MonthTargetPlan10		= $get->getMonthTargetPlan($PrjIndId,10);
	$MonthTargetPlan11		= $get->getMonthTargetPlan($PrjIndId,11);
	$MonthTargetPlan12		= $get->getMonthTargetPlan($PrjIndId,12);
	
	$MonthTargetPlan1		= $get->getMonthTargetPlan($PrjIndId,1);
	$MonthTargetPlan2		= $get->getMonthTargetPlan($PrjIndId,2);
	$MonthTargetPlan3		= $get->getMonthTargetPlan($PrjIndId,3);
	
	$MonthTargetPlan4		= $get->getMonthTargetPlan($PrjIndId,4);
	$MonthTargetPlan5		= $get->getMonthTargetPlan($PrjIndId,5);
	$MonthTargetPlan6		= $get->getMonthTargetPlan($PrjIndId,6);
	
	$MonthTargetPlan7		= $get->getMonthTargetPlan($PrjIndId,7);
	$MonthTargetPlan8		= $get->getMonthTargetPlan($PrjIndId,8);
	$MonthTargetPlan9		= $get->getMonthTargetPlan($PrjIndId,9);
	
	
	
	
	$MonthTargetResult10		= $get->getMonthTargetResult($IndicatorCode,10);
	$MonthTargetResult11		= $get->getMonthTargetResult($IndicatorCode,11);
	$MonthTargetResult12		= $get->getMonthTargetResult($IndicatorCode,12);
	
	$MonthTargetResult1		= $get->getMonthTargetResult($IndicatorCode,1);
	$MonthTargetResult2		= $get->getMonthTargetResult($IndicatorCode,2);
	$MonthTargetResult3		= $get->getMonthTargetResult($IndicatorCode,3);
	
	$MonthTargetResult4		= $get->getMonthTargetResult($IndicatorCode,4);
	$MonthTargetResult5		= $get->getMonthTargetResult($IndicatorCode,5);
	$MonthTargetResult6		= $get->getMonthTargetResult($IndicatorCode,6);
	
	$MonthTargetResult7		= $get->getMonthTargetResult($IndicatorCode,7);
	$MonthTargetResult8		= $get->getMonthTargetResult($IndicatorCode,8);
	$MonthTargetResult9		= $get->getMonthTargetResult($IndicatorCode,9);

?>        
        
        
        
        <tr style="vertical-align:top;">
          <td style="text-align:center;"><?php echo $d; ?></td>
          <td style="text-align:center;"><?php echo $IndicatorCode; ?></td>
          <td><?php echo $IndicatorName; ?></td>
          <td style="text-align:center;"><?php echo ($TargetPlan)?$TargetPlan:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($UnitID)?($get->getUnitName($UnitID)):"-"; ?></td>
          <td style="text-align:center;"><?php echo ($MonthTargetPlan10)?$MonthTargetPlan10:"-"; ?></td>
          <td style="text-align:center;color:#0000FF;"><?php echo ($MonthTargetResult10)?$MonthTargetResult10:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($MonthTargetPlan11)?$MonthTargetPlan11:"-"; ?></td>
          <td style="text-align:center;color:#0000FF;"><?php echo ($MonthTargetResult11)?$MonthTargetResult11:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($MonthTargetPlan12)?$MonthTargetPlan12:"-"; ?></td>
          <td style="text-align:center;color:#0000FF;"><?php echo ($MonthTargetResult12)?$MonthTargetResult12:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($MonthTargetPlan1)?$MonthTargetPlan1:"-"; ?></td>
          <td style="text-align:center;color:#0000FF;"><?php echo ($MonthTargetResult1)?$MonthTargetResult1:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($MonthTargetPlan2)?$MonthTargetPlan2:"-"; ?></td>
          <td style="text-align:center;color:#0000FF;"><?php echo ($MonthTargetResult2)?$MonthTargetResult2:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($MonthTargetPlan3)?$MonthTargetPlan3:"-"; ?></td>
          <td style="text-align:center;color:#0000FF;"><?php echo ($MonthTargetResult3)?$MonthTargetResult3:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($MonthTargetPlan4)?$MonthTargetPlan4:"-"; ?></td>
          <td style="text-align:center;color:#0000FF;"><?php echo ($MonthTargetResult4)?$MonthTargetResult4:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($MonthTargetPlan5)?$MonthTargetPlan5:"-"; ?></td>
          <td style="text-align:center;color:#0000FF;"><?php echo ($MonthTargetResult5)?$MonthTargetResult5:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($MonthTargetPlan6)?$MonthTargetPlan6:"-"; ?></td>
          <td style="text-align:center;color:#0000FF;"><?php echo ($MonthTargetResult6)?$MonthTargetResult6:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($MonthTargetPlan7)?$MonthTargetPlan7:"-"; ?></td>
          <td style="text-align:center;color:#0000FF;"><?php echo ($MonthTargetResult7)?$MonthTargetResult7:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($MonthTargetPlan8)?$MonthTargetPlan8:"-"; ?></td>
          <td style="text-align:center;color:#0000FF;"><?php echo ($MonthTargetResult8)?$MonthTargetResult8:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($MonthTargetPlan9)?$MonthTargetPlan9:"-"; ?></td>
          <td style="text-align:center;color:#0000FF;"><?php echo ($MonthTargetResult9)?$MonthTargetResult9:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($TargetResult)?$TargetResult:"-"; ?></td>
          <td style="text-align:center;">
          <?php
			//$maxMonthNo = $get->getMaxMonthNo($IndicatorCode);
			//$MonthTargetResult	= $get->getMonthTargetResult($IndicatorCode,$maxMonthNo);
			if(($TargetResult >= $MinScore0)&&($TargetResult <= $MaxScore0)){
						
				echo '<span class="icon-col1">&nbsp;</span>';
						
			}else if(($TargetResult >= $MinScore1)&&($TargetResult <= $MaxScore1)){
						
				echo '<span class="icon-col2">&nbsp;</span>';
						
			}else if(($TargetResult >= $MinScore2)&&($TargetResult <= $MaxScore2)){
						
				echo '<span class="icon-col3">&nbsp;</span>';
						
			}else if(($TargetResult >= $MinScore3)&&($TargetResult <= $MaxScore3)){
						
				echo '<span class="icon-col4">&nbsp;</span>';
						
			}else if(($TargetResult >= $MinScore4)&&($TargetResult <= $MaxScore4)){
						
				echo '<span class="icon-col5">&nbsp;</span>';
						
			}else if(($TargetResult >= $MinScore5)&&($TargetResult <= $MaxScore5)){
						
				echo '<span class="icon-col6">&nbsp;</span>';
						
			}else{
				echo '<span>-</span>';
			}
		
			?>
          </td>
        </tr>
        
        
<?php
	$d++;
}
?>              
        
      </table> 
    
    
    
    
    
    
    
    
    </td>
</tr>

 
</table>







<div style="text-align:center; padding-top:10px; padding-bottom:10px">
	<input type="button" value="ปรับปรุงข้อมูล" class="btnActive" onclick="goPage('?mod=<?php echo lurl::dotPage('indicator_add');?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"];?>');" />
	<input type="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage('indicator_list');?>&BgtYear=<?php echo $BgtYear;?>');" />
</div>
      


<br />
<br />
<br />