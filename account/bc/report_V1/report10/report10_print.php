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

<?php if($_REQUEST["ScreenLevel"]){ ?>
<div><b>ขั้นตอนจัดทำแผนปฏิบัติงาน: </b><?php echo $get->getScreenName($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"]); ?></div>
<?php } ?>

<?php if($_REQUEST["PItemCode"]){ ?>
<div><b>ชื่อแผนงาน สช.: </b><?php echo $get->getPItemName($_REQUEST["BgtYear"],$_REQUEST["PItemCode"]); ?></div>
<?php } ?>

<?php if($_REQUEST["OrganizeCode"]){ ?>
<div><b>หน่วยงาน: </b><?php echo $get->getOrgName($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]); ?></div>
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






<table width="100%" border="1" class="tbl-list"  cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">



  <!--วน loop แผนงาน สช.-->
  <?php
  $nPlan = 1; 
  $recPlan = $get->getPItemRecordSet();//ltxt::print_r($recPlan);
  foreach($recPlan as $recPlanRow){ 
  	foreach($recPlanRow as $a=>$b){
		${$a} = $b;
	}

  ?>
  
  <tr class="cate" style="vertical-align:top; font-weight:bold; font-size:16px;">
    <td colspan="3"><?php echo $nPlan; ?>. <?php echo $PItemName; ?></td>
    </tr>
    
  <tr class="cate" style="vertical-align:top; font-weight:bold;">
    <td style="text-align:center;">เป้าประสงค์ของแผนงาน</td>
    <td colspan="2" style="text-align:center;">ตัวชี้วัดความสำเร็จของแผนงาน</td>
 </tr>
 
 
   <tr class="cate" style="vertical-align:top;">
    <td>
    
 <?php
$pp = 1; 
$dataPurpose = $get->getPurposeItem($PItemCode);//ltxt::print_r($recIndPlan);
foreach($dataPurpose as $dataPurposeRow){
		foreach( $dataPurposeRow as $e=>$w){ ${$e} = $w;}
		echo '<div>'.$pp.'. '.$PurposeName.'</div>';
		$pp++;
 }


  ?>   
    
    </td>
    <td colspan="2"><?php
$nIncPlan = 1; 
$recIndPlan = $get->getIndPlanRecordSet($PItemCode);//ltxt::print_r($recIndPlan);
foreach($recIndPlan as $recIndPlanRow){ 
  	foreach($recIndPlanRow as $ac1=>$ac2){ ${$ac1} = $ac2; }
		echo '<div>'.$nIncPlan.'. ('.$PIndCode.') '.$PIndName.'</div>';
		$nIncPlan++;
 }


  ?></td>
 </tr>


  
  
  
  
  
  
<!-- วนลูปโครงการ --> 
  <?php
  $nProject = 1; 
  $recProject = $get->getProjectRecordSet($PItemCode);//ltxt::print_r($recProject);
  foreach($recProject as $recProjectRow){ 
  	foreach($recProjectRow as $m=>$d){
		${$m} = $d;
	}


  ?>
  
  <tr class="cate" style="vertical-align:top;  font-weight:bold;">
    <td colspan="3"><?php echo $nPlan; ?>.<?php echo $nProject; ?> <?php echo $PrjName; ?></td>
    </tr>
    
    
    
  <tr class="cate" style="vertical-align:top; font-weight:bold; ">
    <td style="text-align:center;">วัตถุประสงค์</td>
    <td colspan="2" style="text-align:center;">ตัวชี้วัดความสำเร็จของโครงการ</td>
 </tr>
 
   <tr class="cate" style="vertical-align:top; ">
    <td><?php echo (trim($Purpose))?(trim($Purpose)):"-ไม่ระบุ-"; ?></td>
    <td colspan="2"><?php
$nIncPrj = 1; 
$recIndPrj = $get->getIndPrjRecordSet($PrjDetailId);//ltxt::print_r($recIndPrj);
foreach($recIndPrj as $recIndPrjRow){ 
  	foreach($recIndPrjRow as $ab1=>$ab2){ ${$ab1} = $ab2; }
		echo '<div>'.$nIncPrj.'. ('.$IndicatorCode.') '.$IndicatorName.'</div>';
		$nIncPrj++;
 }


  ?></td>
 </tr>

  <tr style="font-weight:bold; ">
    <td style="text-align:center;">กิจกรรม</td>
    <td style="text-align:center;">เป้าหมาย</td>
    <td style="text-align:center; width:150px;">งบประมาณ</td>
    </tr>

  
  
  <!-- วนลูปกิจกรรม --> 
  <?php
  $totalSumCostMonth = 0;
  $nAct = 1; 
  $recAct = $get->getActRecordSet($PrjDetailId);//ltxt::print_r($recPlan);
  foreach($recAct as $recActRow){ 
  	foreach($recActRow as $w=>$q){
		${$w} = $q;
	}
	$SumCostMonth=$get->getTotalPrjMonth($PItemCode,$PrjDetailId,$PrjActId);
	$totalSumCostMonth = $totalSumCostMonth+$SumCostMonth;
	$totalSumCostMonth = number_format($totalSumCostMonth,0,'.','');

  ?>
  
  <tr class="cate" style="vertical-align:top; ">
    <td><?php echo $nAct; ?>. <?php echo $PrjActName; ?></td>
    <td>
    
<?php
$nIncAct = 1; 
$recIndAct = $get->getIndActRecordSet($PrjActId);//ltxt::print_r($recIndAct);
foreach($recIndAct as $recIndActRow){ 
  	foreach($recIndActRow as $a1=>$a2){ ${$a1} = $a2; }
		echo '<div>'.$nIncAct.'. '.$IndicatorName.'</div>';
		$nIncAct++;
 }


  ?>    
    
    
    </td>
    <td style="text-align:right;"><?php echo number_format($SumCostMonth,2); ?></td>
    </tr>
  <?php 
  $nAct++;
  } 
  ?>
<!--END วนลูปกิจกรรม-->

  
  
  
   <tr style="vertical-align:top; font-weight:bold;">
    <td colspan="2" style="text-align:right;"><span style="font-weight:normal;">(<?php echo JThaiBaht::_($totalSumCostMonth); ?>)</span> รวมทั้งสิ้น</td>
    <td style="text-align:right;"><?php echo number_format($totalSumCostMonth,2); ?></td>
    </tr> 
  
  
  <?php 
  $nProject++;
  } 
  ?>
<!--END วนลูปโครงการ-->
  
  
  
  
  
  
  
  
  
  <?php 
  $nPlan++;
  } 
  ?>
  <!--END วน loop หมวดงบรายจ่าย-->


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