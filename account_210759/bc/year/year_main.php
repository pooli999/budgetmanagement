<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
	),
));


function icoEdit($r){
	$label = 'แก้ไข';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->BgtYear."  '",
		'ico edit',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:if(confirm('ยืนยันการลบปีงบประมาณ ".$r->BgtYear." ')) self.location='?mod=".LURL::dotPage($actionPage)."&action=delete&start=".$_REQUEST["start"]."&BgtYear=".$r->BgtYear." '",
		'ico delete',
		$label,
		$label
	));
}

function icoClose($r){
	$label = 'ปิดปีงบประมาณ';
	global $closePage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($closePage)."&start=".$_REQUEST["start"]."&id=".$r->BgtYear."  '",
		'ico lock',
		$label,
		$label
	));
}

function icoView($r){
	$label = $r->BgtYear;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&start=".$_REQUEST["start"]."&id=".$r->BgtYear." '",
		'',
		$label,
		$label
	));
}
?>


<div class="sysinfo">
  <div class="sysname">รายการ<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?> </div>
</div>


<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr class="td-descr">
       <td>
<input type="button" name="add" id="add" value=" เปิดปีงบประมาณ " class="add" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>');" />
     </td>
      <td align="right" style="width:16%">&nbsp;</th>      
    </tr>
  </table>
</div>


<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list" >
  
  <tr>
    <th style="width:30px; text-align:center">ลำดับ</th>
    <th style="text-align:center">ปีงบประมาณ</th>
    <th style="width:60px;">หน่วยงาน</th>
    <th style="width:60px;">สถานะ</th>
    <th colspan="3">ปฎิบัติการ</th>   
  </tr>
  <?php
 		$list = $get->getYearList($_REQUEST["BgtYear"]);
		//ltxt::print_r($list);
  		if($list["rows"]){
		$i=0;	
          foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
				
				//$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],0,0,0,0,$SCTypeId,0,0);	
				
				$SumBGTotal=$get->getTotalPrj($BgtYear);
				$SumPay = 0;
				$SumStatement = 0;
				$TotalBG = $SumBGTotal - $SumPay;
				$TotalBGStatement = $SumBGTotal - $SumPay - $SumStatement;
				
				$amountOrg = $get->getCountOrg($BgtYear);
  ?>
  <tr>
      <td style="text-align:center"><?php echo $i+1;?>.</td>
      <td><?php echo icoView($r); ?></td>
      <td nowrap="nowrap" style="text-align:center;"><?php echo ($amountOrg)?$amountOrg:"-"; ?></td>
      <td nowrap="nowrap"><?php if($CloseStatus == "Y"){echo '<span class="ico red">ปิดปีงบ</span>';}else{ echo '<span class="ico green">เปิดปีงบ</span>';}; ?></td>
      <td style="width:45px" nowrap="nowrap"><?php  if($CloseStatus == "N"){ echo icoEdit($r); } ?></td>
      <td style="width:60px" nowrap="nowrap"><?php  if($CloseStatus == "N"){ echo icoDelete($r); }?></td>
      <td  style="width:100px" nowrap="nowrap"><?php  if($CloseStatus == "N"){ echo icoClose($r); }?></td>
  </tr>
  <?php
		$i++;  }
  ?>
  <?php
  }else{
  ?>
   <tr>
      <td style="color:#F00; text-align:center; height:100px" colspan="7">- - ไม่มีรายการในฐานข้อมูล - -</td>
   </tr>  
  <?php
  }
  ?>
</table>
