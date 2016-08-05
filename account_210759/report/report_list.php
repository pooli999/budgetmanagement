<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบการเงิน',
		'link' => '?mod=budget.init.startup',
	),
	
	array(
		'text' => $MenuName,
	),
));

function icoActive($r){
	global $actionPage;
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&BankId='.$r->BankId."&start=".$_REQUEST["start"].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}

function icoEdit($r){
	$label = 'แก้ไข';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->BankId."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoView($r){
	$label = $r->BankName;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&id=".$r->BankId."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&id=".$r->BankId."&start=".$_REQUEST["start"]."')",
		'ico delete',
		$label,
		$label
	));
}

/*function icoView($r){
	$label = 'ดูรายละเอียด';
	global $viewPage;
	vprintf('<a href="%s" onclick="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:void(0)",
		"toggleSub('".$r."')",
		'ico search',
		$label,
		$label
	));
}*/

?>

<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	
	function Search(){
		var tsearch=JQ('#tsearch').val();
		window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&tsearch="+ tsearch;
	}
	
	function toggleSub(id){
		JQ("a#icoClass_"+id).toggleClass("minimize");
		JQ("tr.hideRow_"+id).toggle();
	}
	
	function sortItem(){
	window.location.href='?mod=<?php echo lurl::dotPage($sortPage);?>';
	}

/* ]]> */
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูลdd<?php echo $MenuName;?></div>
</div>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td><!--<input type="button" name="button5" id="button5" value="  เรียงลำดับข้อมูล  " class="btnRed" onclick="goPage('?mod=<?php //echo lurl::dotPage($sortPage);?>');" />-->
        <input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();" />
      </td>

          <td align="right"></td>
    </tr>
  </table>
</div>
<form name="searchForm" id="SearchForm" method="post">
<div id="boxSearch" class="boxsearch" style="display:none;">
  <table  border="0" align="center" cellpadding="0" cellspacing="5" >
    <tr>
      <td  align="left"><strong>คำค้น : </strong></td>
      <td align="left"><input name="tsearch" id="tsearch" type="text" class="input-search" size="30" value="<?php echo $_REQUEST['tsearch']?>" />
        <input id="search2" name="search2" type="button" value="  ค้นหา  " class="btnRed"   onclick="Search();" />
        <input type="button" name="button5" id="button2" class="btn" value=" ยกเลิก " onclick="JQ('#boxSearch').hide();JQ('#boxFilter').show();" /></td>
    </tr>
  </table>
  
</div></form>
<div class="cms-box-search">

  <?php 
if($_REQUEST['tsearch']){?>
ผลการค้นหา <span style="color:#FF6600; font-weight:bold;">&quot;<?php echo $_REQUEST['tsearch'];?>&quot;</span> พบจำนวน <span style="color:#FF6600; font-weight:bold;"><?php echo $list['total'];?></span> รายการ 
<?php }?>
</div>
<script type="text/javascript" language="javascript" id="js">
/* <![CDATA[ */
JQ(document).ready(function() {
	
	JQ("table").tablesorter({
		headers: {
			0: {sorter: false},
			3: {sorter: false},
			4: {sorter: false}
		}
	});
	
});
/* ]]> */
</script>

<table width="100%" border="0" class="tbl-list tablesorter"  cellspacing="0">
<thead>
  <tr>
    <th class="no" style="width:10px">ลำดับ</th>
    <th align="left" >ชื่อรายงาน</th>
    <th align="center" style="width:95px;">พิมพ์</th>
    </tr>
</thead>
<tbody>
<?php
/*	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	
	if($list["rows"]){
          foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}*/
?>
  <!--<tr>
    <td valign="top" class="center" ><?php// echo $i ;?>.</td>
    <td valign="top" ><?php // echo icoView($r);?><?php //echo $BankName;?></td>
    <td align="center" valign="top" ><?php //echo icoActive($r);?></td>
    <td style="width:60px;" nowrap="nowrap" valign="top"  ><?php //echo icoEdit($r);?></td>
    <td style="width:60px;" valign="top"  nowrap="nowrap" ><?php //echo icoDelete($r);?></td>
  </tr>-->
 		  <tr >
   			<td class="center" style="width:10px">1</th>
            <td valign="top">พิมพ์รายวัน เรียงวันที่</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">2</th>
            <td valign="top">พิมพ์รายวัน เรียงวันที่ (ตาม Type ที่ระบุ)</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">3</th>
            <td valign="top">พิมพ์รายวัน เรียงวันที่มีรายละเอียดเอกสารประกอบ</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">4</th>
            <td valign="top">พิมพ์รายวัน เรียงวันที่มีรายละเอียดเอกสารประกอบแยกตามระบบงาน</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">5</th>
            <td valign="top">พิมพ์รายวัน เรียงวันที่ แบบสรุป</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">6</th>
            <td valign="top">พิมพ์รายวัน เรียงเลขที่</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">7</th>
            <td valign="top">พิมพ์รายวัน เรียงเลขที่มีรายละเอียดเอกสารประกอบแยกตามระบบงาน</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">8</th>
            <td valign="top">พิมพ์รายวัน เรียงเอกสารแบบสรุป</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">9</th>
            <td valign="top">พิมพ์บัญชีแยกประเภทตัว T</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">10</th>
            <td valign="top">พิมพ์บัญชีแยกประเภทแบบ 3 ช่อง</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">11</th>
            <td valign="top">พิมพ์บัญชีแยกประเภท ระบุฝ่ายแยกแต่ละแผนก</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">12</th>
            <td valign="top">พิมพ์รายการแยกประเภท</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">13</th>
            <td valign="top">พิมพ์สรุปยอดเคลื่อนไหวของแต่ละบัญชี</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">14</th>
            <td valign="top">พิมพ์รายการรายวันที่ไม่ดุล</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">15</th>
            <td valign="top">พิมพ์กระดาษทำการ</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">16</th>
            <td valign="top">รายงานรายวันเรียงวันที่ (บัญชีเป็นแนวคอลัมน์ Dr-Cr)</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">17</th>
            <td valign="top">พิมพ์รายการรายวันที่ยังไม่ POST</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">18</th>
            <td valign="top">พิมพ์งบทดลอง</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">19</th>
            <td valign="top">พิมพ์งบทดลอง แยกยอดเดบิต เครดิต</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">20</th>
            <td valign="top">สรุปยอดเคลื่อนไหวของบัญชีแต่ละแผนกในแนวคอลัมน์</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">21</th>
            <td valign="top">พิมพ์งบดุล</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
			<tr >
   			<td class="center" style="width:10px">22</th>
            <td valign="top">พิมพ์งบกำไร-ขาดทุน</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">23</th>
            <td valign="top">พิมพ์สรุปค่าใช้จ่าย</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">24</th>
            <td valign="top">พิมพ์งบดุลอย่างย่อ</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
   			<td class="center" style="width:10px">25</th>
            <td valign="top">พิมพ์งบกระแสเงินสดตามวิธีทางอ้อม</td>
			<td style="text-align:center;" >พิมพ์</td>
          </tr>
		  <tr >
		    <td class="center" style="width:10px">26          
		    <td valign="top">พิมพ์รายงานลูกหนี้</td>
		    <td style="text-align:center;" >พิมพ์</td>
    </tr>
		  <tr >
		    <td class="center" style="width:10px">27          
		    <td valign="top">พิมพ์รายงานเจ้าหนี้</td>
		    <td style="text-align:center;" >พิมพ์</td>
    </tr>
<?php

		/*$i++;
		}
	}*/
?>
</tbody>
</table>
<?php
if(!$list["rows"]){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>
<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>
          
