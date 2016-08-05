<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setStyles(array(
	'modules/backoffice/budgetpay/style_budgetpay.css'
));
$this->DOC->setPathWays(array(
	array(
		'text' => 'จัดการข้อมูลพื้นฐาน',
		'link' => '?mod=budget.init.startup',
	),
	array(
		'text' => $MenuName,
	),
));




?>


<div class="sysinfo">
  <div class="sysname">จัดการข้อมูลตัวชี้วัด</div>
  <div class="sysdetail">ปรับปรุงแก้ไขรายละเอียดตัวชี้วัด</div>
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="width:120px; padding:5px; border:1px solid #9e676f; border-bottom:8px solid #9e676f; text-align:center; background-color:#b8858d; font-weight:bold;">ตัวชี้วัดโครงการ</td>
    <td style="width:120px; border:1px solid #9e676f; border-bottom:8px solid #9e676f; text-align:center; background-color:#e3cacb; color:#999;">ตัวชี้วัดแผนงาน</td>
    <td style="width:120px; border:1px solid #9e676f; border-bottom:8px solid #9e676f; text-align:center; background-color:#e3cacb; color:#999;">ตัวชี้วัดแผนหลัก</td>
    <td style="border-bottom:8px solid #9e676f;">&nbsp;</td>
  </tr>
</table>


<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
<tr>
    <th>ปีงบประมาณ</th>
    <td>2556</td>
</tr>
<tr>
  <th>รหัสโครงการ</th>
  <td>56P01A</td>
</tr>
<tr>
  <th>ชื่อโครงการ</th>
  <td>โครงการขับเคลื่อน ติดตาม ประเมินผลและทบทวนธรรมนูญว่าด้วยระบบสุขภาพแห่งชาติ พ.ศ. 2552</td>
</tr>
<tr>
    <th>ความถี่ในการรายงาน</th>
    <td>รายเดือน</td>
</tr>
</table>


<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">ข้อมูลตัวชี้วัด</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
<tr>
  <th>รหัสตัวชี้วัด</th>
  <td>IPL001</td>
</tr>
<tr>
  <th>ชื่อตัวชี้วัด</th>
  <td style="font-weight:bold;">มีการจัดทำธรรมนูญสุขภาพพื้นที่หรือนำสาระไปใช้ประกอบการจัดทำแผนพัฒนาสุขภาพในระดับพื้นที่ จำนวน ๓๐ พื้นที่</td>
</tr>
<tr style="vertical-align:top;">
    <th>คำอธิบายตัวชี้วัด</th>
    <td style="color:#999;">-ไม่ระบุ-</td>
</tr>
<tr style="vertical-align:top;">
    <th>วัตถุประสงค์ตัวชี้วัด</th>
    <td style="color:#999;">-ไม่ระบุ-</td>
</tr>
<tr>
    <th>ค่าเป้าหมาย</th>
    <td>30&nbsp;พื้นที่</td>
</tr>
<!--<tr style="vertical-align:top;">
    <th>ผู้กำกับดูแลตัวชี้วัด</th>
    <td>นายกอไก่  สบายใจดี</td>
</tr>
<tr>
    <th>เบอร์ติดต่อผู้กำกับดูแลตัวชี้วัด</th>
    <td>02-5566655</td>
</tr>
--><tr style="vertical-align:top;">
    <th>ผู้รายงานผลตัวชี้วัด</th>
    <td>
	<div>1. นายดีดี&nbsp;&nbsp;มีมากมาย</div>
    <div>2. นายสุขใจ&nbsp;&nbsp;สวนนอก</div>
    </td>
</tr>
<!--<tr>
    <th>ความถี่ในการรายงาน</th>
    <td>รายเดือน</td>
</tr>
--><script>
function showDetail(){
	if(document.getElementById('detail').style.display == ""){
		document.getElementById('detail').style.display="none";
		document.getElementById('a-cate').className='icon-decre txt-normal';
		document.getElementById('a-cate').className='icon-incre txt-normal';
		document.getElementById('a-cate').innerText="แสดงรายละเอียดเพิ่มเติม";
	}else{
		document.getElementById('detail').style.display="";
		document.getElementById('a-cate').className='icon-incre txt-normal';
		document.getElementById('a-cate').className='icon-decre txt-normal';
		document.getElementById('a-cate').innerText="ซ่อนรายละเอียดเพิ่มเติม";
	}
}	
</script>


</table>

<div id="detail">

<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">ข้อมูลเกณฑ์การประเมิน</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
<!--<tr>
    <th>วิธีการคำนวณ</th>
    <td>ค่าสะสม (Summary)</td>
</tr>
--><tr style="vertical-align:top;">
    <th>อธิบายวิธีการคำนวณ</th>
    <td style="color:#999;">-ไม่ระบุ-</td>
</tr>
<!--<tr>
    <th>ค่าถ่วงน้ำหนัก</th>
    <td>1.5</td>
</tr>
--><tr style="vertical-align:top;">
    <th>เกณฑ์การให้คะแนน</th>
    <td>ปริมาณ/ค่าข้อมูล
      <table width="440" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="width:100px;"><input type="text" name="MassValue"  id="MassValue" style="width:98%; text-align:center;" disabled="disabled" value="0" /></td>
          <td style="width:20px; text-align:center;">=</td>
          <td style="width:70px;"><input type="radio" name="val0" checked="checked" /><span class="icon-col1">0 คะแนน</span></td>
          <td style="width:50px;"><input type="radio" name="val0" disabled="disabled" /><span class="icon-col2">1</span></td>
          <td style="width:50px;"><input type="radio" name="val0" disabled="disabled" /><span class="icon-col3">2</span></td>
          <td style="width:50px;"><input type="radio" name="val0" disabled="disabled" /><span class="icon-col4">3</span></td>
          <td style="width:50px;"><input type="radio" name="val0" disabled="disabled" /><span class="icon-col5">4</span></td>
          <td style="width:50px;"><input type="radio" name="val0" disabled="disabled" /><span class="icon-col6">5</span></td>
        </tr>
        <tr>
          <td><input type="text" name="MassValue"  id="MassValue" style="width:98%; text-align:center;" disabled="disabled" value="5" /></td>
          <td style="text-align:center;">=</td>
          <td><input type="radio" name="val1" disabled="disabled" /><span class="icon-col1">0 คะแนน</span></td>
          <td><input type="radio" name="val1" checked="checked" /><span class="icon-col2">1</span></td>
          <td><input type="radio" name="val1" disabled="disabled" /><span class="icon-col3">2</span></td>
          <td><input type="radio" name="val1" disabled="disabled" /><span class="icon-col4">3</span></td>
          <td><input type="radio" name="val1" disabled="disabled" /><span class="icon-col5">4</span></td>
          <td><input type="radio" name="val1" disabled="disabled" /><span class="icon-col6">5</span></td>
        </tr>
        <tr>
          <td><input type="text" name="MassValue"  id="MassValue" style="width:98%; text-align:center;" disabled="disabled" value="10" /></td>
          <td style="text-align:center;">=</td>
          <td><input type="radio" name="val2" disabled="disabled" /><span class="icon-col1">0 คะแนน</span></td>
          <td><input type="radio" name="val2" disabled="disabled" /><span class="icon-col2">1</span></td>
          <td><input type="radio" name="val2" checked="checked" /><span class="icon-col3">2</span></td>
          <td><input type="radio" name="val2" disabled="disabled" /><span class="icon-col4">3</span></td>
          <td><input type="radio" name="val2" disabled="disabled" /><span class="icon-col5">4</span></td>
          <td><input type="radio" name="val2" disabled="disabled" /><span class="icon-col6">5</span></td>
        </tr>
        <tr>
          <td><input type="text" name="MassValue"  id="MassValue" style="width:98%; text-align:center;" disabled="disabled" value="15" /></td>
          <td style="text-align:center;">=</td>
          <td><input type="radio" name="val3" disabled="disabled" /><span class="icon-col1">0 คะแนน</span></td>
          <td><input type="radio" name="val3" disabled="disabled" /><span class="icon-col2">1</span></td>
          <td><input type="radio" name="val3" disabled="disabled" /><span class="icon-col3">2</span></td>
          <td><input type="radio" name="val3" checked="checked" /><span class="icon-col4">3</span></td>
          <td><input type="radio" name="val3" disabled="disabled" /><span class="icon-col5">4</span></td>
          <td><input type="radio" name="val3" disabled="disabled" /><span class="icon-col6">5</span></td>
        </tr>
        <tr>
          <td><input type="text" name="MassValue"  id="MassValue" style="width:98%; text-align:center;" disabled="disabled" value="20" /></td>
          <td style="text-align:center;">=</td>
          <td><input type="radio" name="val4" disabled="disabled" /><span class="icon-col1">0 คะแนน</span></td>
          <td><input type="radio" name="val4" disabled="disabled" /><span class="icon-col2">1</span></td>
          <td><input type="radio" name="val4" disabled="disabled" /><span class="icon-col3">2</span></td>
          <td><input type="radio" name="val4" disabled="disabled" /><span class="icon-col4">3</span></td>
          <td><input type="radio" name="val4" checked="checked" /><span class="icon-col5">4</span></td>
          <td><input type="radio" name="val4" disabled="disabled" /><span class="icon-col6">5</span></td>
        </tr>
        <tr>
          <td><input type="text" name="MassValue"  id="MassValue" style="width:98%; text-align:center;" disabled="disabled" value="30" /></td>
          <td style="text-align:center;">=</td>
          <td><input type="radio" name="val5" disabled="disabled" /><span class="icon-col1">0 คะแนน</span></td>
          <td><input type="radio" name="val5" disabled="disabled" /><span class="icon-col2">1</span></td>
          <td><input type="radio" name="val5" disabled="disabled" /><span class="icon-col3">2</span></td>
          <td><input type="radio" name="val5" disabled="disabled" /><span class="icon-col4">3</span></td>
          <td><input type="radio" name="val5" disabled="disabled" /><span class="icon-col5">4</span></td>
          <td><input type="radio" name="val5" checked="checked" /><span class="icon-col6">5</span></td>
        </tr>
      </table>
      
    </td>
</tr>


</table>



<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">แผนการดำเนินการรายเดือน/ไตรมาส</div>
<table width="100%" border="0" class="tbl-list"  cellspacing="1" cellpadding="0" style="margin-top:0px;">
<thead>
  <tr>
    <th rowspan="2" align="center">ไตรมาส</th>
    <th rowspan="2" align="center" style="width:150px">เดือน/ปี</th>
    <th colspan="2" align="center" style="width:150px">ค่าเป้าหมาย</th>
    <th rowspan="2" align="center" style="width:150px" >เดือน/ปี</th>
    <th colspan="2" align="center" style="width:150px">ค่าเป้าหมาย</th>
    <th rowspan="2" align="center" style="width:150px" >เดือน/ปี</th>
    <th colspan="2" align="center" style="width:150px">ค่าเป้าหมาย</th>
    </tr>
  <tr>
    <th align="center" style="width:80px">แผน</th>
    <th align="center" style="width:80px">ผล</th>
    <th align="center" style="width:80px">แผน</th>
    <th align="center" style="width:80px">ผล</th>
    <th align="center" style="width:80px">แผน</th>
    <th align="center" style="width:80px">ผล</th>
    </tr>
</thead>


  <tr>
    <td align="center" >ไตรมาสที่ 1</td>
    <td align="center">ตุลาคม/55</td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" value="3" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" /></td>
    <td align="center">พฤศจิกายน/55</td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" value="6" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" /></td>
    <td align="center">ธันวาคม/55</td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" value="9" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" /></td>
  </tr>
  
  <tr>
    <td align="center">ไตรมาสที่ 2</td>
    <td align="center">มกราคม/56</td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" value="12" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" /></td>
    <td align="center">กุมภาพันธ์/56</td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" value="15" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" /></td>
    <td align="center">มีนาคม/56</td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" value="18" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" /></td>
  </tr>
  
  <tr>
    <td align="center">ไตรมาสที่ 3</td>
    <td align="center">เมษายน/56</td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" value="20" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" /></td>
    <td align="center">พฤษภาคม/56</td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" value="22" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" /></td>
    <td align="center">มิถุนายน/56</td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" value="24" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" /></td>
  </tr>
  <tr>
   <td align="center">ไตรมาสที่ 4</td>
   <td align="center">กรกฏาคม/56</td>
   <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" value="26" /></td>
   <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" /></td>
   <td align="center">สิงหาคม/56</td>
   <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" value="28" /></td>
   <td align="center"><input type="text" style="width:85%; text-align:center;"  disabled="disabled" /></td>
   <td align="center">กันยายน/56</td>
   <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" value="30" /></td>
   <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" /></td>
  </tr>
  <tr style="font-weight:bold;">
    <td colspan="8" style="text-align:right; font-weight:bold;">รวมทั้งสิ้น</td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" value="30" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" disabled="disabled" /></td>
  </tr>
</table>


</div><!--End div detail-->




<div style="padding:10px; text-align:center;">
<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="history.back(-1);" />
</div>