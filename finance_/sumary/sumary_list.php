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
		'text' => $MenuName,
	),
));

?>

<script language="javascript" type="text/javascript">
function printDocument(){
	window.location.href="?mod=<?php echo LURL::dotPage('sumary_print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('sumary_excel')?>&format=raw<?php echo $get->getQueryString(); ?>";
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
		  url: "?mod=<?php echo LURL::dotPage('sumary_action');?>",		   
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
		  url: "?mod=<?php echo LURL::dotPage('sumary_action');?>",		   
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
		  url: "?mod=<?php echo LURL::dotPage('sumary_action');?>",		   
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
<input type="hidden" name="mod" id="mod" value="<?php echo LURL::dotPage('sumary_list');?>" />
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
	<td><?php echo $get->getSourceExName($_REQUEST["SourceExId"]); ?></td>
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
    <th nowrap="nowrap" style="width:80px;">รหัส</th>
    <th nowrap="nowrap">ชื่อแผนงาน/โครงการ/กิจกรรม</th>
    <th style="width:80px;" nowrap="nowrap">งบตามแผน<br /><span style="font-weight:normal;">(A)</span></th>
    <th style="width:80px;" nowrap="nowrap">งบรับโอน<br /><span style="font-weight:normal;">(B)</span></th>
    <th style="width:80px;" nowrap="nowrap">งบโอนออก<br /><span style="font-weight:normal;">(C)</span></th>
    <th style="width:100px;" nowrap="nowrap">งบ(รอ)รับโอน<br /><span style="font-weight:normal;">(D)</span></th>
    <th style="width:100px;" nowrap="nowrap">งบ(รอ)โอนออก<br /><span style="font-weight:normal;">(E)</span></th>
    <th style="width:140px;" nowrap="nowrap">งบแผนรวมโอน<br />
      <span style="font-weight:normal;">(F)=(A)+(B)-(C)+(D)-(E)</span></th>
    <th style="width:100px;" nowrap="nowrap">งบ(รอ)หลักการ<br /><span style="font-weight:normal;">(G)</span></th>
    <th style="width:80px;" nowrap="nowrap">งบหลักการ<br /><span style="font-weight:normal;">(H)</span></th>
    <th style="width:80px;" nowrap="nowrap">งบผูกพัน<br /><span style="font-weight:normal;">(K)</span></th>
    <th style="width:100px;" nowrap="nowrap">งบ(รอ)ตัดจ่าย<br /><span style="font-weight:normal;">(M)</span></th>
    <th style="width:80px;" nowrap="nowrap">งบตัดจ่าย<br />
      <span style="font-weight:normal;">(N)</span></th>
    <th style="width:100px;" nowrap="nowrap">งบรวมจ่ายจริง<br />
      <span style="font-weight:normal;">(P)=(K)+(M)+(N)</span></th>
    <th style="width:100px;" nowrap="nowrap">คงเหลือ<br />ไม่รวมหลักการ<br />
      <span style="font-weight:normal;">(R)=(F)-(P)</span></th>
    <th style="width:120px;" nowrap="nowrap">คงเหลือ<br />รวมหลักการ<br />
      <span style="font-weight:normal;">(S)=(F)-(G)-(H)-(P)</span></th>
    </tr>
  <?php
 $nPlan = 1; 
  $recPlan = $get->getPItemRecordSet();//ltxt::print_r($recPlan);
  foreach($recPlan as $recPlanRow){ 
  	foreach($recPlanRow as $a=>$b){
		${$a} = $b;
	}
	$BGPlan = $get->getSumBGPlan($PItemCode);
	$BGTferWait = $get->getWaitSumBGTferOut($PItemCode);
	$BGTferIn = $get->getSumBGTferIn($PItemCode);
	$BGTferOut = $get->getSumBGTferOut($PItemCode);
	$BGPlanTfer = $BGPlan+$BGTferIn-$BGTferOut-$BGTferWait;
	
	$BGHoldWait = $get->getSumBGHoldWait($PItemCode);
	$BGHold = $get->getSumBGHold($PItemCode);
	
	$BGChain = $get->getSumBGChain($PItemCode);
	
	$BGPayWait = $get->getSumBGPayWait($PItemCode);
	$BGPay = $get->getSumBGPay($PItemCode);
	
	$BGPayNet = $BGChain+$BGPayWait+$BGPay;

	$BGRemain =  $BGPlanTfer-$BGHoldWait-$BGHold-$BGPayNet;
	$BGRemainNotHold =  $BGPlanTfer-$BGPayNet;
	
	$BGBorrow = $get->getSumBGBorrow($PItemCode);
	
	

?>
  <tr style="vertical-align:top; background-color:#CCC; " title="<?php echo $PItemName; ?>">
    <td style="text-align:center;"><?php echo $PItemCode; ?></td>
    <td nowrap="nowrap"><?php echo $PItemName; ?></td>
    <td class="sum-total"><?php echo ($BGPlan > 0)?number_format($BGPlan,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPlanTfer > 0)?number_format($BGPlanTfer,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHoldWait > 0)?number_format($BGHoldWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHold > 0)?number_format($BGHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGChain > 0)?number_format($BGChain,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayWait > 0)?number_format($BGPayWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay > 0)?number_format($BGPay,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayNet > 0)?number_format($BGPayNet,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemainNotHold > 0)?number_format($BGRemainNotHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemain > 0)?number_format($BGRemain,2):"-"; ?></td>
    </tr>
    
    
<!--โครงการ-->    
<?php
$nProject = 1; 
  $recProject = $get->getProjectRecordSet($PItemCode);//ltxt::print_r($recPlan);
  foreach($recProject as $recProjectRow){ 
  	foreach($recProjectRow as $m=>$d){
		${$m} = $d;
	}
	$BGPlan = $get->getSumBGPlan($PItemCode,$PrjDetailId);
	
	$BGTferWait = $get->getWaitSumBGTferOut($PItemCode);
	
	$BGTferIn = $get->getSumBGTferIn($PItemCode,$PrjDetailId);
	$BGTferOut = $get->getSumBGTferOut($PItemCode,$PrjDetailId);
	$BGPlanTfer = $BGPlan+$BGTferIn-$BGTferOut-$BGTferWait;
	
	$BGHoldWait = $get->getSumBGHoldWait($PItemCode,$PrjDetailId);
	$BGHold = $get->getSumBGHold($PItemCode,$PrjDetailId);
	
	$BGChain = $get->getSumBGChain($PItemCode,$PrjDetailId);
	
	$BGPayWait = $get->getSumBGPayWait($PItemCode,$PrjDetailId);
	$BGPay = $get->getSumBGPay($PItemCode,$PrjDetailId);
	
	$BGPayNet = $BGChain+$BGPayWait+$BGPay;

	$BGRemain =  $BGPlanTfer-$BGHoldWait-$BGHold-$BGPayNet;
	$BGRemainNotHold =  $BGPlanTfer-$BGPayNet;
	
	$BGBorrow = $get->getSumBGBorrow($PItemCode,$PrjDetailId);
	
?>
  <tr style="vertical-align:top; background-color:#EEE;" title="<?php echo $PrjName; ?>">
    <td style="text-align:center;"><?php echo $PrjCode; ?></td>
    <td><?php echo $PrjName; ?></td>
    <td class="sum-total"><?php echo ($BGPlan > 0)?number_format($BGPlan,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPlanTfer > 0)?number_format($BGPlanTfer,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHoldWait > 0)?number_format($BGHoldWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHold > 0)?number_format($BGHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGChain > 0)?number_format($BGChain,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayWait > 0)?number_format($BGPayWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay > 0)?number_format($BGPay,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayNet > 0)?number_format($BGPayNet,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemainNotHold > 0)?number_format($BGRemainNotHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemain > 0)?number_format($BGRemain,2):"-"; ?></td>
    </tr>
    
<!--กิจกรรม-->    
<?php
$nAct = 1; 
  $recAct = $get->getActRecordSet($PrjDetailId);//ltxt::print_r($recPlan);
  foreach($recAct as $recActRow){ 
  	foreach($recActRow as $w=>$q){
		${$w} = $q;
	}
	$BGPlan = $get->getSumBGPlan($PItemCode,$PrjDetailId,$PrjActId);
	
	$BGTferWait = $get->getWaitSumBGTferOut($PItemCode,$PrjDetailId,$PrjActId);
	
	$BGTferIn = $get->getSumBGTferIn($PItemCode,$PrjDetailId,$PrjActId);
	$BGTferOut = $get->getSumBGTferOut($PItemCode,$PrjDetailId,$PrjActId);
	$BGPlanTfer = $BGPlan+$BGTferIn-$BGTferOut-$BGTferWait;
	
	$BGHoldWait = $get->getSumBGHoldWait($PItemCode,$PrjDetailId,$PrjActId);
	$BGHold = $get->getSumBGHold($PItemCode,$PrjDetailId,$PrjActId);
	
	$BGChain = $get->getSumBGChain($PItemCode,$PrjDetailId,$PrjActId);
	
	$BGPayWait = $get->getSumBGPayWait($PItemCode,$PrjDetailId,$PrjActId);
	$BGPay = $get->getSumBGPay($PItemCode,$PrjDetailId,$PrjActId);
	
	$BGPayNet = $BGChain+$BGPayWait+$BGPay;

	$BGRemain =  $BGPlanTfer-$BGHoldWait-$BGHold-$BGPayNet;
	$BGRemainNotHold =  $BGPlanTfer-$BGPayNet;
	
	$BGBorrow = $get->getSumBGBorrow($PItemCode,$PrjDetailId,$PrjActId);
	
?>
  <tr style="vertical-align:top;" title="<?php echo $PrjActName; ?>">
    <td style="text-align:center;"><?php echo $PrjActCode; ?></td>
    <td>- <?php echo $PrjActName; ?></td>
    <td class="sum-total"><?php echo ($BGPlan > 0)?number_format($BGPlan,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPlanTfer > 0)?number_format($BGPlanTfer,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHoldWait > 0)?number_format($BGHoldWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHold > 0)?number_format($BGHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGChain > 0)?number_format($BGChain,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayWait > 0)?number_format($BGPayWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay > 0)?number_format($BGPay,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayNet > 0)?number_format($BGPayNet,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemainNotHold > 0)?number_format($BGRemainNotHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemain > 0)?number_format($BGRemain,2):"-"; ?></td>
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
$BGPlan = $get->getSumBGPlan($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);

$BGTferWait = $get->getWaitSumBGTferOut($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);

$BGTferIn = $get->getSumBGTferIn($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
$BGTferOut = $get->getSumBGTferOut($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
$BGPlanTfer = $BGPlan+$BGTferIn-$BGTferOut-$BGTferWait;

$BGHoldWait = $get->getSumBGHoldWait($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
$BGHold = $get->getSumBGHold($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);

$BGChain = $get->getSumBGChain($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);

$BGPayWait = $get->getSumBGPayWait($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
$BGPay = $get->getSumBGPay($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);

$BGPayNet = $BGChain+$BGPayWait+$BGPay;

$BGRemain =  $BGPlanTfer-$BGHoldWait-$BGHold-$BGPayNet;
$BGRemainNotHold =  $BGPlanTfer-$BGPayNet;
	
$BGBorrow = $get->getSumBGBorrow($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);

?>

  <tr style="vertical-align:top; font-weight:bold; background-color:#EEE;">
    <td colspan="2" style="text-align:right;">รวมทั้งสิ้น</td>
    <td class="sum-total"><?php echo ($BGPlan > 0)?number_format($BGPlan,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPlanTfer > 0)?number_format($BGPlanTfer,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHoldWait > 0)?number_format($BGHoldWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHold > 0)?number_format($BGHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGChain > 0)?number_format($BGChain,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayWait > 0)?number_format($BGPayWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay > 0)?number_format($BGPay,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayNet > 0)?number_format($BGPayNet,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemainNotHold > 0)?number_format($BGRemainNotHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemain > 0)?number_format($BGRemain,2):"-"; ?></td>
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
          
