<?php
include("config.php");
include("data.php");
//ltxt::print_r($_POST);
?>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
 <tr>
	<th>เลขที่สัญญายืมเงิน</th>
  	<td><b><?php echo $_POST["BorrowCode"]; ?></b></td>
  </tr> 
  <tr>
    <th>เลขที่ สช.น</th>
    <td><b><?php echo $_POST["DocCode"]; ?></b></td>
  </tr>
  <tr>
    <th>วันที่เอกสาร</th>
    <td><?php echo ShowDate($_POST["DocDate"]);?></td>
  </tr>
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
   
  
  
    <tr>
    <th colspan="2">เคลียร์เป็นค่าใช้จ่าย</th>
  </tr>  

 

<tr>
<td colspan="2">



<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list-sub">
<thead>
  		<tr>
  		  <td style="text-align:center; width:30px;">ลำดับ</td>
    		<td  style="text-align:center;">รายการค่าใช้จ่าย/รายการชี้แจง</td>
            <td  style="width:120px; text-align:right;">งบเคลียร์ค่าใช้จ่าย</td>
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
?>
<tr style="font-weight:bold;">
  <td style="text-align:center;"><?php echo ($nc+1); ?></td>
	<td ><?php echo $get->getCostItemName($gCostItemCode[$m]);?></td>
	<td  style="text-align:right; "><?php echo number_format($sumSumCost[$m],2);?></td>
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


?>
          <tr style="font-weight:bold;">
            <td style="text-align:right;">&nbsp;</td>
            <td style="text-align:right;">รวมเป็นค่าใช้จ่ายทั้งสิ้น</td>
            <td  style="text-align:right; " ><?php echo number_format($_POST["TotalCost"],2);?></td>
            <td >บาท</td>
        </tr>
<?php }else{ ?>     
	<tr>
    	<td colspan="4" style="text-align:center;">-ไม่พบรายการ-</td>
    </tr> 
<?php } ?>        
	</table>    



<!--END รายการค่าใช้จ่าย-->


 
</td>
</tr>



<?php 
	$BGBorrow = 0;
	$BGReturn = 0;
	$BGPlus = 0;
?>  
<tr style="font-weight:bold;">
    <th colspan="2">สรุปงบเคลียร์เงินยืมทดรอง</th>
</tr> 
 <tr style="font-weight:bold;">
    <th>ยอดเงินยืมทดรองจ่าย</th>
    <td><div style="float:left; text-align:right; width:120px; "><?php echo number_format($_POST["BGBorrow"],2); ?></div>&nbsp;<b>บาท</b></td>
  </tr>   
  <tr style="font-weight:bold;">
    <th>ยอดเคลียร์เป็นเงินสด/เงินโอนแล้ว</th>
    <td><div style="float:left; text-align:right; width:120px; "><?php echo number_format($_POST["BGReturn"],2); ?></div>&nbsp;<b>บาท</b></td>
  </tr> 
   <tr style="font-weight:bold;">
    <th>ยอดเคลียร์ค่าใช้จ่ายแล้ว</th>
    <td><div style="float:left; text-align:right; width:120px; "><?php echo number_format($_POST["BGClear"],2); ?></div>&nbsp;<b>บาท</b></td>
  </tr>
<?php if($_POST["ReturnCost"] > 0){ ?>  
  <tr style="font-weight:bold;">
    <th>
 ยอดเคลียร์เป็น
<span style="background-color:#FFC; font-weight:normal; color:#FF0000;">&nbsp;
<?php 
switch($_POST["ClearType"]){
	case "cash":
		echo "เงินสด";
		break;
	case "transfer":
		echo "เงินโอน";
		break;
}
?>  &nbsp;  
</span>   &nbsp;ครั้งนี้
    </th>
    <td><div style="float:left; text-align:right; width:120px; "><?php echo number_format($_POST["ReturnCost"],2); ?></div>&nbsp;<b>บาท</b></td>
  </tr>
<?php } ?>   
   <tr style="font-weight:bold;">
    <th>ยอดเคลียร์ค่าใช้จ่ายครั้งนี้</th>
    <td><div style="float:left; text-align:right; width:120px; "><?php echo number_format($_POST["TotalCost"],2); ?></div>&nbsp;<b>บาท</b></td>
  </tr>  
<?php if($_POST["ClearLastNo"]=="Y"){  ?>

   
 <?php if($BGPlus > 0){ ?> 
  <tr style="font-weight:bold;">
    <th>ยอดเบิกเพิ่ม</th>
    <td><div style="float:left; text-align:right; width:120px; background-color:#FFC; color:#990000; "><?php echo number_format($_POST["BGPlus"],2); ?></div>&nbsp;<b>บาท</b></td>
  </tr> 
   <?php } ?> 
   
     
<?php } ?>  




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