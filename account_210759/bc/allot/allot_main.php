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

//นับระดับการกลั่นกรองงบ
//$maxScreenLevel = $get->getMaxLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
//ltxt::print_r($maxScreenLevel);

function icoViewPrj($r,$ScreenLevel){
	$label = 'ดูโครงการ';
	global $listRequestPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($listRequestPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$ScreenLevel."  '",
		'ico view',
		$label,
		$label
	));
}


function icoViewScreenPrj($r){
	$label = 'ดูโครงการ';
	$text = '&nbsp;';
	global $listProjectViewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($listProjectViewPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$r->ScreenLevel." '",
		'ico viewproject',
		$label,
		$text
	));
}


function icoViewAllotPrj($r,$ScreenLevel){
	$label = 'รายละเอียด';
	global $viewProjectAllotPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewProjectAllotPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$ScreenLevel."  '",
		'ico view',
		$label,
		$label
	));
}


function icoViewAdjustPrj($r,$ScreenLevel){
	$label = 'รายละเอียด';
	global $viewProjectAdjustPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewProjectAdjustPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$ScreenLevel."  '",
		'ico view',
		$label,
		$label
	));
}



function icoCloseScreenPrj($r,$ScreenLevel){
	$label = 'ปิดการกลั่นกรอง/จัดสรร';
	$text = '&nbsp;';
	global $closescreenPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($closescreenPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$ScreenLevel."  '",
		'ico lock',
		$label,
		$text
	));
}


function icoNextPrj($r,$ScreenLevel){
	$label = 'ปรับขั้นตอน';
	global $nextRequestPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($nextRequestPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$ScreenLevel."  '",
		'ico next',
		$label,
		$label
	));}



function icoEditScreenPrj($r){
	$label = 'กลั่นกรองงบโครงการ';
	$text = '&nbsp;';
	global $listProjectPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($listProjectPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$r->ScreenLevel."'",
		'ico edit',
		$label,
		$text
	));
}


function icoEditAllotPrj($r){
	$label = 'จัดสรรงบโครงการ';
	$text = '&nbsp;';
	global $listProjectPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($listProjectPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$r->ScreenLevel."  '",
		'ico edit',
		$label,
		$text
	));
}


function icoEditAdjustPrj($r){
	$label = 'แก้ไข';
	global $listProjectPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($listProjectPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$r->ScreenLevel."  '",
		'ico edit',
		$label,
		$label
	));
}
/*function icoEditAdjustPrj($r,$ScreenLevel){
	$label = 'แก้ไข';
	global $editAdjustPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($editAdjustPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$ScreenLevel."  '",
		'ico edit',
		$label,
		$label
	));
}
*/

?>

<script type="text/javascript">
function loadSCT(BgtYear){
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($mainPage);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}

function getfilterorg(){
	var BgtYear = $('BgtYear').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($mainPage);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}
</script>


 <table width="100%" cellpadding="0" cellspacing="0" class="page-title">
 	<tr>
    	<td class="div-title-allot">&nbsp;</td>
        <td>
       <div class="font1">กลั่นกรองจัดสรรงบประมาณ</div>
        </td>
    </tr>
 </table>


<div class="sysinfo">
  <div class="sysname">แสดงขั้นตอนการจัดทำแผนปฏิบัติงานประจำปี</div>
</div>


<?php $curProcess = $get->getCurProcess($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);//ดึงข้อมูลขั้นตอนปัจจุบันของหน่วยงาน?>
<div class="boxfilter txtline" id="boxFilter">
      <div>
          <span class="txtbold">ปีงบประมาณ :</span> <?php echo $get->getYearProject(ltxt::getVar('BgtYear'),'BgtYear');?>
          <span class="txtbold">หน่วยงาน :</span> <span id="org-list"><?php echo $get->getOrganizeCode($_REQUEST["OrganizeCode"],ltxt::getVar('OrganizeCode'));?></span>
        
      </div>
</div>

<div class="hint" style="padding:3px; background-color:#EEE; text-align:right;">
<span class="ico step">  ขั้นตอนปัจจุบัน</span>
<span class="ico viewproject">  ดูโครงการ</span>
<span class="ico edit">  กลั่นกรอง/จัดสรร</span>
<!--<span class="ico lock">  ปิดการกลั่นกรอง/จัดสรร</span>-->
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
  <tr>
    <th style="width:80px;">ขั้นตอน</th>
    <th style="text-align:center">ขั้นตอนการจัดทำแผนปฏิบัติงาน</th>
    <th style="width:150px; text-align:right">งบประมาณขอตั้ง (บาท)</th>
    <th style="width:150px; text-align:right">งบกลั่นกรองจัดสรร (บาท)</th>
    <th colspan="2" style="text-align:center;">ปฎิบัติการ</th>
  </tr>
<?php 
$n=0;
$screen = $get->getAllotList($_REQUEST["BgtYear"]); // ltxt::print_r($screen); 
if($screen){
		foreach($screen as $r_screen){
			foreach($r_screen as $k=>$v){ ${$k} = $v; }
			$flag = 0;
			if($curProcess[0]->SCTypeId == $SCTypeId  && $ScreenLevel == $curProcess[0]->ScreenLevel ){
				 $flag = 1; 
			}
			$TotalPrj = $get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],0,0,0,0,$SCTypeId,$ScreenLevel);
			$TotalAllot = $get->getTotalAllotPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$ScreenLevel,$SCTypeId);
?>
              <tr<?php if($flag){ ?> style="background-color:#FFFFCC; font-weight:bold;"<?php } ?>>
                <td align="center"><?php echo ($n+1); ?></td>
                <td><?php echo $ScreenName;?>&nbsp;<?php if($flag){ ?><span class="ico step"></span><?php } ?></td>
                <td align="right"><?php echo ($TotalPrj)?number_format($TotalPrj,2):'-'; ?></td>
                <td align="right"><?php echo ($TotalAllot)?number_format($TotalAllot,2):'-'; ?></td>
                <td nowrap="nowrap" style="width:30px;"><?php 
						//if($SCTypeId==2){ 
							echo icoViewScreenPrj($r_screen); 
						//}
					?>
                  </td>
                <td nowrap="nowrap" style="width:30px;"><?php if($flag){ echo icoEditScreenPrj($r_screen); } ?><?php 
					//$SCTypeId==2 && 
/*					 if($SCTypeId == $CurSCType[0]->SCTypeId  && $ScreenLevel == $CurSCType[0]->ScreenLevel && $CurSCType[0]->CloseStep=='N'){ 
						//if($SCTypeId==2){ 
							echo icoCloseScreenPrj($RCProject,$ScreenLevel); 
						//}
					 }*/
					?></td>
              </tr>
<?php 
			$n++;
		}
}else{
 ?>
	<tr>
    	<td colspan="6" style="text-align:center; vertical-align:middle; color:#900">- - ไม่มีข้อมูล - -</td>
    </tr>
<?php } ?>
</table>





