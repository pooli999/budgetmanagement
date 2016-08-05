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

$allot = $get->getAllotDetail($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0);
//ltxt::print_r($allot);


$adjustDetail = $get->getAllotDetail($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],5,0);
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

function CalCostExDecrease(SourceExId,CostItemCode){
	
var ObjExRe = JQ('#sumExRemainLevel'+SourceExId+CostItemCode);
var ObjExDe = JQ('#ExBGDecrease'+SourceExId+CostItemCode);
var ObjExIn = JQ('#ExBGIncrease'+SourceExId+CostItemCode);
var ValExRe = ObjExRe.val();
var ValExDe = ObjExDe.val();
var ValIExIn = ObjExIn.val();

var ObjTotalExRe = JQ('#totalExRemain'+SourceExId);
var ObjTotalRxIn = JQ('#totalExBGIncrease'+SourceExId);
var ObjTotalExDe = JQ('#totalExBGDecrease'+SourceExId);
var ValTotalExRe = ObjTotalExRe.val();
var ValTotalExIn = ObjTotalRxIn.val();
var ValTotalExDe = ObjTotalExDe.val();



	var SumExInput = parseFloat(ValIExIn) + parseFloat(ValExDe) ;

	if(SumExInput>parseFloat(ValExRe)){
		jAlert('งบเพิ่มและงบลดรวมกันต้องไม่เกินงบคงเหลือ กรุณากรอกข้อมูลใหม่','ระบบตรวจสอบข้อมูล',function(){
			ObjExDe.val("");
			JQ('#ExBGTotal'+SourceExId+CostItemCode).val(ValIExIn);
			ObjExDe.focus();
		});
	}else if(parseFloat(ValIExIn)>parseFloat(ValExRe)){
		jAlert('งบเพิ่มต้องน้อยกว่างบคงเหลือ กรุณากรอกข้อมูลใหม่','ระบบตรวจสอบข้อมูล',function(){
			ObjExIn.val("");
			ObjTotalRxIn.val("");
			JQ('#ExBGTotal'+SourceExId+CostItemCode).val(ValExDe);
			ObjExIn.focus();
		});
	}else if(parseFloat(ValExDe)>parseFloat(ValExRe)){
		jAlert('งบลดต้องน้อยกว่างบคงเหลือ กรุณากรอกข้อมูลใหม่','ระบบตรวจสอบข้อมูล',function(){
			ObjExDe.val("");
			ObjTotalExDe.val("");
			JQ('#ExBGTotal'+SourceExId+CostItemCode).val(ValIExIn);
			ObjExDe.focus();
		});
	} 
	

if(ValExRe=="") ValExRe=0; if(ValIExIn=="") ValIExIn=0;  if(ValExDe=="") ValExDe=0;  
var ResultExVal = parseFloat(ValExRe)+parseFloat(ValIExIn)-parseFloat(ValExDe); 
JQ('#ExBGTotal'+SourceExId+CostItemCode).val(ResultExVal);


if(ValTotalExRe=="") ValTotalExRe=0;  if(ValTotalExIn=="") ValTotalExIn=0;  if(ValTotalExDe=="") ValTotalExDe=0; 
var ResultExValTotal = parseFloat(ValTotalExRe)-parseFloat(ValTotalExIn)-parseFloat(ValTotalExDe); 
JQ('#SumExBGTotal'+SourceExId).val(ResultExValTotal);


}




function CalCostDecrease(CostItemCode){
	
var ObjRe = JQ('#sumRemainLevel' + CostItemCode);
var ObjDe = JQ('#BGDecrease' + CostItemCode);
var ObjIn = JQ('#BGIncrease' + CostItemCode);
var ValRe = ObjRe.val();
var ValDe = ObjDe.val();
var ValIn = ObjIn.val();

var ObjTotalRe = JQ('#totalRemain');
var ObjTotalIn = JQ('#totalBGIncrease');
var ObjTotalDe = JQ('#totalBGDecrease');
var ValTotalRe = ObjTotalRe.val();
var ValTotalIn = ObjTotalIn.val();
var ValTotalDe = ObjTotalDe.val();


	var SumInput = parseFloat(ValDe) + parseFloat(ValIn);

	if(SumInput>parseFloat(ValRe)){
		jAlert('งบเพิ่มและงบลดรวมกันต้องไม่เกินงบคงเหลือ กรุณากรอกข้อมูลใหม่','ระบบตรวจสอบข้อมูล',function(){
			ObjDe.val("");
			JQ('#BGTotal'+CostItemCode).val(ValIn);
			Obj2.focus();
		});
	}else if(parseFloat(ValIn)>parseFloat(ValRe)){
		jAlert('งบเพิ่มต้องน้อยกว่างบคงเหลือ กรุณากรอกข้อมูลใหม่','ระบบตรวจสอบข้อมูล',function(){
			ObjIn.val("");
			JQ('#totalBGIncrease').val("");
			JQ('#BGTotal'+CostItemCode).val(ValDe);
			ObjIn.focus();
		});
	}else if(parseFloat(ValDe)>parseFloat(ValRe)){
		jAlert('งบลดต้องน้อยกว่างบคงเหลือ กรุณากรอกข้อมูลใหม่','ระบบตรวจสอบข้อมูล',function(){
			ObjDe.val("");
			JQ('#totalBGDecrease').val("");
			JQ('#BGTotal'+CostItemCode).val(ValIn);
			ObjDe.focus();
		});
	} 
	

if(ValRe=="") ValRe=0; if(ValIn=="") ValIn=0;  if(ValDe=="") ValDe=0;  
var ResultVal = parseFloat(ValRe)+parseFloat(ValIn)-parseFloat(ValDe); 
JQ('#BGTotal'+CostItemCode).val(ResultVal);


if(ValTotalRe=="") ValTotalRe=0;  if(ValTotalIn=="") ValTotalIn=0;  if(ValTotalDe=="") ValTotalDe=0; 
var ResultValTotal = parseFloat(ValTotalRe)-parseFloat(ValTotalIn)-parseFloat(ValTotalDe); 
JQ('#SumBGTotal').val(ResultValTotal);


/*				var sumAll =0;
				
				 JQ('input[rel=RelBGTotal]').each(function(){
						 numAll = parseFloat(JQ(this).val());
						 if( !isNaN(numAll)) sumAll = sumAll + numAll; 
				 });

				JQ('#SumBGTotal').val(sumAll);*/

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


function SaveAdjust(form){	

   			 form.submit();

}

function getfilterorg(){
	var BgtYear = $('BgtYear').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($ViewAllot);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}

function loadSCT(BgtYear){
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($ViewAllot);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}




</script>

<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td class="td-descr" style="width:225px;"><b>ปีงบประมาณ : <?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?></b></th>
      <td class="td-descr" style="width:382px;"><b>หน่วยงาน : <span id="org-list"><?php echo $get->getOrganizeCode($_REQUEST["OrganizeCode"],ltxt::getVar('OrganizeCode'));?></span></b></td>
    </tr>
  </table>
</div>
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=saveadjust" onSubmit="SaveAdjust(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear']?>" />
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode']?>" />
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST['SCTypeId']?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST['ScreenLevel']?>" />

<input type="hidden" name="AllotId" id="AllotId" value="<?php echo $adjustDetail[0]->AllotId; ?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<td  style="padding-left:20px">งบประมาณแผ่นดิน</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;"  >
  <tr>
    <th rowspan="2" style="width:30%">หมวดงบ/รายการงบรายจ่าย</th>
    <th rowspan="2" valign="bottom"  style="text-align:right; width:10%">งบจัดสรร (บาท)</th>
    <th rowspan="2" valign="bottom" style="text-align:right; width:10%">งบหลักการ (บาท)</th>
    <th rowspan="2" valign="bottom" style="text-align:right; width:10%">งบตัดจ่าย (บาท)</th>
    <th rowspan="2" valign="bottom" style="text-align:right; width:10%">งบคงเหลือ (บาท)</th>
    <th colspan="3" style="text-align:center; width:30%">งบปรับกลางปี</th>
    </tr>
  <tr>
    <th style="text-align:right; width:10%">งบเพิ่ม (บาท)</th>
    <th style="text-align:right; width:10%">งบลด (บาท)</th>
    <th style="text-align:right; width:10%">รวม (บาท)</th>
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
	$sumBGAllotType =  $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,0,0,$CostTypeId,0,0);
	
	$sumBGStatementType = 0;
	$sumPayType = 0;
	$sumRemainType = $sumBGAllotType - $sumBGStatementType - $sumPayType;
	
	$BGInternalType = $get->getTotalBGIncreaseInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$adjustDetail[0]->AllotId,0,0,$CostTypeId,0,0);
	
	$sumAdjustType = ($sumRemainType + $BGInternalType[0]->ValBGIncrease) - $BGInternalType[0]->ValBGDecrease;
	
	
  ?>
  <tr class="cate">
    <td><?php echo $NumCate; ?>. <?php echo $CostTypeName; ?> | <a href="javascript:void(0)" id="a-cate<?php echo $NumCate; ?>" onclick="showHide(<?php echo $NumCate; ?>);" class="icon-decre txt-normal">ย่อ</a></td>
    <td align="right" style="text-align:right">
    <?php echo ($sumBGAllotType > 0)?number_format($sumBGAllotType,2):"-"; ?>
    </td>
    <td align="right" style="text-align:right">
    <?php echo ($sumBGStatementType > 0)?number_format($sumBGStatementType,2):"-"; ?>
    </td>
    <td align="right" style="text-align:right">
    <?php echo ($sumPayType > 0)?number_format($sumPayType,2):"-"; ?>
    </td>
    <td align="right" style="text-align:right; font-weight:bold">
	<?php echo ($sumRemainType > 0)?number_format($sumRemainType,2):"-"; ?>
    </td>
    <td  style="text-align:right"><?php echo ($BGInternalType[0]->ValBGIncrease > 0)?number_format($BGInternalType[0]->ValBGIncrease,2):"-"; ?> </td>
    <td  style="text-align:right"><?php echo ($BGInternalType[0]->ValBGDecrease > 0)?number_format($BGInternalType[0]->ValBGDecrease,2):"-"; ?>   
</td>
    <td  style="text-align:right"><?php echo ($sumAdjustType > 0)?number_format($sumAdjustType,2):"-"; ?>
</td>    
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
	
	$sumBGAllotLevel1 = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	$sumBGStatementLevel1 = 0;
	$sumPayLevel1 = 0;
	$sumRemainLevel1 = 	$sumRemainLevel1 = $sumBGAllotLevel1 - $sumBGStatementLevel1 - $sumPayLevel1;
	
	
	$BGInternalLevel1 = $get->getTotalBGIncreaseInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$adjustDetail[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$sumAdjustLevel1 = ($sumRemainLevel1 + $BGInternalLevel1[0]->ValBGIncrease) - $BGInternalLevel1[0]->ValBGDecrease;
	
  ?>
  <tr class="level1">
    <td style="text-indent:10px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?> </td>
    <td align="right" style="text-align:right">
    <?php echo ($sumBGAllotLevel1 > 0)?number_format($sumBGAllotLevel1,2):"-"; ?>
    </td>
    <td align="right" style="text-align:right">
    <?php echo ($sumBGStatementLevel1 > 0)?number_format($sumBGStatementLevel1,2):"-"; ?>
    </td>
    <td align="right" style="text-align:right">
    <?php echo ($sumPayLevel1 > 0)?number_format($sumPayLevel1,2):"-"; ?>
    </td>
    <td align="right" style="text-align:right">
    <?php echo ($sumRemainLevel1 > 0)?number_format($sumRemainLevel1,2):"-"; ?> 
    </td>
    <td  style="text-align:right">
    <?php echo ($BGInternalLevel1[0]->ValBGIncrease > 0)?number_format($BGInternalLevel1[0]->ValBGIncrease,2):"-"; ?>    
    </td>
    <td style="text-align:right">
    <?php echo ($BGInternalLevel1[0]->ValBGDecrease > 0)?number_format($BGInternalLevel1[0]->ValBGDecrease,2):"-"; ?>   
    </td>
    <td  style="text-align:right">
        <?php echo ($sumAdjustLevel1 > 0)?number_format($sumAdjustLevel1,2):"-"; ?> 
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
	$sumBGAllotLevel2 = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	$sumBGStatementLevel2 = 0;
	$sumPayLevel2 = 0;
	$sumRemainLevel2 = 	$sumRemainLevel2 = $sumBGAllotLevel2 - $sumBGStatementLevel2 - $sumPayLevel2;

	$BGInternalLevel2 = $get->getTotalBGIncreaseInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$adjustDetail[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$sumAdjustLevel2 = ($sumRemainLevel2 + $BGInternalLevel2[0]->ValBGIncrease) - $BGInternalLevel2[0]->ValBGDecrease;


  ?>
  <tr class="level2">
    <td style="text-indent:20px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?> </td>
    <td align="right" style="text-align:right">
    <?php echo ($sumBGAllotLevel2 > 0)?number_format($sumBGAllotLevel2,2):"-"; ?>
    </td>
    <td align="right" style="text-align:right">
    <?php echo ($sumBGStatementLevel2 > 0)?number_format($sumBGStatementLevel2,2):"-"; ?>
    </td>
    <td align="right" style="text-align:right">
	 <?php echo ($sumPayLevel2 > 0)?number_format($sumPayLevel2,2):"-"; ?>
	</td>
    <td align="right" style="text-align:right">
    <?php echo ($sumRemainLevel2 > 0)?number_format($sumRemainLevel2,2):"-"; ?>
    </td>
    <td  style="text-align:right"><?php echo ($BGInternalLevel2[0]->ValBGIncrease > 0)?number_format($BGInternalLevel2[0]->ValBGIncrease,2):"-"; ?>       
    </td>
    <td style="text-align:right">
    <?php echo ($BGInternalLevel2[0]->ValBGDecrease > 0)?number_format($BGInternalLevel2[0]->ValBGDecrease,2):"-"; ?>
    </td>
    <td  style="text-align:right">
        <?php echo ($sumAdjustLevel2 > 0)?number_format($sumAdjustLevel2,2):"-"; ?>
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
	
	$sumBGAllotLevel3 = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$sumBGStatementLevel3 = 0;
	$sumPayLevel3 = 0;
	$sumRemainLevel3 = $sumBGAllotLevel3 - $sumBGStatementLevel3 - $sumPayLevel3;
	
	$BGInternalLevel3 = $get->getTotalBGIncreaseInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$adjustDetail[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	
	$sumAdjustLevel3 = ($sumRemainLevel3 + $BGInternalLevel3[0]->ValBGIncrease) - $BGInternalLevel3[0]->ValBGDecrease;
		
  ?>
  <tr class="level3">
    <td style="text-indent:40px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?></td>
    <td align="right" style="text-align:right">
         <?php echo ($sumBGAllotLevel3 > 0)?number_format($sumBGAllotLevel3,2):"-"; ?>
    </td>
    <td align="right" style="text-align:right">
     <?php echo ($sumBGStatementLevel3 > 0)?number_format($sumBGStatementLevel3,2):"-"; ?>
    </td>
    <td align="right" style="text-align:right">
     <?php echo ($sumPayLevel3 > 0)?number_format($sumPayLevel3,2):"-"; ?>
    </td>
    <td align="right" style="text-align:right">
    <?php echo ($sumRemainLevel3 > 0)?number_format($sumRemainLevel3,2):"-"; ?>
    </td>
    <td  style="text-align:right">
	<?php echo ($BGInternalLevel3[0]->ValBGIncrease > 0)?number_format($BGInternalLevel3[0]->ValBGIncrease,2):"-"; ?>
    </td>
    <td style="text-align:right">
        	<?php echo ($BGInternalLevel3[0]->ValBGDecrease > 0)?number_format($BGInternalLevel3[0]->ValBGDecrease,2):"-"; ?> 
    </td>
    <td  style="text-align:right">
    <?php echo ($sumAdjustLevel3 > 0)?number_format($sumAdjustLevel3,2):"-"; ?>
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
	$totalBGAllot = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,0,0,0,0,0);
	$totalBGStatement = 0;
	$totalPay = 0;
	$totalRemain = $totalBGAllot - $totalBGStatement - $totalPay;  
	
	$TotalBGInternal = $get->getTotalBGIncreaseInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$adjustDetail[0]->AllotId,0,0,0,0,0);	
	//ltxt::print_r($TotalBGInternal);
	
	$TotalAdjust = ($totalRemain + $TotalBGInternal[0]->ValBGIncrease) - $TotalBGInternal[0]->ValBGDecrease;
	
  ?>
  <tr class="total">
    <td style="text-align:right;">รวมงบประมาณทั้งสิ้น (บาทถ้วน)</td>
    <td align="right"  style="text-align:right;"><?php echo ($totalBGAllot > 0)?number_format($totalBGAllot,2):"-"; ?></td>
    <td align="right" style="text-align:right;"><?php echo ($totalBGStatement > 0)?number_format($totalBGStatement,2):"-"; ?></td>
    <td align="right" style="text-align:right;"><?php echo ($totalPay > 0)?number_format($totalPay,2):"-"; ?></td>
    <td align="right" style="text-align:right; font-weight:bold">
	<?php echo ($totalRemain > 0)?number_format($totalRemain,2):"-"; ?>
    </td>
    <td style="text-align:right">
	<?php echo ($TotalBGInternal[0]->ValBGIncrease > 0)?number_format($TotalBGInternal[0]->ValBGIncrease,2):"-"; ?>
    </td>
    <td  style="text-align:right">
    	<?php echo ($TotalBGInternal[0]->ValBGDecrease > 0)?number_format($TotalBGInternal[0]->ValBGDecrease,2):"-"; ?>    
   </td>
    <td  style="text-align:right">
	<?php echo ($TotalAdjust > 0)?number_format($TotalAdjust,2):"-"; ?>     
    </td>
  </tr>
</table>

<br />
<br />


<?php

$getExName=$get->getSourceName();
//ltxt::print_r($getExName);
foreach($getExName as $sName){
	foreach($sName as $k=>$v){
		${$k} = $v;
	}
	
?>
<input type="hidden" name="SourceExId[]" id="SourceExId" value="<?php echo $SourceExId; ?>" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<td  style="padding-left:20px">งบอุดหนุน (<?php echo $SourceExName;?>)</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;"  >
  <tr>
    <th rowspan="2" style="width:30%">หมวดงบ/รายการงบรายจ่าย</th>
    <th rowspan="2" valign="bottom"  style="text-align:right; width:10%">งบจัดสรร (บาท)</th>
    <th rowspan="2" valign="bottom" style="text-align:right; width:10%">งบหลักการ (บาท)</th>
    <th rowspan="2" valign="bottom" style="text-align:right; width:10%">งบตัดจ่าย (บาท)</th>
    <th rowspan="2" valign="bottom" style="text-align:right; width:10%">งบคงเหลือ (บาท)</th>
    <th colspan="3" style="text-align:center; width:30%">งบปรับกลางปี</th>
    </tr>
  <tr>
    <th style="text-align:right; width:10%">งบเพิ่ม (บาท)</th>
    <th style="text-align:right; width:10%">งบลด (บาท)</th>
    <th style="text-align:right; width:10%">รวม (บาท)</th>
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
			
			$sumExBGAllotType =  $get->getTotalBGAllotEnternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,0,0,$CostTypeId2,0,0,$SourceExId);
			
			$sumExBGStatementType = 0;
			$sumExPayType = 0;
			$sumExRemainType = $sumExBGAllotType - $sumExBGStatementType - $sumExPayType;
			
	$BGExternalType = $get->getTotalBGIncreaseExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$adjustDetail[0]->AllotId,0,0,$CostTypeId2,0,0,$SourceExId);
			
		$sumExAdjustType = ($sumExRemainType + $BGExternalType[0]->ValBGIncrease) - $BGExternalType[0]->ValBGDecrease;	

?>
  <tr class="cate">
    <td >
<?php echo $NumCate2; ?>. <?php echo $CostTypeName2; ?> | <a href="javascript:void(0)" id="a-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>" onclick="showHideTwo<?php echo $SourceExId; ?>(<?php echo $NumCate2; ?>);" class="icon-decre txt-normal">ย่อ</a>    
   </td>
    <td align="right" >
    <?php echo ($sumExBGAllotType > 0)?number_format($sumExBGAllotType,2):"-"; ?>
    </td>
    <td  align="right"><?php echo ($sumExBGStatementType > 0)?number_format($sumExBGStatementType,2):"-"; ?></td>
    <td  align="right"><?php echo ($sumExPayType > 0)?number_format($sumExPayType,2):"-"; ?></td>
    <td  align="right"><?php echo ($sumExRemainType > 0)?number_format($sumExRemainType,2):"-"; ?></td>
    <td  align="right"><?php echo ($BGExternalType[0]->ValBGIncrease > 0)?number_format($BGExternalType[0]->ValBGIncrease,2):"-"; ?></td>
    <td  align="right"><?php echo ($BGExternalType[0]->ValBGDecrease > 0)?number_format($BGExternalType[0]->ValBGDecrease,2):"-"; ?></td>
    <td  align="right"><?php echo ($sumExAdjustType > 0)?number_format($sumExAdjustType,2):"-"; ?></td>
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
	
	$sumExBGAllotLevel1 = $get->getTotalBGAllotEnternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,$SourceExId);
	
	$sumExBGStatementLevel1 = 0;
	$sumExPayLevel1 = 0;
	
	$sumExRemainLevel1 = $sumExBGAllotLevel1 - $sumExBGStatementLevel1 - $sumExPayLevel1;	
		
	$BGExternalLevel1 = $get->getTotalBGIncreaseExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$adjustDetail[0]->AllotId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,$SourceExId);
		
	$sumExAdjustLevel1 = ($sumExRemainLevel1 + $BGExternalLevel1[0]->ValBGIncrease) - $BGExternalLevel1[0]->ValBGDecrease;			
  ?>
  <tr class="level1">
    <td style="text-indent:10px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?> <?php echo $CostName3; ?></td>
    <td style="text-align:right">
    <?php echo ($sumExBGAllotLevel1 > 0)?number_format($sumExBGAllotLevel1,2):"-"; ?>
    </td>
    <td style="text-align:right">
    <?php echo ($sumExBGStatementLevel1 > 0)?number_format($sumExBGStatementLevel1,2):"-"; ?>
    </td>
    <td style="text-align:right">
    <?php echo ($sumExPayLevel1 > 0)?number_format($sumExPayLevel1,2):"-"; ?>
    </td>
    <td style="text-align:right">    
    <?php echo ($sumExRemainLevel1 > 0)?number_format($sumExRemainLevel1,2):"-"; ?>
    </td>
    <td style="text-align:right">
       <?php echo ($BGExternalLevel1[0]->ValBGIncrease > 0)?number_format($BGExternalLevel1[0]->ValBGIncrease,2):"-"; ?>
    </td>
    <td style="text-align:right">
               <?php echo ($BGExternalLevel1[0]->ValBGDecrease > 0)?number_format($BGExternalLevel1[0]->ValBGDecrease,2):"-"; ?>
    </td>
    <td style="text-align:right">
     <?php echo ($sumExAdjustLevel1 > 0)?number_format($sumExAdjustLevel1,2):"-"; ?>    
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
	
	
	$sumExBGAllotLevel2 = $get->getTotalBGAllotEnternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,$SourceExId);
	
	$sumExBGStatementLevel2 = 0;
	$sumExPayLevel2 = 0;
	
	$sumExRemainLevel2 = $sumExBGAllotLevel2 - $sumExBGStatementLevel2 - $sumExPayLevel2;	
	
	$BGExternalLevel2 = $get->getTotalBGIncreaseExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$adjustDetail[0]->AllotId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,$SourceExId);
	
	$sumExAdjustLevel2 = ($sumExRemainLevel2 + $BGExternalLevel2[0]->ValBGIncrease) - $BGExternalLevel2[0]->ValBGDecrease;
		
?>
  <tr class="level2">
    <td style="text-indent:20px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?>.			<?php echo $NumLevel22; ?> <?php echo $CostName4; ?> </td>
    <td style="text-align:right">
    <?php echo ($sumExBGAllotLevel2 > 0)?number_format($sumExBGAllotLevel2,2):"-"; ?>
    </td>
    <td style="text-align:right">
        <?php echo ($sumExBGStatementLevel2 > 0)?number_format($sumExBGStatementLevel2,2):"-"; ?>
    </td>
    <td style="text-align:right">
     <?php echo ($sumExPayLevel2 > 0)?number_format($sumExPayLevel2,2):"-"; ?>
    </td>
    <td style="text-align:right">
    <?php echo ($sumExRemainLevel2 > 0)?number_format($sumExRemainLevel2,2):"-"; ?>
    </td>
    <td style="text-align:right">    
            <?php echo ($BGExternalLevel2[0]->ValBGIncrease > 0)?number_format($BGExternalLevel2[0]->ValBGIncrease,2):"-"; ?>

    </td>
    <td style="text-align:right">
               <?php echo ($BGExternalLevel2[0]->ValBGDecrease > 0)?number_format($BGExternalLevel2[0]->ValBGDecrease,2):"-"; ?>    
	</td>
    <td style="text-align:right">
      <?php echo ($sumExAdjustLevel2 > 0)?number_format($sumExAdjustLevel2,2):"-"; ?>  
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
	
	$sumExBGAllotLevel3 = $get->getTotalBGAllotEnternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,$SourceExId);
	
	$sumExBGStatementLevel3 = 0;
	$sumExPayLevel3 = 0;
	
	$sumExRemainLevel3 = $sumExBGAllotLevel3 - $sumExBGStatementLevel3 - $sumExPayLevel3;

	$BGExternalLevel3 = $get->getTotalBGIncreaseExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$adjustDetail[0]->AllotId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,$SourceExId);
	
	$sumExAdjustLevel3 = ($sumExRemainLevel3 + $BGExternalLevel3[0]->ValBGIncrease) - $BGExternalLevel3[0]->ValBGDecrease;
	
	
  ?>
  <tr class="level3">
    <td style="text-indent:40px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?>.<?php echo $NumLevel22; ?>.<?php echo $NumLevel33; ?> <?php echo $CostName5; ?></td>
    <td style="text-align:right">
    <?php echo ($sumExBGAllotLevel3 > 0)?number_format($sumExBGAllotLevel3,2):"-"; ?>
    </td>
    <td style="text-align:right">
	        <?php echo ($sumExBGStatementLevel3 > 0)?number_format($sumExBGStatementLevel3,2):"-"; ?></td>
    <td style="text-align:right">
    <?php echo ($sumExPayLevel3 > 0)?number_format($sumExPayLevel3,2):"-"; ?>
    </td>
    <td style="text-align:right">
    <?php echo ($sumExRemainLevel3 > 0)?number_format($sumExRemainLevel3,2):"-"; ?>
    </td>
    <td style="text-align:right">
        <?php echo ($BGExternalLevel3[0]->ValBGIncrease > 0)?number_format($BGExternalLevel3[0]->ValBGIncrease,2):"-"; ?>
    </td>
    <td style="text-align:right">
           <?php echo ($BGExternalLevel3[0]->ValBGDecrease > 0)?number_format($BGExternalLevel3[0]->ValBGDecrease,2):"-"; ?>
    
    </td>
    <td style="text-align:right">
     <?php echo ($sumExAdjustLevel3 > 0)?number_format($sumExAdjustLevel3,2):"-"; ?>      
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
	$totalExBGAllot = $get->getTotalBGAllotEnternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],3,0,$allot[0]->AllotId,0,0,0,0,0,$SourceExId);
	$totalExBGStatement = 0;
	$totalExPay = 0;
	$totalExRemain = $totalExBGAllot - $totalExBGStatement - $totalExPay;  
	
	$TotalBGExternal = $get->getTotalBGIncreaseExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$adjustDetail[0]->AllotId,0,0,0,0,0,$SourceExId);	
	//ltxt::print_r($TotalBGInternal);
	
	$TotalExAdjust = ($totalExRemain + $TotalBGExternal[0]->ValBGIncrease) - $TotalBGExternal[0]->ValBGDecrease;
	
  ?>  
  <tr class="total">
    <td style="text-align:right;">รวมงบประมาณทั้งสิ้น (บาทถ้วน)</td>
    <td  style="text-align:right;">
    <?php echo ($totalExBGAllot > 0)?number_format($totalExBGAllot,2):"-"; ?>    
    </td>
    <td style="text-align:right;">
     <?php echo ($totalExBGStatement > 0)?number_format($totalExBGStatement,2):"-"; ?>
    </td>
    <td style="text-align:right;">
    <?php echo ($totalExPay > 0)?number_format($totalExPay,2):"-"; ?>
    </td>
    <td style="text-align:right;">
	 <?php echo ($totalExRemain > 0)?number_format($totalExRemain,2):"-"; ?>
    </td>
    <td style="text-align:right;">    
    <?php echo ($TotalBGExternal[0]->ValBGIncrease > 0)?number_format($TotalBGExternal[0]->ValBGIncrease,2):"-"; ?>
    </td>
    <td style="text-align:right;">
       <?php echo ($TotalBGExternal[0]->ValBGDecrease > 0)?number_format($TotalBGExternal[0]->ValBGDecrease,2):"-"; ?>
	</td>
    <td style="text-align:right;">
       <?php echo ($TotalExAdjust > 0)?number_format($TotalExAdjust,2):"-"; ?>  
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
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></div>
      
</form>



