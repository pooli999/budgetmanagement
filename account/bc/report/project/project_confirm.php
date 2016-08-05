<?php
include("config.php");
include($KeyPage."_data.php");
?>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th valign="top">ชื่อ-นามสกุล :</th>
    <td class="require" valign="top">*</td>
    <td>
	<?php echo $_REQUEST["LedName"];?>	</td>
  </tr>
  <tr>
    <th valign="top" >เบอร์ติดต่อ :</th>
    <td class="require">&nbsp;</td>
    <td><?php echo $_REQUEST["Telephone"];?> ต่อ <?php echo $_REQUEST["Ext"];?></td>
  </tr>
  <tr>
    <th valign="top" >เบอร์มือถือ :</th>
    <td class="require">&nbsp;</td>
    <td><?php echo $_REQUEST["Mobile"];?></td>
  </tr>
  <tr>
    <th valign="top" >อีเมล :</th>
    <td class="require">&nbsp;</td>
    <td><?php echo $_REQUEST["Email"];?></td>
  </tr>
  <tr>
    <th valign="top" >คำอธิบาย :</th>
    <td class="require">&nbsp;</td>
    <td>
	<?php
	echo $_REQUEST["Detail"];
	?>
	</td>
  </tr>
    <tr>
    <th valign="top" >&nbsp;</th>
    <td class="require">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>
    <input type="button" name="button4" id="button4" value="กลับไปแก้ไข" class="btn" onclick="toggleView();" />
    <input type="button" class="btnActive" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
      <input type="button" name="button3" id="button3" value=" ยกเลิก " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
  </tr>
</table>
