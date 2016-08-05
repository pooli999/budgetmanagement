<?php
	include("config.php");
	include($KeyPage."_helper.php");
	include($KeyPage."_data.php");
	$format = ltxt::getVar('format');
	if($format == 'raw'){ $get->getWord() ;}

	// ดึงไฟล์แนบ
	$CountFile = $get->getCountFile('tblintra_eform_formal_mat_file',$DocCode);

//ltxt::print_r($_REQUEST);
?>
<style type="text/css">
	body{
		margin-top:0px;
/*		margin-right:28px; 
		margin-left:43px;*/
	}
	
	td{
		font-family:"TH SarabunPSK";
		font-size:15pt; 
		line-height:110%;
	}

	.textcolor{ color:#333; }
	.textmain{ font-size:20pt; font-weight:bold;}
	.textid{ font-size:15pt; }
	.textname{ font-size:14pt; font-weight:bold;}
	.textadd{ font-size:12pt; }
	
</style>

<style type="text/css" media="print">
	body{
		margin-top:0px;
/*		margin-right:28px; 
		margin-left:43px;*/
	}

	td{
		font-family:"TH SarabunPSK";
		font-size:15pt; 
		line-height:110%;
	}
	
	.textcolor{ color:#333; }
	.textmain{ font-size:20pt; font-weight:bold;}
	.textid{ font-size:15pt; }
	.textname{ font-size:14pt;  font-weight:bold;}
	.textadd{ font-size:12pt; }	
	
    .print{ display:none; }
	
</style>


<table width="680" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td  valign="top">
    
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"  bgcolor="#FFFFFF"  bordercolor="#FFFFFF">
  <tr>
    <td align="right" valign="top" style="font-size:14pt;">แบบ FP001<br>(วงเงินการจัดหาไม่เกิน 300,000)</td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"  bgcolor="#FFFFFF"  bordercolor="#FFFFFF">
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
    <td colspan="2" >เรื่อง&nbsp;&nbsp;&nbsp;<span class="textcolor"><?php echo $Topic; ?></span>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="middle"><hr></hr></td>
  </tr>  
  <tr>
    <td colspan="2" >เรียน&nbsp;&nbsp;&nbsp;<span class="textcolor"><?php echo $DocTo; ?></span></td>
  </tr>
  
  <?php if($CountFile > 0){ ?> 
  <tr>
    <td colspan="2" >สิ่งที่ส่งมาด้วย&nbsp;&nbsp;&nbsp;รายละเอียดเกี่ยวกับพัสดุที่จะ<span class="textcolor"><?php echo $get->getInvenTypeName($ProcureTypeId); ?></span></td>
  </tr>   
  <?php } ?>
  
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:55px; text-align:justify" >ด้วย <span class="textcolor"><?php echo $get->getOrganizeName($OrganizeCode); ?></span> มีความประสงค์ที่จะดำเนินการ<span class="textcolor"><?php echo $Purpose; ?></span> ภายใต้<span class="textcolor"><?php echo $get->getPItemName($PItemCode);?> <?php echo $get->getPrjName($PrjId);?></span> กิจกรรม<span class="textcolor"><?php echo $get->getPrjActName($PrjActCode);?></span> (<span class="textcolor"><?php echo $PrjActCode;?></span>) และในประกาศสำนักคณะกรรมการสุขภาพแห่งชาติ เรื่องหลักเกณฑ์ แนวทาง และวิธีปฏิบัติเกี่ยวกับการพัสดุ พ.ศ. 2551 ข้อ 4 กำหนดว่า การจัดหาพัสดุลักษณะเฉพาะ ให้แผนงานต่างๆ ที่มีความประสงค์จะจัดหาพัสดุจัดทำบันทึกคำขออนุมัติหลักการจัดหาพัสดุเสนอต่อผู้มีอำนาจอนุมัติ ซึ่งจะต้องแสดงรายการประกอบการพิจารณาประกอบ นั้น
    </td>
  </tr>  
   <tr>
    <td colspan="2"  style="text-indent:55px; text-align:justify" >ในการนี้ <span class="textcolor"><?php echo $get->getOrganizeName($OrganizeCode); ?></span> จึงใคร่ขออนุมัติ<span class="textcolor"><?php echo $get->getInvenTypeName($ProcureTypeId); ?></span> โดยมีรายละเอียดของการจัดหาพัสดุดังต่อไปนี้</td>
  </tr>  
   <tr>
    <td colspan="2"  style="text-indent:55px; text-align:justify" >1.&nbsp;&nbsp;วัตถุประสงค์หรือความจำเป็นในการจัดหาพัสดุ</td>
  </tr>  
   <tr>
    <td colspan="2"  style="text-indent:74px; text-align:justify" ><span class="textcolor"><?php echo $Purpose; ?></span></td>
  </tr>  
  <tr>
    <td colspan="2"  style="text-indent:55px; text-align:justify" >2.&nbsp;&nbsp;รายละเอียดเกี่ยวกับพัสดุที่จะ<span class="textcolor"><?php echo $get->getInvenTypeName($ProcureTypeId); ?></span></td>
  </tr> 
    <tr>
    <td colspan="2"  style="text-indent:74px; text-align:justify" ><span class="textcolor"><?php if($CountFile > 0){ echo "เอกสารแนบท้าย"; }else{echo $Description;} ?></span></td>
  </tr>  
  <tr>
    <td colspan="2"  style="text-indent:55px; text-align:justify" >3.&nbsp;&nbsp;กำหนดเวลาที่ต้องการใช้พัสดุ <span class="textcolor"><?php if($UseType=="1"){ echo "ภายในเดือน ".$get->getMonthName($UseMonth)." พ.ศ. ".$UseYear; }elseif($UseType=="2"){ echo "เป็นช่วงเวลา จำนวน ".$UseAmountYear." ".$UseUnit." ตั้งแต่วันที่ ".ShowDate($UseStart)." ถึงวันที่ ".ShowDate($UseEnd); }else if($UseType=="3"){ echo $UseOther; }else{ echo "-"; } ?></span></td>
  </tr>  
  <tr>
    <td colspan="2"  style="text-indent:55px; text-align:justify" >4.&nbsp;&nbsp;รายละเอียดอื่นที่จำเป็นตามควรแก่กรณี</td>
  </tr>  
  <tr>
    <td colspan="2"  style="text-indent:74px; text-align:justify" ><span class="textcolor"><?php echo $DescriptionOther; ?></span></td>
  </tr>  
 <tr>
    <td colspan="2"  style="text-indent:55px; text-align:justify" >5.&nbsp;&nbsp;งบประมาณ</td>
 </tr>  
  <tr>
    <td colspan="2"  style="text-indent:74px; text-align:justify" >ภายในวงเงินงบประมาณทั้งสิ้น <span class="textcolor"><?php echo number_format($get->getSumCostGeneral('tblintra_eform_formal_mat_cost','DocCode',$DocCode,$PrjActCode),2);?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($get->getSumCostGeneral('tblintra_eform_formal_mat_cost','DocCode',$DocCode,$PrjActCode)); ?></span>) 
    รวมภาษีมูลค่าเพิ่ม จาก<span class="textcolor"><?php 
	if($SourceType=="Internal"){ echo "งบประมาณ สช.";}
	else if($SourceType=="External"){ 
		echo "เงินนอกงบประมาณของ";
		echo $get->getSourceExName($SourceExId);
	} 
	?>   
	<?php echo $get->getPItemName($PItemCode);?>  
    <?php echo $get->getPrjName($PrjId);?>  </span>
    กิจกรรม<span class="textcolor"><?php echo $get->getPrjActName($PrjActCode);?></span>  (<span class="textcolor"><?php echo $PrjActCode;?></span>) 
    
    
    </td>
  </tr>
    <tr>
    <td colspan="2" height="16"></td>
  </tr>
   <tr>
    <td colspan="2"  style="text-indent:55px; text-align:justify" >จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติหลักการให้จัดหาพัสดุดังรายละเอียดข้างต้น และมอบหมายให้งานพัสดุ สำนักอำนวยการ ดำเนินการตามระเบียบต่อไปด้วย จะเป็นพระคุณ</td>
  </tr>  
</table>
 
 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
   <tr>
    <td colspan="2"  height="60"></td>
  </tr>
</table>  
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
<tr>
<td width="50%" align="left" valign="top">&nbsp;</td>
<td  width="50%" align="left" valign="top">

  <table  border="0" cellspacing="0" cellpadding="0"    >
    <tr>
    	<td align="left">ลงชื่อ</td><td width="200">&nbsp;</td><td align="right">ผู้เบิก</td>
    </tr>
  <tr>
    <td colspan="3"  align="center" ><span class="textcolor">
    (<?php echo fn_getFullNameByPersonalCode($PersonalCode);?>)<br>
      <?php echo $get->getPositionName($PositionId); ?><br>
      <?php echo $get->getOrganizeName($OrgApprove); ?><br></span>
     </td>
  </tr>
</table>        
        
</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
   <tr>
    <td colspan="2"  height="30"></td>
  </tr>
</table>  
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
<td width="50%" align="left" valign="top">

<table  border="0" cellspacing="0" cellpadding="0"    >
    <tr>
    	<td align="left">ลงชื่อ</td><td width="200">&nbsp;</td><td align="right">ผู้อนุมัติ</td>
    </tr>
        <tr> 
        <td colspan="3"  align="center" >
            (...............................................)&nbsp;&nbsp;<br />
            ...............................................&nbsp;&nbsp;<br /><br />
           .............../................/..............&nbsp;&nbsp;<br />
        </td>
        </tr>
     </table>

</td>
<td  width="50%" align="right" valign="top">&nbsp;

	        
        
</td>
</tr>
</table>

	</td>
  </tr>
</table>

