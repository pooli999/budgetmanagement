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

function icoEditF1($BgtYear){
	$label = 'ตัดจ่ายงบ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=budgetpay.pay.pay.pay_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}



function icoEditF2($BgtYear){
	$label = 'ตัดจ่ายงบ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=budgetpay.pay.clear.clear_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}

function icoEditF3($BgtYear){
	$label = 'ตัดจ่ายงบ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=budgetpay.pay.urgent.urgent_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}

function icoEditF4($BgtYear){
	$label = 'ตัดจ่ายงบ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=budgetpay.pay.general_pay.gpay_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}

function icoEditF5($BgtYear){
	$label = 'ตัดจ่ายงบ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=budgetpay.pay.meeting_pay.mpay_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}


function icoEditF6($BgtYear){
	$label = 'ตัดจ่ายงบ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=budgetpay.pay.advances_pay.apay_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}

function icoEditF7($BgtYear){
	$label = 'ตัดจ่ายงบ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=budgetpay.pay.ot_pay.otpay_list&BgtYear=".$BgtYear."'",
		'ico edit',
		$label,
		$label
	));
}

function icoEditF8($BgtYear){
	$label = 'ตัดจ่ายงบ';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=budgetpay.pay.mat_pay.matpay_list&BgtYear=".$BgtYear."'",
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

</script>



<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#eeebac;">
  <tr>
    <td style="padding:5px;">
    <a href="javascript:void(0)" class="ico print">พิมพ์เอกสาร</a>
    <a href="javascript:void(0)" class="ico excel">ส่งออกเป็น Excel</a>
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
    <th style="width:80px;">รวมตัดจ่าย</th>
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
		  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"N");
		  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"Y");
		  $AllPay = $Chain+$PayWait+$Pay;
		  $Remain = $Plan-$AllPay;
  ?>
  <tr class="tr-plan">
    <td>&nbsp;</td>
    <td><?php echo $PItemCode; ?></td>
    <td><?php echo $PItemName; ?></td>
    <td>&nbsp;</td>
    <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
    <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
    <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
    <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
    <td class="number"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
  </tr>
  
  
    <!--START วนลูปรายการโครงการ-->
	  <?php 
      $project = $get->getProjectItem($PItemCode); //ltxt::print_r($project);
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
		  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"N");
		  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"Y");
		  $AllPay = $Chain+$PayWait+$Pay;
		  $Remain = $Plan-$AllPay;
      ?>
      <tr class="tr-project">
        <td style="text-align:center;"><a href="javascript:void(0)" onclick="showHide('<?php echo $PrjCode; ?>');" id="a<?php echo $PrjCode; ?>" class="icon-incre">&nbsp;</a></td>
        <td><?php echo $PrjCode; ?></td>
        <td><?php echo $PrjName; ?></td>
        <td style="text-align:center;"><?php echo $get->getOrgShortName($_REQUEST["BgtYear"], $OrganizeCode);?></td>
        <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
        <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
        <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
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
		  $PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"N");
		  $Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"Y");
		  $AllPay = $Chain+$PayWait+$Pay;
		  $Remain = $Plan-$AllPay;
      ?>
      <tr class="tr-act" style="vertical-align:top;">
        <td>&nbsp;</td>
        <td><?php echo $PrjActCode; ?></td>
        <td><?php echo $PrjActName; ?></td>
        <td style="text-align:center;">(<?php echo $get->getOrgShortName($_REQUEST["BgtYear"], $OrganizeCode);?>)</td>
        <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="number"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
        <td class="number"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
        <td class="number" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
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
	$PayWait = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N");
	$Pay = $get->getPay($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y");
	$AllPay = $Chain+$PayWait+$Pay;
	$Remain = $Plan-$AllPay;
  ?>
   <tr class="tr-sum">
        <td colspan="4">รวมงบประมาณทั้งสิ้น</td>
        <td class="number tr-sum"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($PayWait)?number_format($PayWait,2):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($Pay)?number_format($Pay,2):"-"; ?></td>
        <td class="number tr-sum" title="รวมตัดจ่าย=งบผูกพัน+งบรอตัดจ่าย+งบตัดจ่าย"><?php echo ($AllPay)?number_format($AllPay,2):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
      </tr>
  <?php }else{ //else if($plan) ?>
     <tr>
        <td colspan="8" style="text-align:center; color:#990000; background-color:#EEE;">ไม่มีรายการข้อมูล</td>
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
    <th style="width:50px;">Form</th>
    <th>ชื่อแบบฟอร์ม</th>
    <th style="width:80px;">จำนวน</th>
    <th style="width:80px;">รอตัดจ่าย</th>
    <th style="width:75px;">ปฏิบัติการ</th>
  </tr>
  
  <tr>
    <td style="text-align:center;">&nbsp;</td>
    <td>แบบฟอร์มขออนุมัติเบิกจ่ายหลักการทั่วไป</td>
    <td style="text-align:center;"><?php echo $A_Form11; ?></td>
    <td style="text-align:center;"><?php echo $AW_Form11; ?></td>
    <td><?php echo icoEditF4(($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543)); ?></td>
  </tr>  
  
  <tr>
    <td style="text-align:center;">&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align:center;">&nbsp;</td>
    <td style="text-align:center;">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>

  
  <tr>
    <td style="text-align:center;">&nbsp;</td>
    <td>แบบฟอร์มขออนุมัติเบิกจ่าย</td>
    <td style="text-align:center;"><?php echo $A_Form2; ?></td>
    <td style="text-align:center;"><?php echo $AW_Form2; ?></td>
    <td><?php echo icoEditF1(($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543)); ?></td>
  </tr>
  <tr>
    <td style="text-align:center;">&nbsp;</td>
    <td>	แบบฟอร์มเอกสารขออนุมัติจัดซื้อจัดจ้างและเบิกจ่าย(กรณีเร่งด่วน)</td>
    <td style="text-align:center;"><?php echo $A_Form9; ?></td>
    <td style="text-align:center;"><?php echo $AW_Form9; ?></td>
    <td><?php echo icoEditF3(($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543)); ?></td>
  </tr>
  <tr>
    <td style="text-align:center;">&nbsp;</td>
    <td>แบบฟอร์มขออนุมัติเบิกจ่ายหลักการทั่วไป/สัญญาจ้าง/ข้อตกลง</td>
    <td style="text-align:center;"><?php echo $A_Form11; ?></td>
    <td style="text-align:center;"><?php echo $AW_Form11; ?></td>
    <td><?php echo icoEditF4(($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543)); ?></td>
  </tr>
  <tr>
    <td style="text-align:center;">&nbsp;</td>
    <td>แบบฟอร์มขออนุมัติเบิกจ่ายค่าจัดประชุม/เดินทางไปปฏิบัติงาน</td>
    <td style="text-align:center;"><?php echo $A_Form12; ?></td>
    <td style="text-align:center;"><?php echo $AW_Form12; ?></td>
    <td><?php echo icoEditF5(($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543)); ?></td>
  </tr>
  <tr>
    <td style="text-align:center;">&nbsp;</td>
    <td>แบบฟอร์มขออนุมัติเคลียร์เงินยืมทดรองจัดประชุม/เดินทางปฏิบัติงาน</td>
    <td style="text-align:center;"><?php echo $A_Form8; ?></td>
    <td style="text-align:center;"><?php echo $AW_Form8; ?></td>
    <td><?php echo icoEditF2(($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543)); ?></td>
  </tr>
  <tr>
    <td style="text-align:center;">&nbsp;</td>
    <td>แบบฟอร์มขออนุมัติเบิกจ่ายค่าวางบิลจัดประชุม/เดินทางปฏิบัติงาน (กรณียืมเงินทดรองจ่าย)</td>
    <td style="text-align:center;"><?php echo $A_Form13; ?></td>
    <td style="text-align:center;"><?php echo $AW_Form13; ?></td>
    <td><?php echo icoEditF6(($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543)); ?></td>
  </tr>
  <tr>
    <td style="text-align:center;">&nbsp;</td>
    <td>แบบฟอร์มขออนุมัติเบิกจ่ายค่าปฏิบัติงานล่วงเวลา</td>
    <td style="text-align:center;"><?php echo $A_Form14; ?></td>
    <td style="text-align:center;"><?php echo $AW_Form14; ?></td>
    <td><?php echo icoEditF7(($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543)); ?></td>
  </tr>
  <tr>
    <td style="text-align:center;">&nbsp;</td>
    <td>แบบฟอร์มขออนุมัติเบิกจ่ายค่าจัดซื้อจัดจ้างพัสดู (กรณีอ้างอิงหลักการจัดซื้อจัดจ้าง)</td>
    <td style="text-align:center;"><?php echo $A_Form15; ?></td>
    <td style="text-align:center;"><?php echo $AW_Form15; ?></td>
    <td><?php echo icoEditF8(($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543)); ?></td>
  </tr>
   <tr style="font-weight:bold;">
    <td colspan="2" style="text-align:right;">รวมทั้งสิ้น</td>
    <td style="text-align:center;"><?php echo ($SumA_Form)?$SumA_Form:"-"; ?></td>
    <td style="text-align:center;"><?php echo ($SumAW_Form)?$SumAW_Form:"-"; ?></td>
    <td>รายการ</td>
  </tr>
</table>




<br />
<br />