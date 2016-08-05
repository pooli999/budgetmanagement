<?php
include("transfer_helper.php");
$get = new sHelper();

$method = $_REQUEST["method"];
if($method == 'excel'){ $get->getExcel(); }

?>
<style>

.tbl-sumary {	
	border:1px solid #FFF;
	border-collapse:collapse;
}
.tbl-sumary th {
	font-family: 'Microsoft Sans Serif';
	font-size:13px;		
	
	border:1px solid #FFF;
	background-color:#009999;
	color:#FFF;
	padding:3px;
}
.tbl-sumary td {
	font-family: 'Microsoft Sans Serif';
	font-size:13px;		
	
	border:1px solid #EEE;
	padding:3px;
}
.tbl-sumary .tr-plan {
	background-color:#9ed6d3;
	font-weight:bold;
}
.tbl-sumary .tr-plan td {
	color:#333;
}
.tbl-sumary .tr-project {
	background-color:#EEE;
}
.tbl-sumary .tr-project td {
	color:#333;
	border:1px solid #FFF;
}
.tbl-sumary .tr-sum {
	background-color:#009999;
	font-weight:bold;
	color:#FFF;
	text-align:right;
}

</style>

<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl-sumary">
   <tr>
   		<td colspan="8" style="border:0px; text-align:center; font-weight:bold; font-size:14px;">
   			รายงานการโอนเงินงบประมาณ <?php echo $_REQUEST["BgtYear"]; ?>  
            <?php if($_REQUEST["ExType"]=="Internal"){ echo "งบแผ่นดิน (งบ สช.)"; }else if($_REQUEST["ExType"]=="External"){ echo $get->getSourceExName($_REQUEST["SourceExId"]); } ?>
   		</td>
   </tr>
  <tr>
    <th style="width:10%;">รหัส</th>
    <th>แผนงาน/โครงการ/กิจกรรม</th>
    <th style="width:15%;">หน่วยงาน<br />เจ้าของ/ปฏิบัติงาน</th>
    <th style="width:10%;">งบประมาณ</th>
    <th style="width:10%;">งบรอโอนออก</th>
    <th style="width:10%;">งบโอนออก</th>
    <th style="width:10%;">งบรับโอน</th>
    <th style="width:10%;">งบคงเหลือ</th>
  </tr>
  <!--START วนลูปรายการแผนงาน สช.-->
  <?php 
  $plan = $get->getPlanItem($_REQUEST["BgtYear"]);//ltxt::print_r($plan);
  if($plan){
		  foreach($plan as $r_plan){
			  foreach($r_plan as $p=>$pp){
				  ${$p} = $pp;
			  }
			  	
			// (1) งบตามแผน
		    switch($_REQUEST["ExType"]){
			  case "Internal":
		  			$Plan = $get->getSumPlanBudget('tblbudget_project_activity_cost_internal','tblbudget_project_activity_cost_internal_month','Budget','CostIntId',$_REQUEST["BgtYear"],0,0,$PItemCode,0,0,0,0,0);
			  break;
			  case "External":
					$Plan = $get->getSumPlanBudget('tblbudget_project_activity_cost_external','tblbudget_project_activity_cost_external_month','Budget','CostExtId',$_REQUEST["BgtYear"],0,0,$PItemCode,0,0,0,0,$_REQUEST["SourceExId"]);
			  break;
			  default :
					$Nation 	=  $get->getSumPlanBudget('tblbudget_project_activity_cost_internal','tblbudget_project_activity_cost_internal_month','Budget','CostIntId',$_REQUEST["BgtYear"],0,0,$PItemCode,0,0,0,0,0);
					$Income 	=  $get->getSumPlanBudget('tblbudget_project_activity_cost_external','tblbudget_project_activity_cost_external_month','Budget','CostExtId',$_REQUEST["BgtYear"],0,0,$PItemCode,0,0,0,0,$_REQUEST["SourceExId"]);
					$Plan		=  $Nation+$Income;
			  break;
		    }		  
		  
			// (2) งบรอโอนออก
			$TferOutWait = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"N");

			// (3) งบโอนออก
			$TferOut = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"Y");
			
			// (4) งบรับโอน
			$TferIn = $get->getTferIn($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"Y");

			// (5) งบแผนรวมโอน => 1-2-3+4		งบคงเหลือ
			$Remain = $Plan - $TferOutWait - $TferOut + $TferIn;			  
	
  ?>
  <tr >
    <td class="tr-plan"><?php echo $PItemCode; ?></td>
    <td class="tr-plan"><?php echo $PItemName; ?></td>
    <td class="tr-plan">&nbsp;</td>
    <td class="tr-plan" style="text-align:right;"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
    <td class="tr-plan" style="text-align:right;"><?php echo ($TferOutWait)?number_format($TferOutWait,2):"-"; ?></td>
    <td class="tr-plan" style="text-align:right;"><?php echo ($TferOut)?number_format($TferOut,2):"-"; ?></td>
    <td class="tr-plan" style="text-align:right;"><?php echo ($TferIn)?number_format($TferIn,2):"-"; ?></td>
    <td class="tr-plan" style="text-align:right;"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
  </tr>
  
  
    <!--START วนลูปรายการโครงการ-->
	  <?php 
      $project = $get->getProjectItem($PItemCode);//ltxt::print_r($project);
      foreach($project as $r_project){
          foreach($r_project as $pr=>$ppr){
              ${$pr} = $ppr;
          }
		  
			// (1) งบตามแผน
		    switch($_REQUEST["ExType"]){
			  case "Internal":
		  			$Plan = $get->getSumPlanBudget('tblbudget_project_activity_cost_internal','tblbudget_project_activity_cost_internal_month','Budget','CostIntId',$_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,0,0,0,0);
			  break;
			  case "External":
					$Plan = $get->getSumPlanBudget('tblbudget_project_activity_cost_external','tblbudget_project_activity_cost_external_month','Budget','CostExtId',$_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,0,0,0,$_REQUEST["SourceExId"]);
			  break;
			  default :
					$Nation 	=  $get->getSumPlanBudget('tblbudget_project_activity_cost_internal','tblbudget_project_activity_cost_internal_month','Budget','CostIntId',$_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,0,0,0,0);
					$Income 	=  $get->getSumPlanBudget('tblbudget_project_activity_cost_external','tblbudget_project_activity_cost_external_month','Budget','CostExtId',$_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,0,0,0,$_REQUEST["SourceExId"]);
					$Plan		=  $Nation+$Income;
			  break;
		    }		  
		  
			// (2) งบรอโอนออก
			$TferOutWait = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"N");

			// (3) งบโอนออก
			$TferOut = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"Y");
			
			// (4) งบรับโอน
			$TferIn = $get->getTferIn($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"Y");

			// (5) งบแผนรวมโอน => 1-2-3+4		งบคงเหลือ
			$Remain = $Plan - $TferOutWait - $TferOut + $TferIn;			  
		  
      ?>
      <tr>
        <td class="tr-project" style="padding-left:20px; text-align:left;"><?php echo $PrjCode; ?></td>
        <td class="tr-project"><?php echo $PrjName; ?></td>
        <td class="tr-project" style="text-align:center;"><?php echo $get->getOrgShortName($_REQUEST["BgtYear"], $OrganizeCode);?></td>
        <td class="tr-project" style="text-align:right;"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="tr-project" style="text-align:right;"><?php echo ($TferOutWait)?number_format($TferOutWait,2):"-"; ?></td>
        <td class="tr-project" style="text-align:right;"><?php echo ($TferOut)?number_format($TferOut,2):"-"; ?></td>
        <td class="tr-project" style="text-align:right;"><?php echo ($TferIn)?number_format($TferIn,2):"-"; ?></td>
        <td class="tr-project" style="text-align:right;"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
      </tr>
      
      <!--START วนลูปรายการกิจกรรม-->
	  <?php 
      $act = $get->getActivityItem($PrjId);//ltxt::print_r($act);
      foreach($act as $r_act){
          foreach($r_act as $a=>$aa){
              ${$a} = $aa;
          }
		  
			// (1) งบตามแผน
		    switch($_REQUEST["ExType"]){
			  case "Internal":
		  			$Plan = $get->getSumPlanBudget('tblbudget_project_activity_cost_internal','tblbudget_project_activity_cost_internal_month','Budget','CostIntId',$_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,0);
			  break;
			  case "External":
					$Plan = $get->getSumPlanBudget('tblbudget_project_activity_cost_external','tblbudget_project_activity_cost_external_month','Budget','CostExtId',$_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,$_REQUEST["SourceExId"]);
			  break;
			  default :
					$Nation 	=  $get->getSumPlanBudget('tblbudget_project_activity_cost_internal','tblbudget_project_activity_cost_internal_month','Budget','CostIntId',$_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,0);
					$Income 	=  $get->getSumPlanBudget('tblbudget_project_activity_cost_external','tblbudget_project_activity_cost_external_month','Budget','CostExtId',$_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,$_REQUEST["SourceExId"]);
					$Plan		=  $Nation+$Income;
			  break;
		    }		  
		  
			// (2) งบรอโอนออก
			$TferOutWait = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"N");

			// (3) งบโอนออก
			$TferOut = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"Y");
			
			// (4) งบรับโอน
			$TferIn = $get->getTferIn($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"Y");

			// (5) งบแผนรวมโอน => 1-2-3+4		งบคงเหลือ
			$Remain = $Plan - $TferOutWait - $TferOut + $TferIn;			
      ?>
      <tr>
        <td class="tr-act" style="padding-left:35px;">&bull; <?php echo $PrjActCode; ?></td>
        <td class="tr-act"><?php echo $PrjActName; ?></td>
        <td class="tr-act" style="text-align:center;">(<?php echo $get->getOrgShortName($_REQUEST["BgtYear"], $OrganizeCode);?>)</td>
        <td class="tr-act" style="text-align:right;"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="tr-act" style="text-align:right;"><?php echo ($TferOutWait)?number_format($TferOutWait,2):"-"; ?></td>
        <td class="tr-act" style="text-align:right;"><?php echo ($TferOut)?number_format($TferOut,2):"-"; ?></td>
        <td class="tr-act" style="text-align:right;"><?php echo ($TferIn)?number_format($TferIn,2):"-"; ?></td>
        <td class="tr-act" style="text-align:right;"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
      </tr>
      <?php } ?>
      <!--END วนลูปรายการกิจกรรม-->
     
      <?php } ?>
      <!--END วนลูปรายการโครงการ-->

  
  
  
  <?php } ?>
  <!--END วนลูปรายการแผนงาน สช.-->
    <?php
	
			// (1) งบตามแผน
		    switch($_REQUEST["ExType"]){
			  case "Internal":
		  			$Plan = $get->getSumPlanBudget('tblbudget_project_activity_cost_internal','tblbudget_project_activity_cost_internal_month','Budget','CostIntId',$_REQUEST["BgtYear"],0,0,0,0,0,0,0,0);
			  break;
			  case "External":
					$Plan = $get->getSumPlanBudget('tblbudget_project_activity_cost_external','tblbudget_project_activity_cost_external_month','Budget','CostExtId',$_REQUEST["BgtYear"],0,0,0,0,0,0,0,$_REQUEST["SourceExId"]);
			  break;
			  default :
					$Nation 	=  $get->getSumPlanBudget('tblbudget_project_activity_cost_internal','tblbudget_project_activity_cost_internal_month','Budget','CostIntId',$_REQUEST["BgtYear"],0,0,0,0,0,0,0,0);
					$Income 	=  $get->getSumPlanBudget('tblbudget_project_activity_cost_external','tblbudget_project_activity_cost_external_month','Budget','CostExtId',$_REQUEST["BgtYear"],0,0,0,0,0,0,0,$_REQUEST["SourceExId"]);
					$Plan		=  $Nation+$Income;
			  break;
		    }		  
		  
			// (2) งบรอโอนออก
			$TferOutWait = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N");

			// (3) งบโอนออก
			$TferOut = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y");
			
			// (4) งบรับโอน
			$TferIn = $get->getTferIn($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y");

			// (5) งบแผนรวมโอน => 1-2-3+4		งบคงเหลือ
			$Remain = $Plan - $TferOutWait - $TferOut + $TferIn;				
  ?>
  <tr>
        <td class="tr-sum" colspan="3">รวมงบประมาณทั้งสิ้น</td>
        <td class="tr-sum"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="tr-sum"><?php echo ($TferOutWait)?number_format($TferOutWait,2):"-"; ?></td>
        <td class="tr-sum"><?php echo ($TferOut)?number_format($TferOut,2):"-"; ?></td>
        <td class="tr-sum"><?php echo ($TferIn)?number_format($TferIn,2):"-"; ?></td>
        <td class="tr-sum"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
      </tr>
 <?php }else{ //else if($plan) ?>
     <tr>
        <td colspan="8" style="text-align:center; color:#990000; background-color:#EEE;">ไม่มีรายการข้อมูล</td>
     </tr>
 <?php } //end if($plan) ?>
</table>





