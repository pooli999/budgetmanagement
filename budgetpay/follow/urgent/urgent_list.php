<?php 
$ReportSheet = 'mat_word' ;
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => getMenuItem(lurl::dotPage($startupPage))->MenuName,
		'link' => '?mod='.lurl::dotPage($startupPage)
	),
	array(
		'text' => ติดตามการใช้จ่ายงบประมาณ,
		'link' => '?mod=budgetpay.follow.main_follow'
	),
	array(
		'text' => 'แบบฟอร์มเอกสารขออนุมัติจัดซื้อจัดจ้างและเบิกจ่าย(กรณีเร่งด่วน)',
	),	
));


function icoEdit($r){
	$label = 'แก้ไข';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->DocCode."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}


function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&id=".$r->DocId."&DocCode=".$r->DocCode."&start=".$_REQUEST["start"]."')",
		'ico delete',
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
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toCancel('?mod=".LURL::dotPage($actionPage)."&action=cancel&id=".$r->DocId."&DocCode=".$r->DocCode."&start=".$_REQUEST["start"]."')",
		'ico cancel',
		$label,
		$label
	));
}
?>


<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	
	function loadSCT(BgtYear){
			var PItemCode = JQ('#PItemCode').val();
			var PrjId = JQ('#PrjId').val();
	
			//แผนงาน
			JQ.ajax({
			   type: "POST",
			   url: "?mod=<?php echo LURL::dotPage('urgent_action');?>",		   
			   data: "action=pitemlistsearch&BgtYear="+BgtYear,
			   success: function(msg){
					JQ("#pitem").html(msg);
			   }
			});	
			
			//โครงการ
			JQ.ajax({
			   type: "POST",
			   url: "?mod=<?php echo LURL::dotPage('urgent_action');?>",		   
			   data: "action=projectlistsearch&PItemCode="+PItemCode+"&BgtYear="+BgtYear,
			   success: function(msg){
					JQ("#prj").html(msg);
			   }
			});	
			
			//กิจกรรม
			JQ.ajax({
			   type: "POST",
			   url: "?mod=<?php echo LURL::dotPage('urgent_action');?>",		   
			   data: "action=actlistsearch&PrjId="+PrjId+"&BgtYear="+BgtYear,
			   success: function(msg){
					JQ("#act").html(msg);
			   }
			});
														
	}	// end function 

	function loadPrj(PItemCode){
				var BgtYear = JQ('#BgtYear').val();
				
				//โครงการ
				JQ.ajax({
				   type: "POST",
				   url: "?mod=<?php echo LURL::dotPage('urgent_action');?>",		   
				   data: "action=projectlistsearch&PItemCode="+PItemCode+"&BgtYear="+BgtYear,
				   success: function(msg){
						JQ("#prj").html(msg);
				   }
				});	} 
	
	function hideSoueceEx(){
		JQ("#sourceexshow").hide();
		JQ('#SourceExId').val(0);}

	function showSoueceEx(){
		JQ("#sourceexshow").show();}

	function loadAct(PrjId){
				var BgtYear = JQ('#BgtYear').val();
				
				//โครงการ
				JQ.ajax({
				   type: "POST",
				   url: "?mod=<?php echo LURL::dotPage('urgent_action');?>",		   
				   data: "action=actlistsearch&PrjId="+PrjId+"&BgtYear="+BgtYear,
				   success: function(msg){
						JQ("#act").html(msg);
				   }
				});	
	} 


function Search(){
	var StartDate =JQ('#StartDate').val();
	var EndDate =JQ('#EndDate').val();
	var BgtYear =JQ('#BgtYear').val();
	var PItemCode =JQ('#PItemCode').val();
	var PrjId =JQ('#PrjId').val();
	var PrjActCode =JQ('#PrjActCode').val();
	var DocCode =JQ('#DocCode').val();
	var Budget =JQ('#Budget').val();
	var DocOperator =JQ('#DocOperator').val();
	var SourceExId =JQ('#SourceExId').val();
	var SourceType = JQ("input[name='SourceType']:checked").val();		
	
	window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&StartDate="+StartDate+"&EndDate="+EndDate+"&BgtYear="+BgtYear+"&PItemCode="+PItemCode+"&PrjId="+PrjId+"&PrjActCode="+PrjActCode+"&DocCode="+DocCode+"&Budget="+Budget+"&DocOperator="+DocOperator+"&SourceType="+SourceType+"&SourceExId="+SourceExId;
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
<div class="sysname">แบบฟอร์มเอกสารขออนุมัติจัดซื้อจัดจ้างและเบิกจ่าย(กรณีเร่งด่วน)</div>
<div class="sysdetail">แสดงรายการแบบฟอร์มเอกสารขออนุมัติจัดซื้อจัดจ้างและเบิกจ่าย(กรณีเร่งด่วน)</div>
</div>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td>
<!--      	<input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" />
        <input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();" />
-->
	</td>
    <td style="text-align:right;">
      	<input type="button" value="  ย้อนกลับ  " class="btn" onclick="goPage('?mod=budgetpay.follow.main_follow');" />
	</td>
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
    <td style="text-align:center; vertical-align:text-top"><?php echo ShowDate($MatUrgDate); ?></td>	
    <td style="text-align:left; vertical-align:text-top"><?php echo ltxt::highlight_phrase($DocCode,$_REQUEST['DocCode']);?></td>
    <td style="text-align:left; vertical-align:text-top"><?php echo icoView($r);?></td>
    <td style="text-align:right; vertical-align:text-top"><?php echo $Budget;?></td>
    <td style="text-align:left; vertical-align:text-top" nowrap="nowrap"><div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div></td>
    </tr>
  
<?php

		$i++;
		}
	}else{
?>  
 <tr>
 <td colspan="6"><div class="nullDataList" style="color:#990000;">ไม่มีข้อมูล</div></td>
 </tr> 
<?php } ?> 
</tbody> 
</table>

<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>