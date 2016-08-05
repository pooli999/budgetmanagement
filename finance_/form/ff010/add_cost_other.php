<?php
include("config.php");
include("helper.php");
include("data.php");
	$get = new sHelper();
	$othnumc = $_REQUEST["othnumc"];
?>


	<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl<?php echo $othnumc; ?>_other">
  		<tr>
        <td style="width:28%; text-align:center"><?php echo $get->getOtherCostItemCodeList($_REQUEST["DocCodeRefer"]); ?></td>
        <td style=" width:28%;text-align:center"><input type="text" name="OtherDetailCost[]"  id="OtherDetailCost<?php echo $othnumc; ?>" value="" style="width:95%" /></td>
        <td style="width:12%; text-align:center"><input type="text" name="OtherSumCost[]"  id="OtherSumCost<?php echo $othnumc; ?>"  rel="OtherSumCost" value="0.00"   style="width:95%; text-align:right"    onkeypress="return validChars(event,2)"  onkeyup="CalSumOther(<?php echo $othnumc; ?>);  CheckInputDetailOther(<?php echo $othnumc; ?>); javascript:this.value=Comma(this.value);"  /></td>
        <td style="width:8%; text-align:center "><a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php echo $othnumc; ?>_other').remove(); CalSumOther(<?php echo $othnumc; ?>); }" class="ico delete" >ลบทิ้ง</a></td>
	   </tr>
	</table>
    
    


