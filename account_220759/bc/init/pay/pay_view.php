<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => 'จัดการข้อมูลพื้นฐาน',
		'link' => '?mod=budget.init.startup',
	),
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'รายละเอียด',
	),
));

?>
<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST['start'];?>');" /></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
<th>รหัสรายการค่าใช้จ่าย</th>
<td><?php echo $SourceCode;?></td>
</tr>  
<tr>
<th>ชื่อรายการค่าใช้จ่าย</th>
<td><?php echo $SourceExName;?></td>
</tr>      
<tr>
<th>คำอธิบาย</th>
<td><?php echo $SourceDetail;?></td>
</tr>
<tr>
  <th>&nbsp;</th>
  <td>
  <input type="button" name="button4" id="button4" value="กลับไปแก้ไข" class="btnRed" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>&id=<?php echo $_REQUEST['id'];?>&start=<?php echo $_REQUEST['start'];?>');"  />
  <input name="cancel" type="button" value="ย้อนกลับ" class="btn cancle" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST['start'];?>');" />
  </td>
 </tr>
</table>









