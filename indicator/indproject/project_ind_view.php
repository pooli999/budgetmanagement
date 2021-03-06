<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$indicator = $get->getIndDetail($_REQUEST["PrjIndId"]);//ltxt::print_r($dataPlan);
foreach($indicator as $in){
	foreach( $in as $a=>$q){ ${$a} = $q;}
}
$datas = $get->getDetailPrj($PrjId,$PrjDetailId);//ltxt::print_r($datas);
foreach($datas as $actdatas){
	foreach($actdatas as $k=>$v){
		${$k} = $v;
	}
}

$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบรายงานผลและตัวชี้วัด',
	),
	array(
		'text' => 'ตัวชี้วัดระดับโครงการ',
		'link' => '?mod='.lurl::dotPage("project_list").'&BgtYear='.$BgtYear
	),
	array(
		'text' => 'แสดงรายละเอียด'
	),
));


$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));

?>

<div class="sysinfo">
  <div class="sysname">ตัวชี้วัดระดับโครงการ</div>
  <div class="sysdetail">&nbsp;</div>
</div>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbl-button">
  <tr>
    <td>
     <a href="javascript:printDocument();" class="icon-printer">พิมพ์</a>&nbsp;
    <a href="javascript:saveToWord();" class="icon-word">ส่งออกเป็น Word</a>
    </td>
  </tr>
</table>



<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
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
    <td><?php echo ($UnitID)?($get->getUnitName($UnitID)):''; ?></td>
</tr>
</table>


<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">ข้อมูลเกณฑ์การประเมิน</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
<!--<tr>
    <th>วิธีการคำนวณ</th>
    <td class="require">*</td>
    <td>
      <select style="width:200px;">
        <option>ค่าสะสม (Summary)</option>
        <option>ค่าเฉลี่ย (Average)</option>
        <option>ค่าสุดท้าย (Use Last Data Entry)</option>
      </select> 
    </td>
</tr>
-->
<!--<tr>
    <th>ค่าถ่วงน้ำหนัก</th>
    <td class="require">*</td>
    <td><input type="text" name="MassValue"  id="MassValue" value="1.5" style="width:100px; text-align:center;" />&nbsp;%</td>
</tr>
-->
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


<tr style="vertical-align:top;">
  <td colspan="3" style="vertical-align:top;">
  
  
  
  
  



<div id="tbl-quantity" <?php if($CriterionType !="quantity"){?> style="display:none;"  <?php } ?>  > 
<table width="100%" border="1" class="tbl-list" cellspacing="1" cellpadding="0">
    <tr style="vertical-align:top;">
      <td style="width:200px; text-align:center; background-color:#EEE;">ค่าเป้าหมาย (<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</td>
      <td style="width:200px; text-align:center; background-color:#EEE;">คะแนนที่ได้ตามช่วงของค่าเป้าหมาย</td>
      <td style="text-align:center; background-color:#EEE;">คำอธิบาย</td>
      </tr>
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $QTMinScore0; ?><b> - </b><?php echo $QTMaxScore0; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
        <?php
switch($Score0){
	case 0:
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
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
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
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
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
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
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
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
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
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
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
	break;
}
?></td>
      <td><?php echo $DetailScore5; ?></td>
      </tr>     
  </table>  
</div>  
<!--End  id="tbl-quantity"-->
  


<div id="tbl-quality" <?php if($CriterionType !="quality"){?> style="display:none;"  <?php } ?> > 
<table width="100%" border="1" class="tbl-list" cellspacing="1" cellpadding="0">
    <tr style="vertical-align:top;">
      <td style="width:150px; text-align:center; background-color:#EEE;">ค่าเป้าหมาย (<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</td>
      <td style="width:200px; text-align:center; background-color:#EEE;">คะแนนที่ได้ตามช่วงของค่าเป้าหมาย</td>
      <td style="text-align:center; background-color:#EEE;">คำอธิบาย</td>
      </tr>
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $TQLScore0; ?></td>
      <td><span style="width:20px; text-align:center;">=</span>
        <?php
switch($Score0){
	case 0:
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
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
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
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
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
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
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
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
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
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
		echo '<span class="icon-col0">0 คะแนน</span>';
	break;
	case 1:
		echo '<span class="icon-col1">1 คะแนน</span>';
	break;
	case 2:
		echo '<span class="icon-col2">2 คะแนน</span>';
	break;
	case 3:
		echo '<span class="icon-col3">3 คะแนน</span>';
	break;
	case 4:
		echo '<span class="icon-col4">4 คะแนน</span>';
	break;
	case 5:
		echo '<span class="icon-col5">5 คะแนน</span>';
	break;
}
?></td>
      <td><?php echo $DetailScore5; ?></td>
      </tr>     
  </table>  
</div>  
<!--End  id="tbl-quality"-->


  
  </td>
</tr>

</table>
<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">แผนการดำเนินการ/ค่าเป้าหมายรายเดือน-ไตรมาส</div>
<table width="100%" border="1" class="tbl-list"  cellspacing="0" cellpadding="0" style="margin-top:0px;">
  <thead>
    <tr>
      <th rowspan="2" align="center" style="width:70px;">&nbsp;</th>
      <th rowspan="2" align="center">ค่าเป้าหมาย<br />
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
    <td align="center" >ตามแผน</td>
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
    <td align="center" >ตามผล</td>
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
    <td align="center" >ตามแผน</td>
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
    <td align="center" >ตามผล</td>
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
    echo '<span class="icon-col'.$TGScore.'">&nbsp;</span><br><span> ('.$TGScore.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore10 >= 0){
	echo '<span class="icon-col'.$MTargetScore10.'">&nbsp;</span><br><span> ('.$MTargetScore10.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore11 >= 0){
    echo '<span class="icon-col'.$MTargetScore11.'">&nbsp;</span><br><span> ('.$MTargetScore11.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore12 >= 0){
    echo '<span class="icon-col'.$MTargetScore12.'">&nbsp;</span><br><span> ('.$MTargetScore12.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore1 >= 0){
    echo '<span class="icon-col'.$MTargetScore1.'">&nbsp;</span><br><span> ('.$MTargetScore1.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore2 >= 0){
    echo '<span class="icon-col'.$MTargetScore2.'">&nbsp;</span><br><span> ('.$MTargetScore2.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore3 >= 0){
    echo '<span class="icon-col'.$MTargetScore3.'">&nbsp;</span><br><span> ('.$MTargetScore3.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore4 >= 0){
    echo '<span class="icon-col'.$MTargetScore4.'">&nbsp;</span><br><span> ('.$MTargetScore4.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore5 >= 0){
    echo '<span class="icon-col'.$MTargetScore5.'">&nbsp;</span><br><span> ('.$MTargetScore5.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore6 >= 0){
    echo '<span class="icon-col'.$MTargetScore6.'">&nbsp;</span><br><span> ('.$MTargetScore6.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore7 >= 0){
    echo '<span class="icon-col'.$MTargetScore7.'">&nbsp;</span><br><span> ('.$MTargetScore7.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore8 >= 0){
    echo '<span class="icon-col'.$MTargetScore8.'">&nbsp;</span><br><span> ('.$MTargetScore8.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
    <td align="center"><?php
if($MTargetScore9 >= 0){
    echo '<span class="icon-col'.$MTargetScore9.'">&nbsp;</span><br><span> ('.$MTargetScore9.' คะแนน)</span>';
}else{
	echo '-';
}
?></td>
  </tr>
</table>
<div style="padding:10px; text-align:center;">
<input type="button" name="button4" id="button4" value="ปรับปรุงข้อมูล" class="btnRed" onclick="goPage('?mod=<?php echo lurl::dotPage('project_ind_add');?>&PrjIndId=<?php echo $_REQUEST["PrjIndId"]; ?>');"  />
<input name="cancel" type="button" value="ย้อนกลับ" class="btn cancle" onclick="goPage('?mod=<?php echo lurl::dotPage('project_list');?>&BgtYear=<?php echo $BgtYear; ?>');" />
</div>

</form>
</div>
<div id="detailView" style=" display:none"></div>

<br /><br /><br />