<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");


$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

//นับระดับการกลั่นกรองงบ
$maxScreenLevel = $get->getMaxLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
?>
<script type="text/javascript" src="js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="js/general_jq.js"></script>

<style>
.tbl-list {
}
.tbl-list th {
	border-bottom:1px solid #9e9e9e;
	padding: 3px;
	background-color:#c4c4c4; 
	color:#333;
	font-size:13px; 
	font-weight:bold;
	text-align:left;
}
.tbl-list td {
	border-bottom: 1px dotted #ccc;
	padding: 2px;
	line-height: 16px;
	font-size:13px; 
}

.boxfilter-sub{
	padding:5px 5px 5px 5px;
	color:#333;
	font-weight:bold;
	border-bottom:1px solid #535e74;
	background-color:#ccc;
	font-size:13px; 
}

.tbl-cost {
	border-collapse:collapse;
}
.tbl-cost th {
	border:1px solid #999;
	text-align:center;
	padding:3px;
	background-color:#CCC;
	font-size:13px; 
}
.tbl-cost td {
	border:1px solid #999;
	padding:3px;
	font-size:13px; 
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
/*END ตารางรายการงบรายจ่าย*/
/*Icon*/
.icon-decre {
	background:url(http://127.0.0.1/nationalhealth/images/bullet/minimize.gif) left center no-repeat;
	padding-left:16px;
}
.icon-incre {
	background:url(http://127.0.0.1/nationalhealth/images/bullet/maximize.gif) left center no-repeat;
	padding-left:16px;
}
/*END Icon*/

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


.step {
	background:url(../../../nationalhealth/images/flagred.gif) left center no-repeat;
	padding-left:16px;
}

.topic-step{
	border-bottom:1px solid #666666;
	background-color:#EDEB8F;
	font-weight:bold;
	padding:5px 5px 5px 28px;
	background-image: url(../../../nationalhealth/images/flagred.gif);
	background-repeat:no-repeat;
	background-position:5px 5px;
	color:#333;
	font-size:13px; 
	
}


.tbl-history-check thead td {
	text-align:center;
	background-color:#CCF;
	color:#333;
	font-size:13px; 
}

.tbl-history-check tbody td {
	border-bottom:1px dotted #CCC;
	background-color:#FFF;
	color:#333;
	font-size:13px; 
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


<?php $curProcess = $get->getCurProcess($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);//ดึงข้อมูลขั้นตอนปัจจุบันของหน่วยงาน?>
<div class="topic-step"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>

<?php
$datas = $get->getActivityDetail($_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);//ltxt::print_r($datas);
foreach($datas as $actdatas){
	foreach($actdatas as $k=>$v){
		${$k} = $v;
	}
}
?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list" >
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
       <td><?php echo $get->getOrgName($BgtYear,$OrganizeCode);?></td>
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

  	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
    <thead>
  <tr>
    <td style="width:30px; text-align:center">ลำดับ</td>
      	<td style="width:40%; text-align:center">ชื่อตัวชี้วัดกิจกรรม</td>
        <td style="width:20%; text-align:center">ประเภทตัวชี้วัด</td>
        <td style="width:20%; text-align:center">ค่าเป้าหมาย</td>
        <td style="width:20%; text-align:center">หน่วยนับ</td>
    </tr>
    </thead>
	<?php
	$n=0;
    $indicatorSelect = $get->getIndicatorActSelect($_REQUEST["PrjActId"]);
   //ltxt::print_r($indicatorSelect);
     if($indicatorSelect){
         $count = 1;
            foreach($indicatorSelect as $r){
                foreach( $r as $k=>$v){ ${$k} = $v;}
    ?>    
    <tr>
      <td style="text-align:center"><?php echo ($n+1); ?>.</td>
    <td style="text-align:left"><?php echo $IndicatorName;?>&nbsp;</td>
    <td style="text-align:center"><?php echo $get->getIndTypeName($IndTypeId);?>&nbsp;</td>
    <td style="text-align:right"><?php echo $Value;?>&nbsp;</td>
    <td style="text-align:left"><?php echo $UnitName;?>&nbsp;</td>
	</tr>    
	<?php				
                $count++;
				$n++;
            }
			
        }else{
	?>		
    <tr>
    <td colspan="5" style="color:#900; height:50; text-align:center; vertical-align:middle">- - ไม่มีข้อมูล - -</td>
    </tr>
	<?php		
		}
    ?>     
	</table>
    
    
    <?php //*********************************งบแผ่นดิน **************************************** ?> 
 
 
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  class="tbl-list" style="border-bottom:1px solid #535e74;"  >
 <tr height="25">
 <th style="text-align:left">งบประมาณแผ่นดิน  <a href="javascript:void(0)" onclick="extogglemonth(0);" id="a-exmonth0" class="icon-incre">ขยาย</a></th>
 </tr >
 </table>

<table  width="1460" border="0" cellspacing="0" cellpadding="0" class="tbl-cost"  id="exmonth0" style="display:none">
  <tr>
    <th rowspan="2" style="width:400px" >หมวดงบ/รายการงบรายจ่าย</th>
    <th rowspan="2" style="width:100px;">งบประมาณ(บาท)</th>
    <th colspan="3">ไตรมาส1</th>
    <th colspan="3">ไตรมาส2</th>
    <th colspan="3">ไตรมาส3</th>
    <th colspan="3">ไตรมาส4</th>
  </tr>
  <tr>
    <th style="width:80px;">ต.ค</th>
    <th style="width:80px;">พ.ย</th>
    <th style="width:80px;">ธ.ค</th>
    <th style="width:80px;">ม.ค</th>
    <th style="width:80px;">ก.พ</th>
    <th style="width:80px;">มี.ค</th>
    <th style="width:80px;">เม.ย</th>
    <th style="width:80px;">พ.ค</th>
    <th style="width:80px;">มิ.ย</th>
    <th style="width:80px;">ก.ค</th>
    <th style="width:80px;">ส.ค</th>
    <th style="width:80px;">ก.ย</th>
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
		
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId);
	
	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,10,0);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,11,0);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,12,0);

	//ไตรมาสที่ 2
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,1,0);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,2,0);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,3,0);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,4,0);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,5,0);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,6,0);

	//ไตรมาสที่ 4
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,7,0);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,8,0);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,$CostTypeId,0,0,9,0);

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
    <td style="text-align:right; width:80px;" title="งบเดือน/ไตรมาส"><?php echo ($SumCostMonth > 0)?number_format($SumCostMonth,2):"-"; ?></td>
    <td style="text-align:right; width:80px;" title="ต.ค"><?php echo ($SumCostMonth10 > 0)?number_format($SumCostMonth10,2):"-"; ?></td>
    <td style="text-align:right; width:80px;" title="พ.ย"><?php echo ($SumCostMonth11 > 0)?number_format($SumCostMonth11,2):"-"; ?></td>
    <td style="text-align:right; width:80px;" title="ธ.ค"><?php echo ($SumCostMonth12 > 0)?number_format($SumCostMonth12,2):"-"; ?></td>
   <td style="text-align:right; width:80px;" title="ม.ค"><?php echo ($SumCostMonth1 > 0)?number_format($SumCostMonth1,2):"-"; ?></td>
    <td style="text-align:right; width:80px;" title="ก.พ"><?php echo ($SumCostMonth2 > 0)?number_format($SumCostMonth2,2):"-"; ?></td>
    <td style="text-align:right; width:80px;" title="มี.ค"><?php echo ($SumCostMonth3 > 0)?number_format($SumCostMonth3,2):"-"; ?></td>
   <td style="text-align:right; width:80px;" title="เม.ย"><?php echo ($SumCostMonth4 > 0)?number_format($SumCostMonth4,2):"-"; ?></td>
    <td style="text-align:right; width:80px;" title="พ.ค"><?php echo ($SumCostMonth5 > 0)?number_format($SumCostMonth5,2):"-"; ?></td>
    <td style="text-align:right; width:80px;" title="มิ.ย"><?php echo ($SumCostMonth6 > 0)?number_format($SumCostMonth6,2):"-"; ?></td>
   <td style="text-align:right; width:80px;" title="ก.ค"><?php echo ($SumCostMonth7 > 0)?number_format($SumCostMonth7,2):"-"; ?></td>
    <td style="text-align:right; width:80px;" title="ส.ค"><?php echo ($SumCostMonth8 > 0)?number_format($SumCostMonth8,2):"-"; ?></td>
    <td style="text-align:right; width:80px;" title="ก.ย"><?php echo ($SumCostMonth9 > 0)?number_format($SumCostMonth9,2):"-"; ?></td>
  </tr>
    <tbody id="body-catemonth<?php echo $NumCateMonth; ?>" <?php if(empty($SumCostMonth)){ ?> style="display:none"<?php } ?> >
  <!--วน loop รายการงบรายจ่าย ระดับที่ 1-->
   <?php
  $NumLevel1 = 1; 
  $BGLevel1 = $get->getCostItemRecordSet($CostTypeId);
 //ltxt::print_r($BGLevel1);
  foreach($BGLevel1 as $BGLevel1Row){ 
  	foreach($BGLevel1Row as $c=>$d){
		${$c} = $d;
	}

	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,0);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,0);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,0);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,0);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,0);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,0);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,0);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,0);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,0);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,0);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,0);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,0);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,0);

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
			$CRequireItemLevel1 = $get->getItemRequireInternal($CostItemCode,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId']);
			foreach($CRequireItemLevel1 as $RCRequireItemLevel1){
				foreach($RCRequireItemLevel1 as $k=>$v){
					${$k} = $v;
				}
				
	if($CostIntId){			
				
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostIntId);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostIntId);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostIntId);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostIntId);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostIntId);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostIntId);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostIntId);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostIntId);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostIntId);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostIntId);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostIntId);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostIntId);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostIntId);
				
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

	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,0);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,0);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,0);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,0);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,0);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,0);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,0);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,0);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,0);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,0);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,0);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,0);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST["PrjActId"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,0);

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
			$CRequireItemLevel2 = $get->getItemRequireInternal($CostItemCode,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId']);
			foreach($CRequireItemLevel2 as $RCRequireItemLevel2){
				foreach($RCRequireItemLevel2 as $k=>$v){
					${$k} = $v;
				}
				
				
	if($CostIntId){			
				
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostIntId);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostIntId);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostIntId);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostIntId);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostIntId);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostIntId);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostIntId);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostIntId);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostIntId);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostIntId);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostIntId);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostIntId);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostIntId);
				
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
	
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,0);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,0);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,0);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,0);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,0);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,0);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,0);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,0);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,0);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,0);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,0);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,0);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,0);	
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
			$CRequireItemLevel3 = $get->getItemRequireInternal($CostItemCode,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId']);			
			//ltxt::print_r($CRequireItemLevel3);
			foreach($CRequireItemLevel3 as $RCRequireItemLevel3){
				foreach($RCRequireItemLevel3 as $k=>$v){
					${$k} = $v;
			}
		
	if($CostIntId){			
				
	//$SumTotalCost = $get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild);
	
	$SumCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,0,$CostIntId);

	//ไตรมาสที่ 1	
	$SumCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,10,$CostIntId);
	$SumCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,11,$CostIntId);
	$SumCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,12,$CostIntId);

	//ไตรมาสที่ 2	
	$SumCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,1,$CostIntId);
	$SumCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,2,$CostIntId);
	$SumCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,3,$CostIntId);

	//ไตรมาสที่ 3
	$SumCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,4,$CostIntId);
	$SumCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,5,$CostIntId);
	$SumCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,6,$CostIntId);

	//ไตรมาสที่ 4	
	$SumCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,7,$CostIntId);
	$SumCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,8,$CostIntId);
	$SumCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$CostItemCode,$ParentCode,$CostTypeId,$LevelId,$HasChild,9,$CostIntId);
				
	}
				
			?>
		   <tr>
			<td style="text-indent:100px;"><?php 
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
	
	$SumIntCostMonth=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0);
	
	//ไตรมาสที่ 1	
	$SumIntCostMonth10=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,10,0);
	$SumIntCostMonth11=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,11,0);
	$SumIntCostMonth12=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,12,0);

	//ไตรมาสที่ 2
	$SumIntCostMonth1=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,1,0);
	$SumIntCostMonth2=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,2,0);
	$SumIntCostMonth3=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,3,0);

	//ไตรมาสที่ 3
	$SumIntCostMonth4=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,4,0);
	$SumIntCostMonth5=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,5,0);
	$SumIntCostMonth6=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,6,0);

	//ไตรมาสที่ 4
	$SumIntCostMonth7=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,7,0);
	$SumIntCostMonth8=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,8,0);
	$SumIntCostMonth9=$get->getTotalPrjInternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0,0,0,0,0,9,0);

?>
  <tr class="total">
    <td style="text-align:right; " >รวมงบประมาณทั้งสิ้น</td>
    <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumIntCostMonth > 0)?number_format($SumIntCostMonth,2):"-"; ?></td>
    <td style="text-align:right;" title="ต.ค"><?php echo ($SumIntCostMonth10 > 0)?number_format($SumIntCostMonth10,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ย"><?php echo ($SumIntCostMonth11 > 0)?number_format($SumIntCostMonth11,2):"-"; ?></td>
    <td style="text-align:right;" title="ธ.ค"><?php echo ($SumIntCostMonth12 > 0)?number_format($SumIntCostMonth12,2):"-"; ?></td>
   <td style="text-align:right;" title="ม.ค"><?php echo ($SumIntCostMonth1 > 0)?number_format($SumIntCostMonth1,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.พ"><?php echo ($SumIntCostMonth2 > 0)?number_format($SumIntCostMonth2,2):"-"; ?></td>
    <td style="text-align:right;" title="มี.ค"><?php echo ($SumIntCostMonth3 > 0)?number_format($SumIntCostMonth3,2):"-"; ?></td>
   <td style="text-align:right;" title="เม.ย"><?php echo ($SumIntCostMonth4 > 0)?number_format($SumIntCostMonth4,2):"-"; ?></td>
    <td style="text-align:right;" title="พ.ค"><?php echo ($SumIntCostMonth5 > 0)?number_format($SumIntCostMonth5,2):"-"; ?></td>
    <td style="text-align:right;" title="มิ.ย"><?php echo ($SumIntCostMonth6 > 0)?number_format($SumIntCostMonth6,2):"-"; ?></td>
   <td style="text-align:right;" title="ก.ค"><?php echo ($SumIntCostMonth7 > 0)?number_format($SumIntCostMonth7,2):"-"; ?></td>
    <td style="text-align:right;" title="ส.ค"><?php echo ($SumIntCostMonth8 > 0)?number_format($SumIntCostMonth8,2):"-"; ?></td>
    <td style="text-align:right;" title="ก.ย"><?php echo ($SumIntCostMonth9 > 0)?number_format($SumIntCostMonth9,2):"-"; ?></td>
  </tr>
</table>


 
<?php //******************************** จบ งบแผ่นดิน ************************************?>

 <?php //******************************** เงินนอกงบ ************************************?>
<?php //if(in_array($_REQUEST["SCTypeId"],array(3,4))){ ?>
 
 <?php

$getExName=$get->getSourceName();
foreach($getExName as $sName){
	foreach($sName as $k=>$v){
		${$k} = $v;
	}
	
?>

<input type="hidden" name="SourceExId[]" id="SourceExId" value="<?php echo $SourceExId; ?>" />
 


 
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="tbl-list" style="border-bottom:1px solid #535e74;"  >
 <tr height="25">
 <th style="text-align:left">เงินนอกงบประมาณ [ <?php echo $SourceExName;?> ]  <a href="javascript:void(0)" onclick="extogglemonth(<?php echo $SourceExId;?>);" id="a-exmonth<?php echo $SourceExId;?>" class="icon-incre">ขยาย</a></th>
 </tr >
 </table> 

<table  width="1460" border="0" cellspacing="0" cellpadding="0" class="tbl-cost"  id="exmonth<?php echo $SourceExId; ?>" style="display:none">
  <tr>
    <th rowspan="2" style="width:400px" >หมวดงบ/รายการงบรายจ่าย</th>
    <th rowspan="2" style="width:100px;">งบประมาณ<br />(บาท)</th>
    <th colspan="3">ไตรมาส1</th>
    <th colspan="3">ไตรมาส2</th>
    <th colspan="3">ไตรมาส3</th>
    <th colspan="3">ไตรมาส4</th>
  </tr>
  <tr>
    <th style="width:80px;">ต.ค</th>
    <th style="width:80px;">พ.ย</th>
    <th style="width:80px;">ธ.ค</th>
    <th style="width:80px;">ม.ค</th>
    <th style="width:80px;">ก.พ</th>
    <th style="width:80px;">มี.ค</th>
    <th style="width:80px;">เม.ย</th>
    <th style="width:80px;">พ.ค</th>
    <th style="width:80px;">มิ.ย</th>
    <th style="width:80px;">ก.ค</th>
    <th style="width:80px;">ส.ค</th>
    <th style="width:80px;">ก.ย</th>
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

			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,10,0);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,11,0);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,12,0);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,1,0);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,2,0);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,3,0);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,4,0);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,5,0);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,6,0);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,7,0);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,8,0);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,$CostTypeId2,0,0,9,0);



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
  
  <tbody id="body-catetwomonth<?php echo $SourceExId; ?><?php echo $NumCateMonth2; ?>"  <?php if(empty($SumCostMonth)){ ?> style="display:none"<?php } ?> >
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

			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,0,0);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,10,0);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,11,0);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,12,0);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,1,0);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,2,0);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,3,0);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,4,0);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,5,0);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,6,0);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,7,0);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,8,0);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode3,$CostTypeId3,$LevelId3,$HasChild3,9,0);

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
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$_REQUEST['PrjId'],$SourceExId);
			
			$CRequireItemLevel1 = $get->getItemRequireExternal($CostItemCode3,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$SourceExId);					
			//ltxt::print_r($CRequireItemLevel1);
			foreach($CRequireItemLevel1 as $RCRequireItemLevel1){
				foreach($RCRequireItemLevel1 as $k=>$v){
					${$k} = $v;
				}
				
			if($CostExtId){	
			
			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,0,$CostExtId);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,10,$CostExtId);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,11,$CostExtId);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,12,$CostExtId);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,1,$CostExtId);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,2,$CostExtId);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,3,$CostExtId);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,4,$CostExtId);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,5,$CostExtId);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,6,$CostExtId);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,7,$CostExtId);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,8,$CostExtId);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode3,$ParentCode,$CostTypeId3,$LevelId3,$HasChild3,9,$CostExtId);
				
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

			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,0,0);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,10,0);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,11,0);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,12,0);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,1,0);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,2,0);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,3,0);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,4,0);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,5,0);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,6,0);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,7,0);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,8,0);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,9,0);

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
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$_REQUEST['PrjId'],$SourceExId);
			$CRequireItemLevel2 = $get->getItemRequireExternal($CostItemCode4,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$SourceExId);		
				
			foreach($CRequireItemLevel2 as $RCRequireItemLevel2){
				foreach($RCRequireItemLevel2 as $k=>$v){
					${$k} = $v;
				}
				
			if($CostExtId){	
				
			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,0,$CostExtId);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,10,$CostExtId);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,11,$CostExtId);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,12,$CostExtId);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,1,$CostExtId);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,2,$CostExtId);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,3,$CostExtId);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,4,$CostExtId);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,5,$CostExtId);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,6,$CostExtId);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,7,$CostExtId);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,8,$CostExtId);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode4,$ParentCode4,$CostTypeId4,$LevelId4,$HasChild4,9,$CostExtId);				
				
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

			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,0,0);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,10,0);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,11,0);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,12,0);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,1,0);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,2,0);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,3,0);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,4,0);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,5,0);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,6,0);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,7,0);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,8,0);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,9,0);
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
			//$CRequireItem = $get->getItemRequireExternal($CostItemCode,$PrjActId,$_REQUEST['PrjId'],$SourceExId);
			
			$CRequireItemLevel3 = $get->getItemRequireExternal($CostItemCode5,$_REQUEST['PrjActId'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$SourceExId);
			
			//ltxt::print_r($CRequireItemLevel3);
			
			foreach($CRequireItemLevel3 as $RCRequireItemLevel3){
				foreach($RCRequireItemLevel3 as $k=>$v){
					${$k} = $v;
				}
				
			if($CostExtId){	
				
			$SumCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,0,$CostExtId);

			//ไตรมาสที่ 1
			$SumCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,10,$CostExtId);
			$SumCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,11,$CostExtId);
			$SumCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,12,$CostExtId);
			
			//ไตรมาสที่ 2
			$SumCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,1,$CostExtId);
			$SumCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,2,$CostExtId);
			$SumCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,3,$CostExtId);
			
			//ไตรมาสที่ 3
			$SumCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,4,$CostExtId);
			$SumCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,5,$CostExtId);
			$SumCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,6,$CostExtId);
			
			//ไตรมาสที่ 4
			$SumCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,7,$CostExtId);
			$SumCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,8,$CostExtId);
			$SumCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,$CostItemCode5,$ParentCode5,$CostTypeId5,$LevelId5,$HasChild5,9,$CostExtId);				
				
			}
			
			?>
		   <tr>
		   <td style="text-indent:100px;"><?php 
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
			$SumExtCostMonth=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0);
			
			//ไตรมาสที่ 1
			$SumExtCostMonth10=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,10,0);
			$SumExtCostMonth11=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,11,0);
			$SumExtCostMonth12=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,12,0);
			
			//ไตรมาสที่ 2
			$SumExtCostMonth1=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,1,0);
			$SumExtCostMonth2=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,2,0);
			$SumExtCostMonth3=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,3,0);
			
			//ไตรมาสที่ 3
			$SumExtCostMonth4=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,4,0);
			$SumExtCostMonth5=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,5,0);
			$SumExtCostMonth6=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,6,0);
			
			//ไตรมาสที่ 4
			$SumExtCostMonth7=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,7,0);
			$SumExtCostMonth8=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,8,0);
			$SumExtCostMonth9=$get->getTotalPrjExternalMonth($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST['PItemCode'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId'],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],$SourceExId,0,0,0,0,0,9,0);
	
			$TotalSumExtCostMonth		=	$TotalSumExtCostMonth+$SumExtCostMonth;
			$TotalSumExtCostMonth10	=	$TotalSumExtCostMonth10+$SumExtCostMonth10;
			$TotalSumExtCostMonth11	=	$TotalSumExtCostMonth11+$SumExtCostMonth11;
			$TotalSumExtCostMonth12	=	$TotalSumExtCostMonth12+$SumExtCostMonth12;
			$TotalSumExtCostMonth1		=	$TotalSumExtCostMonth1+$SumExtCostMonth1;
			$TotalSumExtCostMonth2		=	$TotalSumExtCostMonth2+$SumExtCostMonth2;
			$TotalSumExtCostMonth3		=	$TotalSumExtCostMonth3+$SumExtCostMonth3;
			$TotalSumExtCostMonth4		=	$TotalSumExtCostMonth4+$SumExtCostMonth4;
			$TotalSumExtCostMonth5		=	$TotalSumExtCostMonth5+$SumExtCostMonth5;
			$TotalSumExtCostMonth6		=	$TotalSumExtCostMonth6+$SumExtCostMonth6;
			$TotalSumExtCostMonth7		=	$TotalSumExtCostMonth7+$SumExtCostMonth7;
			$TotalSumExtCostMonth8		=	$TotalSumExtCostMonth8+$SumExtCostMonth8;
			$TotalSumExtCostMonth9		=	$TotalSumExtCostMonth9+$SumExtCostMonth9;

    ?>
  <tr class="total">
    		<td style="text-align:right;">รวมงบประมาณทั้งสิ้น</td>
            <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo ($SumExtCostMonth > 0)?number_format($SumExtCostMonth,2):"-"; ?></td>
            <td style="text-align:right;" title="ต.ค"><?php echo ($SumExtCostMonth10 > 0)?number_format($SumExtCostMonth10,2):"-"; ?></td>
            <td style="text-align:right;" title="พ.ย"><?php echo ($SumExtCostMonth11 > 0)?number_format($SumExtCostMonth11,2):"-"; ?></td>
            <td style="text-align:right;" title="ธ.ค"><?php echo ($SumExtCostMonth12 > 0)?number_format($SumExtCostMonth12,2):"-"; ?></td>
           <td style="text-align:right;" title="ม.ค"><?php echo ($SumExtCostMonth1 > 0)?number_format($SumExtCostMonth1,2):"-"; ?></td>
            <td style="text-align:right;" title="ก.พ"><?php echo ($SumExtCostMonth2 > 0)?number_format($SumExtCostMonth2,2):"-"; ?></td>
            <td style="text-align:right;" title="มี.ค"><?php echo ($SumExtCostMonth3 > 0)?number_format($SumExtCostMonth3,2):"-"; ?></td>
           <td style="text-align:right;" title="เม.ย"><?php echo ($SumExtCostMonth4 > 0)?number_format($SumExtCostMonth4,2):"-"; ?></td>
            <td style="text-align:right;" title="พ.ค"><?php echo ($SumExtCostMonth5 > 0)?number_format($SumExtCostMonth5,2):"-"; ?></td>
            <td style="text-align:right;" title="มิ.ย"><?php echo ($SumExtCostMonth6 > 0)?number_format($SumExtCostMonth6,2):"-"; ?></td>
           <td style="text-align:right;" title="ก.ค"><?php echo ($SumExtCostMonth7 > 0)?number_format($SumExtCostMonth7,2):"-"; ?></td>
            <td style="text-align:right;" title="ส.ค"><?php echo ($SumExtCostMonth8 > 0)?number_format($SumExtCostMonth8,2):"-"; ?></td>
            <td style="text-align:right;" title="ก.ย"><?php echo ($SumExtCostMonth9 > 0)?number_format($SumExtCostMonth9,2):"-"; ?></td>               
  </tr>
  



<?php
}
?>
<!--END วน loop แหล่งเงินนนอกงบ-->

<tr class="total" style="background-color:#FFFFCC;">
    		<td style="text-align:right; width:400px;">รวมเงินนอกงบ</td>
            <td style="text-align:right; width:100px;" title="งบเดือน/ไตรมาส"><?php echo ($TotalSumExtCostMonth > 0)?number_format($TotalSumExtCostMonth,2):"-"; ?></td>
            <td style="text-align:right; width:80px;" title="ต.ค"><?php echo ($TotalSumExtCostMonth10 > 0)?number_format($TotalSumExtCostMonth10,2):"-"; ?></td>
            <td style="text-align:right; width:80px;" title="พ.ย"><?php echo ($TotalSumExtCostMonth11 > 0)?number_format($TotalSumExtCostMonth11,2):"-"; ?></td>
            <td style="text-align:right; width:80px;" title="ธ.ค"><?php echo ($TotalSumExtCostMonth12 > 0)?number_format($TotalSumExtCostMonth12,2):"-"; ?></td>
           <td style="text-align:right; width:80px;" title="ม.ค"><?php echo ($TotalSumExtCostMonth1 > 0)?number_format($TotalSumExtCostMonth1,2):"-"; ?></td>
            <td style="text-align:right; width:80px;" title="ก.พ"><?php echo ($TotalSumExtCostMonth2 > 0)?number_format($TotalSumExtCostMonth2,2):"-"; ?></td>
            <td style="text-align:right; width:80px;" title="มี.ค"><?php echo ($TotalSumExtCostMonth3 > 0)?number_format($TotalSumExtCostMonth3,2):"-"; ?></td>
           <td style="text-align:right; width:80px;" title="เม.ย"><?php echo ($TotalSumExtCostMonth4 > 0)?number_format($TotalSumExtCostMonth4,2):"-"; ?></td>
            <td style="text-align:right; width:80px;" title="พ.ค"><?php echo ($TotalSumExtCostMonth5 > 0)?number_format($TotalSumExtCostMonth5,2):"-"; ?></td>
            <td style="text-align:right; width:80px;" title="มิ.ย"><?php echo ($TotalSumExtCostMonth6 > 0)?number_format($TotalSumExtCostMonth6,2):"-"; ?></td>
           <td style="text-align:right; width:80px;" title="ก.ค"><?php echo ($TotalSumExtCostMonth7 > 0)?number_format($TotalSumExtCostMonth7,2):"-"; ?></td>
            <td style="text-align:right; width:80px;" title="ส.ค"><?php echo ($TotalSumExtCostMonth8 > 0)?number_format($TotalSumExtCostMonth8,2):"-"; ?></td>
            <td style="text-align:right; width:80px;" title="ก.ย"><?php echo ($TotalSumExtCostMonth9 > 0)?number_format($TotalSumExtCostMonth9,2):"-"; ?></td>               
  </tr>
  
  

  <tr class="total" style="background-color:#6CC;">
    		<td style="text-align:right;">เงินงบแผ่นดิน+เงินนอกงบ</td>
            <td style="text-align:right;" title="งบเดือน/ไตรมาส"><?php echo (($SumIntCostMonth+$TotalSumExtCostMonth) > 0)?number_format(($SumIntCostMonth+$TotalSumExtCostMonth),2):"-"; ?></td>
            <td style="text-align:right;" title="ต.ค"><?php echo (($SumIntCostMonth10+$TotalSumExtCostMonth10) > 0)?number_format(($SumIntCostMonth10+$TotalSumExtCostMonth10),2):"-"; ?></td>
            <td style="text-align:right;" title="พ.ย"><?php echo (($SumIntCostMonth11+$TotalSumExtCostMonth11) > 0)?number_format(($SumIntCostMonth11+$TotalSumExtCostMonth11),2):"-"; ?></td>
            <td style="text-align:right;" title="ธ.ค"><?php echo (($SumIntCostMonth12+$TotalSumExtCostMonth12) > 0)?number_format(($SumIntCostMonth12+$TotalSumExtCostMonth12),2):"-"; ?></td>
           <td style="text-align:right;" title="ม.ค"><?php echo (($SumIntCostMonth1+$TotalSumExtCostMonth1) > 0)?number_format(($SumIntCostMonth1+$TotalSumExtCostMonth1),2):"-"; ?></td>
            <td style="text-align:right;" title="ก.พ"><?php echo (($SumIntCostMonth2+$TotalSumExtCostMonth2) > 0)?number_format(($SumIntCostMonth2+$TotalSumExtCostMonth2),2):"-"; ?></td>
            <td style="text-align:right;" title="มี.ค"><?php echo (($SumIntCostMonth3+$TotalSumExtCostMonth3) > 0)?number_format(($SumIntCostMonth3+$TotalSumExtCostMonth3),2):"-"; ?></td>
           <td style="text-align:right;" title="เม.ย"><?php echo (($SumIntCostMonth4+$TotalSumExtCostMonth4) > 0)?number_format(($SumIntCostMonth4+$TotalSumExtCostMonth4),2):"-"; ?></td>
            <td style="text-align:right;" title="พ.ค"><?php echo (($SumIntCostMonth5+$TotalSumExtCostMonth5) > 0)?number_format(($SumIntCostMonth5+$TotalSumExtCostMonth5),2):"-"; ?></td>
            <td style="text-align:right;" title="มิ.ย"><?php echo (($SumIntCostMonth6+$TotalSumExtCostMonth6) > 0)?number_format(($SumIntCostMonth6+$TotalSumExtCostMonth6),2):"-"; ?></td>
           <td style="text-align:right;" title="ก.ค"><?php echo (($SumIntCostMonth7+$TotalSumExtCostMonth7) > 0)?number_format(($SumIntCostMonth7+$TotalSumExtCostMonth7),2):"-"; ?></td>
            <td style="text-align:right;" title="ส.ค"><?php echo (($SumIntCostMonth8+$TotalSumExtCostMonth8) > 0)?number_format(($SumIntCostMonth8+$TotalSumExtCostMonth8),2):"-"; ?></td>
            <td style="text-align:right;" title="ก.ย"><?php echo (($SumIntCostMonth9+$TotalSumExtCostMonth9) > 0)?number_format(($SumIntCostMonth9+$TotalSumExtCostMonth9),2):"-"; ?></td>               
  </tr>
</table>  



	<?php //} ?>
 <?php //******************************** จบ เงินนอกงบ ************************************?>
<br />
<div align="center" style="width:100%"><input name="closepage" type="button"  id="closepage" value="ปิดหน้าต่างนี้"  onclick="window.close();"/>