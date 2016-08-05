<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));

?>


<script type="text/javascript">
function Save(form){	
	form.submit();
}
</script>
<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
 <tr>
 <?php
 $datas = $get->getActivityDetail($_REQUEST["$PrjDetailId"],$_REQUEST["PrjActId"]);
foreach($datas as $actdatas){
	foreach($actdatas as $k=>$v){
		${$k} = $v;
	}
}
?>
   <th style="width:200px; text-align:left">ปีงบประมาณ</th>
   <td style="width:948px; text-align:left; font-weight:bold"><?php echo $BgtYear;?></td>
 </tr>
 <tr>
    <th style="width:200px; text-align:left">ชื่อโครงการ</th>
    <td style="width:948px; text-align:left; font-weight:bold"><?php echo $PrjName;?></td>
  </tr>
  <tr>
    <th style="width:200px; text-align:left">ชื่อกิจกรรม</th>
    <td style="width:948px; text-align:left; font-weight:bold"><?php echo $get->getActName($_REQUEST['PrjDetailId'],$_REQUEST['PrjActId']);?></td>
  </tr>
   <tr>
    <th style="width:200px; text-align:left">ระยะเวลากิจกรรม</th>
    <td><?php echo dateFormat($StartDate);?> <b>ถึง</b> <?php echo dateFormat($EndDate); ?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<?php
$SourceExName=$get->getSourceExName($_REQUEST['SourceExId']);
?>
<td  style="padding-left:20px">งบอุดหนุน <?php echo $SourceExName;?></td>
</tr>
</table>
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=savecostex" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $BgtYear;?>">
<input type="hidden" name="SourceExId" id="SourceExId" value="<?php echo $_REQUEST["SourceExId"];?>">
<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId'];?>">
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId'];?>">
<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $_REQUEST['PrjId'];?>">
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-item" >
 <?php 
$data = $get->getCostItemDetail($_REQUEST["CostItemCode"]);
foreach($data as $row){
	foreach($row as $k=>$v){
		${$k} = $v;
	}
}
?>

 <tr>
   <th style="width:200px; text-align:left">หมวดงบประมาณ</th>
   <td style="width:948px; text-align:left; font-weight:bold"><?php echo $CostTypeName; ?></td>
 </tr>
 <tr>
   <th style="width:200px; text-align:left">รายการค่าใช้จ่าย</th>
   <td style="width:948px; text-align:left; font-weight:bold"><?php if($ParentCode){ echo $get->getCostName($ParentCode)." -> "; } ?><?php echo $CostName;?></td>
 </tr>
  <tr>
   <th style="width:200px; text-align:left">งบประมาณที่ได้รับจัดสรร</th>
   <td style="width:948px; text-align:left; font-weight:bold"><?php echo number_format($get->getTotalPrjInternalX4($BgtYear,0,0,$PrjId,$PrjDetailId,$PrjActId,0,0),2); ?> บาท </td>
 </tr>
</table>


<table width="98%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
	<tr>
		<th width="212" rowspan="2" style="text-align:center; vertical-align:middle; width:200px;">รายการชี้แจง</th>
		<th colspan="2" style="width:140px;">ปริมาณ1</th>
		<th colspan="2" style="width:140px;">ปริมาณ2</th>
		<th colspan="2" style="width:140px;">ปริมาณ3</th>
		<th colspan="2" style="width:140px;">ปริมาณ4</th>
		<th width="131" rowspan="2" style="vertical-align:middle; width:140px;">งบประมาณ<br />
	  (บาท)</th>
		<th width="99" rowspan="2" style="width:60px;">ลบทิ้ง</th>
    </tr>
	  <tr>
		<th width="79" style="width:60px;">จำนวน</th>
		<th width="104" style="width:80px;">หน่วยนับ</th>
		<th width="79" style="width:60px;">จำนวน</th>
		<th width="104" style="width:80px;">หน่วยนับ</th>
		<th width="79" style="width:60px;">จำนวน</th>
		<th width="104" style="width:80px;">หน่วยนับ</th>
		<th width="79" style="width:60px;">จำนวน</th>
		<th width="104" style="width:80px;">หน่วยนับ</th>
	</tr>
<tr>
    <td colspan="11">
        <div id="MoreFile2Store" class="hide">
    <div>
    <input type="text" name="Detail[]"  size="30" value="<?php echo $Detail; ?>" style="width:190px" />
    <input  name="Value1[]" rel="Value1" type="text" size="3" value="0"class="number"style="text-align:right; width:55px;"onkeyup="CalSum()"/>
    <select name="UnitId1[]" style="width:82px">
    <option value=<?php echo $get->getUnit($Unit1,"Unit1[]"); ?></option>
    </select>
	<input  name="Value2[]" rel="Value2" type="text" size="3" value="1"class="number"style="text-align:right; width:55px;"onkeyup="CalSum()"/>
    <select name="UnitId2[]" style="width:82px">
    <option value=<?php echo $get->getUnit($Unit2,"Unit2[]"); ?></option>
    </select>
	<input  name="Value3[]" rel="Value3" type="text" size="3" value="1"class="number"style="text-align:right; width:55px;"onkeyup="CalSum()" />
    <select name="UnitId3[]" style="width:85px">
    <option value=<?php echo $get->getUnit($Unit3,"Unit3[]"); ?></option>
    </select>
	<input  name="Value4[]" rel="Value4" type="text" size="3" value="1"class="number"style="text-align:right; width:55px;"onkeyup="CalSum()"/>
    <select name="UnitId4[]" style="width:85px">
    <option value=<?php echo $get->getUnit($Unit4,"Unit4[]"); ?></option>
    </select>
	<input name="SumCost[]" rel="SumCost" type="text" size="12" readonly="yes" value="0.00"style="text-align:right; width:130px;"  />
	<a href="javascript:void(0)" onclick="if(JQ('#MoreFile2 div').length > 1) JQ(this).parent('div').remove()" class="ico delete">ลบทิ้ง</a>
    </div>
</div>
    <div id="MoreFile2">
   <?php
$DItem = $get->getItemRequireExternal($CostItemCode,$_REQUEST["PrjActId"],$_REQUEST["SourceExId"]);
foreach($DItem as $dRow){
	foreach($dRow as $k=>$v){
		${$k} = $v;
	}
?>	
    <div>
    <input type="text" name="Detail[]"  size="30" value="<?php echo $Detail; ?>" style="width:190px" />
    <input  name="Value1[]" rel="Value1" type="text" size="3" value="<?php echo $Value1; ?>"class="number"style="text-align:right; width:55px;"onkeyup="CalSum()"/>
    <select name="UnitId1[]" style="width:82px">
    <option value=<?php echo $get->getUnit($Unit1,"Unit1[]"); ?></option>
    </select>
	<input  name="Value2[]" rel="Value2" type="text" size="3" value="<?php echo $Value2; ?>"class="number"style="text-align:right; width:55px;"onkeyup="CalSum()"/>
    <select name="UnitId2[]" style="width:82px">
    <option value=<?php echo $get->getUnit($Unit2,"Unit2[]"); ?></option>
    </select>
	<input  name="Value3[]" rel="Value3" type="text" size="3" value="<?php echo $Value3; ?>"class="number"style="text-align:right; width:55px;"onkeyup="CalSum()" />
    <select name="UnitId3[]" style="width:85px">
    <option value=<?php echo $get->getUnit($Unit3,"Unit3[]"); ?></option>
    </select>
	<input  name="Value4[]" rel="Value4" type="text" size="3" value="<?php echo $Value4; ?>"class="number"style="text-align:right; width:55px;"onkeyup="CalSum()"/>
    <select name="UnitId4[]" style="width:85px">
    <option value=<?php echo $get->getUnit($Unit4,"Unit4[]"); ?></option>
    </select>
	<input name="SumCost[]" rel="SumCost" type="text" size="12" readonly="yes" value="<?php echo $SumCost; ?>"style="text-align:right; width:130px;"  />
	<a href="javascript:void(0)" onclick="if(JQ('#MoreFile2 div').length > 1) JQ(this).parent('div').remove()" class="ico delete">ลบทิ้ง</a>
	</div>
  <?php
  }
?>
    </div>
    <br />
      <div style="padding-top:3px; width:1000px; text-align:right">
    <input name="new" type="button" value="เพิ่มรายการ" onClick="CreateElementStroe('MoreFile2','MoreFile2Store')" />
      </div>
</td>
 </table>

<input type="hidden" name="CostTypeId" id="CostTypeId" value="<?php echo $CostTypeId; ?>" />
<input type="hidden" name="CostItemCode" id="CostItemCode" value="<?php echo $CostItemCode; ?>" />
<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId'];?>">
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId'];?>">


<div style="text-align:center; margin-top:10px; margin-bottom:30px;">
<input type="submit" class="btnActive" name="save" id="save" value="บันทึก"  />
<input type="hidden" name="CostExtId" id="CostExtId" value="<?php echo $CostExtId;?>">
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="window.location.href='?mod=<?php echo LURL::dotPage($addPage); ?>&PrjId=<?php echo $PrjId; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>&CostItemCode=<?php echo $CostItemCode; ?>&BgtYear=<?php echo $BgtYear; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>'" />
</div>
</form>
<script>
function CalSum(){
	var sumTotal=0;
	var Value1 = $(document.body).getElements('input[rel=Value1]');
	var Value2 = $(document.body).getElements('input[rel=Value2]');
	var Value3 = $(document.body).getElements('input[rel=Value3]');
	var Value4 = $(document.body).getElements('input[rel=Value4]');
	var SumCost = $(document.body).getElements('input[rel=SumCost]');
	SumCost.each(function(item,index){
		var Val1 = parseFloat(Value1[index].value);
		var Val2 = parseFloat(Value2[index].value);
		var Val3 = parseFloat(Value3[index].value);
		var Val4 = parseFloat(Value4[index].value);
		item.value = parseFloat(Val1*Val2*Val3*Val4).Money(2);
		sumTotal += parseFloat(Val1*Val2*Val3*Val4);
	});
	var total = sumTotal.Money(2);
	$('total').set('html',total);
	$('totalText').set('html',JThaiBaht(total));
}


</script>

