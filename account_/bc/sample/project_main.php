<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
	),
));

function icoActive($r){
	global $actionPage;
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&OrganizeId='.$r->OrganizeId.'&start='.$_REQUEST["start"].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}

function icoEdit($r){
	$label = 'แก้ไข';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&start=".$_REQUEST["start"]."&id=".$r->OrganizeId."'",
		'ico edit',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&start=".$_REQUEST["start"]."&action=delete&OrganizeId=".$r->OrganizeId."')",
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

/* ]]> */
</script>
<style>
.parentrow{
	background-color:#eee;
}
</style>
<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td><input type="button" name="button4" id="button4" value="เพิ่มรายการ" class="btnActive" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>');" />
        <!--<input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();" />--></td>

          <td align="right"></td>
    </tr>
  </table>
</div>
<form name="searchForm" id="SearchForm" method="post">
<div id="boxSearch" class="boxsearch" style="display:<?php echo 'none';?>">
  <table width="60%" border="0" align="center" cellpadding="0" cellspacing="5" >
    <tr>
      <td width="15%" align="left"><strong>คำค้น : </strong></td>
      <td width="40" colspan="3"><input name="tsearch" id="tsearch" type="text" class="input-search" size="30" value="<?php echo $_REQUEST['tsearch']?>" />
        <input id="search2" name="search2" type="button" value="  ค้นหา  " class="btnActive"   onclick="Search();" />
        <input type="button" name="button5" id="button2" class="btn" value=" ยกเลิก " onclick="$('#boxSearch').hide();$('#boxFilter').show();" /></td>
    </tr>
  </table>
  
</div></form>
<div class="cms-box-search">

  <?php if($_REQUEST['tsearch']){?>
ผลการค้นหา <span style="color:#FF6600; font-weight:bold;">&quot;<?php echo $_REQUEST['tsearch'];?>&quot;</span> พบจำนวน <span style="color:#FF6600; font-weight:bold;"><?php echo $list['total'];?></span> รายการ 
<?php }?>
</div>
<script type="text/javascript" language="javascript" id="js">
/* <![CDATA[ */
JQ(document).ready(function() {
	/*
	JQ("table").tablesorter({
		headers: {
			0: {sorter: false},
			3: {sorter: false},
			2: {sorter: false}
		}
	});
	*/
});
/* ]]> */
</script>

<?php $x=$get->getSCTypeRecordSet(); ltxt::print_r($x);?>

<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>
          
