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
    <td align="right" valign="top" style="font-size:14pt;"><?php echo $FormCodeAlias; ?></td>
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
    <td colspan="2">เรื่อง&nbsp;<span class="textcolor"><?php echo $Topic; ?></span></td>
 </tr>
   <tr>
    <td colspan="2">เรียน&nbsp;<span class="textcolor"><?php echo $DocTo; ?></span></td>
 </tr>
  <tr>
    <td colspan="2" style="vertical-align:top;"><table  width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td style="width:80px; vertical-align:top;">เอกสารแนบ</td>
        <td class="textcolor"><?php 
				$attachList = $get->getAttachList($DocCode);//ltxt::print_r($costList);
				 if($attachList){
						$no = 1;
						foreach($attachList as $at){
							foreach( $at as $att=>$ath){ ${$att} = $ath;}
						?>
          <div>
            <?php if(count($attachList)>1){ echo $no; ?>
            )
            <?php } echo $AttachName; ?>
          </div>
          <?php 
							$no++;
						} 
				 }else{
					 echo "-";
				 }
				?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify">
<?php 
$dataRefer = $get->getDataDocCodeRefer($DocCodeRefer); //ltxt::print_r($dataRefer); 
$SumBGChain = $get->getSumBGChain($DocCodeRefer);
?>

      อ้างถึงบันทึกข้อความขออนุมัติเลขที่ <span class="textcolor"><?php echo $DocCodeRefer; ?></span>  ซึ่งได้รับการอนุมัติ <span class="textcolor"><?php echo $dataRefer[0]->Title; ?></span> ปีงบประมาณ <span class="textcolor"><?php echo $BgtYear; ?></span> ในวงเงิน <span class="textcolor"><?php echo number_format($SumBGChain,2); ?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($SumBGChain); ?></span>) รายละเอียดตามเอกสารที่แนบท้ายนี้ </td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify"> บัดนี้ ข้าพเจ้า <span class="textcolor"><?php echo $get->fn_getFullNameByPersonalCode($RQPersonalCode); ?></span> มีความประสงค์จะ <span class="textcolor"><?php echo $Detail; ?></span>  โดยมีค่าใช้จ่ายดังนี้ </td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  >
    <table  width="100%" border="0" cellspacing="1" cellpadding="0">
    <tr>
        <td>&nbsp;</td>
        <td colspan="3">รายการขอวางบิลเบิกจ่าย</td>
      </tr>
      <?php 
$gCostItemCode = $get->getImpCostItemCode($DocCode);//ltxt::print_r($gCostItemCode);
$dataCost = $get->getCostDetail($DocCode);//ltxt::print_r($dataCost);
$m=0;
$TotalCost=0;
if($gCostItemCode[0]->CostItemCode){
	foreach($gCostItemCode as $gCostItemCoderow){
		foreach($gCostItemCoderow as $gg=>$qq){	${$gg} = $qq;	}
		$sumSumCost = $get->getSumSumCost($DocCode,$CostItemCode);
		$TotalCost =  $TotalCost+$sumSumCost;
?>
      <tr>
        <td style="width:40px;">&nbsp;</td>
        <td><?php echo ($m+1); ?>) <span class="textcolor"><?php echo $get->getCostItemName($CostItemCode);?></span></td>
        <td  style="text-align:right; width:120px;" ><span class="textcolor"><?php echo number_format($sumSumCost,2);?></span></td>
        <td style="width:40px; text-align:right;">บาท</td>
      </tr>
      <?php
	for($i=0; $i<count($dataCost);$i++){
		if($dataCost[$i]->DetailCost != ""){
			if($dataCost[$i]->CostItemCode == $CostItemCode){

?>
      <tr>
        <td style="padding-left:15px;">&nbsp;</td>
        <td style="padding-left:15px;"><span class="textcolor">- <?php echo $dataCost[$i]->DetailCost;?></span>&nbsp;(<span class="textcolor"><?php echo number_format($dataCost[$i]->SumCost,2);?></span>&nbsp;บาท)</td>
        <td  style="text-align:right;" >&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <?php 
				}
			}
		} 
		$m++;
	}
}
?>
      <?php 
if($gCostItemCode[0]->CostItemCode){
?>
      <tr>
        <td style="text-align:right;">&nbsp;</td>
        <td style="text-align:right;">(<?php echo JThaiBaht::_($TotalCost);?>) รวมเป็นค่าใช้จ่ายทั้งสิ้น</td>
        <td  style="text-align:right;"><span class="textcolor"><?php echo number_format($TotalCost,2);?></span></td>
        <td style="text-align:right;">บาท</td>
      </tr>
      <?php }else{ ?>
      <tr>
        <td colspan="4" style="text-align:center;">-ไม่พบรายการ-</td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
    <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  >
    
    
    
<table  width="100%" border="0" cellspacing="1" cellpadding="0">
<?php 
$gOtherCostItemCode = $get->getImpOtherCostItemCode($DocCode);//ltxt::print_r($gCostItemCode);
$dataOtherCost = $get->getOtherCostDetail($DocCode);//ltxt::print_r($dataCost);
if($gOtherCostItemCode[0]->CostItemCode){
?>   
    <tr>
        <td>&nbsp;</td>
        <td colspan="3">รายการขอเบิกจ่าย (กรณีไม่ได้ขออนุมัติไว้ก่อน)</td>
      </tr>
<?php 
}
$m=0;
$TotalCostOther=0;
if($gOtherCostItemCode[0]->CostItemCode){
	foreach($gOtherCostItemCode as $gOtherCostItemCoderow){
		foreach($gOtherCostItemCoderow as $gg=>$qq){	${$gg} = $qq;	}
		$sumOtherSumCost 	= $get->getOtherSumSumCost($DocCode,$CostItemCode);
		$TotalCostOther =  $TotalCostOther+$sumOtherSumCost;
?>
      <tr>
        <td style="width:40px;">&nbsp;</td>
        <td><?php echo ($m+1); ?>) <span class="textcolor"><?php echo $get->getCostItemName($CostItemCode);?></span></td>
        <td  style="text-align:right; width:120px;" ><span class="textcolor"><?php echo number_format($sumOtherSumCost,2);?></span></td>
        <td style="width:40px; text-align:right;">บาท</td>
      </tr>
      <?php
	for($i=0; $i<count($dataOtherCost);$i++){
		if($dataOtherCost[$i]->OtherDetailCost != ""){
			if($dataOtherCost[$i]->CostItemCode == $CostItemCode){

?>
      <tr>
        <td style="padding-left:15px;">&nbsp;</td>
        <td style="padding-left:15px;"><span class="textcolor">- <?php echo $dataOtherCost[$i]->OtherDetailCost;?></span>&nbsp;(<span class="textcolor"><?php echo number_format($dataOtherCost[$i]->OtherSumCost,2);?></span>&nbsp;บาท)</td>
        <td  style="text-align:right;" >&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <?php 
				}
			}
		} 
		$m++;
	}
}
?>
      <?php 
if($gOtherCostItemCode[0]->CostItemCode){
?>
      <tr>
        <td style="text-align:right;">&nbsp;</td>
        <td style="text-align:right;">(<?php echo JThaiBaht::_($TotalCostOther);?>) รวมเป็นค่าใช้จ่ายทั้งสิ้น</td>
        <td  style="text-align:right;"><span class="textcolor"><?php echo number_format($TotalCostOther,2);?></span></td>
        <td style="text-align:right;">บาท</td>
      </tr>
      <tr>
        <td colspan="4" height="16"></td>
      </tr>
      <?php } ?>
    </table>
    
    </td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" > 
    จึงใคร่ขออนุมัติเบิกจ่ายงบประมาณ เป็นจำนวนเงิน <span class="textcolor"><?php echo number_format(($TotalCost+$TotalCostOther),2);?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($TotalCost+$TotalCostOther); ?></span>)
    โดยใช้งบของ 
    <span class="textcolor"><?php echo $get->getSourceExName($SourceExId); ?></span> &nbsp;<span class="textcolor"><?php echo $get->getPItemName($BgtYear,$PItemCode); ?></span> &nbsp;<span class="textcolor"><?php echo $get->getPrjDetailName($PrjDetailId); ?></span> กิจกรรม&nbsp;<span class="textcolor"><?php echo $get->getPrjActName($PrjActCode); ?></span> (<span class="textcolor"><?php echo $PrjActCode; ?></span>) ภายในวงเงินดังกล่าวด้วย จะเป็นพระคุณ </td>
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
    	<td colspan="3" style="height:20px;"></td>
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
        <td style="width:200px; border-bottom:1px dotted #999;">&nbsp;</td>
        <td align="right">ผู้เบิก</td>
    </tr>
    <tr>
    	<td style="text-align:right; padding-top:5px;">(</td>
        <td style="padding-top:5px; text-align:center;"><span class="textcolor"><?php echo $get->fn_getFullNameByPersonalCode($RQPersonalCode); ?></span></td>
        <td style="padding-top:5px;">)</td>
    </tr>
    </table>        
        
</td>
</tr>

</table>




