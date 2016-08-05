<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
		
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($mainPage).'&start='.$_REQUEST["start"].'&BgtYear='.$_REQUEST["BgtYear"].'&OrganizeCode='.$_REQUEST["OrganizeCode"]
	),
	
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

function icoEditScreenPrj($r,$PrjId,$PrjDetailId){
	$label = 'กลั่นกรองงบ';
	$text = '&nbsp;';
	global $editScreenPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($editScreenPage)."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$r->ScreenLevel."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$text
	));
}

function icoEditAllotPrj($r,$PrjId,$PrjDetailId){
	$label = 'จัดสรรงบ';
	$text = '&nbsp;';
	global $editAllotPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($editAllotPage)."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$r->ScreenLevel."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$text
	));
}

function icoEditAdjustPrj($r,$PrjId,$PrjDetailId){
	$label = 'ปรับงบกลางปี';
	global $editAdjustPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($editAdjustPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']."&PrjActId=".$r->PrjActId."&PrjActCode=".$r->PrjActCode."&PrjId=".$PrjId."&PrjDetailId=".$PrjDetailId."  '",
		'ico edit',
		$label,
		$label
	));
}


function icoView($r){
	$label = $r->PrjName;
	global $viewProjectScreenPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewProjectScreenPage)."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$r->ScreenLevel."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

?>

<script type="text/javascript">
function loadSCT(BgtYear){
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($listProjectPage);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode+'&SCTypeId='+<?php echo $_REQUEST['SCTypeId'];?>+'&ScreenLevel=<?php echo $_REQUEST['ScreenLevel'];?>';
}

function getfilterorg(){
	var BgtYear = $('BgtYear').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($listProjectPage);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode+'&SCTypeId='+<?php echo $_REQUEST['SCTypeId'];?>+'&ScreenLevel=<?php echo $_REQUEST['ScreenLevel'];?>';
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
  <div class="sysname"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>
</div>

<?php $curProcess = $get->getCurProcess($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);//ดึงข้อมูลขั้นตอนปัจจุบันของหน่วยงาน?>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr >
      <td>
      <b>ปีงบประมาณ : </b><?php echo $_REQUEST["BgtYear"]?>
      <b>หน่วยงาน : </b><?php echo $get->getOrgName($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode']);?>
      
      </td>
      <td align="right"><input type="button" name="button" id="button" value="  ย้อนกลับ  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>&SCTypeId=<?php echo $_REQUEST['SCTypeId'];?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel'];?>');" /></td>
    </tr>
  </table>
</div>


<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list" >
  
  <tr>
    <th style="width:30px;">ลำดับ</th>
    <th>โครงการ/กิจกรรม</th>
    <th align="right" style="width:120px;">งบโครงการ (บาท)</th>
    <th align="right" style="width:150px;">งบกลั่นกรอง/จัดสรร (บาท)</th>
    <th style="width:120px;">สถานะโครงการ</th>
    <th>ปฎิบัติการ</th>   
  </tr>
  
  <?php
  $i=1;
  $detail = $get->getProjectSCType($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel']);//ltxt::print_r($detail);
// ltxt::print_r($detail);
  if($detail){
  foreach($detail as $detailprj){
	foreach($detailprj as $k=>$v){
		${$k} = $v;
	}
	
		// งบจัดตั้ง	
		$TotalBGPrj=$get->getTotalPrj($_REQUEST['BgtYear'],0,0,0,$PrjDetailId);
	
		//งบกลั่นกรอง-จัดสรร
		$sumScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllot = $sumScreenInternal + $sumAllotExternal;

  ?>
  <tr style="vertical-align:top;">
    <td style="text-align:center;"><?php echo $i;?>. </td>
     <td class="txtblue"><?php echo icoView($detailprj);?></td>
    <td align="right"><?php echo number_format($TotalBGPrj,2); ?></td>
    <td align="right"><?php echo ($sumAllot > 0)?number_format($sumAllot,2):"-"; ?></td>
    <td><div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div></td>
    <td style="text-align:center; width:75px;">
<?php
	if(in_array($StatusId,array(4))){
			echo icoEditAllotPrj($detailprj,$PrjId,$PrjDetailId); 
	}
?>
    </td>
  </tr>
  <?php 			  
  		$i++;
  }
  ?>
  <?php
	$TotalBG=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
	$TotalScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
	$TotalAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
	$TotalAllot = $TotalScreenInternal + $TotalAllotExternal;


?>
  
  <tr>
    <th colspan="2" align="right">รวมงบประมาณทั้งสิ้น</th>
    <th align="right"><?php echo ($TotalBG > 0)?number_format($TotalBG,2):"-"; ?></th>
    <th align="right"><?php echo ($TotalAllot > 0)?number_format($TotalAllot,2):"-"; ?></th>
    <th colspan="2">บาท</th>
  </tr>  
  <?php
  }else{
  
  ?>
  
  <tr>
  <td colspan="6" style="height:100px; padding-top:10px; text-align:center">- - ไม่มีข้อมูล - -</td>
  </tr>
  <?php } //end  if($detail)?>

</table>

<div class="hint" style="padding-top:5px">
<div style="font-weight:bold; color:#000;float:left;">คำอธิบาย :&nbsp;</div>
<div style="float:left; "><span class="ico edit">  คือ กลั่นกรอง/จัดสรร&nbsp;&nbsp;&nbsp;</span></div>
</div>
