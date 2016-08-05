<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

?>
<style type="text/css">
.sysinfo{
	border-bottom:1px solid #aaa;
	background-color:#eee; 
	padding:5px; 
	margin-bottom:3px;
}
.sysinfo .sysname{
	font-size:14px; 
	font-weight:bold; 
	line-height:18px; 
	color:#333;
}
.sysinfo .sysdetail{
	font-size:12px; 
	color:#666; 
	margin-top:5px;
}

.tbl-cost {
	border-collapse:collapse;
	font-size:12px; 
}
.tbl-cost th {
	border:1px solid #999;
	text-align:center;
	padding:3px;
	background-color:#CCC;
}
.tbl-cost td {
	border:1px solid #999;
	padding:3px;
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
.tbl-item {
	border-collapse:collapse;
	font-size:12px; 
}

.tbl-item th {
	border:1px solid #999;
	padding:3px;
	vertical-align:top;
	background-color:#CCC;
}

.tbl-item td {
	border:1px solid #999;
	padding:3px;
	vertical-align:top;
}

.title-bar2{
	background-image: url(images/budget/tooloptions.png);
	background-repeat:no-repeat;
	background-position:2px 2px; 
	background-color:#EDEB8F;
	font-weight:bold;	
}

.boxfilter-sub{
	padding:5px 5px 5px 5px;
	font-weight:bold;
	border-bottom:1px solid #535e74;
	background-color:#B2B2B2;
	font-size:13px; 
	
}

.boxfilter{
	border-bottom:1px solid #535e74;
	background-color:#9089AD;
}

.icon-topic {
	font-weight:bold;
	padding:3px 3px 3px 25px;
	background-image: url(http://gocodev/nationalhealth/images/budget/comment.png);
	background-repeat:no-repeat;
	background-position:3px 4px;
	color:#FFF;
	font-size:13px; 
	font-family: 'Microsoft Sans Serif';
}

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



  
<div class="topic-step"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>

<div class="boxfilter2" id="boxFilter">
    <b>ปีงบประมาณ : </b><?php echo $_REQUEST["BgtYear"]?>
    <b>หน่วยงาน : </b><?php echo $get->getOrgName($BgtYear, $OrganizeCode);?>
</div>


<div class="boxfilter-sub">&diams; &diams; &diams; งบประมาณแผ่นดิน [ตัวคูณ 4 ช่อง] &diams; &diams; &diams;</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" >
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
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>">
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST["SCTypeId"]; ?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST["ScreenLevel"]; ?>" />
<input type="hidden" name="CostTypeId" id="CostTypeId" value="<?php echo $_REQUEST["CostTypeId"]; ?>" />
  <?php
  $NumCate = 1; 
  $BGCate = $get->getCostTypeRecordSet($_REQUEST["CostTypeId"]);
  //ltxt::print_r($BGCate);
  foreach($BGCate as $BGCateRow){ 
  	foreach($BGCateRow as $a=>$b){
		${$a} = $b;
	}
	$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0,0,$CostTypeId);
  ?>
  <tr class="cate">
    <td><?php echo $NumCate; ?>. <?php echo $CostTypeName; ?></td>
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
  
  <tbody id="body-cate<?php echo $NumCate; ?>">
  <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
   <?php
  $NumLevel1 = 1; 
  $BGLevel1 = $get->getCostItemRecordSet($CostTypeId);
  foreach($BGLevel1 as $BGLevel1Row){ 
  	foreach($BGLevel1Row as $c=>$d){
		${$c} = $d;
	}
			$CSItem = $get->getListCostItem($CostItemCode,$ParentCode);
			$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$CostItemCode,$ParentCode,0,$LevelId,$HasChild);

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
			//$CRequireItem = $get->getItemInternalPopup($CostItemCode); //ltxt::print_r($CRequireItem);
			$CRequireItemLevel1 = $get->getItemRequireInternalPopup($CostItemCode,0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);		
			foreach($CRequireItemLevel1 as $RCRequireItemLevel1){
				foreach($RCRequireItemLevel1 as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:20px;">|-- <?php echo $Detail; ?></td>
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
		$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$CostItemCode,0,0,$LevelId,$HasChild);
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
			//$CRequireItem = $get->getItemInternalPopup($CostItemCode);
			$CRequireItemLevel2 = $get->getItemRequireInternalPopup($CostItemCode,0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);			
			foreach($CRequireItemLevel2 as $RCRequireItemLevel2){
				foreach($RCRequireItemLevel2 as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:30px;">|-- <?php echo $Detail; ?></td>
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
			$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$CostItemCode,$ParentCode,0,$LevelId,$HasChild);

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
			//$CRequireItemLevel3 = $get->getItemRequireInternal($CostItemCode,0,$PrjId,$PrjDetailId);	
			$CRequireItemLevel3 = $get->getItemRequireInternalPopup($CostItemCode,0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);
			foreach($CRequireItemLevel3 as $RCRequireItemLevel3){
				foreach($RCRequireItemLevel3 as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:50px;">|-- <?php echo $Detail; ?></td>
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
  	<?php  $SumCost=$get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0,0,$_REQUEST["CostTypeId"]);?>

  <tr class="total">
    <th style="text-align:right;" colspan="9"><span class="txt-normal">( <?php echo JThaiBaht::_($SumCost); ?> )</span> รวมทั้งสิ้น</th>
    <th style="text-align:right;"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></th>
    </tr>
</table>

<br />
<div align="center" style="width:100%"><input name="closepage" type="button"  id="closepage" value="ปิดหน้าต่างนี้"  onclick="window.close();"/>
