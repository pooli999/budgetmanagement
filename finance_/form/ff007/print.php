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
    <td align="right" valign="top" ><span class="textid"><?php echo $FormCodeAlias; ?></span></td>
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
    <td colspan="2"><div style="width:50px; float:left;">เรื่อง</div>
      <span class="textcolor"><?php echo $Topic; ?></span></td>
  </tr>
  <tr>
    <td colspan="2"><div style="width:50px; float:left;">เรียน</div>
      <span class="textcolor"><?php echo $DocTo; ?></span></td>
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
	<?php $dataRefer = $get->getDataDocCodeRefer($DocCodeRefer); //ltxt::print_r($dataRefer); ?>
      ตามบันทึกที่ สช.น <span class="textcolor"><?php echo $DocCodeRefer; ?></span> ลงวันที่ <span class="textcolor"><?php echo ShowDateLong($dataRefer[0]->DocDate); ?></span> สัญญายืมเงินฉบับที่ <span class="textcolor"><?php echo $get->getBorrowCode($DocCodeRefer); ?></span> ได้อนุมัติให้ยืมเงินทดรองจ่าย จำนวน <span class="textcolor"><?php echo number_format($dataRefer[0]->TotalBorrow,2); ?></span> บาท เพื่อใช้ในการประชุม <span class="textcolor"><?php echo $dataRefer[0]->Detail; ?></span> ณ <span class="textcolor"><?php echo ($Location)?$Location:'-'; ?></span> ในวันที่ <span class="textcolor"><?php echo ShowDateLong($StartDate);?></span> ถึงวันที่ <span class="textcolor"><?php echo ShowDateLong($EndDate);?></span> รวมเป็นเวลา <span class="textcolor"><?php echo ($AmountDate)?$AmountDate:'-'; ?></span> วัน 
โดยเบิกจ่ายจากงบของ
 <span class="textcolor"><?php echo $get->getSourceExName($SourceExId); ?></span>
 &nbsp;<span class="textcolor"><?php echo $get->getPItemName($BgtYear,$PItemCode); ?></span>
 &nbsp;<span class="textcolor"><?php echo $get->getPrjDetailName($PrjDetailId); ?></span>
 กิจกรรม&nbsp;<span class="textcolor"><?php echo $get->getPrjActName($PrjActCode); ?></span> (<span class="textcolor"><?php echo $PrjActCode; ?></span>)</td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify"> บัดนี้ได้ดำเนินการเสร็จเรียบร้อยแล้ว โดยมีค่าใช้จ่าย ดังนี้</td>
  </tr>
  <tr>
    <td colspan="2"  >
    <table  width="100%" border="0" cellspacing="1" cellpadding="0">
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
        <td style="text-align:right;">(<span class="textcolor"><?php echo JThaiBaht::_($TotalCost);?></span>) รวมเป็นเงิน</td>
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
    <td colspan="2"  >
<?php
$BGBorrow = $get->getSumBGBorrow($DocCodeRefer);
?>    
    <table  width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td style="width:40px;">&nbsp;</td>
        <td>ในการนี้ ใคร่ขอคืนเงินยืมทดรอง ดังนี้</td>
        <td  style="text-align:right; width:120px;" >&nbsp;</td>
        <td style="width:40px; text-align:right;">&nbsp;</td>
      </tr>
      <tr>
        <td style="width:40px;">&nbsp;</td>
        <td>สัญญายืมเงินทดรอง</td>
        <td  style="text-align:right; width:120px;" ><span class="textcolor"><?php echo number_format($BGBorrow,2);?></span></td>
        <td style="width:40px; text-align:right;">บาท</td>
        </tr>
      <tr>
        <td style="width:40px;">&nbsp;</td>
        <td>หัก ค่าใช้จ่าย (ใบเสร็จรับเงิน/ใบรับรองการจ่าย)</td>
        <td  style="text-align:right; width:120px;" ><span class="textcolor"><?php echo number_format($TotalCost,2);?></span></td>
        <td style="width:40px; text-align:right;">บาท</td>
        </tr>
<?php if($ReturnCost > 0){ ?>       
      <tr>
        <td style="width:40px;">&nbsp;</td>
        <td>[/] รับคืนเป็น
<?php 
switch($ClearType){
	case "cash":
		echo "เงินสด";
		break;
	case "transfer":
		echo "เงินโอน";
		break;
}
?>
        </td>
        <td  style="text-align:right; width:120px;" ><span class="textcolor"><?php echo number_format($ReturnCost,2);?></span></td>
        <td style="width:40px; text-align:right;">บาท</td>
        </tr>
<?php } ?>
<?php if($PlusCost > 0){ ?>       
      <tr>
        <td style="width:40px;">&nbsp;</td>
        <td>[/] เบิกเพิ่มเป็น
<?php 
switch($PlusType){
	case "cash":
		echo "เงินสด";
		break;
	case "transfer":
		echo "เงินโอน";
		break;
}
?>
        </td>
        <td  style="text-align:right; width:120px;" ><span class="textcolor"><?php echo number_format($PlusCost,2);?></span></td>
        <td style="width:40px; text-align:right;">บาท</td>
        </tr>
<?php } ?> 
    </table>
    
    </td>
  </tr>

  <tr>
    <td colspan="2" height="16"></td>
  </tr> 
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" >จึงเรียนมาเพื่อโปรดดำเนินการต่อไปด้วย จะเป็นพระคุณ</td>
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






</td>
</tr>
</table>


<div style="text-align:center; margin-top:20px; margin-bottom:20px;">
  <input type="button" name="print" value="พิมพ์ออกทางเครื่องพิมพ์" class="print" onClick="window.print();" />
  <input type="button" name="back" value="ย้อนกลับ" class="print" onClick="window.history.go(-1);" />
</div>
