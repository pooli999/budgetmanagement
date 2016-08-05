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
		'text' => 'รายงานรายละเอียดตัวชี้วัดแผนงานหลัก',
	),
));


?>

<script language="javascript" type="text/javascript">
function printDocument(){
	window.location.href="?mod=<?php echo LURL::dotPage('report1_print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('report1_excel')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToWord(){
	window.location.href="?mod=<?php echo LURL::dotPage('report1_word')?>&format=raw<?php echo $get->getQueryString(); ?>";
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

function loadPlan(PLongCode){
	document.getElementById('plan').innerHTML='<span class="icon-load">กรุณารอสักครู่</span>';
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('report1_action');?>",		   
		  data: "action=getplanlist&PLongCode="+PLongCode,
		  success: function(msg){
			JQ("#plan").html(msg);
		  }
	});
	loadInd(0);
}


function loadInd(LPlanCode){
	document.getElementById('ind').innerHTML='<span class="icon-load">กรุณารอสักครู่</span>';
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('report1_action');?>",		   
		  data: "action=getindlist&LPlanCode="+LPlanCode,
		  success: function(msg){
			JQ("#ind").html(msg);
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
	var PLongCode = JQ("#PLongCode").val();
	if(PLongCode==0){
		alert('กรุณาระบุชื่อแผนหลัก');
		JQ("#PLongCode").focus();
		return false;
	}
	var LPlanCode = JQ("#LPlanCode").val();
	if(LPlanCode==0){
		alert('กรุณาระบุชื่อแผนงาน สช.');
		JQ("#LPlanCode").focus();
		return false;
	}
	return true;
}



</script>


<div class="sysinfo">
  <div class="sysname">รายงานรายละเอียดตัวชี้วัดแผนงานหลัก</div>
  <div class="sysdetail">&nbsp;</div>
</div>


<form id="adminForm" name="adminForm" method="get" onSubmit="loadPage(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="mod" id="mod" value="<?php echo LURL::dotPage('report1_list');?>" />
<input type="hidden" name="showResult" id="showResult" value="yes" />
<div id="boxSearch" class="boxsearch" style="display:block; margin-right:0px; margin-left:0px;">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="5" class="tbl-search">
<tbody id="search" <?php if($_REQUEST["showResult"]=="yes"){ ?> style="display:none;" <?php } ?>>
<tr>
	<td colspan="3" style="font-weight:bold; color:#990000; text-decoration:underline;">ระบุเงื่อนไขการแสดงรายงาน</td>
</tr>
<tr>
	<th style="width:100px;">ชื่อแผนหลัก</th>
	<td class="require" style="width:10px;">*</td>
	<td>
	<?php echo $get->getYearMainPlan(ltxt::getVar('PLongCode'),'PLongCode'); ?>
    <span class="hint">(เป็นเงื่อนไขที่จำเป็นต้องระบุทุกครั้ง)</span>
    </td>
</tr>
<tr>
	<th>ชื่อแผนงาน สช.</th>
	<td class="require">*</td>
	<td><span id="plan"><?php echo $get->getPlanItemList(); ?></span></td>
</tr>
<tr>
	<th>ชื่อตัวชี้วัด</th>
	<td>&nbsp;</td>
	<td><span id="ind"><?php echo $get->getIndList(); ?></span></td>
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
<?php if($_REQUEST["PLongCode"]){ ?>
<tr>
	<th>ชื่อแผนหลัก</th>
	<td>&nbsp;</td>
	<td><?php echo $get->getPLongName($_REQUEST["PLongCode"]); ?></td>
</tr>
<?php } ?>
<?php if($_REQUEST["LPlanCode"]){ ?>
<tr>
	<th>ชื่อแผนงาน สช.</th>
	<td>&nbsp;</td>
	<td><?php echo $get->getPItemName($_REQUEST["PLongCode"],$_REQUEST["LPlanCode"]); ?></td>
</tr>
<?php } ?>


<?php if($_REQUEST["LindCode"]){ ?>
<tr style="vertical-align:top;">
	<th>ชื่อตัวชี้วัด</th>
	<td>&nbsp;</td>
	<td><?php echo $get->getIndName($_REQUEST["LindCode"]); ?></td>
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


<?php

$datas = $get->getPlanDetail($_REQUEST["LPlanCode"]);//ltxt::print_r($dataPlan);
foreach($datas as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;}
}


$indicator = $get->getIndDetail($_REQUEST["LindId"]);//ltxt::print_r($indicator);
foreach($indicator as $in){
	foreach( $in as $a=>$q){ ${$a} = $q;}
?>

<div class="topic-report" style="background-color:#EEE;">ตัวชี้วัดแผนหลักของ สช. (<?php echo $PLongName;?>)</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report">
<tr>
    <th>รหัสตัวชี้วัด</th>
    <td style="font-weight:bold;"><?php echo $LindCode; ?><input name="LindCode" type="hidden"  id="LindCode" value="<?php echo $LindCode;?>" /></td>
</tr>
<tr style="vertical-align:top;">
    <th>ชื่อตัวชี้วัด</th>
    <td><?php echo $LindName; ?></td>
</tr>
    <tr>
        <th>ชื่อแผนหลัก</th>
        <td><?php echo $PLongName;?></td>
    </tr>
    <tr style="vertical-align:top;">
        <th valign="top">รายละเอียด</th>
        <td><?php echo ($PLongDetail)?$PLongDetail:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
    </tr>
    <tr>
        <th>ปีที่ตั้งแผนหลัก</th>
        <td><?php echo $PLongYear;?><b>-</b><?php echo $PLongYearEnd;?>&nbsp;(ต่อเนื่อง <?php echo $PLongAmount;?> ปี)</td>
    </tr>
    <tr>
        <th>ชื่อแผนงาน</th>
        <td>(<?php echo $LPlanCode;?>) <?php echo $LPlanName;?></td>
    </tr>
<tr style="vertical-align:top;">
    <th>คำอธิบายตัวชี้วัด</th>
    <td><?php echo ($LindDetail)?$LindDetail:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>วัตถุประสงค์ตัวชี้วัด</th>
    <td><?php echo ($LindPurpose)?$LindPurpose:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>ผู้รายงานผลตัวชี้วัด</th>
    <td>
<?php 
$TaskPersonSelect = $get->getTaskPerson($LindCode); 
if(count($TaskPersonSelect)){
	echo "<ul>";
	foreach($TaskPersonSelect as $rs){
		foreach($rs as $k=>$v){
			${$k} = $v;
		}
		echo "<li>".$Name."</li>";
	}
	echo "</ul>";
}else{
	echo '<span style="color:#999;">-ไม่ระบุ-</span>';
}
?>
    </td>
</tr>
<tr>
    <th>หน่วยนับ</th>
    <td><?php echo ($UnitID)?($get->getUnitName($UnitID)):"-"; ?></td>
</tr>
<tr>
    <th colspan="2">ข้อมูลเกณฑ์การประเมิน</th>
</tr>
<tr style="vertical-align:top;">
  <th>ประเภทเกณฑ์ประเมิน</th>
  <td>
<?php if($CriterionType=="quantity"){ ?>เชิงปริมาณ<?php } ?>
<?php if($CriterionType=="quality"){ ?>เชิงคุณภาพ<?php } ?>
  </td>
  </tr>
  <tr style="vertical-align:top;">
    <th>อธิบายวิธีการคำนวณ</th>
    <td><?php echo ($LindCalculate)?$LindCalculate:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th colspan="2">เกณฑ์การให้คะแนน</th>
</tr>
</table>


  
  
  
  
  


<?php if($CriterionType =="quantity"){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report-list">
    <tr style="vertical-align:top;">
      <th style="width:200px;">ค่าเป้าหมาย (<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</th>
      <th style="width:200px;">คะแนนที่ได้ตามช่วงของค่าเป้าหมาย</th>
      <th>คำอธิบาย</th>
      </tr>
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $QTMinScore0; ?><b> - </b><?php echo $QTMaxScore0; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
        <?php
switch($Score0){
	case 0:
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
	break;
}
?></td>
      <td><?php echo $DetailScore0; ?></td>
      </tr>
    <tr style="vertical-align:top;">
       <td style="text-align:center;"><?php echo $QTMinScore1; ?><b> - </b><?php echo $QTMaxScore1; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score1){
	case 0:
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
	break;
}
?></td>
      <td><?php echo $DetailScore1; ?></td>
      </tr>
    <tr style="vertical-align:top;">
       <td style="text-align:center;"><?php echo $QTMinScore2; ?><b> - </b><?php echo $QTMaxScore2; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score2){
	case 0:
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
	break;
}
?></td>
      <td><?php echo $DetailScore2; ?></td>
      </tr>      
    <tr style="vertical-align:top;">
       <td style="text-align:center;"><?php echo $QTMinScore3; ?><b> - </b><?php echo $QTMaxScore3; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score3){
	case 0:
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
	break;
}
?></td>
      <td><?php echo $DetailScore3; ?></td>
      </tr>      
      <tr style="vertical-align:top;">
       <td style="text-align:center;"><?php echo $QTMinScore4; ?><b> - </b><?php echo $QTMaxScore4; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score4){
	case 0:
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
	break;
}
?></td>
      <td><?php echo $DetailScore4; ?></td>
      </tr>    
     <tr style="vertical-align:top;">
       <td style="text-align:center;"><?php echo $QTMinScore5; ?><b> - </b><?php echo $QTMaxScore5; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score5){
	case 0:
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
	break;
}
?></td>
      <td><?php echo $DetailScore5; ?></td>
      </tr>     
  </table>  
<?php } ?>
<!--End  id="tbl-quantity"-->
  

<?php if($CriterionType =="quality"){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report-list">
    <tr style="vertical-align:top;">
      <th style="width:150px;">ค่าเป้าหมาย (<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</th>
      <th style="width:200px;">คะแนนที่ได้ตามช่วงของค่าเป้าหมาย</th>
      <th>คำอธิบาย</th>
      </tr>
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $TQLScore0; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
        <?php
switch($Score0){
	case 0:
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
	break;
}
?></td>
      <td><?php echo $DetailScore0; ?></td>
      </tr>
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $TQLScore1; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score1){
	case 0:
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
	break;
}
?></td>
      <td><?php echo $DetailScore1; ?></td>
      </tr>
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $TQLScore1; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score2){
	case 0:
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
	break;
}
?></td>
      <td><?php echo $DetailScore2; ?></td>
      </tr>      
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $TQLScore3; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score3){
	case 0:
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
	break;
}
?></td>
      <td><?php echo $DetailScore3; ?></td>
      </tr>      
      <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $TQLScore4; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score4){
	case 0:
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
	break;
}
?></td>
      <td><?php echo $DetailScore4; ?></td>
      </tr>    
     <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $TQLScore5; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score5){
	case 0:
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
	break;
}
?></td>
      <td><?php echo $DetailScore5; ?></td>
      </tr>     
  </table>  
<?php } ?>
<!--End  id="tbl-quality"-->


  





<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report">
<tr>
	<th colspan="2" style="width:100%;">แผนการดำเนินการ/ค่าเป้าหมายรายเดือน-ไตรมาส</th>
</tr>
</table>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report-list">
  <tr>
    <th rowspan="2" style="width:80px;">&nbsp;</th>
    <th rowspan="2">ค่าเป้าหมาย<br />
      <span style="font-weight:normal;">(<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</span></th>
    <th colspan="<?php echo ($PLongAmount); ?>" style="text-align:center;">ค่าเป้าหมายแจกแจงตามปีงบประมาณ</th>
  </tr>
  <tr>
    <th style="text-align:center;">ปี <?php echo $PLongYear; ?>
      <input type="hidden" name="BgtYear_"  id="BgtYear_" value="<?php echo $PLongYear; ?>" /></th>
    <?php 
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
	?>
    <th style="text-align:center;">ปี <?php echo $initYear; ?>
      <input type="hidden" name="BgtYear_<?php echo $y; ?>"  id="BgtYear_<?php echo $y; ?>2" value="<?php echo $initYear; ?>" /></th>
    <?php 
		$initYear++;
	} 
	?>
  </tr>
  <?php if($CriterionType =="quantity"){?>
  <tr>
    <td style="text-align:center;">ตามแผน</td>
    <td style="text-align:center;"><?php echo $LindQTTGPlan; ?></td>
    <td style="text-align:center;"><?php echo $get->getQTIndicatorYear($LindCode,$PLongYear); ?></td>
    <?php 
	$initYear = 0;
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
	?>
    <td style="text-align:center;"><?php echo $get->getQTIndicatorYear($LindCode,$initYear); ?></td>
    <?php 
		$initYear++;
	} 
	?>
  </tr>
  <tr>
    <td style="text-align:center;">ตามผล</td>
    <td style="text-align:center;"><?php echo $LindQTTGResult; ?></td>
    <td style="text-align:center;"><?php echo $get->getQTIndicatorYearResult($LindCode,$PLongYear); ?></td>
    <?php 
	$initYear = 0;
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
	?>
    <td style="text-align:center;"><?php echo $get->getQTIndicatorYearResult($LindCode,$initYear); ?></td>
    <?php 
		$initYear++;
	} 
	?>
  </tr>
  <?php } ?>
  <?php if($CriterionType =="quality"){?>
  <tr>
    <td style="text-align:center;">ตามแผน</td>
    <td style="text-align:center;"><?php echo $LindQLTGPlan; ?></td>
    <td style="text-align:center;"><?php echo $get->getQLIndicatorYear($LindCode,$PLongYear);?></td>
    <?php 
	$initYear = 0;
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
	?>
    <td style="text-align:center;"><?php echo $get->getQLIndicatorYear($LindCode,$initYear);?></td>
    <?php 
		$initYear++;
	} 
	?>
  </tr>
  <tr>
    <td style="text-align:center;">ตามผล</td>
    <td style="text-align:center;"><?php echo ($LindQLTGResult)?$LindQLTGResult:'-'; ?></td>
    <td style="text-align:center;"><?php echo $get->getQLIndicatorYearResult($LindCode,$PLongYear); ?></td>
    <?php 
	$initYear = 0;
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
	?>
    <td style="text-align:center;"><?php echo $get->getQLIndicatorYearResult($LindCode,$initYear); ?></td>
    <?php 
		$initYear++;
	} 
	?>
  </tr>
  <?php } ?>
  <tr style="vertical-align:top;">
    <td style="text-align:center;">คะแนนที่ได้</td>
    <td style="text-align:center;">
<?php
if($LindTGScore){
    echo '<span class="icon-col'.$LindTGScore.'"> ('.$LindTGScore.' คะแนน)</span>';
}else{
	echo '-';
}
?>
</td>
    <td style="text-align:center;">
<?php
$YTargetScore = $get->getYTargetScore($PLongYear,$LindCode);
if($YTargetScore >= 0){
    echo '<span class="icon-col'.$YTargetScore.'"> ('.$YTargetScore.' คะแนน)</span>';
}else{
	echo '-';
}
?>
</td>
    <?php 
	unset($YTargetScore);
	$initYear = 0;
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
		$YTargetScore = $get->getYTargetScore($initYear,$LindCode);
	?>
    <td style="text-align:center;"><?php
if($YTargetScore >= 0){
    echo '<span class="icon-col'.$YTargetScore.'"> ('.$YTargetScore.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <?php 
		$initYear++;
		unset($YTargetScore);
	} 
	?>
  </tr>
</table>



<br />
<br />
<?php } //end foreach ?>


<div style="text-align:right; padding:4px; margin-top:10px;"><a href="#" class="icon-up">กลับสู่ด้านบน</a></div>


<?php }else{ ?>
<div class="nullDataList">กรุณาระบุเงื่อนไขในการแสดงรายงาน</div>
<?php } ?>
</div><!--<div id="c-report">-->
<br />
<br />
<br />
