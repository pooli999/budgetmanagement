<?php
include("config.php");
include("deposit_helper.php");
include($KeyPage."_data.php");
	$get = new sHelper();
	$numi = $_REQUEST["numi"];
?>
    
		<table  width="100%" border="1" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl<?php echo $numi; ?>">
  		<tr>
        <td style="width:10%; text-align:center"><?php 
  		$tag_attribs = 'onchange="loadIncomeDetail('.$numi.');" style="width:60px"';
		echo $get->getIncomeId("IncomeId".$numi,$tag_attribs,$IncomeId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></td>
		<td style=" width:15%;text-align:center"><div id="ReceiveType<?php echo $numi; ?>"></div></td>
		<td style=" width:30%;text-align:center"><div id="Payname<?php echo $numi; ?>"></div></td>
        <td style=" width:25%;text-align:center"><div id="IncomeType<?php echo $numi; ?>"></div></td>
  		<td style="width:12%; text-align:center"><div id="IncomeValue<?php echo $numi; ?>" name="Inval"></div></td>
        <td style="width:8%; text-align:center "><a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php echo $numi; ?>').remove(); calsumInc(); }" class="ico delete" >ลบทิ้ง</a></td>
	  </tr>
	</table>