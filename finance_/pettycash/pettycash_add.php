  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
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


?>
<script language="javascript" type="text/javascript">

/* <![CDATA[ */

function ValidateForm(f){
	
		if(JQ('#AlertPettyCash').val() == '' || JQ('#MaxPettyCash').val() == ''){
			jAlert('กรุณาระบุขเอมูลที่จำเป็น(ดาวแดง)','ระบบตรวจสอบข้อมูล',function(){
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
JQ(function(){
    JQ( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 100000,
	 step: 1000,
      values: [ 10000, 90000 ],
      slide: function( event, ui ) {
		JQ( "#AlertPettyCash" ).val(ui.values[ 0 ]);
	 	 JQ( "#MaxPettyCash" ).val(ui.values[ 1 ]);
      }
    });
	  
  });
/*function Confirm(f){
	if(ValidateForm(f)){		
		var firm_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		toConfirm(f,'confirm',firm_url);
	}
	
}*/
 

/*  ]]> */

</script>
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
<input name="BookbankId" type="hidden"  id="Id" value="<?php echo $_REQUEST['id'];?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
  <th>&nbsp;</th>
  <td class="require">&nbsp;</td>
  <td>
	<table width="70%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3"><div id="slider-range"></div></td>
    </tr>
  <tr>
    <td  width="10%">0</td>
    <td width="90%"></td>
    <td width="10%" align="right">100,000</td>
  </tr>
</table></td>
</tr>
<tr>
  <th>จุดแจ้งเตือน</th>
  <td class="require">*</td>
  <td><input name="AlertPettyCash" type="text" id="AlertPettyCash" value="<?php echo $AlertPettyCash;?>" size="45" /></td>
</tr>
<tr>
<th>เพดานเงินสดย่อย</th>
<td class="require">*</td>
<td><input name="MaxPettyCash" type="text" id="MaxPettyCash" value="<?php echo $MaxPettyCash;?>" size="45" /></td>
</tr>
 <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td>
<input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="history.back(-1);" />    </td>
  </tr>
</table>
</form>
</div>
<div id="detailView" style=" display:none"></div>










