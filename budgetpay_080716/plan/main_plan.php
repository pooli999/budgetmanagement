<?php 
include("helper.php");
$get = new sHelper();
$this->DOC->setStyles(array(
	'modules/backoffice/budgetpay/style_budgetpay.css'
	,VSROOT.'modules/backoffice/finance/style_finance.css'
));
$this->DOC->setPathWays(array(
	array(
		'text' => แผนงบประมาณประจำปี
	)
));

function icoEditF1($BgtYear){
	$label = 'อนุมัติ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=finance.approve.general.general_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}

function icoEditF2($BgtYear){
	$label = 'อนุมัติ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=finance.approve.pay.pay_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}

function icoEditF3($BgtYear){
	$label = 'อนุมัติ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=finance.approve.meeting.meeting_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}

function icoEditF4($BgtYear){
	$label = 'อนุมัติ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=finance.approve.ot.ot_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}

function icoEditF5($BgtYear){
	$label = 'อนุมัติ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=finance.approve.transfer.transfer_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}

function icoEditF6($BgtYear){
	$label = 'อนุมัติ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=finance.approve.training.training_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}

function icoEditF7($BgtYear){
	$label = 'อนุมัติ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=finance.approve.general_pay.gpay_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}

function icoEditF8($BgtYear){
	$label = 'อนุมัติ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=finance.approve.meeting_pay.mpay_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}




?>

<script>
function loadSCT(BgtYear){
	window.location.href='?mod=budgetpay.plan.main_plan&BgtYear='+BgtYear+'#History';
}

function showHide(i){
	if(JQ('#t-'+i).is(':hidden')===true){
		/*JQ('#tbody-'+i).show('slow');*/
		JQ('#t-'+i).show();
		JQ('#a'+i).addClass('icon-decre');
		JQ('#a'+i).removeClass('icon-incre');
		/*JQ('#a'+i).html('ย่อ');*/
	}else{
		/*JQ('#tbody-'+i).hide('slow');*/
		JQ('#t-'+i).hide();
		JQ('#a'+i).removeClass('icon-decre');
		JQ('#a'+i).addClass('icon-incre');
		/*JQ('#a'+i).html('ขยาย');*/
	}
}

function ExportToExcel(){
	var BgtYear = JQ('#BgtYear').val();
	window.location = '?mod=budgetpay.plan.export&format=raw&method=excel&BgtYear='+BgtYear;
}

function PrintPage(){
	var BgtYear = JQ('#BgtYear').val();
	window.open('?mod=budgetpay.plan.export&format=raw&method=print&BgtYear='+BgtYear,null,'scrollbars=yes,height=700,width=920,toolbar=yes,menubar=yes,status=yes');
}

</script>


<div class="sysinfo">
<div class="sysname">แผนงบประมาณประจำปี</div>
<div class="sysdetail">แสดงละเอียดแผนงบประมาณประจำปี</div>
</div>

<?php 
/*$BgtYear			=2554;
$SourceType		= "Internal";
$SourceExId		=0;
$PrjCode			="54P12B";
$PrjActCode		="54P12B01";
$CostItemCode	="010100";
$get->getBudgetRemainForm($BgtYear,$SourceType,$SourceExId,0,0,0,$PrjCode,$PrjActCode,0,$CostItemCode); 
*/?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#eeebac;">
  <tr>
    <td style="padding:5px;">
    <a href="javascript:void(0)" class="ico print" onclick="PrintPage();">พิมพ์เอกสาร</a>
    <a href="javascript:void(0)" class="ico excel" onclick="ExportToExcel();">ส่งออกเป็น Excel</a>
    </td>
    <td style="text-align:right;">ปีงบประมาณ <?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?> <a name="History" id="History">&nbsp;</a></td>
  </tr>
</table>

<?php 
if(count($get->getExternalYear())){
	$twidth =  (count($get->getExternalYear())*2*70)+100+500+120+70+70+70+70; 
}else{
	$twidth =  '100%'; 
}
$tcolumn =   (count($get->getExternalYear())*2)+7;
?>
<table width="<?php echo $twidth; ?>" border="0" cellspacing="1" cellpadding="0" class="tbl-sumary">
  <tr>
    <th rowspan="2" style="width:20px;">&nbsp;</th>
    <th rowspan="2" style="width:100px;">รหัส</th>
    <th rowspan="2">แผนงาน/โครงการ/กิจกรรม</th>
    <th rowspan="2" style="width:120px;">หน่วยงาน<br />เจ้าของ/ปฏิบัติงาน</th>
    <th colspan="2">งบแผ่นดิน</th>
    <?php 
		$external = $get->getExternalYear();
		foreach($external as $r_external){
			foreach($r_external as $e=>$ee){
				${$e} = $ee;
			}
			echo "<th colspan='2'>".$SourceExName."</th>";
		}
	?>
    <th colspan="2">รวมทั้งสิ้น</th>
  </tr>
  <tr>
    <th style="width:70px;">แผน</th>
    <th style="width:70px;">ผล</th>
    <?php 
		$external = $get->getExternalYear();
		foreach($external as $r_external){
			foreach($r_external as $e=>$ee){
				${$e} = $ee;
			}
			echo "<th style='width:70px;'>แผน</th>";
			echo "<th style='width:70px;'>ผล</th>";
		}
	?>
    <th style="width:70px;">แผน</th>
    <th style="width:70px;">ผล</th>
  </tr>
  <!--START วนลูปรายการแผนงาน สช.-->
  <?php 
  $plan = $get->getPlanItem($_REQUEST["BgtYear"]);//ltxt::print_r($plan);
  if($plan){
	  foreach($plan as $r_plan){
		  foreach($r_plan as $p=>$pp){
			  ${$p} = $pp;
		  }
		  //$SumPlan 	= $get->getSumPlanBudget($_REQUEST["BgtYear"],0,0,$PItemCode); //แผนงบแผ่นดิน
		  //$SumResult 	= $get->getTotalPay($_REQUEST["BgtYear"],"Internal",0,0,0,$PItemCode); //ผลงบแผ่นดิน
		  //getTotalPay($BgtYear=0,$SourceType="",$SourceExId=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$CommitStatus="",$FormCode=""){
		  
		  $SumPlan = $get->getSumPlanBudget('tblbudget_project_activity_cost_internal','tblbudget_project_activity_cost_internal_month','Budget','CostIntId',$_REQUEST["BgtYear"],0,0,$PItemCode,0,0,0,0,0); //แผนงบแผ่นดิน
		  $SumResult 	= $get->getTotalPay($_REQUEST["BgtYear"],"Internal",0,0,0,$PItemCode); //ผลงบแผ่นดิน
		  
  ?>
  <tr class="tr-plan">
  	<td>&nbsp;</td>
    <td><?php echo $PItemCode; ?></td>
    <td><a href="?mod=budgetpay.plan.view_plan&PItemCode=<?php echo $PItemCode; ?>"><?php echo $PItemName; ?></a></td>
    <td>&nbsp;</td>
    <td class="number"><?php echo ($SumPlan)?number_format($SumPlan,2):"-"; ?></td>
    <td class="number"><?php echo ($SumResult)?number_format($SumResult,2):"-"; ?></td>
        <?php 
		$SumPlan_Inc=0;
		$SumResult_Inc=0;
		$AllSumPlan_Inc=0;
		$AllSumResult_Inc=0;
		$external = $get->getExternalYear();
		foreach($external as $r_external){
			foreach($r_external as $e=>$ee){
				${$e} = $ee;
			}
			
			$SumPlan_Inc 		= $get->getSumPlanBudget_Inc($_REQUEST["BgtYear"],$SourceExId,0,0,$PItemCode); //แผนเงินนอกงบ
			$SumResult_Inc 		= $get->getTotalPay($_REQUEST["BgtYear"],"External",$SourceExId,0,0,$PItemCode); //ผลเงินนอกงบ
			
			$AllSumPlan_Inc		= $AllSumPlan_Inc+$SumPlan_Inc;
			$AllSumResult_Inc	= $AllSumResult_Inc+$SumResult_Inc;
			
			echo '<td class="number">'.(($SumPlan_Inc)?number_format($SumPlan_Inc,2):"-").'</td>';
			echo '<td class="number">'.(($SumResult_Inc)?number_format($SumResult_Inc,2):"-").'</td>';
		}
		$totalSumPlan 	= $SumPlan+$AllSumPlan_Inc; 
		$totalSumResult 	= $SumResult+$AllSumResult_Inc;  
	?>
    <td class="number"><?php echo ($totalSumPlan)?number_format($totalSumPlan,2):"-"; ?></td>
    <td class="number"><?php echo ($totalSumResult)?number_format($totalSumResult,2):"-"; ?></td>
  </tr>
  
  
    <!--START วนลูปรายการโครงการ-->
	  <?php 
      $project = $get->getProjectItem($PItemCode);//ltxt::print_r($project);
      foreach($project as $r_project){
          foreach($r_project as $pr=>$ppr){
              ${$pr} = $ppr;
          }
		 // $SumPlan 	= $get->getSumPlanBudget($_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode); //แผนงบแผ่นดิน
		 // $SumResult 	= $get->getTotalPay($_REQUEST["BgtYear"],"Internal",$SourceExId,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode); //ผลงบแผ่นดิน
		 
		  $SumPlan = $get->getSumPlanBudget('tblbudget_project_activity_cost_internal','tblbudget_project_activity_cost_internal_month','Budget','CostIntId',$_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,0,0,0,0); //แผนงบแผ่นดิน
		  $SumResult 	= $get->getTotalPay($_REQUEST["BgtYear"],"Internal",0,0,0,$PItemCode,$PrjCode); //ผลงบแผ่นดิน
		 
      ?>
      <tr class="tr-project">
        <td style="text-align:center;"><a href="javascript:void(0)" onclick="showHide('<?php echo $PrjCode; ?>');" id="a<?php echo $PrjCode; ?>" class="icon-incre">&nbsp;</a></td>      
        <td><?php echo $PrjCode; ?></td>
        <td><a href="?mod=budgetpay.plan.view_project&PrjId=<?php echo $PrjId; ?>"><?php echo $PrjName; ?></a></td>
        <td style="text-align:center;"><?php echo $get->getOrgShortName($_REQUEST["BgtYear"], $OrganizeCode);?></td>
        <td class="number"><?php echo ($SumPlan)?number_format($SumPlan,2):"-"; ?></td>
        <td class="number"><?php echo ($SumResult)?number_format($SumResult,2):"-"; ?></td>
        <?php 
		$SumPlan_Inc=0;
		$SumResult_Inc=0;
		$AllSumPlan_Inc=0;
		$AllSumResult_Inc=0;
		$external = $get->getExternalYear();
		foreach($external as $r_external){
			foreach($r_external as $e=>$ee){
				${$e} = $ee;
			}
			
			$SumPlan_Inc 		= $get->getSumPlanBudget_Inc($_REQUEST["BgtYear"],$SourceExId,0,0,$PItemCode,$PrjCode); //แผนเงินนอกงบ
			$SumResult_Inc 		= $get->getTotalPay($_REQUEST["BgtYear"],"External",$SourceExId,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode); //ผลเงินนอกงบ
			
			$AllSumPlan_Inc		= $AllSumPlan_Inc+$SumPlan_Inc;
			$AllSumResult_Inc	= $AllSumResult_Inc+$SumResult_Inc;
			
			echo '<td class="number">'.(($SumPlan_Inc)?number_format($SumPlan_Inc,2):"-").'</td>';
			echo '<td class="number">'.(($SumResult_Inc)?number_format($SumResult_Inc,2):"-").'</td>';
		}
		$totalSumPlan 	= $SumPlan+$AllSumPlan_Inc; 
		$totalSumResult 	= $SumResult+$AllSumResult_Inc;  
		?>
        <td class="number"><?php echo ($totalSumPlan)?number_format($totalSumPlan,2):"-"; ?></td>
        <td class="number"><?php echo ($totalSumResult)?number_format($totalSumResult,2):"-"; ?></td>
      </tr>
      
      
      <tbody id="t-<?php echo $PrjCode; ?>" style="display:none;">
      <!--START วนลูปรายการกิจกรรม-->
	  <?php 
      $act = $get->getActivityItem($PrjId);  //ltxt::print_r($act);
      foreach($act as $r_act){
          foreach($r_act as $a=>$aa){
              ${$a} = $aa;
          }
		  
		 // $SumPlan 	= $get->getSumPlanBudget($_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,$PrjActCode); //แผนงบแผ่นดิน
		 // $SumResult 	= $get->getTotalPay($_REQUEST["BgtYear"],"Internal",$SourceExId,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode); //ผลงบแผ่นดิน
		  
		 //getSumPlanBudget($TblCost='',$TblMonth='',$Field='',$CostField='',$BgtYear=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$SourceExId=0)
		//getTotalPay($BgtYear=0,$SourceType="",$SourceExId=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$CommitStatus="",$FormCode=""){
		 
		 $SumPlan 	=  $get->getSumPlanBudget('tblbudget_project_activity_cost_internal','tblbudget_project_activity_cost_internal_month','Budget','CostIntId',$_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,0); //ผลงบแผ่นดิน
		 $SumResult 	= $get->getTotalPay($_REQUEST["BgtYear"],"Internal",0,0,0,$PItemCode,$PrjCode,$PrjActCode); //ผลงบแผ่นดิน

      ?>
      <tr class="tr-act">
       <td>&nbsp;</td>
        <td><?php echo $PrjActCode; ?></td>
        <td><a href="?mod=budgetpay.plan.view_activity&BgtYear=<?php echo $BgtYear; ?>&PItemCode=<?php echo $PItemCode; ?>&PrjId=<?php echo $PrjId; ?>&PrjActId=<?php echo $PrjActId; ?>&PrjActCode=<?php echo $PrjActCode; ?>"><?php echo $PrjActName; ?></a></td>
        <td style="text-align:center;">(<?php echo $get->getOrgShortName($_REQUEST["BgtYear"], $OrganizeCode);?>)</td>
        <td class="number"><?php echo ($SumPlan)?number_format($SumPlan,2):"-"; ?></td>
        <td class="number"><?php echo ($SumResult)?number_format($SumResult,2):"-"; ?></td>
        <?php
		$SumPlan_Inc=0;
		$SumResult_Inc=0;
		$AllSumPlan_Inc=0;
		$AllSumResult_Inc=0; 
		$external = $get->getExternalYear();
		foreach($external as $r_external){
			foreach($r_external as $e=>$ee){
				${$e} = $ee;
			}
			
			$SumPlan_Inc 		= $get->getSumPlanBudget_Inc($_REQUEST["BgtYear"],$SourceExId,0,0,$PItemCode,$PrjCode,$PrjActCode); //แผนเงินนอกงบ
			$SumResult_Inc 		= $get->getTotalPay($_REQUEST["BgtYear"],"External",$SourceExId,$OrgOwner,$OrgOperate,$PItemCode,$PrjCode,$PrjActCode); //ผลเงินนอกงบ
			
			$AllSumPlan_Inc		= $AllSumPlan_Inc+$SumPlan_Inc;
			$AllSumResult_Inc	= $AllSumResult_Inc+$SumResult_Inc;
			
			echo '<td class="number">'.(($SumPlan_Inc)?number_format($SumPlan_Inc,2):"-").'</td>';
			echo '<td class="number">'.(($SumResult_Inc)?number_format($SumResult_Inc,2):"-").'</td>';
		}
		$totalSumPlan 	= $SumPlan+$AllSumPlan_Inc; 
		$totalSumResult 	= $SumResult+$AllSumResult_Inc; 
		?>
        <td class="number"><?php echo ($totalSumPlan)?number_format($totalSumPlan,2):"-"; ?></td>
        <td class="number"><?php echo ($totalSumResult)?number_format($totalSumResult,2):"-"; ?></td>
      </tr>
      <?php } ?>
      <!--END วนลูปรายการกิจกรรม-->
      
      </tbody>
      <?php } ?>
      <!--END วนลูปรายการโครงการ-->

  
  
  
  <?php } ?>
  <!--END วนลูปรายการแผนงาน สช.-->
   <tr class="tr-sum">
        <td colspan="4">รวมงบประมาณทั้งสิ้น</td>
        <?php 
		//getSumPlanBudget($TblCost='',$TblMonth='',$Field='',$CostField='',$BgtYear=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$SourceExId=0){//งบแผนแผ่นดิน
		//$SumPlan 		= $get->getSumPlanBudget($_REQUEST["BgtYear"]); //แผนงบแผ่นดิน
		$SumPlan = $get->getSumPlanBudget('tblbudget_project_activity_cost_internal','tblbudget_project_activity_cost_internal_month','Budget','CostIntId',$_REQUEST["BgtYear"]); //แผนงบแผ่นดิน
		$SumResult 	= $get->getTotalPay($_REQUEST["BgtYear"]); //ผลงบแผ่นดิน
		//function getTotalPay($BgtYear=0,$SourceType="",$SourceExId=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0,$CommitStatus="",$FormCode=""){
		?>
        <td class="number tr-sum"><?php echo ($SumPlan)?number_format($SumPlan,2):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($SumResult)?number_format($SumResult,2):"-"; ?></td>
        <?php 
		$SumPlan_Inc=0;
		$SumResult_Inc=0;
		$AllSumPlan_Inc=0;
		$AllSumResult_Inc=0;
		$external = $get->getExternalYear();
		foreach($external as $r_external){
			foreach($r_external as $e=>$ee){
				${$e} = $ee;
			}
			$SumPlan_Inc 		= $get->getSumPlanBudget_Inc($_REQUEST["BgtYear"],$SourceExId); //แผนเงินนอกงบ
			$SumResult_Inc 		= $get->getTotalPay($_REQUEST["BgtYear"],"External",$SourceExId); //ผลเงินนอกงบ
			
			$AllSumPlan_Inc		= $AllSumPlan_Inc+$SumPlan_Inc;
			$AllSumResult_Inc	= $AllSumResult_Inc+$SumResult_Inc;
			
			echo '<td class="number  tr-sum">'.(($SumPlan_Inc)?number_format($SumPlan_Inc,2):"-").'</td>';
			echo '<td class="number  tr-sum">'.(($SumResult_Inc)?number_format($SumResult_Inc,2):"-").'</td>';
		}
		$totalSumPlan 	= $SumPlan+$AllSumPlan_Inc; 
		$totalSumResult 	= $SumResult+$AllSumResult_Inc; 
		?>
        <td class="number tr-sum"><?php echo ($totalSumPlan)?number_format($totalSumPlan,2):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($totalSumResult)?number_format($totalSumResult,2):"-"; ?></td>
      </tr>
       <?php }else{ //else if($plan) ?>
     <tr>
        <td colspan="<?php echo $tcolumn; ?>" style="text-align:center; color:#990000; background-color:#EEE;">ไม่มีรายการข้อมูล</td>
     </tr>
 <?php } //end if($plan) ?>

</table>



<br />
<br />