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
	
		ac1 = JQ("#ac_chart_id_ac1").val();
		ac2 = JQ("#ac_chart_id_ac2").val();
		st = JQ("#st").val();
		ed = JQ("#ed").val();
//		searchfield = JQ("#searchfield").val();
		window.location.href="/modules/budgetmanagement/account/report/gl3/gl3.php?ac1="+ac1+"&ac2="+ac2+"&st="+st+"&ed="+ed;
	}
/* ]]> */

JQ(document).ready(function() {
	availableTags = "";
	// ---------ดึงข้อมูล-----------
	JQ.ajax({
	type: "POST",
	async: false,
	url: "?mod=<?php echo LURL::dotPage('report_action');?>",
	data: "action=createautocom",
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
			  },
			  change: function( event, ui ) {
				/*var lenauto = availableTags.length;
				var re_check = true;
				var str = this.id;
				var rowid = str.replace("AcChartCode","");
				for(run_a=0;run_a<lenauto;run_a++){
					if(this.value==availableTags[run_a]["value"]){
						JQ("#ac_chart_id"+rowid).val(availableTags[run_a]["key"]);
						JQ("#ThaiName"+rowid).val(availableTags[run_a]["value1"]);
						re_check = false;
						break;
					}
				}
				if(re_check){
					JQ("#ac_chart_id"+rowid).val("");
					JQ("#ThaiName"+rowid).val("");
					JQ("#textDetail"+rowid).val("");
					JQ("#DrValue"+rowid).val("");
					JQ("#CrValue"+rowid).val("");
				}
				return false;*/
			  }
		});
});

	//-----------------------------------------------
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">พิมพ์บัญชีแยกประเภทแบบ 3 ช่อง<?php echo $MenuName;?></div>
</div>

<table width="100%" border="0" class="tbl-list tablesorter"  cellspacing="0">
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
