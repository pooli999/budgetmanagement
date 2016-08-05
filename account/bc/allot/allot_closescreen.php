<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'รายละเอียด',
	),
));


/*echo "BgtYear=".$_REQUEST["BgtYear"];
echo "OrganizeCode=".$_REQUEST["OrganizeCode"];
echo "SCTypeId=".$_REQUEST["SCTypeId"];
echo "ScreenLevel=".$_REQUEST["ScreenLevel"];*/

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 


function icoView($r){
	$label = $r->PrjName;
	global $viewProjectScreenPage;
	vprintf('<a href="%s" class="%s" title="%s"  ><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewProjectScreenPage)."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$r->SCTypeId."&ScreenLevel=".$r->ScreenLevel."&NextSCTypeId=".$_REQUEST['SCTypeId']."&NextScreenLevel=".$_REQUEST['ScreenLevel']."&start=".$_REQUEST["start"]."'",		
		'ico view noicon',
		$label,
		$label
	));
}


?>
<script type="text/javascript">
function loadSCT(BgtYear){
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($closescreenPage);?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"];?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}

function getfilterorg(){
	var BgtYear = $('BgtYear').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($closescreenPage);?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"];?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}


function Save(form){	

	if($('closeStatus').checked){
		  if (confirm("หากคุณยืนยันการปิดการปรับปรุงข้อมูลแล้วจะไม่สามารถย้อนกลับมาปรับปรุงข้อมูลได้อีก ต้องการดำเนินการต่อไปหรือไม่")) {
   			 form.submit();
 		 }
	}else{
	
		alert('กรุณาคลิกในช่องสี่เหลี่ยมด้านล่างเพื่อยืนยันการปิดปรับปรุงข้อมูล');	
		$('closeStatus').focus();
	}

}

</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับปิดการปรับปรุงข้อมูล<?php echo $MenuName;?> </div>
</div>


<div class="topic-step"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>

<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
      <b>ปีงบประมาณ : <?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?></b>
      <b>หน่วยงาน : <span id="org-list"><?php echo $get->getOrganizeCode($_REQUEST["OrganizeCode"],ltxt::getVar('OrganizeCode'));?></span></b>
      </td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></td>
    </tr>
  </table>
  </div>
  
  
  <table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
  <tr>
    <th style="width:5%; text-align:center">ลำดับ</th>
    <th  style="width:65%;">ชื่อโครงการ</th>
    <th align="right" style="width:15%;">งบประมาณ(บาท)</th>
    <th align="right" style="width:15%;">งบกลั่นกรอง/จัดสรร(บาท)</th>   
    <!--<th style="width:15%;" nowrap="nowrap">สถานะโครงการ</th>-->
  </tr>
  <?php
  		//echo "SCTypeId= ".$_REQUEST['SCTypeId'];
  		//echo "ScreenLevel= ".$_REQUEST['ScreenLevel'];
		//echo "countScreenLevel= ".$countScreenLevel;
		
		//$countScreenLevel = $get->countScreenLevel();
	
		if($_REQUEST["SCTypeId"] == 2  &&  ($_REQUEST["ScreenLevel"] > 1 &&  $_REQUEST["ScreenLevel"] <= $countScreenLevel)){
			$oldScreenLevel = $_REQUEST["ScreenLevel"]-1;
			$oldSCTypeId = $_REQUEST["SCTypeId"];
		}else if($_REQUEST["SCTypeId"] == 3){
			$oldSCTypeId = 2;
			$oldScreenLevel = $countScreenLevel;
		}else{
			$oldScreenLevel = 0;
			$oldSCTypeId = ($_REQUEST["SCTypeId"]-1);
		}	
			
/*  		echo "SCTypeId= ".$_REQUEST['SCTypeId'];
  		echo "ScreenLevel= ".$_REQUEST['ScreenLevel'];
  		echo "oldSCTypeId= ".$oldSCTypeId;
  		echo "oldScreenLevel= ".$oldScreenLevel;
*/	
	$projectList = $get->getProjectSCType($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel']);	
  	//$projectList = $get->getProjectScreenType($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode'],$oldSCTypeId,$oldScreenLevel);
  	//ltxt::print_r($projectList);
	if($projectList){
		$i=0;
		foreach($projectList as $pL){
		foreach($pL as $k=>$v){
			${$k} = $v;
		}
		$i++;
		
		
		// งบจัดตั้ง	
		$TotalBGPrj=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,0,$SCTypeId,$ScreenLevel);
		
		// ดึง PrjDetailId ในระดับการกลั่นกรองปัจจุบัน
		$prjDetail = $get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST["OrganizeCode"], $_REQUEST["SCTypeId"], $_REQUEST["ScreenLevel"], $PrjId);
	
		//งบกลั่นกรอง-จัดสรร
		$sumScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$prjDetail[0]->PrjDetailId);
		$sumAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$prjDetail[0]->PrjDetailId);
		$sumAllot = $sumScreenInternal + $sumAllotExternal;
		
		
		
/*		$SumBGTotal=0;
		$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],0,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0); 	
		
		$sumScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllot = $sumScreenInternal + $sumAllotExternal;
*/		
		
  ?>
        <tr>
          <td align="center" valign="top"><?php echo $i; ?></td>
          <td valign="top"><?php echo icoView($pL);?></td>
          <td valign="top" style="text-align:right"><?php echo ($TotalBGPrj > 0)?number_format($TotalBGPrj,2):"-"; ?></td>
          <td align="right"><?php echo ($sumAllot > 0)?number_format($sumAllot,2):"-"; ?></td>
          <!--<td valign="top" nowrap="nowrap"><div  style="color:<?php //echo $TextColor; ?>; background:url(<?php //echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php //echo $StatusName;?></div></td>--> 
  		</tr>
  <?php  }  ?>
  
  <?php
/*  		//รวมงบโครงการ
	  	$TotalBG = $get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,"");	
  		//รวมงบจัดสรร
  		$TotalScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],0);
		$TotalAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],0);
		$TotalAllot = $TotalScreenInternal + $TotalAllotExternal;*/
		
		$TotalBG=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],0,0,0,0,$SCTypeId,$ScreenLevel);
		
		$TotalScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
		$TotalAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
		$TotalAllot = $TotalScreenInternal + $TotalAllotExternal;

  ?>
    <tr>
    <th colspan="2" align="right">รวมงบประมาณทั้งสิ้น</th>
    <th align="right"><?php echo ($TotalBG > 0)?number_format($TotalBG,2):"-"; ?></th>
    <th align="right"><?php echo ($TotalAllot > 0)?number_format($TotalAllot,2):"-"; ?></th>
  </tr>
  
  <tr><td colspan="5"  >
        
  <?php if($projectList != ""){ 

		$totalScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],0);
		$totalAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],0);
		$TotalAllot = $totalScreenInternal + $totalAllotExternal;
  
  ?>
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=closesreen" onSubmit="Save(this);return false;" enctype="multipart/form-data">
            <input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>" />
            <input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>" />
            <input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST['SCTypeId'];?>" />
            <input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST['ScreenLevel'];?>" />
            <input type="hidden" name="oldSCTypeId" id="oldSCTypeId" value="<?php echo $oldSCTypeId;?>" />
            <input type="hidden" name="oldScreenLevel" id="oldScreenLevel" value="<?php echo $oldScreenLevel;?>" />
            <input type="hidden" name="TotalAllot" id="TotalAllot" value="<?php echo $TotalAllot;?>" />
            
            <input name="closeStatus"  id="closeStatus" type="checkbox" value="Y" /> 
            <span style="color:#F00;">
            คุณต้องการให้ระบบปิดการปรับปรุงข้อมูลใน 
			<?php //echo ($_REQUEST["OrganizeCode"])?$CurSCType[0]->SCTypeName:"........................";  echo ($CurSCType[0]->ScreenLevel)?" --> ".$get->getScreenName($CurSCType[0]->ScreenLevel):"";?>
			<?php echo ($_REQUEST["OrganizeCode"])?$CurSCType[0]->SCTypeName:"........................";  echo ($NameByScreen)?" --> ".$NameByScreen:"";?>
            </span>
      
     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="submit" class="btnRed" name="save" id="save" value="บันทึก"  />
      <input type="button" name="button" id="button" value="ยกเลิก" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></div>
     
     </form>


  <?php } ?>
       
       
       
        </td></tr>


  <?php
  }else{ ?>
  		<tr><td colspan="5"  style="color:#900; text-align:center" height="50"> - -ไม่มีข้อมูล - -</td></tr>
   				
  <?php  }   ?>
  </table>









