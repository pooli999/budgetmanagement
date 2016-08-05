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
.topic-report {
	 text-align:right; 
	 border-bottom:1px solid #999; 
	 padding:10px; 
	 margin-bottom:10px;
	 font-family:TH SarabunPSK; 
	 font-size: 14px; 
}
.tbl-report {
	font-family:TH SarabunPSK; 
	font-size: 14px; 
}
.tbl-report th {
	text-align:left;
	width:180px;
	padding:3px;
}
.tbl-report-list {
	border:1px solid #999;
	border-collapse:collapse;
	margin-bottom:10px;
	font-family:TH SarabunPSK; 
	font-size: 14px; 
}
.tbl-report-list th {
	font-weight:bold;
	text-align:center;
	border:1px solid #999;
	padding:3px;
	vertical-align:top;
}
.tbl-report-list td {
	border:1px solid #999;
	padding:3px;
}

</style>
</HEAD>
<BODY>



<?php


$indicator = $get->getPlanIndDetail();//ltxt::print_r($dataPlan);
foreach($indicator as $in){
	foreach( $in as $a=>$q){ ${$a} = $q;}
	
	$datas = $get->getPItemDetail($PItemCode);//ltxt::print_r($datas);
	foreach($datas as $r){
		foreach( $r as $k=>$v){ ${$k} = $v;}
	}

?>

<div class="topic-report">ตัวชี้วัดแผนงานของ สช. ประจำปี <?php echo $_REQUEST["BgtYear"]; ?></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report">
<tr>
    <th>รหัสตัวชี้วัด</th>
    <td style="font-weight:bold;"><?php echo $PIndCode; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>ชื่อตัวชี้วัด</th>
    <td><?php echo $PIndName; ?></td>
</tr>
  <tr>
    <th>ปีงบประมาณ</th>
    <td><?php echo $BgtYear; ?></td>
  </tr>
    <tr>
        <th>ชื่อแผนงาน</th>
        <td>(<?php echo $PItemCode; ?>) <?php echo $PItemName;?></td>
    </tr>

<?php if($PGroupId == 12){ ?>
<tr>
<th>ภายใต้แผนหลัก</th>
<td><?php echo ($LPlanCode)?($get->getLPlanName($LPlanCode)):('<span style="color:#999;">-ไม่ระบุ-</span>'); ?></td>
</tr>
<?php } ?>

    
    
<tr style="vertical-align:top;">
    <th>คำอธิบายตัวชี้วัด</th>
    <td><?php echo ($PIndDetail)?$PIndDetail:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>วัตถุประสงค์ตัวชี้วัด</th>
    <td><?php echo ($PIndPurpose)?$PIndPurpose:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>ผู้รายงานผลตัวชี้วัด</th>
    <td>
<?php 
$TaskPersonSelect = $get->getPlanTaskPerson($PIndCode); 
if(count($TaskPersonSelect)){
	echo "<ul>";
	foreach($TaskPersonSelect as $rs){
		foreach($rs as $k=>$v){
			${$k} = $v;
		}
		echo "<li>".$Name."</li>";
	}
	echo "</ul>";
}else{
	echo '<span style="color:#999;">-ไม่ระบุ-</span>';
}
?>
    </td>
</tr>
<tr>
    <th>หน่วยนับ</th>
    <td><?php echo ($UnitID)?($get->getUnitName($UnitID)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr>
    <th colspan="2">ข้อมูลเกณฑ์การประเมิน</th>
</tr>
<tr style="vertical-align:top;">
  <th>ประเภทเกณฑ์ประเมิน</th>
  <td>
<?php if($CriterionType=="quantity"){ ?>เชิงปริมาณ<?php } ?>
<?php if($CriterionType=="quality"){ ?>เชิงคุณภาพ<?php } ?>
  </td>
  </tr>
  <tr style="vertical-align:top;">
    <th>อธิบายวิธีการคำนวณ</th>
    <td><?php echo ($PIndCalculate)?$PIndCalculate:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th colspan="2">เกณฑ์การให้คะแนน</th>
</tr>

</table>


  
  
  
  
  


<?php if($CriterionType=="quantity"){ ?>
<table width="100%" border="0" class="tbl-report-list" cellspacing="0" cellpadding="0">
    <tr style="vertical-align:top;">
      <th style="width:200px;">ค่าเป้าหมาย <br />(<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</th>
      <th style="width:200px;">คะแนนที่ได้ตามช่วง<br />ของค่าเป้าหมาย</th>
      <th>คำอธิบาย</th>
      </tr>
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $QTMinScore0; ?><b> - </b><?php echo $QTMaxScore0; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
        <?php
switch($Score0){
	case 0:
		echo '0 คะแนน';
	break;
	case 1:
		echo '1 คะแนน';
	break;
	case 2:
		echo '2 คะแนน';
	break;
	case 3:
		echo '3 คะแนน';
	break;
	case 4:
		echo '4 คะแนน';
	break;
	case 5:
		echo '5 คะแนน';
	break;
}
?></td>
      <td><?php echo $DetailScore0; ?></td>
      </tr>
    <tr style="vertical-align:top;">
       <td style="text-align:center;"><?php echo $QTMinScore1; ?><b> - </b><?php echo $QTMaxScore1; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score1){
	case 0:
		echo '0 คะแนน';
	break;
	case 1:
		echo '1 คะแนน';
	break;
	case 2:
		echo '2 คะแนน';
	break;
	case 3:
		echo '3 คะแนน';
	break;
	case 4:
		echo '4 คะแนน';
	break;
	case 5:
		echo '5 คะแนน';
	break;
}
?></td>
      <td><?php echo $DetailScore1; ?></td>
      </tr>
    <tr style="vertical-align:top;">
       <td style="text-align:center;"><?php echo $QTMinScore2; ?><b> - </b><?php echo $QTMaxScore2; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score2){
	case 0:
		echo '0 คะแนน';
	break;
	case 1:
		echo '1 คะแนน';
	break;
	case 2:
		echo '2 คะแนน';
	break;
	case 3:
		echo '3 คะแนน';
	break;
	case 4:
		echo '4 คะแนน';
	break;
	case 5:
		echo '5 คะแนน';
	break;
}
?></td>
      <td><?php echo $DetailScore2; ?></td>
      </tr>      
    <tr style="vertical-align:top;">
       <td style="text-align:center;"><?php echo $QTMinScore3; ?><b> - </b><?php echo $QTMaxScore3; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score3){
	case 0:
		echo '0 คะแนน';
	break;
	case 1:
		echo '1 คะแนน';
	break;
	case 2:
		echo '2 คะแนน';
	break;
	case 3:
		echo '3 คะแนน';
	break;
	case 4:
		echo '4 คะแนน';
	break;
	case 5:
		echo '5 คะแนน';
	break;
}
?></td>
      <td><?php echo $DetailScore3; ?></td>
      </tr>      
      <tr style="vertical-align:top;">
       <td style="text-align:center;"><?php echo $QTMinScore4; ?><b> - </b><?php echo $QTMaxScore4; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score4){
	case 0:
		echo '0 คะแนน';
	break;
	case 1:
		echo '1 คะแนน';
	break;
	case 2:
		echo '2 คะแนน';
	break;
	case 3:
		echo '3 คะแนน';
	break;
	case 4:
		echo '4 คะแนน';
	break;
	case 5:
		echo '5 คะแนน';
	break;
}
?></td>
      <td><?php echo $DetailScore4; ?></td>
      </tr>    
     <tr style="vertical-align:top;">
       <td style="text-align:center;"><?php echo $QTMinScore5; ?><b> - </b><?php echo $QTMaxScore5; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score5){
	case 0:
		echo '0 คะแนน';
	break;
	case 1:
		echo '1 คะแนน';
	break;
	case 2:
		echo '2 คะแนน';
	break;
	case 3:
		echo '3 คะแนน';
	break;
	case 4:
		echo '4 คะแนน';
	break;
	case 5:
		echo '5 คะแนน';
	break;
}
?></td>
      <td><?php echo $DetailScore5; ?></td>
      </tr>     
  </table>  
<?php } ?>
<!--End  id="tbl-quantity"-->
  

<?php if($CriterionType=="quality"){ ?>
<table width="100%" border="0" class="tbl-report-list" cellspacing="0" cellpadding="0">
    <tr style="vertical-align:top;">
      <th style="width:150px;">ค่าเป้าหมาย <br />(<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</th>
      <th style="width:200px;">คะแนนที่ได้ตามช่วง<br />ของค่าเป้าหมาย</th>
      <th>คำอธิบาย</th>
      </tr>
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $TQLScore0; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
        <?php
switch($Score0){
	case 0:
		echo '0 คะแนน';
	break;
	case 1:
		echo '1 คะแนน';
	break;
	case 2:
		echo '2 คะแนน';
	break;
	case 3:
		echo '3 คะแนน';
	break;
	case 4:
		echo '4 คะแนน';
	break;
	case 5:
		echo '5 คะแนน';
	break;
}
?></td>
      <td><?php echo $DetailScore0; ?></td>
      </tr>
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $TQLScore1; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score1){
	case 0:
		echo '0 คะแนน';
	break;
	case 1:
		echo '1 คะแนน';
	break;
	case 2:
		echo '2 คะแนน';
	break;
	case 3:
		echo '3 คะแนน';
	break;
	case 4:
		echo '4 คะแนน';
	break;
	case 5:
		echo '5 คะแนน';
	break;
}
?></td>
      <td><?php echo $DetailScore1; ?></td>
      </tr>
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $TQLScore1; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score2){
	case 0:
		echo '0 คะแนน';
	break;
	case 1:
		echo '1 คะแนน';
	break;
	case 2:
		echo '2 คะแนน';
	break;
	case 3:
		echo '3 คะแนน';
	break;
	case 4:
		echo '4 คะแนน';
	break;
	case 5:
		echo '5 คะแนน';
	break;
}
?></td>
      <td><?php echo $DetailScore2; ?></td>
      </tr>      
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $TQLScore3; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score3){
	case 0:
		echo '0 คะแนน';
	break;
	case 1:
		echo '1 คะแนน';
	break;
	case 2:
		echo '2 คะแนน';
	break;
	case 3:
		echo '3 คะแนน';
	break;
	case 4:
		echo '4 คะแนน';
	break;
	case 5:
		echo '5 คะแนน';
	break;
}
?></td>
      <td><?php echo $DetailScore3; ?></td>
      </tr>      
      <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $TQLScore4; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score4){
	case 0:
		echo '0 คะแนน';
	break;
	case 1:
		echo '1 คะแนน';
	break;
	case 2:
		echo '2 คะแนน';
	break;
	case 3:
		echo '3 คะแนน';
	break;
	case 4:
		echo '4 คะแนน';
	break;
	case 5:
		echo '5 คะแนน';
	break;
}
?></td>
      <td><?php echo $DetailScore4; ?></td>
      </tr>    
     <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $TQLScore5; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
<?php
switch($Score5){
	case 0:
		echo '0 คะแนน';
	break;
	case 1:
		echo '1 คะแนน';
	break;
	case 2:
		echo '2 คะแนน';
	break;
	case 3:
		echo '3 คะแนน';
	break;
	case 4:
		echo '4 คะแนน';
	break;
	case 5:
		echo '5 คะแนน';
	break;
}
?></td>
      <td><?php echo $DetailScore5; ?></td>
      </tr>     
  </table>  
<?php } ?>
<!--End  id="tbl-quality"-->


  

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report">
<tr>
	<th colspan="2" style="width:100%;">แผนการดำเนินการ/ค่าเป้าหมายรายเดือน-ไตรมาส</th>
</tr>
</table>



<table width="100%" border="0" class="tbl-report-list"  cellspacing="0" cellpadding="0">
<thead>
  <tr>
    <th colspan="2" rowspan="2" align="center">ค่าเป้าหมาย<br /> <span style="font-weight:normal;">(<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</span></th>
    <th colspan="3" align="center">ไตรมาสที่ 1</th>
    <th colspan="3" align="center">ไตรมาสที่ 2</th>
    <th colspan="3" align="center">ไตรมาสที่ 3</th>
    <th colspan="3" align="center">ไตรมาสที่ 4</th>
    </tr>
  <tr>
    <th align="center" style="width:75px">ต.ค</th>
    <th align="center" style="width:75px">พ.ย</th>
    <th align="center" style="width:75px">ธ.ค</th>
    <th align="center" style="width:75px">ม.ค</th>
    <th align="center" style="width:75px">ก.พ</th>
    <th align="center" style="width:75px">มี.ค</th>
    <th align="center" style="width:75px">เม.ย</th>
    <th align="center" style="width:75px">พ.ค</th>
    <th align="center" style="width:75px">มิ.ย</th>
    <th align="center" style="width:75px">ก.ค</th>
    <th align="center" style="width:75px">ส.ค</th>
    <th align="center" style="width:75px">ก.ย</th>
    </tr>
</thead>

<?php if($CriterionType =="quantity"){?>
  <tr>
    <td align="center" >แผน</td>
    <td align="center" ><?php echo $PIndQTTGPlan; ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,10); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,11); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,12); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,1); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,2); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,3); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,4); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,5); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,6); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,7); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,8); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonth($PIndCode,9); ?></td>
    </tr>
      <tr>
    <td align="center" >ผล</td>
    <td align="center" ><?php echo $PIndQTTGResult; ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,10); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,11); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,12); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,1); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,2); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,3); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,4); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,5); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,6); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,7); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,8); ?></td>
    <td align="center"><?php echo $get->getPlanQTIndMonthResult($PIndCode,9); ?></td>
    </tr>
 <?php } ?> 
 
 <?php if($CriterionType =="quality"){?>
  <tr>
    <td align="center" >แผน</td>
    <td align="center" ><?php echo $PIndQLTGPlan; ?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,10); ?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,11);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,12);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,1);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,2);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,3);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,4);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,5);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,6);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,7);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,8);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonth($PIndCode,9);?></td>
    </tr>
      <tr>
    <td align="center" >ผล</td>
    <td align="center" ><?php echo ($PIndQLTGResult)?$PIndQLTGResult:"-";?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,10);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,11);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,12);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,1);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,2);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,3);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,4);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,5);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,6);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,7);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,8);?></td>
    <td align="center"><?php echo $get->getPlanQLIndMonthResult($PIndCode,9);?></td>
    </tr>
 <?php } ?> 


<?php 
$MTargetScore10 = $get->getPlanMTargetScore($PIndCode,10);
$MTargetScore11 = $get->getPlanMTargetScore($PIndCode,11);
$MTargetScore12 = $get->getPlanMTargetScore($PIndCode,12);

$MTargetScore1 = $get->getPlanMTargetScore($PIndCode,1);
$MTargetScore2 = $get->getPlanMTargetScore($PIndCode,2);
$MTargetScore3 = $get->getPlanMTargetScore($PIndCode,3);

$MTargetScore4 = $get->getPlanMTargetScore($PIndCode,4);
$MTargetScore5 = $get->getPlanMTargetScore($PIndCode,5);
$MTargetScore6 = $get->getPlanMTargetScore($PIndCode,6);

$MTargetScore7 = $get->getPlanMTargetScore($PIndCode,7);
$MTargetScore8 = $get->getPlanMTargetScore($PIndCode,8);
$MTargetScore9 = $get->getPlanMTargetScore($PIndCode,9);
?> 
   <tr style="vertical-align:top;">
    <td align="center" >คะแนนที่ได้</td>
    <td align="center" >
<?php
if($PIndTGScore){
	 echo $PIndTGScore.' คะแนน';
}else{
	echo '-';
}
?>
    </td>
    <td align="center">
<?php
if($MTargetScore10 >= 0){
    echo $MTargetScore10.' คะแนน';
}else{
	echo '-';
}
?>
    </td>
    <td align="center">
<?php
if($MTargetScore11 >= 0){
    echo $MTargetScore11.' คะแนน';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore12 >= 0){
    echo $MTargetScore12.' คะแนน';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore1 >= 0){
    echo $MTargetScore1.' คะแนน';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore2 >= 0){
    echo $MTargetScore2.' คะแนน';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore3 >= 0){
    echo $MTargetScore3.' คะแนน';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore4 >= 0){
    echo $MTargetScore4.' คะแนน';
}else{
	echo '-';

}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore5 >= 0){
    echo $MTargetScore5.' คะแนน';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore6 >= 0){
    echo $MTargetScore6.' คะแนน';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore7 >= 0){
    echo $MTargetScore7.' คะแนน';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore8 >= 0){
    echo $MTargetScore8.' คะแนน';
}else{
	echo '-';
}
?>
    </td>

    <td align="center">
<?php
if($MTargetScore9 >= 0){
    echo $MTargetScore9.' คะแนน';
}else{
	echo '-';
}
?>
    </td>

    </tr>

</table>




<div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div>
<br />
<br />
<?php } //end foreach ?>







  




<div style="text-align:center; margin-top:20px;">
  <input class="btnback" type="button" name="back" value="ย้อนกลับ" onClick="window.history.go(-1);" />
</div>

<script>
window.print();
</script>

</BODY>

</HTML>