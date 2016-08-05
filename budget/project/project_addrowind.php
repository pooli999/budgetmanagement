<?php
	include("config.php");
	include($KeyPage."_helper.php");
	include($KeyPage."_data.php");
	$get = new sHelper();
	$num = $_REQUEST["num"];
?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl<?php echo $num; ?>">
    <tr>
    <td style="width:40%; text-align:center"><input type="text" name="IndicatorName[]"  id="IndicatorName" value="" style="width:95%" /></td>
    <td style="width:20%; text-align:center"><?php echo $get->getIndTypeNameList();?></td>
    <td style="width:15%; text-align:center"><input type="text" name="Value[]"  id="Value" value="" style="width:95%" /></td>
    <td style="width:15%; text-align:center"><?php echo $get->getUnitList($UnitID);?></td>
    <td style="width:10%; text-align:center"><a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php echo $num; ?>').remove(); CountItem--;}" class="ico delete" >ลบทิ้ง</a></td>
    </tr>
 </table>

