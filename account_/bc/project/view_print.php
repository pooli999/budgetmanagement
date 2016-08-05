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
	text-align:left;
	width:150px;
}
.tbl-list td {
	padding-top:5px;
}
.tbl-list-sub {
	border-collapse:collapse;
	font-family:TH SarabunPSK; 
	font-size: 14px; 
}
.tbl-list-sub th {
	border:1px solid #999;
	padding-left:3px;
	padding-right:3px;
}
.tbl-list-sub td {
	border:1px solid #999;
	padding-left:3px;
	padding-right:3px;
}

.sum-total {
	text-align:right;
}

.topic {
	font-weight:bold;
	padding:3px;
	padding-left:0px;
	margin-top:10px;
	margin-bottom:5px;
}
.topic-content {
}
</style>

<?php
if($_REQUEST['PrjDetailId']){
	$dataPrj=$get->getProjectDetail(0,0,0,0,0,$_REQUEST['PrjDetailId']);
	//ltxt::print_r($dataPrj);
	foreach( $dataPrj as $row ) {
		foreach( $row as $k=>$v){ 
			${$k} = $v;
		}
	}
}

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

//นับระดับการกลั่นกรองงบ
$maxScreenLevel = $get->getMaxLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
//ltxt::print_r($maxScreenLevel);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list" style="margin-bottom:0px;">
  <tr>
    <th >ปีงบประมาณ</th>
    <td><?php echo $BgtYear;?></td>
  </tr>
  <tr>
    <th>ภายใต้แผนงาน</th>
    <td id="plan">(<?php echo $PItemCode; ?>)&nbsp;<?php echo $get->getPItemCode($PItemCode);?></td>
  </tr>
  <tr>
    <th>ชื่อโครงการ</th>
    <td id="prj">(<?php echo $PrjCode; ?>)&nbsp;<?php echo $PrjName;?></td>
  </tr>
  <tr>
    <th>ระยะเวลาการดำเนินโครงการ</th>
    <td><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td>
  </tr>
  <tr>
    <th valign="top">หน่วยงานที่รับผิดชอบ</th>
    <td><?php echo $get->getOrgName($BgtYear, $OrganizeCode);?></td>
  </tr>
  <tr>
    <th valign="top">ผู้รับผิดชอบโครงการ</th>
    <td><?php 
   	$TaskPerson = $get->getTaskPerson($PrjId); 
	if(!$TaskPerson){ echo '<span style="color:#999;">-ไม่ระบุ-</span>'; }
   foreach($TaskPerson as $rRName){
   		foreach($rRName as $k=>$v){
			${$k} = $v;
		}
		echo "<div>";
		echo "- ".$Name;
		if($ResultStatus == 'Y'){echo " (ผู้รายงาน)";}
		echo "</div>";
   }
	
   ?></td>
  </tr>
    <tr>
    <th valign="top">สถานะโครงการ</th>
    <td><?php echo $StatusName;?></td>
  </tr>
 </table> 
  
  
<div class="topic">หลักการ</div>
<div class="topic-content"><?php echo ($Principles)?$Principles:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></div>

<div class="topic">วัตถุประสงค์</div>
<div class="topic-content"><?php echo ($Purpose)?$Purpose:'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></div>

  


<div class="topic">ตัวชี้วัดความสำเร็จโครงการ</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list-sub">
  <tr>
    <th style="width:30px;">ลำดับ</th>
    <th style="width:80px;">รหัสตัวชี้วัด</th>
    <th >ตัวชี้วัดโครงการ</th>
    <th style="width:80px;">ค่าเป้าหมาย</th>   
    <th style="width:80px;">หน่วยนับ</th>
  </tr>
  <?php 
  $i=1;
    $indicatorSelect = $get->getIndicatorSelect($_REQUEST["PrjDetailId"]);//ltxt::print_r($indicatorSelect);
     if($indicatorSelect){
            foreach($indicatorSelect as $r){
                foreach( $r as $k=>$v){ ${$k} = $v;}
         
    ?>
        <tr>
          <td style="text-align:center;"><?php echo $i; ?></td>
          <td style="text-align:center;"><?php echo $IndicatorCode; ?></td>
          <td><?php echo $IndicatorName;?></td>
          <td style="text-align:center;"><?php echo $TargetPlan;?></td>
          <td><?php echo $UnitName;?></td>
        </tr>
        <?php		
				$i++;		
            }
        }else{
	?>
        <tr>
          <td colspan="5" style="text-align:center; height:30px; background-color:#FFF;" ><span style="color:#999;">-ไม่ระบุ-</span></td>
        </tr>
        <?php	
		}
    ?>
      </table>
      



<div class="topic">กลวิธี / ขั้นตอนการดำเนินงาน / กิจกรรมโครงการ</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list-sub">
          <tr>
            <th style="width:30px; text-align:center">ลำดับ</th>
            <th style="width:60px; text-align:center">วันเริ่มต้น</th>
            <th style="width:60px; text-align:center">วันสิ้นสุด</th>
            <th style="width:80px; text-align:center">รหัสกิจกรรม</th>
            <th style="text-align:center">ชื่อกิจกรรม</th>
            <th style="width:100px; text-align:center">ประเภทกิจกรรม</th>
            <th style="width:70px; text-align:center">%น้ำหนัก</th>
            <th style="width:100px; text-align:center">หน่วยงานปฎิบัติงาน</th>
            <th style="width:80px; text-align:right;">งบประมาณ(บาท)</th>
          </tr>
        <?php 
$n=0;
$totalSumCost = 0;
$selectAct = $get->getProjectDetailActRecordSet($PrjDetailId);//ltxt::print_r($selectAct);
//ltxt::print_r($selectAct);
 if($selectAct){
        foreach($selectAct as $r){
            foreach( $r as $k=>$v){ ${$k} = $v;} 
				$PrjActStart = $StartDate;
				$PrjActEnd = $EndDate;
				
				$SumCost=$get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0);
				$SumCostEx=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$SourceExId);
				$SumCost = $SumCost+$SumCostEx;
				$totalSumCost = $totalSumCost+$SumCost;
				$totalMass = $totalMass+$PercentMass;
?>
        <tr style="vertical-align:top;">
          <td style="text-align:center"><?php echo ($n+1); ?></td>
          <td style="text-align:center"><?php echo ShowDate($PrjActStart);?></td>
          <td style="text-align:center"><?php echo ShowDate($PrjActEnd);?></td>
          <td style="text-align:center"><?php echo $PrjActCode;?></td>
          <td style="text-align:left"><?php echo $PrjActName;?></td>
          <td><?php echo $get->getTypeActName($TypeActCode); ?></td>
          <td style="text-align:center"><?php echo number_format($PercentMass,2); ?></td>
          <td style="text-align:center"><?php echo $get->getOrgNameAct($BgtYear,$OrganizeCode);?></td>
          <td style="text-align:right;"><?php echo ($SumCost)?number_format($SumCost,2):"-"; ?></td>
        </tr>
        <?php	
		$n++;			
            }
	?>
    <tr style="font-weight:bold;">
        <td colspan="6" style="text-align:right;" ><span style="font-weight:normal;">(<?php echo JThaiBaht::_($totalSumCost); ?>)</span> รวมทั้งสิ้น</td>
        <td style="text-align:center;"><?php echo number_format($totalMass,2); ?></td>
        <td>&nbsp;</td>
        <td style="text-align:right;"><?php echo number_format($totalSumCost,2); ?></td>
    </tr>
    <?php 
        }else{
	?>
        <tr>
          <td colspan="9" style="text-align:center; height:30px" ><span style="color:#999;">-ไม่ระบุ-</span></td>
        </tr>
        <?php	
		}
    ?>
</table>
      
      
      
      
<div class="topic">ไฟล์เอกสารโครงการ</div>
<?php  
		  $FileRows = $get->getProjectFile($PrjDetailId);	
		  //ltxt::print_r($FileRows);
                if($FileRows){
					$arrFileRows = array();
					foreach($FileRows as $rFile){
						$arrFileRows[] = $rFile->DocId;
					}
					// Edit
					if($_GET["PrjDetailId"] != '') $MultiDocId = implode(",",$arrFileRows);
					
					FilesManager::LinkFilesView(array(
						'ActiveObj' => 'MultiDocId',
						'ViewType' => 'multi',
						'ActiveId' => $MultiDocId
					));
					
				}else{
					
					echo '<span style="color:#999;">-ไม่ระบุ-</span>';	
					
				}
        
        ?>
        
        
        
        
      
      
      



<div class="topic">รายการค่าใช้จ่ายของโครงการจำแนกตามแหล่งงบประมาณ</div>



<?php //*********************************งบแผ่นดิน **************************************** ?>
<div class="topic">งบประมาณแผ่นดิน</div>
<table  width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list-sub"  id="exmonth0">
  <tr>
    <th rowspan="2">หมวดงบ/รายการงบรายจ่าย</th>
    <th rowspan="2" style="width:100px;">งบประมาณ(บาท)</th>
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
		
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId);
	
	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,10,0);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,11,0);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,12,0);

	//ไตรมาสที่ 2
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,1,0);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,2,0);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,3,0);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,4,0);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,5,0);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,6,0);

	//ไตรมาสที่ 4
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,7,0);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,8,0);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,9,0);

  ?>
<?php if($SumCostMonth){ //หมวดงบประมาณ?>
  <tr class="cate">
    <td   style="width:400px" ><?php echo $NumCateMonth; ?>. <?php echo $CostTypeName; ?></td>
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
  <tbody id="body-catemonth<?php echo $NumCateMonth; ?>">
    <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
    <?php
  $NumLevel1 = 1; 
  $BGLevel1 = $get->getCostItemRecordSet($CostTypeId);
 //ltxt::print_r($BGLevel1);
  foreach($BGLevel1 as $BGLevel1Row){ 
  	foreach($BGLevel1Row as $c=>$d){
		${$c} = $d;
	}

	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,0);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,0);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,0);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,0);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,0);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,0);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,0);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,0);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,0);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,0);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,0);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,0);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,0);

  ?>
<?php if($SumCostMonth){ //รายการค่าใช้จ่าย level1?>
    <tr class="level1">
      <td style="text-indent:10px;"><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></a></td>
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
			$CRequireItemLevel1 = $get->getItemRequireInternal($CostItemCode,0,$PrjId,$PrjDetailId);
			foreach($CRequireItemLevel1 as $RCRequireItemLevel1){
				foreach($RCRequireItemLevel1 as $k=>$v){
					${$k} = $v;
				}
				
	if($CostIntId){			
				
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostIntId);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostIntId);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostIntId);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostIntId);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostIntId);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostIntId);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostIntId);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostIntId);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostIntId);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostIntId);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostIntId);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostIntId);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostIntId);
				
	}
				

			?>
    <tr>
      <td style="text-indent:30px;"><?php 
		   echo "|-- ".$Detail; 
		   echo '<span style="color:#990000; font-size:12px;">&nbsp;(&nbsp;';
		   echo ($Unit1)?(number_format($Value1,2)."&nbsp;".$get->getUnitName($Unit1)):"N/A";
		   echo ($Unit2)?(" x&nbsp;".number_format($Value2,2)."&nbsp;".$get->getUnitName($Unit2)):"";
		   echo ($Unit3)?(" x&nbsp;".number_format($Value3,2)."&nbsp;".$get->getUnitName($Unit3)):"";
		   echo ($Unit4)?(" x&nbsp;".number_format($Value4,2)."&nbsp;".$get->getUnitName($Unit4)):"";
		  echo ($Unit2)?(" =&nbsp;".number_format($SumCost,2)." บาท"):"";
		    echo '&nbsp;)</span>';
		   ?></td>
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

	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,0);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,0);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,0);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,0);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,0);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,0);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,0);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,0);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,0);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,0);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,0);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,0);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,0);

  ?>
<?php if($SumCostMonth){ //รายการค่าใช้จ่าย level2?>
    <tr class="level2">
      <td style="text-indent:20px;"><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></td>
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
			$CRequireItemLevel2 = $get->getItemRequireInternal($CostItemCode,0,$PrjId,$PrjDetailId);
			foreach($CRequireItemLevel2 as $RCRequireItemLevel2){
				foreach($RCRequireItemLevel2 as $k=>$v){
					${$k} = $v;
				}
				
				
	if($CostIntId){			
				
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostIntId);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostIntId);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostIntId);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostIntId);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostIntId);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostIntId);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostIntId);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostIntId);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostIntId);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostIntId);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostIntId);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostIntId);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostIntId);
				
	}				
				
			?>
    <tr>
      <td style="text-indent:50px;"><?php 
		   echo "|-- ".$Detail; 
		   echo '<span style="color:#990000; font-size:12px;">&nbsp;(&nbsp;';
		   echo ($Unit1)?(number_format($Value1,2)."&nbsp;".$get->getUnitName($Unit1)):"N/A";
		   echo ($Unit2)?(" x&nbsp;".number_format($Value2,2)."&nbsp;".$get->getUnitName($Unit2)):"";
		   echo ($Unit3)?(" x&nbsp;".number_format($Value3,2)."&nbsp;".$get->getUnitName($Unit3)):"";
		   echo ($Unit4)?(" x&nbsp;".number_format($Value4,2)."&nbsp;".$get->getUnitName($Unit4)):"";
		  echo ($Unit2)?(" =&nbsp;".number_format($SumCost,2)." บาท"):"";
		    echo '&nbsp;)</span>';
		   ?></td>
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
	
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,0);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,0);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,0);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,0);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,0);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,0);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,0);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,0);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,0);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,0);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,0);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,0);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,0);	
  ?>
<?php if($SumCostMonth){ //รายการค่าใช้จ่าย level3?>
    <tr class="level3">
      <td style="text-indent:40px;"><?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?>
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
			$CRequireItemLevel3 = $get->getItemRequireInternal($CostItemCode,0,$PrjId,$PrjDetailId);			
			//ltxt::print_r($CRequireItemLevel3);
			foreach($CRequireItemLevel3 as $RCRequireItemLevel3){
				foreach($RCRequireItemLevel3 as $k=>$v){
					${$k} = $v;
			}
		
	if($CostIntId){			
				
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostIntId);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostIntId);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostIntId);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostIntId);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostIntId);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostIntId);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostIntId);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostIntId);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostIntId);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostIntId);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostIntId);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostIntId);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostIntId);
				
	}
				
			?>
    <tr>
      <td style="text-indent:80px;"><?php 
		   echo "|-- ".$Detail; 
		   echo '<span style="color:#990000; font-size:12px;">&nbsp;(&nbsp;';
		   echo ($Unit1)?(number_format($Value1,2)."&nbsp;".$get->getUnitName($Unit1)):"N/A";
		   echo ($Unit2)?(" x&nbsp;".number_format($Value2,2)."&nbsp;".$get->getUnitName($Unit2)):"";
		   echo ($Unit3)?(" x&nbsp;".number_format($Value3,2)."&nbsp;".$get->getUnitName($Unit3)):"";
		   echo ($Unit4)?(" x&nbsp;".number_format($Value4,2)."&nbsp;".$get->getUnitName($Unit4)):"";
		  echo ($Unit2)?(" =&nbsp;".number_format($SumCost,2)." บาท"):"";
		    echo '&nbsp;)</span>';
		   ?></td>
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
    
    
    
<?php } //End if $SumCostMonth ของรายการค่าใช้จ่าย level3 ?>    

    
    <?php 
  $NumLevel3++;
  } ?>
    <!--END วน loop รายการงบรายจ่าย ระดับที่ 3-->
    <?php } ?>
    <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->
    
    
<?php } //End if $SumCostMonth ของรายการค่าใช้จ่าย level2 ?>


    
    <?php 
  $NumLevel2++;
  } ?>
    <!--END วน loop รายการงบรายจ่าย ระดับที่ 2-->
    <?php } ?>
    <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->
    
 
 
<?php } //End if $SumCostMonth ของรายการค่าใช้จ่าย level1 ?> 
 
    
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
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0);
	
	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,10,0);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,11,0);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,12,0);

	//ไตรมาสที่ 2
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,1,0);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,2,0);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,3,0);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,4,0);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,5,0);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,6,0);

	//ไตรมาสที่ 4
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,7,0);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,8,0);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,9,0);

?>
<?php } //End if $SumCostMonth ของหมวดงบประมาณ ?>
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



<?php //if(in_array($_REQUEST["SCTypeId"],array(3,4))){ ?>

<div class="topic">งบประมาณจากแหล่งอื่น</div>
<?php

$getExName=$get->getSourceNamePrj($PrjId);
if($getExName){
	foreach($getExName as $sName){
		foreach($sName as $k=>$v){
			${$k} = $v;
		}
	
?>
<input type="hidden" name="SourceExId[]" id="SourceExId" value="<?php echo $SourceExId; ?>" />
<div class="topic">- <?php echo $SourceExName;?></div>
<table  width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list-sub"  id="exmonth<?php echo $SourceExId; ?>">
  <tr>
    <th rowspan="2">หมวดงบ/รายการงบรายจ่าย</th>
    <th rowspan="2" style="width:100px;">งบประมาณ(บาท)</th>
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

			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,10,0);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,11,0);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,12,0);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,1,0);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,2,0);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,3,0);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,4,0);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,5,0);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,6,0);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,7,0);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,8,0);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,9,0);



  ?>
<?php if($SumCostMonth){ //หมวดงบประมาณ?>  
  <tr class="cate">
    <td><?php echo $NumCateMonth2; ?>. <?php echo $CostTypeName2; ?></td>
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
  <tbody id="body-catetwomonth<?php echo $SourceExId; ?><?php echo $NumCateMonth2; ?>">
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

			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,0,0);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,10,0);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,11,0);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,12,0);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,1,0);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,2,0);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,3,0);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,4,0);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,5,0);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,6,0);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,7,0);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,8,0);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,9,0);

  ?>
<?php if($SumCostMonth){ //รายการค่าใช้จ่าย level1?>
    <tr class="level1">
      <td style="text-indent:10px;"><?php echo $NumCateMonth2; ?>.<?php echo $NumLevel11; ?> <?php echo $CostName3; ?></td>
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
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$PrjId,$SourceExId);
			
			$CRequireItemLevel1 = $get->getItemRequireExternal($CostItemCode3,0,$PrjId,$PrjDetailId,$SourceExId);					
			//ltxt::print_r($CRequireItemLevel1);
			foreach($CRequireItemLevel1 as $RCRequireItemLevel1){
				foreach($RCRequireItemLevel1 as $k=>$v){
					${$k} = $v;
				}
				
			if($CostExtId){	
			
			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,0,$CostExtId);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,10,$CostExtId);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,11,$CostExtId);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,12,$CostExtId);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,1,$CostExtId);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,2,$CostExtId);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,3,$CostExtId);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,4,$CostExtId);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,5,$CostExtId);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,6,$CostExtId);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,7,$CostExtId);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,8,$CostExtId);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,9,$CostExtId);
				
			}
	
			?>
    <tr>
      <td style="text-indent:30px;"><?php 
		   echo "|-- ".$Detail; 
		   echo '<span style="color:#990000; font-size:12px;">&nbsp;(&nbsp;';
		   echo ($Unit1)?(number_format($Value1,2)."&nbsp;".$get->getUnitName($Unit1)):"N/A";
		   echo ($Unit2)?(" x&nbsp;".number_format($Value2,2)."&nbsp;".$get->getUnitName($Unit2)):"";
		   echo ($Unit3)?(" x&nbsp;".number_format($Value3,2)."&nbsp;".$get->getUnitName($Unit3)):"";
		   echo ($Unit4)?(" x&nbsp;".number_format($Value4,2)."&nbsp;".$get->getUnitName($Unit4)):"";
		  echo ($Unit2)?(" =&nbsp;".number_format($SumCost,2)." บาท"):"";
		    echo '&nbsp;)</span>';
		   ?></td>
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

			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,0,0);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,10,0);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,11,0);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,12,0);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,1,0);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,2,0);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,3,0);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,4,0);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,5,0);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,6,0);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,7,0);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,8,0);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,9,0);

  ?>
<?php if($SumCostMonth){ //รายการค่าใช้จ่าย level2?>
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
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$PrjId,$SourceExId);
			$CRequireItemLevel2 = $get->getItemRequireExternal($CostItemCode4,0,$PrjId,$PrjDetailId,$SourceExId);		
				
			foreach($CRequireItemLevel2 as $RCRequireItemLevel2){
				foreach($RCRequireItemLevel2 as $k=>$v){
					${$k} = $v;
				}
				
			if($CostExtId){	
				
			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,0,$CostExtId);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,10,$CostExtId);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,11,$CostExtId);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,12,$CostExtId);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,1,$CostExtId);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,2,$CostExtId);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,3,$CostExtId);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,4,$CostExtId);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,5,$CostExtId);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,6,$CostExtId);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,7,$CostExtId);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,8,$CostExtId);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,9,$CostExtId);				
				
			}
			
			?>
    <tr>
      <td style="text-indent:50px;"><?php 
		   echo "|-- ".$Detail; 
		   echo '<span style="color:#990000; font-size:12px;">&nbsp;(&nbsp;';
		   echo ($Unit1)?(number_format($Value1,2)."&nbsp;".$get->getUnitName($Unit1)):"N/A";
		   echo ($Unit2)?(" x&nbsp;".number_format($Value2,2)."&nbsp;".$get->getUnitName($Unit2)):"";
		   echo ($Unit3)?(" x&nbsp;".number_format($Value3,2)."&nbsp;".$get->getUnitName($Unit3)):"";
		   echo ($Unit4)?(" x&nbsp;".number_format($Value4,2)."&nbsp;".$get->getUnitName($Unit4)):"";
		  echo ($Unit2)?(" =&nbsp;".number_format($SumCost,2)." บาท"):"";
		    echo '&nbsp;)</span>';
		   ?></td>
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

			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,0,0);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,10,0);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,11,0);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,12,0);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,1,0);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,2,0);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,3,0);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,4,0);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,5,0);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,6,0);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,7,0);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,8,0);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,9,0);
  ?>
<?php if($SumCostMonth){ //รายการค่าใช้จ่าย level3?>
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
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$PrjId,$SourceExId);
			
			$CRequireItemLevel3 = $get->getItemRequireExternal($CostItemCode5,0,$PrjId,$PrjDetailId,$SourceExId);
			
			//ltxt::print_r($CRequireItemLevel3);
			
			foreach($CRequireItemLevel3 as $RCRequireItemLevel3){
				foreach($RCRequireItemLevel3 as $k=>$v){
					${$k} = $v;
				}
				
			if($CostExtId){	
				
			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,0,$CostExtId);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,10,$CostExtId);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,11,$CostExtId);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,12,$CostExtId);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,1,$CostExtId);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,2,$CostExtId);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,3,$CostExtId);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,4,$CostExtId);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,5,$CostExtId);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,6,$CostExtId);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,7,$CostExtId);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,8,$CostExtId);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,9,$CostExtId);				
				
			}
			
			?>
    <tr>
      <td style="text-indent:80px;"><?php 
		   echo "|-- ".$Detail; 
		   echo '<span style="color:#990000; font-size:12px;">&nbsp;(&nbsp;';
		   echo ($Unit1)?(number_format($Value1,2)."&nbsp;".$get->getUnitName($Unit1)):"N/A";
		   echo ($Unit2)?(" x&nbsp;".number_format($Value2,2)."&nbsp;".$get->getUnitName($Unit2)):"";
		   echo ($Unit3)?(" x&nbsp;".number_format($Value3,2)."&nbsp;".$get->getUnitName($Unit3)):"";
		   echo ($Unit4)?(" x&nbsp;".number_format($Value4,2)."&nbsp;".$get->getUnitName($Unit4)):"";
		  echo ($Unit2)?(" =&nbsp;".number_format($SumCost,2)." บาท"):"";
		    echo '&nbsp;)</span>';
		   ?></td>
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
    
    
<?php } //End if $SumCostMonth ของรายการค่าใช้จ่าย level3 ?>    
    
    
    <?php 
  $NumLevel33++;
  } ?>
    <!--END วน loop รายการงบรายจ่าย ระดับที่ 3-->
    <?php } ?>
    <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->
    
    
<?php } //End if $SumCostMonth ของรายการค่าใช้จ่าย level2 ?>

    
    <?php 
  $NumLevel22++;
  } ?>
    <!--END วน loop รายการงบรายจ่าย ระดับที่ 2-->
    <?php } ?>
    <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->
    
    
<?php } //End if $SumCostMonth ของรายการค่าใช้จ่าย level1 ?>    
    
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
			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,10,0);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,11,0);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,12,0);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,1,0);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,2,0);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,3,0);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,4,0);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,5,0);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,6,0);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,7,0);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,8,0);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,9,0);

    ?>
<?php } //End if $SumCostMonth ของหมวดงบประมาณ ?>
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
	}else{
		echo '<div class="no-record">-ไม่ระบุ-</div>';
	}
//}
?>
<?php //******************************** จบ เงินนอกงบ ************************************?>






<div class="topic">ประวัติการดำเนินการ</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list-sub">
        <thead>
          <tr>
            <td style="text-align: center; width:30px;">ลำดับ</td>
            <td style="text-align: center; width:100px;">วันที่ดำเนินการ</td>
            <td style="text-align: center; width:150px;">ผลการดำเนินการ</td>
            <td style="text-align: center;">หมายเหตุ</td>
            <td style="text-align: center; width:150px;">ผู้ดำเนินการ</td>
          </tr>
        </thead>
        <?php
$d=0;
$DCheck = $get->getListCheck($PrjDetailId);
if($DCheck){
foreach($DCheck as $RCProject){
	foreach($RCProject as $k=>$v){
		${$k} = $v;
	}
?>
        <tr>
          <td style="text-align:center"><?php echo ($d+1); ?></td>
          <td><?php echo dateformat($CreateDate)?>&nbsp;</td>
          <td><?php
            switch($Result){
                case "Y":
                    echo "<span class='ico approve'>ผ่านการตรวจสอบ</span>";
                break;
                case "N";
                    echo "<span class='ico redo'>ตีกลับ</span>";
                break;
                default:
                    echo "<span class='ico wait'>รอตรวจสอบ</span>";
                break;
            }
            ?>
            &nbsp; </td>
          <td><?php echo $Comment;?>&nbsp;</td>
          <td><?php echo fn_getFullNameByUserId($CreateBy);?>&nbsp;</td>
        </tr>
        <?php
$d++;
}
}else{
?>
        <tr>
          <td colspan="5" style="text-align:center; vertical-align:top;"><span style="color:#999;">-ไม่ระบุ-</span></td>
        </tr>
        <?php } ?>
      </table>
 
<div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div>     
