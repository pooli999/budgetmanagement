<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => 'จัดการข้อมูลพื้นฐาน',
		'link' => '?mod=budget.init.startup',
	),
	
	array(
		'text' => $MenuName,
	),
));

function icoActive($r){
	global $actionPage;
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&ScreenId='.$r->ScreenId."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST["BgtYear"].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}

function icoEdit($r){
	$label = 'แก้ไข';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->ScreenId."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoView($r){
	$label = $r->ScreenName;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&id=".$r->ScreenId."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&id=".$r->ScreenId."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST["BgtYear"]."')",  
		'ico delete',
		$label,
		$label
	));
}



function icoOrdering($r){
	$label = 'เรียงลำดับข้อมูล';
	global $sortPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($sortPage)."&SCTypeId=".$r->SCTypeId."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST["BgtYear"]."'",
		'ico ordering',
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
	
	function toggleSub(id){
		JQ("a#icoClass_"+id).toggleClass("minimize");
		JQ("tr.hideRow_"+id).toggle();
	}
	
	function sortItem(){
	window.location.href='?mod=<?php echo lurl::dotPage($sortPage);?>';
	}

	function loadSCT(BgtYear){
		window.location.href='?mod=<?php echo lurl::dotPage($listPage);?>&BgtYear='+BgtYear;
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
      	<input type="button" name="button4" id="button4" value="เพิ่มรายการ" class="add" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>&BgtYear=<?php echo $_REQUEST["BgtYear"];?>');" />
      	<input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" />
        <input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();" />
        </td>
        <td align="right">ปีงบประมาณ : <?php echo $get->getYearProject(ltxt::getVar('BgtYear'),'BgtYear');?></td>
    </tr>
  </table>
</div>
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

<table width="100%" border="0" class="tbl-list tablesorter"  cellspacing="0">
<thead>
  <tr>
    <th style="width:30px;">ลำดับ</th>
    <th style="width:18px;">&nbsp;</th>
    <th>ชื่อขั้นตอน</th>
    <th align="center" style="width:200px;">ประเภทขั้นตอน</th>
    <th colspan="2"  style="text-align:center; width:100px" >ปฏิบัติการ</th>
    </tr>
</thead>
<tbody>


            <?php 
            $data = $get->getOrderList($_REQUEST["BgtYear"]);//ltxt::print_r($data);
			$n = 1;
			if($data){
          	foreach($data["rows"] as $row){
			   foreach( $row as $k=>$v){${$k} = $v;}
            ?>
          <tr>
            <td valign="top" style="text-align:center;"><?php echo $n; ?>.</td>
            <td valign="top" <?php if($Allot=="Y"){ ?> class="icon-allot" title="ขั้นตอนนี้ต้องผ่านการกลั่นกรองจัดสรรงบประมาณ" <?php } ?>>&nbsp;</td>
            <td valign="top"><?php echo icoView($row);?></td>
            <td valign="top" ><?php echo $SCTypeName; ?></td>
            <td   style="width:65px; text-align:center"><?php echo icoEdit($row);?></td>
            <td  style="width:65px; text-align:center" ><?php echo icoDelete($row);?></td>
          </tr>
			<?php
            
                    $n++;
                    }
                }else{
            ?>
            <tr>
            	<td style="color:#900; vertical-align:middle; padding-left:22px" colspan="6">- - ไม่มีข้อมูล - -</td>
            </tr>
			<?php }?>
</tbody>
</table>
<?php
if(!$data){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>
<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>$data['total']));?>
</div>
          
