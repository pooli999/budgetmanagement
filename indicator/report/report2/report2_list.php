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
		'text' => 'รายงานรายละเอียดตัวชี้วัดแผนงานประจำปี',
	),
));




?>

<script language="javascript" type="text/javascript">
function printDocument(){
	window.location.href="?mod=<?php echo LURL::dotPage('report2_print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('report2_excel')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToWord(){
	window.location.href="?mod=<?php echo LURL::dotPage('report2_word')?>&format=raw<?php echo $get->getQueryString(); ?>";
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
		  url: "?mod=<?php echo LURL::dotPage('report2_action');?>",		   
		  data: "action=getplanlist&BgtYear="+BgtYear,
		  success: function(msg){
			JQ("#plan").html(msg);
		  }
	});
	loadInd(0);
}


function loadInd(PItemCode){
	document.getElementById('ind').innerHTML='<span class="icon-load">กรุณารอสักครู่</span>';
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('report2_action');?>",		   
		  data: "action=getindlist&PItemCode="+PItemCode,
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
	var BgtYear = JQ("#BgtYear").val();//alert(BgtYear);
	if(BgtYear==0){
		alert('กรุณาระบุปีงบประมาณ');
		JQ("#BgtYear").focus();
		return false;
	}
	/*var PItemCode = JQ("#PItemCode").val();//alert(ScreenLevel);
	if(PItemCode==0){
		alert('กรุณาระบุชื่อแผนงาน สช.');
		JQ("#PItemCode").focus();
		return false;
	}*/
	return true;
}



</script>

<div class="sysinfo">
  <div class="sysname">รายงานรายละเอียดตัวชี้วัดแผนงานประจำปี</div>
  <div class="sysdetail">&nbsp;</div>
</div>



<form id="adminForm" name="adminForm" method="get" onSubmit="loadPage(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="mod" id="mod" value="<?php echo LURL::dotPage('report2_list');?>" />
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
	<td class="require">&nbsp;</td>
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


<?php if($_REQUEST["PIndCode"]){ ?>
<tr style="vertical-align:top;">
	<th>ชื่อตัวชี้วัด</th>
	<td>&nbsp;</td>
	<td><?php echo $get->getIndName($_REQUEST["PIndCode"]); ?></td>
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


$indicator = $get->getPlanIndDetail();//ltxt::print_r($dataPlan);
foreach($indicator as $in){
	foreach( $in as $a=>$q){ ${$a} = $q;}
	
	$datas = $get->getPItemDetail($PItemCode);//ltxt::print_r($datas);
	foreach($datas as $r){
		foreach( $r as $k=>$v){ ${$k} = $v;}
	}

?>

<div class="topic-report" style="background-color:#EEE;">ตัวชี้วัดแผนงานของ สช. ประจำปี <?php echo $_REQUEST["BgtYear"]; ?></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report">
<tr>
    <th>รหัสตัวชี้วัด</th>
    <td style="font-weight:bold;"><?php echo $PIndCode; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>ชื่อตัวชี้วัด</th>
    <td><?php echo $PIndName; ?></td>
</tr>
  <tr>
    <th>ปีงบประมาณ</th>
    <td><?php echo $BgtYear; ?></td>
  </tr>
    <tr>
        <th>ชื่อแผนงาน</th>
        <td>(<?php echo $PItemCode; ?>) <?php echo $PItemName;?></td>
    </tr>

<?php if($PGroupId == 12){ ?>
<tr>
<th>ภายใต้แผนหลัก</th>
<td><?php echo ($LPlanCode)?($get->getLPlanName($LPlanCode)):('<span style="color:#999;">-ไม่ระบุ-</span>'); ?></td>
</tr>
<?php } ?>

    
    
<tr style="vertical-align:top;">
    <th>คำอธิบายตัวชี้วัด</th>
    <td><?php echo ($PIndDetail)?$PIndDetail:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>วัตถุประสงค์ตัวชี้วัด</th>
    <td><?php echo ($PIndPurpose)?$PIndPurpose:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>ผู้รายงานผลตัวชี้วัด</th>
    <td>
<?php 
$TaskPersonSelect = $get->getPlanTaskPerson($PIndCode); 
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
    <td><?php echo ($UnitID)?($get->getUnitName($UnitID)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
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
    <td><?php echo ($PIndCalculate)?$PIndCalculate:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th colspan="2">เกณฑ์การให้คะแนน</th>
</tr>

</table>


  
  
  
  
  


<?php if($CriterionType=="quantity"){ ?>
<table width="100%" border="0" class="tbl-report-list" cellspacing="0" cellpadding="0">
    <tr style="vertical-align:top;">
      <th style="width:200px;">ค่าเป้าหมาย <br />(<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</th>
      <th style="width:200px;">คะแนนที่ได้ตามช่วง<br />ของค่าเป้าหมาย</th>
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
  

<?php if($CriterionType=="quality"){ ?>
<table width="100%" border="0" class="tbl-report-list" cellspacing="0" cellpadding="0">
    <tr style="vertical-align:top;">
      <th style="width:150px;">ค่าเป้าหมาย <br />(<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</th>
      <th style="width:200px;">คะแนนที่ได้ตามช่วง<br />ของค่าเป้าหมาย</th>
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



<table width="100%" border="0" class="tbl-report-list"  cellspacing="0" cellpadding="0">
<thead>
  <tr>
    <th colspan="2" rowspan="2" align="center">ค่าเป้าหมาย<br /> <span style="font-weight:normal;">(<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</span></th>
    <th colspan="3" align="center">ไตรมาสที่ 1</th>
    <th colspan="3" align="center">ไตรมาสที่ 2</th>
    <th colspan="3" align="center">ไตรมาสที่ 3</th>
    <th colspan="3" align="center">ไตรมาสที่ 4</th>
    </tr>
  <tr>
    <th align="center" style="width:75px">ต.ค</th>
    <th align="center" style="width:75px">พ.ย</th>
    <th align="center" style="width:75px">ธ.ค</th>
    <th align="center" style="width:75px">ม.ค</th>
    <th align="center" style="width:75px">ก.พ</th>
    <th align="center" style="width:75px">มี.ค</th>
    <th align="center" style="width:75px">เม.ย</th>
    <th align="center" style="width:75px">พ.ค</th>
    <th align="center" style="width:75px">มิ.ย</th>
    <th align="center" style="width:75px">ก.ค</th>
    <th align="center" style="width:75px">ส.ค</th>
    <th align="center" style="width:75px">ก.ย</th>
    </tr>
</thead>

<?php if($CriterionType =="quantity"){?>
  <tr>
    <td align="center" >ตามแผน</td>
    <td align="center" ><?php echo $PIndQTTGPlan; ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,10); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,11); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,12); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,1); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,2); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,3); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,4); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,5); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,6); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,7); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,8); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,9); ?></td>
    </tr>
      <tr>
    <td align="center" >ตามผล</td>
    <td align="center" ><?php echo $PIndQTTGResult; ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,10); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,11); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,12); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,1); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,2); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,3); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,4); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,5); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,6); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,7); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,8); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,9); ?></td>
    </tr>
 <?php } ?> 
 
 <?php if($CriterionType =="quality"){?>
  <tr>
    <td align="center" >ตามแผน</td>
    <td align="center" ><?php echo $PIndQLTGPlan; ?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,10); ?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,11);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,12);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,1);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,2);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,3);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,4);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,5);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,6);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,7);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,8);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,9);?></td>
    </tr>
      <tr>
    <td align="center" >ตามผล</td>
    <td align="center" ><?php echo ($PIndQLTGResult)?$PIndQLTGResult:"-";?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,10);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,11);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,12);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,1);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,2);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,3);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,4);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,5);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,6);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,7);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,8);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,9);?></td>
    </tr>
 <?php } ?> 


<?php 
$MTargetScore10 = $get->getPlanMTargetScore($PIndCode,10);
$MTargetScore11 = $get->getPlanMTargetScore($PIndCode,11);
$MTargetScore12 = $get->getPlanMTargetScore($PIndCode,12);

$MTargetScore1 = $get->getPlanMTargetScore($PIndCode,1);
$MTargetScore2 = $get->getPlanMTargetScore($PIndCode,2);
$MTargetScore3 = $get->getPlanMTargetScore($PIndCode,3);

$MTargetScore4 = $get->getPlanMTargetScore($PIndCode,4);
$MTargetScore5 = $get->getPlanMTargetScore($PIndCode,5);
$MTargetScore6 = $get->getPlanMTargetScore($PIndCode,6);

$MTargetScore7 = $get->getPlanMTargetScore($PIndCode,7);
$MTargetScore8 = $get->getPlanMTargetScore($PIndCode,8);
$MTargetScore9 = $get->getPlanMTargetScore($PIndCode,9);
?> 
   <tr style="vertical-align:top;">
    <td align="center" >คะแนนที่ได้</td>
    <td align="center" >
<?php
if($PIndTGScore){
	 echo '<span class="icon-col'.$PIndTGScore.'">&nbsp;</span><br><span> ('.$PIndTGScore.' คะแนน)</span>';
}else{
	echo '-';
}
?>
    </td>
    <td align="center">
<?php
if($MTargetScore10 >= 0){
    echo '<span class="icon-col'.$MTargetScore10.'">&nbsp;</span><br><span> ('.$MTargetScore10.' คะแนน)</span>';
}else{
	echo '-';
}
?>
    </td>
    <td align="center">
<?php
if($MTargetScore11 >= 0){
    echo '<span class="icon-col'.$MTargetScore11.'">&nbsp;</span><br><span> ('.$MTargetScore11.' คะแนน)</span>';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore12 >= 0){
    echo '<span class="icon-col'.$MTargetScore12.'">&nbsp;</span><br><span> ('.$MTargetScore12.' คะแนน)</span>';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore1 >= 0){
    echo '<span class="icon-col'.$MTargetScore1.'">&nbsp;</span><br><span> ('.$MTargetScore1.' คะแนน)</span>';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore2 >= 0){
    echo '<span class="icon-col'.$MTargetScore2.'">&nbsp;</span><br><span> ('.$MTargetScore2.' คะแนน)</span>';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore3 >= 0){
    echo '<span class="icon-col'.$MTargetScore3.'">&nbsp;</span><br><span> ('.$MTargetScore3.' คะแนน)</span>';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore4 >= 0){
    echo '<span class="icon-col'.$MTargetScore4.'">&nbsp;</span><br><span> ('.$MTargetScore4.' คะแนน)</span>';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore5 >= 0){
    echo '<span class="icon-col'.$MTargetScore5.'">&nbsp;</span><br><span> ('.$MTargetScore5.' คะแนน)</span>';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore6 >= 0){
    echo '<span class="icon-col'.$MTargetScore6.'">&nbsp;</span><br><span> ('.$MTargetScore6.' คะแนน)</span>';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore7 >= 0){
    echo '<span class="icon-col'.$MTargetScore7.'">&nbsp;</span><br><span> ('.$MTargetScore7.' คะแนน)</span>';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore8 >= 0){
    echo '<span class="icon-col'.$MTargetScore8.'">&nbsp;</span><br><span> ('.$MTargetScore8.' คะแนน)</span>';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore9 >= 0){
    echo '<span class="icon-col'.$MTargetScore9.'">&nbsp;</span><br><span> ('.$MTargetScore9.' คะแนน)</span>';
}else{
	echo '-';
}
?>
    </td>

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
