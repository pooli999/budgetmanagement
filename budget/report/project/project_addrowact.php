<?php
	include("config.php");
	include($KeyPage."_helper.php");
	include($KeyPage."_data.php");
	$get = new sHelper();
	$numA = $_REQUEST["numA"];
?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tblact<?php echo $numA; ?>">
    <tr style="vertical-align:top;">
      	<td style="width:120px; text-align:center">
		<?php 
			$PrjActStart = date('Y-m-d');
			echo InputCalendar_text(array(
				'id' => 'PrjActStart'.$numA,
				'name' => 'PrjActStart[]',
				'value' => $PrjActStart
			));
		?>        
        </td>
        <td style="width:120px; text-align:center">
		<?php 
			$PrjActEnd = date('Y-m-d');
			echo InputCalendar_text(array(
				'id' => 'PrjActEnd'.$numA,
				'name' => 'PrjActEnd[]',
				'value' => $PrjActEnd
			));
		?>         
        </td>
        <td style="text-align:center"><textarea name="PrjActName[]" id="PrjActName" style="width:98%; height:30px;"></textarea><!--<input type="text" name="PrjActName[]" id="PrjActName" value=""   style="width:200px;"/>--></td>
        <td style="width:120px; text-align:center"><?php echo $get->getTypeActNameList($TypeActId);?></td>
        <td style="width:70px; text-align:center" ><input type="text" name="PercentMass[]"  id="PercentMass[]" value="<?php echo $PercentMass;?>" style="width:95%" class="number" /></td>
        <td style="width:120px; text-align:center" ><?php echo $get->getOrgShortNameList($_REQUEST["BgtYear"],$OrganizeCode);?></td>
        <td style="width:120px; text-align:left"><a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tblact<?php echo $numA; ?>').remove(); CountItemA--;}" class="ico delete" >ลบทิ้ง</a></td>    
    </tr>
 </table>
