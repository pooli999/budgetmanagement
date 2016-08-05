<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setPathWays(array(
	array(
		'text' => 'จัดการข้อมูลพื้นฐาน',
		'link' => '?mod=budget.init.startup',
	),
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'เพิ่ม'.$MenuName
	),
));


?>
<script language="javascript" type="text/javascript">


function ValidateForm(f){
	
		if(JQ('#IndName').val() == '' || JQ('#IndName').val() == ' '){
			jAlert('กรุณาระบุชื่อตัวชี้วัด','ระบบตรวจสอบข้อมูล',function(){
				JQ('#IndName').focus();
			});
			return false;
		}

		return true;
}


function Save(f){
	if(ValidateForm(f)){	
		 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		 var redirec_url = '?mod=<?php echo LURL::dotPage($listPage);?>';
		 toSubmit(f,'save',action_url,redirec_url);
	}
}

/*function Confirm(f){
	if(ValidateForm(f)){		
		var firm_url = '?mod=<?php //echo LURL::dotPage($actionPage);?>';
		toConfirm(f,'confirm',firm_url);
	}
	
}*/
 


</script>
<div class="sysinfo">
  <div class="sysname">เพิ่มรายการ<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไข<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input name="IndId" type="hidden"  id="IndId" value="<?php echo $_REQUEST['id'];?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
<th>รหัสตัวชี้วัด</th>
<td class="require">&nbsp;</td>
<td>
<?php echo ($IndCode)?$IndCode:'<span class="hint">(ระบบสร้างรหัสอัตโนมัติ)</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">

<th>แผนหลัก 5 ปี </th>
<td class="require">*</td>
<td><select name="main_plan_id" id="main_plan_id">
.		<option value="">-</option>
	 	 <option value="" selected="selected">งบประมาณ 2555-2559</option>
		 <option value="">งบประมาณ 2560-2564</option>
	  </select></td>
</tr>

<tr style="vertical-align:top;">

<th>ชื่อตัวชี้วัด</th>
<td class="require">*</td>
<td><textarea name="IndName" id="IndName" style="width:99%; height:200px;"><?php echo $IndName;?></textarea></td>
</tr>
 <tr>
   <th valign="top"><strong>ค่าเป้าหมาย</strong></th>
   <td>&nbsp;</td>
   <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td width="5%"><strong>ปี</strong></td>
       <td width="9%"><strong>แผน (%) </strong></td>
       <td width="86%"><strong>คำชี้แจง</strong></td>
     </tr>
     <tr>
       <td>2555</td>
       <td><input name="textfield" type="text" size="10" /></td>
       <td><textarea name="textfield6" cols="50" rows="2"></textarea></td>
     </tr>
     <tr>
       <td>2556</td>
       <td><input name="textfield2" type="text" size="10" /></td>
       <td><textarea name="textarea" cols="50" rows="2"></textarea></td>
     </tr>
     <tr>
       <td>2557</td>
       <td><input name="textfield3" type="text" size="10" /></td>
       <td><textarea name="textarea2" cols="50" rows="2"></textarea></td>
     </tr>
     <tr>
       <td>2558</td>
       <td><input name="textfield4" type="text" size="10" /></td>
       <td><textarea name="textarea3" cols="50" rows="2"></textarea></td>
     </tr>
     <tr>
       <td>2559</td>
       <td><input name="textfield5" type="text" size="10" /></td>
       <td><textarea name="textarea4" cols="50" rows="2"></textarea></td>
     </tr>
   </table></td>
 </tr>
 <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td>
<input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="history.back(-1);" />    </td>
  </tr>
</table>
</form>
</div>
<div id="detailView" style=" display:none"></div>










