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
<div>

</div>
<div id="formView" style="display:<?php echo 'none'?>">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="PersonalId" id="PersonalId" value="<?php echo $_GET['id']?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th width="150" height="25">ชื่อแผนงานกิจกรรมภาคี</th>
    <td width="8"><span class="require">*</span></td>
    <td colspan="4"><label for="select"></label>
      <input name="textfield" type="text" id="textfield" size="30" />
      (ภาษาไทย)</td>
    <td width="163" align="center" valign="top">
      
    </td>
  </tr>
  <tr>
    <th>ชื่อแผนงานกิจกรรมภาคี</th>
    <td class="require">*</td>
    <td colspan="5"><label for="textfield"></label>
      <input name="textfield" type="text" id="textfield" size="30" />
(ภาษาอังกฤษ)</td>
  </tr>
  <tr>
    <th>ประเภทแผนงานกิจกรรม</th>
    <td>&nbsp;</td>
    <td colspan="5"><label for="textarea">
      <select name="select" id="select">
        <option selected="selected">เกษตรกรรม</option>
        <option>เศรฐกิจ</option>
        <option>ความร่วมมือ</option>
      </select>
    </label></td>
  </tr>
  <tr>
    <th>วันเริ่มต้นแผนงานกิจกรรม</th>
    <td>&nbsp;</td>
    <td colspan="5"><?php 
echo InputCalendar(array(
'name' => 'begindate',
'value'=>'',
'size'=> 8 
)); 
?></td>
  </tr>
  <tr>
    <th>วันสิ้นสุดแผนงานกิจกรรม</th>
    <td>&nbsp;</td>
    <td colspan="5"><?php 
echo InputCalendar(array(
'name' => 'enddate',
'value'=>'',
'size'=> 8 
)); 
?></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td colspan="5"><input type="button" class="btn" name="button2" id="button2" value="คำนวน" /></td>
  </tr>
  <tr>
    <th>ระยะเวลาแผนงานกิจกรรม</th>
    <td>&nbsp;</td>
    <td colspan="5">30 วัน</td>
  </tr>
  <tr>
    <th>ที่มา</th>
    <td>&nbsp;</td>
    <td colspan="5"><select name="select" id="select">
      <option selected="selected">สช.</option>
      <option>สมาชิกภาคีนอก</option>
      </select> 
      &nbsp;โดย : 
      <input name="textfield" type="text" id="textfield" size="30" /></td>
  </tr>
  <tr>
    <th>ปีงบประมาณที่เริ่มต้น</th>
    <td>&nbsp;</td>
    <td colspan="5"><select name="select" id="select">
      <option></option>
      <option>2555</option>
      <option selected="selected">2554</option>
      <option>2553</option>
      <option>2552</option>
      <option>2551</option>
    </select></td>
  </tr>
  <tr>
    <th>หน่วยงานรับผิดชอบหลัก</th>
    <td>&nbsp;</td>
    <td colspan="5"><input name="textfield" type="text" id="textfield" size="30" /></td>
  </tr>
  <tr>
    <th valign="top">เอกสารแนบที่เกียวข้อง</th>
    <td>&nbsp;</td>
    <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th scope="col" style="width:5px; text-align:center">ลำดับ</th>
        <th scope="col">ชื่อเอกสาร</th>
        <th scope="col"  style="width:150px">ไฟลแนบ</th>
        <th scope="col" style="width:100px">ลบทิ้ง</th>
      </tr>
      <tr>
        <td align="center" style="text-align:center">1.</td>
        <td><input name="textfield" type="text" id="textfield" size="30" /></td>
        <td><label for="fileField"></label>
          <input type="file" name="fileField" id="fileField" /></td>
        <td><span class="ico delete"><a href="">ลบทิ้ง</a></span></td>
      </tr>
      <tr>
        <td align="center" style="text-align:center">2.</td>
        <td><input name="textfield" type="text" id="textfield" size="30" /></td>
        <td><input type="file" name="fileField" id="fileField" /></td>
        <td><span class="ico delete"><a href="">ลบทิ้ง</a></span></td>
      </tr>
      <tr>
        <td colspan="4" style="text-align:center"><input type="button" class="btnActive" name="button4" id="button4" value="เพิ่มรายการ" /></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <th>กำหนดผู้รับผิดชอบ</th>
    <td>&nbsp;</td>
    <td colspan="5">(กรุณาเลือก รายชื่อบุคคลที่รับผิดชอบแผนงานกิจกรรมภาคี)</td>
  </tr>
  <tr>
    <th>แหล่งที่มา</th>
    <td>&nbsp;</td>
    <td colspan="5"><select name="select" id="select">
      <option selected="selected">สช.</option>
      <option>สมาชิกภาคีนอก</option>
    </select></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td><select name="Fuel[]" id="Fuel" multiple="multiple" style="width:250px; height:180px;">
      <?php
foreach($arrfuel as $item){
foreach($item as $k=>$v){ ${$k} = $v; }
?>
      <option value="<?php echo $FuelId; ?>"><?php echo $get->getFuelName($FuelId); ?></option>
      <?php
}
?>
    </select></td>
    <td><p>
      <input type="button" name="button5" id="button5" value=">>" />
    </p>
      <p>
        <input type="button" name="button5" id="button5" value="&lt;&lt;" />
      </p></td>
    <td><select name="Fuel[]" id="Fuel" multiple="multiple" style="width:250px; height:180px;">
      <?php
foreach($arrfuel as $item){
foreach($item as $k=>$v){ ${$k} = $v; }
?>
      <option value="<?php echo $FuelId; ?>"><?php echo $get->getFuelName($FuelId); ?></option>
      <?php
}
?>
    </select></td>
    <td><p>
      <input type="button" name="button5" id="button5" value="&gt;&gt;" />
    </p>
      <p>
        <input type="button" name="button5" id="button5" value="&lt;&lt;" />
      </p></td>
    <td><select name="Fuel[]" id="Fuel" multiple="multiple" style="width:250px; height:180px;">
      <?php
foreach($arrfuel as $item){
foreach($item as $k=>$v){ ${$k} = $v; }
?>
      <option value="<?php echo $FuelId; ?>"><?php echo $get->getFuelName($FuelId); ?></option>
      <?php
}
?>
    </select></td>
  </tr>
  <tr>
    <th>รายละเอียดทั่วไป</th>
    <td>&nbsp;</td>
    <td colspan="5"><b>▪ หลักการและเหตุผล:</b></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td colspan="5"> <?php JFCKeditor::Create(array('ToolbarSets' => 'CustomBasicToolbar','name' => 'NewsInnerDetail_EN','id' => 'NewsInnerDetail_EN', 'value' => $bb));?>
</td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td colspan="5"><b>▪ วัตถุประสงค์ :</b></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td colspan="5"> <?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'NewsInnerDetail_EN','id' => 'NewsInnerDetail_EN', 'value' => $bb));?></td>
  </tr>
  <tr>
    <th>สถานะการใช้งาน</th>
    <td>&nbsp;</td>
    <td colspan="5"><input name="checkbox" type="checkbox" id="checkbox" checked="checked" />
      <label for="checkbox">เปิดใช้งาน</label></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <th width="150">&nbsp;</th>
    <td width="8">&nbsp;</td>
    <td colspan="5"><input type="button" class="btnActive" name="save" id="save" value="บันทึก" onclick="window.location='?mod=<?php echo lurl::dotPage($listPage)?>'"  />      <input type="button" name="button3" id="button3" value=" ยกเลิก " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
  </tr>
</table>

</form>
</div>
<div id="detailView" style=" display:none"></div>










