<?php 
$ReportSheet = 'transfer_word' ;
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => 'ทะเบียนคุม เลขที่ สช.น. ',
	)
));


function icoEdit($r){
	$label = 'โอนงบ';
	global $appPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($appPage)."&id=".$r->DocCode."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoView($r){
	if($r->FormCode == "FF005"){ $MainTopic = "ขออนุมัติจัดประชุม หัวข้อ"; }else if($r->FormCode == "FF006"){ $MainTopic = "ขออนุมัติเดินทางไปปฏิบัติงาน ณ "; }	

	$label = $MainTopic.$r->Topic;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&id=".$r->DocCode."&FormCode=".$r->FormCode."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

function icoCancel($r){
	$label = 'ยกเลิก';
	global $cancelPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($cancelPage)."&DocCode=".$r->DocCode."&start=".$_REQUEST["start"]."'",
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

/* ]]> */
	function loadSCT(BgtYear){
		window.location.href='?mod=<?php echo LURL::dotPage($listPage)?>&BgtYear='+BgtYear;
	}

	function loadExternalType(ExType){
		var BgtYear 	= document.getElementById("BgtYear").value;
		window.location.href='?mod=<?php echo LURL::dotPage($listPage)?>&BgtYear='+BgtYear+'&ExType='+ExType+'#History';
	}

	function loadPage(SourceExId){
		var BgtYear 	= document.getElementById("BgtYear").value;
		var ExType 	= document.getElementById("ExType").value;
		window.location.href='?mod=<?php echo LURL::dotPage($listPage)?>&BgtYear='+BgtYear+'&ExType='+ExType+'&SourceExId='+SourceExId+'#History';
	}

</script>
<script type="text/javascript" language="javascript" id="js">
/* <![CDATA[ */
JQ(document).ready(function() {
	
	/*JQ("table").tablesorter({
		headers: {
			0: {sorter: false},
			5: {sorter: false}
		}
	});*/
	
});
/* ]]> */
</script>



<div class="sysinfo">
<div class="sysname"><?php echo $MenuName;?></div>
<div class="sysdetail">แสดงรายการ<?php echo $MenuName;?></div>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#eeebac;">
  <tr>
    <td style="padding:5px;">
<!--    <a href="javascript:void(0)" class="ico print">พิมพ์เอกสาร</a>
    <a href="javascript:void(0)" class="ico excel">ส่งออกเป็น Excel</a>-->
    </td>
    <td style="text-align:right;">
    ปีงบประมาณ <?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?> 
    </td>
  </tr>
</table>







<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list" style="margin-top:0px;">
  <thead>  
  <tr>
    <th style="text-align:center; width:40px">ลำดับ</th>
    <th style="text-align:center; width:100px">เลขที่ สช.น</th>
    <th style="text-align:center; width:100px">วันที่เอกสาร</th>	
    <th style="text-align:center;">ชื่อเรื่อง</th>
    <th style="text-align:center; width:130px">งบประมาณ (บาท)</th>
    <th style="text-align:center; width:150px">เจ้าของเรื่อง</th>
    <th style="text-align:center; width:110px">สถานะเอกสาร</th>
    </tr>
</thead>
<tbody>  
<?php
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	//ltxt::print_r($list["rows"]);
	if($list['total'] > 0){
          foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?> 
  <tr>
    <td style="text-align:center; vertical-align:text-top"><?php echo $i; ?></td>
    <td style="text-align:center; vertical-align:text-top"><?php echo $DocCode;?></td>
    <td style="text-align:center; vertical-align:text-top"><?php echo ShowDate($DocDate); ?></td>	
    <td style="text-align:left; vertical-align:text-top"><?php if($DocStatusId == 13){ echo $Topic; }else{ echo icoView($r); } ?></td>
    <td style="text-align:right; vertical-align:text-top"><?php echo number_format($Budget,2);?></td>
    <td style="text-align:left; vertical-align:text-top"><?php echo fn_getFullNameByPersonalCode($RQPersonalCode);?></td>
    <td style="text-align:left; vertical-align:text-top" nowrap="nowrap"><div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div></td>
    </tr>
  
<?php

		$i++;
		}
	}else{
?>  
 <tr>
 <td colspan="8"><div class="nullDataList" style="color:#990000;">ไม่มีข้อมูล</div></td>
 </tr> 
<?php } ?> 
</tbody> 
</table>

<?php if($list['total'] > 0){ ?>
<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>
<?php } ?>