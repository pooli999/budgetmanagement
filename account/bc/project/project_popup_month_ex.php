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
.boxfilter{
	border-bottom:1px solid #535e74;
	background-color:#9089AD;
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

.boxfilter-sub{
	padding:5px 5px 5px 5px;
	font-weight:bold;
	border-bottom:1px solid #535e74;
	background-color:#B2B2B2;
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

<div class="boxfilter-sub">&diams; &diams; &diams; งบประมาณแผ่นดิน [รายเดือน / ไตรมาส] &diams; &diams; &diams;</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost">
  <tr>
    <th rowspan="2" style="width:350px;">หมวดงบ/รายการงบรายจ่าย</th>
    <th rowspan="2" style="width:100px;">งบคูณ 4 ช่อง<br />(บาท)</th>
    <th colspan="3">ไตรมาส1</th>
    <th colspan="3">ไตรมาส2</th>
    <th colspan="3">ไตรมาส3</th>
    <th colspan="3">ไตรมาส4</th>
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
  $NumCate = 1; 
  $BGCate = $get->getCostTypeRecordSet($_REQUEST["CostTypeId"]);
  foreach($BGCate as $BGCateRow){ 
  	foreach($BGCateRow as $a=>$b){
		${$a} = $b;
	}
	
	$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,$CostTypeId);
	
	/*ไตรมาสที่ 1*/
	$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,$CostTypeId);
		
	$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,$CostTypeId,0,"",10,0);
	$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,$CostTypeId,0,"",11,0);
	$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,$CostTypeId,0,"",12,0);
	
	/*ไตรมาสที่ 2*/
	$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,$CostTypeId,0,"",1,0);
	$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,$CostTypeId,0,"",2,0);
	$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,$CostTypeId,0,"",3,0);

	/*ไตรมาสที่ 3*/
	$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,$CostTypeId,0,"",4,0);
	$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,$CostTypeId,0,"",5,0);
	$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,$CostTypeId,0,"",6,0);
	
	/*ไตรมาสที่ 4*/
	$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,$CostTypeId,0,"",7,0);
	$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,$CostTypeId,0,"",8,0);
	$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,$CostTypeId,0,"",9,0);
	
	
  ?>
  <tr class="cate">
    <td><?php echo $NumCate; ?>. <?php echo $CostTypeName; ?></td>
    <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
	
	$CSItem = $get->getListCostItem($CostItemCode,$ParentCode);
	$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);

		//ไตรมาสที่ 1
		$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10);
		$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11);
		$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12);
		
		//ไตรมาสที่ 2
		$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1);
		$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2);
		$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3);
		
		//ไตรมาสที่ 3
		$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4);
		$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5);
		$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6);
		
		//ไตรมาสที่ 4
		$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7);
		$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8);
		$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9);
		
		
  ?>
  <tr class="level1">
    <td style="text-indent:10px;">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></a></td>
    <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
			$CRequireItemLevel1 = $get->getItemRequireExternalPopup($CostItemCode,0,0,0,$_REQUEST["SourceExId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);
			foreach($CRequireItemLevel1 as $RCRequireItemLevel1){
				foreach($RCRequireItemLevel1 as $k=>$v){
					${$k} = $v;
				}
					
				if($CostExtId){
				
		//ไตรมาสที่ 1
		$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostExtId);
		$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostExtId);
		$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostExtId);
		$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostExtId);
		
		//ไตรมาสที่ 2
		$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostExtId);
		$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostExtId);
		$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostExtId);
		
		//ไตรมาสที่ 3
		$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostExtId);
		$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostExtId);
		$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostExtId);		
			
		//ไตรมาสที่ 4	
		$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostExtId);
		$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostExtId);
		$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostExtId);		
						
			}

			?>
		   <tr>
		   <td style="text-indent:20px;">|-- <?php echo $Detail; ?></td>
		   <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
	
	$CSItem = $get->getListCostItem($CostItemCode,$ParentCode);
	$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);

		//ไตรมาสที่ 1
		$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10);
		$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11);
		$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12);
		
		//ไตรมาสที่ 2
		$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1);
		$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2);
		$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3);
		
		//ไตรมาสที่ 3
		$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4);
		$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5);
		$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6);
		
		//ไตรมาสที่ 4
		$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7);
		$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8);
		$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9);
		
		
  ?>
  <tr class="level2">
    <td style="text-indent:20px;">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></td>
    <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>  </tr>
  
		    <!--รายการค่าใช้จ่ายชี้แจง-->
			<?php 
			$CR=0;
			//$CRequireItem = $get->getItemInternalPopup($CostItemCode);
			//$CRequireItemLevel2 = $get->getItemRequireInternalPopup($CostItemCode,0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);			
			
			$CRequireItemLevel2 = $get->getItemRequireExternalPopup($CostItemCode,0,0,0,$_REQUEST["SourceExId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);
			
			foreach($CRequireItemLevel2 as $RCRequireItemLevel2){
				foreach($RCRequireItemLevel2 as $k=>$v){
					${$k} = $v;
				}
				
				if($CostExtId){
						
		//ไตรมาสที่ 1
		$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostExtId);
		$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostExtId);
		$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostExtId);
		$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostExtId);
		
		//ไตรมาสที่ 2
		$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostExtId);
		$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostExtId);
		$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostExtId);
		
		//ไตรมาสที่ 3
		$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostExtId);
		$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostExtId);
		$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostExtId);		
		
		//ไตรมาสที่ 4
		$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostExtId);
		$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostExtId);
		$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostExtId);		
		
		
			}
				
			?>
		   <tr>
		<td style="text-indent:30px;">|-- <?php echo $Detail; ?></td>
        <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
        <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>		  </tr>
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
  $BGLevel3 = $get->getCostItemRecordSet($_REQUEST["CostTypeId"],3,$CostItemCode);
  foreach($BGLevel3 as $BGLevel3Row){ 
  	foreach($BGLevel3Row as $g=>$h){
		${$g} = $h;
	}

	$CSItem = $get->getListCostItem($CostItemCode,$ParentCode);
	$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);

		//ไตรมาสที่ 1
		$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10);
		$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11);
		$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12);
		
		//ไตรมาสที่ 2
		$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1);
		$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2);
		$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3);
		
		//ไตรมาสที่ 3
		$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4);
		$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5);
		$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6);
	
		//ไตรมาสที่ 4
		$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7);
		$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8);
		$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9);
	


  ?>
  <tr class="level3">
    <td style="text-indent:40px;">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?>
    <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>  </tr>
		    <!--รายการค่าใช้จ่ายชี้แจง-->
			<?php 
			$CR=0;
			//$CRequireItem = $get->getItemInternalPopup($CostItemCode);//ltxt::print_r($CRequireItem);
			//$CRequireItemLevel3 = $get->getItemRequireInternalPopup($CostItemCode,0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);
			
			$CRequireItemLevel3 = $get->getItemRequireExternalPopup($CostItemCode,0,0,0,$_REQUEST["SourceExId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);
			
			foreach($CRequireItemLevel3 as $RCRequireItemLevel3){
				foreach($RCRequireItemLevel3 as $k=>$v){
					${$k} = $v;
			}
				if($CostExtId){
						
		//ไตรมาสที่ 1
		$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostExtId);
		$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostExtId);
		$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostExtId);
		$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostExtId);
		
		//ไตรมาสที่ 2
		$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostExtId);
		$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostExtId);
		$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostExtId);
		
		//ไตรมาสที่ 3
		$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostExtId);
		$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostExtId);
		$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostExtId);		
		
		//ไตรมาสที่ 4	
		$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostExtId);
		$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostExtId);
		$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostExtId);		
		
			}
			?>
		   <tr>
		   
			<td style="text-indent:50px;">|-- <?php echo $Detail; ?></td>
            <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
            <td style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>		  </tr>
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
 <?php
	$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,0);
	
	/*ไตรมาสที่ 1*/
	$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,0);
		
	$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,0,0,"",10,0);
	$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,0,0,"",11,0);
	$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,0,0,"",12,0);
	
	/*ไตรมาสที่ 2*/
	$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,0,0,"",1,0);
	$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,0,0,"",2,0);
	$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,0,0,"",3,0);

	/*ไตรมาสที่ 3*/
	$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,0,0,"",4,0);
	$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,0,0,"",5,0);
	$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,0,0,"",6,0);
	
	/*ไตรมาสที่ 4*/
	$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,0,0,"",7,0);
	$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,0,0,"",8,0);
	$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"],0,0,0,0,"",9,0);



?>
  
    
  <tr class="total">
    <th style="text-align:right; " >รวมงบประมาณทั้งสิ้น</th>
    <th style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></th>
    <th style="text-align:right;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></th>
    <th style="text-align:right;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></th>
    <th style="text-align:right;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></th>
   <th style="text-align:right;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></th>
    <th style="text-align:right;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></th>
    <th style="text-align:right;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></th>
   <th style="text-align:right;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></th>
    <th style="text-align:right;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></th>
    <th style="text-align:right;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></th>
   <th style="text-align:right;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></th>
    <th style="text-align:right;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></th>
    <th style="text-align:right;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></th>
  </tr>  
      
</table>

<br />
<div align="center" style="width:100%"><input name="closepage" type="button"  id="closepage" value="ปิดหน้าต่างนี้"  onclick="window.close();"/>

