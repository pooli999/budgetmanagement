<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
//ltxt::print_r($detail);

$mainDetail = $get->getDetailGeneral('tblintra_eform_advance','EFormId',$_GET["EFormId"]);
//ltxt::print_r($mainDetail);

?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	//window.print();
/*  ]]> */
</script>
<style type="text/css">
/*	body{
		margin-top:0px;
		margin-right:28px; 
		margin-left:43px;
	}
	*/
	td{
		font-family:"TH SarabunPSK";
		font-size:16pt; 
		line-height:110%;
	}

	.textcolor{ color:#06C; }
	.textmain{ font-size:20pt; font-weight:bold;}
	.textid{ font-size:14pt; }
	.textname{ font-size:14pt; font-weight:bold;}
	.textadd{ font-size:12pt; }
</style>

<style type="text/css" media="print">
/*	body{
		margin-top:28px;
		margin-right:28px; 
		margin-left:43px;
	}*/

	td{
		font-family:"TH SarabunPSK";
		font-size:17pt; 
		line-height:110%;
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

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"  bgcolor="#FFFFFF"  bordercolor="#FFFFFF">
  <tr>
    <td align="right" valign="top" ><span class="textid">แบบ FF004</span></td>
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
			  <td align="left"  class="textadd">โทร: 66 2832 9000 โทรสาร: 66 2832 9001 www.nationalhealth.or.th </td>
			</tr>
	  </table>
    </td>
    <td align="right" ><div class="textmain">บันทึกข้อความ</div></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr>
    <td colspan="2"  height="16"></td>
  </tr>
  <tr>
    <td width="50%" >ที่ สช.น. <span class="textcolor"><?php echo $DocCodePay; ?></span>&nbsp;</td>
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
    <td colspan="2"  style="text-indent:40px; text-align:justify" >    
    <span class="textcolor">
    <?php 
   	$textDetail = str_replace( "<p>", "", $Detail);
	$textDetail = str_replace( "</p>", "", $textDetail);
   echo $textDetail; 
   ?>
   </span></td>
  </tr>
  
  <tr>
    <td colspan="2"  height="16"></td>
  </tr>

  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" >
	ในการนี้ <?php echo $get->getOrganizeName($OrgApprove); ?> จึงใคร่ขออนุมัติเบิกจ่ายงบประมาณ รวมเป็นเงินทั้งสิ้น 
    <span class="textcolor"><?php echo number_format($get->getSumCostCenter('tblintra_eform_advance_pay_cost','SumCost','DocCodePay','EFormCostId',$DocCodePay,0,$PrjActCode,0),2); ?></span> บาท   
    (<span class="textcolor"><?php echo JThaiBaht::_($get->getSumCostCenter('tblintra_eform_advance_pay_cost','SumCost','DocCodePay','EFormCostId',$DocCodePay,0,$PrjActCode,0)); ?></span>)
	โดยเบิกจ่ายจาก<span class="textcolor"><?php 
	if($mainDetail->SourceType=="Internal"){ echo "งบประมาณ สช.";}
	else if($mainDetail->SourceType=="External"){ 
		echo "เงินนอกงบประมาณ";
		echo "ของ".$get->getSourceExName($mainDetail->SourceExId);
	} 	
	?> </span> 
	 <span class="textcolor"><?php echo $get->getPItemName($mainDetail->PItemCode);?></span>
 	 <span class="textcolor"><?php echo $get->getPrjName($mainDetail->PrjId);?></span>
	กิจกรรม<span class="textcolor"><?php echo $get->getPrjActName($mainDetail->PrjActCode);?></span> (<span class="textcolor"><?php echo $mainDetail->PrjActCode;?></span>)
</td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" >จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติเบิกจ่ายต่อไปด้วย จะเป็นพระคุณ
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


<div style="padding-top:50px; text-align:center;">
<input name="print" type="button" value="พิมพ์เอกสาร"  onclick="window.print();" class="print" style="color:#009"  />
<input name="print" type="button" value="ปิดหน้าต่าง"  onclick="window.close();" class="print" style="color:#000"  />
</div>
