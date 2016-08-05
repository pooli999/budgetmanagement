<?php
include("config.php");
include("helper.php");
include("data.php");


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
			jAlert('กรุณากรอกช่องชื่อการประชุม',function(){
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
		return true;
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

function CalSumOther(numc){
	var total =0;		
	JQ('input[rel=OtherSumCost]').each(function(){
		num = parseFloat(JQ(this).val().replace(/,/g,''));
		if( !isNaN(num)) total = total + num; 
	});
	JQ('#TotalCostOther').val(Comma(total));
}// end

function CheckInputDetail(id){
	
	/*if(JQ('#CostItemCode'+id).val() == ""){
		jAlert('กรุณาระบุรายการค่าใช้จ่าย','ระบบตรวจสอบข้อมูล',function(){
			JQ('#CostItemCode'+id).focus();
			JQ('#SumCost'+id).val(0);
			CalSum(id);
		});
		return false;
	}// end

	if(JQ('#DetailCost'+id).val() == ""){
		jAlert('กรุณาระบุรายการชี้แจง','ระบบตรวจสอบข้อมูล',function(){
			JQ('#DetailCost'+id).focus();
			JQ('#SumCost'+id).val(0);
			CalSum(id);
		});
		return false;
	}// end	*/
	
}// end


function CheckInputDetailOther(id){
	
	/*if(JQ('#CostItemCode'+id).val() == ""){
		jAlert('กรุณาระบุรายการค่าใช้จ่าย','ระบบตรวจสอบข้อมูล',function(){
			JQ('#CostItemCode'+id).focus();
			JQ('#SumCost'+id).val(0);
			CalSum(id);
		});
		return false;
	}// end

	if(JQ('#DetailCost'+id).val() == ""){
		jAlert('กรุณาระบุรายการชี้แจง','ระบบตรวจสอบข้อมูล',function(){
			JQ('#DetailCost'+id).focus();
			JQ('#SumCost'+id).val(0);
			CalSum(id);
		});
		return false;
	}// end	*/
	
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


<div style="padding-top:10px; padding-bottom:5px"><span class="hint" >กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย</span> <span class="require">*</span></div>


<?php
$dataRefer = $get->getChainFormDetail($_REQUEST["DocCodeRefer"]);//ltxt::print_r($dataRefer);
foreach($dataRefer as $dataReferrow){
	foreach($dataReferrow as $gg=>$qq){
		${$gg} = $qq;
	}
}
$BorrowCode = $get->getBorrowCode($_REQUEST["DocCodeRefer"]);
$ReferTopic = $Topic;
$ReferTitle = $Title;
?>
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $BgtYear; ?>" />
<input type="hidden" name="PItemCode" id="PItemCode" value="<?php echo $PItemCode; ?>" />
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $PrjDetailId; ?>" />
<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $PrjId; ?>" />
<input type="hidden" name="PrjActCode" id="PrjActCode" value="<?php echo $PrjActCode; ?>" />
<input type="hidden" name="SourceExId" id="SourceExId" value="<?php echo $SourceExId; ?>" />
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th>เลขที่สัญญายืมเงิน</th>
    <td class="require">&nbsp;</td>
  	<td style="font-weight:bold;">
	<?php echo $BorrowCode; ?>
	<input type="hidden" name="BorrowCode" id="BorrowCode" value="<?php echo $BorrowCode; ?>" /></td>
  </tr>
  <tr>
    <th>เลขที่เอกสารขอเบิกเงินยืมทดรอง</th>
    <td class="require">&nbsp;</td>
  	<td style="font-weight:bold;"><a href="#"><?php echo $_REQUEST["DocCodeRefer"]; ?></a></td>
  </tr>
       <tr>
    <th colspan="3">รายการเคลียร์เงินยืมทดรองจ่าย</th>
  </tr>  

<tr>
 <td colspan="3" style="padding:10px;">

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
<td colspan="2">



<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list-sub">
<thead>
  		<tr>
  		  <td style="text-align:center; width:50px;">ครั้งที่</td>
  		  <td  style="text-align:center; width:100px;">วันที่เคลียร์</td>
    		<td  style="text-align:center;">รายการ</td>
    		<td  style="width:150px; text-align:right;">เคลียร์เป็นเงินสด/เงินโอน</td>
    		<td  style="width:120px; text-align:right;">เคลียร์ค่าใช้จ่าย</td>
    		<td  style="width:120px; text-align:right;">รวมทั้งสิ้น</td>
    		<td  style="width:50px;">&nbsp;</td>
  		</tr>            
</thead> 
<?php
$m=0;
$itemClear = $get->getItemClear($BorrowCode,$_REQUEST["DocCode"]);//ltxt::print_r($itemClear);
foreach($itemClear as $itemClearRow){
	foreach($itemClearRow as $cc=>$dd){
		${$cc} = $dd;
	}
	$TotalClear = $ReturnCost+$TotalCost;//ยอดรวมทั้งสิ้น
	
?>       
<tr>
  <td style="text-align:center;"><?php echo ($m+1); ?></td>
  <td style="text-align:center;"><?php echo ShowDate($DocDate); ?></td>
	<td ><?php echo $DocCode; ?>&nbsp;<?php echo $Title; ?></td>
	<td  style="text-align:right;" ><?php echo number_format($ReturnCost,2);?></td>
	<td  style="text-align:right;" ><?php echo number_format($TotalCost,2);?></td>
	<td  style="text-align:right;" >	<?php echo number_format($TotalClear,2);?></td>
	<td  style="text-align:right" >&nbsp;</td> 
</tr>
<?php 
	$m++;
} 
?>
<?php if(!count($itemClear)){ ?>     
	<tr>
    	<td colspan="7" style="text-align:center; color:#999;">-ไม่พบรายการ-</td>
    </tr> 
<?php } ?>        
<?php 
$BGBorrow 	= $get->getSumBGBorrow($_REQUEST["DocCodeRefer"]);
$BGClearReturn 	= $get->getSumBGClearReturn($_REQUEST["DocCodeRefer"]);
$BGClearPay 	= $get->getSumBGClearPay($_REQUEST["DocCodeRefer"]);
$SumTotalClearRemain = $BGBorrow-$BGClearReturn-$BGClearPay;
?>
<tr style="font-weight:bold;">
            <td colspan="5" style="text-align:right;">ยอดเงินยืมทดรอง</td>
            <td  style="text-align:right;" ><?php echo number_format($BGBorrow,2);?></td>
            <td >บาท</td>
</tr>
<tr style="font-weight:bold;">
            <td colspan="5" style="text-align:right;">ยอดเคลียร์เป็นเงินสด/เงินโอน</td>
            <td  style="text-align:right;" ><?php echo number_format($BGClearReturn,2);?></td>
            <td >บาท</td>
</tr>
<tr style="font-weight:bold;">
            <td colspan="5" style="text-align:right;">ยอดเคลียร์ค่าใช้จ่าย</td>
            <td  style="text-align:right;" ><?php echo number_format($BGClearPay,2);?></td>
            <td >บาท</td>
</tr>
<tr style="font-weight:bold;">
            <td colspan="5" style="text-align:right;">ยอดเงินยืมทดรองคงเหลือ</td>
            <td  style="text-align:right; color:#FF0000;" ><?php echo ($SumTotalClearRemain>0)?(number_format($SumTotalClearRemain,2)):"-";?></td>
            <td >บาท</td>
</tr>
</table></td>
</tr>
</table></td>
</tr>

<?php
unset($CodeId,$EFormId,$DocStatusId,$DocCode,$FormCode,$DocCreateBy,$DocCreateDate);
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


?>


<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="CodeId" id="CodeId" value="<?php echo $CodeId;?>" />
<input type="hidden" name="EFormId" id="EFormId" value="<?php echo $EFormId;?>" />
<input type="hidden" name="DocStatusId" id="DocStatusId" value="<?php echo $DocStatusId;?>" />
<input type="hidden" name="DocCodeRefer" id="DocCodeRefer" value="<?php echo $_REQUEST["DocCodeRefer"]; ?>" />
<input type="hidden" name="DocCode" id="DocCode" value="<?php echo $DocCode; ?>" />
<input type="hidden" name="FormCode" id="FormCode" value="<?php echo $FormCode; ?>" />
<input type="hidden" name="DocCreateBy" id="DocCreateBy" value="<?php echo $CreateBy; ?>" />
<input type="hidden" name="DocCreateDate" id="DocCreateDate" value="<?php echo $CreateDate; ?>" />



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
?>	</td>
  </tr>
  <tr>
    <th>เรื่อง</th>
    <td class="require">*</td>
    <td><input type="text" name="Topic" id="Topic" value="<?php echo ($Topic)?$Topic:$ReferTopic; ?>" style="width:98%;" /></td>
  </tr>   
  
    <tr>
    <th>ชื่อการประชุม</th>
    <td class="require">*</td>
    <td><input type="text" name="Title" id="Title" value="<?php echo ($Title)?$Title:$ReferTitle; ?>" style="width:98%;" /></td>
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
</table>    </td>
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
	?>	</td>
  </tr>
  
  <tr>
    <th>สถานที่ดำเนินการ</th>
    <td class="require">&nbsp;</td>
  	<td><input type="text" name="Location" id="Location" value="<?php echo $Location; ?>" style="width:98%" /></td>
  </tr>
  <tr>
  	<th>จำนวนผู้เข้าร่วมประชุม</th>
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
		?> <b>รวมเป็น <span class="require">*</span></b> <input type="text" name="AmountDate" id="AmountDate" value="<?php echo $AmountDate; ?>" style="width:50px; text-align:center;" /> <b>วัน</b></td>
  </tr> 



   <tr>
     <th colspan="3" style="color:#FF0000; font-size:16px;">
     <input type="checkbox" name="ClearLastNo" id="ClearLastNo" value="Y" <?php if($ClearLastNo == "Y"){ ?> checked="checked" <?php } ?> /> เป็นการเคลียร์ครั้งสุดท้าย
     <span class="hint" style="font-weight:normal;">(กรุณาทำเครื่องหมายใน check box เพื่อให้ระบบทำการสรุปยอดงบเคลียร์เงินยืมทดรองทั้งหมด)</span>     </th>
   </tr>
   <tr>
    <th>(กรณี) เคลียร์เป็น</th>
    <td>&nbsp;</td>
    <td>
<input type="radio" name="ClearType" value="cash" <?php if(!$ClearType || ($ClearType=="cash")){ ?> checked="checked" <?php } ?> />เงินสด    
<input type="radio" name="ClearType" value="transfer" <?php if($ClearType=="transfer"){ ?> checked="checked" <?php } ?> />เงินโอน
<b>จำนวน</b> <input type="text" name="ReturnCost" id="ReturnCost" value="<?php echo $ReturnCost; ?>" style="width:100px; text-align:center;" onkeypress="return validChars(event,2)"  /> <b>บาท</b>    </td>
  </tr>  
  
  
    <tr>
    <th colspan="3">(กรณี) เคลียร์เป็นค่าใช้จ่าย</th>
  </tr>  
  

<tr>
<td colspan="3">
<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list-sub">
<thead>
  		<tr>
    		<td style="width:28%; text-align:center">รายการค่าใช้จ่าย</td>
            <td style="width:28%; text-align:center">รายการชี้แจง</td>
            <td style="width:12%; text-align:center">งบเคลียร์ค่าใช้จ่าย</td>
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
        <td style="width:28%; text-align:center"><?php echo $get->getCostItemCodeList($_REQUEST["DocCodeRefer"],$CostItemCode); ?></td>
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
				   url: '?mod=<?php echo LURL::dotPage('add_cost');?>&format=raw&DocCodeRefer=<?php echo $_REQUEST["DocCodeRefer"]; ?>&numc=' + CountItemc,
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
				   url: '?mod=<?php echo LURL::dotPage('add_cost');?>&format=raw&DocCodeRefer=<?php echo $_REQUEST["DocCodeRefer"]; ?>&numc=' + CountItemc,
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
            <input type="text" name="TotalCost"  id="TotalCost"  rel="TotalCost" value="<?php echo number_format($totalSumCost, 2); ?>"   style="width:95%; text-align:right" readonly="readonly" />            </td>
			<td style="width:8%; text-align:left; font-weight:bold">บาท</td>
  		</tr>
	</table>    
    
    <div align="right" style="padding-top:4px; padding-bottom:4px" >
    <a href="javascript:void(0);" onclick="AddItemCost();" class="ico add">เพิ่มรายการ...  </a>    </div>
    



<!--END รายการค่าใช้จ่าย--></td>
</tr>









 
 <tr>
    <th>เบิกเพิ่มเป็น</th>
    <td>&nbsp;</td>
    <td>
<input type="radio" name="PlusType" value="cash" <?php if(!$PlusType || ($PlusType=="cash")){ ?> checked="checked" <?php } ?> />เงินสด    
<input type="radio" name="PlusType" value="transfer" <?php if($PlusType=="transfer"){ ?> checked="checked" <?php } ?> />เงินโอน
<span class="hint">(กรณีเป็นการเคลียร์เงินยืมทดรองจ่ายครั้งสุดท้าย แล้วมียอดงบที่ต้องเบิกจ่ายเพิ่ม)</span>    </td>
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
		
?> </td>
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
    <input type="button" value=" ยกเลิก " class="btn" onclick="Cancel('adminForm');" />    </td>
  </tr>
</table>


</div>
<div id="detailView" style=" display:none"></div>
</form>
<br />
<br />
<br />