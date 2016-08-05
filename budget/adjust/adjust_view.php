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


$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

//นับระดับการกลั่นกรองงบ
$maxScreenLevel = $get->getMaxLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);

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

function showHideMonth(i){
	if(JQ('#body-catemonth'+i).is(':hidden')===true){
		JQ('#body-catemonth'+i).show('slow');
		JQ('#a-catemonth'+i).addClass('icon-decre');
		JQ('#a-catemonth'+i).removeClass('icon-incre');
		JQ('#a-catemonth'+i).html('ย่อ');
	}else{
		JQ('#body-catemonth'+i).hide('slow');
		JQ('#a-catemonth'+i).removeClass('icon-decre');
		JQ('#a-catemonth'+i).addClass('icon-incre');
		JQ('#a-catemonth'+i).html('ขยาย');
	}
}

function extogglemonth(i){
	if(JQ('#exmonth'+i).is(':hidden')===true){
		JQ('#exmonth'+i).show('fade');
		JQ('#a-exmonth'+i).addClass('icon-decre');
		JQ('#a-exmonth'+i).removeClass('icon-incre');
		JQ('#a-exmonth'+i).html('ย่อ');
	}else{
		JQ('#exmonth'+i).hide('fade');
		JQ('#a-exmonth'+i).removeClass('icon-decre');
		JQ('#a-exmonth'+i).addClass('icon-incre');
		JQ('#a-exmonth'+i).html('ขยาย');
	}
	
}


function extoggle(i){
	if(JQ('#ex'+i).is(':hidden')===true){
		JQ('#ex'+i).show('fade');
		JQ('#a-ex'+i).addClass('icon-decre');
		JQ('#a-ex'+i).removeClass('icon-incre');
		JQ('#a-ex'+i).html('ย่อ');
	}else{
		JQ('#ex'+i).hide('fade');
		JQ('#a-ex'+i).removeClass('icon-decre');
		JQ('#a-ex'+i).addClass('icon-incre');
		JQ('#a-ex'+i).html('ขยาย');
	}
	
}


</script>
<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดโครงการในส่วนของ<?php echo $MenuName;?> </div>
</div>

<div class="topic-step"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>

<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
      <b>ปีงบประมาณ : </b><?php echo $_REQUEST["BgtYear"]?>
      <b>หน่วยงาน : </b><?php echo $get->getOrgName($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode']);?>
     </td>
      <td align="right">
		<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="history.back(-1);" />     
      </td>
    </tr>
  </table>  
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px; padding-bottom:0px">
 <tr>
   <th >ปีงบประมาณ</th>
   <td><?php echo $BgtYear;?></td>
 </tr>
 <tr>
   <th>ภายใต้แผนงาน</th>
   <td id="plan"><?php echo $get->getPItemCode($PItemCode);?></td>
 </tr> 
  <tr>
    <th>ชื่อโครงการ</th>
    <td id="prj"><?php echo $PrjName;?></td>
  </tr>
    <tr>
    <th>ระยะเวลาการดำเนินโครงการ</th>
    <td><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td>
  </tr>
     <tr>
   <th valign="top">หน่วยงานที่รับผิดชอบ</th>
   <td><?php echo $get->getOrgName($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode']);?></td>
 </tr>
<tr>
	<th valign="top">ผู้รับผิดชอบโครงการ</th>
   <td >
   <?php 
   	$TaskPerson = $get->getTaskPerson($PrjId); 
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
 <td colspan="2" style="padding:0px;"><div class="boxfilter2"><div class="icon-topic">รายละเอียดโครงการ</div></div></td>
 </tr>
 <tr>
 <td colspan="2" style="padding:0px;"><div class="boxfilter-sub">หลักการ</div></td>
 </tr>
   <tr>
    <td colspan="2"  valign="top"> <?php echo $Principles; ?></td>
  </tr>
 <tr>
 <td colspan="2" style="padding:0px;"><div class="boxfilter-sub">วัตถุประสงค์</div></td>
 </tr>
 <tr>
   <td colspan="2" valign="top"> <?php echo $Purpose;?></td>
</tr> 

 <tr>
 <td colspan="2" style="padding:0px;"><div class="boxfilter-sub">ตัวชี้วัดความสำเร็จโครงการ</div></td>
 </tr>
<tr>
<td colspan="2">
  	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
    <tr>
      	<th style="width:40%; text-align:center">ชื่อตัวชี้วัดโครงการ</th>
        <th style="width:20%; text-align:center">ประเภทตัวชี้วัด</th>
        <th style="width:20%; text-align:center">ค่าเป้าหมาย</th>
        <th style="width:20%; text-align:center">หน่วยนับ</th>
    </tr>
	<?php 
    $indicatorSelect = $get->getIndicatorSelect($PrjDetailId);
  // ltxt::print_r($indicatorSelect);
     if($indicatorSelect){
            foreach($indicatorSelect as $r){
                foreach( $r as $k=>$v){ ${$k} = $v;}
         
    ?>    
    <tr>
      	<td><?php echo $IndicatorName;?></td>
        <td style="text-align:center"><?php echo $get->getIndTypeName($IndTypeId);?></td>
      	<td style="text-align:right"><?php echo number_format($Value,2);?></td>
      	<td><?php echo $UnitName;?></td>
    </tr>
	<?php				
            }
        }else{
	?>
    <tr>
    <td colspan="4" style="color:#F00; text-align:center; height:30px" >- - ไม่มีข้อมูล - -</td>
    </tr>
    <?php	
		}
    ?> 
       
	</table>
    
    
</td>
</tr>
 <tr>
 <td colspan="2" style="padding:0px;"><div class="boxfilter-sub">กลวิธี / ขั้นตอนการดำเนินงาน / กิจกรรมโครงการ</div></td>
 </tr>
<tr>
<td colspan="2">
  	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
    <tr>
      	<th style="width:15%; text-align:center">วันเริ่มต้นกิจกรรม</th>
        <th style="width:15%; text-align:center">วันสิ้นสุดกิจกรรม</th>
        <th style="width:10%; text-align:center">รหัสกิจกรรม</th>
        <th style="width:30%; text-align:center">รายการกิจกรรม</th>
        <th style="width:30%; text-align:center">หน่วยงานปฎิบัติงาน</th>
    </tr>
<?php 
$selectAct = $get->getProjectDetailActRecordSet($PrjDetailId);
//ltxt::print_r($selectAct);
 if($selectAct){
        foreach($selectAct as $r){
            foreach( $r as $k=>$v){ ${$k} = $v;} 
				$PrjActStart = $StartDate;
				$PrjActEnd = $EndDate;
?>    
    <tr>
      	<td style="text-align:center"><?php echo dateformat($PrjActStart);?></td>
        <td style="text-align:center"><?php echo dateformat($PrjActEnd);?></td>
         <td style="text-align:left"><?php echo $PrjActCode;?></td>
        <td style="text-align:left">	<a href="javascript:void(0)" style="color:#003399" onclick="window.open('?mod=budget.adjust.adjust_popup_act&format=row&PrjActId=<?php echo $PrjActId; ?>&PrjActCode=<?php echo $PrjActCode; ?>&PItemCode=<?php echo $PItemCode; ?>&PrjId=<?php echo $_REQUEST["PrjId"]; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&SCTypeId=<?php echo $_REQUEST['SCTypeId']; ?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel']; ?>',null,'scrollbars=yes,height=700,width=1000,toolbar=yes,menubar=yes,status=yes');"><?php echo $PrjActName;?></a></td>
        <td style="text-align:left"><?php echo $get->getOrgNameAct($OrganizeCode);?></td>
    </tr>  
	<?php				
            }
        }else{
	?>
    <tr>
    <td colspan="4" style="color:#F00; text-align:center; height:30px" >- - ไม่มีข้อมูล - -</td>
    </tr>
    <?php	
		}
    ?> 
      
	</table>
    
</td>
</tr>
 <tr>
 <td colspan="2" style="padding:0px;"><div class="boxfilter-sub">ไฟล์เอกสารโครงการ</div></td>
 </tr>
<tr>
 <td colspan="2">       
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
					
					echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
					
				}
        
        ?>
        
        
 </td>
 </tr>
 </table>

<?php //*********************************งบแผ่นดิน **************************************** ?> 
 
<div class="boxfilter2"><div class="icon-topic">งบประมาณแผ่นดิน</div></div>
<div class="boxfilter-sub">
 <table width="100%" border="0" cellspacing="0" cellpadding="0"   >
 <tr>
 <td >งบประมาณตัวคูณ <a href="javascript:void(0)" onclick="extoggle(0);" id="a-ex0" class="icon-incre">ขยาย</a></td>
 <td style="width:200px;text-align:right">งบประมาณรวมทั้งสิ้น :</td>
 <td style="width:100px; text-align:right; " >
 <?php   
 	$sumBGTopicIn=$get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel']);
 	echo ($sumBGTopicIn > 0)?number_format($sumBGTopicIn,2):"0.00"; 
?>
 </td>
 <td style="width:10px">&nbsp;บาท</td>
 </tr >
 </table>
</div>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost"  id="ex0" style="display:none">
  <tr>
    <th rowspan="2">หมวดงบ/รายการงบรายจ่าย</th>
    <th colspan="2">ตัวคูณที่ 1</th>
    <th colspan="2">ตัวคูณที่ 2</th>
    <th colspan="2">ตัวคูณที่ 3</th>
    <th colspan="2">ตัวคูณที่ 4</th>
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
	//$SumTotalCost = $get->getTotalPrjInternalX4(0,0,0,$PrjId,$PrjDetailId,0,0,0,0,0,$CostTypeId);
	$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId);
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
  
  <tbody id="body-cate<?php echo $NumCate; ?>"  <?php if(empty($SumTotalCost)){ ?> style="display:none"<?php } ?>>
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
			//$SumTotalCost = $get->getTotalPrjInternalX4(0,0,0,$PrjId,$PrjDetailId,0,0,0,$CostItemCode,$ParentCode,0,$LevelId,$HasChild);
			$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
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

			$CRequireItemLevel1 = $get->getItemRequireInternal($CostItemCode,0,$PrjId,$PrjDetailId);
			
			//ltxt::print_r($CRequireItem);
			foreach($CRequireItemLevel1 as $RCRequireItemLevel1){
				foreach($RCRequireItemLevel1 as $k=>$v){
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
		//$SumTotalCost = $get->getTotalPrjInternalX4(0,0,0,$PrjId,$PrjDetailId,0,0,0,$CostItemCode,0,0,$LevelId,$HasChild);
		$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);

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
			//$CRequireItem = $get->getItemRequireInternal($CostItemCode,$_REQUEST["PrjActId"],$PrjId,$PrjDetailId);
			
			$CRequireItemLevel2 = $get->getItemRequireInternal($CostItemCode,0,$PrjId,$PrjDetailId);
			//ltxt::print_r($CRequireItemLevel2);		
			foreach($CRequireItemLevel2 as $RCRequireItemLevel2){
				foreach($RCRequireItemLevel2 as $k=>$v){
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
			//$SumTotalCost = $get->getTotalPrjInternalX4(0,0,0,$PrjId,$PrjDetailId,0,0,0,$CostItemCode,$ParentCode,0,$LevelId,$HasChild);
			$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);

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
			//$CRequireItem = $get->getItemRequireInternal($CostItemCode,$_REQUEST["PrjActId"],$PrjId,$PrjDetailId);	
			$CRequireItemLevel3 = $get->getItemRequireInternal($CostItemCode,0,$PrjId,$PrjDetailId);		
			//ltxt::print_r($CRequireItemLevel3);	
			foreach($CRequireItemLevel3 as $RCRequireItemLevel3){
				foreach($RCRequireItemLevel3 as $k=>$v){
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
    <td colspan="9" class="td-sum-total" style="text-align:right;">(<?php echo JThaiBaht::_($sumBGTopicIn); ?>) รวมงบประมาณทั้งสิ้น</td>
     <td class="td-sum-total" style="text-align:right; width:100px"><?php echo ($sumBGTopicIn > 0)?number_format($sumBGTopicIn,2):"0.00"; ?></td>
  </tr>
</table>


<div class="boxfilter-sub">
<table width="100%" border="0" cellspacing="0" cellpadding="0"   >
 <tr>
 <td >งบประมาณจำแนกเดือน  <a href="javascript:void(0)" onclick="extogglemonth(0);" id="a-exmonth0" class="icon-incre">ขยาย</a></td>
 <td style="width:200px;text-align:right">งบประมาณรวมทั้งสิ้น :</td>
 <td style="width:100px; text-align:right; " >
 <?php   
	$sumBGMonthTopicIn=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0);
 	echo ($sumBGMonthTopicIn > 0)?number_format($sumBGMonthTopicIn,2):"0.00"; 
?>
 </td>
 <td style="width:10px">&nbsp;บาท</td>
 </tr >
 </table>
</div>


<table  width="1220" border="0" cellspacing="0" cellpadding="0" class="tbl-cost"  id="exmonth0" style="display:none">
  <tr>
    <th rowspan="2" style="width:400px" >หมวดงบ/รายการงบรายจ่าย</th>
    <th rowspan="2" style="width:100px;">งบเดือน/ไตรมาส<br />(บาท)</th>
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
  <tr class="cate">
    <td   style="width:400px" >    
	<?php echo $NumCateMonth; ?>. <?php echo $CostTypeName; ?> | 
    
	<?php if(!empty($SumCostMonth)){ ?>   
	<a href="javascript:void(0)" id="a-catemonth<?php echo $NumCateMonth; ?>" onClick="showHideMonth(<?php echo $NumCateMonth; ?>);" class="icon-decre txt-normal">ย่อ</a>     
    <?php }else{ ?>
	<a href="javascript:void(0)" id="a-catemonth<?php echo $NumCateMonth; ?>" onClick="showHideMonth(<?php echo $NumCateMonth; ?>);" class="icon-incre txt-normal">ขยาย</a>        
	<?php } ?>    
    </td>
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
    <tbody id="body-catemonth<?php echo $NumCateMonth; ?>"  <?php if(empty($SumCostMonth)){ ?> style="display:none"<?php } ?>>
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
  <tr class="level1">
    <td style="text-indent:10px;">
      <?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?> <?php echo $CostName; ?></a></td>
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
			<td style="text-indent:30px;"><?php echo "|-- ".$Detail; ?></td>
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
  <tr class="level2">
    <td style="text-indent:20px;">
      <?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?> <?php echo $CostName; ?></td>
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
		<td style="text-indent:50px;"><?php echo "|-- ".$Detail; ?></td>
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
  <tr class="level3">
    <td style="text-indent:40px;">
	<?php echo $NumCateMonth; ?>.<?php echo $NumLevel1; ?>.<?php echo $NumLevel2; ?>.<?php echo $NumLevel3; ?> <?php echo $CostName; ?>
    
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
			<td style="text-indent:80px;"><?php echo "|-- ".$Detail; ?></td>
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
 <?php if(($_REQUEST["SCTypeId"] == 2 && $_REQUEST["ScreenLevel"] == $maxScreenLevel) || $_REQUEST["SCTypeId"] == 3 || $_REQUEST["SCTypeId"] == 4){ ?>
 <?php

$getExName=$get->getSourceName();
foreach($getExName as $sName){
	foreach($sName as $k=>$v){
		${$k} = $v;
	}
	
?>

<input type="hidden" name="SourceExId[]" id="SourceExId" value="<?php echo $SourceExId; ?>" />

    <div class="boxfilter2"><div class="icon-topic">เงินนอกงบประมาณ [ <?php echo $SourceExName;?> ]</div></div>
<div class="boxfilter-sub">
 <table width="100%" border="0" cellspacing="0" cellpadding="0"   >
 <tr>
 <td >งบประมาณตัวคูณ <a href="javascript:void(0)" onclick="extoggle(<?php echo $SourceExId; ?>);" id="a-ex<?php echo $SourceExId; ?>" class="icon-incre">ขยาย</a></td>
 <td style="width:200px;text-align:right">งบประมาณรวมทั้งสิ้น :</td>
 <td style="width:100px; text-align:right; " >
 <?php   
	$sumBGTopicEx=$get->getTotalPrjExternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId);	
 	echo ($sumBGTopicEx > 0)?number_format($sumBGTopicEx,2):"0.00"; 
?>
 </td>
 <td style="width:10px">&nbsp;บาท</td>
 </tr >
 </table>
</div> 
 
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost "   id="ex<?php echo $SourceExId; ?>"  style="display:none">
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
   	$NumCate2=1;
	$listEx = $get->getCostTypeRecordSet();
		foreach($listEx as $rEx){
			foreach($rEx as $k=>$v){
				${$k} = $v;
			}
			$CostTypeName2 = $CostTypeName;
			$CostTypeId2 = $CostTypeId;
			$SumTotalCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,0,0,$CostTypeId2);
			
  ?>
  <tr class="cate">
    <td>    
	<?php echo $NumCate2; ?>. <?php echo $CostTypeName2; ?> | 
   	<?php if(!empty($SumTotalCost)){ ?>   
    <a href="javascript:void(0)" id="a-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>" onclick="showHideTwo<?php echo $SourceExId; ?>(<?php echo $NumCate2; ?>);" class="icon-decre txt-normal">ย่อ</a> 
    <?php }else{ ?>
    <a href="javascript:void(0)" id="a-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>" onclick="showHideTwo<?php echo $SourceExId; ?>(<?php echo $NumCate2; ?>);" class="icon-incre txt-normal">ขยาย</a> 
    <?php } ?>    
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
  
  <tbody id="body-catetwo<?php echo $SourceExId; ?><?php echo $NumCate2; ?>" <?php if(empty($SumTotalCost)){ ?> style="display:none"<?php } ?>>
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

			$CSItem = $get->getListCostItem($CostItemCode,$ParentCode);
			//$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode,0,$CostTypeId,$LevelId,$HasChild);
			$SumTotalCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3);

  ?>
  <tr class="level1">
    <td style="text-indent:10px;">
	<?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?> <?php echo $CostName3; ?> </td>
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
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$PrjId,$SourceExId);
			
			$CRequireItemLevel1 = $get->getItemRequireExternal($CostItemCode3,0,$PrjId,$PrjDetailId,$SourceExId);					
			
			foreach($CRequireItemLevel1 as $RCRequireItemLevel1){
				foreach($RCRequireItemLevel1 as $k=>$v){
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

		$CSItem = $get->getListCostItem($CostItemCode,$ParentCode);
		//$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
		$SumTotalCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4);

  ?>
  <tr class="level2">
    <td style="text-indent:20px;">
	<?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?>.<?php echo $NumLevel22; ?> <?php echo $CostName4; ?></td>
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
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$PrjId,$SourceExId);
			$CRequireItemLevel2 = $get->getItemRequireExternal($CostItemCode4,0,$PrjId,$PrjDetailId,$SourceExId);		
				
			foreach($CRequireItemLevel2 as $RCRequireItemLevel2){
				foreach($RCRequireItemLevel2 as $k=>$v){
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

			$CSItem = $get->getListCostItem($CostTypeId5);
			//$SumCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
 			$SumTotalCost=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5);

  ?>
  <tr class="level3">
    <td style="text-indent:40px;">
	<?php echo $NumCate2; ?>.<?php echo $NumLevel11; ?>.<?php echo $NumLevel22; ?>.<?php echo $NumLevel33; ?> <?php echo $CostName5; ?></td>
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
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$PrjId,$SourceExId);
			
			$CRequireItemLevel3 = $get->getItemRequireExternal($CostItemCode5,0,$PrjId,$PrjDetailId,$SourceExId);
			
			//ltxt::print_r($CRequireItemLevel3);
			
			foreach($CRequireItemLevel3 as $RCRequireItemLevel3){
				foreach($RCRequireItemLevel3 as $k=>$v){
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
  <tr class="total">
    <td colspan="9" class="td-sum-total" style="text-align:right;">(<?php echo JThaiBaht::_($sumBGTopicEx); ?>) รวมงบประมาณทั้งสิ้น</td>
    <td class="td-sum-total" style="text-align:right; width:100px"><?php echo ($sumBGTopicEx > 0)?number_format($sumBGTopicEx,2):"0.00"; ?></td>
  </tr>
</table>


  <div class="boxfilter-sub">
 <table width="100%" border="0" cellspacing="0" cellpadding="0"   >
 <tr>
 <td >งบประมาณจำแนกเดือน  <a href="javascript:void(0)" onclick="extogglemonth(<?php echo $SourceExId;?>);" id="a-exmonth<?php echo $SourceExId;?>" class="icon-incre">ขยาย</a></td>
 <td style="width:200px;text-align:right">งบประมาณรวมทั้งสิ้น :</td>
 <td style="width:100px; text-align:right; " >
 <?php   
	$sumBGMonthTopicEx=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0);
 	echo ($sumBGMonthTopicEx > 0)?number_format($sumBGMonthTopicEx,2):"0.00"; 
?>
 </td>
 <td style="width:10px">&nbsp;บาท</td>
 </tr >
 </table>
</div>

<table  width="1220" border="0" cellspacing="0" cellpadding="0" class="tbl-cost"  id="exmonth<?php echo $SourceExId; ?>" style="display:none">
  <tr>
    <th rowspan="2" style="width:400px" >หมวดงบ/รายการงบรายจ่าย</th>
    <th rowspan="2" style="width:100px;">งบเดือน/ไตรมาส<br />(บาท)</th>
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
  <tr class="cate">
    <td>
	<?php echo $NumCateMonth2; ?>. <?php echo $CostTypeName2; ?> | 
    
	<?php if(!empty($SumCostMonth)){ ?>   
    <a href="javascript:void(0)" id="a-catetwomonth<?php echo $SourceExId; ?><?php echo $NumCateMonth2; ?>" onclick="showHideTwoMonth<?php echo $SourceExId; ?>(<?php echo $NumCateMonth2; ?>);" class="icon-decre txt-normal">ย่อ</a> 
    <?php }else{ ?>
    <a href="javascript:void(0)" id="a-catetwomonth<?php echo $SourceExId; ?><?php echo $NumCateMonth2; ?>" onclick="showHideTwoMonth<?php echo $SourceExId; ?>(<?php echo $NumCateMonth2; ?>);" class="icon-incre txt-normal">ขยาย</a> 
	<?php } ?>    
    </td>
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
  
  <tbody id="body-catetwomonth<?php echo $SourceExId; ?><?php echo $NumCateMonth2; ?>" <?php if(empty($SumCostMonth)){ ?> style="display:none"<?php } ?>>
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
  <tr class="level1">
    <td style="text-indent:10px;">
      <?php echo $NumCateMonth2; ?>.<?php echo $NumLevel11; ?> <?php echo $CostName3; ?> </td>
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
		   <td style="text-indent:30px;"><?php echo "|-- ".$Detail; ?></td>
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
		   <td style="text-indent:50px;"><?php echo "|-- ".$Detail; ?></td>
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
		   <td style="text-indent:80px;"><?php echo "|-- ".$Detail; ?></td>
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
?>
<!--END วน loop แหล่งเงินนนอกงบ-->

<table width="100%" border="0" cellspacing="0" cellpadding="2" >
 <tr style="background-color:#6AAD6E; font-weight:bold" height="23" >
 <td style="text-align:right;">
 <?php number_format($sumAllBGInternal=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],0,0,$PrjId,$PrjDetailId,0,$SCTypeId,$ScreenLevel),2); ?>
 ( <?php echo JThaiBaht::_($sumBGTopicIn+$sumAllBGInternal); ?> ) เงินงบประมาณแผ่นดิน+เงินนอกงบประมาณ
 </td>
 <td style="width:100px; text-align:right; " ><?php echo number_format($sumBGTopicIn+$sumAllBGInternal,2); ?></td>
 <td style="width:10px">บาท&nbsp;</td>
 </tr >
 </table>

	<?php } ?>
 <?php //******************************** จบ เงินนอกงบ ************************************?>


<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
<tr>
 <td colspan="2" style="padding:0px;"><div class="boxfilter2"><div class="icon-topic">รายการตรวจสอบโครงการ</div></div></td>
 </tr>
 <tr>
 <td colspan="2">
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
        <tr>
          <th style="text-align: center; width:5%;">ลำดับ</th>
          <th style="text-align: center; width:20%;">วันที่ตรวจสอบ</th>
          <th style="text-align: center; width:30%;">ผลการตรวจสอบ</th>
          <th style="text-align: center; width:25%;">หมายเหตุ</th>
          <th style="text-align: center; width:20%;">ผู้ตรวจสอบ</th>
        </tr>
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
          <td>
			<?php
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
            ?>&nbsp;
          </td>
          <td><?php echo $Comment;?>&nbsp;</td>
          <td><?php echo fn_getFullNameByUserId($CreateBy);?>&nbsp;</td>
        </tr>
<?php
$d++;
}
}else{
?>
<tr>
	<td colspan="5" style="text-align:center; vertical-align:top; color:#F00 ">- - ไม่มีข้อมูล - -</td>
</tr>
<?php } ?>

</table>
 
 </td>
 </tr>

<tr>
 <td colspan="2" style="padding:0px;"><div class="boxfilter2"><div class="icon-topic">สถานะโครงการ : <span  style="color: #FFE900; "><?php echo $StatusName;?></span></div></div></td>
 </tr>  
  

<tr>
<td colspan="2" valign="top">
<?php
		// ดึงข้อมูล Level ต่อไป	
/*		if($_REQUEST["SCTypeId"] ==1){
			$oldScreenLevel = 1;
			$oldSCTypeId = ($_REQUEST["SCTypeId"]+1);
		}else if($_REQUEST["SCTypeId"] == 2 && $_REQUEST["ScreenLevel"] < $countScreenLevel){
			$oldScreenLevel = $_REQUEST["ScreenLevel"]+1;
			$oldSCTypeId = 2;	
		}else{
			$oldScreenLevel = 0;
			$oldSCTypeId = ($_REQUEST["SCTypeId"]+1);			
		}
		
		
		$nextPrj = $get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST["OrganizeCode"], $oldSCTypeId, $oldScreenLevel);
*/		//ltxt::print_r($nextPrj);

?>
 
  <div class="boxfilter2"><div class="icon-topic">
	  	<?php 
				switch ($_REQUEST["SCTypeId"]) {
					case 1:
					case 2:
						echo "กลั่นกรองงบประมาณ";
					break;				
					case 3:
						echo "จัดสรรงบประมาณ";
					break;
					case 4:
						echo "ปรับงบประมาณระหว่างปี";
					break;								
				}		
		?>
 </div></div>
 
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
    <tr>
        <th style="text-align: center; width:5%;">ลำดับ</th>
        <th style="text-align: center; width:45%;">แหล่งงบประมาณ</th>
        <th align="right" style="text-align: right; width:25%;">งบขอจัดตั้ง (บาท)</th>
        <th align="right" style="text-align: right; width:25%;">
	  	<?php 
				switch ($_REQUEST["SCTypeId"]) {
					case 1:
					case 2:
						echo "งบกลั่นกรอง";
					break;				
					case 3:
						echo "งบจัดสรร";
					break;
					case 4:
						echo "งบปรับระหว่างปี";
					break;								
				}		
		?>        
         (บาท)
         </th>
    </tr>
    <tr>
        <td style="text-align:center">1.</td>
        <td>งบประมาณแผ่นดิน</td>
        <td style="text-align:right"><?php echo ($sumBGTopicIn > 0)?number_format($sumBGTopicIn,2):"-"; ?></td>
        <td style="text-align:right">
        <?php
			// ดึง PrjDetailId ในระดับการกลั่นกรองปัจจุบัน
			//$prjDetail = $get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST["OrganizeCode"], $_REQUEST["NextSCTypeId"], $_REQUEST["NextScreenLevel"], $PrjId);
			//ltxt::print_r($prjDetail);
		
/*		if($oldSCTypeId <= 3){
			if($nextPrj){
				$TotalAllotBGInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$nextPrj[0]->ScreenLevel,$nextPrj[0]->SCTypeId,$nextPrj[0]->PrjDetailId,$allot[0]->AllotId);
			}
		}
		
		echo ($TotalAllotBGInternal > 0)?number_format($TotalAllotBGInternal,2):"-";
*/	

		$TotalAllotBGInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId,0);		
		echo ($TotalAllotBGInternal > 0)?number_format($TotalAllotBGInternal,2):"-";
	
		?>
        </td>
    </tr>
<?php 
	if(($_REQUEST["SCTypeId"] == 2 && $_REQUEST["ScreenLevel"] == $maxScreenLevel) || $_REQUEST["SCTypeId"] == 3 || $_REQUEST["SCTypeId"] == 4){
	
		$n=2;
		foreach($getExName as $sNameallot){
			foreach($sNameallot as $k=>$v){${$k} = $v;}
			// งบขอตั้ง
			$sumBGEx=$get->getTotalPrjExternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$_REQUEST['PrjDetailId'],0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId);	
			
			// งบจัดสรร
			$sumAllotBGEx = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['ScreenLevel'],$_REQUEST['SCTypeId'],$PrjDetailId,0,$SourceExId);

/*			
		if($oldSCTypeId <= 3){
			if($nextPrj){
			//รวมงบกลั่นกรอง/จัดสรร
			$sumAllotBGEx = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$nextPrj[0]->ScreenLevel,$nextPrj[0]->SCTypeId,$nextPrj[0]->PrjDetailId,0,$SourceExId);
			}
		}*/
?>    
    <tr>
        <td style="text-align:center"><?php echo $n;?>. </td>
        <td>เงินนอกงบประมาณ [<?php echo $SourceExName;?>]</td>
        <td style="text-align:right"><?php echo ($sumBGEx > 0)?number_format($sumBGEx,2):"-"; ?></td>
        <td style="text-align:right"><?php echo ($sumAllotBGEx > 0)?number_format($sumAllotBGEx,2):"-"; ?></td>
    </tr>    
<?php $n++; } }// end if 
	// รวมงบขอตั้ง
	$ToalBGEx=$get->getTotalPrjExternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$PItemCode,$PrjId,$_REQUEST['PrjDetailId'],0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0);	
	$TotalRequest = $ToalBGEx + $sumBGTopicIn;
	
	//รวมงบกลั่นกรอง/จัดสรร
	$TotalAllotBGEx = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['ScreenLevel'],$_REQUEST['SCTypeId'],$PrjDetailId,0,0);
	$TotalAllot = $TotalAllotBGEx + $TotalAllotBGInternal ;
	
/*	if($oldSCTypeId <= 3){
		if($nextPrj){
		//รวมงบกลั่นกรอง/จัดสรร
		$TotalAllotBGEx = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$nextPrj[0]->ScreenLevel,$nextPrj[0]->SCTypeId,$nextPrj[0]->PrjDetailId,0,0);
		$TotalAllot = $TotalAllotBGEx + $TotalAllotBGInternal ;
		}
	}*/
?>    
    <tr class="txtbold"  >
        <td style="text-align:right" colspan="2">รวมงบประมาณทั้งสิ้น</td>
        <td style="text-align:right"><?php echo ($TotalRequest > 0)?number_format($TotalRequest,2):"-"; ?></td>
        <td style="text-align:right"><?php echo ($TotalAllot > 0)?number_format($TotalAllot,2):"-"; ?></td>
    </tr> 
    
</table> 
 
</td>
</tr>


 <tr>
 <th>&nbsp;</th>
 <td >
<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="history.back(-1);" /> 
 </td>
 </tr>
 
</table>

