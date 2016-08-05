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

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css'
));


//$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
//$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
//$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
//$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

function icoView($r){
	$label = $r->PrjName;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"  ><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}


?>
<script type="text/javascript">
function loadSCT(BgtYear){
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($nextRequestPage);?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"];?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}

function getfilterorg(){
	var BgtYear = $('BgtYear').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($nextRequestPage);?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"];?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}


function Save(form){	

	if($('updateStatus').checked){
		  if (confirm("หากคุณยืนยันการปรับขึ้นตอนแล้ว จะไม่สามารถย้อนกลับมายังขั้นตอนเดิมได้อีก ต้องการดำเนินการต่อไปหรือไม่")) {
   			 form.submit();
 		 }
	}else{
	
		alert('กรุณาคลิกในช่องสี่เหลี่ยมด้านล่างเพื่อยืนยันการปรับขึ้นตอน');	
		$('updateStatus').focus();
	}

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





<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right"><input type="button" name="button" id="button" value="  ย้อนกลับ  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></td>
    </tr>
  </table>
</div>  
  
  <form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=Save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
  
  
  
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
         <tr>
       <th >ปีงบประมาณ</th>
       <td><?php echo $_REQUEST["BgtYear"]?></td>
     </tr>
         <tr>
       <th valign="top">หน่วยงานที่รับผิดชอบ</th>
       <td><?php echo $get->getOrgName($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode']);?></td>
     </tr>
    <tr>
        <th valign="top">ขั้นตอนปัจจุบัน</th>
       <td><?php echo $get->getScreenName($_REQUEST["ScreenLevel"]); ?></td>
     </tr>
     <tr>
     <th>ขั้นตอนถัดไป</th>
      <td><?php echo $get->getScreenName($_REQUEST["ScreenLevel"]+1); ?></td> 
    </tr>
    
    <?php
/*		$SumBGTotal=0;
		if($_REQUEST["SCTypeId"] == 2  ){
		 	$SumBGTotal=$get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
		}else{
			$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],0,0); 	
		}	*/	
		
		// งบโครงการ
		 $SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);		
		
		
		 $SumTotalPrjInternalX4=$get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);		
		
		
		$sumScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllot = $sumScreenInternal + $sumAllotExternal;		
	?>
     <?php //if(in_array($_REQUEST["SCTypeId"],array(3,4))){ ?> 
     <!--<tr>   
      <th style="text-align:left">งบประมาณแผ่นดิน</th>
      <td ><div class="txtright txtbold"><?php //echo number_format($SumTotalPrjInternalX4,2); ?>&nbsp;บาท</div></td>
    </tr>      
    <?php //} ?>  
   <?php //if(in_array($_REQUEST["SCTypeId"],array(2,3,4))){ ?> 
   <tr>
      <th style="text-align:left">
	  	<?php 
				//switch ($_REQUEST["SCTypeId"]) {
					//case 2:
					//	echo "งบกลั่นกรอง";
					//break;				
					//case 3:
					//	echo "งบจัดสรร";
					//break;
					//case 4:
						//echo "งบปรับระหว่างปี";
					//break;								
				//}		
		?>
      </th>
      <td ><div class="txtred txtright txtbold"><?php //echo number_format($sumScreenInternal,2); ?>&nbsp;บาท</div></td>
    </tr>
    <?php //} ?>  
        <tr>
      <th style="text-align:left">งบประมาณโครงการ</th>
      <td ><div class="txtblue txtright txtbold"><?php //echo number_format($SumBGTotal,2); ?>&nbsp;บาท</div></td>
    </tr> -->
    </table>
  
  
  
  <table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
  <tr>
    <th style="width:5%;">ลำดับ</th>
    <th>ชื่อโครงการ</th>
    <th style="width:150px; text-align:right">งบโครงการ (บาท)</th>
    <?php if($_REQUEST['SCTypeId']==1){ ?><th style="width:150px; text-align:right">งบกลั่นกรอง/จัดสรร (บาท)</th><?php } ?>
    <th style="width:15%;" nowrap="nowrap">สถานะโครงการ</th>
  </tr>
  <?php
  		$projectList = $get->getProjectScreenType($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode'], $_REQUEST['SCTypeId'], $_REQUEST['ScreenLevel']);
	  	$statusPrj = $get->getCheckStatusProject($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode'], $_REQUEST['SCTypeId'], $_REQUEST['ScreenLevel']);
		$countList = count($projectList);
		
	//ltxt::print_r($statusPrj);
  	//ltxt::print_r($projectList);
	if($projectList){
		$i=0;
		foreach($projectList as $pL){
		foreach($pL as $k=>$v){
			${$k} = $v;
		}
		$i++;
		
		// งบโครงการ
		$SumBGTotal = $get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0); 
		$SumAllBGTotal = $SumAllBGTotal + $SumBGTotal; 
		
		// งบกลั่นกรอง/จัดสรร
		$sumScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllot = $sumScreenInternal + $sumAllotExternal;
		
  ?>
        <tr>
          <td align="center" valign="top"><?php echo $i; ?></td>
          <td valign="top">(<?php echo $PrjCode; ?>)&nbsp;<?php echo $PrjName;?></td>
          <td valign="top" style="text-align:right"><?php echo ($SumBGTotal > 0)?number_format($SumBGTotal,2):"-"; ?></td>
          <?php if($_REQUEST['SCTypeId']==1){ ?><td valign="top" style="text-align:right"><?php echo ($sumAllot > 0)?number_format($sumAllot,2):"-"; ?></td><?php } ?>
          <td valign="top" nowrap="nowrap">
        <div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div>  </td> 
  		</tr>
  <?php  }  ?>
  <?php
  		//รวมงบโครงการ
	  	//$TotalBG = $get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,"");	
  		//รวมงบจัดสรร
/*		if($oldSCTypeId <= 3){
			if($nextPrj){
				$TotalScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$nextPrj[0]->ScreenLevel,$nextPrj[0]->SCTypeId);
				$TotalAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$nextPrj[0]->ScreenLevel,$nextPrj[0]->SCTypeId);
				$TotalAllot = $TotalScreenInternal + $TotalAllotExternal;
			}
		}	*/	
		
	// งบกลั้นกรอง
	$TotalScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
	$TotalAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
	$TotalAllot = $TotalScreenInternal + $TotalAllotExternal;
		
  ?>
    <tr>
    <th colspan="2" align="right">รวมงบประมาณทั้งสิ้น</th>
    <th align="right"><?php echo ($SumAllBGTotal > 0)?number_format($SumAllBGTotal,2):"-"; ?></th>
    <?php if($_REQUEST['SCTypeId']==1){ ?><th align="right"><?php echo ($TotalAllot > 0)?number_format($TotalAllot,2):"-"; ?></th><?php } ?>
    <th style="text-align:left;">บาท</th>
  </tr>
  
 		<tr><td colspan="5"  >
        
  <?php if($projectList != ""  && ($statusPrj == $countList) ){ ?>

            <input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear']?>" />
            <input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode']?>" />
            <input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST['SCTypeId']?>" />
            <input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST['ScreenLevel']?>" />

            
            <input name="updateStatus"  id="updateStatus" type="checkbox" value="Y" /> คุณต้องการให้ระบบปรับขั้นตอนการจัดทำงบประมาณจาก 
            <span style="color:#F00;">
            "<?php echo $get->getScreenName($_REQUEST["ScreenLevel"]); ?>
			<?php 
			//echo ($_REQUEST["OrganizeCode"])?$CurSCType[0]->SCTypeName:"........................";
			//echo ($NameByScreen)?" --> ".$NameByScreen:"";
			?>"
            </span> 
            เป็น 
            <span style="color:#F00;">
            "<?php echo $get->getScreenName($_REQUEST["ScreenLevel"]+1); ?><?php  
				//echo ($nextStep[0]->SCTypeId)?$nextStep[0]->SCTypeName:"........................";
				//echo ($nextStep[0]->ScreenLevel)?" --> ".$nextStep[0]->ScreenName:"";
			?>"
             </span>
      
     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="submit" class="btnRed" name="save" id="save" value="  บันทึก  "  />
      <input type="button" name="button" id="button" value="  ยกเลิก  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></div>
     
     

  <?php }else{?>
  				
                <div style="padding-top:10px; padding-bottom:10px" ><strong>หมายเหตุ :</strong> <span style="color:#F00"> ไม่สามารถปรับขั้นตอนการจัดทำงบประมาณได้ เนื่องจากยังมีโครงการที่ไม่ผ่านการตรวจสอบ</span></div>
 				<div style="text-align:center; padding-top:10px; padding-bottom:10px"><input type="button" name="button" id="button" value="  ยกเลิก  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></div>
  
  
  <?php } ?>
       
       
       
        </td></tr>


  <?php
  }else{ ?>
  		<tr>
        <td colspan="<?php ($_REQUEST['SCTypeId']==1)?5:4; ?>"  style="color:#900; text-align:center" height="50">- -ไม่มีข้อมูล - -</td></tr>
  
  <?php  }   ?>
  </table>

</form>







