<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

//ltxt::print_r($detail);	

$detailCodeRefer = $get->getDetailCodeRefer($DocCodeRefer);
//ltxt::print_r($detailCodeRefer);	
if($detailCodeRefer){
	foreach( $detailCodeRefer as $k=>$v){ ${$k} = $v;}
}

?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	//window.print();
/*  ]]> */
</script>
<style>
td{
	font-size:14px; 
}

</style>
<style type="text/css" media="print">
   .print{ display:none;}
</style>


<table width="610" border="0" cellspacing="0" cellpadding="0" align="center"  bgcolor="#FFFFFF"  bordercolor="#FFFFFF">
  <tr>
    <td align="left" valign="top" >
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		  <tr>
		    <td rowspan="3" align="left" valign="top" ><img src="images/logo.png" border="0" width="59" height="51"/></td>
		    <td align="left" style="font-weight:bold; font-size:12px;">สำนักงานคณะกรรมการสุขภาพแห่งชาติ</td>
		  </tr>
			<tr>
			  <td align="left" style="font-size:10px;">ชั้น 3 อาคารสุขภาพแห่งชาติ 88/39 ถ.ติวานนท์ 14 หมู่ที่ 4 ต.ตลาดขวัญ อ.เมือง จ.นนทบุรี 11000</td>
			</tr>
			<tr>
			  <td align="left" style="font-size:10px;">โทร: 66 2832 9000 โทรสาร: 66 2832 9001 www.nationalhealth.or.th </td>
			</tr>
	  </table>
    </td>
    <td align="right" ><div style="font-weight:bold; font-size:17px;">แบบ สช.บ.008</div></td>
  </tr>
</table>
<table width="610" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr>
    <td colspan="2" height="25"></td>
  </tr>
  <tr>
    <td width="300" >ที่ สช.น. <?php echo $DocCode; ?>&nbsp;</td>
    <td width="310" >&nbsp;</td>
  </tr>
  <tr>
    <td width="300" >&nbsp;</td>
    <td width="310" >วันที่ <?php echo ShowDate($DocDate);?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" height="15"></td>
  </tr>    
   <tr>
    <td colspan="2" >เรื่อง&nbsp;&nbsp;&nbsp;<?php echo $Topic; ?></td>
  </tr>
  <tr>
    <td colspan="2" >เรียน&nbsp;&nbsp;&nbsp;<?php echo $DocTo; ?></td>
  </tr>
  <tr>
    <td colspan="2" height="18"></td>
  </tr>  
  <tr>
    <td colspan="2"  style="line-height:160%; text-indent:40px; text-align:justify" >
    ตามบันทึกที่  สช.น. <?php echo $DocCodeRefer; ?> ลงวันที่ <?php echo ShowDate($DocDateRefer);?> สัญญายืมเงินฉบับที่ .............. ได้อนุมัติให้ยืมเงินทดรองจ่ายจำนวน..... บาท <?php echo $DetailRefer;?>
    ณ <?php echo $LocationRefer; ?> ตั้งแต่วันที่ <?php echo ShowDate($StartDateRefer);?> ถึงวันที่  <?php echo ShowDate($EndDateRefer);?>
	โดยเบิกจ่ายจาก<?php 
	if($SourceType=="Internal"){ echo "งบประมาณแผ่นดิน";}
	else if($SourceType=="External"){ 
		echo "เงินนอกงบประมาณ";
		echo "ของ".$get->getSourceExName($SourceExId);
	} 	
	?>  
แผนงาน	 <?php echo $get->getPItemName($PItemCode);?>	
โครงการ <?php echo $get->getPrjName($PrjId);?> 
กิจกรรม	 <?php echo $get->getPrjActName($PrjActCode);?>    
<br>
บัดนี้ ได้ดำเนินการเสร็จเรียบร้อยแล้ว โดยมีค่าใช้จ่ายดังนี้    
    </td>
  </tr>
  <tr>
    <td colspan="2"  >
<table width="100%" border="0" cellspacing="0" cellpadding="5">

        <?php
		$costList = $get->getClearCostItemList($DocCode);
		//ltxt::print_r($costList);
		 if($costList){
			 	$i=1;
				foreach($costList as $rc){
					foreach( $rc as $k=>$v){ ${$k} = $v;}
		?>

          <tr  style="padding-bottom:10px">
            <td style="width:40px; ">&nbsp;</td>
            <td style="text-align:left; vertical-align:top"><?php echo $i.". ".$DetailCost;  //$get->getCostItemName($CostItemCode)." (".$DetailCost.")"; ?></td>
            <td style="text-align:right; width:10%; vertical-align:top;">เป็นเงิน</td>
            <td style="text-align:right; width:20%; vertical-align:top;padding-left:10px"><?php echo number_format($SumCost,2);?> บาท</td>
          </tr>
        <?php $i++; } }?>    
        <tr>
        <td style="text-align:right" colspan="3">(<?php echo JThaiBaht::_($get->getSumCostClear($DocCodeCost,$PrjActCodeCost,0,0)); ?>) รวมเป็นเงิน</td>
        <td style="text-align:right"><?php echo number_format($get->getSumCostClear($DocCodeCost,$PrjActCodeCost,0,0),2);?> บาท</td>
        </tr>
        </table>    
    
    </td>
  </tr>
  <tr>
  	<td  colspan="2">
    ในการนี้ ใคร่ขอคืนเงินยืมทดรอง ดังนี้<br />
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
    <td>สัญญายืมเงินทดรอง</td>
    <td style="text-align:right">บาท</td>
    </tr>
    <tr>
    <td>หักค่าใช้จ่าย (ใบเสร็จรับเงิน / ใบรับรองการจ่าย)</td>
    <td style="text-align:right">บาท</td>
    </tr>
    <tr>
    <td><input name="" type="checkbox" value="" /> รับคืนเป็น</td>
    <td style="text-align:right">บาท</td>
    </tr>    
    <tr>
    <td><input name="" type="checkbox" value="" /> จ่ายเพิ่มเป็น</td>
    <td style="text-align:right">บาท</td>
    </tr>    
        
	</table>
 	</td>
  </tr>
  <tr>
    <td colspan="2" height="18"></td>
  </tr>  
  <tr>
    <td colspan="2"  style="line-height:160%; text-indent:40px; text-align:justify" >จึงเรียนมาเพื่อโปรดดำเนินการต่อไปด้วย  จะเป็นพระคุณ</td>
  </tr>
    <tr>
    <td colspan="2" height="25"></td>
  </tr>  
</table>

<table border="0" cellspacing="0" cellpadding="0"  align="center"  >
   <tr>
    <td style="text-align:center; line-height:160%;padding-left:166px; ">
	................................... ผู้เบิก<br />	
	(<?php echo fn_getFullNameByUserId($CreateBy);?>)<br />
	</td>
  </tr>  
</table>
<br />

<table border="0" cellspacing="0" cellpadding="0"  align="center"  >
   <tr>
    <td style="text-align:center; line-height:160%;padding-left:166px; ">
	................................... ผู้อนุมัติ<br />	
	(...................................)<br />
	.........../............./...........
	</td>
  </tr>  
</table>

<div style="padding-top:50px; text-align:center;">
<input name="print" type="button" value="พิมพ์เอกสาร"  onclick="window.print();" class="print" style="color:#009"  />
<input name="print" type="button" value="ปิดหน้าต่าง"  onclick="window.close();" class="print" style="color:#000"  />
</div>
