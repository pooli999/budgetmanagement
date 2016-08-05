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

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 


?>


<script type="text/javascript">
/*function Save(form){	
	form.submit();
}
*/
function Save(form){	
	form.submit();
}

</script>
<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับบันทึกรายการค่าใช้จ่าย<?php echo $MenuName;?> </div>
</div>
 <?php
$datas = $get->getActivityDetail($_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);//ltxt::print_r($datas);
foreach($datas as $actdatas){
	foreach($actdatas as $k=>$v){
		${$k} = $v;
	}
}
?>

<div class="topic-step"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>
<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td align="right">
		<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ListViewCostMonthEx); ?>&PrjActId=<?php echo $_REQUEST["PrjActId"]; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>CostItemCode=<?php echo $_REQUEST["CostItemCode"]; ?>&SourceExId=<?php echo $_REQUEST["SourceExId"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>'" />    
      </td>
    </tr>
  </table>  
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th >ปีงบประมาณ</th>
    <td><?php echo $BgtYear;?></td>
  </tr>
  <tr>
    <th>ภายใต้แผนงาน</th>
    <td id="plan">(<?php echo $PItemCode; ?>)&nbsp;<?php echo $get->getPItemCode($PItemCode);?></td>
  </tr>
  <tr>
    <th>ชื่อโครงการ</th>
    <td id="prj">(<?php echo $PrjCode; ?>)&nbsp;<?php echo $PrjName;?></td>
  </tr>
  <tr>
    <th>ระยะเวลาการดำเนินโครงการ</th>
    <td><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td>
  </tr>
  <tr>
    <th valign="top">หน่วยงานที่รับผิดชอบ</th>
    <td><?php echo $get->getOrgName($BgtYear, $OrganizeCode);?></td>
  </tr>
  <tr>
    <th valign="top">ผู้รับผิดชอบโครงการ</th>
    <td ><?php 
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
        
       ?></td>
  </tr>
  <tr>
    <th>ชื่อกิจกรรม</th>
    <td style="text-align:left; font-weight:bold; color:#990000;"><?php echo $PrjActName?></td>
  </tr>
  <tr>
    <th>ระยะเวลากิจกรรม</th>
    <td><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td>
  </tr>
</table>
<div class="boxfilter2">
  <div class="icon-topic">รายละเอียดแจงเดือนของตัวชี้วัดกิจกรรม</div></div>

<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=savecostmonthex" onSubmit="Save(this);return false;" enctype="multipart/form-data">

<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list" >
<?php 
$indicatorSelect = $get->getIndicatorActSelect($PrjActId);//ltxt::print_r($indicatorSelect);
foreach($indicatorSelect as $r){
    foreach( $r as $k=>$v){ ${$k} = $v;}
}
	 
?>

 <tr>
   <th style="width:200px; text-align:left">ชื่อตัวชี้วัด</th>
   <td style="width:948px; text-align:left;"><?php echo $IndicatorName; ?></td>
 </tr>
 <tr>
   <th style="width:200px; text-align:left">ประเภทตัวชี้วัด</th>
   <td style="width:948px; text-align:left;"><?php echo $IndTypeName; ?></td>
 </tr>
 <tr>
   <th style="width:200px; text-align:left">ค่าเป้าหมาย</th>
   <td style="width:948px; text-align:left;">
   <?php echo $Value; ?>&nbsp;<?php echo $UnitName; ?>&nbsp;<span class="hint">(ให้กรอกเป็นยอดแบบสะสม)</span>
   </td>
 </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
  <tr>
    <th width="118" style="width:100px;">ไตรมาสที่ 1</th>
    <td width="94" style="width:80px; text-align:center;">ต.ค/<?php echo ($_REQUEST["BgtYear"]-1); ?></td>
    <td width="177" style="width:150px;">=
      <input type="text" name="Budget10"  id="Budget10" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget10)?$Budget10:0; ?>" onMouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/></td>
    <td width="94" style="width:80px; text-align:center;">พ.ย/<?php echo ($_REQUEST["BgtYear"]-1); ?></td>
    <td width="177" style="width:150px;"> =
      <input type="text" name="Budget11"  id="Budget11" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget11)?$Budget11:0; ?>" onMouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/></td>
    <td width="94" style="width:80px; text-align:center;">ธ.ค/<?php echo ($_REQUEST["BgtYear"]-1); ?></td>
    <td width="150" style="width:150px;"> =
      <input type="text" name="Budget12"  id="Budget12" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget12)?$Budget12:0; ?>" onMouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/></td>
    <td width="284" style="text-align:right;"><input type="text" name="Sum1" id="Sum1" class="number" style="width:100px;" readonly="yes" value="<?php echo ($Sum1)?$Sum1:0; ?>" onMouseover="showhint('ผลรวมงบประมาณไตรมาส 1', this, event, '250px')"/> </td>
  </tr>
  <tr>
    <th>ไตรมาสที่ 2</th>
    <td style="text-align:center;">ม.ค/<?php echo $_REQUEST["BgtYear"]; ?></td>
    <td>= 
      <span style="width:150px;">
      <input type="text" name="Budget1"  id="Budget1" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget1)?$Budget1:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:center;">ก.พ/<?php echo $_REQUEST["BgtYear"]; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget2"  id="Budget2" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget2)?$Budget2:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:center;">มี.ค/<?php echo $_REQUEST["BgtYear"]; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget3"  id="Budget3" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget3)?$Budget3:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:right;"><input type="text" name="Sum2" id="Sum2" class="number" style="width:100px;" readonly="readonly" value="<?php echo ($Sum2)?$Sum2:0; ?>" onmouseover="showhint('ผลรวมงบประมาณไตรมาส 2', this, event, '250px')"/></td>
  </tr>
  <tr>
    <th>ไตรมาสที่ 3</th>
    <td style="text-align:center;">เม.ย/<?php echo $_REQUEST["BgtYear"]; ?></td>
    <td>= 
      <span style="width:150px;">
      <input type="text" name="Budget4"  id="Budget4" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget4)?$Budget4:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:center;">พ.ค/<?php echo $_REQUEST["BgtYear"]; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget5"  id="Budget5" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget5)?$Budget5:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:center;"> มิ.ย/<?php echo $_REQUEST["BgtYear"]; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget6"  id="Budget6" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget6)?$Budget6:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:right;"><input type="text" name="Sum3" id="Sum3" class="number" style="width:100px;" readonly="readonly" value="<?php echo ($Sum3)?$Sum3:0; ?>" onmouseover="showhint('ผลรวมงบประมาณไตรมาส 3', this, event, '250px')"/></td>
  </tr>
  <tr>
    <th>ไตรมาสที่ 4</th>
    <td style="text-align:center;">ก.ค/<?php echo $_REQUEST["BgtYear"]; ?></td>
    <td>= 
      <span style="width:150px;">
      <input type="text" name="Budget7"  id="Budget7" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget7)?$Budget7:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:center;">ส.ค/<?php echo $_REQUEST["BgtYear"]; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget8"  id="Budget8" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget8)?$Budget8:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:center;">ก.ย/<?php echo $_REQUEST["BgtYear"]; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget9"  id="Budget9" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget9)?$Budget9:0; ?>" onmouseover="showhint('กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000', this, event, '250px')"/>
      </span></td>
    <td style="text-align:right;"><input type="text" name="Sum4" id="Sum4" class="number" style="width:100px;" readonly="readonly" value="<?php echo ($Sum4)?$Sum4:0; ?>" onmouseover="showhint('ผลรวมงบประมาณไตรมาส 4', this, event, '250px')"/></td>
    </tr>
    <tr>
    <td colspan="7" style="text-align:right; font-weight:bold;" align="right">&nbsp;</td>
    <td style="text-align:right; font-weight:bold;">รวมทั้งสิ้น<span style="text-align:right;">
      <input type="text" name="Total" id="Total" class="number" style="width:100px; color:#990000;" readonly="readonly" value="<?php echo ($Total)?$Total:0; ?>" onmouseover="showhint('ผลรวมงบประมาณทั้งสิ้น', this, event, '250px')"/>
    </span></td>
    </tr>
</table>

<div style="text-align:center; margin-top:10px; margin-bottom:30px;">
<input type="submit" class="btnActive" name="save" id="save" value="บันทึก"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ListViewCostMonthEx); ?>&PrjActId=<?php echo $_REQUEST["PrjActId"]; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>CostItemCode=<?php echo $_REQUEST["CostItemCode"]; ?>&SourceExId=<?php echo $_REQUEST["SourceExId"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>'" /> 
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
