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
    <td class="notcurrent">ตัวชี้วัดโครงการ</td>
    <td class="notcurrent">ตัวชี้วัดแผนงาน</td>
    <td class="current">ตัวชี้วัดแผนหลัก</td>
    <td class="line">&nbsp;</td>
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



<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">บันทึกผลตัวชี้วัดความสำเร็จแผนงานภายใต้แผนหลัก</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th style="text-align:left; width:20%">ประจำปี</th>
    <td>
    <span class="require" >*</span>
    <select name="BgtYear" id="BgtYear" style="width:150px;" onchange="toPage(this.value);">
    	<option value="0">ระบุ</option>
        <?php 
		$curYear = $PLongYear;
		for($i=0;$i<$PLongAmount;$i++){ 
		?>
        <option value="<?php echo $curYear; ?>" <?php if($_REQUEST["BgtYear"] == $curYear){ ?> selected="selected" <?php } ?>><?php echo $curYear; ?></option>
        <?php 
			$curYear = $curYear+1;
		} 
		?>
    </select>
    </td>
  </tr>
<tr>
    <td colspan="2" style="vertical-align:top;">
    
    
    
    
    
    
    
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
        <thead>
          <tr>
            <td rowspan="2" style="width:30px; text-align:center">ลำดับ</td>
            <td rowspan="2" style="width:100px; text-align:center">รหัสตัวชี้วัด</td>
            <td rowspan="2" style="text-align:center">ชื่อตัวชี้วัดโครงการ</td>
            <td rowspan="2" style="width:80px; text-align:center">ค่าเป้าหมาย</td>
            <td colspan="2" style="text-align:center">ค่าเป้าหมายรายปี</td>
            <td rowspan="2" style="width:80px; text-align:center">หน่วยนับ</td>
          </tr>
          <tr>
            <td style="width:100px; text-align:center">แผน</td>
            <td style="width:100px; text-align:center">ผล</td>
          </tr>
        </thead>
        
<?php
$d=1;
$indicator = $get->getLongPlanIndicator($LPlanCode);//ltxt::print_r($indicator);
foreach($indicator as $r_indicator){
	foreach($r_indicator as $m=>$p){
		${$m} = $p;
	}
	unset($YearTargetPlan);
	unset($YearTargetResult);
	unset($LIndMonthId);
	$Month = $get->getLongPlanMonthIndicator($LindCode,$_REQUEST["BgtYear"]);//ltxt::print_r($Month);
	foreach($Month as $r_Month){
		foreach($r_Month as $g=>$y){
			${$g} = $y;
		}
	}

?>        
        <tr style="vertical-align:top;">
          <td style="text-align:center;"><?php echo $d; ?></td>
          <td style="text-align:center;"><?php echo $LindCode; ?>
          <input type="hidden" name="LindId[]"  value="<?php echo $LindId;?>" />
          <input type="hidden" name="LindCode[]"  value="<?php echo $LindCode;?>" />
          </td>
          <td><?php echo $LindName; ?></td>
          <td style="text-align:center;"><?php echo ($LindTargetPlan)?$LindTargetPlan:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($YearTargetPlan)?$YearTargetPlan:"-"; ?></td>
          <td style="text-align:center;">
          <input type="hidden" name="LIndMonthId[]"  value="<?php echo $LIndMonthId;?>" />
          <input type="text" style="width:90px; text-align:center;" name="YearTargetResult[]" value="<?php echo $YearTargetResult; ?>" <?php if(!$YearTargetPlan){ ?> disabled="disabled" <?php } ?> />
          </td>
          <td style="text-align:center;"><?php echo ($UnitID)?($get->getUnitName($UnitID)):"-"; ?></td>
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
	<input type="submit" class="btnActive" name="save" id="save" value="บันทึก"  />
	<input type="button" name="button" id="button" value="ยกเลิก" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage('indicator_longplan_list');?>&PLongCode=<?php echo $PLongCode;?>');" />
</div>
      
</form>