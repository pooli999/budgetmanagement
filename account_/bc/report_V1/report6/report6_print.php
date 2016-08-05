<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
?>
<HTML>
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
<style media="print">
.btnback {
	display:none;
	vertical-align:top;
}
</style>
<style>
body {
	 font-family:TH SarabunPSK; 
	 font-size: 14px; 
	 margin:20px;
}
.tbl-list {
	border-collapse:collapse;
	font-family:TH SarabunPSK; 
	font-size: 14px; 
}
.tbl-list th {
	border:1px solid #999;
	padding-left:3px;
	padding-right:3px;
}
.tbl-list td {
	border:1px solid #999;
	padding-left:3px;
	padding-right:3px;
}
.sum-total {
	text-align:right;
}
</style>
</HEAD>
<BODY>

<div style="font-weight:bold; text-decoration:underline;">เงื่อนไขการแสดงรายงาน</div>
<?php if($_REQUEST["BgtYear"]){ ?>
<div><b>ปีงบประมาณ: </b><?php echo $_REQUEST["BgtYear"]; ?></div>
<?php } ?>


<?php if($_REQUEST["PItemCode"]){ ?>
<div><b>ชื่อแผนงาน สช.: </b><?php echo $get->getPItemName($_REQUEST["BgtYear"],$_REQUEST["PItemCode"]); ?></div>
<?php } ?>

<?php if($_REQUEST["OrganizeCode"]){ ?>
<div><b>หน่วยงาน: </b><?php echo $get->getOrgName($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]); ?></div>
<?php } ?>

<?php if($_REQUEST["PrjDetailId"]){ ?>
<div><b>โครงการ: </b><?php echo $get->getPrjName($_REQUEST["PrjDetailId"]); ?></div>
<?php } ?>

<?php if($_REQUEST["PrjActId"]){ ?>
<div><b>กิจกรรม: </b><?php echo $get->getPrjActName($_REQUEST["PrjActId"]); ?></div>
<?php } ?>

<?php if($_REQUEST["ExType"]){ ?>
<div><b>แหล่งงบประมาณ: </b>
<?php
switch($_REQUEST["ExType"]){
	case "Internal":
		echo "งบแผ่นดิน";
	break;
	case "External":
		echo "เงินนอกงบ";
		if($_REQUEST["SourceExId"]){
			echo " (".$get->getSourceExName($_REQUEST["SourceExId"]).")";
		}
	break;
}
?>	
</div>
<?php } ?>


<?php $screen=$get->getScreenYear($_REQUEST["BgtYear"]); ?>

<table width="100%" border="0" class="tbl-list"  cellspacing="0" cellpadding="0">
  <tr>
    <th nowrap="nowrap">หมวดงบ/รายการค่าใช้จ่าย</th>
    <?php
$h=1;
foreach( $screen as $prow2 ){
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
?>
<th nowrap="nowrap" style="width:10%;"><?php echo $ScreenName; ?></th>
<?php 
	$h++;
} 
?>    
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
  ?>
  
  <tr class="cate" style="vertical-align:top; font-weight:bold;">
    <td><?php echo $NumCateMonth; ?>. <?php echo $CostTypeName; ?></td>
    <?php 
$h=1;
foreach( $screen as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostScreen=$get->getTotalPrjMonth($CostTypeId,0,0,"",0,$ScreenLevel);
?>
<td class="sum-total" title="<?php echo $ScreenName; ?>"><?php echo ($SumCostScreen)?number_format($SumCostScreen,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    
    </tr>
    <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
    <?php
  $NumLevel1 = 1; 
  $BGLevel1 = $get->getCostItemRecordSet($CostTypeId);
 //ltxt::print_r($BGLevel1);
  foreach($BGLevel1 as $BGLevel1Row){ 
  	foreach($BGLevel1Row as $c=>$d){
		${$c} = $d;
	}
  ?>

    <tr class="level1" style="vertical-align:top;">
      <td><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></td>
      <?php 
$h=1;
foreach( $screen as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostScreen=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,$ScreenLevel);
?>
<td class="sum-total" title="<?php echo $ScreenName; ?>"><?php echo ($SumCostScreen)?number_format($SumCostScreen,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    

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
  ?>
 
    <tr class="level2" style="vertical-align:top;">
      <td><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></td>
      <?php 
$h=1;
foreach( $screen as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostScreen=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,$ScreenLevel);
?>
<td class="sum-total" title="<?php echo $ScreenName; ?>"><?php echo ($SumCostScreen)?number_format($SumCostScreen,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    

    </tr>
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
  ?>

    <tr class="level3" style="vertical-align:top;">
      <td><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?></td>
      <?php 
$h=1;
foreach( $screen as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostScreen=$get->getTotalPrjMonth($CostTypeId,$LevelId,$ParentCode,$HasChild,$CostItemCode,$ScreenLevel);
?>
<td class="sum-total" title="<?php echo $ScreenName; ?>"><?php echo ($SumCostScreen)?number_format($SumCostScreen,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    

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

    
  <?php 
  $NumCateMonth++;
  } ?>
  <!--END วน loop หมวดงบรายจ่าย-->
  
  
  <tr style="vertical-align:top; font-weight:bold;">
    <td style="text-align:right;">รวมทั้งสิ้น</td>
    <?php 
$h=1;
foreach( $screen as $prow2 ) {
	foreach( $prow2 as $d=>$e){ ${$d} = $e;}
	$SumCostScreen=$get->getTotalPrjMonth(0,0,0,"",0,$ScreenLevel);
?>
<td class="sum-total" title="<?php echo $ScreenName; ?>"><?php echo ($SumCostScreen)?number_format($SumCostScreen,2):'-'; ?></td>
<?php 
	$h++;
} 
?>    

    </tr>
</table>








<div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div>  




<div style="text-align:center; margin-top:20px;">
  <input class="btnback" type="button" name="back" value="ย้อนกลับ" onClick="window.history.go(-1);" />
</div>

<script>
window.print();
</script>

</BODY>

</HTML>