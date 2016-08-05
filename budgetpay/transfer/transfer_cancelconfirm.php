<?php
include("config.php");
include($KeyPage."_data.php");
?>



<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view"> 
    <tr>
    <td colspan="2" ><div class="title-bar">บันทึกโอนเงินงบประมาณ  :</div></td>
  </tr> 
   <tr>
    <th>ผลการโอนเงิน  :</th>
    <td><?php echo "<span class='ico cancel txt-red'>ต้องการยกเลิกรายการโอนเงิน</span>"; ?></td>
  </tr>   
  <tr>
    <th style="vertical-align:top;">หมายเหตุ  :</th>
    <td><?php echo ($_REQUEST["Comment"])?$_REQUEST["Comment"]:"<span style='color:#999;'>ไม่ระบุ</span>"; ?></td>
  </tr> 
  <tr>
 <th colspan="2">ไฟล์เอกสารแนบ  :</th>
</tr>
<tr>
 <td colspan="2"><?php  FilesManager::LinkFilesConfirm(array('ActiveObj' => 'MultiDocId'));?></td>
 </tr> 
 <tr>
    <th>ผู้บันทึกข้อมูล  :</th>
    <td><?php echo $_SESSION["Session_FullName"]; ?> (<?php echo dateformat(date('Y-m-d'));?>)
    </td>
  </tr>   
    </table>


<div style="text-align:center; padding:10px">
    <input type="button" name="button4" id="button4" value="กลับไปแก้ไข" class="btn" onclick="toggleView();" />
    <input type="button" class="btnActive" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
    <input type="button" name="button3" id="button3" value=" ยกเลิก " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" />
</div>
