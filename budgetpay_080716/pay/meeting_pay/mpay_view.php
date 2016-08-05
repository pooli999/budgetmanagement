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
		'text' => "เพิ่ม/แก้ไข ".$MenuName,
	),
));
	
	
function icoDelete($PayId,$DocCodePay){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=deletepay&id=".$_GET["id"]."&PayId=".$PayId."&DocCodePay=".$DocCodePay."')",
		'ico drop',
		$label,
		$label
	));
}

function icoEdit($DocId,$PayId){
	$label = 'แก้ไข';
	global $addPayPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPayPage)."&id=".$DocId."&PayId=".$PayId."' ",
		'ico edit',
		$label,
		$label
	));
}
	
?>

<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	JQ(document).ready(function(){
	
		JQ("#exd").show();
		
		JQ('#exd').show('fade');
		JQ('#a-exd').addClass('icon-decre');
		JQ('#a-exd').removeClass('icon-incre');
		JQ('#a-exd').html('ซ่อนรายละเอียด');
	
	});	
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
<?php include("modules/backoffice/finance/form/meeting_pay/view.php"); ?>


<div style="text-align:center; padding:10px">
    <?php if(in_array($DocStatusId,array(3))){ ?>
<input type="button" name="button4" id="button4" value="บันทึกผล" class="btnRed" onclick="goPage('?mod=<?php echo lurl::dotPage($appPage);?>&id=<?php echo $_GET["id"]; ?>')"/>
    <?php } ?>
    <input type="button" name="button3" id="button3" value=" ย้อนกลับ " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" />
</div>