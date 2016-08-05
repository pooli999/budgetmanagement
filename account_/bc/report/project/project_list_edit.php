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

function icoIndicator($r,$PrjId,$PrjDetailId,$SCTypeId,$ScreenLevel){
	$label = 'จัดการตัวชี้วัดโครงการ';
	$text = '&nbsp;';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage('project_ind')."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']." '",
		'icon-prj-index',
		$label,
		$text
	));
}

function icoEditCost($r,$PrjId,$PrjDetailId,$SCTypeId,$ScreenLevel){
	$label = 'จัดการค่าใช้จ่าย';
	$text = '&nbsp;';
	global $ViewCost;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($ViewCost)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']." '",
		'ico money',
		$label,
		$text
	));
}

function icoEditind($r,$PrjId,$PrjDetailId,$SCTypeId,$ScreenLevel){
	$label = 'จัดการตัวชี้วัดกิจกรรม';
	$text = '&nbsp;';
	global $ViewInd;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($ViewInd)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']." '",
		'ico index',
		$label,
		$text
	));
}

function icoParty($r,$PrjId,$PrjDetailId,$SCTypeId,$ScreenLevel){
	$label = 'ภาคีเครือข่าย';
	$text = '&nbsp;';
	global $partyListPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($partyListPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']." '",
		'ico personmulti',
		$label,
		$text
	));
}

function icoEdit($r,$PrjId){
	$label = 'แก้ไขข้อมูล';
	$text = '&nbsp;';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&PItemCode=".$r->PItemCode."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']." '",
		'ico edit',
		$label,
		$text
	));
}

function icoDelete($r,$SCTypeId,$ScreenLevel,$BgtYear,$OrganizeCode){
	$label = 'ลบทิ้ง';
	$text = '&nbsp;';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:if(confirm('คุณต้องการลบข้อมูล ".$r->PrjName." หรือไม่')) self.location='?mod=".LURL::dotPage($actionPage)."&action=delete&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']." '",
		'ico delete',
		$label,
		$text
	));
}

/*function icoSent($r){
	$label = 'ส่งโครงการ';
	$text = '&nbsp;';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:if(confirm('ส่งข้อมูลโครงการ ".$r->PrjName." ไปตรวจสอบ')) self.location='?mod=".LURL::dotPage($actionPage)."&action=sent&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']." '",
		'ico sent',
		$label,
		$text
	));
}*/

function icoCancel($r){
	$label = 'ปิดโครงการ';
	$text = '&nbsp;';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:if(confirm('ปิดโครงการ ".$r->PrjName." ')) self.location='?mod=".LURL::dotPage($actionPage)."&action=cancel&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']."&start=".$_REQUEST["start"]."'",
		'ico lock',
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

function icoBackup($r){
	$label = 'สำรองข้อมูล';
	$text = '&nbsp;';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"#",
		'ico backup',
		$label,
		$text
	));
}

// ระดับกลั่นกรองระดับสุดท้ายของ SCTypeId == 2
$maxScreenLevel = $get->getMaxLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);


?>
<style>
.parentrow{
	background-color:#eee;
}
</style>

<script type="text/javascript">
function sendProject(SCTypeId,SumBGTotal,sumAllot,PrjName,PrjId,PrjDetailId,ScreenLevel,maxScreenLevel){
	
/*	if(confirm('ต้องการยืนยันการส่งข้อมูลโครงการ  '+PrjName+' ไปตรวจสอบ')==true){
		self.location='?mod=<?php echo LURL::dotPage($actionPage);?>&action=sent&PrjId='+PrjId+'&PrjDetailId='+PrjDetailId+'&start=<?php echo $_REQUEST["start"];?>&BgtYear=<?php echo $_REQUEST["BgtYear"];?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"];?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"];?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>' ;
	}*/
	if(SCTypeId == 1 || (SCTypeId == 2 && ScreenLevel == maxScreenLevel) ){
			//if(SumBGTotal <= parseFloat(0)){
				//alert('ไม่สามารถส่งโครงการไปตรวจสอบได้  เนื่องจากไม่ได้แจกแจงรายการค่าใช้จ่าย');
			//}else{
				if(confirm('ยืนยันการส่งข้อมูลโครงการ  '+PrjName+' ไปตรวจสอบ')==true)
				{
					self.location='?mod=<?php echo LURL::dotPage($actionPage);?>&action=sent&PrjId='+PrjId+'&PrjDetailId='+PrjDetailId+'&start=<?php echo $_REQUEST["start"];?>&BgtYear=<?php echo $_REQUEST["BgtYear"];?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"];?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"];?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>' ;
				}// end if
			//}// end if
			
	}else{

			//if(SumBGTotal == sumAllot && SumBGTotal > parseFloat(0)){
				if(confirm('ยืนยันการส่งข้อมูลโครงการ  '+PrjName+' ไปตรวจสอบ')==true)
				{
					self.location='?mod=<?php echo LURL::dotPage($actionPage);?>&action=sent&PrjId='+PrjId+'&PrjDetailId='+PrjDetailId+'&start=<?php echo $_REQUEST["start"];?>&BgtYear=<?php echo $_REQUEST["BgtYear"];?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"];?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"];?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>' ;
				}
			//}else{
				//alert('ไม่สามารถส่งโครงการไปตรวจสอบได้  เนื่องจากงบประมาณโครงการและงบกลั่นกรอง / จัดสรร / งบปรับระหว่างปี ไม่เท่ากันหรือไม่มีงบประมาณ');
			//}
	}
	
}// end function



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
      <td>
      <input type="button" name="add" value="  กรอกรายละเอียดโครงการ  " class="add" onclick="window.location.href='?mod=<?php echo LURL::dotPage($addPage);?>&BgtYear=<?php echo $_REQUEST['BgtYear']; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>'" />
      </td>
      <td align="right">
      <input type="button" name="button" id="button" value="  ย้อนกลับ  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" />
      </td>
    </tr>
  </table>  
</div>



<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&task=Save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>">



<!--<div class="hint" style="padding:8px;">
    <b>คำแนะนำ : </b>
    <div style="text-indent:60px;">- ในกรณีที่ไม่มียอดงบกลั่นกรองจัดสรร จะไม่สามารถทำการบันทึกค่าใช้จ่ายของโครงการได้ โปรดแจ้งเจ้าหน้าที่งานแผนงาน เพื่อดำเนินการบันทึกยอดกลั่นกรองจัดสรรงบให้กับโครงการ</div>
</div>-->

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#EEE;">
<tr>
<td style="padding:3px;">
<b>ปีงบประมาณ : </b><?php echo $_REQUEST["BgtYear"]?>&nbsp;
<b>หน่วยงาน : </b><?php echo $get->getOrgName($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode']);?>
</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list" style="margin-bottom:0px;">
  <tr>
    <th style="width:5%;text-align:center">ลำดับ</th>
    <th style="width:10%;text-align:center">รหัสโครงการ</th>
    <th style="text-align:center">ชื่อโครงการ</th>
    <th style="width:12%;text-align:right" >งบโครงการ (บาท)</th>
    <th style="width:16%;text-align:right">งบกลั่นกรอง/จัดสรร (บาท)</th>
    <th style="width:100px; text-align:center">สถานะโครงการ</th>
    <th colspan="8"  style="text-align:center">ปฏิบัติการ</th>
  </tr>
  <?php
  $CT=0;
if($_REQUEST["start"]){
	$CT = $_REQUEST["start"];
}

$i=0;
$detail = $get->getProjectScreenType($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST['SCTypeId'],$_REQUEST["ScreenLevel"]); 
//ltxt::print_r($detail);
if($detail){
foreach($detail as $detailprj){
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
		
		

?>        
  <tr>
    <td style="text-align:center; vertical-align:top"><?php echo ($i+1); ?></td>
    <td style="text-align:center; vertical-align:top"><?php echo $PrjCode; ?></td>
    <td style="text-align:left; vertical-align:top"><?php echo icoView($detailprj);?></td>
    <td style="text-align:right; vertical-align:top"><?php echo ($SumBGTotal)?number_format($SumBGTotal,2):'-'; ?></td>
	<td style="text-align:right; vertical-align:top"><?php echo ($sumAllot)?number_format($sumAllot,2):'-'; ?></td>
    <td nowrap="nowrap" style="text-align:left; vertical-align:top"><div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div></td>
    <td style="width:20px; vertical-align:top">
   <?php
		if(in_array($StatusId,array(1,3))){
			  echo icoIndicator($detailprj,$PrjId,$PrjDetailId,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
		}
		?>
    </td>
    <td style="width:20px; vertical-align:top">
		<?php
/*	  	if(in_array($StatusId,array(1,3))  && ((!empty($sumAllot) && $_REQUEST["SCTypeId"] != 1) || $_REQUEST["SCTypeId"] == 1) ){
			  echo icoEditCost($detailprj,$PrjId,$PrjDetailId,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
		}
*/		if(in_array($StatusId,array(1,3))){
			  echo icoEditCost($detailprj,$PrjId,$PrjDetailId,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
		}
		?></td>
        <td style="width:20px;vertical-align:top" >
        <?php
        if(in_array($StatusId,array(1,3))){
        echo icoParty($detailprj,$PrjId,$PrjDetailId,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
        }
        ?></td>        
        <td style="width:20px;vertical-align:top" >
		<?php
	  	if(in_array($StatusId,array(1,3))){
			  echo icoEditInd($detailprj,$PrjId,$PrjDetailId,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
		}
		?></td>

    <td style="width:20px;vertical-align:top">
		<?php
	  	if(in_array($StatusId,array(1,3))){
			  echo icoEdit($detailprj,$PrjId);
		}
		?></td>
    <td style="width:20px; vertical-align:top">
		<?php
	  	if(in_array($StatusId,array(1,3))){
			   echo icoDelete($detailprj,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);
		}
		?></td>
    <td style="width:20px;vertical-align:top">
		<?php if(in_array($StatusId,array(1,3))){  ?>
			<a href="JavaScript:void(0);"  class="ico sent"  onClick="sendProject(<?php echo $_REQUEST["SCTypeId"];?>,<?php echo $SumBGTotal;?>,<?php echo ($sumAllot)?$sumAllot:0;?>,'<?php echo $PrjName;?>','<?php echo $PrjId;?>','<?php echo $PrjDetailId;?>',<?php echo $_REQUEST["ScreenLevel"];?>,'<?php echo $maxScreenLevel;?>')" >&nbsp;</a>
		<?php } ?></td>
    <td style="width:20px; vertical-align:top">
		<?php
	  	if(in_array($StatusId,array(1,2,3,4))){
			  echo icoBackup($detailprj);
		}
		?></td>    
    <!--<td style="width:20px;vertical-align:top">-->
		<?php
/*	  	if(in_array($StatusId,array(1,2,3,4))){
			  echo icoCancel($detailprj);
		}*/
		?><!--</td>-->
  </tr>

 <?php
$i++;
}
?>  
<?php
$CT++;
?>
<?php 
/*	if($oldSCTypeId <= 3){
		if($nextPrj){
			$TotalScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$nextPrj[0]->ScreenLevel,$nextPrj[0]->SCTypeId);
			$TotalAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$nextPrj[0]->ScreenLevel,$nextPrj[0]->SCTypeId);
			$TotalAllot = $TotalScreenInternal + $TotalAllotExternal;
		}
	}
*/

	$TotalScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
	$TotalAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
	$TotalAllot = $TotalScreenInternal + $TotalAllotExternal;

?>
<tr>
	<td colspan="3" align="right"><strong>รวมทั้งสิ้น</strong></td>
    <td align="right"><strong><?php echo ($SumAllBGTotal)?number_format($SumAllBGTotal,2):'-'; ?></strong></td>
    <td align="right"><strong><?php echo ($TotalAllot)?number_format($TotalAllot,2):'-'; ?></strong></td>
    <td colspan="9" align="left"><strong>บาท</strong></td>
  </tr>

<?php }else{  ?>
<tr>
	<td colspan="14" style="text-align:center; color:#990000; height:50px">- - ไม่มีข้อมูล - -</td>
</tr>
<?php } ?>

</table>
<!--<div class="cms-box-navpage" style="margin-bottom:5px;"> <?php //echo NavPage(array('total'=>$detail['total']));?> </div>-->




<div class="hint" style="background-color:#EEE; padding:5px;">
    <span style="font-weight:bold; color:#000;">คำอธิบาย :&nbsp;</span>
    <span class="ico money">  จัดการค่าใช้จ่าย&nbsp;&nbsp;&nbsp;</span>
    <span class="ico personmulti">  จัดการภาคีเครือข่าย&nbsp;&nbsp;&nbsp;</span>
    <span class="ico index">  จัดการตัวชี้วัด&nbsp;&nbsp;&nbsp;</span>
    <span class="ico edit">  แก้ไขข้อมูล&nbsp;&nbsp;&nbsp;</span>
    <span class="ico delete">  ลบข้อมูล&nbsp;&nbsp;&nbsp;</span>
    <span class="ico sent">  ส่งโครงการไปตรวจสอบ&nbsp;&nbsp;&nbsp;</span>
    <span class="ico backup">  สำรองข้อมูล&nbsp;&nbsp;&nbsp;</span>
    <!--<span class="ico lock">  คือ ปิดโครงการ</span></div>-->
</div>


<br />
<br />
<br />
