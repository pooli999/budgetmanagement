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

// function icoEdit($r){
// 	$label = 'แก้ไข';
// 	global $addPage;
// 	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
// 		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r."&start=".$_REQUEST["start"]."&jid=".$_REQUEST["jid"]."&jtxt=".$_REQUEST["jtxt"]."'",
// 		'ico edit',
// 		$label,
// 		$label
// 	));
// }
function icoEdit($PaymentId,$journalId,$AcSource){
	if ($AcSource == 0){
		$apage = "";
	}else{
		$apage = "1";
	}

	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage.$apage)."&id=".$PaymentId."&start=".$_REQUEST["start"]."&jid=".$_REQUEST["jid"]."&jtxt=".$_REQUEST["jtxt"]."'",
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
		var pvsearch=JQ('#pvsearch').val();
		var tsearch=JQ('#tsearch').val();
		var descsearch=JQ('#descsearch').val();
		window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&pvsearch="+ pvsearch+"&tsearch="+tsearch+"&descsearch="+descsearch;
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
  <table  border="0" align="center" cellpadding="2" cellspacing="5" >
  	 <tr>
      <td  align="right"><strong>PV : </strong></td>
        <td align="left">
        <input name="pvsearch" id="pvsearch" type="text" class="input-search" size="30" value="<?php echo $_REQUEST['pvsearch']?>" />
        </td>
    </tr>
    <tr>
      <td  align="right"><strong>ได้รับเงินจาก : </strong></td>
        <td align="left">
        <input name="tsearch" id="tsearch" type="text" class="input-search" size="30" value="<?php echo $_REQUEST['tsearch']?>" />
        </td>
    </tr>
     <tr>
      <td  align="right"><strong>คำอธิบาย : </strong></td>
        <td align="left">
        <input name="descsearch" id="descsearch" type="text" class="input-search" size="30" value="<?php echo $_REQUEST['descsearch']?>" />
        </td>
    </tr>

     <tr>
        <td align="center" colspan = "2">
         <input id="search2" name="search2" type="button" value="  ค้นหา  " class="btnRed"   onclick="Search();" />
        <input type="button" name="button5" id="button2" class="btn" value=" ยกเลิก " onclick="JQ('#boxSearch').hide();JQ('#boxFilter').show();" />
        </td>
    </tr>
  </table>

</div>
</form>
<div class="cms-box-search">
 <?php
if($_REQUEST['pvsearch'] || $_REQUEST['tsearch'] || $_REQUEST['descsearch']){?>
ผลการค้นหา
<span style="color:#FF6600; font-weight:bold;">
	<?php if($_REQUEST['pvsearch']){?>&quot;PV : <?php echo $_REQUEST['pvsearch'];?>&quot;<?php }?>
    <?php if($_REQUEST['tsearch']){?>&quot;ได้รับเงินจาก : <?php echo $_REQUEST['tsearch'];?>&quot;<?php }?>
    <?php if($_REQUEST['descsearch']){?>&quot;คำอธิบาย : <?php echo $_REQUEST['descsearch'];?>&quot;<?php }?>
</span> พบจำนวน <span style="color:#FF6600; font-weight:bold;"><?php echo $list['total'];?></span> รายการ
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
	<tr>
    <th class="no" style="width:10px">รหัส</th>
    <th align="center" style="width:120px">PV</th>
    <th align="center" style="width:150px;">ประเภทรายรับ</th>
    <th align="center">ได้รับเงินจาก</th>
    <th align="center" style="width:180px;">ประเภทการรับเงิน</th>
    <th align="center" style="width:120px;">วันที่ทำรายการ</th>
    <th align="center" style="width:120px;">จำนวนเงิน(บาท)</th>
		<th align="center" style="width:100px;">รายการ<br>เพิ่มเอง</th>
    <th colspan="2" style="text-align:center;width:100px;" >ปฏิบัติการ</th>
  </tr>
<thead>
  <tr>
    <td height="24" colspan="10" background="../../../../images/bg.jpg">
			<span class="style9">&nbsp;&nbsp;<img src="../../../../images/edit_s.jpg" width="16" height="16" /></span>
				 <span class="style1">F2-Edit</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span style = "cursor: pointer;" title = "เพิ่ม" id = "add1" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>1&jid=<?php echo $_REQUEST["jid"];?>&jtxt=<?php echo $_REQUEST["jtxt"]?>');">
			<img src="../../../../images/add_s.jpg" width="16" height="16" />
			<span class="style1">F3-Add</span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style = "cursor: pointer;" title = "ค้นหา" id = "search1" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();"><img src="../../../../images/search_s.jpg" width="16" height="16" /><span class="style1"> F6-Search</span></span><span class="style9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../../../images/esc_s.png" width="16" height="16" /> </span><span class="style1">Esc-Exit</span>
		</td>
    </tr>
	<tr>
    <td colspan="10" bgcolor="E6E6E6" height="15"></td>
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
    <td valign="top" class="center" ><?php echo $IncomeId ;?></td>
    <td valign="top" class="center"><?=$PV?></td>
    <td align="center" valign="top" class="center" >
    <?
	$C_IncomeType = $r->IncomeType;
	if ($C_IncomeType == 1){
		echo "เงินประกันสัญญา";
	}elseif ($C_IncomeType == 2){
		echo "คืนเงินข้อตกลง";
	}else{
		echo "ดอกเบี้ยรับ";
	}
	?>
    </td>
    <td align="left" valign="top" class="left"><?=$r->PayName?></td>
    <td align="center" valign="top" class="center"><?php
	// echo icoView($r);
	$C_ReceiveType = $r->ReceiveType;
	if ($C_ReceiveType == 1){
		echo "เงินสด";
	}elseif ($C_ReceiveType == 2){
		echo "เงินโอน";
	}elseif ($C_ReceiveType == 3){
		echo "เช็ค";
	}elseif ($C_ReceiveType == 4){
		echo "พันธบัตร";
	}else{
		echo "หนังสือค้ำประกันธนาคาร(LG)";
	}
	 ?></td>
    <td align="center" valign="top" class="center"><?=$r->CreateDate?></td>
    <td align="right" valign="top" class="right"><?php echo number_format($r->IncomeValue,2);?></td>
		<td align="center" valign="top" >
			<?php
				if ($AcSource=="1"){
					echo "&#10003;";
				}
			?>
		</td>
    <td align="center" valign="top" nowrap="nowrap" style="width:30px;"  >
		<?php echo icoEdit($IncomeId,$journalId,$AcSource);?>
	</td>
    <td align="center" valign="top" nowrap="nowrap" style="width:30px;"  >
	<a class="ico delete" title="ลบทิ้ง" onclick="del_Payment(<?php echo $PaymentId ;?>)">
	</a>
	</td>
  </tr>

<?php

		$i++;
		}
	}
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
