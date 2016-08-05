<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => บันทึกตัดจ่ายงบประมาณ,
		'link' => '?mod=budgetpay.pay.main_pay'
	),
	array(
		'text' => $get->getFormName($_REQUEST["FormCode"]),
		'link' => '?mod='.lurl::dotPage($listPage).'&FormCode='.$_REQUEST["FormCode"].'&&start='.$_REQUEST["start"]
	),
	array(
		'text' => 'แสดงรายละเอียด'
	)
));

/*function icoDelete($GerPayId,$DocCodePay){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=deletepay&id=".$_GET["id"]."&GerPayId=".$GerPayId."&DocCodePay=".$DocCodePay."')",
		'ico drop',
		$label,
		$label
	));
}

function icoEdit($DocId,$GerPayId){
	$label = 'แก้ไข';
	global $addPayPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPayPage)."&id=".$DocId."&GerPayId=".$GerPayId."' ",
		'ico edit',
		$label,
		$label
	));
}

*/	
?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */	

/* ]]> */
</script>

<div class="sysinfo">
<div class="sysname"><?php echo $get->getFormName($_REQUEST["FormCode"]);?></div>
<div class="sysdetail">แสดงรายละเอียด</div>
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&FormCode=<?php echo $_REQUEST["FormCode"];?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>
<?php include("modules/backoffice/finance/form/mat_pay/view.php"); ?>


<div style="text-align:center; padding:10px">
    <?php if(in_array($DocStatusId,array(7))){ ?>
<input type="button" name="button4" id="button4" value="บันทึกผล" class="btnRed" onclick="goPage('?mod=<?php echo lurl::dotPage($appPage);?>&id=<?php echo $_GET["id"]; ?>&FormCode=<?php echo $_REQUEST["FormCode"];?>')"/>
    <?php } ?>
    <input type="button" name="button3" id="button3" value=" ย้อนกลับ " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&FormCode=<?php echo $_REQUEST["FormCode"];?>')" />
</div>