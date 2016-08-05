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
	function gopage(){
		if (JQ("#atype").val() == "income"){
			window.location.href='?mod=account.incomejournal.incomejournal_list&jid='+JQ("#journalId").val()+'&jtxt='+JQ('#journalId option:selected').text();
		}else{
			window.location.href='?mod=account.generaljournal.generaljournal_list&jid='+JQ("#journalId").val()+'&jtxt='+JQ('#journalId option:selected').text();
		}
		
		//alert(JQ("#journalId").val());
	}

/* ]]> */
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="4">
 <tr>
    <th>ประเภท</th>
    <td>
    <select name="atype" id="atype">
  		<option value="pay">รายจ่าย</option>
  		<option value="income">รายรับ</option>
	</select>
</td>
  </tr>
  <tr>
    <th width = "140">สมุดรายวัน</th>
    <td><?php 
		$tag_attribs ='';
		echo $get->getJournalSelect("journalId",$tag_attribs,$journalId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></td>
  </tr>
 
  <tr>
    <td>&nbsp;</td>
    <td><input type="button" class="btnRed" name="save" id="save" value=" ทำรายการ " onclick="gopage();"  />
</td>
  </tr>
</table>