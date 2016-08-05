<?php 
$ReportSheet = 'meeting_word' ;
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => ติดตามการใช้จ่ายงบประมาณ,
		'link' => '?mod=budgetpay.follow.main_follow'
	),
	array(
		'text' => 'แบบฟอร์มขออนุมัติปฏิบัติงานล่วงเวลา',
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

?>


<script language="javascript" type="text/javascript">
/* <![CDATA[ */

	function loadSCT(BgtYear){
			var PItemCode = JQ('#PItemCode').val();
			var PrjId = JQ('#PrjId').val();
	
			//แผนงาน
			JQ.ajax({
			   type: "POST",
			   url: "?mod=<?php echo LURL::dotPage('ot_action');?>",		   
			   data: "action=pitemlistsearch&BgtYear="+BgtYear,
			   success: function(msg){
					JQ("#pitem").html(msg);
			   }
			});	
			
			//โครงการ
			JQ.ajax({
			   type: "POST",
			   url: "?mod=<?php echo LURL::dotPage('ot_action');?>",		   
			   data: "action=projectlistsearch&PItemCode="+PItemCode+"&BgtYear="+BgtYear,
			   success: function(msg){
					JQ("#prj").html(msg);
			   }
			});	
			
			//กิจกรรม
			JQ.ajax({
			   type: "POST",
			   url: "?mod=<?php echo LURL::dotPage('ot_action');?>",		   
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
				   url: "?mod=<?php echo LURL::dotPage('ot_action');?>",		   
				   data: "action=projectlistsearch&PItemCode="+PItemCode+"&BgtYear="+BgtYear,
				   success: function(msg){
						JQ("#prj").html(msg);
				   }
				});	
	} 
	
	function loadAct(PrjId){
				var BgtYear = JQ('#BgtYear').val();
				
				//โครงการ
				JQ.ajax({
				   type: "POST",
				   url: "?mod=<?php echo LURL::dotPage('ot_action');?>",		   
				   data: "action=actlistsearch&PrjId="+PrjId+"&BgtYear="+BgtYear,
				   success: function(msg){
						JQ("#act").html(msg);
				   }
				});	
	} 
	
	
	function hideSoueceEx(){
		JQ("#sourceexshow").hide();
		JQ('#SourceExId').val(0);}

	function showSoueceEx(){
		JQ("#sourceexshow").show();}

	
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

	
/*	function ExportToWord(DocId){
		window.location = '?mod=front.eform.pagecenter.pagecenter_word_meeting1&format=raw&id='+DocId;	
	}*/

	function ExportToWord(DocId,FormId){
		if(FormId == 1){
			window.location = '?mod=front.eform.pagecenter.pagecenter_word_meeting1&format=raw&id='+DocId;	
		}else if(FormId == 5){
			window.location = '?mod=front.eform.pagecenter.pagecenter_word_meeting2&format=raw&id='+DocId;	
		}else if(FormId == 7){
			window.location = '?mod=front.eform.pagecenter.pagecenter_word_meeting3&format=raw&id='+DocId;	
		}
	}

/*	function loadSelect(FormId){
		window.location.href="?mod=<?php //echo LURL::dotPage($listPage)?>&FormId="+FormId;
	}*/
	
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
<!--      	<input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" />
        <input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();" />
-->
	</td>
     <td style="text-align:right;">
      	<input type="button" value="  ย้อนกลับ  " class="btn" onclick="goPage('?mod=budgetpay.follow.main_follow');" />
	</td>
  </table>
</div>




<!--<div style="text-align:right; font-weight:bold">ประเภทแบบฟอร์ม : <?php //echo $get->getFormList($_REQUEST["FormId"]); ?></div>-->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list tablesorter">
<thead>  
  <tr>
    <th style="text-align:center; width:40px">ลำดับ</th>
    <th style="text-align:center; width:100px">วันที่เอกสาร</th>	
    <th style="text-align:center; width:100px">เลขที่ สช.น</th>
    <th style="text-align:center;">ชื่อเรื่อง</th>
    <th style="text-align:center; width:130px">งบประมาณ (บาท)</th>
    <th style="text-align:center; width:95px">สถานะเอกสาร</th>
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