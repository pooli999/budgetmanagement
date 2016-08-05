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
	function f_save(){
		var txt;
		var r = confirm("ต้องการเบิกทดแทนเงินสดย่อย ใช่หรือไม่");
		if (r == true) {
		//	txt = "You pressed OK!";
		} else {
		//	txt = "You pressed Cancel!";
		}
	}
/* ]]> */
</script>

<div class="sysinfo">
  <div class="sysname">จัดการข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>
<div class="boxfilter" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td width="50%"><!--<input type="button" name="button4" id="button4" value="เพิ่ม" class="btnActive" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>');" />-->
      <input type="button" name="button" id="button" value="รีเฟรช" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
      <td width="50%" align="right"><b>แสดงรายการที่ยังไม่คืน
          <select name="select">
            <option value="1" selected="selected">ใช่</option>
            <option value="2">ไม่ใช่</option>
            <option>ทั้งหมด</option>
            </select>
        วันที่ : </b>
        <label for="select"></label>
        
		<?php 
		//$ApproveDate = date('Y-m-d');
		$ApproveDate = "";
	  	echo InputCalendar_text(array(
			'id'=> 'ApproveDate',
			'name' => 'ApproveDate',
			'value' => $ApproveDate
		));
		echo $ApproveDate;
		?>   
		
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
});
/* ]]> */
</script>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="60%" align="right"><table width="500" border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="5" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="65%">&nbsp;</td>
              <td width="35%"><table width="100" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center">90,000</td>
                  </tr>
                  <tr>
                    <td align="center"><img src="../../../../images/point.jpg" alt="nh" width="15" height="18" /></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td width="31">&nbsp;</td>
        <td width="46" bgcolor="#FF7575">&nbsp;</td>
        <td width="354" bgcolor="#CAE4FF">&nbsp;</td>
        <td width="12" bgcolor="#93FF93">&nbsp;</td>
        <td width="57">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="6%">&nbsp;</td>
              <td width="6%">0</td>
              <td width="68%">10,000 </td>
              <td width="20%">100,000 บาท </td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="40%"><table border="0" cellspacing="2" cellpadding="4" >
      <tr>
        <td width="10" align="center"><img src="../../../../images/point.jpg" alt="nh" width="10" /></td>
        <td width="223">เงินสดย่อยคงเหลือ ( 90,000 บาท )</td>
        <td width="20" bgcolor="#CAE4FF">&nbsp;</td>
        <td width="251">เพดานเงินสดย่อย  ( 100,000 บาท )</td>
      </tr>
      <tr>
        <td align="center" bgcolor="#FF7575">&nbsp;</td>
        <td>จุดแจ้งเตือน ( 10,000 บาท )</td>
        <td bgcolor="#93FF93">&nbsp;</td>
        <td>ส่วนเกินเพดานเงินสดย่อย  ( 5,000 บาท )</td>
      </tr>

    </table></td>
  </tr>
</table>
<br>
<table width="100%" border="0" class="tbl-list tablesorter"cellspacing="0">
<thead>
  <tr>
    <th  align="center" class="no" style="width:20px">ลำดับ</th>
    <th  align="center" style="width:150px;">เลขที่ สช.น</th>
    <th  align="center">รายละเอียด</th>
    <th align="center" style="width:200px;">จำนวนเงิน (บาท) </th>
    <th  width="" align="center" style="width:100px;"><input id="btn_save" name="search22" type="button" value="  เบิกทดแทน  " class="btnActive"   onclick="f_save();" /></th>
    </tr>
</thead>
<tbody>
<?php

?>
  <tr class="active-row">
    <td valign="top" class="center"><?php echo $i ;?>1.</td>
    <td align="left" valign="top" class="left">15 ส.ค. 59 </td>
    <td align="left" valign="top" class="left">โครงการ : โครงการจัดสมัชชาสุขภาพแห่งชาติ<br />
เรื่อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 	ขออนุมัติเบิกจ่ายค่าใช้จ่าย1<br />
ชื่อผู้ปฏิบัติงาน : นางสาวทดสอบ </td>
    <td align="right" valign="top" class="right">2,400</td>
    <td align="center"  valign="top" nowrap="nowrap"  ><img src="../../../../images/tic_true.jpg" width="20" height="20" /></td>
    </tr>
  <tr class="active-row">
    <td valign="top" class="center">2.</td>
    <td align="left" valign="top" class="left">20 ส.ค. 59 </td>
    <td align="left" valign="top" class="left">โครงการ : โครงการจัดสมัชชาสุขภาพแห่งชาติ<br />
เรื่อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 	ขออนุมัติเบิกจ่ายค่าใช้จ่าย2<br />
ชื่อผู้ปฏิบัติงาน : นางสาวทดสอบ </td>
    <td align="right" valign="top" class="right">1,200</td>
    <td align="center"  valign="top" nowrap="nowrap"  ><img src="../../../../images/tic_true.jpg" width="20" height="20" /></td>
    </tr>
  <tr class="active-row">
    <td valign="top" class="center">3.</td>
    <td align="left" valign="top" class="left">25 ส.ค. 59 </td>
    <td align="left" valign="top" class="left">โครงการ : โครงการจัดสมัชชาสุขภาพแห่งชาติ<br />
เรื่อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 	ขออนุมัติเบิกจ่ายค่าใช้จ่าย3<br />
ชื่อผู้ปฏิบัติงาน : นางสาวทดสอบ </td>
    <td align="right" valign="top" class="right">1,000</td>
    <td align="center"  valign="top" nowrap="nowrap"  ><img src="../../../../images/tic_true.jpg" width="20" height="20" /></td>
    </tr>
  <tr class="active-row">
    <td valign="top" class="center">4.</td>
    <td align="left" valign="top" class="left">30 ส.ค. 59 </td>
    <td align="left" valign="top" class="left">โครงการ : โครงการจัดสมัชชาสุขภาพแห่งชาติ<br />
เรื่อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 	ขออนุมัติเบิกจ่ายค่าใช้จ่าย4<br />
ชื่อผู้ปฏิบัติงาน : นางสาวทดสอบ </td>
    <td align="right" valign="top" class="right">1,200</td>
    <td align="center"  valign="top" nowrap="nowrap"  ><input type="checkbox" name="checkbox22" value="checkbox" /></td>
    </tr>

<?php if($i==1){?>
<?php } ?>
</tbody>
</table>
<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>4));?>
</div>
          
