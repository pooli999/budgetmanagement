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
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'เพิ่ม'.$MenuName
	),
));

$journalId=$_request["journalId"];
?>
<script language="javascript" type="text/javascript">

/* <![CDATA[ */

function ValidateForm(f){
		vdr = 0;
		maxvdr = 0;
		JQ('.cal_dr').each(function() {	// วนสร้าง ตามจำนวนที่เลือก
			vdr = this.value
			if (vdr == ""){
				vdr = 0;
			}
			maxvdr = parseFloat(maxvdr)+parseFloat(vdr);
		});

		vcr = 0;
		maxvcr = 0;
		JQ('.cal_cr').each(function() {	// วนสร้าง ตามจำนวนที่เลือก
			vcr = this.value
			if (vcr == ""){
				vcr = 0;
			}
			maxvcr = parseFloat(maxvcr)+parseFloat(vcr);
			maxvdr = toFixed(maxvdr,2);
			maxvcr = toFixed(maxvcr,2);
		});
		if (maxvdr == maxvcr){
				return true;
		}else{
			alert("จำนวนเงินDR ไม่เท่ากับ จำนวนเงินCR");
			return false;
		}

}

function toFixed(num, pre){
    num *= Math.pow(10, pre);
    num = (Math.round(num, pre) + (((num - Math.round(num, pre))>=0.5)?1:0)) / Math.pow(10, pre);
    return num.toFixed(pre);
}
function ValidatePV(){
	//-----------------------------------------------
		var ans;
    JQ.ajax({
      type: "POST",
      async: false,
      url: "?mod=<?php echo LURL::dotPage('incomejournal_action');?>",
      data: "action=chkpv&PV="+JQ("#PV").val(),
      success: function(result3){
            if (result3.length > 0){
							ans = result3;
            }
        },
          dataType: "json"
    });
		return ans;
    //-----------------------------------------------
}
function Save(f){
	<?php if ($AcActionId==""){?>
		ans = ValidatePV();
	<?php }else{?>
		ans = "notfound"; // กรณีแก้ไขไม่ต้องเช็ค
	<?php }?>

	if(ans == "notfound"){
		if(ValidateForm(f)){
			 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
			 var redirec_url = '?mod=<?php echo LURL::dotPage($listPage);?>';
			 toSubmit(f,'save',action_url,redirec_url);
		}
	}else{
 	 alert("PV นี้ถูกใช้แล้ว")
  }
}

/*function Confirm(f){
	if(ValidateForm(f)){
		var firm_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		toConfirm(f,'confirm',firm_url);
	}

}*/


/*  ]]> */

/* <![CDATA[ */
var arr_ac_chart_id = []; // arry
var arr_AcChartCode = []; // arry
var arr_ThaiName = []; // arry
var arr_textDetail = []; // arry
var arr_DrValue = []; // arry
var arr_CrValue = []; // arry

	JQ(document).ready(function() {

		JQ('.iRow').live('keydown', function(e) {
			if (e.keyCode == 114) {
				e.preventDefault();
				arr_ac_chart_id.length = 0;
				arr_AcChartCode.length = 0;
				arr_ThaiName.length = 0;
				arr_textDetail.length = 0;
				arr_DrValue.length = 0;
				arr_CrValue.length = 0;
				idxlist_d =JQ(this).attr("list_d");// index ที่กด

				MaxLine=JQ("#MaxLine").val(); // จำนวนมากสุด

				MaxLine--;// เพิ่มแถว

				for (ii = 0;ii <= MaxLine;ii++){
				//	alert(ii);

					if (ii == idxlist_d){
						arr_ac_chart_id[ii]="";
						arr_AcChartCode[ii]="";
						arr_ThaiName[ii]="";
						arr_textDetail[ii]="";
						arr_DrValue[ii]="0";
						arr_CrValue[ii]="0";
						debugii=ii+1;
					}else if (ii < idxlist_d){
						debugii = ii;
					}else{
						debugii=ii+1;
					}

					arr_ac_chart_id[debugii]=JQ("#ac_chart_id"+ii).val();
					arr_AcChartCode[debugii]=JQ("#AcChartCode"+ii).val();
					arr_ThaiName[debugii]=JQ("#ThaiName"+ii).val();
					arr_textDetail[debugii]=JQ("#textDetail"+ii).val();
					arr_DrValue[debugii]=JQ("#DrValue"+ii).val();
					arr_CrValue[debugii]=JQ("#CrValue"+ii).val();
				}
				//alert(ii);
				create_tblacc()
			}
		});

	/*		JQ(".findcode").live('change',function(){
				alert(this.value);
			});*/
			loaddata(<?=$AcActionId?>);
			JQ('.newrow').live('keydown', function(e) {

			if (e.keyCode == 13) {
				e.preventDefault();

			//	JQ('[name=ac_chart_id]').each(function() {	// วนสร้าง ตามจำนวนที่เลือก
				for (ii = 0;ii <= list_d;ii++){
					arr_ac_chart_id[ii]=JQ("#ac_chart_id"+ii).val();
					arr_AcChartCode[ii]=JQ("#AcChartCode"+ii).val();
					arr_ThaiName[ii]=JQ("#ThaiName"+ii).val();
					arr_textDetail[ii]=JQ("#textDetail"+ii).val();
					arr_DrValue[ii]=JQ("#DrValue"+ii).val();
					arr_CrValue[ii]=JQ("#CrValue"+ii).val();
				}
				//});
				create_tblacc(<?=$AcActionId?>);
			}// clode keydown
		});
	});
/* ]]> */

function loaddata(AcActionId){
	//alert(AcActionId);
	 // ---------ดึงข้อมูล ผูกบัญชีค่าใช้จ่าย-----------

	 if (typeof(AcActionId) != "undefined"){
		AcActionId  = AcActionId;
	}else{
		AcActionId ="";
	}

	JQ.ajax({
	  type: "POST",
	  async: false,
	  url: "?mod=<?php echo LURL::dotPage('incomejournal_action');?>",
	  data: "action=findeaccount&AcActionId="+AcActionId+"&IncomeId=<?=$_REQUEST["id"]?>",
	  success: function(result3){
			if (result3.length > 0){
				for (list_d = 0;list_d < result3.length;list_d++){
					arr_ac_chart_id[list_d]=result3[list_d]["AcChartId"];
					arr_AcChartCode[list_d]=result3[list_d]["AcChartCode"]+" || "+result3[list_d]["ThaiName"];
					arr_ThaiName[list_d]=result3[list_d]["ThaiName"];
					arr_textDetail[list_d]=result3[list_d]["TextDetail"];
					arr_DrValue[list_d]=result3[list_d]["DRValue"];// ค่าใช้จ่าย รายจ่าย ลง dr อย่างเดียว
					arr_CrValue[list_d]=result3[list_d]["CRValue"];
	  			}
			}
		},
		  dataType: "json"
	});
	//-----------------------------------------------

	create_tblacc();
}
function ansdr(){
		vdr = 0;
		maxvdr = 0;
		JQ('.cal_dr').each(function() {	// วนสร้าง ตามจำนวนที่เลือก
			vdr = this.value
			if (vdr == ""){
				vdr = 0;
			}
			maxvdr = parseFloat(maxvdr)+parseFloat(vdr);
		});
		JQ("#lblmaxdr").text(addCommas(maxvdr.toFixed(2)));
}
function anscr(){
	vcr = 0;
	maxvcr = 0;
	JQ('.cal_cr').each(function() {	// วนสร้าง ตามจำนวนที่เลือก
		vcr = this.value
		if (vcr == ""){
			vcr = 0;
		}
		maxvcr = parseFloat(maxvcr)+parseFloat(vcr);
	});
	JQ("#lblmaxcr").text(addCommas(maxvcr.toFixed(2)));
}
function create_tblacc(){ // สร้างตาราง แสดงรายการ

	str = '<table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" >';
      str = str+'<tr >';
        str = str+'<td width="20" align="center" bgcolor="808080" class = "iTd style4"> No.</td>';
        str = str+'<td width="100" align="center" bgcolor="808080" class = "iTd style4">Account</td>';
        //str = str+'<td width="250" align="center" bgcolor="808080" class = "iTd style4">Account Name</td>';
        str = str+'<td align="center" bgcolor="808080" class = "iTd style4">Detail</td>';
        str = str+'<td width="110" align="center" bgcolor="808080" class = "iTd style4">Debit</td>';
        str = str+'<td width="110" align="center" bgcolor="808080" class = "iTd style4">Credit</td>';
      str = str+'</tr>';
			 line =1;
			 max_dr = 0;
			 vdr = 0;
			 vcr = 0;
			 max_cr = 0;
				for (list_d = 0;list_d < arr_ac_chart_id.length;list_d++){
					  str = str+'<tr class="iRow" list_d = '+list_d+'>';
						str = str+'<td height="25" bgcolor="#FFFFBB" align="center" class = "iTd" style="background-color:#FFFFBB;">'+line+'</td>';
						str = str+'<td align="left" bgcolor="#FFFFBB" class = "iTd" style="background-color:#FFFFBB;">';
							str = str+'<input name="ac_chart_id'+list_d+'" type="hidden" id = "ac_chart_id'+list_d+'" value="'+arr_ac_chart_id[list_d]+'" />';
							str = str+'<input name="AcChartCode'+list_d+'" type="text" id = "AcChartCode'+list_d+'" class="input_style2 findcode clearrow" value="'+arr_AcChartCode[list_d]+'" size="130"/>';
						str = str+'</td>';
						// str = str+'<td align="left" bgcolor="#FFFFBB"class = "iTd">';
						// 	 str = str+'<input name="ThaiName'+list_d+'" type="text" id = "ThaiName'+list_d+'"  class="input_style2" value="'+arr_ThaiName[list_d]+'" size="50"/>';
						str = str+'</td>';
						str = str+'<td align="center" bgcolor="#FFFFBB"class = "iTd" style="background-color:#FFFFBB;">';
							 str = str+'<textarea name="textDetail'+list_d+'" cols="30" rows="1" class="input_style2" id="textDetail'+list_d+'">'+arr_textDetail[list_d]+'</textarea>';
						str = str+'</td>';
						str = str+'<td align="right" bgcolor="#FFFFBB"class = "iTd" style="background-color:#FFFFBB;">';
						  str = str+'<input name="DrValue'+list_d+'" type="text" id = "DrValue'+list_d+'" class="input_style4 cal_dr" value="'+arr_DrValue[list_d]+'" size="18" maxlength="18"/>';
						str = str+'</td>';
						str = str+'<td align="right" bgcolor="#FFFFBB"class = "iTd" style="background-color:#FFFFBB;">';
						  str = str+'<input name="CrValue'+list_d+'" type="text" id = "CrValue'+list_d+'" class="input_style4 cal_cr" value="'+arr_CrValue[list_d]+'" size="18" maxlength="18"/>';
					   str = str+'</td>';
					  str = str+'</tr>';
					  vdr = arr_DrValue[list_d];
					  if (vdr == ""){
						  vdr = 0;
					  }
					  vcr = arr_CrValue[list_d];
					  if (vcr == ""){
						  vcr = 0;
					  }
					  max_dr = parseFloat(max_dr)+parseFloat(vdr);
					  max_cr = parseFloat(max_cr)+parseFloat(vcr);
					  line++;
	  			}
	str = str+'<tr class="iRow">';
	str = str+'<td height="25" bgcolor="#FFFFBB" align="center" class = "iTd" style="background-color:#FFFFBB;">'+line+'</td>';
	str = str+'<td align="left" bgcolor="#FFFFBB" class = "iTd">';
		str = str+'<input name="ac_chart_id'+list_d+'" type="hidden" id = "ac_chart_id'+list_d+'" value="" />';
		str = str+'<input name="AcChartCode'+list_d+'" type="text" id = "AcChartCode'+list_d+'" class="input_style2 findcode clearrow" value="" size="130"/>';
	str = str+'</td>';
	// str = str+'<td align="left" bgcolor="#FFFFBB"class = "iTd">';
	// 	 str = str+'<input name="ThaiName'+list_d+'" type="text" id = "ThaiName'+list_d+'"  class="input_style2" value="" size="50"/>';
	// str = str+'</td>';
	str = str+'<td align="center" bgcolor="#FFFFBB"class = "iTd" style="background-color:#FFFFBB;">';
		 str = str+'<textarea name="textDetail'+list_d+'" cols="30" rows="1" class="input_style2" id="textDetail'+list_d+'"></textarea>';
	str = str+'</td>';
	str = str+'<td align="right" bgcolor="#FFFFBB"class = "iTd" style="background-color:#FFFFBB;">';
	  str = str+'<input name="DrValue'+list_d+'" type="text" id = "DrValue'+list_d+'" class="input_style4 newrow cal_dr" value="" size="18" maxlength="18"/>';
	str = str+'</td>';
	str = str+'<td align="right" bgcolor="#FFFFBB"class = "iTd" style="background-color:#FFFFBB;">';
	  str = str+'<input name="CrValue'+list_d+'" type="text" id = "CrValue'+list_d+'" class="input_style4 newrow cal_cr" value="" size="18" maxlength="18"/>';
   str = str+'</td>';
  str = str+'</tr>';
     str = str+' <tr class="iRow">';
        str = str+'<td height="40" colspan="3" align="right" bgcolor="#FFFFFF" class = "iTd" >Total&nbsp;&nbsp;</td>';
        str = str+'<td align="right" bgcolor="d4d0c8"class = "iTd"><label id ="lblmaxdr">'+addCommas(max_dr.toFixed(2))+'</label></td>';
        str = str+'<td align="right" bgcolor="d4d0c8"class = "iTd"><label id ="lblmaxcr">'+addCommas(max_cr.toFixed(2))+'</label></td>';
      str = str+'</tr>';
    str = str+'</table>';
	JQ("#div_account").html(str);
	JQ("#MaxLine").val(list_d);
	create_autocom();


}
function addCommas(nStr){
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}
function create_autocom(){
			availableTags = "";
			 // ---------ดึงข้อมูล-----------
			JQ.ajax({
			  type: "POST",
			  async: false,
			  url: "?mod=<?php echo LURL::dotPage('incomejournal_action');?>",
			  data: "action=createautocom",
			  success: function(result3){
					if (result3.length > 0){
						availableTags = result3;
					}
				},
				  dataType: "json"
			});
			//-----------------------------------------------


			JQ( ".findcode" ).autocomplete({
					source: availableTags,
					  select: function( event, ui ) {
						var str = this.id;
						var rowid = str.replace("AcChartCode","");
						 JQ("#ac_chart_id"+rowid).val(ui.item.key);
				//		  JQ("#ThaiName"+rowid).val(ui.item.value1);
				//		return false;
					  },
					  change: function( event, ui ) {
						var lenauto = availableTags.length;
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
						return false;
					  }
		});

	JQ(".clearrow").live('change',function(){
			if (this.value == ""){
				var str = this.id;
				var rowid = str.replace("AcChartCode","");
				JQ("#ac_chart_id"+rowid).val("");
				JQ("#ThaiName"+rowid).val("");
				JQ("#textDetail"+rowid).val("");
				JQ("#DrValue"+rowid).val("");
				JQ("#CrValue"+rowid).val("");
			}
	});
	JQ(".cal_dr").live('change',function(){
		var str = this.id;
		var rowid = str.replace("DrValue","");
		JQ("#CrValue"+rowid).val(0.00);
		if (JQ("#DrValue"+rowid).val() == ""){
			JQ("#DrValue"+rowid).val(0.00)
		}
		ansdr();
		anscr();
	});
	JQ(".cal_cr").live('change',function(){
		var str = this.id;
		var rowid = str.replace("CrValue","");
		JQ("#DrValue"+rowid).val(0.00);
		if (JQ("#CrValue"+rowid).val() == ""){
			JQ("#CrValue"+rowid).val(0.00)
		}
		ansdr();
		anscr();
	});


}
</script>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.iTd {	display:table-cell; /* กำหนดให้แสดงเหมือนแท็ก td หรือ th */
	border:1px solid #ffffff;
	padding:4;
	font-size: 14px;
}
.input_style {	font-family : "MS Sans Serif";
	font-size : 10px;
	border: 1px solid #cfcfcf;
	background-color: #ffffd5;
	style=" background-color:#ffffd5;
	border-bottom-color:#cfcfcf;
}
.input_style2{
	font-family : "MS Sans Serif";
	font-size : 10px;
	border: 1px solid #FFFFBB;
	background-color: #FFFFBB;
	style=" background-color:#FFFFBB;
	border-bottom-color:#cfcfcf;
}
.input_style1 {	font-family : "MS Sans Serif";
	font-size : 10px;
	border: 1px solid #cfcfcf;
	background-color: #d4d0c8;
	style=" background-color:#d4d0c8;
	border-bottom-color:#cfcfcf;
}
.style11 {color: #000000}
.style4 {color: #FFFFFF}
.iRow {	display:table-row; /* กำหนดให้แสดงเหมือนแท็ก tr */
	padding:40;
}
.iTable {	display:table; /* กำหนดให้แสดงเหมือนแท็ก table */
	width:1000px;
	margin:auto;
	border-collapse:collapse;
}
.input_style4 {	font-family : "MS Sans Serif";
	font-size : 10px;
	border: 1px solid #FFFFBB;
	background-color: #FFFFBB;
	style=" background-color:#FFFFBB;
	border-bottom-color:#cfcfcf;
	text-align:right;
}
.input_style3{
	font-family : "MS Sans Serif";
	font-size : 10px;
	border: 1px solid #0a246a;
	background-color: #d4d0c8;
	style=" background-color:#d4d0c8;
	border-bottom-color:#d4d0c8;
}
-->
</style>

<div class="sysinfo">
  <div class="sysname"><? if ($_REQUEST["id"] == ""){?>เพิ่มรายการ<? }else{?>แก้ไขรายการ<? }?><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไข<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input name="AcActionId" type="hidden"  id="AcActionId" value="<?php echo $AcActionId?>" />
<input name="IncomeId" type="hidden"  id="IncomeId" value="<?php echo $_REQUEST["id"]?>" />
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td background="../../../../images/bg.jpg" height="24"><span class="style9">&nbsp;&nbsp;<img src="../../../../images/a1.jpg" width="17" height="16" /> <span class="style1">F2-Balance</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="../../../../images/a2.jpg" width="14" height="15" /> <span class="style1">F3-Ins.Item</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../../../images/a3.jpg" width="14" height="15" /> <span class="style1">F4-Del.Item</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../../../images/a4.jpg" width="13" height="13" /> </span><span class="style1">F10-Save</span><span class="style9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../../../images/esc_s.png" width="16" height="16" /> </span><span class="style1">Esc-Exit</span></td>
  </tr>
  <tr>
    <td colspan="8" bgcolor="E6E6E6" height="5"></td>
    </tr>
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="4" class="tbl-view">
      <tr>
        <th width="13%" bgcolor="f5f2ed">PV . <span class="require">*</span> </th>
        <td width="30%" bgcolor="f5f2ed">
					<?php
					// if ($journalId == ""){
					// 	$journalId = $_REQUEST["jid"];
					// }
					$journalId = 1;// รายรับ
					if ($AcActionId==""){
						$mm = date(m);
						$yy = date(Y)+543;
						$PV = $get->findpvcode($yy,$mm,$journalId);
					}
					?>
					<?php if ($AcActionId==""){?>
          	<input id = "PV" name = "PV" type="text" value = "<?= $PV?>" />
					<?php }else{?>
						<input id = "PV" name = "PV" type="hidden" value = "<?= $PV?>" />
						<?php echo $PV;?>
					<?php }?>
					<input id = "tmp" name = "tmp" type="hidden" />

				 <input id = "MaxLine" name = "MaxLine" type="hidden" />
        </td>
        <th width="13%" bgcolor="f5f2ed">DD/MM/YR <span class="require">*</span></th>
        <td width="19%" bgcolor="f5f2ed">
        	<?php  // วันที่ลงบัญชี
			$ActionDate = date('Y-m-d');
			echo InputCalendar_text(array(
				'id'=> 'ActionDate',
				'name' => 'ActionDate',
				'value' => $ActionDate
			));
			?>
        </td>
        <td width="9%" bgcolor="f5f2ed">&nbsp;</td>
        <td width="16%" bgcolor="f5f2ed">&nbsp;</td>
      </tr>
      <tr>
        <th bgcolor="f5f2ed">Book <span class="require">*</span></th>
        <td bgcolor="f5f2ed">
					<?php
						$journalName = $get->findjournalName($journalId);
						echo $journalName;
					?>
            <input id = "journalId" name = "journalId" type="hidden" value ="<?=$journalId?>"/>
        </td>
        <th bgcolor="f5f2ed">Status <span class="require">*</span></th>
        <td bgcolor="f5f2ed"><span class="iTd style4">
          <select name="AcStatus" id="AcStatus">
            <option value="0" <? if ($AcStatus == "0"){?>selected="selected" <? }?>>Recored</option>
            <option value="1" <? if ($AcStatus == "1"){?>selected="selected" <? }?>>Post</option>
            <option value="2" <? if ($AcStatus == "2"){?>selected="selected" <? }?>>Close</option>
          </select>
        </span></td>
        <td bgcolor="f5f2ed">&nbsp;</td>
        <td bgcolor="f5f2ed">&nbsp;</td>
      </tr>
      <tr>
        <th bgcolor="f5f2ed">ได้รับเงินจาก <span class="require">*</span></th>
        <td bgcolor="f5f2ed">
        <?= $PayName?>

        </td>
        <th bgcolor="f5f2ed">&nbsp;</th>
        <td bgcolor="f5f2ed">&nbsp;</td>
        <td bgcolor="f5f2ed">&nbsp;</td>
        <td bgcolor="f5f2ed">&nbsp;</td>
      </tr>
     <!-- <tr>
        <th bgcolor="f5f2ed">Description <span class="require">*</span></th>
        <td colspan="5" bgcolor="f5f2ed">
       	 <textarea id="AcDescription" name="AcDescription" cols="150" rows="4" class="input_style"><?//=$AcDescription?></textarea>
        </td>
      </tr>-->
         <tr>
        <td colspan="6" bgcolor="f5f2ed">
            <fieldset>
            <legend><strong>รายละเอียดรายการ</strong></legend>
				<table width="100%" cellspacing="1" cellpadding="4" border="0">
				<tbody>
				<tr>
					<th align="center" bgcolor="#f5f2ed" style="width:150px">ประเภทรายรับ</th>
					<th align="center" bgcolor="#f5f2ed" style="width:120px"><?
					if ($IncomeType == 1){
						echo "เลขที่สัญญา";
					}elseif ($IncomeType == 2){
						echo "เลขที่ข้อตกลง";
					}else{
						echo "เลขที่บัญชี";
					}
					?></th>
					<th align="center" bgcolor="#f5f2ed" style="width:200px">ประเภทการรับเงิน</th>
					<th align="center" bgcolor="#f5f2ed">รายละเอียด</th>
					<th align="center" bgcolor="#f5f2ed" style="width:100px">จำนวนเงิน (บาท)</th>
				</tr>
				<tr>
					<td align="left" bgcolor="#FFFFE6"><?
					if ($IncomeType == 1){
						echo "เงินประกันสัญญา";
					}elseif ($IncomeType == 2){
						echo "คืนเงินข้อตกลง";
					}else{
						echo "ดอกเบี้ยรับ";
					}
					?></td>
					<td align="center" bgcolor="#FFFFE6"> <?
					if ($IncomeType == 1){
						echo $ContractId;
					}elseif ($IncomeType == 2){
						echo $AgreementId;
					}else{
						echo $InterestBookbankId;
					}
					?></td>
					<td align="left" bgcolor="#FFFFE6"><?
                    if ($ReceiveType == 1){
						echo "เงินสด";
					}else if ($ReceiveType == 2){
						echo "เงินโอน";
					}else if ($ReceiveType == 3){
						echo "เช็ค";
					}else if ($ReceiveType == 4){
						echo "พันธบัตร";
					}else if ($ReceiveType == 5){
						echo "หนังสือค้ำประกันธนาคาร(LG)";
					}
					?> <?
                    if ($ReceiveType == 1){

					}else if ($ReceiveType == 2){
						echo "ธนาคาร ".$BankId."<br>เลขที่บัญชี ".$BookbankId;
					}else if ($ReceiveType == 3){
						echo "เลขที่เช็ค ".$CheckNumber." "."<br>วันที่เช็ค ".$CheckDate;
					}else if ($ReceiveType == 4){
						echo "เลขที่ ".$BondNumber;
					}else if ($ReceiveType == 5){
						echo "ชื่อธนาคาร ".$GuaranteeBankId."<br>เลขที่ ".$GuaranteeNumber;
					}
					?></td>
					<td align="left" bgcolor="#FFFFE6"><?PHP
						echo $IncomeDetail;
					?>
					<br><textarea name="IncomeDetailAccount" id = "IncomeDetailAccount" cols="60" rows="2" maxlength="1000"><?=$IncomeDetailAccount?></textarea>
					</td>
					<td align="center" bgcolor="#FFFFE6" style = 'text-align: right;'> <? echo number_format($IncomeValue,2)?> </td>
				</tr>
				</tbody>
				</table>
             </fieldset>
        </td>
        </tr>

</table></td>
  </tr>
  <tr>
    <td>
    <div id ="div_account"></div>
    </td>
  </tr>
  <tr>
    <td><input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');" />
      <input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onclick="history.back(-1);" /></td>
  </tr>
</table>
</form>
</div>
<div id="detailView" style=" display:none"></div>
