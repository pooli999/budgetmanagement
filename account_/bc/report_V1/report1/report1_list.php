<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));
$this->DOC->setPathWays(array(
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
	window.location.href="?mod=<?php echo LURL::dotPage('report1_print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('report1_excel')?>&format=raw<?php echo $get->getQueryString(); ?>";
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
		  url: "?mod=<?php echo LURL::dotPage('report1_action');?>",		   
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
		  url: "?mod=<?php echo LURL::dotPage('report1_action');?>",		   
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
		  url: "?mod=<?php echo LURL::dotPage('report1_action');?>",		   
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
		  url: "?mod=<?php echo LURL::dotPage('report1_action');?>",		   
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
		  url: "?mod=<?php echo LURL::dotPage('report1_action');?>",		   
		  data: "action=getprjactlist&PrjDetailId="+PrjDetailId,
		  success: function(msg){
			JQ("#prj-act").html(msg);
		  }
	});

}


function loadExternalType(ExType){
	if(ExType=='External'){
		document.getElementById('source').innerHTML='<span class="icon-load">กรุณารอสักครู่</span>';
		JQ.ajax({
			  type: "POST",
			  url: "?mod=<?php echo LURL::dotPage('report1_action');?>",		   
			  data: "action=getsourcelist",
			  success: function(msg){
				JQ("#source").html(msg);
			  }
		});
	}else{
		JQ("#source").html('');
	}

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
<input type="hidden" name="mod" id="mod" value="<?php echo LURL::dotPage('report1_list');?>" />
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
	<th>แหล่งงบประมาณ</th>
	<td>&nbsp;</td>
	<td>
<select name="ExType" id="ExType" onchange="loadExternalType(this.value)">
	<option value="0" <?php if($_REQUEST["ExType"]=="0"){ ?> selected="selected" <?php } ?>>ทั้งหมด</option>
	<option value="Internal" <?php if($_REQUEST["ExType"]=="Internal"){ ?> selected="selected" <?php } ?>>งบแผ่นดิน</option>
	<option value="External" <?php if($_REQUEST["ExType"]=="External"){ ?> selected="selected" <?php } ?>>เงินนอกงบ</option>
</select>   
<span id="source"><?php if($_REQUEST["ExType"] == "External"){ ?>ระบุ <?php echo $get->getSourceExternal($_REQUEST["SourceExId"]);?><?php } ?></span>
    </td>
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
<?php if($_REQUEST["ExType"]){ ?>
<tr>
	<th>แหล่งงบประมาณ</th>
	<td>&nbsp;</td>
	<td>
<?php
switch($_REQUEST["ExType"]){
	case "Internal":
		echo "งบแผ่นดิน";
	break;
	case "External":
		echo "เงินนอกงบ";
		if($_REQUEST["SourceExId"]){
			echo " (".$get->getSourceExName($_REQUEST["SourceExId"]).")";
		}
	break;
}
?>	
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



<table width="100%" border="1" class="tbl-list"  cellspacing="1" cellpadding="0">
  <tr>
    <th rowspan="2" nowrap="nowrap">หมวดงบ/รายการค่าใช้จ่าย</th>
    <th rowspan="2" style="width:80px;">งบประมาณ<br />(บาท)</th>
    <th colspan="3">ไตรมาส1</th>
    <th colspan="3">ไตรมาส2</th>
    <th colspan="3">ไตรมาส3</th>
    <th colspan="3">ไตรมาส4</th>
    </tr>
  <tr>
    <th style="width:6%;">ต.ค</th>
    <th style="width:6%;">พ.ย</th>
    <th style="width:6%;">ธ.ค</th>
    <th style="width:6%;">ม.ค</th>
    <th style="width:6%;">ก.พ</th>
    <th style="width:6%;">มี.ค</th>
    <th style="width:6%;">เม.ย</th>
    <th style="width:6%;">พ.ค</th>
    <th style="width:6%;">มิ.ย</th>
    <th style="width:6%;">ก.ค</th>
    <th style="width:6%;">ส.ค</th>
    <th style="width:6%;">ก.ย</th>
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
		//ไตรมาสที่ 1	
		$SumCostMonth10=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,10);
		$SumCostMonth11=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,11);
		$SumCostMonth12=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,12);
	
		//ไตรมาสที่ 2	
		$SumCostMonth1=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,1);
		$SumCostMonth2=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,2);
		$SumCostMonth3=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,3);
	
		//ไตรมาสที่ 3
		$SumCostMonth4=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,4);
		$SumCostMonth5=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,5);
		$SumCostMonth6=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,6);
	
		//ไตรมาสที่ 4	
		$SumCostMonth7=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,7);
		$SumCostMonth8=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,8);
		$SumCostMonth9=$get->getTotalPrjMonth($CostTypeId,0,0,0,0,9);	

  ?>
  
  <tr class="cate" style="vertical-align:top; font-weight:bold; background-color:#EEE;">
    <td><?php echo $NumCateMonth; ?>. <?php echo $CostTypeName; ?></td>
    <td class="sum-total" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td class="sum-total" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td class="sum-total" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td class="sum-total" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
    <td class="sum-total" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td class="sum-total" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td class="sum-total" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
    <td class="sum-total" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td class="sum-total" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td class="sum-total" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
    <td class="sum-total" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td class="sum-total" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td class="sum-total" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
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
		//ไตรมาสที่ 1	
		$SumCostMonth10=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,10);
		$SumCostMonth11=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,11);
		$SumCostMonth12=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,12);
	
		//ไตรมาสที่ 2	
		$SumCostMonth1=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,1);
		$SumCostMonth2=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,2);
		$SumCostMonth3=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,3);
	
		//ไตรมาสที่ 3
		$SumCostMonth4=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,4);
		$SumCostMonth5=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,5);
		$SumCostMonth6=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,6);
	
		//ไตรมาสที่ 4	
		$SumCostMonth7=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,7);
		$SumCostMonth8=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,8);
		$SumCostMonth9=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,9);


  ?>

    <tr class="level1" style="vertical-align:top;">
      <td><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></td>
      <td class="sum-total" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
      <td class="sum-total" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
      <td class="sum-total" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
      <td class="sum-total" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
      <td class="sum-total" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
      <td class="sum-total" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
      <td class="sum-total" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
      <td class="sum-total" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
      <td class="sum-total" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
      <td class="sum-total" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
      <td class="sum-total" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
      <td class="sum-total" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
      <td class="sum-total" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
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
		//ไตรมาสที่ 1	
		$SumCostMonth10=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,10);
		$SumCostMonth11=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,11);
		$SumCostMonth12=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,12);
	
		//ไตรมาสที่ 2	
		$SumCostMonth1=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,1);
		$SumCostMonth2=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,2);
		$SumCostMonth3=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,3);
	
		//ไตรมาสที่ 3
		$SumCostMonth4=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,4);
		$SumCostMonth5=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,5);
		$SumCostMonth6=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,6);
	
		//ไตรมาสที่ 4	
		$SumCostMonth7=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,7);
		$SumCostMonth8=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,8);
		$SumCostMonth9=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,9);
  ?>
 
    <tr class="level2" style="vertical-align:top;">
      <td><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></td>
      <td class="sum-total" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
      <td class="sum-total" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
      <td class="sum-total" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
      <td class="sum-total" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
      <td class="sum-total" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
      <td class="sum-total" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
      <td class="sum-total" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
      <td class="sum-total" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
      <td class="sum-total" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
      <td class="sum-total" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
      <td class="sum-total" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
      <td class="sum-total" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
      <td class="sum-total" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
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
		//ไตรมาสที่ 1	
		$SumCostMonth10=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,10);
		$SumCostMonth11=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,11);
		$SumCostMonth12=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,12);
	
		//ไตรมาสที่ 2	
		$SumCostMonth1=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,1);
		$SumCostMonth2=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,2);
		$SumCostMonth3=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,3);
	
		//ไตรมาสที่ 3
		$SumCostMonth4=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,4);
		$SumCostMonth5=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,5);
		$SumCostMonth6=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,6);
	
		//ไตรมาสที่ 4	
		$SumCostMonth7=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,7);
		$SumCostMonth8=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,8);
		$SumCostMonth9=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,9);
  ?>

    <tr class="level3" style="vertical-align:top;">
      <td><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?></td>
      <td class="sum-total" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
      <td class="sum-total" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
      <td class="sum-total" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
      <td class="sum-total" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
      <td class="sum-total" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
      <td class="sum-total" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
      <td class="sum-total" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
      <td class="sum-total" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
      <td class="sum-total" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
      <td class="sum-total" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
      <td class="sum-total" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
      <td class="sum-total" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
      <td class="sum-total" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
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

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjMonth(0,0,0,0,0,10);
	$SumCostMonth11=$get->getTotalPrjMonth(0,0,0,0,0,11);
	$SumCostMonth12=$get->getTotalPrjMonth(0,0,0,0,0,12);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjMonth(0,0,0,0,0,1);
	$SumCostMonth2=$get->getTotalPrjMonth(0,0,0,0,0,2);
	$SumCostMonth3=$get->getTotalPrjMonth(0,0,0,0,0,3);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjMonth(0,0,0,0,0,4);
	$SumCostMonth5=$get->getTotalPrjMonth(0,0,0,0,0,5);
	$SumCostMonth6=$get->getTotalPrjMonth(0,0,0,0,0,6);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjMonth(0,0,0,0,0,7);
	$SumCostMonth8=$get->getTotalPrjMonth(0,0,0,0,0,8);
	$SumCostMonth9=$get->getTotalPrjMonth(0,0,0,0,0,9);
?>  
  
  
  
  <tr style="vertical-align:top; font-weight:bold; background-color:#CCC;">
    <td style="text-align:right;">รวมทั้งสิ้น</td>
    <td class="sum-total" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td class="sum-total" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td class="sum-total" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td class="sum-total" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
    <td class="sum-total" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td class="sum-total" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td class="sum-total" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
    <td class="sum-total" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td class="sum-total" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td class="sum-total" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
    <td class="sum-total" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td class="sum-total" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td class="sum-total" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
  </tr>
</table>


<?php }else{ ?>
<div class="nullDataList">กรุณาระบุเงื่อนไขในการแสดงรายงาน</div>
<?php } ?>
</div><!--<div id="c-report">-->
<br />
<br />
<br />
          
