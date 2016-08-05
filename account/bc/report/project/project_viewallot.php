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

$allot = $get->getAllotDetail($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],0);
//ltxt::print_r($allot);

$scLevel = $get-> getScreenLevel($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);
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

	if((JQ('#SumBGAllot').val() >= parseFloat(1) )  ||  (JQ('#SumBGAllotTwo').val() >= parseFloat(1)) ){
   			 form.submit();
	}else{
	
		alert('กรุณาตรวจสอบงบจัดสรรต้องมากกว่าศูนย์');	
		JQ('#SumBGAllot').focus();
		JQ('#SumBGAllotTwo').focus();
	}
	


}
function getfilterorg(){
	var BgtYear = $('BgtYear').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($ViewAllot);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}

function loadSCT(BgtYear){
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($ViewAllot);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}

</script>

<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td class="td-descr" style="width:225px;"><b>ปีงบประมาณ : <?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?></b></th>
      <td class="td-descr" style="width:382px;"><b>หน่วยงาน : <span id="org-list"><?php echo $get->getOrganizeCode($_REQUEST["OrganizeCode"],ltxt::getVar('OrganizeCode'));?></span></b></td>
    </tr>
  </table>
</div>
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=saveallot" onSubmit="SaveAllot(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear']?>" />
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode']?>" />
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST['SCTypeId']?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST['ScreenLevel']?>" />

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
	
	$sumScreenType = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,0,0,$CostTypeId,0,0);
	
	$sumAllotType = $get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,0,0,$CostTypeId,0,0);
	
	//$get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,$CostTypeId,0,$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
  ?>
  <tr class="cate">
    <td><?php echo $NumCate; ?>. <?php echo $CostTypeName; ?> | <a href="javascript:void(0)" id="a-cate<?php echo $NumCate; ?>" onclick="showHide(<?php echo $NumCate; ?>);" class="icon-decre txt-normal">ย่อ</a></td>
    <td style="text-align:right"><?php echo ($sumScreenType > 0)?number_format($sumScreenType,2):"-"; ?></td>
    <td style="text-align:right"><?php echo ($sumAllotType > 0)?number_format($sumAllotType,2):"-"; ?></td>
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
	
	$sumScreenLevel1 = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$sumAllotLevel1 = $get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	//$get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,$CostTypeId,$CostItemCode,$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);	
		
  ?>
  <tr class="level1">
    <td style="text-indent:10px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></td>
    <td style="text-align:right"><?php echo ($sumScreenLevel1 > 0)?number_format($sumScreenLevel1,2):"-"; ?></td>
    <td style="text-align:right"><?php echo ($sumAllotLevel1 > 0)?number_format($sumAllotLevel1,2):"-"; ?></td>
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
	
	
	$sumScreenLevel2 = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$sumAllotLevel2 = $get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	//$get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,$CostTypeId,$CostItemCode,$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);	
	
	
  ?>
  <tr class="level2">
    <td style="text-indent:20px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></td>
    <td style="text-align:right"><?php echo ($sumScreenLevel2 > 0)?number_format($sumScreenLevel2,2):"-"; ?></td>
    <td style="text-align:right"><?php echo ($sumAllotLevel2 > 0)?number_format($sumAllotLevel2,2):"-"; ?></td>
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
	
	$sumScreenLevel3 = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$sumAllotLevel3 =   $get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	//$get->getBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,$CostTypeId,$CostItemCode,$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);
  ?>
  <tr class="level3">
    <td style="text-indent:40px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?></td>
    <td style="text-align:right"><?php echo ($sumScreenLevel3 > 0)?number_format($sumScreenLevel3,2):"-"; ?></td>
    <td style="text-align:right"><?php echo ($sumAllotLevel3 > 0)?number_format($sumAllotLevel3,2):"-"; ?></td>
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
	   $TotalScreen = $get->getTotalBGAllotInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],2,$scLevel[0]->SLevel,$scLevel[0]->AllotId,0,0,0,0,0);
	   $TotalAllot = $get->getBGTotalInternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,0,0,$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);

    ?>    
  <tr class="total">
    <td style="text-align:right;">รวมงบประมาณทั้งสิ้น (บาทถ้วน)</td>
    <td  style="text-align:right;"><?php echo ($TotalScreen > 0)?number_format($TotalScreen,2):"-"; ?></td>
    <td style="text-align:right;"><?php echo ($TotalAllot > 0)?number_format($TotalAllot,2):"-"; ?></td>
  </tr>
</table>

<br />
<br />


<?php
$getExName=$get->getSourceName();
foreach($getExName as $sName){
	foreach($sName as $k=>$v){
		${$k} = $v;
	}
?>
<input type="hidden" name="SourceExId[]" id="SourceExId" value="<?php echo $SourceExId; ?>" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<td  style="padding-left:20px">งบอุดหนุน (<?php echo $SourceExName;?>)</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;"  >
  <tr>
    <th style="width:68%">หมวดงบ/รายการงบรายจ่าย</th>
    <th  style="text-align:right; width:16%">งบขอจัดตั้ง (บาท)</th>
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
			
			$sumBGTypeEx  = $get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,1,0,$SourceExId,0,0,$CostTypeId2,0,0);
			
			$sumAllotTypeEx = $get->getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,0,0,$CostTypeId2,0,0,$SourceExId);
			
			//getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,$CostTypeId5,$CostItemCode5,$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$SourceExId);
			
			
?>
  <tr class="cate">
    <td >
<?php echo $NumCate2; ?>. <?php echo $CostTypeName2; ?> | <a href="javascript:void(0)" id="a-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>" onclick="showHideTwo<?php echo $SourceExId; ?>(<?php echo $NumCate2; ?>);" class="icon-decre txt-normal">ย่อ</a>    
   </td>
    <td align="right" ><?php echo ($sumBGTypeEx > 0)?number_format($sumBGTypeEx,2):"-"; ?></td>
    <td align="right"><?php echo ($sumAllotTypeEx > 0)?number_format($sumAllotTypeEx,2):"-"; ?></td>
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
	$HasChild3 = $HasChild;
	
	$sumBGLevel1Ex = $get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,1,0,$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3);
	
	$sumAllotLevel1Ex = $get->getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,$SourceExId);
	
	//getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,$CostTypeId3,$CostItemCode3,$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$SourceExId);
  ?>
  <tr class="level1">
    <td style="text-indent:10px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?> <?php echo $CostName3; ?></td>
    <td style="text-align:right"><?php echo ($sumBGLevel1Ex > 0)?number_format($sumBGLevel1Ex,2):"-"; ?></td>
    <td style="text-align:right"><?php echo ($sumAllotLevel1Ex > 0)?number_format($sumAllotLevel1Ex,2):"-"; ?></td>
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
	
	$sumBGLevel2Ex = $get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,1,0,$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4);
	
	$sumAllotLevel2Ex = $get->getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,$SourceExId);
	
	//getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,$CostTypeId4,$CostItemCode4,$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$SourceExId);
	
?>
  <tr class="level2">
    <td style="text-indent:20px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?>.<?php echo $NumLevel22; ?> <?php echo $CostName4; ?> </td>
    <td style="text-align:right"><?php echo ($sumBGLevel2Ex > 0)?number_format($sumBGLevel2Ex,2):"-"; ?></td>
    <td style="text-align:right"><?php echo ($sumAllotLevel2Ex > 0)?number_format($sumAllotLevel2Ex,2):"-"; ?></td>
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
	
	$sumBGLevel3Ex = $get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,1,0,$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5);
	
	$sumAllotLevel3Ex = $get->getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$allot[0]->AllotId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,$SourceExId);
	
	//$get->getBGAllotExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,$CostTypeId5,$CostItemCode5,$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$SourceExId);
	
  ?>
  <tr class="level3">
    <td style="text-indent:40px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?>.<?php echo $NumLevel22; ?>.<?php echo $NumLevel33; ?> <?php echo $CostName5; ?></td>
    <td style="text-align:right"><?php echo ($sumBGLevel3Ex > 0)?number_format($sumBGLevel3Ex,2):"-"; ?></td>
    <td style="text-align:right"> <?php echo ($sumAllotLevel3Ex > 0)?number_format($sumAllotLevel3Ex,2):"-"; ?></td>
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
  	<?php 
		$TotalBGEx = $get->getTotalPrjExternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],0,0,0,0,1,0,$SourceExId,0,0,0,0,0); 
		
		$TotalAllotEx = $get->getBGTotalExternal($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$allot[0]->AllotId,0,0,$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$SourceExId);
		
	?>

  <tr class="total">
    <td style="text-align:right;">รวมงบประมาณทั้งสิ้น (บาทถ้วน)</td>
    <td  style="text-align:right;"><?php echo ($TotalBGEx > 0)?number_format($TotalBGEx,2):"-"; ?></td>
    <td style="text-align:right;"><?php echo ($TotalAllotEx > 0)?number_format($TotalAllotEx,2):"-"; ?></td>
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
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></div>
      
</form>



