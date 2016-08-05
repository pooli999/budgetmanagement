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

$dataPrj=$get->getProjectView($_REQUEST['PrjDetailId']);
//ltxt::print_r($dataPrj);
foreach( $dataPrj as $row ) {
	foreach( $row as $k=>$v){ 
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
	if(JQ('#Progress').val()==""){
		alert("กรุณากรอก % ความก้าวหน้า");
		JQ('Progress').focus();
		return false
	}
	
	return true;
}

function toPage(MonthNo){
	window.location.href='?mod=<?php echo lurl::dotPage("fresult_projectmonth");?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"];?>&MonthNo='+MonthNo+'#History';
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


<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th style="width:20%; text-align:left">ปีงบประมาณ</th>
    <td  style="width:80%; text-align:left;"><?php echo $BgtYear;?></td>
  </tr>
  <tr>
    <th style="text-align:left">ชื่อโครงการ</th>
    <td  style="text-align:left;"><b><?php echo $PrjName;?></b></td>
  </tr>
  <tr>
    <th style="text-align:left">เจ้าของโครงการ</th>
    <td  style="text-align:left;"><?php echo $get->getOrgName($BgtYear, $OrganizeCode);?></td>
  </tr>
  <tr>
    <th style="text-align:left">วิธีการรายงานผล</th>
    <td  style="text-align:left;"><?php if($PrjMethods == "quarterly"){echo "รายไตรมาส";}else{echo "รายเดือน";} ?></td>
  </tr>
  <tr>
    <th style="text-align:left">ระยะเวลาโครงการ</th>
    <td  style="text-align:left;"><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td>
  </tr> 
    <tr>
    <th colspan="2" valign="top">ตัวชี้วัดโครงการ</th>
  </tr>
  <tr>
    <td colspan="2" valign="top">
  
  
  
  
  
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
          <td style="text-align:center;"><?php echo ($TargetResult)?$TargetResult:"-"; ?></td>
          <td style="text-align:center;"><?php echo ($UnitID)?($get->getUnitName($UnitID)):"-"; ?></td>
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


<?php 
	$detail = $get->getResultDetail($_REQUEST['PrjDetailId'],$_REQUEST['PrjActCode'],$_REQUEST['pageid']);
	//ltxt::print_r($detail);
	foreach($detail as $drow){
		foreach($drow as $k=>$v){
			${$k} = $v;
		}
	}
?>



    
<table width="100%" border="0" cellspacing="1" cellpadding="6" class="tbl-list" >
  <tr>
  <th colspan="2" style="text-align:left;">ผลการดำเนินงานจำแนกตามกิจกรรมในโครงการ</th>
  </tr>
  <tr>
  <td colspan="2" style="background-color:#EEE; vertical-align:top;">
  
  <div style="padding:5px;">
  <a name="History" id="History">&nbsp;</a> 
  <?php $_REQUEST["MonthNo"] = ($_REQUEST["MonthNo"])?$_REQUEST["MonthNo"]:(date("m")); ?>
  <?php if($PrjMethods == "monthly"){ ?>
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
<?php } ?>
<?php if($PrjMethods == "quarterly"){ ?>
<span style="font-weight:bold;">ประจำไตรมาส</span>
    <select name="MonthNo" id="MonthNo" style="width:150px;" onchange="toPage(this.value);">
        <option value="12" <?php if($_REQUEST["MonthNo"] == 12){ ?> selected="selected" <?php } ?>>ไตรมาสที่ 1</option>
        <option value="3" <?php if($_REQUEST["MonthNo"] == 3){ ?> selected="selected" <?php } ?>>ไตรมาสที่ 2</option>
        <option value="6" <?php if($_REQUEST["MonthNo"] == 6){ ?> selected="selected" <?php } ?>>ไตรมาสที่ 3</option>
        <option value="9" <?php if($_REQUEST["MonthNo"] == 9){ ?> selected="selected" <?php } ?>>ไตรมาสที่ 4</option>
    </select>
<?php } ?>
  
  </div>
  
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
  <thead>
    <tr>
      <td style="width:40px;">ลำดับ</td>
      <td style="text-align:center;">ชื่อกิจกรรมในโครงการ</td>
      <td style="width:80px; text-align:center;">%ค่าน้ำหนัก</td>
      <td style="width:80px; text-align:center;">%ดำเนินงาน</td>
      <td style="width:100px; text-align:center;">%ก้าวหน้าโครงการ</td>
      <td style="width:100px; text-align:center;">ผลดำเนินการ</td>
      <td style="width:100px; text-align:center;">ปัญหา/อุปสรรค</td>
      <td style="width:100px; text-align:center;">ปัจจัยสนับสนุน</td>
      <td style="width:200px; text-align:center;">เอกสารแนบ</td>
      <td style="width:100px; text-align:center;">หมายเหตุ</td>
      </tr>
    </thead>
<?php   
$selectAct = $get->getProjectDetailActRecordSet($PrjDetailId);//ltxt::print_r($selectAct);
foreach($selectAct as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;} 
	unset($Progress); 
	unset($ProgressAmass);
	unset($Result);
	unset($Problem);
	unset($Factor);
	unset($ResultId);
	unset($Comment);
	$detail = $get->getResultDetail($PrjActCode,$_REQUEST["MonthNo"]);//ltxt::print_r($detail);
	foreach($detail as $drow){
		foreach($drow as $k=>$v){
			${$k} = $v;
		}
	}
	$totalPercentMass		= $totalPercentMass+$PercentMass;
	$totalProgressAmass	= $totalProgressAmass+$ProgressAmass;

?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo ($n+1); ?></td>
      <td><?php echo $PrjActName;?></td>
      <td style="text-align:center;"><?php echo ($PercentMass)?$PercentMass:"-";?></td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Problem)?$Problem:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Factor)?$Factor:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'MultiDocId10',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      </tr> 
<?php	
	$n++;			
}
?>      

     <tr style="vertical-align:top; font-weight:bold;">
      <td colspan="2" style="text-align:right;">%โครงการ</td>
      <td style="text-align:center;"><?php echo ($totalPercentMass)?$totalPercentMass:"-";?></td>
      <td style="text-align:center;">-</td>
      <td style="text-align:center; background-color:#FFFF99;"><?php echo ($totalProgressAmass)?$totalProgressAmass:"-";?></td>
      <td colspan="5">&nbsp;</td>
      </tr>
      
    </table>
 
 
  
    
    
    
    
    
    </td>
  </tr>
  
  
  
  
  
  
</table>




     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>');" /></div>
      
</form>

