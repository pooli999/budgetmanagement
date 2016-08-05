<?php
	include("config.php");
	include($KeyPage."_helper.php");
	include($KeyPage."_data.php");
	$get = new sHelper();
	$num = $_REQUEST["num"];
?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $num; ?>">
    <tr>
    <td style="width:15%; text-align:center"><input type="text" style="width:99%; text-align:center;" name="PIndCode[]" /></td>
    <td style="width:77%; text-align:center"><input type="text" style="width:99%;" name="PIndName[]" /></td>
    <td style="width:8%; text-align:center"><a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl-ind<?php echo $num; ?>').remove(); CountItem--;}" class="ico delete" >ลบทิ้ง</a></td>
    </tr>
 </table>

