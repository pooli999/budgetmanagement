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
		'text' => 'บันทึกตัดจ่าย'
	)
));
	
?>

<script language="javascript" type="text/javascript">
function ValidateForm(f){
		return true;
}
function Save(f){
	 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
	 var redirec_url = '?mod=front.eform.general.general_list';
	 toSubmit(f,'approve',action_url,redirec_url);
}

function Confirm(f){
	if(ValidateForm(f)){
		var firm_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		toConfirm(f,'confirm',firm_url);
	}
	
}
</script>

<div class="sysinfo">
<div class="sysname"><?php echo $get->getFormName($_REQUEST["FormCode"]);?></div>
<div class="sysdetail">บันทึกตัดจ่าย</div>
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&FormCode=<?php echo $_REQUEST["FormCode"];?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>
<?php include("modules/backoffice/finance/form/urgent/view.php"); ?>



<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="DocCode" id="DocCode" value="<?php echo $DocCode; ?>" />
<input type="hidden" name="Topic" id="Topic" value="<?php echo $Topic; ?>" />
<input type="hidden" name="FormCode" id="FormCode" value="<?php echo $FormCode; ?>" />

<?php include("modules/backoffice/budgetpay/pay/add.php"); ?>

<div style="text-align:center; padding:10px">
    <input type="button" class="btnActive" name="save" id="save" value=" ตรวจทาน " onclick="Confirm('adminForm');"  />
      <input type="button" name="button3" id="button3" value=" ยกเลิก " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&FormCode=<?php echo $_REQUEST["FormCode"];?>&start=<?php echo $_REQUEST["start"];?>')" />
</div>

</form>
</div>
<div id="detailView" style=" display:none"></div>