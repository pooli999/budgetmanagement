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

$project = $get->getPlan($_REQUEST["PItemId"]);//ltxt::print_r($project);
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
	window.location.href='?mod=<?php echo lurl::dotPage("findicator_plan_add");?>&PItemId=<?php echo $_REQUEST["PItemId"];?>&MonthNo='+MonthNo;
}

	
</script>



<div class="sysinfo">
  <div class="sysname">จัดการข้อมูลตัวชี้วัด</div>
  <div class="sysdetail">ปรับปรุงแก้ไขรายละเอียดตัวชี้วัด</div>
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-tab">
  <tr>
    <td class="notcurrent">ตัวชี้วัดโครงการ</td>
    <td class="current">ตัวชี้วัดแผนงาน</td>
    <td class="notcurrent">ตัวชี้วัดแผนหลัก</td>
    <td class="line">&nbsp;</td>
  </tr>
</table>




<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=saveplan" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="PItemId" id="PItemId" value="<?php echo $_REQUEST['PItemId'];?>" />
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $BgtYear;?>" />


<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
<tr>
    <th>ปีงบประมาณ</th>
    <td><?php echo $BgtYear; ?></td>
</tr>
<tr>
    <th>ชื่อแผนงาน</th>
    <td style="font-weight:bold;">(<?php echo $PItemCode; ?>) <?php echo $PItemName; ?></td>
</tr>
<tr>
    <th>ความถี่ในการรายงาน</th>
    <td>
    <?php if($Methods == "monthly"){ echo 'รายเดือน'; } ?>
	<?php if($Methods == "quarterly"){ echo 'รายไตรมาส'; } ?>
    </td>
</tr>
<tr>
    <th colspan="2">ช่วงเวลาการรายงานผลตัวชี้วัด</th>
</tr>
<tr>
    <td colspan="2">
    
    
<?php 
$curDate = date("Y-m-d");
$year = $get->getYearStart($BgtYear);
foreach($year as $rYear){
	foreach($rYear as $t=>$w){
		${$t} = $w;
	}
}
?>
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
        <thead>
          <tr>
            <td style="width:25%; text-align:center">ไตรมาสที่ 1</td>
            <td style="width:25%; text-align:center">ไตรมาสที่ 2</td>
            <td style="width:25%; text-align:center">ไตรมาสที่ 3</td>
            <td style="width:25%; text-align:center">ไตรมาสที่ 4</td>
            </tr>
        </thead>
        <tr>
          <td style="text-align:center"><?php  echo ($QuarterStart1)?Showdate($QuarterStart1):' <span style="color:#999;">ไม่ระบุ</span>ุ '; ?> - <?php  echo ($QuarterEnd1)?Showdate($QuarterEnd1):' <span style="color:#999;">ไม่ระบุ</span> '; ?></td>
          <td style="text-align:center"><?php  echo ($QuarterStart2)?Showdate($QuarterStart2):' <span style="color:#999;">ไม่ระบุ</span> '; ?> - <?php  echo ($QuarterEnd2)?Showdate($QuarterEnd2):' <span style="color:#999;">ไม่ระบุ</span> '; ?></td>
          <td style="text-align:center"><?php  echo ($QuarterStart3)?Showdate($QuarterStart3):' <span style="color:#999;">ไม่ระบุ</span> '; ?> - <?php  echo ($QuarterEnd3)?Showdate($QuarterEnd3):' <span style="color:#999;">ไม่ระบุ</span> '; ?></td>
          <td style="text-align:center"><?php  echo ($QuarterStart4)?Showdate($QuarterStart4):' <span style="color:#999;">ไม่ระบุ</span> '; ?> - <?php  echo ($QuarterEnd4)?Showdate($QuarterEnd4):' <span style="color:#999;">ไม่ระบุ</span> '; ?></td>
          </tr>
    </table>   
    
    
    
    
    
    </td>
</tr>


</table>



<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">บันทึกผลตัวชี้วัดความสำเร็จแผนงาน</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
<?php if($Methods == "monthly"){ ?>
  <tr>
    <th style="text-align:left; width:20%">ประจำเดือน</th>
    <td class="require" >*</td>
    <td>
    <select name="MonthNo" id="MonthNo" style="width:150px;" onchange="toPage(this.value);">
    	<option value="0">ระบุ</option>
        <option value="10" <?php if($_REQUEST["MonthNo"] == 10){ ?> selected="selected" <?php } ?>>ตุลาคม</option>
        <option value="11" <?php if($_REQUEST["MonthNo"] == 11){ ?> selected="selected" <?php } ?>>พฤศจิกายน</option>
        <option value="12" <?php if($_REQUEST["MonthNo"] == 12){ ?> selected="selected" <?php } ?>>ธันวาคม</option>
        <option value="1" <?php if($_REQUEST["MonthNo"] == 1){ ?> selected="selected" <?php } ?>>มกราคม</option>
        <option value="2" <?php if($_REQUEST["MonthNo"] == 2){ ?> selected="selected" <?php } ?>>กุมภาพันธ์</option>
        <option value="3" <?php if($_REQUEST["MonthNo"] == 3){ ?> selected="selected" <?php } ?>>มีนาคม</option>
        <option value="4" <?php if($_REQUEST["MonthNo"] == 4){ ?> selected="selected" <?php } ?>>เมษายน</option>
        <option value="5" <?php if($_REQUEST["MonthNo"] == 5){ ?> selected="selected" <?php } ?>>พฤษภาคม</option>
        <option value="6" <?php if($_REQUEST["MonthNo"] == 6){ ?> selected="selected" <?php } ?>>มิถุนายน</option>
        <option value="7" <?php if($_REQUEST["MonthNo"] == 7){ ?> selected="selected" <?php } ?>>กรกฎาคม</option>
        <option value="8" <?php if($_REQUEST["MonthNo"] == 8){ ?> selected="selected" <?php } ?>>สิงหาคม</option>
        <option value="9" <?php if($_REQUEST["MonthNo"] == 9){ ?> selected="selected" <?php } ?>>กันยายน</option>
    </select>
    </td>
  </tr>
<?php } ?>
<?php if($Methods == "quarterly"){ ?>
    <tr>
    <th style="text-align:left;">ประจำไตรมาส</th>
    <td class="require" >*</td>
    <td>
    <select name="MonthNo" id="MonthNo" style="width:150px;" onchange="toPage(this.value);">
    	<option value="0">ระบุ</option>
        <option value="12" <?php if($_REQUEST["MonthNo"] == 12){ ?> selected="selected" <?php } ?>>ไตรมาสที่ 1</option>
        <option value="3" <?php if($_REQUEST["MonthNo"] == 3){ ?> selected="selected" <?php } ?>>ไตรมาสที่ 2</option>
        <option value="6" <?php if($_REQUEST["MonthNo"] == 6){ ?> selected="selected" <?php } ?>>ไตรมาสที่ 3</option>
        <option value="9" <?php if($_REQUEST["MonthNo"] == 9){ ?> selected="selected" <?php } ?>>ไตรมาสที่ 4</option>
    </select>
    </td>
  </tr>
<?php } ?>
<tr>
    <td colspan="3" style="vertical-align:top;">
    
    
    
    
    
    
    
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
        <thead>
          <tr>
            <td rowspan="2" style="width:30px; text-align:center">ลำดับ</td>
            <td rowspan="2" style="width:100px; text-align:center">รหัสตัวชี้วัด</td>
            <td rowspan="2" style="text-align:center">ชื่อตัวชี้วัดโครงการ</td>
            <td rowspan="2" style="width:80px; text-align:center">ค่าเป้าหมาย</td>
            <td colspan="2" style="text-align:center">ค่าเป้าหมายเดือน/ไตรมาส</td>
            <td rowspan="2" style="width:80px; text-align:center">หน่วยนับ</td>
          </tr>
          <tr>
            <td style="width:100px; text-align:center">แผน</td>
            <td style="width:100px; text-align:center">ผล</td>
          </tr>
        </thead>
        
<?php
$d=1;
$indicator = $get->getPlanIndicator($PItemCode);//ltxt::print_r($indicator);
foreach($indicator as $r_indicator){
	foreach($r_indicator as $m=>$p){
		${$m} = $p;
	}
	unset($MonthTargetPlan);
	unset($MonthTargetResult);
	unset($IndMonthId);
	$Month = $get->getPlanMonthIndicator($PIndCode,$_REQUEST["MonthNo"]);//ltxt::print_r($Month);
	foreach($Month as $r_Month){
		foreach($r_Month as $g=>$y){
			${$g} = $y;
		}
	}

?>        
        <tr>
          <td style="text-align:center;"><?php echo $d; ?></td>
          <td style="text-align:center;"><?php echo $PIndCode; ?>
          <input type="hidden" name="PIndId[]"  value="<?php echo $PIndId;?>" />
          <input type="hidden" name="PIndCode[]"  value="<?php echo $PIndCode;?>" />
          </td>
          <td><?php echo $PIndName; ?></td>
          <td style="text-align:center;"><?php echo ($PIndTargetPlan)?$PIndTargetPlan:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($MonthTargetPlan)?$MonthTargetPlan:"-"; ?></td>
          <td style="text-align:center;">
          <input type="hidden" name="IndMonthId[]"  value="<?php echo $IndMonthId;?>" />
          <input type="text" style="width:90px; text-align:center;" name="MonthTargetResult[]" value="<?php echo $MonthTargetResult; ?>" />
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
	<input type="button" name="button" id="button" value="ยกเลิก" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage('findicator_plan_list');?>&BgtYear=<?php echo $BgtYear;?>');" />
</div>
      
</form>