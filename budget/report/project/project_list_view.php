<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));

function icoView($r){
	$label = $r->PrjName;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

?>
<style>
.parentrow{
	background-color:#eee;
}
</style>
<script>
function getfilterorg(){
	var BgtYear = $('BgtYear').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage("project_list_view");?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode+'&SCTypeId=<?php echo $_REQUEST["SCTypeId"]; ?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"]; ?>';
}

function loadSCT(BgtYear){
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage("project_list_view");?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode+'&SCTypeId=<?php echo $_REQUEST["SCTypeId"]; ?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"]; ?>';
}

function printDocument(PrjDetailId){
	window.location.href="?mod=<?php echo LURL::dotPage('project_view_print')?>&format=raw&PrjDetailId="+PrjDetailId;
}

function saveToWord(PrjDetailId){
	window.location.href="?mod=<?php echo LURL::dotPage('project_view_word')?>&format=raw&PrjDetailId="+PrjDetailId;
}

function saveToExcel(PrjDetailId){
	window.location.href="?mod=<?php echo LURL::dotPage('project_view_excel')?>&format=raw&PrjDetailId="+PrjDetailId;
}

</script>


<table width="100%" cellpadding="0" cellspacing="0" class="page-title-user">
 	<tr>
    	<td class="div-title-plan">&nbsp;</td>
        <td>
       <div class="font1">จัดทำแผนปฏิบัติงานประจำปี</div>
        </td>
    </tr>
 </table>


<div class="sysinfo">
  <div class="sysname" style="font-size:16px;"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>
</div>

<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td >
      <b>ปีงบประมาณ : </b><?php echo $get->getYearProject(ltxt::getVar('BgtYear'),'BgtYear');?>
      <b>หน่วยงาน : </b><span id="org-list"><?php echo $get->getOrganizeCode($_REQUEST["OrganizeCode"],ltxt::getVar('OrganizeCode'));?></span>
     </td>  
     <td align="right">
       <input type="button" name="button" id="button" value="  ย้อนกลับ  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" />
     </td>
    </tr>
  </table>
</div>


<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list" style="margin-bottom:0px;">
  <tr>
    <th style="width:5%;text-align:center">ลำดับ</th>
    <th style="width:8%;text-align:center">รหัสโครงการ</th>
    <th style="text-align:center">ชื่อโครงการ</th>
    <th style="width:12%;text-align:right" >งบโครงการ (บาท)</th>
    <th style="width:16%;text-align:right">งบกลั่นกรอง/จัดสรร (บาท)</th>
    <th style="width:100px; text-align:center">สถานะโครงการ</th>
    <th colspan="3" style="text-align:center">ปฎิบัติการ</th>
  </tr>
    <?php 

$CT=0;
if($_REQUEST["start"]){
	$CT = $_REQUEST["start"];
}
  $i=0; 
  $detail = $get->getProjectScreenType($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
  //ltxt::print_r($detail);
  if($detail){
	  
	foreach($detail as $detailprj){
	foreach($detailprj as $k=>$v){
		${$k} = $v;
	}

		// งบโครงการ
		$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0); 
		$SumAllBGTotal = $SumAllBGTotal + $SumBGTotal;  

		// งบกลั่นกรอง/จัดสรร
		$sumScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllot = $sumScreenInternal + $sumAllotExternal;

		
		// ดึงข้อมูล Level ต่อไป	
/*		if($_REQUEST["SCTypeId"] ==1){
			$oldScreenLevel = 1;
			$oldSCTypeId = ($_REQUEST["SCTypeId"]+1);
		}else if($_REQUEST["SCTypeId"] == 2 && $_REQUEST["ScreenLevel"] < $countScreenLevel){
			$oldScreenLevel = $_REQUEST["ScreenLevel"]+1;
			$oldSCTypeId = 2;	
		}else{
			$oldScreenLevel = 0;
			$oldSCTypeId = ($_REQUEST["SCTypeId"]+1);			
		}

		if($oldSCTypeId <= 3){
		
		$nextPrj = $get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST["OrganizeCode"], $oldSCTypeId, $oldScreenLevel);
		//ltxt::print_r($nextPrj);

			if($nextPrj){
				$sumScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$nextPrj[0]->ScreenLevel,$nextPrj[0]->SCTypeId,$nextPrj[0]->PrjDetailId);
				$sumAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$nextPrj[0]->ScreenLevel,$nextPrj[0]->SCTypeId,$nextPrj[0]->PrjDetailId);
				$sumAllot = $sumScreenInternal + $sumAllotExternal;
			}
		}// end 
*/		
	
		
?>
  <tr style="vertical-align:top;">
    <td style="text-align:center;"><?php echo ($i+1); ?>&nbsp;</td>
    <td style="text-align:center;"><?php echo $PrjCode?></td>
    <td style="text-align:left;"><?php echo icoView($detailprj);?></td>
    <td style="text-align:right;"><?php echo ($SumBGTotal)?number_format($SumBGTotal,2):'-'; ?></td>
    <td style="text-align:right;"><?php echo ($sumAllot)?number_format($sumAllot,2):'-'; ?></td>
    <td nowrap="nowrap" style="text-align:left; vertical-align:top"><div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div></td>
    <td  style="text-align:center; width:20px;" ><a href="javascript:printDocument('<?php echo $PrjDetailId ?>');" class="icon-printer" title="พิมพ์แบบฟอร์ม">&nbsp;</a></td>
    <td  style="text-align:center; width:20px;" ><a href="javascript:saveToWord('<?php echo $PrjDetailId ?>')" class="icon-word" title="ส่งออกเป็น Word">&nbsp;</a></td>
    <td  style="text-align:center; width:20px;" ><a href="javascript:saveToExcel('<?php echo $PrjDetailId ?>');" class="icon-excel" title="ส่งออกเป็น Excel">&nbsp;</a></td>
  </tr>
   <?php
$i++;
}
?>  
<?php
$CT++;

/*	if($oldSCTypeId <= 3){
		if($nextPrj){
			$TotalScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$nextPrj[0]->ScreenLevel,$nextPrj[0]->SCTypeId);
			$TotalAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$nextPrj[0]->ScreenLevel,$nextPrj[0]->SCTypeId);
			$TotalAllot = $TotalScreenInternal + $TotalAllotExternal;
		}
	}*/
	
	// งบกลั้นกรอง
	$TotalScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
	$TotalAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
	$TotalAllot = $TotalScreenInternal + $TotalAllotExternal;
	
?>
  <tr>
    <td colspan="3" style="text-align:right; font-weight:bold">รวมทั้งสิ้น</td>
    <td style="text-align:right"><strong><?php echo ($SumAllBGTotal)?number_format($SumAllBGTotal,2):'-'; ?></strong></td>
    <td align="right"><strong><?php echo ($TotalAllot)?number_format($TotalAllot,2):'-'; ?></strong></td>
    <td colspan="4" style="text-align:left; font-weight:bold;">บาท</td>
  </tr>
<?php }else{?>
<tr>
	<td colspan="11" style="text-align:center; color:#990000; height:50px">- - ไม่มีข้อมูล - -</td>
</tr>
<?php } ?>

</table>



<div class="hint" style="background-color:#EEE; padding:5px;">
    <span style="font-weight:bold; color:#000;">คำอธิบาย :&nbsp;</span>
    <span class="icon-printer">พิมพ์แบบฟอร์ม&nbsp;&nbsp;&nbsp;</span>
    <span class="icon-word">ส่งออกเป็น Word&nbsp;&nbsp;&nbsp;</span>
    <span class="icon-excel">ส่งออกเป็น Excel&nbsp;&nbsp;&nbsp;</span>
</div>


<br /><br /><br />