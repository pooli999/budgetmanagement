<?php

include("config.php");

include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบบัญชี',
		'link' => '?mod=account.startup',
	),

	array(
		'text' => $MenuName,
	),
));

function icoActive($r){
	global $actionPage;
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&BankId='.$r->BankId."&start=".$_REQUEST["start"].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}

function icoEdit($r){
	$label = 'แก้ไข';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->CostItemId."&CostItemAcId=".$r->CostItemAcId."&AcGroupId=".$r->AcGroupId."&AcSeriesId=".$r->AcSeriesId."&AcSeriesName=".$r->AcSeriesName."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoView($r){
	$label = $r->BankName;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&id=".$r->BankId."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&id=".$r->BankId."&start=".$_REQUEST["start"]."')",
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

<script language="javascript" type="text/javascript">
/* <![CDATA[ */

	function Search(){
		var AcSeriesId=JQ('#AcSeriesId').val();
		var AcSeriesName=JQ('#AcSeriesId option:selected').text();
		window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&AcSeriesId="+ AcSeriesId+"&AcSeriesName="+AcSeriesName;
	}

	function toggleSub(id){
		JQ("a#icoClass_"+id).toggleClass("minimize");
		JQ("tr.hideRow_"+id).toggle();
	}

	function sortItem(){
	window.location.href='?mod=<?php echo lurl::dotPage($sortPage);?>';
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
      	<!--<input type="button" name="button4" id="button4" value="เพิ่มรายการ" class="add" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>');" />-->
        <!--<input type="button" name="button5" id="button5" value="  เรียงลำดับข้อมูล  " class="btnRed" onclick="goPage('?mod=<?php //echo lurl::dotPage($sortPage);?>');" />-->
      	<input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" />
        <!--<input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();" />-->
      </td>

          <td align="right"><form name="searchForm" id="SearchForm" method="post">ชื่อชุดผังบัญชี<?php
  		//$tag_attribs = 'onchange="newAcSeries();"';
		$tag_attribs ="";
		echo $get->getAcSeriesIdSelect("AcSeriesId",$tag_attribs,$_REQUEST["AcSeriesId"],"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?> <input id="search2" name="search2" type="button" value="  ค้นหา  " class="btnRed"   onclick="Search();" /></form></td>
    </tr>
  </table>
</div>
<div id="boxSearch" class="boxsearch" style="display:none;">
  <table  border="0" align="center" cellpadding="0" cellspacing="5" >
    <tr>
      <td  align="left"><strong>คำค้น : </strong></td>
      <td align="left"><input name="tsearch" id="tsearch" type="text" class="input-search" size="30" value="<?php echo $_REQUEST['tsearch']?>" />
        <!--<input id="search2" name="search2" type="button" value="  ค้นหา  " class="btnRed"   onclick="Search();" />-->
        <input type="button" name="button5" id="button2" class="btn" value=" ยกเลิก " onclick="JQ('#boxSearch').hide();JQ('#boxFilter').show();" /></td>
    </tr>
  </table>

</div>
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
			2: {sorter: false},
			3: {sorter: false}
		}
	});

});
/* ]]> */
</script>

<table width="100%" border="0" class="tbl-list tablesorter"  cellspacing="0">
<thead>
  <tr>
    <th class="no" style="width:10px">ลำดับ</th>
    <th align="left" style="width:500px">รายการค่าใช้จ่าย</th>
    <th align="left">ผูกบัญชีย่อย Dr.</th>
    <th style="text-align:center;width:120px;" >ปฏิบัติการ</th>
    </tr>
</thead>
<tbody>
<?php
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;

	if($list["rows"]){
          foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
  <tr>
    <td valign="top" class="center" ><?php echo $i ;?>.</td>
    <td valign="top" ><?php // echo icoView($r);?><?php echo $CostName;?></td>
    <td valign="top" >
<?php
$AcList = $get->getAcDataList($CostItemId);//ltxt::print_r($AcList);
if($AcList["rows"]){
	$iv = 0;
	foreach($AcList["rows"] as $r1 ) {
			foreach( $r1 as $k1=>$v1){ ${$k1} = $v1;}
			if($iv==0){
				echo $r1->acName;
			}else{
				echo "<br>".$r1->acName;
			}
		$iv++;
	}
}
?>
	</td>
    <td align="center" nowrap="nowrap" valign="top"  ><?php echo icoEdit($r);?></td>
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
<?php echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]."&AcSeriesId=1&AcSeriesName=มาตราฐาน"));?>
</div>
