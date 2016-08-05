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
	/*window.location.href="?mod=<?php //echo LURL::dotPage('report4_print')?>&format=raw<?php //echo $get->getQueryString(); ?>";*/
}

function saveToExcel(){
	/*window.location.href="?mod=<?php //echo LURL::dotPage('report4_excel')?>&format=raw<?php //echo $get->getQueryString(); ?>";*/
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
		  url: "?mod=<?php echo LURL::dotPage('report4_action');?>",		   
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
		  url: "?mod=<?php echo LURL::dotPage('report4_action');?>",		   
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
		  url: "?mod=<?php echo LURL::dotPage('report4_action');?>",		   
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
	var PItemCode = JQ("#PItemCode").val();//alert(BgtYear);
	if(PItemCode==0){
		alert('กรุณาระบุชื่อแผนงาน');
		JQ("#PItemCode").focus();
		return false;
	}
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
<input type="hidden" name="mod" id="mod" value="<?php echo LURL::dotPage('report4_list');?>" />
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
	<td><span class="require" style="width:10px;">*</span></td>
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
    <th rowspan="2" nowrap="nowrap" style="width:30px;">ลำดับ</th>
    <th rowspan="2" nowrap="nowrap" style="width:80px;">เลขที่<br />สัญญายืม</th>
    <th rowspan="2" nowrap="nowrap" style="width:80px;">เลขที่ สช.น.</th>
    <th rowspan="2" nowrap="nowrap" style="width:80px;">ว.ด.ป <br />ใน สช.น.</th>
    <th rowspan="2" nowrap="nowrap" style="width:150px;">ชื่อ-นามสกุล</th>
    <th rowspan="2">รายการ</th>
    <th rowspan="2" style="width:120px;">ระยะเวลาปฏิบัติงาน</th>
    <th rowspan="2" style="width:80px;">จำนวนเงิน<br />ตามสัญญา</th>
    <th colspan="3">เคลียร์เป็น</th>
    <th rowspan="2" style="width:80px;">จำนวนเงิน<br />คงเหลือ</th>
    <th rowspan="2" style="width:90px;">กำหนด/<br />ว.ด.ป ที่เคลียร์</th>
    </tr>
  <tr style="vertical-align:top;">
    <th style="width:80px;">ค่าใช้จ่าย</th>
    <th style="width:90px;">เงินรับคืน</th>
    <th style="width:80px;">เงินจ่ายเพิ่ม</th>
    </tr>

<?php
$nItem = 1; 
$recItem = $get->getItemRecordSet();//ltxt::print_r($recItem);
foreach($recItem as $recItemRow){ 
	foreach($recItemRow as $ww=>$qq){
		${$ww} = $qq;
	}
?>
  <tr style="vertical-align:top;">
    <td style="text-align:center;"><?php echo $nItem; ?></td>
    <td style="text-align:center;"><?php echo $BorrowCode; ?></td>
    <td style="text-align:center;"><?php echo $DocCode; ?></td>
    <td style="text-align:center;"><?php echo ShowDate($DocDate); ?></td>
    <td><?php echo ($RQPersonalCode)?($get->fn_getFullNameByPersonalCode($RQPersonalCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
    <td><?php echo $Title; ?></td>
    <td style="text-align:center;"><?php echo ShowDate($StartDate); ?>-<?php echo ShowDate($EndDate); ?></td>
    <td class="sum-total"><?php echo ($SumBGBorrow > 0)?number_format($SumBGBorrow,2):""; ?></td>
    <td class="sum-total">&nbsp;</td>
    <td class="sum-total">&nbsp;</td>
    <td class="sum-total"><?php echo ($DocBGHold > 0)?number_format($DocBGHold,2):""; ?></td>
    <td class="sum-total"><?php echo ($SumBGRemain > 0)?number_format($SumBGRemain,2):""; ?></td>
    <td style="text-align:center;"><?php echo ShowDate($ReturnDate); ?></td>
    </tr>
    
    
<?php
$sub = 1; 
$subItem = $get->getClearItemRecordSet($BorrowCode);//ltxt::print_r($subItem);
foreach($subItem as $subItemRow){ 
	foreach($subItemRow as $w=>$q){
		${$w} = $q;
	}
?>
  <tr style="vertical-align:top;">
    <td style="text-align:center;">&nbsp;</td>
    <td style="text-align:center;">&nbsp;</td>
    <td style="text-align:center;">&nbsp;</td>
    <td style="text-align:center;">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align:center;">&nbsp;</td>
    <td style="text-align:right;">ครั้งที่ <?php echo $ClearNo; ?></td>
    <td class="sum-total"><?php echo ($TotalCost > 0)?number_format($TotalCost,2):""; ?></td>
    <td class="sum-total"><?php echo ($ReturnCost > 0)?number_format($ReturnCost,2):""; ?></td>
    <td class="sum-total"><?php echo ($TotalOther > 0)?number_format($TotalOther,2):""; ?></td>
    <td class="sum-total">&nbsp;</td>
    <td style="text-align:center;"><?php echo ShowDate($ReturnDate); ?></td>
    </tr>
    
<?php 
	$sub++;
} 
?>    
    
    
    
    
    
<?php 
	$nItem++;
} 
?>    




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
          
