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
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'เพิ่ม'.$MenuName
	),
));

//ltxt::print_r($_GET);
?>
<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td style="padding:3px; font-weight:bold; font-size:16px;"><?php echo $get->getPGroupName($PGroupId);?></td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $BgtYear;?>');" /></td>
  </tr>
</table>


<!--<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-item" >
<tr class="title-bar2">
<td  style="padding-left:20px"><?php //echo $get->getPGroupName($PGroupId);?>&nbsp;</td>
</tr>
</table>-->


<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
<th>ปีงบประมาณ</th>
    <td><?php echo $BgtYear;?></td>
  </tr>
<tr>
<th style="vertical-align:top;">ชื่อ<?php echo $get->getPGroupName($PGroupId);?></th>
<td style="font-weight:bold;">(<?php echo $PItemCode;?>) <?php echo $PItemName;?></td>
</tr>   
<!--<tr>
<th>แผนงานต่อเนื่องที่เกี่ยวข้อง</th>
<td>
<?php
/*$ArrPlanSelect = $get->getPlanLongtermSelect($PItemId); 
//ltxt::print_r($ArrPlanSelect);
if($ArrPlanSelect){
	foreach($ArrPlanSelect as $r){
		echo '<div style="padding-bottom:5px">&bull; '.$get->getPlanLongName($PLongCode).'</div>';
	}
}
*/
	?>            
</td>
</tr>         
-->

<?php if($PGroupId == 12){ ?>
<tr>
  <th>วิธีการรายงานผลตัวชี้วัด</th>
  <td>
<?php if($Methods == "monthly"){ echo 'รายเดือน'; } ?>
<?php if($Methods == "quarterly"){ echo 'รายไตรมาส'; } ?>
  </td>
</tr>   
<tr>
<th>อ้างอิงแผนหลัก</th>
<td><?php echo ($LPlanCode)?($get->getLPlanName($LPlanCode)):('<span style="color:#999;">-ไม่ระบุ-</span>'); ?></td>
</tr>


<tr>
	<th colspan="2">เป้าประสงค์ของแผนงาน</th>
</tr>
<tr>
	<td colspan="2">
    
    
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
    <thead>
      <tr>
        <td class="no" style="width:10px">ลำดับ</td>
        <td align="left" >ชื่อเป้าประสงค์</td>
        </tr>
    </thead>
    <tbody>
<?php
	$n=1;
	$purpose = $get->getPurposeItem($PItemCode);
	if($purpose){
          foreach($purpose as $pp ) {
				foreach( $pp as $u=>$t){ ${$u} = $t;}
?>
  <tr>
    <td valign="top" style="text-align:center;"><?php echo $n ;?>.</td>
    <td valign="top" ><?php echo $PurposeName;?></td>
    </tr>
  
<?php

		$n++;
		}
	}
?>
    </tbody>
</table>
<?php
if(!$purpose){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>
    
    
    
    </td>
</tr>


<?php } ?>


<tr>
	<th colspan="2">ตัวชี้วัดของแผนงาน</th>
</tr>
<tr>
	<td colspan="2">
    
    
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
    <thead>
      <tr>
        <td class="no" style="width:10px">ลำดับ</td>
        <td align="left"  style="width:100px;">รหัสตัวชี้วัด</td>
        <td align="left" >ชื่อตัวชี้วัด</td>
        <td align="center" style="width:120px;">ค่าเป้าหมาย</td>
        <td align="center" style="width:120px;">หน่วยนับ</td>
        </tr>
    </thead>
    <tbody>
<?php

	//ltxt::print_r($list["rows"]);
	$i=1;
	$datas = $get->getIndicatorItem($_REQUEST["id"]);
	if($datas){
          foreach($datas as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
  <tr>
    <td valign="top" style="text-align:center;"><?php echo $i ;?>.</td>
    <td valign="top" style="text-align:center;"><?php echo $PIndCode; ?></td>
    <td valign="top" ><a href="?mod=<?php echo LURL::dotPage('policy_ind_view'); ?>&PItemId=<?php echo $PItemId; ?>&PIndId=<?php echo $PIndId; ?>"><?php echo $PIndName;?></a></td>
    <td valign="top" style="text-align:center;"><?php echo ($PIndTargetPlan)?$PIndTargetPlan:'<span style="color:#999;">-ไม่ระบุ-</span>';?>&nbsp;</td>
    <td valign="top" style="text-align:center;"><?php echo ($UnitID)?($get->getUnitName($UnitID)):('<span style="color:#999;">-ไม่ระบุ-</span>');?></td>    
    </tr>
  
<?php

		$i++;
		}
	}
?>
    </tbody>
</table>
<?php
if(!$datas){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>
    
    
    
    </td>
</tr>
</table>








<div style="text-align:center; padding:8px;">
  <input type="button" name="button4" id="button4" value=" ปรับปรุงข้อมูล " class="btnRed" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>&id=<?php echo $_REQUEST['id'];?>&start=<?php echo $_REQUEST['start'];?>');"  />
  <input name="cancel" type="button" value=" ย้อนกลับ " class="btn cancle" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $BgtYear;?>');" />
</div>









