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

$allot = $get->getAllotDetail($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
//ltxt::print_r($allot);
//if($allot){   foreach($allot as $ar ) { foreach( $ar as $k=>$v){ ${$k} = $v;} } }



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


function CalCostSum(CostItemCode){

var Obj2 = JQ('#BGAllot'+CostItemCode);
var Value2 = Obj2.val();
//alert(Value2);

				var sum =0;
				
				 JQ('input[rel=RelBGAllot]').each(function(){
						 num = parseFloat(JQ(this).val());
						 if( !isNaN(num)) sum = sum + num; 
				 });
				 
				 JQ('#SumBGAllot').val(sum);
					
}


function SaveScreen(form){	

	if(JQ('#SumBGAllot').val() >= parseFloat(1)){
   			 form.submit();
	}else{
	
		alert('กรุณาตรวจสอบงบกลั่นกรองต้องมากกว่าศูนย์');	
		JQ('#SumBGAllot').focus();
	}

}

function getfilterorg(){
	var BgtYear = $('BgtYear').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($ViewScreen);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}

function loadSCT(BgtYear){
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($ViewScreen);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}

function getfilterscr(){
	var ScreenLevel = $('ScreenLevel').value;
	window.location.href = '?mod=<?php echo lurl::dotPage($ViewScreen);?>&BgtYear=<?php echo $_REQUEST["BgtYear"];?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"];?>&ScreenLevel=' + ScreenLevel;
}


</script>

<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td class="td-descr"><b>ปีงบประมาณ : <?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?></b>
    <b>หน่วยงาน : <span id="org-list"><?php echo $get->getOrganizeCode($_REQUEST["OrganizeCode"],ltxt::getVar('OrganizeCode'));?></span></b>
    <b>กลั่นกรองงบ ระดับ : <span id="scr"><?php echo $get->getScreenName($_REQUEST["ScreenLevel"],'ScreenLevel');?></span></b>
    </td>
    </tr>
  </table>
</div>
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=savescreen" onSubmit="SaveScreen(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear']?>" />
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode']?>" />
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST['SCTypeId']?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST['ScreenLevel']?>" />
<input type="hidden" name="AllotId" id="AllotId" value="<?php echo $allot[0]->AllotId; ?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<td  style="padding-left:20px">งบประมาณแผ่นดิน</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;">
  <tr>
    <th style="width:68%">หมวดงบ/รายการงบรายจ่าย</th>
    <th  style="text-align:right; width:16%">งบขอจัดตั้ง (บาท)</th>
    <th style="text-align:right; width:16%">งบกลั่นกรอง (บาท)</th>
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
	$sumBGType = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],0,0,0,0,1,0,0,0,$CostTypeId);
	
	//$SumBGScreenType = 	$get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,0,0,$CostTypeId,0,0);
	
	$SumBGScreenType = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);

	

  ?>
  <tr class="cate">
    <td><?php echo $NumCate; ?>. <?php echo $CostTypeName; ?> | <a href="javascript:void(0)" id="a-cate<?php echo $NumCate; ?>" onclick="showHide(<?php echo $NumCate; ?>);" class="icon-decre txt-normal">ย่อ</a></td>
    <td style="text-align:right"><?php echo ($sumBGType > 0)?number_format($sumBGType,2):"-"; ?></td>
    <td style="text-align:right"><?php echo ($SumBGScreenType > 0)?number_format($SumBGScreenType,2):"-"; ?></td>
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
	
	$sumBGLevel1 = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],0,0,0,0,1,0,$CostItemCode,$ParentCode,0,$LevelId,$HasChild);
	
	$SumBGScreenLevel1 = 		$get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
  ?>
  <tr class="level1">
    <td style="text-indent:10px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?> <?php //echo " / ".$CostItemCode;?></td>
    <td style="text-align:right"><?php echo ($sumBGLevel1 > 0)?number_format($sumBGLevel1,2):"-"; ?></td>
    <td style="text-align:right"><?php echo ($SumBGScreenLevel1 > 0)?number_format($SumBGScreenLevel1,2):"-"; ?></td>
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
	
	$sumBGLevel2 = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],0,0,0,0,1,0,$CostItemCode,0,0,$LevelId,$HasChild);
	
	$SumBGScreenLevel2 = 	$get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
  ?>
  <tr class="level2">
    <td style="text-indent:20px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?> <?php //echo " / ".$CostItemCode;?></td>
    <td style="text-align:right"><?php echo ($sumBGLevel2 > 0)?number_format($sumBGLevel2,2):"-"; ?></td>
    <td style="text-align:right"><?php echo ($SumBGScreenLevel2 > 0)?number_format($SumBGScreenLevel2,2):"-"; ?></td>
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
	
	$sumBGLevel3 = $get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,1,0,$CostItemCode,$ParentCode,0,$LevelId,$HasChild);
	
	$SumBGScreenLevel3 = $get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);

  ?>
  <tr class="level3">
    <td style="text-indent:40px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?><?php //echo " / ".$CostItemCode;?></td>
    <td style="text-align:right"><?php echo ($sumBGLevel3 > 0)?number_format($sumBGLevel3,2):"-"; ?></td>
    <td style="text-align:right"><?php echo ($SumBGScreenLevel3 > 0)?number_format($SumBGScreenLevel3,2):"-"; ?></td>
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
 $TotalBG = $get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,1,0,0,0,0,0,0); 
 $TotalBGScreen = $get->getBGTotalInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,0,0,$_REQUEST["ScreenLevel"]);
 
 ?>
 
  <tr class="total">
    <td style="text-align:right;">รวมงบประมาณทั้งสิ้น (บาทถ้วน)</td>
    <td  style="text-align:right;"><?php echo ($TotalBG > 0)?number_format($TotalBG,2):"-"; ?></td>
    <td style="text-align:right;"><?php echo ($TotalBGScreen > 0)?number_format($TotalBGScreen,2):"-"; ?></td>
  </tr>
</table>


     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></div>
      
</form>



