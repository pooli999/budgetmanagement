<?php
header("Content-type: text/html; charset=tis-620");
header("Content-Disposition: attachment; filename=Indicator-report1_".date("d-m-Y").".xls");
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




<?php
$datas = $get->getPlanDetail($_REQUEST["LPlanCode"]);//ltxt::print_r($dataPlan);
foreach($datas as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;}
}


$indicator = $get->getIndDetail($_REQUEST["LindId"]);//ltxt::print_r($indicator);
foreach($indicator as $in){
	foreach( $in as $a=>$q){ ${$a} = $q;}
?>

<div class="topic-report">ตัวชี้วัดแผนหลักของ สช. (<?php echo $PLongName;?>)</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report">
<tr>
    <th>รหัสตัวชี้วัด</th>
    <td style="font-weight:bold;"><?php echo $LindCode; ?><input name="LindCode" type="hidden"  id="LindCode" value="<?php echo $LindCode;?>" /></td>
</tr>
<tr style="vertical-align:top;">
    <th>ชื่อตัวชี้วัด</th>
    <td><?php echo $LindName; ?></td>
</tr>
    <tr>
        <th>ชื่อแผนหลัก</th>
        <td><?php echo $PLongName;?></td>
    </tr>
    <tr style="vertical-align:top;">
        <th valign="top">รายละเอียด</th>
        <td><?php echo ($PLongDetail)?$PLongDetail:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
    </tr>
    <tr>
        <th>ปีที่ตั้งแผนหลัก</th>
        <td><?php echo $PLongYear;?><b>-</b><?php echo $PLongYearEnd;?>&nbsp;(ต่อเนื่อง <?php echo $PLongAmount;?> ปี)</td>
    </tr>
    <tr>
        <th>ชื่อแผนงาน</th>
        <td>(<?php echo $LPlanCode;?>) <?php echo $LPlanName;?></td>
    </tr>
<tr style="vertical-align:top;">
    <th>คำอธิบายตัวชี้วัด</th>
    <td><?php echo ($LindDetail)?$LindDetail:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>วัตถุประสงค์ตัวชี้วัด</th>
    <td><?php echo ($LindPurpose)?$LindPurpose:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>ผู้รายงานผลตัวชี้วัด</th>
    <td>
<?php 
$TaskPersonSelect = $get->getTaskPerson($LindCode); 
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
    <td><?php echo ($UnitID)?($get->getUnitName($UnitID)):"-"; ?></td>
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
    <td><?php echo ($LindCalculate)?$LindCalculate:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th colspan="2">เกณฑ์การให้คะแนน</th>
</tr>
</table>


  
  
  
  
  


<?php if($CriterionType =="quantity"){?>
<table width="100%" border="1" class="tbl-report-list" cellspacing="0" cellpadding="0">
    <tr style="vertical-align:top;">
      <th style="width:200px;">ค่าเป้าหมาย (<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</th>
      <th style="width:200px;">คะแนนที่ได้ตามช่วงของค่าเป้าหมาย</th>
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
  

<?php if($CriterionType =="quality"){?>
<table width="100%" border="1" class="tbl-report-list" cellspacing="0" cellpadding="0">
    <tr style="vertical-align:top;">
      <th style="width:150px;">ค่าเป้าหมาย (<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</th>
      <th style="width:200px;">คะแนนที่ได้ตามช่วงของค่าเป้าหมาย</th>
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


<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl-report-list">
  <tr>
    <th rowspan="2" style="width:80px;">&nbsp;</th>
    <th rowspan="2">ค่าเป้าหมาย<br />
      <span style="font-weight:normal;">(<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</span></th>
    <th colspan="<?php echo ($PLongAmount); ?>" style="text-align:center;">ค่าเป้าหมายแจกแจงตามปีงบประมาณ</th>
  </tr>
  <tr>
    <th style="text-align:center;">ปี <?php echo $PLongYear; ?>
      <input type="hidden" name="BgtYear_"  id="BgtYear_" value="<?php echo $PLongYear; ?>" /></th>
    <?php 
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
	?>
    <th style="text-align:center;">ปี <?php echo $initYear; ?>
      <input type="hidden" name="BgtYear_<?php echo $y; ?>"  id="BgtYear_<?php echo $y; ?>2" value="<?php echo $initYear; ?>" /></th>
    <?php 
		$initYear++;
	} 
	?>
  </tr>
  <?php if($CriterionType =="quantity"){?>
  <tr>
    <td style="text-align:center;">แผน</td>
    <td style="text-align:center;"><?php echo $LindQTTGPlan; ?></td>
    <td style="text-align:center;"><?php echo $get->getQTIndicatorYear($LindCode,$PLongYear); ?></td>
    <?php 
	$initYear = 0;
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
	?>
    <td style="text-align:center;"><?php echo $get->getQTIndicatorYear($LindCode,$initYear); ?></td>
    <?php 
		$initYear++;
	} 
	?>
  </tr>
  <tr>
    <td style="text-align:center;">ผล</td>
    <td style="text-align:center;"><?php echo $LindQTTGResult; ?></td>
    <td style="text-align:center;"><?php echo $get->getQTIndicatorYearResult($LindCode,$PLongYear); ?></td>
    <?php 
	$initYear = 0;
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
	?>
    <td style="text-align:center;"><?php echo $get->getQTIndicatorYearResult($LindCode,$initYear); ?></td>
    <?php 
		$initYear++;
	} 
	?>
  </tr>
  <?php } ?>
  <?php if($CriterionType =="quality"){?>
  <tr>
    <td style="text-align:center;">แผน</td>
    <td style="text-align:center;"><?php echo $LindQLTGPlan; ?></td>
    <td style="text-align:center;"><?php echo $get->getQLIndicatorYear($LindCode,$PLongYear);?></td>
    <?php 
	$initYear = 0;
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
	?>
    <td style="text-align:center;"><?php echo $get->getQLIndicatorYear($LindCode,$initYear);?></td>
    <?php 
		$initYear++;
	} 
	?>
  </tr>
  <tr>
    <td style="text-align:center;">ผล</td>
    <td style="text-align:center;"><?php echo ($LindQLTGResult)?$LindQLTGResult:'-'; ?></td>
    <td style="text-align:center;"><?php echo $get->getQLIndicatorYearResult($LindCode,$PLongYear); ?></td>
    <?php 
	$initYear = 0;
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
	?>
    <td style="text-align:center;"><?php echo $get->getQLIndicatorYearResult($LindCode,$initYear); ?></td>
    <?php 
		$initYear++;
	} 
	?>
  </tr>
  <?php } ?>
  <tr style="vertical-align:top;">
    <td style="text-align:center;">คะแนนที่ได้</td>
    <td style="text-align:center;">
<?php
if($LindTGScore){
    echo $LindTGScore.' คะแนน';
}else{
	echo '-';
}
?>
</td>
    <td style="text-align:center;">
<?php
$YTargetScore = $get->getYTargetScore($PLongYear,$LindCode);
if($YTargetScore >= 0){
    echo $YTargetScore.' คะแนน';
}else{
	echo '-';
}
?>
</td>
    <?php 
	unset($YTargetScore);
	$initYear = 0;
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
		$YTargetScore = $get->getYTargetScore($initYear,$LindCode);
	?>
    <td style="text-align:center;"><?php
if($YTargetScore >= 0){
    echo $YTargetScore.' คะแนน';
}else{
	echo '-';
}
?></td>
    <?php 
		$initYear++;
		unset($YTargetScore);
	} 
	?>
  </tr>
</table>



<div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div>
<br />
<br />
<?php } //end foreach ?>






</BODY>

</HTML>


