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
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'แก้ไข'.$MenuName
	),
));


?>
<script language="javascript" type="text/javascript">

/* <![CDATA[ */

function ValidateForm(f){
	
		if(JQ('#BankName').val() == '' || JQ('#BankName').val() == ' '){
			jAlert('กรุณาระบุชื่อธนาคาร','ระบบตรวจสอบข้อมูล',function(){
				JQ('#BankName').focus();
			});
			return false;
		}

		return true;
}


function Save(f){
	if(ValidateForm(f)){	
		JQ("[name='AcCode2[]'] option").attr('selected','selected');
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
function loadAC(){
	AcGroupId = JQ("#AcGroupId").val();
	AcSeriesId = JQ("#AcSeriesId").val();
	JQ.ajax({
		  type: "GET",
		  url: "?mod=<?php echo LURL::dotPage('bindincome_action');?>",		   
		  data: "action=loadac&AcGroupId="+AcGroupId+"&AcSeriesId="+AcSeriesId,
		  success: function(msg){
			JQ("#acNumber").html(msg);
		  }
	});
}
	JQ(document).ready(function(){
		
	  	var actionURL = "?mod=<?php echo LURL::dotPage($actionPage)?>";
		JQ("#AcGroupId").live('change',function(){
				JQ.post(actionURL,{action:'loadac',node:JQ(this).val(),AcSeriesId:JQ("#AcSeriesId").val()},function(callback){
					JQ("#acNumber").html(callback);
				})
		});
		JQ("#AcCode2").empty();
		<?php if($_GET["id"]!=""){?>
			JQ.ajax({
				type: "POST",
				async: false,
				url: "?mod=<?php echo LURL::dotPage('bindincome_action');?>",		   
				data: "action=getacdata&IncomeType=<?php echo $_GET["id"];?>",
				success: function(result3){
					if (result3.length > 0){
						for (list_d = 0;list_d < result3.length;list_d++){
							JQ("#AcCode2").append('<option value='+result3[list_d]["key"]+'>'+result3[list_d]["value"]+'</option>')
						}
					}
				},
				dataType: "json"
			});
		<?php }?>
	});
</script>
<div class="sysinfo">
  <div class="sysname"><? if ($_REQUEST["IncomeTypeAcId"] == ""){?>เพิ่มรายการ<? }else{?>แก้ไขรายการ<? }?><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไข<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&AcSeriesId=<?php echo $_REQUEST["AcSeriesId"];?>&AcSeriesName=<?php echo $_REQUEST["AcSeriesName"];?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input name="IncomeType" type="hidden"  id="IncomeType" value="<?php echo $_REQUEST['id'];?>" />
<input name="IncomeTypeAcId" type="hidden"  id="IncomeTypeAcId" value="<?php echo $_REQUEST['IncomeTypeAcId'];?>" />
<input name="AcSeriesId" type="hidden"  id="AcSeriesId" value="<?php echo $_REQUEST['AcSeriesId'];?>" />
<input name="AcSeriesName" type="hidden"  id="AcSeriesName" value="<?php echo $_REQUEST['AcSeriesName'];?>" />
<input name="IncomeType_Name" type="hidden"  id="IncomeType_Name" value="<?php echo $IncomeType_Name;?>" />
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
<th>ประเภทรายรับ</th>
<td class="require">*</td>
<td colspan="3"><?php echo $IncomeType_Name;?></td>
</tr>
<tr>
  <th>ชุดผังบัญชี</th>
  <td class="require">&nbsp;</td>
  <td colspan="3"><?php echo $_REQUEST['AcSeriesName'];?></td>
</tr>
<tr>
<th>หมวดบัญชี</th>
<td class="require">*</td>
<td colspan="3"><?php 
		if ($_REQUEST["IncomeTypeAcId"] == ""){
			$AcGroupId = "";
			$AcChartId = "";
		}
  		//$tag_attribs = 'onchange="loadAC();"';
		$tag_attribs = '';
		echo $get->getAccGroupSelect("AcGroupId",$tag_attribs,$AcGroupId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></td>
</tr>
<script type="text/javascript">
JQ(function(){
JQ("[name='AcCode[]'] ").live('dblclick',function(){   
	var numOp=JQ("[name='AcCode[]'] option:selected").length;   
	 if(numOp>0){   
		  for(i=0;i<numOp;i++){ 
				var Option = JQ("[name='AcCode[]'] option:selected").eq(i);  
				if(JQ("[name='AcCode2[]'] ").find("option[value='"+Option.val()+"']").size() < 1){
					
					var html = Option.html();
					html = html.replace("|--",'');
					html = html.replace(/&nbsp;/g,'');
					JQ("[name='AcCode2[]'] ")
					.prepend("<option value='"+Option.val()+"'>"+html+"</option>");
				}
				 //JQ("[name='CatGroupCode2[]'] ").find("option").attr('selected','selected');   
		  }   
		}   
	});   
JQ("[name=SelectAll] ").click(function(){
		JQ("[name='AcCode2[]'] option").attr('selected','selected');
	}); 
JQ("#left2right").click(function(){
		JQ("[name='AcCode[]'] ").trigger('dblclick');
});
JQ("#delRight").click(function(){

		JQ("[name='AcCode2[]'] option:selected").remove();
}); 
})
</script>
<tr>
<th valign="top">&nbsp;&nbsp;&nbsp;&nbsp;ผูกบัญชีย่อย Cr. </th>
<td class="require">*</td>
<td><div id="acNumber"><select name="AcCode[]" multiple="multiple" style="width: 320px; height: 280px;" id="AcCode[]"/>
  </select ></div></td><th scope="col" style="text-align:center"><p>
                                    <input type="button" name="left2right" id="left2right" value="เพิ่ม >>" />
                                  </p>
                                  <p>
                                    <input type="button" name="delRight" id="delRight" value="ลบ" />
                                  </p></th>
                                <td scope="col">
                                
                                <select name="AcCode2[]" id="AcCode2" multiple="multiple" style="width:320px; height:280px;">
                                  </select></td>
</tr>
 <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td colspan="3">
<input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="history.back(-1);" />    </td>
  </tr>
</table>
</form>
</div>
<div id="detailView" style=" display:none"></div>










