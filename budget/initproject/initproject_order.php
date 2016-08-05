<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css'
));

//ltxt::print_r($_GET);

		if(!$_REQUEST['BgtYear']){
			$_REQUEST['BgtYear'] = date("Y")+543;
		}
		
		$defaultpage = date("m");
		//echo "defaultpage= ".$defaultpage;
		if($_REQUEST["pageid"]  == ""){
			$_REQUEST["pageid"] = $defaultpage;
			
		}
	
if($_REQUEST['PrjId']){
	$dataPrj=$get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST['OrgCode'], 0, 0, $_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId']);
	//ltxt::print_r($dataPrj);
	foreach( $dataPrj as $row ) {
		foreach( $row as $k=>$v){ 
			${$k} = $v;
		}
	}
}	



?>
<script  type="text/javascript">
function Save(form){	
	if(validateSubmit()){
		form.submit();
	}
}

function validateSubmit(){
	//% ความก้าวหน้า
	/*if(JQ('#Progress').val()==""){
		alert("กรุณากรอก % ความก้าวหน้า");
		JQ('Progress').focus();
		return false
	}*/
	
	return true;
}

	
</script>


<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>

<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td align="right">
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn"  onClick="history.back(-1);" />
      </td>
    </tr>
  </table>  
</div>



<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=savemass" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="PItemCode" id="PItemCode" value="<?php echo $_REQUEST['PItemCode'];?>" />
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>" />

<table class="tbl-view" width="100%" cellspacing="1" cellpadding="1" border="0">
<tbody>
<tr>
  <th colspan="2" valign="top"><strong>แผนงานสมัชชาสุขภาพ </strong></th>
  </tr>
<tr>
<th valign="top"> </th>
<td class="hint">* Drag(คลิกเม้าท์ค้างไว้) ที่ชื่อหัวข้อ เพื่อเลื่อนขึ้นหรือเลื่อนลง</td>
</tr>
<tr>
<th valign="top">โครงการ :</th>
<td>
<div class="orderbox">
<ul id="sortable" class="ui-sortable" unselectable="on" style="-moz-user-select: none;">
<li id="49" class="ui-state-default" unselectable="on" style="-moz-user-select: none;">56P02A  โครงการจัดสมัชชาสุขภาพแห่งชาติ</li>
<li id="1" class="ui-state-default" unselectable="on" style="-moz-user-select: none;">56P02B  โครงการขับเคลื่อนมติสมัชชาสุขภาพแห่งชาติ</li>
<li id="2" class="ui-state-default" unselectable="on" style="-moz-user-select: none;">56P02C  โครงการสนับสนุนสมัชชาสุขภาพเฉพาะพื้นที่และสมัชชาสุขภาพเฉพาะประเด็น ปีงบประมาณ ๒๕๕๖</li>
</ul>
</div></td>
</tr>
<tr>
<td> </td>
<td>
<input id="button4" class="btnRed" type="button" onclick="SaveOrder()" value="บันทึกลำดับ" name="button4">
<input class="btn cancle" type="button" onclick="history.back(-1);" value="ย้อนกลับ" name="cancel"></td>
</tr>
</tbody>
</table>








      
</form>

