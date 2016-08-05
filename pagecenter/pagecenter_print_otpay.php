<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

//ltxt::print_r($detail);	

$DataG = $get->getDetailGeneral('tblintra_eform_formal_ot','DocCode',$DocCode);	//ltxt::print_r($DataG);	

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
    <td align="right" valign="top" ><span class="textid">แบบ FH006</span></td>
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
    <td colspan="2"  height="16"></td>
  </tr>
  <tr>
    <td width="50%" >ที่ สช.น. <span class="textcolor"><?php echo $DocCodePay; ?></span>&nbsp;</td>
    <td width="50%" >วันที่ <span class="textcolor"><?php echo ShowDateLong($DocDate);?></span>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" >
    	เรื่อง&nbsp;&nbsp;&nbsp;<span class="textcolor"><?php echo $Topic; ?></span>&nbsp;
    </td>
  </tr>
  <tr>
    <td colspan="2" valign="middle"><hr></hr></td>
  </tr>   
  
  <tr>
    <td colspan="2" >เรียน&nbsp;&nbsp;&nbsp;<span class="textcolor"><?php echo $DocTo; ?></span></td>
  </tr>
  <tr>
    <td colspan="2" >
    		สิ่งที่แนบมาด้วย&nbsp;&nbsp;&nbsp;1. แบบควบคุมการปฏิบัติงานล่วงเวลา(DH001) <br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            2. ใบสำคัญรับเงิน (DF003)
    </td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>  
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" >
    ข้าพเจ้า <span class="textcolor"><?php echo fn_getFullNameByPersonalCode($PayPersonalCode);?> <?php echo $get->getPositionName($PayPositionId); ?>  <?php echo $get->getOrganizeName($PayOrgApprove); ?></span> มีความประสงค์จะเบิกเงินในการปฏิบัติงานล่วงเวลา ให้ผู้เข้าร่วมปฏิบัติงาน จำนวน <span class="textcolor"><?php echo count($get->getTaskPersonOtPay($DocCodePay));?></span> คน ดังต่อไปนี้
      <span class="textcolor">
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
           <?php 
            $TaskPerson = $get->getTaskPersonOtPay($DocCodePay); 
            $i=1;
			$TotalCostPay = 0;
           foreach($TaskPerson as $rRName){
/*                foreach($rRName as $k=>$v){
                    ${$k} = $v;
                }*/
                $TotalCostPay = $TotalCostPay+$rRName->SumCostPay;
            ?>	
              <tr >
                <td style="width:40%; vertical-align:top; padding-left:40px"><span class="textcolor"><?php echo $i.". ".fn_getFullNameByPersonalCode($rRName->PersonalCode);?></span></td>
                <td style="width:25%; vertical-align:top">ตำแหน่ง <span class="textcolor"><?php echo $get->getPositionByPersonalCode($rRName->PersonalCode);?></span> </td>
                <td style="width:10%; vertical-align:top; text-align:right">จำนวน</td>
                <td style="width:20%; vertical-align:top; text-align:right"><span class="textcolor"><?php echo $rRName->SumCostPay;?></span> บาท</td>
              </tr>
        <?php  $i++; }	?>
        		<tr><td colspan="3" height="5"></td></tr>
        	   <tr>
               		<td colspan="3" style="text-align:right;">(<span class="textcolor"><?php echo JThaiBaht::_($TotalCostPay); ?></span>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รวมทั้งสิ้น</td>
                    <td style="vertical-align:top; text-align:right"><span class="textcolor"><?php echo number_format($TotalCostPay,2);?></span> บาท</td>
               </tr>
        </table>
		
    </td>
  </tr>

  <tr>
  <td colspan="2" style="text-align:justify;" >ในวันที่  <span class="textcolor"><?php echo ShowDateLong($StartDate);?></span> ถึงวันที่  <span class="textcolor"><?php echo ShowDateLong($EndDate);?></span> รวมเป็นเวลา <span class="textcolor"><?php  echo $get->getdays($StartDate,$EndDate); ?></span> วัน มีกิจกรรมการปฏิบัติงาน ดังนี้  

	</td>
  </tr>
  <tr>
    <td  colspan="2" style="text-align:justify; padding-left:40px;"><span class="textcolor"><?php echo $Detail; ?></span></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-align:justify; " >โดยเบิกจ่ายภายในวงเงินงบประมาณ <span class="textcolor"><?php echo number_format($TotalCostPay,2); ?></span> บาท  (<span class="textcolor"><?php echo JThaiBaht::_($TotalCostPay); ?></span>)
    จาก<span class="textcolor"><?php 
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
    <td colspan="2" height="16"></td>
  </tr>  
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" >จึงใครขออนุมัติเบิกจ่ายค่าใช้จ่ายดังกล่าว โดยมี <span class="textcolor"><?php echo fn_getFullNameByPersonalCode($PayPersonalCode);?></span> เป็นผู้ควบคุม และเบิกจ่ายค่าปฏิบัติงานล่วงเวลาจากแผนงานโครงการและกิจกรรมดังกล่าวด้วย จะเป็นพระคุณ
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
            (.......................................................) &nbsp;&nbsp;<br />
            ....................................................... &nbsp;&nbsp;<br /><br />
           ................./................../................ &nbsp;&nbsp;<br />
        </td>
        </tr>
     </table>

</td>
<td  width="50%" align="right" valign="top">&nbsp;</td></tr></table>

</td>
</tr>
</table>


<div style="padding-top:50px; text-align:center;">
<input name="print" type="button" value="พิมพ์เอกสาร"  onclick="window.print();" class="print" style="color:#009"  />
<input name="print" type="button" value="ปิดหน้าต่าง"  onclick="window.close();" class="print" style="color:#000"  />
</div>
