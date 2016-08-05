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
<div class="sysinfo">
  <div class="sysname">เพิ่มรายการ<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไข<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onClick="history.back(-1);" /></td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<?php 
$datas = $get->getPlanDetail($_REQUEST["PItemId"]);//ltxt::print_r($datas);
foreach($datas as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;}
}

?>
<input name="PItemId" type="hidden"  id="PItemId" value="<?php echo $_REQUEST['PItemId'];?>" />
<input name="PItemCode" type="hidden"  id="PItemCode" value="<?php echo $PItemCode;?>" />
<input name="BgtYear" type="hidden"  id="BgtYear" value="<?php echo $BgtYear;?>" />
<input name="PGroupId" type="hidden"  id="PGroupId" value="<?php echo $_REQUEST['PGroupId'];?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>





<div style="background-color:#c9e39c; padding:3px; font-weight:bold; font-size:16px;"><?php echo $PGroupName;?></div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th>ปีงบประมาณ</th>
    <td colspan="2"><?php echo $BgtYear; ?></td>
  </tr>
    <tr style="font-weight:bold;">
        <th>ชื่อแผนงาน</th>
        <td colspan="2">(<?php echo $PItemCode; ?>) <?php echo $PItemName;?></td>
    </tr>

<?php if($PGroupId == 12){ ?>
<tr>
<th>อ้างอิงแผนหลัก</th>
<td colspan="2"><?php echo ($LPlanCode)?($get->getLPlanName($LPlanCode)):('<span style="color:#999;">-ไม่ระบุ-</span>'); ?></td>
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
    <th>รหัสตัวชี้วัด</th>
    <td class="require">*</td>
    <td><input type="text"  style="width:150px;" name="PIndCode" id="PIndCode" value="<?php echo $PIndCode; ?>" /></td>
</tr>
<tr style="vertical-align:top;">
    <th>ชื่อตัวชี้วัด</th>
    <td class="require">*</td>
    <td><textarea style="width:98%; height:50px;" name="PIndName" id="PIndName"><?php echo $PIndName; ?></textarea></td>
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
    <th>ค่าเป้าหมาย</th>
    <td class="require">*</td>
    <td>
    <input type="text" name="PIndTargetPlan"  id="PIndTargetPlan" value="<?php echo $PIndTargetPlan; ?>" style="width:100px; text-align:center;" />
	<?php echo $get->getUnitList($UnitID);?>
    </td>
</tr>
</table>


<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">แผนการดำเนินการ/ค่าเป้าหมายรายเดือน-ไตรมาส</div>
<table width="100%" border="0" class="tbl-list"  cellspacing="1" cellpadding="0" style="margin-top:0px;">
<thead>
  <tr>
    <th align="center">ไตรมาส</th>
    <th align="center" style="width:150px">เดือน/ปี</th>
    <th align="center" style="width:150px">ค่าเป้าหมาย</th>
    <th align="center" style="width:150px" >เดือน/ปี</th>
    <th align="center" style="width:150px">ค่าเป้าหมาย</th>
    <th align="center" style="width:150px" >เดือน/ปี</th>
    <th align="center" style="width:150px">ค่าเป้าหมาย</th>
    </tr>
</thead>


  <tr>
    <td align="center" >ไตรมาสที่ 1</td>
    <td align="center">ตุลาคม/55</td>
    <td align="center">= <input type="text" style="width:85%; text-align:center;" name="MonthTargetPlan[10]" id="MonthTargetPlan_10" value="<?php echo $get->getIndicatorMonth($PIndCode,10); ?>" /></td>
    <td align="center">พฤศจิกายน/55</td>
    <td align="center">= <input type="text" style="width:85%; text-align:center;" name="MonthTargetPlan[11]" id="MonthTargetPlan_11" value="<?php echo $get->getIndicatorMonth($PIndCode,11); ?>" /></td>
    <td align="center">ธันวาคม/55</td>
    <td align="center">= <input type="text" style="width:85%; text-align:center;" name="MonthTargetPlan[12]" id="MonthTargetPlan_12" value="<?php echo $get->getIndicatorMonth($PIndCode,12); ?>" /></td>
  </tr>
  
  <tr>
    <td align="center">ไตรมาสที่ 2</td>
    <td align="center">มกราคม/56</td>
    <td align="center">= <input type="text" style="width:85%; text-align:center;" name="MonthTargetPlan[1]" id="MonthTargetPlan_1" value="<?php echo $get->getIndicatorMonth($PIndCode,1); ?>" /></td>
    <td align="center">กุมภาพันธ์/56</td>
    <td align="center">= <input type="text" style="width:85%; text-align:center;" name="MonthTargetPlan[2]" id="MonthTargetPlan_2" value="<?php echo $get->getIndicatorMonth($PIndCode,2); ?>" /></td>
    <td align="center">มีนาคม/56</td>
    <td align="center">= <input type="text" style="width:85%; text-align:center;" name="MonthTargetPlan[3]" id="MonthTargetPlan_3" value="<?php echo $get->getIndicatorMonth($PIndCode,3); ?>" /></td>
  </tr>
  
  <tr>
    <td align="center">ไตรมาสที่ 3</td>
    <td align="center">เมษายน/56</td>
    <td align="center">= <input type="text" style="width:85%; text-align:center;" name="MonthTargetPlan[4]" id="MonthTargetPlan_4" value="<?php echo $get->getIndicatorMonth($PIndCode,4); ?>" /></td>
    <td align="center">พฤษภาคม/56</td>
    <td align="center">= <input type="text" style="width:85%; text-align:center;" name="MonthTargetPlan[5]" id="MonthTargetPlan_5" value="<?php echo $get->getIndicatorMonth($PIndCode,5); ?>" /></td>
    <td align="center">มิถุนายน/56</td>
    <td align="center">= <input type="text" style="width:85%; text-align:center;" name="MonthTargetPlan[6]" id="MonthTargetPlan_6" value="<?php echo $get->getIndicatorMonth($PIndCode,6); ?>" /></td>
  </tr>
  <tr>
   <td align="center">ไตรมาสที่ 4</td>
   <td align="center">กรกฏาคม/56</td>
   <td align="center">= <input type="text" style="width:85%; text-align:center;" name="MonthTargetPlan[7]" id="MonthTargetPlan_7" value="<?php echo $get->getIndicatorMonth($PIndCode,7); ?>" /></td>
   <td align="center">สิงหาคม/56</td>
   <td align="center">= <input type="text" style="width:85%; text-align:center;" name="MonthTargetPlan[8]" id="MonthTargetPlan_8" value="<?php echo $get->getIndicatorMonth($PIndCode,8); ?>" /></td>
   <td align="center">กันยายน/56</td>
   <td align="center">= <input type="text" style="width:85%; text-align:center;" name="MonthTargetPlan[9]" id="MonthTargetPlan_9" value="<?php echo $get->getIndicatorMonth($PIndCode,9); ?>" /></td>
  </tr>
  
  
</table>


<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">ข้อมูลเกณฑ์การประเมินddd</div>
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
--><tr style="vertical-align:top;">
    <th>อธิบายวิธีการคำนวณ</th>
    <td class="require">*</td>
    <td><?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'PIndCalculate','id' => 'PIndCalculate', 'value' => $PIndCalculate,'height'=>'150'));?></td>
</tr>
<!--<tr>
    <th>ค่าถ่วงน้ำหนัก</th>
    <td class="require">*</td>
    <td><input type="text" name="MassValue"  id="MassValue" value="1.5" style="width:100px; text-align:center;" />&nbsp;%</td>
</tr>
--><tr style="vertical-align:top;">
    <th>เกณฑ์การให้คะแนน</th>
    <td class="require">*</td>
    <td>
      <table width="750" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="width:150px;">
          <input type="text" name="MinScore0"  id="MinScore0" style="width:50px; text-align:center;" value="<?php echo $MinScore0; ?>" />
          <b> - </b>
          <input type="text" name="MaxScore0"  id="MaxScore0" style="width:50px; text-align:center;" value="<?php echo $MinScore0; ?>" />
          </td>
          <td style="width:20px; text-align:center;">=</td>
          <td style="width:100px;"><input type="radio" name="Score0" value="0" <?php if($Score0==0){ ?> checked="checked" <?php } ?> /><span class="icon-col1">0 คะแนน</span></td>
          <td style="width:100px;"><input type="radio" name="Score0" value="1" <?php if($Score0==1){ ?> checked="checked" <?php } ?> /><span class="icon-col2">1 คะแนน</span></td>
          <td style="width:100px;"><input type="radio" name="Score0" value="2" <?php if($Score0==2){ ?> checked="checked" <?php } ?> /><span class="icon-col3">2 คะแนน</span></td>
          <td style="width:100px;"><input type="radio" name="Score0" value="3" <?php if($Score0==3){ ?> checked="checked" <?php } ?> /><span class="icon-col4">3 คะแนน</span></td>
          <td style="width:100px;"><input type="radio" name="Score0" value="4" <?php if($Score0==4){ ?> checked="checked" <?php } ?> /><span class="icon-col5">4 คะแนน</span></td>
          <td style="width:100px;"><input type="radio" name="Score0" value="5" <?php if($Score0==5){ ?> checked="checked" <?php } ?> /><span class="icon-col6">5 คะแนน</span></td>
        </tr>
        <tr>
          <td>
          <input type="text" name="MinScore1"  id="MinScore1" style="width:50px; text-align:center;" value="<?php echo $MinScore1; ?>" />
          <b> - </b>
          <input type="text" name="MaxScore1"  id="MaxScore1" style="width:50px; text-align:center;" value="<?php echo $MaxScore1; ?>" />
          </td>
          <td style="text-align:center;">=</td>
          <td><input type="radio" name="Score1" value="0" <?php if($Score1==0){ ?> checked="checked" <?php } ?> /><span class="icon-col1">0 คะแนน</span></td>
          <td><input type="radio" name="Score1" value="1" <?php if($Score1==1){ ?> checked="checked" <?php } ?> /><span class="icon-col2">1 คะแนน</span></td>
          <td><input type="radio" name="Score1" value="2" <?php if($Score1==2){ ?> checked="checked" <?php } ?> /><span class="icon-col3">2 คะแนน</span></td>
          <td><input type="radio" name="Score1" value="3" <?php if($Score1==3){ ?> checked="checked" <?php } ?> /><span class="icon-col4">3 คะแนน</span></td>
          <td><input type="radio" name="Score1" value="4" <?php if($Score1==4){ ?> checked="checked" <?php } ?> /><span class="icon-col5">4 คะแนน</span></td>
          <td><input type="radio" name="Score1" value="5" <?php if($Score1==5){ ?> checked="checked" <?php } ?> /><span class="icon-col6">5 คะแนน</span></td>
        </tr>
        <tr>
          <td>
          <input type="text" name="MinScore2"  id="MinScore2" style="width:50px; text-align:center;" value="<?php echo $MinScore2; ?>" />
          <b> - </b>
          <input type="text" name="MaxScore2"  id="MaxScore2" style="width:50px; text-align:center;" value="<?php echo $MaxScore2; ?>" />
          </td>
          <td style="text-align:center;">=</td>
          <td><input type="radio" name="Score2" value="0" <?php if($Score2==0){ ?> checked="checked" <?php } ?> /><span class="icon-col1">0 คะแนน</span></td>
          <td><input type="radio" name="Score2" value="1" <?php if($Score2==1){ ?> checked="checked" <?php } ?> /><span class="icon-col2">1 คะแนน</span></td>
          <td><input type="radio" name="Score2" value="2" <?php if($Score2==2){ ?> checked="checked" <?php } ?> /><span class="icon-col3">2 คะแนน</span></td>
          <td><input type="radio" name="Score2" value="3" <?php if($Score2==3){ ?> checked="checked" <?php } ?> /><span class="icon-col4">3 คะแนน</span></td>
          <td><input type="radio" name="Score2" value="4" <?php if($Score2==4){ ?> checked="checked" <?php } ?> /><span class="icon-col5">4 คะแนน</span></td>
          <td><input type="radio" name="Score2" value="5" <?php if($Score2==5){ ?> checked="checked" <?php } ?> /><span class="icon-col6">5 คะแนน</span></td>
        </tr>
        <tr>
          <td>
          <input type="text" name="MinScore3"  id="MinScore3" style="width:50px; text-align:center;" value="<?php echo $MinScore3; ?>" />
          <b> - </b>
          <input type="text" name="MaxScore3"  id="MaxScore3" style="width:50px; text-align:center;" value="<?php echo $MaxScore3; ?>" />
          </td>
          <td style="text-align:center;">=</td>
          <td><input type="radio" name="Score3" value="0" <?php if($Score3==0){ ?> checked="checked" <?php } ?> /><span class="icon-col1">0 คะแนน</span></td>
          <td><input type="radio" name="Score3" value="1" <?php if($Score3==1){ ?> checked="checked" <?php } ?> /><span class="icon-col2">1 คะแนน</span></td>
          <td><input type="radio" name="Score3" value="2" <?php if($Score3==2){ ?> checked="checked" <?php } ?> /><span class="icon-col3">2 คะแนน</span></td>
          <td><input type="radio" name="Score3" value="3" <?php if($Score3==3){ ?> checked="checked" <?php } ?> /><span class="icon-col4">3 คะแนน</span></td>
          <td><input type="radio" name="Score3" value="4" <?php if($Score3==4){ ?> checked="checked" <?php } ?> /><span class="icon-col5">4 คะแนน</span></td>
          <td><input type="radio" name="Score3" value="5" <?php if($Score3==5){ ?> checked="checked" <?php } ?> /><span class="icon-col6">5 คะแนน</span></td>
        </tr>
        <tr>
          <td>
          <input type="text" name="MinScore4"  id="MinScore4" style="width:50px; text-align:center;" value="<?php echo $MinScore4; ?>" />
          <b> - </b>
          <input type="text" name="MaxScore4"  id="MaxScore4" style="width:50px; text-align:center;" value="<?php echo $MaxScore4; ?>" />
          </td>
          <td style="text-align:center;">=</td>
          <td><input type="radio" name="Score4" value="0" <?php if($Score4==0){ ?> checked="checked" <?php } ?> /><span class="icon-col1">0 คะแนน</span></td>
          <td><input type="radio" name="Score4" value="1" <?php if($Score4==1){ ?> checked="checked" <?php } ?> /><span class="icon-col2">1 คะแนน</span></td>
          <td><input type="radio" name="Score4" value="2" <?php if($Score4==2){ ?> checked="checked" <?php } ?> /><span class="icon-col3">2 คะแนน</span></td>
          <td><input type="radio" name="Score4" value="3" <?php if($Score4==3){ ?> checked="checked" <?php } ?> /><span class="icon-col4">3 คะแนน</span></td>
          <td><input type="radio" name="Score4" value="4" <?php if($Score4==4){ ?> checked="checked" <?php } ?> /><span class="icon-col5">4 คะแนน</span></td>
          <td><input type="radio" name="Score4" value="5" <?php if($Score4==5){ ?> checked="checked" <?php } ?> /><span class="icon-col6">5 คะแนน</span></td>
        </tr>
        <tr>
          <td>
          <input type="text" name="MinScore5"  id="MinScore5" style="width:50px; text-align:center;" value="<?php echo $MinScore5; ?>" />
          <b> - </b>
          <input type="text" name="MaxScore5"  id="MaxScore5" style="width:50px; text-align:center;" value="<?php echo $MaxScore5; ?>" />
          </td>
          <td style="text-align:center;">=</td>
          <td><input type="radio" name="Score5" value="0" <?php if($Score5==0){ ?> checked="checked" <?php } ?> /><span class="icon-col1">0 คะแนน</span></td>
          <td><input type="radio" name="Score5" value="1" <?php if($Score5==1){ ?> checked="checked" <?php } ?> /><span class="icon-col2">1 คะแนน</span></td>
          <td><input type="radio" name="Score5" value="2" <?php if($Score5==2){ ?> checked="checked" <?php } ?> /><span class="icon-col3">2 คะแนน</span></td>
          <td><input type="radio" name="Score5" value="3" <?php if($Score5==3){ ?> checked="checked" <?php } ?> /><span class="icon-col4">3 คะแนน</span></td>
          <td><input type="radio" name="Score5" value="4" <?php if($Score5==4){ ?> checked="checked" <?php } ?> /><span class="icon-col5">4 คะแนน</span></td>
          <td><input type="radio" name="Score5" value="5" <?php if($Score5==5){ ?> checked="checked" <?php } ?> /><span class="icon-col6">5 คะแนน</span></td>
        </tr>
      </table>
      
    </td>
</tr>


</table>





<div style="padding:10px; text-align:center;">
<input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="history.back(-1);" />
</div>



</form>
</div>
<div id="detailView" style=" display:none"></div>










