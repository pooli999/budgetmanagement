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

//ltxt::print_r($detail);

?>
<script type="text/javascript">

function Save(form){	

	if($('CloseStatus').checked){
		  if (confirm("หากคุณยืนยันการปิดปีงบประมาณแล้วจะไม่สามารถย้อนกลับมาปรับปรุงข้อมูลได้อีก ต้องการดำเนินการต่อไปหรือไม่")) {
   			 form.submit();
 		 }
	}else{
	
		alert('กรุณาคลิกในช่องสี่เหลี่ยมด้านล่างเพื่อยืนยันการปิดปีงบประมาณ');	
		$('CloseStatus').focus();
	}

}

</script>


<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr class="td-descr">
      <td style=" text-align:right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>');" /></td>
    </tr>
  </table>
</div>

<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=closeyear" onSubmit="Save(this);return false;" enctype="multipart/form-data">
 <input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $BgtYear;?>" />
<?php

	$SumBGTotal=$get->getTotalPrj($BgtYear);
	$SumPay = 0;
	$SumStatement = 0;
	$TotalBG = $SumBGTotal - $SumPay;
	$TotalBGStatement = $SumBGTotal - $SumPay - $SumStatement;


?>

<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-view">
  <tr>
    <th>ปีงบประมาณ :</th>
    <td><?php echo $BgtYear; ?></td>
  </tr>
  <tr>
    <th>สถานะ :</th>
    <td><?php if($CloseStatus == "Y"){echo '<span class="ico red">ปิดปีงบประมาณ</span>';}else{ echo '<span class="ico green">เปิดปีงบประมาณ</span>';}; ?></td>
  </tr>  
  <tr>
    <th colspan="2">ข้อมูลหน่วยงาน :</th>
  </tr>   
  <tr>
    <td  colspan="2" valign="top">
    
        <table width="100%" border="1" cellspacing="0" cellpadding="0"  class="tbl-view" style="background-color:#eee">
        			<tr  style="height:26px; ">
                    	<th style="width:2%; text-align:left">ลำดับ</th>
                        <th  style="width:25%; text-align:center">หน่วยงาน</th>
                    	<th  style="width:33%; text-align:center">ขั้นตอนปัจจุบัน</th>

                    </tr>
<?php
$j = 0; //ltxt::print_r($datas);
$datas = $get->dataSetView();
if($datas){														
	foreach($datas as $row){
		foreach($row as $k=>$v){ ${$k} = $v; }
?>
                      <tr  style="height:26px;">
                        <td style="border-bottom: 0px; text-align:center"><?php echo ($j+1); ?></td>
                        <td style="border-bottom: 0px;">
                           <?php echo $OrgName; ?>
                        </td>
                        <td style="border-bottom: 0px;"><?php echo ($ScreenLevel)?$get->getScreenName($BgtYear,$ScreenLevel):"-"; ?></td>
                      </tr>
<?php 
		$j++;             
	}// level = 1
} // foreach      
?>    
        </table>
            <input name="CloseStatus"  id="CloseStatus" type="checkbox" value="Y" /> <span class="ico red" style="color:#F00;">ยืนยันการปิดปีงบประมาณ</span>
            </td>
  </tr> 
 <tr>
    <th>&nbsp;</th>
    <td>
    <input type="submit" class="btnActive" name="save" id="save" value="บันทึก"  />
    <input type="button" name="button" id="button" value="ยกเลิก" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>');" />
    
    </td>
  </tr>
</table>

</form>

