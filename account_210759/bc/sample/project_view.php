<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	
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
        <th valign="top">ชื่อ-นามสกุล :</th>
        <td><?php echo $LedName;?></td>
      </tr>
      <tr>
        <th valign="top">เบอร์ติดต่อ :</th>
        <td valign="top"><?php echo $Telephone;?> <?php if($Ext != '') echo ' ต่อ '.$Ext;?></td>
      </tr>
      <tr>
        <th valign="top">เบอร์มือถือ :</th>
        <td valign="top"><?php echo $Mobile;?></td>
      </tr>
      <tr>
        <th valign="top">อีเมล :</th>
        <td valign="top"><?php echo $Email;?></td>
      </tr>
      <tr>
        <th valign="top">คำอธิบาย :</th>
        <td valign="top"><?php echo $Detail;?></td>
      </tr>
      <tr>
        <th valign="top">&nbsp;</th>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="button" name="button4" id="button4" value="กลับไปแก้ไข" class="btnActive" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>&id=<?php echo $_REQUEST['id'];?>&start=<?php echo $_REQUEST['start'];?>');"  />
        <input name="cancel" type="button" value="ย้อนกลับ" class="btn cancle" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST['start'];?>');" /></td>
      </tr>
    </table>









