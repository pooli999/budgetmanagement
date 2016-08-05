<?php
	include("config.php");
	include($KeyPage."_helper.php");
	include($KeyPage."_data.php");
	$get = new sHelper();
	$num = $_REQUEST["num"];
?>


	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list"  id="tbl<?php echo $num; ?>">
  		<tr>
  		  <td style="width:35%; text-align:center"><?php echo $get->getPersonalList(0,0,$StaffPersonalCode,'StaffPersonalCode[]','style="width:200px"');?></td>
  		  <td style="width:35%; text-align:center"><?php echo $get->getPositionList($StaffPositionId,'StaffPositionId[]');?></td>
		  <td style="width:20%; text-align:center"><?php echo $get->getDuty($DutyId,'DutyId[]');?></td>
  		  <td style="width:10%; text-align:center"><a href="javascript:void(0);" onclick="JQ('#tbl<?php echo $num; ?>').remove(); CountItem--;" class="ico delete" >ลบทิ้ง</a></td>
		  </tr>
	</table>


