<?php
	include("config.php");
	include($KeyPage."_helper.php");
	include($KeyPage."_data.php");
	$get = new sHelper();
	$num = $_REQUEST["num"];
?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl<?php echo $num; ?>">
    <tr>
    <td style="width:30%; text-align:center"><?php //echo $get->getMainGroup(); ?>
                    <?php
					$Network = $get->getNetworkParent();
					?>
                  <select style="width:250px;" name="CatGroupId[]" id="CatGroupId<?php echo $num; ?>" onchange="getSubGroup(this.value,'<?php echo $num; ?>');">
                  		<option value="-1">=== เลือกหมวดหมู่ ===</option>
                    	<?php
						foreach($Network as $rs){
						?>
                    	<option value="<?php echo $rs->CatGroupId;?>"><?php echo $rs->CatGroupName;?></option>
                        <?php
						}
						?>
                    </select>
    </td>
    <td style="width:30%; text-align:center">
                    <select style="width:250px;" name="CatGroupCode[]" id="CatGroupCode<?php echo $num; ?>"  onchange="getPerson(this.value,'<?php echo $num; ?>');">
                    	<option value="-1">=== เลือกหมวดหมู่ ===</option>
                    </select>
    </td>
    <td style="width:30%; text-align:center">
                    <select style="width:250px;" name="PartnerCode[]" id="PartnerCode<?php echo $num; ?>" >
                    	<option value="-1">=== เลือกภาคี ===</option>
                    </select>    
    </td>
    <td style="width:10%; text-align:center"><a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php echo $num; ?>').remove(); } " class="ico delete" >ลบทิ้ง</a></td>
    </tr>
 </table>

