<?php 
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));
include("helper.php");
$get = new sHelper();
$this->DOC->setPathWays(array(
	array(
		'text' => ติดตามการใช้จ่ายงบประมาณ
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
		window.location.href='?mod=budget.follow.main_follow&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId+'#History';
	}else{
		window.location.href='?mod=budget.follow.main_follow&BgtYear='+BgtYear+'&ExType='+ExType+'#History';
	}
}

function loadExternalType(ExType){
	var BgtYear 	= document.getElementById("BgtYear").value;
	window.location.href='?mod=budget.follow.main_follow&BgtYear='+BgtYear+'&ExType='+ExType+'#History';
}

function loadPage(SourceExId){
	var BgtYear 	= document.getElementById("BgtYear").value;
	var ExType 	= document.getElementById("ExType").value;
	window.location.href='?mod=budget.follow.main_follow&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId+'#History';
}

function saveToExcel(){
	var BgtYear = $('BgtYear').value;
	var ExType = $('ExType').value;
	if(ExType=='External'){
		var SourceExId = $('SourceExId').value;
	}else{
		var SourceExId = 0;
	}
	window.location.href="?mod=<?php echo LURL::dotPage('main_follow_excel')?>&format=raw&BgtYear="+BgtYear+"&ExType="+ExType+"&SourceExId="+SourceExId;
}
</script>


<div class="sysinfo">
<div class="sysname">ติดตามการใช้จ่ายงบประมาณ</div>
<div class="sysdetail">แสดงข้อมูลแผนและผลการใช้จ่ายงบประมาณประจำปี</div>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#eeebac;">
  <tr>
    <td style="padding:5px;">
    <a href="javascript:void(0)" class="ico print">พิมพ์เอกสาร</a>
    <a href="javascript:void(0)"  onclick="javascript:saveToExcel();" class="ico excel">ส่งออกเป็น Excel</a>
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


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-sumary">
  <tr>
    <th style="width:20px;">&nbsp;</th>
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
		  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode);
		  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"N");
		  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"Y");
		  $AllPay = $Chain+$PayWait+$Pay;
		  $Remain = $Plan-$AllPay;
		  $perAllPay = ($AllPay)?(($AllPay*100)/$Plan):0;
		  $perRemain = ($Remain)?(($Remain*100)/$Plan):0;
  ?>
  <tr class="tr-plan" style="vertical-align:top;">
    <td>&nbsp;</td>
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
		  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode);
		  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"N");
		  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"Y");
		  $AllPay = $Chain+$PayWait+$Pay;
		  $Remain = $Plan-$AllPay;
		  $perAllPay = ($AllPay)?(($AllPay*100)/$Plan):0;
		  $perRemain = ($Remain)?(($Remain*100)/$Plan):0;
      ?>
     
      <tr class="tr-project" style="vertical-align:top;">
        <td style="text-align:center;"><a href="javascript:void(0)" onclick="showHide('<?php echo $PrjCode; ?>');" id="a<?php echo $PrjCode; ?>" class="icon-incre">&nbsp;</a></td>
        <td><?php echo $PrjCode; ?></td>
        <td><?php echo $PrjName; ?></td>
        <td style="text-align:center;"><?php echo $get->getOrgShortName($_REQUEST["BgtYear"], $OrganizeCode);?></td>
         <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
         <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
        <td class="number"><?php echo ($perAllPay)?(number_format($perAllPay,2)."%"):"-"; ?></td>
        <td class="number"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
        <td class="number"><?php echo ($perRemain)?(number_format($perRemain,2)."%"):"-"; ?></td>
      </tr>
      
      
       <tbody id="t-<?php echo $PrjCode; ?>" style="display:none;">
      <!--START วนลูปรายการกิจกรรม-->
	  <?php 
      $act = $get->getActivityItem($PrjId);//ltxt::print_r($act);
      foreach($act as $r_act){
          foreach($r_act as $a=>$aa){
              ${$a} = $aa;
          }
		  switch($_REQUEST["ExType"]){
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
		  $Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode);
		  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"N");
		  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"Y");
		  $AllPay = $Chain+$PayWait+$Pay;
		  $Remain = $Plan-$AllPay;
		  $perAllPay = ($AllPay)?(($AllPay*100)/$Plan):0;
		  $perRemain = ($Remain)?(($Remain*100)/$Plan):0;
      ?>
      <tr class="tr-act" style="vertical-align:top;">
        <td>&nbsp;</td>
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
	$Chain = $get->getChain($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"]);
	$PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N");
	$Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y");
	$AllPay = $Chain+$PayWait+$Pay;
	$Remain = $Plan-$AllPay;
	$perAllPay = ($AllPay)?(($AllPay*100)/$Plan):0;
	$perRemain = ($Remain)?(($Remain*100)/$Plan):0;
  ?>
   <tr class="tr-sum">
        <td colspan="4">รวมงบประมาณทั้งสิ้น</td>
        <td class="number tr-sum"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="number tr-sum" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><span class="number"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></span></td>
        <td class="number tr-sum"><?php echo ($perAllPay)?(number_format($perAllPay,2)."%"):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($perRemain)?(number_format($perRemain,2)."%"):"-"; ?></td>
      </tr>
<?php }else{ //else if($plan) ?>
     <tr>
        <td colspan="9" style="text-align:center; color:#990000; background-color:#EEE;">ไม่มีรายการข้อมูล</td>
     </tr>
<?php } //end if($plan) ?>
</table>






<br />
<br />