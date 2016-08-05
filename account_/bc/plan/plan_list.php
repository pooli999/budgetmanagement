<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));
$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
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
		"javascript:self.location='?mod=".LURL::dotPage('plan_ind')."&LPlanCode=".$r->LPlanCode."&LindId=".$r->LindId."&start=".$_REQUEST["start"]."'",
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
	window.location.href='?mod=<?php echo lurl::dotPage('plan_list');?>&PLongCode='+PLongCode;
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
	window.location.href="?mod=<?php echo LURL::dotPage('plan_print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('plan_excel')?>&format=raw<?php echo $get->getQueryString(); ?>";
}
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbl-button">
  <tr>
    <td>
     <a href="javascript:printDocument();" class="icon-printer">พิมพ์</a>&nbsp;
    <a href="javascript:saveToExcel();" class="icon-excel">ส่งออกเป็น Excel</a>
    </td>
  </tr>
</table>



<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td>
      <input type="button" name="button4" id="button4" value="  เพิ่มแผนหลัก  " class="add" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>');" />
      	<input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" />
        </td>
       <td style="padding:5px; text-align:right;">ชื่อแผนหลัก <?php echo $get->getYearMainPlan(ltxt::getVar('PLongCode'),'PLongCode');?></td>
    </tr>
  </table>
</div>

<table width="100%" class="tbl-list"  cellspacing="1" cellpadding="0" style="margin-top:0px;">
  <tr>
    <th style="width:30px;">ลำดับ</th>
    <th nowrap="nowrap">ชื่อแผนหลัก</th>
    <th style="width:95px;">ปีเริ่มต้น</th>
    <th style="width:95px;">ปีสิ้นสุด</th>
    <th style="width:95px;">จำนวนปี</th>
    <th colspan="2" style="text-align:center;" >ปฏิบัติการ</th>
    </tr>
<tbody>
<!--รายการแผนหลัก-->
<?php
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	
	if($list){
          foreach($list as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
  <tr style="background-color:#dfc7df; font-size:14px;">
    <td style="text-align:center; padding:5px;"><?php echo $i ;?></td>
    <td nowrap="nowrap"><?php //echo icoView($r);?><?php echo $PLongName; ?></td>
    <td style="text-align:center;"><?php echo $PLongYear;?></td>
    <td style="text-align:center;"><?php echo $PLongYearEnd;?></td>
    <td style="text-align:center;"><?php echo $PLongAmount;?></td>
    <td style="width:120px;"><?php echo icoEdit($r);?></td>
    <td style="width:140px;"><?php echo icoDelete($r);?></td>
  </tr>
  
 <tr style="background-color:#CCC; font-size:14px;">
  <td style="text-align:center; padding:5px;">&nbsp;</td>
  <td colspan="4"><u>ตัวชี้วัดแผนหลัก</u></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>

<!--รายการตัวชี้วัด--> 
<?php 
$dataInd = $get->getIndItem($PLongCode);//ltxt::print_r($dataInd);
if($dataInd){
	foreach($dataInd as $dataIndRow){
		foreach( $dataIndRow as $di=>$dv){ ${$di} = $dv;}
?>    
<tr style="vertical-align:top; background-color:#EEE;">
    <td>&nbsp;</td>
    <td colspan="4">(<?php echo $PIndCode; ?>) <?php echo $PIndName; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr> 
<?php 
	}
}else{
?> 
<tr style="background-color:#EEE;">
    <td colspan="7" style="text-align:center;">-ไม่พบรายการในฐานข้อมูล-</td>
</tr> 
<?php } ?>
<!--END รายการตัวชี้วัด-->   
  
<tr style="background-color:#CCC; font-size:14px;">
  <td style="text-align:center; padding:5px;">&nbsp;</td>
  <td colspan="4"><u>แผนงานภายใต้แผนหลัก</u></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
  
  
  
<!--รายการแผนงาน--> 
<?php 
$d=1;
$dataPlan = $get->getPlanItem($PLongCode);//ltxt::print_r($dataPlan);
if($dataPlan){
	foreach($dataPlan as $r){
		foreach( $r as $k=>$v){ ${$k} = $v;}
?>    

<tr style="background-color:#c9e39c; vertical-align:top;">
    <td style="text-align:center;">&nbsp;</td>
    <td colspan="4" ><?php //echo $i.".".$d; ?>(<?php echo $LPlanCode; ?>) <?php echo $LPlanName; ?></td>
    <td><a href="?mod=<?php echo LURL::dotPage('plan_ind'); ?>&LPlanCode=<?php echo $LPlanCode; ?>" class="ico edit">เพิ่มตัวชี้วัด</a></td>
    <td><a href="?mod=<?php echo LURL::dotPage('plan_add_project'); ?>&LPlanCode=<?php echo $LPlanCode; ?>" class="ico edit">จัดการโครงการ</a></td>
</tr> 


<!--รายการตัวชี้วัด-->
<tr style="background-color:#EEE; vertical-align:top;">
  <td>&nbsp;</td>
  <td colspan="4"><u>ตัวชี้วัด : </u></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>

<?php 
$t=1;
$dataIndicator = $get->getIndicatorItem($LPlanCode);//ltxt::print_r($dataIndicator);
if($dataIndicator){
	foreach($dataIndicator as $in){
		foreach( $in as $a=>$q){ ${$a} = $q;}
?>    

<tr style="background-color:#EEE; vertical-align:top;">
    <td>&nbsp;</td>
    <td colspan="4">|- (<?php echo $LindCode; ?>) <a href="?mod=<?php echo LURL::dotPage('plan_ind_view'); ?>&LPlanCode=<?php echo $LPlanCode; ?>&LindId=<?php echo $LindId; ?>"><?php echo $LindName; ?></a></td>
    <td><?php echo icoIndEdit($in);?></td>
    <td><?php echo icoIndDelete($in);?></td>
</tr> 
  
<?php				
			$t++;
	}
}
?>   
<!--END รายการตัวชี้วัด-->




<!--รายการโครงการ-->
<tr style="vertical-align:top;">
  <td>&nbsp;</td>
  <td colspan="4"><u>โครงการ :</u></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>

<?php 
$y=1;
$dataProject = $get->getProjectItem($LPlanCode);//ltxt::print_r($dataPlan);
if($dataProject){
	foreach($dataProject as $p){
		foreach( $p as $m=>$s){ ${$m} = $s;}
?>    

<tr style="vertical-align:top;">
    <td>&nbsp;</td>
    <td colspan="4">|- (<?php echo $LPrjCode; ?>) <?php echo $LPrjName; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr> 
  
<?php				
			$y++;
	}
}
?>   
<!--END รายการโครงการ-->




  
<?php				
			$d++;
	}
}
?>   
<!--END รายการแผนงาน-->  
  

  
<?php

		$i++;
		}
	}
?>
<!--END รายการแผนหลัก-->
</tbody>
</table>
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
          
