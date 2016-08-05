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

// ดึงรายการงบอุดหนุน
$getExName=$get->getSourceName();

//นับระดับการกลั่นกรองงบ
$maxScreenLevel = $get->getMaxLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
//ltxt::print_r($maxScreenLevel);

?>

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




<?php $curProcess = $get->getCurProcess($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);//ดึงข้อมูลขั้นตอนปัจจุบันของหน่วยงาน?>
<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td align="right">
      <input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ListEditPage); ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"]; ?>'" />
      </td>
    </tr>
  </table>  
</div>


<?php
 $datas = $get->getDetailPrj($_REQUEST["PrjId"],$_REQUEST["PrjDetailId"]);//ltxt::print_r($datas);
 //ltxt::print_r($datas);
foreach($datas as $actdatas){
	foreach($actdatas as $k=>$v){
		${$k} = $v;
	}
}

		//if($_REQUEST["SCTypeId"] == 2  ){
		 //	$SumBGTotal=$get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
		//}else{
		//	$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],0,0); 	
		//}		
		
		// งบโครงการ
		 $SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);

		// งบกลั่นกรอง/จัดสรร
		$sumScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$_REQUEST["PrjDetailId"]);
		$sumAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$_REQUEST["PrjDetailId"]);
		$sumAllot = $sumScreenInternal + $sumAllotExternal;		

?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" >
     <tr>
       <th >ปีงบประมาณ</th>
       <td><?php echo $BgtYear;?></td>
     </tr>
     <tr>
       <th>ภายใต้แผนงาน</th>
       <td id="plan">(<?php echo $PItemCode; ?>)&nbsp;<?php echo $get->getPItemCode($PItemCode);?></td>
     </tr> 
      <tr>
        <th>ชื่อโครงการ</th>
        <td id="prj">(<?php echo $PrjCode; ?>)&nbsp;<?php echo $PrjName;?></td>
      </tr>
        <tr>
        <th>ระยะเวลาการดำเนินโครงการ</th>
        <td><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td>
      </tr>
         <tr>
       <th valign="top">หน่วยงานที่รับผิดชอบ</th>
       <td><?php echo $get->getOrgName($BgtYear, $OrganizeCode);?></td>
     </tr>
    <tr>
        <th valign="top">ผู้รับผิดชอบโครงการ</th>
       <td >
       <?php 
        $TaskPerson = $get->getTaskPerson($PrjId); 
		if(!$TaskPerson){ echo '<span style="color:#999;">-ไม่ระบุ-</span>'; }
       echo "<ul>";
       foreach($TaskPerson as $rRName){
            foreach($rRName as $k=>$v){
                ${$k} = $v;
            }
            echo "<li>";
            echo $Name;
            if($ResultStatus == 'Y'){echo " (ผู้รายงาน)";}
            echo "</li>";
       }
       echo "</ul>";
        
       ?>
       </td>
     </tr>
</table>


<div class="boxfilter2"><div class="icon-topic">งบประมาณแผ่นดิน</div></div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" >
  <tr>
    <th width="6%">ลำดับ</th>
    <th width="54%">รายการกิจกรรม&nbsp;</th>
    <th width="20%" style="text-align:right">งบประมาณตัวคูณ (บาท)&nbsp;</th>
    <th width="20%" style="text-align:right">งบประมาณจำแนกเดือน (บาท)&nbsp;</th>
  </tr>
  <?php 
  	$i=0;
	$SumTotalCost=0;
	$SumTotalCostMonth=0;/*ผลรวมงบประมาณรายเดือน/ไตรมาส*/
	$detailact = $get->getActivity($PrjDetailId);
foreach($detailact as $prjactdetail){
	foreach($prjactdetail as $k=>$v){
		${$k} = $v;
	}
		$SumCost=$get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0);
		$SumTotalCost = $SumTotalCost + $SumCost;
		
		/*งบประมาณรายเดือน/ไตรมาส*/
		$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId);
		$SumTotalCostMonth = $SumTotalCostMonth + $SumCostMonth;
		/*END งบประมาณรายเดือน/ไตรมาส*/
  ?>
  <tr style="vertical-align:top;">
    <td style="text-align:center"><?php echo ($i+1); ?></td>
    <td><?php echo $PrjActName; ?></td>
    <td style="text-align:right">
    <a href="?mod=<?php echo LURL::dotPage($ListViewCost); ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&PrjId=<?php echo $_REQUEST["PrjId"]; ?>&PrjActId=<?php echo $PrjActId; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>"><?php echo number_format($SumCost,2); ?></a></td>
    <td style="text-align:right;">
    <?php if($SumCostMonth != $SumCost){   echo '<span style="color:#FF0000; font-weight:bold;">!</span>';   } ?> 
    <a href="?mod=<?php echo LURL::dotPage($ListViewCostMonth); ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&PrjId=<?php echo $_REQUEST["PrjId"]; ?>&PrjActId=<?php echo $PrjActId; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>"><?php echo number_format($SumCostMonth,2); ?></a></td>
  </tr>
   <?php
$i++;
}
?>  

<tr>
    <td style="text-align:right" colspan="2"><b>รวมงบประมาณทั้งสิ้น</b></td>
    <td style="text-align:right; font-weight:bold"><?php echo number_format($SumTotalCost,2); ?></td>
    <td style="text-align:right; font-weight:bold"><?php echo number_format($SumTotalCostMonth,2); ?></td>
  </tr>
</table>

<?php //*************** เงินนอกงบ *********** ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
<?php //if(in_array($_REQUEST["SCTypeId"],array(3,4))){ ?>

<!--<table width="100%" border="0" cellspacing="0" cellpadding="0" >-->
<?php
//$getExName=$get->getSourceName();
foreach($getExName as $sName){
	foreach($sName as $k=>$v){
		${$k} = $v;
	}
?>
<!--</table>-->

<div class="boxfilter2"><div class="icon-topic">เงินนอกงบประมาณ [ <?php echo $SourceExName;?> ]</div></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" >
  <tr>
    <th width="6%">ลำดับ</th>
    <th width="54%">รายการกิจกรรม&nbsp;</th>
    <th width="20%" style="text-align:right">งบประมาณตัวคูณ (บาท)&nbsp;</th>
    <th width="20%" style="text-align:right">งบประมาณจำแนกเดือน (บาท)&nbsp;</th>
  </tr>
<?php
   	$d=0;
	$SumTotalCostEX=0;
	$SumTotalCostExMonth=0;	
	$detailactex = $get->getActivity($PrjDetailId);
		foreach($detailactex as $prjactdetailex){
			foreach($prjactdetailex as $k=>$v){
				${$k} = $v;
	}
		$SumCostEx=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$SourceExId);
		$SumTotalCostEX = $SumTotalCostEX + $SumCostEx;
		/*งบประมาณรายเดือน/ไตรมาส*/
		$SumCostExMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$SourceExId);
		$SumTotalCostExMonth = $SumTotalCostExMonth + $SumCostExMonth;
		/*END งบประมาณรายเดือน/ไตรมาส*/

?>
  <tr style="vertical-align:top;">
    <td style="text-align:center"><?php echo ($d+1); ?></td>
    <td><?php echo $PrjActName; ?></td>
    <td style="text-align:right">    
    <a href="?mod=<?php echo LURL::dotPage($ListViewCostEx); ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $BgtYear; ?>&PrjId=<?php echo $PrjId; ?>&PrjActId=<?php echo $PrjActId; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&SourceExId=<?php echo $SourceExId; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>">
	<?php echo number_format($SumCostEx,2); ?></a>
    </td>
    <td style="text-align:right">
    <?php if($SumCostExMonth != $SumCostEx){   echo '<span style="color:#FF0000; font-weight:bold;">!</span>';   } ?>
    <a href="?mod=<?php echo LURL::dotPage($ListViewCostMonthEx); ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $BgtYear; ?>&PrjId=<?php echo $PrjId; ?>&PrjActId=<?php echo $PrjActId; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&SourceExId=<?php echo $SourceExId; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>"><?php echo number_format($SumCostExMonth,2); ?></a>
    </td>
  </tr>
<?php
$d++;
		}
?>  

<tr>    
	<td style="text-align:right" colspan="2"><b>รวมงบประมาณทั้งสิ้น</b></td>
    <td style="text-align:right" class="txtbold"><?php echo number_format($SumTotalCostEX,2); ?></td>
    <td style="text-align:right" class="txtbold"><?php echo number_format($SumTotalCostExMonth,2); ?></td>
  </tr>
</table>

<?php } ?>

<?php
	// เงินงบประมาณแผ่นดิน+เงินนอกงบประมาณ
	//งบประมาณตัวคูณ
	$SumAllCostEx=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,$_REQUEST["PrjDetailId"],0,0,0,0);
	$TotalCost = $SumAllCostEx + $SumTotalCost;
	//งบประมาณจำแนกเดือน
	$SumTotalCostExMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,$_REQUEST["PrjDetailId"],0,0,0,0);
	$TotalCostMonth = $SumTotalCostExMonth + $SumTotalCostMonth;

?>

<div style="padding-top:5px"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" >
  <tr style="background-color:#6AAD6E; font-weight:bold">
    <td colspan="2" width="60%" style="text-align:right">เงินงบประมาณแผ่นดิน+เงินนอกงบประมาณ</td>
    <td width="20%" style="text-align:right"><?php  echo number_format($TotalCost,2); ?></td>
    <td width="20%" style="text-align:right"><?php  echo number_format($TotalCostMonth,2);?></td>
  </tr>  
</table>

<?php //*************** จบ เงินนอกงบ *********** ?>
<?php //} // end  ?>

<!--<div style="text-align:center; margin-top:10px; margin-bottom:30px;">
<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ListEditPage); ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $BgtYear; ?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"]?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"]; ?>'" />   

</div>-->
