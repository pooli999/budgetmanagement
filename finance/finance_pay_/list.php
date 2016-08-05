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
	),
));

function icoActive($r){
	$label = 'เปิดใช้งาน';
	$label2 = '&nbsp;';
	global $listPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($listPage)."&id=".$r->PersonalId."'",					'ico enabled',
		$label,
		$label
	));
}

function icoEdit($r){
	$label = 'แก้ไข';
	$label2 = '&nbsp;';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->PersonalId."'",					'ico edit',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบ';
	$label2 = '&nbsp;';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&PersonalId=".$r->PersonalId."')",
		'ico delete',		$label,
		$label
	));
}


?>

<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	
	function Search(){
		var tsearch=JQ('#tsearch').val();
		window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&tsearch="+ tsearch;
	}
	
	JQ(document).ready(function(){

	});

/* ]]> */
</script>
<style type="text/css">
<!--
.style2 {color: #000000; font-weight: bold; }
-->
</style>


<div class="sysinfo">
  <div class="sysname">จัดการข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>
<div class="boxfilter" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td width="50%"><input type="button" name="button" id="button" value="รีเฟรช" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
      <td width="50%" align="right"><b>ชื่อ : </b>
        <label for="select"></label>
        
		<select name="">
		  <option selected="selected">ทั้งหมด</option>
		  <option>นางพิมพ์ใจ นัยโกวิท</option>
		  <option>คุณประภาพร ศรีมหาพรหม</option>
		  <option>นายประดิษฐ์ นิจไตรรัตน์</option>
		</select>
		
		        <input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').slideToggle();" /></td>
    </tr>
  </table>
</div>
<form name="searchForm" id="SearchForm" method="post">
<div id="boxSearch" class="boxsearch" style="display:<?php echo 'none';?>">
  <table width="60%" border="0" align="center" cellpadding="0" cellspacing="5" >
    <tr>
      <td width="15%" align="left"><strong>คำค้น : </strong></td>
      <td width="40" colspan="3"><input name="tsearch" id="tsearch" type="text" class="input-search" size="30" value="<?php echo $_REQUEST['tsearch']?>" />
        <input id="search2" name="search2" type="button" value="  ค้นหา  " class="btnActive"   onclick="Search();" />
        <input type="button" name="button5" id="button2" class="btn" value=" ยกเลิก " onclick="JQ('#boxSearch').slideToggle();" /></td>
    </tr>
  </table>
  
</div></form>
<div class="cms-box-search">

  <?php if($_REQUEST['tsearch']){?>
ผลการค้นหา <span style="color:#FF6600; font-weight:bold;">&quot;<?php echo $_REQUEST['tsearch'];?>&quot;</span> พบจำนวน <span style="color:#FF6600; font-weight:bold;"><?php echo $list['total'];?></span> รายการ 
<?php }?>
</div>
<script type="text/javascript" language="javascript" id="js">
/* <![CDATA[ */
JQ(document).ready(function() {
	JQ("table").tablesorter({
		headers: {
			0: {sorter: false},
			6: {sorter: false},
			7: {sorter: false}
		}
	});
	JQ("#btn_company").live('click',function(){  
		JQ( "#dialog-company" ).dialog( "open" );
	 })
	 JQ("#btn_info").live('click',function(){  
		JQ( "#dialog-info" ).dialog( "open" );
	 })
	 JQ("#btn_bank").live('click',function(){  
		JQ( "#dialog-bank" ).dialog( "open" );
	 })
	   JQ( "#dialog-company" ).dialog({
			  resizable: false,
			  autoOpen: false,
			  height:600,
			  width:900,
			  modal: true,
			  buttons: {
				"บันทึก": function() {
				  JQ( this ).dialog( "close" );
				},
				"ปิด": function() {
				  JQ( this ).dialog( "close" );
				}
			  }
		});
		JQ( "#dialog-info" ).dialog({
			  resizable: false,
			  autoOpen: false,
			  height:600,
			  width:800,
			  modal: true,
			  buttons: {
				"เพิ่ม": function() {
				  JQ( this ).dialog( "close" );
				},
				"ปิด": function() {
				  JQ( this ).dialog( "close" );
				}
			  }
		});
		JQ( "#dialog-bank" ).dialog({
			  resizable: false,
			  autoOpen: false,
			  height:300,
			  width:600,
			  modal: true,
			  buttons: {
				"เพิ่ม": function() {
				  JQ( this ).dialog( "close" );
				},
				"ปิด": function() {
				  JQ( this ).dialog( "close" );
				}
			  }
		});
 var availableTags = [
      "นาย มานะ แสนดี",
      "นาย ปิติ สุขใจ",
      "นาย สมปอง ใจหมาย",
      "นาย สมชาย ชาตรี"
    ];
    JQ( "#p_name" ).autocomplete({
      source: availableTags
    });
});

/* ]]> */
</script>

<table width="100%" border="0" class="tbl-list tablesorter"cellspacing="0">
<thead>
  <tr>
    <th  align="center" class="no" style="width:40px">รหัส</th>
    <th  align="center" style="width:150px;">รหัสเอกสาร</th>
    <th  align="center"style="width:150px;" >วันที่เอกสาร</th>
    <th  align="center" style="width:150px;">เลขที่ สช.น</th>
    <th  align="center" >ชื่อเรื่อง</th>
    <th align="center" style="width:150px;">จำนวนเงิน (บาท) </th>
    <th align="center"  width="" style="width:100px;">ปฏิบัติการ</th>
    </tr>
</thead>
<tbody>
<?php

?>
  <tr class="active-row">
    <td valign="top" class="center"><?php echo $i ;?>0091</td>
    <td align="left" valign="top" class="center">FF008</td>
    <td align="left" valign="top" class="center">8 ม.ค. 59 </td>
    <td align="left" valign="top" class="center">0015/2560</td>
    <td align="left" valign="top" class="left">แบบฟอร์มขออนุมัติึค่าเบี้ยประชุม</td>
    <td align="right" valign="top" class="right">50,000</td>
    <td align="center"  valign="top" nowrap="nowrap"  ><input name="checkbox" type="checkbox" value="checkbox" checked="checked" /></td>
  </tr>
  <tr class="active-row">
    <td height="22" valign="top" class="center">0092</td>
    <td align="left" valign="top" class="center">FF009</td>
    <td align="left" valign="top" class="center">1 ม.ค. 59</td>
    <td align="left" valign="top" class="center">0016/2560</td>
    <td align="left" valign="top" class="left">แบบฟอร์มขออนุมัติเบิกค่าเดินทาง</td>
    <td align="right" valign="top" class="right">12,000</td>
    <td align="center"  valign="top" nowrap="nowrap"  ><input name="checkbox2" type="checkbox" value="checkbox" checked="checked" /></td>
  </tr>
  <tr class="active-row">
    <td valign="top" class="center">0093</td>
    <td align="left" valign="top" class="center">FF008</td>
    <td align="left" valign="top" class="center">12 ม.ค. 59</td>
    <td align="left" valign="top" class="center">0017/2560</td>
    <td align="left" valign="top" class="left">แบบฟอร์มขออนุมัติค่าเบี้ยประชุม</td>
    <td align="right" valign="top" class="right">10,200</td>
    <td align="center"  valign="top" nowrap="nowrap"  ><input type="checkbox" name="checkbox3" value="checkbox" /></td>
  </tr>
<tr class="active-row">
    <td valign="top" class="center">&nbsp;</td>
    <td align="left" valign="top" class="center">&nbsp;</td>
    <td align="left" valign="top" class="center">&nbsp;</td>
    <td align="left" valign="top" class="center">&nbsp;</td>
    <td align="left" valign="top" class="left">&nbsp;</td>
    <td align="right" valign="top" class="right">&nbsp;</td>
    <td align="center"  valign="top" nowrap="nowrap"  ><input id="btn_company" name="search22" type="button" value="  จ่ายเงิน  " class="btnActive" /></td>
  </tr>
<?php if($i==1){?>
<?php } ?>
</tbody>
</table>
<div class="cms-box-navpage">
<?//php echo NavPage(array('total'=>4));?>
</div>
<br>
<table width="100%" border="0" class="tbl-list tablesorter"cellspacing="0">
<thead>
  <tr>
    <th  align="center" class="no" style="width:40px">รหัส</th>
    <th  align="center" style="width:150px;">PV</th>
    <th  align="center">เลขที่ สช.น </th>
    <th  align="center"style="width:150px;" >วันที่จ่ายเช็ค</th>
    <th align="center"  width="" style="width:100px;">ปฏิบัติการ</th>
    </tr>
</thead>
<tbody>
<?php

?>
  <tr class="active-row">
    <td valign="top" class="center"><?php echo $i ;?>12</td>
    <td  valign="top" class="center">&nbsp;</td>
    <td  valign="top" class="center">0015/2560,0016/2560</td>
    <td  valign="top" class="center">12 ม.ค. 59 </td>
    <td align="center"  valign="top" nowrap="nowrap"  ><?php echo icoEdit($r);?>&nbsp;<?php echo icoDelete($r);?></td>
  </tr>
  <tr class="active-row">
    <td height="22" valign="top" class="center">13</td>
    <td align="left" valign="top" class="center">&nbsp;</td>
    <td align="left" valign="top" class="center">0017/2560</td>
    <td align="left" valign="top" class="center">12 ม.ค. 59</td>
    <td align="center"  valign="top" nowrap="nowrap"  ><?php echo icoEdit($r);?>&nbsp;<?php echo icoDelete($r);?></td>
  </tr>
<?php if($i==1){?>
<?php } ?>
</tbody>
</table>
<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>4));?>
</div>


<div id="dialog-company"  title="จ่ายเงิน">
  <table width="100%" border="0" class="tbl-list tablesorter"cellspacing="0">
    <thead>
      <tr>
        <th  align="center" class="no" style="width:40px">รหัส</th>
        <th  align="center" style="width:150px;">รหัสเอกสาร</th>
        <th  align="center"style="width:150px;" >วันที่เอกสาร</th>
        <th  align="center" style="width:150px;">เลขที่ สช.น</th>
        <th  align="center" >ชื่อเรื่อง</th>
        <th align="center" style="width:150px;">จำนวนเงิน (บาท) </th>
      </tr>
    </thead>
    <tbody>
      <?php

?>
      <tr class="active-row">
        <td valign="top" class="center"><?php echo $i ;?>0091</td>
        <td align="left" valign="top" class="center">FF008</td>
        <td align="left" valign="top" class="center">8 ม.ค. 59 </td>
        <td align="left" valign="top" class="center">0015/2560</td>
        <td align="left" valign="top" class="left">แบบฟอร์มขออนุมัติึค่าเบี้ยประชุม</td>
        <td align="right" valign="top" class="right">50,000</td>
      </tr>
      <tr class="active-row">
        <td height="22" valign="top" class="center">0092</td>
        <td align="left" valign="top" class="center">FF009</td>
        <td align="left" valign="top" class="center">1 ม.ค. 59</td>
        <td align="left" valign="top" class="center">0016/2560</td>
        <td align="left" valign="top" class="left">แบบฟอร์มขออนุมัติเบิกค่าเดินทาง</td>
        <td align="right" valign="top" class="right">12,000</td>
      </tr>
      <tr class="active-row">
        <td height="22" valign="top" class="center">&nbsp;</td>
        <td align="left" valign="top" class="center">&nbsp;</td>
        <td align="left" valign="top" class="center">&nbsp;</td>
        <td align="left" valign="top" class="center">&nbsp;</td>
        <td  valign="top" class="right">จำนวนเงินรวม</td>
        <td align="right" valign="top" class="right">62,000</td>
      </tr>

      <?php if($i==1){?>
      <?php } ?>
    </tbody>
  </table>
  <br>
  <input id="btn_info" name="search23" type="button" value="เพิ่มบริษัท" class="btnActive"  />
  <br>
  <table width="100%" border="0" class="tbl-list tablesorter" cellspacing="0">
    <thead>
      <tr>
        <th  align="center" class="no" style="width:40px">ลำดับ</th>
        <th  align="center" style="width:200px;">ชื่อผู้รับเงิน</th>
		 <th  align="center" style="width:150px;">เลขประจำตัวผู้เสียภาษี</th>
        <th  align="center">ที่อยู่</th>
        <th align="center" style="width:150px;">จำนวนเงิน (บาท) </th>
      </tr>
    </thead>
    <tbody>
      <?php

?>
      <tr class="active-row">
        <td valign="top" class="center"><?php echo $i ;?>1</td>
        <td align="left" valign="top" class="center">FF008</td>
        <td align="left" valign="top" class="center">8 ม.ค. 59 </td>
        <td align="left" valign="top" class="center">0015/2560</td>
        <td align="right" valign="top" class="right">50,000</td>
      </tr>
      <tr class="active-row">
        <td height="22" valign="top" class="center">2</td>
        <td align="left" valign="top" class="center">FF009</td>
        <td align="left" valign="top" class="center">1 ม.ค. 59</td>
        <td align="left" valign="top" class="center">0016/2560</td>
        <td align="right" valign="top" class="right">12,000</td>
      </tr>
      <tr class="active-row">
        <td height="22" valign="top" class="center">&nbsp;</td>
        <td align="left" valign="top" class="center">&nbsp;</td>
        <td align="left" valign="top" class="center">&nbsp;</td>
        <td  valign="top" class="right">จำนวนเงินรวม</td>
        <td align="right" valign="top" class="right">62,000</td>
      </tr>
      <?php if($i==1){?>
      <?php } ?>
    </tbody>
  </table>
</div>


<div id="dialog-info"  title="รายละเอียดการจ่ายเงิน">
  <table width="100%" border="0" cellspacing="0" class="tbl-list tablesorter">
  	 <tr>
        <td class="left">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list tablesorter">
			  <tr>
			    <td height="30" colspan="4" bgcolor="#999999" class="style2">จ่าย</td>
		      </tr>
			  <tr>
				<td width="11%">ชื่อผู้รับเงิน</td>
				<td width="35%"><input name="p_name" type="text" id="p_name" value="" size="30" class="input-search" /></td>
			    <td width="16%">เลขประจำตัวผู้เสียภาษี</td>
			    <td width="38%"><input name="Input3" type="text" /></td>
			  </tr>
			  <tr>
				<td>ที่อยู่</td>
				<td><textarea name="Input" cols="40" rows="4"></textarea></td>
			    <td>ภาษีมูลค่าเพิ่ม</td>
			    <td><select name="select">
			        <option selected="selected">7</option>
			        <option>10</option>
		          </select>
			      %</td>
			  </tr>
	    </table>		</td>
    </tr>
  	 <tr class="active-row">
  	   <td class="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td height="30" colspan="2" bgcolor="#999999" style="color:#CCCCCC"><span class="style2">วิธีการจ่ายชำระเงิน</span></td>
         </tr>
         <tr>
           <td width="21%">ภาษีหัก ณ ที่จ่าย</td>
           <td><input name="Input2" type="text" size="5" maxlength="5" />
           %</td>
          </tr>

         <tr>
           <td>เงินสด</td>
           <td align="left"><input name="Input22" type="text" />
           บาท</td>
         </tr>
         <tr>
           <td>เงินโอน/เช็ค </td>
           <td align="right"><input id="btn_bank" name="search232" type="button" value="เพิ่มข้อมูล เงินโอน/เช็ค" class="btnActive" /></td>
         </tr>
         <tr>
           <td colspan="2"><table width="100%" border="0" cellspacing="0">
               <thead>
                 <tr>
                   <th  align="center" class="no" style="width:40px">ลำดับ</th>
                   <th  align="center" style="width:200px;">รูปแบบการจ่ายเงิน</th>
                   <th  align="center" style="width:200px;">ธนาคาร</th>
                   <th  align="center">Payment<br />
                     Number</th>
                   <th  align="center"style="width:150px;" >จำนวนเงิน<br />
                     (บาท)</th>
                   <th align="center"  width="" style="width:100px;">ปฏิบัติการ</th>
                 </tr>
               </thead>
               <tbody>
                 <?php

?>
                 <tr class="active-row">
                   <td valign="top" class="center"><?php echo $i ;?>12</td>
                   <td  valign="top" class="center">เช็ค</td>
                   <td  valign="top" class="center">ธ.กรุงไทย 059-0-99819-7 </td>
                   <td  valign="top" class="center">60670464</td>
                   <td  valign="top" class="center">30,000</td>
                   <td align="center"  valign="top" nowrap="nowrap"  ><?php echo icoEdit($r);?>&nbsp;<?php echo icoDelete($r);?></td>
                 </tr>
                 <tr class="active-row">
                   <td height="22" valign="top" class="center">13</td>
                   <td align="left" valign="top" class="center">เงินโอน</td>
                   <td align="left" valign="top" class="center">ธ.กรุงไทย 487-0-21549-7 </td>
                   <td align="left" valign="top" class="center">48545556</td>
                   <td align="left" valign="top" class="center">20,000</td>
                   <td align="center"  valign="top" nowrap="nowrap"  ><?php echo icoEdit($r);?>&nbsp;<?php echo icoDelete($r);?></td>
                 </tr>
                 <?php if($i==1){?>
                 <?php } ?>
               </tbody>
           </table></td>
         </tr>
       </table></td>
    </tr>
  </table>
</div>

<div id="dialog-bank"  title="เงินโอน/เช็ค">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list tablesorter">
    <tr>
      <td>รูปแบบการจ่ายเงิน</td>
      <td><input name="radiobutton" type="radio" value="radiobutton" />
        เงินโอน
          <input name="radiobutton" type="radio" value="radiobutton" />
          เช็ค</td>
    </tr>
    <tr>
      <td width="35%">ธนาคาร/เลขที่บัญชี</td>
      <td width="65%"><select name="select4">
          <option selected="selected">-</option>
          <option value="1">กรุงเทพ</option>
          <option value="2">กรุงไทย</option>
          <option value="3">ออมสิน</option>
        </select>
        /
        <select name="select5">
  <option selected="selected">-</option>
  <option value="1">1234-8775-47</option>
  <option value="2">7854-8524-77</option>
  <option value="3">4577-8585-82</option>
</select></td>
    </tr>
    <tr>
      <td>Payment Number /เลขที่เช็ค </td>
      <td><input name="Input32" type="text" /></td>
    </tr>
    <tr>
      <td>จำนวนเงิน</td>
      <td><input name="Input322" type="text" />
        บาท</td>
    </tr>
  </table>
</div>
