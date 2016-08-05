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
    <td align="right" valign="top" ><span class="textid">แบบ FF003</span></td>
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
    <td width="50%" >ที่ สช.น. <span class="textcolor"><?php echo $ClearDocCode; ?></span>&nbsp;</td>
    <td width="50%" >วันที่ <span class="textcolor"><?php echo ShowDateLong($ClearDocDate);?></span>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" >เรื่อง&nbsp;&nbsp;&nbsp;<span class="textcolor"><?php echo $ClearTopic; ?></span>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="middle"><hr></hr></td>
  </tr>  
  <tr>
    <td colspan="2" >เรียน&nbsp;&nbsp;&nbsp;<span class="textcolor"><?php echo $ClearDocTo; ?></span></td>
  </tr>
  <tr>
    <td colspan="2"  height="16"></td>
  </tr>

  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" >ตามบันทึกที่  สช.น. <span class="textcolor"><?php echo $mainDetail->DocCode; ?></span> ลงวันที่ <span class="textcolor"><?php echo ShowDate($mainDetail->DocDate);?></span> ได้อนุมัติให้ยืมเงินทดรองจ่ายจำนวน <span class="textcolor"><?php echo number_format($get->getSumCostCenter('tblintra_eform_advance_cost','BorrowBudget','DocCode','EFormCostId',$mainDetail->DocCode,0,$mainDetail->PrjActCode,0),2); ?></span> บาท   (<span class="textcolor"><?php echo JThaiBaht::_($get->getSumCostCenter('tblintra_eform_advance_cost','BorrowBudget','DocCode','EFormCostId',$mainDetail->DocCode,0,$mainDetail->PrjActCode,0)); ?></span>) เพื่อใช้ในการ<?php echo $mainDetail->Topic; ?>
    <span class="textcolor">
    <?php 
 /*  	$textDetail = str_replace( "<p>", "", $mainDetail->Detail);
	$textDetail = str_replace( "</p>", "", $textDetail);
   echo $textDetail; */
   ?>
   </span>
    ณ <span class="textcolor"><?php echo $mainDetail->Location; ?></span> ตั้งแต่วันที่ <span class="textcolor"><?php echo ShowDate($mainDetail->StartDate);?></span> ถึงวันที่ <span class="textcolor"><?php echo ShowDate($mainDetail->EndDate);?></span>
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
<br>
บัดนี้ ได้ดำเนินการเสร็จเรียบร้อยแล้ว โดยมีค่าใช้จ่าย ดังนี้    
    </td>
  </tr>
  <tr>
    <td colspan="2"  >
    
        <table width="100%" border="0" cellspacing="0" cellpadding="3" >

        <?php
		$costList = $get->getCostItemList($DocCode);
		//ltxt::print_r($costList);
		 if($costList){
			 	$i=1;
				foreach($costList as $rc){
					foreach( $rc as $k=>$v){ ${$k} = $v;}
		?>
          <tr  style="padding-bottom:10px; ">
			<td style="vertical-align:top; width:64%;text-indent:40px; " ><span class="textcolor"><?php echo $i.". ".$get->getCostItemName($CostItemCode)." (".$DetailCost.")"; ?></span></td>
            <td style="text-align:right; width:20%; vertical-align:top;padding-left:10px">เป็นเงิน</td>
            <td style="text-align:right; width:16%; vertical-align:top;padding-left:10px"><span class="textcolor"><?php echo number_format($BorrowBudget,2); ?></span> บาท</td>
          </tr>
        <?php $i++; } }?>    
          <tr>
          <td style="text-align:right; " colspan="2" >(<span class="textcolor"><?php echo JThaiBaht::_($get->getSumCostCenter('tblintra_eform_advance_cost','BorrowBudget','DocCode','EFormCostId',$mainDetail->DocCode,0,$mainDetail->PrjActCode,0)); ?></span>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รวมทั้งสิ้น</td>
          <td style="text-align:right;padding-left:10px; font-weight:bold;"><span class="textcolor"><?php echo number_format($get->getSumCostCenter('tblintra_eform_advance_cost','BorrowBudget','DocCode','EFormCostId',$mainDetail->DocCode,0,$mainDetail->PrjActCode,0),2); ?></span> บาท</td>
          </tr>
        </table>
    
    </td>
  </tr>
  <tr>
    <td colspan="2"   >
    <?php 
		$ReturnBG = $get->getSumCostCenter('tblintra_eform_advance_cost_clear','ReturnBudget','ClearDocCode','ClearItemId',$ClearDocCode,0,0,0);
		$PlusBG = $get->getSumCostCenter('tblintra_eform_advance_cost_clear','PlusBudget','ClearDocCode','ClearItemId',$ClearDocCode,0,0,0);
	?>
    <div style="text-indent:40px">ในการนี้ใคร่ขอคืนเงินยืมทดรอง ดังนี้</div>
    <table width="100%" border="0" cellspacing="0" cellpadding="3" >
       <tr  style="padding-bottom:10px; ">
		<td style="vertical-align:top; width:64%;text-indent:40px; " >รับคืน</td>
        <td style="text-align:right; width:20%; vertical-align:top;padding-left:10px">เป็นเงิน</td>
        <td style="text-align:right; width:16%; vertical-align:top;padding-left:10px"><span class="textcolor"><?php echo number_format($ReturnBG,2); ?></span> บาท</td>
     </tr>
       <tr  style="padding-bottom:10px; ">
		<td style="vertical-align:top; width:64%;text-indent:40px; " >จ่ายเพิ่ม</td>
        <td style="text-align:right; width:20%; vertical-align:top;padding-left:10px">เป็นเงิน</td>
        <td style="text-align:right; width:16%; vertical-align:top;padding-left:10px"><span class="textcolor"><?php echo number_format($PlusBG,2); ?></span> บาท</td>
     </tr>     
    </table>

	</td>
  </tr>  
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" >จึงเรียนมาเพื่อโปรดดำเนินการต่อไปด้วย จะเป็นพระคุณ
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


<div style="padding-top:50px; text-align:center;">
<input name="print" type="button" value="พิมพ์เอกสาร"  onclick="window.print();" class="print" style="color:#009"  />
<input name="print" type="button" value="ปิดหน้าต่าง"  onclick="window.close();" class="print" style="color:#000"  />
</div>
