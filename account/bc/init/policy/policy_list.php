<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));
$this->DOC->setPathWays(array(
	array(
		'text' => 'จัดการข้อมูลพื้นฐาน',
		'link' => '?mod=budget.init.startup',
	),
	
	array(
		'text' => $MenuName,
	),
));

/*function icoActive($r){
	global $actionPage;
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&PGroupId='.$r->PGroupId."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST["BgtYear"].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}
*/

function icoViewInd($r){
	$label =  "[".$r->PItemCode."] ".$r->PItemName; 
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&id=".$r->PItemId."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}


function icoEdit($r){
	$label = 'แก้ไข';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->PItemId."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&id=".$r->PItemId."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST["BgtYear"]."')",  
		'ico delete',
		$label,
		$label
	));
}

function icoAddSub($r){
	$label = 'เพิ่มรายการย่อย';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&PGroupId=".$r->PGroupId."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST["BgtYear"]."'",
		'ico add',
		$label,
		$label
	));
}

function icoAddInd($r){
	$label = 'เพิ่มตัวชี้วัด';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage('policy_ind_add')."&PItemId=".$r->PItemId."&PGroupId=".$r->PGroupId."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST["BgtYear"]."'",
		'ico view',
		$label,
		$label
	));
	
	
	/*$label = 'เพิ่มตัวชี้วัด';
	global $indicatorListPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($indicatorListPage)."&PItemId=".$r->PItemId."&PGroupId=".$r->PGroupId."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST["BgtYear"]."'",
		'ico view',
		$label,
		$label
	));*/
	
	
}

function icoIndEdit($r){
	$label = 'แก้ไข';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage('policy_ind_add')."&PItemId=".$r->PItemId."&PIndId=".$r->PIndId."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoIndDelete($r){
	$label = 'ลบทิ้ง';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&PIndId=".$r->PIndId."&start=".$_REQUEST["start"]."')",
		'ico delete',
		$label,
		$label
	));
}

?>

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
	
	function sortItem(){
	window.location.href='?mod=<?php echo lurl::dotPage($sortPage);?>';
	}

	function loadSCT(BgtYear){
		window.location.href='?mod=<?php echo lurl::dotPage($listPage);?>&BgtYear='+BgtYear;
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

/* ]]> */

function printDocument(){
	window.location.href="?mod=<?php echo LURL::dotPage('policy_print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('policy_excel')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

</script>
<script type="text/javascript" language="javascript" id="js">
/* <![CDATA[ */
/*JQ(document).ready(function() {
	
	JQ("table").tablesorter({
		headers: {
			0: {sorter: false},
			3: {sorter: false},
			4: {sorter: false}
		}
	});
	
});*/
/* ]]> */
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
      	<input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" />
        </td>
        <td align="right">ปีงบประมาณ : <?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?></td>
    </tr>
  </table>
</div>







<table width="100%" border="1" class="tbl-list" cellspacing="0" cellpadding="0">
  <thead>
  <tr>
    <th align="center" style="width:15px;">&nbsp;</th>
    <th align="center">นโยบายแผนงานประจำปี</th>
    <th colspan="3" align="center" >ปฏิบัติการ</th>
    </tr>
</thead>
<?php
	$no = 1;
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	
	if($list){
          foreach($list as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
  <tr style="background-color:#dfc7df;">
    <td style="text-align:center; padding:5px;" onClick="swap('td-<?php echo $i;?>',this,'np<?php echo $i; ?>')"  ><img id="np<?php echo $i;?>" src="images/bullet/minimize.gif" align="absmiddle" style="border:none; background-color:#dfc7df;" width="16" highg="16"   /></td>
    <td style="font-weight:bold;"><?php echo $no." ) ".$PGroupName;?></td>
    <td colspan="3"><?php echo icoAddSub($r);?></td>
    </tr>
  	<tbody id="td-<?php echo $i;?>">		
<?php
$item=$get->getItemList($PGroupId); //ltxt::print_r($item);
if($item){
	$t=1; 
	foreach( $item as $grp ) {
		foreach( $grp as $k=>$v){ ${$k} = $v;}
?>
              <tr style="background-color:#c9e39c;" valign="top"><!-- onmouseover="this.bgColor='#fffbcc'" onmouseout="this.bgColor='#FFFFFF'" #ded4d7-->
                <td valign="top">&nbsp;</td>
                <td valign="top"><?php echo icoViewInd($grp); ?><?php //echo "[".$PItemCode."] ".$PItemName; ?></td>
                <td style="width:85px;" nowrap="nowrap" valign="top"  ><?php echo icoAddInd($grp);?></td>
                <td style="width:60px;" nowrap="nowrap" valign="top"  ><?php echo icoEdit($grp);?></td>
                <td style="width:60px;" valign="top"  nowrap="nowrap" ><?php echo icoDelete($grp);?></td>
              </tr>  
              
              
              
<?php if($PGroupId == 12){ ?>

<!--รายการเป้าประสงค์ของแผนงาน-->
<?php 
$t=1;
$dataPurpose = $get->getPurposeItem($PItemCode);//ltxt::print_r($dataIndicator);
if($dataPurpose){
?>
<tr style="background-color:#EEE;">
  <td>&nbsp;</td>
  <td><u>เป้าประสงค์ของแผนงาน : </u></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<?php
	foreach($dataPurpose as $pp){
		foreach( $pp as $e=>$w){ ${$e} = $w;}
?>    

<tr style="background-color:#EEE;">
  <td>&nbsp;</td>
    <td>|- <?php echo $PurposeName; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr> 
  
<?php				
			$t++;
	}
}
?>   
<!--END รายการเป้าประสงค์ของแผนงาน-->


<?php } ?>              
              
              
              
<!--รายการตัวชี้วัด-->
<?php 
$t=1;
$dataIndicator = $get->getIndicatorItem($PItemId);//ltxt::print_r($dataIndicator);
if($dataIndicator){
?>
<tr>
  <td>&nbsp;</td>
  <td><u>ตัวชี้วัด : </u></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<?php
	foreach($dataIndicator as $in){
		foreach( $in as $a=>$q){ ${$a} = $q;}
?>    

<tr>
  <td>&nbsp;</td>
    <td>
    |- (<?php echo $PIndCode; ?>) 
    <a href="?mod=<?php echo LURL::dotPage('policy_ind_view'); ?>&PItemId=<?php echo $PItemId; ?>&PIndId=<?php echo $PIndId; ?>"><?php echo $PIndName; ?></a></td>
    <td>&nbsp;</td>
    <td><?php echo icoIndEdit($in);?></td>
    <td><?php echo icoIndDelete($in);?></td>
</tr> 
  
<?php				
			$t++;
	}
}
?>   
<!--END รายการตัวชี้วัด-->

              
              
              
              
              
              
              
              
              
              
              
              
              
              
<?php
		$t++;
	 }
}else{
 ?>
                <tr>
                <td colspan="5" style="color:#990000; height:50px; vertical-align:middle">- - ไม่มีข้อมูล - -</td>
                </tr>
<?php } ?>
             
             
             
             
             
            
             
             
             
             
             
             
             
             
             
</tbody>
<?php

				$i++;
				$no++;
			}
	}
?>

</table>
<?php
if(!$list){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>
<!--<div class="cms-box-navpage">
<?php //echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>-->

<br />
<br />
<br />
          
