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
<input name="AcChartId" type="hidden"  id="AcChartId" value="<?php echo $_REQUEST['id'];?>" />
<input name="AcSeriesId" type="hidden"  id="AcSeriesId" value="<?php echo $_REQUEST['AcSeriesId'];?>" />
<input name="AcSeriesName" type="hidden"  id="AcSeriesName" value="<?php echo $_REQUEST['AcSeriesName'];?>" />
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
  <th>ชื่อชุดผังบัญชี</th>
  <td class="require">&nbsp;</td>
  <td><?php echo $_REQUEST['AcSeriesName'];?></td>
</tr>
<tr>
<th><span class="no" style="width:130px">รหัสบัญชี</span></th>
<td class="require">*</td>
<td><input name="AcChartCode" type="text" id="AcChartCode" value="<?php echo $AcChartCode;?>" size="15" /></td>
</tr>
<tr>
<th><span class="no" style="width:130px">ชื่อบัญชี(ภาษาไทย)</span></th>
<td class="require">*</td>
<td><input name="ThaiName" type="text" id="ThaiName" value="<?php echo $ThaiName;?>" size="45" /></td>
</tr>
<tr>
<th><span class="no" style="width:130px">ชื่อบัญชี(ภาษาอังกฤษ)</span></th>
<td></td>
<td><input name="EngName" type="text" id="EngName" value="<?php echo $EngName;?>" size="45" /></td>
</tr>
<tr>
<th><span class="no" style="width:130px">หมวดบัญชี</span></th>
<td class="require">*</td>
<td><!--<input name="GInitial" type="text" id="GInitial" value="<?php echo $GInitial;?>" size="2" /><input name="GName" type="text" id="GName" value="<?php echo $GName;?>" size="38" disabled="disabled" />-->
<?php 
  		//$tag_attribs = 'onchange="loadBBNumber();" style="width:300px"';
		$tag_attribs ='';
		echo $get->getAccGroupSelect("AcGroupId",$tag_attribs,$AcGroupId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></td>
</tr>
</tr>
<tr>
<th><span class="no" style="width:130px">ชนิดบัญชี</span></th>
<td class="require">*</td>
<td><!--<input name="AcType" type="text" id="AcType" value="<?php echo $AcType;?>" size="2" />&nbsp;G=กลุ่มบัญชี(ไว้รวมยอด) ,D=บัญชีย่อย--><select name="AcType" id="AcType">
	<option value="" <?php if($AcType==""){ echo "selected";}?>>เลือก</option>
	<option value="G" <?php if($AcType=="G"){ echo "selected";}?>>G=กลุ่มบัญชี(ไว้รวมยอด)</option>
	<option value="D" <?php if($AcType=="D"){ echo "selected";}?>>D=บัญชีย่อย</option>
</select></td>
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










