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


$datas = $get->getActivityDetail($_REQUEST["$PrjDetailId"],$_REQUEST["PrjActId"]);
//ltxt::print_r($datas);
foreach($datas as $actdatas){
	foreach($actdatas as $k=>$v){
		${$k} = $v;
	}
}

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 


$SourceExName=$get->getSourceExName($_REQUEST['SourceExId']);

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
<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>

<?php $curProcess = $get->getCurProcess($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);//ดึงข้อมูลขั้นตอนปัจจุบันของหน่วยงาน?>
<div class="topic-step"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>


<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td align="right">
		<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ViewCost); ?>&PrjId=<?php echo $PrjId; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>&PrjActId=<?php echo $_REQUEST["PrjActId"]; ?>&SourceExId=<?php echo $_REQUEST["SourceExId"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>&BgtYear=<?php echo $_REQUEST['BgtYear']; ?>'" />    
      </td>
    </tr>
  </table>  
</div>

<form name="Form" id="Form" method="post">
<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $PrjId;?>">
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>">
<input type="hidden" name="SourceExId" id="SourceExId" value="<?php echo $_REQUEST["SourceExId"];?>">

    <?php
		// งบประมาณโครงการ
		$SumTotalPrj = $get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
	
		//เงินนอกงบประมาณ 
		$SumBGTotal=$get->getTotalPrjExternalX4($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["SourceExId"]);

		// งบจัดสรร
		$sumAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId,0,$_REQUEST["SourceExId"]);
		
	?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" >
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
       <td >
       <?php 
        $TaskPerson = $get->getTaskPerson($PrjId); 
		if(!$TaskPerson){ echo '<span style="color:#999;">-ไม่ระบุ-</span>'; }
       echo "<ul>";
       foreach($TaskPerson as $rRName){
            foreach($rRName as $k=>$v){
                ${$k} = $v;
            }
            echo "<li>";
            echo $Name;
            if($ResultStatus == 'Y'){echo " (ผู้รายงาน)";}
            echo "</li>";
       }
       echo "</ul>";
        
       ?>
       </td>
     </tr>
     <tr>
     <th>ชื่อกิจกรรม</th>
      <td style="text-align:left; font-weight:bold; color:#990000;"><?php echo $PrjActName?></td> 
    </tr>
     <tr>
      <th>ระยะเวลากิจกรรม</th>
      <td><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td> 
    </tr>
    
    <?php
/*		$SumBGTotal=0;
		if($_REQUEST["SCTypeId"] == 2  ){
		 	$SumBGTotal=$get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
		}else{
			$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],0,0); 	
		}	*/	
		
		// งบโครงการ
		 $SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);		
		
		
		 $SumTotalPrjInternalX4=$get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);		
		
		
		$sumScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllot = $sumScreenInternal + $sumAllotExternal;		
	?>
     <?php //if(in_array($_REQUEST["SCTypeId"],array(3,4))){ ?> 
     <!--<tr>   
      <th style="text-align:left">งบประมาณแผ่นดิน</th>
      <td ><div class="txtright txtbold"><?php //echo number_format($SumTotalPrjInternalX4,2); ?>&nbsp;บาท</div></td>
    </tr>      
    <?php //} ?>  
   <?php //if(in_array($_REQUEST["SCTypeId"],array(2,3,4))){ ?> 
   <tr>
      <th style="text-align:left">
	  	<?php 
				//switch ($_REQUEST["SCTypeId"]) {
					//case 2:
					//	echo "งบกลั่นกรอง";
					//break;				
					//case 3:
					//	echo "งบจัดสรร";
					//break;
					//case 4:
						//echo "งบปรับระหว่างปี";
					//break;								
				//}		
		?>
      </th>
      <td ><div class="txtred txtright txtbold"><?php //echo number_format($sumScreenInternal,2); ?>&nbsp;บาท</div></td>
    </tr>
    <?php //} ?>  
        <tr>
      <th style="text-align:left">งบประมาณโครงการ</th>
      <td ><div class="txtblue txtright txtbold"><?php //echo number_format($SumBGTotal,2); ?>&nbsp;บาท</div></td>
    </tr> -->
    </table>


<div class="boxfilter2"><div class="icon-topic">เงินนอกงบประมาณ [ <?php echo $SourceExName;?> ]</div></div>



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
	$SumTotalCost = $get->getTotalPrjExternalX4(0,0,0,0,0,$_REQUEST["PrjActId"],0,0,$_REQUEST["SourceExId"],0,0,$CostTypeId);
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
			$SumTotalCost = $get->getTotalPrjExternalX4(0,0,0,0,0,$_REQUEST["PrjActId"],0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,0,$LevelId,$HasChild);

  ?>
  <tr class="level1">
    <td style="text-indent:10px;">
    <?php if($HasChild == N){ ?><a href="?mod=<?php echo LURL::dotPage($AddCostExternal); ?>&CostItemId=<?php echo $CostItemId; ?>&PrjActId=<?php echo $PrjActId; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&CostItemCode=<?php echo $CostItemCode; ?>&ParentCode=<?php echo $ParentCode; ?>&SourceExId=<?php echo $_REQUEST['SourceExId']; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>&BgtYear=<?php echo $_REQUEST['BgtYear']; ?>">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></a>
	<?php }else{?><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?><?php } ?></td>
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
			$CRequireItem = $get->getItemRequireExternal($CostItemCode,$_REQUEST["PrjActId"],0,0,$_REQUEST["SourceExId"]);
			foreach($CRequireItem as $RCRequireItem){
				foreach($RCRequireItem as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:30px;"><?php echo "|-- ".$Detail; ?></td>
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
		$SumTotalCost = $get->getTotalPrjExternalX4(0,0,0,0,0,$_REQUEST["PrjActId"],0,0,$_REQUEST["SourceExId"],$CostItemCode,0,0,$LevelId,$HasChild);
  ?>
  <tr class="level2">
    <td style="text-indent:20px;">
	<?php if($HasChild == N){ ?><a href="?mod=<?php echo LURL::dotPage($AddCostExternal); ?>&CostItemId=<?php echo $CostItemId; ?>&PrjActId=<?php echo $PrjActId; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&CostItemCode=<?php echo $CostItemCode; ?>&ParentCode=<?php echo $ParentCode; ?>&SourceExId=<?php echo $_REQUEST['SourceExId']; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>&BgtYear=<?php echo $_REQUEST['BgtYear']; ?>">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></a><?php }else{?><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?><?php } ?></td>
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
			$CRequireItem = $get->getItemRequireExternal($CostItemCode,$_REQUEST["PrjActId"],0,0,$_REQUEST["SourceExId"]);
			foreach($CRequireItem as $RCRequireItem){
				foreach($RCRequireItem as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:50px;"><?php echo "|-- ".$Detail; ?></td>
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
			$SumTotalCost = $get->getTotalPrjExternalX4(0,0,0,0,0,$_REQUEST["PrjActId"],0,0,$_REQUEST["SourceExId"],$CostItemCode,$ParentCode,0,$LevelId,$HasChild);

  ?>
  <tr class="level3">
    <td style="text-indent:40px;">
	 <?php if($HasChild == N){ ?><a href="?mod=<?php echo LURL::dotPage($AddCostExternal); ?>&CostItemId=<?php echo $CostItemId; ?>&PrjActId=<?php echo $PrjActId; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&CostItemCode=<?php echo $CostItemCode; ?>&ParentCode=<?php echo $ParentCode; ?>&SourceExId=<?php echo $_REQUEST['SourceExId']; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>&BgtYear=<?php echo $_REQUEST['BgtYear']; ?>">
	<?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?></a>
	<?php }else{?><?php echo $NumCate; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?><?php }?></td>
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
			$CRequireItem = $get->getItemRequireExternal($CostItemCode,$_REQUEST["PrjActId"],0,0,$_REQUEST["SourceExId"]);
			//ltxt::print_r($CRequireItem);
			foreach($CRequireItem as $RCRequireItem){
				foreach($RCRequireItem as $k=>$v){
					${$k} = $v;
				}
			?>
		   <tr>
		   <td style="text-indent:80px;"><?php echo "|-- ".$Detail; ?></td>
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
    <td colspan="9" style="text-align:right;">(<?php echo JThaiBaht::_($get->getTotalPrjExternalX4($BgtYear,0,0,$PrjId,$PrjDetailId,$PrjActId,0,0,$_REQUEST["SourceExId"])); ?>) รวมงบประมาณทั้งสิ้น</td>
    <td style="text-align:right; font-weight:bold"><?php echo number_format($get->getTotalPrjExternalX4($BgtYear,0,0,$PrjId,$PrjDetailId,$PrjActId,0,0,$_REQUEST["SourceExId"]),2); ?></td>
  </tr>
</table>

<div style="text-align:center; margin-top:10px; margin-bottom:30px;">
<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ViewCost); ?>&PrjId=<?php echo $PrjId; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>&PrjActId=<?php echo $_REQUEST["PrjActId"]; ?>&SourceExId=<?php echo $_REQUEST["SourceExId"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>&BgtYear=<?php echo $_REQUEST['BgtYear']; ?>'" />  
</div>
