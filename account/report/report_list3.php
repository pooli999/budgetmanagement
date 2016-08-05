<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบบัญชี',
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
		AcSeriesId = JQ("#AcSeriesId").val();
		ac1 = JQ("#ac_chart_id_ac1").val();
		ac2 = JQ("#ac_chart_id_ac2").val();
		st = JQ("#st").val();
		ed = JQ("#ed").val();
//		searchfield = JQ("#searchfield").val();
		window.location.href="/modules/budgetmanagement/account/report/t1/t1.php?AcSeriesId="+AcSeriesId+"&ac1="+ac1+"&ac2="+ac2+"&st="+st+"&ed="+ed;
	}

	function loadAc(AcSeriesId){
		//alert(AcSeriesId);
		JQ.ajax({
		type: "POST",
		async: false,
		url: "?mod=<?php echo LURL::dotPage('report_action');?>",
		data: "action=createautocom&AcSeriesId="+AcSeriesId,
		success: function(result3){
			if (result3.length > 0){
				availableTags = result3;
			}
		},
		  dataType: "json"
		});
	JQ( ".findcode" ).autocomplete({
			source: availableTags,
			  select: function( event, ui ) {
				var str = this.id;
				JQ("#ac_chart_id_"+str).val(ui.item.key);
				return false;
			  }
		});
	}
/* ]]> */


	//-----------------------------------------------
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">พิมพ์งบทดลอง<?php echo $MenuName;?></div>
</div>

<table width="100%" border="0" class="tbl-list tablesorter"  cellspacing="0">
<tr>
<td>ชุดผังบัญชี</td>
<td>
	<?php
  		$tag_attribs = 'onchange="loadAc(this.value);"';
		echo $get->getAcSeriesIdSelect("AcSeriesId",$tag_attribs,$_REQUEST["AcSeriesId"],"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></td>
<tr>
<tr>
<td>บัญชีย่อย</td>
<td>
	<input name = "ac1" type="text" class = "findcode" id="ac1" size="25" maxlength="20" />
	<input name="ac_chart_id_ac1" type="hidden" id="ac_chart_id_ac1" /> ถึง <input name = "ac2" type="text" class = "findcode" id="ac2" size="25" maxlength="20" /><input name="ac_chart_id_ac2" type="hidden" id="ac_chart_id_ac2" /></td>
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
