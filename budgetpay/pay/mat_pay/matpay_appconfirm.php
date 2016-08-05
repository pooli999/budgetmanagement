<?php
include("config.php");
include($KeyPage."_data.php");
?>



<?php include("modules/backoffice/budgetpay/pay/confirm.php"); ?>


<div style="text-align:center; padding:10px">
    <input type="button" name="button4" id="button4" value="กลับไปแก้ไข" class="btn" onclick="toggleView();" />
    <input type="button" class="btnActive" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
    <input type="button" name="button3" id="button3" value=" ยกเลิก " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" />
</div>
