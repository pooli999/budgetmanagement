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
		'text' => 'ระบบรายงานผลและตัวชี้วัด',
	),
	array(
		'text' => 'พิมพ์รายงาน',
		'link' => '?mod=indicator.report.startup'
	),
	array(
		'text' => 'รายงานรายละเอียดความก้าวหน้าการดำเนินงานกิจกรรม/โครงการ/แผนงาน',
	),
));

?>

<script language="javascript" type="text/javascript">
function printDocument(){
	window.location.href="?mod=<?php echo LURL::dotPage('report4_print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('report4_excel')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToWord(){
	window.location.href="?mod=<?php echo LURL::dotPage('report4_word')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function loadCondition(act){
	if(act=="show"){
		$('search').style.display='';
		$('search-item').style.display='none';
	}else{
		$('search').style.display='none';
		$('search-item').style.display='';
	}
}

function loadPlan(BgtYear){
	document.getElementById('plan').innerHTML='<span class="icon-load">กรุณารอสักครู่</span>';
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('report4_action');?>",		   
		  data: "action=getplanlist&BgtYear="+BgtYear,
		  success: function(msg){
			JQ("#plan").html(msg);
		  }
	});
	loadPrj(0);
}


function loadPrj(PItemCode){
	document.getElementById('prj').innerHTML='<span class="icon-load">กรุณารอสักครู่</span>';
	var BgtYear = JQ("#BgtYear").val();//alert(BgtYear);
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('report4_action');?>",		   
		  data: "action=getprjlist&BgtYear="+BgtYear+"&PItemCode="+PItemCode,
		  success: function(msg){
			JQ("#prj").html(msg);
		  }
	});

}


function loadPage(form){
	if(ValidateForm(form)){	
		document.getElementById('c-report').innerHTML='<span class="icon-load">กรุณารอสักครู่ ระบบกำลังทำการรวบรวมข้อมูล !!!!!</span>';
		form.submit();
	}
}


function ValidateForm(form){
	var BgtYear = JQ("#BgtYear").val();//alert(BgtYear);
	if(BgtYear==0){
		alert('กรุณาระบุปีงบประมาณ');
		JQ("#BgtYear").focus();
		return false;
	}
	var PItemCode = JQ("#PItemCode").val();//alert(ScreenLevel);
	if(PItemCode==0){
		alert('กรุณาระบุชื่อแผนงาน สช.');
		JQ("#PItemCode").focus();
		return false;
	}
	/*var PrjDetailId = JQ("#PrjDetailId").val();//alert(ScreenLevel);
	if(PrjDetailId==0){
		alert('กรุณาระบุชื่อโครงการ');
		JQ("#PrjDetailId").focus();
		return false;
	}*/
	return true;
}



</script>


<div class="sysinfo">
  <div class="sysname">รายงานรายละเอียดความก้าวหน้าการดำเนินงานกิจกรรม/โครงการ/แผนงาน</div>
  <div class="sysdetail">&nbsp;</div>
</div>





<form id="adminForm" name="adminForm" method="get" onSubmit="loadPage(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="mod" id="mod" value="<?php echo LURL::dotPage('report4_list');?>" />
<input type="hidden" name="showResult" id="showResult" value="yes" />
<div id="boxSearch" class="boxsearch" style="display:block; margin-right:0px; margin-left:0px;">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="5" class="tbl-search">
<tbody id="search" <?php if($_REQUEST["showResult"]=="yes"){ ?> style="display:none;" <?php } ?>>
<tr>
	<td colspan="3" style="font-weight:bold; color:#990000; text-decoration:underline;">ระบุเงื่อนไขการแสดงรายงาน</td>
</tr>
<tr>
	<th style="width:100px;">ปีงบประมาณ</th>
	<td class="require" style="width:10px;">*</td>
	<td>
	<?php echo $get->getYearProject();?>
    <span class="hint">(เป็นเงื่อนไขที่จำเป็นต้องระบุทุกครั้ง)</span>
    </td>
</tr>
<tr>
	<th>ชื่อแผนงาน สช.</th>
	<td class="require">*</td>
	<td><span id="plan"><?php echo $get->getPlanItemList(); ?></span></td>
</tr>
<tr>
	<th>โครงการ</th>
	<td class="require">&nbsp;</td>
	<td><span id="prj"><?php echo $get->getProjectListSearch(); ?></span></td>
</tr>


<tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
	<td>
<input type="submit" name="button" id="button" value="แสดงข้อมูล" class="btn-search" />
<input type="button" name="close" id="close" value="ปิดส่วนนี้" onclick="loadCondition('hide')" />
    </td>
</tr>
</tbody>
<tbody id="search-item" <?php if($_REQUEST["showResult"]!="yes"){ ?> style="display:none;" <?php } ?>>
<tr>
	<td colspan="3" style="font-weight:bold; color:#990000; text-decoration:underline;">เงื่อนไขการแสดงรายงาน</td>
</tr>
<?php if($_REQUEST["BgtYear"]){ ?>
<tr>
	<th>ปีงบประมาณ</th>
	<td>&nbsp;</td>
	<td><?php echo $_REQUEST["BgtYear"]; ?></td>
</tr>
<?php } ?>
<?php if($_REQUEST["PItemCode"]){ ?>
<tr>
	<th>ชื่อแผนงาน สช.</th>
	<td>&nbsp;</td>
	<td><?php echo $get->getPItemName($_REQUEST["BgtYear"],$_REQUEST["PItemCode"]); ?></td>
</tr>
<?php } ?>

<?php if($_REQUEST["PrjDetailId"]){ ?>
<tr style="vertical-align:top;">
	<th>โครงการ</th>
	<td>&nbsp;</td>
	<td><?php echo $get->getPrjDetailName($_REQUEST["PrjDetailId"]); ?></td>
</tr>
<?php } ?>


<tr>
	<th>&nbsp;</th>
	<td>&nbsp;</td>
	<td>
<input type="button" name="new-search" id="new-search" value="ระบุเงื่อนไขการแสดงข้อมูล" onclick="loadCondition('show')" class="btn-search" />      
    </td>
</tr>
</tbody>
</table>
</div>
</form>


<div id="c-report">
<?php if($_REQUEST["showResult"] == "yes"){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbl-button">
  <tr>
    <td>
     <a href="javascript:printDocument();" class="icon-printer">พิมพ์</a>&nbsp;
     <a href="javascript:saveToWord();" class="icon-word">ส่งออกเป็น Word</a>&nbsp;
    <a href="javascript:saveToExcel();" class="icon-excel">ส่งออกเป็น Excel</a>
    </td>
  </tr>
</table>




<div class="topic-report" style="background-color:#EEE;">ความก้าวหน้าการดำเนินงานกิจกรรม/โครงการ/แผนงาน สช. ประจำปี <?php echo $_REQUEST["BgtYear"]; ?></div>


<?php
$planDetail = $get->getPlanDetail($_REQUEST["PItemCode"]);//ltxt::print_r($planDetail);
foreach( $planDetail as $row ) {
	foreach( $row as $k=>$v){ 
		${$k} = $v;
	}
}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-report">
<tr>
<th style="vertical-align:top;">ชื่อแผนงาน</th>
<td style="font-weight:bold;">(<?php echo $PItemCode;?>) <?php echo $PItemName;?></td>
</tr>   
<tr>
<th>ปีงบประมาณ</th>
    <td><?php echo $BgtYear;?></td>
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
</table>    
    
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report-list">
      <tr>
        <th style="width:40px;">ลำดับ</th>
        <th>ชื่อเป้าประสงค์</th>
        </tr>
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
</table>
    
    







<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-report">
  <tr>
  <th colspan="2" style="text-align:left;">ผลการดำเนินงานจำแนกตามโครงการภายใต้แผนงาน</th>
  </tr>
</table>  
  <!--/////////////////////////////////////////////////////////////////////////////-->
  
<?php if($Methods != "quarterly"){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report-list">
    <tr>
      <th rowspan="2" style="width:40px;">ลำดับ</th>
      <th rowspan="2" style="text-align:center;">ชื่อโครงการ</th>
      <th rowspan="2" style="width:80px; text-align:center;">%ค่าน้ำหนัก</th>
      <th colspan="12" style="text-align:center;">%ดำเนินงานโครงการ</th>
      </tr>
    <tr>
      <th style="width:55px; text-align:center;">ต.ค</th>
      <th style="width:55px; text-align:center;">พ.ย</th>
      <th style="width:55px; text-align:center;">ธ.ค</th>
      <th style="width:55px; text-align:center;">ม.ค</th>
      <th style="width:55px; text-align:center;">ก.พ</th>
      <th style="width:55px; text-align:center;">มี.ค</th>
      <th style="width:55px; text-align:center;">เม.ย</th>
      <th style="width:55px; text-align:center;">พ.ค</th>
      <th style="width:55px; text-align:center;">มิ.ย</th>
      <th style="width:55px; text-align:center;">ก.ค</th>
      <th style="width:55px; text-align:center;">ส.ค</th>
      <th style="width:55px; text-align:center;">ก.ย</th>
      </tr>
<?php   
$totalPercentMass=0;
$n=0;
$selectAct = $get->getProjectList($PItemCode);//ltxt::print_r($selectAct);
foreach($selectAct as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;} 
	$totalPercentMass	= $totalPercentMass+$PrjMass;
	
	$prog10 = $get->getPrjResultDetail($PrjCode,10);
	$prog11 = $get->getPrjResultDetail($PrjCode,11);
	$prog12 = $get->getPrjResultDetail($PrjCode,12);
	
	$prog1 = $get->getPrjResultDetail($PrjCode,1);
	$prog2 = $get->getPrjResultDetail($PrjCode,2);
	$prog3 = $get->getPrjResultDetail($PrjCode,3);
	
	$prog4 = $get->getPrjResultDetail($PrjCode,4);
	$prog5 = $get->getPrjResultDetail($PrjCode,5);
	$prog6 = $get->getPrjResultDetail($PrjCode,6);
	
	$prog7 = $get->getPrjResultDetail($PrjCode,7);
	$prog8 = $get->getPrjResultDetail($PrjCode,8);
	$prog9 = $get->getPrjResultDetail($PrjCode,9);
	
	$totalProgressAmass10= $totalProgressAmass10+$prog10[0]->PrjProgressAmass;
	$totalProgressAmass11= $totalProgressAmass11+$prog11[0]->PrjProgressAmass;
	$totalProgressAmass12= $totalProgressAmass12+$prog12[0]->PrjProgressAmass;
	
	$totalProgressAmass1= $totalProgressAmass1+$prog1[0]->PrjProgressAmass;
	$totalProgressAmass2= $totalProgressAmass2+$prog2[0]->PrjProgressAmass;
	$totalProgressAmass3= $totalProgressAmass3+$prog3[0]->PrjProgressAmass;
	
	$totalProgressAmass4 = $totalProgressAmass4+$prog4[0]->PrjProgressAmass;
	$totalProgressAmass5 = $totalProgressAmass5+$prog5[0]->PrjProgressAmass;
	$totalProgressAmass6 = $totalProgressAmass6+$prog6[0]->PrjProgressAmass;
	
	$totalProgressAmass7 = $totalProgressAmass7+$prog7[0]->PrjProgressAmass;
	$totalProgressAmass8 = $totalProgressAmass8+$prog8[0]->PrjProgressAmass;
	$totalProgressAmass9 = $totalProgressAmass9+$prog9[0]->PrjProgressAmass;

?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo ($n+1); ?></td>
      <td><?php echo $PrjName;?></td>
      <td style="text-align:right;"><?php echo ($PrjMass)?(number_format($PrjMass,2)):"-";?></td>
      <td style="text-align:right;"><?php echo ($prog10[0]->PrjProgressAmass)?$prog10[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog10[0]->PrjProgressAmass)?$prog10[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog12[0]->PrjProgressAmass)?$prog12[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog1[0]->PrjProgressAmass)?$prog1[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog2[0]->PrjProgressAmass)?$prog2[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog3[0]->PrjProgressAmass)?$prog3[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog4[0]->PrjProgressAmass)?$prog4[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog5[0]->PrjProgressAmass)?$prog5[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog6[0]->PrjProgressAmass)?$prog6[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog7[0]->PrjProgressAmass)?$prog7[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog8[0]->PrjProgressAmass)?$prog8[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog9[0]->PrjProgressAmass)?$prog9[0]->PrjProgressAmass:'-'; ?></td>
      </tr> 
      
      
      
      
      
<?php	
	$n++;			
}
?>    

  
      <!--%ความก้าวหน้าโครงการ-->
      <tr style="vertical-align:top; color:#990000;">
      <td style="text-align:right;">&nbsp;</td>
      <td style="text-align:right;">%ความก้าวหน้าแผนงาน สช.</td>
      <td style="text-align:right;"><?php echo number_format($totalPercentMass,2); ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass10)?(number_format($totalProgressAmass10,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass11)?(number_format($totalProgressAmass11,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass12)?(number_format($totalProgressAmass12,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass1)?(number_format($totalProgressAmass1,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass2)?(number_format($totalProgressAmass2,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass3)?(number_format($totalProgressAmass3,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass4)?(number_format($totalProgressAmass4,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass5)?(number_format($totalProgressAmass5,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass6)?(number_format($totalProgressAmass6,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass7)?(number_format($totalProgressAmass7,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass8)?(number_format($totalProgressAmass8,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass9)?(number_format($totalProgressAmass9,2)):'-'; ?></td>
      </tr> 
      <!--END %ความก้าวหน้าโครงการ-->

     </table>

<?php } ?>
<?php if($Methods == "quarterly"){ ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report-list">
    <tr>
      <th rowspan="2" style="width:40px;">ลำดับ</th>
      <th rowspan="2" style="text-align:center;">ชื่อโครงการ</th>
      <th rowspan="2" style="width:80px; text-align:center;">%ค่าน้ำหนัก</th>
      <th colspan="4" style="text-align:center;">%ดำเนินงานโครงการ</th>
      </tr>
    <tr>
      <th style="width:100px; text-align:center;">ไตรมาส1</th>
      <th style="width:100px; text-align:center;">ไตรมาส2</th>
      <th style="width:100px; text-align:center;">ไตรมาส3</th>
      <th style="width:100px; text-align:center;">ไตรมาส4</th>
      </tr>
<?php   
$n=0;
$selectAct = $get->getProjectList($PItemCode);//ltxt::print_r($selectAct);
foreach($selectAct as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;} 
	$totalPercentMass	= $totalPercentMass+$PrjMass;
	
	$prog10 = $get->getPrjResultDetail($PrjCode,10);
	$prog11 = $get->getPrjResultDetail($PrjCode,11);
	$prog12 = $get->getPrjResultDetail($PrjCode,12);
	
	$prog1 = $get->getPrjResultDetail($PrjCode,1);
	$prog2 = $get->getPrjResultDetail($PrjCode,2);
	$prog3 = $get->getPrjResultDetail($PrjCode,3);
	
	$prog4 = $get->getPrjResultDetail($PrjCode,4);
	$prog5 = $get->getPrjResultDetail($PrjCode,5);
	$prog6 = $get->getPrjResultDetail($PrjCode,6);
	
	$prog7 = $get->getPrjResultDetail($PrjCode,7);
	$prog8 = $get->getPrjResultDetail($PrjCode,8);
	$prog9 = $get->getPrjResultDetail($PrjCode,9);
	
	$totalProgressAmass10= $totalProgressAmass10+$prog10[0]->PrjProgressAmass;
	$totalProgressAmass11= $totalProgressAmass11+$prog11[0]->PrjProgressAmass;
	$totalProgressAmass12= $totalProgressAmass12+$prog12[0]->PrjProgressAmass;
	
	$totalProgressAmass1= $totalProgressAmass1+$prog1[0]->PrjProgressAmass;
	$totalProgressAmass2= $totalProgressAmass2+$prog2[0]->PrjProgressAmass;
	$totalProgressAmass3= $totalProgressAmass3+$prog3[0]->PrjProgressAmass;
	
	$totalProgressAmass4 = $totalProgressAmass4+$prog4[0]->PrjProgressAmass;
	$totalProgressAmass5 = $totalProgressAmass5+$prog5[0]->PrjProgressAmass;
	$totalProgressAmass6 = $totalProgressAmass6+$prog6[0]->PrjProgressAmass;
	
	$totalProgressAmass7 = $totalProgressAmass7+$prog7[0]->PrjProgressAmass;
	$totalProgressAmass8 = $totalProgressAmass8+$prog8[0]->PrjProgressAmass;
	$totalProgressAmass9 = $totalProgressAmass9+$prog9[0]->PrjProgressAmass;

?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo ($n+1); ?></td>
      <td><?php echo $PrjName;?></td>
      <td style="text-align:right;"><?php echo ($PrjMass)?(number_format($PrjMass,2)):"-";?></td>
      <td style="text-align:right;"><?php echo ($prog12[0]->PrjProgressAmass)?$prog12[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog3[0]->PrjProgressAmass)?$prog3[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog6[0]->PrjProgressAmass)?$prog6[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog9[0]->PrjProgressAmass)?$prog9[0]->PrjProgressAmass:'-'; ?></td>
      </tr> 
      
      
      
      
      
<?php	
	$n++;			
}
?>    

  
      <!--%ความก้าวหน้าโครงการ-->
      <tr style="vertical-align:top; color:#990000;">
      <td style="text-align:right;">&nbsp;</td>
      <td style="text-align:right;">%ความก้าวหน้าแผนงาน สช.</td>
      <td style="text-align:right;"><?php echo number_format($totalPercentMass,2); ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass12)?(number_format($totalProgressAmass12,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass3)?(number_format($totalProgressAmass3,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass6)?(number_format($totalProgressAmass6,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass9)?(number_format($totalProgressAmass9,2)):'-'; ?></td>
      </tr> 
      <!--END %ความก้าวหน้าโครงการ-->

     </table>

<?php } ?>

  <!--/////////////////////////////////////////////////////////////////////////////-->
    




<?php
$noPrj=1;
$dataPrj=$get->getProjectView($PItemCode);//ltxt::print_r($dataPrj);
foreach( $dataPrj as $row ) {
	foreach( $row as $k=>$v){ 
		${$k} = $v;
	}
?>

<div style="padding:3px; padding-top:15px; padding-bottom:10px; margin-top:20px; font-weight:bold; border-top:1px solid #999;"><?php echo $noPrj; ?>) <?php echo $PrjName;?></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report">
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
    <th colspan="2">ผลการดำเนินงานโครงการ</th>
  </tr> 
</table>




  
  <!--/////////////////////////////////////////////////////////////////////////////-->
  
<?php if($PrjMethods == "monthly"){ ?>
<?php
$PrjProgressAmass10 = $get->getPrjProgressAmass($PrjCode,10);
$PrjProgressAmass11 = $get->getPrjProgressAmass($PrjCode,11);
$PrjProgressAmass12 = $get->getPrjProgressAmass($PrjCode,12);
	
$PrjProgressAmass1 = $get->getPrjProgressAmass($PrjCode,1);
$PrjProgressAmass2 = $get->getPrjProgressAmass($PrjCode,2);
$PrjProgressAmass3 = $get->getPrjProgressAmass($PrjCode,3);
	
$PrjProgressAmass4 = $get->getPrjProgressAmass($PrjCode,4);
$PrjProgressAmass5 = $get->getPrjProgressAmass($PrjCode,5);
$PrjProgressAmass6 = $get->getPrjProgressAmass($PrjCode,6);
	
$PrjProgressAmass7 = $get->getPrjProgressAmass($PrjCode,7);
$PrjProgressAmass8 = $get->getPrjProgressAmass($PrjCode,8);
$PrjProgressAmass9 = $get->getPrjProgressAmass($PrjCode,9);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report-list">
    <tr>
      <th style="width:100px; text-align:center;">เดือน</th>
      <th style="width:100px; text-align:center;">%ก้าวหน้าโครงการ</th>
      <th style="width:200px; text-align:center;">ผลดำเนินการ</th>
      <th style="width:200px; text-align:center;">ปัญหา/อุปสรรค</th>
      <th style="width:200px; text-align:center;">ปัจจัยสนับสนุน</th>
      <th style="width:200px; text-align:center;">เอกสารแนบ</th>
      <th style="text-align:center;">หมายเหตุ</th>
    </tr>
<?php 
$detail10 = $get->getPrjResultDetail($PrjCode,10);//ltxt::print_r($detail10);
foreach($detail10 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;">ตุลาคม</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass10)?$PrjProgressAmass10:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
    </tr> 




<?php
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail11 = $get->getPrjResultDetail($PrjCode,11);//ltxt::print_r($detail11);
foreach($detail11 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
      
       <tr style="vertical-align:top;">
      <td style="text-align:center;">พฤศจิกายน</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass11)?$PrjProgressAmass11:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail12 = $get->getPrjResultDetail($PrjCode,12);//ltxt::print_r($detail12);
foreach($detail12 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
      
       <tr style="vertical-align:top;">
      <td style="text-align:center;">ธันวาคม</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass12)?$PrjProgressAmass12:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail1 = $get->getPrjResultDetail($PrjCode,1);//ltxt::print_r($detail);
foreach($detail1 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
          <td style="text-align:center;">มกราคม</td>
          <td style="text-align:center;"><?php echo ($PrjProgressAmass1)?$PrjProgressAmass1:"-";?></td>
          <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
          <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
          <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
          <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
          <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
    </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail2 = $get->getPrjResultDetail($PrjCode,2);//ltxt::print_r($detail);
foreach($detail2 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">กุมภาพันธ์</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass2)?$PrjProgressAmass2:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail3 = $get->getPrjResultDetail($PrjCode,3);//ltxt::print_r($detail);
foreach($detail3 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">มีนาคม</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass3)?$PrjProgressAmass3:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      </tr> 
 
 
<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail4 = $get->getPrjResultDetail($PrjCode,4);//ltxt::print_r($detail);
foreach($detail4 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">เมษายน</td>
          <td style="text-align:center;"><?php echo ($PrjProgressAmass4)?$PrjProgressAmass4:"-";?></td>
          <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
          <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
          <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
          <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
          <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
    </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail5 = $get->getPrjResultDetail($PrjCode,5);//ltxt::print_r($detail);
foreach($detail5 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">พฤษภาคม</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass5)?$PrjProgressAmass5:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail6 = $get->getPrjResultDetail($PrjCode,6);//ltxt::print_r($detail);
foreach($detail6 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">มิถุนายน</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass6)?$PrjProgressAmass6:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail7 = $get->getPrjResultDetail($PrjCode,7);//ltxt::print_r($detail);
foreach($detail7 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
         <td style="text-align:center;">กรกฏาคม</td>
         <td style="text-align:center;"><?php echo ($PrjProgressAmass7)?$PrjProgressAmass7:"-";?></td>
          <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
          <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
          <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
          <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
          <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
    </tr>
       
 
 
 <?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail8 = $get->getPrjResultDetail($PrjCode,8);//ltxt::print_r($detail);
foreach($detail8 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
      
       <tr style="vertical-align:top;">
         <td style="text-align:center;">สิงหาคม</td>
         <td style="text-align:center;"><?php echo ($PrjProgressAmass8)?$PrjProgressAmass8:"-";?></td>
          <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
          <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
          <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
          <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
          <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
    </tr>
       
<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail9 = $get->getPrjResultDetail($PrjCode,9);//ltxt::print_r($detail);
foreach($detail9 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       

       <tr style="vertical-align:top;">
         <td style="text-align:center;">กันยายน</td>
         <td style="text-align:center;"><?php echo ($PrjProgressAmass9)?$PrjProgressAmass9:"-";?></td>
         <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
         <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
         <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
         <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
         <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
    </tr> 
     </table>

<?php } ?>
<?php if($PrjMethods == "quarterly"){ ?>
<?php
$PrjProgressAmass12 = $get->getPrjProgressAmass($PrjCode,12);
$PrjProgressAmass3 = $get->getPrjProgressAmass($PrjCode,3);
$PrjProgressAmass6 = $get->getPrjProgressAmass($PrjCode,6);
$PrjProgressAmass9 = $get->getPrjProgressAmass($PrjCode,9);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report-list">
    <tr>
      <th style="width:100px; text-align:center;">ไตรมาสที่</th>
      <th style="width:100px; text-align:center;">%ก้าวหน้าโครงการ</th>
      <th style="width:200px; text-align:center;">ผลดำเนินการ</th>
      <th style="width:200px; text-align:center;">ปัญหา/อุปสรรค</th>
      <th style="width:200px; text-align:center;">ปัจจัยสนับสนุน</th>
      <th style="width:200px; text-align:center;">เอกสารแนบ</th>
      <th style="text-align:center;">หมายเหตุ</th>
      </tr>
       <?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail12 = $get->getPrjResultDetail($PrjCode,12);//ltxt::print_r($detail12);
foreach($detail12 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
      
       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส1</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass12)?$PrjProgressAmass12:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      </tr> 


       <?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment); 
$detail3 = $get->getPrjResultDetail($PrjCode,3);//ltxt::print_r($detail);
foreach($detail3 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส2</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass3)?$PrjProgressAmass3:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      </tr> 
 
 
       <?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail6 = $get->getPrjResultDetail($PrjCode,6);//ltxt::print_r($detail);
foreach($detail6 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส3</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass6)?$PrjProgressAmass6:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      </tr> 


       <?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment); 
$detail9 = $get->getPrjResultDetail($PrjCode,9);//ltxt::print_r($detail);
foreach($detail9 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       

       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส4</td>
         <td style="text-align:center;"><?php echo ($PrjProgressAmass9)?$PrjProgressAmass9:"-";?></td>
         <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
         <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
         <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
         <td><?php echo $get->getPrjResultDocName($PrjResultId); ?></td>
         <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
        </tr> 
     </table>

<?php 
	$d++;
} 
?>





<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report" >
  <tr>
  <th>ผลการดำเนินงานจำแนกตามกิจกรรมในโครงการ</th>
  </tr>
</table>


  <!--/////////////////////////////////////////////////////////////////////////////-->

<?php if($PrjMethods == "monthly"){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report-list">
    <tr>
      <th rowspan="2" style="width:30px;">ลำดับ</th>
      <th rowspan="2" style="text-align:center;">ชื่อกิจกรรมในโครงการ</th>
      <th rowspan="2" style="width:80px; text-align:center;">%ค่าน้ำหนัก</th>
      <th colspan="12" style="text-align:center;">%ดำเนินงานกิจกรรม</th>
      </tr>
    <tr>
      <th style="width:55px; text-align:center;">ต.ค</th>
      <th style="width:55px; text-align:center;">พ.ย</th>
      <th style="width:55px; text-align:center;">ธ.ค</th>
      <th style="width:55px; text-align:center;">ม.ค</th>
      <th style="width:55px; text-align:center;">ก.พ</th>
      <th style="width:55px; text-align:center;">มี.ค</th>
      <th style="width:55px; text-align:center;">เม.ย</th>
      <th style="width:55px; text-align:center;">พ.ค</th>
      <th style="width:55px; text-align:center;">มิ.ย</th>
      <th style="width:55px; text-align:center;">ก.ค</th>
      <th style="width:55px; text-align:center;">ส.ค</th>
      <th style="width:55px; text-align:center;">ก.ย</th>
      </tr>
<?php   
$totalPercentMass=0;
$n=0;
$selectAct = $get->getProjectDetailActRecordSet($PrjDetailId);//ltxt::print_r($selectAct);
foreach($selectAct as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;} 
	$totalPercentMass	= $totalPercentMass+$PercentMass;
	
	$prog10 = $get->getResultDetail($PrjActCode,10);
	$prog11 = $get->getResultDetail($PrjActCode,11);
	$prog12 = $get->getResultDetail($PrjActCode,12);
	
	$prog1 = $get->getResultDetail($PrjActCode,1);
	$prog2 = $get->getResultDetail($PrjActCode,2);
	$prog3 = $get->getResultDetail($PrjActCode,3);
	
	$prog4 = $get->getResultDetail($PrjActCode,4);
	$prog5 = $get->getResultDetail($PrjActCode,5);
	$prog6 = $get->getResultDetail($PrjActCode,6);
	
	$prog7 = $get->getResultDetail($PrjActCode,7);
	$prog8 = $get->getResultDetail($PrjActCode,8);
	$prog9 = $get->getResultDetail($PrjActCode,9);
	
	$totalProgressAmass10= $totalProgressAmass10+$prog10[0]->ProgressAmass;
	$totalProgressAmass11= $totalProgressAmass11+$prog11[0]->ProgressAmass;
	$totalProgressAmass12= $totalProgressAmass12+$prog12[0]->ProgressAmass;
	
	$totalProgressAmass1= $totalProgressAmass1+$prog1[0]->ProgressAmass;
	$totalProgressAmass2= $totalProgressAmass2+$prog2[0]->ProgressAmass;
	$totalProgressAmass3= $totalProgressAmass3+$prog3[0]->ProgressAmass;
	
	$totalProgressAmass4 = $totalProgressAmass4+$prog4[0]->ProgressAmass;
	$totalProgressAmass5 = $totalProgressAmass5+$prog5[0]->ProgressAmass;
	$totalProgressAmass6 = $totalProgressAmass6+$prog6[0]->ProgressAmass;
	
	$totalProgressAmass7 = $totalProgressAmass7+$prog7[0]->ProgressAmass;
	$totalProgressAmass8 = $totalProgressAmass8+$prog8[0]->ProgressAmass;
	$totalProgressAmass9 = $totalProgressAmass9+$prog9[0]->ProgressAmass;

?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo ($n+1); ?></td>
      <td><?php echo $PrjActName;?></td>
      <td style="text-align:right;"><?php echo ($PercentMass)?(number_format($PercentMass,2)):"-";?></td>
      <td style="text-align:right;"><?php echo ($prog10[0]->Progress)?($prog10[0]->Progress):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog11[0]->Progress)?($prog11[0]->Progress):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog12[0]->Progress)?($prog12[0]->Progress):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog1[0]->Progress)?($prog1[0]->Progress):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog2[0]->Progress)?($prog2[0]->Progress):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog3[0]->Progress)?($prog3[0]->Progress):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog4[0]->Progress)?($prog4[0]->Progress):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog5[0]->Progress)?($prog5[0]->Progress):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog6[0]->Progress)?($prog6[0]->Progress):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog7[0]->Progress)?($prog7[0]->Progress):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog8[0]->Progress)?($prog8[0]->Progress):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog9[0]->Progress)?($prog9[0]->Progress):'-'; ?></td>
      </tr> 
      
      
      
      
      
<?php	
	$n++;			
}
?>    

  
      <!--%ความก้าวหน้าโครงการ-->
      <tr style="vertical-align:top; color:#990000;">
      <td style="text-align:right;">&nbsp;</td>
      <td style="text-align:right;">%ความก้าวหน้าโครงการ</td>
      <td style="text-align:right;"><?php echo number_format($totalPercentMass,2); ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass10)?(number_format($totalProgressAmass10,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass11)?(number_format($totalProgressAmass11,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass12)?(number_format($totalProgressAmass12,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass1)?(number_format($totalProgressAmass1,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass2)?(number_format($totalProgressAmass2,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass3)?(number_format($totalProgressAmass3,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass4)?(number_format($totalProgressAmass4,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass5)?(number_format($totalProgressAmass5,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass6)?(number_format($totalProgressAmass6,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass7)?(number_format($totalProgressAmass7,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass8)?(number_format($totalProgressAmass8,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass9)?(number_format($totalProgressAmass9,2)):'-'; ?></td>
      </tr> 
      <!--END %ความก้าวหน้าโครงการ-->

     </table>

<?php } ?>
<?php if($PrjMethods == "quarterly"){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report-list">
    <tr>
      <th rowspan="2" style="width:30px;">ลำดับ</th>
      <th rowspan="2" style="text-align:center;">ชื่อกิจกรรมในโครงการ</th>
      <th rowspan="2" style="width:80px; text-align:center;">%ค่าน้ำหนัก</th>
      <th colspan="4" style="text-align:center;">%ดำเนินงานกิจกรรม</th>
      </tr>
    <tr>
      <th style="width:100px; text-align:center;">ไตรมาส1</th>
      <th style="width:100px; text-align:center;">ไตรมาส2</th>
      <th style="width:100px; text-align:center;">ไตรมาส3</th>
      <th style="width:100px; text-align:center;">ไตรมาส4</th>
      </tr>
<?php   
$selectAct = $get->getProjectDetailActRecordSet($PrjDetailId);//ltxt::print_r($selectAct);
foreach($selectAct as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;} 
	$totalPercentMass	= $totalPercentMass+$PercentMass;
	
	/*$prog12 = $get->getResultDetail($PrjActCode,12);
	$prog3 = $get->getResultDetail($PrjActCode,3);
	$prog6 = $get->getResultDetail($PrjActCode,6);
	$prog9 = $get->getResultDetail($PrjActCode,9);*/
	
	$totalProgressAmass12= $totalProgressAmass12+$prog12[0]->ProgressAmass;
	$totalProgressAmass3= $totalProgressAmass3+$prog3[0]->ProgressAmass;
	$totalProgressAmass6 = $totalProgressAmass6+$prog6[0]->ProgressAmass;
	$totalProgressAmass9 = $totalProgressAmass9+$prog9[0]->ProgressAmass;

?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo ($n+1); ?></td>
      <td><?php echo $PrjActName;?></td>
      <td style="text-align:right;"><?php echo ($PercentMass)?(number_format($PercentMass,2)):"-";?></td>
      <td style="text-align:right;"><?php echo ($prog12[0]->Progress)?($prog12[0]->Progress):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog3[0]->Progress)?($prog3[0]->Progress):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog6[0]->Progress)?($prog6[0]->Progress):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog9[0]->Progress)?($prog9[0]->Progress):'-'; ?></td>
      </tr> 
      
      
      
      
      
<?php	
	$n++;			
}
?>    

  
      <!--%ความก้าวหน้าโครงการ-->
<!--      <tr style="vertical-align:top; color:#990000;">
      <td style="text-align:right;">&nbsp;</td>
      <td style="text-align:right;">%ความก้าวหน้าโครงการ</td>
      <td style="text-align:right;"><?php //echo number_format($totalPercentMass,2); ?></td>
      <td style="text-align:right;"><?php //echo ($totalProgressAmass12)?(number_format($totalProgressAmass12,2)):'-'; ?></td>
      <td style="text-align:right;"><?php //echo ($totalProgressAmass3)?(number_format($totalProgressAmass3,2)):'-'; ?></td>
      <td style="text-align:right;"><?php //echo ($totalProgressAmass6)?(number_format($totalProgressAmass6,2)):'-'; ?></td>
      <td style="text-align:right;"><?php //echo ($totalProgressAmass9)?(number_format($totalProgressAmass9,2)):'-'; ?></td>
      </tr> 
-->      <!--END %ความก้าวหน้าโครงการ-->

     </table>

<?php } ?>





<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<?php
$dataPrj=$get->getProjectView($PrjDetailId);
foreach( $dataPrj as $row ) {
	foreach( $row as $k=>$v){ 
		${$k} = $v;
	}
}

$p=1;
$selectAct = $get->getProjectDetailActRecordSet($PrjDetailId);//ltxt::print_r($selectAct);
foreach($selectAct as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;} 
?>    
<div style="padding:3px; font-weight:bold;"><u>กิจกรรมที่ <?php echo $p; ?></u>  <?php echo $PrjActName;?></div>


 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->  
 <?php if($PrjMethods == "monthly"){ ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report-list">
    <tr>
      <th style="width:100px; text-align:center;">เดือน</th>
      <th style="width:80px; text-align:center;">%ดำเนินงาน</th>
      <th style="width:100px; text-align:center;">%ก้าวหน้าโครงการ</th>
      <th style="width:200px; text-align:center;">ผลดำเนินการ</th>
      <th style="width:200px; text-align:center;">ปัญหา/อุปสรรค</th>
      <th style="width:200px; text-align:center;">ปัจจัยสนับสนุน</th>
      <th style="width:200px; text-align:center;">เอกสารแนบ</th>
      <th style="text-align:center;">หมายเหตุ</th>
    </tr>
<?php 
$detail10 = $get->getResultDetail($PrjActCode,10);//ltxt::print_r($detail10);
foreach($detail10 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;">ตุลาคม</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td><?php echo $get->getResultDocName($ResultId); ?></td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
    </tr> 


<?php
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail11 = $get->getResultDetail($PrjActCode,11);//ltxt::print_r($detail11);
foreach($detail11 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
      
       <tr style="vertical-align:top;">
      <td style="text-align:center;">พฤศจิกายน</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td><?php echo $get->getResultDocName($ResultId); ?></td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail12 = $get->getResultDetail($PrjActCode,12);//ltxt::print_r($detail12);
foreach($detail12 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
      
       <tr style="vertical-align:top;">
      <td style="text-align:center;">ธันวาคม</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td><?php echo $get->getResultDocName($ResultId); ?></td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail1 = $get->getResultDetail($PrjActCode,1);//ltxt::print_r($detail);
foreach($detail1 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
          <td style="text-align:center;">มกราคม</td>
          <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
          <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
          <td><?php echo ($Result)?$Result:'-';?></td>
          <td><?php echo ($Problem)?$Problem:'-';?></td>
          <td><?php echo ($Factor)?$Factor:'-';?></td>
          <td><?php echo $get->getResultDocName($ResultId); ?></td>
          <td><?php echo ($Comment)?$Comment:'-';?></td>
    </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail2 = $get->getResultDetail($PrjActCode,2);//ltxt::print_r($detail);
foreach($detail2 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">กุมภาพันธ์</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td><?php echo $get->getResultDocName($ResultId); ?></td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail3 = $get->getResultDetail($PrjActCode,3);//ltxt::print_r($detail);
foreach($detail3 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">มีนาคม</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td><?php echo $get->getResultDocName($ResultId); ?></td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 

 
 
<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail4 = $get->getResultDetail($PrjActCode,4);//ltxt::print_r($detail);
foreach($detail4 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">เมษายน</td>
          <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
          <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
          <td><?php echo ($Result)?$Result:'-';?></td>
          <td><?php echo ($Problem)?$Problem:'-';?></td>
          <td><?php echo ($Factor)?$Factor:'-';?></td>
          <td><?php echo $get->getResultDocName($ResultId); ?></td>
          <td><?php echo ($Comment)?$Comment:'-';?></td>
    </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail5 = $get->getResultDetail($PrjActCode,5);//ltxt::print_r($detail);
foreach($detail5 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">พฤษภาคม</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td><?php echo $get->getResultDocName($ResultId); ?></td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail6 = $get->getResultDetail($PrjActCode,6);//ltxt::print_r($detail);
foreach($detail6 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">มิถุนายน</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td><?php echo $get->getResultDocName($ResultId); ?></td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail7 = $get->getResultDetail($PrjActCode,7);//ltxt::print_r($detail);
foreach($detail7 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
         <td style="text-align:center;">กรกฏาคม</td>
         <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
          <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
          <td><?php echo ($Result)?$Result:'-';?></td>
          <td><?php echo ($Problem)?$Problem:'-';?></td>
          <td><?php echo ($Factor)?$Factor:'-';?></td>
          <td><?php echo $get->getResultDocName($ResultId); ?></td>
          <td><?php echo ($Comment)?$Comment:'-';?></td>
    </tr>
       
 
 
 <?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail8 = $get->getResultDetail($PrjActCode,8);//ltxt::print_r($detail);
foreach($detail8 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
      
       <tr style="vertical-align:top;">
         <td style="text-align:center;">สิงหาคม</td>
         <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
          <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
          <td><?php echo ($Result)?$Result:'-';?></td>
          <td><?php echo ($Problem)?$Problem:'-';?></td>
          <td><?php echo ($Factor)?$Factor:'-';?></td>
          <td><?php echo $get->getResultDocName($ResultId); ?></td>
          <td><?php echo ($Comment)?$Comment:'-';?></td>
    </tr>
       
<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail9 = $get->getResultDetail($PrjActCode,9);//ltxt::print_r($detail);
foreach($detail9 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       

       <tr style="vertical-align:top;">
         <td style="text-align:center;">กันยายน</td>
         <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
         <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
         <td><?php echo ($Result)?$Result:'-';?></td>
         <td><?php echo ($Problem)?$Problem:'-';?></td>
         <td><?php echo ($Factor)?$Factor:'-';?></td>
         <td><?php echo $get->getResultDocName($ResultId); ?></td>
         <td><?php echo ($Comment)?$Comment:'-';?></td>
    </tr> 
  </table>

<?php } ?>
<?php if($PrjMethods == "quarterly"){ ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report-list">
    <tr>
      <th style="width:100px; text-align:center;">ไตรมาสที่</th>
      <th style="width:80px; text-align:center;">%ดำเนินงาน</th>
      <th style="width:100px; text-align:center;">%ก้าวหน้าโครงการ</th>
      <th style="width:200px; text-align:center;">ผลดำเนินการ</th>
      <th style="width:200px; text-align:center;">ปัญหา/อุปสรรค</th>
      <th style="width:200px; text-align:center;">ปัจจัยสนับสนุน</th>
      <th style="width:200px; text-align:center;">เอกสารแนบ</th>
      <th style="text-align:center;">หมายเหตุ</th>
    </tr>
       <?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail12 = $get->getResultDetail($PrjActCode,12);//ltxt::print_r($detail12);
foreach($detail12 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
      
       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส1</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td><?php echo $get->getResultDocName($ResultId); ?></td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


       <?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment); 
$detail3 = $get->getResultDetail($PrjActCode,3);//ltxt::print_r($detail);
foreach($detail3 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส2</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td><?php echo $get->getResultDocName($ResultId); ?></td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 
 
 
       <?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail6 = $get->getResultDetail($PrjActCode,6);//ltxt::print_r($detail);
foreach($detail6 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส3</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td><?php echo $get->getResultDocName($ResultId); ?></td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


       <?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment); 
$detail9 = $get->getResultDetail($PrjActCode,9);//ltxt::print_r($detail);
foreach($detail9 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       

       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส4</td>
         <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
         <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
         <td><?php echo ($Result)?$Result:'-';?></td>
         <td><?php echo ($Problem)?$Problem:'-';?></td>
         <td><?php echo ($Factor)?$Factor:'-';?></td>
         <td><?php echo $get->getResultDocName($ResultId); ?></td>
         <td><?php echo ($Comment)?$Comment:'-';?></td>
    </tr> 
  </table>

<?php } ?>
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////--> 



<?php	
	$p++;			
}
?>  

<!--//////////////////////////////////////////////////////////////////////////////-->




 
 
 <?php 
 	$noPrj++;
 } //end foreach project 
 ?>







      

<div style="text-align:right; padding:4px; margin-top:10px;"><a href="#" class="icon-up">กลับสู่ด้านบน</a></div>
<?php }else{ ?>
<div class="nullDataList">กรุณาระบุเงื่อนไขในการแสดงรายงาน</div>
<?php } ?>
</div><!--<div id="c-report">-->
<br />
<br />
<br />