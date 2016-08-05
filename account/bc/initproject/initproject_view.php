<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
/*	array(
		'text' => 'จัดการข้อมูลพื้นฐาน',
		'link' => '?mod=budget.init.startup',
	),*/
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'รายละเอียด',
	),
));

//ltxt::print_r($detail);

?>
<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $BgtYear;?>');" /></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th>ปีงบประมาณ</th>
    <td><?php echo $BgtYear; ?></td>
  </tr>
<tr>
  <th>รหัสโครงการ</th>
  <td><?php echo $PrjCode; ?></td>
</tr>  
<tr>
  <th>ชื่อโครงการ</th>
  <td><?php echo $PrjName;?></td>
</tr>
<tr>
  <th>ภายใต้แผนงาน สช.</th>
  <td id="pitembox"><?php echo $get->getPItemName($PItemCode); ?></td>
</tr>
<tr>
  <th>หน่วยงานเจ้าของโครงการ</th>
  <td id="orgbox"><?php  echo  $get->getOrgShortName($BgtYear,$OrganizeCode);  ?></td>
</tr>
<tr>
   <th valign="top">ผู้รับผิดชอบโครงการ</th>
   <td >
   <?php 
   	$TaskPerson = $get->getTaskPerson($PrjId); 
   echo "<ul>";
   foreach($TaskPerson as $rRName){
   		foreach($rRName as $k=>$v){
			${$k} = $v;
		}
		echo "<li>".$Name."</li>";
   }
   echo "</ul>";
	
   ?>
   </td>
 </tr>

<tr>
  <th>กรอบงบประมาณ</th>
  <td style="font-weight:bold"><div style="width:100px; text-align:right; float:left"><?php echo number_format($PrjBudget,2);?></div>&nbsp;บาท</td>
</tr>
<tr>
  <th>งบกลั่นกรองระดับสำนักงบประมาณ</th>
  <td style="font-weight:bold"><div style="width:100px; text-align:right; float:left"><?php echo number_format($get->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,0,0,2,1,0),2);?></div>&nbsp;บาท</td>
</tr>
<tr>
  <th>งบกลั่นกรองระดับอนุกรรมาธิการ</th>
  <td style="font-weight:bold"><div style="width:100px; text-align:right; float:left"><?php echo number_format($get->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,0,0,2,2,0),2);?></div>&nbsp;บาท</td>
</tr>
<tr>
  <th>งบจัดสรร</th>
  <td style="font-weight:bold"><div style="width:100px; text-align:right; float:left"><?php echo number_format($get->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,0,0,3,0,0),2);?></div>&nbsp;บาท</td>
</tr>
<tr>
  <th>งบปรับกลางปี</th>
  <td style="font-weight:bold"><div style="width:100px; text-align:right; float:left"><?php echo number_format($get->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,0,0,4,0,0),2);?></div>&nbsp;บาท</td>
</tr>
<tr>
  <th>วิธีการรายงานผลการดำเนินงาน</th>
  <td>
<?php if($PrjMethods == "monthly"){ echo 'รายเดือน'; } ?>
<?php if($PrjMethods == "quarterly"){ echo 'รายไตรมาส'; } ?>
  </td>
</tr>   
<tr>
  <th>วิธีการรายงานผลการดำเนินงาน</th>
  <td>
<?php if($PrjFeature == "continue"){ echo 'โครงการต่อเนื่อง'; } ?>
<?php if($PrjFeature == "discontinuous"){ echo 'โครงการไม่ต่อเนื่อง'; } ?>
  </td>
</tr>      
<tr>
  <th style="vertical-align:top">รายชื่อผู้รายงานผล</th>
  <td>
     <?php 
   	$TaskPersonSelect = $get->getTaskPerson($PrjId,'Y'); 
   echo "<ul>";
   foreach($TaskPersonSelect as $rs){
   		foreach($rs as $k=>$v){
			${$k} = $v;
		}
		echo "<li>".$Name."</li>";
   }
   echo "</ul>";
	
   ?>
  </td>
</tr>      
  
<tr>
  <th>&nbsp;</th>
  <td>
  <input type="button" name="button4" id="button4" value="กลับไปแก้ไข" class="btnRed" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>&id=<?php echo $_REQUEST['id'];?>&start=<?php echo $_REQUEST['start'];?>');"  />
  <input name="cancel" type="button" value="ย้อนกลับ" class="btn cancle" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $BgtYear;?>');" />
  </td>
 </tr>
</table>









