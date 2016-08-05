<?php
	include("config.php");
	include($KeyPage."_helper.php");
	include($KeyPage."_data.php");
	$format = ltxt::getVar('format');
	if($format == 'raw'){ $get->getWord() ;}
	
	$TotalBGPrj = $get->getTotalPrj($BgtYearTo,$OrganizeCodeTo,$PItemCodeTo,$PrjIdTo,0,$PrjActCodeTo);	
	$TotalBGTransfer = $get->TotalBGTransfer($DocCode);	
	
	//ltxt::print_r($_REQUEST);
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
    <td align="right" valign="top" style="font-size:14pt;">แบบ FB001</td>
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

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
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
    <td colspan="2" >เรียน&nbsp;&nbsp;&nbsp;<span class="textcolor"><?php echo $DocTo; ?></span>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:44px; text-align:justify" >ตามที่ <span class="textcolor"><?php echo $get->getOrganizeName($OrganizeCodeTo); ?></span> ได้รับงบประมาณ จำนวนเงิน <span class="textcolor"><?php echo number_format($TotalBGPrj,2);?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($TotalBGPrj); ?></span>) ใน<span class="textcolor"><?php echo $get->getPrjName($PrjIdTo);?></span>นั้น ขณะนี้โครงการดังกล่าวได้มีค่าใช้จ่ายรวมผูกพันแล้วทั้งสิ้น  จำนวนเงิน <span class="textcolor"><?php echo number_format($SumChain,2);?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($SumChain); ?></span>) และคงเหลือเงินงบประมาณ จำนวนเงิน <span class="textcolor"><?php echo number_format($SumRemain,2);?></span> บาท  (<span class="textcolor"><?php echo JThaiBaht::_($SumRemain); ?></span>)
	</td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:44px; text-align:justify" ><span class="textcolor"><?php echo $Detail;?></span></td>
  </tr>     
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:44px; text-align:justify" >เนื่องจาก<span class="textcolor"><?php echo $get->getPrjName($PrjIdTo);?></span>มีกิจกรรมที่จะต้องดำเนินงานเพิ่มเติมในรายการดังต่อไปนี้ <span class="textcolor">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" >
	<?php 
	$actList = $get->getTransferItem($DocCode);
	 if($actList){
		 $count = 1;
			foreach($actList as $r){
				foreach( $r as $k=>$v){ ${$k} = $v;}
	?> 
          <tr  style="padding-bottom:5px">
            <td style="text-align:left; vertical-align:top; text-indent:44px;"><span class="textcolor"><?php echo $count.". ".$ItemName; ?></span></td>
            <td style="text-align:right; width:10%; vertical-align:top;">จำนวนเงิน</td>
            <td style="text-align:right; width:20%; vertical-align:top;padding-left:10px"><span class="textcolor"><?php echo number_format($ItemBudget,2);?></span> บาท</td>
          </tr>              

	<?php				
			$count++;
			}
		}
	?>	

        </table>      
    </span>
	</td>
  </tr>   
  <tr>
    <td colspan="2"  style=" text-align:justify" >รวมค่าใช้จ่ายทั้งสิ้น จำนวนเงิน <span class="textcolor"><?php echo number_format($get->getTotalBudget($DocCode),2);?></span> บาท </td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"   style="text-indent:44px; text-align:justify" >ดังนั้น <span class="textcolor"><?php echo $get->getOrganizeName($OrganizeCodeTo); ?></span> พิจารณาแล้วเห็นควรขอโอนเงินงบประมาณจากแผนงาน/โครงการ/กิจกรรม ดังต่อไปนี้
    <span class="textcolor">
	<?php 
$prjForBG = $get->getPrjForBudget($DocCode);	//ltxt::print_r($prjForBG);
 if($prjForBG){
     $bg = 1;
        foreach($prjForBG as $rb){	 
	?> 
	<div>
		<?php 
			echo $bg.".&nbsp;";
			if($rb->SourceType=="Internal"){ echo "งบประมาณ สช.";}
			else if($rb->SourceType=="External"){ 
				echo "เงินนอกงบประมาณของ";
				echo $get->getSourceExName($rb->SourceExId);
			} 	 
			echo "&nbsp;".$get->getPItemName($rb->PItemCode);
			echo "&nbsp;".$get->getPrjName($rb->PrjId);
			echo "&nbsp;กิจกรรม".$get->getPrjActName($rb->PrjActCode)."(".$rb->PrjActCode.")"; 
			echo "&nbsp;จำนวนเงิน ".number_format($rb->Budget,2)."&nbsp;บาท (".JThaiBaht::_($rb->Budget).")";
 		?>
  	</div>
	<?php				
			$bg++;
			}
		}
	?>	</span>    
    </td>
  </tr> 
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:44px; text-align:justify" >รวมงบประมาณที่ขอโอนเป็นจำนวนเงินทั้งสิ้น <span class="textcolor"><?php echo number_format($TotalBGTransfer,2);?></span> บาท มาสมทบ<span class="textcolor"><?php 
	if($SourceTypeTo=="Internal"){ echo "งบประมาณ สช.";}
	else if($SourceTypeTo=="External"){ 
		echo "เงินนอกงบประมาณของ";
		echo $get->getSourceExName($SourceExIdTo);
	} 
	?>   
	<?php echo $get->getPItemName($PItemCodeTo);?>  
    <?php echo $get->getPrjName($PrjIdTo);?>  </span>
    กิจกรรม<span class="textcolor"><?php echo $get->getPrjActName($PrjActCodeTo);?>  (<?php echo $PrjActCodeTo;?>) </span>
    </td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:44px; text-align:justify" >จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติโอนเงินงบประมาณเพื่อใช้ในการดำเนินงานต่อไปด้วย จะเป็นพระคุณ  
	</td>
  </tr>   
  </table>
  
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
   <tr>
    <td colspan="2"  height="50"></td>
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

