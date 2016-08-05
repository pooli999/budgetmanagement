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
/*function Save(form){	
	form.submit();
}
*/
function Save(form){	
	var SumCost = parseInt($('SumCost').value);
	var Total = $('Total').value;
	if(Total > SumCost){
		alert("คุณกรอกรายการแจงเดือน/ไตรมาส สูงกว่าที่ตั้งไว้ กรุณากรอกยอดงบแจงเดือน/ไตรมาสให้ถูกต้อง");
		return false;
	}
	if(Total < SumCost){
		alert("คุณกรอกรายการแจงเดือน/ไตรมาส น้อยกว่าที่ตั้งไว้ กรุณากรอกยอดงบแจงเดือน/ไตรมาสให้ถูกต้อง");
		return false;
	}
	form.submit();
}
function loadSCT(PrjActId){
	var PrjActId = JQ('#PrjActId').val();
	JQ('#act').load('?mod=<?php echo lurl::dotPage("ajaxdata");?>&section=getCostDetail&format=raw&PrjActId=' + PrjActId);
}
function loadCost(CostIntId){
	var CostIntId = JQ('#CostIntId').val();
	window.location.href = '?mod=<?php echo lurl::dotPage("project_cost_add_internal_month");?>&CostItemId=<?php echo $_REQUEST["CostItemId"];?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"];?>&CostItemCode=<?php echo $_REQUEST["CostItemCode"];?>&ParentCode=<?php echo $_REQUEST["ParentCode"];?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"];?>&PrjId=<?php echo $_REQUEST["PrjId"];?>&CostIntId=' + CostIntId + '&PrjActId=' + JQ('#PrjActId').val();
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
    <td style="width:948px; text-align:left; font-weight:bold"><?php echo $get->getActName(ltxt::getVar('PrjDetailId'),ltxt::getVar('PrjActId'),'PrjActId');?>
    </td>
  </tr>
   <tr>
    <th style="width:200px; text-align:left">ระยะเวลากิจกรรม</th>
    <td><?php echo dateFormat($StartDate);?> <b>ถึง</b> <?php echo dateFormat($EndDate); ?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<td  style="padding-left:20px">งบประมาณแผ่นดิน</td>
</tr>
</table>

<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=savecostmonth" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>">
<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId'];?>">
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId'];?>">
<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $_REQUEST['PrjId'];?>">
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>">
<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
 <?php 
$data = $get->getCostItemDetail($_REQUEST["CostItemCode"]);
foreach($data as $row){
	foreach($row as $k=>$v){
		${$k} = $v;
	}
}
if($_REQUEST["CostIntId"]){
	$Budget10 = $get->getCostMonth($_REQUEST["CostIntId"],10); 
	$Budget11 = $get->getCostMonth($_REQUEST["CostIntId"],11); 
	$Budget12 = $get->getCostMonth($_REQUEST["CostIntId"],12); 
	$Sum1 = $Budget10+$Budget11+$Budget12;
	$Budget1 = $get->getCostMonth($_REQUEST["CostIntId"],1); 
	$Budget2 = $get->getCostMonth($_REQUEST["CostIntId"],2); 
	$Budget3 = $get->getCostMonth($_REQUEST["CostIntId"],3); 
	$Sum2 = $Budget1+$Budget2+$Budget3;
	$Budget4 = $get->getCostMonth($_REQUEST["CostIntId"],4); 
	$Budget5 = $get->getCostMonth($_REQUEST["CostIntId"],5); 
	$Budget6 = $get->getCostMonth($_REQUEST["CostIntId"],6); 
	$Sum3 = $Budget4+$Budget5+$Budget6;
	$Budget7 = $get->getCostMonth($_REQUEST["CostIntId"],7); 
	$Budget8 = $get->getCostMonth($_REQUEST["CostIntId"],8); 
	$Budget9 = $get->getCostMonth($_REQUEST["CostIntId"],9); 
	$Sum4 = $Budget7+$Budget8+$Budget9;
	$Total = $Sum1+$Sum2+$Sum3+$Sum4;
}
?>

 <tr>
   <th style="width:200px; text-align:left">หมวดงบประมาณ</th>
   <td style="width:948px; text-align:left; font-weight:bold"><?php echo $CostTypeName; ?></td>
 </tr>
 <tr>
   <th style="width:200px; text-align:left">รายการรายจ่าย</th>
   <td style="width:948px; text-align:left; font-weight:bold"><?php if($ParentCode){ echo $get->getCostName($ParentCode)." -> "; } ?><?php echo $CostName;?></td>
 </tr>
  <tr>
   <th style="width:200px; text-align:left">รายการชี้แจง</th>
   <td style="width:948px; text-align:left; font-weight:bold"><div id="act"><?php echo $get->getCostDetail(ltxt::getVar('PrjActId'),ltxt::getVar('CostIntId'),'CostIntId');?></div></td>
 </tr>
  <tr>
   <th style="width:200px; text-align:left">งบประมาณตัวคูณ 4 ช่อง</th>
   <?php $SumCost=$get->getcost($_REQUEST["CostIntId"]);?>
   <td style="width:948px; text-align:left; font-weight:bold">
   <input type="text"name="SumCost" id="SumCost" style="text-align:right; color:#990000;" value="<?php echo $SumCost; ?>" readonly="readonly"> 
   (<?php echo JThaiBaht::_($get->getcost($_REQUEST["CostIntId"])); ?>)</td>
 </tr>
 <tr>
 		<th colspan="2" style="text-align:left;">งบประมาณแจงรายเดือน/ไตรมาส</th> 
 </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
  <tr>
    <th width="118" style="width:100px;">ไตรมาสที่ 1</th>
    <td width="94" style="width:80px; text-align:center;">ต.ค/<?php echo ($BgtYear-1); ?></td>
    <td width="177" style="width:150px;">=
      <input type="text" name="Budget10"  id="Budget10" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget10)?$Budget10:0; ?>" onMouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/></td>
    <td width="94" style="width:80px; text-align:center;">พ.ย/<?php echo ($BgtYear-1); ?></td>
    <td width="177" style="width:150px;"> =
      <input type="text" name="Budget11"  id="Budget11" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget11)?$Budget11:0; ?>" onMouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/></td>
    <td width="94" style="width:80px; text-align:center;">ธ.ค/<?php echo ($BgtYear-1); ?></td>
    <td width="150" style="width:150px;"> =
      <input type="text" name="Budget12"  id="Budget12" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget12)?$Budget12:0; ?>" onMouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/></td>
    <td width="284" style="text-align:right;"><input type="text" name="Sum1" id="Sum1" class="number" style="width:100px;" readonly="yes" value="<?php echo ($Sum1)?$Sum1:0; ?>" onMouseover="showhint('ผลรวมงบประมาณไตรมาส 1', this, event, '250px')"/> </td>
  </tr>
  <tr>
    <th>ไตรมาสที่ 2</th>
    <td style="text-align:center;">ม.ค/<?php echo $BgtYear; ?></td>
    <td>= 
      <span style="width:150px;">
      <input type="text" name="Budget1"  id="Budget1" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget1)?$Budget1:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:center;">ก.พ/<?php echo $BgtYear; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget2"  id="Budget2" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget2)?$Budget2:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:center;">มี.ค/<?php echo $BgtYear; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget3"  id="Budget3" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget3)?$Budget3:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:right;"><input type="text" name="Sum2" id="Sum2" class="number" style="width:100px;" readonly="readonly" value="<?php echo ($Sum2)?$Sum2:0; ?>" onmouseover="showhint('ผลรวมงบประมาณไตรมาส 2', this, event, '250px')"/></td>
  </tr>
  <tr>
    <th>ไตรมาสที่ 3</th>
    <td style="text-align:center;">เม.ย/<?php echo $BgtYear; ?></td>
    <td>= 
      <span style="width:150px;">
      <input type="text" name="Budget4"  id="Budget4" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget4)?$Budget4:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:center;">พ.ค/<?php echo $BgtYear; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget5"  id="Budget5" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget5)?$Budget5:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:center;"> มิ.ย/<?php echo $BgtYear; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget6"  id="Budget6" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget6)?$Budget6:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:right;"><input type="text" name="Sum3" id="Sum3" class="number" style="width:100px;" readonly="readonly" value="<?php echo ($Sum3)?$Sum3:0; ?>" onmouseover="showhint('ผลรวมงบประมาณไตรมาส 3', this, event, '250px')"/></td>
  </tr>
  <tr>
    <th>ไตรมาสที่ 4</th>
    <td style="text-align:center;">ก.ค/<?php echo $BgtYear; ?></td>
    <td>= 
      <span style="width:150px;">
      <input type="text" name="Budget7"  id="Budget7" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget7)?$Budget7:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:center;">ส.ค/<?php echo $BgtYear; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget8"  id="Budget8" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget7)?$Budget7:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:center;">ก.ย/<?php echo $BgtYear; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget9"  id="Budget9" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget9)?$Budget9:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:right;"><input type="text" name="Sum4" id="Sum4" class="number" style="width:100px;" readonly="readonly" value="<?php echo ($Sum4)?$Sum4:0; ?>" onmouseover="showhint('ผลรวมงบประมาณไตรมาส 4', this, event, '250px')"/></td>
    </tr>
    <tr>
    <td colspan="7" style="text-align:right; font-weight:bold;" align="right">&nbsp;</td>
    <td style="text-align:right; font-weight:bold;">รวมทั้งสิ้น <span style="text-align:right;">
      <input type="text" name="Total" id="Total" class="number" style="width:100px; color:#990000;" readonly="readonly" value="<?php echo ($Total)?$Total:0; ?>" onmouseover="showhint('ผลรวมงบประมาณทั้งสิ้น', this, event, '250px')"/>
    </span></td>
    </tr>
</table>

<div style="text-align:center; margin-top:10px; margin-bottom:30px;">
<input type="submit" class="btnActive" name="save" id="save" value="บันทึก"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="window.location.href='?mod=<?php echo LURL::dotPage($addPage); ?>&PrjId=<?php echo $PrjId; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>&CostItemCode=<?php echo $CostItemCode; ?>&BgtYear=<?php echo $BgtYear; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>'" />
</div>
</form>

<script>
function CalSum(){
	
	
	var Month10 = $('Budget10').value;
	var Month11 = $('Budget11').value;
	var Month12 = $('Budget12').value;
	var Budget1 = (Month10*1)+(Month11*1)+(Month12*1);
		
	var Month1 = $('Budget1').value;
	var Month2 = $('Budget2').value;
	var Month3 = $('Budget3').value;
	var Budget2 = (Month1*1)+(Month2*1)+(Month3*1);
	
	var Month4 = $('Budget4').value;
	var Month5 = $('Budget5').value;
	var Month6 = $('Budget6').value;
	var Budget3 = (Month4*1)+(Month5*1)+(Month6*1);
	
	var Month7 = $('Budget7').value;
	var Month8 = $('Budget8').value;
	var Month9 = $('Budget9').value;
	var Budget4 = (Month7*1)+(Month8*1)+(Month9*1);
	
	var Total = (Budget1*1)+(Budget2*1)+(Budget3*1)+(Budget4*1);
	
	$('Sum1').value = Budget1;
	$('Sum2').value = Budget2;
	$('Sum3').value = Budget3;
	$('Sum4').value = Budget4;
	$('Total').value = Total;

}
</script>
