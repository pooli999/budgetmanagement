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


function icoViewScreenPrj($r,$ScreenLevel){
	$label = 'ดูรายละเอียด';
	global $viewProjectScreenPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewProjectScreenPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$ScreenLevel."  '",
		'ico view',
		$label,
		$label
	));
}


function icoViewAllotPrj($r,$ScreenLevel){
	$label = 'ดูรายละเอียด';
	global $viewProjectAllotPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewProjectAllotPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$ScreenLevel."  '",
		'ico view',
		$label,
		$label
	));
}


function icoViewAdjustPrj($r,$ScreenLevel){
	$label = 'ดูรายละเอียด';
	global $viewProjectAdjustPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewProjectAdjustPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$ScreenLevel."  '",
		'ico view',
		$label,
		$label
	));
}


function icoEditScreenPrj($r,$ScreenLevel){
	$label = 'แก้ไข';
	global $editScreenPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($editScreenPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$ScreenLevel."  '",
		'ico edit',
		$label,
		$label
	));
}

function icoCloseScreenPrj($r,$ScreenLevel){
	$label = 'ปิด';
	global $closescreenPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($closescreenPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$ScreenLevel."  '",
		'ico lock',
		$label,
		$label
	));
}



function icoNextPrj($r){
	$label = 'ปรับขั้นตอน';
	global $nextRequestPage;
	vprintf('<a style="font-weight:normal;" href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($nextRequestPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$r->ScreenLevel."  '",
		'ico next',
		$label,
		$label
	));}



function icoEditAllotPrj($r,$ScreenLevel){
	$label = 'แก้ไข';
	global $editAllotPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($editAllotPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$ScreenLevel."  '",
		'ico edit',
		$label,
		$label
	));
}

function icoEditAdjustPrj($r,$ScreenLevel){
	$label = 'แก้ไข';
	global $editAdjustPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($editAdjustPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$ScreenLevel."  '",
		'ico edit',
		$label,
		$label
	));
}


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
    	<td class="div-title-next">&nbsp;</td>
        <td>
       <div class="font1">ปรับขั้นตอนแผนปฏิบัติงานประจำปี</div>
        </td>
    </tr>
 </table>


<div class="sysinfo">
  <div class="sysname"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>
</div>



<?php $curProcess = $get->getCurProcess($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);//ltxt::print_r($curProcess);//ดึงข้อมูลขั้นตอนปัจจุบันของหน่วยงาน?>
<div class="boxfilter txtline" id="boxFilter">
      <div>
          <span class="txtbold">ปีงบประมาณ :</span> <?php echo $get->getYearProject(ltxt::getVar('BgtYear'),'BgtYear');?>
          <span class="txtbold">หน่วยงาน :</span> <span id="org-list"><?php echo $get->getOrganizeCode($_REQUEST["OrganizeCode"],ltxt::getVar('OrganizeCode'));?></span>
      </div>
</div>
<div class="hint" style="padding:3px; background-color:#EEE; text-align:right;">
<span class="ico step">  ขั้นตอนปัจจุบัน</span>
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
  <tr>
    <th style="width:80px;">ขั้นตอน</th>
    <th style="width:20px;">&nbsp;</th>
    <th style="text-align:center">ขั้นตอนการจัดทำแผนปฏิบัติงาน</th>
    <th style="width:150px; text-align:right">งบประมาณขอตั้ง (บาท)</th>
    <th style="width:150px; text-align:right">งบกลั่นกรองจัดสรร (บาท)</th>
    <th style="text-align:center; width:80px">ปฎิบัติการ</th>
  </tr>
<?php 
$n=0;
$screen = $get->getScreenRecordSet($_REQUEST["BgtYear"]);  //ltxt::print_r($screen);  echo $curProcess[0]->SCTypeId; echo $curProcess[0]->ScreenLevel;
if($screen){
		foreach($screen as $r_screen){
			foreach($r_screen as $k=>$v){ ${$k} = $v; }
			$nextStep = $get->getNextSCTypeID($_REQUEST["BgtYear"],$ScreenLevel);
			$flag = 0;
			if($curProcess[0]->SCTypeId == $SCTypeId  && $ScreenLevel == $curProcess[0]->ScreenLevel ){
				 $flag = 1; 
			}
			/*if(!$nextStep){
				$flag = 0; 
			}*/
			$TotalPrj = $get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],0,0,0,0,$SCTypeId,$ScreenLevel);
			$TotalAllot = $get->getTotalAllotPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$ScreenLevel,$SCTypeId);
?>
              <tr<?php if($flag){ ?> style="background-color:#FFFFCC; font-weight:bold;"<?php } ?>>
                <td align="center"><?php echo ($n+1); ?></td>
                <td <?php if($Allot=="Y"){ ?> class="icon-allot" title="ขั้นตอนนี้ต้องผ่านการกลั่นกรองจัดสรรงบประมาณ" <?php } ?>>&nbsp;</td>
                <td><?php //echo $SCTypeName;?><?php echo $ScreenName;?>&nbsp;<?php if($flag){ ?><span class="ico step"></span><?php } ?></td>
                <td align="right"><?php echo ($TotalPrj)?number_format($TotalPrj,2):'-'; ?></td>
                <td align="right"><?php echo ($TotalAllot)?number_format($TotalAllot,2):'-'; ?></td>
                <td>
<?php 
if($nextStep && $flag){ 
	if($Allot=='Y'){
		if($TotalAllot > 0){
			echo icoNextPrj($r_screen); 
		}
	}else{
		echo icoNextPrj($r_screen); 
	}
} 
?>
                </td>
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

