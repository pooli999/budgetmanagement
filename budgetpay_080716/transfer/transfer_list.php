<?php 
$ReportSheet = 'transfer_word' ;
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => บันทึกโอนงบประมาณประจำปี,
		'link' => '?mod=finance.approve.main_approve'
	),
	array(
		'text' => 'แบบฟอร์มเอกสารขออนุมัติโอนเงินงบประมาณ',
	)
));


function icoEdit($r){
	$label = 'โอนงบ';
	global $appPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($appPage)."&id=".$r->DocCode."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoView($r){
	$label = $r->Topic;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&id=".$r->DocCode."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

function icoCancel($r){
	$label = 'ยกเลิก';
	global $cancelPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($cancelPage)."&DocCode=".$r->DocCode."&start=".$_REQUEST["start"]."'",
		'ico cancel',
		$label,
		$label
	));
}






?>


<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	
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
	
	function Search(){
		var tsearch=JQ('#tsearch').val();
		window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&tsearch="+ tsearch;
	}

/* ]]> */
	function loadSCT(BgtYear){
		var ExType 	= document.getElementById("ExType").value;
		if(ExType == "External"){
			var SourceExId = document.getElementById("SourceExId").value;
			window.location.href='?mod=<?php echo LURL::dotPage($listPage)?>&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId+'#History';
		}else{
			window.location.href='?mod=<?php echo LURL::dotPage($listPage)?>&BgtYear='+BgtYear+'&ExType='+ExType+'#History';
		}
	}

	function loadExternalType(ExType){
		var BgtYear 	= document.getElementById("BgtYear").value;
		window.location.href='?mod=<?php echo LURL::dotPage($listPage)?>&BgtYear='+BgtYear+'&ExType='+ExType+'#History';
	}

	function loadPage(SourceExId){
		var BgtYear 	= document.getElementById("BgtYear").value;
		var ExType 	= document.getElementById("ExType").value;
		window.location.href='?mod=<?php echo LURL::dotPage($listPage)?>&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId+'#History';
	}

	function ExportToExcel(){
		var BgtYear = JQ('#BgtYear').val();
		var ExType = JQ('#ExType').val();
		var SourceExId = JQ('#SourceExId').val();
		window.location = '?mod=budgetpay.transfer.export&format=raw&method=excel&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId;
	}
	
	function PrintPage(){
		var BgtYear = JQ('#BgtYear').val();
		var ExType = JQ('#ExType').val();	
		var SourceExId = JQ('#SourceExId').val();
		window.open('?mod=budgetpay.transfer.export&format=raw&method=print&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId,null,'scrollbars=yes,height=700,width=920,toolbar=yes,menubar=yes,status=yes');
	}

</script>
<script type="text/javascript" language="javascript" id="js">
/* <![CDATA[ */
JQ(document).ready(function() {
	
	JQ("table").tablesorter({
		headers: {
			0: {sorter: false},
			6: {sorter: false}
		}
	});
	
});
/* ]]> */
</script>



<div class="sysinfo">
<div class="sysname"><?php echo $MenuName;?></div>
<div class="sysdetail">แสดงรายการ<?php echo $MenuName;?></div>
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
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-sumary">
  <tr>
   <th style="width:20px;">&nbsp;</th>
    <th style="width:100px;">รหัส</th>
    <th>แผนงาน/โครงการ/กิจกรรม</th>
    <th style="width:120px;">หน่วยงาน<br />เจ้าของ/ปฏิบัติงาน</th>
    <th style="width:80px;">งบประมาณ</th>
    <th style="width:80px;">งบรอโอนออก</th>
    <th style="width:80px;">งบโอนออก</th>
    <th style="width:80px;">งบรับโอน</th>
    <th style="width:80px;" title="งบคงเหลือ=งบประมาณ-งบโอนออก+งบรับโอน">งบคงเหลือ</th>
  </tr>
  <!--START วนลูปรายการแผนงาน สช.-->
  <?php 
  $plan = $get->getPlanItem($_REQUEST["BgtYear"]);//ltxt::print_r($plan);
  if($plan){
		  foreach($plan as $r_plan){
			  foreach($r_plan as $p=>$pp){
				  ${$p} = $pp;
			  }
/*			   switch($_REQUEST["ExType"]){
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
			  $TferOutWait = $get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"N");			  
			  $TferIn = $get->getTferIn($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"Y");
			  $TferOut=$get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,0,0,0,0,"Y");
			  $Remain = $Plan+$TferIn-$TferOut;*/
	
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
  <tr class="tr-plan">
    <td>&nbsp;</td>
    <td><?php echo $PItemCode; ?></td>
    <td><?php echo $PItemName; ?></td>
    <td>&nbsp;</td>
    <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
    <td class="number"><?php echo ($TferOutWait)?number_format($TferOutWait,2):"-"; ?></td>
    <td class="number"><?php echo ($TferOut)?number_format($TferOut,2):"-"; ?></td>
    <td class="number"><?php echo ($TferIn)?number_format($TferIn,2):"-"; ?></td>
    <td class="number" title="งบคงเหลือ=งบประมาณ-งบโอนออก+งบรับโอน"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
  </tr>
  
  
    <!--START วนลูปรายการโครงการ-->
	  <?php 
      $project = $get->getProjectItem($PItemCode);//ltxt::print_r($project);
      foreach($project as $r_project){
          foreach($r_project as $pr=>$ppr){
              ${$pr} = $ppr;
          }
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
		  $TferOutWait=$get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"N");
		  $TferIn = $get->getTferIn($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"Y");
		  $TferOut=$get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,0,0,0,"Y");
		  $Remain = $Plan+$TferIn-$TferOut;*/
		  
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
      <tr class="tr-project">
        <td style="text-align:center;"><a href="javascript:void(0)" onclick="showHide('<?php echo $PrjCode; ?>');" id="a<?php echo $PrjCode; ?>" class="icon-incre">&nbsp;</a></td>      
        <td><?php echo $PrjCode; ?></td>
        <td><?php echo $PrjName; ?></td>
        <td style="text-align:center;"><?php echo $get->getOrgShortName($_REQUEST["BgtYear"], $OrganizeCode);?></td>
        <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="number"><?php echo ($TferOutWait)?number_format($TferOutWait,2):"-"; ?></td>
        <td class="number"><?php echo ($TferOut)?number_format($TferOut,2):"-"; ?></td>
        <td class="number"><?php echo ($TferIn)?number_format($TferIn,2):"-"; ?></td>
        <td class="number" title="งบคงเหลือ=งบประมาณ-งบโอนออก+งบรับโอน"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
      </tr>
      
      
      <tbody id="t-<?php echo $PrjCode; ?>" style="display:none;">
      <!--START วนลูปรายการกิจกรรม-->
	  <?php 
      $act = $get->getActivityItem($PrjId);//ltxt::print_r($act);
      foreach($act as $r_act){
          foreach($r_act as $a=>$aa){
              ${$a} = $aa;
          }
/*		   switch($_REQUEST["ExType"]){
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
		  $TferOutWait=$get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"N");
		  $TferIn = $get->getTferIn($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"Y");
		  $TferOut=$get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,$PItemCode,$PrjCode,$PrjActCode,0,0,"Y");
		  $Remain = $Plan+$TferIn-$TferOut;*/
		  
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
      <tr class="tr-act">
        <td>&nbsp;</td>
        <td><?php echo $PrjActCode; ?></td>
        <td><?php echo $PrjActName; ?></td>
        <td style="text-align:center;">(<?php echo $get->getOrgShortName($_REQUEST["BgtYear"], $OrganizeCode);?>)</td>
        <td class="number"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="number"><?php echo ($TferOutWait)?number_format($TferOutWait,2):"-"; ?></td>
        <td class="number"><?php echo ($TferOut)?number_format($TferOut,2):"-"; ?></td>
        <td class="number"><?php echo ($TferIn)?number_format($TferIn,2):"-"; ?></td>
        <td class="number" title="งบคงเหลือ=งบประมาณ-งบโอนออก+งบรับโอน"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
      </tr>
      <?php } ?>
      <!--END วนลูปรายการกิจกรรม-->
      
      </tbody>
      <?php } ?>
      <!--END วนลูปรายการโครงการ-->

  
  
  
  <?php } ?>
  <!--END วนลูปรายการแผนงาน สช.-->
    <?php
/*	  switch($_REQUEST["ExType"]){
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
	$TferOutWait=$get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"N");
	$TferIn = $get->getTferIn($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y");
	$TferOut=$get->getTferOut($_REQUEST["BgtYear"],$_REQUEST["ExType"],$_REQUEST["SourceExId"],0,0,0,0,0,0,0,"Y");
	$Remain = $Plan+$TferIn-$TferOut;*/
	
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
  <tr class="tr-sum">
        <td colspan="4">รวมงบประมาณทั้งสิ้น</td>
        <td class="number tr-sum"><?php echo ($Plan)?number_format($Plan,2):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($TferOutWait)?number_format($TferOutWait,2):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($TferOut)?number_format($TferOut,2):"-"; ?></td>
        <td class="number tr-sum"><?php echo ($TferIn)?number_format($TferIn,2):"-"; ?></td>
        <td class="number tr-sum" title="งบคงเหลือ=งบประมาณ-งบโอนออก+งบรับโอน"><?php echo ($Remain)?number_format($Remain,2):"-"; ?></td>
      </tr>
 <?php }else{ //else if($plan) ?>
     <tr>
        <td colspan="8" style="text-align:center; color:#990000; background-color:#EEE;">ไม่มีรายการข้อมูล</td>
     </tr>
 <?php } //end if($plan) ?>
</table>










<div class="topic-break">FB001 แบบฟอร์มขออนุมัติโอนเงินงบประมาณ ประจำปี <?php echo ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543); ?></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list tablesorter" style="margin-top:0px;">
<thead>  
  <tr>
    <th style="text-align:center; width:40px">ลำดับ</th>
    <th style="text-align:center; width:100px">วันที่เอกสาร</th>	
    <th style="text-align:center; width:100px">เลขที่ สช.น</th>
    <th style="text-align:center;">ชื่อเรื่อง</th>
    <th style="text-align:center; width:130px">งบประมาณ (บาท)</th>
    <th style="text-align:center; width:95px">สถานะเอกสาร</th>
    <th colspan="2" style="text-align:center;">ปฏิบัติการ</th>
    </tr>
</thead>
<tbody>  
<?php
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	//ltxt::print_r($list);
	if($list['total'] > 0){
          foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?> 
  <tr>
    <td style="text-align:center; vertical-align:text-top"><?php echo $i; ?></td>
    <td style="text-align:center; vertical-align:text-top"><?php echo ShowDate($DocDate); ?></td>	
    <td style="text-align:left; vertical-align:text-top"><?php echo $DocCode;?></td>
    <td style="text-align:left; vertical-align:text-top"><?php echo icoView($r);?></td>
    <td style="text-align:right; vertical-align:text-top"><?php echo number_format($get->getSumBudget($DocCode,0,0),2); ?></td>
    <td style="text-align:left; vertical-align:text-top" nowrap="nowrap"><div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div></td>
    <td style="text-align:left; vertical-align:text-top; width:60px;"><?php if(in_array($DocStatusId,array(7))){ echo icoEdit($r); } ?></td>
    <td style="text-align:left; vertical-align:text-top; width:65px;"><?php if(in_array($DocStatusId,array(12))){ echo icoCancel($r); } ?></td>
    </tr>
  
<?php

		$i++;
		}
	}else{
?>  
 <tr>
 <td colspan="9"><div class="nullDataList" style="color:#990000;">ไม่มีข้อมูล</div></td>
 </tr> 
<?php } ?> 
</tbody> 
</table>

<?php if($list['total'] > 0){ ?>
<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>
<?php } ?>