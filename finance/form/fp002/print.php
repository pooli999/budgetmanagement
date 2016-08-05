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
    <td align="right" valign="top" >
    <span class="textid"><?php echo $FormCodeAlias; ?></span>
    <div>(วงเงินการจัดหาเกิน 300,000 บาท)</div>
    </td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="left" valign="top"  width="80%">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		  <tr>
		    <td rowspan="3" align="left" valign="middle" ><img src="http://suchon.nationalhealth.or.th/nationalhealth/images/logo.png" border="0" width="59" height="51"/></td>
		    <td align="left"  class="textname">สำนักงานคณะกรรมการสุขภาพแห่งชาติ</td>
		  </tr>
			<tr>
			  <td align="left"  class="textadd">ชั้น 3 อาคารสุขภาพแห่งชาติ 88/39 ถ.ติวานนท์ 14 หมู่ที่ 4 ต.ตลาดขวัญ อ.เมือง จ.นนทบุรี 11000</td>
			</tr>
			<tr>
			  <td align="left"  class="textadd">โทร: 66 2832 9000 โทรสาร: 66 2832 9001 www.nationalhealth.or.th </td>
			</tr>
	  </table>
    </td>
    <td align="right" ><div class="textmain">บันทึกข้อความ</div></td>
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
    <td colspan="2" style="border-bottom:1px solid #999; padding-bottom:10px;"><div style="width:50px; float:left;">เรื่อง</div><span class="textcolor"><?php echo $Topic; ?></span></td>
 </tr>
   <tr>
    <td colspan="2" style="padding-top:10px;"><div style="width:50px; float:left;">เรียน</div><span class="textcolor"><?php echo $DocTo; ?></span></td>
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
    <td colspan="2"  style="text-indent:40px; text-align:justify">
ด้วย <span class="textcolor"><?php echo ($PItemCode)?($get->getPItemName($BgtYear,$PItemCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></span>
มีความประสงค์จะดำเนินการ <span class="textcolor"><?php echo $Detail; ?></span>
ภายใต้กิจกรรม <span class="textcolor"><?php echo ($PrjActCode)?($get->getPrjActName($PrjActCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></span>
<span class="textcolor"><?php echo ($PrjDetailId)?($get->getPrjDetailName($PrjDetailId)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></span>
และในประกาศสำนักงานคณะกรรมการสุขภาพแห่งชาติ เรื่องหลักเกณฑ์ แนวทาง และวิธีปฏิบัติเกี่ยวกับการพัสดุ พ.ศ. 2551 ข้อ 4 กำหนดว่า การจัดหาพัสดุลักษณะพิเศษ ให้แผนงานต่างๆ ที่มีความประสงค์จะจัดหาพัสดุ จัดทำบันทึกคำขออนุมัติหลักการจัดหาพัสดุเสนอต่อผู้มีอำนาจอนุมัติ ซึ่งจะต้องแสดงรายการประกอบการพิจารณานั้น
    </td>
  </tr>
  
  <tr>
    <td colspan="2" height="16"></td>
  </tr>  
  <tr>
    <td colspan="2"  style="padding-left:40px; text-align:justify">
ในการนี้ แผนงานฯ จึงใคร่ขออนุมัติจัดซื้อ/จัดจ้าง โดยมีรายละเอียดของการจัดหาพัสดุดังต่อไปนี้

<div>1. วัตถุประสงค์หรือความจำเป็นในการจัดหาพัสดุ</div>
<div style="text-indent:30px;">- <span class="textcolor"><?php  echo ($Purpose)?(strip_tags($Purpose)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></span></div>

<div>2. รายละเอียดเกี่ยวกับพัสดุที่จะซื้อ/จ้าง</div>
<div style="text-indent:30px;">- <span class="textcolor"><?php echo ($Description)?(strip_tags($Description)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></span></div>

<div>3. กำหนดเวลาที่ต้องการใช้พัสดุ</div>
<div style="text-indent:30px;">- <span class="textcolor"><?php echo $AmountMonth; ?></span> เดือน <span class="textcolor"><?php echo ($AmountDate)?$AmountDate:"-"; ?></span> วัน ตั้งแต่วันที่ <span class="textcolor"><?php echo dateFormat($StartDate1);?></span> ถึงวันที่ <span class="textcolor"><?php echo dateFormat($EndDate1);?></span> </div>    

<div>4. รายละเอียดอื่นที่จำเป็นตามควรแก่กรณี</div>
<div style="text-indent:30px;">- <span class="textcolor"><?php echo ($Other)?(strip_tags($Other)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></span></div>

<div>5. งบประมาณ</div>
<div style="text-indent:30px;">

<!--///////////////////////////////////////////////-->
<table  width="100%" border="0" cellspacing="1" cellpadding="0">
<?php 
$gCostItemCode = $get->getImpCostItemCode($DocCode);//ltxt::print_r($gCostItemCode);
$dataCost = $get->getCostDetail($DocCode);//ltxt::print_r($dataCost);
$m=0;
if($gCostItemCode[0]->CostItemCode){
	foreach($gCostItemCode as $gCostItemCoderow){
		foreach($gCostItemCoderow as $gg=>$qq){	${$gg} = $qq;	}
		$sumSumCost 			= $get->getSumSumCost($DocCode,$CostItemCode);
?>
<tr style="vertical-align:top;">
  <td>
  <?php echo ($m+1); ?>) <span class="textcolor"><?php echo $get->getCostItemName($CostItemCode);?></span>
  
<?php
	for($i=0; $i<count($dataCost);$i++){
		if($dataCost[$i]->DetailCost != ""){
			if($dataCost[$i]->CostItemCode == $CostItemCode){
?>
  <div style="padding-left:20px;"><span class="textcolor">- <?php echo $dataCost[$i]->DetailCost;?></span>&nbsp;(<span class="textcolor"><?php echo number_format($dataCost[$i]->SumCost,2);?></span>&nbsp;บาท)</div>
 <?php
				}
			}
		} 
 ?> 
  </td>
	<td  style="text-align:right; width:120px;" ><span class="textcolor"><?php echo number_format($sumSumCost,2);?></span></td>
    <td style="width:100px; text-align:left;">บาท</td> 
</tr>
<?php 
		$m++;
	}
}
?>
<?php if($gCostItemCode[0]->CostItemCode == ""){ ?>     
	<tr>
    	<td colspan="3" style="text-align:center;">-ไม่พบรายการ-</td>
    </tr> 
<?php } ?>        
	</table>
<!--///////////////////////////////////////////////-->

</div>    
    
 <div style="text-indent:40px;">
 ภายในวงเงินงบประมาณทั้งสิ้น <span class="textcolor"><?php echo number_format($TotalCost,2);?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($TotalCost);?></span>) รวมหักภาษีมูลค่าเพิ่ม จากงบประมาณ
<span class="textcolor"><?php echo $get->getSourceExName($SourceExId); ?></span>
 &nbsp;<span class="textcolor"><?php echo $get->getPItemName($BgtYear,$PItemCode); ?></span>
 &nbsp;<span class="textcolor"><?php echo $get->getPrjDetailName($PrjDetailId); ?></span>
 กิจกรรม&nbsp;<span class="textcolor"><?php echo $get->getPrjActName($PrjActCode); ?></span> (<span class="textcolor"><?php echo $PrjActCode; ?></span>) 
</div>   


<div>6. แต่งตั้งคณะกรรมการจัดหาพัสดุ</div>
<div>

<div style="text-indent:40px;">
ตามที่ประกาศสำนักงานคณะกรรมการสุขภาพแห่งชาติ เรื่องหลักเกณฑ์ แนวทาง และวิธีปฏิบัติเกี่ยวกับการพัสดุ พ.ศ. 2551 ในข้อ 6-8 หากเป็นการจัดหาพัสดุครั้งหนึ่งซึ่งมีวงเงินเกิน 300,000 บาท (สามแสนบาทถ้วน) จะต้องแต่งตั้งคณะกรรมการจัดหาพัสดุจำนวน 3 คน ซึ่งกองแผนงานฯ เสนอขอแต่งตั้ง
</div>

<!--///////////////////////////////////////////////-->
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
<!--///////////////////////////////////////////////-->


</div>



</td>
  </tr>


    <tr>
    <td colspan="2" height="16"></td>
  </tr>  
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" >
จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติหลักการให้จัดหาพัสดุดังรายละเอียดข้างต้น และมอบหมายให้งานพัสดุ ดำเนินการตามระเบียบต่อไปด้วย จะเป็นพระคุณ
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
<td style="vertical-align:top; width:50%;">


<table  border="0" cellspacing="0" cellpadding="0"  align="center">
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
</table>


</td>
<td style="vertical-align:top; width:50%;">

  <table  border="0" cellspacing="0" cellpadding="0"  align="center">
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
    </table>        
        
</td>
</tr>

</table>






</td>
</tr>
</table>


<div style="text-align:center; margin-top:20px; margin-bottom:20px;">
  <input type="button" name="print" value="พิมพ์ออกทางเครื่องพิมพ์" class="print" onClick="window.print();" />
  <input type="button" name="back" value="ย้อนกลับ" class="print" onClick="window.history.go(-1);" />
</div>
