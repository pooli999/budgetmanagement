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
	
		if(JQ('#CostTypeId').val() == 0){
			jAlert('กรุณาระบุหมวดเงินงบประมาณ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#CostTypeId').focus();
			});
			return false;
		}	
		
/*		if(JQ('#ParentCode').val() == 0){
			jAlert('กรุณาระบุระดับรายการค่าใช้จ่าย','ระบบตรวจสอบข้อมูล',function(){
				JQ('#ParentCode').focus();
			});
			return false;
		}		*/	
	
		if(JQ('#CostName').val() == '' || JQ('#CostName').val() == ' '){
			jAlert('กรุณาระบุชื่อรายการค่าใช้จ่าย','ระบบตรวจสอบข้อมูล',function(){
				JQ('#CostName').focus();
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
 

 
function loadCostGroup(){
	
	var CostTypeId = JQ('#CostTypeId').val();
	window.location.href='?mod=<?php echo lurl::dotPage($addPage);?>&CostTypeId='+CostTypeId;
	
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
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="CostItemId" id="CostItemId" value="<?php echo $_GET["id"]; ?>" />


<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
<th>ภายใต้หมวดเงินงบประมาณ</th>
<td class="require">*</td>
<td><?php echo $get->getCostTypeFilter(($CostTypeId)?$CostTypeId:$_REQUEST["CostTypeId"],'CostTypeId','onchange="loadCostGroup()"'); ?></td>
</tr>
<tr>
<th>ภายใต้รายการค่าใช้จ่าย</th>
<td class="require">*</td>
<td>
      <select name="ParentCode" id="ParentCode">
        <option value="0"  style="font-weight:bold">เป็นรายการหลัก</option>
        <?php
		$ParentLevel1 =  $get->getCostItemLevel(0,1,($CostTypeId)?$CostTypeId:$_REQUEST["CostTypeId"]);
	  	foreach($ParentLevel1 as $p){
		if($ParentCode==$p->CostItemCode) $scl = 'selected="selected"'; else $scl = '';
	  	?>
        <option value="<?php echo $p->CostItemCode;?>" <?php echo $scl;?> style="font-weight:bold" ><?php echo $p->CostName;?></option>
        
        	<?php 
					$ParentLevel2 =  $get->getCostItemLevel($p->CostItemCode,2);
					foreach($ParentLevel2 as $L){
					if($ParentCode==$L->CostItemCode) $scl2 = 'selected="selected"'; else $scl2 = '';
			?>
        			<option value="<?php echo $L->CostItemCode;?>"  <?php echo $scl2;?> style="padding-left:15px;" ><?php echo "|--".$L->CostName;?></option>
        <?php
					}// end ParentLevel2
	  	}// end ParentLevel1
	  	?>
        </select>

</td>
</tr>
<tr>
<th>รหัสรายการค่าใช้จ่าย</th>
<td class="require">*</td>
<td><input name="CostItemCode" type="text" id="CostItemCode" value="<?php echo $CostItemCode;?>" size="20" /></td>
</tr>
<tr>
<th>ชื่อรายการค่าใช้จ่าย</th>
<td class="require">*</td>
<td><input name="CostName" type="text" id="CostName" value="<?php echo $CostName;?>" size="50" /></td>
</tr>
<tr>
<th valign="top">คำอธิบาย</th>
<td class="require"></td>
<td><textarea name="CostItemDetail" cols="50" rows="3"  id="CostItemDetail"><?php echo $CostItemDetail;?></textarea></td>
</tr>
<tr>
  <th valign="top">&nbsp;</th>
  <td class="require"></td>
  <td><input name="GraphSelect" type="checkbox" value="Y" <?php if($GraphSelect=="Y"){ ?> checked="checked" <?php } ?> />เป็นรายการที่ผู้บริหารสนใจบนกราฟ MIS/EIS</td>
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










