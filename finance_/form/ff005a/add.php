<?php
include("config.php");
include("helper.php");
include("data.php");

$data = $get->getFormDetail($_REQUEST["DocCode"]);//ltxt::print_r($data);
foreach($data as $datarow){
	foreach($datarow as $g=>$q){
		${$g} = $q;
	}
}
if(!$data){
	$info = $get->getDocCodeDetail($_REQUEST["DocCode"]);//ltxt::print_r($info);
	foreach($info as $inforow){
		foreach($inforow as $gg=>$qq){
			${$gg} = $qq;
		}
	}
}

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));

$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบแบบฟอร์มอิเล็กทรอนิกส์',
		'link' => '?mod=front.form.main'
	),
	array(
		'text' => "เพิ่ม/แก้ไข",
	),
));


?>
<script language="javascript" type="text/javascript">
function Cancel(f){
	var inValid = JQ('#BGInValid').val();
	if(inValid == 'Y'){
		jAlert('ระบบไม่สามารถทำการยกเลิกและ Check out ทะเบียนคุมงบประมาณรายการนี้ได้ เนื่องจากยอดงบประมาณไม่ถูกต้อง กรุณาปรับปรุงข้อมูลให้ถูกต้อง และทำการบันทึกข้อมูลลงสู่ฐานข้อมูล');
	}else{
		//window.location.href='?mod=front.form.main';
		jConfirmQ('ยืนยันการยกเลิกและ Check Out เอกสาร', 'ยืนยันการดำเนินการ', function(r) {
				if(r){ 
					var DocCode = JQ('#DocCode').val();
					var action_url = '?mod=<?php echo LURL::dotPage("action");?>&DocCode='+DocCode;
					toSubmit(f,'checkout',action_url);
				}
		});
		/*if(confirm('ยืนยันการยกเลิกและ Check Out ข้อมูลทะเบียนคุมงบประมาณ')){
			var DocCode = JQ('#DocCode').val();
			var action_url = '?mod=<?php //echo LURL::dotPage("action");?>&DocCode='+DocCode;
			toSubmit(f,'checkout',action_url);
		}*/
	}
}
function ValidateForm(f){
		if(JQ('#Topic').val() == ""){
			jAlert('กรุณากรอกช่องเรื่อง',function(){
				JQ('#Topic').focus();
			});
			return false;
		}
		if(JQ('#Title').val() == ""){
			jAlert('กรุณากรอกช่องชื่อการปฏิบัติงาน',function(){
				JQ('#Title').focus();
			});
			return false;
		}
		if(JQ('#DocTo').val() == ""){
			jAlert('กรุณากรอกช่องเรียน',function(){
				JQ('#DocTo').focus();
			});
			return false;
		}
		if(JQ('#AmountDate').val() == ""){
			jAlert('กรุณากรอกช่องรวมเป็นเวลา(วัน)',function(){
				JQ('#AmountDate').focus();
			});
			return false;
		}
		if(getValueTextEditor('Detail') == ""){
			jAlert('กรุณากรองช่องมีความประสงค์จะ',function(){
				JQ('#Detail').focus();
			});
			return false;
		}
		if(parseFloat(JQ('#TotalCost').val()) == 0){
			jAlert('กรุณากรอกจำนวนเงินที่ต้องการขออนุมัติ',function(){
				JQ('#TotalCost').focus();
			});
			return false;
		}
/*		if(parseFloat(JQ('#TotalBorrow').val()) == 0){
			jAlert('กรุณากรอกจำนวนเงินที่ต้องการขอยืมเงินทดรอง',function(){
				JQ('#TotalBorrow').focus();
			});
			return false;
		}
*/		return true;
}


function Save(f){
	var inValid = JQ('#BGInValid').val();
	if(inValid == 'Y'){
		 jAlert('ระบบไม่สามารถทำการบันทึกข้อมูลลงสู่ฐานข้อมูลได้ เนื่องจากยอดงบประมาณไม่ถูกต้อง กรุณาปรับปรุงข้อมูลให้ถูกต้อง');
	}else{
		var action_url = '?mod=<?php echo LURL::dotPage("action");?>';
		toSubmit(f,'save',action_url);
	}
}

function Confirm(f){
	if(ValidateForm(f)){
		getValueTextEditor('Detail');		
		var firm_url = '?mod=<?php echo LURL::dotPage("action");?>';
		toConfirm(f,'confirm',firm_url);
	}
}// end


function CalSum(numc){
	var total =0;		
	JQ('input[rel=SumCost]').each(function(){
		num = parseFloat(JQ(this).val().replace(/,/g,''));
		if( !isNaN(num)) total = total + num; 
	});
	JQ('#TotalCost').val(Comma(total));
}// end

function Comma(Num){	  
       Num += '';
       Num = Num.replace(/,/g, '');

       x = Num.split('.');
       x1 = x[0];
       x2 = x.length > 1 ? '.' + x[1] : '';
       var rgx = /(\d+)(\d{3})/;
       while (rgx.test(x1))
       x1 = x1.replace(rgx, '$1' + ',' + '$2');
       return x1 + x2;
 } 
</script>


<div class="sysinfo">
  <div class="sysname"><span style="background-color:<?php echo $BGColor; ?>">&nbsp;<?php echo $FormCode; ?>&nbsp;</span>&nbsp;<?php echo $FormName; ?></div>
  <div class="sysdetail"><?php echo $FormDetail; ?> โดยมีเอกสารแนบดังนี้ <div>- <?php echo $FormAttach; ?></div></div>
</div>

<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage("action");?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >

<div id="formView">

<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="CodeId" id="CodeId" value="<?php echo $CodeId;?>" />
<input type="hidden" name="EFormId" id="EFormId" value="<?php echo $EFormId;?>" />
<input type="hidden" name="DocStatusId" id="DocStatusId" value="<?php echo $DocStatusId;?>" />
<input type="hidden" name="DocCode" id="DocCode" value="<?php echo $DocCode; ?>" />
<input type="hidden" name="FormCode" id="FormCode" value="<?php echo $FormCode; ?>" />
<input type="hidden" name="DocCreateBy" id="DocCreateBy" value="<?php echo $CreateBy; ?>" />
<input type="hidden" name="DocCreateDate" id="DocCreateDate" value="<?php echo $CreateDate; ?>" />

<div style="padding-top:10px; padding-bottom:5px"><span class="hint" >กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย</span> <span class="require">*</span></div>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th>เลขที่ สช.น</th>
    <td class="require">&nbsp;</td>
    <td><b><?php echo $DocCode; ?></b></td>
  </tr>
  <tr>
    <th>วันที่เอกสาร</th>
    <td class="require">*</td>
    <td>
<?php 
if($DocDate=="") $DocDate = date('Y-m-d');
echo InputCalendar_text(array(
	'name' => 'DocDate',
	'value' => $DocDate
));	
?> 	
	</td>
  </tr>
  <tr>
    <th>เรื่อง</th>
    <td class="require">*</td>
    <td><input type="text" name="Topic" id="Topic" value="<?php echo ($Topic)?$Topic:$TopicDefault; ?>" style="width:98%;" /></td>
  </tr>   
  
    <tr>
    <th>ชื่อการปฏิบัติงาน</th>
    <td class="require">*</td>
    <td><input type="text" name="Title" id="Title" value="<?php echo ($Title)?$Title:$TopicDefault; ?>" style="width:98%;" /></td>
  </tr>   

   
  <tr>
    <th>เรียน</th>
    <td class="require">*</td>
    <td><input type="text" name="DocTo" id="DocTo" value="<?php echo ($DocTo)?$DocTo:'เลขาธิการคณะกรรมการสุขภาพแห่งชาติ'; ?>" style="width:98%"  />	</td>
  </tr>
  <tr style="vertical-align:top;">
    <th>เอกสารแนบ</th>
    <td class="require">&nbsp;</td>
    <td style="padding:5px;">
<style>
.tbl-list-attach td {
	border:none;
}
</style>
    
<table  width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list-attach">
 <?php 
 $no=1;
$data = $get->getMapAttachList($_REQUEST["FormCode"]);//ltxt::print_r($data);
 if($data){
	foreach($data as $datarow){
		foreach($datarow as $g=>$q){
			${$g} = $q;
		}
		$inputHidden = '';
		$txtCheck = '';
		if($Priority != '1'){
			$hasAttach = $get->getAttachTrue($DocCode,$AttachCode);
			if($hasAttach > 0){
				$txtCheck = ' checked="checked"  ';
			}
		}else{
			$txtCheck = ' checked="checked" disabled="disabled" ';
			$inputHidden = ' <input type="hidden"  name="AttachCode[]" id="AttachCode[]" value="'.$AttachCode.'" />  ';
		}

?>    

    <tr style="vertical-align:top;">
    	<td style="width:18px; text-align:right;" class="require"><?php echo ($Priority=='1')?"*":"&nbsp;"; ?></td>
    	<td style="text-align:center; width:20px;"><input type="checkbox"  name="AttachCode[]" id="AttachCode[]" value="<?php echo $AttachCode; ?>" <?php echo $txtCheck; ?> /><?php echo $inputHidden; ?></td>
        <td><?php echo $AttachName; ?> <span class="hint"><?php echo $AttachDetail; ?><?php //echo ($AttachDetail)?("( ".$AttachDetail." )"):""; ?></span></td>
  	</tr>
    
<?php 
		$no++;
	}
 }
 ?>
</table>
   
    </td>
  </tr>
  <tr>
    <th colspan="3">มีความประสงค์จะ <span class="require">*</span></th>
  </tr>  
  <tr>
    <td  colspan="3">
	<?php
	JFCKeditor::Create(array(
		'ToolbarSets' => 'Mini',
		'name' => 'Detail',
		'id' => 'Detail', 
		'value' => $Detail,
		'height'=>'150',
		'align'=>'left'
	));
	?>	
	</td>
  </tr>
  
  <tr>
    <th>สถานที่ดำเนินการ</th>
    <td class="require">&nbsp;</td>
  	<td><input type="text" name="Location" id="Location" value="<?php echo $Location; ?>" style="width:98%" /></td>
  </tr>
  <tr>
  	<th>จำนวนผู้เข้าร่วมปฏิบัติงาน</th>
    <td class="require">&nbsp;</td>
    <td><input type="text" name="AmountPerson" id="AmountPerson" value="<?php echo $AmountPerson; ?>" style="width:10%;" onkeypress="return validChars(event,2)"  /> <b>คน</b></td>
  </tr> 
  <tr style="vertical-align:top;">
    <th>ระยะเวลาดำเนินการ</th>
    <td class="require">&nbsp;</td>
  	<td>	
	<?php 
		if($StartDate=="") $StartDate = date('Y-m-d');
	  	echo InputCalendar_text(array(
			'id'=> 'StartDate',
			'name' => 'StartDate',
			'value' => $StartDate
		));
		?>
        <b>ถึง</b>    
        <?php 
		if($EndDate=="") $EndDate = date('Y-m-d');
	  	echo InputCalendar_text(array(
			'id' => 'EndDate',
			'name' => 'EndDate',
			'value' => $EndDate
		));
		?> <b>รวมเป็น <span class="require">*</span></b> <input type="text" name="AmountDate" id="AmountDate" value="<?php echo $AmountDate; ?>" style="width:50px; text-align:center;" /> <b>วัน</b>
</td>
  </tr> 
  
       <tr>
    <th colspan="3">รายการค่าใช้จ่าย</th>
  </tr>  
 
<tr>
	<th>ปีงบประมาณ</th>
	<td>&nbsp;</td>
	<td>
<?php echo $BgtYear; ?>
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $BgtYear; ?>"  />
    </td>
</tr>
<tr>
	<th>ชื่อแผนงาน สช.</th>
	<td>&nbsp;</td>
	<td>
	<?php echo $get->getPItemName($BgtYear,$PItemCode); ?>
    <input type="hidden" name="PItemCode" id="PItemCode" value="<?php echo $PItemCode; ?>"  />
    </td>
</tr>
<tr style="vertical-align:top;">
	<th>โครงการ</th>
	<td>&nbsp;</td>
	<td>
	<?php echo $get->getPrjDetailName($PrjDetailId); ?>
    <input type="hidden" name="PrjId" id="PrjId" value="<?php echo $PrjId; ?>"  />
    <input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $PrjDetailId; ?>"  />
    </td>
</tr>
  <tr style="vertical-align:top;">
    <th>กิจกรรม</th>
    <td>&nbsp;</td>
    <td>
	<?php echo $get->getPrjActName($PrjActCode); ?>
    <input type="hidden" name="PrjActCode" id="PrjActCode" value="<?php echo $PrjActCode; ?>"  />
    </td>
  </tr>  
  <tr style="vertical-align:top;">
    <th>แหล่งงบประมาณ</th>
    <td>&nbsp;</td>
    <td>
	<?php echo $get->getSourceExName($SourceExId); ?>
    <input type="hidden" name="SourceExId" id="SourceExId" value="<?php echo $SourceExId; ?>"  />
    </td>
  </tr>   
  
  
  

<tr>
 <td colspan="3">


<!--รายการค่าใช้จ่าย-->



<table width="100%" border="1" class="tbl-list"  cellspacing="1" cellpadding="0">
  <tr>
    <th nowrap="nowrap">หมวดงบ/รายการค่าใช้จ่าย</th>
    <th style="width:80px; text-align:right;">งบตามแผน</th>
    <th style="width:80px; text-align:right;">งบรับโอน</th>
    <th style="width:80px; text-align:right;">งบโอนออก</th>
    <th style="width:100px; text-align:right;">งบแผนรวมโอน</th>
    <th style="width:80px; text-align:right;">งบหลักการ</th>
    <th style="width:80px; text-align:right;">งบผูกพัน</th>
    <th style="width:80px; text-align:right;">งบเบิกจ่าย</th>
    <th style="width:80px; text-align:right;">งบคงเหลือ</th>
  </tr>




  <!--วน loop หมวดงบรายจ่าย-->
  <?php
  $NumCateMonth = 1; 
  $BGCateMonth = $get->getCostTypeRecordSet();
 // ltxt::print_r($BGCateMonth);
  foreach($BGCateMonth as $BGCateMonthRow){ 
  	foreach($BGCateMonthRow as $a=>$b){
		${$a} = $b;
	}
	$SumPlan=$get->getSumPlan($PrjActCode,$SourceExId,$CostTypeId);
	$SumTferIn=$get->getSumTferIn($PrjActCode,$SourceExId,$CostTypeId);
	$SumTferOut=$get->getSumTferOut($PrjActCode,$SourceExId,$CostTypeId);
	$SumPlanNet = $SumPlan+$SumTferIn-$SumTferOut;
	if($SumPlanNet){ //check หมวดงบประมาณ\$SumHold=$get->getSumHold($CostTypeId);
		$SumHold=$get->getSumHold($PrjActCode,$SourceExId,$CostTypeId);
		$SumChain=$get->getSumChain($PrjActCode,$SourceExId,$CostTypeId);
		$SumPay=$get->getSumPay($PrjActCode,$SourceExId,$CostTypeId);
		$SumRemain = $SumPlanNet-$SumHold-$SumChain-$SumPay;
  ?>
  
  <tr class="cate" style="vertical-align:top; font-weight:bold; background-color:#EEE;">
    <td><?php echo $NumCateMonth; ?>. <?php echo $CostTypeName; ?></td>
    <td class="sum-total" title="งบตามแผน"><?php echo ($SumPlan > 0)?number_format($SumPlan,2):"-"; ?></td>
    <td class="sum-total" title="งบรับโอน"><?php echo ($SumTferIn > 0)?number_format($SumTferIn,2):"-"; ?></td>
    <td class="sum-total" title="งบโอนออก"><?php echo ($SumTferOut > 0)?number_format($SumTferOut,2):"-"; ?></td>
    <td class="sum-total" title="งบแผนรวมโอน"><?php echo ($SumPlanNet > 0)?number_format($SumPlanNet,2):"-"; ?></td>
    <td class="sum-total" title="งบหลักการ"><?php echo ($SumHold > 0)?number_format($SumHold,2):"-"; ?></td>
    <td class="sum-total" title="งบผูกพัน"><?php echo ($SumChain > 0)?number_format($SumChain,2):"-"; ?></td>
    <td class="sum-total" title="งบเบิกจ่าย"><?php echo ($SumPay > 0)?number_format($SumPay,2):"-"; ?></td>
    <td class="sum-total" title="งบคงเหลือ"><?php echo ($SumRemain > 0)?number_format($SumRemain,2):"-"; ?></td>
  </tr>
    <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
    <?php
  $NumLevel1 = 1; 
  $BGLevel1 = $get->getCostItemRecordSet($CostTypeId);
 //ltxt::print_r($BGLevel1);
  foreach($BGLevel1 as $BGLevel1Row){ 
  	foreach($BGLevel1Row as $c=>$d){
		${$c} = $d;
	}
	$SumPlan=$get->getSumPlan($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumTferIn=$get->getSumTferIn($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumTferOut=$get->getSumTferOut($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumPlanNet = $SumPlan+$SumTferIn-$SumTferOut;
	if($SumPlanNet){ //check รายการค่าใช้จ่าย level1
		$SumHold=$get->getSumHold($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumChain=$get->getSumChain($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumPay=$get->getSumPay($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumRemain = $SumPlanNet-$SumHold-$SumChain-$SumPay;
  ?>

    <tr class="level1" style="vertical-align:top;">
      <td ><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></td>
      <td class="sum-total" title="งบตามแผน"><?php echo ($SumPlan > 0)?number_format($SumPlan,2):"-"; ?></td>
    <td class="sum-total" title="งบรับโอน"><?php echo ($SumTferIn > 0)?number_format($SumTferIn,2):"-"; ?></td>
    <td class="sum-total" title="งบโอนออก"><?php echo ($SumTferOut > 0)?number_format($SumTferOut,2):"-"; ?></td>
    <td class="sum-total" title="งบแผนรวมโอน"><?php echo ($SumPlanNet > 0)?number_format($SumPlanNet,2):"-"; ?></td>
    <td class="sum-total" title="งบหลักการ"><?php echo ($SumHold > 0)?number_format($SumHold,2):"-"; ?></td>
    <td class="sum-total" title="งบผูกพัน"><?php echo ($SumChain > 0)?number_format($SumChain,2):"-"; ?></td>
    <td class="sum-total" title="งบเบิกจ่าย"><?php echo ($SumPay > 0)?number_format($SumPay,2):"-"; ?></td>
    <td class="sum-total" title="งบคงเหลือ"><?php echo ($SumRemain > 0)?number_format($SumRemain,2):"-"; ?></td>
    </tr>
    
    <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->
    <?php if($HasChild == Y){ ?>
    <!--วน loop รายการงบรายจ่าย ระดับที่ 2-->
    <?php
  $NumLevel2 = 1; 
  $BGLevel2 = $get->getCostItemRecordSet($CostTypeId,2,$CostItemCode);
  foreach($BGLevel2 as $BGLevel2Row){ 
  	foreach($BGLevel2Row as $e=>$f){
		${$e} = $f;
	}
	$SumPlan=$get->getSumPlan($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumTferIn=$get->getSumTferIn($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumTferOut=$get->getSumTferOut($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumPlanNet = $SumPlan+$SumTferIn-$SumTferOut;
	if($SumPlanNet){ //check รายการค่าใช้จ่าย level2
		$SumHold=$get->getSumHold($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumChain=$get->getSumChain($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumPay=$get->getSumPay($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumRemain = $SumPlanNet-$SumHold-$SumChain-$SumPay;
  ?>
 
    <tr class="level2" style="vertical-align:top;">
      <td style="padding-left:15px;"><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></td>
      <td class="sum-total" title="งบตามแผน"><?php echo ($SumPlan > 0)?number_format($SumPlan,2):"-"; ?></td>
    <td class="sum-total" title="งบรับโอน"><?php echo ($SumTferIn > 0)?number_format($SumTferIn,2):"-"; ?></td>
    <td class="sum-total" title="งบโอนออก"><?php echo ($SumTferOut > 0)?number_format($SumTferOut,2):"-"; ?></td>
    <td class="sum-total" title="งบแผนรวมโอน"><?php echo ($SumPlanNet > 0)?number_format($SumPlanNet,2):"-"; ?></td>
    <td class="sum-total" title="งบหลักการ"><?php echo ($SumHold > 0)?number_format($SumHold,2):"-"; ?></td>
    <td class="sum-total" title="งบผูกพัน"><?php echo ($SumChain > 0)?number_format($SumChain,2):"-"; ?></td>
    <td class="sum-total" title="งบเบิกจ่าย"><?php echo ($SumPay > 0)?number_format($SumPay,2):"-"; ?></td>
    <td class="sum-total" title="งบคงเหลือ"><?php echo ($SumRemain > 0)?number_format($SumRemain,2):"-"; ?></td>
    </tr>
<!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->
<?php if($HasChild == Y){ ?>
<!--วน loop รายการงบรายจ่าย ระดับที่ 3-->
<?php
$NumLevel3 = 1; 
$BGLevel3 = $get->getCostItemRecordSet($CostTypeId,3,$CostItemCode);
foreach($BGLevel3 as $BGLevel3Row){ 
	foreach($BGLevel3Row as $g=>$h){
		${$g} = $h;
	}
	$SumPlan=$get->getSumPlan($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumTferIn=$get->getSumTferIn($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumTferOut=$get->getSumTferOut($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
	$SumPlanNet = $SumPlan+$SumTferIn-$SumTferOut;
	if($SumPlanNet){ //check รายการค่าใช้จ่าย level3
		$SumHold=$get->getSumHold($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumChain=$get->getSumChain($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumPay=$get->getSumPay($PrjActCode,$SourceExId,$CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode);
		$SumRemain = $SumPlanNet-$SumHold-$SumChain-$SumPay;
  ?>

    <tr class="level3" style="vertical-align:top;">
      <td style="padding-left:25px;"><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?></td>
      <td class="sum-total" title="งบตามแผน"><?php echo ($SumPlan > 0)?number_format($SumPlan,2):"-"; ?></td>
    <td class="sum-total" title="งบรับโอน"><?php echo ($SumTferIn > 0)?number_format($SumTferIn,2):"-"; ?></td>
    <td class="sum-total" title="งบโอนออก"><?php echo ($SumTferOut > 0)?number_format($SumTferOut,2):"-"; ?></td>
    <td class="sum-total" title="งบแผนรวมโอน"><?php echo ($SumPlanNet > 0)?number_format($SumPlanNet,2):"-"; ?></td>
    <td class="sum-total" title="งบหลักการ"><?php echo ($SumHold > 0)?number_format($SumHold,2):"-"; ?></td>
    <td class="sum-total" title="งบผูกพัน"><?php echo ($SumChain > 0)?number_format($SumChain,2):"-"; ?></td>
    <td class="sum-total" title="งบเบิกจ่าย"><?php echo ($SumPay > 0)?number_format($SumPay,2):"-"; ?></td>
    <td class="sum-total" title="งบคงเหลือ"><?php echo ($SumRemain > 0)?number_format($SumRemain,2):"-"; ?></td>
    </tr>
    <?php 
  $NumLevel3++;
  } ?>
    <!--END วน loop รายการงบรายจ่าย ระดับที่ 3-->
    <?php } ?>
    <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->
    
 
    
    <?php 
  $NumLevel2++;
  } ?>
    <!--END วน loop รายการงบรายจ่าย ระดับที่ 2-->
<?php } //check รายการค่าใช้จ่าย level3?>
     
    
    <?php } ?>
    <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->
<?php } //check รายการค่าใช้จ่าย level2?>    
    

    <?php 
  $NumLevel1++;
  } ?>
    <!--END วน loop รายการงบรายจ่าย ระดับที่ 1-->
<?php } //check รายการค่าใช้จ่าย level1?>

    
  <?php 
  $NumCateMonth++;
  } ?>
<?php } //check หมวดงบประมาณ?>  
  <!--END วน loop หมวดงบรายจ่าย-->
  
<?php
	$SumPlan=$get->getSumPlan($PrjActCode,$SourceExId);
	$SumTferIn=$get->getSumTferIn($PrjActCode,$SourceExId);
	$SumTferOut=$get->getSumTferOut($PrjActCode,$SourceExId);
	$SumPlanNet = $SumPlan+$SumTferIn-$SumTferOut;
	$SumHold=$get->getSumHold($PrjActCode,$SourceExId);
	$SumChain=$get->getSumChain($PrjActCode,$SourceExId);
	$SumPay=$get->getSumPay($PrjActCode,$SourceExId);
	$SumRemain = $SumPlanNet-$SumHold-$SumChain-$SumPay;
?>  
  
  
  
  <tr style="vertical-align:top; font-weight:bold; background-color:#CCC;">
    <td style="text-align:right;">รวมทั้งสิ้น</td>
    <td class="sum-total" title="งบตามแผน"><?php echo ($SumPlan > 0)?number_format($SumPlan,2):"-"; ?></td>
    <td class="sum-total" title="งบรับโอน"><?php echo ($SumTferIn > 0)?number_format($SumTferIn,2):"-"; ?></td>
    <td class="sum-total" title="งบโอนออก"><?php echo ($SumTferOut > 0)?number_format($SumTferOut,2):"-"; ?></td>
    <td class="sum-total" title="งบแผนรวมโอน"><?php echo ($SumPlanNet > 0)?number_format($SumPlanNet,2):"-"; ?></td>
    <td class="sum-total" title="งบหลักการ"><?php echo ($SumHold > 0)?number_format($SumHold,2):"-"; ?></td>
    <td class="sum-total" title="งบผูกพัน"><?php echo ($SumChain > 0)?number_format($SumChain,2):"-"; ?></td>
    <td class="sum-total" title="งบเบิกจ่าย"><?php echo ($SumPay > 0)?number_format($SumPay,2):"-"; ?></td>
    <td class="sum-total" title="งบคงเหลือ"><?php echo ($SumRemain > 0)?number_format($SumRemain,2):"-"; ?></td>
  </tr>
</table>

</td>
</tr>


    <tr>
    <th colspan="3">รายการประมาณการค่าใช้จ่าย</th>
  </tr>  


<tr>
<td colspan="3">
<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list-sub">
<thead>
  		<tr>
    		<td style="width:28%; text-align:center">รายการค่าใช้จ่าย</td>
            <td style="width:28%; text-align:center">รายการชี้แจง</td>
            <td style="width:12%; text-align:center">งบขออนุมัติ</td>
            <td style="width:8%; text-align:center">ปฏิบัติการ</td>
  		</tr>
        </thead>
	</table>
	
<?php 
$costList = $get->getCostItemList($DocCode);//ltxt::print_r($costList);
 if($costList){
     $countc = 1;
        foreach($costList as $rc){
            foreach( $rc as $k=>$v){ ${$k} = $v;}
			$totalSumCost 			=  $totalSumCost+$SumCost;
			$totalBorrowBudget 		=  $totalBorrowBudget+$BorrowBudget;
			$totalBillingBudget		=  $totalBillingBudget+$BillingBudget;
?>    		 
	<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl<?php echo $countc; ?>">
  		<tr>
        <td style="width:28%; text-align:center"><?php echo $get->getCostItemCodeList($CostItemCode); ?></td>
        <td style=" width:28%;text-align:center"><input type="text" name="DetailCost[]"  id="DetailCost<?php echo $countc; ?>" value="<?php echo $DetailCost; ?>" style="width:95%" /></td>
  		<td style="width:12%; text-align:center"><input type="text" name="SumCost[]"  id="SumCost<?php echo $countc; ?>"  rel="SumCost" value="<?php echo number_format($SumCost, 2); ?>"  style="width:95%; text-align:right" onkeypress="return validChars(event,2)" onkeyup="CalSum(<?php echo $countc; ?>);  CheckInputDetail(<?php echo $countc; ?>); javascript:this.value=Comma(this.value);"  /></td>
        <td style="width:8%; text-align:center "><a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php echo $countc; ?>').remove(); CalSum(<?php echo $countc; ?>); }" class="ico delete" >ลบทิ้ง</a></td>
	  </tr>
	</table>
	
<?php				
			$countc++;
		}
	}
?> 	
	
<?php if(!empty($costList)){ $CItemc = $countc; }else{ $CItemc = 1; } ?>

<div id="ListItemsc"></div>

<script>
var CountItemc = <?php echo $CItemc; ?>;

<?php if(empty($costList)){  ?>

JQ(document).ready(function(){
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('add_cost');?>&format=raw&numc=' + CountItemc,
				   success: function(data){
					   CountItemc = CountItemc + 1;
					  JQ('#ListItemsc').append(data);
				   }
			 });	

});
<?php } ?>

function AddItemCost()
{
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('add_cost');?>&format=raw&numc=' + CountItemc,
				   success: function(data){
					   CountItemc = CountItemc + 1;
					  JQ('#ListItemsc').append(data);
				   }
			 });	
}
</script>    

<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
  		<tr>
            <td style="width:56%; text-align:right; font-weight:bold" colspan="5">รวมเป็นค่าใช้จ่ายทั้งสิ้น</td>
            <td style="width:12%; text-align:center">
            <input type="text" name="TotalCost"  id="TotalCost"  rel="TotalCost" value="<?php echo number_format($totalSumCost, 2); ?>"   style="width:95%; text-align:right" readonly="readonly" />
            </td>
			<td style="width:8%; text-align:left; font-weight:bold">บาท</td>
  		</tr>
	</table>    
    
    <div align="right" style="padding-top:4px; padding-bottom:4px" >
    <a href="javascript:void(0);" onclick="AddItemCost();" class="ico add">เพิ่มรายการ...  </a>
    </div>
    



<!--END รายการค่าใช้จ่าย-->


 
</td>
</tr>
 
 <tr>
    <th>ขออนุมัติยืมเงินทดรองเป็นจำนวนเงิน</th>
    <td class="require">&nbsp;</td>
    <td><input type="text" name="TotalBorrow" id="TotalBorrow" style="text-align:right;" value="<?php echo number_format($TotalBorrow,2); ?>" onkeyup="javascript:this.value=Comma(this.value);"  /> <b>บาท</b></td>
  </tr>   

  
    <tr>
    <th colspan="3">ไฟล์เอกสารแนบ</th>
  </tr>  

<tr>
 <td colspan="3">
 <?php
		$MultiDocId =	$get->getFile($DocCode);//ltxt::print_r($MultiDocId);
		FilesManager::LinkFiles(
		array(
			"MaxUploadSize"=> 1,
			"imgWidth"		=>120,
			'imgHeight'		=> 100,
			'UploadType'	=> "multi",
			'FileTypeAllow'	=> "*",
			'ActiveObj'	=> "MultiDocId",
			'ActiveId'	=> $MultiDocId,
			'Category'	=> "ระบบอินทราเน็ต",
			'SubCategory'	=> "แบบฟอร์มอิเล็กทรอนิกส์",		
			'System'		=> "intranet",
			'Module'		=> "eform"
		));
		
?>
  
        
 </td>
 </tr>
 
      <tr>
    <th colspan="3">ข้อมูลผู้ขออนุมัติ</th>
  </tr>  
  <tr>
    <th>ปีงบประมาณ-คำสั่งที่</th>
    <td>&nbsp;</td>
    <td><?php echo $RQOrgRoundCode; ?><input type="hidden" name="RQOrgRoundCode" id="RQOrgRoundCode" value="<?php echo $RQOrgRoundCode; ?>"  /></td>
  </tr>    
  <tr>
    <th>หน่วยงานปฏิบัติงาน</th>
    <td>&nbsp;</td>
    <td><?php echo $get->getOrganizeName($RQOrganizeCode); ?><input type="hidden" name="RQOrganizeCode" id="RQOrganizeCode" value="<?php echo $RQOrganizeCode; ?>"  /></td>
  </tr>  
  <tr>
    <th>ชื่อผู้ปฏิบัติงาน</th>
    <td>&nbsp;</td>
    <td><?php echo $get->fn_getFullNameByPersonalCode($RQPersonalCode); ?><input type="hidden" name="RQPersonalCode" id="RQPersonalCode" value="<?php echo $RQPersonalCode; ?>"  /></td>
  </tr>
  <tr>
    <th>ตำแหน่งปฏิบัติงาน</th>
    <td>&nbsp;</td>
    <td><?php echo $get->getPositionName($RQPositionId); ?><input type="hidden" name="RQPositionId" id="RQPositionId" value="<?php echo $RQPositionId; ?>"  /></td>
  </tr> 
      <tr>
    <th colspan="3">ประวัติการสร้างเอกสาร</th>
  </tr>  
  <tr>
    <th>ผู้สร้างเอกสาร</th>
    <td>&nbsp;</td>
    <td><?php echo $get->getPersonalName($CreateBy); ?> (<?php echo dateFormat($CreateDate); ?>)</td>
  </tr>   
 <?php if($UpdateBy){ ?>  
  <tr>
    <th>ผู้ปรับปรุงเอกสารล่าสุด</th>
    <td>&nbsp;</td>
    <td><?php echo $get->getPersonalName($UpdateBy); ?> (<?php echo dateFormat($UpdateDate); ?>)</td>
  </tr> 
<?php } ?>
 <?php if($StatusName){ ?>
    <tr>
    <th>สถานะเอกสาร</th>
    <td>&nbsp;</td>
    <td><div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div></td>
  </tr>  
<?php } ?>
  <tr>
    <th>&nbsp;</th>
    <td class="require">&nbsp;</td>
    <td>
    <input type="button" class="btnRed" name="save" id="save" value="ตรวจทาน" onclick="Confirm('adminForm');"  />
    <input type="button" value=" ยกเลิก " class="btn" onclick="Cancel('adminForm');" />
    </td>
  </tr>
</table>


</div>
<div id="detailView" style=" display:none"></div>
</form>
<br />
<br />
<br />