<?php
//header('Content-type: application/ms-excel');
//header('Content-Disposition: attachment; filename="PAYMENT_VOUCHER'.date("d-m-Y").'.xls"');
$PaymentId = $_REQUEST["PaymentId"];
include("../../../../report/config.php");
$sql = "select * from ac_action inner join tblfinance_payment_comp on ac_action.PaymentId=tblfinance_payment_comp.PaymentId where ac_action.PaymentId = ".$PaymentId;
$result =mysql_query($sql);
if ($row = mysql_fetch_array($result)){		// Loop ชื่อบัญชี Start
  $PV = $row["PV"];
  $ActionDate  = $row["ActionDate"];
  $PartnerName  = $row["PartnerName"];
}
?>

<html>
<head>
<meta name=Title content="">
<meta name=Keywords content="">
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 2008">
<style>
<!--table {}
.font7
	{color:windowtext;
	font-size:14.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"TH Sarabun New";}
.font9
	{color:windowtext;
	font-size:14.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"TH Sarabun New";}
.style18 {}
.style0
	{text-align:general;
	vertical-align:bottom;
	white-space:nowrap;
	color:windowtext;
	font-size:20.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:CordiaUPC;
	border:none;}
td
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	color:windowtext;
	font-size:20.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:CordiaUPC;
	text-align:general;
	vertical-align:bottom;
	border:none;
	white-space:nowrap;}
.xl24
	{font-size:14.0pt;
	font-family:"TH Sarabun New";}
.xl25
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	border:.5pt solid windowtext;}
.xl26
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:left;}
.xl27
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:left;}
.xl28
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:right;
	border:.5pt solid windowtext;}
.xl29
	{font-size:18.0pt;
	font-weight:700;
	font-family:"TH Sarabun New";
	text-align:center;
	white-space:normal;}
.xl30
	{font-size:14.0pt;
	font-weight:700;
	font-family:"TH Sarabun New";
	text-align:left;
	white-space:normal;}
.xl31
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:center;
	border:.5pt solid windowtext;}
.xl32
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl33
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl34
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:center;
	vertical-align:top;
	border:.5pt solid windowtext;}
.xl35
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	white-space:normal;}
.xl36
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	white-space:normal;}
.xl37
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:right;
	vertical-align:top;
	border:.5pt solid windowtext;}
.xl38
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:center;
	border:.5pt solid windowtext;
	white-space:normal;}
.xl39
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:center;
	vertical-align:top;
	border:.5pt solid windowtext;
	white-space:normal;}
.xl40
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	white-space:normal;}
.xl41
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	white-space:normal;}
.xl42
	{font-size:14.0pt;
	font-family:"TH Sarabun New";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;}
ruby
	{ruby-align:left;}
rt
	{color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:CordiaUPC;
	display:none;}
-->
</style>
</head>

<body link="#0000d4" vlink="#993366" class=xl24>
<div class=Section1>
  <p class=MsoNormal>
<table border=0 cellpadding=0 cellspacing=0 width=573 style='border-collapse:
 collapse;table-layout:fixed'>
 <col class=xl24 width=65 span=2>
 <col class=xl24 width=96>
 <col class=xl24 width=102>
 <col class=xl24 width=80 span=2>
 <col class=xl24 width=85>
 <tr height=19>
  <td height=19 class=xl24 width=65></td>
  <td class=xl24 width=65></td>
  <td class=xl24 width=96></td>
  <td class=xl24 width=102></td>
  <td class=xl24 colspan=3 width=245>สำนักงานคณะกรรมการสุขภาพแห่งชาติ</td>
 </tr>
 <tr height=19>
  <td height=19 class=xl24></td>
  <td class=xl24></td>
  <td class=xl24></td>
  <td class=xl24></td>
  <td class=xl24 colspan=2>สนง.คณะกรรมการสุขภาพแห่งชาติ</td>
  <td class=xl24></td>
 </tr>
 <tr height=52>
  <td colspan=6 height=52 class=xl29 width=488>ใบสำคัญจ่าย<br>
  PAYMENT VOUCHER</td>
  <td class=xl24></td>
 </tr>
 <tr height=40>
  <td height=40 class=xl24></td>
  <td class=xl24></td>
  <td class=xl24></td>
  <td class=xl24></td>
  <td colspan=2 class=xl30 width=160>PV<font class=font7> : <?php echo $PV?><br>
  </font><font
  class=font9>วันที่</font><font class=font7> : <?php echo ShowDateLong($ActionDate)?></font></td>
  <td class=xl24></td>
 </tr>
 <tr height=19>
  <td colspan=6 height=19 class=xl27 align=right> จ่ายให้ : <?php echo con_utf($PartnerName);?> </td>
  <td class=xl24></td>
 </tr>
 <tr height=19>
  <td colspan=6 height=19 class=xl26>           เงินยืม</td>
  <td class=xl24></td>
 </tr>
 <tr height=19>
  <td height=19 class=xl24></td>
  <td class=xl24></td>
  <td class=xl24></td>
  <td class=xl24></td>
  <td class=xl24></td>
  <td class=xl24></td>
  <td class=xl24></td>
 </tr>
 <tr height=38>
  <td height=38 class=xl39 width=65>รหัสบัญชี<br>
  Account</td>
  <td class=xl42>รหัสกิจกรรม</td>
  <td colspan=2 class=xl40 width=198 style='border-right:.5pt solid black'>รายการ<br>
  Particulars</td>
  <td class=xl39 width=80>เดบิต<br>
  Debit</td>
  <td class=xl39 width=80>เครดิต<br>
  Credit</td>
  <td class=xl24></td>
 </tr>
 <tr height=43>
  <td height=43 class=xl34>122222</td>
  <td class=xl34>59pcssdf</td>
  <td colspan=2 class=xl35 width=198 style='border-right:.5pt solid black'>sasa
  sa s qwdwqdwqd qwdqwdqwdqwdqw dwqdwqd </td>
  <td class=xl37>999,999,999.00</td>
  <td class=xl37>999,999,999.00</td>
  <td class=xl24></td>
 </tr>
 <tr height=19>
  <td height=19 class=xl25>&nbsp;</td>
  <td class=xl25>&nbsp;</td>
  <td colspan=2 class=xl32 style='border-right:.5pt solid black'>TOTAL</td>
  <td class=xl28>999,999,999.00</td>
  <td class=xl28>999,999,999.00</td>
  <td class=xl24></td>
 </tr>
 <tr height=19>
  <td height=19 class=xl24></td>
  <td class=xl24></td>
  <td class=xl24></td>
  <td class=xl24></td>
  <td class=xl24></td>
  <td class=xl24></td>
  <td class=xl24></td>
 </tr>
 <tr height=111>
  <td colspan=3 height=111 class=xl38 width=226>--------------------------------------<br>
  (นส. ddddddddddd)<br>
  ตำแหน่ง<br>
  ผู้จัดทำบัญชี</td>
  <td colspan=3 class=xl38 width=262>--------------------------------------<br>
  (นส. ddddddddddd)<br>
  ตำแหน่ง<br>
  ผู้ตรวจสอบ</td>
  <td class=xl24></td>
 </tr>
</table>
</p>
</div>
</body>

</html>
