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
	window.location.href="?mod=<?php echo LURL::dotPage('report3_print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('report3_excel')?>&format=raw<?php echo $get->getQueryString(); ?>";
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
		  url: "?mod=<?php echo LURL::dotPage('report3_action');?>",		   
		  data: "action=getsteplist&BgtYear="+BgtYear,
		  success: function(msg){
			JQ("#step").html(msg);
		  }
	});
	loadPlan(BgtYear);
	loadOrg(BgtYear);
	loadPrj(0);
	loadPrjAct(0);
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
}

function loadOrg(BgtYear){
	document.getElementById('org').innerHTML='<span class="icon-load">กรุณารอสักครู่</span>';
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('report3_action');?>",		   
		  data: "action=getorglist&BgtYear="+BgtYear,
		  success: function(msg){
			JQ("#org").html(msg);
		  }
	});
	
}

function loadPrj(){//alert(OrganizeCode);
	document.getElementById('prj').innerHTML='<span class="icon-load">กรุณารอสักครู่</span>';
	var BgtYear = JQ("#BgtYear").val();//alert(BgtYear);
	var ScreenLevel = JQ("#ScreenLevel").val();//alert(ScreenLevel);
	var PItemCode = JQ("#PItemCode").val();//alert(PItemCode);
	var OrganizeCode = JQ("#OrganizeCode").val();//alert(PItemCode);
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('report3_action');?>",		   
		  data: "action=getprjlist&BgtYear="+BgtYear+"&ScreenLevel="+ScreenLevel+"&PItemCode="+PItemCode+"&OrganizeCode="+OrganizeCode,
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
<input type="hidden" name="mod" id="mod" value="<?php echo LURL::dotPage('report3_list');?>" />
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
	<th>หมวดงบประมาณ</th>
	<td>&nbsp;</td>
	<td><span id="cost-type"><?php $get->getCostTypeList($_REQUEST["CostTypeId"]); ?></span></td>
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
<?php if($_REQUEST["CostTypeId"]){ ?>
<tr>
	<th>หมวดงบประมาณ</th>
	<td>&nbsp;</td>
	<td><?php echo $get->getCostTypeName($_REQUEST["CostTypeId"]); ?></td>
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
    <th nowrap="nowrap">หมวดงบ/รายการค่าใช้จ่าย</th>
    <th style="width:10%;">งบประมาณ</th>
    <th style="width:10%;">งบ พ.ร.บ</th>
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




  <!--วน loop หมวดงบรายจ่าย-->
  <?php
  $NumCateMonth = 1; 
  $BGCateMonth = $get->getCostTypeRecordSet();
 // ltxt::print_r($BGCateMonth);
  foreach($BGCateMonth as $BGCateMonthRow){ 
  	foreach($BGCateMonthRow as $a=>$b){
		${$a} = $b;
	}
	$SumCostMonth=$get->getTotalPrjMonth($CostTypeId);
	if($SumCostMonth){ //check หมวดงบประมาณ
		$SumCostInternal=$get->getTotalPrjMonthInternal($CostTypeId);
  ?>
  
  <tr class="cate" style="vertical-align:top; font-weight:bold; background-color:#EEE;">
    <td><?php echo $NumCateMonth; ?>. <?php echo $CostTypeName; ?></td>
    <td class="sum-total" title="งบประมาณ"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td class="sum-total" title="งบ พ.ร.บ"><?php echo ($SumCostInternal > 0)?number_format($SumCostInternal,2):"-"; ?></td>
<?php 
$h=1;
foreach( $source2 as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostExternal=$get->getTotalPrjMonthExternal($CostTypeId,0,0,"",0,$SourceExId);
?>
<td class="sum-total" title="<?php echo $SourceExName; ?>"><?php echo ($SumCostExternal)?number_format($SumCostExternal,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    
    </tr>
    <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
    <?php
  $NumLevel1 = 1; 
  $BGLevel1 = $get->getCostItemRecordSet($CostTypeId);
 //ltxt::print_r($BGLevel1);
  foreach($BGLevel1 as $BGLevel1Row){ 
  	foreach($BGLevel1Row as $c=>$d){
		${$c} = $d;
	}
	$SumCostMonth=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	if($SumCostMonth){ //check รายการค่าใช้จ่าย level1
		$SumCostInternal=$get->getTotalPrjMonthInternal($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
  ?>

    <tr class="level1" style="vertical-align:top;">
      <td><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></td>
      <td class="sum-total" title="งบประมาณ"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
      <td class="sum-total" title="งบ พ.ร.บ"><?php echo ($SumCostInternal > 0)?number_format($SumCostInternal,2):"-"; ?></td>
<?php 
$h=1;
foreach( $source2 as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostExternal=$get->getTotalPrjMonthExternal($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,$SourceExId);
?>
<td class="sum-total" title="<?php echo $SourceExName; ?>"><?php echo ($SumCostExternal)?number_format($SumCostExternal,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    

    </tr>
    
    <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->
    <?php if($HasChild == Y){ ?>
    <!--วน loop รายการงบรายจ่าย ระดับที่ 2-->
    <?php
  $NumLevel2 = 1; 
  $BGLevel2 = $get->getCostItemRecordSet($CostTypeId,2,$CostItemCode);
  foreach($BGLevel2 as $BGLevel2Row){ 
  	foreach($BGLevel2Row as $e=>$f){
		${$e} = $f;
	}
	$SumCostMonth=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	if($SumCostMonth){ //check รายการค่าใช้จ่าย level2
		$SumCostInternal=$get->getTotalPrjMonthInternal($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
  ?>
 
    <tr class="level2" style="vertical-align:top;">
      <td><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></td>
      <td class="sum-total" title="งบประมาณ"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
      <td class="sum-total" title="งบ พ.ร.บ"><?php echo ($SumCostInternal > 0)?number_format($SumCostInternal,2):"-"; ?></td>
<?php 
$h=1;
foreach( $source2 as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostExternal=$get->getTotalPrjMonthExternal($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,$SourceExId);
?>
<td class="sum-total" title="<?php echo $SourceExName; ?>"><?php echo ($SumCostExternal)?number_format($SumCostExternal,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    

    </tr>
<!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->
<?php if($HasChild == Y){ ?>
<!--วน loop รายการงบรายจ่าย ระดับที่ 3-->
<?php
$NumLevel3 = 1; 
$BGLevel3 = $get->getCostItemRecordSet($CostTypeId,3,$CostItemCode);
foreach($BGLevel3 as $BGLevel3Row){ 
	foreach($BGLevel3Row as $g=>$h){
		${$g} = $h;
	}
	$SumCostMonth=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	if($SumCostMonth){ //check รายการค่าใช้จ่าย level3
		$SumCostInternal=$get->getTotalPrjMonthInternal($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
  ?>

    <tr class="level3" style="vertical-align:top;">
      <td><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?></td>
      <td class="sum-total" title="งบประมาณ"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
      <td class="sum-total" title="งบ พ.ร.บ"><?php echo ($SumCostInternal > 0)?number_format($SumCostInternal,2):"-"; ?></td>
<?php 
$h=1;
foreach( $source2 as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostExternal=$get->getTotalPrjMonthExternal($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,$SourceExId);
?>
<td class="sum-total" title="<?php echo $SourceExName; ?>"><?php echo ($SumCostExternal)?number_format($SumCostExternal,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    

    </tr>
    <?php 
  $NumLevel3++;
  } ?>
    <!--END วน loop รายการงบรายจ่าย ระดับที่ 3-->
    <?php } ?>
    <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->
    
 
    
    <?php 
  $NumLevel2++;
  } ?>
    <!--END วน loop รายการงบรายจ่าย ระดับที่ 2-->
<?php } //check รายการค่าใช้จ่าย level3?>
     
    
    <?php } ?>
    <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->
<?php } //check รายการค่าใช้จ่าย level2?>    
    

    <?php 
  $NumLevel1++;
  } ?>
    <!--END วน loop รายการงบรายจ่าย ระดับที่ 1-->
<?php } //check รายการค่าใช้จ่าย level1?>

    
  <?php 
  $NumCateMonth++;
  } ?>
<?php } //check หมวดงบประมาณ?>  
  <!--END วน loop หมวดงบรายจ่าย-->
  
<?php
	$SumCostMonth=$get->getTotalPrjMonth();
	$SumCostInternal=$get->getTotalPrjMonthInternal();
?>  
  
  
  
  <tr style="vertical-align:top; font-weight:bold; background-color:#CCC;">
    <td style="text-align:right;">รวมทั้งสิ้น</td>
    <td class="sum-total" title="งบประมาณ"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td class="sum-total" title="งบ พ.ร.บ"><?php echo ($SumCostInternal > 0)?number_format($SumCostInternal,2):"-"; ?></td>
<?php 
$h=1;
foreach( $source2 as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostExternal=$get->getTotalPrjMonthExternal(0,0,0,"",0,$SourceExId);
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
          
