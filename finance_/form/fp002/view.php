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

if(!$data){
	$info = $get->getDocCodeDetail($_REQUEST["DocCode"]);//ltxt::print_r($info);
	foreach($info as $inforow){
		foreach($inforow as $gg=>$qq){
			${$gg} = $qq;
		}
	}
}



$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));
$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบแบบฟอร์มอิเล็กทรอนิกส์',
		'link' => '?mod=front.form.main'
	),
	array(
		'text' => "แสดงรายละเอียด",
	),
));


?>

<script language="javascript" type="text/javascript">
function editDocument(FormCode,DocCode){
	window.location.href="?mod=front.form.checkin&FormCode="+FormCode+"&DocCode="+DocCode;
}
function printDocument(){
	window.location.href="?mod=<?php echo LURL::dotPage('print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}
function saveToWord(){
	window.location.href="?mod=<?php echo LURL::dotPage('word')?>&format=raw<?php echo $get->getQueryString(); ?>";
}
function saveAttachFile(FormCode,DocCode){
	window.location.href="?mod=<?php echo LURL::dotPage('attach')?>&FormCode="+FormCode+"&DocCode="+DocCode;
}
function closeDocument(FormCode,DocCode){
	//window.location.href="?mod=front.form.add&FormCode="+FormCode+"&DocCode="+DocCode;
	jAlert("ยังไม่เปิดใช้งานฟังก์ชันนี้");
}

</script>


<div class="sysinfo">
  <div class="sysname"><span style="background-color:<?php echo $BGColor; ?>">&nbsp;<?php echo $FormCode; ?>&nbsp;</span>&nbsp;<?php echo $FormName; ?></div>
  <div class="sysdetail"><?php echo $FormDetail; ?></div>
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" onClick="goPage('?mod=front.form.main')" /></td>
  </tr>
</table>






<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th>เลขที่ สช.น</th>
    <td><b><?php echo $DocCode; ?></b></td>
  </tr>
  <tr>
    <th>วันที่เอกสาร</th>
    <td><?php echo ShowDate($DocDate);?></td>
  </tr>
  <tr>
    <th>เรื่อง</th>
    <td><?php echo ($Topic)?$Topic:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>  
    
  <tr style="vertical-align:top;">
    <th>ชื่อการประชุม</th>
    <td><?php echo ($Title)?$Title:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>  
    
  <tr>
    <th>เรียน</th>
    <td><?php echo ($DocTo)?$DocTo:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>
  <tr style="vertical-align:top;">
     <th style="width:80px;">เอกสารแนบ</th>
     <td class="textcolor">
				 <?php 
				$attachList = $get->getAttachList($DocCode);//ltxt::print_r($costList);
				 if($attachList){
						$no = 1;
						foreach($attachList as $at){
							foreach( $at as $att=>$ath){ ${$att} = $ath;}
						?>
						<div><?php if(count($attachList)>1){ echo $no; ?>) <?php } echo $AttachName; ?></div>
						<?php 
							$no++;
						} 
				 }else{
					 echo '<span style="color:#999;">-ไม่ระบุ-</span>';
				 }
				?>    
      </td>
    </tr>
    


  <tr>
    <th valign="top">มีความประสงค์จะ</th>
    <td valign="top"><?php echo ($Detail)?(strip_tags($Detail)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>
    <tr>
    <th valign="top">วัตถุประสงค์หรือความจำเป็นในการจัดจ้าง</th>
    <td valign="top"><?php echo ($Purpose)?(strip_tags($Purpose)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>
  
      <tr>
    <th valign="top">รายละเอียดเกี่ยวกับการจ้าง</th>
    <td valign="top"><?php echo ($Description)?(strip_tags($Description)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>
  
  
  <tr>
	<th>กำหนดเวลาที่ต้องการจ้าง</th>
  	<td>
<b>เป็นเวลา </b><?php echo ($AmountMonth)?$AmountMonth:"-"; ?><b> เดือน</b><?php echo ($AmountDate)?$AmountDate:"-"; ?><b> วัน</b>
<b> ตั้งแต่วันที่ </b><?php echo dateFormat($StartDate1);?><b> ถึงวันที่ </b><?php echo dateFormat($EndDate1);?>    
    </td>
  </tr> 
  
  <tr>
    <th valign="top">รายละเอียดอื่นที่จำเป็นตามควรแก่กรณี</th>
    <td valign="top"><?php echo ($Other)?(strip_tags($Other)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>





       <tr>
    <th colspan="2">รายการค่าใช้จ่าย</th>
  </tr>  
 
<tr>
	<th>ปีงบประมาณ</th>
	<td><?php echo ($BgtYear)?$BgtYear:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr>
	<th>ชื่อแผนงาน สช.</th>
	<td><?php echo ($PItemCode)?($get->getPItemName($BgtYear,$PItemCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
<tr style="vertical-align:top;">
	<th>โครงการ</th>
	<td><?php echo ($PrjDetailId)?($get->getPrjDetailName($PrjDetailId)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
</tr>
  <tr style="vertical-align:top;">
    <th>กิจกรรม</th>
    <td><?php echo ($PrjActCode)?($get->getPrjActName($PrjActCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>  
  <tr style="vertical-align:top;">
    <th>แหล่งงบประมาณ</th>
    <td><?php echo ($SourceExId)?($get->getSourceExName($SourceExId)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>   
  
  
  



    <tr>
    <th colspan="2">รายการประมาณการค่าใช้จ่าย</th>
  </tr>  


<tr>
<td colspan="2">



<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list-sub">
<thead>
  		<tr>
  		  <td style="text-align:center; width:30px;">ลำดับ</td>
    		<td  style="text-align:center;">รายการค่าใช้จ่าย/รายการชี้แจง</td>
            <td  style="width:100px; text-align:right;">งบขออนุมัติ</td>
            <td  style="width:50px;">&nbsp;</td>
  		</tr>            
</thead>        
<?php 
$gCostItemCode = $get->getImpCostItemCode($DocCode);//ltxt::print_r($gCostItemCode);
$dataCost = $get->getCostDetail($DocCode);//ltxt::print_r($dataCost);
$m=0;
if($gCostItemCode[0]->CostItemCode){
	foreach($gCostItemCode as $gCostItemCoderow){
		foreach($gCostItemCoderow as $gg=>$qq){	${$gg} = $qq;	}
		$sumSumCost 			= $get->getSumSumCost($DocCode,$CostItemCode);
?>
<tr style="font-weight:bold;">
  <td style="text-align:center;"><?php echo ($m+1); ?></td>
	<td ><?php echo $get->getCostItemName($CostItemCode);?></td>
	<td  style="text-align:right;" ><?php echo number_format($sumSumCost,2);?></td>
        <td  style="text-align:right" >&nbsp;</td> 
</tr>
<?php
	for($i=0; $i<count($dataCost);$i++){
		if($dataCost[$i]->DetailCost != ""){
			if($dataCost[$i]->CostItemCode == $CostItemCode){
?>
        <tr>
          <td >&nbsp;</td>
        <td >- <?php echo $dataCost[$i]->DetailCost;?></td>
        <td  style="text-align:right;" ><?php echo number_format($dataCost[$i]->SumCost,2);?></td>
        <td  style="text-align:right;" >&nbsp;</td>        
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
          <tr style="font-weight:bold;">
            <td style="text-align:right;">&nbsp;</td>
            <td style="text-align:right;">รวมเป็นค่าใช้จ่ายทั้งสิ้น</td>
            <td  style="text-align:right;" ><?php echo number_format($TotalCost,2);?></td>
            <td >บาท</td>
  		</tr>
<?php }else{ ?>     
	<tr>
    	<td colspan="4" style="text-align:center; color:#999;">-ไม่พบรายการ-</td>
    </tr> 
<?php } ?>        
	</table>    



<!--END รายการค่าใช้จ่าย-->


 
</td>
</tr>


    <tr>
    <th colspan="2">คณะกรรมการจัดหาพัสดุ</th>
  </tr>  
<tr style="vertical-align:top;">
    <td colspan="2" style="padding:5px;">
<!--/////////////////////////////////////////////////////////-->    
<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list-sub">
<thead>
    <tr>
      <td style="text-align:center; width:30px;">ลำดับ</td>
      <td style="text-align:center;">ชื่อ-นามสกุล</td>
      <td style="text-align:center; width:200px;">ตำแหน่ง</td>
      <td style="text-align:center; width:200px;">หน้าที่</td>
    </tr>
</thead>
    <tr>
    	<td style="text-align:center;">1</td>
    	<td style="text-align:left;"><?php echo $get->fn_getFullNameByPersonalCode($CommiteeName1);?></td>
    	<td style="text-align:left;"><?php echo $get->getPositionName($CommiteePosition1);?></td>
        <td style="text-align:left;"><?php echo $get->getDutyName($CommiteeDuty1); ?></td>
  	</tr>
     <tr>
    	<td style="text-align:center;">2</td>
    	<td style="text-align:left;"><?php echo $get->fn_getFullNameByPersonalCode($CommiteeName2);?></td>
    	<td style="text-align:left;"><?php echo $get->getPositionName($CommiteePosition2);?></td>
        <td style="text-align:left;"><?php echo $get->getDutyName($CommiteeDuty2); ?></td>
  	</tr>
    <tr>
    	<td style="text-align:center;">3</td>
    	<td style="text-align:left;"><?php echo $get->fn_getFullNameByPersonalCode($CommiteeName3);?></td>
    	<td style="text-align:left;"><?php echo $get->getPositionName($CommiteePosition3);?></td>
        <td style="text-align:left;"><?php echo $get->getDutyName($CommiteeDuty3); ?></td>
  	</tr>
</table>
   
<!--/////////////////////////////////////////////////////////-->
    </td>
</tr>


    <tr>
    <th colspan="2">ไฟล์เอกสารแนบ</th>
  </tr>  

<tr>
 <td colspan="2">
<?php  
$MultiDocId =	$get->getFile($DocCode);//ltxt::print_r($MultiDocId);
if($MultiDocId){
	FilesManager::LinkFilesView(array(
			'ActiveObj' => 'MultiDocId',
			'ViewType' => 'multi',
			'ActiveId' => $MultiDocId
	));
}else{
		echo '<div style="text-align:center; color:#999;">-ไม่พบรายการ-</div>';	
}
?>  
</td>
</tr>




  <tr>
    <th colspan="2">ข้อมูลผู้ขออนุมัติ</th>
  </tr>  
  <tr>
    <th>ปีงบประมาณ-คำสั่งที่</th>
    <td><?php echo ($RQOrgRoundCode)?$RQOrgRoundCode:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>    
  <tr>
    <th>หน่วยงานปฏิบัติงาน</th>
    <td><?php echo ($RQOrganizeCode)?($get->getOrganizeName($RQOrganizeCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>  
  <tr>
    <th>ชื่อผู้ปฏิบัติงาน</th>
    <td><?php echo ($RQPersonalCode)?($get->fn_getFullNameByPersonalCode($RQPersonalCode)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>
  <tr>
    <th>ตำแหน่งปฏิบัติงาน</th>
    <td><?php echo ($RQPositionId)?($get->getPositionName($RQPositionId)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr> 
    <tr>
    <th colspan="2">ประวัติการสร้างเอกสาร</th>
  </tr>  
  <tr>
    <th>ผู้สร้างเอกสาร</th>
    <td><?php echo ($CreateBy)?($get->getPersonalName($CreateBy)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?> (<?php echo ($CreateDate)?(dateFormat($CreateDate)):'<span style="color:#999;">-</span>'; ?>)</td>
  </tr>    
  <tr>
    <th>ผู้ปรับปรุงเอกสารล่าสุด</th>
    <td><?php echo ($UpdateBy)?($get->getPersonalName($UpdateBy)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?> (<?php echo ($UpdateDate)?(dateFormat($UpdateDate)):'<span style="color:#999;">-</span>'; ?>)</td>
  </tr> 
    <tr>
    <th>สถานะเอกสาร</th>
    <td><div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div></td>
  </tr>  
</table>




<div style="text-align:right; padding:4px; margin-top:10px;"><a href="#" class="icon-up">กลับสู่ด้านบน</a></div>

