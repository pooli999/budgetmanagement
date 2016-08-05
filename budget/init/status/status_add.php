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
	
		if(JQ('#BgtYear').val() == 0){
			jAlert('กรุณาระบุปีงบประมาณ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#BgtYear').focus();
			});
			return false;
		}

		if(JQ('#SCTypeId').val() == 0){
			jAlert('กรุณาระบุขั้นตอนการจัดทำงบประมาณ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#SCTypeId').focus();
			});
			return false;
		}	
	
		if(JQ('#ScreenName').val() == '' || JQ('#ScreenName').val() == ' '){
			jAlert('กรุณาระบุชื่อขั้นตอนการกลั่นกรองงบประมาณ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#ScreenName').focus();
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
 
 	function loadSCT(BgtYear){
		//window.location.href='?mod=<?php echo lurl::dotPage($addPage);?>&BgtYear='+BgtYear;
	}

/*  ]]> */

</script>
<div class="sysinfo">
  <div class="sysname">เพิ่มรายการ<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไข<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>&BgtYear=<?php echo $BgtYear;?>')" /></td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input name="ScreenId" type="hidden"  id="ScreenId" value="<?php echo $_REQUEST['id'];?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th>ปีงบประมาณ</th>
    <td class="require">*</td>
    <td><?php $get->getYear(($BgtYear)?$BgtYear:$_REQUEST["BgtYear"],'BgtYear');?></td>
  </tr>
  <tr>
    <th>ขั้นตอนการจัดทำงบประมาณ</th>
    <td class="require">*</td>
    <td><?php echo $get->getScreenTypeList($SCTypeId);?></td>
  </tr>
<tr>
<th>ชื่อขั้นตอนการกลั่นกรองงบประมาณ</th>
<td class="require">*</td>
<td><input name="ScreenName" type="text" id="ScreenName" value="<?php echo $ScreenName;?>"  style="width:98%"/></td>
</tr>
 <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td><input name="Allot" type="checkbox" value="Y" <?php if($Allot=="Y"){ ?> checked="checked" <?php } ?> /><span class="icon-allot">ขั้นตอนนี้ต้องผ่านการกลั่นกรองจัดสรรงบประมาณ</span></tr>
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










