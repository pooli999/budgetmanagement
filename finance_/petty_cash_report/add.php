<?php
include("config.php");
include("helper.php");
include("data.php");

$this->DOC->setPathWays(array(
	array(
		'text' => getMenuItem(lurl::dotPage($startupPage))->MenuName,
		'link' => '?mod='.lurl::dotPage($startupPage)
	),
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'เพิ่มข้อมูล'.$MenuName
	),
));
?>
<style type="text/css">
<!--
.style1 {
	color: #FF6A11;
	font-weight: bold;
}
-->
</style>


<div class="sysinfo">
  <div class="sysname">เพิ่มรายการข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไขข้อมูล<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
  </tr>
</table>
<div id="import-box">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="PersonalId" id="PersonalId" value="<?php echo $_GET['id']?>" />
<fieldset  >
<legend ><b>รายการที่จ่ายเงินสดย่อย</b></legend>
  <table width="100%" border="0" cellpadding="1" cellspacing="1" class="tbl-list-sub">
    <tr>
      <th width="50" height="25" align="center" bgcolor="A6A5B3" style="width:50">&nbsp;</th>
      <th bgcolor="A6A5B3" style="width:200px; text-align:center;">เลขที่ สช.น</td>
      <th bgcolor="A6A5B3">รายละเอียด</td>
      <th bgcolor="A6A5B3">จำนวนเงิน</td>      </tr>
    <tr>
      <td bgcolor="E6E6E6" style="width:50px; text-align:center;">1</th>
      <td bgcolor="E6E6E6" style="width:200px; text-align:center;">0015/2559</td>
      <td bgcolor="E6E6E6">โครงการ : โครงการจัดสมัชชาสุขภาพแห่งชาติ<br />
        เรื่อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 	ขออนุมัติเบิกจ่ายค่าใช้จ่าย1<br />
        ชื่อผู้ปฏิบัติงาน : นางสาวทดสอบ </td>
      <td bgcolor="E6E6E6" style="width:200px; text-align:right;">1,000</td>
      </tr>
    <tr>
      <td align="center" style="width:50px; text-align:center;">2</th>
      <td style="width:200px; text-align:center;">0019/2559</td>
      <td>โครงการ : โครงการจัดสมัชชาสุขภาพแห่งชาติ<br />
เรื่อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 	ขออนุมัติเบิกจ่ายค่าใช้จ่าย2<br />
ชื่อผู้ปฏิบัติงาน : นางสาวทดสอบ </td>
      <td style="width:200px; text-align:right;">400</td>
      </tr>
    <tr>
      <td align="center" bgcolor="E6E6E6" style="width:50px; text-align:center;">3</th>
      <td bgcolor="E6E6E6" style="width:200px; text-align:center;">0020/2559</td>
      <td bgcolor="E6E6E6">โครงการ : โครงการจัดสมัชชาสุขภาพแห่งชาติ<br />
เรื่อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 	ขออนุมัติเบิกจ่ายค่าใช้จ่าย3<br />
ชื่อผู้ปฏิบัติงาน : นางสาวทดสอบ </td>
      <td bgcolor="E6E6E6" style="width:200px; text-align:right;">1,000</td>
      </tr>
    <tr>
      <td align="center">4</th>
      <td style="width:200px; text-align:center;">0025/2559</td>
      <td>โครงการ : โครงการจัดสมัชชาสุขภาพแห่งชาติ<br />
เรื่อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 	ขออนุมัติเบิกจ่ายค่าใช้จ่าย4<br />
ชื่อผู้ปฏิบัติงาน : นางสาวทดสอบ </td>
      <td style="width:200px; text-align:right;">500</td>
      </tr>
    <tr>
      <td colspan="3" style="text-align:right;">จำนวนเงินรวม&nbsp;</th>
      <td style="width:200px; text-align:right;"><strong>2,400</strong></td>
      </tr>
</table>
  </fieldset>
</form>
</div>
