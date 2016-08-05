<?php 
header("Content-type: text/html; charset=tis-620");
header("Content-Disposition: attachment; filename=BG".date("d-m-Y").".xls");
include("helper.php");
$get = new sHelper();
?>






<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl-sumary">
  <tr>
    <th style="width:80px;">รหัส</th>
    <th>แผนงาน/โครงการ/กิจกรรม</th>
    <th style="width:120px;">หน่วยงาน<br />เจ้าของ/ปฏิบัติงาน</th>
    <th style="width:100px;">งบประมาณ(บาท)</th>
    <th style="width:100px;" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย">รวมตัดจ่าย(บาท)</th>
    <th style="width:60px;">%ใช้จ่าย</th>
    <th style="width:100px;">คงเหลือ(บาท)</th>
    <th style="width:60px;">%คงเหลือ</th>
  </tr>
  <!--START วนลูปรายการแผนงาน สช.-->
  <?php 
  $plan = $get->getPlanItem($_REQUEST["BgtYear"]);//ltxt::print_r($plan);
  if($plan){
	  foreach($plan as $r_plan){
		  foreach($r_plan as $p=>$pp){
			  ${$p} = $pp;
		  }
		  switch($_REQUEST["ExType"]){
			  case "Internal":
					$Plan =  $get->getSumPlanBudgetExcel($_REQUEST["BgtYear"],0,0,$PItemCode);
			  break;
			  case "External":
					$Plan =  $get->getSumPlanBudgetExcel_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"],0,0,$PItemCode);
			  break;
			  default :
					$Nation 	=  $get->getSumPlanBudgetExcel($_REQUEST["BgtYear"],0,0,$PItemCode);
					$Income =  $get->getSumPlanBudgetExcel_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"],0,0,$PItemCode);
					$Plan	= $Nation+$Income;
			  break;
		  }
		  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode);
		  $PayWait = $get->getPayExcel($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"N");
		  $Pay = $get->getPayExcel($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"Y");
		  $AllPay = $Chain+$PayWait+$Pay;
		  $Remain = $Plan-$AllPay;
		  $perAllPay = ($AllPay)?(($AllPay*100)/$Plan):0;
		  $perRemain = ($Remain)?(($Remain*100)/$Plan):0;
  ?>
  <tr class="tr-plan" style="vertical-align:top;">
    <td><?php echo $PItemCode; ?></td>
    <td><?php echo $PItemName; ?></td>
    <td>&nbsp;</td>
    <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
    <td class="number"><?php echo ($perAllPay)?(number_format($perAllPay,2)."%"):"-"; ?></td>
    <td class="number"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
    <td class="number"><?php echo ($perRemain)?(number_format($perRemain,2)."%"):"-"; ?></td>
  </tr>
  
  
    <!--START วนลูปรายการโครงการ-->
	  <?php 
      $project = $get->getProjectItem($PItemCode);//ltxt::print_r($project);
      foreach($project as $r_project){
          foreach($r_project as $pr=>$ppr){
              ${$pr} = $ppr;
          }
		  switch($_REQUEST["ExType"]){
			  case "Internal":
					$Plan =  $get->getSumPlanBudgetExcel($_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode);
			  break;
			  case "External":
					$Plan =  $get->getSumPlanBudgetExcel_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode);
			  break;
			  default :
					$Nation 	=  $get->getSumPlanBudgetExcel($_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode);
					$Income =  $get->getSumPlanBudgetExcel_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode);
					$Plan	= $Nation+$Income;
			  break;
		  }
		  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode);
		  $PayWait = $get->getPayExcel($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"N");
		  $Pay = $get->getPayExcel($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"Y");
		  $AllPay = $Chain+$PayWait+$Pay;
		  $Remain = $Plan-$AllPay;
		  $perAllPay = ($AllPay)?(($AllPay*100)/$Plan):0;
		  $perRemain = ($Remain)?(($Remain*100)/$Plan):0;
      ?>
     
      <tr class="tr-project" style="vertical-align:top;">
        <td><?php echo $PrjCode; ?></td>
        <td><?php echo $PrjName; ?></td>
        <td style="text-align:center;"><?php echo $get->getOrgShortName($_REQUEST["BgtYear"], $OrganizeCode);?></td>
         <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
         <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
        <td class="number"><?php echo ($perAllPay)?(number_format($perAllPay,2)."%"):"-"; ?></td>
        <td class="number"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
        <td class="number"><?php echo ($perRemain)?(number_format($perRemain,2)."%"):"-"; ?></td>
      </tr>
      
      
       <tbody id="t-<?php echo $PrjCode; ?>">
      <!--START วนลูปรายการกิจกรรม-->
	  <?php 
      $act = $get->getActivityItem($PrjId);//ltxt::print_r($act);
      foreach($act as $r_act){
          foreach($r_act as $a=>$aa){
              ${$a} = $aa;
          }
		  switch($_REQUEST["ExType"]){
			  case "Internal":
					$Plan =  $get->getSumPlanBudgetExcel($_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,$PrjActCode);
			  break;
			  case "External":
					$Plan =  $get->getSumPlanBudgetExcel_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode);
			  break;
			  default :
					$Nation 	=  $get->getSumPlanBudgetExcel($_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,$PrjActCode);
					$Income =  $get->getSumPlanBudgetExcel_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode);
					$Plan	= $Nation+$Income;
			  break;
		  }
		  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode);
		  $PayWait = $get->getPayExcel($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"N");
		  $Pay = $get->getPayExcel($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"Y");
		  $AllPay = $Chain+$PayWait+$Pay;
		  $Remain = $Plan-$AllPay;
		  $perAllPay = ($AllPay)?(($AllPay*100)/$Plan):0;
		  $perRemain = ($Remain)?(($Remain*100)/$Plan):0;
      ?>
      <tr class="tr-act" style="vertical-align:top;">
        <td><?php echo $PrjActCode; ?></td>
        <td><?php echo $PrjActName; ?></td>
        <td style="text-align:center;">(<?php echo ($OrganizeCode)?($get->getOrgShortName($_REQUEST["BgtYear"],$OrganizeCode)):"-";?>)</td>
         <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
         <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
        <td class="number"><?php echo ($perAllPay)?(number_format($perAllPay,2)."%"):"-"; ?></td>
        <td class="number"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
        <td class="number"><?php echo ($perRemain)?(number_format($perRemain,2)."%"):"-"; ?></td>
      </tr>
      <?php } ?>
      <!--END วนลูปรายการกิจกรรม-->
      
      </tbody>
      
      <?php } ?>
      <!--END วนลูปรายการโครงการ-->

  
  
  
  <?php } ?>
  <!--END วนลูปรายการแผนงาน สช.-->
<?php
  switch($_REQUEST["ExType"]){
		case "Internal":
				$Plan =  $get->getSumPlanBudgetExcel($_REQUEST["BgtYear"]);
		break;
		case "External":
				$Plan =  $get->getSumPlanBudgetExcel_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"]);
		break;
		default :
				$Nation 	=  $get->getSumPlanBudgetExcel($_REQUEST["BgtYear"]);
				$Income =  $get->getSumPlanBudgetExcel_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"]);
				$Plan	= $Nation+$Income;
		break;
	}
	$Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
	$PayWait = $get->getPayExcel($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N");
	$Pay = $get->getPayExcel($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y");
	$AllPay = $Chain+$PayWait+$Pay;
	$Remain = $Plan-$AllPay;
	$perAllPay = ($AllPay)?(($AllPay*100)/$Plan):0;
	$perRemain = ($Remain)?(($Remain*100)/$Plan):0;
  ?>
   <tr class="tr-sum">
        <td colspan="3">รวมงบประมาณทั้งสิ้น</td>
        <td class="number tr-sum"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="number tr-sum" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><span class="number"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></span></td>
        <td class="number tr-sum"><?php echo ($perAllPay)?(number_format($perAllPay,2)."%"):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($perRemain)?(number_format($perRemain,2)."%"):"-"; ?></td>
      </tr>
<?php }else{ //else if($plan) ?>
     <tr>
        <td colspan="8" style="text-align:center; color:#990000; background-color:#EEE;">ไม่มีรายการข้อมูล</td>
     </tr>
<?php } //end if($plan) ?>
</table>



 </BODY>

</HTML>