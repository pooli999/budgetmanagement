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

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

function icoEdit($r){
	$label = 'บันทึกผลการตรวจสอบ';
	$text = '&nbsp;';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&PItemCode=".$r->PItemCode."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']." '",
		'ico edit',
		$label,
		$text
	));
}

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


?>
<style>
.parentrow{
	background-color:#eee;
}
</style>

 <table width="100%" cellpadding="0" cellspacing="0" class="page-title">
 	<tr>
    	<td class="div-title-check">&nbsp;</td>
        <td>
       <div class="font1">ตรวจสอบแผนปฏิบัติงานประจำปี</div>
        </td>
    </tr>
 </table>


<div class="sysinfo">
  <div class="sysname"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>
</div>

<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
      <b>ปีงบประมาณ : </b><?php echo $_REQUEST["BgtYear"]?>
      <b>หน่วยงาน : </b><?php echo $get->getOrgName($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode']);?>
      </td>
      <td align="right"><input type="button" name="button" id="button" value="  ย้อนกลับ  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></td>
    </tr>
  </table>
</div>


<form>
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST["ScreenLevel"]; ?>" />
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST['SCTypeId'];?>" />
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>">

<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list" >
    <tr class="td-descr">
    <th style="width:37px;">ลำดับ</th>
    <th>ชื่อโครงการ</th>
    <th style="width:100px; text-align:right">งบโครงการ(บาท)</th>
    <th style="width:155px;">งบกลั่นกรอง/จัดสรร (บาท)</th>
    <th style="width:100px;">สถานะโครงการ</th>
    <th style="width:50px;">ครั้งที่</th>
    <th style="width:100px;">วันที่ตรวจสอบ</th>
    <th style="width:60px;">ปฎิบัติการ</th>
  </tr>
  <?php
  $CT=0;
if($_REQUEST["start"]){
	$CT = $_REQUEST["start"];
}

$detail = $get->getDataSetProjectScreenType($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel']);
//ltxt::print_r($detail);
foreach($detail["rows"] as $detailprj){
	foreach($detailprj as $k=>$v){
		${$k} = $v;
	}
	
		// งบโครงการ
		$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST["ScreenLevel"],0); 
		$SumAllBGTotal = $SumAllBGTotal + $SumBGTotal;  
		
		// งบกลั่นกรองจัดสรร
		$sumScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllot = $sumScreenInternal + $sumAllotExternal;

		
/*		// ดึงข้อมูล Level ต่อไป	
		if($_REQUEST["SCTypeId"] ==1){
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
    <td align="center"><?php echo ($CT+1); ?>.</td>
	<td><?php echo icoView($detailprj);?></td>
    <td style="text-align:right"><?php echo ($SumBGTotal)?number_format($SumBGTotal,2):'-'; ?></td>
    <td style="text-align:right"><?php echo ($sumAllot)?number_format($sumAllot,2):'-'; ?></td>
    <td style="text-align:left"><div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div></td>
    <td style="text-align:center">
	<?php 
	$ChkNo=$get->getMaxChk($PrjDetailId);
	if($StatusId==2){
		$ChkNo=$ChkNo+1;
	}
	echo $ChkNo;
	?>
    &nbsp;</td>
        <td style="text-align:center"><?php $CreateDate=$get->getdate($PrjDetailId); echo dateformat($CreateDate);?>&nbsp;</td>
    <td style="text-align:center">
	  <?php  	if(($StatusId==2)){?>
	  <?php echo icoEdit($detailprj); ?>
	  <?php }?>
&nbsp;</td>
  </tr>
<?php
$CT++;
}
?>  



<?php if($CT==0){ ?>
<tr>
	<td colspan="9" style="text-align:center; color:#990000;">- - ไม่มีข้อมูล - -</td>
</tr>
<?php }else{ 
/*	if($oldSCTypeId <= 3){
		if($nextPrj){
			$TotalScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$nextPrj[0]->ScreenLevel,$nextPrj[0]->SCTypeId);
			$TotalAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$nextPrj[0]->ScreenLevel,$nextPrj[0]->SCTypeId);
			$TotalAllot = $TotalScreenInternal + $TotalAllotExternal;
		}
	}*/

	$TotalScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
	$TotalAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
	$TotalAllot = $TotalScreenInternal + $TotalAllotExternal;
?>

<tr>
    <td colspan="2" align="right" style="font-weight:bold"><b>รวมทั้งสิ้น </b></td>
    <td align="right" style="font-weight:bold"><?php echo ($SumAllBGTotal)?number_format($SumAllBGTotal,2):'-'; ?></td>
    <td align="right"><strong><?php echo ($TotalAllot)?number_format($TotalAllot,2):'-'; ?></strong></td>
    <td align="left" style="font-weight:bold" colspan="4">บาท</td>
  </tr>
<?php 
}
?>
</table>
</form>
<div class="cms-box-navpage" style="margin-bottom:5px;"> <?php echo NavPage(array('total'=>$detail['total']));?> </div>

<div class="hint" style="padding-top:5px">
<div style="font-weight:bold; color:#000;float:left;">คำอธิบาย :&nbsp;</div>
<div style="float:left; "><span class="ico edit">  คือ บันทึกผลการตรวจสอบ&nbsp;&nbsp;&nbsp;</span></div>
</div>


