<?php 
include("helper.php");
$get = new sHelper();
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/finance/style_finance.css'
));
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));
$this->DOC->setPathWays(array(
	array(
		'text' => getMenuItem(lurl::dotPage($startupPage))->MenuName,
		'link' => '?mod='.lurl::dotPage($startupPage)
	),
	array(
		'text' => $MenuName,
	),
));

?>

<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดโครงการในส่วนของ<?php echo $MenuName;?> </div>
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" class="btn" name="Cancel2" id="Cancel2" value="ย้อนกลับ" onclick="history.back(-1);" /></td>
  </tr>
</table>


<?php
$detail = $get->getPlanDetail($_REQUEST["PItemCode"]);
foreach( $detail as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
?>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
<th>ปีงบประมาณ</th>
    <td><?php echo $BgtYear;?></td>
  </tr>
<tr>
<th>รหัสนโยบายแผนงาน</th>
<td><?php echo $PItemCode;?></td>
</tr>
<tr>
<th>ชื่อนโยบายแผนงาน</th>
<td><?php echo $PItemName;?></td>
</tr>   
<tr>
<th>แผนงานต่อเนื่องที่เกี่ยวข้อง</th>
<td>
<?php
$ArrPlanSelect = $get->getPlanLongtermSelect($_REQUEST["PItemCode"]); 
//ltxt::print_r($ArrPlanSelect);
if($ArrPlanSelect){
	foreach($ArrPlanSelect as $r){
		echo '<div style="padding-bottom:5px">&bull; '.$get->getPlanLongName($PLongCode).'</div>';
	}
}else{
	echo '<span style="color:#999;">-ไม่ระบุ-</span>';
}

	?>            
</td>
</tr>   
<tr>
    <th colspan="2">ข้อมูลโครงการ</th>      
</tr>
<tr>
    <td colspan="2" >
    
    
    
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
    <thead>
      <tr>
        <td style="width:30px;">ลำดับ</td>
        <td style="width:80px;">รหัสโครงการ</td>
        <td>ชื่อโครงการ</td>
        <td style="width:100px;">เจ้าของโครงการ</td>
        <td style="width:120px; text-align:right;">กรอบงบประมาณ(บาท)</td>
        <td style="width:100px; text-align:right;">งบตามแผน(บาท)</td>
        <td style="width:100px; text-align:right;">งบใช้จ่าย(บาท)</td>
        <td style="width:100px; text-align:right;">งบคงเหลือ(บาท)</td>
      </tr>
      </thead>
      <tbody>
      <?php
	  $totalPrjBudget=0; 
	  $project = $get->getProjectItem($_REQUEST["PItemCode"]);
	  if($project){
			  $h=0;
			 foreach($project as $r_project){
				  foreach($r_project as $pr=>$ppr){
					  ${$pr} = $ppr;
				  }
				  $totalPrjBudget = $totalPrjBudget+$PrjBudget;
			  ?>
			  <tr style="vertical-align:top;">
				<td style="text-align:center;"><?php echo ($h+1); ?>.</td>
				<td style="text-align:center;"><?php echo $PrjCode; ?></td>
				<td><a href="?mod=budgetpay.plan.view_project&PrjId=<?php echo $PrjId; ?>"><?php echo $PrjName; ?></a></td>
				<td style="text-align:center;"><?php echo $get->getOrgShortName($BgtYear, $OrganizeCode);?></td>
				<td style="text-align:right;"><?php echo number_format($PrjBudget,2); ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <?php
				$h++;
			  }
			  ?>
               <tr style="vertical-align:top;">
				<td colspan="4" style="text-align:right; font-weight:bold;">รวมทั้งสิ้น</td>
				<td style="text-align:right; font-weight:bold;"><?php echo number_format($totalPrjBudget,2); ?></td>
				<td style="text-align:right; font-weight:bold;">&nbsp;</td>
				<td style="text-align:right; font-weight:bold;">&nbsp;</td>
				<td style="text-align:right; font-weight:bold;">&nbsp;</td>
			  </tr>
<?php }else{ ?>
		  <tr>
				<td colspan="8" style="text-align:center; color:#999;">ไม่มีประวัติการตรวจสอบข้อมูล</td>
		  </tr>
      <?php
	  }
	  ?>
      </tbody>
    </table>
    
    
    
    </td>
</tr> 

</table>



<div style="text-align:center; padding:10px">
<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="history.back(-1);" /> 
</div>





