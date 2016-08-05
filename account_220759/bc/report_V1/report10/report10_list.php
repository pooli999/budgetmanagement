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
	window.location.href="?mod=<?php echo LURL::dotPage('report10_print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('report10_excel')?>&format=raw<?php echo $get->getQueryString(); ?>";
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
		  url: "?mod=<?php echo LURL::dotPage('report10_action');?>",		   
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
		  url: "?mod=<?php echo LURL::dotPage('report10_action');?>",		   
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
		  url: "?mod=<?php echo LURL::dotPage('report10_action');?>",		   
		  data: "action=getorglist&BgtYear="+BgtYear,
		  success: function(msg){
			JQ("#org").html(msg);
		  }
	});
	
}

function loadExternalType(ExType){
	if(ExType=='External'){
		document.getElementById('source').innerHTML='<span class="icon-load">กรุณารอสักครู่</span>';
		JQ.ajax({
			  type: "POST",
			  url: "?mod=<?php echo LURL::dotPage('report10_action');?>",		   
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
<input type="hidden" name="mod" id="mod" value="<?php echo LURL::dotPage('report10_list');?>" />
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


<style>
.tbl-list td {
	padding:5px;
}
</style>
<table width="100%" border="1" class="tbl-list"  cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">



  <!--วน loop แผนงาน สช.-->
  <?php
  $nPlan = 1; 
  $recPlan = $get->getPItemRecordSet();//ltxt::print_r($recPlan);
  foreach($recPlan as $recPlanRow){ 
  	foreach($recPlanRow as $a=>$b){
		${$a} = $b;
	}

  ?>
  
  <tr class="cate" style="vertical-align:top; background-color:#3ad531; font-weight:bold; font-size:16px;">
    <td colspan="3"><?php echo $nPlan; ?>. <?php echo $PItemName; ?></td>
    </tr>
    
  <tr class="cate" style="vertical-align:top; background-color:#abdb92; font-weight:bold;">
    <td style="text-align:center;">เป้าประสงค์ของแผนงาน</td>
    <td colspan="2" style="text-align:center;">ตัวชี้วัดความสำเร็จของแผนงาน</td>
 </tr>
 
 
   <tr class="cate" style="vertical-align:top; background-color:#abdb92;">
    <td>
    
 <?php
$pp = 1; 
$dataPurpose = $get->getPurposeItem($PItemCode);//ltxt::print_r($recIndPlan);
foreach($dataPurpose as $dataPurposeRow){
		foreach( $dataPurposeRow as $e=>$w){ ${$e} = $w;}
		echo '<div>'.$pp.'. '.$PurposeName.'</div>';
		$pp++;
 }


  ?>   
    
    </td>
    <td colspan="2">
 
 <?php
$nIncPlan = 1; 
$recIndPlan = $get->getIndPlanRecordSet($PItemCode);//ltxt::print_r($recIndPlan);
foreach($recIndPlan as $recIndPlanRow){ 
  	foreach($recIndPlanRow as $ac1=>$ac2){ ${$ac1} = $ac2; }
		echo '<div>'.$nIncPlan.'. ('.$PIndCode.') '.$PIndName.'</div>';
		$nIncPlan++;
 }


  ?>    
  
    
    </td>
 </tr>


  
  
  
  
  
  
<!-- วนลูปโครงการ --> 
  <?php
  $nProject = 1; 
  $recProject = $get->getProjectRecordSet($PItemCode);//ltxt::print_r($recProject);
  foreach($recProject as $recProjectRow){ 
  	foreach($recProjectRow as $m=>$d){
		${$m} = $d;
	}


  ?>
  
  <tr class="cate" style="vertical-align:top; background-color:#8add66; font-weight:bold;">
    <td colspan="3"><?php echo $nPlan; ?>.<?php echo $nProject; ?> <?php echo $PrjName; ?></td>
    </tr>
    
    
    
  <tr class="cate" style="vertical-align:top; font-weight:bold; background-color:#DDD;">
    <td style="text-align:center;">วัตถุประสงค์</td>
    <td colspan="2" style="text-align:center;">ตัวชี้วัดความสำเร็จของโครงการ</td>
 </tr>
 
   <tr class="cate" style="vertical-align:top; background-color:#EEE;">
    <td><?php echo (trim($Purpose))?(trim($Purpose)):"-ไม่ระบุ-"; ?></td>
    <td colspan="2">

<?php
$nIncPrj = 1; 
$recIndPrj = $get->getIndPrjRecordSet($PrjDetailId);//ltxt::print_r($recIndPrj);
foreach($recIndPrj as $recIndPrjRow){ 
  	foreach($recIndPrjRow as $ab1=>$ab2){ ${$ab1} = $ab2; }
		echo '<div>'.$nIncPrj.'. ('.$IndicatorCode.') '.$IndicatorName.'</div>';
		$nIncPrj++;
 }


  ?>    
    
    </td>
 </tr>

  <tr style="font-weight:bold; background-color:#DDD;">
    <td style="text-align:center;">กิจกรรม</td>
    <td style="text-align:center;">เป้าหมาย</td>
    <td style="text-align:center; width:150px;">งบประมาณ</td>
    </tr>

  
  
  <!-- วนลูปกิจกรรม --> 
  <?php
  $totalSumCostMonth = 0;
  $nAct = 1; 
  $recAct = $get->getActRecordSet($PrjDetailId);//ltxt::print_r($recPlan);
  foreach($recAct as $recActRow){ 
  	foreach($recActRow as $w=>$q){
		${$w} = $q;
	}
	$SumCostMonth=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId);
	$totalSumCostMonth = $totalSumCostMonth+$SumCostMonth;
	$totalSumCostMonth = number_format($totalSumCostMonth,0,'.','');

  ?>
  
  <tr class="cate" style="vertical-align:top; background-color:#EEE;">
    <td><?php echo $nAct; ?>. <?php echo $PrjActName; ?></td>
    <td>
    
<?php
$nIncAct = 1; 
$recIndAct = $get->getIndActRecordSet($PrjActId);//ltxt::print_r($recIndAct);
foreach($recIndAct as $recIndActRow){ 
  	foreach($recIndActRow as $a1=>$a2){ ${$a1} = $a2; }
		echo '<div>'.$nIncAct.'. '.$IndicatorName.'</div>';
		$nIncAct++;
 }


  ?>    
    
    
    </td>
    <td style="text-align:right;"><?php echo number_format($SumCostMonth,2); ?></td>
    </tr>
  <?php 
  $nAct++;
  } 
  ?>
<!--END วนลูปกิจกรรม-->

  
  
  
   <tr style="vertical-align:top; background-color:#DDD; font-weight:bold;">
    <td colspan="2" style="text-align:right;"><span style="font-weight:normal;">(<?php echo JThaiBaht::_($totalSumCostMonth); ?>)</span> รวมทั้งสิ้น</td>
    <td style="text-align:right;"><?php echo number_format($totalSumCostMonth,2); ?></td>
    </tr> 
  
  
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


</table>

<?php }else{ ?>
<div class="nullDataList">กรุณาระบุเงื่อนไขในการแสดงรายงาน</div>
<?php } ?>
</div><!--<div id="c-report">-->

<br />
<br />
<br />
          
