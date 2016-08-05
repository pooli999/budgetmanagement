<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$indicator = $get->getIndDetail($_REQUEST["PrjIndId"]);//ltxt::print_r($indicator);
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
		'text' => 'รายงานความก้าวหน้างาน',
		'link' => '?mod='.lurl::dotPage("result_main").'&BgtYear='.$BgtYear
	),
	array(
		'text' => 'บันทึกผลตัวชี้วัดโครงการ',
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
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
		 toSubmit(f,'saveprojectindmonth',action_url,redirec_url);
	}
}
</script>


<div class="sysinfo">
  <div class="sysname">รายงานความก้าวหน้างาน</div>
  <div class="sysdetail">&nbsp;</div>
</div>


<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input name="BgtYear" type="hidden"  id="BgtYear" value="<?php echo $BgtYear;?>" />
<input name="OrganizeCode" type="hidden"  id="OrganizeCode" value="<?php echo $OrganizeCode;?>" />
<input name="PrjId" type="hidden"  id="PrjId" value="<?php echo $PrjId;?>" />
<input name="PrjCode" type="hidden"  id="PrjCode" value="<?php echo $PrjCode;?>" />
<input name="PrjDetailId" type="hidden"  id="PrjDetailId" value="<?php echo $PrjDetailId;?>" />
<input name="SCTypeId" type="hidden"  id="SCTypeId" value="<?php echo $SCTypeId;?>" />
<input name="ScreenLevel" type="hidden"  id="ScreenLevel" value="<?php echo $ScreenLevel;?>" />
<input name="PrjIndId" type="hidden"  id="PrjIndId" value="<?php echo $_REQUEST['PrjIndId'];?>" />
<input name="IndicatorCode" type="hidden"  id="IndicatorCode" value="<?php echo $IndicatorCode;?>" />
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
<input type="hidden" name="CriterionType" value="<?php echo $CriterionType; ?>" />
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
    <td align="center" >ตามผล <span class="require">*</span></td>
    <td align="center" ><?php echo $QTTGResult; ?></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[10]" id="QTMTargetResult_10" value="<?php echo $get->getQTIndMonthResult($PrjIndId,10); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[11]" id="QTMTargetResult_11" value="<?php echo $get->getQTIndMonthResult($PrjIndId,11); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[12]" id="QTMTargetResult_12" value="<?php echo $get->getQTIndMonthResult($PrjIndId,12); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[1]" id="QTMTargetResult_1" value="<?php echo $get->getQTIndMonthResult($PrjIndId,1); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[2]" id="QTMTargetResult_2" value="<?php echo $get->getQTIndMonthResult($PrjIndId,2); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[3]" id="QTMTargetResult_3" value="<?php echo $get->getQTIndMonthResult($PrjIndId,3); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[4]" id="QTMTargetResult_4" value="<?php echo $get->getQTIndMonthResult($PrjIndId,4); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[5]" id="QTMTargetResult_5" value="<?php echo $get->getQTIndMonthResult($PrjIndId,5); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[6]" id="QTMTargetResult_6" value="<?php echo $get->getQTIndMonthResult($PrjIndId,6); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[7]" id="QTMTargetResult_7" value="<?php echo $get->getQTIndMonthResult($PrjIndId,7); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[8]" id="QTMTargetResult_8" value="<?php echo $get->getQTIndMonthResult($PrjIndId,8); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetResult[9]" id="QTMTargetResult_9" value="<?php echo $get->getQTIndMonthResult($PrjIndId,9); ?>" /></td>
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
    <td align="center" >ตามผล <span class="require">*</span></td>
    <td align="center" ><?php echo $QLTGResult; ?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonthResult($PrjIndId,10),"QLMTargetResult[10]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonthResult($PrjIndId,11),"QLMTargetResult[11]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonthResult($PrjIndId,12),"QLMTargetResult[12]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonthResult($PrjIndId,1),"QLMTargetResult[1]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonthResult($PrjIndId,2),"QLMTargetResult[2]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonthResult($PrjIndId,3),"QLMTargetResult[3]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonthResult($PrjIndId,4),"QLMTargetResult[4]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonthResult($PrjIndId,5),"QLMTargetResult[5]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonthResult($PrjIndId,6),"QLMTargetResult[6]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonthResult($PrjIndId,7),"QLMTargetResult[7]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonthResult($PrjIndId,8),"QLMTargetResult[8]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonthResult($PrjIndId,9),"QLMTargetResult[9]");?></td>
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
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onclick="goPage('?mod=<?php echo lurl::dotPage("result_projectmonth");?>&PrjDetailId=<?php echo $PrjDetailId;?>');"  />
</div>

</form>
</div>
<div id="detailView" style=" display:none"></div>

<br /><br /><br />