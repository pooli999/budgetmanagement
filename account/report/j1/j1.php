<?php
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename="reportmaster_excel_'.date("d-m-Y").'.xls"');
?>
<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
<style>
tr
	{mso-height-source:auto;}
col
	{mso-width-source:auto;}
br
	{mso-data-placement:same-cell;}
.style0
	{mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	white-space:nowrap;
	mso-rotate:0;
	mso-background-source:auto;
	mso-pattern:auto;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:222;
	border:none;
	mso-protection:locked visible;
	mso-style-name:ปกติ;
	mso-style-id:0;}
td
	{mso-style-parent:style0;
	padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:222;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:none;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:locked visible;
	white-space:nowrap;
	mso-rotate:0;}
.xl65
	{mso-style-parent:style0;
	font-size:10.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.xl66
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.xl67
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;}
.xl68
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border:.5pt solid windowtext;}
.xl69
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"Short Date";
	text-align:center;
	vertical-align:top;
	border:.5pt solid windowtext;}
.xl70
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	vertical-align:top;
	border:.5pt solid windowtext;}
.xl71
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	vertical-align:top;
	border:.5pt solid windowtext;
	white-space:normal;}
.xl72
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"Short Date";
	vertical-align:top;
	border:.5pt solid windowtext;}
.xl73
	{mso-style-parent:style0;
	font-size:10.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"Short Date";
	text-align:center;
	border:.5pt solid windowtext;}
.xl74
	{mso-style-parent:style0;
	font-size:10.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border:.5pt solid windowtext;}
.xl75
	{mso-style-parent:style0;
	font-size:10.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border:.5pt solid windowtext;}
.xl76
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:top;
	border:.5pt solid windowtext;
	background:#F2F2F2;
	mso-pattern:black none;}
.xl77
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"\@";
	text-align:left;
	vertical-align:top;
	border:.5pt solid windowtext;}
.xl78
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:Standard;
	vertical-align:top;
	border:.5pt solid windowtext;}
.xl79
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:Standard;
	border:.5pt solid windowtext;}
.xl80
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"\@";
	text-align:center;
	vertical-align:top;
	border:.5pt solid windowtext;
	background:#F2F2F2;
	mso-pattern:black none;}
.xl81
	{mso-style-parent:style0;
	font-size:10.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl82
	{mso-style-parent:style0;
	font-size:10.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl83
	{mso-style-parent:style0;
	font-size:10.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl84
	{mso-style-parent:style0;
	font-size:10.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"Short Date";
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;}
.xl85
	{mso-style-parent:style0;
	font-size:10.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"Short Date";
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl86
	{mso-style-parent:style0;
	font-size:10.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"Short Date";
	text-align:center;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl87
	{mso-style-parent:style0;
	font-size:10.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl88
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;}
.xl89
	{mso-style-parent:style0;
	font-size:10.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;}
.xl90
	{mso-style-parent:style0;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#F2F2F2;
	mso-pattern:black none;
	white-space:normal;}
.xl91
	{mso-style-parent:style0;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;}
.xl92
	{mso-style-parent:style0;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;}

<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
@page
	{margin:.04in .04in .04in .04in;
	mso-header-margin:.31in;
	mso-footer-margin:.31in;}
-->
</style>
</head>

<body link=blue vlink=purple class=xl65>
<?php
function ShowDate($myDate) {
		if($myDate=="0000-00-00" || $myDate==""){ return "";}
		$myDateArray=explode("-",$myDate);
		$myDay = sprintf("%d",$myDateArray[2]);
		switch($myDateArray[1]) {
			case "01" : $myMonth = "ม.ค.";  break;
			case "02" : $myMonth = "ก.พ.";  break;
			case "03" : $myMonth = "มี.ค."; break;
			case "04" : $myMonth = "เม.ย."; break;
			case "05" : $myMonth = "พ.ค.";   break;
			case "06" : $myMonth = "มิ.ย.";  break;
			case "07" : $myMonth = "ก.ค.";   break;
			case "08" : $myMonth = "ส.ค.";  break;
			case "09" : $myMonth = "ก.ย.";  break;
			case "10" : $myMonth = "ต.ค.";  break;
			case "11" : $myMonth = "พ.ย.";  break;
			case "12" : $myMonth = "ธ.ค.";  break;
		}
		$myYear = sprintf("%d",$myDateArray[0])+543;
        return($myDay . " " . $myMonth . " " . substr($myYear,2));
}
$myServer = "localhost";
$myUser = "root";
$myPass = "go11co11";

// $myUser = "root1";
// $myPass = "1234";

$db_ksp ="nationalhealth";

$dbhandle = mysql_connect($myServer, $myUser, $myPass)or die("Couldn't connect to SQL Server on $myServer");
$selected = mysql_select_db($db_ksp, $dbhandle)or die("Couldn't open database $myDB");
mysql_query("SET character_set_results=tis620");
mysql_query("SET character_set_client=tis620");
mysql_query("SET character_set_connection=tis620");

$sql1 = "SELECT journalName FROM ac_journal WHERE journalId=".$_REQUEST["journalId"];
$resultjname =mysql_query($sql1);
if ($rowjn = mysql_fetch_array($resultjname)){
    $journalName = $rowjn["journalName"];
}
?>
<table border=0 cellpadding=0 cellspacing=0 width=764 style='border-collapse:
 collapse;table-layout:fixed;width:573pt'>
 <col class=xl65 width=79 style='mso-width-source:userset;mso-width-alt:2528;
 width:59pt'>
 <col class=xl65 width=95 style='mso-width-source:userset;mso-width-alt:3040;
 width:71pt'>
 <col class=xl65 width=104 style='mso-width-source:userset;mso-width-alt:3328;
 width:78pt'>
 <col class=xl65 width=316 style='mso-width-source:userset;mso-width-alt:10112;
 width:237pt'>
 <col class=xl65 width=85 span=2 style='mso-width-source:userset;mso-width-alt:
 2720;width:64pt'>
 <tr height=20 style='height:15.0pt'>
  <td colspan=6 height=20 class=xl88 width=764 style='height:15.0pt;width:573pt'>สำนักงานคณะกรรมการสุขภาพแห่งชาติ
  สนง. คณะกรรมการสุขภาพแห่งชาติ</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=6 height=20 class=xl88 style='height:15.0pt'>รายการรายวันเรียงวันที่ - <?php echo iconv("tis-620","utf-8",$journalName);?></td>
 </tr>
 <tr height=17 style='height:12.75pt'>
  <td colspan=6 height=17 class=xl89 style='height:12.75pt'>สำหรับรายการในช่วงวันที่
  <?php echo ShowDate($_REQUEST["st"]); ?> ถึง <?php echo ShowDate($_REQUEST["ed"]); ?></td>
 </tr>
 <tr height=17 style='height:12.75pt'>
  <td colspan=6 height=17 class=xl87 style='height:12.75pt'>&nbsp;</td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl67 style='height:15.75pt;border-top:none'>วันที่</td>
  <td class=xl67 style='border-top:none;border-left:none'>เอกสาร</td>
  <td class=xl67 style='border-top:none;border-left:none'>รหัสบัญชี</td>
  <td class=xl67 style='border-top:none;border-left:none'>ชื่อบัญชี/รายละเอียด</td>
  <td class=xl67 style='border-top:none;border-left:none'>จำนวนเงินเดบิต</td>
  <td class=xl67 style='border-top:none;border-left:none'>จำนวนเงินเครดิต</td>
 </tr>
<?php
	$sqlitem = "SELECT * FROM ac_action as t1 inner join tblfinance_payment as t2 on t1.PaymentId=t2.PaymentId WHERE journalId=".$_REQUEST["journalId"]." and ActionDate>='".$_REQUEST["st"]."' and ActionDate<='".$_REQUEST["ed"]."' order by ActionDate,PV ASC";

	//echo $sqlitem."<br>";
	$resultitem =mysql_query($sqlitem);
	while ($rowi = mysql_fetch_array($resultitem)){		// Loop PV Start
		// $sqlExpend = "SELECT * FROM ac_action_detail as t1 left join tblfinance_payment_list_detail as t3 on t1.PaymentListDetailId=t3.PaymentListDetailId WHERE t1.AcActionId=".$rowi["AcActionId"];
		// echo "----| ".$sqlExpend;
		// $resultex =mysql_query($sqlExpend);
		// $count_e = 0;
		// while ($rowe = mysql_fetch_array($resultex)){		// Loop Expend Start
		// 	if($count_e==0){		// รอบแรก display PV
?>
 <tr height=19 style='height:14.25pt'>
  <td height=19 class=xl80 style='height:14.25pt;border-top:none'><?php echo ShowDate($rowi["ActionDate"]);?></td>
  <td class=xl76 style='border-top:none;border-left:none'><?php echo $rowi["PV"];?></td>
  <td colspan=4 class=xl90 width=590 style='border-right:.5pt solid black;
  border-left:none;width:443pt'><?php echo iconv("tis-620","utf-8",$rowi["PaymentDetailAccount"]);?></td>
 </tr>
 <?php
		$sqlDr = "SELECT * FROM ac_action_detail as t1 inner join ac_chart as t2 on t1.DrId=t2.AcChartId WHERE t1.AcActionId=".$rowi["AcActionId"]." order by Ordering asc";
		$resultdr =mysql_query($sqlDr);
		$sumdr = 0;
		while ($rowd = mysql_fetch_array($resultdr)){		// Loop Dr Start
 ?>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl69 style='height:12.75pt;border-top:none'>&nbsp;</td>
  <td class=xl70 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl77 style='border-top:none;border-left:none'><?php echo $rowd["AcChartCode"];?></td>
  <td class=xl71 align=left width=316 style='border-top:none;border-left:none;
  width:237pt'><?php echo iconv("tis-620","utf-8",$rowd["ThaiName"]);?></td>
  <td class=xl78 align=right style='border-top:none;border-left:none'><?php echo $rowd["DrValue"];?></td>
  <td class=xl78 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 <?php
 			$sumdr = $sumdr+$rowd["DrValue"];
 		}
 ?>
  <?php
		$sqlCr = "SELECT * FROM ac_action_detail as t1 inner join ac_chart as t2 on t1.CrId=t2.AcChartId WHERE t1.AcActionId=".$rowi["AcActionId"]." order by Ordering asc";
		$resultcr =mysql_query($sqlCr);
		$sumcr = 0;
		while ($rowc = mysql_fetch_array($resultcr)){		// Loop Cr Start
 ?>
 <tr class=xl66 height=16 style='height:12.0pt'>
  <td height=16 class=xl72 style='height:12.0pt;border-top:none'>&nbsp;</td>
  <td class=xl70 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl77 style='border-top:none;border-left:none'><span
  style='mso-spacerun:yes'>          </span><?php echo $rowc["AcChartCode"];?></td>
  <td class=xl71 align=left width=316 style='border-top:none;border-left:none;
  width:237pt'><span style='mso-spacerun:yes'>          </span><?php echo iconv("tis-620","utf-8",$rowc["ThaiName"]);?></td>
  <td class=xl78 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl78 align=right style='border-top:none;border-left:none'><?php echo $rowc["CrValue"];?></td>
 </tr>
 <?php
 			$sumcr = $sumcr+$rowc["CrValue"];
 		}
 ?>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl73 style='height:12.75pt;border-top:none'>*** รวม ***</td>
  <td class=xl74 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl75 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl68 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl79 align=right style='border-top:none;border-left:none'><?php echo $sumdr;?></td>
  <td class=xl79 align=right style='border-top:none;border-left:none'><?php echo $sumcr;?></td>
 </tr>
 <tr height=5 style='mso-height-source:userset;height:3.95pt'>
  <td colspan=6 height=5 class=xl84 style='border-right:.5pt solid black;
  height:3.95pt'>&nbsp;</td>
 </tr>
<?php
	}
?>
</table>

</body>

</html>
