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


<script type="text/javascript">
/*function Save(form){	
	form.submit();
}
*/
function Save(form){	
	var SumCost = parseFloat($('SumCost').value);
	var Total = $('Total').value;
	if(Total > SumCost){
		alert("คุณกรอกรายการแจงเดือน/ไตรมาส สูงกว่าที่ตั้งไว้ กรุณากรอกยอดงบแจงเดือน/ไตรมาสให้ถูกต้อง");
		return false;
	}
	if(Total < SumCost){
		alert("คุณกรอกรายการแจงเดือน/ไตรมาส น้อยกว่าที่ตั้งไว้ กรุณากรอกยอดงบแจงเดือน/ไตรมาสให้ถูกต้อง");
		return false;
	}
	form.submit();
}

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

 <?php
 $datas = $get->getActivityDetail($_REQUEST["$PrjDetailId"],$_REQUEST["PrjActId"]);
foreach($datas as $actdatas){
	foreach($actdatas as $k=>$v){
		${$k} = $v;
	}
}
?>

<?php $curProcess = $get->getCurProcess($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);//ดึงข้อมูลขั้นตอนปัจจุบันของหน่วยงาน?>
<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td align="right">
			<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ListViewCostMonth); ?>&PrjActId=<?php echo $_REQUEST["PrjActId"]; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>&CostItemCode=<?php echo $CostItemCode; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>'" />     
      </td>
    </tr>
  </table>  
</div>




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
     <tr>
     <th>ชื่อกิจกรรม</th>
      <td style="text-align:left; font-weight:bold; color:#990000;"><?php echo $PrjActName?></td> 
    </tr>
     <tr>
      <th>ระยะเวลากิจกรรม</th>
      <td><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td> 
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



<div class="boxfilter2"><div class="icon-topic">งบประมาณแผ่นดิน</div></div>

<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=savecostmonth" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>">
<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId'];?>">
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId'];?>">
<input type="hidden" name="CostIntId" id="CostIntId" value="<?php echo $_REQUEST['CostIntId'];?>">

<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>">
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST["SCTypeId"]; ?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST["ScreenLevel"]; ?>" />

<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $PrjId; ?>" />
<input type="hidden" name="CostItemCode" id="CostItemCode" value="<?php echo $_REQUEST["CostItemCode"]; ?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
 <?php 
$data = $get->getCostItemDetail($_REQUEST["CostItemCode"]);
foreach($data as $row){
	foreach($row as $k=>$v){
		${$k} = $v;
	}
}
if($_REQUEST["CostIntId"]){
	$Budget10 = $get->getCostMonth($_REQUEST["CostIntId"],10); 
	$Budget11 = $get->getCostMonth($_REQUEST["CostIntId"],11); 
	$Budget12 = $get->getCostMonth($_REQUEST["CostIntId"],12); 
	$Sum1 = $Budget10+$Budget11+$Budget12;
	$Budget1 = $get->getCostMonth($_REQUEST["CostIntId"],1); 
	$Budget2 = $get->getCostMonth($_REQUEST["CostIntId"],2); 
	$Budget3 = $get->getCostMonth($_REQUEST["CostIntId"],3); 
	$Sum2 = $Budget1+$Budget2+$Budget3;
	$Budget4 = $get->getCostMonth($_REQUEST["CostIntId"],4); 
	$Budget5 = $get->getCostMonth($_REQUEST["CostIntId"],5); 
	$Budget6 = $get->getCostMonth($_REQUEST["CostIntId"],6); 
	$Sum3 = $Budget4+$Budget5+$Budget6;
	$Budget7 = $get->getCostMonth($_REQUEST["CostIntId"],7); 
	$Budget8 = $get->getCostMonth($_REQUEST["CostIntId"],8); 
	$Budget9 = $get->getCostMonth($_REQUEST["CostIntId"],9); 
	$Sum4 = $Budget7+$Budget8+$Budget9;
	$Total = $Sum1+$Sum2+$Sum3+$Sum4;
}
?>

 <tr>
   <th style="width:200px; text-align:left">หมวดงบประมาณ</th>
   <td style="width:948px; text-align:left; font-weight:bold"><?php echo $CostTypeName; ?></td>
 </tr>
 <tr>
   <th style="width:200px; text-align:left">รายการค่าใช้จ่าย</th>
   <td style="width:948px; text-align:left; font-weight:bold"><?php if($ParentCode){ echo $get->getCostName($ParentCode)." -> "; } ?><?php echo $CostName;?></td>
 </tr>
  <tr>
   <th style="width:200px; text-align:left">งบประมาณตัวคูณ 4 ช่อง</th>
   <?php $dataCost=$get->getcost($_REQUEST["CostIntId"]); ?>
   <td style="width:948px; text-align:left; font-weight:bold">
   <input type="text"name="SumCost" id="SumCost" style="text-align:right; color:#990000;" value="<?php echo $dataCost[0]->SumCost; ?>" readonly="readonly"> 
   (<?php echo JThaiBaht::_($dataCost[0]->SumCost); ?>)
   <?php 
		   echo '<span style="color:#666; font-weight:normal;">&nbsp;(&nbsp;';
		   echo ($dataCost[0]->Unit1)?(number_format($dataCost[0]->Value1,2)."&nbsp;".$get->getUnitName($dataCost[0]->Unit1)):"N/A";
		   echo ($dataCost[0]->Unit2)?(" x&nbsp;".number_format($dataCost[0]->Value2,2)."&nbsp;".$get->getUnitName($dataCost[0]->Unit2)):"";
		   echo ($dataCost[0]->Unit3)?(" x&nbsp;".number_format($dataCost[0]->Value3,2)."&nbsp;".$get->getUnitName($dataCost[0]->Unit3)):"";
		   echo ($dataCost[0]->Unit4)?(" x&nbsp;".number_format($dataCost[0]->Value4,2)."&nbsp;".$get->getUnitName($dataCost[0]->Unit4)):"";
		    echo '&nbsp;)</span>';
		   ?>
   </td>
 </tr>
 <tr>
 		<th colspan="2" style="text-align:left;">งบประมาณแจงรายเดือน/ไตรมาส</th> 
 </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
  <tr>
    <th width="118" style="width:100px;">ไตรมาสที่ 1</th>
    <td width="94" style="width:80px; text-align:center;">ต.ค/<?php echo ($BgtYear-1); ?></td>
    <td width="177" style="width:150px;">=
      <input type="text" name="Budget10"  id="Budget10" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget10)?$Budget10:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/></td>
    <td width="94" style="width:80px; text-align:center;">พ.ย/<?php echo ($BgtYear-1); ?></td>
    <td width="177" style="width:150px;"> =
      <input type="text" name="Budget11"  id="Budget11" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget11)?$Budget11:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/></td>
    <td width="94" style="width:80px; text-align:center;">ธ.ค/<?php echo ($BgtYear-1); ?></td>
    <td width="150" style="width:150px;"> =
      <input type="text" name="Budget12"  id="Budget12" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget12)?$Budget12:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/></td>
    <td width="284" style="text-align:right;"><input type="text" name="Sum1" id="Sum1" class="number" style="width:100px;" readonly="yes" value="<?php echo ($Sum1)?$Sum1:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/> </td>
  </tr>
  <tr>
    <th>ไตรมาสที่ 2</th>
    <td style="text-align:center;">ม.ค/<?php echo $BgtYear; ?></td>
    <td>= 
      <span style="width:150px;">
      <input type="text" name="Budget1"  id="Budget1" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget1)?$Budget1:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/>
      </span></td>
    <td style="text-align:center;">ก.พ/<?php echo $BgtYear; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget2"  id="Budget2" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget2)?$Budget2:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/>
      </span></td>
    <td style="text-align:center;">มี.ค/<?php echo $BgtYear; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget3"  id="Budget3" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget3)?$Budget3:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/>
      </span></td>
    <td style="text-align:right;"><input type="text" name="Sum2" id="Sum2" class="number" style="width:100px;" readonly="readonly" value="<?php echo ($Sum2)?$Sum2:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/></td>
  </tr>
  <tr>
    <th>ไตรมาสที่ 3</th>
    <td style="text-align:center;">เม.ย/<?php echo $BgtYear; ?></td>
    <td>= 
      <span style="width:150px;">
      <input type="text" name="Budget4"  id="Budget4" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget4)?$Budget4:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/>
      </span></td>
    <td style="text-align:center;">พ.ค/<?php echo $BgtYear; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget5"  id="Budget5" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget5)?$Budget5:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/>
      </span></td>
    <td style="text-align:center;"> มิ.ย/<?php echo $BgtYear; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget6"  id="Budget6" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget6)?$Budget6:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/>
      </span></td>
    <td style="text-align:right;"><input type="text" name="Sum3" id="Sum3" class="number" style="width:100px;" readonly="readonly" value="<?php echo ($Sum3)?$Sum3:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/></td>
  </tr>
  <tr>
    <th>ไตรมาสที่ 4</th>
    <td style="text-align:center;">ก.ค/<?php echo $BgtYear; ?></td>
    <td>= 
      <span style="width:150px;">
      <input type="text" name="Budget7"  id="Budget7" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget7)?$Budget7:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/>
      </span></td>
    <td style="text-align:center;">ส.ค/<?php echo $BgtYear; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget8"  id="Budget8" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget8)?$Budget8:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/>
      </span></td>
    <td style="text-align:center;">ก.ย/<?php echo $BgtYear; ?></td>
    <td> =
      <span style="width:150px;">
      <input type="text" name="Budget9"  id="Budget9" class="number" style="width:100px;" onkeyup="CalSum()" value="<?php echo ($Budget9)?$Budget9:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"/>
      </span></td>
    <td style="text-align:right;"><input type="text" name="Sum4" id="Sum4" class="number" style="width:100px;" readonly="readonly" value="<?php echo ($Sum4)?$Sum4:0; ?>" title="กรอกงบประมาณเป็นตัวเลข 0-9 ตัวอย่าง เช่น 1000"  /></td>
    </tr>
    <tr>
    <td colspan="7" style="text-align:right; font-weight:bold;" align="right">&nbsp;</td>
    <td style="text-align:right; font-weight:bold;">รวมทั้งสิ้น <span style="text-align:right;">
      <input type="text" name="Total" id="Total" class="number" style="width:100px; color:#990000;" readonly="readonly" value="<?php echo ($Total)?$Total:0; ?>"  title="ผลรวมงบประมาณทั้งสิ้น 0-9 ตัวอย่าง เช่น 1000" />
    </span></td>
    </tr>
</table>

<div style="text-align:center; margin-top:10px; margin-bottom:30px;">
<input type="submit" class="btnActive" name="save" id="save" value="บันทึก"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ListViewCostMonth); ?>&PrjActId=<?php echo $_REQUEST["PrjActId"]; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>&CostItemCode=<?php echo $CostItemCode; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>'" />  
</div>
</form>

<script>
function CalSum(){
	
	
	var Month10 = $('Budget10').value;
	var Month11 = $('Budget11').value;
	var Month12 = $('Budget12').value;
	var Budget1 = (Month10*1)+(Month11*1)+(Month12*1);
		
	var Month1 = $('Budget1').value;
	var Month2 = $('Budget2').value;
	var Month3 = $('Budget3').value;
	var Budget2 = (Month1*1)+(Month2*1)+(Month3*1);
	
	var Month4 = $('Budget4').value;
	var Month5 = $('Budget5').value;
	var Month6 = $('Budget6').value;
	var Budget3 = (Month4*1)+(Month5*1)+(Month6*1);
	
	var Month7 = $('Budget7').value;
	var Month8 = $('Budget8').value;
	var Month9 = $('Budget9').value;
	var Budget4 = (Month7*1)+(Month8*1)+(Month9*1);
	
	var Total = (Budget1*1)+(Budget2*1)+(Budget3*1)+(Budget4*1);
	
	$('Sum1').value = Budget1;
	$('Sum2').value = Budget2;
	$('Sum3').value = Budget3;
	$('Sum4').value = Budget4;
	$('Total').value = Total;

}
</script>
