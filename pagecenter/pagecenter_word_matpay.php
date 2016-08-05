<?php
	include("config.php");
	include($KeyPage."_helper.php");
	include($KeyPage."_data.php");
	$format = ltxt::getVar('format');
	if($format == 'raw'){ $get->getWord() ;}

//ltxt::print_r($_REQUEST);
$DataG = $get->getDetailGeneral('tblintra_eform_formal_mat','DocCode',$DocCode);	//ltxt::print_r($DataG);	

?>
<style type="text/css" media="word">
	td{
		font-family:"TH SarabunPSK";
		font-size:14pt;
		line-height:110%;
	}
	.textcolor{ color:#000000; }
</style>

<style type="text/css" media="print">
	td{
		font-family:"TH SarabunPSK";
		font-size:14pt; 
		line-height:110%;
	}
	.textcolor{ color:#000000; }
    .print{ display:none; }
</style>

<table width="680" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td  valign="top">
    
    
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"  bgcolor="#FFFFFF"  bordercolor="#FFFFFF">
  <tr>
    <td align="right" valign="top" style="font-size:14pt;">แบบ FP005</td>
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
    <td colspan="2"  height="16"></td>
  </tr>
  <tr>
    <td width="50%" >ที่ สช.น <span class="textcolor"><?php echo $DocCodePay; ?></span>&nbsp;</td>
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
  <tr>
    <td colspan="2"  height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:44px; text-align:justify" ><span class="textcolor"><?php echo $Detail; ?></span></td>
  </tr>
  <tr>
    <td colspan="2"  height="16"></td>
  </tr>  
  <tr>
    <td colspan="2"  style="text-indent:44px; text-align:justify" >บัดนี้ผู้รับจ้างได้ดำเนินงานเรียบร้อยแล้ว และกรรมการตรวจรับได้ทำการตรวจรับไว้เรียบร้อยแล้ว ดังนั้นจึง<span class="textcolor"><?php echo $Topic; ?></span>เป็นเงินรวมทั้งสิ้น <?php echo number_format($get->getSumCostGeneral('tblintra_eform_formal_mat_pay_cost','DocCodePay',$DocCodePay,0,0,0),2); ?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($get->getSumCostGeneral('tblintra_eform_formal_mat_pay_cost','DocCodePay',$DocCodePay,0,0,0)); ?></span>)
   โดยเบิกจาก<span class="textcolor"><?php 
	if($DataG->SourceType=="Internal"){ echo "งบประมาณ สช.";}
	else if($DataG->SourceType=="External"){ 
		echo "เงินนอกงบประมาณ";
		echo "ของ".$get->getSourceExName($DataG->SourceExId);
	} 
	?></span>   
	
    ภายใต้<span class="textcolor">
	<?php echo $get->getPItemName($DataG->PItemCode);?>  
    <?php echo $get->getPrjName($DataG->PrjId);?>  </span>
    กิจกรรม<span class="textcolor"><?php echo $get->getPrjActName($DataG->PrjActCode);?></span>  (<span class="textcolor"><?php echo $DataG->PrjActCode;?></span>) 
	</td>
  </tr>
  <tr>
    <td colspan="2"  height="16"></td>
  </tr> 
  <tr>
    <td colspan="2"  style="text-indent:44px; text-align:justify" >จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติเบิกจ่ายต่อไปด้วย จะเป็นพระคุณ</td>
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
    (<?php echo fn_getFullNameByPersonalCode($PayPersonalCode);?>)<br>
      <?php echo $get->getPositionName($PayPositionId); ?><br>
      <?php echo $get->getOrganizeName($PayOrgApprove); ?><br></span>
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


