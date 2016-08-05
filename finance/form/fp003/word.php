<?php
header("Content-type: text/html; charset=tis-620");
header("Content-Disposition: attachment; filename=".$_REQUEST["FormCode"]."_สช.น ".$_REQUEST["DocCode"].".doc");
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
<HTML xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
<style type="text/css">
.textcolor {color:#06C; }
</style>
</HEAD>
<BODY>
<style type="text/css" media="word">
	td {
		font-family:"TH SarabunPSK";
		font-size:14pt;
	}
	.textcolor{ color:#000000; }
</style>

<style type="text/css" media="print">
	td {
		font-family:"TH SarabunPSK";
		font-size:14pt; 
	}
	.textcolor{ color:#000000; }
    .print{ display:none; }
</style>

<table width="680" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td  valign="top">

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="right" valign="top" style="font-size:14pt;"><?php echo $FormCodeAlias; ?> <div>(จัดหาในกรณีมีความจำเป็นเร่งด่วน)</div></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="left" valign="top"  width="80%">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		  <tr>
		    <td rowspan="3" align="left" valign="middle" ><img src="http://suchon.nationalhealth.or.th/nationalhealth/images/logo.png" border="0" width="59" height="51"/></td>
		    <td align="left" style="font-weight:bold; font-size:14pt;">สำนักงานคณะกรรมการสุขภาพแห่งชาติ</td>
		  </tr>
			<tr>
			  <td align="left" style="font-size:12pt;">ชั้น 3 อาคารสุขภาพแห่งชาติ 88/39 ถ.ติวานนท์ 14 หมู่ที่ 4 ต.ตลาดขวัญ อ.เมือง จ.นนทบุรี 11000</td>
			</tr>
			<tr>
			  <td align="left" style="font-size:12pt;">โทร: 66 2832 9000 โทรสาร: 66 2832 9001 www.nationalhealth.or.th </td>
			</tr>
	  </table>
    </td>
    <td align="right" ><div style="font-weight:bold; font-size:20pt;">บันทึกข้อความ</div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td width="50%" >ที่ สช.น. <span class="textcolor"><?php echo $DocCode; ?></span>&nbsp;</td>
    <td width="50%" >วันที่ <span class="textcolor"><?php echo ShowDateLong($DocDate);?></span>&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2" style="border-bottom:1px solid #999; padding-bottom:10px;">เรื่อง&nbsp;<span class="textcolor"><?php echo $Topic; ?></span></td>
 </tr>
   <tr>
    <td colspan="2" style="padding-top:10px;">เรียน&nbsp;<span class="textcolor"><?php echo $DocTo; ?></span></td>
 </tr>
 <tr>
 <td colspan="2" style="vertical-align:top;">
 
<table  width="100%" border="0" cellspacing="1" cellpadding="0"> 
    <tr>
      <td style="width:80px; vertical-align:top;">สิ่งที่ส่งมาด้วย</td>
      <td>
				 <?php 
				$attachList = $get->getAttachList($DocCode);//ltxt::print_r($costList);
				 if($attachList){
						$no = 1;
						foreach($attachList as $at){
							foreach( $at as $att=>$ath){ ${$att} = $ath;}
						?>
						<?php if(count($attachList)>1){ echo $no; ?>) <span class="textcolor"><?php } echo $AttachName; ?>&nbsp;</span>
						<?php 
							$no++;
						} 
				 }else{
					 echo "-";
				 }
				?>    
      </td>  
 </tr>
 </table>
 
 </td>
 </tr>
   <tr>
    <td colspan="2" height="16"></td>
  </tr>  
    <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify; font-weight:bold;">1. ความเป็นมา</td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify">
ด้วย <span class="textcolor"><?php echo ($RQOrganizeCode)?($get->getOrganizeName($RQOrganizeCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></span>
มีความจำเป็นเร่งด่วนที่จะต้องดำเนินการ <span class="textcolor"><?php echo strip_tags($Detail); ?></span>
ภายใต้ <span class="textcolor"><?php echo $get->getPItemName($BgtYear,$PItemCode); ?></span>
 &nbsp;<span class="textcolor"><?php echo $get->getPrjDetailName($PrjDetailId); ?></span>
 กิจกรรม&nbsp;<span class="textcolor"><?php echo $get->getPrjActName($PrjActCode); ?></span> (<span class="textcolor"><?php echo $PrjActCode; ?></span>) 
เพื่อใช้ในงาน <span class="textcolor"><?php echo strip_tags($Purpose); ?></span> ณ วันที่ <span class="textcolor"><?php echo dateFormat($StartDate);?></span>
<?php if($Description){ ?> (<span class="textcolor"><?php echo strip_tags($Description); ?></span>) <?php } ?>
    </td>
  </tr>
    <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify">
สำนักฯ จึงได้จัดซื้อ/จัดจ้าง <span class="textcolor"><?php echo $Title; ?></span> จากบริษัท/ห้าง/ร้าน <span class="textcolor"><?php echo $PartnerName; ?></span>
ตามใบเสร็จรับเงิน/ใบกำกับภาษี/ใบส่งของ/ใบแจ้งหนี้/เล่มที่ <span class="textcolor"><?php echo $BillNo; ?></span> เลขที่ <span class="textcolor"><?php echo $BillNumber; ?></span> ลงวันที่ <span class="textcolor"><?php echo dateFormat($BillDate); ?></span>
เป็นเงินทั้งสิ้น <span class="textcolor"><?php echo number_format($TotalCost,2);?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($TotalCost);?></span>) ดังรายละเอียดในสิ่งที่ส่งมาด้วยพร้อมนี้
    </td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>  
    <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify; font-weight:bold;">2. ข้อพิจารณา</td>
  </tr>
    <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify;">
2.1 ประกาศสำนักงานคณะกรรมการสุขภาพแห่งชาติ เรื่องหลักเกณฑ์ แนวทาง และวิธีปฏิบัติเกี่ยวกับการพัสดุ พ.ศ.2551 ข้อ 5 กำหนดว่า การจัดหาพัสดุโดยวิธีตกลงราคา 
ในกรณีที่เป็นการจัดหาพัสดุครั้งหนึ่งซึ่งมีวงเงินไม่เกิน 5,000 บาท หรือการจัดหาพัสดุในกรณีจำเป็นและเร่งด่วนที่เกิดขึ้นโดยมิได้คาดหมายไว้ก่อน และไม่อาจดำเนินการตามปกติได้ทัน ให้เจ้าหน้าที่หรือพนักงานดำเนินการไปก่อน แล้วให้ทำบันทึกขออนุมัติจัดหาพัสดุเสนอต่อผู้มีอำนาจอนุมัติโดยทันที
</td>
  </tr>
      <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify;">
2.2 ตามระเบียบคณะกรรมการบริหารสำนักงานคณะกรรมการสุขภาพแห่งชาติว่าด้วยการรับการเก็บรักษา การจ่ายเงิน และการบัญชี พ.ศ. 2551 ข้อ 6 กำหนดให้เลขาธิการมีอำนาจอนุมัติก่อหนี้ผูกพันทั้งที่ดำเนินการตามระเบียบว่าด้วยการพัสดุ หรือกรณีการสนับสนุนหรือดำเนินโครงการของสำนักงานที่มิใช่การดำเนินงานตามระเบียบว่าด้วยการพัสดุได้ภายในวงเงินไม่เกิน 10 ล้านบาท หากเกินกว่า 10 ล้านบาทให้เป็นอำนาจของ คบ. และคำสั่งสำนักงานคณะกรรมการสุขภาพแห่งชาติที่ 3/2553 เรื่อง มอบอำนาจการบริหารได้มอบอำนาจให้รองเลขาธิการฯ จัดหาพัสดุ ก่อหนี้ผูกพัน อนุมัติโครงการ จ่ายเงิน ตามระเบียบ ประกาศ และคำสั่งที่เกี่ยวข้องของ คสช. คบ. และสำนักงาน ในวงเงินครั้งละไม่เกิน 2 ล้านบาท
</td>
  </tr>
      <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify;">
2.3 ประกาศสำนักงานคณะกรรมการสุขภาพแห่งชาติ เรื่องหลักเกณฑ์ แนวทาง และวิธีปฏิบัติเกี่ยวกับการพัสดุ พ.ศ. 2551 ข้อ 16 กำหนดว่า สำหรับการตรวจรับพัสดุซึ่งมีวงเงินไม่เกิน 50,000 บาท (ห้าหมื่นบาท) ให้ดำเนินการโดยพนักงาน 1 คน สำหรับการตรวจรับพัสดุซึ่งมีวงเงินเกิน 50,000 บาท (ห้าหมื่นบาท) ให้ดำเนินการโดยคณะกรรมการตรวจรับพัสดุจำนวน 3 คน บุคคลซึ่งทำหน้าที่ตรวจรับพัสดุจะต้องไม่เป็นเจ้าหน้าที่พัสดุหรือคณะกรรมการจัดหาพัสดุ
</td>
  </tr>
<tr>
	<td colspan="2"  style="text-indent:40px; text-align:justify;">
การจัดหาพัสดุครั้งนี้ เป็นเงินทั้งสิ้น <span class="textcolor"><?php echo number_format($TotalCost,2);?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($TotalCost);?></span>) จึงเห็นสมควรแต่งตั้งคณะกรรมการตรวจรับพัสดุ 3 คน ได้แก่   
 <!--คณะกรรมการ-->   
 <table  width="690" border="0" cellspacing="1" cellpadding="0" class="tbl-list-sub">
    <tr>
      <td style="text-align:left; width:250px;">1) <span class="textcolor"><?php echo $get->fn_getFullNameByPersonalCode($CommiteeName1);?></span></td>
    	<td style="text-align:left; width:200px;">ตำแหน่ง <span class="textcolor"><?php echo $get->getPositionName($CommiteePosition1);?></span></td>
        <td style="text-align:left; width:200px;"><span class="textcolor"><?php echo $get->getDutyName($CommiteeDuty1); ?></span></td>
  	</tr>
     <tr>
       <td style="text-align:left;">2) <span class="textcolor"><?php echo $get->fn_getFullNameByPersonalCode($CommiteeName2);?></span></td>
    	<td style="text-align:left;">ตำแหน่ง <span class="textcolor"><?php echo $get->getPositionName($CommiteePosition2);?></span></td>
        <td style="text-align:left;"><span class="textcolor"><?php echo $get->getDutyName($CommiteeDuty2); ?></span></td>
  	</tr>
    <tr>
      <td style="text-align:left;">3) <span class="textcolor"><?php echo $get->fn_getFullNameByPersonalCode($CommiteeName3);?></span></td>
    	<td style="text-align:left;">ตำแหน่ง <span class="textcolor"><?php echo $get->getPositionName($CommiteePosition3);?></span></td>
        <td style="text-align:left;"><span class="textcolor"><?php echo $get->getDutyName($CommiteeDuty3); ?></span></td>
  	</tr>
</table>
 <!--END คณะกรรมการ-->
    
    
    </td>
</tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>  
<tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify; font-weight:bold;">3. ข้อเสนอ</td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify">
จึงเรียนมาเพื่อโปรดพิจารณา
    </td>
  </tr>
   <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify">
3.1 อนุมัติให้จัดซื้อ/จัดจ้าง  <span class="textcolor"><?php echo $Topic; ?></span> จากบริษัท/ห้าง/ร้าน <span class="textcolor"><?php echo $PartnerName; ?></span> ดังรายละเอียดในข้อ 1 โดยวิธีตกลงราคา กรณีจำเป็นและเร่งด่วน
    </td>
  </tr>
   <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify">
3.2 อนุมัติให้เบิกจ่ายเงินจำนวนทั้งสิ้น <span class="textcolor"><?php echo number_format($TotalCost,2);?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($TotalCost);?></span>) โดยเบิกจ่ายจาก
<span class="textcolor"><?php echo $get->getSourceExName($SourceExId); ?></span>
 &nbsp;<span class="textcolor"><?php echo $get->getPItemName($BgtYear,$PItemCode); ?></span>
 &nbsp;<span class="textcolor"><?php echo $get->getPrjDetailName($PrjDetailId); ?></span>
 กิจกรรม&nbsp;<span class="textcolor"><?php echo $get->getPrjActName($PrjActCode); ?></span> (<span class="textcolor"><?php echo $PrjActCode; ?></span>) 
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td colspan="2"  height="60"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td style="vertical-align:top; width:50%;"><table  border="0" cellspacing="0" cellpadding="0"  align="center">
      <tr>
        <td align="left">ลงชื่อ</td>
        <td style="width:200px; border-bottom:1px dotted #999;">&nbsp;</td>
        <td align="right">ผู้อนุมัติ</td>
      </tr>
      <tr>
        <td style="text-align:right; padding-top:5px;">(</td>
        <td style="border-bottom:1px dotted #999; padding-top:5px;">&nbsp;</td>
        <td style="padding-top:5px;">)</td>
      </tr>
      <tr>
        <td colspan="3" style="height:30px;"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td style="text-align:center;">............../............../..............</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td style="vertical-align:top; width:50%;"><table  border="0" cellspacing="0" cellpadding="0"  align="center">
      <tr>
        <td align="left">ลงชื่อ</td>
        <td style="width:250px; border-bottom:1px dotted #999;">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td style="text-align:right; padding-top:5px;">(</td>
        <td style="padding-top:5px; text-align:center;"><span class="textcolor"><?php echo $get->fn_getFullNameByPersonalCode($RQPersonalCode); ?></span></td>
        <td style="padding-top:5px;">)</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td style="text-align:center;"><?php echo ($RQPositionId)?($get->getPositionName($RQPositionId)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td style="width:250px; text-align:center;"><?php echo ($RQOrganizeCode)?($get->getOrganizeName($RQOrganizeCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>    