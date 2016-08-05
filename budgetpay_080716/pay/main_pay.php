<?php 
$this->DOC->setStyles(array(
	'modules/backoffice/budgetpay/style_budgetpay.css'
));
include("helper.php");
$get = new sHelper();
$this->DOC->setPathWays(array(
	array(
		'text' => บันทึกตัดจ่ายงบประมาณ
	)
));

function icoEditA($BgtYear,$r){	
	$label = 'ตัดจ่ายงบ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".$r->FormPayPage."&BgtYear=".$BgtYear."&FormCode=".$r->FormCode."' ",
		'ico edit',
		$label,
		$label
	));
}

?>


<div class="sysinfo">
<div class="sysname">บันทึกตัดจ่ายงบประมาณ</div>
<div class="sysdetail">แสดงรายการแบบฟอร์มเอกสารการเงิน</div>
</div>


<script>
function loadSCT(BgtYear){
	var ExType 	= document.getElementById("ExType").value;
	if(ExType == "External"){
		var SourceExId = document.getElementById("SourceExId").value;
		window.location.href='?mod=budgetpay.pay.main_pay&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId+'#History';
	}else{
		window.location.href='?mod=budgetpay.pay.main_pay&BgtYear='+BgtYear+'&ExType='+ExType+'#History';
	}
}

function loadExternalType(ExType){
	var BgtYear 	= document.getElementById("BgtYear").value;
	window.location.href='?mod=budgetpay.pay.main_pay&BgtYear='+BgtYear+'&ExType='+ExType+'#History';
}

function loadPage(SourceExId){
	var BgtYear 	= document.getElementById("BgtYear").value;
	var ExType 	= document.getElementById("ExType").value;
	window.location.href='?mod=budgetpay.pay.main_pay&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId+'#History';
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
	var ExType = JQ('#ExType').val();
	var SourceExId = JQ('#SourceExId').val();
	window.location = '?mod=budgetpay.pay.export&format=raw&method=excel&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId;
}

function PrintPage(){
	var BgtYear = JQ('#BgtYear').val();
	var ExType = JQ('#ExType').val();	
	var SourceExId = JQ('#SourceExId').val();
	window.open('?mod=budgetpay.pay.export&format=raw&method=print&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId,null,'scrollbars=yes,height=700,width=920,toolbar=yes,menubar=yes,status=yes');
}

</script>



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

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-sumary">
  <tr>
    <th style="width:20px;">&nbsp;</th>
    <th style="width:100px;">รหัส</th>
    <th>แผนงาน/โครงการ/กิจกรรม</th>
    <th style="width:120px;">หน่วยงาน<br />เจ้าของ/ปฏิบัติงาน</th>
    <th style="width:80px;">งบประมาณ</th>
    <th style="width:80px;">งบรอตัดจ่าย</th>
    <th style="width:80px;">งบตัดจ่าย</th>
    <th style="width:80px;">งบรวมจ่ายจริง</th>
    <th style="width:80px;">งบคงเหลือ</th>
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
					$Plan =  $get->getSumPlanBudget($_REQUEST["BgtYear"],0,0,$PItemCode);
			  break;
			  case "External":
					$Plan =  $get->getSumPlanBudget_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"],0,0,$PItemCode);
			  break;
			  default :
					$Nation 	=  $get->getSumPlanBudget($_REQUEST["BgtYear"],0,0,$PItemCode);
					$Income =  $get->getSumPlanBudget_Inc($_REQUEST["BgtYear"],$_REQUEST["SourceExId"],0,0,$PItemCode);
					$Plan	= $Nation+$Income;
			  break;
		  }
		  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"N");
		  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"Y");
		  $AllPay = $Chain+$PayWait+$Pay;
		  $Remain = $Plan-$AllPay;*/
		  
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
			
			// (8) งบประมาณผูกพัน
			//$Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,$FormCode);

			// (9) งบรอตัดจ่าย
			$PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"N",$FormCode);

			// (10) งบตัดจ่าย
			$Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"Y",$FormCode);
		  
			// (11) งบรวมจ่ายจริง => 9+10
			$SumPay = $PayWait + $Pay;
			
			// งบคงเหลือ
			$Remain = $Plan-$SumPay;			  
		  
  ?>
  <tr class="tr-plan">
   <td>&nbsp;</td>
    <td><?php echo $PItemCode; ?></td>
    <td><?php echo $PItemName; ?></td>
    <td>&nbsp;</td>
    <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="งบรวมจ่ายจริง=งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($SumPay)?number_format($SumPay,2):"-"; ?></td>
    <td class="number"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
  </tr>
  
  
    <!--START วนลูปรายการโครงการ-->
	  <?php 
      $project = $get->getProjectItem($PItemCode); //ltxt::print_r($project);
      foreach($project as $r_project){
          foreach($r_project as $pr=>$ppr){
              ${$pr} = $ppr;
          }
/*		   switch($_REQUEST["ExType"]){
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
		  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"N");
		  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"Y");
		  $AllPay = $Chain+$PayWait+$Pay;
		  $Remain = $Plan-$AllPay;*/
		  
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
			
			// (8) งบประมาณผูกพัน
			//$Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,$FormCode);

			// (9) งบรอตัดจ่าย
			$PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"N",$FormCode);

			// (10) งบตัดจ่าย
			$Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"Y",$FormCode);
		  
			// (11) งบรวมจ่ายจริง => 9+10
			$SumPay = $PayWait + $Pay;
			
			// งบคงเหลือ
			$Remain = $Plan-$SumPay;		  
		  
      ?>
      <tr class="tr-project">
        <td style="text-align:center;"><a href="javascript:void(0)" onclick="showHide('<?php echo $PrjCode; ?>');" id="a<?php echo $PrjCode; ?>" class="icon-incre">&nbsp;</a></td>
        <td><?php echo $PrjCode; ?></td>
        <td><?php echo $PrjName; ?></td>
        <td style="text-align:center;"><?php echo $get->getOrgShortName($_REQUEST["BgtYear"], $OrganizeCode);?></td>
        <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
        <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
        <td class="number" title="งบรวมจ่ายจริง=งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($SumPay)?number_format($SumPay,2):"-"; ?></td>
        <td class="number"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
      </tr>
      
      
      <tbody id="t-<?php echo $PrjCode; ?>" style="display:none;">
      <!--START วนลูปรายการกิจกรรม-->
	  <?php 
      $act = $get->getActivityItem($PrjId);//ltxt::print_r($act);
      foreach($act as $r_act){
          foreach($r_act as $a=>$aa){
              ${$a} = $aa;
          }
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
		  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"N");
		  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"Y");
		  $AllPay = $Chain+$PayWait+$Pay;
		  $Remain = $Plan-$AllPay;*/
		  
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
			
			// (8) งบประมาณผูกพัน
			//$Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,$FormCode);

			// (9) งบรอตัดจ่าย
			$PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"N",$FormCode);

			// (10) งบตัดจ่าย
			$Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"Y",$FormCode);
		  
			// (11) งบรวมจ่ายจริง => 9+10
			$SumPay = $PayWait + $Pay;
			
			// งบคงเหลือ
			$Remain = $Plan-$SumPay;

      ?>
      <tr class="tr-act">
        <td>&nbsp;</td>
        <td><?php echo $PrjActCode; ?></td>
        <td><?php echo $PrjActName; ?></td>
        <td style="text-align:center;">(<?php echo $get->getOrgShortName($_REQUEST["BgtYear"], $OrganizeCode);?>)</td>
        <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
        <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
        <td class="number" title="งบรวมจ่ายจริง=งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($SumPay)?number_format($SumPay,2):"-"; ?></td>
        <td class="number"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
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
	$PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N");
	$Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y");
	$AllPay = $Chain+$PayWait+$Pay;
	$Remain = $Plan-$AllPay;*/
	
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
			
			// (8) งบประมาณผูกพัน
			//$Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,$FormCode);

			// (9) งบรอตัดจ่าย
			$PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N",$FormCode);

			// (10) งบตัดจ่าย
			$Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y",$FormCode);
		  
			// (11) งบรวมจ่ายจริง => 9+10
			$SumPay =$PayWait + $Pay;
			
			// งบคงเหลือ
			$Remain = $Plan-$SumPay;			  	
	
  ?>
   <tr class="tr-sum">
        <td colspan="4">รวมงบประมาณทั้งสิ้น</td>
        <td class="number tr-sum"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
        <td class="number tr-sum" title="งบรวมจ่ายจริง=งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($SumPay)?number_format($SumPay,2):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
      </tr>
  <?php }else{ //else if($plan) ?>
     <tr>
        <td colspan="9" style="text-align:center; color:#990000; background-color:#EEE;">ไม่มีรายการข้อมูล</td>
     </tr>
 <?php } //end if($plan) ?>
</table>

<?php
//จำนวนเอกสารทั้งหมด
$A_Form2		= 	$get->getAmountDoc("tblintra_eform_formal_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form8		= 	$get->getAmountDoc("tblintra_eform_advance_clear",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form9		= 	$get->getAmountDoc("tblintra_eform_mat_urgent",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form11		= 	$get->getAmountDoc("tblintra_eform_formal_general_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form12		= 	$get->getAmountDoc("tblintra_eform_formal_meeting_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form13		= 	$get->getAmountDoc("tblintra_eform_advance_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form14		= 	$get->getAmountDoc("tblintra_eform_formal_ot_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$A_Form15		= 	$get->getAmountDoc("tblintra_eform_formal_mat_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
$SumA_Form	= $A_Form2+$A_Form8+$A_Form9+$A_Form11+$A_Form12+$A_Form13+$A_Form14+$A_Form15;

//จำนวนเอกสารรอตัดจ่ายงบประมาณ
$AW_Form2		= 	$get->getAmountDoc("tblintra_eform_formal_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"],"7");
$AW_Form8		= 	$get->getAmountDoc("tblintra_eform_advance_clear",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"],"7");
$AW_Form9		= 	$get->getAmountDoc("tblintra_eform_mat_urgent",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"],"7");
$AW_Form11		= 	$get->getAmountDoc("tblintra_eform_formal_general_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"],"7");
$AW_Form12		= 	$get->getAmountDoc("tblintra_eform_formal_meeting_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"],"7");
$AW_Form13		= 	$get->getAmountDoc("tblintra_eform_advance_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"],"7");
$AW_Form14		= 	$get->getAmountDoc("tblintra_eform_formal_ot_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"],"7");
$AW_Form15		= 	$get->getAmountDoc("tblintra_eform_formal_mat_pay",$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"],"7");
$SumAW_Form	= $AW_Form2+$AW_Form8+$AW_Form9+$AW_Form11+$AW_Form12+$AW_Form13+$AW_Form14+$AW_Form15;

?>


<div class="topic-break">แบบฟอร์มตัดจ่ายงบประมาณ ประจำปี <?php echo ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543); ?></div>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
  <tr>
    <th style="width:10%;">รหัสแบบฟอร์ม</th>
    <th style="width:60%;">ชื่อแบบฟอร์ม</th>
    <th style="width:10%;">ทั้งหมด</th>
    <th style="width:10%;">รอตัดจ่าย</th>
    <th style="width:10%;">ปฏิบัติการ</th>
  </tr>

  <tr><td colspan="5" class="boxheadtab" style="padding-left:22px">แบบฟอร์มเอกสารงานการเงิน</td></tr>  
  <?php
  $formListFF = $get->getFromList("'FF004','FF007','FF009','FF010','FF012'");
  foreach($formListFF as $FF ) {
	  
	//  function getAmountDoc($tablename,$BgtYear=0,$DocStatusId=0,$SourceType="",$SourceExId=0,$FormCode=0){
	  
	//จำนวนเอกสารทั้งหมด
	$FF_Form = $get->getAmountDoc($FF->FormTable,$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"],$FF->FormCode);

	//จำนวนเอกสารรอตัดจ่าย
	$FFW_Form = $get->getAmountDoc($FF->FormTable,$_REQUEST["BgtYear"],"7",$_REQUEST["ExType"],$_REQUEST["SourceExId"],$FF->FormCode);

  ?>
  <tr>
    <td style="text-align:center;"><?php echo $FF->FormCode;?></td>
    <td><?php echo $FF->FormName;?></td>
    <td style="text-align:center;"><?php echo $FF_Form;?></td>
    <td style="text-align:center;"><?php echo $FFW_Form;?></td>
    <td style="text-align:center;"><?php echo icoEditA(($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543),$FF); ?></td>
  </tr>
 <?php
   }
 ?>

  <tr><td colspan="5" class="boxheadtab" style="padding-left:22px">แบบฟอร์มเอกสารงานข้อตกลง</td></tr> 
  <?php
  $formListFC = $get->getFromList("'FC002'");
  foreach($formListFC as $FC ) {
	  
	//จำนวนเอกสารทั้งหมด
	$FC_Form = $get->getAmountDoc($FC->FormTable,$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"],$FC->FormCode);

	//จำนวนเอกสารรอตัดจ่าย
	$FCW_Form = $get->getAmountDoc($FC->FormTable,$_REQUEST["BgtYear"],"7",$_REQUEST["ExType"],$_REQUEST["SourceExId"],$FC->FormCode);
   
  ?>
  <tr>
    <td style="text-align:center;"><?php echo $FC->FormCode;?></td>
    <td><?php echo $FC->FormName;?></td>
    <td style="text-align:center;"><?php echo $FC_Form;?></td>
    <td style="text-align:center;"><?php echo $FCW_Form;?></td>
    <td style="text-align:center;"><?php echo icoEditA(($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543),$FC); ?></td>
  </tr>
 <?php
   }
 ?>  

  <tr><td colspan="5" class="boxheadtab" style="padding-left:22px">แบบฟอร์มเอกสารงานพัสดุ</td></tr>  
  <?php
  $formListFP = $get->getFromList("'FP003','FP004','FP005'");
  foreach($formListFP as $FP ) {

	//จำนวนเอกสารทั้งหมด
	$FP_Form = $get->getAmountDoc($FP->FormTable,$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"],$FP->FormCode);

	//จำนวนเอกสารรอตัดจ่าย
	$FPW_Form = $get->getAmountDoc($FP->FormTable,$_REQUEST["BgtYear"],"7",$_REQUEST["ExType"],$_REQUEST["SourceExId"],$FP->FormCode);
  
  ?>
  <tr>
    <td style="text-align:center;"><?php echo $FP->FormCode;?></td>
    <td><?php echo $FP->FormName;?></td>
    <td style="text-align:center;"><?php echo $FP_Form;?></td>
    <td style="text-align:center;"><?php echo $FPW_Form;?></td>
    <td style="text-align:center;"><?php echo icoEditA(($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543),$FP); ?></td>
  </tr>
 <?php
   }
 ?>  

  <tr><td colspan="5" class="boxheadtab" style="padding-left:22px">แบบฟอร์มเอกสารงานบุคลากร (HR)</td></tr> 
  <?php
  $formListFH = $get->getFromList("'FH001','FH002','FH004','FH006'");
  foreach($formListFH as $FH ) {
	  
	//จำนวนเอกสารทั้งหมด
	$FH_Form = $get->getAmountDoc($FH->FormTable,$_REQUEST["BgtYear"],0,$_REQUEST["ExType"],$_REQUEST["SourceExId"],$FH->FormCode);

	//จำนวนเอกสารรอตัดจ่าย
	$FHW_Form = $get->getAmountDoc($FH->FormTable,$_REQUEST["BgtYear"],"7",$_REQUEST["ExType"],$_REQUEST["SourceExId"],$FH->FormCode);
  
  ?>
  <tr>
    <td style="text-align:center;"><?php echo $FH->FormCode;?></td>
    <td><?php echo $FH->FormName;?></td>
    <td style="text-align:center;"><?php echo $FH_Form;?></td>
    <td style="text-align:center;"><?php echo $FHW_Form;?></td>
    <td style="text-align:center;"><?php echo icoEditA(($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543),$FH); ?></td>
  </tr>
 <?php
   }
 ?>  

</table>




