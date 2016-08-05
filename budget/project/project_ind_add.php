<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

function icoEdit($r){
	$label = 'แก้ไขข้อมูล';
	$text = '&nbsp;';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage('project_ind_add')."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']." '",
		'ico edit',
		$label,
		$text
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	$text = '&nbsp;';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:if(confirm('คุณต้องการลบข้อมูลหรือไม่')) self.location='?mod=".LURL::dotPage($actionPage)."&action=delete&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']." '",
		'ico delete',
		$label,
		$text
	));
}

?>

<script language="javascript" type="text/javascript">

/* <![CDATA[ */

function ValidateForm(f){
		/*if(JQ('#IndCode').val() == 0){
			jAlert('กรุณาระบุรหัสตัวชี้วัดอ้างอิง','ระบบตรวจสอบข้อมูล',function(){
				JQ('#IndCode').focus();
			});
			return false;
		}
		if(JQ('#IndTypeName').val() == '' || JQ('#IndTypeName').val() == ' '){
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
		 toSubmit(f,'saveprojectind',action_url,redirec_url);
	}
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

function loadIndName(PIndCode){
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('project_action');?>",		   
		  data: "action=getindname&PIndCode="+PIndCode,
		  success: function(msg){
			JQ("#ind-name").html(msg);
		  }
	});

}// end

</script>  


 <table width="100%" cellpadding="0" cellspacing="0" class="page-title-user">
 	<tr>
    	<td class="div-title-plan">&nbsp;</td>
        <td>
       <div class="font1">จัดทำแผนปฏิบัติงานประจำปี</div>
        </td>
    </tr>
 </table>


<div class="sysinfo">
  <div class="sysname" style="font-size:16px;"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>
</div>


<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />



<?php
 $datas = $get->getDetailPrj($_REQUEST["PrjId"],$_REQUEST["PrjDetailId"]);//ltxt::print_r($datas);
 //ltxt::print_r($datas);
foreach($datas as $actdatas){
	foreach($actdatas as $k=>$v){
		${$k} = $v;
	}
}

		//if($_REQUEST["SCTypeId"] == 2  ){
		 //	$SumBGTotal=$get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
		//}else{
		//	$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],0,0); 	
		//}		
		
		// งบโครงการ
		 $SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);

		// งบกลั่นกรอง/จัดสรร
		$sumScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$_REQUEST["PrjDetailId"]);
		$sumAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$_REQUEST["PrjDetailId"]);
		$sumAllot = $sumScreenInternal + $sumAllotExternal;		

?>

<input name="BgtYear" type="hidden"  id="BgtYear" value="<?php echo $BgtYear;?>" />
<input name="OrganizeCode" type="hidden"  id="OrganizeCode" value="<?php echo $OrganizeCode;?>" />
<input name="PrjId" type="hidden"  id="PrjId" value="<?php echo $PrjId;?>" />
<input name="LPrjCode" type="hidden"  id="LPrjCode" value="<?php echo $LPrjCode;?>" />
<input name="PrjCode" type="hidden"  id="PrjCode" value="<?php echo $PrjCode;?>" />
<input name="PrjDetailId" type="hidden"  id="PrjDetailId" value="<?php echo $PrjDetailId;?>" />
<input name="SCTypeId" type="hidden"  id="SCTypeId" value="<?php echo $SCTypeId;?>" />
<input name="ScreenLevel" type="hidden"  id="ScreenLevel" value="<?php echo $ScreenLevel;?>" />

<?    
    if($_REQUEST["PrjIndId"]){
	$indicator = $get->getIndDetail($_REQUEST["PrjIndId"]);//ltxt::print_r($dataPlan);
	foreach($indicator as $in){
		foreach( $in as $a=>$q){ ${$a} = $q;}
	}
?>   
    <input name="PrjIndId" type="hidden"  id="PrjIndId" value="<?php echo $_REQUEST['PrjIndId'];?>" />
    <input name="IndicatorCode" type="hidden"  id="IndicatorCode" value="<?php echo $IndicatorCode;?>" />
<?php } ?>


<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
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
    <tr>
      <th>อ้างอิงตัวชี้วัดแผนงาน##</th>
      <td class="require">*</td>
      <td><div><?php // echo $get->getIndList($BgtYear,$PIndCode);?>
	  <select name="">
	    <option value="1">(56P02-01) ผลการประเมินการจัดสมัชชาสุขภาพแห่งชาติมีความเป็นระบบและเป็นที่ยอมรับมากขึ้นกว่าปีก่อน</option>
	    <option value="2">(56P02-02) มีการขับเคลื่อนมติและข้อเสนอเชิงนโยบายจากสมัชชาสุขภาพแห่งชาติจนเกิดผลการปฏิบัติอย่างน้อย ๒๐ เรื่อง</option>
	    <option value="3">(56P02-03) มีการจัดกระบวนการสมัชชาสุขภาพจังหวัด (PHA) อย่างน้อย ๓๐ จังหวัด</option>
	    <option value="4">(56P02-04) มีการจัดกระบวนการสมัชชาสุขภาพเฉพาะประเด็น อย่างน้อย ๑๐ ประเด็น</option>
	  
	  </select>
	  
	  </div>
	  </td>
    </tr>
     
<tr>
    <th>รหัสตัวชี้วัด</th>
    <td class="require">&nbsp;</td>
    <td><?php echo ($IndicatorCode)?$IndicatorCode:'<span class="hint">(ระบบสร้างรหัสอัตโนมัติ)</span>'; ?><input type="hidden" name="IndicatorCode" id="IndicatorCode" value="<?php echo $IndicatorCode; ?>" /></td>
</tr>
<tr style="vertical-align:top;">
    <th>ชื่อตัวชี้วัด</th>
    <td class="require">*</td>
    <td>
<div id="ind-name" style="padding-top:8px; padding-bottom:8px;" class="hint"><?php //$get->getIndName($IndCode); ?></div>
<textarea style="width:99%; height:50px;" name="IndicatorName" id="IndicatorName"><?php echo $IndicatorName; ?></textarea>
	</td>
</tr>
<tr style="vertical-align:top;">
    <th>คำอธิบายตัวชี้วัด</th>
    <td class="require">*</td>
    <td><?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'IndicatorDetail','id' => 'IndicatorDetail', 'value' => $IndicatorDetail,'height'=>'150'));?></td>
</tr>
<tr style="vertical-align:top;">
    <th>วัตถุประสงค์ตัวชี้วัด</th>
    <td class="require">*</td>
    <td><?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'IndicatorPurpose','id' => 'IndicatorPurpose', 'value' => $IndicatorPurpose,'height'=>'150'));?></td>
</tr>
<tr style="vertical-align:top;">
  <th>ผู้รายงานผลตัวชี้วัด</th>
  <td class="require">*</td>
  <td>
    <?php //echo ePerson(array('name'=>'ResultSelect[]','id'=>'ResultSelect','value'=>'','selecttype'=>'multi'));?>
    <?php echo ePerson(array('name'=>'PersonalSelect[]','id'=>'PersonalSelect','value'=>implodeString($get->getTaskIndPerson($IndicatorCode),'PersonalCode'),'selecttype'=>'multi'));?>
    </td>
</tr>
<tr>
  <th>หน่วยนับ</th>
  <td class="require">*</td>
  <td><?php echo $get->getUnitList($UnitID,"UnitID");?>
    <input type="radio" name="UnitPosition" value="front"  <?php if($UnitPosition=="front"){ ?> checked="checked" <?php } ?> />
    อยู่หน้าค่าข้อมูล
    <input type="radio" name="UnitPosition" <?php if(($UnitPosition == "") || ($UnitPosition=="back") ){ ?> checked="checked" <?php } ?> value="back" />
    อยู่หลังค่าข้อมูล </td>
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
    <td><?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'Calculate','id' => 'Calculate', 'value' => $Calculate,'height'=>'150'));?></td>
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
    <td align="center" ><input type="text" name="QTTGPlan"  id="QTTGPlan" value="<?php echo $QTTGPlan; ?>" style="width:100px; text-align:center;" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[10]" id="QTMTargetPlan_10" value="<?php echo $get->getQTIndMonth($PrjIndId,10); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[11]" id="QTMTargetPlan_11" value="<?php echo $get->getQTIndMonth($PrjIndId,11); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[12]" id="QTMTargetPlan_12" value="<?php echo $get->getQTIndMonth($PrjIndId,12); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[1]" id="QTMTargetPlan_1" value="<?php echo $get->getQTIndMonth($PrjIndId,1); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[2]" id="QTMTargetPlan_2" value="<?php echo $get->getQTIndMonth($PrjIndId,2); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[3]" id="QTMTargetPlan_3" value="<?php echo $get->getQTIndMonth($PrjIndId,3); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[4]" id="QTMTargetPlan_4" value="<?php echo $get->getQTIndMonth($PrjIndId,4); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[5]" id="QTMTargetPlan_5" value="<?php echo $get->getQTIndMonth($PrjIndId,5); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[6]" id="QTMTargetPlan_6" value="<?php echo $get->getQTIndMonth($PrjIndId,6); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[7]" id="QTMTargetPlan_7" value="<?php echo $get->getQTIndMonth($PrjIndId,7); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[8]" id="QTMTargetPlan_8" value="<?php echo $get->getQTIndMonth($PrjIndId,8); ?>" /></td>
    <td align="center"><input type="text" style="width:85%; text-align:center;" name="QTMTargetPlan[9]" id="QTMTargetPlan_9" value="<?php echo $get->getQTIndMonth($PrjIndId,9); ?>" /></td>
    </tr>
 <?php } ?> 
 
 <?php if($CriterionType =="quality"){?>
  <tr>
    <td align="center" ><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$QLTGPlan,"QLTGPlan");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonth($PrjIndId,10),"QLMTargetPlan[10]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonth($PrjIndId,11),"QLMTargetPlan[11]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonth($PrjIndId,12),"QLMTargetPlan[12]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonth($PrjIndId,1),"QLMTargetPlan[1]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonth($PrjIndId,2),"QLMTargetPlan[2]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonth($PrjIndId,3),"QLMTargetPlan[3]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonth($PrjIndId,4),"QLMTargetPlan[4]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonth($PrjIndId,5),"QLMTargetPlan[5]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonth($PrjIndId,6),"QLMTargetPlan[6]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonth($PrjIndId,7),"QLMTargetPlan[7]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonth($PrjIndId,8),"QLMTargetPlan[8]");?></td>
    <td align="center"><?php echo $get->getTQLScore($_REQUEST["PrjIndId"],$get->getQLIndMonth($PrjIndId,9),"QLMTargetPlan[9]");?></td>
    </tr>
 <?php } ?> 

</table>






<div style="padding:10px; text-align:center;">
<input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onclick="goPage('?mod=<?php echo lurl::dotPage("project_ind");?>&BgtYear=<?php echo $_REQUEST["BgtYear"];?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"];?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"];?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>&PrjId=<?php echo $_REQUEST["PrjId"];?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"];?>');"  />
</div>


</form>
</div>
<div id="detailView" style=" display:none"></div>

<br /><br /><br />