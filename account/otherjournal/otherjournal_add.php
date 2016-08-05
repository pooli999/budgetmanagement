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
function toFixed(num, pre){
    num *= Math.pow(10, pre);
    num = (Math.round(num, pre) + (((num - Math.round(num, pre))>=0.5)?1:0)) / Math.pow(10, pre);
    return num.toFixed(pre);
}
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
		});

		maxvdr = toFixed(maxvdr,2);
		maxvcr = toFixed(maxvcr,2);

		if (parseFloat(maxvdr) == parseFloat(maxvcr)){
				return true;
		}else{
			alert("จำนวนเงินDR ไม่เท่ากับ จำนวนเงินCR");
			return false;
		}

}
function ValidatePV(){
	//-----------------------------------------------
		var ans;
    JQ.ajax({
      type: "POST",
      async: false,
      url: "?mod=<?php echo LURL::dotPage('generaljournal_action');?>",
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
		var firm_url = '?mod=<?php //echo LURL::dotPage($actionPage);?>';
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



		//	JQ(".iRow").live('click',function(){
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

				PaymentListDetailId =JQ(this).attr("ass");// ค่าใช้จ่าย
				MaxLine=JQ("#MaxLine"+PaymentListDetailId).val(); // จำนวนมากสุด
				MaxLine--;// เพิ่มแถว
				//alert(idxlist_d);
				//alert(PaymentListDetailId);
				//alert(MaxLine);
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
					arr_ac_chart_id[debugii]=JQ("#ac_chart_id"+PaymentListDetailId+ii).val();
					arr_AcChartCode[debugii]=JQ("#AcChartCode"+PaymentListDetailId+ii).val();
					arr_ThaiName[debugii]=JQ("#ThaiName"+PaymentListDetailId+ii).val();
					arr_textDetail[debugii]=JQ("#textDetail"+PaymentListDetailId+ii).val();
					arr_DrValue[debugii]=JQ("#DrValue"+PaymentListDetailId+ii).val();
					arr_CrValue[debugii]=JQ("#CrValue"+PaymentListDetailId+ii).val();
				}
				//alert(ii);
				create_tblacc(PaymentListDetailId)
			}
			});

	/*		JQ(".findcode").live('change',function(){
				alert(this.value);
			});*/
			//loaddata(<?//=$AcActionId?>);
		JQ('.newrow').live('keydown', function(e) {

			if (e.keyCode == 13) {
				e.preventDefault();

			//	alert(JQ(this).val( JQ(this).attr("ass") ));
				//alert((this).attr("ass"));
				arr_ac_chart_id.length = 0;
				arr_AcChartCode.length = 0;
				arr_ThaiName.length = 0;
				arr_textDetail.length = 0;
				arr_DrValue.length = 0;
				arr_CrValue.length = 0;

				PaymentListDetailId =JQ(this).attr("ass");
				list_d=JQ("#MaxLine"+PaymentListDetailId).val();
				//alert(list_d);
				for (ii = 0;ii <= list_d;ii++){
				//	alert(ii);
					arr_ac_chart_id[ii]=JQ("#ac_chart_id"+PaymentListDetailId+ii).val();
					arr_AcChartCode[ii]=JQ("#AcChartCode"+PaymentListDetailId+ii).val();
					arr_ThaiName[ii]=JQ("#ThaiName"+PaymentListDetailId+ii).val();
					arr_textDetail[ii]=JQ("#textDetail"+PaymentListDetailId+ii).val();
					arr_DrValue[ii]=JQ("#DrValue"+PaymentListDetailId+ii).val();
					arr_CrValue[ii]=JQ("#CrValue"+PaymentListDetailId+ii).val();
				}
				//create_tblacc();
				create_tblacc(PaymentListDetailId);

			}// code enter
		});
	});
/* ]]> */
function loaddata(AcActionId,PaymentListDetailId,PaymentValue,AcActionId,addcr,TaxType){//TaxType : 1ภงด3 2ภงด53 addcr:เช็คแถวสุดทา้ยดึงรายการบัญชีเงินสด หรือธนาคาร
 // ---------ดึงข้อมูล ผูกบัญชีค่าใช้จ่าย-----------
	arr_ac_chart_id.length = 0;
	arr_AcChartCode.length = 0;
	arr_ThaiName.length = 0;
	arr_textDetail.length = 0;
	arr_DrValue.length = 0;
	arr_CrValue.length = 0;
	if (typeof(AcActionId) != "undefined"){
		AcActionId  = AcActionId;
	}else{
		AcActionId ="";
	}

	JQ.ajax({
	  type: "POST",
	  async: false,
	  url: "?mod=<?php echo LURL::dotPage('generaljournal_action');?>",
	  data: "action=findeaccount&PaymentValue="+PaymentValue+"&PaymentListDetailId="+PaymentListDetailId+"&AcActionId="+AcActionId+"&PaymentId=<?=$_REQUEST["id"]?>&addcr="+addcr+"&TaxType="+TaxType,
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
	create_tblacc(PaymentListDetailId,addcr);
}
function ansdr(PaymentListDetailId){
		// vdr = 0;
		// maxvdr = 0;
		// i=1
		// JQ('.cal_dr').each(function() {	// วนสร้าง ตามจำนวนที่เลือก
		// 	vdr = this.value
		// 	if (vdr == ""){
		// 		vdr = 0;
		// 	}
		// 	newPaymentListDetailId = JQ(this).attr("ass");
		// 	if (newPaymentListDetailId==PaymentListDetailId){
		// 		maxvdr = parseFloat(maxvdr)+parseFloat(vdr);
		// 	}
		// 	i++;
		// });
		// JQ("#lblmaxdr"+PaymentListDetailId).text(addCommas(maxvdr.toFixed(2)));
		vdr = 0;
		maxvdr = 0;
		i=1
		JQ('.cal_dr').each(function() {	// วนสร้าง ตามจำนวนที่เลือก
			vdr = this.value
			 	if (vdr == ""){
			 		vdr = 0;
			 	}
				maxvdr = parseFloat(maxvdr)+parseFloat(vdr);
			i++;
		});
		JQ("#lblmaxdr").text(addCommas(maxvdr.toFixed(2)));
}
function anscr(PaymentListDetailId){
	// vcr = 0;
	// maxvcr = 0;
	// JQ('.cal_cr').each(function() {	// วนสร้าง ตามจำนวนที่เลือก
	// 	vcr = this.value
	// 	if (vcr == ""){
	// 		vcr = 0;
	// 	}
	// 	newPaymentListDetailId = JQ(this).attr("ass");
	// //	alert("newPaymentListDetailId="+newPaymentListDetailId+"PaymentListDetailId"+PaymentListDetailId);
	// 	if (newPaymentListDetailId==PaymentListDetailId){
	// 		maxvcr = parseFloat(maxvcr)+parseFloat(vcr);
	// 	}
	//
	// });
	// JQ("#lblmaxcr"+PaymentListDetailId).text(addCommas(maxvcr.toFixed(2)));
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
function create_tblacc(PaymentListDetailId,addcr){ // สร้างตาราง แสดงรายการ
	//alert("a");
	str = '<table width="100%" border="0" align="left" cellpadding="4" cellspacing="1" >';
      str = str+'<tr background="../../../../images/bg.jpg">';
        str = str+'<th width="20" style="width:20px;" bgcolor = "f5f2ed" align="center" class = "iTd style4";bgcolor="808080"> No.</td>';
        str = str+'<th align="center" class = "iTd style4">Account</td>';
        //str = str+'<th width="250" align="center" class = "iTd style4">Account Name</td>';
        str = str+'<th width="150" style="width:150px;" align="center" class = "iTd style4">Detail</td>';
        str = str+'<th width="50" style="width:50px;" align="center" class = "iTd style4">Debit</td>';
        str = str+'<th width="50" style="width:50px;" align="center" class = "iTd style4">Credit</td>';
      str = str+'</tr>';
			 line =1;
			 max_dr = 0;
			 vdr = 0;
			 vcr = 0;
			 max_cr = 0;
				for (list_d = 0;list_d < arr_ac_chart_id.length;list_d++){
					  str = str+'<tr class="iRow" list_d = '+list_d+' ass="'+PaymentListDetailId+'" >';
						str = str+'<td height="25" bgcolor="#FFFFBB" align="center" class = "iTd" style="text-align:center;background-color:#FFFFBB;">'+line+'</td>';
						str = str+'<td align="left" bgcolor="#FFFFBB" class = "iTd" style="background-color:#FFFFBB;">';
							str = str+'<input name="ac_chart_id'+PaymentListDetailId+list_d+'" type="hidden" id = "ac_chart_id'+PaymentListDetailId+list_d+'" value="'+arr_ac_chart_id[list_d]+'" />';
							str = str+'<input name="AcChartCode'+PaymentListDetailId+list_d+'" type="text" id = "AcChartCode'+PaymentListDetailId+list_d+'" class="input_style2 findcode clearrow" value="'+arr_AcChartCode[list_d]+'" size="120"/>';
						str = str+'</td>';
						str = str+'<td align="center" bgcolor="#FFFFBB"class = "iTd" style="background-color:#FFFFBB;">';
							 str = str+'<textarea name="textDetail'+PaymentListDetailId+list_d+'" cols="30" rows="1" class="input_style2" id="textDetail'+PaymentListDetailId+list_d+'">'+arr_textDetail[list_d]+'</textarea>';
						str = str+'</td>';
						str = str+'<td align="right" bgcolor="#FFFFBB"class = "iTd" style="background-color:#FFFFBB;">';
						  str = str+'<input name="DrValue'+PaymentListDetailId+list_d+'" ass="'+PaymentListDetailId+'" type="text" id = "DrValue'+PaymentListDetailId+list_d+'" class="input_style4 cal_dr" value="'+arr_DrValue[list_d]+'" size="18" maxlength="18"/>';
						str = str+'</td>';
						str = str+'<td align="right" bgcolor="#FFFFBB"class = "iTd" style="background-color:#FFFFBB;">';
						  str = str+'<input name="CrValue'+PaymentListDetailId+list_d+'" ass="'+PaymentListDetailId+'" type="text" id = "CrValue'+PaymentListDetailId+list_d+'" class="input_style4 cal_cr" value="'+arr_CrValue[list_d]+'" size="18" maxlength="18"/>';
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
	str = str+'<td height="25" bgcolor="#FFFFBB" align="right" class = "iTd" style="text-align:center;background-color:#FFFFBB;">'+line+'</td>';
	str = str+'<td align="left" bgcolor="#FFFFBB" class = "iTd" style="background-color:#FFFFBB;">';
		str = str+'<input name="ac_chart_id'+PaymentListDetailId+list_d+'" type="hidden" id = "ac_chart_id'+PaymentListDetailId+list_d+'" value="" />';
		str = str+'<input name="AcChartCode'+PaymentListDetailId+list_d+'" type="text" id = "AcChartCode'+PaymentListDetailId+list_d+'" class="input_style2 findcode clearrow" value="" size="120"/>';
	str = str+'</td>';
	//str = str+'<td align="left" bgcolor="#FFFFBB"class = "iTd">';
	//	 str = str+'<input name="ThaiName'+PaymentListDetailId+list_d+'" type="text" id = "ThaiName'+PaymentListDetailId+list_d+'"  class="input_style2" value="" size="50"/>';
	//str = str+'</td>';
	str = str+'<td align="center" bgcolor="#FFFFBB"class = "iTd" style="background-color:#FFFFBB;">';
		 str = str+'<textarea name="textDetail'+PaymentListDetailId+list_d+'" cols="30" rows="1" class="input_style2" id="textDetail'+PaymentListDetailId+list_d+'"></textarea>';
	str = str+'</td>';
	str = str+'<td align="right" bgcolor="#FFFFBB"class = "iTd" style="background-color:#FFFFBB;">';
	  str = str+'<input name="DrValue'+PaymentListDetailId+list_d+'" ass="'+PaymentListDetailId+'" type="text" id = "DrValue'+PaymentListDetailId+list_d+'" class="input_style4 newrow cal_dr" value="0" size="18" maxlength="18"/>';
	str = str+'</td>';
	str = str+'<td align="right" bgcolor="#FFFFBB"class = "iTd" style="background-color:#FFFFBB;">';
	  str = str+'<input name="CrValue'+PaymentListDetailId+list_d+'" ass="'+PaymentListDetailId+'" type="text" id = "CrValue'+PaymentListDetailId+list_d+'" class="input_style4 newrow cal_cr" value="0" size="18" maxlength="18"/>';
		str = str+'<input id = "MaxLine'+PaymentListDetailId+'" name = "MaxLine'+PaymentListDetailId+'" type="hidden" value="'+list_d+'"/>';
   str = str+'</td>';
  str = str+'</tr>';
			if (addcr == "addcr"){
     		str = str+' <tr class="iRow">';
	        str = str+'<td height="40" colspan="3" style="text-align:right;" bgcolor="#FFFFFF" class = "iTd" >Total&nbsp;&nbsp;';
		//				str = str+'<input id = "MaxLine'+PaymentListDetailId+'" name = "MaxLine'+PaymentListDetailId+'" type="text" value="'+list_d+'"/>';
					str = str+'</td>';
	      //  str = str+'<td align="right" bgcolor="d4d0c8"class = "iTd" style="text-align:right;"><label id ="lblmaxdr'+PaymentListDetailId+'">'+addCommas(max_dr.toFixed(2))+'</label></td>';
				str = str+'<td align="right" bgcolor="d4d0c8"class = "iTd" style="text-align:right;"><label id ="lblmaxdr">'+addCommas(max_dr.toFixed(2))+'</label></td>';
	        str = str+'<td align="right" bgcolor="d4d0c8"class = "iTd" style="text-align:right;"><label id ="lblmaxcr">'+addCommas(max_cr.toFixed(2))+'</label></td>';
      	str = str+'</tr>';
			}

    str = str+'</table>';
	JQ("#div_account"+PaymentListDetailId).html(str);
	//JQ("#MaxLine"+PaymentListDetailId).val(list_d);
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
			  url: "?mod=<?php echo LURL::dotPage('generaljournal_action');?>",
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
						  JQ("#ThaiName"+rowid).val(ui.item.value1);
						//return false;
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

		PaymentListDetailId =JQ(this).attr("ass");
		var str = this.id;
		var rowid = str.replace("DrValue","");
		JQ("#CrValue"+rowid).val(0.00);
		if (JQ("#DrValue"+rowid).val() == ""){
			JQ("#DrValue"+rowid).val(0.00)
		}

		//ansdr(PaymentListDetailId);
		//anscr(PaymentListDetailId);
		ansdr();
		anscr();
	});
	JQ(".cal_cr").live('change',function(){
		PaymentListDetailId =JQ(this).attr("ass");
		var str = this.id;
		var rowid = str.replace("CrValue","");
		JQ("#DrValue"+rowid).val(0.00);
		if (JQ("#CrValue"+rowid).val() == ""){
			JQ("#CrValue"+rowid).val(0.00)
		}
		//ansdr(PaymentListDetailId);
		//anscr(PaymentListDetailId);
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
<input name="PaymentId" type="hidden"  id="PaymentId" value="<?php echo $_REQUEST["id"]?>" />
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
					if ($journalId == ""){
						$journalId = $_REQUEST["jid"];
					}
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
					<input id = "tmp" name = "tmp" type="hidden" /><!---->
						<!-- <input id = "findcode1" name = "findcode1" class = "findcode" type="hidden" value = "" /> -->
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
						$journalName = $get->findjournalName($_REQUEST["jid"]);
						echo $journalName;
					?>
          <input id = "journalId" name = "journalId" type="hidden" value ="<?=$_REQUEST["jid"]?>"/>
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
        <th bgcolor="f5f2ed">จ่ายให้ <span class="require">*</span></th>
        <td bgcolor="f5f2ed">
        <?PHP
		if ($PType =="1" ){
		$sql="SELECT CONCAT(IFNULL(nh_in_partner_prefix.PtnPrefixTH,''), IFNULL(nh_in_partner.PtnFname,''),' ',IFNULL(nh_in_partner.PtnSname,'')) as pname  FROM nh_in_partner left join nh_in_partner_prefix on nh_in_partner.PrefixUid=nh_in_partner_prefix.PrefixUid where PartnerCode='$PartnerCode' ";
		}else{
			$sql="SELECT CONCAT(IFNULL(tblpersonal_prefix.PrefixName,''), IFNULL(tblpersonal.FirstName,''),' ',IFNULL(tblpersonal.LastName,'')) as pname  FROM tblpersonal left join tblpersonal_prefix on tblpersonal.PrefixId= tblpersonal_prefix.PrefixId  where PersonalCode='$PartnerCode' ";
		}
		$result1 =mysql_query($sql);
		if ($row1 = mysql_fetch_array($result1)){
			$pname = $row1["pname"];
		}
		echo $pname;
		?>
        <input id = "PartnerCode" name = "PartnerCode" type="hidden" value = "<?= $PartnerCode?>" />
        </td>
        <th bgcolor="f5f2ed">&nbsp;</th>
        <td bgcolor="f5f2ed">&nbsp;</td>
        <td bgcolor="f5f2ed">&nbsp;</td>
        <td bgcolor="f5f2ed">&nbsp;</td>
      </tr>
		<tr>
 		 <td colspan="6" bgcolor="f5f2ed">
 		 <fieldset>
 		 <legend><strong>รายละเอียดการจ่ายเงิน</strong></legend>
 			 <table width="100%" border="0" cellspacing="1" cellpadding="4">
 							 <tr>
 										 <th bgcolor="f5f2ed">จ่ายเป็น</th>
 										 <td bgcolor="f5f2ed">
 											 <?

 												 if ($ChequeOrCash == "1"){

 						 if ($PaymentType == "1"){
 								 echo "เงินโอน";
 						 }else{
 								 echo "เช็ค";
 						 }
 					 }else{
 						 echo "เงินสด";
 					 }
 					 ?>
 											 <input id = "ChequeOrCash" name = "ChequeOrCash" type="hidden" value = "<?= $ChequeOrCash?>" />
 											 <input id = "PaymentType" name = "PaymentType" type="hidden" value = "<?= $PaymentType?>" />
									 	</td>
 										 <th bgcolor="f5f2ed">ธนาคาร</th>
 										 <td bgcolor="f5f2ed"><? echo $BankName?>
 										 <input id = "BankId" name = "BankId" type="hidden" value = "<?= $BankId?>" /></td>
 										 </tr>
 									 <tr>
 										 <th bgcolor="f5f2ed">เลขที่บัญชี</th>
 										 <td bgcolor="f5f2ed" width = 275><? echo $BookbankNumber?>
 										 <input id = "BookbankId" name = "BookbankId" type="hidden" value = "<?= $BookbankId?>" /></td>
 										 <th bgcolor="f5f2ed">เลขที่เช็ค</th>
 										 <td bgcolor="f5f2ed"><? echo $PaymentNumber?>
 										 <input id = "PaymentNumber" name = "PaymentNumber" type="hidden" value = "<?= $PaymentNumber?>" /></td>
 										 </tr>
 										<tr>
 										 <th bgcolor="f5f2ed">วันที่จ่ายเช็ค</th>
 										 <td bgcolor="f5f2ed"><? echo $ChequePayDate?>
 											<input id = "ChequePayDate" name = "ChequePayDate" type="hidden" value = "<?= $ChequePayDate?>" /></td>
 										 <th bgcolor="f5f2ed">จำนวนเงิน</th>
 										 <td bgcolor="f5f2ed">
											 		<?
 													 if ($PaymentValue == ""){
														$PaymentValue = $CashValue;
													 }
													?>
 											 <input id = "PaymentValue" name = "PaymentValue" type="hidden" value = "<?= $PaymentValue?>" />
 											 <input id = "CashValue" name = "CashValue" type="hidden" value = "<?= $PaymentValue?>" /> <?php echo number_format($PaymentValue,2)?> บาท </td>
 										 </tr>
 										<tr>
 										 <th bgcolor="f5f2ed">ภาษีหักมูลค่าเพิ่ม</th>
 										<td bgcolor="f5f2ed"><?=$Tax?><input id = "Tax" name = "Tax" type="hidden" value="<?=$Tax?>"/> %</td>
 										 <th bgcolor="f5f2ed">ภาษีหัก ณ ที่จ่าย <span class="require"></span></th>
 										 <td bgcolor="f5f2ed">
 											 <?php echo $CalTex ?> บาท
 											 <input id = "TaxW" name = "TaxW" type="hidden" value = "<?= $CalTex ?>" />
											 <?
											 	if ($TaxType == "1"){
													echo "(ภงด 3)";
												}else{
													echo "(ภงด 53)";
												}
											 ?>
 										 </td>
 										 </tr>
 					 </table>
 					</fieldset>
 		 </td>
 		 </tr>
      <tr>
        <td colspan="6" bgcolor="f5f2ed">
        <fieldset>
        <legend><strong>รายละเอียดรายการ</strong></legend>
        <?php
		$iall = 0;

		$List1 = $get->getDataList1($_REQUEST["id"]);//PaymentId
		$countrec = count($List1);
		if($List1["rows"]){
				  foreach($List1["rows"] as $r ) {
						foreach( $r as $k=>$v){ ${$k} = $v;}

		?>
        <fieldset>
            <legend>
            <strong>เลขที่ สช.น <?=$DocCode?> &nbsp;&nbsp;&nbsp;รหัสกิจกรรม <?=$PrjActCode?></strong>
            </legend>
        	<table width="100%" border="0" cellspacing="1" cellpadding="4">
                  <tr>
                    <th style="width:100px" align="center" bgcolor="#f5f2ed">ลำดับ</th>
                    <th style="width:250px" align="center" bgcolor="#f5f2ed">รายการ</th>
                    <th style="width:500px" align="center" bgcolor="#f5f2ed">คำอธิบาย</th>
                    <th style="width:120px" align="center" bgcolor="#f5f2ed">จำนวนเงิน (บาท)</th>
                  </tr>
                  <?php
				  	$ii = 1;
					$List2 = $get->getDataList2($PaymentListId,$formcode);
					if($List2["rows"]){
							  foreach($List2["rows"] as $r1 ) {
									foreach( $r1 as $k1=>$v1){ ${$k1} = $v1;}
					?>
                  <tr>
                    <td align="center" bgcolor="#FFFFE6">
                    	<?= $ii?>
                    </td>
                    <td bgcolor="#FFFFE6" align="left">
						<?=$CostName?>
                    </td>
                    <td bgcolor="#FFFFE6" align="left">
                    	<?=$DetailCostFinance?>
					<br>
						<input name="PaymentListDetailId<?=$iall?>" id="PaymentListDetailId<?=$iall?>" type="hidden" value="<?=$PaymentListDetailId?>" />
						<input name="CostItemCode<?=$iall?>" id="CostItemCode<?=$iall?>" type="hidden" value="<?=$CostItemCode?>" />
						<textarea name="DetailCostAccount<?=$iall?>" id = "DetailCostAccount<?=$iall?>" cols="60" rows="1" maxlength="500"><?=$DetailCostAccount?></textarea>
                    </td>
                    <td align="right" bgcolor="#FFFFE6">
						<?=$CastValue?>
                    </td>
										<tr>
											<td colspan="5">
													<div id ="div_account<?php echo $PaymentListDetailId;?>"></div>
													<?php
														$t1 = $countrec-1;
														if ($t1 == $iall){
															$ans1 = "addcr";
														}else{
															$ans1 = "";
														}
													?>
													<script>
														loaddata("<?php echo $PaymentId;?>","<?php echo $PaymentListDetailId;?>","<?php echo $PaymentValue?>","<?php echo $AcActionId;?>","<?php echo $ans1?>","<?php echo $TaxType?>");
													</script>
											</td>
										</tr>
                  </tr>
                  <?php
							$ii++;
							$iall++;
						}
					}
				?>
              </table>

              </fieldset>
            <?php
							$i++;
						}
					}
				?>
				<input name="countPL" id="countPL" type="hidden" value="<?=$iall-1?>" />
             </fieldset>
        </td>
      </tr>
</table>
</td>
  </tr>
  <tr>
    <td>
    <!-- <div id ="div_account"></div> -->
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
