<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบการเงิน',
//		'link' => '?mod=budget.init.startup',
	),
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'เพิ่ม'.$MenuName
	),
));


?>
<script language="javascript" type="text/javascript">

/* <![CDATA[ */

function ValidateForm(f){
		if(JQ('#IncomeType').val() == '' || JQ('#PayName').val() == '' || JQ('#IncomeDetail').val() == '' || JQ('#IncomeValue').val() == '' || JQ('#ReceiveType').val() == ''){
			chk_a = false;
		}else{
			if (JQ('#IncomeType').val() == "1"){
				if (JQ('#ContractId').val() == '0'){
					chk_a = false;
					}else{
					chk_a = true;
				}
			}
			if (JQ('#IncomeType').val() == "2"){
				if (JQ('#AgreementId').val() == '0'){
					chk_a = false;
					}else{
					chk_a = true;
				}
			}
			if (JQ('#IncomeType').val() == "3"){
				if (JQ('#InterestBookbankId').val() == '0'){
					chk_a = false;
					}else{
					chk_a = true;
				}
			}
			if (JQ('#IncomeType').val() == "4"){
//				if (JQ('#InterestBookbankId').val() == '0'){
//					chk_a = false;
//					}else{
//					chk_a = true;
//				}
				chk_a = true;
			}
			if (JQ('#IncomeType').val() == "5"){
//				if (JQ('#InterestBookbankId').val() == '0'){
//					chk_a = false;
//					}else{
//					chk_a = true;
//				}
				chk_a = true;
			}
			if (JQ('#IncomeType').val() == "6"){
//				if (JQ('#InterestBookbankId').val() == '0'){
//					chk_a = false;
//					}else{
//					chk_a = true;
//				}
				chk_a = true;
			}
			if (JQ('#IncomeType').val() == "7"){
//				if (JQ('#InterestBookbankId').val() == '0'){
//					chk_a = false;
//					}else{
//					chk_a = true;
//				}
				chk_a = true;
			}
		}
		if(chk_a == false){
			jAlert('กรุณาระบุข้อมูลที่จำเป็น(ดาวแดง)','ระบบตรวจสอบข้อมูล',function(){
				//JQ('#BankName').focus();
			});
			return false;
		}

		return true;
}


function Save(f){
	if(ValidateForm(f)){	
		 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		 var redirec_url = '?mod=<?php echo LURL::dotPage($listPage);?>';
		 toSubmit(f,'save',action_url,redirec_url);
	}
}

/*function Confirm(f){
	if(ValidateForm(f)){		
		var firm_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		toConfirm(f,'confirm',firm_url);
	}
	
}*/
 

/*  ]]> */
JQ(function(){
	//$("#opta1").prop("checked", true);
	//alert($('input:radio[id=opta1]:checked').val());
	JQ(".find_ans").live('change',function(){  // 	หา id ตามประเภท
		getDetail1(JQ("#IncomeType").val(),this.value);
	});
	JQ("#IncomeDetail").live('change',function(){  // 	หา id ตามประเภท
		JQ("#IncomeDetailAccount").val(this.value);
	});
	JQ(".show_ele").hide();
	JQ("#tr_tranfer").hide();
	JQ("#tr_check").hide();
	JQ("#tr_bond").hide();
	JQ("#tr_gt").hide();

	JQ('input[name="opta"]').click(function() {
		change_opta();
	});
	chk_income_type();
	change_opta();
});
function change_opta(){
		JQ("#tr_tranfer").hide();
		JQ("#tr_check").hide();
		JQ("#tr_bond").hide();
		JQ("#tr_gt").hide();
		
		if(JQ('#opta1').is(':checked')){
			JQ("#ReceiveType").val("1");
		}else if(JQ('#opta2').is(':checked')){
			JQ("#tr_tranfer").show();
			JQ("#ReceiveType").val("2");
		}else if(JQ('#opta3').is(':checked')){
			JQ("#tr_check").show();
			JQ("#ReceiveType").val("3");
		}else if(JQ('#opta4').is(':checked')){
			JQ("#tr_gt").show();
			JQ("#ReceiveType").val("4");
		}else if(JQ('#opta5').is(':checked')){
			JQ("#tr_bond").show();
			JQ("#ReceiveType").val("5");
		}
}
function chk_income_type(){
		JQ(".show_ele").hide();
		JQ(".a1").hide();
		JQ(".a2").hide();
		JQ(".a3").hide();
		JQ(".a4").hide();
		JQ(".a5").hide();
		JQ("#tr_itemid").show();
		if(JQ("#IncomeType").val() == "1"){
			JQ("#show_t1").show();
			JQ("#lbla").text("เลขที่สัญญา");
			JQ(".a1").show();
			JQ(".a3").show();
			JQ(".a4").show();
			JQ(".a5").show();
			JQ(".change_stye").addClass( "change_to_label" );
		}else if(JQ("#IncomeType").val() == "2"){
			JQ("#show_t2").show();
			JQ("#lbla").text("เลขที่ข้อตกลง");
			JQ(".a1").show();
			JQ(".a2").show();
			JQ(".a3").show();
			JQ(".change_stye").addClass( "change_to_label" );
		}else if(JQ("#IncomeType").val() == "3"){
			JQ("#opta1").attr("checked", true);
			JQ("#show_t3").show();
			JQ("#lbla").text("เลขที่บัญชี");
			JQ(".a1").show();
			JQ(".change_stye").removeClass( "change_to_label" );
		}else if(JQ("#IncomeType").val() == "4"){
			alert("เงินยืม");
			JQ("#lbla").text("เลขที่ สช.น.");
			JQ("#show_t4").show();
			JQ(".a1").show();
			JQ(".a2").show();
			JQ(".a3").show();
		}else if(JQ("#IncomeType").val() == "5" || JQ("#IncomeType").val() == "6" || JQ("#IncomeType").val() == "7" || JQ("#IncomeType").val() == "0"){
			JQ("#tr_itemid").hide();
			JQ(".change_stye").removeClass( "change_to_label" );
			JQ(".a1").show();
			JQ(".a2").show();
			JQ(".a3").show();
		}
		change_opta();
}
function getDetail1(IncomeType,id){
	fid = "";
	if(IncomeType==1){
		fid = JQ("#ContractId").val();
	}
	if(IncomeType==2){
		fid = JQ("#AgreementId").val();
	}
	if(IncomeType==3){
		fid = JQ("#InterestBookbankId").val();
	}
	if(IncomeType==4){
		fid = JQ("#DocCode").val();
	}
	if(fid!=""){
	var param = '&action=detail1&IncomeType=' + IncomeType +'&id=' + fid;
	JQ.ajax({
		type: "POST",
		url: '?mod=<?php echo LURL::dotPage($actionPage);?>',
		data: param,
		success: function(res){ 
			var str = res;
			var ans1 = str.split("|||");
				if (ans1[0] != ""){
					JQ("#Topic").text("("+ans1[0]+")");
				}else{
					JQ("#Topic").text("");
				}
			 JQ("#PayName").val(ans1[1]);
			 JQ("#IncomeValue").val(ans1[2]);
		}
	});
	}else{
		JQ("#Topic").text("");
	}
}

</script>
<style type="text/css">
<!--
.change_to_label {
	background-color:#F4F4F4;
	border:none;
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
<input name="IncomeId" type="hidden"  id="Id" value="<?php echo $_REQUEST['id'];?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
  <th>ประเภทรายรับ</th>
  <td class="require">*</td>
  <td><?php 
  		$tag_attribs = 'onchange="chk_income_type();" style="width:300px" class = "find_ans" ';
		echo $get->getIncomeType("IncomeType",$tag_attribs,$IncomeType,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?>
	  </td>
</tr>
<tr id="tr_itemid">
  <th><label id = "lbla"></label></th>
  <td class="require">*</td>
  <td><div id = "show_t1" class = "show_ele">
	<?php 
  		$tag_attribs = 'onchange="" style="width:300px" class = "find_ans" ';
		echo $get->getContractId("ContractId",$tag_attribs,$ContractId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></div>
	<div id = "show_t2" class = "show_ele">
	<?php 
  		$tag_attribs = 'onchange="" style="width:300px" class = "find_ans"';
		echo $get->getAgreementId("AgreementId",$tag_attribs,$AgreementId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></div>
	<div id = "show_t3" class = "show_ele">
	<?php 
  		$tag_attribs = 'onchange="" style="width:300px" class = "find_ans"';
		echo $get->getInterestBookbankId("InterestBookbankId",$tag_attribs,$InterestBookbankId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></div>
	<div id = "show_t4" class = "show_ele">
	<?php 
  		$tag_attribs = 'onchange="" style="width:300px" class = "find_ans"';
		echo $get->getDocCode("DocCode",$tag_attribs,$DocCode,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></div>
	<label id = "Topic"></label>	</td>
</tr>
<tr>
  <th>ได้รับเงินจาก</th>
  <td class="require">*</td>
  <td>
  <!--	<label id = "PayName"><?php// echo $PayName;?></label>-->
    <input name="PayName" type="text" id="PayName" value="<?php echo $PayName;?>" size="60" class = "change_stye"/></td>
</tr>
<tr>
  <th>อ้างอิงเอกสารที่</th>
  <td class="require">&nbsp;</td>
  <td><input name="ReferCode" type="text" id="ReferCode" value="<?php echo $ReferCode;?>" size="20" maxlength="20" /></td>
</tr>
<tr>
  <th>รายการ</th>
  <td class="require">*</td>
  <td><textarea name="IncomeDetail" cols="60" rows="2" id="IncomeDetail"><?php echo $IncomeDetail;?></textarea>
    <input name="IncomeDetailAccount" type="hidden" id="IncomeDetailAccount" value=""/></td>
</tr>
<tr>
  <th>จำนวนเงิน</th>
  <td class="require">*</td>
  <td>
<!--  <label id = "IncomeValue"><?php //echo number_format($IncomeValue,2);?></label>-->
  <input name="IncomeValue" type="text" class = "change_stye" id="IncomeValue" value="<?php echo $IncomeValue;?>" size="10" maxlength="15" />
  บาท</td>
</tr>
<tr>
  <th colspan="3" align="left">รายละเอียดการรับเงิน</th>
  </tr>
<tr>
  <th>ประเภทการรับเงิน    </th>
  <td class="require">*</td>
  <td>
 <input name="opta" class = "a1" type="radio" value="1" id = "opta1" <? if ($ReceiveType == "1"){?>checked="checked"<? }?>/><label class = "a1">เงินสด</label>
 <input name="opta" class = "a2" type="radio" value="2" id = "opta2" <? if ($ReceiveType == "2"){?>checked="checked"<? }?>/><label class = "a2">เงินโอน</label>
<input name="opta" class = "a3" type="radio" value="3" id = "opta3" <? if ($ReceiveType == "3"){?>checked="checked"<? }?>/><label class = "a3">เช็ค</label>
<input name="opta" class = "a4" type="radio" value="4" id = "opta4" <? if ($ReceiveType == "4"){?>checked="checked"<? }?>/><label class = "a4">พันธบัตร</label> 
<input name="opta" class = "a5" type="radio" value="5" id = "opta5" <? if ($ReceiveType == "5"){?>checked="checked"<? }?>/>
<label class = "a5">หนังสือค้ำประกันธนาคาร(LG)</label>
<input name="ReceiveType" type="hidden" id="ReceiveType" value="<?php echo $ReceiveType;?>"/></td>
</tr>
<tr id = "tr_tranfer">
  <th>&nbsp;</th>
  <td class="require">*</td>
  <td>ธนาคาร
    <?php 
  		$tag_attribs = 'onchange="" style="width:300px"';
		echo $get->getBankId("BankId",$tag_attribs,$BankId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?>
เลขที่บัญชี
<?php 
  		$tag_attribs = 'onchange="" style="width:300px"';
		echo $get->getBookbankId("BookbankId",$tag_attribs,$BookbankId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></td>
</tr>
<tr id = "tr_check">
<th >&nbsp;</th>
<td class="require">*</td>
<td>เลขที่เช็ค
  <input name="CheckNumber" type="text" id="CheckNumber" value="<?php echo $CheckNumber;?>" />
วันที่เช็ค
<?php  // ทำปฏิทิน
								$ApproveDate = date('Y-m-d');
								echo InputCalendar_text(array(
									'id'=> 'CheckDate',
									'name' => 'CheckDate',
									'value' => $CheckDate
								));
								?></td>
</tr>

<tr id = "tr_gt">
<th >&nbsp;</th>
<td class="require">*</td>
<td>
  เลขที่
  <input name="BondNumber" type="text" id="BondNumber" value="<?php echo $BondNumber;?>" /></td>
</tr>
<tr id = "tr_bond">
<th >&nbsp;</th>
<td class="require">*</td>
<td>ชื่อธนาคาร
  <?php 
  		$tag_attribs = 'onchange="" style="width:300px"';
		echo $get->getGuaranteeBankId("GuaranteeBankId",$tag_attribs,$GuaranteeBankId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?>
  เลขที่
  <input name="GuaranteeNumber" type="text" id="GuaranteeNumber" value="<?php echo $GuaranteeNumber;?>"/></td>
</tr>
 <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td>
<input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="history.back(-1);" /></td>
 </tr>
</table>
</form>
</div>
<div id="detailView" style=" display:none"></div>
