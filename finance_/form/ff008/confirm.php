<?php
include("config.php");
include("data.php");
//ltxt::print_r($_REQUEST);
?>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th>เลขที่ สช.น</th>
    <td><b><?php echo $_POST["DocCode"]; ?></b></td>
  </tr>
  <tr>
    <th>วันที่เอกสาร</th>
    <td><?php echo ShowDate($_POST["DocDate"]);?></td>
  </tr>

  <?php if($_POST["DocCode"]){ ?>
  <tr>
    <th>เลขที่ สช.น</th>
    <td><?php echo $_POST["DocCode"]; ?></td>
  </tr>
  <?php } ?>

  <tr>
    <th>เรื่อง</th>
    <td><?php echo $_POST["Topic"]; ?></td>
  </tr>  
    
  <tr>
    <th>ชื่อการประชุม</th>
    <td><?php echo $_POST["Title"]; ?></td>
  </tr>  
    
  <tr>
    <th>เรียน</th>
    <td><?php echo ($_POST["DocTo"])?$_POST["DocTo"]:'เลขาธิการคณะกรรมการสุขภาพแห่งชาติ (ผ่าน ผอ., ผอ.สอ.)'; ?></td>
  </tr>

<?php  if(count($_REQUEST["AttachCode"])){ ?>  
   <tr style="vertical-align:top;">
    <th>เอกสารแนบ</th>
    <td style="padding:5px;">
<style>
.tbl-list-attach td {
	border:none;
}
</style>
    
<table  width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list-attach">
<?php 
$no=1;
for($i=0;$i<count($_REQUEST["AttachCode"]);$i++){
?>    

    <tr style="vertical-align:top;">
        <td><?php echo $no; ?>) <?php echo $get->getAttachName($_REQUEST["AttachCode"][$i]); ?></td>
  	</tr>
    
<?php 
	$no++;
 }
 ?>
</table>
   
    </td>
  </tr> 
<?php } ?>  
  
  <tr>
    <th valign="top">มีความประสงค์จะ</th>
    <td valign="top">
	<?php 
   	$textDetail = str_replace( "<p>", "", $_POST["Detail"]);
	$textDetail = str_replace( "</p>", "", $textDetail);
   echo $textDetail; 
   ?>
    </td>
  </tr>
  <tr>
	<th>สถานที่ดำเนินการ</th>
  	<td><?php echo $_POST["Location"]; ?></td>
  </tr> 
  <tr>
	<th>จำนวนผู้เข้าร่วมประชุม</th>
  	<td><?php echo $_POST["AmountPerson"]; ?> <b>คน</b></td>
  </tr>   
  <tr>
    <th>ระยะเวลาดำเนินการ</th>
  	<td><?php echo ShowDate($_POST["StartDate"]);?>	<strong>ถึง</strong>     <?php echo ShowDate($_POST["EndDate"]);?>	     
</td>
  </tr> 
  <tr>
	<th>เลขที่เอกสารขอเบิกเงินยืมทดรอง</th>
  	<td><?php echo $_POST["DocCodeRefer"]; ?></td>
  </tr> 
  <tr style="font-weight:bold;">
    <th>งบขออนุมัติวางบิลเบิกจ่ายคงเหลือ</th>
    <td><div style="float:left; text-align:right; background-color:#FFC; color:#990000; "><?php echo number_format($_POST["TotalBillingRemain"],2); ?></div>&nbsp;<b>บาท</b></td>
  </tr>   
  
  

  
  
  
    <tr>
    <th colspan="2">รายการค่าใช้จ่ายที่ต้องการวางบิลเบิกจ่าย <span class="hint" style="font-weight:normal;">(ต้องไม่เกินยอดงบขออนุมัติคงเหลือของแต่ละรายการค่าใช้จ่ายที่ได้ขออนุมัติวางบิลไว้)</span></th>
  </tr>  

 

<tr>
<td colspan="2">



<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list-sub">
<thead>
  		<tr>
  		  <td style="text-align:center; width:30px;">ลำดับ</td>
    		<td  style="text-align:center;">รายการค่าใช้จ่าย/รายการชี้แจง</td>
            <td  style="width:120px; text-align:right;">งบขออนุมัติคงเหลือ</td>
            <td  style="width:120px; text-align:right;">งบขอวางบิลเบิกจ่าย</td>
            <td  style="width:50px;">&nbsp;</td>
          </tr>            
</thead>        
<?php 

$nc=0;
$gCostItemCode = array_unique($_REQUEST["CostItemCode"]);
for($m=0; $m <= count($gCostItemCode);$m++){
	for($i=0; $i<count($_POST["DetailCost"]);$i++){
		if($_POST["DetailCost"][$i] != ""){
			if($_POST["CostItemCode"][$i] == $gCostItemCode[$m]){
				$_POST["SumCost"][$i] = str_replace(",","",$_POST["SumCost"][$i]);
				$sumSumCost[$m] = $sumSumCost[$m] + $_POST["SumCost"][$i];
			}
		}
	}
}

for($m=0; $m <= count($gCostItemCode);$m++){
	if($gCostItemCode[$m]){
		//$SumBGPlan[$m]=$get->getSumSumRemain($_POST["DocCodeRefer"],$gCostItemCode[$m]);
		$SumBGPlan[$m]=$_REQUEST["ReferSumRemain"][$gCostItemCode[$m]];
		$TotalSumBGPlan = $TotalSumBGPlan+$SumBGPlan[$m];
		$txtRed = "";
		if($sumSumCost[$m] > $SumBGPlan[$m]){
			$txtRed = "Y";
			$BGInValid = "Y";
		}
?>
<tr style="font-weight:bold;">
  <td style="text-align:center;"><?php echo ($nc+1); ?></td>
	<td ><?php echo $get->getCostItemName($gCostItemCode[$m]);?></td>
	<td  style="text-align:right" ><?php echo number_format($SumBGPlan[$m],2);?></td>
	<td  style="text-align:right; <?php if($txtRed == "Y"){ ?> color:#FF0000; <?php } ?>" ><?php echo number_format($sumSumCost[$m],2);?></td>
	<td>&nbsp;</td>
        </tr>



<?php
	for($i=0; $i<count($_POST["DetailCost"]);$i++){
		if($_POST["DetailCost"][$i] != ""){
			if($_POST["CostItemCode"][$i] == $gCostItemCode[$m]){
?>
        <tr>
          <td >&nbsp;</td>
        <td >- <?php echo $_POST["DetailCost"][$i];?></td>
        <td  style="text-align:right;" >&nbsp;</td>
        <td  style="text-align:right;" ><?php echo number_format($_POST["SumCost"][$i],2);?></td>
        <td  style="text-align:right;" >&nbsp;</td>
        </tr>
<?php 
				}
			}
		} 
		$nc++;
	}
}
?>
<?php 
if($gCostItemCode[0] != ""){
$_POST["TotalCost"] = str_replace(",","",$_POST["TotalCost"]);

if($_POST["TotalCost"] > $_POST["TotalBillingRemain"]){
	$txtRed = "Y";
	$BGInValid = "Y";
}

?>
          <tr style="font-weight:bold;">
            <td style="text-align:right;">&nbsp;</td>
            <td style="text-align:right;">รวมเป็นค่าใช้จ่ายทั้งสิ้น</td>
            <td style="text-align:right;"><?php echo number_format($TotalSumBGPlan,2);?></td>
            <td  style="text-align:right; <?php if($txtRed == "Y"){ ?> color:#FF0000; <?php } ?>" ><?php echo number_format($_POST["TotalCost"],2);?></td>
            <td >บาท</td>
        </tr>
<?php }else{ ?>     
	<tr>
    	<td colspan="5" style="text-align:center;">-ไม่พบรายการ-</td>
    </tr> 
<?php } ?>        
	</table>    



<!--END รายการค่าใช้จ่าย-->


 
</td>
</tr>





    <tr>
    <th colspan="2">รายการค่าใช้จ่ายที่ต้องการเบิกจ่าย โดยไม่ได้ขออนุมัติไว้ก่อน <span class="hint" style="font-weight:normal;">(กรณีไม่ขออนุมัติไว้ก่อน โดยสามารถทำการขอเบิกจ่ายได้ครั้งละไม่เกิน 20,000 / สองหมื่นบาท)</span></th>
  </tr>  


<tr>
<td colspan="2">



<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list-sub">
<thead>
  		<tr>
  		  <td style="text-align:center; width:30px;">ลำดับ</td>
    		<td  style="text-align:center;">รายการค่าใช้จ่าย/รายการชี้แจง</td>
            <td  style="width:120px; text-align:right;">งบประมาณ</td>
            <td  style="width:120px; text-align:right;">งบขออนุมัติ</td>
            <td  style="width:50px;">&nbsp;</td>
          </tr>            
</thead>        
<?php 

$nc=0;
$gOtherCostItemCode = array_unique($_REQUEST["OtherCostItemCode"]);
for($m=0; $m <= count($gOtherCostItemCode);$m++){
	for($i=0; $i<count($_POST["OtherDetailCost"]);$i++){
		if($_POST["OtherDetailCost"][$i] != ""){
			if($_POST["OtherCostItemCode"][$i] == $gOtherCostItemCode[$m]){
				$_POST["OtherSumCost"][$i] = str_replace(",","",$_POST["OtherSumCost"][$i]);
				$sumOtherSumCost[$m] = $sumOtherSumCost[$m] + $_POST["OtherSumCost"][$i];
			}
		}
	}
}

for($m=0; $m <= count($gOtherCostItemCode);$m++){
	if($gOtherCostItemCode[$m]){
		$OtherSumBGPlan[$m]=$get->getSumPlan($_REQUEST["PrjActCode"],$_REQUEST["SourceExId"],0,0,0,"",$gOtherCostItemCode[$m]);
		$TotalOtherSumBGPlan = $TotalOtherSumBGPlan+$OtherSumBGPlan[$m];
		$txtRed = "";
		if($sumOtherSumCost[$m] > $OtherSumBGPlan[$m]){
			$txtRed = "Y";
			$BGInValid = "Y";
		}
?>
<tr style="font-weight:bold;">
  <td style="text-align:center;"><?php echo ($nc+1); ?></td>
	<td ><?php echo $get->getCostItemName($gOtherCostItemCode[$m]);?></td>
	<td  style="text-align:right" ><?php echo number_format($OtherSumBGPlan[$m],2);?></td>
	<td  style="text-align:right; <?php if($txtRed == "Y"){ ?> color:#FF0000; <?php } ?>" ><?php echo number_format($sumOtherSumCost[$m],2);?></td>
	<td>&nbsp;</td>
        </tr>



<?php
	for($i=0; $i<count($_POST["OtherDetailCost"]);$i++){
		if($_POST["OtherDetailCost"][$i] != ""){
			if($_POST["OtherCostItemCode"][$i] == $gOtherCostItemCode[$m]){
?>
        <tr>
          <td >&nbsp;</td>
        <td >- <?php echo $_POST["OtherDetailCost"][$i];?></td>
        <td  style="text-align:right;" >&nbsp;</td>
        <td  style="text-align:right;" ><?php echo number_format($_POST["OtherSumCost"][$i],2);?></td>
        <td  style="text-align:right;" >&nbsp;</td>
        </tr>
<?php 
				}
			}
		} 
		$nc++;
	}
}
?>
<?php 
if($gOtherCostItemCode[0] != ""){
$_POST["TotalCostOther"] = str_replace(",","",$_POST["TotalCostOther"]);
if($_POST["TotalCostOther"] > 20000){
	$txtRed = "Y";
	$BGInValid = "Y";
}
?>
          <tr style="font-weight:bold;">
            <td style="text-align:right;">&nbsp;</td>
            <td style="text-align:right;">รวมเป็นค่าใช้จ่ายทั้งสิ้น</td>
            <td style="text-align:right;"><?php echo number_format($TotalOtherSumBGPlan,2);?></td>
            <td  style="text-align:right; <?php if($txtRed == "Y"){ ?> color:#FF0000; <?php } ?>" ><?php echo number_format($_POST["TotalCostOther"],2);?></td>
            <td >บาท</td>
        </tr>
<?php }else{ ?>     
	<tr>
    	<td colspan="5" style="text-align:center;">-ไม่พบรายการ-</td>
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
$ArrDoc = explode(",",$_POST["MultiDocId"]);
if(count($ArrDoc) > 1){
	foreach($ArrDoc as $val){
		if($val != 0){
			echo '<div style="padding-left:10px;">- '.$get->getDocName($val).'</div>';
		}
	}	
}else{
	echo '<div style="text-align:center;">-ไม่พบรายการ-</div>';
}

 ?>
</td>
</tr>




  <tr>
    <th colspan="2">ข้อมูลผู้ขออนุมัติ</th>
  </tr>  
  <tr>
    <th>ปีงบประมาณ-คำสั่งที่</th>
    <td><?php echo $_REQUEST["RQOrgRoundCode"]; ?></td>
  </tr>    
  <tr>
    <th>หน่วยงานปฏิบัติงาน</th>
    <td><?php echo $get->getOrganizeName($_REQUEST["RQOrganizeCode"]); ?></td>
  </tr>  
  <tr>
    <th>ชื่อผู้ปฏิบัติงาน</th>
    <td><?php echo $get->fn_getFullNameByPersonalCode($_REQUEST["RQPersonalCode"]); ?></td>
  </tr>
  <tr>
    <th>ตำแหน่งปฏิบัติงาน</th>
    <td><?php echo $get->getPositionName($_REQUEST["RQPositionId"]); ?></td>
  </tr> 
  
  
  <tr>
    <th>&nbsp;</th>
    <td>
    <input type="button" name="button4" id="button4" value="กลับไปแก้ไข" class="btn" onclick="toggleView();" />
    <input type="button" class="btnActive" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
      <input type="button" name="button3" id="button3" value=" ยกเลิก " class="btn" onclick="Cancel('adminForm');" /></td>
  </tr>
</table>

<input type="hidden" id="BGInValid" name="BGInValid" value="<?php echo $BGInValid; ?>" />