<?php 
include("config.php");
//include("project_action.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));

if($_REQUEST['PrjId']){
	$dataPrj=$get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode'], $_REQUEST['SCTypeId'], $_REQUEST['ScreenLevel'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId']);
	foreach( $dataPrj as $row ) {
		foreach( $row as $k=>$v){ 
			${$k} = $v;
		}
	}
}


?>
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId']; ?>" />
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>">
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST["SCTypeId"]; ?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST["ScreenLevel"]; ?>" />
<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $_REQUEST["PrjId"]; ?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<td  style="padding-left:20px">ข้อมูลทั่วไปโครงการ</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
 <tr>
   <th style="width:120px;">ปีงบประมาณ</th>
   <td colspan="2"><?php echo $BgtYear;?></td>
 </tr>
 <tr>
   <th>ภายใต้แผนงาน</th>
   <td colspan="2"><?php echo $PItemCode;?></td>
 </tr>
 <tr>
    <th>ชื่อโครงการ</th>
    <td colspan="2"><?php echo $PrjName;?></td>
  </tr>
  <tr>
    <th>ระยะเวลาการดำเนินโครงการ</th>
    <td colspan="2"><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td>
  </tr>
  
   <tr>
   <th valign="top">หน่วยงานที่รับผิดชอบ</th>
   <td colspan="2"><?php echo $get->getOrgName($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode']);?></td>
  </tr>
 
   <tr>
   <th valign="top">บุคลากรที่รับผิดชอบ</th>
   <td colspan="2"><?php 
/*   $RName = $get->getResponsibleView($PrjID);
   echo "<ul>";
   foreach($RName as $rRName){
   		foreach($rRName as $k=>$v){
			${$k} = $v;
		}
		echo "<li>".$Name."</li>";
   }
   echo "</ul>";
*/   ?></td>
 </tr>
 
<table>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<td  style="padding-left:20px">รายละเอียดโครงการ</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
  <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">การติดต่อ</th>
  </tr> 
</table>
    
<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th style="width:193px;">หมายเลขโทรศัพท์</th>
   <td colspan="2"><?php echo $Telephone;?></td>
  </tr>
  <tr>
    <th style="width:120px;">โทรสาร</th>
    <td colspan="2"><?php echo $Fax;?></td>
  </tr>
  <tr>
    <th style="width:120px;">อีเมล์</th>
   <td colspan="2"><?php echo $Email;?></td>
  </tr>
  </table>

  <table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">วัตถุประสงค์</th>
  </tr> 
  <tr>
    <td colspan="3"><?php echo $Purpose; ?></td>
  </tr> 
  <tr>
    <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">ตัวชี้วัดความสำเร็จโครงการ</th>
  </tr> 
  <tr>
    <td colspan="3"><?php echo $Indicator; ?></td>
  </tr>
  <tr>
    <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">ผลงาน (Output)</th>
  </tr> 
  <tr>
    <td colspan="3"><?php echo $Outputs; ?></td>
  </tr> 
   <tr>
    <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">ปริมาณงาน / ตัวชี้วัด</th>
  </tr> 
   </table>
     
  	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
    <tr>
    <th style="text-align:center; width:80px">ลำดับ</th>
  	<th colspan="2" style="width:410px; text-align:center;">ชื่อตัวชี้วัดโครงการ</th>
    <th style="width:300px; text-align:center;">ค่าเป้าหมาย</th>
    <th style="width:120px; text-align:center;">หน่วยนับ</th>
  </tr>
  <?php 
$i=0;
  $indicator = $get->getIndicator($PrjDetailId);
  foreach($indicator as $row){
  	foreach($row as $k=>$v){
		${$k} = $v;
	}
  ?>
  <tr>
  	<td style="text-align:center"><?php echo $i+1;?></td>
  	<td colspan="2" style="width:410px; text-align:left;"><?php echo $IndName;?></td>
    <td style="width:300px; text-align:right;"><?php echo $Value;?></td>
    <td style="width:120px; text-align:left;"><?php echo $UnitName;?></td>
  </tr>
<?php
$i++;
}
?>
  <?php if($i==0){ ?>
<tr>
	<td colspan="4" style="text-align:center; vertical-align:top; color:#900 ">- - ไม่มีข้อมูล - -</td>
</tr>
<?php } ?>
  </table>
  
   <table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
   <tr>
    <th colspan="4" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">กลวิธี / ขั้นตอนการดำเนินงาน / กิจกรรมโครงการ</th>
  </tr> 
  </table>
  
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
<tr>
<th style="text-align: center; width:130px;">วันเริ่มต้นกิจกรรม</th>
<th style="text-align: center; width:130px;">วันสิ้นสุดกิจกรรม</th>
<th style="text-align: center; width: 600px;">รายการกิจกรรม</th>
<th style="text-align: center; width:300px;">หน่วยงานปฎิบัติงาน</th>
</tr>
<?php 
$r=0;
$task = $get->getProjectDetailActRecordSet($PrjDetailId);//ltxt::print_r($task);
foreach($task as $RTask){
	foreach($RTask as $k=>$v){
		${$k} = $v;
	}
?>
<tr>
<td width="141" style="text-align: center; width:120px; vertical-align:top;"><?php echo dateformat($StartDate)?></td>
<td width="141" style="text-align: center; width:120px; vertical-align:top;"><?php echo dateformat($EndDate)?></td>
<td width="600"><?php echo $PrjActName; ?></td>
<td width="230"><?php echo $get->getOrgNameAct($OrganizeCode);?></td>
</tr>
<?php
$r++;
}
?>
  <?php if($r==0){ ?>
<tr>
<td colspan="2" style="text-align:center; vertical-align:top; color:#900 ">- - ไม่มีข้อมูล - -</td>
</tr>
<?php  } ?>
  <tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
   <tr>
    <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">ไฟล์เอกสารโครงการ</th>
  </tr> 
   <tr>
    <th width="8%">ลำดับ</th>
    <th width="92%" colspan="2">ชื่อไฟล์เอกสาร</th>
  </tr> 
  <?php
 $k=0;
/*$Prjchk = $get->getProjectDetailCheckRecordSet($PrjDetailId);
foreach($Prjchk as $RPrjchk){
	foreach($RPrjchk as $k=>$v){
		${$k} = $v;
	}
*/?>
   <tr>
    <td style="text-align:center"><?php echo $k+1;?></td>
    <td><?php echo $FileName;?>&nbsp;</td>
  </tr> 
<?php
$k++;
?>
  <?php if($k==0){ ?>
<tr>
<td colspan="2" style="text-align:center; vertical-align:top; color:#900 ">- - ไม่มีข้อมูล - -</td>
</tr>
<?php  } ?>
  <tr>
    <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">รายการตรวจสอบโครงการ</th>
  </tr> 
</table>
<div>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
        <tr>
          <th style="text-align: center; width:80px;">ลำดับ</th>
          <th style="text-align: center; width:250px;">วันที่ตรวจสอบ</th>
          <th style="text-align: center; width:330px;">ผลการตรวจสอบ</th>
          <th style="text-align: center; width:400px;">หมายเหตุ</th>
          <th style="text-align: center; width:140px;">ผู้ตรวจสอบ</th>
        </tr>
<?php
$d=0;
$Prjchk = $get->getProjectDetailCheckRecordSet($PrjDetailId);
foreach($Prjchk as $RPrjchk){
	foreach($RPrjchk as $k=>$v){
		${$k} = $v;
	}
			$StatusChk = $get->getStatusChk($PrjDetailId);//ltxt::print_r($detail);
					foreach($StatusChk as $detailprj){
						foreach($detailprj as $m=>$n){
							${$m} = $n;
					}
?>
        <tr>
          <td style="text-align:center"><?php echo ($d+1); ?></td>
          <td><?php echo dateformat($CreateDate)?>&nbsp;</td>
          <td>
          <div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div>&nbsp;
          </td>
          <td><?php echo $Comment;?>&nbsp;</td>
          <td><?php echo $CreateBy;?>&nbsp;</td>
        </tr><?php }?>
<?php
$d++;
}
?>
<?php if($d==0){ ?>
<tr>
	<td colspan="5" style="text-align:center; vertical-align:top; color:#900 ">- - ไม่มีข้อมูล - -</td>
</tr>
<?php } ?>
</table>
<!--/*********************************************รายการงบแผ่นดิน********************************************************************************/-->
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<td  style="padding-left:20px">งบประมาณแผ่นดิน</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;">
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
	$SumTotalCost = $get->getTotalPrjInternalX4(0,0,0,$PrjId,$PrjDetailId,0,0,0,0,0,$CostTypeId);
  ?>
  <tr class="cate">
    <td><?php echo $NumCate; ?>. <?php echo $CostTypeName; ?> | <a href="javascript:void(0)" id="a-cate<?php echo $NumCate; ?>" onclick="showHide(<?php echo $NumCate; ?>);" class="icon-decre txt-normal">ย่อ</a></td>
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
			$SumTotalCost = $get->getTotalPrjInternalX4(0,0,0,$PrjId,$PrjDetailId,0,0,0,$CostItemCode,$ParentCode,0,$LevelId,$HasChild);

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
			$CRequireItem = $get->getItemRequireInternal($CostItemCode,$PrjActId,$PrjId);
			foreach($CRequireItem as $RCRequireItem){
				foreach($RCRequireItem as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:20px;">- <?php echo $Detail; ?></td>
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
		$SumTotalCost = $get->getTotalPrjInternalX4(0,0,0,$PrjId,$PrjDetailId,0,0,0,$CostItemCode,0,0,$LevelId,$HasChild);
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
			$CRequireItem = $get->getItemRequireInternal($CostItemCode,$PrjActId,$PrjId);
			foreach($CRequireItem as $RCRequireItem){
				foreach($RCRequireItem as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:30px;">- <?php echo $Detail; ?></td>
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
			$SumTotalCost = $get->getTotalPrjInternalX4(0,0,0,$PrjId,$PrjDetailId,0,0,0,$CostItemCode,$ParentCode,0,$LevelId,$HasChild);

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
			$CRequireItem = $get->getItemRequireInternal($CostItemCode,$PrjActId,$PrjId);
			foreach($CRequireItem as $RCRequireItem){
				foreach($RCRequireItem as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:50px;">- <?php echo $Detail; ?></td>
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
    <td colspan="9" style="text-align:right;">(<?php echo JThaiBaht::_($get->getTotalPrjInternalX4($BgtYear,0,0,$PrjId,$PrjDetailId,0,0,0)); ?>) รวมงบประมาณทั้งสิ้น</td>
    <?php number_format($sumBG=$get->getTotalPrjInternalX4($BgtYear,0,0,$PrjId,$PrjDetailId,0,0,0),2); ?>
    <td style="text-align:right; font-weight:bold"><?php echo $sumBG; ?></td>
  </tr>
</table>

<!--**************************************************iรายการเงินนอกงบประมาณ*******************************************************************************-->
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<?php
$SourceExName=$get->getSourceExName($_REQUEST['SourceExId']);
?>
<td  style="padding-left:20px">เงินนอกงบประมาณ [ <?php echo $SourceExName;?> ]</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;">
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
	$SumTotalCost = $get->getTotalPrjExternalX4(0,0,0,$PrjId,$PrjDetailId,0,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId);
  ?>
  <tr class="cate">
    <td><?php echo $NumCate; ?>. <?php echo $CostTypeName; ?> | <a href="javascript:void(0)" id="a-cate<?php echo $NumCate; ?>" onclick="showHide(<?php echo $NumCate; ?>);" class="icon-decre txt-normal">ย่อ</a></td>
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
			$SumTotalCost = $get->getTotalPrjExternalX4(0,0,0,$PrjId,$PrjDetailId,0,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,0,$LevelId,$HasChild);

  ?>
  <tr class="level1">
    <td style="text-indent:10px;">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></td>
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
			$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$PrjId,$_REQUEST["SourceExId"]);
			foreach($CRequireItem as $RCRequireItem){
				foreach($RCRequireItem as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:20px;">- <?php echo $Detail; ?></td>
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
		$SumTotalCost = $get->getTotalPrjExternalX4(0,0,0,$PrjId,$PrjDetailId,0,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,0,$LevelId,$HasChild);
  ?>
  <tr class="level2">
    <td style="text-indent:20px;">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></td>
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
			$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$PrjId,$_REQUEST["SourceExId"]);
			foreach($CRequireItem as $RCRequireItem){
				foreach($RCRequireItem as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:30px;">- <?php echo $Detail; ?></td>
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
			$SumTotalCost = $get->getTotalPrjExternalX4(0,0,0,$PrjId,$PrjDetailId,0,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,0,$LevelId,$HasChild);

  ?>
  <tr class="level3">
    <td style="text-indent:40px;">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?>
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
		    <!--รายการค่าใช้จ่ายชี้แจง-->
			<?php 
			$CR=0;
			$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$PrjId,$_REQUEST["SourceExId"]);
			foreach($CRequireItem as $RCRequireItem){
				foreach($RCRequireItem as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:50px;">- <?php echo $Detail; ?></td>
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
    <td colspan="9" style="text-align:right;">(<?php echo JThaiBaht::_($get->getTotalPrjExternalX4($BgtYear,0,0,$PrjId,$PrjDetailId,0,0,0,$_REQUEST["SourceExId"])); ?>) รวมงบประมาณทั้งสิ้น</td>
    <?php number_format($sumBGInternal=$get->getTotalPrjExternalX4($BgtYear,0,0,$PrjId,$PrjDetailId,0,0,0,$_REQUEST["SourceExId"]),2); ?>
    <td style="text-align:right; font-weight:bold"><?php echo $sumBGInternal;?></td>
  </tr>
</table>
<!--***********************************************************************************************************************************-->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;">
  <tr class="total">
	<td colspan="9" class="td-sum-total" style="text-align:right">( <?php echo JThaiBaht::_($sumBG+$sumBGInternal); ?> ) เงินงบประมาณแผ่นดิน+เงินนอกงบประมาณ</td>
		   <td class="td-sum-total" style="text-align:right; width:100px"><?php echo number_format($sumBG+$sumBGInternal,2); ?></td>
  </tr>
</table>



<div style="text-align:center; margin-top:10px; margin-bottom:30px;">
<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="window.location.href='?mod=<?php echo LURL::dotPage($listRequestPage); ?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"]; ?>&PrjId=<?php echo $PrjId; ?>'" />
</div>
