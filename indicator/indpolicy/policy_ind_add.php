<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));

$datas = $get->getPlanDetail($_REQUEST["PItemId"]);//ltxt::print_r($datas);
foreach($datas as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;}
}

$indicator = $get->getIndDetail($_REQUEST["PIndId"]);//ltxt::print_r($dataPlan);
foreach($indicator as $in){
	foreach( $in as $a=>$q){ ${$a} = $q;}
}


$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบรายงานผลและตัวชี้วัด',
	),
	array(
		'text' => 'ตัวชี้วัดระดับแผนงาน',
		'link' => '?mod='.lurl::dotPage("policy_list").'&BgtYear='.$BgtYear
	),
	array(
		'text' => 'บันทึกผลตัวชี้วัด'
	),
));

?>
<script language="javascript" type="text/javascript">
function ValidateForm(f){
		return true;
}

function Save(f){
	if(ValidateForm(f)){	
		 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		 var redirec_url = '?mod=<?php echo LURL::dotPage($listPage);?>';
		 toSubmit(f,'saveindmonth',action_url,redirec_url);
	}
}
</script>

<div class="sysinfo">
  <div class="sysname">ตัวชี้วัดระดับแผนงาน</div>
  <div class="sysdetail">&nbsp;</div>
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input name="PItemId" type="hidden"  id="PItemId" value="<?php echo $_REQUEST['PItemId'];?>" />
<input name="PItemCode" type="hidden"  id="PItemCode" value="<?php echo $PItemCode;?>" />
<input name="BgtYear" type="hidden"  id="BgtYear" value="<?php echo $BgtYear;?>" />
<input name="PGroupId" type="hidden"  id="PGroupId" value="<?php echo $_REQUEST['PGroupId'];?>" />
<input name="PIndId" type="hidden"  id="PIndId" value="<?php echo $_REQUEST['PIndId'];?>" />
<input name="PIndCode" type="hidden"  id="PIndCode" value="<?php echo $PIndCode;?>" />
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#EEEEEE">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
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
    <td><?php 
$TaskPersonSelect = $get->getTaskPerson($PIndCode); 
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
?></td>
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
<input type="hidden" name="CriterionType" value="<?php echo $CriterionType; ?>" />
  </td>
  </tr>
  <tr style="vertical-align:top;">
    <th>อธิบายวิธีการคำนวณ</th>
    <td><?php echo ($PIndCalculate)?$PIndCalculate:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
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




<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">แผนการดำเนินการ/ค่าเป้าหมายรายเดือน-ไตรมาส <span class="require">*</span></div>
<table width="100%" border="1" class="tbl-list"  cellspacing="0" cellpadding="0" style="margin-top:0px;">
<thead>
  <tr>
    <th rowspan="2" align="center" style="width:70px;">&nbsp;</th>
    <th rowspan="2" align="center">ค่าเป้าหมาย<br /> <span style="font-weight:normal;">(<?php echo ($UnitID)?($get->getUnitName($UnitID)):"-";  ?>)</span></th>
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
    <td align="center" ><?php echo $PIndQTTGPlan; ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PIndCode,10); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PIndCode,11); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PIndCode,12); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PIndCode,1); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PIndCode,2); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PIndCode,3); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PIndCode,4); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PIndCode,5); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PIndCode,6); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PIndCode,7); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PIndCode,8); ?></td>
    <td align="center"><?php echo $get->getQTIndMonth($PIndCode,9); ?></td>
    </tr>
      <tr>
    <td align="center" >ตามผล</td>
    <td align="center" ><?php echo $PIndQTTGResult; ?></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[10]" id="QTMTargetResult_10" value="<?php echo $get->getQTIndMonthResult($PIndCode,10); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[11]" id="QTMTargetResult_11" value="<?php echo $get->getQTIndMonthResult($PIndCode,11); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[12]" id="QTMTargetResult_12" value="<?php echo $get->getQTIndMonthResult($PIndCode,12); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[1]" id="QTMTargetResult_1" value="<?php echo $get->getQTIndMonthResult($PIndCode,1); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[2]" id="QTMTargetResult_2" value="<?php echo $get->getQTIndMonthResult($PIndCode,2); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[3]" id="QTMTargetResult_3" value="<?php echo $get->getQTIndMonthResult($PIndCode,3); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[4]" id="QTMTargetResult_4" value="<?php echo $get->getQTIndMonthResult($PIndCode,4); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[5]" id="QTMTargetResult_5" value="<?php echo $get->getQTIndMonthResult($PIndCode,5); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[6]" id="QTMTargetResult_6" value="<?php echo $get->getQTIndMonthResult($PIndCode,6); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[7]" id="QTMTargetResult_7" value="<?php echo $get->getQTIndMonthResult($PIndCode,7); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[8]" id="QTMTargetResult_8" value="<?php echo $get->getQTIndMonthResult($PIndCode,8); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[9]" id="QTMTargetResult_9" value="<?php echo $get->getQTIndMonthResult($PIndCode,9); ?>" /></td>
    </tr>
 <?php } ?> 
 
 <?php if($CriterionType =="quality"){?>
  <tr>
    <td align="center" >ตามแผน</td>
    <td align="center" ><?php echo $PIndQLTGPlan; ?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PIndCode,10); ?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PIndCode,11);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PIndCode,12);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PIndCode,1);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PIndCode,2);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PIndCode,3);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PIndCode,4);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PIndCode,5);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PIndCode,6);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PIndCode,7);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PIndCode,8);?></td>
    <td align="center"><?php echo $get->getQLIndMonth($PIndCode,9);?></td>
    </tr>
      <tr>
    <td align="center" >ตามผล</td>
    <td align="center" ><?php echo ($PIndQLTGResult)?$PIndQLTGResult:"-";?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonthResult($PIndCode,10),"QLMTargetResult[10]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonthResult($PIndCode,11),"QLMTargetResult[11]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonthResult($PIndCode,12),"QLMTargetResult[12]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonthResult($PIndCode,1),"QLMTargetResult[1]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonthResult($PIndCode,2),"QLMTargetResult[2]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonthResult($PIndCode,3),"QLMTargetResult[3]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonthResult($PIndCode,4),"QLMTargetResult[4]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonthResult($PIndCode,5),"QLMTargetResult[5]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonthResult($PIndCode,6),"QLMTargetResult[6]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonthResult($PIndCode,7),"QLMTargetResult[7]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonthResult($PIndCode,8),"QLMTargetResult[8]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonthResult($PIndCode,9),"QLMTargetResult[9]");?></td>
    </tr>
 <?php } ?> 

  <?php if(!$CriterionType){?>  
    <tr>
  	<td colspan="14" style="text-align:center;"><span style="color:#999;">-ไม่ระบุ-</span></td>
  </tr>
<?php } ?>



</table>






<div style="padding:10px; text-align:center;">
<input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onclick="goPage('?mod=<?php echo lurl::dotPage("policy_list");?>&BgtYear=<?php echo $BgtYear;?>');"  />
</div>





</form>
</div>
<div id="detailView" style=" display:none"></div>

<br /><br /><br />








