<?php
include("config.php");
include("helper.php");
include("data.php");

$info = $get->getDocCodeDetail($_REQUEST["DocCode"]);//ltxt::print_r($info);
foreach($info as $inforow){
	foreach($inforow as $gg=>$qq){
		${$gg} = $qq;
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

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">

  <tr>
    <th>เลขที่ สช.น หลักการ</th>
    <td class="require">&nbsp;</td>
  	<td style="font-weight:bold;"><?php echo $_REQUEST["DocCodeRefer"]; ?></td>
  </tr>
       <tr>
    <th colspan="3">รายละเอียดของเอกสารหลักการที่ใช้อ้างอิง</th>
  </tr>  
<!--ข้อมูลเอกสารหลักการ/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////--> 
<tr>
 <td colspan="3" style="padding:10px;">
<div style="padding:15px; border:1px solid #999; border-radius:20px; background-color:#FFFFFF;">
<?php
$dataRefer = $get->getChainFormDetail($_REQUEST["DocCodeRefer"]);//ltxt::print_r($dataRefer);
foreach($dataRefer as $dataReferrow){
	foreach($dataReferrow as $gg=>$qq){
		${$gg} = $qq;
	}
}
?>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th>เลขที่ สช.น</th>
    <td><?php echo $DocCode; ?></td>
  </tr>
  <tr>
    <th>วันที่เอกสาร</th>
    <td><?php echo ShowDate($DocDate);?></td>
  </tr>
  <tr>
    <th>เรื่อง</th>
    <td><?php echo ($Topic)?$Topic:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>  
    
  <tr style="vertical-align:top;">
    <th>ชื่อการประชุม</th>
    <td><?php echo ($Title)?$Title:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>  
    
  <tr>
    <th>เรียน</th>
    <td><?php echo ($DocTo)?$DocTo:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>
  <tr style="vertical-align:top;">
     <th style="width:80px;">เอกสารแนบ</th>
     <td class="textcolor">
				 <?php 
				$attachList = $get->getAttachList($DocCode);//ltxt::print_r($costList);
				 if($attachList){
						$no = 1;
						foreach($attachList as $at){
							foreach( $at as $att=>$ath){ ${$att} = $ath;}
						?>
						<div><?php if(count($attachList)>1){ echo $no; ?>) <?php } echo $AttachName; ?></div>
						<?php 
							$no++;
						} 
				 }else{
					 echo '<span style="color:#999;">-ไม่ระบุ-</span>';
				 }
				?>    
      </td>
    </tr>
  <tr>
    <th valign="top">มีความประสงค์จะ</th>
    <td valign="top"><?php echo ($Detail)?$Detail:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>
 
<?php if(strtolower($_POST["FormCode"])=="ff002"){ ?> 
     <tr>
	<th>จำนวนผู้เข้าร่วมประชุม/ผู้ร่วมเดินทาง</th>
  	<td><?php echo $AmountPerson; ?> <b>คน</b></td>
  </tr>   
  
    <tr>
    <th>เดินทางไปประเทศจุดหมาย</th>
    <td><?php echo $get->getMasterCountryName($CountryCode);?></td>
  </tr>  

  
  <tr>
    <th>การเดินทาง (ไป)</th>
  	<td>
        <div style="float:left; width:170px;">ออกจากประเทศไทย ตั้งแต่วันที่</div>
        <div style="float:left; width:120px;"><?php echo dateFormat($StartDate1);?></div>
        <div style="float:left; width:115px;">ถึงประเทศจุดหมายวันที่</div>    
        <div style="float:left; width:120px;"><?php echo dateFormat($EndDate1);?></div>
</td>
  </tr> 
  
   <tr>
    <th>การเดินทาง (กลับ)</th>
  	<td>
	<div style="float:left; width:170px;">ออกจากประเทศจุดหมาย ตั้งแต่วันที่</div>
    <div style="float:left; width:120px;"><?php echo dateFormat($StartDate2);?></div>
    <div style="float:left; width:115px;">ถึงประเทศไทยวันที่</div>    
    <div style="float:left; width:120px;"><?php echo dateFormat($EndDate2);?></div>     
</td>
  </tr> 
  
<?php } ?>  
  
       <tr>
    <th colspan="2">รายการค่าใช้จ่าย</th>
  </tr>  
 
<tr>
	<th>ปีงบประมาณ</th>
	<td>
	<?php echo ($BgtYear)?$BgtYear:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?>
    <input type="hidden" name="DocCreateDate" id="DocCreateDate" value="<?php echo $CreateDate; ?>" />
    </td>
</tr>
<tr>
	<th>ชื่อแผนงาน สช.</th>
	<td>
	<?php echo ($PItemCode)?($get->getPItemName($BgtYear,$PItemCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?>
    <input type="hidden" name="PItemCode" id="PItemCode" value="<?php echo $PItemCode; ?>" />
    </td>
</tr>
<tr style="vertical-align:top;">
	<th>โครงการ</th>
	<td>
	<?php echo ($PrjDetailId)?($get->getPrjDetailName($PrjDetailId)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?>
    <input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $PrjDetailId; ?>" />
    <input type="hidden" name="PrjId" id="PrjId" value="<?php echo $PrjId; ?>" />
    </td>
</tr>
  <tr style="vertical-align:top;">
    <th>กิจกรรม</th>
    <td>
	<?php echo ($PrjActCode)?($get->getPrjActName($PrjActCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?>
    <input type="hidden" name="PrjActCode" id="PrjActCode" value="<?php echo $PrjActCode; ?>" />
    </td>
  </tr>  
  <tr style="vertical-align:top;">
    <th>แหล่งงบประมาณ</th>
    <td>
	<?php echo ($SourceExId)?($get->getSourceExName($SourceExId)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?>
    <input type="hidden" name="SourceExId" id="SourceExId" value="<?php echo $SourceExId; ?>" />
    </td>
  </tr>   
<?php 
$TotalBorrowClear 		= $get->getSumSumClear($_REQUEST["DocCodeRefer"],0,$_REQUEST["DocCode"]);//งบเคลียร์ค่าใช้จ่าย
$TotalBorrowRemain 	= $TotalBorrow-$TotalBorrowReturn-$TotalBorrowClear;//งบเบิกเงินยืมทดรองคงเหลือ
$TotalBillingPay 			= $get->getSumSumBilling($_REQUEST["DocCodeRefer"],0,$_REQUEST["DocCode"]);//งบวางบิลเบิกจ่าย
$TotalBillingRemain		= $TotalBilling-$TotalBillingPay;
?>  
   <tr style="font-weight:bold;">
    <th>งบขออนุมัติ</th>
    <td><div style="width:120px; float:left; text-align:right; "><?php echo number_format($TotalCost,2); ?></div>&nbsp;<b>บาท</b></td>
  </tr>   
  <tr style="font-weight:bold;">
    <th>งบเบิกเงินยืมทดรอง</th>
    <td><div style="width:120px; float:left; text-align:right; "><?php echo number_format($TotalBorrow,2); ?></div>&nbsp;<b>บาท</b></td>
  </tr>   
    <tr style="color:#999;">
    <th style="text-align:right; font-weight:normal;">คืนเป็นเงินสด/เงินโอน</th>
    <td><div style="width:120px; float:left; text-align:right; "><?php echo number_format($TotalBorrowReturn,2); ?></div>
    &nbsp;<b>บาท</b></td>
  </tr>   
     <tr style="color:#999;">
    <th style="text-align:right; font-weight:normal;">เคลียร์เป็นค่าใช้จ่าย</th>
    <td><div style="width:120px; float:left; text-align:right; "><?php echo number_format($TotalBorrowClear,2); ?></div>
    &nbsp;<b>บาท</b></td>
  </tr>   
   <tr style="color:#999;">
    <th style="text-align:right; font-weight:normal;">คงเหลือ</th>
    <td><div style="width:120px; float:left; text-align:right; "><?php echo number_format($TotalBorrowRemain,2); ?></div>
    &nbsp;<b>บาท</b></td>
  </tr>   
  <tr style="font-weight:bold;">
    <th>งบขอวางบิลเบิกจ่าย</th>
    <td><div style="width:120px; float:left; text-align:right; "><?php echo number_format($TotalBilling,2); ?></div>
    &nbsp;<b>บาท</b></td>
  </tr>   
      <tr style="color:#999;">
    <th style="text-align:right; font-weight:normal;">งบวางบิลเบิกจ่ายแล้ว</th>
    <td><div style="width:120px; float:left; text-align:right; "><?php echo number_format($TotalBillingPay,2); ?></div>
    &nbsp;<b>บาท</b></td>
  </tr>   
   <tr style="color:#999;">
    <th style="text-align:right; font-weight:normal;">คงเหลือ</th>
    <td>
    <div style="width:120px; float:left; text-align:right; background-color:#FFC; color:#990000; "><?php echo number_format($TotalBillingRemain,2); ?></div>
    &nbsp;<b>บาท</b>
    <input type="hidden" name="TotalBillingRemain" id="TotalBillingRemain" value="<?php echo $TotalBillingRemain; ?>" />
    </td>
  </tr>  

  
  



    <tr>
    <th colspan="2">รายการประมาณการค่าใช้จ่าย</th>
  </tr>  


<tr>
<td colspan="2">



<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list-sub">
<thead>
  		<tr>
  		  <td style="text-align:center; width:30px;">ลำดับ</td>
    		<td  style="text-align:center;">รายการค่าใช้จ่าย/รายการชี้แจง</td>
    		<td  style="width:100px; text-align:right;">งบขออนุมัติ</td>
    		<td  style="width:120px; text-align:right;">งบเคลียร์ค่าใช้จ่าย</td>
    		<td  style="width:120px; text-align:right;">งบวางบิลเบิกจ่าย</td>
    		<td  style="width:120px; text-align:right;">งบคงเหลือ</td>
            <td  style="width:50px;">&nbsp;</td>
  		</tr>            
</thead>        
<?php 
$sumTotalCost 			= 0;
$sumTotalChain 			= 0; 
$sumTotalRemain 		= 0;
$gCostItemCode = $get->getImpCostItemCodeChain($DocCode);//ltxt::print_r($gCostItemCode);
$dataCost = $get->getHoldCostDetail($DocCode);//ltxt::print_r($dataCost);
$m=0;
if($gCostItemCode[0]->CostItemCode){
	foreach($gCostItemCode as $gCostItemCoderow){
		foreach($gCostItemCoderow as $gg=>$qq){	${$gg} = $qq;	}
		$sumRFSumCost 			= $get->getSumSumCostChain($_REQUEST["DocCodeRefer"],$CostItemCode);//งบขออนุมัติ 
		$sumRFSumClear 		= $get->getSumSumClear($_REQUEST["DocCodeRefer"],$CostItemCode,$_REQUEST["DocCode"]);//งบเคลียร์ค่าใช้จ่าย
		$sumRFSumBill 			= $get->getSumSumBilling($_REQUEST["DocCodeRefer"],$CostItemCode,$_REQUEST["DocCode"]);//งบวางบิลเบิกจ่าย
		$sumRFSumRemain		= $sumRFSumCost-($sumRFSumClear+$sumRFSumBill);//งบคงเหลือ
		
		$TotalRFSumCost 			= $sumRFTotalCost+$sumRFSumCost;
		$TotalRFSumClear 			= $sumRFTotalChain+$sumRFSumClear; 
		$TotalRFSumBill 				= $sumRFTotalRemain+$sumRFSumBill;
		$TotalRFSumRemain 		= $sumRFTotalRemain+$sumRFSumRemain;
?>
<tr style="font-weight:bold;">
  <td style="text-align:center;"><?php echo ($m+1); ?></td>
	<td ><?php echo $get->getCostItemName($CostItemCode);?></td>
	<td  style="text-align:right;" ><?php echo number_format($sumRFSumCost,2);?></td>
	<td  style="text-align:right;" ><?php echo number_format($sumRFSumClear,2);?></td>
	<td  style="text-align:right;" >	<?php echo number_format($sumRFSumBill,2);?></td>
	<td  style="text-align:right;" >
	<?php echo number_format($sumRFSumRemain,2);?>
    <input type="hidden" name="ReferSumRemain[<?php echo $CostItemCode; ?>]" id="ReferSumRemain[<?php echo $CostItemCode; ?>]" value="<?php echo $sumRFSumRemain; ?>" />
    </td>
        <td  style="text-align:right" >&nbsp;</td> 
</tr>
<?php
	for($i=0; $i<count($dataCost);$i++){
		if($dataCost[$i]->DetailCost != ""){
			if($dataCost[$i]->CostItemCode == $CostItemCode){
?>
        <tr>
          <td >&nbsp;</td>
        <td >- <?php echo $dataCost[$i]->DetailCost;?></td>
        <td  style="text-align:right;" ><?php echo number_format($dataCost[$i]->SumCost,2);?></td>
        <td  style="text-align:right;" >-</td>
        <td  style="text-align:right;" >-</td>
        <td  style="text-align:right;" >-</td>
        <td  style="text-align:right;" >&nbsp;</td>        
        </tr>
<?php 
				}
			}
		} 
		$m++;
	}
}
?>
<?php 
if($gCostItemCode[0]->CostItemCode){
?>
          <tr style="font-weight:bold;">
            <td style="text-align:right;">&nbsp;</td>
            <td style="text-align:right;">รวมเป็นค่าใช้จ่ายทั้งสิ้น</td>
            <td  style="text-align:right;" ><?php echo number_format($TotalRFSumCost,2);?></td>
            <td  style="text-align:right;" ><?php echo number_format($TotalRFSumClear,2);?></td>
            <td  style="text-align:right;" ><?php echo number_format($TotalRFSumBill,2);?></td>
            <td  style="text-align:right;" ><?php echo number_format($TotalRFSumRemain,2);?></td>
            <td >บาท</td>
  		</tr>
<?php }else{ ?>     
	<tr>
    	<td colspan="7" style="text-align:center; color:#999;">-ไม่พบรายการ-</td>
    </tr> 
<?php } ?>        
	</table>    



<!--END รายการค่าใช้จ่าย-->


 
</td>
</tr>



    <tr>
    <th colspan="2">ไฟล์เอกสารแนบ</th>
  </tr>  

<tr>
 <td colspan="2">
<?php  
$MultiDocId =	$get->getFile($DocCode);//ltxt::print_r($MultiDocId);
if($MultiDocId){
	FilesManager::LinkFilesView(array(
			'ActiveObj' => 'MultiDocId',
			'ViewType' => 'multi',
			'ActiveId' => $MultiDocId
	));
}else{
		echo '<div style="text-align:center; color:#999;">-ไม่พบรายการ-</div>';	
}
?>  
</td>
</tr>




  <tr>
    <th colspan="2">ข้อมูลผู้ขออนุมัติ</th>
  </tr>  
  <tr>
    <th>ปีงบประมาณ-คำสั่งที่</th>
    <td><?php echo ($RQOrgRoundCode)?$RQOrgRoundCode:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>    
  <tr>
    <th>หน่วยงานปฏิบัติงาน</th>
    <td><?php echo ($RQOrganizeCode)?($get->getOrganizeName($RQOrganizeCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>  
  <tr>
    <th>ชื่อผู้ปฏิบัติงาน</th>
    <td><?php echo ($RQPersonalCode)?($get->fn_getFullNameByPersonalCode($RQPersonalCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>
  <tr>
    <th>ตำแหน่งปฏิบัติงาน</th>
    <td><?php echo ($RQPositionId)?($get->getPositionName($RQPositionId)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr> 
    <tr>
    <th colspan="2">ประวัติการสร้างเอกสาร</th>
  </tr>  
  <tr>
    <th>ผู้สร้างเอกสาร</th>
    <td><?php echo ($CreateBy)?($get->getPersonalName($CreateBy)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?> (<?php echo ($CreateDate)?(dateFormat($CreateDate)):'<span style="color:#999;">-</span>'; ?>)</td>
  </tr>    
  <tr>
    <th>ผู้ปรับปรุงเอกสารล่าสุด</th>
    <td><?php echo ($UpdateBy)?($get->getPersonalName($UpdateBy)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?> (<?php echo ($UpdateDate)?(dateFormat($UpdateDate)):'<span style="color:#999;">-</span>'; ?>)</td>
  </tr> 
    <tr>
    <th>สถานะเอกสาร</th>
    <td><div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div></td>
  </tr>  
</table>

</div><!--End div radius-->
</td>
</tr>
<!--END ข้อมูลเอกสารหลักการ/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////--> 

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
?> 	
	</td>
  </tr>
  <tr>
    <th>เรื่อง</th>
    <td class="require">*</td>
    <td><input type="text" name="Topic" id="Topic" value="<?php echo ($Topic)?$Topic:$TopicDefault; ?>" style="width:98%;" /></td>
  </tr>   
  
    <tr>
    <th>ชื่อการประชุม</th>
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
		?> <b>รวมเป็น <span class="require">*</span></b> <input type="text" name="AmountDate" id="AmountDate" value="<?php echo $AmountDate; ?>" style="width:50px; text-align:center;" /> <b>วัน</b>
</td>
  </tr> 

    <tr>
    <th colspan="3">รายการค่าใช้จ่ายที่ต้องการวางบิลเบิกจ่าย <span class="hint" style="font-weight:normal;">(ต้องไม่เกินยอดงบขออนุมัติคงเหลือของแต่ละรายการค่าใช้จ่ายที่ได้ขออนุมัติวางบิลไว้)</span></th>
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
    <th colspan="3">รายการค่าใช้จ่ายที่ต้องการเบิกจ่าย โดยไม่ได้ขออนุมัติไว้ก่อน <span class="hint" style="font-weight:normal;">(กรณีไม่ขออนุมัติไว้ก่อน โดยสามารถทำการขอเบิกจ่ายได้ครั้งละไม่เกิน 20,000 / สองหมื่นบาท)</span></th>
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
$costListOther = $get->getOtherCostItemList($DocCode);//ltxt::print_r($costListOther);
 if($costListOther){
     $countcOther = 1;
        foreach($costListOther as $rc){
            foreach( $rc as $k=>$v){ ${$k} = $v;}
			$totalOtherSumCost 	=  $totalOtherSumCost+$OtherSumCost;
?>    		 
	<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl<?php echo $countcOther; ?>_other">
  		<tr>
        <td style="width:28%; text-align:center"><?php echo $get->getOtherCostItemCodeList($_REQUEST["DocCodeRefer"],$CostItemCode); ?></td>
        <td style=" width:28%;text-align:center"><input type="text" name="OtherDetailCost[]"  id="OtherDetailCost<?php echo $countcOther; ?>" value="<?php echo $OtherDetailCost; ?>" style="width:95%" /></td>
  		<td style="width:12%; text-align:center"><input type="text" name="OtherSumCost[]"  id="OtherSumCost<?php echo $countcOther; ?>"  rel="OtherSumCost" value="<?php echo number_format($OtherSumCost,2); ?>"  style="width:95%; text-align:right" onkeypress="return validChars(event,2)" onkeyup="CalSumOther(<?php echo $countcOther; ?>);  CheckInputDetailOther(<?php echo $countcOther; ?>); javascript:this.value=Comma(this.value);"  /></td>
        <td style="width:8%; text-align:center "><a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php echo $countcOther; ?>_other').remove(); CalSumOther(<?php echo $countcOther; ?>); }" class="ico delete" >ลบทิ้ง</a></td>
	  </tr>
	</table>
	
<?php				
			$countcOther++;
		}
	}
?> 	
	
<?php if(!empty($costListOther)){ $CItemcOther = $countcOther; }else{ $CItemcOther = 1; } ?>

<div id="ListItemscOther"></div>

<script>
var CountItemcOther = <?php echo $CItemcOther; ?>;

<?php if(empty($costListOther)){  ?>

JQ(document).ready(function(){
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('add_cost_other');?>&format=raw&DocCodeRefer=<?php echo $_REQUEST["DocCodeRefer"]; ?>&othnumc=' + CountItemcOther,
				   success: function(data){
					   CountItemcOther = CountItemcOther + 1;
					  JQ('#ListItemscOther').append(data);
				   }
			 });	

});
<?php } ?>

function AddItemCostOther(){
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('add_cost_other');?>&format=raw&DocCodeRefer=<?php echo $_REQUEST["DocCodeRefer"]; ?>&othnumc=' + CountItemcOther,
				   success: function(data){
					   CountItemcOther = CountItemcOther + 1;
					  JQ('#ListItemscOther').append(data);
				   }
			 });	
}
</script>    

<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
  		<tr>
            <td style="width:56%; text-align:right; font-weight:bold" colspan="5">รวมเป็นค่าใช้จ่ายทั้งสิ้น</td>
            <td style="width:12%; text-align:center">
            <input type="text" name="TotalCostOther"  id="TotalCostOther"  rel="TotalCostOther" value="<?php echo number_format($totalOtherSumCost, 2); ?>"   style="width:95%; text-align:right" readonly="readonly" />
            </td>
			<td style="width:8%; text-align:left; font-weight:bold">บาท</td>
  		</tr>
	</table>    
    
    <div align="right" style="padding-top:4px; padding-bottom:4px" >
    <a href="javascript:void(0);" onclick="AddItemCostOther();" class="ico add">เพิ่มรายการ...  </a>
    </div>
    



<!--END รายการค่าใช้จ่าย-->


 
</td>
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