<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));

$planDetail = $get->getPlanDetail($_REQUEST["PItemCode"]);//ltxt::print_r($planDetail);
foreach( $planDetail as $row ) {
	foreach( $row as $k=>$v){ 
		${$k} = $v;
	}
}



?>
<script  type="text/javascript">
function toPage(MonthNo){
	window.location.href='?mod=<?php echo lurl::dotPage("fresult_planmonth");?>&PItemCode=<?php echo $_REQUEST["PItemCode"];?>&MonthNo='+MonthNo+'#History';
}

	
</script>


<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#eeebac;">
  <tr>
    <td style="padding:5px;">
    <a href="javascript:saveToWord()" class="ico print">พิมพ์</a>&nbsp;
    <a href="javascript:saveToWord()" class="icon-word">ส่งออกเป็น Word</a>
    </td>
    <td style="text-align:right; padding-right:5px;">
      <input type="button" name="button" id="button" value="  ย้อนกลับ  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>');" />
    </td>
  </tr>
</table>




<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
  </table>  
</div>



<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $_REQUEST['PrjId'];?>" />
<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId'];?>" />
<input type="hidden" name="PrjActCode" id="PrjActCode" value="<?php echo $_REQUEST['PrjActCode'];?>" />
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId'];?>" />
<input type="hidden" name="OrgCode" id="OrgCode" value="<?php echo $_REQUEST['OrgCode'];?>" />
<input type="hidden" name="MonthNo" id="MonthNo" value="<?php echo $_REQUEST['pageid'];?>" />
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>" />




<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
<th>ปีงบประมาณ</th>
    <td><?php echo $BgtYear;?></td>
  </tr>
<tr>
<th style="vertical-align:top;">ชื่อแผนงาน</th>
<td style="font-weight:bold;">(<?php echo $PItemCode;?>) <?php echo $PItemName;?></td>
</tr>   
<tr>
  <th>วิธีการรายงานผลตัวชี้วัด</th>
  <td>
<?php if($Methods == "monthly"){ echo 'รายเดือน'; } ?>
<?php if($Methods == "quarterly"){ echo 'รายไตรมาส'; } ?>
  </td>
</tr>   
<tr>
<th>ภายใต้แผนหลัก</th>
<td><?php echo ($LPlanCode)?($get->getLPlanName($LPlanCode)):('<span style="color:#999;">-ไม่ระบุ-</span>'); ?></td>
</tr>


<tr>
	<th colspan="2">เป้าประสงค์ของแผนงาน</th>
</tr>
<tr>
	<td colspan="2">
    
    
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
    <thead>
      <tr>
        <td class="no" style="width:10px">ลำดับ</td>
        <td align="left" >ชื่อเป้าประสงค์</td>
        </tr>
    </thead>
    <tbody>
<?php
	$n=1;
	$purpose = $get->getPurposeItem($PItemCode);
	if($purpose){
          foreach($purpose as $pp ) {
				foreach( $pp as $u=>$t){ ${$u} = $t;}
?>
  <tr>
    <td valign="top" style="text-align:center;"><?php echo $n ;?>.</td>
    <td valign="top" ><?php echo $PurposeName;?></td>
    </tr>
  
<?php

		$n++;
		}
	}
?>
    </tbody>
</table>
    
    
    
    </td>
</tr>





<?php 
	$detail = $get->getResultDetail($_REQUEST['PrjDetailId'],$_REQUEST['PrjActCode'],$_REQUEST['pageid']);
	//ltxt::print_r($detail);
	foreach($detail as $drow){
		foreach($drow as $k=>$v){
			${$k} = $v;
		}
	}
?>



<tr>
	<th colspan="2">ตัวชี้วัดของแผนงาน</th>
</tr>
<tr>
	<td colspan="2" style="vertical-align:top;">
    
    
    
    
    
    
    
    
    
    
    
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
        <thead>
          <tr>
            <td style="width:30px; text-align:center">ลำดับ</td>
            <td style="width:100px; text-align:center">รหัสตัวชี้วัด</td>
            <td style="text-align:center">ชื่อตัวชี้วัดโครงการ</td>
            <td style="width:80px; text-align:center">ค่าเป้าหมาย</td>
            <td style="width:80px; text-align:center">ผลดำเนินงาน</td>
            <td style="width:80px; text-align:center">หน่วยนับ</td>
            <td style="width:40px; text-align:center">สี</td>
          </tr>
        </thead>
        
        
        
<?php
$d=1;
$indicator = $get->getPlanIndicator($PItemCode);//ltxt::print_r($indicator);
foreach($indicator as $r_indicator){
	foreach($r_indicator as $m=>$p){
		${$m} = $p;
	}
	


?>        
        
        
        
        <tr style="vertical-align:top;">
          <td style="text-align:center;"><?php echo $d; ?></td>
          <td style="text-align:center;"><?php echo $PIndCode; ?></td>
          <td><?php echo $PIndName; ?></td>
          <td style="text-align:center;"><?php echo ($PIndTargetPlan)?$PIndTargetPlan:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($PIndTargetResult)?$PIndTargetResult:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($UnitID)?($get->getUnitName($UnitID)):"-"; ?></td>
          <td style="text-align:center;">
            <?php
			//$maxMonthNo = $get->getMaxMonthNo($IndicatorCode);
			//$MonthTargetResult	= $get->getMonthTargetResult($IndicatorCode,$maxMonthNo);
			if(($PIndTargetResult >= $MinScore0)&&($PIndTargetResult <= $MaxScore0)){
						
				echo '<span class="icon-col1">&nbsp;</span>';
						
			}else if(($PIndTargetResult >= $MinScore1)&&($PIndTargetResult <= $MaxScore1)){
						
				echo '<span class="icon-col2">&nbsp;</span>';
						
			}else if(($PIndTargetResult >= $MinScore2)&&($PIndTargetResult <= $MaxScore2)){
						
				echo '<span class="icon-col3">&nbsp;</span>';
						
			}else if(($PIndTargetResult >= $MinScore3)&&($PIndTargetResult <= $MaxScore3)){
						
				echo '<span class="icon-col4">&nbsp;</span>';
						
			}else if(($PIndTargetResult >= $MinScore4)&&($PIndTargetResult <= $MaxScore4)){
						
				echo '<span class="icon-col5">&nbsp;</span>';
						
			}else if(($PIndTargetResult >= $MinScore5)&&($PIndTargetResult <= $MaxScore5)){
						
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


  <tr>
  <th colspan="2" style="text-align:left;">ผลการดำเนินงานจำแนกตามโครงการภายใต้แผนงาน</th>
  </tr>
  <tr>
  <td colspan="2" style="background-color:#EEE; vertical-align:top;">
  
  <div style="padding:5px;">
  <a name="History" id="History">&nbsp;</a> 
  <?php $_REQUEST["MonthNo"] = ($_REQUEST["MonthNo"])?$_REQUEST["MonthNo"]:(date("m")); ?>
  <span style="font-weight:bold;">ประจำเดือน</span>
    <select name="MonthNo" id="MonthNo" style="width:150px;" onchange="toPage(this.value);">
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
  </div>
  
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
  <thead>
    <tr>
      <td style="width:40px;">ลำดับ</td>
      <td style="text-align:center;">ชื่อโครงการ</td>
      <td style="width:80px; text-align:center;">%ค่าน้ำหนัก</td>
      <td style="width:100px; text-align:center;">%ก้าวหน้าแผนงาน</td>
      </tr>
    </thead>
<?php   
$n=0;
$selectAct = $get->getProjectList($_REQUEST["PItemCode"]);//ltxt::print_r($selectAct);
foreach($selectAct as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;} 
	$ProgressAmass			= $get->getSumProgressAmass($PrjCode,$_REQUEST["MonthNo"]);
	$totalPercentMass		= $totalPercentMass+$PrjMass;
	$totalProgressAmass	= $totalProgressAmass+$ProgressAmass;

?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo ($n+1); ?></td>
      <td><a href="?mod=<?php echo LURL::dotPage($resultMonthPage); ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&MonthNo=<?php echo $_REQUEST["MonthNo"]; ?>"><?php echo $PrjName;?></a></td>
      <td style="text-align:center;"><?php echo ($PrjMass)?$PrjMass:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      </tr> 
<?php	
	$n++;			
}
?>      

     <tr style="vertical-align:top; font-weight:bold;">
      <td colspan="2" style="text-align:right;">%แผนงาน</td>
      <td style="text-align:center;"><?php echo ($totalPercentMass)?$totalPercentMass:"-";?></td>
      <td style="text-align:center; background-color:#FFFF99;"><?php echo ($totalProgressAmass)?$totalProgressAmass:"-";?></td>
      </tr>
      
    </table>
 
 
  
    
    
    
    
    
    </td>
  </tr>
  
  
  
  
  
  
</table>




     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>');" /></div>
      
</form>

