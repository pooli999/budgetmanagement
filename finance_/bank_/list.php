<?php
include("config.php");
include("helper.php");
include("data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => getMenuItem(lurl::dotPage($startupPage))->MenuName,
		'link' => '?mod='.lurl::dotPage($startupPage)
	),
	array(
		'text' => $MenuName,
	),
));

function icoActive($r){
	$label = 'เปิดใช้งาน';
	$label2 = '&nbsp;';
	global $listPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($listPage)."&id=".$r->PersonalId."'",					'ico enabled',
		$label,
		$label
	));
}

function icoEdit($r){
	$label = 'แก้ไข';
	$label2 = '&nbsp;';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->PersonalId."'",					'ico edit',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบ';
	$label2 = '&nbsp;';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&PersonalId=".$r->PersonalId."')",
		'ico delete',		$label,
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
	
	JQ(document).ready(function(){

	});

/* ]]> */
</script>

<div class="sysinfo">
  <div class="sysname">จัดการข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>
<div class="boxfilter" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td width="50%"><input type="button" name="button4" id="button4" value="เพิ่ม" class="btnActive" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>');" />
      <input type="button" name="button" id="button" value="รีเฟรช" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
      <td width="50%" align="right"><b>วันที่ : </b>
        <label for="select"></label>
        
		<?php 
		//$ApproveDate = date('Y-m-d');
		$ApproveDate = "";
	  	echo InputCalendar_text(array(
			'id'=> 'ApproveDate',
			'name' => 'ApproveDate',
			'value' => $ApproveDate
		));
		echo $ApproveDate;
		?>   
		
		        <input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').slideToggle();" /></td>
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
        <input type="button" name="button5" id="button2" class="btn" value=" ยกเลิก " onclick="JQ('#boxSearch').slideToggle();" /></td>
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
	JQ("table").tablesorter({
		headers: {
			0: {sorter: false},
			6: {sorter: false},
			7: {sorter: false}
		}
	});
});
/* ]]> */
</script>
<table width="100%" border="0" class="tbl-list tablesorter"cellspacing="0">
<thead>
  <tr>
    <th  align="center" class="no" style="width:20px">ลำดับ</th>
    <th  align="center">ชื่อธนาคาร</th>
    <th  align="center" style="width:150px;">วันทีทำรายการ</th>
    <th align="center"  width="" style="width:100px;">ปฏิบัติการ</th>
    </tr>
</thead>
<tbody>
<?php

?>
  <tr class="active-row">
    <td valign="top" class="center"><?php echo $i ;?>1.</td>
    <td align="left" valign="top" class="left">กรุงเทพ</td>
    <td align="center" valign="top" class="center">15 ส.ค. 59 </td>
    <td align="center"  valign="top" nowrap="nowrap"  ><?php echo icoEdit($r);?>&nbsp;<?php echo icoDelete($r);?></td>
  </tr>
  <tr class="active-row">
    <td valign="top" class="center">2.</td>
    <td align="left" valign="top" class="left">กรุงไทย</td>
    <td align="center" valign="top" class="center">20 ส.ค. 59 </td>
    <td align="center"  valign="top" nowrap="nowrap"  ><?php echo icoEdit($r);?>&nbsp;<?php echo icoDelete($r);?></td>
  </tr>
  <tr class="active-row">
    <td valign="top" class="center">3.</td>
    <td align="left" valign="top" class="left">ออนสิน</td>
    <td align="center" valign="top" class="center">25 ส.ค. 59 </td>
    <td align="center"  valign="top" nowrap="nowrap"  ><?php echo icoEdit($r);?>&nbsp;<?php echo icoDelete($r);?></td>
  </tr>

<?php if($i==1){?>
<?php } ?>
</tbody>
</table>
<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>4));?>
</div>
          
