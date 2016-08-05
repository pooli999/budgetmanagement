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


function icoViewPrj($r){
	$label = 'ดูโครงการ';
	$text = '&nbsp;';
	global $ListView;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($ListView)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$r->ScreenLevel." '",
		'ico viewproject',
		$label,
		$text
	));
}

function icoViewCost($r){
	$label = 'ดูงบรายจ่าย';
	$text = '&nbsp;';
	global $ListCost;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($ListCost)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$r->ScreenLevel." '",
		'ico viewmoney',
		$label,
		$text
	));
}

function icoEdit($r){
	$label = 'แก้ไขข้อมูล';
	$text = '&nbsp;';
	global $ListEditPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($ListEditPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$r->ScreenLevel." '",
		'ico edit',
		$label,
		$text
	));
	
	
}

function icoViewScreen($r,$SCTypeId){
	$label = 'ดูงบกลั่นกรอง';
	$text = '&nbsp;';
	global $ViewScreen;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($ViewScreen)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$SCTypeId."&ScreenLevel=".$r->ScreenLevel." '",
		'ico viewscreen',
		$label,
		$text
	));
}

function icoViewAllot($r,$SCTypeId){
	$label = 'ดูงบจัดสรร';
	$text = '&nbsp;';
	global $ViewAllot;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($ViewAllot)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$SCTypeId."&ScreenLevel=".$r->ScreenLevel." '",
		'ico viewallot',
		$label,
		$text
	));
}

function icoViewAdjust($r,$SCTypeId){
	$label = 'ดูงบกลางปี';
	global $ViewAdjust;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($ViewAdjust)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$SCTypeId."&ScreenLevel=".$r->ScreenLevel." '",
		'ico view',
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
<script>
function getfilterorg(){
	var BgtYear = $('BgtYear').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($mainPage);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}

function loadSCT(BgtYear){
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($mainPage);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}

function saveToExcel(){
	var BgtYear = $('BgtYear').value;
	window.location.href="?mod=<?php echo LURL::dotPage('project_excel_cost')?>&format=raw&BgtYear="+BgtYear;
}
</script>



<?php $curProcess = $get->getCurProcess($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);//ltxt::print_r($curProcess); //ดึงข้อมูลขั้นตอนปัจจุบันของหน่วยงาน?>
 <table width="100%" cellpadding="0" cellspacing="0" class="page-title-user">
 	<tr>
    	<td class="div-title-plan">&nbsp;</td>
        <td>
       <div class="font1">จัดทำแผนปฏิบัติงานประจำปี</div>
        </td>
    </tr>
 </table>


<div class="sysinfo">
  <div class="sysname">แสดงขั้นตอนการจัดทำแผนปฏิบัติงานประจำปี</div>
</div>






<div class="boxfilter txtline" id="boxFilter">
      <div>
          <span class="txtbold">ปีงบประมาณ :</span> <?php echo $get->getYearProject(ltxt::getVar('BgtYear'),'BgtYear');?>
          <span class="txtbold">หน่วยงาน :</span> <span id="org-list"><?php echo $get->getOrganizeCode($_REQUEST["OrganizeCode"],ltxt::getVar('OrganizeCode'));?></span>
          <!--<input type="button" name="excel" id="excel" value="ส่งออกเป็น Excel" class="btn" onclick="javascript:saveToExcel();" />-->
      </div>
</div>



<div class="hint" style="padding:3px; background-color:#EEE; text-align:right;">
<span class="ico step">  ขั้นตอนปัจจุบัน</span>
<span class="ico viewproject">  ดูโครงการ</span>
<!--<span class="ico viewmoney">  ดูงบรายจ่าย</span>-->
<span class="ico edit">  แก้ไขข้อมูล</span>
</div>
    

<table width="100%" border="1" cellspacing="1" cellpadding="2" class="tbl-list">
  <tr>
    <th style="width:60px;">ขั้นตอน</th>
    <th style="width:20px;">&nbsp;</th>
    <th style="width:20px;">&nbsp;</th>
    <th style="text-align:center">ขั้นตอนการจัดทำแผนปฏิบัติงาน</th>
    <th style="width:100px; text-align:right">จำนวนโครงการ</th>
    <th style="width:150px; text-align:right">งบประมาณขอตั้ง (บาท)</th>
    <th style="width:150px; text-align:right">งบกลั่นกรองจัดสรร (บาท)</th>
    <th colspan="2" style="text-align:center; width:60px">ปฎิบัติการ</th>
  </tr>
<?php 
$n=0;
$screen = $get->getScreenRecordSet($_REQUEST["BgtYear"]); // ltxt::print_r($screen); 
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
              <tr><!--<?php //if($flag){ ?> style="background-color:#FFFFCC; font-weight:bold;"<?php //} ?>-->
                <td align="center"><?php echo ($n+1); ?></td>
                <td align="center"><?php if($flag){ ?><span class="ico step" title="ขั้นตอนปัจจุบัน"></span><?php } ?></td>
                <td <?php if($Allot=="Y"){ ?> class="icon-allot" title="ขั้นตอนนี้ต้องผ่านการกลั่นกรองจัดสรรงบประมาณ" <?php } ?>>&nbsp;</td>
                <td><?php //echo $SCTypeName;?> <?php echo $ScreenName;?></td>
                <td align="right"><?php echo $get->countProject($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$SCTypeId,$ScreenLevel); ?></td>
                <td align="right"><?php echo ($TotalPrj)?number_format($TotalPrj,2):'-'; ?></td>
                <td align="right"><?php echo ($TotalAllot)?number_format($TotalAllot,2):'-'; ?></td>
                <td style="width:20px;">&nbsp;<?php echo icoViewPrj($r_screen);?></td>
                <!--<td style="width:20px;">&nbsp;<?php //echo icoViewCost($r_screen); ?></td>-->
                <td style="width:20px;"><?php if($flag){ echo icoEdit($r_screen); } ?></td>
              </tr>
<?php 
			$n++;
		}
}else{
 ?>
	<tr>
    	<td colspan="9" style="text-align:center; vertical-align:middle; color:#900">- - ไม่มีข้อมูล - -</td>
    </tr>
<?php } ?>
</table>









