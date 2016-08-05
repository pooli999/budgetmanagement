<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),	
	array(
		'text' => "รายละเอียด".$MenuName,
	),
));

?>

<script language="javascript" type="text/javascript">
/* <![CDATA[ */

	function ExportToWord(DocId){
		window.location = '?mod=front.eform.pagecenter.pagecenter_word_transfer&format=raw&id='+DocId;
	}
	
/* ]]> */
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียด<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>

<?php include("modules/backoffice/finance/form/transfer/view.php"); ?>

<div style="text-align:center; padding:10px">
    <input type="button" name="button3" id="button3" value=" ย้อนกลับ " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" />
</div>
