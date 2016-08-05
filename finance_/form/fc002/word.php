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
    <td colspan="2"  style="text-indent:40px; text-align:justify"><?php $dataRefer = $get->getDataDocCodeRefer($DocCodeRefer); //ltxt::print_r($dataRefer); ?>
      อ้างถึงบันทึกข้อความขออนุมัติหลักการเลขที่ สช.น <span class="textcolor"><?php echo $DocCodeRefer; ?></span> ลงวันที่ <span class="textcolor"><?php echo ShowDateLong($dataRefer[0]->DocDate); ?></span> ซึ่งได้รับการอนุมัติสนับสนุน <span class="textcolor"><?php echo $dataRefer[0]->Title; ?></span> ปีงบประมาณ <span class="textcolor"><?php echo $BgtYear; ?></span> ในวงเงิน <span class="textcolor"><?php echo number_format($dataRefer[0]->TotalCost,2); ?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($dataRefer[0]->TotalCost); ?></span>) รายละเอียดตามเอกสารที่แนบท้ายนี้ </td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify"> บัดนี้ คณะกรรมการกลั่นกรองโครงการฯ ได้พิจารณาเป็นที่เรียบร้อยแล้วเมื่อวันที่ <span class="textcolor"><?php echo ShowDateLong($AnalystDate);?></span> เห็นควรสนับสนุนการดำเนินโครงการ โดยมีระยะเวลางานระหว่าง <span class="textcolor"><?php echo ShowDateLong($StartDate);?></span> ถึงวันที่ <span class="textcolor"><?php echo ShowDateLong($EndDate);?></span> จึงขออนุมัติจัดทำข้อตกลงเพื่อสนับสนุน <span class="textcolor"><?php echo $Title; ?></span>
      <?php if($NHOrg){ ?>
      ซึ่งหน่วยงานที่ทำข้อตกลงกับ สช. คือ <span class="textcolor"><?php echo $NHOrg; ?></span>
      <?php } ?>
      โดยมี <span class="textcolor"><?php echo $NHPerson; ?></span> ตำแหน่ง <span class="textcolor"><?php echo $NHPosition; ?></span> เป็นผู้รับการสนับสนุนโครงการดังกล่าว เป็นจำนวนเงิน <span class="textcolor"><?php echo number_format($TotalCost); ?></span> บาท (<span class="textcolor"><?php echo JThaiBaht::_($TotalCost); ?></span>) โดยใช้งบประมาณ ของ <span class="textcolor"><?php echo $get->getSourceExName($SourceExId); ?></span> &nbsp;<span class="textcolor"><?php echo $get->getPItemName($BgtYear,$PItemCode); ?></span> &nbsp;<span class="textcolor"><?php echo $get->getPrjDetailName($PrjDetailId); ?></span> กิจกรรม&nbsp;<span class="textcolor"><?php echo $get->getPrjActName($PrjActCode); ?></span> (<span class="textcolor"><?php echo $PrjActCode; ?></span>) </td>
  </tr>
  <tr>
    <td colspan="2" height="16"></td>
  </tr>
  <tr>
    <td colspan="2"  style="text-indent:40px; text-align:justify" > จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติจัดทำข้อตกลงดังกล่าวด้วย จะเป็นพระคุณ </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
   <tr>
    <td colspan="2"  height="60"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td style="vertical-align:top; width:50%;"><table  border="0" cellspacing="0" cellpadding="0"  align="center">
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
        <td colspan="3" style="height:40px;"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td style="text-align:center;">............../............../..............</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td style="vertical-align:top; width:50%;"><table  border="0" cellspacing="0" cellpadding="0"  align="center">
      <tr>
        <td align="left">&nbsp;</td>
        <td style="width:200px; border-bottom:1px dotted #999;">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td style="text-align:right; padding-top:5px;">(</td>
        <td style="padding-top:5px; text-align:center;"><span class="textcolor"><?php echo $get->fn_getFullNameByPersonalCode($RQPersonalCode); ?></span></td>
        <td style="padding-top:5px;">)</td>
      </tr>
      <tr>
        <td style="text-align:right; padding-top:5px;">&nbsp;</td>
        <td style="padding-top:5px; text-align:center;"><span class="textcolor"><?php echo ($RQPositionId)?($get->getPositionName($RQPositionId)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></span></td>
        <td style="padding-top:5px;">&nbsp;</td>
      </tr>
      <tr>
        <td style="text-align:right; padding-top:5px;">&nbsp;</td>
        <td style="padding-top:5px; text-align:center;"><span class="textcolor"><?php echo ($RQOrganizeCode)?($get->getOrganizeName($RQOrganizeCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></span></td>
        <td style="padding-top:5px;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>    