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
//Detail
function ValidateForm(form){
	
/*	JQ("input[name^='Detail']").each(function(){
	alert(JQ(this).val());	
	});
	
	var checkprj = false;
	JQ("input[name^='Detail']").each(function(){
		//alert($(this).val());		
		if(JQ(this).val() == ""){ checkprj = false; }else{ checkprj = true; }

	});
			
	if(!checkprj){ 
		jAlert('กรุณาระบุรายการชี้แจง','ระบบตรวจสอบข้อมูล');
		return false;
	}*/

	return true;

}

function Save(form){	
	//form.submit(); 
	/*if(ValidateForm(form)){	
		if(<?=$_REQUEST["SCTypeId"];?> == 1){
			 form.submit(); 
		}else{
			var sum =0;
			JQ('input[rel=SumCost]').each(function(){
				num = parseFloat(JQ(this).val());
				if( !isNaN(num)) sum = sum + num; 
			});
			var TotalPrj = parseFloat(sum) + parseFloat(JQ('#SumBGTotal').val());
			if(JQ('#sumAllot').val() >= TotalPrj){ form.submit(); }else{ alert('ยอดรวมแจงตัวคูณ 4 ช่องต้องไม่เกินยอดงบกลั่นกรอง / จัดสรร / งบปรับระหว่างปี'); }
		}
	}*/
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
// ltxt::print_r($datas);
foreach($datas as $actdatas){
	foreach($actdatas as $k=>$v){
		${$k} = $v;
	}
}


$data = $get->getCostItemDetail($_REQUEST["CostItemCode"]);
//ltxt::print_r($data);
foreach($data as $row){
	foreach($row as $k=>$v){
		${$k} = $v;
	}
}

//getTotalPrj($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0,$CostItemCode=0,$ParentCode=0,$CostTypeId=0,$LevelId=0,$HasChild="")

// งบโครงการ
$SumBGPrj=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);				

// งบประมาณแผ่นดิน
$AllBGTotal=$get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
		
// งบกลั่นกรอง		
$sumAllot = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);

// งบโครงการไม่รวมกิจกรรมนี้
$SumBGOtherAct=$get->getCostPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0);

// งบโครงการกิจกกรรมนี้ แต่ไม่รวมรายการค่าใช้จ่ายนี้
$SumBGThisAct=$get->getCostPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$CostItemCode);

$SumBGTotal=$SumBGOtherAct+$SumBGThisAct;
//echo "SumBGTotal=".$SumBGTotal;

?>

<?php $curProcess = $get->getCurProcess($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);//ดึงข้อมูลขั้นตอนปัจจุบันของหน่วยงาน?>
<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td align="right">
		<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ViewCost); ?>&PrjId=<?php echo $PrjId; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>&PrjActId=<?php echo $_REQUEST["PrjActId"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>&BgtYear=<?php echo $_REQUEST['BgtYear']; ?>'" />    
      </td>
    </tr>
  </table>  
</div>


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
     <tr>
     <th>ชื่อกิจกรรม</th>
      <td style="text-align:left; font-weight:bold; color:#990000;"><?php echo $PrjActName?></td> 
    </tr>
     <tr>
      <th>ระยะเวลากิจกรรม</th>
      <td><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td> 
    </tr>
</table>


<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=savecostin" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $BgtYear;?>">
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>">
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST["SCTypeId"]; ?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST["ScreenLevel"]; ?>" />
<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $PrjId; ?>" />



<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view"  style="margin-bottom:0px;" >
  <tr>
 <td colspan="2" style="padding:0px;"><div class="boxfilter2"><div class="icon-topic">งบประมาณแผ่นดิน</div></div></td>
 </tr>
 <tr>
    <th style="text-align:left">หมวดงบประมาณ</th>
    <td style="text-align:left; font-weight:bold;"><?php echo $CostTypeName; ?></td>
  </tr>
  <tr>
    <th style="text-align:left">รายการค่าใช้จ่าย</th>
    <td style="text-align:left; font-weight:bold;"><?php if($ParentCode){ echo $get->getCostName($ParentCode)." -> "; } ?><?php echo $CostName;?></td>
  </tr>  
</table>


<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
	<tr>
		<th rowspan="2" style="width:20%">รายการชี้แจง</th>
		<th colspan="2" >ปริมาณ1</th>
		<th colspan="2" >ปริมาณ2</th>
		<th colspan="2" >ปริมาณ3</th>
		<th colspan="2" >ปริมาณ4</th>
		<th rowspan="2" style="width:120px;">งบประมาณ (บาท)</th>
		<th rowspan="2" style="width:50px;">ลบทิ้ง</th>
    </tr>
	<tr>
		<th style="width:60px;">จำนวน</th>
		<th style="width:80px;">หน่วยนับ</th>
		<th style="width:60px;">จำนวน</th>
		<th style="width:80px;">หน่วยนับ</th>
		<th style="width:60px;">จำนวน</th>
		<th style="width:80px;">หน่วยนับ</th>
		<th style="width:60px;">จำนวน</th>
		<th style="width:80px;">หน่วยนับ</th>
	</tr>
 </table>

<?php
$actList = $get->getItemRequireInternal($CostItemCode,$_REQUEST["PrjActId"]);
//ltxt::print_r($actList);
 if($actList){
     $count = 1;
        foreach($actList as $r){
            foreach( $r as $k=>$v){ ${$k} = $v;}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list"  id="tbl<?php echo $count; ?>">
	<tr>
		<td style="text-align:center; width:20%;"><input type="text" name="Detail[]"  id="Detail" value="<?php echo $Detail; ?>" style="width:95%" /><input type="hidden" name="CostIntId[]" id="CostIntId" value="<?php echo $CostIntId;?>"></td>
        
		<td style="text-align:center; width:60px;"><input type="text" name="Value1[]" id="Value1"  rel="Value1"  class="number" onkeyup="CalSum()"  value="<?php echo $Value1; ?>" style="width:95%; text-align:right" /></td>
		<td style="text-align:center; width:80px;"><?php  echo $get->getUnitList($Unit1,"Unit1[]"); ?></td>
        
		<td style="text-align:center; width:60px;"><input type="text" name="Value2[]" id="Value2"  rel="Value2"  class="number" onkeyup="CalSum()"  value="<?php echo $Value2; ?>" style="width:95%; text-align:right" /></td>
		<td style="text-align:center; width:80px;"><?php  echo $get->getUnitList($Unit2,"Unit2[]"); ?></td>
        
		<td style="text-align:center; width:60px;"><input type="text" name="Value3[]" id="Value3"  rel="Value3"  class="number" onkeyup="CalSum()"  value="<?php echo $Value3; ?>" style="width:95%; text-align:right" /></td>
		<td style="text-align:center; width:80px;"><?php  echo $get->getUnitList($Unit3,"Unit3[]"); ?></td>
        
		<td style="text-align:center; width:60px;"><input type="text" name="Value4[]" id="Value4"  rel="Value4"  class="number" onkeyup="CalSum()"  value="<?php echo $Value4; ?>" style="width:95%; text-align:right" /></td>
		<td style="text-align:center; width:80px;"><?php  echo $get->getUnitList($Unit4,"Unit4[]"); ?></td>
        
		<td style="text-align:center; width:120px;"><input type="text" name="SumCost[]"  id="SumCost"  rel="SumCost" value="<?php echo $SumCost; ?>"  class="number" style="width:95%; text-align:right" readonly="readonly" />        
        </td>
		<td style="text-align:center; width:50px; ">
         <a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php echo $count; ?>').remove();  }" class="ico delete" >ลบทิ้ง</a>
        </td>        
	</tr>
 </table>
    
<?php				
			$count++;
		}
	}
?> 


    
    

<?php if(!empty($actList)){ $CItem = $count; }else{ $CItem = 1; } ?>

<div id="ListItems"></div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list"  id="tbl<?php echo $count; ?>">
	<tr style="font-weight:bold;">
		<td style="text-align:right;">
        ( <span id="totalText" style="font-weight:normal;"><?php echo JThaiBaht::_($get->getTotalPrjInternalX4($BgtYear,0,0,$PrjId,$PrjDetailId,$PrjActId,0,0,$_REQUEST["CostItemCode"])); ?></span> )
       <b>รวมทั้งสิ้น</b>  
        </td>
		<td style="text-align:center; width:120px;"><span id="total"><?php echo number_format($get->getTotalPrjInternalX4($BgtYear,0,0,$PrjId,$PrjDetailId,$PrjActId,0,0,$_REQUEST["CostItemCode"]),2); ?></span>&nbsp;
        </td>
        <td style="width:50px;">บาท</td>
	</tr>
 </table>	



<script>
var CountItem = <?php echo $CItem; ?>;

<?php if(empty($actList)){  ?>

JQ(document).ready(function(){
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('project_cost_add_internal_item');?>&format=raw&num=' + CountItem,
				   success: function(data){
					   CountItem = CountItem + 1;
					  JQ('#ListItems').append(data);
				   }
			 });	

});
<?php } ?>

function AddItem()
{
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('project_cost_add_internal_item');?>&format=raw&num=' + CountItem,
				   success: function(data){
					   CountItem = CountItem + 1;
					  JQ('#ListItems').append(data);
				   }
			 });	
}
</script>    
    
    <div align="right">
    <a href="javascript:void(0);" onclick="AddItem();" class="ico add">เพิ่มรายการ...</a>
    </div>



<input type="hidden" name="SumBGTotal" id="SumBGTotal" value="<?php echo ($SumBGTotal)?$SumBGTotal:0;?>" rel="SumBGTotal">
<input type="hidden" name="sumAllot" id="sumAllot" value="<?php echo ($sumAllot)?$sumAllot:0;?>">

<input type="hidden" name="CostTypeId" id="CostTypeId" value="<?php echo $CostTypeId; ?>" />
<input type="hidden" name="CostItemCode" id="CostItemCode" value="<?php echo $CostItemCode; ?>" />
<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId'];?>">
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId'];?>">

<div style="text-align:center; margin-top:10px; margin-bottom:30px;">
<input type="submit" class="btnRed" name="save" id="save" value="บันทึก"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ListViewCost); ?>&PrjActId=<?php echo $_REQUEST["PrjActId"]; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>&CostItemCode=<?php echo $CostItemCode; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>'" />    </td>
</div>

</form>



<script>

function CalSum(){
	var sumTotal=0;
	var Value1 = $(document.body).getElements('input[rel=Value1]');
	var Value2 = $(document.body).getElements('input[rel=Value2]');
	var Value3 = $(document.body).getElements('input[rel=Value3]');
	var Value4 = $(document.body).getElements('input[rel=Value4]');
	var SumCost = $(document.body).getElements('input[rel=SumCost]');
	SumCost.each(function(item,index){
		var Val1 = parseFloat(Value1[index].value);
		var Val2 = parseFloat(Value2[index].value);
		var Val3 = parseFloat(Value3[index].value);
		var Val4 = parseFloat(Value4[index].value);
		//item.value = parseFloat(Val1*Val2*Val3*Val4).Money(2);
		item.value = parseFloat(Val1*Val2*Val3*Val4);
		sumTotal += parseFloat(Val1*Val2*Val3*Val4);
	});
	
	var sum =0;
	JQ('input[rel=SumCost]').each(function(){
		num = parseFloat(JQ(this).val());
		if( !isNaN(num)) sum = sum + num; 
	});	
	
	var sumprj = parseFloat(JQ('#SumBGTotal').val())+parseFloat(sum);
	
	var totalprj = sumprj.Money(2);
	var total = sumTotal.Money(2);
	$('total').set('html',total);
	$('totalText').set('html',JThaiBaht(total));
	
	<?php  if(in_array($_REQUEST["SCTypeId"],array(2,3,4))){ ?>  
	$('totalprj').set('html',totalprj);
	<?php } ?>
	
	
}

</script>





