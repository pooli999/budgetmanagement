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


 <?php
 $datas = $get->getDetailPrj($_REQUEST["PrjId"]);
// ltxt::print_r($datas);
foreach($datas as $actdatas){
	foreach($actdatas as $k=>$v){
		${$k} = $v;
	}
}
?>

<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right">
      	<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ListEditPage); ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $BgtYear; ?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"]?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"]; ?>'" />
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
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
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




<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;">
  <tr>
    <th style="width:30px;">ลำดับ</td>
    <th >รายการกิจกรรม/ตัวชี้วัด&nbsp;</td>
    <th style="width:120px;">ประเภทตัวชี้วัด    
    <th style="width:100px;">ค่าเป้าหมาย    
    <th style="width:120px;">หน่วยนับ&nbsp;</td>
  <th colspan="2" style="width:70px;">ปฎิบัติการ  &nbsp;</tr>
  <?php 
  	$i=0;
	$SumTotalCost=0;
	$SumTotalCostMonth=0;/*ผลรวมงบประมาณรายเดือน/ไตรมาส*/
	$detailact = $get->getActivity($PrjDetailId); //ltxt::print_r($detailact);
foreach($detailact as $prjactdetail){
	foreach($prjactdetail as $k=>$v){
		${$k} = $v;
	}
		$SumCost=$get->getTotalPrj($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["PItemCode"],$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],$PrjActId);
		$SumTotalCost = $SumTotalCost + $SumCost;
		
		/*งบประมาณรายเดือน/ไตรมาส*/
		$SumCostMonth=$get->getTotalPrj($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["PItemCode"],$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],$PrjActId);
		$SumTotalCostMonth = $SumTotalCostMonth + $SumCostMonth;
		/*END งบประมาณรายเดือน/ไตรมาส*/
		
		// จำนวนตัวชี้วัด
		$listtInd = $get->getIndicatorActSelect($PrjActId);
		$countInd = count($listtInd);
  ?>
  <tr style="background-color:#EEE;">
    <td style="text-align:center"><?php echo ($i+1); ?></td>
    <td><?php echo $PrjActName; ?></td>
    <td width="120" style="text-align:right">&nbsp;</td>
    <td width="120" style="text-align:right">&nbsp;</td>
    <td width="120" style="text-align:right">&nbsp;</td>
    <td width="120" style="text-align:center"><a class="ico edit" href="?mod=<?php echo LURL::dotPage($EditInd); ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&PrjId=<?php echo $_REQUEST["PrjId"]; ?>&PrjActId=<?php echo $PrjActId; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>">ตัวชี้วัด</a></td>
    <td width="120" style="text-align:center"><a class="ico edit" href="?mod=<?php echo LURL::dotPage($Edit1Ind); ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&PrjId=<?php echo $_REQUEST["PrjId"]; ?>&PrjActId=<?php echo $PrjActId; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>">WorkSpace</a></td>
  </tr>
  
  
  
  
  
<!--รายการตัวชี้วัดของกิจกรรม-->
<?php 
$d=0;
$indicatorSelect = $get->getIndicatorActSelect($PrjActId);//ltxt::print_r($indicatorSelect);
 if($indicatorSelect){
     foreach($indicatorSelect as $r){
    	 foreach( $r as $k=>$v){ ${$k} = $v;}
	 
?>
<tr>
    <td style="text-align:center;">&nbsp;</td>
    <td><?php echo ($i+1); ?>.<?php echo ($d+1); ?>&nbsp;<?php echo $IndicatorName; ?></td>
     <td style="text-align:center;"><?php echo $IndTypeName; ?></td>
    <td style="text-align:center;"><?php echo $Value; ?></td>
    <td><?php echo $UnitName; ?></td>
    <td style="text-align:center;"><a class="icon-month" href="?mod=<?php echo LURL::dotPage('project_edit_ind_month'); ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&PrjId=<?php echo $_REQUEST["PrjId"]; ?>&PrjActId=<?php echo $PrjActId; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&PrjActIndId=<?php echo $PrjActIndId; ?>">แจงเดือน</a></td>
    <td style="text-align:center;">&nbsp;</td>
  </tr>
<?php 
	$d++;
	} 
}
?>
<!--รายการตัวชี้วัดของกิจกรรม-->  
  
  
  
  
  
  
  
  
  
   <?php
$i++;
}
?>  
</table>


<!--<div style="text-align:center; margin-top:10px; margin-bottom:30px;">
<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ListEditPage); ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $BgtYear; ?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"]?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"]; ?>'" />
</div>-->
