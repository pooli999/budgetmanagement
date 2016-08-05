<?php
header("Content-type: text/html; charset=tis-620");
header("Content-Disposition: attachment; filename=Plan-report2_".date("d-m-Y").".xls");
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

?>


<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
<style>
body {
	 font-family:TH SarabunPSK; 
	 font-size: 14px; 
	 margin:20px;
}
.tbl-list {
	border-collapse:collapse;
	font-family:TH SarabunPSK; 
	font-size: 14px; 
}
.tbl-list th {
	border:1px solid #999;
	padding-left:3px;
	padding-right:3px;
}
.tbl-list td {
	border:1px solid #999;
	padding-left:3px;
	padding-right:3px;
}
.sum-total {
	text-align:right;
}
</style>
</HEAD>
<BODY>




<div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div>  

</BODY>

</HTML>


