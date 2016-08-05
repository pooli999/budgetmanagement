<?php
header("Content-Type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=Plan".date("d-m-Y").".doc");
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




<?php $_REQUEST["BgtYear"] = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543); ?>
<div style="text-align:center; font-weight:bold; padding:10px; font-size:16px;">
โครงการประจำปี <?php echo $_REQUEST["BgtYear"];?>
</div>




<table width="100%" border="0" class="tbl-list"  cellspacing="0" cellpadding="0">
  <tr>
    <th align="center" style="width:30px;">ลำดับ</th>
    <th align="center" >แผนงาน/โครงการ</th>
    <th align="center" style="width:120px;">เจ้าของโครงการ</th>    
    <th align="center" style="width:100px;">กรอบงบประมาณ(บาท)</th>
    <th align="center" style="width:80px;">%ค่าน้ำหนัก</th>    
    <th align="center" style="width:70px;">สถานะ</th>
    </tr>
<?php
	//ltxt::print_r($list);

	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	if($list){
          foreach($list as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
  <tr style="vertical-align:top; font-weight:bold;">
    <td style="text-align:center;"><?php echo $i; ?></td>
    <td><?php  if($PItemCode != ""){ echo "[ ".$PItemCode." ] "; } echo $PItemName;?></td>
    <td style="text-align:center;">-</td>
    <td>&nbsp;</td>
    <td style="text-align:center;"><?php echo $get->getSumPrjMass($PItemCode); ?></td>
    <td>&nbsp;</td>
    </tr>
  		  <?php
          	$listProject = $get->getProject($PItemCode,$BgtYear);//ltxt::print_r($listProject);
			if($listProject){
				$p=1;
          		foreach($listProject as $listP) {
					foreach( $listP as $k=>$v){ ${$k} = $v;}
		  ?>
          <tr style="vertical-align:top;">
            <td>&nbsp;</td>
            <td><?php echo $i.".".$p; ?> <?php echo $PrjName; ?></td>
            <td style="text-align:center;"><?php echo $get->getOrgShortName($BgtYear, $OrganizeCode);?></td>
            <td style="text-align:right;"><?php echo number_format($PrjBudget,2);?></td>
            <td style="text-align:center;"><?php echo ($PrjMass)?$PrjMass:"-"; ?></td>
            <td style="text-align:center;">
<?php
switch($EnableStatus){
	case "Y":
		echo "แสดง";
	break;
	case "N":
		echo "ไม่แสดง";
	break;
}
?>           
            </td>
          </tr>  
          <?php 
					$p++;
				} 
		 	}else{ ?>
            <tr>
            <td colspan="6" class="nullDataList">-ไม่มีรายการในฐานข้อมูล-</td>
            </tr>
  		  <?php } ?>	
<?php

		$i++;
		}
	}
?>
<tr>
</table>


<div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div> 

</BODY>

</HTML>


