<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

//นับระดับการกลั่นกรองงบ
$maxScreenLevel = $get->getMaxLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);

?>
<script type="text/javascript" src="js/jquery-1.6.1.js"></script>
<!--<script type="text/javascript" src="js/jAlert/jquery.alerts.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js"></script>
<script type="text/javascript" src="js/prettyPhoto/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="js/sortable/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery.clock.js"></script>
<script type="text/javascript" src="js/tiptip/jquery.tipTip.js"></script>-->
<script type="text/javascript" src="js/general_jq.js"></script>


<style>
.tbl-list {
}
.tbl-list th {
	border-bottom:1px solid #9e9e9e;
	padding: 3px;
	background-color:#c4c4c4; 
	color:#333;
	font-size:13px; 
	font-weight:bold;
}
.tbl-list td {
	border-bottom: 1px dotted #ccc;
	padding: 2px;
	line-height: 16px;
	font-size:13px; 
}

.icon-topic {
	padding:3px 3px 3px 25px;
	background-image: url(http://127.0.0.1/nationalhealth/images/budget/comment.png);
	background-repeat:no-repeat;
	background-position:3px 4px;
	color:#FFF;
	font-size:13px; 
	font-family: 'Microsoft Sans Serif';
	font-weight:bold;
}

.boxfilter-sub{
	padding:5px 5px 5px 5px;
	color:#333;
	font-weight:bold;
	border-bottom:1px solid #535e74;
	background-color:#ccc;
	font-size:13px; 
}

.tbl-cost {
	border-collapse:collapse;
}
.tbl-cost th {
	border:1px solid #999;
	text-align:center;
	padding:3px;
	background-color:#CCC;
	font-size:13px; 
}
.tbl-cost td {
	border:1px solid #999;
	padding:3px;
	font-size:13px; 
}
.tbl-cost .cate {
	background-color:#dbdbdb;
	font-weight:bold;
}
.tbl-cost .level1 {
	background-color:#eee;
}
.tbl-cost .total {
	font-weight:bold;
}
/*END ตารางรายการงบรายจ่าย*/
/*Icon*/
.icon-decre {
	background:url(http://127.0.0.1/nationalhealth/images/bullet/minimize.gif) left center no-repeat;
	padding-left:16px;
}
.icon-incre {
	background:url(http://127.0.0.1/nationalhealth/images/bullet/maximize.gif) left center no-repeat;
	padding-left:16px;
}
/*END Icon*/

.boxfiltertop{
	font-family: 'Microsoft Sans Serif';
	font-weight:bold; 
	font-size:18px; 
	color:#990000; 
	background-image:url(../../../nationalhealth/images/budget/dollar.png);
	background-repeat:no-repeat; 
	height:40px;
	padding-left:40px; 
	line-height: 40px;
	background-color:#eee;
	margin:0px;
}

.boxfiltersub{
	background-color:#EDEB8F;
	padding:7px 5px 5px 25px;
	background-image: url(../../../nationalhealth/images/budget/forward.png);
	background-repeat:no-repeat;
	background-position:3px 5px;
	font-family: 'Microsoft Sans Serif';
	font-size:13px; 
	color:#900;
}

.boxfilter{
	border-bottom:1px solid #535e74;
	background-color:#9089AD;
	padding-top:5px; 
	padding-bottom:5px;
	padding-left:3px;
	color:#FFF;
	font-size:13px; 
	font-family: 'Microsoft Sans Serif';
	/*font-weight:bold;*/
}
</style>
<script>
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

function showHideMonth(i){
	if(JQ('#body-catemonth'+i).is(':hidden')===true){
		JQ('#body-catemonth'+i).show('slow');
		JQ('#a-catemonth'+i).addClass('icon-decre');
		JQ('#a-catemonth'+i).removeClass('icon-incre');
		JQ('#a-catemonth'+i).html('ย่อ');
	}else{
		JQ('#body-catemonth'+i).hide('slow');
		JQ('#a-catemonth'+i).removeClass('icon-decre');
		JQ('#a-catemonth'+i).addClass('icon-incre');
		JQ('#a-catemonth'+i).html('ขยาย');
	}
}

function extogglemonth(i){
	if(JQ('#exmonth'+i).is(':hidden')===true){
		JQ('#exmonth'+i).show('fade');
		JQ('#a-exmonth'+i).addClass('icon-decre');
		JQ('#a-exmonth'+i).removeClass('icon-incre');
		JQ('#a-exmonth'+i).html('ย่อ');
	}else{
		JQ('#exmonth'+i).hide('fade');
		JQ('#a-exmonth'+i).removeClass('icon-decre');
		JQ('#a-exmonth'+i).addClass('icon-incre');
		JQ('#a-exmonth'+i).html('ขยาย');
	}
	
}


function extoggle(i){
	if(JQ('#ex'+i).is(':hidden')===true){
		JQ('#ex'+i).show('fade');
		JQ('#a-ex'+i).addClass('icon-decre');
		JQ('#a-ex'+i).removeClass('icon-incre');
		JQ('#a-ex'+i).html('ย่อ');
	}else{
		JQ('#ex'+i).hide('fade');
		JQ('#a-ex'+i).removeClass('icon-decre');
		JQ('#a-ex'+i).addClass('icon-incre');
		JQ('#a-ex'+i).html('ขยาย');
	}
	
}

</script>

<div class="topic-step"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>

<div class="boxfilter2" id="boxFilter">
    <b>ปีงบประมาณ : </b><?php echo $_REQUEST["BgtYear"]?>
    <b>หน่วยงาน : </b><?php echo $get->getOrgName($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode']);?>
</div>


<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
    <tr>
      <th align="left" width="15%" >ปีงบประมาณ :</th>
      <td ><?php echo $_REQUEST["BgtYear"]; ?></td>  
  </tr>
      <tr>
       <th align="left">ภายใต้แผนงาน :</th>
       <td><?php echo $get->getPItemCode($_REQUEST["PItemCode"]);?></td>
  </tr>   
    <tr>
     <th align="left" >ชื่อโครงการ :</th>
      <td ><?php echo $get->getPrjName($_REQUEST["PrjId"]); ?></td> 
  </tr>
     <tr>
     <th align="left" >ชื่อกิจกรรม :</th>
      <td ><?php echo $get->getActName($_REQUEST["PrjActId"]); ?></td> 
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
  <tr>
      	<th style="width:40%; text-align:center">ชื่อตัวชี้วัดโครงการ</th>
        <th style="width:20%; text-align:center">ประเภทตัวชี้วัด</th>
        <th style="width:20%; text-align:center">ค่าเป้าหมาย</th>
        <th style="width:20%; text-align:center">หน่วยนับ</th>
    </tr>
	<?php
    $indicatorSelect = $get->getIndicatorActSelect($_REQUEST["PrjActId"]);
 // ltxt::print_r($indicatorSelect);
     if($indicatorSelect){
         $count = 1;
            foreach($indicatorSelect as $r){
                foreach( $r as $k=>$v){ ${$k} = $v;}
    ?>    
    <tr>
    <td style="text-align:left"><?php echo $IndicatorName;?>&nbsp;</td>
    <td style="text-align:center"><?php echo $get->getIndTypeName($IndTypeId);?>&nbsp;</td>
    <td style="text-align:right"><?php echo $Value;?>&nbsp;</td>
    <td style="text-align:left"><?php echo $UnitName;?>&nbsp;</td>
	</tr>    
	<?php				
                $count++;
            }
        }else{
	?>		
    <tr>
    <td colspan="4" style="color:#900; height:50; text-align:center; vertical-align:middle">- - ไม่มีข้อมูล - -</td>
    </tr>
	<?php		
		}
    ?>     
	</table>    
    
    <?php //*********************************งบแผ่นดิน **************************************** ?> 
 
<div class="boxfilter2"><div class="icon-topic">งบประมาณแผ่นดิน</div></div>
 <table width="100%" border="0" cellspacing="0" cellpadding="0"  class="tbl-list" style="border-bottom:1px solid #535e74;"  >
 <tr height="25">
 <th style="padding:0px; text-align:left">งบประมาณตัวคูณ <a href="javascript:void(0)" onclick="extoggle(0);" id="a-ex0" class="icon-incre">ขยาย</a></th>
 <th style="padding:0px; width:200px;text-align:right">งบประมาณรวมทั้งสิ้น :</th>
 <th style="padding:0px; width:100px; text-align:right; " >
 <?php  
 $sumBGTopicIn=$get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel']);
 echo ($sumBGTopicIn > 0)?number_format($sumBGTopicIn,2):"0.00"; 
 ?>
 </th>
 <th style="padding:0px; width:10px">&nbsp;บาท&nbsp;</th>
 </tr >
 </table>

 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse; display:none" id="ex0" >
  <tr>
    <th rowspan="2">หมวดงบ/รายการงบรายจ่าย</th>
    <th colspan="2">ตัวคูณที่ 1</th>
    <th colspan="2">ตัวคูณที่ 2    </th>
    <th colspan="2">ตัวคูณที่ 3    </th>
    <th colspan="2">ตัวคูณที่ 4    </th>
    <th rowspan="2" style="width:100px;">งบประมาณ(บาท)</th>
  </tr>
  <tr>
    <th style="width:60px;">จำนวน</th>
    <th style="width:60px;">หน่วยนับ</th>
    <th style="width:60px;">จำนวน</th>
    <th style="width:60px;">หน่วยนับ</th>
    <th style="width:60px;">จำนวน</th>
    <th style="width:60px;">หน่วยนับ</th>
    <th style="width:60px;">จำนวน</th>
    <th style="width:60px;">หน่วยนับ</th>
  </tr>
  
  
  
  <!--วน loop หมวดงบรายจ่าย-->
  <?php
  $NumCate = 1; 
  $BGCate = $get->getCostTypeRecordSet();
  foreach($BGCate as $BGCateRow){ 
  	foreach($BGCateRow as $a=>$b){
		${$a} = $b;
	}
	
	$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId);
  ?>
  <tr class="cate">
    <td>
	<?php echo $NumCate; ?>. <?php echo $CostTypeName; ?> | 
	<?php if(!empty($SumTotalCost)){ ?>   
    <a href="javascript:void(0)" id="a-cate<?php echo $NumCate; ?>" onclick="showHide(<?php echo $NumCate; ?>);" class="icon-decre txt-normal">ย่อ</a>
    <?php }else{ ?>
    <a href="javascript:void(0)" id="a-cate<?php echo $NumCate; ?>" onclick="showHide(<?php echo $NumCate; ?>);" class="icon-incre txt-normal">ขยาย</a>
    <?php } ?>    
    </td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;"><?php echo ($SumTotalCost > 0)?number_format($SumTotalCost,2):"-"; ?></td>
  </tr>
  
  <tbody id="body-cate<?php echo $NumCate; ?>"  <?php if(empty($SumTotalCost)){ ?> style="display:none"<?php } ?>>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
   <?php
  $NumLevel1 = 1; 
  $BGLevel1 = $get->getCostItemRecordSet($CostTypeId);
  //ltxt::print_r($BGLevel1);
  foreach($BGLevel1 as $BGLevel1Row){ 
  	foreach($BGLevel1Row as $c=>$d){
		${$c} = $d;
	}
			$CSItem = $get->getListCostItem($CostItemCode,$ParentCode);
			//$SumTotalCost = $get->getTotalPrjInternalX4(0,0,0,$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],0,0,0,$CostItemCode,$ParentCode,0,$LevelId,$HasChild);
			$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
  ?>
  <tr class="level1">
    <td style="text-indent:10px;">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;"><?php echo ($SumTotalCost > 0)?number_format($SumTotalCost,2):"-"; ?></td>
  </tr>
  
		    <!--รายการค่าใช้จ่ายชี้แจง-->
			<?php
			$CRI=0;
			$CR=0;
			//$CRequireItemLevel1 = $get->getItemRequireInternal($CostItemCode,0,$_REQUEST['PrjId'],$_REQUEST['PrjDetailId']);
			$CRequireItemLevel1 = $get->getItemRequireInternal($CostItemCode,$_REQUEST["PrjActId"],$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"]);
			//ltxt::print_r($CRequireItem);
			foreach($CRequireItemLevel1 as $RCRequireItemLevel1){
				foreach($RCRequireItemLevel1 as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:30px;"><?php echo "|-- ".$Detail; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value1,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit1)?$get->getUnitName($Unit1):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value2,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit2)?$get->getUnitName($Unit2):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value3,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit3)?$get->getUnitName($Unit3):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value4,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit4)?$get->getUnitName($Unit4):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($SumCost,2); ?></td>
		  </tr>
		  <?php
				$CR++; 
			}
			?>
			<!--END รายการชี้แจง-->

  
  
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
		$CSItem = $get->getListCostItem($CostItemCode,$ParentCode);
		//$SumTotalCost = $get->getTotalPrjInternalX4(0,0,0,$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],0,0,0,$CostItemCode,0,0,$LevelId,$HasChild);
		$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);

  ?>
  <tr class="level2">
    <td style="text-indent:20px;">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;"><?php echo ($SumTotalCost > 0)?number_format($SumTotalCost,2):"-"; ?></td>
  </tr>
  
		    <!--รายการค่าใช้จ่ายชี้แจง-->
			<?php 
			$CR=0;
			//$CRequireItem = $get->getItemRequireInternal($CostItemCode,$_REQUEST["PrjActId"],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId']);
			
			$CRequireItemLevel2 = $get->getItemRequireInternal($CostItemCode,$_REQUEST["PrjActId"],$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"]);

			//$CRequireItemLevel2 = $get->getItemRequireInternal($CostItemCode,0,$_REQUEST['PrjId'],$_REQUEST['PrjDetailId']);
			//ltxt::print_r($CRequireItemLevel2);		
			foreach($CRequireItemLevel2 as $RCRequireItemLevel2){
				foreach($RCRequireItemLevel2 as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:50px;"><?php echo "|-- ".$Detail; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value1,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit1)?$get->getUnitName($Unit1):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value2,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit2)?$get->getUnitName($Unit2):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value3,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit3)?$get->getUnitName($Unit3):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value4,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit4)?$get->getUnitName($Unit4):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($SumCost,2); ?></td>
		  </tr>
		  <?php
				$CR++; 
			}
			?>
			<!--END รายการชี้แจง-->
  
  <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->  
  <?php if($HasChild == Y){ ?>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 3-->
   <?php
  $NumLevel3 = 1; 
  $BGLevel3 = $get->getCostItemRecordSet($CostTypeId,3,$CostItemCode);
  foreach($BGLevel3 as $BGLevel3Row){ 
  	foreach($BGLevel3Row as $g=>$h){
		${$g} = $h;
	}
			$CSItem = $get->getListCostItem($CostTypeId);
			//$SumTotalCost = $get->getTotalPrjInternalX4(0,0,0,$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],0,0,0,$CostItemCode,$ParentCode,0,$LevelId,$HasChild);
			$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);

  ?>
  <tr class="level3">
    <td style="text-indent:40px;">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?></td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;"><?php echo ($SumTotalCost > 0)?number_format($SumTotalCost,2):"-"; ?></td>
  </tr>
		    <!--รายการค่าใช้จ่ายชี้แจง-->
	 <?php 
			$CR=0;
			//$CRequireItem = $get->getItemRequireInternal($CostItemCode,$_REQUEST["PrjActId"],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId']);	
			//$CRequireItemLevel3 = $get->getItemRequireInternal($CostItemCode,0,$_REQUEST['PrjId'],$_REQUEST['PrjDetailId']);		
			$CRequireItemLevel3 = $get->getItemRequireInternal($CostItemCode,$_REQUEST["PrjActId"],$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"]);
			
			//ltxt::print_r($CRequireItemLevel3);	
			foreach($CRequireItemLevel3 as $RCRequireItemLevel3){
				foreach($RCRequireItemLevel3 as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:80px;"><?php echo "|-- ".$Detail; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value1,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit1)?$get->getUnitName($Unit1):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value2,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit2)?$get->getUnitName($Unit2):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value3,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit3)?$get->getUnitName($Unit3):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value4,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit4)?$get->getUnitName($Unit4):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($SumCost,2); ?></td>
		  </tr>
		  <?php
			$CR++; 
			}
			?>
			<!--END รายการชี้แจง-->

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
  <tr class="total">
    <td colspan="9" class="td-sum-total" style="text-align:right;">(<?php echo JThaiBaht::_($sumBGTopicIn); ?>) รวมงบประมาณทั้งสิ้น</td>
     <td class="td-sum-total" style="text-align:right; width:100px"><?php echo ($sumBGTopicIn > 0)?number_format($sumBGTopicIn,2):"0.00"; ?></td>
  </tr>
</table>


<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="border-collapse:collapse;" >
 <tr>
 <td style="padding:0px;"><div class="boxfilter-sub">งบประมาณจำแนกเดือน  <a href="javascript:void(0)" onclick="extogglemonth(0);" id="a-exmonth0" class="icon-decre">ย่อ</a></div></td>
 <td style="padding:0px; width:200px;text-align:right"><div class="boxfilter-sub">งบประมาณรวมทั้งสิ้น :</div></td>
 <td style="padding:0px; width:100px; text-align:right; " >
 <div class="boxfilter-sub">
 <?php   
	$sumBGMonthTopicIn=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0);
 	echo ($sumBGMonthTopicIn > 0)?number_format($sumBGMonthTopicIn,2):"0.00"; 
?>
</div>
 </td>
 <td style="padding:0px; width:10px"><div class="boxfilter-sub">บาท</div></td>
 </tr >
</table>-->
 
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  class="tbl-list" style="border-bottom:1px solid #535e74;"  >
 <tr height="25">
 <th style="padding:0px; text-align:left">งบประมาณจำแนกเดือน  <a href="javascript:void(0)" onclick="extogglemonth(0);" id="a-exmonth0" class="icon-incre">ขยาย</a></th>
 <th style="padding:0px; width:200px;text-align:right">งบประมาณรวมทั้งสิ้น :</th>
 <th style="padding:0px; width:100px; text-align:right; " >
 <?php   
	$sumBGMonthTopicIn=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0);
 	echo ($sumBGMonthTopicIn > 0)?number_format($sumBGMonthTopicIn,2):"0.00"; 
?>
 </th>
 <th style="padding:0px; width:10px">&nbsp;บาท&nbsp;</th>
 </tr >
 </table>

<table  width="1220" border="0" cellspacing="0" cellpadding="0" class="tbl-cost"  id="exmonth0" style="display:none">
  <tr>
    <th rowspan="2" style="width:400px" >หมวดงบ/รายการงบรายจ่าย</th>
    <th rowspan="2" style="width:100px;">งบเดือน/ไตรมาส(บาท)</th>
    <th colspan="3" style="width:180px;">ไตรมาส1</th>
    <th colspan="3" style="width:180px;">ไตรมาส2</th>
    <th colspan="3" style="width:180px;">ไตรมาส3</th>
    <th colspan="3" style="width:180px;">ไตรมาส4</th>
  </tr>
  <tr>
    <th style="width:60px;">ต.ค</th>
    <th style="width:60px;">พ.ย</th>
    <th style="width:60px;">ธ.ค</th>
    <th style="width:60px;">ม.ค</th>
    <th style="width:60px;">ก.พ</th>
    <th style="width:60px;">มี.ค</th>
    <th style="width:60px;">เม.ย</th>
    <th style="width:60px;">พ.ค</th>
    <th style="width:60px;">มิ.ย</th>
    <th style="width:60px;">ก.ค</th>
    <th style="width:60px;">ส.ค</th>
    <th style="width:60px;">ก.ย</th>
  </tr>

  <!--วน loop หมวดงบรายจ่าย-->
  <?php
  $NumCateMonth = 1; 
  $BGCateMonth = $get->getCostTypeRecordSet();
 // ltxt::print_r($BGCateMonth);
  foreach($BGCateMonth as $BGCateMonthRow){ 
  	foreach($BGCateMonthRow as $a=>$b){
		${$a} = $b;
	}
		
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId);
	
	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,10,0);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,11,0);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,12,0);

	//ไตรมาสที่ 2
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,1,0);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,2,0);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,3,0);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,4,0);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,5,0);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,6,0);

	//ไตรมาสที่ 4
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,7,0);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,8,0);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,9,0);

  ?>
  <tr class="cate">
    <td   style="width:400px" >
	<?php echo $NumCateMonth; ?>. <?php echo $CostTypeName; ?> | 
    
	<?php if(!empty($SumCostMonth)){ ?>   
	<a href="javascript:void(0)" id="a-catemonth<?php echo $NumCateMonth; ?>" onClick="showHideMonth(<?php echo $NumCateMonth; ?>);" class="icon-decre txt-normal">ย่อ</a>     
    <?php }else{ ?>
	<a href="javascript:void(0)" id="a-catemonth<?php echo $NumCateMonth; ?>" onClick="showHideMonth(<?php echo $NumCateMonth; ?>);" class="icon-incre txt-normal">ขยาย</a>        
	<?php } ?>    
    </td>
    <td style="text-align:right; width:100px;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td style="text-align:right; width:60px;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td style="text-align:right; width:60px;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td style="text-align:right; width:60px;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
   <td style="text-align:right; width:60px;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td style="text-align:right; width:60px;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td style="text-align:right; width:60px;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
   <td style="text-align:right; width:60px;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td style="text-align:right; width:60px;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td style="text-align:right; width:60px;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
   <td style="text-align:right; width:60px;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td style="text-align:right; width:60px;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td style="text-align:right; width:60px;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
  </tr>
    <tbody id="body-catemonth<?php echo $NumCateMonth; ?>"  <?php if(empty($SumCostMonth)){ ?> style="display:none"<?php } ?>>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
   <?php
  $NumLevel1 = 1; 
  $BGLevel1 = $get->getCostItemRecordSet($CostTypeId);
 //ltxt::print_r($BGLevel1);
  foreach($BGLevel1 as $BGLevel1Row){ 
  	foreach($BGLevel1Row as $c=>$d){
		${$c} = $d;
	}

	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,0);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,0);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,0);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,0);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,0);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,0);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,0);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,0);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,0);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,0);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,0);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,0);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,0);

  ?>
  <tr class="level1">
    <td style="text-indent:10px;">
      <?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></a></td>
    <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
   <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
   <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
   <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
  </tr>
  
  
  			<?php 
			$CR=0;
			//$CRequireItem = $get->getItemRequireInternal($CostItemCode,$PrjActId);//ltxt::print_r($CRequireItem);
			$CRequireItemLevel1 = $get->getItemRequireInternal($CostItemCode,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId']);
			foreach($CRequireItemLevel1 as $RCRequireItemLevel1){
				foreach($RCRequireItemLevel1 as $k=>$v){
					${$k} = $v;
				}
				
	if($CostIntId){			
				
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostIntId);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostIntId);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostIntId);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostIntId);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostIntId);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostIntId);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostIntId);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostIntId);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostIntId);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostIntId);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostIntId);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostIntId);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostIntId);
				
	}
				

			?>
		   <tr>
			<td style="text-indent:30px;"><?php echo "|-- ".$Detail; ?></td>
    <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
   <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
   <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
   <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
		  </tr>
		  <?php
				$CR++; 
			}
			?>
			<!--END รายการชี้แจง-->

  
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

	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,0);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,0);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,0);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,0);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,0);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,0);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,0);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,0);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,0);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,0);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,0);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,0);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,0);

  ?>
  <tr class="level2">
    <td style="text-indent:20px;">
      <?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></td>
    <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
   <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
   <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
   <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
    </tr>
  
		    <!--รายการค่าใช้จ่ายชี้แจง-->
	   <?php 
			$CR=0;
			//$CRequireItem = $get->getItemRequireInternal($CostItemCode,$PrjActId);
			$CRequireItemLevel2 = $get->getItemRequireInternal($CostItemCode,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId']);
			foreach($CRequireItemLevel2 as $RCRequireItemLevel2){
				foreach($RCRequireItemLevel2 as $k=>$v){
					${$k} = $v;
				}
				
				
	if($CostIntId){			
				
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostIntId);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostIntId);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostIntId);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostIntId);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostIntId);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostIntId);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostIntId);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostIntId);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostIntId);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostIntId);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostIntId);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostIntId);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostIntId);
				
	}				
				
			?>
		   <tr>
		<td style="text-indent:50px;"><?php echo "|-- ".$Detail; ?></td>
    <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
   <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
   <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
   <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
        </tr>
		  <?php
				$CR++; 
			}
			?>
			<!--END รายการชี้แจง-->

  
  
  
  
  <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->  
  <?php if($HasChild == Y){ ?>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 3-->
   <?php
  $NumLevel3 = 1; 
  $BGLevel3 = $get->getCostItemRecordSet($CostTypeId,3,$CostItemCode);
  foreach($BGLevel3 as $BGLevel3Row){ 
  	foreach($BGLevel3Row as $g=>$h){
		${$g} = $h;
	}
	
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,0);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,0);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,0);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,0);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,0);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,0);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,0);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,0);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,0);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,0);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,0);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,0);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,0);	
  ?>
  <tr class="level3">
    <td style="text-indent:40px;">
	<?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?>
    
    <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
   <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
   <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
   <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
    </tr>
		    <!--รายการค่าใช้จ่ายชี้แจง-->
			<?php 
			$CR=0;
			//$CRequireItem = $get->getItemRequireInternal($CostItemCode,$PrjActId);//ltxt::print_r($CRequireItem);
			$CRequireItemLevel3 = $get->getItemRequireInternal($CostItemCode,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId']);			
			//ltxt::print_r($CRequireItemLevel3);
			foreach($CRequireItemLevel3 as $RCRequireItemLevel3){
				foreach($RCRequireItemLevel3 as $k=>$v){
					${$k} = $v;
			}
		
	if($CostIntId){			
				
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostIntId);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostIntId);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostIntId);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostIntId);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostIntId);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostIntId);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostIntId);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostIntId);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostIntId);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostIntId);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostIntId);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostIntId);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostIntId);
				
	}
				
			?>
		   <tr>
			<td style="text-indent:80px;"><?php echo "|-- ".$Detail; ?></td>
    <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
   <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
   <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
   <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
  
          </tr>
		  <?php
			$CR++; 
			}
			?>
			<!--END รายการชี้แจง-->  
  
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
  $NumCateMonth++;
  } ?>
  <!--END วน loop หมวดงบรายจ่าย-->
<?php
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0);
	
	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,10,0);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,11,0);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,12,0);

	//ไตรมาสที่ 2
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,1,0);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,2,0);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,3,0);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,4,0);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,5,0);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,6,0);

	//ไตรมาสที่ 4
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,7,0);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,8,0);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,9,0);

?>
  <tr class="total">
    <td style="text-align:right; " >รวมงบประมาณทั้งสิ้น</td>
    <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
   <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
   <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
   <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
  </tr>
</table>


 
<?php //******************************** จบ งบแผ่นดิน ************************************?>

 <?php //******************************** เงินนอกงบ ************************************?>
 <?php if($_REQUEST["SCTypeId"] == 3 || ($_REQUEST["SCTypeId"] == 2 && $_REQUEST["ScreenLevel"] == $maxScreenLevel)){ ?>
 <?php

$getExName=$get->getSourceName();
foreach($getExName as $sName){
	foreach($sName as $k=>$v){
		${$k} = $v;
	}
	
?>

<input type="hidden" name="SourceExId[]" id="SourceExId" value="<?php echo $SourceExId; ?>" />

<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0"   style="border-collapse:collapse;" >
  <tr>
 <td colspan="4" style="padding:0px;"><div class="boxfilter2"><div class="icon-topic">เงินนอกงบประมาณ [ <?php echo $SourceExName;?> ]</div></div></td>
 </tr> 

 <tr>
 <td style="padding:0px;"><div class="boxfilter-sub">งบประมาณตัวคูณ <a href="javascript:void(0)" onclick="extoggle(<?php echo $SourceExId; ?>);" id="a-ex<?php echo $SourceExId; ?>" class="icon-decre">ย่อ</a></div></td>
 <td style="padding:0px; width:200px;text-align:right"><div class="boxfilter-sub">งบประมาณรวมทั้งสิ้น :</div></td>
 <td style="padding:0px; width:100px; text-align:right; " >
 <div class="boxfilter-sub">
 <?php   
	$sumBGTopicEx=$get->getTotalPrjExternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId);	
 	echo ($sumBGTopicEx > 0)?number_format($sumBGTopicEx,2):"0.00"; 
?>
</div>
 </td>
 <td style="padding:0px; width:10px"><div class="boxfilter-sub">บาท</div></td>
 </tr > 
 </table>-->
 
 <div class="boxfilter2"><div class="icon-topic">เงินนอกงบประมาณ [ <?php echo $SourceExName;?> ]</div></div>
 <table width="100%" border="0" cellspacing="0" cellpadding="0"  class="tbl-list" style="border-bottom:1px solid #535e74;"  >
 <tr height="25">
 <th style="padding:0px; text-align:left">งบประมาณตัวคูณ <a href="javascript:void(0)" onclick="extoggle(<?php echo $SourceExId; ?>);" id="a-ex<?php echo $SourceExId; ?>" class="icon-incre">ขยาย</a></th>
 <th style="padding:0px; width:200px;text-align:right">งบประมาณรวมทั้งสิ้น :</th>
 <th style="padding:0px; width:100px; text-align:right; " >
 <?php   
	$sumBGTopicEx=$get->getTotalPrjExternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId);	
 	echo ($sumBGTopicEx > 0)?number_format($sumBGTopicEx,2):"0.00"; 
?>
 </th>
 <th style="padding:0px; width:10px">&nbsp;บาท&nbsp;</th>
 </tr >
 </table>
 
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost " style="border-collapse:collapse; display:none"  id="ex<?php echo $SourceExId; ?>" >
  <tr>
    <th rowspan="2">หมวดงบ/รายการงบรายจ่าย</th>
    <th colspan="2">ตัวคูณที่ 1</th>
    <th colspan="2">ตัวคูณที่ 2    </th>
    <th colspan="2">ตัวคูณที่ 3    </th>
    <th colspan="2">ตัวคูณที่ 4    </th>
    <th rowspan="2" style="width:100px;">งบประมาณ(บาท)</th>
  </tr>
  <tr>
    <th style="width:60px;">จำนวน</th>
    <th style="width:60px;">หน่วยนับ</th>
    <th style="width:60px;">จำนวน</th>
    <th style="width:60px;">หน่วยนับ</th>
    <th style="width:60px;">จำนวน</th>
    <th style="width:60px;">หน่วยนับ</th>
    <th style="width:60px;">จำนวน</th>
    <th style="width:60px;">หน่วยนับ</th>
  </tr>
  <!--วน loop หมวดงบรายจ่าย-->
<?php
   	$NumCate2=1;
	$listEx = $get->getCostTypeRecordSet();
		foreach($listEx as $rEx){
			foreach($rEx as $k=>$v){
				${$k} = $v;
			}
			$CostTypeName2 = $CostTypeName;
			$CostTypeId2 = $CostTypeId;
			$SumTotalCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,0,0,$CostTypeId2);
			
  ?>
  <tr class="cate">
    <td>
	<?php echo $NumCate2; ?>. <?php echo $CostTypeName2; ?> | 
   	<?php if(!empty($SumTotalCost)){ ?>   
    <a href="javascript:void(0)" id="a-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>" onclick="showHideTwo<?php echo $SourceExId; ?>(<?php echo $NumCate2; ?>);" class="icon-decre txt-normal">ย่อ</a> 
    <?php }else{ ?>
    <a href="javascript:void(0)" id="a-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>" onclick="showHideTwo<?php echo $SourceExId; ?>(<?php echo $NumCate2; ?>);" class="icon-incre txt-normal">ขยาย</a> 
    <?php } ?>    
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align:right;"><?php echo ($SumTotalCost > 0)?number_format($SumTotalCost,2):"-"; ?></td>
  </tr>
  
  <tbody id="body-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>"  <?php if(empty($SumTotalCost)){ ?> style="display:none"<?php } ?>>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
    <?php
  $NumLevel11 = 1; 
  $BGLevel11 = $get->getCostItemRecordSet($CostTypeId2);
  foreach($BGLevel11 as $BGLevel11Row){ 
  	foreach($BGLevel11Row as $c=>$d){
		${$c} = $d;
	}
	$CostName3 = $CostName;
	$CostItemCode3 = $CostItemCode;
	$CostTypeId3 = $CostTypeId;
	$ParentCode3 = $ParentCode;
	$LevelId3 = $LevelId;
	$HasChild3 = $HasChild;	

			$CSItem = $get->getListCostItem($CostItemCode,$ParentCode);
			//$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode,0,$CostTypeId,$LevelId,$HasChild);
			$SumTotalCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3);

  ?>
  <tr class="level1">
    <td style="text-indent:10px;">
	<?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?> <?php echo $CostName3; ?> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align:right;"><?php echo ($SumTotalCost > 0)?number_format($SumTotalCost,2):"-"; ?></td>
  </tr>
  
		    <!--รายการค่าใช้จ่ายชี้แจง-->
<?php
			$CRI=0;
			$CR=0;
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$_REQUEST['PrjId'],$SourceExId);
			
			$CRequireItemLevel1 = $get->getItemRequireExternal($CostItemCode3,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$SourceExId);					
			
			foreach($CRequireItemLevel1 as $RCRequireItemLevel1){
				foreach($RCRequireItemLevel1 as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:30px;"><?php echo "|-- ".$Detail; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value1,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit1)?$get->getUnitName($Unit1):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value2,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit2)?$get->getUnitName($Unit2):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value3,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit3)?$get->getUnitName($Unit3):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value4,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit4)?$get->getUnitName($Unit4):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($SumCost,2); ?></td>
		  </tr>
		  <?php
				$CR++; 
			}
			?>
			<!--END รายการชี้แจง-->

  
  
  <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->  
  <?php if($HasChild == Y){ ?>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 2-->
   <?php
  $NumLevel22 = 1; 
  $BGLevel22 = $get->getCostItemRecordSet($CostTypeId3,2,$CostItemCode3);
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

		$CSItem = $get->getListCostItem($CostItemCode,$ParentCode);
		//$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		$SumTotalCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4);

  ?>
  <tr class="level2">
    <td style="text-indent:20px;">
	<?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?>.<?php echo $NumLevel22; ?> <?php echo $CostName4; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align:right;"><?php echo ($SumTotalCost > 0)?number_format($SumTotalCost,2):"-"; ?></td>
  </tr>
  
		    <!--รายการค่าใช้จ่ายชี้แจง-->
			<?php 
			$CR=0;
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$_REQUEST['PrjId'],$SourceExId);
			$CRequireItemLevel2 = $get->getItemRequireExternal($CostItemCode4,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$SourceExId);		
				
			foreach($CRequireItemLevel2 as $RCRequireItemLevel2){
				foreach($RCRequireItemLevel2 as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:50px;"><?php echo "|-- ".$Detail; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value1,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit1)?$get->getUnitName($Unit1):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value2,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit2)?$get->getUnitName($Unit2):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value3,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit3)?$get->getUnitName($Unit3):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value4,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit4)?$get->getUnitName($Unit4):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($SumCost,2); ?></td>
		  </tr>
		  <?php
				$CR++; 
			}
			?>
			<!--END รายการชี้แจง-->
  
  <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->  
  <?php if($HasChild == Y){ ?>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 3-->
    <?php
  $NumLevel33 = 1; 
  $BGLevel33 = $get->getCostItemRecordSet($CostTypeId4,3,$CostItemCode4);
 //ltxt::print_r($BGLevel33);
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

			$CSItem = $get->getListCostItem($CostTypeId5);
			//$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
 			$SumTotalCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5);

  ?>
  <tr class="level3">
    <td style="text-indent:40px;">
	<?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?>.<?php echo $NumLevel22; ?>.<?php echo $NumLevel33; ?> <?php echo $CostName5; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align:right;"><?php echo ($SumTotalCost > 0)?number_format($SumTotalCost,2):"-"; ?></td>
  </tr>
		    <!--รายการค่าใช้จ่ายชี้แจง-->
	 <?php 
			$CR=0;
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$_REQUEST['PrjId'],$SourceExId);
			
			$CRequireItemLevel3 = $get->getItemRequireExternal($CostItemCode5,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$SourceExId);
			
			//ltxt::print_r($CRequireItemLevel3);
			
			foreach($CRequireItemLevel3 as $RCRequireItemLevel3){
				foreach($RCRequireItemLevel3 as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:80px;"><?php echo "|-- ".$Detail; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value1,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit1)?$get->getUnitName($Unit1):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value2,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit2)?$get->getUnitName($Unit2):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value3,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit3)?$get->getUnitName($Unit3):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($Value4,2); ?></td>
		   <td class="td-descr" style="text-align:left;"><?php echo ($Unit4)?$get->getUnitName($Unit4):"N/A"; ?></td>
		   <td class="td-descr" style="text-align:right;"><?php echo number_format($SumCost,2); ?></td>
		  </tr>
		  <?php
			$CR++; 
			}
			?>
			<!--END รายการชี้แจง-->

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
  <tr class="total">
    <td colspan="9" class="td-sum-total" style="text-align:right;">(<?php echo JThaiBaht::_($sumBGTopicEx); ?>) รวมงบประมาณทั้งสิ้น</td>
    <td class="td-sum-total" style="text-align:right; width:100px"><?php echo ($sumBGTopicEx > 0)?number_format($sumBGTopicEx,2):"0.00"; ?></td>
  </tr>
</table>


<!--<table width="100%" border="0" cellspacing="0" cellpadding="0"  style="border-collapse:collapse;"  >
 <tr>
 <td style="padding:0px;"><div class="boxfilter-sub">งบประมาณจำแนกเดือน  <a href="javascript:void(0)" onclick="extogglemonth(<?php echo $SourceExId;?>);" id="a-exmonth<?php echo $SourceExId;?>" class="icon-decre">ย่อ</a></div></td>
 <td style="padding:0px; width:200px;text-align:right"><div class="boxfilter-sub">งบประมาณรวมทั้งสิ้น :</div></td>
 <td style="padding:0px; width:100px; text-align:right; " >
 <div class="boxfilter-sub">
 <?php   
	$sumBGMonthTopicEx=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0);
 	echo ($sumBGMonthTopicEx > 0)?number_format($sumBGMonthTopicEx,2):"0.00"; 
?>
</div>
 </td>
 <td style="padding:0px; width:10px"><div class="boxfilter-sub">บาท</div></td>
 </tr > 
 </table>-->
 
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="tbl-list" style="border-bottom:1px solid #535e74;"  >
 <tr height="25">
 <th style="padding:0px; text-align:left">งบประมาณจำแนกเดือน  <a href="javascript:void(0)" onclick="extogglemonth(<?php echo $SourceExId;?>);" id="a-exmonth<?php echo $SourceExId;?>" class="icon-incre">ขยาย</a></th>
 <th style="padding:0px; width:200px;text-align:right">งบประมาณรวมทั้งสิ้น :</th>
 <th style="padding:0px; width:100px; text-align:right; " >
 <?php   
	$sumBGMonthTopicEx=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0);
 	echo ($sumBGMonthTopicEx > 0)?number_format($sumBGMonthTopicEx,2):"0.00"; 
?>
 </th>
 <th style="padding:0px; width:10px">&nbsp;บาท&nbsp;</th>
 </tr >
 </table> 

<table  width="1220" border="0" cellspacing="0" cellpadding="0" class="tbl-cost"  id="exmonth<?php echo $SourceExId; ?>" style="display:none">
  <tr>

    <th rowspan="2" style="width:400px" >หมวดงบ/รายการงบรายจ่าย</th>
    <th rowspan="2" style="width:100px;">งบเดือน/ไตรมาส<br />(บาท)</th>
    <th colspan="3" style="width:180px;">ไตรมาส1</th>
    <th colspan="3" style="width:180px;">ไตรมาส2</th>
    <th colspan="3" style="width:180px;">ไตรมาส3</th>
    <th colspan="3" style="width:180px;">ไตรมาส4</th>
  </tr>
  <tr>
    <th style="width:60px;">ต.ค</th>
    <th style="width:60px;">พ.ย</th>
    <th style="width:60px;">ธ.ค</th>
    <th style="width:60px;">ม.ค</th>
    <th style="width:60px;">ก.พ</th>
    <th style="width:60px;">มี.ค</th>
    <th style="width:60px;">เม.ย</th>
    <th style="width:60px;">พ.ค</th>
    <th style="width:60px;">มิ.ย</th>
    <th style="width:60px;">ก.ค</th>
    <th style="width:60px;">ส.ค</th>
    <th style="width:60px;">ก.ย</th>
  </tr>
  
  
  <!--วน loop หมวดงบรายจ่าย-->
<?php
   	$NumCateMonth2=1;
	$listEx = $get->getCostTypeRecordSet();
		foreach($listEx as $rEx){
			foreach($rEx as $k=>$v){
				${$k} = $v;
			}
			$CostTypeName2 = $CostTypeName;
			$CostTypeId2 = $CostTypeId;

			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,10,0);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,11,0);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,12,0);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,1,0);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,2,0);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,3,0);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,4,0);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,5,0);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,6,0);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,7,0);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,8,0);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,9,0);



  ?>
  <tr class="cate">
    <td>
	<?php echo $NumCateMonth2; ?>. <?php echo $CostTypeName2; ?> | 
    
	<?php if(!empty($SumCostMonth)){ ?>   
    <a href="javascript:void(0)" id="a-catetwomonth<?php echo $SourceExId; ?><?php echo $NumCateMonth2; ?>" onclick="showHideTwoMonth<?php echo $SourceExId; ?>(<?php echo $NumCateMonth2; ?>);" class="icon-decre txt-normal">ย่อ</a> 
    <?php }else{ ?>
    <a href="javascript:void(0)" id="a-catetwomonth<?php echo $SourceExId; ?><?php echo $NumCateMonth2; ?>" onclick="showHideTwoMonth<?php echo $SourceExId; ?>(<?php echo $NumCateMonth2; ?>);" class="icon-incre txt-normal">ขยาย</a> 
	<?php } ?>     
    </td>
    <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
   <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
   <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
   <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
  </tr>
  
  <tbody id="body-catetwomonth<?php echo $SourceExId; ?><?php echo $NumCateMonth2; ?>" <?php if(empty($SumCostMonth)){ ?> style="display:none"<?php } ?>>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
    <?php
  $NumLevel11 = 1; 
  $BGLevel11 = $get->getCostItemRecordSet($CostTypeId2);
  foreach($BGLevel11 as $BGLevel11Row){ 
  	foreach($BGLevel11Row as $c=>$d){
		${$c} = $d;
	}
	$CostName3 = $CostName;
	$CostItemCode3 = $CostItemCode;
	$CostTypeId3 = $CostTypeId;
	$ParentCode3 = $ParentCode;
	$LevelId3 = $LevelId;
	$HasChild3 = $HasChild;	

			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,0,0);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,10,0);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,11,0);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,12,0);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,1,0);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,2,0);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,3,0);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,4,0);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,5,0);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,6,0);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,7,0);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,8,0);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,9,0);

  ?>
  <tr class="level1">
    <td style="text-indent:10px;">
      <?php echo $NumCateMonth2; ?>.<?php echo $NumLevel11; ?> <?php echo $CostName3; ?> </td>
    <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
   <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
   <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
   <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>   
    </tr>
  
		    <!--รายการค่าใช้จ่ายชี้แจง-->
<?php
			$CRI=0;
			$CR=0;
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$_REQUEST['PrjId'],$SourceExId);
			
			$CRequireItemLevel1 = $get->getItemRequireExternal($CostItemCode3,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$SourceExId);					
			//ltxt::print_r($CRequireItemLevel1);
			foreach($CRequireItemLevel1 as $RCRequireItemLevel1){
				foreach($RCRequireItemLevel1 as $k=>$v){
					${$k} = $v;
				}
				
			if($CostExtId){	
			
			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,0,$CostExtId);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,10,$CostExtId);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,11,$CostExtId);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,12,$CostExtId);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,1,$CostExtId);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,2,$CostExtId);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,3,$CostExtId);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,4,$CostExtId);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,5,$CostExtId);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,6,$CostExtId);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,7,$CostExtId);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,8,$CostExtId);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,9,$CostExtId);
				
			}
	
			?>
		   <tr>
		   <td style="text-indent:30px;"><?php echo "|-- ".$Detail; ?></td>
            <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
            <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
            <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
            <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
           <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
            <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
            <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
           <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
            <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
            <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
           <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
            <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
            <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>             
	      </tr>
		  <?php
				$CR++; 
			}
			?>
			<!--END รายการชี้แจง-->

  
  
  <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->  
  <?php if($HasChild == Y){ ?>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 2-->
   <?php
  $NumLevel22 = 1; 
  $BGLevel22 = $get->getCostItemRecordSet($CostTypeId3,2,$CostItemCode3);
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

			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,0,0);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,10,0);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,11,0);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,12,0);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,1,0);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,2,0);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,3,0);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,4,0);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,5,0);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,6,0);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,7,0);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,8,0);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,9,0);

  ?>
  <tr class="level2">
    <td style="text-indent:20px;"><?php echo $NumCateMonth2; ?>.<?php echo $NumLevel11; ?>.<?php echo $NumLevel22; ?> <?php echo $CostName4; ?></td>
    <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
   <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
   <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
   <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>     
    
    </tr>
  
		    <!--รายการค่าใช้จ่ายชี้แจง-->
			<?php 
			$CR=0;
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$_REQUEST['PrjId'],$SourceExId);
			$CRequireItemLevel2 = $get->getItemRequireExternal($CostItemCode4,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$SourceExId);		
				
			foreach($CRequireItemLevel2 as $RCRequireItemLevel2){
				foreach($RCRequireItemLevel2 as $k=>$v){
					${$k} = $v;
				}
				
			if($CostExtId){	
				
			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,0,$CostExtId);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,10,$CostExtId);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,11,$CostExtId);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,12,$CostExtId);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,1,$CostExtId);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,2,$CostExtId);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,3,$CostExtId);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,4,$CostExtId);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,5,$CostExtId);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,6,$CostExtId);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,7,$CostExtId);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,8,$CostExtId);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,9,$CostExtId);				
				
			}
			
			?>
		   <tr>
		   <td style="text-indent:50px;"><?php echo "|-- ".$Detail; ?></td>
            <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
            <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
            <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
            <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
           <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
            <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
            <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
           <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
            <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
            <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
           <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
            <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
            <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>          
	      </tr>
		  <?php
				$CR++; 
			}
			?>
			<!--END รายการชี้แจง-->
  
  <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->  
  <?php if($HasChild == Y){ ?>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 3-->
    <?php
  $NumLevel33 = 1; 
  $BGLevel33 = $get->getCostItemRecordSet($CostTypeId4,3,$CostItemCode4);
 //ltxt::print_r($BGLevel33);
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

			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,0,0);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,10,0);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,11,0);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,12,0);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,1,0);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,2,0);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,3,0);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,4,0);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,5,0);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,6,0);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,7,0);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,8,0);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,9,0);
  ?>
  <tr class="level3">
    <td style="text-indent:40px;"><?php echo $NumCateMonth2; ?>.<?php echo $NumLevel11; ?>.<?php echo $NumLevel22; ?>.<?php echo $NumLevel33; ?> <?php echo $CostName5; ?></td>
    <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
   <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
   <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
   <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td> 
    </tr>
		    <!--รายการค่าใช้จ่ายชี้แจง-->
			<?php 
			$CR=0;
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$_REQUEST['PrjId'],$SourceExId);
			
			$CRequireItemLevel3 = $get->getItemRequireExternal($CostItemCode5,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$SourceExId);
			
			//ltxt::print_r($CRequireItemLevel3);
			
			foreach($CRequireItemLevel3 as $RCRequireItemLevel3){
				foreach($RCRequireItemLevel3 as $k=>$v){
					${$k} = $v;
				}
				
			if($CostExtId){	
				
			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,0,$CostExtId);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,10,$CostExtId);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,11,$CostExtId);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,12,$CostExtId);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,1,$CostExtId);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,2,$CostExtId);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,3,$CostExtId);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,4,$CostExtId);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,5,$CostExtId);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,6,$CostExtId);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,7,$CostExtId);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,8,$CostExtId);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,9,$CostExtId);				
				
			}
			
			?>
		   <tr>
		   <td style="text-indent:80px;"><?php echo "|-- ".$Detail; ?></td>
            <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
            <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
            <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
            <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
           <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
            <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
            <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
           <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
            <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
            <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
           <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
            <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
            <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>        
	      </tr>
		  <?php
			$CR++; 
			}
			?>
			<!--END รายการชี้แจง-->

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
	function showHideTwoMonth<?php echo $SourceExId; ?>(i){		
		if(JQ('#body-catetwomonth<?php echo $SourceExId; ?>'+i).is(':hidden')===true){
			JQ('#body-catetwomonth<?php echo $SourceExId; ?>'+i).show('slow');
			JQ('#a-catetwomonth<?php echo $SourceExId; ?>'+i).addClass('icon-decre');
			JQ('#a-catetwomonth<?php echo $SourceExId; ?>'+i).removeClass('icon-incre');
			JQ('#a-catetwomonth<?php echo $SourceExId; ?>'+i).html('ย่อ');
		}else{
			JQ('#body-catetwomonth<?php echo $SourceExId; ?>'+i).hide('slow');
			JQ('#a-catetwomonth<?php echo $SourceExId; ?>'+i).removeClass('icon-decre');
			JQ('#a-catetwomonth<?php echo $SourceExId; ?>'+i).addClass('icon-incre');
			JQ('#a-catetwomonth<?php echo $SourceExId; ?>'+i).html('ขยาย');
		}
	}  
  </script>
  <?php  $NumCateMonth2++; } ?>
  
	<?php
			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,10,0);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,11,0);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,12,0);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,1,0);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,2,0);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,3,0);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,4,0);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,5,0);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,6,0);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,7,0);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,8,0);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,9,0);

    ?>
  <tr class="total">
    		<td style="text-align:right;">รวมงบประมาณทั้งสิ้น</td>
            <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
            <td style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
            <td style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
            <td style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
           <td style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
            <td style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
            <td style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
           <td style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
            <td style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
            <td style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
           <td style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
            <td style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
            <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>               
  </tr>
</table>  
  



<?php
}
?>
<!--END วน loop แหล่งเงินนนอกงบ-->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" >
  <tr class="total" style="background-color:#6AAD6E">
   <?php number_format($sumAllBGInternal=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],0,0,$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel']),2); ?>
	<td colspan="9" class="td-sum-total" style="text-align:right;">( <?php echo JThaiBaht::_($sumBGTopicIn+$sumAllBGInternal); ?> ) เงินงบประมาณแผ่นดิน+เงินนอกงบประมาณ</td>
    <td class="td-sum-total" style="text-align:right; width:100px"><?php echo number_format($sumBGTopicIn+$sumAllBGInternal,2); ?></td>
  </tr>
</table>

	<?php } ?>
 <?php //******************************** จบ เงินนอกงบ ************************************?>
<br />
<div align="center" style="width:100%"><input name="closepage" type="button"  id="closepage" value="ปิดหน้าต่างนี้"  onclick="window.close();"/>