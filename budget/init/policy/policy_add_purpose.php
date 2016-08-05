<?php
	include("config.php");
	include($KeyPage."_helper.php");
	include($KeyPage."_data.php");
	$get = new sHelper();
	$num = $_REQUEST["num"];
?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl<?php echo $num; ?>">
    <tr style="vertical-align:top;">
    <td style="width:92%; text-align:center"><textarea style="width:99%; height:35px;" name="PurposeName[]"></textarea></td>
    <td style="width:8%; text-align:center"><a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php echo $num; ?>').remove(); CountItem--;}" class="ico delete" >ลบทิ้ง</a></td>
    </tr>
 </table>

