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

?>
<style type="text/css">
	td {
		font-family:"TH SarabunPSK";
		font-size:16pt; 
	}

	.textcolor{ color:#06C; }
	.textmain{ font-size:20pt; font-weight:bold;}
	.textid{ font-size:14pt; }
	.textname{ font-size:14pt; font-weight:bold;}
	.textadd{ font-size:12pt; }
</style>

<style type="text/css" media="print">
	td {
		font-family:"TH SarabunPSK";
		font-size:17pt; 
	}
	.textcolor{ color:#333; }
	.textmain{ font-size:25pt; font-weight:bold;}
	.textid{ font-size:17pt; }
	.textname{ font-size:17pt;  font-weight:bold;}
	.textadd{ font-size:15pt; }	
    .print{ display:none; }
</style>


<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td  valign="top">

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="right" valign="top" ><span class="textid"><?php echo $FormCodeAlias; ?></span></td>
  </tr>
</table>



<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr>
    <td colspan="2" style="text-align:center; font-weight:bold; padding-bottom:20px;">
    ใบเบิกเงินสวัสดิการเกี่ยวกับการบริการสาธารณสุข สำนักงานคณะกรรมการสุขภาพแห่งชาติ (สช.)
    <div style="font-weight:normal;">โปรดทำเครื่องหมาย / ลงในช่อง [&nbsp;] พร้อมทั้งกรอกข้อความเท่าที่จำเป็น</div>
    </td>
    </tr>
  <tr>
    <td width="50%" >ที่ สช.น. <span class="textcolor"><?php echo $DocCode; ?></span>&nbsp;</td>
    <td width="50%" >วันที่ <span class="textcolor"><?php echo ShowDateLong($DocDate);?></span>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"  style="text-align:justify; border:1px solid #999; padding:20px;">
<b>1. ข้าพเจ้า</b> <span class="textcolor"><?php echo $get->fn_getFullNameByPersonalCode($RQPersonalCode); ?></span> 
ตำแหน่ง <span class="textcolor"><?php echo ($RQPositionId)?($get->getPositionName($RQPositionId)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></span>
สังกัดสำนัก/กลุ่ม/ศูนย์ <span class="textcolor"><?php echo ($RQOrganizeCode)?($get->getOrganizeName($RQOrganizeCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></span> 
สำนักงานคณะกรรมการสุขภาพแห่งชาติ (สช.) เป็นผู้มีสิทธิ์ได้รับเงินสวัสดิการเกี่ยวกับบริการสาธารณสุขตามระเบียบสำนักงานคณะกรรมการสุขภาพแห่งชาติ ว่าด้วยการรับบริการสาธารณสุข การประกันภัย และเงินช่วยเหลือกรณีพนักงานถึงแก่กรรม พ.ศ. 2552 ( ฉบับที่ 2 พ.ศ. 2556 เมื่อวันที่ 15 พฤศจิกายน 2556 ตามสิทธิไม่เกิน 80,000 บาท/ปี )
</td>
  </tr>
  
    <tr>
    <td colspan="2"  style="text-align:justify; border:1px solid #999; padding:20px;">
<b>2. ขอเบิกเงินค่าบริการสาธารณสุข ของ</b>
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

 <style>
 .blog-relate {
	margin-bottom:10px;
 }
 </style>   
 <!--กรณีข้าพเจ้า-->   
 <div class="blog-relate" <?php if(!$truePerson1){ ?> style="display:none;" <?php } ?>>
 <?php $RPay = $get->getRelateDocCode($DocCode,7); //ltxt::print_r($RPay); ?>
<div style="padding-left:15px;">
	<div>
    [/] ข้าพเจ้า
    โดยป่วยเป็นโรค <span class="textcolor"><?php echo $RPay[0]->Disease; ?></span>
    </div>
   <div style="padding-left:20px;">
   และไปรับบริการสาธารณสุข ซึ่งเป็นสถานพยาบาลของ 
    <span class="textcolor">
    <?php 
	switch($RPay[0]->HospitalType){
		case "affair":
			echo "ทางราชการ";
			break;
		case "private":
			echo "เอกชน";
			break;
	}
	?> </span>  
    ชื่อ <span class="textcolor"><?php echo $RPay[0]->HospitalName; ?></span>
    </div>
    <div style="padding-left:20px;">
	ตั้งแต่วันที่ <span class="textcolor"><?php echo dateFormat($RPay[0]->OPDStartDate); ?></span> ถึง <span class="textcolor"><?php echo dateFormat($RPay[0]->OPDEndDate); ?></span>
    </div>
</div>
 </div>
 <!--END กรณีข้าพเจ้า-->      
 
 
 <!--กรณีคู่สมรส-->
<div class="blog-relate" <?php if(!$truePerson2){ ?> style="display:none;" <?php } ?>>
<?php $RPay = $get->getRelateDocCode($DocCode,1);//ltxt::print_r($RPay) ?>
<div style="padding-left:15px;">
	<div>
    [/] คู่สมรสที่มีการจัดทะเบียนสมรส ชื่อ <span class="textcolor"><?php echo $RPay[0]->FullName; ?></span> 
    โดยป่วยเป็นโรค <span class="textcolor"><?php echo $RPay[0]->Disease; ?></span>
    </div>
   <div style="padding-left:20px;">
   และไปรับบริการสาธารณสุข ซึ่งเป็นสถานพยาบาลของ 
    <span class="textcolor">
    <?php 
	switch($RPay[0]->HospitalType){
		case "affair":
			echo "ทางราชการ";
			break;
		case "private":
			echo "เอกชน";
			break;
	}
	?> </span>  
    ชื่อ <span class="textcolor"><?php echo $RPay[0]->HospitalName; ?></span>
	</div>
    <div style="padding-left:20px;">
	ตั้งแต่วันที่ <span class="textcolor"><?php echo dateFormat($RPay[0]->OPDStartDate); ?></span> ถึง <span class="textcolor"><?php echo dateFormat($RPay[0]->OPDEndDate); ?></span>
    </div>
</div>
 </div>
 <!--END กรณีคู่สมรส-->      
 
 
 <!--กรณีบิดา--> 
<div class="blog-relate" <?php if(!$truePerson3){ ?> style="display:none;" <?php } ?>>
 <?php $RPay = $get->getRelateDocCode($DocCode,2);//ltxt::print_r($RPay); ?>
<div style="padding-left:15px;">
	<div>
    [/] บิดาของข้าพเจ้าตามสำเนาทะเบียนบ้าน ชื่อ <span class="textcolor"><?php echo $RPay[0]->FullName; ?></span> 
    โดยป่วยเป็นโรค <span class="textcolor"><?php echo $RPay[0]->Disease; ?></span>
    </div>
   <div style="padding-left:20px;">
   และไปรับบริการสาธารณสุข ซึ่งเป็นสถานพยาบาลของ 
    <span class="textcolor">
    <?php 
	switch($RPay[0]->HospitalType){
		case "affair":
			echo "ทางราชการ";
			break;
		case "private":
			echo "เอกชน";
			break;
	}
	?> </span>  
    ชื่อ <span class="textcolor"><?php echo $RPay[0]->HospitalName; ?></span>
	</div>
    <div style="padding-left:20px;">
	ตั้งแต่วันที่ <span class="textcolor"><?php echo dateFormat($RPay[0]->OPDStartDate); ?></span> ถึง <span class="textcolor"><?php echo dateFormat($RPay[0]->OPDEndDate); ?></span>
    </div>
</div>
 </div>
 <!--END กรณีบิดา-->      
 
 
 <!--กรณีมารดา--> 
<div class="blog-relate" <?php if(!$truePerson4){ ?> style="display:none;" <?php } ?>>
 <?php $RPay = $get->getRelateDocCode($DocCode,3);//ltxt::print_r($RPay); ?>
<div style="padding-left:15px;">
	<div>
    [/] มารดาของข้าพเจ้าตามสำเนาทะเบียนบ้าน ชื่อ <span class="textcolor"><?php echo $RPay[0]->FullName; ?></span> 
    โดยป่วยเป็นโรค <span class="textcolor"><?php echo $RPay[0]->Disease; ?></span>
    </div>
   <div style="padding-left:20px;">
   และไปรับบริการสาธารณสุข ซึ่งเป็นสถานพยาบาลของ 
    <span class="textcolor">
    <?php 
	switch($RPay[0]->HospitalType){
		case "affair":
			echo "ทางราชการ";
			break;
		case "private":
			echo "เอกชน";
			break;
	}
	?> </span>  
    ชื่อ <span class="textcolor"><?php echo $RPay[0]->HospitalName; ?></span>
	</div>
    <div style="padding-left:20px;">
	ตั้งแต่วันที่ <span class="textcolor"><?php echo dateFormat($RPay[0]->OPDStartDate); ?></span> ถึง <span class="textcolor"><?php echo dateFormat($RPay[0]->OPDEndDate); ?></span>
    </div>
</div>
 </div>
 <!--END กรณีมารดา-->      
 
 <!--กรณีบุตรคนที่ 1-->   
 <div class="blog-relate" <?php if(!$truePerson5){ ?> style="display:none; "<?php } ?>>
<?php $RPay = $get->getRelateDocCode($DocCode,4);//ltxt::print_r($RPay); ?>
<div style="padding-left:15px;">
	<div>
    [/] บุตรของข้าพเจ้าคนที่ 1 ชื่อ <span class="textcolor"><?php echo $RPay[0]->FullName; ?></span> 
    เกิดเมื่อ <span class="textcolor"><?php echo $RPay[0]->BirthDay; ?></span> อายุ <span class="textcolor"><?php echo $RPay[0]->Age; ?></span>
    </div>
    
  <div style="padding-left:20px;">
  <?php 
$tc=1;
$tchild = $get->getChildTypeList();//ltxt::print_r($data);
foreach($tchild as $tchildrow){
	foreach($tchildrow as $gg=>$qq){
		${$gg} = $qq;
	}
	$trueTChildId = $get->getTrueTChildId($RPay[0]->PPersonId,$TChildId);
?>    
  [ <?php if($trueTChildId){ echo "/"; }else{ echo "-"; } ?> ]&nbsp;<?php echo $TChildName; ?>&nbsp;&nbsp;
  <?php 
	if($tc%3==0){
		echo '<br>';
	}
	$tc++;
 }
 ?>   
    </div>   
    <div style="padding-left:20px;">
    โดยป่วยเป็นโรค <span class="textcolor"><?php echo $RPay[0]->Disease; ?></span> และไปรับบริการสาธารณสุข ซึ่งเป็นสถานพยาบาลของ 
    <span class="textcolor">
    <?php 
	switch($RPay[0]->HospitalType){
		case "affair":
			echo "ทางราชการ";
			break;
		case "private":
			echo "เอกชน";
			break;
	}
	?> </span>  
    ชื่อ <span class="textcolor"><?php echo $RPay[0]->HospitalName; ?></span>
	</div>
    <div style="padding-left:20px;">
	ตั้งแต่วันที่ <span class="textcolor"><?php echo dateFormat($RPay[0]->OPDStartDate); ?></span> ถึง <span class="textcolor"><?php echo dateFormat($RPay[0]->OPDEndDate); ?></span>
    </div>
</div>
 </div>
 <!--END กรณีบุตรคนที่ 1-->      
 
 
  <!--กรณีบุตรคนที่ 2-->   
 <div class="blog-relate" <?php if(!$truePerson6){ ?> style="display:none; "<?php } ?>>
<?php $RPay = $get->getRelateDocCode($DocCode,5);//ltxt::print_r($RPay); ?>
<div style="padding-left:15px;">
	<div>
    [/] บุตรของข้าพเจ้าคนที่ 2 ชื่อ <span class="textcolor"><?php echo $RPay[0]->FullName; ?></span> 
    เกิดเมื่อ <span class="textcolor"><?php echo $RPay[0]->BirthDay; ?></span> อายุ <span class="textcolor"><?php echo $RPay[0]->Age; ?></span>
    </div>
    
  <div style="padding-left:20px;">
  <?php 
$tc=1;
$tchild = $get->getChildTypeList();//ltxt::print_r($data);
foreach($tchild as $tchildrow){
	foreach($tchildrow as $gg=>$qq){
		${$gg} = $qq;
	}
	$trueTChildId = $get->getTrueTChildId($RPay[0]->PPersonId,$TChildId);
?>    
  [ <?php if($trueTChildId){ echo " / "; }else{ echo " - "; } ?> ]&nbsp;<?php echo $TChildName; ?>&nbsp;&nbsp;
  <?php 
	if($tc%3==0){
		echo '<br>';
	}
	$tc++;
 }
 ?>   
    </div>   
    <div style="padding-left:20px;">
    โดยป่วยเป็นโรค <span class="textcolor"><?php echo $RPay[0]->Disease; ?></span> และไปรับบริการสาธารณสุข ซึ่งเป็นสถานพยาบาลของ 
    <span class="textcolor">
    <?php 
	switch($RPay[0]->HospitalType){
		case "affair":
			echo "ทางราชการ";
			break;
		case "private":
			echo "เอกชน";
			break;
	}
	?> </span>  
    ชื่อ <span class="textcolor"><?php echo $RPay[0]->HospitalName; ?></span>
	</div>
    <div style="padding-left:20px;">
	ตั้งแต่วันที่ <span class="textcolor"><?php echo dateFormat($RPay[0]->OPDStartDate); ?></span> ถึง <span class="textcolor"><?php echo dateFormat($RPay[0]->OPDEndDate); ?></span>
    </div>
</div>
 </div>
 <!--END กรณีบุตรคนที่ 2-->      
 
 
 
   <!--กรณีบุตรคนที่ 3-->   
 <div class="blog-relate" <?php if(!$truePerson7){ ?> style="display:none; " <?php } ?>>
<?php $RPay = $get->getRelateDocCode($DocCode,6);//ltxt::print_r($RPay); ?>
<div style="padding-left:15px;">
	<div>
    [/] บุตรของข้าพเจ้าคนที่ 3 ชื่อ <span class="textcolor"><?php echo $RPay[0]->FullName; ?></span> 
    เกิดเมื่อ <span class="textcolor"><?php echo $RPay[0]->BirthDay; ?></span> อายุ <span class="textcolor"><?php echo $RPay[0]->Age; ?></span>
    </div>
    
  <div style="padding-left:20px;">
  <?php 
$tc=1;
$tchild = $get->getChildTypeList();//ltxt::print_r($data);
foreach($tchild as $tchildrow){
	foreach($tchildrow as $gg=>$qq){
		${$gg} = $qq;
	}
	$trueTChildId = $get->getTrueTChildId($RPay[0]->PPersonId,$TChildId);
?>    
  [ <?php if($trueTChildId){ echo " / "; }else{ echo " - "; } ?> ]&nbsp;<?php echo $TChildName; ?>&nbsp;&nbsp;
  <?php 
	if($tc%3==0){
		echo '<br>';
	}
	$tc++;
 }
 ?>   
    </div>   
    <div style="padding-left:20px;">
    โดยป่วยเป็นโรค <span class="textcolor"><?php echo $RPay[0]->Disease; ?></span> และไปรับบริการสาธารณสุข ซึ่งเป็นสถานพยาบาลของ 
    <span class="textcolor">
    <?php 
	switch($RPay[0]->HospitalType){
		case "affair":
			echo "ทางราชการ";
			break;
		case "private":
			echo "เอกชน";
			break;
	}
	?> </span>  
    ชื่อ <span class="textcolor"><?php echo $RPay[0]->HospitalName; ?></span>
	</div>
    <div style="padding-left:20px;">
	ตั้งแต่วันที่ <span class="textcolor"><?php echo dateFormat($RPay[0]->OPDStartDate); ?></span> ถึง <span class="textcolor"><?php echo dateFormat($RPay[0]->OPDEndDate); ?></span>
    </div>
</div>
 </div>
 <!--END กรณีบุตรคนที่ 3-->      

<div style="padding-left:20px; font-size:14pt; margin-bottom:10px; color:#999;">
    <div><i>หมายเหตุ :</i></div>
    <div>- <i>กรณีเป็นทางราชการ มีสิทธิเบิกได้ทั้งประเภทผู้ป่วยใน และผู้ป่วยนอกตามจำนวนที่ได้จ่ายจริง ทั้งนี้ ไม่เกินอัตราที่กระทรวงการคลังกำหนด</i></div>
    <div>- <i>กรณีเป็นเอกชน สิทธิเฉพาะบุคคลภายในครอบครัว มีสิทธิเบิกได้เฉพาะกรณีประเภทผู้ป่วยนอก โดยให้เบิกได้ครึ่งหนึ่งของที่ได้จ่ายจริง แต่ไม่เกินหนึ่งพันบาทต่อครั้ง , สิทธิเฉพาะตนเอง มีสิทธิเบิกได้เฉพาะกรณีประเภทผู้ป่วยนอก โดยให้เบิกได้ไม่เกินสองพันบาทต่อครั้ง</i></div>
</div>

<div style="padding-left:20px;">เป็นเงินที่มีสิทธิเบิกจ่ายทั้งสิ้น <span class="textcolor"><?php echo number_format($TotalCost,2);?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($TotalCost);?></span>) ตามใบเสร็จรับเงิน จำนวน <span class="textcolor"><?php echo $AmountBill; ?></span> ฉบับ</div>

<div style="padding-left:20px;">ข้าพเจ้าขอรับรองว่า ข้อความข้างต้นเป็นความจริงทุกประการ</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
<tr>
<td style="vertical-align:top; width:50%;">&nbsp;</td>
<td style="vertical-align:top; width:50%;">

  <table  border="0" cellspacing="0" cellpadding="0"  align="center">
    <tr>
    	<td align="left">ลงชื่อ</td>
        <td style="width:200px; border-bottom:1px dotted #999;">&nbsp;</td>
        <td align="right">ผู้ขอรับเงินสวัสดิการ</td>
    </tr>
    <tr>
    	<td style="text-align:right; padding-top:5px;">(</td>
        <td style="padding-top:5px; text-align:center;"><span class="textcolor"><?php echo $get->fn_getFullNameByPersonalCode($RQPersonalCode); ?></span></td>
        <td style="padding-top:5px;">)</td>
    </tr>
        <tr>
    	<td>&nbsp;</td>
        <td style="text-align:center;">............../............../..............</td>
        <td>&nbsp;</td>
    </tr>
    </table>        
        
</td>
</tr>

</table>



</td>
  </tr>
<tr style="vertical-align:top;">
    <td colspan="2"  style="text-align:justify; border:1px solid #999; padding:20px;">
<b>3. การตรวจสอบสิทธิ์</b>
<div><div style="width:40px; float:left;">เรื่อง</div><span class="textcolor"><?php echo $Topic; ?></span></div>
<div><div style="width:40px; float:left;">เรียน</div><span class="textcolor"><?php echo $DocTo; ?></span></div>
<div style="text-indent:40px; margin-top:20px;">
ข้าพเจ้า <span class="textcolor"><?php echo $get->fn_getFullNameByPersonalCode($CKPersonalCode); ?></span> ตำแหน่ง <span class="textcolor"><?php echo $get->getPositionName($CKPositionId); ?></span> 
ได้ตรวจสอบสิทธิ์และใบเบิกเงินสวัสดิการเกี่ยวกับบริการสาธารณสุข พร้อมเอกสารหลักฐานประกอบการเบิกจ่ายแล้ว ขอรับรองว่า ผู้เบิกมีสิทธิเบิกได้ตามระเบียบ ตามจำนวนที่ขอเบิก 
โดยใช้งบของ <span class="textcolor"><?php echo $get->getSourceExName($SourceExId); ?></span> &nbsp;<span class="textcolor"><?php echo $get->getPItemName($BgtYear,$PItemCode); ?></span> &nbsp;<span class="textcolor"><?php echo $get->getPrjDetailName($PrjDetailId); ?></span> กิจกรรม&nbsp;<span class="textcolor"><?php echo $get->getPrjActName($PrjActCode); ?></span> (<span class="textcolor"><?php echo $PrjActCode; ?></span>)
</div>
<div style="text-indent:40px; margin-bottom:20px;">จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติให้เบิกจ่าย</div>
    

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
<tr>
<td style="vertical-align:top; width:50%;">&nbsp;</td>
<td style="vertical-align:top; width:50%;">

  <table  border="0" cellspacing="0" cellpadding="0"  align="center">
    <tr>
    	<td align="left">ลงชื่อ</td>
        <td style="width:200px; border-bottom:1px dotted #999;">&nbsp;</td>
        <td align="right">ผู้ตรวจสอบ</td>
    </tr>
    <tr>
    	<td style="text-align:right; padding-top:5px;">(</td>
        <td style="padding-top:5px; text-align:center;"><span class="textcolor"><?php echo $get->fn_getFullNameByPersonalCode($CKPersonalCode); ?></span></td>
        <td style="padding-top:5px;">)</td>
    </tr>
        <tr>
    	<td>&nbsp;</td>
        <td style="text-align:center;"><?php echo dateFormat($CKDate); ?></td>
        <td>&nbsp;</td>
    </tr>
    </table>        
        
</td>
</tr>

</table>




<div style="font-size:14pt; margin-top:20px; margin-bottom:10px; color:#999;">
    <div><i><b>หมายเหตุ :</b> ให้พนักงานผู้รับผิดชอบการเบิกจ่าย ตรวจสอบความถูกต้องข้อมูลจากแฟ้มประวัติของพนักงาน และเอกสารสำคัญ ดังนี้</i></div>
    <div style="padding-left:60px;">- <i>ประวัติของผู้ที่มีสิทธิ , สำเนาทะเบียนบ้าน , สำเนาใบสำคัญการสมรส , สูติบัตรของบุตร</i></div>
    <div style="padding-left:60px;">- <i>สำเนาคำพิพากษาของศาล กรณีที่มีบุตรไร้หรือเสมือนไร้ความสามารถ</i></div>
    <div style="padding-left:60px;">- <i>สำเนาคำวินิจฉัยของแพทย์ กรณีที่มีบุตรที่มีจิตฟั่นเฟือนไม่สมประกอบ</i></div>
</div>



    
    </td>
</tr>

<tr>
    <td colspan="2"  style="text-align:justify; border:1px solid #999; padding:20px;">
    
    
<div style="float:left; width:100px;"><b>4. คำอนุมัติ</b></div>
<div> [&nbsp;&nbsp;] อนุมัติให้เบิกจ่าย  [&nbsp;&nbsp;] ไม่อนุมัติ </div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
<tr>
<td style="vertical-align:top; width:50%;">&nbsp;</td>
<td style="vertical-align:top; width:50%;">

  <table  border="0" cellspacing="0" cellpadding="0"  align="center">
    <tr>
    	<td align="left">ลงชื่อ</td>
        <td style="width:200px; border-bottom:1px dotted #999;">&nbsp;</td>
        <td align="right">ผู้มีอำนาจอนุมัติ</td>
    </tr>
    <tr>
    	<td style="text-align:right; padding-top:5px;">(</td>
        <td style="padding-top:5px; text-align:center;">&nbsp;</td>
        <td style="padding-top:5px;">)</td>
    </tr>
        <tr style="height:40px; vertical-align:bottom;">
    	<td>ตำแหน่ง</td>
        <td style="text-align:center; border-bottom:1px dotted #999;">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
     <tr style="height:70px;">
    	<td>&nbsp;</td>
        <td style="text-align:center;">............../............../..............</td>
        <td>&nbsp;</td>
    </tr>
    </table>        
        
</td>
</tr>
</table>


</td>
</tr>




<tr>
    <td colspan="2"  style="text-align:justify; border:1px solid #999; padding:20px;">
    
<b>5. ใบรับเงิน</b>
<div style="padding-left:15px;">- ได้รับเงินสวัสดิการเกี่ยวกับบริการสาธารณสุข จำนวน <span class="textcolor"><?php echo number_format($TotalCost,2);?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($TotalCost);?></span>)</div>
<div style="padding-left:15px;">- การรับเงินนี้ จะสมบูรณ์เมื่อได้รับโอนเงินเข้าบัญชีเงินเดือนของข้าพเจ้าแล้ว</div>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
<tr>
<td style="vertical-align:top; width:50%;">


  <table  border="0" cellspacing="0" cellpadding="0"  align="center">
    <tr>
    	<td align="left">ลงชื่อ</td>
        <td style="width:200px; border-bottom:1px dotted #999;">&nbsp;</td>
        <td align="right">ผู้จ่ายเงิน</td>
    </tr>
    <tr>
      <td style="text-align:right; padding-top:5px;">(</td>
      <td style="padding-top:5px; text-align:center;">&nbsp;</td>
      <td style="padding-top:5px;">)</td>
    </tr>
        <tr style="height:50px;">
          <td>&nbsp;</td>
          <td style="text-align:center;">............../............../..............</td>
          <td>&nbsp;</td>
        </tr>
    </table>   



</td>
<td style="vertical-align:top; width:50%;">

  <table  border="0" cellspacing="0" cellpadding="0"  align="center">
    <tr>
    	<td align="left">ลงชื่อ</td>
        <td style="width:200px; border-bottom:1px dotted #999;">&nbsp;</td>
        <td align="right">ผู้รับเงิน</td>
    </tr>
    <tr>
      <td style="text-align:right; padding-top:5px;">(</td>
      <td style="padding-top:5px; text-align:center;"><span class="textcolor"><?php echo $get->fn_getFullNameByPersonalCode($RQPersonalCode); ?></span></td>
      <td style="padding-top:5px;">)</td>
    </tr>
    <tr style="height:50px;">
      <td>&nbsp;</td>
      <td style="text-align:center;">............../............../..............</td>
      <td>&nbsp;</td>
    </tr>
    </table>        
        
</td>
</tr>

</table>


</td>
</tr>


<tr>
    <td colspan="2"  style="text-align:justify; border:1px solid #999; padding:20px;">

    <table width="95%" cellpadding="0" cellspacing="0" border="0" align="left">
        <tr style="vertical-align:top">
            <td style="width:50px;"><b>บันทึก : </b></td>
            <td style="width:200px;">เป็นการเบิกครั้งที่ <span class="textcolor"><?php echo ($PayNo)?($PayNo."/".$BgtYear):"-ไม่ระบุ-";  ?></span></td>
            <td style="text-align:right;">เบิกจ่ายแล้ว</td>
            <td style="width:120px; text-align:right;"><span class="textcolor"><?php echo number_format($BGWelfarePay,2); ?></span></td>
            <td style="width:50px;">&nbsp;บาท</td>
        </tr>
        <tr style="vertical-align:top">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align:right;">เบิกจ่ายครั้งนี้</td>
            <td style="text-align:right;"><span class="textcolor"><?php echo number_format($TotalCost,2); ?></span></td>
            <td>&nbsp;บาท</td>
        </tr>
        <tr style="vertical-align:top">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align:right;">คงเหลือ</td>
            <td style="text-align:right;"><span class="textcolor"><?php echo number_format(($BGWelfareRemain-$TotalCost),2); ?></span></td>
            <td>&nbsp;บาท</td>
        </tr>
    </table>    
  
    </td>
</tr>  
  
</table>



<div style="text-align:center; margin-top:20px; margin-bottom:20px;">
  <input type="button" name="print" value="พิมพ์ออกทางเครื่องพิมพ์" class="print" onClick="window.print();" />
  <input type="button" name="back" value="ย้อนกลับ" class="print" onClick="window.history.go(-1);" />
</div>
