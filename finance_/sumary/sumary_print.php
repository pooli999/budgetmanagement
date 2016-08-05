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

<?php if($_REQUEST["PrjDetailId"]){ ?>
<div><b>โครงการ: </b><?php echo $get->getPrjName($_REQUEST["PrjDetailId"]); ?></div>
<?php } ?>

<?php if($_REQUEST["PrjActId"]){ ?>
<div><b>กิจกรรม: </b><?php echo $get->getPrjActName($_REQUEST["PrjActId"]); ?></div>
<?php } ?>

<?php if($_REQUEST["SourceExId"]){ ?>
<div><b>แหล่งงบประมาณ: </b>
<?php echo $get->getSourceExName($_REQUEST["SourceExId"]); ?>
</div>
<?php } ?>




<table width="100%" border="0" class="tbl-list"  cellspacing="0" cellpadding="0">
  <tr style="vertical-align:top;">
    <th nowrap="nowrap" style="width:80px;">รหัส</th>
    <th nowrap="nowrap">ชื่อแผนงาน/โครงการ/กิจกรรม</th>
    <th style="width:80px;" nowrap="nowrap">งบตามแผน<br /><span style="font-weight:normal;">(A)</span></th>
    <th style="width:80px;" nowrap="nowrap">งบรับโอน<br /><span style="font-weight:normal;">(B)</span></th>
    <th style="width:80px;" nowrap="nowrap">งบโอนออก<br /><span style="font-weight:normal;">(C)</span></th>
    <th style="width:100px;" nowrap="nowrap">งบ(รอ)รับโอน<br /><span style="font-weight:normal;">(D)</span></th>
    <th style="width:100px;" nowrap="nowrap">งบ(รอ)โอนออก<br /><span style="font-weight:normal;">(E)</span></th>
    <th style="width:140px;" nowrap="nowrap">งบแผนรวมโอน<br />
      <span style="font-weight:normal;">(F)=(A)+(B)-(C)+(D)-(E)</span></th>
    <th style="width:100px;" nowrap="nowrap">งบ(รอ)หลักการ<br /><span style="font-weight:normal;">(G)</span></th>
    <th style="width:80px;" nowrap="nowrap">งบหลักการ<br /><span style="font-weight:normal;">(H)</span></th>
    <th style="width:80px;" nowrap="nowrap">งบผูกพัน<br /><span style="font-weight:normal;">(K)</span></th>
    <th style="width:100px;" nowrap="nowrap">งบ(รอ)ตัดจ่าย<br /><span style="font-weight:normal;">(M)</span></th>
    <th style="width:80px;" nowrap="nowrap">งบตัดจ่าย<br />
      <span style="font-weight:normal;">(N)</span></th>
    <th style="width:100px;" nowrap="nowrap">งบรวมจ่ายจริง<br />
      <span style="font-weight:normal;">(P)=(K)+(M)+(N)</span></th>
    <th style="width:100px;" nowrap="nowrap">คงเหลือ<br />ไม่รวมหลักการ<br />
      <span style="font-weight:normal;">(R)=(F)-(P)</span></th>
    <th style="width:120px;" nowrap="nowrap">คงเหลือ<br />รวมหลักการ<br />
      <span style="font-weight:normal;">(S)=(F)-(G)-(H)-(P)</span></th>
    </tr>
  <?php
 $nPlan = 1; 
  $recPlan = $get->getPItemRecordSet();//ltxt::print_r($recPlan);
  foreach($recPlan as $recPlanRow){ 
  	foreach($recPlanRow as $a=>$b){
		${$a} = $b;
	}
	$BGPlan = $get->getSumBGPlan($PItemCode);
	$BGTferWait = $get->getWaitSumBGTferOut($PItemCode);
	$BGTferIn = $get->getSumBGTferIn($PItemCode);
	$BGTferOut = $get->getSumBGTferOut($PItemCode);
	$BGPlanTfer = $BGPlan+$BGTferIn-$BGTferOut-$BGTferWait;
	
	$BGHoldWait = $get->getSumBGHoldWait($PItemCode);
	$BGHold = $get->getSumBGHold($PItemCode);
	
	$BGChain = $get->getSumBGChain($PItemCode);
	
	$BGPayWait = $get->getSumBGPayWait($PItemCode);
	$BGPay = $get->getSumBGPay($PItemCode);
	
	$BGPayNet = $BGChain+$BGPayWait+$BGPay;

	$BGRemain =  $BGPlanTfer-$BGHoldWait-$BGHold-$BGPayNet;
	$BGRemainNotHold =  $BGPlanTfer-$BGPayNet;
	
	$BGBorrow = $get->getSumBGBorrow($PItemCode);
	
	

?>
  <tr style="vertical-align:top;  " title="<?php echo $PItemName; ?>">
    <td style="text-align:center;"><?php echo $PItemCode; ?></td>
    <td nowrap="nowrap"><?php echo $PItemName; ?></td>
    <td class="sum-total"><?php echo ($BGPlan > 0)?number_format($BGPlan,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPlanTfer > 0)?number_format($BGPlanTfer,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHoldWait > 0)?number_format($BGHoldWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHold > 0)?number_format($BGHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGChain > 0)?number_format($BGChain,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayWait > 0)?number_format($BGPayWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay > 0)?number_format($BGPay,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayNet > 0)?number_format($BGPayNet,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemainNotHold > 0)?number_format($BGRemainNotHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemain > 0)?number_format($BGRemain,2):"-"; ?></td>
    </tr>
    
    
<!--โครงการ-->    
<?php
$nProject = 1; 
  $recProject = $get->getProjectRecordSet($PItemCode);//ltxt::print_r($recPlan);
  foreach($recProject as $recProjectRow){ 
  	foreach($recProjectRow as $m=>$d){
		${$m} = $d;
	}
	$BGPlan = $get->getSumBGPlan($PItemCode,$PrjDetailId);
	
	$BGTferWait = $get->getWaitSumBGTferOut($PItemCode);
	
	$BGTferIn = $get->getSumBGTferIn($PItemCode,$PrjDetailId);
	$BGTferOut = $get->getSumBGTferOut($PItemCode,$PrjDetailId);
	$BGPlanTfer = $BGPlan+$BGTferIn-$BGTferOut-$BGTferWait;
	
	$BGHoldWait = $get->getSumBGHoldWait($PItemCode,$PrjDetailId);
	$BGHold = $get->getSumBGHold($PItemCode,$PrjDetailId);
	
	$BGChain = $get->getSumBGChain($PItemCode,$PrjDetailId);
	
	$BGPayWait = $get->getSumBGPayWait($PItemCode,$PrjDetailId);
	$BGPay = $get->getSumBGPay($PItemCode,$PrjDetailId);
	
	$BGPayNet = $BGChain+$BGPayWait+$BGPay;

	$BGRemain =  $BGPlanTfer-$BGHoldWait-$BGHold-$BGPayNet;
	$BGRemainNotHold =  $BGPlanTfer-$BGPayNet;
	
	$BGBorrow = $get->getSumBGBorrow($PItemCode,$PrjDetailId);
	
?>
  <tr style="vertical-align:top; " title="<?php echo $PrjName; ?>">
    <td style="text-align:center;"><?php echo $PrjCode; ?></td>
    <td><?php echo $PrjName; ?></td>
    <td class="sum-total"><?php echo ($BGPlan > 0)?number_format($BGPlan,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPlanTfer > 0)?number_format($BGPlanTfer,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHoldWait > 0)?number_format($BGHoldWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHold > 0)?number_format($BGHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGChain > 0)?number_format($BGChain,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayWait > 0)?number_format($BGPayWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay > 0)?number_format($BGPay,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayNet > 0)?number_format($BGPayNet,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemainNotHold > 0)?number_format($BGRemainNotHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemain > 0)?number_format($BGRemain,2):"-"; ?></td>
    </tr>
    
<!--กิจกรรม-->    
<?php
$nAct = 1; 
  $recAct = $get->getActRecordSet($PrjDetailId);//ltxt::print_r($recPlan);
  foreach($recAct as $recActRow){ 
  	foreach($recActRow as $w=>$q){
		${$w} = $q;
	}
	$BGPlan = $get->getSumBGPlan($PItemCode,$PrjDetailId,$PrjActId);
	
	$BGTferWait = $get->getWaitSumBGTferOut($PItemCode,$PrjDetailId,$PrjActId);
	
	$BGTferIn = $get->getSumBGTferIn($PItemCode,$PrjDetailId,$PrjActId);
	$BGTferOut = $get->getSumBGTferOut($PItemCode,$PrjDetailId,$PrjActId);
	$BGPlanTfer = $BGPlan+$BGTferIn-$BGTferOut-$BGTferWait;
	
	$BGHoldWait = $get->getSumBGHoldWait($PItemCode,$PrjDetailId,$PrjActId);
	$BGHold = $get->getSumBGHold($PItemCode,$PrjDetailId,$PrjActId);
	
	$BGChain = $get->getSumBGChain($PItemCode,$PrjDetailId,$PrjActId);
	
	$BGPayWait = $get->getSumBGPayWait($PItemCode,$PrjDetailId,$PrjActId);
	$BGPay = $get->getSumBGPay($PItemCode,$PrjDetailId,$PrjActId);
	
	$BGPayNet = $BGChain+$BGPayWait+$BGPay;

	$BGRemain =  $BGPlanTfer-$BGHoldWait-$BGHold-$BGPayNet;
	$BGRemainNotHold =  $BGPlanTfer-$BGPayNet;
	
	$BGBorrow = $get->getSumBGBorrow($PItemCode,$PrjDetailId,$PrjActId);
	
?>
  <tr style="vertical-align:top;" title="<?php echo $PrjActName; ?>">
    <td style="text-align:center;"><?php echo $PrjActCode; ?></td>
    <td>- <?php echo $PrjActName; ?></td>
    <td class="sum-total"><?php echo ($BGPlan > 0)?number_format($BGPlan,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPlanTfer > 0)?number_format($BGPlanTfer,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHoldWait > 0)?number_format($BGHoldWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHold > 0)?number_format($BGHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGChain > 0)?number_format($BGChain,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayWait > 0)?number_format($BGPayWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay > 0)?number_format($BGPay,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayNet > 0)?number_format($BGPayNet,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemainNotHold > 0)?number_format($BGRemainNotHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemain > 0)?number_format($BGRemain,2):"-"; ?></td>
    </tr>
<?php 
	$nAct++;
} 
?>    
<!--END กิจกรรม-->      
    
    
    
<?php 
	$nProject++;
}
?>    
<!--END โครงการ-->    
    
    
    
    
    
<?php 
	$nPlan++;
} 
?>
<?php 
$BGPlan = $get->getSumBGPlan($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);

$BGTferWait = $get->getWaitSumBGTferOut($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);

$BGTferIn = $get->getSumBGTferIn($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
$BGTferOut = $get->getSumBGTferOut($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
$BGPlanTfer = $BGPlan+$BGTferIn-$BGTferOut-$BGTferWait;

$BGHoldWait = $get->getSumBGHoldWait($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
$BGHold = $get->getSumBGHold($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);

$BGChain = $get->getSumBGChain($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);

$BGPayWait = $get->getSumBGPayWait($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);
$BGPay = $get->getSumBGPay($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);

$BGPayNet = $BGChain+$BGPayWait+$BGPay;

$BGRemain =  $BGPlanTfer-$BGHoldWait-$BGHold-$BGPayNet;
$BGRemainNotHold =  $BGPlanTfer-$BGPayNet;
	
$BGBorrow = $get->getSumBGBorrow($_REQUEST["PItemCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);

?>

  <tr style="vertical-align:top; font-weight:bold; ">
    <td colspan="2" style="text-align:right;">รวมทั้งสิ้น</td>
    <td class="sum-total"><?php echo ($BGPlan > 0)?number_format($BGPlan,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferIn > 0)?number_format($BGTferIn,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGTferOut > 0)?number_format($BGTferOut,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPlanTfer > 0)?number_format($BGPlanTfer,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHoldWait > 0)?number_format($BGHoldWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGHold > 0)?number_format($BGHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGChain > 0)?number_format($BGChain,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayWait > 0)?number_format($BGPayWait,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPay > 0)?number_format($BGPay,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGPayNet > 0)?number_format($BGPayNet,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemainNotHold > 0)?number_format($BGRemainNotHold,2):"-"; ?></td>
    <td class="sum-total"><?php echo ($BGRemain > 0)?number_format($BGRemain,2):"-"; ?></td>
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