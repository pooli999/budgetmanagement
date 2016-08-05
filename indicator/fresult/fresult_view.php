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
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));

if($_REQUEST['PrjActId']){
	$dataPrj=$get->getProjectDetail($_REQUEST['PrjActId']);//ltxt::print_r($dataPrj);
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
	if(JQ('#Progress').val()==""){
		alert("กรุณากรอก % ความก้าวหน้า");
		JQ('Progress').focus();
		return false
	}
	
	return true;
}

function toPage(MonthNo){
	//window.location.href='?mod=<?php //echo lurl::dotPage($addMonthPage);?>&PrjId=<?php //echo $_REQUEST["PrjId"];?>&PrjActId=<?php //echo $_REQUEST["PrjActId"];?>&PrjDetailId=<?php //echo $_REQUEST["PrjDetailId"];?>&PrjActCode=<?php //echo $_REQUEST["PrjActCode"];?>&OrgCode=<?php //echo $_REQUEST["OrgCode"];?>&BgtYear=<?php //echo $_REQUEST["BgtYear"];?>&pageid='+pageid;
	window.location.href='?mod=<?php echo lurl::dotPage($addMonthPage);?>&PrjActId=<?php echo $_REQUEST["PrjActId"];?>&MonthNo='+MonthNo;
}

	
</script>

 <table width="100%" cellpadding="0" cellspacing="0" class="page-title-user">
 	<tr>
    	<td class="div-title-result">&nbsp;</td>
        <td>
       <div class="font1">ติดตามผลการดำเนินงานโครงการ</div>
        </td>
    </tr>
 </table>


<div class="sysinfo">
  <div class="sysname">แสดงรายละเอียดผลการดำเนินงานกิจกรรมในโครงการ</div>
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#eeebac;">
  <tr>
    <td style="padding:5px;">
    <a href="javascript:saveToWord()" class="ico print">พิมพ์</a>&nbsp;
    <a href="javascript:saveToWord()" class="icon-word">ส่งออกเป็น Word</a>
    </td>
    <td style="text-align:right; padding-right:5px;">
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $BgtYear;?>');" />
    </td>
  </tr>
</table>



<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
  </table>  
</div>



<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId'];?>" />
<input type="hidden" name="PrjActCode" id="PrjActCode" value="<?php echo $PrjActCode;?>" />
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $BgtYear;?>" />


<?php include("modules/backoffice/budget/result/view.php"); ?>
    
    




     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage("fresult_main");?>&BgtYear=<?php echo $BgtYear;?>');" />
      </div>
      
</form>

