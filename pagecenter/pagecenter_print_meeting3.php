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
    <td valign="top">

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"  bgcolor="#FFFFFF"  bordercolor="#FFFFFF">
  <tr>
    <td align="right" valign="top" ><span class="textid">แบบ FF007</span></td>
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


<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
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
    <td colspan="2"  style="text-indent:40px; text-align:justify" >เนื่องด้วย ข้าพเจ้า<span class="textcolor"><?php echo fn_getFullNameByPersonalCode($PayPersonalCode);?></span> มีความประสงค์จะเบิกจ่ายเงินเพื่อ<span class="textcolor"><?php $textDetail = str_replace( "<p>", "", $Detail); $textDetail = str_replace( "</p>", "", $textDetail); echo $textDetail; ?></span> ณ <span class="textcolor"><?php echo $Location; ?></span> ในวันที่ <span class="textcolor"><?php echo ShowDateLong($StartDate);?></span> ถึงวันที่  <span class="textcolor"><?php echo ShowDateLong($EndDate);?></span> รวมเป็นเวลา <span class="textcolor"><span id="countdate"><?php  echo $get->getdays($StartDate,$EndDate); ?></span></span> วัน ซึ่งมีผู้เข้าร่วมปฏิบัติงาน จำนวน <span class="textcolor"><?php //echo ($get->countperson('tblintra_eform_formal_meeting_person','DocCode',$DocCode))+($get->countperson('tblintra_eform_formal_meeting_personexternal','DocCode',$DocCode)); ?><?php echo $AmountPerson; ?></span> คน  โดยมีรายการค่าใช้จ่ายดังนี้</td>
  </tr>
  <tr>
    <td colspan="2"  height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  valign="top" >
		
	<table width="100%" border="0" cellspacing="1" cellpadding="0"   align="center">
<!--        <tr>
            <td style="text-align:left;vertical-align:top; padding-left:44px;" colspan="3"><u>รายการค่าใช้จ่ายที่คาดการณ์ไว้ก่อน :</u></td>
        </tr>-->
        <?php 		
        $groupList = $get->getCostGroupGeneral('tblintra_eform_formal_meeting_pay_cost','DocCodePay','CostIdPay',$DocCodePay);
        //ltxt::print_r($groupList);
        if($groupList){
            $i=1;
            foreach($groupList as $rg){
         ?>
        
                  <tr>
                    <td style="text-align:left;vertical-align:top; padding-left:44px;" colspan="3"><span class="textcolor"><?php echo $i.". ".$get->getCostItemName($rg->CostItemCode); ?></span></td>
                  </tr>
        
                   <?php  		
                        $costList = $get->getCostItemListGeneral('tblintra_eform_formal_meeting_pay_cost','DocCodePay','CostIdPay',$DocCodePay,$rg->CostItemCode);
                        //ltxt::print_r($costList);
						$TotalCost = 0;
                        foreach($costList as $rc){
                            foreach( $rc as $k=>$v){ ${$k} = $v;}	
								$TotalCost = $TotalCost + $SumCost;			
                   ?>
                      <tr>
                         <td style="text-align:left; vertical-align:top; text-indent:59px;"><span class="textcolor"><?php echo "- ".$DetailCost; ?></span></td>
                        <td style="text-align:right; width:10%; vertical-align:top;">เป็นเงิน</td>
                        <td style="text-align:right; width:20%; vertical-align:top;padding-left:10px"><span class="textcolor"><?php echo number_format($SumCost,2);?></span> บาท</td>
                      </tr>      
                  <?php } ?>    
                      <tr>
                         <td style="text-align:left; vertical-align:top; text-indent:15px;">&nbsp;</td>
                        <td style="text-align:right; width:10%; vertical-align:top;">รวมทั้งสิ้น</td>
                        <td style="text-align:right; width:20%; vertical-align:top;padding-left:10px"><span class="textcolor"><?php echo number_format($TotalCost,2);?></span> บาท</td>
                      </tr>                  
                  
        <?php 
				$i++; 
			}
			
			$TotalMeetingPay = $get->getSumCostMeetingPay($DocCodePay,$PrjActCode,0,0);
			
		?>
        		  <tr><td colspan="3" height="5"></td></tr>	
                  <tr >
                      	<td style="text-align:right;" colspan="2">(<span class="textcolor"><?php echo JThaiBaht::_($TotalMeetingPay); ?></span>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รวมทุกหมวดงบประมาณ </td>
                      	<td style="text-align:right;padding-left:10px; "><span class="textcolor"><?php echo number_format($TotalMeetingPay,2); ?></span> บาท</td>
                  </tr>
        <?php 
        }else{ 
        echo '<tr><td align="center" height="300" style="color:#f00;">- - ไม่มีรายการชี้แจง - -</td></tr>';
        } 
        ?>
    </table>     

	</td>
  </tr>
  <tr>
    <td colspan="2"  height="16"></td>
  </tr> 
   
   <?php
   $groupOtherList = $get->getCostGroupGeneral('tblintra_eform_formal_meeting_pay_costother','DocCodePay','CostId',$DocCodePay);
   if($groupOtherList){
   ?>
  <tr>
    <td colspan="2"  valign="top" >

	<table width="100%" border="0" cellspacing="1" cellpadding="0"   align="center">
        <tr>
            <td style="text-align:left;vertical-align:top; padding-left:44px;" colspan="3"><u>รายการค่าใช้จ่ายที่ไม่ได้คาดการณ์ไว้ก่อน :</u></td>
        </tr>
        <?php 		
        //$groupOtherList = $get->getCostGroupGeneral('tblintra_eform_formal_meeting_pay_costother','DocCodePay','CostId',$DocCodePay);
        //ltxt::print_r($groupOtherList);
        if($groupOtherList){
            $i=1;
            foreach($groupOtherList as $rg){
         ?>
                  <tr>
                    <td style="text-align:left;vertical-align:top; padding-left:44px;" colspan="3"><span class="textcolor"><?php echo $i.". ".$get->getCostItemName($rg->CostItemCode); ?></span></td>
                  </tr>
        
                   <?php  		
                        $costList = $get->getCostItemListGeneral('tblintra_eform_formal_meeting_pay_costother','DocCodePay','CostId',$DocCodePay,$rg->CostItemCode);
                        //ltxt::print_r($costList);
						$TotalCost = 0;
                        foreach($costList as $rc){
                            foreach( $rc as $k=>$v){ ${$k} = $v;}	
								$TotalCost = $TotalCost + $SumCost;			
                   ?>
                      <tr>
                         <td style="text-align:left; vertical-align:top; text-indent:59px;"><span class="textcolor"><?php echo "- ".$DetailCost; ?></span></td>
                        <td style="text-align:right; width:10%; vertical-align:top;">เป็นเงิน</td>
                        <td style="text-align:right; width:20%; vertical-align:top;padding-left:10px"><span class="textcolor"><?php echo number_format($SumCost,2);?></span> บาท</td>
                      </tr>      
                  <?php } ?>    
                      <tr>
                         <td style="text-align:left; vertical-align:top; text-indent:15px;">&nbsp;</td>
                        <td style="text-align:right; width:10%; vertical-align:top;">รวมทั้งสิ้น</td>
                        <td style="text-align:right; width:20%; vertical-align:top;padding-left:10px"><span class="textcolor"><?php echo number_format($TotalCost,2);?></span> บาท</td>
                      </tr>                  
                  
        <?php 
					$i++; 
				} 	
				
				$TotalMeetingOther = 	$get->getSumCostOther($DocCodePay,$PrjActCode,0,0,$DocCode,$TaskNo);
		?>
        		  <tr><td colspan="3" height="5"></td></tr>	
                  <tr >
                      	<td style="text-align:right;" colspan="2">(<span class="textcolor"><?php echo JThaiBaht::_($TotalMeetingOther); ?></span>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รวมทุกหมวดงบประมาณ </td>
                      	<td style="text-align:right;padding-left:10px; "><span class="textcolor"><?php echo number_format($TotalMeetingOther,2); ?></span> บาท</td>
                  </tr>
        <?php 
        }else{ 
        echo '<tr><td align="center" height="300" style="color:#f00;">- - ไม่มีรายการชี้แจง - -</td></tr>';
        } 
        ?>
     </table>        

    </td>
  </tr>

  <tr>
    <td colspan="2"  valign="top" >

    	<table width="100%" border="0" cellspacing="1" cellpadding="0"   align="center">
          <tr><td  height="16"></td></tr>	
          <tr>
                <td style="text-align:right;" >(<span class="textcolor"><?php echo JThaiBaht::_($TotalMeetingPay+$TotalMeetingOther); ?></span>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;งบประมาณรวมทั้งสิ้น </td>
                <td style="text-align:right;padding-left:10px; width:20%;"><span class="textcolor"><?php echo number_format(($TotalMeetingPay+$TotalMeetingOther),2); ?></span> บาท</td>
          </tr>          
        </table>
    
    </td>
  </tr>

  <tr>
    <td colspan="2" height="16"></td>
  </tr>
       <?php } ?> 
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" >จึงใคร่ขออนุมัติเบิกจ่ายค่าใช้จ่ายดังกล่าว โดยใช้<span class="textcolor"><?php 
	if($SourceType=="Internal"){ echo "งบประมาณ สช.";}
	else if($SourceType=="External"){ 
		echo "เงินนอกงบประมาณ";
		echo "ของ".$get->getSourceExName($SourceExId);
	} 	
	?>    
<?php echo $get->getPItemName($PItemCode);?>	
<?php echo $get->getPrjName($PrjId);?>  
</span>
กิจกรรม<span class="textcolor"><?php echo $get->getPrjActName($PrjActCode);?> (<?php echo $PrjActCode;?>)</span>  ภายในวงเงินดังกล่าวด้วย จะเป็นพระคุณ
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


