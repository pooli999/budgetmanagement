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

//ltxt::print_r($_GET);

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 


/*function icoViewScreenPrj($r,$PrjId,$PrjDetailId){
	$label = $r->PrjActName;
	global $viewProjectScreenPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewProjectScreenPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']."&PrjActId=".$r->PrjActId."&PrjActCode=".$r->PrjActCode."&PrjId=".$PrjId."&PrjDetailId=".$PrjDetailId."  '",
		'',
		$label,
		$label
	));
}

function icoEditAllotPrj($r,$PrjId,$PrjDetailId){
	$label = $r->PrjActName;
	global $viewProjectAllotPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewProjectAllotPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']."&PrjActId=".$r->PrjActId."&PrjActCode=".$r->PrjActCode."&PrjId=".$PrjId."&PrjDetailId=".$PrjDetailId."  '",
		'',
		$label,
		$label
	));
}
*/

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
	window.location.href='?mod=<?php echo lurl::dotPage($listProjectViewPage);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode+'&SCTypeId='+<?php echo $_REQUEST['SCTypeId'];?>+'&ScreenLevel=<?php echo $_REQUEST['ScreenLevel'];?>';
}

function getfilterorg(){
	var BgtYear = $('BgtYear').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($listProjectViewPage);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode+'&SCTypeId='+<?php echo $_REQUEST['SCTypeId'];?>+'&ScreenLevel=<?php echo $_REQUEST['ScreenLevel'];?>';
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
      <b>ปีงบประมาณ : <?php echo $get->getYearProject(ltxt::getVar('BgtYear'),'BgtYear');?></b>
      <b>หน่วยงาน : <span id="org-list"><?php echo $get->getOrganizeCode($_REQUEST["OrganizeCode"],ltxt::getVar('OrganizeCode'));?></span></b>
      </td>
      <td align="right"><input type="button" name="button" id="button" value="  ย้อนกลับ  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>&SCTypeId=<?php echo $_REQUEST['SCTypeId'];?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel'];?>');" /></td>
    </tr>
  </table>
</div>


<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list" >
  
  <tr>
    <th style="width:30px;">ลำดับ</th>
    <th style="width:80px;">รหัส</th>
    <th>โครงการ/กิจกรรม</th>
    <th align="right" style="width:120px;">งบประมาณ(บาท)</th>
    <th align="right" style="width:150px;">งบกลั่นกรอง/จัดสรร(บาท)</th>
    <th style="width:120px;">สถานะโครงการ</th>   
  </tr>
  
  <?php
  		
			//นับระดับการกลั่นกรองงบ
			$maxScreenLevel = $get->getMaxLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
			//echo "maxScreenLevel=".$maxScreenLevel."<br>";

			if(($_REQUEST['SCTypeId'] == 2 || $_REQUEST['SCTypeId'] == 4 ) && $_REQUEST['ScreenLevel'] == 1){
				$SCTypeIdbg = $_REQUEST['SCTypeId']-1;
				$ScreenLevelbg = 0;
				//echo "SCTypeIdbg=".$SCTypeIdbg."<br>";
				//echo "ScreenLevelbg=".$ScreenLevelbg."<br>";
				
			}else if(($_REQUEST['SCTypeId'] == 2 || $_REQUEST['SCTypeId'] == 4 ) && $_REQUEST['ScreenLevel'] > 1 && $_REQUEST['ScreenLevel'] <= $maxScreenLevel){
				$SCTypeIdbg = $_REQUEST['SCTypeId'];
				$ScreenLevelbg = $_REQUEST['ScreenLevel']-1;	
				//echo "SCTypeIdbg=".$SCTypeIdbg."<br>";
				//echo "ScreenLevelbg=".$ScreenLevelbg."<br>";
						
			}else if($_REQUEST['SCTypeId'] == 3){
				$SCTypeIdbg = $_REQUEST['SCTypeId']-1;
				//นับระดับการกลั่นกรองงบ
				$maxScreenLevel = $get->getMaxLevel($_REQUEST['BgtYear'],$SCTypeIdbg);
				$ScreenLevelbg = $maxScreenLevel;	
			}	

  $i=1;
  $detail = $get->getProjectSCType($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel']);
  //ltxt::print_r($detail);
  if($detail){
  foreach($detail as $detailprj){
	foreach($detailprj as $k=>$v){
		${$k} = $v;
	}
	
	$OrganizeCodePrj = $OrganizeCode;
				
		// ดึง PrjDetailId ในขั้นตอนก่อนหน้า
		$prjDetail = $get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST["OrganizeCode"], $SCTypeIdbg, $ScreenLevelbg, $PrjId);		//ltxt::print_r($prjDetail);
			
		// งบจัดตั้ง	
		$TotalBGPrj=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$prjDetail[0]->PItemCode,$prjDetail[0]->PrjId,$prjDetail[0]->PrjDetailId,0,$prjDetail[0]->SCTypeId,$prjDetail[0]->ScreenLevel);
	
		//งบกลั่นกรอง-จัดสรร
		$sumScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllot = $sumScreenInternal + $sumAllotExternal;
  ?>
  <tr style="vertical-align:top;">
    <td style="text-align:center;"><?php echo $i;?>. </td>
    <td style="text-align:center;"><?php echo $PrjCode; ?></td>
    <td><?php echo icoView($detailprj);?></td>
    <td align="right"><?php echo (!empty($prjDetail) && $TotalBGPrj > 0)?number_format($TotalBGPrj,2):"-"; ?></td>
    <td align="right"><?php echo ($sumAllot > 0)?number_format($sumAllot,2):"-"; ?></td>
    <td><div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div></td>
  </tr>

  		
  <?php   
  		$i++;
  }
  ?>
    <?php	

	$TotalBG=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],0,0,0,0,$SCTypeIdbg,$ScreenLevelbg);
	
	$TotalScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
	$TotalAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
	$TotalAllot = $TotalScreenInternal + $TotalAllotExternal;

?>
  
  <tr>
    <th colspan="3" align="right">รวมทั้งสิ้น</th>
    <th align="right"><?php echo ($TotalBG > 0)?number_format($TotalBG,2):"-"; ?></th>
    <th align="right"><?php echo ($TotalAllot > 0)?number_format($TotalAllot,2):"-"; ?></th>
    <th>บาท</th>
  </tr>
  <?
  }else{
  
  ?>
  
  <tr>
  <td colspan="6" style="height:100px; padding-top:10px; text-align:center; color:#900">- - ไม่มีข้อมูล - -</td>
  </tr>
  <?php } //end  if($detail)?>

</table>
