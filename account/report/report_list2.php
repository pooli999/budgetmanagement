<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบการเงิน',
		'link' => '?mod=budget.init.startup',
	),
	
	array(
		'text' => $MenuName,
	),
));

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

	function saveToExcel(){
		journalId = JQ("#journalId").val();
		st = JQ("#st").val();
		ed = JQ("#ed").val();
//		searchfield = JQ("#searchfield").val();
		window.location.href="/modules/budgetmanagement/account/report/j1/j1.php?journalId="+journalId+"&st="+st+"&ed="+ed;
	}

/* ]]> */


	//-----------------------------------------------
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">พิมพ์รายวัน เรียงวันที่<?php echo $MenuName;?></div>
</div>

<table width="100%" border="0" class="tbl-list tablesorter"  cellspacing="0">
<tr>
<td>สมุดรายวัน</td>
<td>
	<?php 
  		$tag_attribs = '';
		echo $get->getJournalIdSelect("journalId",$tag_attribs,$_REQUEST["journalId"],"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></td>
<tr>
<tr>
<td>วันที่</td>
<td><?php  // 
		$aa = date('Y-m-d');
	  	echo InputCalendar_text(array(
			'id'=> 'st',
			'name' => 'st',
			'value' => $aa
		));
		?>  ถึง
		<?php  // 
		$aa = date('Y-m-d');
	  	echo InputCalendar_text(array(
			'id'=> 'ed',
			'name' => 'ed',
			'value' => $aa
		));
		?>
		</td>
<tr>
<tr>
  <td>&nbsp;</td>
  <td><input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="saveToExcel('adminForm');" /></td>
<tr>
</table>
