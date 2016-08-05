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
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->BankId."&start=".$_REQUEST["start"]."'",
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
function loaddata(){
   // arr_ac_chart_id.length = 0;
    //-----------------------------------------------
    JQ.ajax({
      type: "POST",
      async: false,
      url: "?mod=<?php echo LURL::dotPage('generaljournal_action');?>",
      data: "action=findeaccount&CastValue="+CastValue+"&PaymentListDetailId="+PaymentListDetailId+"&AcActionId="+AcActionId+"&PaymentId=<?=$_REQUEST["id"]?>",
      success: function(result3){
            if (result3.length > 0){

                for (list_d = 0;list_d < result3.length;list_d++){
                    arr_ac_chart_id[list_d]=result3[list_d]["AcChartId"];
                    arr_AcChartCode[list_d]=result3[list_d]["AcChartCode"]+" || "+result3[list_d]["ThaiName"];

                  }
            }
        },
          dataType: "json"
    });
    //-----------------------------------------------

}
/* <![CDATA[ */
	function Save(f,idv){
		if(ValidateForm(f)){
			JQ("#CompensateId").val(idv);
			 var action_url = '?mod=finance.pettycashreport.pettycashreport_action&idv='+idv;
			 var redirec_url = '?mod=finance.pettycashreport.pettycashreport_list';
			 toSubmit(f,'save',action_url,redirec_url);
		}
	}
	function ValidateForm(f){
			//return true;
			/*if(JQ('#data1').val() == ''){
				jAlert('กรุณาเลือกรายการ','ระบบตรวจสอบข้อมูล',function(){
					JQ('#BankName').focus();
				});
				return false;
			}*/
			var r = confirm("ต้องการทำรายการใช่หรือไม่");
			if (r == true) {
				return true;
			} else {
				return false;
			}
	}

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
				<input id="btnstvaule" name="btnstvaule" type="button" value="  ปรับปรุงยอดยกมา  " class="btnRed"    />
				<input type="button" name="button52" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" />

			</td>
      <td align="right"><b>วันทีทำรายการ: </b>
		<?php  // ทำปฏิทิน
			$tsearch = date('Y-m-d');
			echo InputCalendar_text(array(
				'id'=> 'tsearch',
				'name' => 'tsearch',
				'value' => $tsearch
			));
		?>
          <input id="search22" name="search22" type="button" value="  ค้นหา  " class="btnRed"   onclick="Search();" />
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
function loaddata(){
   // arr_ac_chart_id.length = 0;
    //-----------------------------------------------
    JQ.ajax({
      type: "POST",
      async: false,
      url: "?mod=<?php echo LURL::dotPage('pettycashreport_action');?>",
      data: "action=loadstvaule",
      success: function(result3){
            if (result3.length > 0){
                for (list_d = 0;list_d < result3.length;list_d++){
                    JQ("#v0").text(result3[0]["v0"]);
                    JQ("#v1").text(result3[0]["v1"]);
										JQ("#v2").text(result3[0]["v2"]);
										JQ("#v3").text(result3[0]["v3"]);
                  }
            }
        },
          dataType: "json"
    });
    //-----------------------------------------------
}
JQ(document).ready(function() {
	loaddata();
	JQ( "#dialog-stvalue" ).dialog({
		resizable: false,
		autoOpen: false,
		height: "auto",
		width: 300,
		modal: true,
		buttons: {
			"บันทึก": function() {
				stvalue = JQ("#stvalue").val();
				JQ.ajax({
		      type: "POST",
		      async: false,
		      url: "?mod=<?php echo LURL::dotPage('pettycashreport_action');?>",
		      data: "action=btnstvaule&stvalue="+stvalue,
		      success: function(result3){

		          alert("ปรับปรุงยอดยกมาแล้ว");
							loaddata();
							JQ( "#dialog-stvalue" ).dialog( "close" );
		        },
		          dataType: "json"
		    });
			},
			"ปิด": function() {
				JQ( "#dialog-stvalue" ).dialog( "close" );
			}
		}
	});

	JQ("#btnstvaule").live('click', function(event) {
		JQ( "#dialog-stvalue" ).dialog( "open" );
	});
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
<table width="700" border="0"  cellspacing="0">

<tr>
	<td valign="top" style="width:100px;">
		<b>ยอดยกมา</b> <label id = "v0" name = "v0">10000</label> บาท  -
		<b>เบิกจ่ายไป</b> <label id = "v1" name = "v1">10000</label> บาท +
		<b>เบิกทดแทน</b> <label id = "v2" name = "v2">20000</label> บาท =
		<b>ยอดคงเหลือ</b> <label id = "v3" name = "v3">30000</label> บาท


	</td>

</tr>

</table>
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>&action=save" enctype="multipart/form-data" >
<table width="100%" border="0" class="tbl-list tablesorter"  cellspacing="0">
<thead>
  <tr>
    <th width="41" class="no" style="width:10px">ลำดับ</th>
    <th width="150" align="center" ><span style="width:150px;">วันทีทำรายการ</span></th>
    <th align="center" >เลขที่ เงินสดย่อย <input name="CompensateId" type="hidden" id="CompensateId" value="" /></th>
    <th width="150" align="center" style="width:150px;"><span style="width:240px;">จำนวนเงิน (บาท) </span></th>
    <th colspan="2" style="text-align:center;" >ปฏิบัติการ</th>
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
    <td valign="top" ><?php echo $CreateDate;?></td>
    <td align="left" valign="top" ><?php
	echo str_replace("||","&nbsp;,&nbsp;",$DocCode);
	?></td>
    <td align="center" valign="top" ><?php echo $TotalValue;?></td>
    <td width="60" valign="top" nowrap="nowrap" style="width:60px;"  ><a class="ico view" title="แก้ไข" href="javascript:self.location='?mod=finance.pettycashreportv.pettycashreportv_list&idv=<?=$CompensateId?>'">แสดง</a></td>
    <td width="60" valign="top"  nowrap="nowrap" style="width:60px;" ><a href="#" onclick="Save('adminForm','<?=$CompensateId?>');">ยกเลิกรายการ</a></td>
  </tr>

<?php

		$i++;
		}
	}
?>
</tbody>
</table>
</script>
<?php
if(!$list["rows"]){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';
}
?>
<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>

<div id="dialog-stvalue" title="ปรับปรุงยอดยกมา">
    <input type="text" name="stvalue" id="stvalue" value="" /> บาท
</div>
