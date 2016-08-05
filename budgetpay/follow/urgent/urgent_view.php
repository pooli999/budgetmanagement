<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => getMenuItem(lurl::dotPage($startupPage))->MenuName,
		'link' => '?mod='.lurl::dotPage($startupPage)
	),
	array(
		'text' => ติดตามการใช้จ่ายงบประมาณ,
		'link' => '?mod=budgetpay.follow.main_follow'
	),
	array(
		'text' => 'แบบฟอร์มเอกสารขออนุมัติจัดซื้อจัดจ้างและเบิกจ่าย(กรณีเร่งด่วน)',
		'link' => '?mod=front.eform.urgent.urgent_list'
	),	
	array(
		'text' => 'รายละเอียดแบบฟอร์มเอกสารขออนุมัติจัดซื้อจัดจ้างและเบิกจ่าย(กรณีเร่งด่วน)',
	),
));
	
?>

<script language="javascript" type="text/javascript">
/* <![CDATA[ */	
function ExportToWord(DocId,FormId){
	if(FormId == 14){
		//window.location = '?mod=<?=lurl::dotPage($wordPage2)?>&format=raw&id='+DocId;
		window.location = '?mod=front.eform.pagecenter.pagecenter_word_urgent&format=raw&id='+DocId;
	}else if(FormId == 15){
		//window.location = '?mod=<?=lurl::dotPage($wordPage3)?>&format=raw&id='+DocId;
		window.location = '?mod=front.eform.pagecenter.pagecenter_word_mat1&format=raw&id='+DocId;
	}
}
/*
function ExportToWord(DocId){
			window.location = '?mod=front.eform.pagecenter.pagecenter_word_urgent&format=raw&id='+DocId;
	}
*/
/* ]]> */
</script>

<div class="sysinfo">
  <div class="sysname">รายละเอียดแบบฟอร์มเอกสารขออนุมัติจัดซื้อจัดจ้างและเบิกจ่าย(กรณีเร่งด่วน)</div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดแบบฟอร์มเอกสารขออนุมัติจัดซื้อจัดจ้างและเบิกจ่าย(กรณีเร่งด่วน)</div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>
<?php include("modules/backoffice/finance/form/urgent/view.php"); ?>


<div style="text-align:center; padding:10px">
    <input type="button" name="button3" id="button3" value=" ย้อนกลับ " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" />
</div>