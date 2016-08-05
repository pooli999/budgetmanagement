<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css'
));

$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'รายละเอียด',
	),
));

?>
<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST['start'];?>');" /></td>
  </tr>
</table>






<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<!--<tr>
<th>รหัสแผนงานต่อเนื่อง</th>
<td><?php //echo $PLongCode;?></td>
</tr>
--><tr>
<th>ชื่อแผนหลัก</th>
<td><?php echo $PLongName;?></td>
</tr>
<tr style="vertical-align:top;">
<th valign="top">รายละเอียด</th>
<td><?php echo ($PLongDetail)?$PLongDetail:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
</tr>
<tr>
<th>ปีที่ตั้งแผนหลัก</th>
<td><?php echo $PLongYear;?><b>-</b><?php echo $PLongYearEnd;?>&nbsp;(ต่อเนื่อง <?php echo $PLongAmount;?> ปี)</td>
</tr>
<tr>
<th colspan="2">ข้อมูลแผนงานภายใต้แผนหลัก</th>
</tr>
<tr>
<td colspan="2">





    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
        <thead>
          <tr>
            <td style="width:30px; text-align:center">ลำดับ</td>
            <td style="width:100px; text-align:center">รหัสแผนงาน</td>
            <td style="text-align:center">ชื่อแผนงาน</td>
          </tr>
        </thead>
        
<?php 
$i=1;
$dataPlan = $get->getPlanItem($PLongCode);//ltxt::print_r($dataPlan);
if($dataPlan){
	foreach($dataPlan as $r){
		foreach( $r as $k=>$v){ ${$k} = $v;}
?>    
        
        
        <tr>
          <td style="text-align:center;"><?php echo $i; ?></td>
          <td style="text-align:center;"><?php echo $LPlanCode; ?></td>
          <td><?php echo $LPlanName; ?></td>
        </tr>
<?php				
			$i++;
	}
}
?> 

      </table>





</td>
<tr>
  <th>&nbsp;</th>
  <td>
  <input type="button" name="button4" id="button4" value="กลับไปแก้ไข" class="btnRed" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>&id=<?php echo $_REQUEST['id'];?>&start=<?php echo $_REQUEST['start'];?>');"  />
  <input name="cancel" type="button" value="ย้อนกลับ" class="btn cancle" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST['start'];?>');" />
  </td>
 </tr>
</table>









