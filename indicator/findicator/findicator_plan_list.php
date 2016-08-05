<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));

$this->DOC->setPathWays(array(
	array(
		'text' => $MenuName,
	),
));




?>

<script>
function loadSCT(BgtYear){
	window.location.href='?mod=<?php echo lurl::dotPage('findicator_plan_list');?>&BgtYear='+BgtYear;
}

function swap(id,el,img){
		var Obj = document.getElementById(id);
		var Img = document.getElementById(img);
		if(Obj.style.display=='none'){
			Obj.style.display='';
			el.src='images/bullet/minimize.gif';
			if(Img) Img.src='images/bullet/minimize.gif';
		}else{
			Obj.style.display='none';
			el.src='images/bullet/maximize.gif';
			if(Img) Img.src='images/bullet/maximize.gif';
		}
}	

</script>


<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>



<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-tab">
  <tr>
    <td class="notcurrent"><a href="?mod=<?php echo LURL::dotPage('findicator_list'); ?>&BgtYear=<?php echo ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543); ?>">ตัวชี้วัดโครงการ</a></td>
    <td class="current">ตัวชี้วัดแผนงาน</td>
    <td class="notcurrent"><a href="?mod=<?php echo LURL::dotPage('findicator_longplan_list'); ?>">ตัวชี้วัดแผนหลัก</a></td>
    <td class="line">&nbsp;</td>
  </tr>
</table>




<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#eeebac;">
  <tr>
    <td style="padding:5px; text-align:right;">
    ประจำปีงบประมาณ <?php echo $get->getYearProject(ltxt::getVar('BgtYear'),'BgtYear');?> 
    </td>
  </tr>
</table>


<table width="100%" border="0" class="tbl-list"  cellspacing="1" cellpadding="0" style="margin-top:0px;">
<thead>
  <tr>
    <th rowspan="2" align="center" style="width:18px;">&nbsp;</th>
    <th rowspan="2" align="center" style="width:30px;">ลำดับ</th>
    <th rowspan="2" align="center" >ชื่อแผนงาน/ตัวชี้วัดแผนงาน</th>
    <th rowspan="2" align="center" style="width:70px;">ความถี่</th>
    <th colspan="2" align="center" style="width:80px;">ค่าเป้าหมาย</th>
    <th rowspan="2" align="center" style="width:70px;">หน่วยนับ</th>
    <th rowspan="2" align="center" style="width:40px;">สี</th>
    </tr>
  <tr>
    <th align="center" style="width:80px;">แผน</th>
    <th align="center" style="width:80px;">ผล</th>
    </tr>
</thead>

<?php
$i=1;
$plan = $get->getPlan();//ltxt::print_r($plan);
foreach($plan as $detailprj){
	foreach($detailprj as $k=>$v){
		${$k} = $v;
	}
	$indicator = $get->getPlanIndicator($PItemCode);//ltxt::print_r($indicator);
?>


  <tr style="background-color:#EEE; vertical-align:top;">

<?php if($indicator){ ?>
    <td style="text-align:center;" onClick="swap('td-<?php echo $i;?>',this,'np<?php echo $i; ?>')">
    <img id="np<?php echo $i;?>" src="images/bullet/minimize.gif" align="absmiddle" style="border:none; background-color:#EEE;" width="16" highg="16"   />
    </td>
<?php }else{ ?>
	<td>&nbsp;</td>
<?php } ?>

    <td style="text-align:center;"><?php echo $i; ?></td>
    <td valign="top" >
    (<?php echo $PItemCode; ?>) 
    <a href="?mod=<?php echo LURL::dotPage('findicator_plan_view'); ?>&PItemId=<?php echo $PItemId; ?>"><?php echo $PItemName; ?></a>
    </td>
    <td style="text-align:center;">
    <?php if($Methods == "monthly"){ echo 'รายเดือน'; } ?>
	<?php if($Methods == "quarterly"){ echo 'รายไตรมาส'; } ?>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  
  
<tbody id="td-<?php echo $i;?>">  
<!--รายการตัวชี้วัดโครงการ-->
<?php
$d=1;
foreach($indicator as $r_indicator){
	foreach($r_indicator as $m=>$p){
		${$m} = $p;
	}
?>
   <tr style="vertical-align:top;">
     <td align="center">&nbsp;</td>
   <td align="center">&nbsp;</td>
    <td>
	<?php echo $i.".".$d; ?> (<?php echo $PIndCode; ?>) 
    <!--<a href="?mod=<?php //echo LURL::dotPage('findicator_view_sub'); ?>">--><?php echo $PIndName; ?><!--</a>-->
    </td>
    <td align="center">&nbsp;</td>
    <td align="center"><?php echo ($PIndTargetPlan)?$PIndTargetPlan:"-"; ?></td>
    <td align="center"><?php echo ($PIndTargetResult)?$PIndTargetResult:"-"; ?></td>
    <td align="center"><?php echo ($UnitID)?($get->getUnitName($UnitID)):"-"; ?></td>
    <td align="center">
    <?php
	//$maxPlanMonthNo = $get->getMaxPlanMonthNo($PIndCode);
	//$PIndTargetResult	= $get->getPlanPIndTargetResult($PIndCode,$maxPlanMonthNo);
	if(($PIndTargetResult >= $MinScore0)&&($PIndTargetResult <= $MaxScore0)){
				
		echo '<span class="icon-col1">&nbsp;</span>';
				
	}else if(($PIndTargetResult >= $MinScore1)&&($PIndTargetResult <= $MaxScore1)){
				
		echo '<span class="icon-col2">&nbsp;</span>';
				
	}else if(($PIndTargetResult >= $MinScore2)&&($PIndTargetResult <= $MaxScore2)){
				
		echo '<span class="icon-col3">&nbsp;</span>';
				
	}else if(($PIndTargetResult >= $MinScore3)&&($PIndTargetResult <= $MaxScore3)){
				
		echo '<span class="icon-col4">&nbsp;</span>';
				
	}else if(($PIndTargetResult >= $MinScore4)&&($PIndTargetResult <= $MaxScore4)){
				
		echo '<span class="icon-col5">&nbsp;</span>';
				
	}else if(($PIndTargetResult >= $MinScore5)&&($PIndTargetResult <= $MaxScore5)){
				
		echo '<span class="icon-col6">&nbsp;</span>';
				
	}else{
		echo '<span>-</span>';
	}

	?>
    </td>
  </tr>
<?php
	$d++;
}
?>
<!--END รายการตัวชี้วัดโครงการ-->
</tbody>  
  
  
  
  
  
  
  
<?php
	$i++;
}
?>
  
  
  
   

</table>


<?php
if(!$plan){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>


<!--<div class="cms-box-navpage">
<?php //echo NavPage(array('total'=>4,'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>-->
          
<br />
<br />
<br />