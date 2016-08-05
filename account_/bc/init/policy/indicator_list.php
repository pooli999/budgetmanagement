<?php
include 'action.php';
$this->DOC->setPathWays(array(
	array(
		'text' => 'กำหนดค่าเบื้องต้น ',
		'link' => '?mod=budget.init.startup',
	),
	array(
		'text' => 'ยุทธศาสตร์ชาติ',
	)

));
function icoEdit($r){
	$label = 'แก้ไข';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage('indicator_add')."&BgtYear=".$_REQUEST['BgtYear']."&PItemId=".$r->PItemId."'",
		'ico edit',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:if(confirm('ยืนยันการลบรายการ')) self.location='?mod=".LURL::dotPage('action')."&task=deleteInd&BgtYear=".$r->BgtYear."&id=".$r->PIndId."'",
		'ico delete',
		$label,
		$label
	));
}


?>

<script>
function addItem(){
	var PItemId = $('PItemId').value;
	var BgtYear = $('BgtYear').value;
	window.location.href='?mod=<?php echo lurl::dotPage("indicator_add");?>&PItemId='+PItemId+'&BgtYear='+BgtYear;
}

function getfilteryear(){
	var BgtYear = $('BgtYear').value;
	window.location.href='?mod=<?php echo lurl::dotPage("indicator_list");?>&BgtYear='+BgtYear;
}
function loadSCT(PItemId){
	var PItemId = $('PItemId').value;
	window.location.href='?mod=<?php echo lurl::dotPage("indicator_list");?>&PItemId='+PItemId;

}
function sortItem(){
	var PItemId = $('PItemId').value;
	var BgtYear = $('BgtYear').value;
	window.location.href='?mod=<?php echo lurl::dotPage("sort");?>&PItemId='+PItemId+'&BgtYear='+BgtYear;
}

</script>


<div class="sysinfo">
  <div class="sysname">ยุทธศาสตร์ชาติ</div>
  <div class="sysdetail">สำหรับ เพิ่ม ลบ หรือ แก้ไขข้อมูลตัวชี้วัด</div>
</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbl-button">
  <tr>
    <td><input name="add" type="button" value="เพิ่มรายการ" onclick="addItem()" />
		   <input name="sort" type="button" value="เรียงลำดับข้อมูล" onclick="sortItem()" />
    	   <input type="button" name="button" id="button" value="ย้อนกลับ" onClick="history.back(-1);">
    </td>
     <td style="text-align:right;">
	ปีงบประมาณ : <?php $Helper->getYear($_REQUEST['BgtYear'],'BgtYear','onchange="getfilteryear(this.value)"');?>
    ชื่อยุทธศาสตร์ชาติ : <?php echo $Helper->getPItemName($BgtYear,'PItemId',$_REQUEST['PItemId']);?>
	</td>
  </tr>
</table>
<div style="padding:3px; background-color:#FFC; font-weight:bold;"><?php echo $PItemName=$Helper->getPItemName2($PItemId);?></div>
<table width="100%" border="0" class="tbl-list" cellspacing="0">
  <tr>
    <th style="width:10px;">ลำดับ</th>
    <th>รายการ</th>
    <th style="width:120px;">ประเภทตัวชี้วัด</th>
    <th colspan="2">ปฏิบัติการ</th>
  </tr>
  <?php 
	$i=1;
		$data=$Helper->getIndicator($PItemId);//ltxt::print_r($data);
		foreach( $data["rows"] as $row ) {
			foreach( $row as $k=>$v){ ${$k} = $v;}
?>
  <tr style="vertical-align:top;" >
    <td align="center"  ><?php echo $i.".";?></td>
    <td><?php echo $PIndName;?></td>
    <td align="center"><?php echo $IndTypeName=$Helper->getIndTypeName($IndTypeId); ?></td>
    <td style="width:45px;"><?php echo icoEdit($row); ?></td>
	<td style="width:45px;"><?php echo icoDelete($row);?></td>
  </tr>
   <?php $i++; }?>
</table>
<div class="cms-box-navpage" style="margin-bottom:5px;"> <?php echo NavPage(array('total'=>$data['total']));?> </div>
