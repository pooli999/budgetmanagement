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
		'link' => '?mod='.lurl::dotPage("due_list")
	),
));

$datas = $get->dataSet($_REQUEST["BgtYear"]);
foreach($datas as $r ) {
	foreach( $r as $k=>$v){ ${$k} = $v;}
}


//ltxt::print_r($detail);

?>

<script  type="text/javascript">

function Save(form){	
	if(validateSubmit()){
		form.submit();
	}
}

function validateSubmit(){
		return true;
}

function loadPage(BgtYear){
	window.location.href='?mod=<?php echo lurl::dotPage($addPage);?>&BgtYear='+BgtYear;
}

</script>

<div class="sysinfo">
  <div class="sysname">กำหนดช่วงเวลารายงานผล</div>
  <div class="sysdetail">&nbsp;</div>
</div>
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="BgtYearId" id="BgtYearId" value="<?php echo $_REQUEST["BgtYearId"];?>" />

<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr class="td-descr">
      <td style=" text-align:right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" /></td>
    </tr>
  </table>
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-view">
  <tr>
    <th>ปีงบประมาณ :</th>
    <td colspan="2" style="font-weight:bold;"><?php echo $_REQUEST["BgtYear"]; ?></td>
  </tr>
  <tr>
    <th colspan="3" valign="top">กำหนดช่วงเวลาการรายงานผล</th>
    </tr>
  <tr>
    <th valign="top">ไตรมาสที่ 1 <span style="font-weight:normal;">(ต.ค - ธ.ค)</span></th>
    <td valign="top" class="require">*</td>
    <td>    
    <div>
	<?php 
			echo InputCalendar_text(array(
				'id' => 'QuarterStart1',
				'name' => 'QuarterStart1',
				'value' => $QuarterStart1
			));
	?>&nbsp;<b>ถึง</b>&nbsp;
    <?php 
			echo InputCalendar_text(array(
				'id' => 'QuarterEnd1',
				'name' => 'QuarterEnd1',
				'value' => $QuarterEnd1
			));
	?>
     </div>
</td>
  </tr>
  <tr>
    <th valign="top">ไตรมาสที่ 2 <span style="font-weight:normal;">(ม.ค - มี.ค)</span></th>
    <td valign="top" class="require">*</td>
    <td>      
    <div>
        <?php 
			echo InputCalendar_text(array(
				'id' => 'QuarterStart2',
				'name' => 'QuarterStart2',
				'value' => $QuarterStart2
			));
	?>&nbsp;<b>ถึง</b>&nbsp;
        <?php 
			echo InputCalendar_text(array(
				'id' => 'QuarterEnd2',
				'name' => 'QuarterEnd2',
				'value' => $QuarterEnd2
			));
	?>
     </div>   
</td>
  </tr>
  <tr>
    <th valign="top">ไตรมาสที่ 3 <span style="font-weight:normal;">(เม.ย - มิ.ย)</span></th>
    <td valign="top" class="require">*</td>
    <td>    
    <div>
	<?php 
			echo InputCalendar_text(array(
				'id' => 'QuarterStart3',
				'name' => 'QuarterStart3',
				'value' => $QuarterStart3
			));
	?>&nbsp;<b>ถึง</b>&nbsp;
    <?php 
			echo InputCalendar_text(array(
				'id' => 'QuarterEnd3',
				'name' => 'QuarterEnd3',
				'value' => $QuarterEnd3
			));
	?>
      </div>
</td>
  </tr>
  <tr>
    <th valign="top">ไตรมาสที่ 4 <span style="font-weight:normal;">(ก.ค - ก.ย)</span></th>
    <td valign="top" class="require">*</td>
    <td>      
    <div>
        <?php 
			echo InputCalendar_text(array(
				'id' => 'QuarterStart4',
				'name' => 'QuarterStart4',
				'value' => $QuarterStart4
			));
	?>&nbsp;<b>ถึง</b>&nbsp;
        <?php 
			echo InputCalendar_text(array(
				'id' => 'QuarterEnd4',
				'name' => 'QuarterEnd4',
				'value' => $QuarterEnd4
			));
	?>
    </div>   
</td>
  </tr>  
  <tr>
    <th>&nbsp;</th>
    <td class="require"></td>
    <td><input type="submit" class="btnRed" name="save" id="save" value="บันทึก"  />
      <input type="button" name="button" id="button" value="ยกเลิก" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>');" /></td>
  </tr>
</table>

</form>

