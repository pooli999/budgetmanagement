<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));


$this->DOC->setPathWays(array(
	array(
		'text' => 'จัดการข้อมูลพื้นฐาน',
		'link' => '?mod=budget.init.startup',
	),
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'เพิ่ม'.$MenuName
	),
));

//ltxt::print_r($datas);
?>
<script language="javascript" type="text/javascript">

/* <![CDATA[ */

function ValidateForm(f){
		if(JQ('#IndCode').val() == 0){
			jAlert('กรุณาระบุรหัสตัวชี้วัดอ้างอิง','ระบบตรวจสอบข้อมูล',function(){
				JQ('#IndCode').focus();
			});
			return false;
		}
	
		/*if(JQ('#IndTypeName').val() == '' || JQ('#IndTypeName').val() == ' '){
			jAlert('กรุณาระบุชื่อประเภทตัวชี้วัด(KPI)','ระบบตรวจสอบข้อมูล',function(){
				JQ('#IndTypeName').focus();
			});
			return false;
		}*/

		return true;
}


function Save(f){
	if(ValidateForm(f)){	
		 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		 var redirec_url = '?mod=<?php echo LURL::dotPage($listPage);?>';
		 toSubmit(f,'saveind',action_url,redirec_url);
	}
}

/*function Confirm(f){
	if(ValidateForm(f)){		
		var firm_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		toConfirm(f,'confirm',firm_url);
	}
	
}*/
 
	function loadSCT(BgtYear){
		
	}

/*  ]]> */

</script>
<script>
function showCriterion(obj){ 
	if(obj == 'quantity'){
		document.getElementById('tbl-quantity').style.display="";
		document.getElementById('tbl-quality').style.display="none";
	}else{
		document.getElementById('tbl-quantity').style.display="none";
		document.getElementById('tbl-quality').style.display="";
	}
}

function loadIndName(LindCode){
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('policy_action');?>",		   
		  data: "action=getindname&LindCode="+LindCode,
		  success: function(msg){
			JQ("#ind-name").html(msg);
		  }
	});

}// end

</script>  
<?php 
$datas = $get->getPlanDetail($_REQUEST["PItemId"]);//ltxt::print_r($datas);
foreach($datas as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;}
}

?>


<div class="sysinfo">
  <div class="sysname">เพิ่มรายการ<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไข<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td style="padding:3px; font-weight:bold; font-size:16px;"><?php echo $PGroupName;?></td>
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

<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#EEEEEE">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>





<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th>ปีงบประมาณ</th>
    <td colspan="2"><?php echo $BgtYear; ?><input type="hidden" name="BgtYear" value="<?php echo $BgtYear; ?>" /></td>
  </tr>
    <tr style="font-weight:bold;">
        <th>ชื่อแผนงาน</th>
        <td colspan="2">(<?php echo $PItemCode; ?>) <?php echo $PItemName;?></td>
    </tr>

<?php if($PGroupId == 12){ ?>
<tr>
<th>อ้างอิงแผนหลัก</th>
<td colspan="2">
<?php echo ($LPlanCode)?($get->getLPlanName($LPlanCode)):('<span style="color:#999;">-ไม่ระบุ-</span>'); ?>
<input type="hidden" name="LPlanCode" value="<?php echo $LPlanCode; ?>" />
</td>
</tr>
<?php } ?>

    
<?    
    if($_REQUEST["PIndId"]){
	$indicator = $get->getIndDetail($_REQUEST["PIndId"]);//ltxt::print_r($dataPlan);
	foreach($indicator as $in){
		foreach( $in as $a=>$q){ ${$a} = $q;}
	}
?>   
    <input name="PIndId" type="hidden"  id="PIndId" value="<?php echo $_REQUEST['PIndId'];?>" />
    <input name="PIndCode" type="hidden"  id="PIndCode" value="<?php echo $PIndCode;?>" />
<?php } ?>
<tr>
      <th>อ้างอิงตัวชี้วัดแผนหลัก</th>
      <td class="require">*</td>
      <td><div><?php echo $get->getIndList($LindCode);?></div></td>
    </tr>   
<tr>
    <th>รหัสตัวชี้วัด</th>
    <td class="require">&nbsp;</td>
    <td><?php echo ($PIndCode)?$PIndCode:'<span class="hint">(ระบบสร้างรหัสอัตโนมัติ)</span>'; ?><input type="hidden" name="PIndCode" id="PIndCode" value="<?php echo $PIndCode; ?>" /></td>
</tr>
<tr style="vertical-align:top;">
    <th>ชื่อตัวชี้วัด</th>
    <td class="require">*</td>
    <td>
<div id="ind-name" style="padding-top:8px; padding-bottom:8px;" class="hint"><?php //$get->getIndName($IndCode); ?></div>
<textarea style="width:99%; height:50px;" name="PIndName" id="PIndName"><?php echo $PIndName; ?></textarea>
	</td>
</tr>
<tr style="vertical-align:top;">
    <th>คำอธิบายตัวชี้วัด</th>
    <td class="require">*</td>
    <td><?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'PIndDetail','id' => 'PIndDetail', 'value' => $PIndDetail,'height'=>'150'));?></td>
</tr>
<tr style="vertical-align:top;">
    <th>วัตถุประสงค์ตัวชี้วัด</th>
    <td class="require">*</td>
    <td><?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'PIndPurpose','id' => 'PIndPurpose', 'value' => $PIndPurpose,'height'=>'150'));?></td>
</tr>
<tr style="vertical-align:top;">
  <th>ผู้รายงานผลตัวชี้วัด</th>
  <td class="require">*</td>
  <td>
    <?php //echo ePerson(array('name'=>'ResultSelect[]','id'=>'ResultSelect','value'=>'','selecttype'=>'multi'));?>
    <?php echo ePerson(array('name'=>'PersonalSelect[]','id'=>'PersonalSelect','value'=>implodeString($get->getTaskPerson($PIndCode),'PersonalCode'),'selecttype'=>'multi'));?>
    </td>
</tr>
<tr>
  <th>หน่วยนับ</th>
  <td class="require">*</td>
  <td><?php echo $get->getUnitList($UnitID);?>
    <input type="radio" name="UnitPosition" value="front"  <?php if($UnitPosition=="front"){ ?> checked="checked" <?php } ?> />
    อยู่หน้าค่าข้อมูล
    <input type="radio" name="UnitPosition" <?php if(($UnitPosition == "") || ($UnitPosition=="back") ){ ?> checked="checked" <?php } ?> value="back" />
    อยู่หลังค่าข้อมูล </td>
</tr>
</table>



<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">ข้อมูลเกณฑ์การประเมินsss</div>
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
<tr style="vertical-align:top;">
  <th>ประเภทเกณฑ์ประเมิน</th>
  <td class="require">*</td>
  <td>
<input type="radio" name="CriterionType" value="quantity" <?php if((!$CriterionType) || ($CriterionType=="quantity")){ ?> checked="checked" <?php } ?> onclick="showCriterion('quantity');" />&nbsp;เชิงปริมาณ&nbsp;
<input type="radio" name="CriterionType" value="quality" <?php if($CriterionType=="quality"){ ?> checked="checked" <?php } ?> onclick="showCriterion('quality');" />&nbsp;เชิงคุณภาพ
  </td>
  </tr>
<tr style="vertical-align:top;">
    <th>อธิบายวิธีการคำนวณ</th>
    <td class="require">*</td>
    <td><?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'PIndCalculate','id' => 'PIndCalculate', 'value' => $PIndCalculate,'height'=>'150'));?></td>
</tr>
<!--<tr>
    <th>ค่าถ่วงน้ำหนัก</th>
    <td class="require">*</td>
    <td><input type="text" name="MassValue"  id="MassValue" value="1.5" style="width:100px; text-align:center;" />&nbsp;%</td>
</tr>
-->
<tr style="vertical-align:top;">
  <th colspan="3">เกณฑ์การให้คะแนน <span class="require">*</span></th>
</tr>
<!--<tr>
    <th>ค่าถ่วงน้ำหนัก</th>
    <td class="require">*</td>
    <td><input type="text" name="MassValue"  id="MassValue" value="1.5" style="width:100px; text-align:center;" />&nbsp;%</td>
</tr>
-->
<tr style="vertical-align:top;">
  <td colspan="3" style="vertical-align:top;">
  
  
  
  
  
<div id="tbl-quantity" <?php if($CriterionType =="quality"){?> style="display:none;"  <?php } ?>>  
<table width="100%" border="0" class="tbl-list" cellspacing="1" cellpadding="0">
    <tr style="vertical-align:top;">
      <td style="width:150px; text-align:center; background-color:#EEE;">ช่วงค่าเป้าหมาย<br /><span class="hint" style="font-size:12px;">(กรอกเป็นตัวเลขเท่านั้น)</span></td>
      <td colspan="7" style="text-align:center; background-color:#EEE;">คะแนนที่ได้ตามช่วงของค่าเป้าหมาย</td>
      <td style="text-align:center; background-color:#EEE;">คำอธิบาย</td>
    </tr>
    <tr>
      <td style="width:150px; text-align:center;"><input type="text" name="QTMinScore0"  id="QTMinScore0" style="width:50px; text-align:center;" value="<?php echo $QTMinScore0; ?>" />
        <b> - </b>
        <input type="text" name="QTMaxScore0"  id="QTMaxScore0" style="width:50px; text-align:center;" value="<?php echo $QTMaxScore0; ?>" /></td>
      <td style="width:20px; text-align:center;">=</td>
      <td style="width:100px;"><input type="radio" name="QTScore0" value="0" <?php if($Score0==0){ ?> checked="checked" <?php } ?> />
        <span class="icon-col1">0 คะแนน</span></td>
      <td style="width:100px;"><input type="radio" name="QTScore0" value="1" <?php if($Score0==1){ ?> checked="checked" <?php } ?> />
        <span class="icon-col2">1 คะแนน</span></td>
      <td style="width:100px;"><input type="radio" name="QTScore0" value="2" <?php if($Score0==2){ ?> checked="checked" <?php } ?> />
        <span class="icon-col3">2 คะแนน</span></td>
      <td style="width:100px;"><input type="radio" name="QTScore0" value="3" <?php if($Score0==3){ ?> checked="checked" <?php } ?> />
        <span class="icon-col4">3 คะแนน</span></td>
      <td style="width:100px;"><input type="radio" name="QTScore0" value="4" <?php if($Score0==4){ ?> checked="checked" <?php } ?> />
        <span class="icon-col5">4 คะแนน</span></td>
      <td style="width:100px;"><input type="radio" name="QTScore0" value="5" <?php if($Score0==5){ ?> checked="checked" <?php } ?> />
        <span class="icon-col6">5 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QTDetailScore0" id="QTDetailScore0"><?php echo $DetailScore0; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="QTMinScore1"  id="QTMinScore1" style="width:50px; text-align:center;" value="<?php echo $QTMinScore1; ?>" />
        <b> - </b>
        <input type="text" name="QTMaxScore1"  id="QTMaxScore1" style="width:50px; text-align:center;" value="<?php echo $QTMaxScore1; ?>" /></td>
      <td style="text-align:center;">=</td>
      <td><input type="radio" name="QTScore1" value="0" <?php if($Score1==0){ ?> checked="checked" <?php } ?> />
        <span class="icon-col1">0 คะแนน</span></td>
      <td><input type="radio" name="QTScore1" value="1" <?php if($Score1==1){ ?> checked="checked" <?php } ?> />
        <span class="icon-col2">1 คะแนน</span></td>
      <td><input type="radio" name="QTScore1" value="2" <?php if($Score1==2){ ?> checked="checked" <?php } ?> />
        <span class="icon-col3">2 คะแนน</span></td>
      <td><input type="radio" name="QTScore1" value="3" <?php if($Score1==3){ ?> checked="checked" <?php } ?> />
        <span class="icon-col4">3 คะแนน</span></td>
      <td><input type="radio" name="QTScore1" value="4" <?php if($Score1==4){ ?> checked="checked" <?php } ?> />
        <span class="icon-col5">4 คะแนน</span></td>
      <td><input type="radio" name="QTScore1" value="5" <?php if($Score1==5){ ?> checked="checked" <?php } ?> />
        <span class="icon-col6">5 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QTDetailScore1" id="QTDetailScore1"><?php echo $DetailScore1; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="QTMinScore2"  id="QTMinScore2" style="width:50px; text-align:center;" value="<?php echo $QTMinScore2; ?>" />
        <b> - </b>
        <input type="text" name="QTMaxScore2"  id="QTMaxScore2" style="width:50px; text-align:center;" value="<?php echo $QTMaxScore2; ?>" /></td>
      <td style="text-align:center;">=</td>
      <td><input type="radio" name="QTScore2" value="0" <?php if($Score2==0){ ?> checked="checked" <?php } ?> />
        <span class="icon-col1">0 คะแนน</span></td>
      <td><input type="radio" name="QTScore2" value="1" <?php if($Score2==1){ ?> checked="checked" <?php } ?> />
        <span class="icon-col2">1 คะแนน</span></td>
      <td><input type="radio" name="QTScore2" value="2" <?php if($Score2==2){ ?> checked="checked" <?php } ?> />
        <span class="icon-col3">2 คะแนน</span></td>
      <td><input type="radio" name="QTScore2" value="3" <?php if($Score2==3){ ?> checked="checked" <?php } ?> />
        <span class="icon-col4">3 คะแนน</span></td>
      <td><input type="radio" name="QTScore2" value="4" <?php if($Score2==4){ ?> checked="checked" <?php } ?> />
        <span class="icon-col5">4 คะแนน</span></td>
      <td><input type="radio" name="QTScore2" value="5" <?php if($Score2==5){ ?> checked="checked" <?php } ?> />
        <span class="icon-col6">5 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QTDetailScore2" id="QTDetailScore2"><?php echo $DetailScore2; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="QTMinScore3"  id="QTMinScore3" style="width:50px; text-align:center;" value="<?php echo $QTMinScore3; ?>" />
        <b> - </b>
        <input type="text" name="QTMaxScore3"  id="QTMaxScore3" style="width:50px; text-align:center;" value="<?php echo $QTMaxScore3; ?>" /></td>
      <td style="text-align:center;">=</td>
      <td><input type="radio" name="QTScore3" value="0" <?php if($Score3==0){ ?> checked="checked" <?php } ?> />
        <span class="icon-col1">0 คะแนน</span></td>
      <td><input type="radio" name="QTScore3" value="1" <?php if($Score3==1){ ?> checked="checked" <?php } ?> />
        <span class="icon-col2">1 คะแนน</span></td>
      <td><input type="radio" name="QTScore3" value="2" <?php if($Score3==2){ ?> checked="checked" <?php } ?> />
        <span class="icon-col3">2 คะแนน</span></td>
      <td><input type="radio" name="QTScore3" value="3" <?php if($Score3==3){ ?> checked="checked" <?php } ?> />
        <span class="icon-col4">3 คะแนน</span></td>
      <td><input type="radio" name="QTScore3" value="4" <?php if($Score3==4){ ?> checked="checked" <?php } ?> />
        <span class="icon-col5">4 คะแนน</span></td>
      <td><input type="radio" name="QTScore3" value="5" <?php if($Score3==5){ ?> checked="checked" <?php } ?> />
        <span class="icon-col6">5 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QTDetailScore3" id="QTDetailScore3"><?php echo $DetailScore3; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="QTMinScore4"  id="QTMinScore4" style="width:50px; text-align:center;" value="<?php echo $QTMinScore4; ?>" />
        <b> - </b>
        <input type="text" name="QTMaxScore4"  id="QTMaxScore4" style="width:50px; text-align:center;" value="<?php echo $QTMaxScore4; ?>" /></td>
      <td style="text-align:center;">=</td>
      <td><input type="radio" name="QTScore4" value="0" <?php if($Score4==0){ ?> checked="checked" <?php } ?> />
        <span class="icon-col1">0 คะแนน</span></td>
      <td><input type="radio" name="QTScore4" value="1" <?php if($Score4==1){ ?> checked="checked" <?php } ?> />
        <span class="icon-col2">1 คะแนน</span></td>
      <td><input type="radio" name="QTScore4" value="2" <?php if($Score4==2){ ?> checked="checked" <?php } ?> />
        <span class="icon-col3">2 คะแนน</span></td>
      <td><input type="radio" name="QTScore4" value="3" <?php if($Score4==3){ ?> checked="checked" <?php } ?> />
        <span class="icon-col4">3 คะแนน</span></td>
      <td><input type="radio" name="QTScore4" value="4" <?php if($Score4==4){ ?> checked="checked" <?php } ?> />
        <span class="icon-col5">4 คะแนน</span></td>
      <td><input type="radio" name="QTScore4" value="5" <?php if($Score4==5){ ?> checked="checked" <?php } ?> />
        <span class="icon-col6">5 คะแนน</span></td>
         <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QTDetailScore4" id="QTDetailScore4"><?php echo $DetailScore4; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="QTMinScore5"  id="QTMinScore5" style="width:50px; text-align:center;" value="<?php echo $QTMinScore5; ?>" />
        <b> - </b>
        <input type="text" name="QTMaxScore5"  id="QTMaxScore5" style="width:50px; text-align:center;" value="<?php echo $QTMaxScore5; ?>" /></td>
      <td style="text-align:center;">=</td>
      <td><input type="radio" name="QTScore5" value="0" <?php if($Score5==0){ ?> checked="checked" <?php } ?> />
        <span class="icon-col1">0 คะแนน</span></td>
      <td><input type="radio" name="QTScore5" value="1" <?php if($Score5==1){ ?> checked="checked" <?php } ?> />
        <span class="icon-col2">1 คะแนน</span></td>
      <td><input type="radio" name="QTScore5" value="2" <?php if($Score5==2){ ?> checked="checked" <?php } ?> />
        <span class="icon-col3">2 คะแนน</span></td>
      <td><input type="radio" name="QTScore5" value="3" <?php if($Score5==3){ ?> checked="checked" <?php } ?> />
        <span class="icon-col4">3 คะแนน</span></td>
      <td><input type="radio" name="QTScore5" value="4" <?php if($Score5==4){ ?> checked="checked" <?php } ?> />
        <span class="icon-col5">4 คะแนน</span></td>
      <td><input type="radio" name="QTScore5" value="5" <?php if($Score5==5){ ?> checked="checked" <?php } ?> />
        <span class="icon-col6">5 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QTDetailScore5" id="QTDetailScore5"><?php echo $DetailScore5; ?></textarea></td>
    </tr>
  </table>  
</div>  
<!--End  id="tbl-quantity"-->
  


<div id="tbl-quality" <?php if((!$CriterionType) || ($CriterionType =="quantity")){?> style="display:none;"  <?php } ?>>  
<table width="100%" border="0" class="tbl-list" cellspacing="1" cellpadding="0">
    <tr style="vertical-align:top;">
      <td style="width:150px; text-align:center; background-color:#EEE;">ค่าเป้าหมาย</td>
      <td colspan="7" style="text-align:center; background-color:#EEE;">คะแนนที่ได้ตามช่วงของค่าเป้าหมาย</td>
      <td style="text-align:center; background-color:#EEE;">คำอธิบาย</td>
    </tr>
    <tr>
      <td style="width:150px; text-align:center;"><input type="text" name="TQLScore0"  id="TQLScore0" style="width:140px;" value="<?php echo $TQLScore0; ?>" /></td>
      <td style="width:20px; text-align:center;">=</td>
      <td style="width:100px;"><input type="radio" name="QLScore0" value="0" <?php if($Score0==0){ ?> checked="checked" <?php } ?> />
        <span class="icon-col1">0 คะแนน</span></td>
      <td style="width:100px;"><input type="radio" name="QLScore0" value="1" <?php if($Score0==1){ ?> checked="checked" <?php } ?> />
        <span class="icon-col2">1 คะแนน</span></td>
      <td style="width:100px;"><input type="radio" name="QLScore0" value="2" <?php if($Score0==2){ ?> checked="checked" <?php } ?> />
        <span class="icon-col3">2 คะแนน</span></td>
      <td style="width:100px;"><input type="radio" name="QLScore0" value="3" <?php if($Score0==3){ ?> checked="checked" <?php } ?> />
        <span class="icon-col4">3 คะแนน</span></td>
      <td style="width:100px;"><input type="radio" name="QLScore0" value="4" <?php if($Score0==4){ ?> checked="checked" <?php } ?> />
        <span class="icon-col5">4 คะแนน</span></td>
      <td style="width:100px;"><input type="radio" name="QLScore0" value="5" <?php if($Score0==5){ ?> checked="checked" <?php } ?> />
        <span class="icon-col6">5 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QLDetailScore0" id="QLDetailScore0"><?php echo $DetailScore0; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="TQLScore1"  id="TQLScore1" style="width:140px;" value="<?php echo $TQLScore1; ?>" /></td>
      <td style="text-align:center;">=</td>
      <td><input type="radio" name="QLScore1" value="0" <?php if($Score1==0){ ?> checked="checked" <?php } ?> />
        <span class="icon-col1">0 คะแนน</span></td>
      <td><input type="radio" name="QLScore1" value="1" <?php if($Score1==1){ ?> checked="checked" <?php } ?> />
        <span class="icon-col2">1 คะแนน</span></td>
      <td><input type="radio" name="QLScore1" value="2" <?php if($Score1==2){ ?> checked="checked" <?php } ?> />
        <span class="icon-col3">2 คะแนน</span></td>
      <td><input type="radio" name="QLScore1" value="3" <?php if($Score1==3){ ?> checked="checked" <?php } ?> />
        <span class="icon-col4">3 คะแนน</span></td>
      <td><input type="radio" name="QLScore1" value="4" <?php if($Score1==4){ ?> checked="checked" <?php } ?> />
        <span class="icon-col5">4 คะแนน</span></td>
      <td><input type="radio" name="QLScore1" value="5" <?php if($Score1==5){ ?> checked="checked" <?php } ?> />
        <span class="icon-col6">5 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QLDetailScore1" id="QLDetailScore1"><?php echo $DetailScore1; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="TQLScore2"  id="TQLScore2" style="width:140px;" value="<?php echo $TQLScore2; ?>" /></td>
      <td style="text-align:center;">=</td>
      <td><input type="radio" name="QLScore2" value="0" <?php if($Score2==0){ ?> checked="checked" <?php } ?> />
        <span class="icon-col1">0 คะแนน</span></td>
      <td><input type="radio" name="QLScore2" value="1" <?php if($Score2==1){ ?> checked="checked" <?php } ?> />
        <span class="icon-col2">1 คะแนน</span></td>
      <td><input type="radio" name="QLScore2" value="2" <?php if($Score2==2){ ?> checked="checked" <?php } ?> />
        <span class="icon-col3">2 คะแนน</span></td>
      <td><input type="radio" name="QLScore2" value="3" <?php if($Score2==3){ ?> checked="checked" <?php } ?> />
        <span class="icon-col4">3 คะแนน</span></td>
      <td><input type="radio" name="QLScore2" value="4" <?php if($Score2==4){ ?> checked="checked" <?php } ?> />
        <span class="icon-col5">4 คะแนน</span></td>
      <td><input type="radio" name="QLScore2" value="5" <?php if($Score2==5){ ?> checked="checked" <?php } ?> />
        <span class="icon-col6">5 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QLDetailScore2" id="QLDetailScore2"><?php echo $DetailScore2; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="TQLScore3"  id="TQLScore3" style="width:140px;" value="<?php echo $TQLScore3; ?>" /></td>
      <td style="text-align:center;">=</td>
      <td><input type="radio" name="QLScore3" value="0" <?php if($Score3==0){ ?> checked="checked" <?php } ?> />
        <span class="icon-col1">0 คะแนน</span></td>
      <td><input type="radio" name="QLScore3" value="1" <?php if($Score3==1){ ?> checked="checked" <?php } ?> />
        <span class="icon-col2">1 คะแนน</span></td>
      <td><input type="radio" name="QLScore3" value="2" <?php if($Score3==2){ ?> checked="checked" <?php } ?> />
        <span class="icon-col3">2 คะแนน</span></td>
      <td><input type="radio" name="QLScore3" value="3" <?php if($Score3==3){ ?> checked="checked" <?php } ?> />
        <span class="icon-col4">3 คะแนน</span></td>
      <td><input type="radio" name="QLScore3" value="4" <?php if($Score3==4){ ?> checked="checked" <?php } ?> />
        <span class="icon-col5">4 คะแนน</span></td>
      <td><input type="radio" name="QLScore3" value="5" <?php if($Score3==5){ ?> checked="checked" <?php } ?> />
        <span class="icon-col6">5 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QLDetailScore3" id="QLDetailScore3"><?php echo $DetailScore3; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="TQLScore4"  id="TQLScore4" style="width:140px;" value="<?php echo $TQLScore4; ?>" /></td>
      <td style="text-align:center;">=</td>
      <td><input type="radio" name="QLScore4" value="0" <?php if($Score4==0){ ?> checked="checked" <?php } ?> />
        <span class="icon-col1">0 คะแนน</span></td>
      <td><input type="radio" name="QLScore4" value="1" <?php if($Score4==1){ ?> checked="checked" <?php } ?> />
        <span class="icon-col2">1 คะแนน</span></td>
      <td><input type="radio" name="QLScore4" value="2" <?php if($Score4==2){ ?> checked="checked" <?php } ?> />
        <span class="icon-col3">2 คะแนน</span></td>
      <td><input type="radio" name="QLScore4" value="3" <?php if($Score4==3){ ?> checked="checked" <?php } ?> />
        <span class="icon-col4">3 คะแนน</span></td>
      <td><input type="radio" name="QLScore4" value="4" <?php if($Score4==4){ ?> checked="checked" <?php } ?> />
        <span class="icon-col5">4 คะแนน</span></td>
      <td><input type="radio" name="QLScore4" value="5" <?php if($Score4==5){ ?> checked="checked" <?php } ?> />
        <span class="icon-col6">5 คะแนน</span></td>
         <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QLDetailScore4" id="QLDetailScore4"><?php echo $DetailScore4; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="TQLScore5"  id="TQLScore5" style="width:140px;" value="<?php echo $TQLScore5; ?>" /></td>
      <td style="text-align:center;">=</td>
      <td><input type="radio" name="QLScore5" value="0" <?php if($Score5==0){ ?> checked="checked" <?php } ?> />
        <span class="icon-col1">0 คะแนน</span></td>
      <td><input type="radio" name="QLScore5" value="1" <?php if($Score5==1){ ?> checked="checked" <?php } ?> />
        <span class="icon-col2">1 คะแนน</span></td>
      <td><input type="radio" name="QLScore5" value="2" <?php if($Score5==2){ ?> checked="checked" <?php } ?> />
        <span class="icon-col3">2 คะแนน</span></td>
      <td><input type="radio" name="QLScore5" value="3" <?php if($Score5==3){ ?> checked="checked" <?php } ?> />
        <span class="icon-col4">3 คะแนน</span></td>
      <td><input type="radio" name="QLScore5" value="4" <?php if($Score5==4){ ?> checked="checked" <?php } ?> />
        <span class="icon-col5">4 คะแนน</span></td>
      <td><input type="radio" name="QLScore5" value="5" <?php if($Score5==5){ ?> checked="checked" <?php } ?> />
        <span class="icon-col6">5 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QLDetailScore5" id="QLDetailScore5"><?php echo $DetailScore5; ?></textarea></td>
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
    <th rowspan="2" align="center">ค่าเป้าหมาย<br /> <span class="hint" style="font-weight:normal;">(หน่วยนับตามที่ระบุด้านบน)</span></th>
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
    <td align="center" ><input type="text" name="PIndQTTGPlan"  id="PIndQTTGPlan" value="<?php echo $PIndQTTGPlan; ?>" style="width:100px; text-align:center;" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[10]" id="QTMTargetPlan_10" value="<?php echo $get->getQTIndMonth($PIndCode,10); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[11]" id="QTMTargetPlan_11" value="<?php echo $get->getQTIndMonth($PIndCode,11); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[12]" id="QTMTargetPlan_12" value="<?php echo $get->getQTIndMonth($PIndCode,12); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[1]" id="QTMTargetPlan_1" value="<?php echo $get->getQTIndMonth($PIndCode,1); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[2]" id="QTMTargetPlan_2" value="<?php echo $get->getQTIndMonth($PIndCode,2); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[3]" id="QTMTargetPlan_3" value="<?php echo $get->getQTIndMonth($PIndCode,3); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[4]" id="QTMTargetPlan_4" value="<?php echo $get->getQTIndMonth($PIndCode,4); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[5]" id="QTMTargetPlan_5" value="<?php echo $get->getQTIndMonth($PIndCode,5); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[6]" id="QTMTargetPlan_6" value="<?php echo $get->getQTIndMonth($PIndCode,6); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[7]" id="QTMTargetPlan_7" value="<?php echo $get->getQTIndMonth($PIndCode,7); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[8]" id="QTMTargetPlan_8" value="<?php echo $get->getQTIndMonth($PIndCode,8); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[9]" id="QTMTargetPlan_9" value="<?php echo $get->getQTIndMonth($PIndCode,9); ?>" /></td>
    </tr>
 <?php } ?> 
 
 <?php if($CriterionType =="quality"){?>
  <tr>
    <td align="center" ><?php echo $get->getTQLScore($_REQUEST["PIndId"],$PIndQLTGPlan,"PIndQLTGPlan");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonth($PIndCode,10),"QLMTargetPlan[10]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonth($PIndCode,11),"QLMTargetPlan[11]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonth($PIndCode,12),"QLMTargetPlan[12]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonth($PIndCode,1),"QLMTargetPlan[1]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonth($PIndCode,2),"QLMTargetPlan[2]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonth($PIndCode,3),"QLMTargetPlan[3]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonth($PIndCode,4),"QLMTargetPlan[4]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonth($PIndCode,5),"QLMTargetPlan[5]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonth($PIndCode,6),"QLMTargetPlan[6]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonth($PIndCode,7),"QLMTargetPlan[7]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonth($PIndCode,8),"QLMTargetPlan[8]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PIndId"],$get->getQLIndMonth($PIndCode,9),"QLMTargetPlan[9]");?></td>
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








