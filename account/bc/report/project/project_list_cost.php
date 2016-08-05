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

//นับระดับการกลั่นกรองงบ
$maxScreenLevel = $get->getMaxLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);

?>
<style>
.parentrow{
	background-color:#eee;
}
</style>
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


function getfilterorg(){
	var BgtYear = $('BgtYear').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($ListCost);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode+'&SCTypeId=<?php echo $_REQUEST["SCTypeId"];?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>';
}

function loadSCT(BgtYear){
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($ListCost);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode+'&SCTypeId=<?php echo $_REQUEST["SCTypeId"];?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>';
}
</script>

<script language="javascript">
function popWin(url)
{
	var param =  "width=800px,height:450px,resizable=1,scrollbars=1";
	url = url + '&format=raw';
	var Win = window.open(url,'',param);
}
</script>

<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการค่าใช้จ่ายในส่วนของ<?php echo $MenuName;?> </div>
</div>

<div class="topic-step"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
      	  <b>ปีงบประมาณ : <?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?></b>
          <b>หน่วยงาน : <span id="org-list"><?php echo $get->getOrganizeCode($_REQUEST["OrganizeCode"],ltxt::getVar('OrganizeCode'));?></span></b>
      </td>
       <td align="right">
       		<input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" />
       </td>
    </tr>
  </table>
</div>

<form>
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear']?>" />
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode']?>" />
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST['SCTypeId']?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST['ScreenLevel']?>" />

<div class="boxfilter-sub">&diams; &diams; &diams; 
	งบประมาณแผ่นดิน &diams; &diams; &diams;  
    <a href="javascript:void(0);" onclick="popWin('?mod=<?php echo LURL::dotPage($PopupCost); ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>')" style="background:url(images/budget/detail.png) left center no-repeat; padding-left:18px;"  class="txt-normal">ตัวคูณ 4 ช่อง</a>
    <a href="javascript:void(0);" onclick="popWin('?mod=<?php echo LURL::dotPage($PopupMonth); ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>')" style="background:url(images/budget/detail.png) left center no-repeat; padding-left:18px;"  class="txt-normal">รายเดือน / ไตรมาส</a>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;">
    <tr>
      <th style="width:700px;">รายการงบรายจ่าย</th>
      <th style="width:200px;">งบประมาณ</th>
    </tr>
    <?php
  $NumCate = 1; 
  $BGCate = $get->getCostTypeRecordSet();
  foreach($BGCate as $BGCateRow){ 
  	foreach($BGCateRow as $a=>$b){
		${$a} = $b;
	}
		$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0,0,$CostTypeId);
  ?>
  <tr class="cate">
      <td>
    <?php echo $NumCate; ?>. <?php echo $CostTypeName; ?> | 
	<?php if(!empty($SumTotalCost)){ ?>   
    <a href="javascript:void(0)" id="a-cate<?php echo $NumCate; ?>" onclick="showHide(<?php echo $NumCate; ?>);" class="icon-decre txt-normal">ย่อ</a>
    <?php }else{ ?>
    <a href="javascript:void(0)" id="a-cate<?php echo $NumCate; ?>" onclick="showHide(<?php echo $NumCate; ?>);" class="icon-incre txt-normal">ขยาย</a>
    <?php } ?>
       </td>
      <td style="text-align:right;"><?php echo ($SumTotalCost > 0)?number_format($SumTotalCost,2):"-"; ?></td>
    </tr>
  <tbody id="body-cate<?php echo $NumCate; ?>" <?php if(empty($SumTotalCost)){ ?> style="display:none"<?php } ?>>
  <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
   <?php
  $NumLevel1 = 1; 
  $BGLevel1 = $get->getCostItemRecordSet($CostTypeId);
  foreach($BGLevel1 as $BGLevel1Row){ 
  	foreach($BGLevel1Row as $c=>$d){
		${$c} = $d;
	}
			$CSItem = $get->getListCostItem($CostItemCode,$ParentCode);
			$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$CostItemCode,$ParentCode,0,$LevelId,$HasChild);

  ?>
  <tr class="level1">
    <td style="text-indent:10px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?><?php //echo " / ".$CostItemCode;?></td>
    <td style="text-align:right;"><?php echo ($SumTotalCost > 0)?number_format($SumTotalCost,2):"-"; ?></td>
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
		$CSItem = $get->getListCostItem($CostItemCode,$ParentCode);
		$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$CostItemCode,0,0,$LevelId,$HasChild);

  ?>
  <tr class="level2">
   <td style="text-indent:20px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?><?php //echo " / ".$CostItemCode;?></td>
    <td style="text-align:right;"><?php echo ($SumTotalCost > 0)?number_format($SumTotalCost,2):"-"; ?></td>
    </tr>
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
			$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$CostItemCode,$ParentCode,0,$LevelId,$HasChild);

  ?>
  <tr class="level3">
    <td style="text-indent:30px;"><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?><?php //echo " / ".$CostItemCode;?></td>
    <td style="text-align:right;"><?php echo ($SumTotalCost > 0)?number_format($SumTotalCost,2):"-"; ?></td>
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
  	<?php  $SumCost=$get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);?>

  <tr class="total">
    <th style="text-align:right;"><span class="txt-normal">( <?php echo JThaiBaht::_($SumCost); ?> )</span> รวมทั้งสิ้น</th>
    <th align="right"  style="text-align:right;"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></th>
    </tr>
</table>

<div style="padding-top:5px"></div>
<!--++++++++++++++++++++++++เงินนอกงบประมาณ***********************************-->
 <?php if(($_REQUEST["SCTypeId"] == 2 && $_REQUEST["ScreenLevel"] == $maxScreenLevel) || $_REQUEST["SCTypeId"] == 3 || $_REQUEST["SCTypeId"] == 4){ ?>

<?php

$getExName=$get->getSourceName();
foreach($getExName as $sName){
	foreach($sName as $k=>$v){
		${$k} = $v;
	}
	
?>
<input type="hidden" name="SourceExId[]" id="SourceExId" value="<?php echo $SourceExId; ?>" />

<div class="boxfilter-sub">&diams; &diams; &diams; 
	เงินนอกงบประมาณ [ <?php echo $SourceExName;?> ] &diams; &diams; &diams;  
    <a href="javascript:void(0);" onclick="popWin('?mod=<?php echo LURL::dotPage($PopupCostEx); ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&SourceExId=<?php echo $SourceExId;?>')" style="background:url(images/budget/detail.png) left center no-repeat; padding-left:18px;"  class="txt-normal">ตัวคูณ 4 ช่อง</a>
    <a href="javascript:void(0);" onclick="popWin('?mod=<?php echo LURL::dotPage($PopupMonthEx); ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&SourceExId=<?php echo $SourceExId;?>')" style="background:url(images/budget/detail.png) left center no-repeat; padding-left:18px;"  class="txt-normal">รายเดือน / ไตรมาส</a>
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;"  >
    <tr>
      <th style="width:700px;">รายการงบรายจ่าย</th>
      <th style="width:200px;">งบประมาณ</th>
    </tr>
    <?php
   	$NumCate2=1;
	$listEx = $get->getCostTypeRecordSet();
		foreach($listEx as $rEx){
			foreach($rEx as $k=>$v){
				${$k} = $v;
			}
			$CostTypeName2 = $CostTypeName;
			$CostTypeId2 = $CostTypeId;
			$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,0,0,$CostTypeId);

?>
  <tr class="cate">
      <td>
	<?php echo $NumCate2; ?>. <?php echo $CostTypeName2; ?> | 
   	<?php if(!empty($SumCost)){ ?>   
    <a href="javascript:void(0)" id="a-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>" onclick="showHideTwo<?php echo $SourceExId; ?>(<?php echo $NumCate2; ?>);" class="icon-decre txt-normal">ย่อ</a> 
    <?php }else{ ?>
    <a href="javascript:void(0)" id="a-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>" onclick="showHideTwo<?php echo $SourceExId; ?>(<?php echo $NumCate2; ?>);" class="icon-incre txt-normal">ขยาย</a> 
    <?php } ?>

	</td>
    <td style="text-align:right;"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
    </tr>
  <tbody id="body-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>"  <?php if(empty($SumCost)){ ?> style="display:none"<?php } ?>>
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
	$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode,0,$CostTypeId,$LevelId,$HasChild);

  ?>
    <tr class="level1">
      <td style="text-indent:10px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?> <?php echo $CostName3; ?> </td>
      <td style="text-align:right;"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
      </tr>
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
	
	$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);

?>
    <tr class="level2">
      <td style="text-indent:20px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?>.<?php echo $NumLevel22; ?> <?php echo $CostName4; ?></td>
      <td style="text-align:right;"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
      </tr>
    <!--ถ้า HasChild=Y ให้มีการดึงรายการงบรายจ่ายระดับที่ 3-->  
    <?php if($HasChild == Y){ ?>
    <!--วน loop รายการงบรายจ่าย ระดับที่ 3-->
    <?php
  $NumLevel33 = 1; 
  $BGLevel33 = $get->getCostItemRecordSet($CostTypeId4,3,$CostItemCode4);
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
	$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
  ?>
    <tr class="level3">
      <td style="text-indent:30px;"><?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?>.<?php echo $NumLevel22; ?>.<?php echo $NumLevel33; ?> <?php echo $CostName5; ?></td>
      <td style="text-align:right;"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></td>
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
    <?php  $SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId);?>
 
  
  <tr class="total">
    <th style="text-align:right;"><span class="txt-normal">( <?php echo JThaiBaht::_($SumCost); ?> )</span> รวมทั้งสิ้น</th>
    <th align="right"  style="text-align:right;"><?php echo ($SumCost > 0)?number_format($SumCost,2):"-"; ?></th>
    </tr>
</table>
<div style="padding-top:5px"></div>
<?php
}
?>


<?php
	// เงินงบประมาณแผ่นดิน+เงินนอกงบประมาณ
	$TotalCost = $get->getTotalPrj($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;"  >
  <tr style="background-color:#6AAD6E; font-weight:bold">
    <td style="text-align:right; width:700px;"><span class="txt-normal">( <?php echo JThaiBaht::_($TotalCost); ?> )</span> เงินงบประมาณแผ่นดิน+เงินนอกงบประมาณ</td>
    <td style="text-align:right; width:200px;"><?php  echo number_format($TotalCost,2);?></td>
  </tr>
</table>


<?php } ?>

<!--END วน loop แหล่งเงินนนอกงบ-->
</form>
<div style="text-align:center; margin-top:10px; margin-bottom:30px;">
<input name="cancel" type="button" value="ย้อนกลับ" class="btn cancle" onclick="history.back(-1);" />
</div>



