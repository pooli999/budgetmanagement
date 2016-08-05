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
	VSROOT.'modules/backoffice/budget/style_budget.css'
));


/*echo "BgtYear=".$_REQUEST["BgtYear"];
echo "OrganizeCode=".$_REQUEST["OrganizeCode"];
echo "SCTypeId=".$_REQUEST["SCTypeId"];
echo "ScreenLevel=".$_REQUEST["ScreenLevel"];*/

//$allot = $get->getAllotDetail($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0);
//$adjustDetail = $get->getAllotDetail($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],5,0);


$allot = $get->getAllotDetail($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,0,0,$_REQUEST["PrjActCode"]);
//ltxt::print_r($allot);

$adjustDetail = $get->getAllotDetail($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);
//ltxt::print_r($adjustDetail);



//$scLevel = $get-> getScreenLevel($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);
//ltxt::print_r($scLevel);


?>
<script type="text/javascript">


function showHide(i){
	if(JQ('#body-cate'+i).is(':hidden')===true){
		JQ('#body-cate'+i).show('slow');
		JQ('#a-cate'+i).addClass('icon-decre');
		JQ('#a-cate'+i).removeClass('icon-incre');
		JQ('#a-cate'+i).html('ย่อ');
	}else{
		JQ('#body-cate'+i).hide('slow');
		JQ('#a-cate'+i).removeClass('icon-decre');
		JQ('#a-cate'+i).addClass('icon-incre');
		JQ('#a-cate'+i).html('ขยาย');
	}
}


function CalCostSumExBGIncrease(SourceExId,CostItemCode){
	
				var sumEx =0;
				
				 JQ('input[rel=RelExBGIncrease'+SourceExId+']').each(function(){
						 numEx = parseFloat(JQ(this).val());
						 if( !isNaN(numEx)) sumEx = sumEx + numEx; 
				 });
				 
				 JQ('#totalExBGIncrease'+SourceExId).val(sumEx);
}

function CalCostSumExBGDecrease(SourceExId,CostItemCode){
	
				var sumEx =0;
				
				 JQ('input[rel=RelExBGDecrease'+SourceExId+']').each(function(){
						 numEx = parseFloat(JQ(this).val());
						 if( !isNaN(numEx)) sumEx = sumEx + numEx; 
				 });
				 
				 JQ('#totalExBGDecrease'+SourceExId).val(sumEx);
}


function CalCostSumDecrease(CostItemCode){

				var sum =0;
				
				 JQ('input[rel=RelBGDecrease]').each(function(){
						 num = parseFloat(JQ(this).val());
						 if( !isNaN(num)) sum = sum + num; 
				 });
				 
				 JQ('#totalBGDecrease').val(sum);
					
}

function CalCostSumBGIncrease(CostItemCode){

				var sumIn =0;
				
				 JQ('input[rel=RelBGIncrease]').each(function(){
						 numIn = parseFloat(JQ(this).val());
						 if( !isNaN(numIn)) sumIn = sumIn + numIn; 
				 });
				 
				 JQ('#totalBGIncrease').val(sumIn);
					
}

function CheckInput(CostItemCode,sumRemain){
	
	//alert(sumRemain);
/*	var BGIncrease = JQ('#BGIncrease'+CostItemCode).val();
		
	if(sumRemain > BGIncrease){
			alert('กรุณาตรวจสอบงบปรับกลางปีต้องมากกว่าหรือเท่ากับงบตัดจ่าย');	
			JQ('#BGIncrease'+CostItemCode).focus();
	}*/
	
/*	var BGIncrease = JQ('#BGIncrease'+CostItemCode).val();
	var sumRemainLevel = JQ('#sumRemainLevel'+CostItemCode).val();
	if(parseFloat(sumRemainLevel)>parseFloat(BGIncrease)){
			alert('กรุณาตรวจสอบงบปรับกลางปีต้องมากกว่าหรือเท่ากับงบตัดจ่าย');	
			JQ('#BGIncrease'+CostItemCode).focus();
			
	}*/
	
}

function SaveAdjust(form){	


	if(JQ('#totalBGIncrease').val() >= parseFloat(1)){
   			 form.submit();
	}else{
	
		alert('กรุณาตรวจสอบปรับกลางปีต้องมากกว่าศูนย์');	
		JQ('#totalBGIncrease').focus();
	}

}





</script>

<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
  <tr>
    <th style="width:20%; text-align:left">ปีงบประมาณ</th>
    <td  style="width:80%; text-align:left; font-weight:bold"><?php echo $_REQUEST['BgtYear'];?></td>
  </tr>
  <tr>
    <th style="text-align:left">หน่วยงาน</th>
    <td  style="text-align:left; font-weight:bold"><?php echo $get->getOrganizeName($_REQUEST["OrganizeCode"]);?></td>
  </tr>
  <tr>
    <th style="text-align:left">โครงการ</th>
    <td  style="text-align:left; font-weight:bold"><?php echo $get->getPrjName($_REQUEST["PrjId"]);?></td>
  </tr>
  <tr>
    <th style="text-align:left">กิจกรรม</th>
    <td  style="text-align:left; font-weight:bold"><?php echo $get->getPrjActName($_REQUEST["PrjActId"]);?></td>
  </tr>   
</table>
<br />


<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=saveadjust" onSubmit="SaveAdjust(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear']?>" />
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode']?>" />
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST['SCTypeId']?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST['ScreenLevel']?>" />

<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId']?>" />
<input type="hidden" name="PrjActCode" id="PrjActCode" value="<?php echo $_REQUEST['PrjActCode']?>" />
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId']?>" />
<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $_REQUEST['PrjId']?>" />

<input type="hidden" name="AllotId" id="AllotId" value="<?php echo $adjustDetail[0]->AllotId; ?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<td  style="padding-left:20px">งบประมาณแผ่นดิน</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;"  >
  <tr>
    <th rowspan="2" style="width:30%">หมวดงบ/รายการงบรายจ่าย</th>
    <th rowspan="2" style="text-align:right; width:10%">งบจัดสรร (บาท)</th>
    <th colspan="4" style="text-align:center; width:40%">งบตัดจ่าย</th>
    <th rowspan="2" style="text-align:right; width:10%">งบคงเหลือ (บาท)</th>
    <th rowspan="2" style="text-align:center; width:10%">งบปรับกลางปี (บาท)</th>
    </tr>
  <tr>
    <th style="text-align:right; width:10%">งบหลักการ (บาท)</th>
    <th style="text-align:right; width:10%">งบผูกพัน (บาท)</th>
    <th style="text-align:right; width:10%">งบจ่ายจริง (บาท)</th>
    <th style="text-align:right; width:10%">รวมทั้งสิ้น (บาท)</th>
    </tr>
  <!--วน loop หมวดงบรายจ่าย-->
  <?php
  $NumCate = 1; 
  $BGCate = $get->getCostTypeRecordSet();
  //ltxt::print_r($BGCate);
  foreach($BGCate as $BGCateRow){ 
  	foreach($BGCateRow as $a=>$b){
		${$a} = $b;
	}
	
	//งบจัดสรร	
	$sumBGAllotType = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,0,0,$CostTypeId,0,0,$allot[0]->PrjDetailId,$allot[0]->PrjActId,$allot[0]->PrjActCode);
	
	//งบหลักการ
	$sumBGStatemenType = 0;
	
	//งบผูกพัน
	$sumHoldType = 0;
	
	//งบจ่ายจริง
	$sumPayType = 0;
	
	//งบรวมตัดจ่าย (รวมทั้งสิ้น)
	$sumRemainPayType = $sumBGStatemenType + $sumHoldType + $sumPayType;
	
	//งบคงเหลือ
	$sumRemainType = $sumBGAllotType - $sumRemainPayType;
	
	
	//$sumBGStatementType = 0;
	//$sumPayType = 0;
	//$sumRemainType = $sumBGAllotType - $sumBGStatementType - $sumPayType;
	
  ?>
  <tr class="cate">
    <td><?php echo $NumCate; ?>. <?php echo $CostTypeName; ?> | <a href="javascript:void(0)" id="a-cate<?php echo $NumCate; ?>" onclick="showHide(<?php echo $NumCate; ?>);" class="icon-decre txt-normal">ย่อ</a></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumBGAllotType,2)?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumHoldType,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumHoldLevel1,2)?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumPayType,2)?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumRemainPayType,2)?></td>
    <td align="right" style="text-align:right; font-weight:bold"><?php echo number_format($sumRemainType,2);?>
<!--  <input name="sumRemainType" id="sumRemainType" value="<?php echo number_format($sumRemainType,2);?>"    readonly="readonly"   style="background-color:#EDEB82; width:95%; text-align:right">-->
    </td>
    <td align="right" style="text-align:center">&nbsp;</td>
  </tr>
  
  <tbody id="body-cate<?php echo $NumCate; ?>">
  <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
   <?php
  $NumLevel1 = 1; 
  $BGLevel1 = $get->getCostItemRecordSet($CostTypeId);
  //ltxt::print_r($BGLevel1);
  foreach($BGLevel1 as $BGLevel1Row){ 
  	foreach($BGLevel1Row as $c=>$d){
		${$c} = $d;
	}
	
	//งบจัดสรร
	$sumBGAllotLevel1 = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$allot[0]->PrjDetailId,$allot[0]->PrjActId,$allot[0]->PrjActCode);
	
	//งบหลักการ
	$sumBGStatementLevel1 = 0;
	
	//งบผูกพัน
	$sumHoldLevel1 = 0;
	
	//งบจ่ายจริง
	$sumPayLevel1 = 0;
	
	//งบรวมตัดจ่าย (รวมทั้งสิ้น)
	$sumRemainPayLevel1 = $sumBGStatementLevel1 + $sumHoldLevel1 + $sumPayLevel1;
	
	//งบคงเหลือ
	$sumRemainLevel1 = $sumBGAllotLevel1 - $sumRemainPayLevel1;
	
	//งบจัดสรรกลางปี	
	$BGInternalLevel1 = $get->getTotalBGIncreaseInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],5,0,$adjustDetail[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);
	//ltxt::print_r($BGInternalLevel1);
	
	//$sumAdjustLevel1 = ($sumRemainLevel1 + $BGInternalLevel1[0]->ValBGIncrease) - $BGInternalLevel1[0]->ValBGDecrease;
	
  ?>
  <tr class="level1">
    <td style="text-indent:10px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?> <?php echo " / ".$CostItemCode;?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumBGAllotLevel1,2)?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumBGStatementLevel1,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumHoldLevel1,2)?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumPayLevel1,2)?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumRemainPayLevel1,2)?></td>
    <td align="right" style="text-align:right">
    <?php echo number_format($sumRemainLevel1,2);?>
    <?php if($HasChild == 'N'){ ?>
	<input type="hidden" name="sumRemainLevel[]" id="sumRemainLevel<?=$CostItemCode?>"  value="<?php echo $sumRemainLevel1;?>" /> 
    <?php } ?>
    </td>
    <td align="right" style="text-align:center">
<?php if($HasChild == 'N'){ ?>
<input type="hidden" name="CostItemCode[]" id="CostItemCode" value="<?php echo $CostItemCode; ?>" />
    <input name="BGIncrease[]"  id="BGIncrease<?=$CostItemCode?>" rel="RelBGIncrease"   type="text"  value="<?php  echo number_format($BGInternalLevel1[0]->ValBGIncrease,2,'.','');?>"   onkeyup="CalCostSumBGIncrease('<?php echo $CostItemCode; ?>');CheckInput('<?php echo $CostItemCode; ?>','<?php echo $sumRemainLevel1;?>')" onKeyPress="return validChars(event,2)"  class="number-normal"  />  
    <?php } ?>    
    </td>
    </tr>
  
  <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->  
  <?php if($HasChild == Y){ ?>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 2-->
   <?php
  $NumLevel2 = 1; 
  $BGLevel2 = $get->getCostItemRecordSet($CostTypeId,2,$CostItemCode);
  foreach($BGLevel2 as $BGLevel2Row){ 
  	foreach($BGLevel2Row as $e=>$f){
		${$e} = $f;
	}
	
	//งบจัดสรร	
	$sumBGAllotLevel2 = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$allot[0]->PrjDetailId,$allot[0]->PrjActId,$allot[0]->PrjActCode);
	
	
	//งบหลักการ
	$sumBGStatementLevel2 = 0;
	
	//งบผูกพัน
	$sumHoldLevel2 = 0;
	
	//งบจ่ายจริง
	$sumPayLevel2 = 0;
	
	//งบรวมตัดจ่าย (รวมทั้งสิ้น)
	$sumRemainPayLevel2 = $sumBGStatementLevel2 + $sumHoldLevel2 + $sumPayLevel2;
	
	//งบคงเหลือ
	$sumRemainLevel2 = $sumBGAllotLevel2 - $sumRemainPayLevel2;
	
	//งบจัดสรรกลางปี
	$BGInternalLevel2 = $get->getTotalBGIncreaseInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],5,0,$adjustDetail[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);
	
	//$sumAdjustLevel2 = ($sumRemainLevel2 + $BGInternalLevel2[0]->ValBGIncrease) - $BGInternalLevel2[0]->ValBGDecrease;


  ?>
  <tr class="level2">
    <td style="text-indent:20px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?> <?php echo " / ".$CostItemCode;?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumBGAllotLevel2,2);?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumBGStatementLevel2,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumHoldLevel2,2)?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumPayLevel2,2)?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumRemainPayLevel2,2)?></td>
    <td align="right" style="text-align:right">
    <?php echo number_format($sumRemainLevel2,2);?>
    <?php if($HasChild == 'N'){ ?>
	<input type="hidden" name="sumRemainLevel[]" id="sumRemainLevel<?=$CostItemCode?>"  value="<?php echo $sumRemainLevel2;?>"  />
    <?php } ?> 
    </td>
    <td align="right" style="text-align:center">
<?php if($HasChild == 'N'){ ?>
<input type="hidden" name="CostItemCode[]" id="CostItemCode" value="<?php echo $CostItemCode; ?>" />
    <input name="BGIncrease[]"  id="BGIncrease<?=$CostItemCode?>" rel="RelBGIncrease"   type="text"   value="<?php  echo number_format($BGInternalLevel2[0]->ValBGIncrease,2,'.','');?>"  onkeyup="CalCostSumBGIncrease('<?php echo $CostItemCode; ?>');CheckInput('<?php echo $CostItemCode; ?>','<?php echo $sumRemainLevel1;?>')"  onKeyPress="return validChars(event,2)"  class="number-normal"  />  
    <?php } ?>         
    </td>
    </tr>
  
  
  
  <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->  
  <?php if($HasChild == Y){ ?>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 3-->
   <?php
  $NumLevel3 = 1; 
  $BGLevel3 = $get->getCostItemRecordSet($CostTypeId,3,$CostItemCode);
  //ltxt::print_r($BGLevel3);
  foreach($BGLevel3 as $BGLevel3Row){ 
  	foreach($BGLevel3Row as $g=>$h){
		${$g} = $h;
	}
	
	//งบจัดสรร	
	$sumBGAllotLevel3 = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$allot[0]->PrjDetailId,$allot[0]->PrjActId,$allot[0]->PrjActCode);
		
	//งบหลักการ
	$sumBGStatementLevel3 = 0;
	
	//งบผูกพัน
	$sumHoldLevel3 = 0;
	
	//งบจ่ายจริง
	$sumPayLevel3 = 0;
	
	//งบรวมตัดจ่าย (รวมทั้งสิ้น)
	$sumRemainPayLevel3 = $sumBGStatementLevel3 + $sumHoldLevel3 + $sumPayLevel3;
	
	//งบคงเหลือ
	$sumRemainLevel3 = $sumBGAllotLevel3 - $sumRemainPayLevel3;
	
	//งบจัดสรรกลางปี
	$BGInternalLevel3 = $get->getTotalBGIncreaseInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],5,0,$adjustDetail[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);
	
	//$sumAdjustLevel3 = ($sumRemainLevel3 + $BGInternalLevel3[0]->ValBGIncrease) - $BGInternalLevel3[0]->ValBGDecrease;
		
  ?>
  <tr class="level3">
    <td style="text-indent:40px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?><?php echo " / ".$CostItemCode;?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumBGAllotLevel3,2);?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumBGStatementLevel3,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumHoldLevel3,2)?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumPayLevel3,2);?></td>
    <td align="right" style="text-align:right"><?php echo number_format($sumRemainPayLevel3,2)?></td>
    <td align="right" style="text-align:right">
    <?php echo number_format($sumRemainLevel3,2);?>
    <?php if($HasChild == 'N'){ ?>
	<input type="hidden" name="sumRemainLevel[]" id="sumRemainLevel<?=$CostItemCode?>" value="<?php echo $sumRemainLevel3;?>" />    
    <?php } ?>
    </td>
    <td align="right" style="text-align:center"> 
    <?php if($HasChild == 'N'){ ?>
    <input type="hidden" name="CostItemCode[]" id="CostItemCode" value="<?php echo $CostItemCode; ?>" />
    <input name="BGIncrease[]"  id="BGIncrease<?=$CostItemCode?>" rel="RelBGIncrease"   type="text"    value="<?php  echo number_format($BGInternalLevel3[0]->ValBGIncrease,2,'.','');?>"  onkeyup="CalCostSumBGIncrease('<?php echo $CostItemCode; ?>');CheckInput('<?php echo $CostItemCode; ?>','<?php echo $sumRemainLevel1;?>')"  onKeyPress="return validChars(event,2)"  class="number-normal" />  
    <?php } ?>    
    </td>
    </tr>
  <?php 
  $NumLevel3++;
  } ?>
  <!--END วน loop รายการงบรายจ่าย ระดับที่ 3-->
  <?php } ?>
  <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->
  
  
  
  
  
  <?php 
  $NumLevel2++;
  } ?>
  <!--END วน loop รายการงบรายจ่าย ระดับที่ 2-->
  <?php } ?>
  <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->
  
  
  
  
  
  <?php 
  $NumLevel1++;
  } ?>
  <!--END วน loop รายการงบรายจ่าย ระดับที่ 1-->
   </tbody>
  
  
  
  
  <?php 
  $NumCate++;
  } ?>
  <!--END วน loop หมวดงบรายจ่าย-->
  <?php
    //งบจัดสรร
	$totalBGAllot = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,0,0,0,0,0,$allot[0]->PrjDetailId,$allot[0]->PrjActId,$allot[0]->PrjActCode);
  	
	//งบหลักการ
	$totalBGStatement = 0;
	
	//งบผูกพัน
	$totalHold = 0;
	
	//งบจ่ายจริง
	$totalPay = 0;
	
	//งบรวมตัดจ่าย (รวมทั้งสิ้น)
	$totalRemainPay = $totalBGStatement + $totalHold + $totalPay;
	
	//งบคงเหลือ
	$totalRemain = $totalBGAllot - $totalRemainPay;
	
	//งบจัดสรรกลางปี	
	$totalBGInternal = $get->getTotalBGIncreaseInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],5,0,$adjustDetail[0]->AllotId,0,0,0,0,0,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);	
	//ltxt::print_r($TotalBGInternal);
	

	
	//$TotalAdjust = ($totalRemain + $TotalBGInternal[0]->ValBGIncrease) - $TotalBGInternal[0]->ValBGDecrease;
	
  ?>
  <tr class="total">
    <td style="text-align:right;">รวมงบประมาณทั้งสิ้น</td>
    <td align="right"  style="text-align:right;"><?php echo number_format($totalBGAllot,2);?></td>
    <td align="right" style="text-align:right;"><?php echo number_format($totalBGStatement,2)?></td>
    <td style="text-align:right"><?php echo number_format($totalHold,2)?></td>
    <td align="right" style="text-align:right;"><?php echo number_format($totalPay,2)?></td>
    <td align="right" style="text-align:right"><?php echo number_format($totalRemainPay,2)?></td>
    <td align="right" style="text-align:right; font-weight:bold"><?php echo number_format($totalRemain,2);?><input type="hidden" name="totalRemain" id="totalRemain" value="<?php echo $totalRemain;?>" />
    </td>
    <td align="right" style="text-align:center">    
    <input name="totalBGIncrease" rel="totalBGIncrease" type="text"   id="totalBGIncrease"    value="<?php  echo number_format($totalBGInternal[0]->ValBGIncrease,2,'.','');?>"   readonly="readonly"  onKeyPress="return validChars(event,2)"  class="number-sum" />
    </td>
  </tr>
</table>

<br />
<br />


<?php

$getExName=$get->getSourceExName();
//ltxt::print_r($getExName);
foreach($getExName as $sName){
	foreach($sName as $k=>$v){
		${$k} = $v;
	}
	
?>
<input type="hidden" name="SourceExId[]" id="SourceExId" value="<?php echo $SourceExId; ?>" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<td  style="padding-left:20px">เงินนอกงบประมาณ [<?php echo $SourceExName;?>]</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;"  >
  <tr>
    <th rowspan="2" style="width:30%">หมวดงบ/รายการงบรายจ่าย</th>
    <th rowspan="2" style="text-align:right; width:10%">งบจัดสรร (บาท)</th>
    <th colspan="4" style="text-align:center; width:40%">งบตัดจ่าย</th>
    <th rowspan="2" style="text-align:right; width:10%">งบคงเหลือ (บาท)</th>
    <th rowspan="2" style="text-align:center; width:10%">งบปรับกลางปี (บาท)</th>
    </tr>
  <tr>
    <th style="text-align:right; width:10%">งบหลักการ (บาท)</th>
    <th style="text-align:right; width:10%">งบผูกพัน (บาท)</th>
    <th style="text-align:right; width:10%">งบจ่ายจริง (บาท)</th>
    <th style="text-align:right; width:10%">รวมทั้งสิ้น (บาท)</th>
    </tr>
<?php
   	$NumCate2=1;
	//$listEx = $get->getCostType($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$SourceExId);
	$listEx = $get->getCostTypeRecordSet();
	//ltxt::print_r($listEx);
		foreach($listEx as $rEx){
			foreach($rEx as $k=>$v){
				${$k} = $v;
			}
			
			$CostTypeName2 = $CostTypeName;
			$CostTypeId2 = $CostTypeId;
			
			$sumExBGAllotType =  $get->getTotalBGAllotEnternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,0,0,$CostTypeId2,0,0,$SourceExId,$allot[0]->PrjDetailId,$allot[0]->PrjActId,$allot[0]->PrjActCode);
			
	//งบหลักการ
	$sumExBGStatementType = 0;
	
	//งบผูกพัน
	$sumExHoldType = 0;
	
	//งบจ่ายจริง
	$sumExPayType = 0;
	
	//งบรวมตัดจ่าย (รวมทั้งสิ้น)
	$sumExRemainPayType = $sumExBGStatementType + $sumExHoldType + $sumExPayType;
	
	//งบคงเหลือ
	$sumExRemainType = $sumExBGAllotType - $sumExRemainPayType;

			
?>
  <tr class="cate">
    <td >
<?php echo $NumCate2; ?>. <?php echo $CostTypeName2; ?> | <a href="javascript:void(0)" id="a-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>" onclick="showHideTwo<?php echo $SourceExId; ?>(<?php echo $NumCate2; ?>);" class="icon-decre txt-normal">ย่อ</a>    
   </td>
    <td align="right" ><?php echo number_format($sumExBGAllotType,2);?></td>
    <td  align="right"><?php echo number_format($sumExBGStatementType,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumExHoldType,2)?></td>
    <td  align="right"><?php echo number_format($sumExPayType,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumExRemainPayType,2)?></td>    
    <td  align="right"><?php echo number_format($sumExRemainType,2);?></td>
    <td style="text-align:right;">&nbsp;</td>
  </tr>
  
  <tbody id="body-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>">
  <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
   <?php
  $NumLevel11 = 1; 
  $BGLevel11 = $get->getCostItemRecordSet($CostTypeId2);
  //ltxt::print_r($BGLevel11);
  foreach($BGLevel11 as $BGLevel11Row){ 
  	foreach($BGLevel11Row as $c=>$d){
		${$c} = $d;
	}
	$CostName3 = $CostName;
	$CostItemCode3 = $CostItemCode;
	$CostTypeId3 = $CostTypeId;
	$ParentCode3 = $ParentCode;
	$LevelId3 = $LevelId;
	$HasChild3 = $HasChild	;
	
	//จัดสรรงบ
	$sumExBGAllotLevel1 = $get->getTotalBGAllotEnternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,$SourceExId,$allot[0]->PrjDetailId,$allot[0]->PrjActId,$allot[0]->PrjActCode);
	
	//งบหลักการ
	$sumExBGStatementLevel1 = 0;
	
	//งบผูกพัน
	$sumExHoldLevel1 = 0;
	
	//งบจ่ายจริง
	$sumExPayLevel1 = 0;
	
	//งบรวมตัดจ่าย (รวมทั้งสิ้น)
	$sumExRemainPayLevel1 = $sumExBGStatementLevel1 + $sumExHoldLevel1 + $sumExPayLevel1;
	
	//งบคงเหลือ
	$sumExRemainLevel1 = $sumExBGAllotLevel1 - $sumExRemainPayLevel1;
	
	$BGExternalLevel1 = $get->getTotalBGIncreaseExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],5,0,$adjustDetail[0]->AllotId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,$SourceExId,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);
	
	//$sumExAdjustLevel1 = ($sumExRemainLevel1 + $BGExternalLevel1[0]->ValBGIncrease) - $BGExternalLevel1[0]->ValBGDecrease;
			
  ?>
  <tr class="level1">
    <td style="text-indent:10px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?> <?php echo $CostName3; ?> <?php echo " / ".$CostItemCode3;?></td>
    <td style="text-align:right">
<?php 
	   echo number_format($sumExBGAllotLevel1,2);
    ?>
    </td>
    <td style="text-align:right"><?php echo number_format($sumExBGStatementLevel1,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumExHoldLevel1,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumExPayLevel1,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumExRemainPayLevel1,2)?></td>
    <td style="text-align:right">    
	<?php echo number_format($sumExRemainLevel1,2);?>
    <?php if($HasChild3 == 'N'){ ?>
	<input type="hidden" name="sumExRemainLevel<?=$SourceExId;?>[]" id="sumExRemainLevel<?=$SourceExId;?><?=$CostItemCode3;?>" value="<?php echo $sumExRemainLevel1;?>" />
    <?php } ?>
    </td>
    <td style="text-align:right">
	<?php if($HasChild3 == 'N'){ ?>
    <input type="hidden" name="ExCostItemCode<?=$SourceExId;?>[]" id="ExCostItemCode<?=$SourceExId;?>" value="<?php echo $CostItemCode3; ?>" />
    <input name="ExBGIncrease<?=$SourceExId;?>[]"  id="ExBGIncrease<?=$SourceExId;?><?=$CostItemCode3;?>" rel="RelExBGIncrease<?=$SourceExId;?>"  type="text"  value="<?php  echo number_format($BGExternalLevel1[0]->ValBGIncrease,2,'.','');?>"   onkeyup="CalCostSumExBGIncrease('<?php echo $SourceExId; ?>','<?php echo $CostItemCode3; ?>');"  onKeyPress="return validChars(event,2)"  class="number-normal"  />
    <?php } ?>
    </td>
    </tr>
  
  <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->  
  <?php if($HasChild == Y){ ?>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 2-->
   <?php
  $NumLevel22 = 1; 
  $BGLevel22 = $get->getCostItemRecordSet($CostTypeId3,2,$CostItemCode3);
  //ltxt::print_r($BGLevel22);
  foreach($BGLevel22 as $BGLevel22Row){ 
  	foreach($BGLevel22Row as $e=>$f){
		${$e} = $f;
	}
	
	$CostName4 = $CostName;
	$CostItemCode4 = $CostItemCode;
	$CostTypeId4 = $CostTypeId;
	$ParentCode4 = $ParentCode;
	$LevelId4 = $LevelId;
	$HasChild4 = $HasChild;
	
	//งบจัดสรร
	$sumExBGAllotLevel2 = $get->getTotalBGAllotEnternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,$SourceExId,$allot[0]->PrjDetailId,$allot[0]->PrjActId,$allot[0]->PrjActCode);
	
	//งบหลักการ
	$sumExBGStatementLevel2 = 0;
	
	//งบผูกพัน
	$sumExHoldLevel2 = 0;
	
	//งบจ่ายจริง
	$sumExPayLevel2 = 0;
	
	//งบรวมตัดจ่าย (รวมทั้งสิ้น)
	$sumExRemainPayLevel2 = $sumExBGStatementLevel2 + $sumExHoldLevel2 + $sumExPayLevel2;
	
	//งบคงเหลือ
	$sumExRemainLevel2 = $sumExBGAllotLevel2 - $sumExRemainPayLevel2;
	
	$BGExternalLevel2 = $get->getTotalBGIncreaseExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],5,0,$adjustDetail[0]->AllotId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,$SourceExId,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);
	
	//$sumExAdjustLevel2 = ($sumExRemainLevel2 + $BGExternalLevel2[0]->ValBGIncrease) - $BGExternalLevel2[0]->ValBGDecrease;
		
?>
  <tr class="level2">
    <td style="text-indent:20px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?>.			<?php echo $NumLevel22; ?> <?php echo $CostName4; ?> <?php echo " / ".$CostItemCode4;?></td>
    <td style="text-align:right">
	<?php 
	   echo number_format($sumExBGAllotLevel2,2);
    ?>
    </td>
    <td style="text-align:right"><?php echo number_format($sumExBGStatementLevel2,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumExHoldLevel2,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumExPayLevel2,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumExRemainPayLevel2,2)?></td>
    <td style="text-align:right">
    <?php echo number_format($sumExRemainLevel2,2);?>
    <?php if($HasChild4 == 'N'){ ?>
	<input type="hidden" name="sumExRemainLevel<?=$SourceExId;?>[]" id="sumExRemainLevel<?=$SourceExId;?><?=$CostItemCode4;?>"  value="<?php echo $sumExRemainLevel2;?>" /> 
    <?php } ?>
    </td>
    <td style="text-align:right">    
	<?php if($HasChild4 == 'N'){ ?>
    <input type="hidden" name="ExCostItemCode<?=$SourceExId;?>[]" id="ExCostItemCode<?=$SourceExId;?>" value="<?php echo $CostItemCode4; ?>" />
    <input name="ExBGIncrease<?=$SourceExId;?>[]"  id="ExBGIncrease<?=$SourceExId;?><?=$CostItemCode4;?>" rel="RelExBGIncrease<?=$SourceExId;?>"  type="text"  value="<?php  echo number_format($BGExternalLevel2[0]->ValBGIncrease,2,'.','');?>"  onkeyup="CalCostSumExBGIncrease('<?php echo $SourceExId; ?>','<?php echo $CostItemCode4; ?>');"  onKeyPress="return validChars(event,2)"  class="number-normal"  />
    <?php } ?>
    </td>
    </tr>
  
  
  
  <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->  
  <?php if($HasChild == Y){ ?>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 3-->
   <?php
  $NumLevel33 = 1; 
  $BGLevel33 = $get->getCostItemRecordSet($CostTypeId4,3,$CostItemCode4);
 // ltxt::print_r($BGLevel33);
  foreach($BGLevel33 as $BGLevel33Row){ 
  	foreach($BGLevel33Row as $g=>$h){
		${$g} = $h;
	}
	
	$CostName5 = $CostName;
	$CostItemCode5 = $CostItemCode;
	$CostTypeId5 = $CostTypeId;
	$ParentCode5 = $ParentCode;
	$LevelId5 = $LevelId;
	$HasChild5 = $HasChild;
	
	//งบจัดสรร
	$sumExBGAllotLevel3 = $get->getTotalBGAllotEnternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,$SourceExId,$allot[0]->PrjDetailId,$allot[0]->PrjActId,$allot[0]->PrjActCode);

	//งบหลักการ
	$sumExBGStatementLevel3 = 0;
	
	//งบผูกพัน
	$sumExHoldLevel3 = 0;
	
	//งบจ่ายจริง
	$sumExPayLevel3 = 0;
	
	//งบรวมตัดจ่าย (รวมทั้งสิ้น)
	$sumExRemainPayLevel3 = $sumExBGStatementLevel3 + $sumExHoldLevel3 + $sumExPayLevel3;
	
	//งบคงเหลือ
	$sumExRemainLevel3 = $sumExBGAllotLevel3 - $sumExRemainPayLevel3;
	
	//งบจัดสรรกลางปี
	$BGExternalLevel3 = $get->getTotalBGIncreaseExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],5,0,$adjustDetail[0]->AllotId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,$SourceExId,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);
		
  ?>
  <tr class="level3">
    <td style="text-indent:40px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?>.<?php echo $NumLevel22; ?>.<?php echo $NumLevel33; ?> <?php echo $CostName5; ?><?php echo " / ".$CostItemCode5;?></td>
    <td style="text-align:right"><?php echo number_format($sumExBGAllotLevel3,2);?></td>
    <td style="text-align:right"><?php echo number_format($sumExBGStatementLevel3,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumExHoldLevel3,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumExPayLevel3,2)?></td>
    <td style="text-align:right"><?php echo number_format($sumExRemainPayLevel3,2)?></td>
    <td style="text-align:right">
    <?php echo number_format($sumExRemainLevel3,2);?>
    <?php if($HasChild5 == 'N'){ ?>
	<input type="hidden" name="sumExRemainLevel<?=$SourceExId;?>[]" id="sumExRemainLevel<?=$SourceExId;?><?=$CostItemCode5;?>" value="<?php echo $sumExRemainLevel3;?>" /> 
     <?php } ?>   
    </td>
    <td style="text-align:right">
    <?php if($HasChild5 == 'N'){ ?>
    <input type="hidden" name="ExCostItemCode<?=$SourceExId;?>[]" id="ExCostItemCode<?=$SourceExId;?>" value="<?php echo $CostItemCode5; ?>" />
    <input name="ExBGIncrease<?=$SourceExId;?>[]"  id="ExBGIncrease<?=$SourceExId;?><?=$CostItemCode5;?>" rel="RelExBGIncrease<?=$SourceExId;?>"  type="text"   value="<?php  echo number_format($BGExternalLevel3[0]->ValBGIncrease,2,'.','');?>"  onkeyup="CalCostSumExBGIncrease('<?php echo $SourceExId; ?>','<?php echo $CostItemCode5; ?>');"  onKeyPress="return validChars(event,2)"  class="number-normal" />
    <?php } ?>      
    </td>
    </tr>
  <?php 
  $NumLevel33++;
  } ?>
  <!--END วน loop รายการงบรายจ่าย ระดับที่ 3-->
  <?php } ?>
  <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->
  
  
  
  
  
  <?php 
  $NumLevel22++;
  } ?>
  <!--END วน loop รายการงบรายจ่าย ระดับที่ 2-->
  <?php } ?>
  <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->
  
  
  
  
  
  <?php 
  $NumLevel11++;
  } ?>
  <!--END วน loop รายการงบรายจ่าย ระดับที่ 1-->
   </tbody>
    
  <script type="text/javascript">
	function showHideTwo<?php echo $SourceExId; ?>(i){
		//alert("showHideTwo<?php echo $SourceExId; ?>");
		
		if(JQ('#body-catetwo<?php echo $SourceExId; ?>'+i).is(':hidden')===true){
			JQ('#body-catetwo<?php echo $SourceExId; ?>'+i).show('slow');
			JQ('#a-catetwo<?php echo $SourceExId; ?>'+i).addClass('icon-decre');
			JQ('#a-catetwo<?php echo $SourceExId; ?>'+i).removeClass('icon-incre');
			JQ('#a-catetwo<?php echo $SourceExId; ?>'+i).html('ย่อ');
		}else{
			JQ('#body-catetwo<?php echo $SourceExId; ?>'+i).hide('slow');
			JQ('#a-catetwo<?php echo $SourceExId; ?>'+i).removeClass('icon-decre');
			JQ('#a-catetwo<?php echo $SourceExId; ?>'+i).addClass('icon-incre');
			JQ('#a-catetwo<?php echo $SourceExId; ?>'+i).html('ขยาย');
		}
	}  
  </script>
  

<?php  $NumCate2++; } ?>


  <!--END วน loop หมวดงบรายจ่าย-->
  <?php
  	// งบจัดสรร
	$totalExBGAllot = $get->getTotalBGAllotEnternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,0,0,0,0,0,$SourceExId,$allot[0]->PrjDetailId,$allot[0]->PrjActId,$allot[0]->PrjActCode);
	
	//งบหลักการ
	$totalExBGStatement = 0;
	
	//งบผูกพัน
	$totalExHold = 0;
	
	//งบจ่ายจริง
	$totalExPay = 0;
	
	//งบรวมตัดจ่าย (รวมทั้งสิ้น)
	$totalExRemainPay = $totalExBGStatement + $totalExHold + $totalExPay;
	
	//งบคงเหลือ
	$totalExRemain = $totalExBGAllot - $totalExRemainPay;
	
	//งบจัดสรรกลางปี	
	$TotalBGExternal = $get->getTotalBGIncreaseExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],5,0,$adjustDetail[0]->AllotId,0,0,0,0,0,$SourceExId,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);	
	//ltxt::print_r($TotalBGInternal);
	
  ?>  
  <tr class="total">
    <td style="text-align:right;">รวมงบประมาณทั้งสิ้น</td>
    <td  style="text-align:right;"><?php echo number_format($totalExBGAllot,2);?>    
    </td>
    <td style="text-align:right;"><?php echo number_format($totalExBGStatement,2)?></td>
    <td style="text-align:right"><?php echo number_format($totalExHold,2)?></td>
    <td style="text-align:right;"><?php echo number_format($totalExPay,2)?></td>
    <td style="text-align:right"><?php echo number_format($totalExRemainPay,2)?></td>
    <td style="text-align:right;"><?php echo number_format($totalExRemain,2);?><input type="hidden" name="totalExRemain<?php echo $SourceExId;?>" id="totalExRemain<?php echo $SourceExId;?>" value="<?php echo $totalExRemain;?>" /></td>
    <td style="text-align:right;">    
    <input name="totalExBGIncrease<?=$SourceExId;?>" rel="totalExBGIncrease<?=$SourceExId;?>" type="text"   id="totalExBGIncrease<?=$SourceExId;?>"   value="<?php  echo number_format($TotalBGExternal[0]->ValBGIncrease,2,'.','');?>"    readonly="readonly"  onKeyPress="return validChars(event,2)"  class="number-sum"  />
    </td>
  </tr>

</table>

<br />
<br />

<script type="text/javascript">
function CalCostSumTwo<?php echo $SourceExId; ?>(CostItemCode){

var Obj2 = JQ('#BGAllotTwo_<?php echo $SourceExId; ?>'+CostItemCode);
var Value2 = Obj2.val();
//alert(Value2);

				var sum =0;
				
				 JQ('input[rel=RelBGAllotTwo_<?php echo $SourceExId; ?>]').each(function(){
						 num = parseFloat(JQ(this).val());
						 if( !isNaN(num)) sum = sum + num; 
				 });
				 
				 JQ('#SumBGAllotTwo_<?php echo $SourceExId; ?>').val(sum);
					
}
</script>
<?php
}
?>
<!--END วน loop แหล่งเงินนนอกงบ-->

     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="submit" class="btnActive" name="save" id="save" value="บันทึก"  />
      <input type="button" name="button" id="button" value="ยกเลิก" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listProjectPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>&SCTypeId=<?php echo $_REQUEST['SCTypeId'];?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel'];?>');" /></div>
      
</form>



