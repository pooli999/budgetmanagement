<?php 
include "action.php";
$this->DOC->setPathWays(array(
	array(
		'text' => 'กำหนดค่าเบื้องต้น',
		'link' => '?mod=budget.init.startup',
	),
	array(
		'text' => 'บริหารจัดการข้อมูลตัวชี้วัดแผนงาน/โครงการประจำปี',
		'link' => '?mod='.LURL::dotPage('list'),
	),
	array(
		'text' => 'เพิ่ม/แก้ไข'
	)


));
if($_REQUEST['PItemId']){
	$data=$Helper->getPItemIdData($_REQUEST['PItemId'],$_REQUEST['id']);
	foreach( $data as $row ) {
		foreach( $row as $k=>$v){ 
			${$k} = $v;
		}
	}
}


?>
<script type="text/javascript">

function Save(form){	
	if($('PIndName').value==""){
		alert("กรุณาระบุชื่อยุทธศาสตร์ชาติ");
		$('PIndName').focus();
		return false;
	}
	$('task').value = 'saveInd';
	if(validateSubmit()){
		form.submit();
	}

}
function validateSubmit(){
		return true;
}
function getfilteryear(obj){
	window.location.href='?mod=<?php echo lurl::dotPage("Indicator_add");?>&BgtYear='+obj;
}

</script>
<div class="sysinfo">
<div class="sysname">เพิ่ม/แก้ไขตัวชี้วัดแผนงาน/โครงการประจำปี</div>
<div class="sysdetail">ทำการเพิ่ม แก้ไข ลบตัวชี้วัดแผนงาน/โครงการประจำปี</div>
</div>



<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage('action');?>&action=saveInd" onSubmit="Save(this);return false;" enctype="multipart/form-data">

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onClick="history.back(-1);"></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>



<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th>ปีงบประมาณ</th>
    <td class="require">*</td>
    <td><?php $Helper->getYear($_REQUEST['BgtYear'],'BgtYear','onchange="getfilteryear(this.value)"');?></td>
  </tr>
  <tr>
    <th>ชื่อยุทธศาสตร์ชาติ</th>
    <td class="require">*</td>
    <td><?php echo $Helper->getPItemName($BgtYear,'PItemId',$PItemId);?></td>
  </tr>
  <tr>
  <th>ชื่อตัวชี้วัด</th>
  <td class="require">*</td>
  <td><input name="PIndName" type="text" id="PIndName" value="<?php echo $PIndName;?>" size="90" /></td>
</tr>
  <tr>
    <th>ประเภทตัวชี้วัด</th>
    <td><span class="require">*</span></td>
    <td><?php $Helper->getIndTypeNameList('IndTypeId',$IndTypeId);?></td>
  </tr>
  <tr>
    <th>ค่าเป้าหมาย</th>
    <td><span class="require">*</span></td>
    <td><input name="Value" type="text" id="Value" value="<?php echo $Value;?>" size="8" style="text-align:right;" />
    <?php $Helper->getUnit($UnitID,'UnitID');?>
    </td>
  </tr>
<tr>
  <th><input name="task" type="hidden"  id="task" />
    <input name="PIndId" type="hidden"  id="PIndId" value="<?php echo $_REQUEST['id'];?>" /></th>
  <td colspan="2">
    <input type="submit" class="btnActive" name="save" id="save" value="บันทึก"  />
    <input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="history.back(-1);" />    </td>
</tr>
</table>
</form>