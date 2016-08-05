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
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'เพิ่มข้อมูล'.$MenuName
	),
));
?>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script language="javascript" type="text/javascript">
 JQ(function(){
 		JQ("#h_cash1").hide();
		JQ("input[name='ClearType']").change(function(){
			if(JQ('#cash1').is(':checked')){
				JQ("#h_cash1").hide();
			}else if(JQ('#cash2').is(':checked')){
				JQ("#h_cash1").show();
				JQ("#h_cash2").show();
				JQ("#h_cash3").hide();
			}else if(JQ('#cash3').is(':checked')){
				JQ("#h_cash1").show();
				JQ("#h_cash2").hide();
				JQ("#h_cash3").show();
			}
		});
		JQ("#div1").hide();
		JQ("#div2").hide();
		JQ("#type1").change(function(){
			if(JQ('#type1').val() == 1){
				JQ("#div1").show();
				JQ("#div2").hide();
			}else if(JQ('#type1').val() == 2){
				JQ("#div2").show();
				JQ("#div1").hide();
			}else{
				JQ("#div1").hide();
				JQ("#div2").hide();
			}
		});
		
		
//alert("a");

});
</script>>
<div class="sysinfo">
  <div class="sysname">เพิ่มรายการข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไขข้อมูล<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
  </tr>
</table>
<div id="import-box">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="PersonalId" id="PersonalId" value="<?php echo $_GET['id']?>" />
<fieldset  >
<legend ><b>ธนาคาร</b></legend>
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td width="13%" bgcolor="E6E6E6">ชื่อธนาคาร</td>
      <td width="87%"><input type="text" name="textfield" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><span style="text-align:center;">
        <input type="button" name="button42" id="button42" value="บันทึก" class="btnActive" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&amp;id=<?php echo $_REQUEST['id'];?>');" />
        &nbsp;
        <input name="cancel2" type="button" value="ยกเลิก" class="btn cancle" onclick="history.back(-1);" />
      </span></td>
      </tr>
  </table>
</fieldset>
</form>
</div>
