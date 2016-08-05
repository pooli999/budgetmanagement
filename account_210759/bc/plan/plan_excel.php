<?php
header("Content-type: text/html; charset=tis-620");
header("Content-Disposition: attachment; filename=Plan".date("d-m-Y").".xls");
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





<!--รายการแผนหลัก-->
<?php
foreach($list as $r ) {
	foreach( $r as $k=>$v){ ${$k} = $v;}
}
?>
<div style="text-align:center; font-weight:bold; padding:10px; font-size:16px;">
<?php echo $PLongName; ?> ประจำปี พ.ศ <?php echo $PLongYear;?> - พ.ศ <?php echo $PLongYearEnd;?> (<?php echo $PLongAmount;?>ปี)
</div>
<!--END รายการแผนหลัก-->


<table width="100%" border="0" class="tbl-list"  cellspacing="0" cellpadding="0" style="margin-top:0px;">
<thead>
  <tr>
    <th style="width:30px">ลำดับ</th>
    <th align="center" >ตัวชี้วัดแผนหลัก/แผนงาน/ตัวชี้วัดแผนงาน/โครงการตามแผนหลัก</th>
    </tr>
</thead>

<!--รายการตัวชี้วัด--> 
<tr>
    <td >&nbsp;</td>
    <td><u>ตัวชี้วัดแผนหลัก</u></td>
</tr> 

<?php 
$kno = 1;
$dataInd = $get->getIndItem($PLongCode);//ltxt::print_r($dataInd);
if($dataInd){
	foreach($dataInd as $dataIndRow){
		foreach( $dataIndRow as $di=>$dv){ ${$di} = $dv;}
?>    
<tr style="vertical-align:top;">
    <td style="text-align:center;"><?php echo $kno; ?></td>
    <td>(<?php echo $PIndCode; ?>) <?php echo $PIndName; ?></td>
</tr> 
<?php 
		$kno++;
	}
}else{
?> 
<tr style="background-color:#EEE;">
	<td>&nbsp;</td>
    <td style="text-align:center;">-ไม่พบรายการในฐานข้อมูล-</td>
</tr> 
<?php } ?>
<!--END รายการตัวชี้วัด-->   


<!--รายการแผนงาน--> 

<tr>
    <td >&nbsp;</td>
    <td><u>แผนงานภายใต้แผนหลัก</u></td>
</tr> 


<?php 
$d=1;
$dataPlan = $get->getPlanItem($PLongCode);//ltxt::print_r($dataPlan);
if($dataPlan){
	foreach($dataPlan as $r){
		foreach( $r as $k=>$v){ ${$k} = $v;}
?>    

<tr style="vertical-align:top;">
    <td style="text-align:center;"><?php echo $d; ?></td>
    <td >(<?php echo $LPlanCode; ?>) <?php echo $LPlanName; ?></td>
    </tr> 


<!--รายการตัวชี้วัด-->
<?php 
$t=1;
$dataIndicator = $get->getIndicatorItem($LPlanCode);//ltxt::print_r($dataIndicator);
if($dataIndicator){
	foreach($dataIndicator as $in){
		foreach( $in as $a=>$q){ ${$a} = $q;}
?>    

<tr style="vertical-align:top;">
    <td>&nbsp;</td>
    <td style="padding-left:10px;" >- (<?php echo $LindCode; ?>) <?php echo $LindName; ?></td>
    </tr> 
  
<?php				
			$t++;
	}
}
?>   
<!--END รายการตัวชี้วัด-->




<!--รายการโครงการ-->
<?php 
$y=1;
$dataProject = $get->getProjectItem($LPlanCode);//ltxt::print_r($dataPlan);
if($dataProject){
	foreach($dataProject as $p){
		foreach( $p as $m=>$s){ ${$m} = $s;}
?>    

<tr style="vertical-align:top;">
    <td>&nbsp;</td>
    <td style="padding-left:10px;" >- (<?php echo $LPrjCode; ?>) <?php echo $LPrjName; ?></td>
    </tr> 
  
<?php				
			$y++;
	}
}
?>   
<!--END รายการโครงการ-->




  
<?php				
			$d++;
	}
}
?>   
<!--END รายการแผนงาน-->  
  

  
</table>
<?php
if(!$list){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>

<div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div> 

</BODY>

</HTML>


