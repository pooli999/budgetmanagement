<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$format = ltxt::getVar('format');
if($format == 'raw'){ $get->getWord() ;}

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

	.textcolor{ color:#333; }
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
    <td align="right" valign="top" ><span class="textid">แบบ FF008</span></td>
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
    <td colspan="2"  style="text-indent:44px; text-align:justify" >ในการนี้ <span class="textcolor"><?php echo $get->getOrganizeName($OrganizeCode); ?> </span>จึงใคร่ขออนุมัติหลักการสนับสนุนโครงการ
   โดยใช้<span class="textcolor">
   <?php 
	if($SourceType=="Internal"){ echo "งบประมาณ สช.";}
	else if($SourceType=="External"){ 
		echo "เงินนอกงบประมาณ";
		echo "ของ".$get->getSourceExName($SourceExId);
	} 
	?>   
    <?php echo $get->getPItemName($PItemCode);?> 
    <?php echo $get->getPrjName($PrjId);?>  
    กิจกรรม<?php echo $get->getPrjActName($PrjActCode);?>  (<?php echo $PrjActCode;?>)
    วงเงินงบประมาณ <?php echo number_format($get->getSumCostGeneral('tblintra_eform_formal_general_cost','DocCode',$DocCode,$PrjActCode,0,0),2); ?> บาท 
(<?php echo JThaiBaht::_($get->getSumCostGeneral('tblintra_eform_formal_general_cost','DocCode',$DocCode,$PrjActCode,0,0)); ?>) 
</span>
	</td>
  </tr>
  <tr>
    <td colspan="2"  height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:44px; text-align:justify" >จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติหลักการสนับสนุนงบประมาณในการดำเนินงานดังกล่าวด้วย จะเป็นพระคุณ  
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

<br />
<br />
<br />
<table width="660" border="0" cellspacing="1" cellpadding="0"   align="center">
  <tr><td colspan="2" align="left" style="padding-bottom:10px"><u>สรุปรายการประมาณการค่าใช้จ่าย :</u></td></tr>
<?php 		
$groupList = $get->getCostGroupGeneral('tblintra_eform_formal_general_cost','DocCode','CostId',$DocCode);
//ltxt::print_r($groupList);
if($groupList){
	$i=1;
	foreach($groupList as $rg){
 ?>

          <tr>
            <td style="text-align:left; width:70%; vertical-align:top; "><?php echo $i.". ".$get->getCostItemName($rg->CostItemCode); ?></td>
            <td style="text-align:right; width:30%; vertical-align:top;padding-left:10px; "><!--<strong><?php //echo number_format($get->getSumCostGeneral('tblintra_eform_formal_general_cost','DocCode',$DocCode,$PrjActCode,$rg->CostItemCode,0),2); ?> บาท</strong>-->&nbsp;</td>
          </tr>

		   <?php  		
		   		$costList = $get->getCostItemListGeneral('tblintra_eform_formal_general_cost','DocCode','CostId',$DocCode,$rg->CostItemCode);
				//ltxt::print_r($costList);
				foreach($costList as $rc){
					foreach( $rc as $k=>$v){ ${$k} = $v;}				
 		   ?>
              <tr>
                <td style="text-align:left; width:70%; vertical-align:top; padding-left:17px "><?php echo "- ".$DetailCost; ?></td>
                <td style="text-align:right; width:30%; vertical-align:top;padding-left:10px; "><?php echo number_format($SumCost,2);?> บาท</td>
              </tr>      
          <?php } ?>  
          
                      <tr>
                        <td style="text-align:right; vertical-align:top;">รวมทั้งสิ้น</td>
                        <td style="text-align:right; vertical-align:top;padding-left:10px"><span class="textcolor"><?php echo number_format($get->getSumCostGeneral('tblintra_eform_formal_general_cost','DocCode',$DocCode,$PrjActCode,$rg->CostItemCode,0),2); ?></span> บาท</td>
                      </tr>            
            
<?php $i++; } ?>
		<tr><td colspan="3" height="5"></td></tr>	
          <tr >
          <td style="text-align:right;">(<?php echo JThaiBaht::_($get->getSumCostGeneral('tblintra_eform_formal_general_cost','DocCode',$DocCode,$PrjActCode,0,0)); ?>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รวมทุกหมวดงบประมาณ</td>
          <td style="text-align:right;padding-left:10px; "><?php echo number_format($get->getSumCostGeneral('tblintra_eform_formal_general_cost','DocCode',$DocCode,$PrjActCode,0,0),2); ?> บาท</td>
          </tr>
<?php 
}else{ 
echo '<tr><td align="center" height="300" style="color:#f00;">- - ไม่มีรายการชี้แจง - -</td></tr>';
} 
?>
</table>  






	</td>
  </tr>
</table>
