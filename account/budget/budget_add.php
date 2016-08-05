<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setPathWays(array(
	array(
		'text' => 'ฐานข้อมูล',
		'link' => '?mod=account.startup',
	),
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'แก้ไข'.$MenuName
	),
));


?>
<script language="javascript" type="text/javascript">
JQ(document ).ready(function() {
    JQ("#sename").hide();
});
/* <![CDATA[ */

function ValidateForm(f){
	
		if(JQ('#AcSeriesId').val() == '0' || (JQ('#AcSeriesId').val() == 'newr' && JQ('#SeriesName').val()=='')){
			jAlert('กรุณาระบุชื่อชุดผังบัญชี','ระบบตรวจสอบข้อมูล',function(){
				JQ('#AcSeriesId').focus();
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

function newAcSeries(){
	AcSeriesId = JQ("#AcSeriesId").val();
	if(AcSeriesId=="newr"){
		JQ("#sename").show();
	}else{
		JQ("#sename").hide();
	}
}// end
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
<input name="BgtYearId" type="hidden"  id="Id" value="<?php echo $_REQUEST['id'];?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
  <th>ปีงบประมาณ</th>
  <td class="require">&nbsp;</td>
  <td><?php echo $BgtYear;?></td>
</tr>
<tr>
<th>ชื่อชุดผังบัญชี</th>
<td class="require">*</td>
<td><?php 
  		$tag_attribs = 'onchange="newAcSeries();"';
		echo $get->getAcSeriesIdSelect("AcSeriesId",$tag_attribs,$AcSeriesId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?>
  <div id="sename">ระบุ <input name="SeriesName" type="text" id="SeriesName" value="<?php echo $SeriesName;?>" size="45" /></div></td>
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










