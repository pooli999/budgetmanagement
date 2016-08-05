<?php
	include("config.php");
	include($KeyPage."_helper.php");
	include($KeyPage."_data.php");
	$format = ltxt::getVar('format');
	if($format == 'raw'){ $get->getWord() ;}



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
    <td align="right" valign="top" style="font-size:14pt;">แบบ FF001</td>
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
    <td width="50%" >&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" >&nbsp;</td>
    <td width="50%" >วันที่ <span class="textcolor"><?php echo ShowDateLong($DocDate);?></span>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>    
   <tr>
    <td colspan="2" >เรื่อง&nbsp;&nbsp;&nbsp;<span class="textcolor"><?php echo $Topic; ?></span></td>
  </tr>
  <tr>
    <td colspan="2" >เรียน&nbsp;&nbsp;&nbsp;<span class="textcolor"><?php echo $DocTo; ?></span></td>
  </tr>
  <tr>
    <td colspan="2" >เอกสารแนบ&nbsp;&nbsp;&nbsp;สัญญายืมเงิน (แบบ สช.บ.007)</td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>  
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" >เนื่องด้วย ข้าพเจ้า<span class="textcolor"><?php echo fn_getFullNameByPersonalCode($PersonalCode);?></span> มีความประสงค์จะ<span class="textcolor"><?php echo $Detail; ?></span> ณ <span class="textcolor"><?php echo $Location; ?></span> ในวันที่ <span class="textcolor"><?php echo ShowDateLong($StartDate);?></span> ถึงวันที่  <span class="textcolor"><?php echo ShowDateLong($EndDate);?></span> รวมเวลา <span class="textcolor"><?php  echo $get->getdays($StartDate,$EndDate); ?></span> วัน	ซึ่งมีผู้เข้าร่วมประชุมจำนวน <span class="textcolor"><?php echo $AmountPerson; ?></span> คน  โดยมีค่าใช้จ่ายดังนี้   </td>
  </tr>
  <tr>
    <td colspan="2"  >
    
        <table width="100%" border="0" cellspacing="0" cellpadding="3" >
        <tr >
       <!-- <td style="text-align:center">ลำดับ</td>-->
        <td style="text-align:center; font-weight:bold;">&nbsp;</td>
        <td style="text-align:right; font-weight:bold;">งบประมาณ (บาท)</td>
        <td style="text-align:right;  font-weight:bold;">ยืมเงิน (บาท)</td>
        </tr>
		
        <?php
		$costList = $get->getCostItemList($DocCode);
		//ltxt::print_r($costList);
		 if($costList){
			 	$i=1;
				foreach($costList as $rc){
					foreach( $rc as $k=>$v){ ${$k} = $v;}
		?>
          <tr  style="padding-bottom:10px; ">
			<td style="vertical-align:top; width:64%" ><span class="textcolor"><?php echo $i.". ".$get->getCostItemName($CostItemCode)." (".$DetailCost.")"; ?></span></td>
            <td style="text-align:right; width:20%; vertical-align:top;padding-left:10px"><span class="textcolor"><?php echo number_format($SumCost,2);?></span></td>
            <td style="text-align:right; width:16%; vertical-align:top;padding-left:10px"><span class="textcolor"><?php echo number_format($BorrowBudget,2); ?></span></td>
          </tr>
        <?php $i++; } }?>    
          <tr>
          <td style="text-align:right; font-weight:bold;" >รวมเป็นค่าใช้จ่ายทั้งสิ้น</td>
          <td style="text-align:right;padding-left:10px; font-weight:bold;"><span class="textcolor"><?php echo number_format($get->getSumCost($DocCode,$PrjActCode,0,0),2); ?></span></td>
          <td style="text-align:right;padding-left:10px; font-weight:bold;"><span class="textcolor"><?php echo number_format($get->getSumCostBorrow($DocCode,$PrjActCode,0,0),2); ?></span></td>
          </tr>
<!--          <tr style="line-height:160%">
          <td >&nbsp;</td>
          <td colspan="2" style="text-align:right;">(<?php //echo JThaiBaht::_($get->getSumCost($DocCode,$PrjActCode,0,0)); ?>)</td>
          </tr>-->
          
          
        </table>
    
    </td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>  
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" >จึงใครขออนุมัติจัดประชุมและยืมเงินทดรองเป็นจำนวนเงิน <span class="textcolor"><?php echo number_format($get->getSumCostBorrow($DocCode,$PrjActCode,0,0),2); ?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($get->getSumCostBorrow($DocCode,$PrjActCode,0,0)); ?></span>)
    และขอวางบิล/เบิกจ่ายในภายหลัง เป็นจำนวนเงิน <span class="textcolor"><?php echo number_format($get->getSumCost($DocCode,$PrjActCode,0,0)-$get->getSumCostBorrow($DocCode,$PrjActCode,0,0),2);  ?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($get->getSumCost($DocCode,$PrjActCode,0,0)-$get->getSumCostBorrow($DocCode,$PrjActCode,0,0));?></span>)
    โดยใช้<span class="textcolor"><?php 
	if($SourceType=="Internal"){ echo "งบประมาณ สช.";}
	else if($SourceType=="External"){ 
		echo "เงินนอกงบประมาณ";
		echo "ของ".$get->getSourceExName($SourceExId);
	} 	
	?>  
<?php echo $get->getPItemName($PItemCode);?>	
<?php echo $get->getPrjName($PrjId);?> </span>
กิจกรรม<span class="textcolor"><?php echo $get->getPrjActName($PrjActCode);?></span>   (<span class="textcolor"><?php echo $PrjActCode; ?></span>) ภายในวงเงินดังกล่าวด้วย จะเป็นพระคุณ
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



