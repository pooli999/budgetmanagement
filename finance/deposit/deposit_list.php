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
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&DepositId='.$r->DepositId."&start=".$_REQUEST["start"].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}

function icoEdit($r){
	$label = 'แก้ไข';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->DepositId."&bankid=".$r->BankId."&typeid=".$r->BookbankTypeId."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoView($r){
	$label = $r->BankName;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&id=".$r->DepositId."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&id=".$r->DepositId."&BookbankId=".$r->BookbankId."&start=".$_REQUEST["start"]."')",
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

/* ]]> */
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td>
      	<input type="button" name="button4" id="button4" value="เพิ่มรายการ" class="add" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>');" />
        <!--<input type="button" name="button5" id="button5" value="  เรียงลำดับข้อมูล  " class="btnRed" onclick="goPage('?mod=<?php //echo lurl::dotPage($sortPage);?>');" />-->
      	<input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" />
       <!-- <input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();" />-->
      </td>

          <td align="right">
		  
<form name="searchForm" id="SearchForm" method="post">
<table  border="0" align="right" cellpadding="0" cellspacing="5" >
    <tr>
      <td  align="right"><?php 
	  	if($_REQUEST['tsearch']){
			$tsearch=$_REQUEST['tsearch'];
		}else{
			$tsearch = date('Y-m-d');
		}
	  	echo InputCalendar_text(array(
			'id'=> 'tsearch',
			'name' => 'tsearch',
			'value' => $tsearch
		));
		?></td>
      <td align="right">
        <input id="search2" name="search2" type="button" value="  ค้นหา  " class="btnRed"   onclick="Search();" />
        </td>
    </tr>
  </table>
 </form>
		</td>
    </tr>
  </table>
</div>

<div class="cms-box-search">

  <?php 
if($tsearch){?>
ผลการค้นหา <span style="color:#FF6600; font-weight:bold;">&quot;<?php echo $tsearch;?>&quot;</span> พบจำนวน <span style="color:#FF6600; font-weight:bold;"><?php echo $list['total'];?></span> รายการ 
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
<thead>
  <tr>
    <th class="no" style="width:10px">รหัส</th>
    <th align="center" >ธนาคาร</th>
    <th align="center" >ประเภทบัญชี</th>
    <th align="center" ><span style="width:300px;">เลขที่บัญชี</span></th>
    <th align="center" ><span style="width:200px;">จำนวนเงิน (บาท)</span></th>
    <th align="center" style="width:150px;">วันที่นำฝาก</th>
    <th align="center" style="width:150px;"><span style="width:150px;">วันทีทำรายการ</span></th>
    <th colspan="2" style="text-align:center;" >ปฏิบัติการ</th>
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
    <td align="center" valign="top" class="center" ><?php echo $DepositId ;?></td>
    <td align="center" valign="top" ><?php echo $BankName ;?></td>
    <td align="center" valign="top" ><?php echo $BookbankType ;?></td>
    <td align="center" valign="top" ><?php echo $BookbankNumber;?></td>
    <td align="center" valign="top" ><?php echo number_format($DepositValue,2);?></td>
    <td align="center" valign="top" ><?php echo $DepositDate;?></td>
    <td align="center" valign="top" ><?php echo $CreateDate;?></td>
    <td style="width:60px;" nowrap="nowrap" valign="top"  ><?php echo icoEdit($r);?></td>
    <td style="width:60px;" valign="top"  nowrap="nowrap" ><?php echo icoDelete($r);?></td>
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
          
