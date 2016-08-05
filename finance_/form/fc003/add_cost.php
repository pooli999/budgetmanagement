<?php
include("config.php");
include("helper.php");
include("data.php");
	$get = new sHelper();
	$numc = $_REQUEST["numc"];
?>


	<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl<?php echo $numc; ?>">
  		<tr>
        <td style="width:28%; text-align:center"><?php echo $get->getCostItemCodeList($_REQUEST["DocCodeRefer"]); ?></td>
        <td style=" width:28%;text-align:center"><input type="text" name="DetailCost[]"  id="DetailCost<?php echo $numc; ?>" value="" style="width:95%" /></td>
        <td style="width:12%; text-align:center"><input type="text" name="SumCost[]"  id="SumCost<?php echo $numc; ?>"  rel="SumCost" value="0.00"   style="width:95%; text-align:right"    onkeypress="return validChars(event,2)"  onkeyup="CalSum(<?php echo $numc; ?>);  CheckInputDetail(<?php echo $numc; ?>); javascript:this.value=Comma(this.value);"  /></td>
        <td style="width:8%; text-align:center "><a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php echo $numc; ?>').remove(); CalSum(<?php echo $numc; ?>); }" class="ico delete" >ลบทิ้ง</a></td>
	   </tr>
	</table>
    
    


