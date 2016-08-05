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
    <td  valign="top">

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"  bgcolor="#FFFFFF"  bordercolor="#FFFFFF">
  <tr>
    <td align="right" valign="top" ><span class="textid">แบบ FH005</span></td>
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
<!--  <tr>
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
  </tr>-->
  
  <tr>
    <td colspan="2"  height="16"></td>
  </tr>
  <tr>
    <td width="50%" >ที่ สช.น. <span class="textcolor"><?php echo $DocCode; ?></span>&nbsp;</td>
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
    <td colspan="2" height="16"></td>
  </tr>  
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" >
    ข้าพเจ้า <span class="textcolor"><?php echo fn_getFullNameByPersonalCode($PersonalCode);?> <?php echo $get->getPositionName($PositionId); ?>  <?php echo $get->getOrganizeName($OrgApprove); ?></span> ใคร่ขออนุมัติให้
        <span class="textcolor">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
           <?php 
            $TaskPerson = $get->getTaskPersonOt($DocCode); 
            $i=1;
           foreach($TaskPerson as $rRName){
/*                foreach($rRName as $k=>$v){
                    ${$k} = $v;
                }*/ 
            ?>	
              <tr >
                <td style="width:50%; vertical-align:top; padding-left:40px"><?php echo $i.". ".fn_getFullNameByPersonalCode($rRName->PersonalCode);?></td>
                <td style="width:50%; vertical-align:top">ตำแหน่ง <?php echo $get->getPositionByPersonalCode($rRName->PersonalCode);?> </td>
              </tr>
        <?php  $i++; }	?>
        </table>
		</span>
    </td>
  </tr>
  <tr>
  <td colspan="2" style="text-align:justify;" >ปฏิบัติงานล่วงเวลาในวันที่  <span class="textcolor"><?php echo ShowDateLong($StartDate);?></span> ถึงวันที่  <span class="textcolor"><?php echo ShowDateLong($EndDate);?></span> รวมเป็นเวลา <span class="textcolor"><?php  echo $get->getdays($StartDate,$EndDate); ?></span> วัน
โดยมีกิจกรรมการปฏิบัติงาน ดังนี้  

	</td>
  </tr>
  <tr>
    <td  colspan="2" style="text-align:justify; padding-left:40px;"><span class="textcolor"><?php echo $Detail; ?></span></td>
  </tr>
 
  <tr>
    <td colspan="2"  style="text-align:justify; " >โดยเบิกจ่ายภายในวงเงินงบประมาณ <span class="textcolor"><?php echo number_format($get->getSumCostOt($DocCode,$PrjActCode,0,0),2); ?></span> บาท  (<span class="textcolor"><?php echo JThaiBaht::_($get->getSumCostOt($DocCode,$PrjActCode,0,0)); ?></span>)
    
    จาก<span class="textcolor"><?php 
	if($SourceType=="Internal"){ echo "งบประมาณ สช.";}
	else if($SourceType=="External"){ 
		echo "เงินนอกงบประมาณ";
		echo "ของ".$get->getSourceExName($SourceExId);
	} 	
	?>   
<?php echo $get->getPItemName($PItemCode);?>  	
<?php echo $get->getPrjName($PrjId);?> </span>  
กิจกรรม<span class="textcolor"><?php echo $get->getPrjActName($PrjActCode);?></span> (<span class="textcolor"><?php echo $PrjActCode;?></span>)
	</td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>  
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" >จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติให้พนักงานสช. ตามรายชื่อข้างต้นปฏิบัติงานล่วงเวลา โดยมี <span class="textcolor"><?php echo fn_getFullNameByPersonalCode($PersonalCode);?></span> เป็นผู้ควบคุม และเบิกจ่ายค่าปฏิบัติงานล่วงเวลาจากแผนงานโครงการและกิจกรรมดังกล่าวด้วย จะเป็นพระคุณ
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
<td  width="50%" align="right" valign="top">&nbsp;</td></tr></table>

</td>
</tr>
</table>


<div style="padding-top:50px; text-align:center;">
<input name="print" type="button" value="พิมพ์เอกสาร"  onclick="window.print();" class="print" style="color:#009"  />
<input name="print" type="button" value="ปิดหน้าต่าง"  onclick="window.close();" class="print" style="color:#000"  />
</div>
