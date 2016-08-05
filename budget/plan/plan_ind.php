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
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'เพิ่ม'.$MenuName
	),
));


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
		
		/*if(JQ('#PLongCode').val() == '' || JQ('#PLongCode').val() == ' '){
			jAlert('กรุณาระบุรหัสแผนงานต่อเนื่อง','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PLongCode').focus();
			});
			return false;
		}
			
		if(JQ('#PLongName').val() == '' || JQ('#PLongName').val() == ' '){
			jAlert('กรุณาระบุชื่อแผนงานต่อเนื่อง','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PLongName').focus();
			});
			return false;
		}
		
		if(JQ('#PLongYear').val() == 0){
			jAlert('กรุณาระบุปีที่ตั้งแผนงาน','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PLongYear').focus();
			});
			return false;
		}		
		
		if(JQ('#PLongAmount').val() == '' || JQ('#PLongAmount').val() == ' '){
			jAlert('กรุณาระบุจำนวนปีต่อเนื่อง','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PLongAmount').focus();
			});
			return false;
		}		*/	

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

function loadIndName(IndCode){
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('plan_action');?>",		   
		  data: "action=getindname&IndCode="+IndCode,
		  success: function(msg){
			JQ("#ind-name").html(msg);
		  }
	});

}// end
JQ(function(){
	JQ("#LindName").val(JQ('#m_plan_id option:selected').text());
	JQ("#m_plan_id").change(function(){
			JQ("#LindName").val(JQ('#m_plan_id option:selected').text());
	});
});
</script>  


<div class="sysinfo">
  <div class="sysname">เพิ่มข้อมูลแผนงานต่อเนื่อง</div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไขแผนงานต่อเนื่อง</div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input name="LPlanCode" type="hidden"  id="LPlanCode" value="<?php echo $_REQUEST['LPlanCode'];?>" />
<?php if($_REQUEST["LindId"]){ ?>
<input name="LindId" type="hidden"  id="LindId" value="<?php echo $_REQUEST['LindId'];?>" />
<?php } ?>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#EEEEEE">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>


<?php 
$datas = $get->getPlanDetail($_REQUEST["LPlanCode"]);//ltxt::print_r($dataPlan);
foreach($datas as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;}
}

if($_REQUEST["LindId"]){
	$indicator = $get->getIndDetail($_REQUEST["LindId"]);//ltxt::print_r($dataPlan);
	foreach($indicator as $in){
		foreach( $in as $a=>$q){ ${$a} = $q;}
	}
}
?>   
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
    <tr>
        <th>ชื่อแผนหลัก</th>
        <td colspan="2"><?php echo $PLongName;?></td>
    </tr>
    <tr style="vertical-align:top;">
        <th valign="top">รายละเอียด</th>
        <td colspan="2"><?php echo ($PLongDetail)?$PLongDetail:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
    </tr>
    <tr>
        <th>ปีที่ตั้งแผนหลัก</th>
        <td colspan="2"><?php echo $PLongYear;?><b>-</b><?php echo $PLongYearEnd;?>&nbsp;(ต่อเนื่อง <?php echo $PLongAmount;?> ปี)</td>
    </tr>
    <tr>
      <th>ตัวชี้วัดแผนหลัก</th>
      <td colspan="2" style="font-weight:bold;"> 
	  <select id = "m_plan_id">
	  <option value="">-</option>
		<option value="1"> (001) มีการนำสาระสำคัญในธรรมนูญว่าด้วยระบบสุขภาพแห่งชาติฯ ไปใช้ในการจัดทำแผนปฏิบัติราชการ และแผนประจำปีของหน่วยงานยุทธศาสตร์ </option>
		<option value="1"> (002)  มีการจัดทำธรรมนูญสุขภาพพื้นที่ หรือนำสาระของธรรมนูญว่าด้วยระบบสุขภาพแห่งชาติฯ ไปประกอบการจัดทำแผนพัฒนาสุขภาพในระดับพื้นที่และมีการดำเนินการตามแผน อย่างน้อย ๑๐๐ แห่ง</option>
		<option value="1">(003)  มีธรรมนูญว่าด้วยระบบสุขภาพแห่งชาติ ฉบับที่สอง</option>
		<option value="1"> 	(004) มีข้อเสนอนโยบายสาธารณะเพื่อสุขภาพที่คณะรัฐมนตรีให้ความเห็นชอบ และมีการนำไปสู่การปฏิบัติ อย่างน้อย ๒๕ เรื่อง</option>
		<option value="1"> 	(005) มีรายงานสถานการณ์ระบบสุขภาพแห่งชาติที่สะท้อนสถานการณ์ในภาพรวม และประเด็นสำคัญ อย่างน้อย ๑๕ ฉบับ</option>
		<option value="1">(006)  มีการขับเคลื่อนมติและข้อเสนอเชิงนโยบายจากสมัชชาสุขภาพแห่งชาติจนเกิดผลการปฏิบัติอย่างน้อย ๕๐ เรื่อง</option>
		<option value="1">(007)  	มีการใช้สมัชชาสุขภาพเฉพาะพื้นที่ในการพัฒนานโยบายสาธารณะเพื่อสุขภาพและมีการดำเนินการตามข้อเสนอเชิงนโยบาย ในทุกจังหวัดทั่วประเทศ</option>
		<option value="1"> (008) มีการใช้สมัชชาสุขภาพเฉพาะประเด็นในการพัฒนานโยบายสาธารณะเพื่อสุขภาพและมีการดำเนินการตามข้อเสนอเชิงนโยบายในเรื่องต่างๆ อย่างน้อย ๕๐ เรื่อง</option>
		<option value="1"> (009) 	มีการใช้สมัชชาสุขภาพเฉพาะพื้นที่ และสมัชชาสุขภาพเฉพาะประเด็นในการพัฒนานโยบายสาธารณะที่หนุนเสริมการปฏิรูปประเทศไทยอย่างต่อเนื่อง</option>
		<option value="1">(010)  เกิดระบบและกลไกที่เชื่อมโยงทุกภาคส่วนของสังคมในการร่วมกันพัฒนา เอชไอเอ ให้เป็นเครื่องมือสำคัญในการกำหนดทิศทางการพัฒนา</option>
		<option value="1">(011)  มีการทำงานกับกลุ่มประเทศอาเซียน ประเทศในภูมิภาคเอเชียตะวันออกเฉียงใต้ และเครือข่ายระหว่างประเทศ เพื่อพัฒนาและใช้ เอชไอเอ ร่วมกัน </option>
		<option value="1">(012)  ชุมชนท้องถิ่นมีการนำเครื่องมือ เอชไอเอ ไปใช้ เพิ่มขึ้น อย่างน้อย ๒๕๐ พื้นที่</option>
		<option value="1"> (013) หลักเกณฑ์และวิธีการทำ เอชไอเอสามารถนำไปปฏิบัติได้อย่างสอดคล้องกับบริบทของสังคมไทย</option>
		<option value="1"> (014) หน่วยงาน องค์กร และภาคีต่างๆ มีการทำ เอชไอเอ ในหลายระดับ</option>
		<option value="1">(015)  มีการตัดสินใจเลือกทางเลือกเชิงนโยบายต่างๆ ที่เป็นผลดีต่อสุขภาพของประชาชน โดยการใช้ผลการทำ เอชไอเอ เป็นข้อมูลประกอบอย่างสำคัญ</option>
		<option value="1">(016)  องค์กรวิชาชีพ สถานพยาบาล และภาคีเครือข่ายต่างๆ ที่เกี่ยวข้อง มีการรับรู้ เข้าใจ เรื่องสิทธิและหน้าที่ด้านสุขภาพตาม พ.ร.บ. สุขภาพแห่งชาติ อย่างน้อยร้อยละ ๓๐ </option>
      </select>
      </td>
    </tr>
    <tr>
        <th>ชื่อแผนงาน</th>
        <td colspan="2" style="font-weight:bold;">(<?php echo $LPlanCode;?>) <?php echo $LPlanName;?></td>
    </tr>
   <!-- <tr>
      <th>ตัวชี้วัดอ้างอิง</th>
      <td class="require">*</td>
      <td><?php// echo $get->getIndList($IndCode);?></td>
    </tr>-->
    <tr>
    <th>รหัสตัวชี้วัด</th>
    <td class="require">&nbsp;</td>
    <td>
<?php echo ($LindCode)?$LindCode:'<span class="hint">(ระบบสร้างรหัสอัตโนมัติ)</span>'; ?>
<input type="hidden" name="LindCode" id="LindCode" value="<?php echo $LindCode; ?>" />    </td>
</tr>
<tr style="vertical-align:top;">
    <th>ชื่อตัวชี้วัด</th>
    <td class="require">*</td>
    <td>

<textarea style="width:99%; height:50px;" name="LindName" id="LindName"><?php  // echo $LindName; ?>มีการจัดทำธรรมนูญสุขภาพพื้นที่ หรือนำสาระของธรรมนูญว่าด้วยระบบสุขภาพแห่งชาติฯ ไปประกอบการจัดทำแผนพัฒนาสุขภาพในระดับพื้นที่และมีการดำเนินการตามแผน อย่างน้อย ๑๐๐ แห่ง</textarea>	</td>
</tr>
<tr style="vertical-align:top;">
    <th>คำอธิบายตัวชี้วัด</th>
    <td class="require">*</td>
    <td><?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'LindDetail','id' => 'LindDetail', 'value' => $LindDetail,'height'=>'150'));?></td>
</tr>
<tr style="vertical-align:top;">
    <th>วัตถุประสงค์ตัวชี้วัด</th>
    <td class="require">*</td>
    <td><?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'LindPurpose','id' => 'LindPurpose', 'value' => $LindPurpose,'height'=>'150'));?></td>
</tr>
<tr style="vertical-align:top;">
    <th>ผู้รายงานผลตัวชี้วัด</th>
    <td class="require">*</td>
    <td>
	<?php //echo ePerson(array('name'=>'ResultSelect[]','id'=>'ResultSelect','value'=>'','selecttype'=>'multi'));?>
    <?php echo ePerson(array('name'=>'PersonalSelect[]','id'=>'PersonalSelect','value'=>implodeString($get->getTaskPerson($LindCode),'PersonalCode'),'selecttype'=>'multi'));?>    </td>
</tr>
<tr>
    <th>หน่วยนับ</th>
    <td class="require">*</td>
    <td>
<?php echo $get->getUnitList($UnitID);?>
<input type="radio" name="UnitPosition" value="front"  <?php if($UnitPosition=="front"){ ?> checked="checked" <?php } ?> />อยู่หน้าค่าข้อมูล
<input type="radio" name="UnitPosition" <?php if(($UnitPosition == "") || ($UnitPosition=="back") ){ ?> checked="checked" <?php } ?> value="back" />อยู่หลังค่าข้อมูล    </td>
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
    <td><?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'LindCalculate','id' => 'LindCalculate', 'value' => $LindCalculate,'height'=>'150'));?></td>
</tr>
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
      <td colspan="7" style="text-align:left; background-color:#EEE;">คะแนนที่ได้ตามช่วงของค่าเป้าหมาย##</td>
      <td style="text-align:center; background-color:#EEE;">คำอธิบาย</td>
    </tr>
    <tr>
      <td style="width:150px; text-align:center;"><input type="text" name="QTMinScore0"  id="QTMinScore0" style="width:50px; text-align:center;" value="<?php echo $QTMinScore0; ?>" />
        <b> - </b>
        <input type="text" name="QTMaxScore0"  id="QTMaxScore0" style="width:50px; text-align:center;" value="<?php echo $QTMinScore0; ?>" /></td>
      <td style="width:20px; text-align:center;">=</td>
      <td style="width:100px;" colspan="6">
	  <select name="select">
	  	<option value="0" selected="selected">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
      </select> 
         <span class="icon-col0">0 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QTDetailScore0" id="QTDetailScore0"><?php echo $DetailScore0; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="QTMinScore1"  id="QTMinScore1" style="width:50px; text-align:center;" value="<?php echo $QTMinScore1; ?>" />
        <b> - </b>
        <input type="text" name="QTMaxScore1"  id="QTMaxScore1" style="width:50px; text-align:center;" value="<?php echo $QTMaxScore1; ?>" /></td>
      <td style="text-align:center;">=</td>
      <td style="width:100px;" colspan="6">
	  <select name="select">
	  	<option value="0">0</option>
        <option value="1" selected="selected">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
      </select> 
         <span class="icon-col1">1 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QTDetailScore1" id="QTDetailScore1"><?php echo $DetailScore1; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="QTMinScore2"  id="QTMinScore2" style="width:50px; text-align:center;" value="<?php echo $QTMinScore2; ?>" />
        <b> - </b>
        <input type="text" name="QTMaxScore2"  id="QTMaxScore2" style="width:50px; text-align:center;" value="<?php echo $QTMaxScore2; ?>" /></td>
      <td style="text-align:center;">=</td>
     <td style="width:100px;" colspan="6">
	  <select name="select">
	  	<option value="0">0</option>
        <option value="1">1</option>
        <option value="2" selected="selected">2</option>
        <option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
      </select> 
         <span class="icon-col2">2 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QTDetailScore2" id="QTDetailScore2"><?php echo $DetailScore2; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="QTMinScore3"  id="QTMinScore3" style="width:50px; text-align:center;" value="<?php echo $QTMinScore3; ?>" />
        <b> - </b>
        <input type="text" name="QTMaxScore3"  id="QTMaxScore3" style="width:50px; text-align:center;" value="<?php echo $QTMaxScore3; ?>" /></td>
      <td style="text-align:center;">=</td>
     <td style="width:100px;" colspan="6">
	  <select name="select">
	  	<option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3" selected="selected">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
      </select> 
         <span class="icon-col3">3 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QTDetailScore3" id="QTDetailScore3"><?php echo $DetailScore3; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="QTMinScore4"  id="QTMinScore4" style="width:50px; text-align:center;" value="<?php echo $QTMinScore4; ?>" />
        <b> - </b>
        <input type="text" name="QTMaxScore4"  id="QTMaxScore4" style="width:50px; text-align:center;" value="<?php echo $QTMaxScore4; ?>" /></td>
      <td style="text-align:center;">=</td>
     <td style="width:100px;" colspan="6">
	  <select name="select">
	  	<option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
		<option value="4" selected="selected">4</option>
		<option value="5">5</option>
      </select> 
         <span class="icon-col4">4 คะแนน</span></td>
         <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QTDetailScore4" id="QTDetailScore4"><?php echo $DetailScore4; ?></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;"><input type="text" name="QTMinScore5"  id="QTMinScore5" style="width:50px; text-align:center;" value="<?php echo $QTMinScore5; ?>" />
        <b> - </b>
        <input type="text" name="QTMaxScore5"  id="QTMaxScore5" style="width:50px; text-align:center;" value="<?php echo $QTMaxScore5; ?>" /></td>
      <td style="text-align:center;">=</td>
      <td style="width:100px;" colspan="6">
	  <select name="select">
	  	<option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
		<option value="4">4</option>
		<option value="5" selected="selected">5</option>
      </select>  
        <span class="icon-col5">5 คะแนน</span></td>
        <td style="text-align:center;"><textarea style="width:98%; height:30px;" name="QTDetailScore5" id="QTDetailScore5"><?php echo $DetailScore5; ?></textarea></td>
    </tr>
  </table>  
<!--<table width="100%" border="0" class="tbl-list" cellspacing="1" cellpadding="0">
    <tr style="vertical-align:top;">
      <td style="width:150px; text-align:center; background-color:#EEE;">ช่วงค่าเป้าหมาย<br /><span class="hint" style="font-size:12px;">(กรอกเป็นตัวเลขเท่านั้น)</span></td>
      <td colspan="7" style="text-align:center; background-color:#EEE;">คะแนนที่ได้ตามช่วงของค่าเป้าหมาย</td>
      <td style="text-align:center; background-color:#EEE;">คำอธิบาย</td>
    </tr>
    <tr>
      <td style="width:150px; text-align:center;"><input type="text" name="QTMinScore0"  id="QTMinScore0" style="width:50px; text-align:center;" value="<?php echo $QTMinScore0; ?>" />
        <b> - </b>
        <input type="text" name="QTMaxScore0"  id="QTMaxScore0" style="width:50px; text-align:center;" value="<?php echo $QTMinScore0; ?>" /></td>
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
  </table>  -->
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





<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">แผนการดำเนินการ/ค่าเป้าหมายรายปี <span class="require">*</span></div>
<table width="100%" border="1" class="tbl-list"  cellspacing="1" cellpadding="0" style="margin-top:0px;">
  <tr>
    <th rowspan="2">ค่าเป้าหมาย<br /> <span class="hint" style="font-weight:normal;">(หน่วยนับตามที่ระบุด้านบน)</span></th>
    <th colspan="<?php echo ($PLongAmount); ?>" style="text-align:center;">ค่าเป้าหมายแจกแจงตามปีงบประมาณ</th>
  </tr>
  <tr>
    <th style="text-align:center;">ปี <?php echo $PLongYear; ?><input type="hidden" name="BgtYear[0]"  id="BgtYear_0" value="<?php echo $PLongYear; ?>" /></th>
    <?php 
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
	?>
    <th style="text-align:center;">ปี <?php echo $initYear; ?><input type="hidden" name="BgtYear[<?php echo $y; ?>]"  id="BgtYear_<?php echo $y; ?>" value="<?php echo $initYear; ?>" /></th>
    <?php 
		$initYear++;
	} 
	?>
    </tr>
<?php if($CriterionType =="quantity"){?> 
  <tr>
  	<td style="text-align:center;">
<input type="text" name="LindQTTGPlan"  id="LindQTTGPlan" value="<?php echo $LindQTTGPlan; ?>" style="width:100px; text-align:center;" />
    </td>
    <td style="text-align:center;">
<input type="text" name="QTYTargetPlan[0]"  id="QTYTargetPlan_0" style="width:100px; text-align:center;" value="<?php echo $get->getQTIndicatorYear($LindCode,$PLongYear); ?>" />
    </td>
    <?php 
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
	?>
    <td style="text-align:center;">
<input type="text" name="QTYTargetPlan[<?php echo $y; ?>]"  id="QTYTargetPlan_<?php echo $y; ?>" style="width:100px; text-align:center;" value="<?php echo $get->getQTIndicatorYear($LindCode,$initYear); ?>" />
    </td>
    <?php 
		$initYear++;
	} 
	?>
  </tr>
<?php } ?>  

<?php if($CriterionType =="quality"){?>  
    <tr>
  	<td style="text-align:center;">
<?php echo $get->getTQLScore($_REQUEST["LindId"],$LindQLTGPlan,"LindQLTGPlan");?> 
    </td>
    <td style="text-align:center;">
<?php echo $get->getTQLScore($_REQUEST["LindId"],$get->getQLIndicatorYear($LindCode,$PLongYear),"QLYTargetPlan[0]");?> 
    </td>
    <?php 
	$initYear = $PLongYear+1;
	for($y=1;$y<$PLongAmount;$y++){ 
	?>
    <td style="text-align:center;">
<?php echo $get->getTQLScore($_REQUEST["LindId"],$get->getQLIndicatorYear($LindCode,$initYear),"QLYTargetPlan[".$y."]");?> 
    </td>
    <?php 
		$initYear++;
	} 
	?>
  </tr>
<?php } ?>



  
  
</table>












<div style="padding:10px; text-align:center;">
<input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onclick="goPage('?mod=<?php echo lurl::dotPage("plan_list");?>&PLongCode=<?php echo $PLongCode;?>');"  />
</div>













</form>
</div>
<div id="detailView" style=" display:none"></div>

