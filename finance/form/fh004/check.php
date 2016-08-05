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
		'text' => 'ระบบงบประมาณการเงิน',
	),
	array(
		'text' => 'ตรวจสอบเอกสารการเงิน',
		'link' => '?mod=finance.form.list_approve'
	),
	array(
		'text' => "บันทึกผลการตรวจสอบ",
	),
));


?>

<script language="javascript" type="text/javascript">
function editDocument(FormCode,DocCode){
	window.location.href="?mod=front.form.checkin&FormCode="+FormCode+"&DocCode="+DocCode;
}
function printDocument(){
	window.location.href="?mod=<?php echo LURL::dotPage('print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}
function saveToWord(){
	window.location.href="?mod=<?php echo LURL::dotPage('word')?>&format=raw<?php echo $get->getQueryString(); ?>";
}
function saveAttachFile(FormCode,DocCode){
	window.location.href="?mod=<?php echo LURL::dotPage('attach')?>&FormCode="+FormCode+"&DocCode="+DocCode;
}
</script>


<div class="sysinfo">
  <div class="sysname"><span style="background-color:<?php echo $BGColor; ?>">&nbsp;<?php echo $FormCode; ?>&nbsp;</span>&nbsp;<?php echo $FormName; ?></div>
  <div class="sysdetail"><?php echo $FormDetail; ?> โดยมีเอกสารแนบดังนี้ <div>- <?php echo $FormAttach; ?></div></div>
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" onClick="goPage('?mod=finance.form.list_check')" /></td>
  </tr>
</table>



<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th>เลขที่ สช.น</th>
    <td><b><?php echo $DocCode; ?></b></td>
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
    <th>ชื่อการปฏิบัติงาน</th>
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
  
  
  
  
  
  <tr>
    <th colspan="2">รายละเอียดการขอเบิกค่ารักษาพยาบาล</th>
  </tr>
 
 
 <?php
$person = $get->getArrayRelateData($RQPersonalCode);//ltxt::print_r($person);
$truePerson1 = $get->checkPayPerson($DocCode,7);
$truePerson2 = $get->checkPayPerson($DocCode,1);
$truePerson3 = $get->checkPayPerson($DocCode,2);
$truePerson4 = $get->checkPayPerson($DocCode,3);
$truePerson5 = $get->checkPayPerson($DocCode,4);
$truePerson6 = $get->checkPayPerson($DocCode,5);
$truePerson7 = $get->checkPayPerson($DocCode,6);
?>    

 
  
    <tr>
    <td colspan="2" style="padding:10px;">
 <style>
 .blog-relate {
	padding:10px; 
	border:1px solid #999; 
	border-radius:10px; 
	background-color:#CCC; 
	margin-bottom:10px;
 }
 </style>   
 <!--กรณีข้าพเจ้า-->   
 <div class="blog-relate" <?php if(!$truePerson1){ ?> style="display:none;" <?php } ?>>
 <?php $RPay = $get->getRelateDocCode($DocCode,7); //ltxt::print_r($RPay); ?>
 <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
   <tr>
    <th colspan="2" style="background-color:#9CC;">กรณีข้าพเจ้า</th>
  </tr>
  <tr>
    <th>ป่วยเป็นโรค</th>
    <td><?php echo $RPay[0]->Disease; ?></td>
  </tr>
    <tr>
    <th>ชื่อสถานพยาบาล</th>
    <td>
<?php 
switch($RPay[0]->HospitalType){
	case "affair":
		echo "ทางราชการ";
		break;
	case "private":
		echo "เอกชน";
		break;
}
echo " <b>ระบุ</b> ".$RPay[0]->HospitalName; 
?>    
</td>
  </tr>
    <tr style="vertical-align:top;">
    <th>ตั้งแต่วันที่</th>
  	<td><?php echo dateFormat($RPay[0]->OPDStartDate); ?><b> ถึง </b><?php echo dateFormat($RPay[0]->OPDEndDate); ?></td>
  </tr> 
</table>
 </div>
 <!--END กรณีข้าพเจ้า-->      
 
 
 <!--กรณีคู่สมรส-->
<div class="blog-relate" <?php if(!$truePerson2){ ?> style="display:none;" <?php } ?>>
 <?php
$RPay = $get->getRelateDocCode($DocCode,1);//ltxt::print_r($RPay);
?>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
 <tr>
    <th colspan="2" style="background-color:#9CC;">กรณีคู่สมรส</th>
  </tr>
  <tr>
    <th>ชื่อ-นามสกุล</th>
    <td><?php echo $RPay[0]->FullName; ?></td>
  </tr>
  <tr>
    <th>ป่วยเป็นโรค</th>
    <td><?php echo $RPay[0]->Disease; ?></td>
  </tr>
    <tr>
    <th>ชื่อสถานพยาบาล</th>
    <td>
<?php 
switch($RPay[0]->HospitalType){
	case "affair":
		echo "ทางราชการ";
		break;
	case "private":
		echo "เอกชน";
		break;
}
echo " <b>ระบุ</b> ".$RPay[0]->HospitalName; 
?>    
</td>
  </tr>
    <tr style="vertical-align:top;">
    <th>ตั้งแต่วันที่</th>
  	<td><?php echo dateFormat($RPay[0]->OPDStartDate); ?><b> ถึง </b><?php echo dateFormat($RPay[0]->OPDEndDate); ?></td>
  </tr> 
</table>
 </div>
 <!--END กรณีคู่สมรส-->      
 
 
 <!--กรณีบิดา--> 
<div class="blog-relate" <?php if(!$truePerson3){ ?> style="display:none;" <?php } ?>>
 <?php
$RPay = $get->getRelateDocCode($DocCode,2);//ltxt::print_r($RPay);
?>

 <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
 <tr>
    <th colspan="2" style="background-color:#9CC;">กรณีบิดา</th>
  </tr>
  <tr>
    <th>ชื่อ-นามสกุล</th>
    <td><?php echo $RPay[0]->FullName; ?></td>
  </tr>
  <tr>
    <th>ป่วยเป็นโรค</th>
    <td><?php echo $RPay[0]->Disease; ?></td>
  </tr>
    <tr>
    <th>ชื่อสถานพยาบาล</th>
    <td>
<?php 
switch($RPay[0]->HospitalType){
	case "affair":
		echo "ทางราชการ";
		break;
	case "private":
		echo "เอกชน";
		break;
}
echo " <b>ระบุ</b> ".$RPay[0]->HospitalName; 
?>    
</td>
  </tr>
    <tr style="vertical-align:top;">
    <th>ตั้งแต่วันที่</th>
  	<td><?php echo dateFormat($RPay[0]->OPDStartDate); ?><b> ถึง </b><?php echo dateFormat($RPay[0]->OPDEndDate); ?></td>
  </tr> 
</table>
 </div>
 <!--END กรณีบิดา-->      
 
 
 <!--กรณีมารดา--> 
<div class="blog-relate" <?php if(!$truePerson4){ ?> style="display:none;" <?php } ?>>
 <?php
$RPay = $get->getRelateDocCode($DocCode,3);//ltxt::print_r($RPay);
?>

 <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
 <tr>
    <th colspan="2" style="background-color:#9CC;">กรณีมารดา</th>
  </tr>
  <tr>
    <th>ชื่อ-นามสกุล</th>
    <td><?php echo $RPay[0]->FullName; ?></td>
  </tr>
  <tr>
    <th>ป่วยเป็นโรค</th>
    <td><?php echo $RPay[0]->Disease; ?></td>
  </tr>
    <tr>
    <th>ชื่อสถานพยาบาล</th>
    <td>
<?php 
switch($RPay[0]->HospitalType){
	case "affair":
		echo "ทางราชการ";
		break;
	case "private":
		echo "เอกชน";
		break;
}
echo " <b>ระบุ</b> ".$RPay[0]->HospitalName; 
?>    
</td>
  </tr>
    <tr style="vertical-align:top;">
    <th>ตั้งแต่วันที่</th>
  	<td><?php echo dateFormat($RPay[0]->OPDStartDate); ?><b> ถึง </b><?php echo dateFormat($RPay[0]->OPDEndDate); ?></td>
  </tr> 
</table>
 </div>
 <!--END กรณีมารดา-->      
 
 <!--กรณีบุตรคนที่ 1-->   
 <div class="blog-relate" <?php if(!$truePerson5){ ?> style="display:none; "<?php } ?>>
<?php
$RPay = $get->getRelateDocCode($DocCode,4);//ltxt::print_r($RPay);
?>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
    <th colspan="2" style="background-color:#9CC;">กรณีบุตรคนที่ 1</th>
  </tr>
  <tr>
    <th>ชื่อ-นามสกุล</th>
    <td><?php echo $RPay[0]->FullName; ?></td>
  </tr>
    <tr>
  	<th>เกิดเมื่อ</th>
    <td><?php echo dateFormat($RPay[0]->BirthDay); ?> <b>อายุ</b> <?php echo $RPay[0]->Age; ?> <b>ปี</b></td>
 </tr>
  <tr>
  	<th>&nbsp;</th>
    <td>
      
  <div style="padding-top:5px; padding-bottom:5px;">    
  <?php 
$tc=1;
$tchild = $get->getChildTypeList();//ltxt::print_r($data);
foreach($tchild as $tchildrow){
	foreach($tchildrow as $gg=>$qq){
		${$gg} = $qq;
	}
	$trueTChildId = $get->getTrueTChildId($RPay[0]->PPersonId,$TChildId);
?>    
  <input type="checkbox"  <?php if($trueTChildId){ ?> checked="checked" <?php } ?> disabled="disabled" />&nbsp;<?php echo $TChildName; ?>&nbsp;&nbsp;
  <?php 
	if($tc%3==0){
		echo '</div><div style="padding-bottom:5px;">';
	}
	$tc++;
 }
 ?>   
    </div>   
      
    </td>
 </tr> 
  <tr>
    <th>ป่วยเป็นโรค</th>
    <td><?php echo $RPay[0]->Disease; ?></td>
  </tr>
    <tr>
    <th>ชื่อสถานพยาบาล</th>
    <td>
<?php 
switch($RPay[0]->HospitalType){
	case "affair":
		echo "ทางราชการ";
		break;
	case "private":
		echo "เอกชน";
		break;
}
echo " <b>ระบุ</b> ".$RPay[0]->HospitalName; 
?>    
</td>
  </tr>
    <tr style="vertical-align:top;">
    <th>ตั้งแต่วันที่</th>
  	<td><?php echo dateFormat($RPay[0]->OPDStartDate); ?><b> ถึง </b><?php echo dateFormat($RPay[0]->OPDEndDate); ?></td>
  </tr> 
</table>
 </div>
 <!--END กรณีบุตรคนที่ 1-->      
 
 
  <!--กรณีบุตรคนที่ 2-->   
 <div class="blog-relate" <?php if(!$truePerson6){ ?> style="display:none; "<?php } ?>>
 <?php
$RPay = $get->getRelateDocCode($DocCode,5);//ltxt::print_r($RPay);
?>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
    <th colspan="3" style="background-color:#9CC;">กรณีบุตรคนที่ 2</th>
  </tr>
  <tr>
    <th>ชื่อ-นามสกุล</th>
    <td class="require">&nbsp;</td>
    <td><?php echo $RPay[0]->FullName; ?></td>
  </tr>
    <tr>
  	<th>เกิดเมื่อ</th>
    <td class="require">&nbsp;</td>
    <td>
<?php echo dateFormat($RPay[0]->BirthDay); ?> <b>อายุ</b> <?php echo $RPay[0]->Age; ?> <b>ปี</b>
	</td>
 </tr>
  <tr>
  	<th>&nbsp;</th>
    <td class="require">&nbsp;</td>
  	<td>
    
<div style="padding-top:5px; padding-bottom:5px;">    
<?php 
$tc=1;
$tchild = $get->getChildTypeList();//ltxt::print_r($data);
foreach($tchild as $tchildrow){
	foreach($tchildrow as $gg=>$qq){
		${$gg} = $qq;
	}
	$trueTChildId = $get->getTrueTChildId($RPay[0]->PPersonId,$TChildId);
?>    
<input type="checkbox"  <?php if($trueTChildId){ ?> checked="checked" <?php } ?> disabled="disabled" />&nbsp;<?php echo $TChildName; ?>&nbsp;&nbsp;
<?php 
	if($tc%3==0){
		echo '</div><div style="padding-bottom:5px;">';
	}
	$tc++;
 }
 ?>   
 </div>   
    
    </td>
 </tr> 
  <tr>
    <th>ป่วยเป็นโรค</th>
    <td><?php echo $RPay[0]->Disease; ?></td>
  </tr>
    <tr>
    <th>ชื่อสถานพยาบาล</th>
    <td>
<?php 
switch($RPay[0]->HospitalType){
	case "affair":
		echo "ทางราชการ";
		break;
	case "private":
		echo "เอกชน";
		break;
}
echo " <b>ระบุ</b> ".$RPay[0]->HospitalName; 
?>    
</td>
  </tr>
    <tr style="vertical-align:top;">
    <th>ตั้งแต่วันที่</th>
  	<td><?php echo dateFormat($RPay[0]->OPDStartDate); ?><b> ถึง </b><?php echo dateFormat($RPay[0]->OPDEndDate); ?></td>
  </tr> 
</table>
 </div>
 <!--END กรณีบุตรคนที่ 2-->      
 
 
 
   <!--กรณีบุตรคนที่ 3-->   
 <div class="blog-relate" style="margin-bottom:0px; <?php if(!$truePerson7){ ?> display:none; <?php } ?>">
  <?php $RPay = $get->getRelateDocCode($DocCode,6); //ltxt::print_r($RPay); ?>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
    <th colspan="2" style="background-color:#9CC;">กรณีบุตรคนที่ 3</th>
  </tr>
  <tr>
    <th>ชื่อ-นามสกุล</th>
    <td><?php echo $RPay[0]->FullName; ?></td>
  </tr>
    <tr>
  	<th>เกิดเมื่อ</th>
    <td><?php echo dateFormat($_POST["BirthDay5Per3"]); ?> <b>อายุ</b> <?php echo $_POST["Age5Per3"]; ?> <b>ปี</b></td>
 </tr>
  <tr>
  	<th>&nbsp;</th>
    <td>
      
  <div style="padding-top:5px; padding-bottom:5px;">    
  <?php 
$tc=1;
$tchild = $get->getChildTypeList();//ltxt::print_r($data);
foreach($tchild as $tchildrow){
	foreach($tchildrow as $gg=>$qq){
		${$gg} = $qq;
	}
	$trueTChildId = $get->getTrueTChildId($RPay[0]->PPersonId,$TChildId);
?>    
  <input type="checkbox"  <?php if($trueTChildId){ ?> checked="checked" <?php } ?> disabled="disabled" />&nbsp;<?php echo $TChildName; ?>&nbsp;&nbsp;
  <?php 
	if($tc%3==0){
		echo '</div><div style="padding-bottom:5px;">';
	}
	$tc++;
 }
 ?>   
    </div>   
      
    </td>
 </tr> 
  <tr>
    <th>ป่วยเป็นโรค</th>
    <td><?php echo $RPay[0]->Disease; ?></td>
  </tr>
    <tr>
    <th>ชื่อสถานพยาบาล</th>
    <td>
<?php 
switch($RPay[0]->HospitalType){
	case "affair":
		echo "ทางราชการ";
		break;
	case "private":
		echo "เอกชน";
		break;
}
echo " <b>ระบุ</b> ".$RPay[0]->HospitalName; 
?>    
</td>
  </tr>
    <tr style="vertical-align:top;">
    <th>ตั้งแต่วันที่</th>
  	<td><?php echo dateFormat($RPay[0]->OPDStartDate); ?><b> ถึง </b><?php echo dateFormat($RPay[0]->OPDEndDate); ?></td>
  </tr> 
</table>
 </div>
 <!--END กรณีบุตรคนที่ 3-->      

 
 
 
    </td>
	</tr>  
  
  
  
  
  
  

       <tr>
    <th colspan="2">รายการค่าใช้จ่าย</th>
  </tr>  
 
<tr>
	<th>ปีงบประมาณ</th>
	<td><?php echo ($BgtYear)?$BgtYear:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr>
	<th>ชื่อแผนงาน สช.</th>
	<td><?php echo ($PItemCode)?($get->getPItemName($BgtYear,$PItemCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
	<th>โครงการ</th>
	<td><?php echo ($PrjDetailId)?($get->getPrjDetailName($PrjDetailId)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
  <tr style="vertical-align:top;">
    <th>กิจกรรม</th>
    <td><?php echo ($PrjActCode)?($get->getPrjActName($PrjActCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>  
  <tr style="vertical-align:top;">
    <th>แหล่งงบประมาณ</th>
    <td><?php echo ($SourceExId)?($get->getSourceExName($SourceExId)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>   
  
  
  



  
  
<?php $BGWelfareRemain	= $BGWelfare-$BGWelfarePay; ?>  
    <tr>
    <th>สวัสดิการค่ารักษาพยาบาล</th>
    <td><div style="width:100px; float:left; text-align:right;"><?php echo number_format($BGWelfare,2); ?></div>&nbsp;<b>บาท/ปี</b></td>
  </tr>  
    <tr>
    <th>เบิกจ่ายแล้ว</th>
    <td><div style="width:100px; float:left; text-align:right;"><?php echo number_format($BGWelfarePay,2); ?></div>&nbsp;<b>บาท</b></td>
  </tr>  
    <tr>
    <th>คงเหลือ</th>
    <td ><div style="width:100px; float:left; text-align:right;"><?php echo number_format($BGWelfareRemain,2); ?></div>&nbsp;<b>บาท</b></td>
  </tr>  
  <tr>
    <th>จำนวนใบเสร็จรับเงิน</th>
    <td><div style="width:100px; float:left; text-align:right;"><?php echo $AmountBill; ?></div>&nbsp;<b>ฉบับ</b></td>
  </tr>
  
  


<tr>
<td colspan="2">



<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list-sub">
<thead>
  		<tr>
  		  <td style="text-align:center; width:30px;">ลำดับ</td>
    		<td  style="text-align:center;">รายการค่าใช้จ่าย/รายการชี้แจง</td>
            <td  style="width:100px; text-align:right;">งบขออนุมัติ</td>
            <td  style="width:50px;">&nbsp;</td>
  		</tr>            
</thead>        
<?php 
$gCostItemCode = $get->getImpCostItemCode($DocCode);//ltxt::print_r($gCostItemCode);
$dataCost = $get->getCostDetail($DocCode);//ltxt::print_r($dataCost);
$m=0;
if($gCostItemCode[0]->CostItemCode){
	foreach($gCostItemCode as $gCostItemCoderow){
		foreach($gCostItemCoderow as $gg=>$qq){	${$gg} = $qq;	}
		$sumSumCost 			= $get->getSumSumCost($DocCode,$CostItemCode);
?>
<tr style="font-weight:bold;">
  <td style="text-align:center;"><?php echo ($m+1); ?></td>
	<td ><?php echo $get->getCostItemName($CostItemCode);?></td>
	<td  style="text-align:right;" ><?php echo number_format($sumSumCost,2);?></td>
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
            <td  style="text-align:right;" ><?php echo number_format($TotalCost,2);?></td>
            <td >บาท</td>
  		</tr>
<?php }else{ ?>     
	<tr>
    	<td colspan="4" style="text-align:center; color:#999;">-ไม่พบรายการ-</td>
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

<?php if($PayNo){ ?>
  <tr>
    <th colspan="2" style="background-color:#9CC;">ข้อมูลการตรวจสอบสิทธิ์</th>
  </tr>
     <tr>
    <td colspan="2" style="padding:10px;">
 <style>
 .blog-relate {
	padding:10px; 
	border:1px solid #999; 
	border-radius:10px; 
	background-color:#CCC; 
	margin-bottom:10px;
 }
 </style>  
 <div class="blog-relate" style="margin-bottom:0px;">
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view"> 
    <tr>
    <th>เป็นการเบิกครั้งที่</th>
    <td><b><?php echo ($PayNo)?($PayNo."/".$BgtYear):"-ไม่ระบุ-";  ?></b></td>
  </tr> 
  <tr>
    <th>วันที่ตรวจสอบสิทธิ</th>
    <td><?php echo dateFormat($CKDate); ?></td>
  </tr>  
 <tr>
    <th>ปีงบประมาณ-คำสั่งที่</th>
    <td><?php echo $CKOrgRoundCode; ?></td>
    </tr>    
  <tr>
    <th>หน่วยงานผู้ตรวจสอบสิทธิ</th>
    <td><?php echo $get->getOrganizeName($CKOrganizeCode); ?></td>
    </tr>  
  <tr>
    <th>ชื่อผู้ตรวจสอบสิทธิ</th>
    <td><?php echo $get->fn_getFullNameByPersonalCode($CKPersonalCode); ?></td>
    </tr>
  <tr>
    <th>ตำแหน่งผู้ตรวจสอบสิทธิ</th>
    <td><?php echo $get->getPositionName($CKPositionId); ?></td>
    </tr>
  <tr style="vertical-align:top;">
    <th>หมายเหตุ</th>
    <td><?php echo ($CKComment)?$CKComment:"-ไม่ระบุ-"; ?></td>
  </tr> 
  </table>
</div> 
 
 </td>
 </tr> 
<?php } ?>  
  
  
  
  
</table>


<script language="javascript" type="text/javascript">
function Save(f){
	jConfirmQ('บันทึกผลการตรจสอบเอกสารใช่หรือไม่?', 'ยืนยันการดำเนินการ', function(r) {
			if(r){ 
				var action_url = '?mod=<?php echo LURL::dotPage("action");?>';
				toSubmit(f,'check',action_url);
			}
	});
}
</script>
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage("action");?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="DocCode" id="DocCode" value="<?php echo $DocCode; ?>" />
<input type="hidden" name="EFormId" id="EFormId" value="<?php echo $EFormId; ?>" />
<input type="hidden" name="FormCode" id="FormCode" value="<?php echo $FormCode; ?>" />

<div style="padding:10px; border:1px solid #999; background-color:#EEE;">
<div style="padding-bottom:10px; font-weight:bold; font-size:14pt;">บันทึกผลการตรวจสอบเอกสาร :</div>
<div>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view"> 
   <tr>
    <th>ผลการตรวจสอบ</th>
    <td>
      <input name="DocStatusId" type="radio" value="3" checked="checked" /> ผ่านการตรวจสอบ
      <input name="DocStatusId" type="radio" value="4" /> <span style="color:#FF0000">ตีกลับเอกสาร</span>
    </td>
  </tr>   
  <tr>
    <th style="vertical-align:top;">หมายเหตุ</th>
    <td><textarea name="Comment"  style="width:99%; height:100px;"></textarea></td>
  </tr> 
  <tr>
 <th colspan="2">แนบไฟล์</th>
</tr>
<tr>
 <td colspan="2">
 <?php
		FilesManager::LinkFiles(
		array(
			"MaxUploadSize"=> 1,
			"imgWidth"		=>120,
			'imgHeight'		=> 100,
			'UploadType'	=> "multi",
			'FileTypeAllow'	=> "*",
			'ActiveObj'	=> "MultiDocId",
			'ActiveId'	=> "",
			'Category'	=> "ระบบนโยบายแผนงาน",
			'SubCategory'	=> "ระบบการเงิน",		
			'System'		=> "backoffice",
			'Module'		=> "finance"
		));
?>
 </td>
 </tr> 
 <tr>
    <th>ผู้ตรวจสอบ</th>
    <td><?php echo $_SESSION["Session_FullName"]; ?></td>
  </tr>
   <tr>
    <th>วันที่ตรวจสอบ</th>
    <td><?php echo dateformat(date('Y-m-d'));?></td>
  </tr>   
   
    </table>


</div>

</div>


<div style="padding:15px; text-align:center;">
	<input type="button" class="btnActive" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
    <input type="button" class="btn" name="button" id="button" value=" ยกเลิก " onClick="goPage('?mod=finance.form.list_check')" />
</div>



</form>

<div style="text-align:right; padding:4px; margin-top:10px;"><a href="#" class="icon-up">กลับสู่ด้านบน</a></div>

