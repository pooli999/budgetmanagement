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
<script language="javascript" type="text/javascript">

 JQ(function(){
 JQ("#div2").hide();
 JQ("input[name='c_type']").change(function(){
    if(JQ('#cash').is(':checked')){
		JQ("#div1").show();
		JQ("#div2").hide();
	}else{
		JQ("#div1").hide();
		JQ("#div2").show();
	}
});
 	//alert("a");
	
});

</script>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style3 {color: #FFFFFF; font-weight: bold; }
-->
</style>
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
<legend ><b>ฝากเงินสดและเช็ค</b></legend>
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td width="13%" bgcolor="E6E6E6">ประเภทการรับเงิน</td>
      <td width="87%"><input name="c_type" type="radio" id = "cash" value="radiobutton" checked="checked" />
        เงินสด
        <input name="c_type" id = "cheque" type="radio" value="radiobutton" />
เช็ค</td>
    </tr>
    <tr>
      <td bgcolor="E6E6E6">รายการรายรับ</td>
      <td>
	  <div id = "div1">
	  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="105" align="center" bgcolor="#AAAAAA"><span class="style3">รหัส</span></td>
    <td width="228" align="center" bgcolor="#AAAAAA"><span class="style1"><strong>ได้รับเงินจาก</strong></span></td>
    <td width="676" align="center" bgcolor="#AAAAAA"><span class="style1"><strong>ประเภทรายรับ</strong></span></td>
    <td width="128" align="center" bgcolor="#AAAAAA"><span class="style1"><strong>ประเภทการรับเงิน</strong></span></td>
    <td width="128" align="center" bgcolor="#AAAAAA"><span class="style1"><strong>จำนวนเงิน (บาท) </strong></span></td>
    <td width="80" align="center" bgcolor="#AAAAAA"><span class="style1"><strong>ปฏิบัติการ</strong></span></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC"><select name="select8">
      <option>-</option>
      <option value="3" selected="selected">0001</option>
      <option value="4">0002</option>
      <option value="5">0003</option>
      <option value="1">0004</option>
      <option value="2">0005</option>
        </select></td>
    <td align="center" bgcolor="#CCCCCC"><span class="left">นางพิมพ์ใจ นัยโกวิท</span></td>
    <td align="center" bgcolor="#CCCCCC"><span class="left">เงินประกันสัญญา</span></td>
    <td align="right" bgcolor="#CCCCCC">เงินสด</td>
    <td align="right" bgcolor="#CCCCCC"><span class="right">50,000</span></td>
    <td align="right" bgcolor="#CCCCCC"><a class="ico delete" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl1').remove(); CalSum(1); }" href="javascript:void(0);">ลบทิ้ง</a></td>
  </tr>
  <tr>
    <td align="center"><select name="select7">
      <option>-</option>
      <option value="3">0001</option>
      <option value="4" selected="selected">0002</option>
      <option value="5">0003</option>
      <option value="1">0004</option>
      <option value="2">0005</option>
        </select></td>
    <td align="center">คุณประภาพร ศรีมหาพรหม</td>
    <td align="center"><span class="left">คืนเงินข้อตกลง</span></td>
    <td align="right">เงินสด</td>
    <td align="right">10,000</td>
    <td align="right"><a class="ico delete" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl1').remove(); CalSum(1); }" href="javascript:void(0);">ลบทิ้ง</a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="3" align="right"><a class="ico add" onclick="AddItemCost();" href="javascript:void(0);">เพิ่มรายการ... </a></td>
    </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">จำนวนเงินรวม (บาท) </td>
    <td align="right">&nbsp;</td>
    <td align="right">60,000</td>
    <td align="right">&nbsp;</td>
  </tr>
		</table>
		</div>
		<div id = "div2">
	  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="105" align="center" bgcolor="#AAAAAA"><span class="style3">รหัส</span></td>
    <td width="228" align="center" bgcolor="#AAAAAA"><span class="style1"><strong>ได้รับเงินจาก</strong></span></td>
    <td width="676" align="center" bgcolor="#AAAAAA"><span class="style1"><strong>ประเภทรายรับ</strong></span></td>
    <td width="128" align="center" bgcolor="#AAAAAA"><span class="style1"><strong>ประเภทการรับเงิน</strong></span></td>
    <td width="128" align="center" bgcolor="#AAAAAA"><span class="style1"><strong>จำนวนเงิน (บาท) </strong></span></td>
    <td width="80" align="center" bgcolor="#AAAAAA"><span class="style1"><strong>ปฏิบัติการ</strong></span></td>
  </tr>
  <tr>
    <td align="center"><select name="select5">
      <option>-</option>
      <option value="3">0001</option>
      <option value="4">0002</option>
      <option value="5">0003</option>
      <option value="1" selected="selected">0004</option>
      <option value="2">0005</option>
        </select></td>
    <td align="center">นายสมศักดิ์ จิตรเอื้อตระกูล</td>
    <td align="center"><span class="left">คืนเงินข้อตกลง</span></td>
    <td align="right">เช็ค</td>
    <td align="right"><span class="right">50,000</span></td>
    <td align="right"><a class="ico delete" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl1').remove(); CalSum(1); }" href="javascript:void(0);">ลบทิ้ง</a></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC"><select name="select4">
      <option>-</option>
      <option value="3">0001</option>
      <option value="4">0002</option>
      <option value="5">0003</option>
      <option value="1">0004</option>
      <option value="2" selected="selected">0005</option>
                    </select></td>
    <td align="center" bgcolor="#CCCCCC">นายจรูญ กันชนะ</td>
    <td align="center" bgcolor="#CCCCCC"><span class="left">เงินประกันสัญญา</span></td>
    <td align="right" bgcolor="#CCCCCC">เช็ค</td>
    <td align="right" bgcolor="#CCCCCC"><span class="right">60,000</span></td>
    <td align="right" bgcolor="#CCCCCC"><a class="ico delete" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl1').remove(); CalSum(1); }" href="javascript:void(0);">ลบทิ้ง</a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="3" align="right"><a class="ico add" onclick="AddItemCost();" href="javascript:void(0);">เพิ่มรายการ... </a></td>
    </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">จำนวนเงินรวม (บาท) </td>
    <td align="right">&nbsp;</td>
    <td align="right">110,000</td>
    <td align="right">&nbsp;</td>
  </tr>
		</table>
		</div>
</p></td>
    </tr>
    <tr>
      <td bgcolor="E6E6E6">เลขที่บัญชี</td>
      <td><select name="select3">
        <option selected="selected">-</option>
        <option value="1">ออมทรัพย์</option>
        <option value="2">กระแสรายวัน</option>
      </select>
        /
        <select name="select2">
        <option selected="selected">-</option>
        <option value="1">1234-8775-47</option>
        <option value="2">7854-8524-77</option>
        <option value="3">4577-8585-82</option>
      </select></td>
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
