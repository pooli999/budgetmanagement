<?php
header("Content-type: text/html; charset=tis-620");
header("Content-Disposition: attachment; filename=".$_REQUEST["PrjCode"]."_".date("d-m-Y").".xls");
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

?>

<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
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



<?php
// ดึงรายการหน่วยงาน
$orgList = $get->getOrgList(($_REQUEST['BgtYear'])?$_REQUEST['BgtYear']:(date("Y")+543));
// นับหน่วยงาน
$countList = count($orgList);
//ltxt::print_r($orgList);
?>



<div style="text-align:center; font-weight:bold; padding:10px; font-size:16px;">
โครงการประจำปี พ.ศ <?php echo $_REQUEST["BgtYear"];?>&nbsp;
<?php if($_REQUEST["OrganizeCode"]){ ?>
ของหน่วยงาน <?php echo $get->getOrgName($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]); ?>
<?php } ?>
</div>



<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list">
  <tr>
    <th rowspan="2" style="width:30px;">ลำดับ</th>
    <th rowspan="2">โครงการ / กิจกรรม</th>
    <th rowspan="2" style="width:100px; text-align:right">งบโครงการ (บาท)</th>
    <th rowspan="2" style="width:90px;"">เจ้าของโครงการ<br />
      /ผู้ปฏิบัติงาน</th>
    <th rowspan="2" style="width:90px;"">&nbsp;</th>
    <th colspan="<?php echo $countList; ?>">จำแนกงบประมาณตามสำนัก / กอง ที่ปฎิบัติงาน</th>
  </tr>
  <tr>
  <?php 
	foreach($orgList as $rlist){
		foreach($rlist as $k=>$v){ ${$k} = $v;}
  ?>
  	<th  style="width:60px; vertical-align:top; text-align:center"><?php  $OrgShortName = $get->getOrgShortName($BgtYear, $OrganizeCode);  echo ($OrgShortName)? $OrgShortName:'ไม่มีชื่อย่อ' ?></th>
  <?php } ?>
  </tr>  
  <?php 
	$i=($_REQUEST["start"])?$_REQUEST["start"]:0;
  	$detail = $get->getProjectScreenType(($_REQUEST['BgtYear'])?$_REQUEST['BgtYear']:(date("Y")+543),$_REQUEST["OrganizeCode"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel']);
	//ltxt::print_r($detail);

	$SumBGTotal = 0;

	foreach($detail as $detailprj){
	foreach($detailprj as $k=>$v){
		${$k} = $v;
	}
		$SumBGTotal=0;
		$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0); 
		
		$SumTotal	= $SumTotal+$SumBGTotal;
		
		//$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0);
		$SumAllBGTotal = $SumAllBGTotal + $SumBGTotal; 
		
		//$SumCostAct=$get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
		//$SumCostActEx=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0)
				
?>
  <tr style="vertical-align:top;">
    <td  style=" text-align:center;"><?php echo $i+1; ?></td>
    <td>(<?php echo $PrjCode; ?>)&nbsp;<?php echo $PrjName;?></td>
    <td style="text-align:right;"><?php echo number_format($SumBGTotal,2); ?></td>
    <td style="text-align:center;"><?php echo $get->getOrgShortName($BgtYear,$OrganizeCodePrj); //getOrgShortName($BgtYear=0, $OrganizeCode=0) ?></td>
    <td style="text-align:center;"><?php echo $OrganizeCode; ?></td>
  <?php 
	foreach($orgList as $rlist2){
  ?>    
    <td style="text-align:right;">
	<?php 
	$SumCostPrj=$get->getTotalPrjAct($_REQUEST["BgtYear"],$rlist2->OrganizeCode,0,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0);
	echo ($SumCostPrj > 0)?number_format($SumCostPrj,2):"-"; 
	$totalOrg[$rlist2->OrganizeCode] = $totalOrg[$rlist2->OrganizeCode]+$SumCostPrj;
	?>     
    </td>
  <?php } ?>
  </tr>
  <tbody id="t-<?php echo $PrjCode; ?>">
  <?php
 		$d=1;
  		$detailact = $get->getActivity($PrjDetailId); //ltxt::print_r($detailact);
			foreach($detailact as $prjactdetail){
				foreach($prjactdetail as $k=>$v){
					${$k} = $v;
							}
						$SumAct=$get->getTotalPrj($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,0);//ltxt::print_r($SumAct);
 ?>																
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $i+1; ?>.<?php echo $d; ?> </td>
    <td>[<?php echo $PrjActCode; ?>]&nbsp;<?php echo $PrjActName; ?></td>
    <td style="text-align:right"><?php echo number_format($SumAct,2); ?></td>
    <td style="text-align:center"><?php echo $get->getOrgShortName($BgtYear,$OrganizeCode);?></td>
    <td style="text-align:center">&nbsp;</td>
  <?php 
	foreach($orgList as $rlist3){
  ?>    
    <td style="text-align:right;">
	<?php 
	$SumCostAct=$get->getTotalPrjAct($_REQUEST["BgtYear"],$rlist3->OrganizeCode,0,$PrjId,$PrjDetailId,$PrjActId,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0);
	echo ($SumCostAct > 0)?number_format($SumCostAct,2):"-"; 
	?>    
    </td>
  <?php } ?>
  </tr>
<?php
$d++;
}
?>  
</tbody>
<?php
$i++;
 }
?>  


 <?php if($i==0){  ?> 
<tr>
  <td style="text-align:center; color:#990000; height:50px">&nbsp;</td>
	<td colspan="<?php echo (3+$countList); ?>" style="text-align:center; color:#990000; height:50px">- - ไม่มีข้อมูล - -</td>
</tr>  
 <?php } ?> 
 
 <tr style="vertical-align:top;">
      <th colspan="2" style="text-align:right;">รวมทั้งสิ้น</th>
    <th style="text-align:right"><?php echo number_format($SumTotal,2); ?></th>
    <th style="text-align:center">-</th>
    <th style="text-align:center">&nbsp;</th>
  <?php 
	foreach($orgList as $rlist3){
  ?>    
    <th style="text-align:right;">
	<?php //echo number_format($get->getTotalPrjAct($_REQUEST["BgtYear"],$rlist3->OrganizeCode,0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0),2); ?>
    <?php echo ($totalOrg[$rlist3->OrganizeCode] > 0)?number_format($totalOrg[$rlist3->OrganizeCode],2):"-";  ?>
    </th>
  <?php } ?>
  </tr>
 
 
</table>





</BODY>
</HTML>

