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
	
		if(JQ('#SourceCode').val() == '' || JQ('#SourceCode').val() == ' '){
			jAlert('กรุณาระบุรหัสแหล่งที่มาของเงินนอกงบประมาณ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#SourceCode').focus();
			});
			return false;
		}	
	
		if(JQ('#SourceExName').val() == '' || JQ('#SourceExName').val() == ' '){
			jAlert('กรุณาระบุชื่อแหล่งที่มาของเงินนอกงบประมาณ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#SourceExName').focus();
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
<input name="SourceExId" type="hidden"  id="SourceExId" value="<?php echo $_REQUEST['id'];?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
<th>รหัสแหล่งที่มาของเงินนอกงบประมาณ</th>
<td class="require">*</td>
<td><input name="SourceCode" type="text" id="SourceCode" value="<?php echo $SourceCode;?>" size="20" /></td>
</tr>
<tr>
<th>ชื่อแหล่งที่มาของเงินนอกงบประมาณ</th>
<td class="require">*</td>
<td><input name="SourceExName" type="text" id="SourceExName" value="<?php echo $SourceExName;?>" size="45" /></td>
</tr>
<tr>
<th>คำอธิบาย</th>
<td class="require"></td>
<td><textarea name="SourceDetail" cols="45" rows="5"  id="SourceDetail"><?php echo $SourceDetail;?></textarea></td>
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










