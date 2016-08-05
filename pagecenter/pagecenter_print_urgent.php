<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
	
//ltxt::print_r($detail);	
?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	//window.print();
/*  ]]> */
</script>
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

	.textcolor{ color:#06C; }
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


<table width="660" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td  valign="top">
    
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"  bgcolor="#FFFFFF"  bordercolor="#FFFFFF">
  <tr>
    <td align="right" valign="top" ><span class="textid">แบบ FP003<br />(จัดหาในกรณีมีความจำเป็นเร่งด่วน)</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"  bgcolor="#FFFFFF"  bordercolor="#FFFFFF">
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
			  <td align="left"  class="textadd">โทร: +66 2832 9000 โทรสาร: +66 2832 9001 www.nationalhealth.or.th </td>
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
    <td width="50%" >วันที่ <span class="textcolor"><?php echo ShowDateLong($MatUrgDate);?></span>&nbsp;</td>
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
  <tr>
    <td colspan="2" >สิ่งที่ส่งมาด้วย&nbsp;&nbsp;&nbsp;<span class="textcolor"><?php echo $Bill; ?></span></td>
  </tr>   

  <!--<table width="610" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr>
  <td valign="top" nowrap="nowrap">สิ่งที่ส่งมาด้วย&nbsp;&nbsp;&nbsp;</td>
  <td valign="top">1.&nbsp;&nbsp;</td>
  <td valign="top" style="">ใบเสร็จรับเงิน/ใบกำกับภาษี/ใบส่งของ/ใบแจ้งหนี้ของบริษัท/ห้าง/ร้าน <?php //echo $get->getComName($ComId);?></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>เล่มที่ <?php //echo $DocNo; ?> เลขที่ <?php //echo $DocNumber;?> ลงวันที่ <?php //echo ShowDate($DocDate);?></td>
  </tr>  
  <tr>
  <td>&nbsp;</td>
  <td>2.&nbsp;&nbsp;</td>
  <td>รายงานการตรวจรับพัสดุ กรณีวงเงินการจัดซื้อ/จัดจ้างเกิน 5,000 บาท</td>
  </tr>
 </table>-->
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
   <tr>
    <td colspan="2" style="padding-left:40px;"><strong>1.&nbsp;&nbsp;<u>ความเป็นมา</u></strong>
	</td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:60px; text-align:justify" >
  ด้วย <span class="textcolor"><?php echo $get->getOrganizeName($OrganizeCode); ?></span> มีความจำเป็นที่จะ<span class="textcolor"><?php echo $Detail; ?> <?php echo $DescriptionOther; ?></span> ภายใต้<span class="textcolor"><?php echo $get->getPItemName($PItemCode);?> <?php echo $get->getPrjName($PrjId);?></span> กิจกรรม<span class="textcolor"><?php echo $get->getPrjActName($PrjActCode);?> (<?php echo $PrjActCode;?>)  </span>
    </td>
  </tr>
    <tr>
    <td colspan="2"  style="text-indent:60px; text-align:justify" >
<span class="textcolor"><?php echo $get->getOrganizeName($OrganizeCode); ?></span> จึงได้<span class="textcolor"><?php echo $UrgentType; ?><?php echo $Description; ?></span> จาก<span class="textcolor"><?php echo $ComName; ?></span> ตาม<span class="textcolor"><?php echo $Bill; ?></span> ลงวันที่ <span class="textcolor"><?php echo ShowDateLong($DocDate);?></span> เป็นเงินทั้งสิ้น <span class="textcolor"><?php echo number_format($get->getSumCostGeneral('tblintra_eform_mat_urgent_cost','DocCode',$DocCode,$PrjActCode,0,0),2); ?></span> บาท 
(<span class="textcolor"><?php echo JThaiBaht::_($get->getSumCostGeneral('tblintra_eform_mat_urgent_cost','DocCode',$DocCode,$PrjActCode,0,0)); ?></span>) ดังรายละเอียดในสิ่งที่ส่งมาด้วยพร้อมนี้
    </td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>  
  <tr>
    <td colspan="2" style="padding-left:40px;"><strong>2.&nbsp;&nbsp;<u>ข้อพิจารณา</u></strong>
	</td>
  </tr> 
   <tr>
    <td colspan="2"  style="text-indent:60px; text-align:justify" >
2.1&nbsp;&nbsp;ประกาศสำนักงานคณะกรรมการสุขภาพแห่งชาติ เรื่องหลักเกณฑ์ แนวทาง และวิธีปฏิบัติเกี่ยวกับการพัสดุ พ.ศ. 2551 ข้อ 5 กำหนดว่า การจัดหาพัสดุโดยวิธีตกลงราคา ในกรณีที่เป็นการจัดหาพัสดุครั้งหนึ่งซึ่งมีวงเงินไม่เกิน 5,000 บาท หรือการจัดหาพัสดุในกรณีจำเป็นและเร่งด่วนที่เกิดขึ้น โดยมิได้คาดหมายไว้ก่อนและไม่อาจดำเนินการตามปกติได้ทัน ให้เจ้าหน้าที่พัสดุหรือพนักงานดำเนินการไปก่อน แล้วให้ทำบันทึกขออนุมัติจัดหาพัสดุเสนอต่อผู้มีอำนาจอนุมัติโดยทันที 
	</td>
  </tr>  
   <tr>
    <td colspan="2"  style="text-indent:60px; text-align:justify" >
2.2  ตามระเบียบคณะกรรมการบริหารสำนักงานคณะกรรมการสุขภาพแห่งชาติ ว่าด้วยการรับ การเก็บรักษา การจ่ายเงิน และการบัญชี พ.ศ. 2551 ข้อ 6 กำหนดให้เลขาธิการมีอำนาจอนุมัติก่อหนี้ผูกพันทั้งที่ดำเนินการตามระเบียบว่าด้วยพัสดุ หรือกรณีการสนับสนุนหรือดำเนินโครงการของสำนักงานที่มิใช่การดำเนินการตามระเบียบว่าด้วยการพัสดุได้ภายในวงเงินไม่เกิน 10 ล้านบาท หากเกินกว่า 10 ล้านให้เป็นอำนาจของ คบ. และคำสั่งสำนักงานคณะกรรมการสุขภาพแห่งชาติที่ 28/2554 เรื่อง มอบอำนาจการบริหารได้มอบอำนาจให้รองเลขาธิการฯ จัดหาพัสดุ ก่อหนี้ผูกพัน  และจ่ายเงิน ตามระเบียบ ประกาศ คบ. และคำสั่งที่เกี่ยวข้อง ในวงเงินครั้งละไม่เกิน 2 ล้านบาท	</td>
  </tr>  
   <tr>
    <td colspan="2"  style="text-indent:60px; text-align:justify" >
2.3  ประกาศสำนักคณะกรรมการสุขภาพแห่งชาติ เรื่องหลักเกณฑ์ แนวทาง และวิธีปฏิบัติเกี่ยวกับการพัสดุ พ.ศ. 2551 ข้อ 16 กำหนดว่า สำหรับการตรวจรับพัสดุซึ่งมีวงเงินไม่เกิน 50,000 บาท(ห้าหมื่นบาทถ้วน) ให้ดำเนินการโดยพนักงาน 1 คน สำหรับการตรวจรับพัสดุซึ่งมีวงเงินเกิน 50,000 บาท(ห้าหมื่นบาทถ้วน) ให้ดำเนินการโดยคณะกรรมการตรวจรับพัสดุจำนวน 3 คนบุคคลซึ่งทำหน้าที่ตรวจรับพัสดุจะต้องไม่เป็นเจ้าหน้าที่พัสดุหรือคณะกรรมการจัดหาพัสดุ
	</td>
  </tr>
   <tr>
    <td colspan="2"  style="text-indent:60px; text-align:justify" >
การจัดหาพัสดุครั้งนี้ เป็นเงินทั้งสิ้น  <span class="textcolor"><?php echo number_format($get->getSumCostGeneral('tblintra_eform_mat_urgent_cost','DocCode',$DocCode,$PrjActCode,0,0),2); ?></span> บาท 
(<span class="textcolor"><?php echo JThaiBaht::_($get->getSumCostGeneral('tblintra_eform_mat_urgent_cost','DocCode',$DocCode,$PrjActCode,0,0)); ?></span>) จึงเห็นสมควรแต่งตั้งคณะกรรมการตรวจรับพัสดุ <span class="textcolor"><?php echo $get->getcountstaff($DocCode);?></span> คน ได้แก่
  <table border="0" cellspacing="0" cellpadding="0"  width="100%"  >
	
	<?php 
		$actList = $get->getmatItem($DocCode);
		 if($actList){
			 $i = 1;
				foreach($actList as $r){
					foreach( $r as $k=>$v){ ${$k} = $v;}
	?>  
  <tr> 
  <td width="40%" align="left" valign="top"  style="text-indent:60px;" ><span class="textcolor"><?php echo $i;?>)&nbsp;&nbsp;<?php echo fn_getFullNameByPersonalCode($StaffPersonalCode);?></span></td>
  <td width="30%" align="left" valign="top">ตำแหน่ง<span class="textcolor"><?php echo $get->getPositionName($StaffPositionId); ?></span></td>
  <td width="20%" align="left" valign="top"><span class="textcolor"><?php echo $get->getDutyName($DutyId); ?></span></td>  
  </tr>
	<?php				
			$i++;
			}
		}
	?> 
  </table>    
	</td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>  
  <tr>
    <td colspan="2" style="padding-left:40px;"><strong>3.&nbsp;&nbsp;<u>ข้อเสนอ</u></strong>
	</td>
  </tr> 
   <tr>
    <td colspan="2"  style="text-indent:60px" >จึงเรียนมาเพื่อโปรดพิจารณา
	</td>
  </tr> 
   <tr>
    <td colspan="2"  style="text-indent:60px; text-align:justify" >
    3.1&nbsp;&nbsp;อนุมัติให้<span class="textcolor"><?php echo $UrgentType; ?> <?php echo $Description; ?></span> จาก<span class="textcolor"><?php echo $ComName; ?></span> ดังรายละเอียดในข้อ 1 โดยวิธีตกลงราคา กรณีจำเป็นและเร่งด่วน
	</td>
  </tr>   
   <tr>
    <td colspan="2"  style="text-indent:60px; text-align:justify" >
    3.2&nbsp;&nbsp;อนุมัติให้เบิกจ่ายเงินจำนวนทั้งสิ้น  <span class="textcolor"><?php echo number_format($get->getSumCostGeneral('tblintra_eform_mat_urgent_cost','DocCode',$DocCode,$PrjActCode,0,0),2); ?></span> บาท 
(<span class="textcolor"><?php echo JThaiBaht::_($get->getSumCostGeneral('tblintra_eform_mat_urgent_cost','DocCode',$DocCode,$PrjActCode,0,0)); ?></span>) โดยเบิกจ่ายจาก
<span class="textcolor">
	<?php 
	if($SourceType=="Internal"){ echo "งบประมาณ สช.";}
	else if($SourceType=="External"){ 
		echo "เงินนอกงบประมาณของ".$get->getSourceExName($SourceExId);
	} 
	?></span>
ภายใต้<span class="textcolor">
<?php echo $get->getPItemName($PItemCode);?>  
<?php echo $get->getPrjName($PrjId);?></span>  
กิจกรรม<span class="textcolor"><?php echo $get->getPrjActName($PrjActCode);?> (<?php echo $PrjActCode;?>) </span>
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
            (.......................................................) &nbsp;&nbsp;<br />
            ....................................................... &nbsp;&nbsp;<br /><br />
           ................./................../................ &nbsp;&nbsp;<br />
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

<div style="padding-top:50px; text-align:center;">
<input name="print" type="button" value="พิมพ์เอกสาร"  onclick="window.print();" class="print" style="color:#009"  />
<input name="print" type="button" value="ปิดหน้าต่าง"  onclick="window.close();" class="print" style="color:#000"  />
</div>

