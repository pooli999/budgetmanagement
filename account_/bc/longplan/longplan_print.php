<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
?>
<HTML>
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
<style media="print">
.btnback {
	display:none;
	vertical-align:top;
}
</style>
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
$mainPlan = $get->getMainPlan();
foreach($mainPlan as $rMainPlan ) {
	foreach( $rMainPlan as $mk=>$mv){ ${$mk} = $mv;}
}
?>
<div style="text-align:center; font-weight:bold; padding:10px; font-size:16px;">
<?php echo $PLongName; ?> ประจำปี พ.ศ <?php echo $PLongYear;?> - พ.ศ <?php echo $PLongYearEnd;?> (<?php echo $PLongAmount;?>ปี)
</div>
<!--END รายการแผนหลัก-->




<?php
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;//ltxt::print_r($list);
	
	if($list){
          foreach($list as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>

<table width="<?php echo (18+80+450+(($PLongAmount*3+3)*80)); ?>" border="0" class="tbl-list"  cellspacing="0" cellpadding="0" style="margin-top:0px;">
<thead>
  <tr>
    <th rowspan="3" style="width:80px">รหัส</th>
    <th rowspan="3" style="width:450px">แผนงานต่อเนื่อง/โครงการ</th>
    <th colspan="<?php echo ($PLongAmount*3+3); ?>" style="text-align:center;" >งบประมาณ (บาท)</th>
    </tr>
    
  <tr>
  
	   <?php 
		  $startYear = $PLongYear;
		  for($y=0;$y<$PLongAmount;$y++){ 
		  ?>
          <th colspan="3">ปี <?php echo $startYear; ?></th>
		  <?php 
		  	$startYear = $startYear+1;
		  } 
		  ?>
    
    <th colspan="3">รวมทั้งสิ้น</th>
    </tr>
    
      <tr>
  
	   <?php 
		  $startYear = $PLongYear;
		  for($y=0;$y<$PLongAmount;$y++){ 
		  ?>
          <th style="width:80px;">กรอบวงเงิน</th>
          <th style="width:80px;">เงินที่ได้รับ</th>
          <th style="width:80px;">เงินจ่ายจริง</th>
		  <?php 
		  	$startYear = $startYear+1;
		  } 
		  ?>
    
          <th style="width:80px;">กรอบวงเงิน</th>
          <th style="width:80px;">เงินที่ได้รับ</th>
          <th style="width:80px;">เงินจ่ายจริง</th>
    </tr>

</thead>
  
  
  
  
<!--รายการแผนงาน--> 
<?php 
$d=1;
$dataPlan = $get->getPlanItem($PLongCode);//ltxt::print_r($dataPlan);
if($dataPlan){
	foreach($dataPlan as $r){
		foreach( $r as $k=>$v){ ${$k} = $v;}
		$dataProject = $get->getProjectItem($LPlanCode);//ltxt::print_r($dataPlan);
?>    

<tr style="font-weight:bold;">
<?php if($dataProject){ ?>
    <?php }else{ ?>
	<td>&nbsp;</td>
<?php } ?>
    
    <td style="text-align:center;"><?php echo $LPlanCode; ?></td>
    <td><?php echo $LPlanName; ?></td>
    
		 <?php 
		  $startYear = $PLongYear;
		  for($y=0;$y<$PLongAmount;$y++){ 
		  ?>
          <td style="text-align:center;">-</td>
          <td style="text-align:center;">-</td>
          <td style="text-align:center;">-</td>
		  <?php 
		  	$startYear = $startYear+1;
		  } 
		  ?>
    
          <td style="text-align:center;">-</td>
          <td style="text-align:center;">-</td>
          <td style="text-align:center;">-</td>
</tr> 






<tbody id="td-<?php echo $d;?>">	
<!--รายการโครงการ-->
<?php 
$y=1;
if($dataProject){
	foreach($dataProject as $p){
		foreach( $p as $m=>$s){ ${$m} = $s;}
?>    

<tr style="vertical-align:top;">
    <td style="text-align:center;"><?php echo $LPrjCode; ?></td>
    <td><?php echo $LPrjName; ?></td>
    
		<?php 
		  $startYear = $PLongYear;
		  for($y=0;$y<$PLongAmount;$y++){ 
		  ?>
          <td style="text-align:center;">-</td>
          <td style="text-align:center;">-</td>
          <td style="text-align:center;">-</td>
		  <?php 
		  	$startYear = $startYear+1;
		  } 
		  ?>
    
          <td style="text-align:center;">-</td>
          <td style="text-align:center;">-</td>
          <td style="text-align:center;">-</td>
</tr> 


  
<?php				
			$y++;
	}
}
?>   
<!--END รายการโครงการ-->
</tbody>



  
<?php				
			$d++;
	}
}
?>   
<!--END รายการแผนงาน-->  
  

  
<?php

		$i++;
		}
?>
<!--END รายการแผนหลัก-->


<tr style="font-weight:bold;">
    <th colspan="2" style="text-align:right;">รวมทั้งสิ้น</th>
    
		 <?php 
		  $startYear = $PLongYear;
		  for($y=0;$y<$PLongAmount;$y++){ 
		  ?>
          <th style="text-align:center;">-</th>
          <th style="text-align:center;">-</th>
          <th style="text-align:center;">-</th>
		  <?php 
		  	$startYear = $startYear+1;
		  } 
		  ?>
    
          <th style="text-align:center;">-</th>
          <th style="text-align:center;">-</th>
          <th style="text-align:center;">-</th>
</tr> 




</table>
<?php } ?>
<?php
if(!$list){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>

<div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div> 


<div style="text-align:center; margin-top:20px;">
  <input class="btnback" type="button" name="back" value="ย้อนกลับ" onClick="window.history.go(-1);" />
</div>

<script>
	window.print();
</script>

</BODY>

</HTML>