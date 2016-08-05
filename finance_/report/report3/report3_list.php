<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));
$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบงบประมาณการเงิน',
	),
	array(
		'text' => 'พิมพ์รายงาน ',
		'link' => '?mod=finance.report.startup',
	),
	
	array(
		'text' => $MenuName,
	),
));

?>

<script language="javascript" type="text/javascript">
function printDocument(){
	/*window.location.href="?mod=<?php //echo LURL::dotPage('report3_print')?>&format=raw<?php //echo $get->getQueryString(); ?>";*/
}

function saveToExcel(){
	/*window.location.href="?mod=<?php //echo LURL::dotPage('report3_excel')?>&format=raw<?php //echo $get->getQueryString(); ?>";*/
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

function loadStep(BgtYear){
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
	loadPrjAct(0);
}

function loadPrj(){//alert(OrganizeCode);
	document.getElementById('prj').innerHTML='<span class="icon-load">กรุณารอสักครู่</span>';
	var BgtYear = JQ("#BgtYear").val();//alert(BgtYear);
	var ScreenLevel = JQ("#ScreenLevel").val();//alert(ScreenLevel);
	var PItemCode = JQ("#PItemCode").val();//alert(PItemCode);
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('report3_action');?>",		   
		  data: "action=getprjlist&BgtYear="+BgtYear+"&ScreenLevel="+ScreenLevel+"&PItemCode="+PItemCode,
		  success: function(msg){
			JQ("#prj").html(msg);
		  }
	});
	loadPrjAct(0);

}


function loadPrjAct(PrjDetailId){
	document.getElementById('prj-act').innerHTML='<span class="icon-load">กรุณารอสักครู่</span>';
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('report3_action');?>",		   
		  data: "action=getprjactlist&PrjDetailId="+PrjDetailId,
		  success: function(msg){
			JQ("#prj-act").html(msg);
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
	/*var PItemCode = JQ("#PItemCode").val();//alert(BgtYear);
	if(PItemCode==0){
		alert('กรุณาระบุชื่อแผนงาน');
		JQ("#PItemCode").focus();
		return false;
	}
	var PrjDetailId = JQ("#PrjDetailId").val();//alert(BgtYear);
	if(PrjDetailId==0){
		alert('กรุณาระบุชื่อโครงการ');
		JQ("#PrjDetailId").focus();
		return false;
	}*/
	return true;
}



</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>


<style>
.tbl-search th {
	width:200px; 
	text-align:left; 
	font-weight:bold;
	/*border-bottom:1px dotted #999;*/
}
.tbl-search td {
	text-align:left; 
	/*border-bottom:1px dotted #999;*/
}
</style>
<form id="adminForm" name="adminForm" method="get" onSubmit="loadPage(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="mod" id="mod" value="<?php echo LURL::dotPage('report3_list');?>" />
<input type="hidden" name="showResult" id="showResult" value="yes" />
<div id="boxSearch" class="boxsearch" style="display:block; margin-right:0px; margin-left:0px;">
<table width="100%"  border="0" align="center" cellpadding="1" cellspacing="5" class="tbl-search">
<tbody id="search" <?php if($_REQUEST["showResult"]=="yes"){ ?> style="display:none;" <?php } ?>>
<tr>
	<td colspan="3" style="font-weight:bold; color:#990000; text-decoration:underline;">ระบุเงื่อนไขการแสดงรายงาน</td>
</tr>
<tr>
	<th>ปีงบประมาณ</th>
	<td class="require" style="width:10px;">*</td>
	<td>
	<?php echo $get->getYearProject($_REQUEST["BgtYear"]);?>
    <span class="hint">(เป็นเงื่อนไขที่จำเป็นต้องระบุทุกครั้ง)</span>
    </td>
</tr>
<tr>
	<th>ชื่อแผนงาน สช.</th>
	<td>&nbsp;</td>
	<td><span id="plan"><?php echo $get->getPlanItemList($_REQUEST["PItemCode"]); ?></span></td>
</tr>
<tr>
	<th>โครงการ</th>
	<td>&nbsp;</td>
	<td><span id="prj"><?php echo $get->getProjectList($_REQUEST["PrjDetailId"]); ?></span></td>
</tr>
<tr>
	<th>กิจกรรม</th>
	<td>&nbsp;</td>
	<td><span id="prj-act"><?php echo $get->getProjectActList($_REQUEST["PrjActId"]); ?></span></td>
</tr>
<tr>
	<th>แหล่งงบประมาณ</th>
	<td>&nbsp;</td>
	<td><?php echo $get->getSourceExternal($_REQUEST["SourceExId"]);?></td>
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
<?php if($_REQUEST["PrjActId"]){ ?>
<tr style="vertical-align:top;">
	<th>กิจกรรม</th>
	<td>&nbsp;</td>
	<td><?php echo $get->getPrjActName($_REQUEST["PrjActId"]); ?></td>
</tr>
<?php } ?>
<?php if($_REQUEST["SourceExId"]){ ?>
<tr>
	<th>แหล่งงบประมาณ</th>
	<td>&nbsp;</td>
	<td><?php echo $get->getSourceExName($_REQUEST["SourceExId"]); ?>	
	</td>
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
    <a href="javascript:saveToExcel();" class="icon-excel">ส่งออกเป็น Excel</a>
    </td>
  </tr>
</table>


<style>
.tbl-list {
	border-collapse:collapse;
}
.tbl-list th {
	border:1px solid #999;
}
.tbl-list td {
	border:1px solid #999;
	border-top:none;
	border-bottom:1px dotted #999;
}
</style>

<table width="100%" border="0" class="tbl-list"  cellspacing="0" cellpadding="0">
  <tr style="vertical-align:top;">
    <th rowspan="2" nowrap="nowrap" style="width:80px;">รหัส</th>
    <th rowspan="2" nowrap="nowrap">ชื่อแผนงาน/โครงการ/กิจกรรม</th>
    <th colspan="4">ไตรมาสที่1</th>
    <th colspan="4">ไตรมาสที่2</th>
    <th colspan="4" >ไตรมาสที่3</th>
    <th colspan="4">ไตรมาสที่4</th>
    <th rowspan="2" style="width:80px;">รวมทั้งสิ้น</th>
    </tr>
  <tr style="vertical-align:top;">
    <th style="width:80px;">ต.ค</th>
    <th style="width:80px;">พ.ย</th>
    <th style="width:80px;">ธ.ค</th>
    <th style="width:80px;">รวม</th>
    <th style="width:80px;">ม.ค</th>
    <th style="width:80px;">ก.พ</th>
    <th style="width:80px;">มี.ค</th>
    <th style="width:80px;">รวม</th>
    <th style="width:80px;">เม.ย</th>
    <th style="width:80px;">พ.ค</th>
    <th style="width:80px;">มิ.ย</th>
    <th style="width:80px;">รวม</th>
    <th style="width:80px;">ก.ค</th>
    <th style="width:80px;">ส.ค</th>
    <th style="width:80px;">ก.ย</th>
    <th style="width:80px;">รวม</th>
    </tr>
<?php
 $nPlan = 1; 
  $recPlan = $get->getPItemRecordSet();//ltxt::print_r($recPlan);
  foreach($recPlan as $recPlanRow){ 
  	foreach($recPlanRow as $a=>$b){
		${$a} = $b;
	}
	$BGPay10 = $get->getSumBGPay(10,$PItemCode);
	$BGPay11 = $get->getSumBGPay(11,$PItemCode);
	$BGPay12 = $get->getSumBGPay(12,$PItemCode);
	$BGQuater1 = $BGPay10+$BGPay11+$BGPay12;
	
	$BGPay1 = $get->getSumBGPay(1,$PItemCode);
	$BGPay2 = $get->getSumBGPay(2,$PItemCode);
	$BGPay3 = $get->getSumBGPay(3,$PItemCode);
	$BGQuater2 = $BGPay1+$BGPay2+$BGPay3;
	
	$BGPay3 = $get->getSumBGPay(3,$PItemCode);
	$BGPay4 = $get->getSumBGPay(4,$PItemCode);
	$BGPay5 = $get->getSumBGPay(5,$PItemCode);
	$BGQuater3 = $BGPay3+$BGPay4+$BGPay5;
	
	$BGPay6 = $get->getSumBGPay(6,$PItemCode);
	$BGPay7 = $get->getSumBGPay(7,$PItemCode);
	$BGPay8 = $get->getSumBGPay(8,$PItemCode);
	$BGQuater4 = $BGPay6+$BGPay7+$BGPay8;
	
	$BGTotal = $BGQuater1+$BGQuater2+$BGQuater3+$BGQuater4;
	

?>
  <tr style="vertical-align:top; background-color:#CCC; ">
    <td style="text-align:center;"><?php echo $PItemCode; ?></td>
    <td><?php echo $PItemName; ?></td>
    <td class="sum-total"><?php echo ($BGPay10 > 0)?number_format($BGPay10,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay11 > 0)?number_format($BGPay11,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay12 > 0)?number_format($BGPay12,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater1 > 0)?number_format($BGQuater1,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGPay1 > 0)?number_format($BGPay1,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay2 > 0)?number_format($BGPay2,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay3 > 0)?number_format($BGPay3,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater2 > 0)?number_format($BGQuater2,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGPay4 > 0)?number_format($BGPay4,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay5 > 0)?number_format($BGPay5,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay6 > 0)?number_format($BGPay6,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater3 > 0)?number_format($BGQuater3,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGPay7 > 0)?number_format($BGPay7,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay8 > 0)?number_format($BGPay8,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay9 > 0)?number_format($BGPay9,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater4 > 0)?number_format($BGQuater4,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGTotal > 0)?number_format($BGTotal,2):"-"; ?></td>
    </tr>
    
    
<!--โครงการ-->    
<?php
$nProject = 1; 
  $recProject = $get->getProjectRecordSet($PItemCode);//ltxt::print_r($recPlan);
  foreach($recProject as $recProjectRow){ 
  	foreach($recProjectRow as $m=>$d){
		${$m} = $d;
	}
	$BGPay10 = $get->getSumBGPay(10,$PItemCode,$PrjDetailId);
	$BGPay11 = $get->getSumBGPay(11,$PItemCode,$PrjDetailId);
	$BGPay12 = $get->getSumBGPay(12,$PItemCode,$PrjDetailId);
	$BGQuater1 = $BGPay10+$BGPay11+$BGPay12;
	
	$BGPay1 = $get->getSumBGPay(1,$PItemCode,$PrjDetailId);
	$BGPay2 = $get->getSumBGPay(2,$PItemCode,$PrjDetailId);
	$BGPay3 = $get->getSumBGPay(3,$PItemCode,$PrjDetailId);
	$BGQuater2 = $BGPay1+$BGPay2+$BGPay3;
	
	$BGPay3 = $get->getSumBGPay(3,$PItemCode,$PrjDetailId);
	$BGPay4 = $get->getSumBGPay(4,$PItemCode,$PrjDetailId);
	$BGPay5 = $get->getSumBGPay(5,$PItemCode,$PrjDetailId);
	$BGQuater3 = $BGPay3+$BGPay4+$BGPay5;
	
	$BGPay6 = $get->getSumBGPay(6,$PItemCode,$PrjDetailId);
	$BGPay7 = $get->getSumBGPay(7,$PItemCode,$PrjDetailId);
	$BGPay8 = $get->getSumBGPay(8,$PItemCode,$PrjDetailId);
	$BGQuater4 = $BGPay6+$BGPay7+$BGPay8;
	
	$BGTotal = $BGQuater1+$BGQuater2+$BGQuater3+$BGQuater4;
?>
  <tr style="vertical-align:top; background-color:#EEE;">
    <td style="text-align:center;"><?php echo $PrjCode; ?></td>
    <td><?php echo $PrjName; ?></td>
    <td class="sum-total"><?php echo ($BGPay10 > 0)?number_format($BGPay10,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay11 > 0)?number_format($BGPay11,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay12 > 0)?number_format($BGPay12,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater1 > 0)?number_format($BGQuater1,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGPay1 > 0)?number_format($BGPay1,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay2 > 0)?number_format($BGPay2,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay3 > 0)?number_format($BGPay3,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater2 > 0)?number_format($BGQuater2,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGPay4 > 0)?number_format($BGPay4,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay5 > 0)?number_format($BGPay5,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay6 > 0)?number_format($BGPay6,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater3 > 0)?number_format($BGQuater3,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGPay7 > 0)?number_format($BGPay7,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay8 > 0)?number_format($BGPay8,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay9 > 0)?number_format($BGPay9,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater4 > 0)?number_format($BGQuater4,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGTotal > 0)?number_format($BGTotal,2):"-"; ?></td>
    </tr>
    
<!--กิจกรรม-->    
<?php
$nAct = 1; 
  $recAct = $get->getActRecordSet($PrjDetailId);//ltxt::print_r($recPlan);
  foreach($recAct as $recActRow){ 
  	foreach($recActRow as $w=>$q){
		${$w} = $q;
	}
	$BGPay10 = $get->getSumBGPay(10,$PItemCode,$PrjDetailId,$PrjActId);
	$BGPay11 = $get->getSumBGPay(11,$PItemCode,$PrjDetailId,$PrjActId);
	$BGPay12 = $get->getSumBGPay(12,$PItemCode,$PrjDetailId,$PrjActId);
	$BGQuater1 = $BGPay10+$BGPay11+$BGPay12;
	
	$BGPay1 = $get->getSumBGPay(1,$PItemCode,$PrjDetailId,$PrjActId);
	$BGPay2 = $get->getSumBGPay(2,$PItemCode,$PrjDetailId,$PrjActId);
	$BGPay3 = $get->getSumBGPay(3,$PItemCode,$PrjDetailId,$PrjActId);
	$BGQuater2 = $BGPay1+$BGPay2+$BGPay3;
	
	$BGPay3 = $get->getSumBGPay(3,$PItemCode,$PrjDetailId,$PrjActId);
	$BGPay4 = $get->getSumBGPay(4,$PItemCode,$PrjDetailId,$PrjActId);
	$BGPay5 = $get->getSumBGPay(5,$PItemCode,$PrjDetailId,$PrjActId);
	$BGQuater3 = $BGPay3+$BGPay4+$BGPay5;
	
	$BGPay6 = $get->getSumBGPay(6,$PItemCode,$PrjDetailId,$PrjActId);
	$BGPay7 = $get->getSumBGPay(7,$PItemCode,$PrjDetailId,$PrjActId);
	$BGPay8 = $get->getSumBGPay(8,$PItemCode,$PrjDetailId,$PrjActId);
	$BGQuater4 = $BGPay6+$BGPay7+$BGPay8;
	
	$BGTotal = $BGQuater1+$BGQuater2+$BGQuater3+$BGQuater4;
	

?>
  <tr style="vertical-align:top;">
    <td style="text-align:center;"><?php echo $PrjActCode; ?></td>
    <td>- <?php echo $PrjActName; ?></td>
    <td class="sum-total"><?php echo ($BGPay10 > 0)?number_format($BGPay10,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay11 > 0)?number_format($BGPay11,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay12 > 0)?number_format($BGPay12,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater1 > 0)?number_format($BGQuater1,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGPay1 > 0)?number_format($BGPay1,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay2 > 0)?number_format($BGPay2,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay3 > 0)?number_format($BGPay3,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater2 > 0)?number_format($BGQuater2,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGPay4 > 0)?number_format($BGPay4,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay5 > 0)?number_format($BGPay5,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay6 > 0)?number_format($BGPay6,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater3 > 0)?number_format($BGQuater3,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGPay7 > 0)?number_format($BGPay7,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay8 > 0)?number_format($BGPay8,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay9 > 0)?number_format($BGPay9,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater4 > 0)?number_format($BGQuater4,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGTotal > 0)?number_format($BGTotal,2):"-"; ?></td>
    </tr>
<?php 
	$nAct++;
} 
?>    
<!--END กิจกรรม-->      
    
    
    
<?php 
	$nProject++;
}
?>    
<!--END โครงการ-->    
    
    
    
    
    
<?php 
	$nPlan++;
} 
?>
<?php 
	$BGPay10 = $get->getSumBGPay(10,$_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
	$BGPay11 = $get->getSumBGPay(11,$_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
	$BGPay12 = $get->getSumBGPay(12,$_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
	$BGQuater1 = $BGPay10+$BGPay11+$BGPay12;
	
	$BGPay1 = $get->getSumBGPay(1,$_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
	$BGPay2 = $get->getSumBGPay(2,$_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
	$BGPay3 = $get->getSumBGPay(3,$_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
	$BGQuater2 = $BGPay1+$BGPay2+$BGPay3;
	
	$BGPay3 = $get->getSumBGPay(3,$_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
	$BGPay4 = $get->getSumBGPay(4,$_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
	$BGPay5 = $get->getSumBGPay(5,$_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
	$BGQuater3 = $BGPay3+$BGPay4+$BGPay5;
	
	$BGPay6 = $get->getSumBGPay(6,$_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
	$BGPay7 = $get->getSumBGPay(7,$_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
	$BGPay8 = $get->getSumBGPay(8,$_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
	$BGQuater4 = $BGPay6+$BGPay7+$BGPay8;
	
	$BGTotal = $BGQuater1+$BGQuater2+$BGQuater3+$BGQuater4;

?>

  <tr style="vertical-align:top; font-weight:bold; background-color:#EEE;">
    <td colspan="2" style="text-align:right;">รวมทั้งสิ้น</td>
    <td class="sum-total"><?php echo ($BGPay10 > 0)?number_format($BGPay10,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay11 > 0)?number_format($BGPay11,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay12 > 0)?number_format($BGPay12,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater1 > 0)?number_format($BGQuater1,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGPay1 > 0)?number_format($BGPay1,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay2 > 0)?number_format($BGPay2,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay3 > 0)?number_format($BGPay3,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater2 > 0)?number_format($BGQuater2,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGPay4 > 0)?number_format($BGPay4,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay5 > 0)?number_format($BGPay5,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay6 > 0)?number_format($BGPay6,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater3 > 0)?number_format($BGQuater3,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGPay7 > 0)?number_format($BGPay7,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay8 > 0)?number_format($BGPay8,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay9 > 0)?number_format($BGPay9,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGQuater4 > 0)?number_format($BGQuater4,2):"-"; ?></td>
    
    <td class="sum-total"><?php echo ($BGTotal > 0)?number_format($BGTotal,2):"-"; ?></td>
    </tr>

</table>
<br />
<?php 
/*$BGPlan = $get->getSumBGPlan($_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
$BGTferIn = $get->getSumBGTferIn($_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
$BGTferOut = $get->getSumBGTferOut($_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
$BGPlanTfer = $BGPlan+$BGTferIn-$BGTferOut;
$BGHold = $get->getSumBGHold($_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
$BGChain = $get->getSumBGChain($_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
$BGPay = $get->getSumBGPay($_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
$BGRemain =  $BGPlanTfer-$BGHold-$BGChain-$BGPay;
*/?>
<!--<table width="100%" border="0"  cellspacing="0" cellpadding="2">    
  <tr style="vertical-align:top; font-weight:bold;">
    <td style="text-align:right;">งบตามแผน</td>
    <td style="width:150px; text-align:right; font-weight:normal;"><?php //echo ($BGPlan > 0)?number_format($BGPlan,2):"-"; ?></td>
    <td style="width:200px;">&nbsp;บาท</td>
    </tr>
  <tr style="vertical-align:top; font-weight:bold;">
    <td style="text-align:right;">งบรับโอน</td>
    <td style="width:150px; text-align:right; font-weight:normal;"><?php //echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td style="width:200px;">&nbsp;บาท</td>
    </tr>
    <tr style="vertical-align:top; font-weight:bold;">
    <td style="text-align:right;">งบโอนออก</td>
    <td style="width:150px; text-align:right; font-weight:normal;"><?php //echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td style="width:200px;">&nbsp;บาท</td>
    </tr>
    
   <tr>
   	<td colspan="3">&nbsp;</td>
   </tr>

  <tr style="vertical-align:top; font-weight:bold;">
    <td style="text-align:right;">งบแผนรวมโอน</td>
    <td style="width:150px; text-align:right; font-weight:normal;"><?php //echo ($BGPlanTfer > 0)?number_format($BGPlanTfer,2):"-"; ?></td>
    <td style="width:200px;">&nbsp;บาท</td>
    </tr>
    <tr style="vertical-align:top; font-weight:bold;">
    <td style="text-align:right;">หลักการคงเหลือ</td>
    <td style="text-align:right; font-weight:normal;"><?php //echo ($BGHold > 0)?number_format($BGHold,2):"-"; ?></td>
    <td>&nbsp;บาท</td>
    </tr>
   <tr style="vertical-align:top; font-weight:bold;">
    <td style="text-align:right;">ผูกพันคงเหลือ</td>
     <td style="text-align:right; font-weight:normal;"><?php //echo ($BGChain > 0)?number_format($BGChain,2):"-"; ?></td>
    <td>&nbsp;บาท</td>
    </tr>
    <tr style="vertical-align:top; font-weight:bold;">
    <td style="text-align:right;">ชำระ/เบิกจ่ายแล้ว</td>
    <td style="text-align:right; font-weight:normal;"><?php //echo ($BGPay > 0)?number_format($BGPay,2):"-"; ?></td>
    <td>&nbsp;บาท</td>
    </tr>
    <tr style="vertical-align:top; font-weight:bold;">
    <td style="text-align:right;">งบแผนรวมโอนคงเหลือ</td>
    <td style="text-align:right; font-weight:normal;"><?php //echo ($BGRemain > 0)?number_format($BGRemain,2):"-"; ?></td>
    <td>&nbsp;บาท</td>
    </tr>
</table>
-->




<?php }else{ ?>
<div class="nullDataList">กรุณาระบุเงื่อนไขในการแสดงรายงาน</div>
<?php } ?>
</div><!--<div id="c-report">-->
<br />
<br />
<br />
          
