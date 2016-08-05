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

function icoEdit($r){
	$label = 'แก้ไขข้อมูล';
	$text = '&nbsp;';
	global $addPage;
/*	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage('project_ind_add')."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']." '",
		'ico edit',
		$label,
		$text
	));
*/	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage('project_ind_add')."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']."&PrjIndId=".$r->PrjIndId." '",
		'ico edit',
		$label,
		$text
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	$text = '&nbsp;';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:if(confirm('คุณต้องการลบข้อมูลหรือไม่')) self.location='?mod=".LURL::dotPage($actionPage)."&action=delete&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']." '",
		'ico delete',
		$label,
		$text
	));
}

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
        <input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="history.back(-1);" />
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


<div style="background-color:#EEE; padding:8px;">
<input type="button" name="add" value="เพิ่มตัวชี้วัดโครงการ" onclick="window.location.href='?mod=<?php echo LURL::dotPage('project_ind_add');?>&start=<?php echo $_REQUEST["start"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&PrjId=<?php echo $_REQUEST["PrjId"]; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"]; ?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"]; ?> '" />
</div>





<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;">
  <tr>
    <th style="width:30px;">ลำดับ</th>
    <th style="width:120px;">รหัสตัวชี้วัด</th>
    <th >ตัวชี้วัดโครงการ</th>
    <th style="width:100px;">ประเภทฯ</th>
    <th style="width:100px;">ค่าเป้าหมาย</th>   
    <th style="width:120px;">หน่วยนับ</th>
  <th colspan="2">ปฎิบัติการ</th>  
  </tr>
  <?php 
  $i=1;
    $indicatorSelect = $get->getIndicatorSelect($_REQUEST["PrjDetailId"]);//ltxt::print_r($indicatorSelect);
     if($indicatorSelect){
            foreach($indicatorSelect as $r){
                foreach( $r as $k=>$v){ ${$k} = $v;}
         
    ?>
        <tr style="vertical-align:top;">
          <td style="text-align:center;"><?php echo $i; ?></td>
          <td style="text-align:center;"><?php echo $IndicatorCode; ?></td>
          <td>
		  <a href="?mod=<?php echo LURL::dotPage('project_ind_view'); ?>&PrjIndId=<?php echo $PrjIndId; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&PrjId=<?php echo $_REQUEST["PrjId"]; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"]; ?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"]; ?>"><?php echo $IndicatorName;?></a>
          </td>
          <td style="text-align:center;">
<?php
switch($CriterionType){
	case "quantity":
		echo "เชิงปริมาณ";
	break;
	case "quality":
		echo "เชิงคุณภาพ";
	break;
}
?>
          </td>
          <td style="text-align:center;">
<?php
switch($CriterionType){
	case "quantity":
		echo $QTTGPlan;
	break;
	case "quality":
		echo $QLTGPlan;
	break;
}
?>
          </td>
          <td style="text-align:center;"><?php echo $UnitName;?></td>
          <td style="text-align:center; width:25px;"><?php echo icoEdit($r); ?></td>
    <td style="text-align:center; width:25px;"><?php echo icoDelete($r); ?></td>
        </tr>
        <?php		
				$i++;		
            }
        }else{
	?>
        <tr>
          <td colspan="8" style="text-align:center; height:30px; background-color:#FFF;" ><span style="color:#999;">-ไม่ระบุ-</span></td>
        </tr>
        <?php	
		}
    ?>
      </table>










<div style="text-align:center; margin-top:10px; margin-bottom:30px;">
<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ListEditPage); ?>&BgtYear=<?php echo $BgtYear; ?>'" />
<!--<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ListEditPage); ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $BgtYear; ?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"]?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"]; ?>'" />-->
</div>
