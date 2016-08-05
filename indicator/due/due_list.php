<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบรายงานผลและตัวชี้วัด',
	),
	array(
		'text' => 'กำหนดช่วงเวลารายงานผล',
	),
));


function icoEdit($r){
	$label = 'ปรับปรุงข้อมูล';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&BgtYearId=".$r->BgtYearId."&BgtYear=".$r->BgtYear."  '",
		'ico edit',
		$label,
		$label
	));
}
?>


<div class="sysinfo">
  <div class="sysname">กำหนดช่วงเวลารายงานผล</div>
  <div class="sysdetail">&nbsp;</div>
</div>




<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl-list" >
  <tr style="vertical-align:top;">
    <th rowspan="2" style="width:30px; text-align:center">ลำดับ</th>
    <th rowspan="2" style="text-align:center">ปีงบประมาณ</th>
    <th colspan="3">ไตรมาสที่ 1</th>
    <th colspan="3">ไตรมาสที่ 2</th>
    <th colspan="3">ไตรมาสที่ 3</th>
    <th colspan="3">ไตรมาสที่ 4</th>
    <th rowspan="2">ปฎิบัติการ</th>
  </tr>
  <tr style="vertical-align:top;">
    <th style="width:50px;">ต.ค</th>
    <th style="width:50px;">พ.ย</th>
    <th style="width:50px;">ธ.ค</th>
    <th style="width:50px;">ม.ค</th>
    <th style="width:50px;">ก.พ</th>
    <th style="width:50px;">มี.ค</th>
    <th style="width:50px;">เม.ย</th>
    <th style="width:50px;">พ.ค</th>
    <th style="width:50px;">มิ.ย</th>
    <th style="width:50px;">ก.ค</th>
    <th style="width:50px;">ส.ค</th>
    <th style="width:50px;">ก.ย</th>
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
  ?>
  <tr>
      <td style="text-align:center"><?php echo $i+1;?></td>
      <td style="text-align:center"><?php echo $BgtYear; ?></td>
      <td colspan="3" align="center"><?php  echo ($QuarterStart1)?Showdate($QuarterStart1):''; ?> - <?php  echo ($QuarterEnd1)?Showdate($QuarterEnd1):''; ?></td>
      <td colspan="3" align="center"><?php  echo ($QuarterStart2)?Showdate($QuarterStart2):''; ?> - <?php  echo ($QuarterEnd2)?Showdate($QuarterEnd2):''; ?></td>
      <td colspan="3" align="center"><?php  echo ($QuarterStart3)?Showdate($QuarterStart3):''; ?> - <?php  echo ($QuarterEnd3)?Showdate($QuarterEnd3):''; ?></td>
      <td colspan="3" align="center"><?php  echo ($QuarterStart4)?Showdate($QuarterStart4):''; ?> - <?php  echo ($QuarterEnd4)?Showdate($QuarterEnd4):''; ?></td>
      <td style="width:100px" nowrap="nowrap"><?php  echo icoEdit($r); ?></td>
  </tr>
  <?php
		$i++;  }

  }else{
  ?>
   <tr>
      <td style="color:#F00; text-align:center; height:100px" colspan="15">- - ไม่มีรายการปีงบประมาณในฐานข้อมูล - -</td>
   </tr>  
  <?php
  }
  ?>
</table>
