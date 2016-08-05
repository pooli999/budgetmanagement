<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'เพิ่มข้อมูล'.$MenuName
	),
));


?>
<script language="javascript" type="text/javascript">

/* <![CDATA[ */

function ValidateForm(f){
		
		
		if(JQ('#LedName').val() == ''){
			jAlert('กรุณาระบุชื่อ-นามสกุล','ระบบตรวจสอบข้อมูล',function(){
				JQ('#LedName').focus();
			});
			return false;
		}

		return true;
}


function Save(f){
	 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
	 var redirec_url = '?mod=<?php echo LURL::dotPage($listPage);?>';
	 toSubmit(f,'save',action_url,redirec_url);
}

function Confirm(f){
	if(ValidateForm(f)){		
		var firm_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		toConfirm(f,'confirm',firm_url);
	}
	
}
 

/*  ]]> */

</script>
<div class="sysinfo">
  <div class="sysname">เพิ่มรายการข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไขข้อมูล<?php echo $MenuName;?></div>
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
<input type="hidden" name="OrganizeId" id="OrganizeId" value="<?php echo $_GET['id']?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th>ชื่อ-นามสกุล :</th>
    <td class="require">*</td>
    <td><input name="LedName" type="text" id="LedName" value="<?php echo $LedName;?>" size="45" class="input-search" />    </td>
  </tr>
  <tr>
    <th valign="top">เบอร์ติดต่อ :</th>
    <td class="require" valign="top">&nbsp;</td>
    <td><input name="Telephone" type="text" id="Telephone" value="<?php echo $Telephone;?>" size="20" class="input-search" /> 
      ต่อ 
      <input name="Ext" type="text" id="Ext" value="<?php echo $Ext;?>" size="10" class="input-search" /></td>
  </tr>
  <tr>
    <th valign="top">เบอร์มือถือ :</th>
    <td class="require" valign="top">&nbsp;</td>
    <td><input name="Mobile" type="text" id="Mobile" value="<?php echo $Mobile;?>" size="20" class="input-search" /></td>
  </tr>
  <tr>
    <th valign="top">อีเมล :</th>
    <td class="require" valign="top">&nbsp;</td>
    <td><input name="Email" type="text" id="Email" value="<?php echo $Email;?>" size="45" class="input-search" /></td>
  </tr>
  <tr>
    <th valign="top">ข้อมูลเพิ่มเติม :</th>
    <td class="require" valign="top">&nbsp;</td>
    <td>
      <textarea name="Detail" id="Detail" cols="45" rows="5"><?php echo $Detail;?></textarea></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td><input name="EnableStatus" type="hidden" id="EnableStatus" value="Y" /></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>
    <input type="button" class="btnActive" name="save" id="save" value="ดูรายละเอียด" onclick="Confirm('adminForm');"  />
      <input type="button" name="button3" id="button3" value=" ยกเลิก " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>

</form>
</div>
<div id="detailView" style=" display:none"></div>










