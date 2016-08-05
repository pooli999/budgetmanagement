<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view"> 
    <tr>
    <td colspan="2" ><div class="title-bar">บันทึกยกเลิกการตัดจ่ายงบประมาณ  :</div></td>
  </tr> 
   <tr>
    <th>ผลการตัดจ่าย  :</th>
    <td><?php echo "<span class='ico cancel txt-red'>ต้องการยกเลิกรายการตัดจ่ายงบ</span>"; ?></td>
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
