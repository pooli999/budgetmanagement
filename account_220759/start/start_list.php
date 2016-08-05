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
		if (JQ("#atype").val() == ""){
			alert("เลือกรายการ");
		}else{
			if (JQ("#atype").val() == "1"){
				window.location.href='?mod=account.incomejournal.incomejournal_list&jid='+JQ("#atype").val()+'&jtxt='+JQ('#atype option:selected').text();
			}else if (JQ("#atype").val() == "2"){
				window.location.href='?mod=account.generaljournal.generaljournal_list&jid='+JQ("#atype").val()+'&jtxt='+JQ('#atype option:selected').text();
			}else{
			//	window.location.href='?mod=account.generaljournal.generaljournal_list&jid='+JQ("#journalId").val()+'&jtxt='+JQ('#journalId option:selected').text();
			}
		}
		//alert(JQ("#journalId").val());
	}

	JQ(document).ready(function() {
		JQ( "#dialog-openpage" ).dialog({
			resizable: false,
			height: 200,
			width: 400,
			modal: true,
			closeOnEscape: false,
			//dialogClass: 'no-close',
			//closeOnEscape: false,
			buttons: {
				"ทำรายการ": function() {
					//$( this ).dialog( "close" );
					gopage();
				}
			}
		});
		JQ( "#dialog-openpage" ).dialog({ dialogClass: 'no-close' });
	} );
	//JQ(".ui-dialog-titlebar").hide();
/* ]]> */
</script>
<style type="text/css">
	<!--
		.no-close .ui-dialog-titlebar-close {display: none }
	-->
</style>
<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>
<div id="dialog-openpage" title="ลงรายวัน"><br><br>
	<table width="100%" border="0" cellspacing="0" cellpadding="4">
	 <tr>
	    <th>ประเภท</th>
	    <td>&nbsp;&nbsp;&nbsp;
				<?php
		        $tag_attribs = 'onchange="" style="width:120px"';
		        echo $get->getJournalNameSelect("atype",$tag_attribs,$atype,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
		    ?>
			</td>
	  </tr>
	</table>
</div>
