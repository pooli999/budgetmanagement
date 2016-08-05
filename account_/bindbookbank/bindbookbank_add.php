<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบบัญชี',
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

/* <![CDATA[ */

function ValidateForm(f){
	
		if(JQ('#BankName').val() == '' || JQ('#BankName').val() == ' '){
			jAlert('กรุณาระบุชื่อธนาคาร','ระบบตรวจสอบข้อมูล',function(){
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
function loadAC(){
	AcGroupId = JQ("#AcGroupId").val();
	AcSeriesId = JQ("#AcSeriesId").val();
	JQ.ajax({
		  type: "GET",
		  url: "?mod=<?php echo LURL::dotPage('bindbookbank_action');?>",		   
		  data: "action=loadac&AcGroupId="+AcGroupId+"&AcSeriesId="+AcSeriesId,
		  success: function(msg){
			JQ("#acNumber").html(msg);
		  }
	});
}
</script>
<div class="sysinfo">
  <div class="sysname"><? if ($_REQUEST["BookbankAcId"] == ""){?>เพิ่มรายการ<? }else{?>แก้ไขรายการ<? }?><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไข<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&AcSeriesId=<?php echo $_REQUEST["AcSeriesId"];?>&AcSeriesName=<?php echo $_REQUEST["AcSeriesName"];?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input name="BookbankId" type="hidden"  id="BookbankId" value="<?php echo $_REQUEST['id'];?>" />
<input name="BookbankAcId" type="hidden"  id="BookbankAcId" value="<?php echo $_REQUEST['BookbankAcId'];?>" />
<input name="AcSeriesId" type="hidden"  id="AcSeriesId" value="<?php echo $_REQUEST['AcSeriesId'];?>" />
<input name="AcSeriesName" type="hidden"  id="AcSeriesName" value="<?php echo $_REQUEST['AcSeriesName'];?>" />
<input name="BookbankNumber" type="hidden"  id="BookbankNumber" value="<?php echo $BookbankNumber;?>" />
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
<th>บัญชีธนาคาร</th>
<td class="require">*</td>
<td><?php echo $BookbankNumber;?></td>
</tr>
<tr>
  <th>&nbsp;&nbsp;&nbsp;&nbsp;ธนาคาร</th>
  <td class="require">&nbsp;</td>
  <td><?php echo $BankName;?></td>
</tr>
<tr>
  <th>&nbsp;&nbsp;&nbsp;&nbsp;สาขา</th>
  <td class="require">&nbsp;</td>
  <td><?php echo $Branch;?></td>
</tr>
<tr>
  <th>&nbsp;&nbsp;&nbsp;&nbsp;ประเภท</th>
  <td class="require">&nbsp;</td>
  <td><?php echo $BookbankType;?></td>
</tr>
<tr>
  <th>ชุดผังบัญชี</th>
  <td class="require">&nbsp;</td>
  <td><?php echo $_REQUEST['AcSeriesName'];?></td>
</tr>
<tr>
<th>หมวดบัญชี</th>
<td class="require">*</td>
<td><?php 
		if ($_REQUEST["BookbankAcId"] == ""){
			$AcGroupId = "";
			$AcChartId = "";
		}
  		$tag_attribs = 'onchange="loadAC();"';
		echo $get->getAccGroupSelect("AcGroupId",$tag_attribs,$AcGroupId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></td>
</tr>
<tr>
<th>&nbsp;&nbsp;&nbsp;&nbsp;ผูกบัญชีย่อย</th>
<td class="require">*</td>
<td><div id="acNumber"><?php 
  		$tag_attribs = '';
		echo $get->getAcCode("AcChartId",$tag_attribs,$AcChartId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></div></td>
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










