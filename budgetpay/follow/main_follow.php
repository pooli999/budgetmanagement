<?php 
$this->DOC->setStyles(array(
	'modules/backoffice/budgetpay/style_budgetpay.css'
));
include("helper.php");
$get = new sHelper();
$this->DOC->setPathWays(array(
	array(
		'text' => ติดตามการกันเงินงบประมาณ
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

function loadSCT(BgtYear){
	var ExType 	= document.getElementById("ExType").value;
	if(ExType == "External"){
		var SourceExId = document.getElementById("SourceExId").value;
		window.location.href='?mod=budgetpay.follow.main_follow&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId+'#History';
	}else{
		window.location.href='?mod=budgetpay.follow.main_follow&BgtYear='+BgtYear+'&ExType='+ExType+'#History';
	}
}

function loadExternalType(ExType){
	var BgtYear 	= document.getElementById("BgtYear").value;
	window.location.href='?mod=budgetpay.follow.main_follow&BgtYear='+BgtYear+'&ExType='+ExType+'#History';
}

function loadPage(SourceExId){
	var BgtYear 	= document.getElementById("BgtYear").value;
	var ExType 	= document.getElementById("ExType").value;
	window.location.href='?mod=budgetpay.follow.main_follow&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId+'#History';
}

function ExportToExcel(){
	var BgtYear = JQ('#BgtYear').val();
	var ExType = JQ('#ExType').val();
	var SourceExId = JQ('#SourceExId').val();
	window.location = '?mod=budgetpay.follow.export&format=raw&method=excel&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId;
}

function PrintPage(){
	var BgtYear = JQ('#BgtYear').val();
	var ExType = JQ('#ExType').val();	
	var SourceExId = JQ('#SourceExId').val();
	window.open('?mod=budgetpay.follow.export&format=raw&method=print&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId,null,'scrollbars=yes,height=700,width=920,toolbar=yes,menubar=yes,status=yes');
}

</script>


<div class="sysinfo">
<div class="sysname">ติดตามการกันเงินงบประมาณ</div>
<div class="sysdetail">แสดงรายการแบบฟอร์มเอกสารการเงิน</div>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#eeebac;">
  <tr>
    <td style="padding:5px;">
    <a href="javascript:void(0)" class="ico print" onclick="PrintPage();">พิมพ์เอกสาร</a>
    <a href="javascript:void(0)" class="ico excel" onclick="ExportToExcel();">ส่งออกเป็น Excel</a>    
    </td>
    <td style="text-align:right;">
    ปีงบประมาณ <?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?> 
    แหล่งงบประมาณ
    <select name="ExType" id="ExType" onchange="loadExternalType(this.value)">
        <option value="0" <?php if($_REQUEST["ExType"]=="0"){ ?> selected="selected" <?php } ?>>ทั้งหมด</option>
        <option value="Internal" <?php if($_REQUEST["ExType"]=="Internal"){ ?> selected="selected" <?php } ?>>งบแผ่นดิน</option>
        <option value="External" <?php if($_REQUEST["ExType"]=="External"){ ?> selected="selected" <?php } ?>>เงินนอกงบ</option>
    </select> 
    <?php if($_REQUEST["ExType"] == "External"){ ?>ระบุ <?php echo $get->getSourceExternal($_REQUEST["SourceExId"]);?> <?php } ?>
    <a name="History" id="History">&nbsp;</a>
    </td>
  </tr>
</table>


<table width="1640" border="0" cellspacing="0" cellpadding="0" class="tbl-sumary">
  <tr>
    <th style="width:20px;">&nbsp;</th>
    <th style="width:80px;">รหัส</th>
    <th style="width:300px;">แผนงาน/โครงการ/กิจกรรม</th>
    <th style="width:120px;">หน่วยงาน<br />เจ้าของ/ปฏิบัติงาน</th>
    <th style="width:80px;">งบตามแผน</th>
    <th style="width:80px;">งบรอโอนออก</th>
    <th style="width:80px;">งบโอนออก</th>
    <th style="width:80px;">งบรับโอน</th>
    <th style="width:100px;">งบแผนรวมโอน</th>
    <th style="width:80px;">งบรอหลักการ</th>
    <th style="width:80px;">งบหลักการ</th>
    <th style="width:80px;">งบผูกพัน</th>
    <th style="width:80px;">งบรอตัดจ่าย</th>
    <th style="width:80px;">งบตัดจ่าย</th>
    <th style="width:100px;" title="งบรวมจ่ายจริง=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย">งบรวมจ่ายจริง</th>
    <th style="width:100px;">คงเหลือ<br /><span style="font-size:12px; font-weight:normal;">(ไม่รวมหลักการ)</span></th>
    <th style="width:100px;">คงเหลือ<br /><span style="font-size:12px; font-weight:normal;">(รวมหลักการ)</span></th>
  </tr>
  <!--START วนลูปรายการแผนงาน สช.-->
  <?php 
  $plan = $get->getPlanItem($_REQUEST["BgtYear"]);//ltxt::print_r($plan);
  if($plan){
	  foreach($plan as $r_plan){
		  foreach($r_plan as $p=>$pp){
			  ${$p} = $pp;
		  }
		  
/*		  switch($_REQUEST["ExType"]){
			  case "Internal":
					//$Plan =  $get->getSumPlanBudget($_REQUEST["BgtYear"],0,0,$PItemCode);
					//function getSumPlanBudget($TblCost='',$TblMonth='',$Field='',$CostField='',$BgtYear=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0)
					$Plan = $get->getSumPlanBudget('tblbudget_project_activity_cost_internal','tblbudget_project_activity_cost_internal_month','Budget','CostIntId',$BgtYear=0,$OrgOwner=0,$OrgOperate=0,$PItemCode=0,$PrjCode="",$PrjActCode=0,$CostTypeId=0,$CostItemCode=0);
					
			  break;
			  case "External":
					$Plan =  $get->getSumPlanBudget_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"],0,0,$PItemCode);
			  break;
			  default :
					$Nation 	=  $get->getSumPlanBudget($_REQUEST["BgtYear"],0,0,$PItemCode);
					$Income =  $get->getSumPlanBudget_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"],0,0,$PItemCode);
					$Plan	= $Nation+$Income;
			  break;
		  }*/

		   // (1)  งบตามแผน
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
			$TferWait = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"N");

			// (3) งบโอนออก
			$TferOut = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"Y");
			
			// (4) งบรับโอน
			$TferIn = $get->getTferIn($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"Y");

			// (5) งบแผนรวมโอน => 1-2-3+4
			$SumTfer = $Plan - $TferWait - $TferOut + $TferIn;

			// (6) งบรอหลักการ
			$BookWait = $get->getHoldFormalWait($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,0,"N","N",0);

			// (7) งบหลักการ
			$Book = $get->getHoldFormal($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,$FormCode);

			// (8) งบประมาณผูกพัน
			$Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,$FormCode);

			// (9) งบรอตัดจ่าย
			$PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"N",$FormCode);

			// (10) งบตัดจ่าย
			$Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"Y",$FormCode);
		  
			// (11) งบรวมจ่ายจริง => 8+9+10
			$SumPay = $Chain + $PayWait + $Pay;
			
			// (12) คงเหลือ (ไม่รวมหลักการ) => 5-11
			 $Remain =  $SumTfer - $SumPay;
		  
			// (13) คงเหลือ (รวมหลักการ) => 5-6-7-11
			$RemainPlus =  $SumTfer - $BookWait - $Book - $SumPay;

  ?>
  <tr class="tr-plan" style="vertical-align:top;">
    <td>&nbsp;</td>
    <td><?php echo $PItemCode; ?></td>
    <td><?php echo $PItemName; ?></td>
    <td>&nbsp;</td>
    <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
    <td class="number"><?php echo ($TferWait)?number_format($TferWait,2):"-"; ?></td>
    <td class="number"><?php echo ($TferOut)?number_format($TferOut,2):"-"; ?></td>
    <td class="number"><?php echo ($TferIn)?number_format($TferIn,2):"-"; ?></td>
    <td class="number"><?php echo ($SumTfer)?number_format($SumTfer,2):"-"; ?></td>
    <td class="number"><?php echo ($BookWait)?number_format($BookWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="งบรวมจ่ายจริง=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($SumPay)?number_format($SumPay,2):"-"; ?></td>
    <td class="number"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
    <td class="number"><?php echo ($RemainPlus)?number_format($RemainPlus,2):"-"; ?></td>    
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
			$TferWait = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"N");

			// (3) งบโอนออก
			$TferOut = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"Y");
			
			// (4) งบรับโอน
			$TferIn = $get->getTferIn($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"Y");

			// (5) งบแผนรวมโอน => 1-2-3+4
			$SumTfer = $Plan - $TferWait - $TferOut + $TferIn;

			// (6) งบรอหลักการ
			$BookWait = $get->getHoldFormalWait($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,0,"N","N",0);

			// (7) งบหลักการ
			$Book = $get->getHoldFormal($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,$FormCode);

			// (8) งบประมาณผูกพัน
			$Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,$FormCode);

			// (9) งบรอตัดจ่าย
			$PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"N",$FormCode);

			// (10) งบตัดจ่าย
			$Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"Y",$FormCode);
		  
			// (11) งบรวมจ่ายจริง => 8+9+10
			$SumPay = $Chain + $PayWait + $Pay;
			
			// (12) คงเหลือ (ไม่รวมหลักการ) => 5-11
			 $Remain =  $SumTfer - $SumPay;
		  
			// (13) คงเหลือ (รวมหลักการ) => 5-6-7-11
			$RemainPlus =  $SumTfer - $BookWait - $Book - $SumPay;
		  
/*		  switch($_REQUEST["ExType"]){
			  case "Internal":
					$Plan =  $get->getSumPlanBudget($_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode);
			  break;
			  case "External":
					$Plan =  $get->getSumPlanBudget_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode);
			  break;
			  default :
					$Nation 	=  $get->getSumPlanBudget($_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode);
					$Income =  $get->getSumPlanBudget_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode);
					$Plan	= $Nation+$Income;
			  break;
		  }
		  $FormalWait = $get->getHoldFormalWait($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode);
		  $Formal = $get->getHoldFormal($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode);
		  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode);
		  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"N");
		  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"Y");
		  $AllPay = $Chain+$PayWait+$Pay;
		  $Remain = $Plan-$AllPay;
		  $RemainFormal = $Plan-$AllPay-$FormalWait-$Formal;*/
      ?>
      <tr class="tr-project" style="vertical-align:top;">
        <td style="text-align:center;"><a href="javascript:void(0)" onclick="showHide('<?php echo $PrjCode; ?>');" id="a<?php echo $PrjCode; ?>" class="icon-incre">&nbsp;</a></td>
        <td><?php echo $PrjCode; ?></td>
        <td><?php echo $PrjName; ?></td>
        <td style="text-align:center;"><?php echo $get->getOrgShortName($_REQUEST["BgtYear"], $OrganizeCode);?></td>
        <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="number"><?php echo ($TferWait)?number_format($TferWait,2):"-"; ?></td>
        <td class="number"><?php echo ($TferOut)?number_format($TferOut,2):"-"; ?></td>
        <td class="number"><?php echo ($TferIn)?number_format($TferIn,2):"-"; ?></td>
        <td class="number"><?php echo ($SumTfer)?number_format($SumTfer,2):"-"; ?></td>
        <td class="number"><?php echo ($BookWait)?number_format($BookWait,2):"-"; ?></td>
        <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
        <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
        <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
        <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
        <td class="number" title="งบรวมจ่ายจริง=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($SumPay)?number_format($SumPay,2):"-"; ?></td>
        <td class="number"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
        <td class="number"><?php echo ($RemainPlus)?number_format($RemainPlus,2):"-"; ?></td>
      </tr>
      
      
      <tbody id="t-<?php echo $PrjCode; ?>" style="display:none;">
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
			$TferWait = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"N");

			// (3) งบโอนออก
			$TferOut = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"Y");
			
			// (4) งบรับโอน
			$TferIn = $get->getTferIn($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"Y");

			// (5) งบแผนรวมโอน => 1-2-3+4
			$SumTfer = $Plan - $TferWait - $TferOut + $TferIn;

			// (6) งบรอหลักการ
			$BookWait = $get->getHoldFormalWait($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,0,"N","N",0);

			// (7) งบหลักการ
			$Book = $get->getHoldFormal($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,$FormCode);

			// (8) งบประมาณผูกพัน
			$Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,$FormCode);

			// (9) งบรอตัดจ่าย
			$PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"N",$FormCode);

			// (10) งบตัดจ่าย
			$Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"Y",$FormCode);
		  
			// (11) งบรวมจ่ายจริง => 8+9+10
			$SumPay = $Chain + $PayWait + $Pay;
			
			// (12) คงเหลือ (ไม่รวมหลักการ) => 5-11
			 $Remain =  $SumTfer - $SumPay;
		  
			// (13) คงเหลือ (รวมหลักการ) => 5-6-7-11
			$RemainPlus =  $SumTfer - $BookWait - $Book - $SumPay;

/*		  switch($_REQUEST["ExType"]){
			  case "Internal":
					$Plan =  $get->getSumPlanBudget($_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,$PrjActCode);
			  break;
			  case "External":
					$Plan =  $get->getSumPlanBudget_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode);
			  break;
			  default :
					$Nation 	=  $get->getSumPlanBudget($_REQUEST["BgtYear"],0,0,$PItemCode,$PrjCode,$PrjActCode);
					$Income =  $get->getSumPlanBudget_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode);
					$Plan	= $Nation+$Income;
			  break;
		  }
		  $FormalWait = $get->getHoldFormalWait($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode);
		  $Formal = $get->getHoldFormal($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode);
		  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode);
		  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"N");
		  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"Y");
		  $AllPay = $Chain+$PayWait+$Pay;
		  $Remain = $Plan-$AllPay;
		  $RemainFormal = $Plan-$AllPay-$FormalWait-$Formal;*/
      ?>
      <tr class="tr-act" style="vertical-align:top;">
        <td>&nbsp;</td>
        <td><?php echo $PrjActCode; ?></td>
        <td><?php echo $PrjActName; ?></td>
        <td style="text-align:center;">(<?php echo ($OrganizeCode)?($get->getOrgShortName($_REQUEST["BgtYear"],$OrganizeCode)):"-";?>)</td>
        <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="number"><?php echo ($TferWait)?number_format($TferWait,2):"-"; ?></td>
        <td class="number"><?php echo ($TferOut)?number_format($TferOut,2):"-"; ?></td>
        <td class="number"><?php echo ($TferIn)?number_format($TferIn,2):"-"; ?></td>
        <td class="number"><?php echo ($SumTfer)?number_format($SumTfer,2):"-"; ?></td>
        <td class="number"><?php echo ($BookWait)?number_format($BookWait,2):"-"; ?></td>
        <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
        <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
        <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
        <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
        <td class="number" title="งบรวมจ่ายจริง=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($SumPay)?number_format($SumPay,2):"-"; ?></td>
        <td class="number"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
        <td class="number"><?php echo ($RemainPlus)?number_format($RemainPlus,2):"-"; ?></td>
      </tr>
      <?php } ?>
      <!--END วนลูปรายการกิจกรรม-->
      
      </tbody>
      <?php } ?>
      <!--END วนลูปรายการโครงการ-->

  
  
  
  <?php } ?>
  <!--END วนลูปรายการแผนงาน สช.-->
<?php
/*  switch($_REQUEST["ExType"]){
		case "Internal":
				$Plan =  $get->getSumPlanBudget($_REQUEST["BgtYear"]);
		break;
		case "External":
				$Plan =  $get->getSumPlanBudget_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"]);
		break;
		default :
				$Nation 	=  $get->getSumPlanBudget($_REQUEST["BgtYear"]);
				$Income =  $get->getSumPlanBudget_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"]);
				$Plan	= $Nation+$Income;
		break;
	}
	$FormalWait = $get->getHoldFormalWait($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
	$Formal = $get->getHoldFormal($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
	$Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
	$PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N");
	$Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y");
	$AllPay = $Chain+$PayWait+$Pay;
	$Remain = $Plan-$AllPay;
	$RemainFormal = $Plan-$AllPay-$FormalWait-$Formal;*/
	
		   // (1)  งบตามแผน
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
			$TferWait = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N");

			// (3) งบโอนออก
			$TferOut = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y");
			
			// (4) งบรับโอน
			$TferIn = $get->getTferIn($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y");

			// (5) งบแผนรวมโอน => 1-2-3+4
			$SumTfer = $Plan - $TferWait - $TferOut + $TferIn;

			// (6) งบรอหลักการ
			$BookWait = $get->getHoldFormalWait($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,0,"N","N",0);

			// (7) งบหลักการ
			$Book = $get->getHoldFormal($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,$FormCode);

			// (8) งบประมาณผูกพัน
			$Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,$FormCode);

			// (9) งบรอตัดจ่าย
			$PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N",$FormCode);

			// (10) งบตัดจ่าย
			$Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y",$FormCode);
		  
			// (11) งบรวมจ่ายจริง => 8+9+10
			$SumPay = $Chain + $PayWait + $Pay;
			
			// (12) คงเหลือ (ไม่รวมหลักการ) => 5-11
			 $Remain =  $SumTfer - $SumPay;
		  
			// (13) คงเหลือ (รวมหลักการ) => 5-6-7-11
			$RemainPlus =  $SumTfer - $BookWait - $Book - $SumPay;	
	
  ?>
   <tr class="tr-sum" style="vertical-align:top;">
        <td colspan="4">รวมงบประมาณทั้งสิ้น</td>
        <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="number"><?php echo ($TferWait)?number_format($TferWait,2):"-"; ?></td>
        <td class="number"><?php echo ($TferOut)?number_format($TferOut,2):"-"; ?></td>
        <td class="number"><?php echo ($TferIn)?number_format($TferIn,2):"-"; ?></td>
        <td class="number"><?php echo ($SumTfer)?number_format($SumTfer,2):"-"; ?></td>
        <td class="number"><?php echo ($BookWait)?number_format($BookWait,2):"-"; ?></td>
        <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
        <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
        <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
        <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
        <td class="number" title="งบรวมจ่ายจริง=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($SumPay)?number_format($SumPay,2):"-"; ?></td>
        <td class="number"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
        <td class="number"><?php echo ($RemainPlus)?number_format($RemainPlus,2):"-"; ?></td>
   </tr>
<?php }else{ //else if($plan) ?>
     <tr>
        <td colspan="17" style="text-align:center; color:#990000; background-color:#EEE;">ไม่มีรายการข้อมูล</td>
     </tr>
<?php } //end if($plan) ?>
</table>


<?php
//จำนวนเอกสารทั้งหมด
$A_Form1		= 	$get->getAmountDoc("tblintra_eform_formal_general",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form2		= 	$get->getAmountDoc("tblintra_eform_formal_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form3		= 	$get->getAmountDoc("tblintra_eform_formal_meeting",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form4		= 	$get->getAmountDoc("tblintra_eform_formal_ot",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form5		= 	$get->getAmountDoc("tblintra_eform_transfer",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form6		= 	$get->getAmountDoc("tblintra_eform_formal_borrow",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form7		= 	$get->getAmountDoc("tblintra_eform_advance",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form8		= 	$get->getAmountDoc("tblintra_eform_advance_clear",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form9		= 	$get->getAmountDoc("tblintra_eform_mat_urgent",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form10		= 	$get->getAmountDoc("tblintra_eform_formal_mat",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form11		= 	$get->getAmountDoc("tblintra_eform_formal_general_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form12		= 	$get->getAmountDoc("tblintra_eform_formal_meeting_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form13		= 	$get->getAmountDoc("tblintra_eform_advance_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form14		= 	$get->getAmountDoc("tblintra_eform_formal_ot_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form15		= 	$get->getAmountDoc("tblintra_eform_formal_mat_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$SumA_Form	= $A_Form1+$A_Form2+$A_Form3+$A_Form4+$A_Form5+$A_Form6+$A_Form7+$A_Form8+$A_Form9+$A_Form10+$A_Form11+$A_Form12+$A_Form13+$A_Form14+$A_Form15;
?>


<!--<div class="topic-break">จำแนกตามแบบฟอร์มเอกสารการเงิน ประจำปี <?php //echo ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543); ?></div>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
  <tr>
    <th style="width:30px;">ลำดับ</th>
    <th>ชื่อแบบฟอร์ม</th>
    <th style="width:80px;">จำนวน</th>
    <th style="width:80px;">งบประมาณ</th>
    <th style="width:80px;">งบรออนุมัติ</th>
    <th style="width:80px;">งบกันเงิน</th>
    <th style="width:80px;">งบผูกพัน</th>
    <th style="width:80px;">งบรอตัดจ่าย</th>
    <th style="width:80px;">งบตัดจ่าย</th>
    <th style="width:100px;">งบรวมตัดจ่าย</th>
  </tr>
  <?php
  //แบบฟอร์มที่ 1
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"1,2,3","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"1,2,3","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"1,2,3");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"1,2,3");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","1,2,3");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","1,2,3");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
  <tr>
    <td style="text-align:center;">1.</td>
    <td><a href="?mod=budgetpay.follow.general.general_list">แบบฟอร์มขออนุมัติหลักการทั่วไป/หลักการสัญญาจ้าง OS/หลักการข้อตกลง</a></td>
    <td style="text-align:center;"><?php echo $A_Form1; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"1,2,3","N","N"); echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //แบบฟอร์มที่ 2
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"4","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"4","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"4");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"4");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","4");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","4");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
  <tr>
    <td style="text-align:center;">2.</td>
    <td><a href="?mod=budgetpay.follow.pay.pay_list">แบบฟอร์มขออนุมัติเบิกจ่าย</a></td>
    <td style="text-align:center;"><?php echo $A_Form2; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //แบบฟอร์มที่ 3
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"5,6","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"5,6","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"5,6");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"5,6");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","5,6");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","5,6");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
  <tr>
    <td style="text-align:center;">3.</td>
    <td><a href="?mod=budgetpay.follow.meeting.meeting_list">แบบฟอร์มขออนุมัติจัดประชุม/เดินทางไปปฏิบัติงาน</a></td>
    <td style="text-align:center;"><?php echo $A_Form3; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //แบบฟอร์มที่ 4
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"7","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"7","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"7");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"7");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","7");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","7");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
  <tr>
    <td style="text-align:center;">4.</td>
    <td><a href="?mod=budgetpay.follow.ot.ot_list">แบบฟอร์มขออนุมัติปฏิบัติงานล่วงเวลา</a></td>
    <td style="text-align:center;"><?php echo $A_Form4; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //แบบฟอร์มที่ 5
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"8","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"8","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"8");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"8");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","8");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","8");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
  <tr>
    <td style="text-align:center;">5.</td>
    <td><a href="?mod=budgetpay.follow.transfer.transfer_list">แบบฟอร์มขออนุมัติโอนเงินงบประมาณ</a></td>
    <td style="text-align:center;"><?php echo $A_Form5; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //แบบฟอร์มที่ 6
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"9","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"9","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"9");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"9");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","9");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","9");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
  <tr>
    <td style="text-align:center;">6.</td>
    <td><a href="?mod=budgetpay.follow.training.training_list">แบบฟอร์มขออนุมัติหลักการเข้ารับการอบรม/สัมมนา/ดูงาน/ปฏิบัติงาน/วิจัย/เดินทางไปต่างประเทศ</a></td>
    <td style="text-align:center;"><?php echo $A_Form6; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //แบบฟอร์มที่ 7
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"10,11","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"10,11","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"10,11");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"10,11");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","10,11");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","10,11");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
  <tr>
    <td style="text-align:center;">7.</td>
    <td><a href="?mod=budgetpay.follow.advances.advances_list">แบบฟอร์มขออนุมัติจัดประชุม/เดินทางปฏิบัติงาน และเบิกเงินยืมทดรอง</a></td>
    <td style="text-align:center;"><?php echo $A_Form7; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //แบบฟอร์มที่ 8
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"12,13","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"12,13","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"12,13");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"12,13");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","12,13");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","12,13");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
  <tr>
    <td style="text-align:center;">8.</td>
    <td><a href="?mod=budgetpay.follow.clear.clear_list">แบบฟอร์มขออนุมัติเคลียร์เงินยืมทดรองจัดประชุม/เดินทางปฏิบัติงาน</a></td>
    <td style="text-align:center;"><?php echo $A_Form8; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //แบบฟอร์มที่ 9
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"14,15","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"14,15","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"14,15");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"14,15");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","14,15");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","14,15");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
  <tr>
    <td style="text-align:center;">9.</td>
    <td>	<a href="?mod=budgetpay.follow.urgent.urgent_list">แบบฟอร์มเอกสารขออนุมัติจัดซื้อจัดจ้างและเบิกจ่าย(กรณีเร่งด่วน)</a></td>
    <td style="text-align:center;"><?php echo $A_Form9; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //แบบฟอร์มที่ 10
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"16,17","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"16,17","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"16,17");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"16,17");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","16,17");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","16,17");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
  <tr>
    <td style="text-align:center;">10.</td>
    <td><a href="?mod=budgetpay.follow.mat.mat_list">แบบฟอร์มขออนุมัติหลักการในการจัดซื้อ/จัดจ้างพัสดุ</a></td>
    <td style="text-align:center;"><?php echo $A_Form10; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //แบบฟอร์มที่ 11
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"18","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"18","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"18");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"18");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","18");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","18");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
  <tr>
    <td style="text-align:center;">11.</td>
    <td><a href="?mod=budgetpay.follow.general_pay.gpay_list">แบบฟอร์มขออนุมัติเบิกจ่ายหลักการทั่วไป/สัญญาจ้าง/ข้อตกลง</a></td>
    <td style="text-align:center;"><?php echo $A_Form11; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //แบบฟอร์มที่ 12
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"19","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"19","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"19");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"19");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","19");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","19");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
  <tr>
    <td style="text-align:center;">12.</td>
    <td><a href="?mod=budgetpay.follow.general_meeting.mpay_list">แบบฟอร์มขออนุมัติเบิกจ่ายค่าจัดประชุม/เดินทางไปปฏิบัติงาน</a></td>
    <td style="text-align:center;"><?php echo $A_Form12; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //แบบฟอร์มที่ 13
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"20","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"20","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"20");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"20");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","20");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","20");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
    <tr>
    <td style="text-align:center;">13.</td>
    <td><a href="#">แบบฟอร์มขออนุมัติเบิกจ่ายค่าวางบิลจัดประชุม/เดินทางปฏิบัติงาน (กรณียืมเงินทดรองจ่าย)</a></td>
    <td style="text-align:center;"><?php echo $A_Form13; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //แบบฟอร์มที่ 14
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"21","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"21","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"21");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"21");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","21");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","21");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
  <tr>
    <td style="text-align:center;">14.</td>
    <td><a href="#">แบบฟอร์มขออนุมัติเบิกจ่ายค่าปฏิบัติงานล่วงเวลา</a></td>
    <td style="text-align:center;"><?php echo $A_Form14; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //แบบฟอร์มที่ 15
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"22","N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"22","N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"22");
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"22");
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N","22");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y","22");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
  <tr>
    <td style="text-align:center;">15.</td>
    <td><a href="#">แบบฟอร์มขออนุมัติเบิกจ่ายค่าจัดซื้อจัดจ้างพัสดู (กรณีอ้างอิงหลักการจัดซื้อจัดจ้าง)</a></td>
    <td style="text-align:center;"><?php echo $A_Form15; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>
  <?php
  //ผลรวมของทุกแบบฟอร์ม
  $AllBook = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,0,"N");
  $Book = $get->getBooking($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,0,"N","N");
  $Hold = $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N");
  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y");
  $AllPay = $Chain+$PayWait+$Pay;
  ?>
    <tr style="font-weight:bold;">
    <td colspan="2" style="text-align:right;">รวมทั้งสิ้น</td>
    <td style="text-align:center;"><?php echo ($SumA_Form)?$SumA_Form:"-"; ?></td>
    <td class="number"><?php echo ($AllBook)?number_format($AllBook,2):"-"; ?></td>
    <td class="number"><?php echo ($Book)?number_format($Book,2):"-"; ?></td>
    <td class="number"><?php echo ($Hold)?number_format($Hold,2):"-"; $get->getHold($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"]); ?></td>
    <td class="number"><?php echo ($Chain)?number_format($Chain,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
  </tr>

</table>

<br />
<br />-->