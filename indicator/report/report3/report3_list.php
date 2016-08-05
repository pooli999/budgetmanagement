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
		'text' => 'รายงานรายละเอียดตัวชี้วัดโครงการประจำปี',
	),
));




?>

<script language="javascript" type="text/javascript">
function printDocument(){
	window.location.href="?mod=<?php echo LURL::dotPage('report3_print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('report3_excel')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToWord(){
	window.location.href="?mod=<?php echo LURL::dotPage('report3_word')?>&format=raw<?php echo $get->getQueryString(); ?>";
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
		  url: "?mod=<?php echo LURL::dotPage('report3_action');?>",		   
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
		  url: "?mod=<?php echo LURL::dotPage('report3_action');?>",		   
		  data: "action=getprjlist&BgtYear="+BgtYear+"&PItemCode="+PItemCode,
		  success: function(msg){
			JQ("#prj").html(msg);
		  }
	});
	loadPrjInd(0);

}

function loadPrjInd(PrjDetailId){
	document.getElementById('ind').innerHTML='<span class="icon-load">กรุณารอสักครู่</span>';
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('report3_action');?>",		   
		  data: "action=getprjindlist&PrjDetailId="+PrjDetailId,
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
  <div class="sysname">รายงานรายละเอียดตัวชี้วัดโครงการประจำปี</div>
  <div class="sysdetail">&nbsp;</div>
</div>





<form id="adminForm" name="adminForm" method="get" onSubmit="loadPage(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="mod" id="mod" value="<?php echo LURL::dotPage('report3_list');?>" />
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
	<th>โครงการ</th>
	<td class="require">&nbsp;</td>
	<td><span id="prj"><?php echo $get->getProjectList(); ?></span></td>
</tr>
<tr>
	<th>ชื่อตัวชี้วัด</th>
	<td>&nbsp;</td>
	<td><span id="ind"><?php echo $get->getIndPrjList(); ?></span></td>
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
	<td><?php echo $get->getPrjName($_REQUEST["PrjDetailId"]); ?></td>
</tr>
<?php } ?>

<?php if($_REQUEST["IndicatorCode"]){ ?>
<tr style="vertical-align:top;">
	<th>ชื่อตัวชี้วัด</th>
	<td>&nbsp;</td>
	<td><?php echo $get->getIndPrjName($_REQUEST["IndicatorCode"]); ?></td>
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
$indicator = $get->getIndDetail();//ltxt::print_r($indicator);
foreach($indicator as $in){
	foreach( $in as $a=>$q){ ${$a} = $q;}

		$datas = $get->getDetailPrj($PrjDetailId);//ltxt::print_r($datas);
		foreach($datas as $actdatas){
			foreach($actdatas as $k=>$v){
				${$k} = $v;
			}
		}
?>



<div class="topic-report" style="background-color:#EEE;">ตัวชี้วัดโครงการของ สช. ประจำปี <?php echo $_REQUEST["BgtYear"]; ?></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report">
<tr>
    <th>รหัสตัวชี้วัด</th>
    <td style="font-weight:bold;"><?php echo $IndicatorCode; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>ชื่อตัวชี้วัด</th>
    <td><?php echo $IndicatorName; ?></td>
</tr>
     <tr>
       <th >ปีงบประมาณ</th>
       <td colspan="2"><?php echo $BgtYear;?></td>
     </tr>
     <tr>
       <th>ภายใต้แผนงาน</th>
       <td colspan="2" id="plan">(<?php echo $PItemCode; ?>)&nbsp;<?php echo $get->getPItemCode($PItemCode);?></td>
     </tr> 
      <tr>
        <th>ชื่อโครงการ</th>
        <td colspan="2" id="prj">(<?php echo $PrjCode; ?>)&nbsp;<?php echo $PrjName;?></td>
      </tr>
        <tr>
        <th>ระยะเวลาการดำเนินโครงการ</th>
        <td colspan="2"><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td>
      </tr>
         <tr>
       <th valign="top">หน่วยงานที่รับผิดชอบ</th>
       <td colspan="2"><?php echo $get->getOrgName($BgtYear, $OrganizeCode);?></td>
     </tr>
    <tr>
        <th valign="top">ผู้รับผิดชอบโครงการ</th>
       <td colspan="2">
       <?php 
        $TaskPerson = $get->getTaskPerson($PrjId); 
		if(!$TaskPerson){ echo '<span style="color:#999;">-ไม่ระบุ-</span>'; }
       echo "<ul>";
       foreach($TaskPerson as $rRName){
            foreach($rRName as $k=>$v){
                ${$k} = $v;
            }
            echo "<li>";
            echo $Name;
            if($ResultStatus == 'Y'){echo " (ผู้รายงาน)";}
            echo "</li>";
       }
       echo "</ul>";
        
       ?>
       </td>
    </tr>
<tr style="vertical-align:top;">
    <th>คำอธิบายตัวชี้วัด</th>
    <td><?php echo ($IndicatorDetail)?$IndicatorDetail:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>วัตถุประสงค์ตัวชี้วัด</th>
    <td><?php echo ($IndicatorPurpose)?$IndicatorPurpose:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>ผู้รายงานผลตัวชี้วัด</th>
    <td>
<?php 
$TaskPersonSelect = $get->getTaskIndPerson($IndicatorCode); 
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
    <td><?php echo ($Calculate)?$Calculate:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th colspan="2">เกณฑ์การให้คะแนน</th>
</tr>
</table>

<?php if($CriterionType =="quantity"){?>
<table width="100%" border="0" class="tbl-report-list" cellspacing="0" cellpadding="0">
    <tr>
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
  

<?php if($CriterionType =="quality"){?>
<table width="100%" border="0" class="tbl-report-list" cellspacing="0" cellpadding="0">
    <tr>
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
      <th colspan="2" rowspan="2" align="center">ค่าเป้าหมาย<br />
        <span style="font-weight:normal;">(<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</span></th>
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
    <td align="center" >แผน</td>
    <td align="center" ><?php echo $QTTGPlan; ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,10); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,11); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,12); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,1); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,2); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,3); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,4); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,5); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,6); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,7); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,8); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,9); ?></td>
  </tr>
  <tr>
    <td align="center" >ผล</td>
    <td align="center" ><?php echo $QTTGResult; ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,10); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,11); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,12); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,1); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,2); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,3); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,4); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,5); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,6); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,7); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,8); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,9); ?></td>
  </tr>
  <?php } ?>
  <?php if($CriterionType =="quality"){?>
  <tr>
    <td align="center" >แผน</td>
    <td align="center" ><?php echo $QLTGPlan; ?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,10);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,11);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,12);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,1);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,2);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,3);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,4);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,5);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,6);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,7);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,8);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,9);?></td>
  </tr>
  <tr>
    <td align="center" >ผล</td>
    <td align="center" ><?php echo $QLTGResult; ?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,10);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,11);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,12);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,1);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,2);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,3);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,4);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,5);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,6);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,7);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,8);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,9);?></td>
  </tr>
  <?php } ?>
  <?php 
$MTargetScore10 = $get->getMTargetScore($IndicatorCode,10);
$MTargetScore11 = $get->getMTargetScore($IndicatorCode,11);
$MTargetScore12 = $get->getMTargetScore($IndicatorCode,12);

$MTargetScore1 = $get->getMTargetScore($IndicatorCode,1);
$MTargetScore2 = $get->getMTargetScore($IndicatorCode,2);
$MTargetScore3 = $get->getMTargetScore($IndicatorCode,3);

$MTargetScore4 = $get->getMTargetScore($IndicatorCode,4);
$MTargetScore5 = $get->getMTargetScore($IndicatorCode,5);
$MTargetScore6 = $get->getMTargetScore($IndicatorCode,6);

$MTargetScore7 = $get->getMTargetScore($IndicatorCode,7);
$MTargetScore8 = $get->getMTargetScore($IndicatorCode,8);
$MTargetScore9 = $get->getMTargetScore($IndicatorCode,9);
?>
  <tr style="vertical-align:top;">
    <td align="center" >คะแนนที่ได้</td>
    <td align="center" ><?php
if($TGScore){
    echo '<span class="icon-col'.$TGScore.'">&nbsp;</span><br><span> ('.$TGScore.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore10 >= 0){
	echo '<span class="icon-col'.$MTargetScore10.'">&nbsp;</span><br><span> ('.$MTargetScore10.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore11 >= 0){
    echo '<span class="icon-col'.$MTargetScore11.'">&nbsp;</span><br><span> ('.$MTargetScore11.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore12 >= 0){
    echo '<span class="icon-col'.$MTargetScore12.'">&nbsp;</span><br><span> ('.$MTargetScore12.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore1 >= 0){
    echo '<span class="icon-col'.$MTargetScore1.'">&nbsp;</span><br><span> ('.$MTargetScore1.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore2 >= 0){
    echo '<span class="icon-col'.$MTargetScore2.'">&nbsp;</span><br><span> ('.$MTargetScore2.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore3 >= 0){
    echo '<span class="icon-col'.$MTargetScore3.'">&nbsp;</span><br><span> ('.$MTargetScore3.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore4 >= 0){
    echo '<span class="icon-col'.$MTargetScore4.'">&nbsp;</span><br><span> ('.$MTargetScore4.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore5 >= 0){
    echo '<span class="icon-col'.$MTargetScore5.'">&nbsp;</span><br><span> ('.$MTargetScore5.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore6 >= 0){
    echo '<span class="icon-col'.$MTargetScore6.'">&nbsp;</span><br><span> ('.$MTargetScore6.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore7 >= 0){
    echo '<span class="icon-col'.$MTargetScore7.'">&nbsp;</span><br><span> ('.$MTargetScore7.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore8 >= 0){
    echo '<span class="icon-col'.$MTargetScore8.'">&nbsp;</span><br><span> ('.$MTargetScore8.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore9 >= 0){
    echo '<span class="icon-col'.$MTargetScore9.'">&nbsp;</span><br><span> ('.$MTargetScore9.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
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