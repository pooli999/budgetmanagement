<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));

$datas = $get->getPlanDetail($_REQUEST["LPlanCode"]);//ltxt::print_r($datas);
foreach($datas as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;}
}

if($_REQUEST["LindId"]){
	$indicator = $get->getIndDetail($_REQUEST["LindId"]);//ltxt::print_r($indicator);
	foreach($indicator as $in){
		foreach( $in as $a=>$q){ ${$a} = $q;}
	}
}


$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบรายงานผลและตัวชี้วัด',
	),
	array(
		'text' => 'ตัวชี้วัดระดับแผนหลัก',
		'link' => '?mod='.lurl::dotPage("plan_list").'&PLongCode='.$PLongCode
	),
	array(
		'text' => 'บันทึกผลตัวชี้วัด'
	),
));




?>
<script language="javascript" type="text/javascript">
function ValidateForm(f){
	return true;
}

function Save(f){
	if(ValidateForm(f)){	
		 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		 var redirec_url = '?mod=<?php echo LURL::dotPage($listPage);?>';
		 toSubmit(f,'saveindyear',action_url,redirec_url);
	}
}
</script>



<div class="sysinfo">
<div class="sysname">บันทึกผล ตัวชี้วัด แผนหลัก 5 ปี</div>
<div class="sysdetail">สำหรับบันทึกผล ตัวชี้วัด แผนหลัก 5 ปี</div>
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input name="PLongCode" type="hidden"  id="PLongCode" value="<?php echo $PLongCode;?>" />
<input name="LPlanCode" type="hidden"  id="LPlanCode" value="<?php echo $_REQUEST['LPlanCode'];?>" />
<?php if($_REQUEST["LindId"]){ ?>
<input name="LindId" type="hidden"  id="LindId" value="<?php echo $_REQUEST['LindId'];?>" />
<?php } ?>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellpadding="1" cellspacing="1" style="margin-bottom:0px;" class="tbl-view">
<tr>
  <td height="46" colspan="3" align="left" bgcolor="F4F4F4" style="font-weight:bold;"><strong>ตัวชี้วัด แผนหลัก 5 ปี : </strong>(001) มีการนำสาระสำคัญในธรรมนูญว่าด้วยระบบสุขภาพแห่งชาติฯ ไปใช้ในการจัดทำแผนปฏิบัติราชการ และแผนประจำปีของหน่วยงานยุทธศาสตร์ </td>
  </tr>
<tr>
  <th align="center" bgcolor="#CDCDCD" style="font-weight:bold;width:100px;">ปี</th>
  <td align="center" bgcolor="#CDCDCD" style="font-weight:bold;width:100px;">คะแนน (ร้อยละ) </td>
  <td  align="center" bgcolor="#CDCDCD" style="font-weight:bold;">คำชี้แจง</td>
</tr>

<tr>	
    <th bgcolor="E6E6E6">2555</th>
    <td align="center" bgcolor="F4F4F4" style="font-weight:bold;text-align:center"><label>
      <input name="textfield2" type="text" size="4" maxlength="4" />
    </label></td>
    <td bgcolor="F4F4F4" style="font-weight:bold;"><label>
      <textarea name="textfield" cols="100" rows="2"></textarea>
    </label></td>
</tr>
<tr>
  <th bgcolor="E6E6E6">2556</th>
  <td align="center" bgcolor="F4F4F4" style="font-weight:bold;text-align:center"><input name="textfield22" type="text" size="4" maxlength="4" /></td>
  <td bgcolor="F4F4F4" style="font-weight:bold;"><textarea name="textarea" cols="100" rows="2"></textarea></td>
</tr>
<tr>
  <th bgcolor="E6E6E6">2557</th>
  <td align="center" bgcolor="F4F4F4" style="font-weight:bold;text-align:center"><input name="textfield23" type="text" size="4" maxlength="4" /></td>
  <td bgcolor="F4F4F4" style="font-weight:bold;"><textarea name="textarea2" cols="100" rows="2"></textarea></td>
</tr>
<tr>
  <th bgcolor="E6E6E6">2558</th>
  <td align="center" bgcolor="F4F4F4" style="font-weight:bold;text-align:center"><input name="textfield24" type="text" size="4" maxlength="4" /></td>
  <td bgcolor="F4F4F4" style="font-weight:bold;"><textarea name="textarea3" cols="100" rows="2"></textarea></td>
</tr>
<tr>
  <th bgcolor="E6E6E6">2559</th>
  <td align="center" bgcolor="F4F4F4" style="font-weight:bold;text-align:center"><input name="textfield25" type="text" size="4" maxlength="4" /></td>
  <td bgcolor="F4F4F4" style="font-weight:bold;"><textarea name="textarea4" cols="100" rows="2"></textarea></td>
</tr>
</table>








<div style="padding:10px; text-align:center;">
  <input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onclick="goPage('?mod=<?php echo lurl::dotPage("plan_list");?>&PLongCode=<?php echo $PLongCode;?>');"  />
</div>













</form>
</div>
<div id="detailView" style=" display:none"></div>

