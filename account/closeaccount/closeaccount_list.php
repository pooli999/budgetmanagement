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
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r."&start=".$_REQUEST["start"]."&jid=".$_REQUEST["jid"]."&jtxt=".$_REQUEST["jtxt"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoView($r){
	$label = $r->BankName;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&id=".$r->AcChartId."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&id=".$r->AcChartId."&start=".$_REQUEST["start"]."')",
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
	function Save(f,smode){
		JQ("#smode").val(smode);
		if(ValidateForm(f)){
			 var action_url = '?mod=account.postaccount.postaccount_action';
			 var redirec_url = '?mod=account.postaccount.postaccount_list';
			 toSubmit(f,'save',action_url,redirec_url);
		}
	}
	function ValidateForm(f){
			var r = confirm("ต้องการทำรายการใช่หรือไม่");
			if (r == true) {
				return true;
			} else {
				return false;
			}
	}
/* ]]> */
</script>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>


<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>
  <!--<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td>
      	<input type="button" name="button4" id="button4" value="เพิ่มรายการ" class="add" onclick="goPage('?mod=<?php //echo lurl::dotPage($addPage);?>');" />
      	<input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php //echo lurl::dotPage($listPage);?>');" />
        <input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();" />
      </td>

          <td align="right"></td>
    </tr>
  </table>
</div>-->
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
		JQ('input[name="CboSendId"]').click(function() {
			str1 = "";
			JQ('input[name="CboSendId"]:checked').each(function(){ // หาว่าตัวไหน checked บ้าง ถ้า checked ให้ส่งข้อมูล
				str1 = str1+this.value+"||";
			});
			str1 = str1.substring(0, str1.length-2); 
			JQ("#data2").val(str1);
			
			str1 = "";
			JQ('input[name="CboSendId"]:not(:checked)').each(function(){ // หาว่าตัวไหน checked บ้าง ถ้า checked ให้ส่งข้อมูล
				str1 = str1+this.value+"||";
			});
			str1 = str1.substring(0, str1.length-2); 
			JQ("#data2_c").val(str1);
		});
});
/* ]]> */
</script>
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>&action=save" enctype="multipart/form-data" >
<table width="100%" border="0" class="tbl-list tablesorter"  cellspacing="0">
	<tr>
    <th class="no" style="width:10px">รหัส</th>
    <th align="center" style="width:120px">
	PV
	<input name="data2" type="hidden" id="data2" value="" />
    <input name="data2_c" type="hidden" id="data2_c" value="" />
	 <input name="smode" type="hidden" id="smode" value="" />
	</th>
    <th align="center">เลขที่ สช.น</th>
    <th align="center" style="width:120px;">เลขที่เช็ค</th>
    <th align="center" style="width:150px;">จำนวนเงิน (บาท)</th>
    <th align="center" style="width:120px;">วันที่ทำเช็ค</th>
    <th align="center" style="width:120px;">วันที่จ่าย</th>
    <th style="text-align:center;width:100px;" ><input id="savesend" class="btnRed" type="button" onclick="Save('adminForm','send');" value="ปิดบัญชี " name="save2" /></th>
    </tr>
<thead>
  <tr>
    <td height="24" colspan="8" background="../../../../images/bg.jpg"><span class="style9">&nbsp;&nbsp;<img src="../../../../images/edit_s.jpg" width="16" height="16" /> <span class="style1">F2-Edit</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="../../../../images/add_s.jpg" width="16" height="16" /> </span><span class="style1">F3-Add</span><!--<span class="style9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../../../images/del_s.jpg" width="16" height="16" /> </span><span class="style1">F4-Delete</span>--><span class="style9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../../../images/search_s.jpg" width="16" height="16" /> </span><span class="style1">F6-Search</span><span class="style9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../../../images/esc_s.png" width="16" height="16" /> </span><span class="style1">Esc-Exit</span></td>
    </tr>
	<tr>
    <td colspan="8" bgcolor="E6E6E6" height="15"></td>
    </tr>
</thead>
<tbody>
<?php
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	
	if($list["rows"]){
          foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
					$t1 = $r->PV;
					 if ($t1 != ""){
?>
  <tr>
    <td valign="top" class="center" ><?php echo $PaymentId ;?></td>
    <td valign="top" class="center"><?=$PV?></td>
    <td align="left" valign="top" ><?php 

		$tList3 = $get->getDataList3($PaymentId);//ltxt::print_r($costList);
		if($tList3["rows"]){
		$iv = 0;
		$iv_txt="";
				  foreach($tList3["rows"] as $r1 ) {
						foreach( $r1 as $k1=>$v1){ ${$k1} = $v1;}
							if ($iv != 0){
								$iv_txt = " , ";
							}
							echo $iv_txt.$r1->DocCode;
		?>
			
		<?php				
				$iv++;
				}
			}
		?></td>
    <td align="center" valign="top" ><?=$r->PaymentNumber?></td>
    <td align="center" valign="top" ><?=$r->pvalue?></td>
    <td align="center" valign="top" ><?=$r->ChequeMakeDate?></td>
    <td align="center" valign="top" ><?=$r->ChequePayDate?></td>
    <td align="center" valign="top" nowrap="nowrap"><input name="CboSendId" type="checkbox"  value="<?php echo $AcActionId ;?>" <?php if ($CloseStatus == "1"){?>checked="checked"<? }?> /></td>
    </tr>
  
<?php
			}
		$i++;
		}
	}
?>
</tbody>
</table>
</form>
<?php
if(!$list["rows"]){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>
<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>
          
