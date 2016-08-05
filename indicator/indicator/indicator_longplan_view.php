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

$project = $get->getLongPlan($_REQUEST["LPlanId"]);//ltxt::print_r($project);
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

function toPage(BgtYear){
	window.location.href='?mod=<?php echo lurl::dotPage("indicator_longplan_add");?>&LPlanId=<?php echo $_REQUEST["LPlanId"];?>&BgtYear='+BgtYear;
}

	
</script>



<div class="sysinfo">
  <div class="sysname">จัดการข้อมูลตัวชี้วัด</div>
  <div class="sysdetail">ปรับปรุงแก้ไขรายละเอียดตัวชี้วัด</div>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-tab">
  <tr>
    <td class="notcurrent"><a href="?mod=<?php echo LURL::dotPage('indicator_list'); ?>&BgtYear=<?php echo ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543); ?>">ตัวชี้วัดโครงการ</a></td>
    <td class="notcurrent"><a href="?mod=<?php echo LURL::dotPage('indicator_plan_list'); ?>&BgtYear=<?php echo ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543); ?>">ตัวชี้วัดแผนงาน</a></td>
    <td class="current">ตัวชี้วัดแผนหลัก</td>
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



<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=savelongplan" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="LPlanId" id="LPlanId" value="<?php echo $_REQUEST['LPlanId'];?>" />
<input type="hidden" name="PLongCode" id="PLongCode" value="<?php echo $PLongCode;?>" />


<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
<tr>
    <th>ชื่อแผนหลัก</th>
    <td><?php echo $PLongName; ?></td>
</tr>
<tr>
    <th>ชื่อแผนงานภายใต้แผนหลัก</th>
    <td style="font-weight:bold;">(<?php echo $LPlanCode; ?>) <?php echo $LPlanName; ?></td>
</tr>
    <tr>
        <th>ปีที่ตั้งแผนหลัก</th>
        <td><?php echo $PLongYear;?><b>-</b><?php echo $PLongYearEnd;?>&nbsp;(ต่อเนื่อง <?php echo $PLongAmount;?> ปี)</td>
    </tr>


</table>



<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">ตัวชี้วัดความสำเร็จแผนงานภายใต้แผนหลัก</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
<tr>
    <td colspan="2" style="vertical-align:top;">
    
    
    
    
    
    
    
        
    
    
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
        <thead>
          <tr>
            <td rowspan="3" style="width:30px; text-align:center">ลำดับ</td>
            <td rowspan="3" style="width:100px; text-align:center">รหัสตัวชี้วัด</td>
            <td rowspan="3" style="text-align:center">ชื่อตัวชี้วัดโครงการ</td>
            <td rowspan="3" style="width:80px; text-align:center">ค่าเป้าหมาย</td>
            <td rowspan="3" style="width:80px; text-align:center">หน่วยนับ</td>
            <td style="text-align:center" colspan="<?php echo ($PLongAmount*2); ?>">ค่าเป้าหมายรายปี</td>
            <td rowspan="3" style="width:80px; text-align:center">ผลดำเนินงาน</td>
            <td rowspan="3" style="width:40px; text-align:center">สี</td>
          </tr>
          <tr>
          <?php 
		  $startYear = $PLongYear;
		  for($y=0;$y<$PLongAmount;$y++){ 
		  ?>
          <td colspan="2" style="text-align:center;"><?php echo $startYear; ?></td>
		  <?php 
		  	$startYear = $startYear+1;
		  } 
		  ?>
            </tr>
          <tr>
          <?php 
		  $startYear = $PLongYear;
		  for($y=0;$y<$PLongAmount;$y++){ 
		  ?>
            <td style="width:40px; text-align:center">แผน</td>
            <td style="width:40px; text-align:center">ผล</td>
          <?php 
		  	$startYear = $startYear+1;
		  } 
		  ?>
            </tr>
        </thead>
        
        
        
<?php
$d=1;
$indicator = $get->getLongPlanIndicator($LPlanCode);//ltxt::print_r($indicator);
foreach($indicator as $r_indicator){
	foreach($r_indicator as $m=>$p){
		${$m} = $p;
	}
	


?>        
        
        
        
        <tr style="vertical-align:top;">
          <td style="text-align:center;"><?php echo $d; ?></td>
          <td style="text-align:center;"><?php echo $LindCode; ?></td>
          <td><?php echo $LindName; ?></td>
          <td style="text-align:center;"><?php echo ($LindTargetPlan)?$LindTargetPlan:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($UnitID)?($get->getUnitName($UnitID)):"-"; ?></td>
          
          
          
          <?php 
		  $startYear = $PLongYear;
		  for($y=0;$y<$PLongAmount;$y++){ 
		  	$YearTargetPlan = $get->getYearTargetPlan($LindCode,$startYear);
			$YearTargetResult = $get->getYearTargetResult($LindCode,$startYear);
		  ?>
          <td style="text-align:center;"><?php echo ($YearTargetPlan)?$YearTargetPlan:"-"; ?></td>
          <td style="text-align:center;color:#0000FF;"><?php echo ($YearTargetResult)?$YearTargetResult:"-"; ?></td>
           <?php 
		  	$startYear = $startYear+1;
			unset($YearTargetPlan);
			unset($YearTargetResult);
		  } 
		  ?>
          
          
          <td style="text-align:center;"><?php echo ($LindTargetResult)?$LindTargetResult:"-"; ?></td>
          <td style="text-align:center;">
          <?php
			//$maxMonthNo = $get->getMaxMonthNo($IndicatorCode);
			//$MonthTargetResult	= $get->getMonthTargetResult($IndicatorCode,$maxMonthNo);
			if(($LindTargetResult >= $MinScore0)&&($LindTargetResult <= $MaxScore0)){
						
				echo '<span class="icon-col1">&nbsp;</span>';
						
			}else if(($LindTargetResult >= $MinScore1)&&($LindTargetResult <= $MaxScore1)){
						
				echo '<span class="icon-col2">&nbsp;</span>';
						
			}else if(($LindTargetResult >= $MinScore2)&&($LindTargetResult <= $MaxScore2)){
						
				echo '<span class="icon-col3">&nbsp;</span>';
						
			}else if(($LindTargetResult >= $MinScore3)&&($LindTargetResult <= $MaxScore3)){
						
				echo '<span class="icon-col4">&nbsp;</span>';
						
			}else if(($LindTargetResult >= $MinScore4)&&($LindTargetResult <= $MaxScore4)){
						
				echo '<span class="icon-col5">&nbsp;</span>';
						
			}else if(($LindTargetResult >= $MinScore5)&&($LindTargetResult <= $MaxScore5)){
						
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
	<input type="button" value="ปรับปรุงข้อมูล" class="btnActive" onclick="goPage('?mod=<?php echo lurl::dotPage('indicator_longplan_add');?>&LPlanId=<?php echo $_REQUEST["LPlanId"];?>');" />
	<input type="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage('indicator_longplan_list');?>&PLongCode=<?php echo $PLongCode;?>');" />
</div>
      
</form>