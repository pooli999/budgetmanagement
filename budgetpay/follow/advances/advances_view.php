<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => ติดตามการใช้จ่ายงบประมาณ,
		'link' => '?mod=budgetpay.follow.main_follow'
	),

	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),	
	
	array(
		'text' => "เพิ่ม/แก้ไข ".$MenuName,
		
	),	
	
));
	
	
function icoDelete($ClearId,$ClearDocCode){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=deleteclear&id=".$_GET["id"]."&ClearId=".$ClearId."&ClearDocCode=".$ClearDocCode."')",
		'ico drop',
		$label,
		$label
	));
}

function icoEdit($EFormId,$ClearId){
	$label = 'แก้ไข';
	global $clearPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($clearPage)."&id=".$EFormId."&ClearId=".$ClearId."' ",
		'ico edit',
		$label,
		$label
	));
}	
?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */

	function ExportToWord(EFormId,FormId){
		if(FormId == 3){
			window.location = '?mod=front.eform.pagecenter.pagecenter_word_advances1&format=raw&id='+EFormId;	
		}else if(FormId == 6){
			window.location = '?mod=front.eform.pagecenter.pagecenter_word_advances2&format=raw&id='+EFormId;	
		}
	}

function extoggle(i){
	if(JQ('#ex'+i).is(':hidden')===true){
		JQ('#ex'+i).show('fade');
		JQ('#a-ex'+i).addClass('icon-decre');
		JQ('#a-ex'+i).removeClass('icon-incre');
		JQ('#a-ex'+i).html('ซ่อนรายละเอียด');
	}else{
		JQ('#ex'+i).hide('fade');
		JQ('#a-ex'+i).removeClass('icon-decre');
		JQ('#a-ex'+i).addClass('icon-incre');
		JQ('#a-ex'+i).html('ดูรายละเอียด');
	}
	
}	


/* ]]> */
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียด<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>

<?php include("modules/backoffice/finance/form/advances/view.php"); ?>



<div style="text-align:center; padding:10px">
    <input type="button" name="button3" id="button3" value=" ย้อนกลับ " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" />
</div>