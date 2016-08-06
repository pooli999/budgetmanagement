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
		var docsearch=JQ('#docsearch').val();
		var tsearch=JQ('#tsearch').val();
		var descsearch=JQ('#descsearch').val();
		window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&pvsearch="+ pvsearch+"&docsearch="+docsearch+"&tsearch="+tsearch+"&descsearch="+descsearch+"&jid=<?php echo $_REQUEST['jid']?>&jtxt=<?php echo $_REQUEST['jtxt']?>";
	}

	function toggleSub(id){
		JQ("a#icoClass_"+id).toggleClass("minimize");
		JQ("tr.hideRow_"+id).toggle();
	}

	function sortItem(){
	window.location.href='?mod=<?php echo lurl::dotPage($sortPage);?>';
	}

	function del_Payment(PaymentId){ // ปุ่มลบ
		//alert(PaymentId);
		if(confirm('ต้องการลบข้อมูลรายการนี้หรือไม่ ? กรุณายืนยัน')){
			url = '?mod=account.generaljournal.generaljournal_action&action=delete&id='+PaymentId+'&start=';
			window.location.href= url;
		}
	}
	function saveToExcel(PaymentId){

		window.location.href="/modules/budgetmanagement/account/generaljournal/word.php?PaymentId="+PaymentId;
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
      <td  align="right"><strong>คำค้น : </strong></td>
        <td align="left">
        <input name="tsearch" id="tsearch" type="text" class="input-search" size="30" value="<?php echo $_REQUEST['tsearch']?>" />
        </td>
    </tr>

     <tr>
        <td align="center" colspan = "2">
         <input id="search2" name="search2" type="button" value="  ค้นหา  " class="btnRed"   onclick="Search();" />
        <input type="button" name="button5" id="button2" class="btn" value=" ยกเลิก " onclick="JQ('#boxSearch').hide();JQ('#boxFilter').show();" />
        </td>
    </tr>
  </table>

</div></form>
<div class="cms-box-search">

  <?php
if($_REQUEST['pvsearch'] || $_REQUEST['docsearch'] || $_REQUEST['tsearch'] || $_REQUEST['descsearch']){?>
ผลการค้นหา
<span style="color:#FF6600; font-weight:bold;">
    <?php if($_REQUEST['tsearch']){?>&quot;คำค้น : <?php echo $_REQUEST['tsearch'];?>&quot;<?php }?>
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
    <th align="center">เลขที่ สช.น</th>

    <th align="center" style="width:150px;">จ่ายให้</th>
    <th align="center" style="width:100px;">จำนวนเงิน (บาท)</th>
    <th align="center" style="width:80px;">วันที่ทำเช็ค/<br />
      (เลขที่เช็ค)</th>
    <th align="center" style="width:100px;">วันที่จ่าย</th>
			<th align="center" style="width:60px;">รายการ<br>เพิ่มเอง</th>
    <th colspan="2" style="text-align:center;width:60px;" >ปฏิบัติการ</th>
		<th align="center" style="width:120px;">ใบสำคัญจ่าย</th>
    </tr>
<thead>
  <tr>
    <td height="24" colspan="11" background="../../../../images/bg.jpg"><span class="style9">&nbsp;&nbsp;<img src="../../../../images/edit_s.jpg" width="16" height="16" /> <span class="style1">F2-Edit</span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style = "cursor: pointer;" title = "เพิ่ม" id = "add1" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>1&jid=<?php echo $_REQUEST["jid"];?>&jtxt=<?php echo $_REQUEST["jtxt"]?>');"><img src="../../../../images/add_s.jpg" width="16" height="16" /><span class="style1">F3-Add</span></span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style = "cursor: pointer;" title = "ค้นหา" id = "search1" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();"><img src="../../../../images/search_s.jpg" width="16" height="16" /><span class="style1"> F6-Search</span></span><span class="style9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../../../images/esc_s.png" width="16" height="16" /> </span><span class="style1">Esc-Exit</span></td>
    </tr>
	<tr>
    <td colspan="11" bgcolor="E6E6E6" height="15"></td>
    </tr>
</thead>
<tbody>
<?php
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;

	if($list["rows"]){
      foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
				//$AcSource = $r->AcSource;
				//echo "ssss".$AcSource;
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
									//$iv_txt = "<br>";
								}
								if ($AcSource=="0"){
										echo "<fieldset><legend><strong>".$iv_txt.$r1->DocCode."</strong></legend>";
									$PaymentListId = $r1->PaymentListId;
									$tList4 = $get->getDataList4($PaymentListId);//ltxt::print_r($costList);
									if($tList4["rows"]){
										foreach($tList4["rows"] as $r2 ) {
										foreach( $r2 as $k2=>$v2){ ${$k2} = $v2;}
											echo $r2->DetailCostAccount."<br>";
										}
									}
									echo "</fieldset>";
								}else{

									echo $r1->DocCode;
								}
		?>

		<?php
				$iv++;
				}
			}

		?>
</td>

    <td align="center" valign="top" ><?PHP
		if ($PType =="1" ){
		$sql="SELECT CONCAT(IFNULL(nh_in_partner_prefix.PtnPrefixTH,''), IFNULL(nh_in_partner.PtnFname,''),' ',IFNULL(nh_in_partner.PtnSname,'')) as pname  FROM nh_in_partner left join nh_in_partner_prefix on nh_in_partner.PrefixUid=nh_in_partner_prefix.PrefixUid where PartnerCode='$PartnerCode' ";
		}else{
			$sql="SELECT CONCAT(IFNULL(tblpersonal_prefix.PrefixName,''), IFNULL(tblpersonal.FirstName,''),' ',IFNULL(tblpersonal.LastName,'')) as pname  FROM tblpersonal left join tblpersonal_prefix on tblpersonal.PrefixId= tblpersonal_prefix.PrefixId  where PersonalCode='$PartnerCode' ";
		}
		$result1 =mysql_query($sql);
		if ($row1 = mysql_fetch_array($result1)){
			$pname = $row1["pname"];
		}
		echo $pname;
		?></td>
    <td align="center" valign="top" ><?php
    $pvalue = $r->pvalue;
	echo number_format($pvalue,2);
	$r->pvalue?></td>
    <td align="center" valign="top" ><?php

	$ChequeMakeDate = $r->ChequeMakeDate;
	echo ShowDate($ChequeMakeDate);
	?>
      <br />
      (<?=$r->PaymentNumber?>)</td>
    <td align="center" valign="top" ><?=ShowDate($r->ChequePayDate)?></td>
		<td align="center" valign="top" >
			<?php
				if ($AcSource=="1"){
					echo "&#10003;";
				}
			?>
		</td>
    <td align="center" valign="top" nowrap="nowrap" style="width:30px;"  >

    <?php echo icoEdit($PaymentId,$journalId,$AcSource);?>
	</td>
    <td align="center" valign="top" nowrap="nowrap" style="width:30px;"  >
		<?php if ($AcSource == "1"){?>
			<a class="ico delete" title="ลบทิ้ง" onclick="del_Payment(<?php echo $PaymentId ;?>)"></a>
		<?php }else{?>
			-
		<?php }?>
	</td>
	<td align="center" valign="top" nowrap="nowrap" style="width:30px;"  >
		<a href="javascript:saveToExcel(<?php echo $PaymentId ;?>);" class="icon-excel"></a>
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
