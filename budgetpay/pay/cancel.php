<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view"> 
    <tr>
    <td colspan="2" ><div class="title-bar">บันทึกยกเลิกการตัดจ่ายงบประมาณ  :</div></td>
  </tr> 
   <tr>
    <th>ผลการตัดจ่าย  :</th>
    <td>
      <input name="DocStatusId" type="radio" value="8" checked="checked" /> <span style="color:#990000;">ต้องการยกเลิกรายการตัดจ่ายงบ</span>
    </td>
  </tr>   
  <tr>
    <th style="vertical-align:top;">หมายเหตุ  :</th>
    <td><textarea name="Comment"  style="width:99%; height:100px;"></textarea></td>
  </tr> 
  <tr>
 <th colspan="2">ไฟล์เอกสารแนบ  :</th>
</tr>
<tr>
 <td colspan="2">
 <?php
		FilesManager::LinkFiles(
		array(
			"MaxUploadSize"=> 1,
			"imgWidth"		=>120,
			'imgHeight'		=> 100,
			'UploadType'	=> "multi",
			'FileTypeAllow'	=> "*",
			'ActiveObj'	=> "MultiDocId",
			'ActiveId'	=> "",
			'Category'	=> "ระบบนโยบายแผนงาน",
			'SubCategory'	=> "แผนปฏิบัติงานประจำปี",		
			'System'		=> "backoffice",
			'Module'		=> "project"
		));
		
?>
  
        
 </td>
 </tr> 
 <tr>
    <th>ผู้บันทึกข้อมูล  :</th>
    <td><?php echo $_SESSION["Session_FullName"]; ?> (<?php echo dateformat(date('Y-m-d'));?>)
    </td>
  </tr>   
    </table>
