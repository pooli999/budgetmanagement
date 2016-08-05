<?php 
$ReportSheet = 'pay_word' ;
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => บันทึกตัดจ่ายงบประมาณ,
		'link' => '?mod=budgetpay.pay.main_pay'
	),
	array(
		'text' => 'แบบฟอร์มขออนุมัติเบิกจ่าย',
	)
));



function icoEdit($r){
	$label = 'บันทึกผล';
	global $appPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($appPage)."&id=".$r->DocCode."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoView($r){
	$label = $r->Topic;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&id=".$r->DocCode."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

function icoCancel($r){
	$label = 'ยกเลิก';
	global $cancelPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($cancelPage)."&id=".$r->DocCode."&start=".$_REQUEST["start"]."'",
		'ico cancel',
		$label,
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
	
	function ExportToWord(DocId){
		window.location = '?mod=front.eform.pagecenter.pagecenter_word_pay&format=raw&id='+DocId;	
	}

/* ]]> */
</script>
<script type="text/javascript" language="javascript" id="js">
/* <![CDATA[ */
JQ(document).ready(function() {
	
	JQ("table").tablesorter({
		headers: {
			0: {sorter: false},
			6: {sorter: false}
		}
	});
	
});
/* ]]> */
</script>



<div class="sysinfo">
<div class="sysname"><?php echo $MenuName;?></div>
<div class="sysdetail">แสดงรายการ<?php echo $MenuName;?></div>
</div>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td>
<!--       	<input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" />
        <input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();" />
-->
	</td>
    <td style="text-align:right;"><input type="button" value="  ย้อนกลับ  " class="btn" onclick="goPage('?mod=budgetpay.pay.main_pay&amp;BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>');" /></td>
  </table>


</div>




<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list tablesorter">
<thead>  
  <tr>
    <th style="text-align:center; width:40px">ลำดับ</th>
    <th style="text-align:center; width:100px">วันที่เอกสาร</th>	
    <th style="text-align:center; width:100px">เลขที่ สช.น</th>
    <th style="text-align:center;">ชื่อเรื่อง</th>
    <th style="text-align:center; width:130px">งบประมาณ (บาท)</th>
    <th style="text-align:center; width:100px">สถานะเอกสาร</th>
    <th colspan="2" style="text-align:center; width:75px">ปฏิบัติการ</th>
    </tr>
</thead>
<tbody>  
<?php
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	
	if($list["rows"]){
          foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?> 
  <tr>
    <td style="text-align:center; vertical-align:text-top"><?php echo $i; ?></td>
    <td style="text-align:center; vertical-align:text-top"><?php echo ShowDate($DocDate); ?></td>	
    <td style="text-align:left; vertical-align:text-top"><?php echo $DocCode;?></td>
    <td style="text-align:left; vertical-align:text-top"><?php echo icoView($r);?></td>
    <td style="text-align:right; vertical-align:text-top"><?php //echo number_format($get->getSumCost($DocCode,$PrjActCode,0,0),2); ?></td>
    <td style="text-align:left; vertical-align:text-top" nowrap="nowrap"><div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div></td>
    <td style="text-align:left; vertical-align:text-top; width:65px;"><?php /*if(in_array($DocStatusId,array(7))){*/ echo icoEdit($r);/* }*/ ?></td>
    <td style="text-align:left; vertical-align:text-top; width:65px;"><?php /*if(in_array($DocStatusId,array(10))){*/ echo icoCancel($r); /*}*/ ?></td>    
  </tr>
  
<?php

		$i++;
		}
	}else{
?>  
 <tr>
 <td colspan="9"><div class="nullDataList" style="color:#990000;">ไม่มีข้อมูล</div></td>
 </tr> 
<?php } ?> 
</tbody> 
</table>

<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>