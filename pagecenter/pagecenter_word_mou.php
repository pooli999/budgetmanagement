<?php
	include("config.php");
	include($KeyPage."_helper.php");
	include($KeyPage."_data.php");
	$format = ltxt::getVar('format');
	if($format == 'raw'){ $get->getWord() ;}

//ltxt::print_r($_REQUEST);
?>
<style>
td{
	font-size:14px; 
}

</style>


<table width="610" border="0" cellspacing="0" cellpadding="0" align="center"  bgcolor="#FFFFFF"  bordercolor="#FFFFFF">
  <tr>
    <td align="left" valign="top" >
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		  <tr>
		    <td rowspan="3" align="left" valign="top" ><img src="http://203.185.147.12/nationalhealth/images/logo.png" border="0" width="59" height="51"/></td>
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
    <td align="right" ><div style="font-weight:bold; font-size:17px;">บันทึกข้อความ</div></td>
  </tr>
</table>
<table width="610" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr>
    <td colspan="2" height="18"></td>
  </tr>
  <tr>
    <td width="300" >ที่ สช.น. <?php echo $DocCode; ?>&nbsp;</td>
    <td width="310" >วันที่ <?php echo ShowDate($DocDate);?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" >เรื่อง&nbsp;&nbsp;&nbsp;<?php echo $Topic; ?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="middle"><hr></hr></td>
  </tr>  
  <tr>
    <td colspan="2" >เรียน&nbsp;&nbsp;&nbsp;<?php echo $DocTo; ?></td>
  </tr>
  <tr>
    <td colspan="2" height="18"></td>
  </tr>  
  <tr>
    <td colspan="2"  style="line-height:160%; text-indent:40px; text-align:justify" >ความเป็นมา (เรื่องเดิม) <?php echo $Detail; ?></td>
  </tr>
  <tr>
    <td colspan="2" height="18"></td>
  </tr>  
  <tr>
    <td colspan="2"  style="line-height:160%; text-indent:40px; text-align:justify" >ดังนั้น สำนัก<?php echo $get->getOrganizeName($OrganizeCode); ?> พิจารณาเห็นควรสนับสนุนงบประมาณภายในวงเงิน <?php echo number_format($Budget,2); ?> บาท 
(<?php echo JThaiBaht::_($Budget); ?>) 
จาก<?php 
	if($SourceType=="Internal"){ echo "งบประมาณแผ่นดิน";}
	else if($SourceType=="External"){ 
		echo "เงินนอกงบประมาณ";
		echo "ของ".$get->getSourceExName($SourceExId);
	} 
	?> 
แผนงาน<?php echo $get->getPItemName($PItemCode);?>  
โครงการ<?php echo $get->getPrjName($PrjId);?>  
กิจกรรม<?php echo $get->getPrjActName($PrjActCode);?>
	</td>
  </tr>
  <tr>
    <td colspan="2" height="18"></td>
  </tr>
  <tr>
    <td colspan="2"  style="line-height:160%; text-indent:40px; text-align:justify" >จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติเงินสนับสนุนดังกล่าวต่อไปด้วย จะเป็นพระคุณ  
	</td>
  </tr>   
    <tr>
    <td colspan="2" height="30">&nbsp;</td>
  </tr>
  </table>
  
   <table border="0" cellspacing="0" cellpadding="0"  align="center"  >
   <tr>
    <td style="text-align:center; line-height:160%;padding-left:166px; ">
	...................................<br />	
	(<?php echo fn_getFullNameByPersonalCode($PersonalCode);?>)<br />
	ตำแหน่ง <?php echo $get->getPositionName($PositionId); ?>
	</td>
  </tr>  
</table>

