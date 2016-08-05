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
</script>
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
<legend ><b>รายรับ</b></legend>
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td width="13%" bgcolor="E6E6E6">ประเภทรายรับ</td>
      <td width="87%"><select name="type1" id="type1">
        <option selected="selected">-</option>
        <option value="1">เงินประกันสัญญา</option>
        <option value="2">คืนเงินข้อตกลง</option>
        <option value="3">ดอกเบี้ยรับ</option>
      </select>
	  <div id ="div1">
      เลขที่สัญญา
      <select name="select2">
        <option selected="selected">-</option>
        <option value="1">0001/2559</option>
        <option value="2">0001/2559</option>
        <option value="3">0001/2559</option>
            </select>
      (ชื่อสัญญา)	  </div>
	  <div id ="div2">
	   เลขที่ข้อตกลง 
      <select name="select2">
        <option selected="selected">-</option>
        <option value="1">0001/2559</option>
        <option value="2">0001/2559</option>
        <option value="3">0001/2559</option>
            </select>
      (ชื่อข้อตกลง )	  </div>	  </td>
    </tr>
    <tr>
      <td bgcolor="E6E6E6">ได้รับเงินจาก</td>
      <td><input type="text" name="textfield" /></td>
    </tr>
    <tr>
      <td bgcolor="E6E6E6">รายละเอียด</td>
      <td><textarea name="textfield2" cols="40" rows="4"></textarea></td>
    </tr>
    <tr>
      <td bgcolor="E6E6E6">จำนวนเงิน</td>
      <td><input type="text" name="textfield3" />
        บาท</td>
    </tr>
    <tr>
      <td height="23" colspan="2" valign="bottom" bgcolor="A6A5B3"><span class="style1">รายละเอียดการรับเงิน</span></td>
      </tr>
    <tr>
      <td bgcolor="E6E6E6">ประเภทการรับเงิน</td>
      <td>
	    <p>
	      <input name="ClearType" type="radio" value="radiobutton" id = "cash1" checked="checked"/>
	      เงินสด
	      <input name="ClearType" type="radio" value="radiobutton" id = "cash2"/>
	      เงินโอน/เช็ค
	      <input name="ClearType" type="radio" value="radiobutton" id = "cash3"/>
	      พันธบัตร
	    </p>
		  <div id = "h_cash1">
						<div id = "h_cash2">
							<p>ธนาคาร
						<select name="select4">
						<option selected="selected">-</option>
						<option value="1">กรุงเทพ</option>
						<option value="2">กรุงไทย</option>
						<option value="3">ออมสิน</option>
						</select>
						เลขที่บัญชี
						<select name="select5">
						<option selected="selected">-</option>
						<option value="1">1234-8775-47</option>
						<option value="2">7854-8524-77</option>
						<option value="3">4577-8585-82</option>
						</select>
						</div>
				
						<div id = "h_cash3">
					
						เลขที่เช็ค
						<input type="text" name="textfield323" />
						วันที่เช็ค
						<?php  // ทำปฏิทิน
								$ApproveDate = date('Y-m-d');
								echo InputCalendar_text(array(
									'id'=> 'ApproveDate',
									'name' => 'ApproveDate',
									'value' => $ApproveDate
								));
								?>
						</div>
		</div>
</p></td>
    </tr>
    <tr>
      <td bgcolor="E6E6E6">&nbsp;</td>
      <td><input type="checkbox" name="checkbox" value="checkbox" />
        ออกใบเสร็จ</td>
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
