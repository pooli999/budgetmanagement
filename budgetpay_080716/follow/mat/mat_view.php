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
		'text' => 'แบบฟอร์มเอกสารขออนุมัติหลักการจัดซื้อจัดจ้างพัสดุ',
		'link' => '?mod=front.eform.mat.mat_list'
	),	
	array(
		'text' => 'รายละเอียดแบบฟอร์มเอกสารขออนุมัติหลักการจัดซื้อจัดจ้างพัสดุ',
	),
));
	
?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */	
function ExportToWord(DocId,FormId){
		if(FormId == 16){
			//window.location = '?mod=<?=lurl::dotPage($wordPage2)?>&format=raw&id='+DocId;
			window.location = '?mod=front.eform.pagecenter.pagecenter_word_mat2&format=raw&id='+DocId;
		}else if(FormId == 17){
			//window.location = '?mod=<?=lurl::dotPage($wordPage3)?>&format=raw&id='+DocId;
			window.location = '?mod=front.eform.pagecenter.pagecenter_word_mat3&format=raw&id='+DocId;
		}
	}

/* ]]> */
</script>

<div class="sysinfo">
  <div class="sysname">รายละเอียดแบบฟอร์มเอกสารขออนุมัติหลักการจัดซื้อจัดจ้างพัสดุ</div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดแบบฟอร์มเอกสารขออนุมัติหลักการจัดซื้อจัดจ้างพัสดุ</div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>
<?php include("modules/backoffice/finance/form/mat/view.php"); ?>


<div style="text-align:center; padding:10px">
    <input type="button" name="button3" id="button3" value=" ย้อนกลับ " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" />
</div>