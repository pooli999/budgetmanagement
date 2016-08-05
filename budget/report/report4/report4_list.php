<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));
$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบนโยบายแผนงานและโครงการ',
	),
	array(
		'text' => 'พิมพ์รายงาน ',
		'link' => '?mod=budget.report.startup',
	),
	
	array(
		'text' => $MenuName,
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
	document.getElementById('step').innerHTML='<span class="icon-load">กรุณารอสักครู่</span>';
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('report4_action');?>",		   
		  data: "action=getsteplist&BgtYear="+BgtYear,
		  success: function(msg){
			JQ("#step").html(msg);
		  }
	});
	loadPlan(BgtYear);
	loadOrg(BgtYear);
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
}

function loadOrg(BgtYear){
	document.getElementById('org').innerHTML='<span class="icon-load">กรุณารอสักครู่</span>';
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('report4_action');?>",		   
		  data: "action=getorglist&BgtYear="+BgtYear,
		  success: function(msg){
			JQ("#org").html(msg);
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
	var ScreenLevel = JQ("#ScreenLevel").val();//alert(ScreenLevel);
	if(ScreenLevel==0){
		alert('กรุณาระบุขั้นตอนจัดทำแผนปฏิบัติงาน');
		JQ("#ScreenLevel").focus();
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
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="5" class="tbl-search">
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
	<th>ขั้นตอนจัดทำแผนปฏิบัติงาน</th>
	<td class="require">*</td>
	<td>
    <span id="step"><?php echo $get->getStepList($_REQUEST["ScreenLevel"]); ?></span>
    <span class="hint">(เป็นเงื่อนไขที่จำเป็นต้องระบุทุกครั้ง)</span>
    </td>
</tr>
<tr>
	<th>ชื่อแผนงาน สช.</th>
	<td>&nbsp;</td>
	<td><span id="plan"><?php echo $get->getPlanItemList($_REQUEST["PItemCode"]); ?></span></td>
</tr>
<tr>
	<th>หน่วยงาน</th>
	<td>&nbsp;</td>
	<td><span id="org"><?php echo $get->getOrgList($_REQUEST["OrganizeCode"]);?></span></td>
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
<?php if($_REQUEST["ScreenLevel"]){ ?>
<tr>
	<th>ขั้นตอนจัดทำแผนปฏิบัติงาน</th>
	<td>&nbsp;</td>
	<td><?php echo $get->getScreenName($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"]); ?></td>
</tr>
<?php } ?>
<?php if($_REQUEST["PItemCode"]){ ?>
<tr>
	<th>ชื่อแผนงาน สช.</th>
	<td>&nbsp;</td>
	<td><?php echo $get->getPItemName($_REQUEST["BgtYear"],$_REQUEST["PItemCode"]); ?></td>
</tr>
<?php } ?>
<?php if($_REQUEST["OrganizeCode"]){ ?>
<tr>
	<th>หน่วยงาน</th>
	<td>&nbsp;</td>
	<td><?php echo $get->getOrgName($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]); ?></td>
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


<?php $source2=$get->getSourceYear($_REQUEST["BgtYear"]); ?>
<table width="100%" border="1" class="tbl-list"  cellspacing="1" cellpadding="0">
  <tr>
    <th style="width:30px;">ลำดับ</th>
    <th nowrap="nowrap">ชื่อแผนงาน/โครงการ/กิจกรรม</th>
   <th style="width:10%;">งบประมาณ</th>
    <?php
$h=1;
foreach( $source2 as $prow2 ){
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
?>
<th style="width:10%;"><?php echo $SourceExName; ?></th>
<?php 
	$h++;
} 
?>    

    </tr>




  <!--วน loop แผนงาน สช.-->
  <?php
  $nPlan = 1; 
  $recPlan = $get->getPItemRecordSet();//ltxt::print_r($recPlan);
  foreach($recPlan as $recPlanRow){ 
  	foreach($recPlanRow as $a=>$b){
		${$a} = $b;
	}
	$SumCostMonth=$get->getTotalPrjMonth($PItemCode);
  ?>
  
  <tr class="cate" style="vertical-align:top; background-color:#DDD;">
    <td style="text-align:center;"><?php echo $nPlan; ?></td>
    <td><?php echo $PItemName; ?></td>
    <td class="sum-total" title="งบประมาณ"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <?php 
$h=1;
foreach( $source2 as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostExternal=0;
	if($SumCostMonth){
		$SumCostExternal=$get->getTotalPrjMonthExternal($PItemCode,0,0,$SourceExId);
	}
?>
<td class="sum-total" title="<?php echo $SourceExName; ?>"><?php echo ($SumCostExternal)?number_format($SumCostExternal,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    

    </tr>
  
  
  
  
  
  
<!-- วนลูปโครงการ --> 
  <?php
  $nProject = 1; 
  $recProject = $get->getProjectRecordSet($PItemCode);//ltxt::print_r($recPlan);
  foreach($recProject as $recProjectRow){ 
  	foreach($recProjectRow as $m=>$d){
		${$m} = $d;
	}
	$SumCostMonth=$get->getTotalPrjMonth($PItemCode,$PrjDetailId);
  ?>
  
  <tr class="cate" style="vertical-align:top; background-color:#EEE;">
    <td style="text-align:center;"><?php echo $nPlan.".".$nProject; ?></td>
    <td><?php echo $PrjName; ?></td>
    <td class="sum-total" title="งบประมาณ"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <?php 
$h=1;
foreach( $source2 as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostExternal=0;
	if($SumCostMonth){
		$SumCostExternal=$get->getTotalPrjMonthExternal($PItemCode,$PrjDetailId,0,$SourceExId);
	}
?>
<td class="sum-total" title="<?php echo $SourceExName; ?>"><?php echo ($SumCostExternal)?number_format($SumCostExternal,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    

    </tr>
  
  
  <!-- วนลูปกิจกรรม --> 
  <?php
  $nAct = 1; 
  $recAct = $get->getActRecordSet($PrjDetailId);//ltxt::print_r($recPlan);
  foreach($recAct as $recActRow){ 
  	foreach($recActRow as $w=>$q){
		${$w} = $q;
	}
	$SumCostMonth=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId);
  ?>
  
  <tr class="cate" style="vertical-align:top;">
    <td style="text-align:center;">&nbsp;</td>
    <td>- <?php echo $PrjActName; ?></td>
    <td class="sum-total" title="งบประมาณ"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <?php 
$h=1;
foreach( $source2 as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostExternal=0;
	if($SumCostMonth){
		$SumCostExternal=$get->getTotalPrjMonthExternal($PItemCode,$PrjDetailId,$PrjActId,$SourceExId);
	}
?>
<td class="sum-total" title="<?php echo $SourceExName; ?>"><?php echo ($SumCostExternal)?number_format($SumCostExternal,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    

    </tr>
  <?php 
  $nAct++;
  } 
  ?>
<!--END วนลูปกิจกรรม-->

  
  
  
  
  
  
  <?php 
  $nProject++;
  } 
  ?>
<!--END วนลูปโครงการ-->
  
  
  
  
  
  
  
  
  
  <?php 
  $nPlan++;
  } 
  ?>
  <!--END วน loop หมวดงบรายจ่าย-->

<?php
	$SumCostMonth=$get->getTotalPrjMonth();
?>  
  
  
  
  <tr style="vertical-align:top; font-weight:bold; background-color:#CCC;">
    <td colspan="2" style="text-align:right;">รวมทั้งสิ้น</td>
    <td class="sum-total" title="งบประมาณ"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <?php 
$h=1;
foreach( $source2 as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostExternal=0;
	if($SumCostMonth){
		$SumCostExternal=$get->getTotalPrjMonthExternal(0,0,0,$SourceExId);
	}
?>
<td class="sum-total" title="<?php echo $SourceExName; ?>"><?php echo ($SumCostExternal)?number_format($SumCostExternal,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    

    </tr>
</table>

<?php }else{ ?>
<div class="nullDataList">กรุณาระบุเงื่อนไขในการแสดงรายงาน</div>
<?php } ?>
</div><!--<div id="c-report">-->

<br />
<br />
<br />
          
