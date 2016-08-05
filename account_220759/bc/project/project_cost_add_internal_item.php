<?php
	include("config.php");
	include($KeyPage."_helper.php");
	include($KeyPage."_data.php");
	$get = new sHelper();
	$num = $_REQUEST["num"];
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list"  id="tbl<?php echo $num; ?>">
	<tr>
		<td style="text-align:center; width:20%;"><input type="text" name="Detail[]"  id="Detail" value="" style="width:95%" /></td>
        
		<td style="text-align:center; width:60px;"><input type="text" name="Value1[]" id="Value1"  rel="Value1"  class="number" onkeyup="CalSum()"  value="0" style="width:95%; text-align:right" /></td>
		<td style="text-align:center; width:80px;"><?php  echo $get->getUnitList($Unit1,"Unit1[]"); ?></td>
        
		<td style="text-align:center; width:60px;"><input type="text" name="Value2[]" id="Value2"  rel="Value2"  class="number" onkeyup="CalSum()"  value="1" style="width:95%; text-align:right" /></td>
		<td style="text-align:center; width:80px;"><?php  echo $get->getUnitList($Unit2,"Unit2[]"); ?></td>
        
		<td style="text-align:center; width:60px;"><input type="text" name="Value3[]" id="Value3"  rel="Value3"  class="number" onkeyup="CalSum()"  value="1" style="width:95%; text-align:right" /></td>
		<td style="text-align:center; width:80px;"><?php  echo $get->getUnitList($Unit3,"Unit3[]"); ?></td>
        
		<td style="text-align:center; width:60px;"><input type="text" name="Value4[]" id="Value4"  rel="Value4"  class="number" onkeyup="CalSum()"  value="1" style="width:95%; text-align:right" /></td>
		<td style="text-align:center; width:80px;"><?php  echo $get->getUnitList($Unit4,"Unit4[]"); ?></td>
        
		<td style="text-align:center; width:120px;"><input type="text" name="SumCost[]"  id="SumCost"  rel="SumCost" value="0"  class="number" style="width:95%; text-align:right" readonly="readonly" />        
        </td>
		<td style="text-align:center; width:50px; ">
        <a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php echo $num; ?>').remove();   }" class="ico delete" >ลบทิ้ง</a>
        </td>        
	</tr>
 </table>
