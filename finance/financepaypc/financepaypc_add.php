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

/* <![CDATA[ */

function ValidateForm(f){

		if(JQ('#BankId').val() == '' || JQ('#Branch').val() == '' || JQ('#BookbankTypeId').val() == '' || JQ('#BookbankNumber').val() == ''){
			jAlert('กรุณาระบุขเอมูลที่จำเป็น(ดาวแดง)','ระบบตรวจสอบข้อมูล',function(){
				JQ('#BankName').focus();
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
		var firm_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		toConfirm(f,'confirm',firm_url);
	}

}*/


/*  ]]> */

</script>
<div class="sysinfo">
  <div class="sysname"><? if ($_REQUEST["id"] == ""){?>เพิ่มรายการ<? }else{?>แก้ไขรายการ<? }?><?php echo $MenuName;?></div>
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
<input name="BookbankId" type="hidden"  id="Id" value="<?php echo $_REQUEST['id'];?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
  <th>ชื่อธนาคาร</th>
  <td class="require">*</td>
  <td><?php
  		$tag_attribs = 'onchange="" style="width:300px"';
		echo $get->getBankNameSelect("BankId",$tag_attribs,$BankId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></td>
</tr>
<tr>
  <th>สาขา</th>
  <td class="require">*</td>
  <td><input name="Branch" type="text" id="Branch" value="<?php echo $Branch;?>" size="45" /></td>
</tr>
<tr>
  <th>ประเภท</th>
  <td class="require">*</td>
  <td>
	<?php
  		$tag_attribs = 'onchange="" style="width:300px"';
		echo $get->getBookbankType("BookbankTypeId",$tag_attribs,$BookbankTypeId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?>
  </td>
</tr>
<tr>
<th>เลขที่บัญชีธนาคาร</th>
<td class="require">*</td>
<td><input name="BookbankNumber" type="text" id="BookbankNumber" value="<?php echo $BookbankNumber;?>" size="45" /></td>
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
