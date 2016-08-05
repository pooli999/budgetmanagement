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
	VSROOT.'modules/backoffice/budget/style_budget.css'
));

// ดึงชื่อขั้นตอน
$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 

?>
<style>
.parentrow{
	background-color:#eee;
}
</style>
<script>
function getfilterSCr(){
	var SCTypeId = $('SCTypeId').value;
	var ScreenLevel = $('ScreenLevel').value;
	window.location.href='?mod=<?php echo lurl::dotPage($ImportPrj);?>&SCTypeId='+SCTypeId+'&ScreenLevel='+ScreenLevel;
}

function loadSCT(SCTypeId){
	var ScreenLevel = $('ScreenLevel').value;
	window.location.href='?mod=<?php echo lurl::dotPage($ImportPrj);?>&SCTypeId='+SCTypeId+'&ScreenLevel='+ScreenLevel;
}
</script>

<form name="sform" id="sform" method="post"  >
<div class="sysinfo">
  <div class="sysname">กรุณาระบุโครงการที่ต้องการคัดลอก</div>
</div>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
  		<td width="149" class="td-descr" style="width:150px; text-align:left; font-weight:bold">ปีงบประมาณ :</td>
        <td colspan="3" class="td-descr"><?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?></td>
  </tr>
    <tr>
      <td class="td-descr" style="width:150px; text-align:left; font-weight:bold">ขั้นตอนโครงการ :</td>
      <td width="176" class="td-descr"><?php echo $get->getSCType(ltxt::getVar('SCTypeId'),'SCTypeId');?></td>
      <td width="138" class="td-descr" style="text-align:left; font-weight:bold">ระดับกลั้นกรอง :</th>
      <td width="757" class="td-descr"><div id="scr"><?php echo $get->getScreen($_REQUEST["ScreenLevel"],ltxt::getVar('ScreenLevel'));?></div></td>
    </tr>
   <tr>
  	<td  class="td-descr" style="width:150px; text-align:left; font-weight:bold">ชื่อโครงการ :</td>
     <td colspan="3" class="td-descr"><div id="prj"><?php echo $get->getProjectList($BgtYear,$PrjId);?></div></td>
  </tr>
  <tr>
  <td colspan="4" align="center">
		<input name="getImport" id="getImport" type="button" value="แสดงข้อมูล" class="btn" />
  </td>
  </tr>
  </table>
</div>
</form>

