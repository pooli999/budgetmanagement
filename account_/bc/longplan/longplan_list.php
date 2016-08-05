<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));
$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบนโยบายแผนงานและโครงการ',
	),
	array(
		'text' => 'พิมพ์รายงาน ',
		'link' => '?mod=budget.report.startup',
	),
	
	array(
		'text' => 'รายงานภาพรวมแผนหลัก',
	),
));

function icoActive($r){
	global $actionPage;
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&PLongId='.$r->PLongId."&start=".$_REQUEST["start"].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}

function icoEdit($r){
	$label = 'แก้ไข';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->PLongId."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoView($r){
	$label = $r->PLongName;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&id=".$r->PLongId."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&id=".$r->PLongId."&start=".$_REQUEST["start"]."')",
		'ico delete',
		$label,
		$label
	));
}


function icoIndEdit($r){
	$label = 'แก้ไข';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage('plan_add_indicator')."&LPlanCode=".$r->LPlanCode."&LindId=".$r->LindId."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoIndDelete($r){
	$label = 'ลบทิ้ง';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&LindId=".$r->LindId."&start=".$_REQUEST["start"]."')",
		'ico delete',
		$label,
		$label
	));
}



/*function icoView($r){
	$label = 'ดูรายละเอียด';
	global $viewPage;
	vprintf('<a href="%s" onclick="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:void(0)",
		"toggleSub('".$r."')",
		'ico search',
		$label,
		$label
	));
}*/

?>

<script>
function loadSCT(PLongCode){
	window.location.href='?mod=<?php echo lurl::dotPage('longplan_list');?>&PLongCode='+PLongCode;
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

<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	
	function Search(){
		var tsearch=JQ('#tsearch').val();
		window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&tsearch="+ tsearch;
	}
	
	function toggleSub(id){
		JQ("a#icoClass_"+id).toggleClass("minimize");
		JQ("tr.hideRow_"+id).toggle();
	}

/* ]]> */

function printDocument(){
	//window.location.href="?mod=<?php //echo LURL::dotPage('longplan_print')?>&format=raw<?php //echo $get->getQueryString(); ?>";
}

function saveToExcel(){
	//window.location.href="?mod=<?php //echo LURL::dotPage('longplan_excel')?>&format=raw<?php //echo $get->getQueryString(); ?>";
}

</script>

<div class="sysinfo">
  <div class="sysname">รายงานภาพรวมแผนหลัก</div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูลงบประมาณตามแผนหลัก</div>
</div>
<form name="searchForm" id="SearchForm" method="post">
<div id="boxSearch" class="boxsearch" style="display:none;">
  <table  border="0" align="center" cellpadding="0" cellspacing="5" >
    <tr>
      <td  align="left"><strong>คำค้น : </strong></td>
      <td align="left"><input name="tsearch" id="tsearch" type="text" class="input-search" size="30" value="<?php echo $_REQUEST['tsearch']?>" />
        <input id="search2" name="search2" type="button" value="  ค้นหา  " class="btnRed"   onclick="Search();" />
        <input type="button" name="button5" id="button2" class="btn" value=" ยกเลิก " onclick="JQ('#boxSearch').hide();JQ('#boxFilter').show();" /></td>
    </tr>
  </table>
  
</div></form>
<div class="cms-box-search">

  <?php 
if($_REQUEST['tsearch']){?>
ผลการค้นหา <span style="color:#FF6600; font-weight:bold;">&quot;<?php echo $_REQUEST['tsearch'];?>&quot;</span> พบจำนวน <span style="color:#FF6600; font-weight:bold;"><?php echo $list['total'];?></span> รายการ 
<?php }?>
</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbl-button">
  <tr>
    <td>
     <a href="javascript:printDocument();" class="icon-printer">พิมพ์</a>&nbsp;
    <a href="javascript:saveToExcel();" class="icon-excel">ส่งออกเป็น Excel</a>
    </td>
    <td style="text-align:right;">ชื่อแผนหลัก <?php echo $get->getYearMainPlan(ltxt::getVar('PLongCode'),'PLongCode');?> </td>
  </tr>
</table>


<!--รายการแผนหลัก-->
<?php
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;//ltxt::print_r($list);
	
	if($list){
          foreach($list as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
<?php //echo (18+80+450+(($PLongAmount*3+3)*80)); ?>
<table width="100%" border="0" class="tbl-sumary"  cellspacing="1" cellpadding="0" style="margin-top:0px;">
<thead>
  <tr>
    <th rowspan="2" style="width:18px">&nbsp;</th>
    <th rowspan="2" style="width:80px">รหัส</th>
    <th rowspan="2">แผนงานต่อเนื่อง/โครงการ</th>
    <th rowspan="2" style="width:100px;">&nbsp;</th>
    <th colspan="<?php echo ($PLongAmount*3+3); ?>" style="text-align:center;" >งบประมาณ (บาท)</th>
    </tr>
    
  <tr>
  
	   <?php 
		  $startYear = $PLongYear;
		  for($y=0;$y<$PLongAmount;$y++){ 
		  ?>
          <th style="width:90px;">ปี <?php echo $startYear; ?></th>
		  <?php 
		  	$startYear = $startYear+1;
		  } 
		  ?>
    
    <th style="width:90px;">รวมทั้งสิ้น</th>
    </tr>
    
  </thead>
  
  
  
  
<!--รายการแผนงาน--> 
<?php 
$d=1;
$dataPlan = $get->getPlanItem($PLongCode);//ltxt::print_r($dataPlan);
if($dataPlan){
	foreach($dataPlan as $r){
		foreach( $r as $k=>$v){ ${$k} = $v;}
		$dataProject = $get->getProjectItem($LPlanCode);//ltxt::print_r($dataPlan);
?>    

<tr style="background-color:#CCC;">
<?php if($dataProject){ ?>
    <td style="text-align:center;" onClick="swap('td-<?php echo $d;?>',this,'np<?php echo $d; ?>')">
    <img id="np<?php echo $d;?>" src="images/bullet/minimize.gif" align="absmiddle" style="border:none; background-color:#CCC;" width="16" highg="16"   />
    </td>
<?php }else{ ?>
	<td>&nbsp;</td>
<?php } ?>
    
    <td style="text-align:center;"><?php echo $LPlanCode; ?></td>
    <td><?php echo $LPlanName; ?></td>
    <td style="text-align:right;">กรอบวงเงิน</td>
    
    
		 <?php 
		  $startYear = $PLongYear;
		  for($y=0;$y<$PLongAmount;$y++){ 
		  ?>
          <td style="text-align:center;">-</td>
		  <?php 
		  	$startYear = $startYear+1;
		  } 
		  ?>
    
          <td style="text-align:center;">-</td>
</tr>







<tr style="background-color:#dbdbdb;">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">เงินที่ได้รับ</td>
<?php 
$startYear = $PLongYear;
for($y=0;$y<$PLongAmount;$y++){ 
?>
<td style="text-align:center;">-</td>
<?php 
	$startYear = $startYear+1;
} 
?>
    <td>&nbsp;</td>
</tr>

<tr style="background-color:#dbdbdb;">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">เงินจ่ายจริง</td>
<?php 
$startYear = $PLongYear;
for($y=0;$y<$PLongAmount;$y++){ 
?>
<td style="text-align:center;">-</td>
<?php 
	$startYear = $startYear+1;
} 
?>
    <td>&nbsp;</td>
</tr>











 






<tbody id="td-<?php echo $d;?>">	
<!--รายการโครงการ-->
<?php 
$y=1;
if($dataProject){
	foreach($dataProject as $p){
		foreach( $p as $m=>$s){ ${$m} = $s;}
?>    

<tr style="vertical-align:top;">
    <td>&nbsp;</td>
    <td style="text-align:center;"><?php echo $LPrjCode; ?></td>
    <td><?php echo $LPrjName; ?></td>
    <td style="text-align:right;">กรอบวงเงิน</td>
    
		<?php 
		  $startYear = $PLongYear;
		  for($y=0;$y<$PLongAmount;$y++){ 
		  ?>
          <td style="text-align:center;">-</td>
          <?php 
		  	$startYear = $startYear+1;
		  } 
		  ?>
    
          <td style="text-align:center;">-</td>
    </tr> 
    

<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align:right;">&nbsp;</td>
    <td style="text-align:right;">เงินที่ได้รับ</td>
<?php 
$startYear = $PLongYear;
for($y=0;$y<$PLongAmount;$y++){ 
?>
<td style="text-align:center;">-</td>
<?php 
	$startYear = $startYear+1;
} 
?>
    <td>&nbsp;</td>
</tr>

<tr>
    <td style="border-bottom:1px solid #999;">&nbsp;</td>
    <td style="border-bottom:1px solid #999;">&nbsp;</td>
    <td style="text-align:right; border-bottom:1px solid #999;">&nbsp;</td>
    <td style="text-align:right; border-bottom:1px solid #999;">เงินจ่ายจริง</td>
<?php 
$startYear = $PLongYear;
for($y=0;$y<$PLongAmount;$y++){ 
?>
<td style="text-align:center; border-bottom:1px solid #999;">-</td>
<?php 
	$startYear = $startYear+1;
} 
?>
    <td style="border-bottom:1px solid #999;">&nbsp;</td>
</tr>







  
<?php				
			$y++;
	}
}
?>   
<!--END รายการโครงการ-->
</tbody>



  
<?php				
			$d++;
	}
}
?>   
<!--END รายการแผนงาน-->  
  

  
<?php

		$i++;
		}
?>
<!--END รายการแผนหลัก-->


<tr style="font-weight:bold;">
    <th colspan="4" style="text-align:right;">กรอบวงเงิน</th>
    
		 <?php 
		  $startYear = $PLongYear;
		  for($y=0;$y<$PLongAmount;$y++){ 
		  ?>
          <th style="text-align:center;">-</th>
          <?php 
		  	$startYear = $startYear+1;
		  } 
		  ?>
    
          <th style="text-align:center;">-</th>
  </tr> 
  <tr style="font-weight:bold;">
    <th colspan="4" style="text-align:right;">เงินที่ได้รับ</th>
    
		 <?php 
		  $startYear = $PLongYear;
		  for($y=0;$y<$PLongAmount;$y++){ 
		  ?>
          <th style="text-align:center;">-</th>
          <?php 
		  	$startYear = $startYear+1;
		  } 
		  ?>
    
          <th style="text-align:center;">-</th>
  </tr> 
  <tr style="font-weight:bold;">
    <th colspan="4" style="text-align:right;">เงินจ่ายจริง</th>
    
		 <?php 
		  $startYear = $PLongYear;
		  for($y=0;$y<$PLongAmount;$y++){ 
		  ?>
          <th style="text-align:center;">-</th>
          <?php 
		  	$startYear = $startYear+1;
		  } 
		  ?>
    
          <th style="text-align:center;">-</th>
  </tr> 




</table>
<?php } ?>
<?php
if(!$list){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>

<br />
<br />
<br />
<!--<div class="cms-box-navpage">
<?php //echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>-->
          
