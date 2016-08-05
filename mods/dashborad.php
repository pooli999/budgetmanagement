<?php 
include("helper.php");
$get = new sHelper();
?>

<script type="text/javascript">
function loadSCT(BgtYear){
	var BgtYear2 = JQ('#BgtYear2').val();
	window.location.href='?alias=backoffice&BgtYear2='+BgtYear2+"&BgtYear="+BgtYear;
}
function loadSCTBG(BgtYear2){
	var BgtYear = JQ('#BgtYear').val();
	window.location.href='?alias=backoffice&BgtYear2='+BgtYear2+"&BgtYear="+BgtYear;
}

</script>

<style>
.tbl-main {
	border-collapse:collapse;
	margin-bottom:10px;
}
.tbl-main th {
	border:1px solid #999;
	background-color:#bbb4d6;
	text-align:center;
	padding:3px;
	color:#FFF;
}
.tbl-main td {
	border:1px solid #999;
	padding:3px;
	text-align:center;
	font-size:12px;
}
.main-topic {
	background-color:#999;
	font-weight:bold;
	padding:5px;
}
</style>
<div class="main-topic">ตารางสรุปงบประจำปีจำแนกตามหมวดงบประมาณ</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-main">
    <tr>
      <th rowspan="2" style="width:120px;">ปีงบประมาณ</th>
      <th rowspan="2" style="width:100px;">จำนวนโครงการ</th>
      <th colspan="2" rowspan="2">งบประมาณ(บาท)</th>
      <th colspan="5">งบประมาณจำแนกตามหมวดงบ(บาท)</th>
    </tr>
    <tr>
      <th style="width:120px;">งบบุคลากร</th>
      <th style="width:120px;">งบดำเนินงาน</th>
      <th style="width:120px;">งบเงินอุดหนุน</th>
      <th style="width:120px;">งบลงทุน</th>
      <th style="width:120px;">งบรายจ่ายอื่น</th>
      </tr>
   <tr>
      <td rowspan="2">2557</td>
      <td rowspan="2">23</td>
      <td style="width:50px;">แผน</td>
      <td style="text-align:right;">295,775,470.00</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
  </tr>
   <tr style="background-color:#EEE;">
     <td>ผล</td>
      <td style="text-align:right;">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
   </tr>
      <tr>
      <td rowspan="2">2556</td>
      <td rowspan="2">23</td>
      <td>แผน</td>
      <td style="text-align:right;">212,210,000.00</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
   </tr>
   <tr style="background-color:#EEE;">
        <td>ผล</td>
        <td style="text-align:right;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
  </tr>
   <tr>
     <td rowspan="2">2555</td>
     <td rowspan="2">24</td>
     <td>แผน</td>
     <td style="text-align:right;">218,259,571.92</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr style="background-color:#EEE;">
      <td>ผล</td>
      <td style="text-align:right;">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
   </tr>
      <tr style="font-weight:bold;">
      <td colspan="3" style="text-align:right;">รวมทั้งสิ้น</td>
      <td style="text-align:right;">726,245,041.92</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
   </tr>
</table>







<div class="main-topic">ตารางสรุปงบประจำปีจำแนกตามแหล่งงบประมาณ</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-main">
    <tr>
      <th rowspan="2" style="width:120px;">ปีงบประมาณ</th>
      <th rowspan="2" style="width:100px;">จำนวนโครงการ</th>
      <th colspan="2" rowspan="2">งบประมาณ(บาท)</th>
      <th colspan="5">งบประมาณจำแนกตามแหล่งงบ(บาท)</th>
    </tr>
    <tr>
      <th style="width:120px;">งบ พ.ร.บ</th>
      <th style="width:120px;">งบ สสส.</th>
      <th style="width:120px;">งบ.....</th>
      <th style="width:120px;">งบ.....</th>
      <th style="width:120px;">งบ.....</th>
      </tr>
   <tr>
      <td rowspan="2">2557</td>
      <td rowspan="2">23</td>
      <td style="width:50px;">แผน</td>
      <td style="text-align:right;">295,775,470.00</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
  </tr>
   <tr style="background-color:#EEE;">
     <td>ผล</td>
      <td style="text-align:right;">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
   </tr>
      <tr>
      <td rowspan="2">2556</td>
      <td rowspan="2">23</td>
      <td>แผน</td>
      <td style="text-align:right;">212,210,000.00</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
   </tr>
   <tr style="background-color:#EEE;">
        <td>ผล</td>
        <td style="text-align:right;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
  </tr>
   <tr>
     <td rowspan="2">2555</td>
     <td rowspan="2">24</td>
     <td>แผน</td>
     <td style="text-align:right;">218,259,571.92</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr style="background-color:#EEE;">
      <td>ผล</td>
      <td style="text-align:right;">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
   </tr>
      <tr style="font-weight:bold;">
      <td colspan="3" style="text-align:right;">รวมทั้งสิ้น</td>
      <td style="text-align:right;">726,245,041.92</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
   </tr>
</table>








