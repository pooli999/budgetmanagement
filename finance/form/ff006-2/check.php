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
		'text' => 'ระบบงบประมาณการเงิน',
	),
	array(
		'text' => 'ตรวจสอบเอกสารการเงิน',
		'link' => '?mod=finance.form.list_approve'
	),
	array(
		'text' => "บันทึกผลการตรวจสอบ",
	),
));


?>

<script language="javascript" type="text/javascript">
function editDocument(FormCode,DocCode,DocCodeRefer){
	window.location.href="?mod=<?php echo LURL::dotPage('action'); ?>&action=checkin&FormCode="+FormCode+"&DocCode="+DocCode+"&DocCodeRefer="+DocCodeRefer;
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


<script language="javascript" type="text/javascript">
function Save(f){
	jConfirmQ('บันทึกผลการตรจสอบเอกสารใช่หรือไม่?', 'ยืนยันการดำเนินการ', function(r) {
			if(r){
				var action_url = '?mod=<?php echo LURL::dotPage("action");?>';
				toSubmit(f,'check',action_url);
			}
	});
}
</script>



<div class="sysinfo">
  <div class="sysname"><span style="background-color:<?php echo $BGColor; ?>">&nbsp;<?php echo $FormCode; ?>&nbsp;</span>&nbsp;<?php echo $FormName; ?></div>
  <div class="sysdetail"><?php echo $FormDetail; ?> โดยมีเอกสารแนบดังนี้ <div>- <?php echo $FormAttach; ?></div></div>
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
    <th>เอกสารอ้างอิง</th>
    <td><a href="#"><?php echo $DocCodeRefer; ?></a></td>
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
    <td valign="top"><?php echo ($Detail)?$Detail:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>
  <tr>
	<th>สถานที่ดำเนินการ</th>
  	<td><?php echo ($Location)?$Location:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
  </tr>
  <tr>
	<th>จำนวนผู้เข้าร่วมประชุม</th>
  	<td><?php echo ($AmountPerson)?$AmountPerson:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?> <b>คน</b></td>
  </tr>
  <tr>
    <th>ระยะเวลาดำเนินการ</th>
  	<td><?php echo (ShowDate($StartDate))?ShowDate($StartDate):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?>&nbsp;<b>ถึง</b>&nbsp;<?php echo (ShowDate($EndDate))?ShowDate($EndDate):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?>&nbsp;<b>รวมเป็นเวลา</b>&nbsp;<?php echo ($AmountDate)?$AmountDate:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?>&nbsp;<b>วัน</b>
</td>
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
    <th colspan="2">รายการค่าใช้จ่ายที่ต้องการวางบิลเบิกจ่าย</th>
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
$TotalCost = 0;
if($gCostItemCode[0]->CostItemCode){
	foreach($gCostItemCode as $gCostItemCoderow){
		foreach($gCostItemCoderow as $gg=>$qq){	${$gg} = $qq;	}
		$sumSumCost 			= $get->getSumSumCost($DocCode,$CostItemCode);
		$TotalCost = $TotalCost+$sumSumCost;
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
    <th colspan="2">รายการค่าใช้จ่ายที่ต้องการเบิกจ่าย โดยไม่ได้ขออนุมัติไว้ก่อน</th>
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
$gOtherCostItemCode = $get->getImpOtherCostItemCode($DocCode);//ltxt::print_r($gCostItemCode);
$dataOtherCost = $get->getOtherCostDetail($DocCode);//ltxt::print_r($dataOtherCost);
$m=0;
$OtherTotalCost = 0;
if($gOtherCostItemCode[0]->CostItemCode){
	foreach($gOtherCostItemCode as $gOtherCostItemCoderow){
		foreach($gOtherCostItemCoderow as $gg=>$qq){	${$gg} = $qq;	}
		$sumOtherSumCost = $get->getOtherSumSumCost($DocCode,$CostItemCode);
		$OtherTotalCost = $OtherTotalCost+$sumOtherSumCost;
?>
<tr style="font-weight:bold;">
  <td style="text-align:center;"><?php echo ($m+1); ?></td>
	<td ><?php echo $get->getCostItemName($CostItemCode);?></td>
	<td  style="text-align:right;" ><?php echo number_format($sumOtherSumCost,2);?></td>
        <td  style="text-align:right" >&nbsp;</td>
</tr>
<?php
	for($i=0; $i<count($dataOtherCost);$i++){
		if($dataOtherCost[$i]->OtherDetailCost != ""){
			if($dataOtherCost[$i]->CostItemCode == $CostItemCode){
?>
        <tr>
          <td >&nbsp;</td>
        <td >- <?php echo $dataOtherCost[$i]->OtherDetailCost;?></td>
        <td  style="text-align:right;" ><?php echo number_format($dataOtherCost[$i]->OtherSumCost,2);?></td>
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
if($gOtherCostItemCode[0]->CostItemCode){
?>
          <tr style="font-weight:bold;">
            <td style="text-align:right;">&nbsp;</td>
            <td style="text-align:right;">รวมเป็นค่าใช้จ่ายทั้งสิ้น</td>
            <td  style="text-align:right;" ><?php echo number_format($OtherTotalCost,2);?></td>
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




<script language="javascript" type="text/javascript">
function Save(f){
	jConfirmQ('บันทึกผลการตรจสอบเอกสารใช่หรือไม่?', 'ยืนยันการดำเนินการ', function(r) {
			if(r){
				var action_url = '?mod=<?php echo LURL::dotPage("action");?>';
				toSubmit(f,'check',action_url);
			}
	});
}
</script>
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage("action");?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="DocCode" id="DocCode" value="<?php echo $DocCode; ?>" />
<input type="hidden" name="EFormId" id="EFormId" value="<?php echo $EFormId; ?>" />
<input type="hidden" name="FormCode" id="FormCode" value="<?php echo $FormCode; ?>" />

<div style="padding:10px; border:1px solid #999; background-color:#EEE;">
<div style="padding-bottom:10px; font-weight:bold; font-size:14pt;">บันทึกผลการตรวจสอบเอกสาร :</div>
<div>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
   <tr>
    <th>ผลการตรวจสอบ</th>
    <td>
      <input name="DocStatusId" type="radio" value="3" checked="checked" /> ผ่านการตรวจสอบ
      <input name="DocStatusId" type="radio" value="4" /> <span style="color:#FF0000">ตีกลับเอกสาร</span>
    </td>
  </tr>
  <tr>
    <th style="vertical-align:top;">หมายเหตุ</th>
    <td><textarea name="Comment"  style="width:99%; height:100px;"></textarea></td>
  </tr>
  <tr>
 <th colspan="2">แนบไฟล์</th>
</tr>
<tr>
 <td colspan="2">
 <?php
		FilesManager::LinkFiles(
		array(
			"MaxUploadSize"=> 1,
			"imgWidth"		=>120,
			'imgHeight'		=> 100,
			'UploadType'	=> "multi",
			'FileTypeAllow'	=> "*",
			'ActiveObj'	=> "MultiDocId",
			'ActiveId'	=> "",
			'Category'	=> "ระบบนโยบายแผนงาน",
			'SubCategory'	=> "ระบบการเงิน",
			'System'		=> "backoffice",
			'Module'		=> "finance"
		));
?>
 </td>
 </tr>
 <tr>
    <th>ผู้ตรวจสอบ</th>
    <td><?php echo $_SESSION["Session_FullName"]; ?></td>
  </tr>
   <tr>
    <th>วันที่ตรวจสอบ</th>
    <td><?php echo dateformat(date('Y-m-d'));?></td>
  </tr>

    </table>


</div>

</div>


<div style="padding:15px; text-align:center;">
	<input type="button" class="btnActive" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
    <input type="button" class="btn" name="button" id="button" value=" ยกเลิก " onClick="goPage('?mod=finance.form.list_check')" />
</div>



</form>




<div style="text-align:right; padding:4px; margin-top:10px;"><a href="#" class="icon-up">กลับสู่ด้านบน</a></div>
