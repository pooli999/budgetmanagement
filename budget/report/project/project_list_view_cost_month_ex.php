<?php
include("config.php");
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

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

?>

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

</script>

 <table width="100%" cellpadding="0" cellspacing="0" class="page-title-user">
 	<tr>
    	<td class="div-title-plan">&nbsp;</td>
        <td>
       <div class="font1">จัดทำแผนปฏิบัติงานประจำปี</div>
        </td>
    </tr>
 </table>


<div class="sysinfo">
  <div class="sysname" style="font-size:16px;"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>
</div>


<?php
 $datas = $get->getActivityDetail($_REQUEST["$PrjDetailId"],$_REQUEST["PrjActId"]);
foreach($datas as $actdatas){
	foreach($actdatas as $k=>$v){
		${$k} = $v;
	}
}
?>

<?php $curProcess = $get->getCurProcess($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);//ดึงข้อมูลขั้นตอนปัจจุบันของหน่วยงาน?>


<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td align="right">
      <input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ViewCost); ?>&PrjId=<?php echo $PrjId; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"];?>&SourceExId=<?php echo $_REQUEST["SourceExId"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>&BgtYear=<?php echo $_REQUEST['BgtYear']; ?>'" />
      </td>
    </tr>
  </table>  
</div>



<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
<!-- <tr>
   <th style="width:200px; text-align:left">ปีงบประมาณ</th>
   <td style="width:948px; text-align:left; font-weight:bold"><?php //echo $BgtYear;?></td>
 </tr>-->
 <tr>
    <th style="width:200px; text-align:left">ชื่อโครงการ</th>
    <td style="width:948px; text-align:left; font-weight:bold"><?php echo $PrjName;?><input type="hidden" name="PrjId" id="PrjId" value="<?php echo $PrjId;?>"></td>
  </tr>
  <tr>
    <th style="width:200px; text-align:left">ชื่อกิจกรรม</th>
    <td style="width:948px; text-align:left; font-weight:bold"><?php echo $PrjActName;?></td>
  </tr>
   <tr>
    <th style="width:200px; text-align:left">ระยะเวลากิจกรรม</th>
    <td><?php echo dateFormat($StartDate);?> <b>ถึง</b> <?php echo dateFormat($EndDate); ?></td>
  </tr>
</table>
<?php
$SourceExName=$get->getSourceExName($_REQUEST['SourceExId']);
?>
<div class="boxfilter2"><div class="icon-topic">เงินนอกงบประมาณ [ <?php echo $SourceExName;?> ]</div></div>
<!--<div style="overflow:scroll; width:100%; height:500px;">-->
<table width="1220" border="0" cellspacing="0" cellpadding="0" class="tbl-cost">
  <tr>
    <th rowspan="2" style="width:300px;">หมวดงบ/รายการงบรายจ่าย</th>
    <th rowspan="2" style="width:100px;">งบคูณ 4 ช่อง<br />(บาท)</th>
    <th rowspan="2" style="width:100px;">งบเดือน/ไตรมาส<br />(บาท)</th>
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
  </tr>  <!--วน loop หมวดงบรายจ่าย-->
  <?php
  $NumCate = 1; 
  $BGCate = $get->getCostTypeRecordSet();
  foreach($BGCate as $BGCateRow){ 
  	foreach($BGCateRow as $a=>$b){
		${$a} = $b;
	}
	//$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,$CostTypeId);
	$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId,$LevelId,$HasChild);
		
	/*ไตรมาสที่ 1*/
	$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId);
	$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId,0,0,10);
	$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId,0,0,11);
	$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId,0,0,12);
	/*ไตรมาสที่ 2*/
	$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId,0,0,1);
	$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId,0,0,2);
	$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId,0,0,3);
	/*ไตรมาสที่ 3*/
	$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId,0,0,4);
	$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId,0,0,5);
	$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId,0,0,6);
	/*ไตรมาสที่ 4*/
	$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId,0,0,7);
	$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId,0,0,8);
	$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId,0,0,9);
  ?>
  <tr class="cate">
    <td><?php echo $NumCate; ?>. <?php echo $CostTypeName; ?> | <a href="javascript:void(0)" id="a-cate<?php echo $NumCate; ?>" onclick="showHide(<?php echo $NumCate; ?>);" class="icon-decre txt-normal">ย่อ</a></td>
    <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
		$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,$CostTypeId,$LevelId,$HasChild);
		/*ไตรมาสที่ 1*/
		$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,$CostTypeId,$LevelId,$HasChild);
		$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,$CostTypeId,$LevelId,$HasChild,10);
		$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,$CostTypeId,$LevelId,$HasChild,11);
		$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,$CostTypeId,$LevelId,$HasChild,12);
		/*ไตรมาสที่ 2*/
		$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,$CostTypeId,$LevelId,$HasChild,1);
		$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,$CostTypeId,$LevelId,$HasChild,2);
		$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,$CostTypeId,$LevelId,$HasChild,3);
		/*ไตรมาสที่ 3*/
		$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,$CostTypeId,$LevelId,$HasChild,4);
		$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,$CostTypeId,$LevelId,$HasChild,5);
		$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,$CostTypeId,$LevelId,$HasChild,6);
		/*ไตรมาสที่ 4*/
		$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,$CostTypeId,$LevelId,$HasChild,7);
		$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,$CostTypeId,$LevelId,$HasChild,8);
		$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,0,$CostTypeId,$LevelId,$HasChild,9);
  ?>
  <tr class="level1">
    <td style="text-indent:10px;">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></a></td>
    <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$_REQUEST["PrjActId"],$PrjId,$_REQUEST["SourceExId"]);
			$CRequireItem = $get->getItemRequireExternal($CostItemCode,$_REQUEST["PrjActId"],0,0,$_REQUEST["SourceExId"]);
			foreach($CRequireItem as $RCRequireItem){
				foreach($RCRequireItem as $k=>$v){
					${$k} = $v;
				}
					if($CostExtId){
						/*$Budget10 = $get->getCostMonthEx($CostExtId,10); 
						$Budget11 = $get->getCostMonthEx($CostExtId,11); 
						$Budget12 = $get->getCostMonthEx($CostExtId,12); 
						$Sum1 = $Budget10+$Budget11+$Budget12;
						$Budget1 = $get->getCostMonthEx($CostExtId,1); 
						$Budget2 = $get->getCostMonthEx($CostExtId,2); 
						$Budget3 = $get->getCostMonthEx($CostExtId,3); 
						$Sum2 = $Budget1+$Budget2+$Budget3;
						$Budget4 = $get->getCostMonthEx($CostExtId,4); 
						$Budget5 = $get->getCostMonthEx($CostExtId,5); 
						$Budget6 = $get->getCostMonthEx($CostExtId,6); 
						$Sum3 = $Budget4+$Budget5+$Budget6;
						$Budget7 = $get->getCostMonthEx($CostExtId,7); 
						$Budget8 = $get->getCostMonthEx($CostExtId,8); 
						$Budget9 = $get->getCostMonthEx($CostExtId,9); 
						$Sum4 = $Budget7+$Budget8+$Budget9;
						$Total = $Sum1+$Sum2+$Sum3+$Sum4;*/
						/*ไตรมาสที่ 1*/
						$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostExtId);
						$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostExtId);
						$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostExtId);
						$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostExtId);
						/*ไตรมาสที่ 2*/
						$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostExtId);
						$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostExtId);
						$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostExtId);
						/*ไตรมาสที่ 3*/
						$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostExtId);
						$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostExtId);
						$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostExtId);
						/*ไตรมาสที่ 4*/
						$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostExtId);
						$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostExtId);
						$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostExtId);
					}

			?>
		   <tr>
		   <td style="text-indent:10px;">
		   <a href="?mod=<?php echo LURL::dotPage($AddCostExternalMonth); ?>&CostItemId=<?php echo $CostItemId; ?>&PrjActId=<?php echo $PrjActId; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&CostItemCode=<?php echo $CostItemCode; ?>&ParentCode=<?php echo $ParentCode; ?>&CostExtId=<?php echo $CostExtId; ?>&SourceExId=<?php echo $_REQUEST['SourceExId']; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>">
		   |-- <?php echo $Detail; ?></a>
           <?php 
		   echo '<span style="color:#990000; font-size:12px;">&nbsp;(&nbsp;';
		   echo ($Unit1)?(number_format($Value1,2)."&nbsp;".$get->getUnitName($Unit1)):"N/A";
		   echo ($Unit2)?(" x&nbsp;".number_format($Value2,2)."&nbsp;".$get->getUnitName($Unit2)):"";
		   echo ($Unit3)?(" x&nbsp;".number_format($Value3,2)."&nbsp;".$get->getUnitName($Unit3)):"";
		   echo ($Unit4)?(" x&nbsp;".number_format($Value4,2)."&nbsp;".$get->getUnitName($Unit4)):"";
		  //echo ($Unit2)?(" =&nbsp;".number_format($SumCost,2)." บาท"):"";
		    echo '&nbsp;)</span>';
		   ?>
           </td>
		   <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
		$CSItem = $get->getListCostItem($CostItemCode,$ParentCode);
		$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		/*ไตรมาสที่ 1*/
		$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10);
		$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11);
		$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12);
		/*ไตรมาสที่ 2*/
		$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1);
		$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2);
		$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3);
		/*ไตรมาสที่ 3*/
		$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4);
		$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5);
		$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6);
		/*ไตรมาสที่ 4*/
		$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7);
		$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8);
		$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9);
  ?>
  <tr class="level2">
    <td style="text-indent:20px;">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></td>
    <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
			$CRequireItem = $get->getItemRequireExternal($CostItemCode,$_REQUEST["PrjActId"],0,0,$_REQUEST["SourceExId"]);
			foreach($CRequireItem as $RCRequireItem){
				foreach($RCRequireItem as $k=>$v){
					${$k} = $v;
				}
					if($CostExtId){
						/*$Budget10 = $get->getCostMonthEx($CostExtId,10); 
						$Budget11 = $get->getCostMonthEx($CostExtId,11); 
						$Budget12 = $get->getCostMonthEx($CostExtId,12); 
						$Sum1 = $Budget10+$Budget11+$Budget12;
						$Budget1 = $get->getCostMonthEx($CostExtId,1); 
						$Budget2 = $get->getCostMonthEx($CostExtId,2); 
						$Budget3 = $get->getCostMonthEx($CostExtId,3); 
						$Sum2 = $Budget1+$Budget2+$Budget3;
						$Budget4 = $get->getCostMonthEx($CostExtId,4); 
						$Budget5 = $get->getCostMonthEx($CostExtId,5); 
						$Budget6 = $get->getCostMonthEx($CostExtId,6); 
						$Sum3 = $Budget4+$Budget5+$Budget6;
						$Budget7 = $get->getCostMonthEx($CostExtId,7); 
						$Budget8 = $get->getCostMonthEx($CostExtId,8); 
						$Budget9 = $get->getCostMonthEx($CostExtId,9); 
						$Sum4 = $Budget7+$Budget8+$Budget9;
						$Total = $Sum1+$Sum2+$Sum3+$Sum4;*/
						
						/*ไตรมาสที่ 1*/
						$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostExtId);
						$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostExtId);
						$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostExtId);
						$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostExtId);
						/*ไตรมาสที่ 2*/
						$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostExtId);
						$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostExtId);
						$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostExtId);
						/*ไตรมาสที่ 3*/
						$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostExtId);
						$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostExtId);
						$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostExtId);
						/*ไตรมาสที่ 4*/
						$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostExtId);
						$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostExtId);
						$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostExtId);
					}
				
			?>
		   <tr>
		   <td style="text-indent:20px;">
		   <a href="?mod=<?php echo LURL::dotPage($AddCostExternalMonth); ?>&CostItemId=<?php echo $CostItemId; ?>&PrjActId=<?php echo $PrjActId; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&CostItemCode=<?php echo $CostItemCode; ?>&ParentCode=<?php echo $ParentCode; ?>&CostExtId=<?php echo $CostExtId; ?>&SourceExId=<?php echo $_REQUEST['SourceExId']; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>">
		   |-- <?php echo $Detail; ?></a>
           <?php 
		   echo '<span style="color:#990000; font-size:12px;">&nbsp;(&nbsp;';
		   echo ($Unit1)?(number_format($Value1,2)."&nbsp;".$get->getUnitName($Unit1)):"N/A";
		   echo ($Unit2)?(" x&nbsp;".number_format($Value2,2)."&nbsp;".$get->getUnitName($Unit2)):"";
		   echo ($Unit3)?(" x&nbsp;".number_format($Value3,2)."&nbsp;".$get->getUnitName($Unit3)):"";
		   echo ($Unit4)?(" x&nbsp;".number_format($Value4,2)."&nbsp;".$get->getUnitName($Unit4)):"";
		 // echo ($Unit2)?(" =&nbsp;".number_format($SumCost,2)." บาท"):"";
		    echo '&nbsp;)</span>';
		   ?>
           </td>
		   <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
			$CSItem = $get->getListCostItem($CostTypeId);
			$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
			/*ไตรมาสที่ 1*/
			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12);
			/*ไตรมาสที่ 2*/
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3);
			/*ไตรมาสที่ 3*/
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6);
			/*ไตรมาสที่ 4*/
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9);
  ?>
  <tr class="level3">
    <td style="text-indent:40px;">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?>
    <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
			$CRequireItem = $get->getItemRequireExternal($CostItemCode,$_REQUEST["PrjActId"],0,0,$_REQUEST["SourceExId"]);
			foreach($CRequireItem as $RCRequireItem){
				foreach($RCRequireItem as $k=>$v){
					${$k} = $v;
			}
					if($CostExtId){
						/*$Budget10 = $get->getCostMonthEx($CostExtId,10); 
						$Budget11 = $get->getCostMonthEx($CostExtId,11); 
						$Budget12 = $get->getCostMonthEx($CostExtId,12); 
						$Sum1 = $Budget10+$Budget11+$Budget12;
						$Budget1 = $get->getCostMonthEx($CostExtId,1); 
						$Budget2 = $get->getCostMonthEx($CostExtId,2); 
						$Budget3 = $get->getCostMonthEx($CostExtId,3); 
						$Sum2 = $Budget1+$Budget2+$Budget3;
						$Budget4 = $get->getCostMonthEx($CostExtId,4); 
						$Budget5 = $get->getCostMonthEx($CostExtId,5); 
						$Budget6 = $get->getCostMonthEx($CostExtId,6); 
						$Sum3 = $Budget4+$Budget5+$Budget6;
						$Budget7 = $get->getCostMonthEx($CostExtId,7); 
						$Budget8 = $get->getCostMonthEx($CostExtId,8); 
						$Budget9 = $get->getCostMonthEx($CostExtId,9); 
						$Sum4 = $Budget7+$Budget8+$Budget9;
						$Total = $Sum1+$Sum2+$Sum3+$Sum4;*/
						
						/*ไตรมาสที่ 1*/
						$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostExtId);
						$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostExtId);
						$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostExtId);
						$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostExtId);
						/*ไตรมาสที่ 2*/
						$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostExtId);
						$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostExtId);
						$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostExtId);
						/*ไตรมาสที่ 3*/
						$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostExtId);
						$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostExtId);
						$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostExtId);
						/*ไตรมาสที่ 4*/
						$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostExtId);
						$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostExtId);
						$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostExtId);
					}
			?>
		   <tr>
		   <td style="text-indent:40px;">
		   <a href="?mod=<?php echo LURL::dotPage($AddCostExternalMonth); ?>&CostItemId=<?php echo $CostItemId; ?>&PrjActId=<?php echo $PrjActId; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&CostItemCode=<?php echo $CostItemCode; ?>&ParentCode=<?php echo $ParentCode; ?>&CostExtId=<?php echo $CostExtId; ?>&SourceExId=<?php echo $_REQUEST['SourceExId']; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>">
		   |-- <?php echo $Detail; ?></a>
           <?php 
		   echo '<span style="color:#990000; font-size:12px;">&nbsp;(&nbsp;';
		   echo ($Unit1)?(number_format($Value1,2)."&nbsp;".$get->getUnitName($Unit1)):"N/A";
		   echo ($Unit2)?(" x&nbsp;".number_format($Value2,2)."&nbsp;".$get->getUnitName($Unit2)):"";
		   echo ($Unit3)?(" x&nbsp;".number_format($Value3,2)."&nbsp;".$get->getUnitName($Unit3)):"";
		   echo ($Unit4)?(" x&nbsp;".number_format($Value4,2)."&nbsp;".$get->getUnitName($Unit4)):"";
		 // echo ($Unit2)?(" =&nbsp;".number_format($SumCost,2)." บาท"):"";
		    echo '&nbsp;)</span>';
		   ?>
           </td>
		   <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
  $NumCate++;
  } ?>
  <!--END วน loop หมวดงบรายจ่าย-->
   <?php
	 $SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"]);
	/*ไตรมาสที่ 1*/
	$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"]);
	$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,0,0,0,10);
	$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,0,0,0,11);
	$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,0,0,0,12);
	/*ไตรมาสที่ 2*/
	$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,0,0,0,1);
	$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,0,0,0,2);
	$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,0,0,0,3);
	/*ไตรมาสที่ 3*/
	$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,0,0,0,4);
	$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,0,0,0,5);
	$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,0,0,0,6);
	/*ไตรมาสที่ 4*/
	$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,0,0,0,7);
	$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,0,0,0,8);
	$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,$_REQUEST["SourceExId"],0,0,0,0,0,9);
 ?>
  <tr class="total">
    <td style="text-align:right;">รวมงบประมาณทั้งสิ้น</td>
   <td style="text-align:right;" title="งบคูณ 4 ช่อง"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
<!--</div>-->

<div style="text-align:center; margin-top:10px; margin-bottom:30px;">
<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ViewCost); ?>&PrjId=<?php echo $PrjId; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"];?>&SourceExId=<?php echo $_REQUEST["SourceExId"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>&BgtYear=<?php echo $_REQUEST['BgtYear']; ?>'" /> 
</div>