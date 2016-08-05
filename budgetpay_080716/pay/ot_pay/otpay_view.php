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
  <div class="sysname"><?php echo $get->getFormName($_REQUEST["FormCode"]);?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียด</div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&FormCode=<?php echo $_REQUEST["FormCode"];?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>

<?php include("modules/backoffice/finance/form/ot_pay/view.php"); ?>

<div style="text-align:center; padding:10px">
    <?php if(in_array($DocStatusId,array(3))){ ?>
<input type="button" name="button4" id="button4" value="บันทึกผล" class="btnRed" onclick="goPage('?mod=<?php echo lurl::dotPage($appPage);?>&id=<?php echo $_GET["id"]; ?>&FormCode=<?php echo $_REQUEST["FormCode"];?>')"/>
    <?php } ?>
    <input type="button" name="button3" id="button3" value=" ย้อนกลับ " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&FormCode=<?php echo $_REQUEST["FormCode"];?>')" />
</div>
