<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'รายละเอียด',
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));


/*echo "BgtYear=".$_REQUEST["BgtYear"];
echo "OrganizeCode=".$_REQUEST["OrganizeCode"];
echo "SCTypeId=".$_REQUEST["SCTypeId"];
echo "ScreenLevel=".$_REQUEST["ScreenLevel"];*/

//$allot = $get->getAllotDetail($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],0);

$allot = $get->getAllotDetail($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);

//ltxt::print_r($allot);

$scLevel = $get-> getScreenLevel($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);
//ltxt::print_r($scLevel);


?>
<script type="text/javascript">

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


function CalCostSum(CostItemCode){

var Obj2 = JQ('#BGAllot'+CostItemCode);
var Value2 = Obj2.val();
//alert(Value2);

				var sum =0;
				
				 JQ('input[rel=RelBGAllot]').each(function(){
						 num = parseFloat(JQ(this).val());
						 if( !isNaN(num)) sum = sum + num; 
				 });
				 
				 JQ('#SumBGAllot').val(sum);
					
}


function SaveAllot(form){	


	if(JQ('#SumBGAllot').val() >= parseFloat(1)){
   			 form.submit();
	}else{
	
		alert('กรุณาตรวจสอบงบจัดสรรต้องมากกว่าศูนย์');	
		JQ('#SumBGAllot').focus();
	}



}

</script>

<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
  <tr>
    <th style="width:20%; text-align:left">ปีงบประมาณ</th>
    <td  style="width:80%; text-align:left; font-weight:bold"><?php echo $_REQUEST['BgtYear'];?></td>
  </tr>
  <tr>
    <th style="text-align:left">หน่วยงาน</th>
    <td  style="text-align:left; font-weight:bold"><?php echo $get->getOrganizeName($_REQUEST["OrganizeCode"]);?></td>
  </tr> 
  <tr>
    <th style="text-align:left">โครงการ</th>
    <td  style="text-align:left; font-weight:bold"><?php echo $get->getPrjName($_REQUEST["PrjId"]);?></td>
  </tr>
  <tr>
    <th style="text-align:left">กิจกรรม</th>
    <td  style="text-align:left; font-weight:bold"><?php echo $get->getPrjActName($_REQUEST["PrjActId"]);?></td>
  </tr> 
</table>
<br />


<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=saveallot" onSubmit="SaveAllot(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear']?>" />
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode']?>" />
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST['SCTypeId']?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST['ScreenLevel']?>" />

<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId']?>" />
<input type="hidden" name="PrjActCode" id="PrjActCode" value="<?php echo $_REQUEST['PrjActCode']?>" />
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId']?>" />
<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $_REQUEST['PrjId']?>" />

<input type="hidden" name="AllotId" id="AllotId" value="<?php echo $allot[0]->AllotId; ?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<td  style="padding-left:20px">งบประมาณแผ่นดิน</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;">
  <tr>
    <th style="width:68%">หมวดงบ/รายการงบรายจ่าย</th>
    <th  style="text-align:right; width:16%">งบกลั่นกรอง (บาท)</th>
    <th style="text-align:right; width:16%">งบจัดสรร (บาท)</th>
  </tr>
  <!--วน loop หมวดงบรายจ่าย-->
  <?php
  $NumCate = 1; 
  $BGCate = $get->getCostTypeRecordSet();
  //ltxt::print_r($BGCate);
  foreach($BGCate as $BGCateRow){ 
  	foreach($BGCateRow as $a=>$b){
		${$a} = $b;
	}

	   //echo number_format($get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,0,0,$CostTypeId,0,0),2);
	   
	$sumBGTypeIn = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,0,0,$CostTypeId,0,0,$scLevel[0]->PrjDetailId,$scLevel[0]->PrjActId,$scLevel[0]->PrjActCode);
	
	$SumBGAllotInLevelType = $get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,0,0,$CostTypeId,0,0,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);
	
  ?>
  <tr class="cate">
    <td><?php echo $NumCate; ?>. <?php echo $CostTypeName; ?> | <a href="javascript:void(0)" id="a-cate<?php echo $NumCate; ?>" onclick="showHide(<?php echo $NumCate; ?>);" class="icon-decre txt-normal">ย่อ</a></td>
    <td style="text-align:right"><?php echo number_format($sumBGTypeIn,2); ?></td>
    <td style="text-align:right"><?php echo number_format($SumBGAllotInLevelType,2); ?></td>
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

//$get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild)
	
	$sumBGInLevel1 = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$scLevel[0]->PrjDetailId,$scLevel[0]->PrjActId,$scLevel[0]->PrjActCode);
	
	$SumBGAllotInLevel1 = $get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);	
	
//$get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild)
		
  ?>
  <tr class="level1">
    <td style="text-indent:10px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?> <?php echo " / ".$CostItemCode;?></td>
    <td style="text-align:right"><?php echo number_format($sumBGInLevel1,2); ?></td>
    <td style="text-align:right"><?php echo number_format($SumBGAllotInLevel1,2); ?></td>
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
	
//$get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild)
	
	$sumBGInLevel2 = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$scLevel[0]->PrjDetailId,$scLevel[0]->PrjActId,$scLevel[0]->PrjActCode);
	
	$SumBGAllotInLevel2 = $get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);	
	
//$get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild)	
	
  ?>
  <tr class="level2">
    <td style="text-indent:20px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?> <?php echo " / ".$CostItemCode;?></td>
    <td style="text-align:right"><?php echo number_format($sumBGInLevel2,2); ?></td>
    <td style="text-align:right"><?php echo number_format($SumBGAllotInLevel2,2); ?></td>
    </tr>
  
  
  
  <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->  
  <?php if($HasChild == Y){ ?>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 3-->
   <?php
  $NumLevel3 = 1; 
  $BGLevel3 = $get->getCostItemRecordSet($CostTypeId,3,$CostItemCode);
  //ltxt::print_r($BGLevel3);
  foreach($BGLevel3 as $BGLevel3Row){ 
  	foreach($BGLevel3Row as $g=>$h){
		${$g} = $h;
	}
//$get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild)	
	
	$sumBGInLevel3 = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$scLevel[0]->PrjDetailId,$scLevel[0]->PrjActId,$scLevel[0]->PrjActCode);
	
	$SumBGAllotInLevel3 = $get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);

	//$get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild)
	
  ?>
  <tr class="level3">
    <td style="text-indent:40px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?><?php echo " / ".$CostItemCode;?></td>
    <td style="text-align:right"><?php echo number_format($sumBGInLevel3,2); ?></td>
    <td style="text-align:right"><?php echo number_format($SumBGAllotInLevel3,2); ?></td>
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
   </tbody>
  
  
  
  
  <?php 
  $NumCate++;
  } ?>


  <!--END วน loop หมวดงบรายจ่าย-->
	<?php 
	   //echo number_format($get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,0,0,0,0,0),2);
	   
	   $TotalBGIn = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,0,0,0,0,"",$scLevel[0]->PrjDetailId,$scLevel[0]->PrjActId,$scLevel[0]->PrjActCode);
	   	 
		$TotalBGAllotInLevel = $get->getBGTotalInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,0,0,$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);
		  
		//$get->getBGTotalInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,0,0,$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"])  
				   
    ?>     
  <tr class="total">
    <td style="text-align:right;">รวมงบประมาณทั้งสิ้น (บาทถ้วน)</td>
    <td  style="text-align:right;"><?php echo number_format($TotalBGIn,2); ?></td>
    <td style="text-align:right;"><?php echo number_format($TotalBGAllotInLevel,2); ?></td>
  </tr>
</table>

<br />
<br />


<?php
$getExName=$get->getSourceExName();
//ltxt::print_r($getExName);
foreach($getExName as $sName){
	foreach($sName as $k=>$v){
		${$k} = $v;
	}
?>
<input type="hidden" name="SourceExId[]" id="SourceExId" value="<?php echo $SourceExId; ?>" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<td  style="padding-left:20px">เงินนอกงบประมาณ  [<?php echo $SourceExName;?>]</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;"  >
  <tr>
    <th style="width:68%">หมวดงบ/รายการงบรายจ่าย</th>
    <th  style="text-align:right; width:16%">งบประมาณโครงการ (บาท)</th>
    <th style="text-align:right; width:16%">งบจัดสรร (บาท)</th>
  </tr>
<?php
   	$NumCate2=1;
	//$listEx = $get->getCostType($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$SourceExId);
	$listEx = $get->getCostTypeRecordSet();
	//ltxt::print_r($listEx);
		foreach($listEx as $rEx){
			foreach($rEx as $k=>$v){
				${$k} = $v;
			}
			
			$CostTypeName2 = $CostTypeName;
			$CostTypeId2 = $CostTypeId;
			
			$sumBGExType = $get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,0,0,$CostTypeId2,0,0);
			
			//$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,1,0,$SourceExId,0,0,$CostTypeId2,0,0)
			
	$SumBGAllotExLevelType = $get->getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,0,0,$CostTypeId2,0,0,$SourceExId,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"])	
			
?>
  <tr class="cate">
    <td >
<?php echo $NumCate2; ?>. <?php echo $CostTypeName2; ?> | <a href="javascript:void(0)" id="a-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>" onclick="showHideTwo<?php echo $SourceExId; ?>(<?php echo $NumCate2; ?>);" class="icon-decre txt-normal">ย่อ</a>    
   </td>
    <td align="right" ><?php echo number_format($sumBGExType,2); ?></td>
    <td style="text-align:right" ><?php echo number_format($SumBGAllotExLevelType,2); ?></td>
  </tr>
  
  <tbody id="body-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>">
  <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
   <?php
  $NumLevel11 = 1; 
  $BGLevel11 = $get->getCostItemRecordSet($CostTypeId2);
  //ltxt::print_r($BGLevel11);
  foreach($BGLevel11 as $BGLevel11Row){ 
  	foreach($BGLevel11Row as $c=>$d){
		${$c} = $d;
	}
	$CostName3 = $CostName;
	$CostItemCode3 = $CostItemCode;
	$CostTypeId3 = $CostTypeId;
	$ParentCode3 = $ParentCode;
	$LevelId3 = $LevelId;
	$HasChild3 = $HasChild	;
	
	$sumBGExLevel1 = $get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3);
	
	$SumBGAllotExLevel1 = $get->getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,$SourceExId,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);
	
	//$get->getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,$SourceExId)
	
  ?>
  <tr class="level1">
    <td style="text-indent:10px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?> <?php echo $CostName3; ?> <?php echo " / ".$CostItemCode3;?></td>
    <td style="text-align:right"><?php echo number_format($sumBGExLevel1,2); ?></td>
    <td style="text-align:right"><?php echo number_format($SumBGAllotExLevel1,2); ?></td>
    </tr>
  
  <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->  
  <?php if($HasChild == Y){ ?>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 2-->
   <?php
  $NumLevel22 = 1; 
  $BGLevel22 = $get->getCostItemRecordSet($CostTypeId3,2,$CostItemCode3);
  //ltxt::print_r($BGLevel22);
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

	//$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,1,0,$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4)

	$sumBGExLevel2 = $get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4);
	
	$SumBGAllotExLevel2 = $get->getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,$SourceExId,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);
	
	//$get->getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,$SourceExId)
	
?>
  <tr class="level2">
    <td style="text-indent:20px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?>.<?php echo $NumLevel22; ?> <?php echo $CostName4; ?> <?php echo " / ".$CostItemCode4;?></td>
    <td style="text-align:right"><?php echo number_format($sumBGExLevel2,2); ?></td>
    <td style="text-align:right"><?php echo number_format($SumBGAllotExLevel2,2); ?></td>
    </tr>
  
  
  
  <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->  
  <?php if($HasChild == Y){ ?>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 3-->
   <?php
  $NumLevel33 = 1; 
  $BGLevel33 = $get->getCostItemRecordSet($CostTypeId4,3,$CostItemCode4);
 // ltxt::print_r($BGLevel33);
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
	
	//$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,1,0,$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5);
	
	$sumBGExLevel3 = $get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5);	
		
	$SumBGAllotExLevel3 = $get->getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,$SourceExId,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"])	
	
	//$get->getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,$SourceExId);
	
  ?>
  <tr class="level3">
    <td style="text-indent:40px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?>.<?php echo $NumLevel22; ?>.<?php echo $NumLevel33; ?> <?php echo $CostName5; ?><?php echo " / ".$CostItemCode5;?></td>
    <td style="text-align:right"><?php echo number_format($sumBGExLevel3,2); ?></td>
    <td style="text-align:right"><?php echo number_format($SumBGAllotExLevel3,2); ?> </td>
    </tr>
  <?php 
  $NumLevel33++;
  } ?>
  <!--END วน loop รายการงบรายจ่าย ระดับที่ 3-->
  <?php } ?>
  <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->
  
  
  
  
  
  <?php 
  $NumLevel22++;
  } ?>
  <!--END วน loop รายการงบรายจ่าย ระดับที่ 2-->
  <?php } ?>
  <!--END ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 2-->
  
  
  
  
  
  <?php 
  $NumLevel11++;
  } ?>
  <!--END วน loop รายการงบรายจ่าย ระดับที่ 1-->
   </tbody>
    
  <script type="text/javascript">
	function showHideTwo<?php echo $SourceExId; ?>(i){
		//alert("showHideTwo<?php echo $SourceExId; ?>");
		
		if(JQ('#body-catetwo<?php echo $SourceExId; ?>'+i).is(':hidden')===true){
			JQ('#body-catetwo<?php echo $SourceExId; ?>'+i).show('slow');
			JQ('#a-catetwo<?php echo $SourceExId; ?>'+i).addClass('icon-decre');
			JQ('#a-catetwo<?php echo $SourceExId; ?>'+i).removeClass('icon-incre');
			JQ('#a-catetwo<?php echo $SourceExId; ?>'+i).html('ย่อ');
		}else{
			JQ('#body-catetwo<?php echo $SourceExId; ?>'+i).hide('slow');
			JQ('#a-catetwo<?php echo $SourceExId; ?>'+i).removeClass('icon-decre');
			JQ('#a-catetwo<?php echo $SourceExId; ?>'+i).addClass('icon-incre');
			JQ('#a-catetwo<?php echo $SourceExId; ?>'+i).html('ขยาย');
		}
	}  
  </script>
  

<?php  $NumCate2++; } ?>


  <!--END วน loop หมวดงบรายจ่าย-->
  		<?php //echo number_format($get->getTotalPrjExternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],0,0,0,0,1,0,$SourceExId,0,0,0,0,0),2); 
		
		
		$TotalBGEx = $get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,0,0,0,0,0);
		
		$TotalBGAllotExLevel = $get->getBGTotalExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,0,0,$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$SourceExId,$_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"],$_REQUEST["PrjActCode"]);
		
		//$get->getBGTotalExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,0,0,$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$SourceExId)
		
		?>
  
  <tr class="total">
    <td style="text-align:right;">รวมงบประมาณทั้งสิ้น (บาทถ้วน)</td>
    <td  style="text-align:right;"><?php echo number_format($TotalBGEx,2); ?></td>
    <td style="text-align:right;"><?php echo number_format($TotalBGAllotExLevel,2); ?></td>
  </tr>

</table>

<br />
<br />

<script type="text/javascript">
function CalCostSumTwo<?php echo $SourceExId; ?>(CostItemCode){

var Obj2 = JQ('#BGAllotTwo_<?php echo $SourceExId; ?>'+CostItemCode);
var Value2 = Obj2.val();
//alert(Value2);

				var sum =0;
				
				 JQ('input[rel=RelBGAllotTwo_<?php echo $SourceExId; ?>]').each(function(){
						 num = parseFloat(JQ(this).val());
						 if( !isNaN(num)) sum = sum + num; 
				 });
				 
				 JQ('#SumBGAllotTwo_<?php echo $SourceExId; ?>').val(sum);
					
}
</script>
<?php
}
?>
<!--END วน loop แหล่งเงินนนอกงบ-->

     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listProjectViewPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>&SCTypeId=<?php echo $_REQUEST['SCTypeId'];?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel'];?>');" /></div>
      
</form>



