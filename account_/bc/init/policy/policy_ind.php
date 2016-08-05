<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => 'จัดการข้อมูลพื้นฐาน',
		'link' => '?mod=budget.init.startup',
	),
	
	array(
		'text' => $MenuName,
	),
));

/*
function icoActive($r){
	global $actionPage;
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&IndTypeId='.$r->IndTypeId."&start=".$_REQUEST["start"].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}
*/
/*
function icoEdit($r){
	$label = 'แก้ไข';
	global $indicatorAddPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($indicatorAddPage)."&id=".$r->PIndId."&BgtYear=".$_REQUEST["BgtYear"]."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoView($r){
	$label = $r->IndTypeName;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&id=".$r->IndTypeId."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=deleteind&id=".$r->PIndId."&start=".$_REQUEST["start"]."')",
		'ico delete',
		$label,
		$label
	));
}
*/


?>

<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	
/*	function Search(){
		var tsearch=JQ('#tsearch').val();
		window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&tsearch="+ tsearch;
	}
	
	function toggleSub(id){
		JQ("a#icoClass_"+id).toggleClass("minimize");
		JQ("tr.hideRow_"+id).toggle();
	}*/
	
	function sortItem(){
	window.location.href='?mod=<?php echo lurl::dotPage($sortPage);?>';
	}
	
	function loadSCT(BgtYear){
		
	}
	
	function loadGroup(PGroupId){
		var BgtYear = JQ('#BgtYear').val();
		window.location.href='?mod=<?php echo lurl::dotPage($indicatorListPage);?>&BgtYear='+BgtYear+'&PGroupId='+PGroupId;
	}
	
	function loadList(PItemId){
		var BgtYear = JQ('#BgtYear').val();
		var PGroupId = JQ('#PGroupId').val();
		window.location.href='?mod=<?php echo lurl::dotPage($indicatorListPage);?>&BgtYear='+BgtYear+'&PGroupId='+PGroupId+'&PItemId='+PItemId;
	}	

	function goAdd(){
		var BgtYear = JQ('#BgtYear').val();
		var PGroupId = JQ('#PGroupId').val();
		var PItemId = JQ('#PItemId').val();
		window.location.href='?mod=<?php echo lurl::dotPage($indicatorAddPage);?>&BgtYear='+BgtYear+'&PGroupId='+PGroupId+'&PItemId='+PItemId;
	}	
	
	function goEdit(PIndId){
		var BgtYear = JQ('#BgtYear').val();
		var PGroupId = JQ('#PGroupId').val();
		var PItemId = JQ('#PItemId').val();
		window.location.href='?mod=<?php echo lurl::dotPage($indicatorAddPage);?>&BgtYear='+BgtYear+'&PGroupId='+PGroupId+'&PItemId='+PItemId+'&PIndId='+PIndId;
	}	
		
	function goDelete(PIndId){
		if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){
			var BgtYear = JQ('#BgtYear').val();
			var PGroupId = JQ('#PGroupId').val();
			var PItemId = JQ('#PItemId').val();
			window.location.href='?mod=<?php echo lurl::dotPage($actionPage);?>&action=deleteind&BgtYear='+BgtYear+'&PGroupId='+PGroupId+'&PItemId='+PItemId+'&PIndId='+PIndId;
		}else{
			return false;
		}
	}		
	

	function goSort(){
		var BgtYear = JQ('#BgtYear').val();
		var PGroupId = JQ('#PGroupId').val();
		var PItemId = JQ('#PItemId').val();
		window.location.href='?mod=<?php echo lurl::dotPage($sortPage);?>&BgtYear='+BgtYear+'&PGroupId='+PGroupId+'&PItemId='+PItemId;
	}	
		
/* ]]> */
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td>
      	<input type="button" name="button4" id="button4" value="เพิ่มรายการ" class="add" onclick="goAdd();" />
        <input type="button" name="button5" id="button5" value="  เรียงลำดับข้อมูล  " class="btnRed" onclick="goSort();"  />
      	<input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($indicatorListPage);?>');" />
       <!-- <input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();" />-->
       <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $BgtYear;?>');" />
        </td>

    </tr>
        <tr>

          <td align="right">
          ปีงบประมาณ : <?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?>
          กลุ่ม : <?php echo $get->getGroupListbox($_REQUEST["PGroupId"],'PGroupId');?>
          รายการ : <?php echo $get->getItemListbox($_REQUEST["PItemId"],'PItemId');?>
          </td>
    </tr>
  </table>
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
<script type="text/javascript" language="javascript" id="js">
/* <![CDATA[ */
JQ(document).ready(function() {
	
	JQ("table").tablesorter({
		headers: {
			0: {sorter: false},
			3: {sorter: false},
			4: {sorter: false}
		}
	});
	
});
/* ]]> */
</script>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<td  style="padding-left:20px"><?php echo $get->getPGroupName(($PGroupId)?$PGroupId:$_REQUEST["PGroupId"]);?>&nbsp;->&nbsp;<?php echo $get->getItemName(($PItemId)?$PItemId:$_REQUEST["PItemId"]);?></td>
</tr>
</table>
<table width="100%" border="0" class="tbl-list tablesorter"  cellspacing="0">
<thead>
  <tr>
    <th class="no" style="width:10px">ลำดับ</th>
    <th align="left" >ชื่อตัวชี้วัด</th>
    <th align="center" style="width:150px;">ประเภทตัวชี้วัด</th>
    <th align="center" style="width:150px;">ค่าเป้าหมาย</th>
    <th align="center" style="width:150px;">หน่วยนับ</th>
    <th colspan="2" style="text-align:center;" >ปฏิบัติการ</th>
    </tr>
</thead>
<tbody>
<?php

	//ltxt::print_r($list["rows"]);
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	
	if($list["rows"]){
          foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
<input name="PIndId" type="hidden"  id="PIndId" value="<?php echo $PIndId;?>" />
  <tr>
    <td valign="top" class="center" ><?php echo $i ;?>.</td>
    <td valign="top" ><?php echo $PIndName;?></td>
    <td valign="top" ><?php echo $get->getIndTypeName($IndTypeId); ?></td>
    <td valign="top" ><?php echo $Value;?></td>
    <td valign="top" ><?php echo $get->getUnitName($UnitID);?></td>    
    <td style="width:60px;" nowrap="nowrap" valign="top"  ><a onclick="goEdit(<?php echo $PIndId;?>);" class="ico edit" style="color:#003399">แก้ไข</a><?php //echo icoEdit($r);?></td>
    <td style="width:60px;" valign="top"  nowrap="nowrap" ><a onclick="goDelete(<?php echo $PIndId;?>);" class="ico delete" style="color:#003399">ลบทิ้ง</a><?php //echo icoDelete($r);?></td>
  </tr>
  
<?php

		$i++;
		}
	}
?>
</tbody>
</table>
<?php
if(!$list["rows"]){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>
<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>
          
