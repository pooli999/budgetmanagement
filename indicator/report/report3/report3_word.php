<?php
header("Content-Type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=Indicator-report3_".date("d-m-Y").".doc");
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

?>


<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
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
$indicator = $get->getIndDetail();//ltxt::print_r($indicator);
foreach($indicator as $in){
	foreach( $in as $a=>$q){ ${$a} = $q;}

		$datas = $get->getDetailPrj($PrjId,$PrjDetailId);//ltxt::print_r($datas);
		foreach($datas as $actdatas){
			foreach($actdatas as $k=>$v){
				${$k} = $v;
			}
		}
?>



<div class="topic-report">ตัวชี้วัดโครงการของ สช. ประจำปี <?php echo $_REQUEST["BgtYear"]; ?></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-report">
<tr>
    <th>รหัสตัวชี้วัด</th>
    <td style="font-weight:bold;"><?php echo $IndicatorCode; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>ชื่อตัวชี้วัด</th>
    <td><?php echo $IndicatorName; ?></td>
</tr>
     <tr>
       <th >ปีงบประมาณ</th>
       <td colspan="2"><?php echo $BgtYear;?></td>
     </tr>
     <tr>
       <th>ภายใต้แผนงาน</th>
       <td colspan="2" id="plan">(<?php echo $PItemCode; ?>)&nbsp;<?php echo $get->getPItemCode($PItemCode);?></td>
     </tr> 
      <tr>
        <th>ชื่อโครงการ</th>
        <td colspan="2" id="prj">(<?php echo $PrjCode; ?>)&nbsp;<?php echo $PrjName;?></td>
      </tr>
        <tr>
        <th>ระยะเวลาการดำเนินโครงการ</th>
        <td colspan="2"><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td>
      </tr>
         <tr>
       <th valign="top">หน่วยงานที่รับผิดชอบ</th>
       <td colspan="2"><?php echo $get->getOrgName($BgtYear, $OrganizeCode);?></td>
     </tr>
    <tr>
        <th valign="top">ผู้รับผิดชอบโครงการ</th>
       <td colspan="2">
       <?php 
        $TaskPerson = $get->getTaskPerson($PrjId); 
		if(!$TaskPerson){ echo '<span style="color:#999;">-ไม่ระบุ-</span>'; }
       echo "<ul>";
       foreach($TaskPerson as $rRName){
            foreach($rRName as $k=>$v){
                ${$k} = $v;
            }
            echo "<li>";
            echo $Name;
            if($ResultStatus == 'Y'){echo " (ผู้รายงาน)";}
            echo "</li>";
       }
       echo "</ul>";
        
       ?>
       </td>
    </tr>
<tr style="vertical-align:top;">
    <th>คำอธิบายตัวชี้วัด</th>
    <td><?php echo ($IndicatorDetail)?$IndicatorDetail:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>วัตถุประสงค์ตัวชี้วัด</th>
    <td><?php echo ($IndicatorPurpose)?$IndicatorPurpose:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th>ผู้รายงานผลตัวชี้วัด</th>
    <td>
<?php 
$TaskPersonSelect = $get->getTaskIndPerson($IndicatorCode); 
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
    <td><?php echo ($Calculate)?$Calculate:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
    <th colspan="2">เกณฑ์การให้คะแนน</th>
</tr>
</table>


<?php if($CriterionType =="quantity"){?>
<table width="100%" border="1" class="tbl-report-list" cellspacing="0" cellpadding="0">
    <tr>
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
		echo '<span>0 คะแนน</span>';
	break;
	case 1:
		echo '<span>1 คะแนน</span>';
	break;
	case 2:
		echo '<span>2 คะแนน</span>';
	break;
	case 3:
		echo '<span>3 คะแนน</span>';
	break;
	case 4:
		echo '<span>4 คะแนน</span>';
	break;
	case 5:
		echo '<span>5 คะแนน</span>';
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
		echo '<span>0 คะแนน</span>';
	break;
	case 1:
		echo '<span>1 คะแนน</span>';
	break;
	case 2:
		echo '<span>2 คะแนน</span>';
	break;
	case 3:
		echo '<span>3 คะแนน</span>';
	break;
	case 4:
		echo '<span>4 คะแนน</span>';
	break;
	case 5:
		echo '<span>5 คะแนน</span>';
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
		echo '<span>0 คะแนน</span>';
	break;
	case 1:
		echo '<span>1 คะแนน</span>';
	break;
	case 2:
		echo '<span>2 คะแนน</span>';
	break;
	case 3:
		echo '<span>3 คะแนน</span>';
	break;
	case 4:
		echo '<span>4 คะแนน</span>';
	break;
	case 5:
		echo '<span>5 คะแนน</span>';
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
		echo '<span>0 คะแนน</span>';
	break;
	case 1:
		echo '<span>1 คะแนน</span>';
	break;
	case 2:
		echo '<span>2 คะแนน</span>';
	break;
	case 3:
		echo '<span>3 คะแนน</span>';
	break;
	case 4:
		echo '<span>4 คะแนน</span>';
	break;
	case 5:
		echo '<span>5 คะแนน</span>';
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
		echo '<span>0 คะแนน</span>';
	break;
	case 1:
		echo '<span>1 คะแนน</span>';
	break;
	case 2:
		echo '<span>2 คะแนน</span>';
	break;
	case 3:
		echo '<span>3 คะแนน</span>';
	break;
	case 4:
		echo '<span>4 คะแนน</span>';
	break;
	case 5:
		echo '<span>5 คะแนน</span>';
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
		echo '<span>0 คะแนน</span>';
	break;
	case 1:
		echo '<span>1 คะแนน</span>';
	break;
	case 2:
		echo '<span>2 คะแนน</span>';
	break;
	case 3:
		echo '<span>3 คะแนน</span>';
	break;
	case 4:
		echo '<span>4 คะแนน</span>';
	break;
	case 5:
		echo '<span>5 คะแนน</span>';
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
    <tr>
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
		echo '<span>0 คะแนน</span>';
	break;
	case 1:
		echo '<span>1 คะแนน</span>';
	break;
	case 2:
		echo '<span>2 คะแนน</span>';
	break;
	case 3:
		echo '<span>3 คะแนน</span>';
	break;
	case 4:
		echo '<span>4 คะแนน</span>';
	break;
	case 5:
		echo '<span>5 คะแนน</span>';
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
		echo '<span>0 คะแนน</span>';
	break;
	case 1:
		echo '<span>1 คะแนน</span>';
	break;
	case 2:
		echo '<span>2 คะแนน</span>';
	break;
	case 3:
		echo '<span>3 คะแนน</span>';
	break;
	case 4:
		echo '<span>4 คะแนน</span>';
	break;
	case 5:
		echo '<span>5 คะแนน</span>';
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
		echo '<span>0 คะแนน</span>';
	break;
	case 1:
		echo '<span>1 คะแนน</span>';
	break;
	case 2:
		echo '<span>2 คะแนน</span>';
	break;
	case 3:
		echo '<span>3 คะแนน</span>';
	break;
	case 4:
		echo '<span>4 คะแนน</span>';
	break;
	case 5:
		echo '<span>5 คะแนน</span>';
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
		echo '<span>0 คะแนน</span>';
	break;
	case 1:
		echo '<span>1 คะแนน</span>';
	break;
	case 2:
		echo '<span>2 คะแนน</span>';
	break;
	case 3:
		echo '<span>3 คะแนน</span>';
	break;
	case 4:
		echo '<span>4 คะแนน</span>';
	break;
	case 5:
		echo '<span>5 คะแนน</span>';
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
		echo '<span>0 คะแนน</span>';
	break;
	case 1:
		echo '<span>1 คะแนน</span>';
	break;
	case 2:
		echo '<span>2 คะแนน</span>';
	break;
	case 3:
		echo '<span>3 คะแนน</span>';
	break;
	case 4:
		echo '<span>4 คะแนน</span>';
	break;
	case 5:
		echo '<span>5 คะแนน</span>';
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
		echo '<span>0 คะแนน</span>';
	break;
	case 1:
		echo '<span>1 คะแนน</span>';
	break;
	case 2:
		echo '<span>2 คะแนน</span>';
	break;
	case 3:
		echo '<span>3 คะแนน</span>';
	break;
	case 4:
		echo '<span>4 คะแนน</span>';
	break;
	case 5:
		echo '<span>5 คะแนน</span>';
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



<table width="100%" border="1" class="tbl-report-list"  cellspacing="0" cellpadding="0">
  <thead>
    <tr>
      <th colspan="2" rowspan="2" align="center">ค่าเป้าหมาย<br />
        <span style="font-weight:normal;">(<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</span></th>
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
    <td align="center" ><?php echo $QTTGPlan; ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,10); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,11); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,12); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,1); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,2); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,3); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,4); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,5); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,6); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,7); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,8); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PrjIndId,9); ?></td>
  </tr>
  <tr>
    <td align="center" >ผล</td>
    <td align="center" ><?php echo $QTTGResult; ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,10); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,11); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,12); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,1); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,2); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,3); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,4); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,5); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,6); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,7); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,8); ?></td>
    <td align="center"><?php echo $get->getQTIndMonthResult($PrjIndId,9); ?></td>
  </tr>
  <?php } ?>
  <?php if($CriterionType =="quality"){?>
  <tr>
    <td align="center" >แผน</td>
    <td align="center" ><?php echo $QLTGPlan; ?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,10);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,11);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,12);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,1);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,2);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,3);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,4);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,5);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,6);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,7);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,8);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PrjIndId,9);?></td>
  </tr>
  <tr>
    <td align="center" >ผล</td>
    <td align="center" ><?php echo $QLTGResult; ?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,10);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,11);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,12);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,1);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,2);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,3);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,4);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,5);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,6);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,7);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,8);?></td>
    <td align="center"><?php echo $get->getQLIndMonthResult($PrjIndId,9);?></td>
  </tr>
  <?php } ?>
  <?php 
$MTargetScore10 = $get->getMTargetScore($IndicatorCode,10);
$MTargetScore11 = $get->getMTargetScore($IndicatorCode,11);
$MTargetScore12 = $get->getMTargetScore($IndicatorCode,12);

$MTargetScore1 = $get->getMTargetScore($IndicatorCode,1);
$MTargetScore2 = $get->getMTargetScore($IndicatorCode,2);
$MTargetScore3 = $get->getMTargetScore($IndicatorCode,3);

$MTargetScore4 = $get->getMTargetScore($IndicatorCode,4);
$MTargetScore5 = $get->getMTargetScore($IndicatorCode,5);
$MTargetScore6 = $get->getMTargetScore($IndicatorCode,6);

$MTargetScore7 = $get->getMTargetScore($IndicatorCode,7);
$MTargetScore8 = $get->getMTargetScore($IndicatorCode,8);
$MTargetScore9 = $get->getMTargetScore($IndicatorCode,9);
?>
  <tr style="vertical-align:top;">
    <td align="center" >คะแนนที่ได้</td>
    <td align="center" ><?php
if($TGScore){
    echo $TGScore.' คะแนน';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore10 >= 0){
	echo $MTargetScore10.' คะแนน';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore11 >= 0){
	echo $MTargetScore11.' คะแนน';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore12 >= 0){
	echo $MTargetScore12.' คะแนน';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore1 >= 0){
	echo $MTargetScore1.' คะแนน';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore2 >= 0){
	echo $MTargetScore2.' คะแนน';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore3 >= 0){
	echo $MTargetScore3.' คะแนน';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore4 >= 0){
	echo $MTargetScore4.' คะแนน';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore5 >= 0){
	echo $MTargetScore5.' คะแนน';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore6 >= 0){
	echo $MTargetScore6.' คะแนน';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore7 >= 0){
	echo $MTargetScore7.' คะแนน';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore8 >= 0){
	echo $MTargetScore8.' คะแนน';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore9 >= 0){
	echo $MTargetScore9.' คะแนน';
}else{
	echo '-';
}
?></td>
  </tr>
</table>


<div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div>
<br />
<br />
<?php } //end foreach ?>



</BODY>

</HTML>


