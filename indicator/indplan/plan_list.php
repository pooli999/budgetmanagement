<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));
$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบรายงานผลและตัวชี้วัด',
	),
	array(
		'text' => 'ตัวชี้วัดระดับแผนหลัก',
	),
));


function icoIndEdit($r){
	$label = 'บันทึกผล';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage('plan_ind')."&LPlanCode=".$r->LPlanCode."&LindId=".$r->LindId."'",
		'ico edit',
		$label,
		$label
	));
}
?>

<script>
function loadSCT(PLongCode){
	window.location.href='?mod=<?php echo lurl::dotPage('plan_list');?>&PLongCode='+PLongCode;
}
</script>

<script language="javascript" type="text/javascript">
	function Search(){
		var tsearch=JQ('#tsearch').val();
		window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&tsearch="+ tsearch;
	}
	
function toggleSub(id){
	JQ("a#icoClass_"+id).toggleClass("minimize");
	JQ("tr.hideRow_"+id).toggle();
}

function printDocument(){
	/*window.location.href="?mod=<?php //echo LURL::dotPage('plan_print')?>&format=raw<?php //echo $get->getQueryString(); ?>";*/
}

function saveToExcel(){
	/*window.location.href="?mod=<?php //echo LURL::dotPage('plan_excel')?>&format=raw<?php //echo $get->getQueryString(); ?>";*/
}
</script>

<div class="sysinfo">
  <div class="sysname">ตัวชี้วัดระดับแผนหลัก</div>
  <div class="sysdetail">&nbsp;</div>
</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbl-button">
  <tr>
    <td>
     <a href="javascript:printDocument();" class="icon-printer">พิมพ์</a>&nbsp;
    <a href="javascript:saveToExcel();" class="icon-excel">ส่งออกเป็น Excel</a>
    </td>
  </tr>
</table>



<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td>&nbsp;</td>
       <td style="text-align:right;">ชื่อแผนหลัก <?php echo $get->getYearMainPlan(ltxt::getVar('PLongCode'),'PLongCode');?></td>
    </tr>
  </table>
</div>
<table width="100%" class="tbl-list" border="1"  cellspacing="จ" cellpadding="0" style="margin-top:0px;">
  <tr>
    <th style="width:30px;">ลำดับ</th>
    <th nowrap="nowrap">ชื่อแผนงานภายใต้แผนหลัก 5 ปี</th>
    <th style="width:100px;">ผล (ร้อยละ) </th>
    <th style="text-align:center;width:70px;" >ปฏิบัติการ</th>
  </tr>
  <tr style="background-color:#dfc7df; vertical-align:top;">
    <td style="text-align:center">&nbsp;</td>
    <td nowrap="nowrap"><strong>แผนงานปีงบประมาณ 2555-2559</strong></td>
    <td style="text-align:center;"></td>
    <td style="text-align:center;">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">1</td>
    <td align="left" nowrap="nowrap">(001) มีการนำสาระสำคัญในธรรมนูญว่าด้วยระบบสุขภาพแห่งชาติฯ ไปใช้ในการจัดทำแผนปฏิบัติราชการ และแผนประจำปีของหน่วยงานยุทธศาสตร์ </td>
    <td align="center" style="width:100px;">90.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span>
</a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">2</td>
    <td align="left" nowrap="nowrap">(002)  มีการจัดทำธรรมนูญสุขภาพพื้นที่ หรือนำสาระของธรรมนูญว่าด้วยระบบสุขภาพแห่งชาติฯ ไปประกอบการจัดทำแผนพัฒนาสุขภาพในระดับพื้นที่และมีการดำเนินการตามแผน อย่างน้อย ๑๐๐ แห่ง</td>
    <td align="center" style="width:100px;">75.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">3</td>
    <td align="left" nowrap="nowrap">(003)  มีธรรมนูญว่าด้วยระบบสุขภาพแห่งชาติ ฉบับที่สอง</td>
    <td align="center" style="width:100px;">84.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">4</td>
    <td align="left" nowrap="nowrap">(004) มีข้อเสนอนโยบายสาธารณะเพื่อสุขภาพที่คณะรัฐมนตรีให้ความเห็นชอบ และมีการนำไปสู่การปฏิบัติ อย่างน้อย ๒๕ เรื่อง</td>
    <td align="center" style="width:100px;">85.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">5</td>
    <td align="left" nowrap="nowrap">(005) มีรายงานสถานการณ์ระบบสุขภาพแห่งชาติที่สะท้อนสถานการณ์ในภาพรวม และประเด็นสำคัญ อย่างน้อย ๑๕ ฉบับ</td>
    <td align="center" style="width:100px;">94.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">6</td>
    <td align="left" nowrap="nowrap">(006) มีการขับเคลื่อนมติและข้อเสนอเชิงนโยบายจากสมัชชาสุขภาพแห่งชาติจนเกิดผลการปฏิบัติอย่างน้อย ๕๐ เรื่อง</td>
    <td align="center" style="width:100px;">97.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">7</td>
    <td align="left" nowrap="nowrap">(007) มีการใช้สมัชชาสุขภาพเฉพาะพื้นที่ในการพัฒนานโยบายสาธารณะเพื่อสุขภาพและมีการดำเนินการตามข้อเสนอเชิงนโยบาย ในทุกจังหวัดทั่วประเทศ</td>
    <td align="center" style="width:100px;">70.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">8</td>
    <td align="left" nowrap="nowrap">(008) มีการใช้สมัชชาสุขภาพเฉพาะประเด็นในการพัฒนานโยบายสาธารณะเพื่อสุขภาพและมีการดำเนินการตามข้อเสนอเชิงนโยบายในเรื่องต่างๆ อย่างน้อย ๕๐ เรื่อง</td>
    <td align="center" style="width:100px;">80.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">9</td>
    <td align="left" nowrap="nowrap">(009) 	มีการใช้สมัชชาสุขภาพเฉพาะพื้นที่ และสมัชชาสุขภาพเฉพาะประเด็นในการพัฒนานโยบายสาธารณะที่หนุนเสริมการปฏิรูปประเทศไทยอย่างต่อเนื่อง</td>
    <td align="center" style="width:100px;">90.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">10</td>
    <td align="left" nowrap="nowrap">(010)  เกิดระบบและกลไกที่เชื่อมโยงทุกภาคส่วนของสังคมในการร่วมกันพัฒนา เอชไอเอ ให้เป็นเครื่องมือสำคัญในการกำหนดทิศทางการพัฒนา</td>
    <td align="center" style="width:100px;">96.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">11</td>
    <td align="left" nowrap="nowrap">(011)  มีการทำงานกับกลุ่มประเทศอาเซียน ประเทศในภูมิภาคเอเชียตะวันออกเฉียงใต้ และเครือข่ายระหว่างประเทศ เพื่อพัฒนาและใช้ เอชไอเอ ร่วมกัน </td>
    <td align="center" style="width:100px;">91.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">12</td>
    <td align="left" nowrap="nowrap">(012)  ชุมชนท้องถิ่นมีการนำเครื่องมือ เอชไอเอ ไปใช้ เพิ่มขึ้น อย่างน้อย ๒๕๐ พื้นที่</td>
    <td align="center" style="width:100px;">82.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">13</td>
    <td align="left" nowrap="nowrap">(013) หลักเกณฑ์และวิธีการทำ เอชไอเอสามารถนำไปปฏิบัติได้อย่างสอดคล้องกับบริบทของสังคมไทย</td>
    <td align="center" style="width:100px;">86.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">14</td>
    <td align="left" nowrap="nowrap">(014) หน่วยงาน องค์กร และภาคีต่างๆ มีการทำ เอชไอเอ ในหลายระดับ</td>
    <td align="center" style="width:100px;">78.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">15</td>
    <td align="left" nowrap="nowrap">(015)  มีการตัดสินใจเลือกทางเลือกเชิงนโยบายต่างๆ ที่เป็นผลดีต่อสุขภาพของประชาชน โดยการใช้ผลการทำ เอชไอเอ เป็นข้อมูลประกอบอย่างสำคัญ </td>
    <td align="center" style="width:100px;">87.00</td>
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></td>
  </tr>
  <tr>
    <td align="center" style="width:30px;">16</td>
    <td align="left" nowrap="nowrap">(016)  องค์กรวิชาชีพ สถานพยาบาล และภาคีเครือข่ายต่างๆ ที่เกี่ยวข้อง มีการรับรู้ เข้าใจ เรื่องสิทธิและหน้าที่ด้านสุขภาพตาม พ.ร.บ. สุขภาพแห่งชาติ อย่างน้อยร้อยละ ๓๐</td>
    <td align="center" style="width:100px;">91
    .00
    <td style="text-align:center;" ><a class="ico edit" title="บันทึกผล" href="javascript:self.location='?mod=indicator.indplan.plan_ind_1&LPlanCode=V02M01&LindId=1'">
<span>บันทึกผล</span></a></th>  </tr>
</table>
<table width="100%" class="tbl-list" border="1"  cellspacing="จ" cellpadding="0" style="margin-top:0px;">
  <tr>
    <th rowspan="2" style="width:30px;">ลำดับ</th>
    <th rowspan="2" nowrap="nowrap">ชื่อแผนงานภายใต้แผนหลัก 5 ปี</th>
    <th rowspan="2" style="width:100px;">หน่วยนับ</th>
    <th colspan="3">ค่าเป้าหมาย</th>
    <th rowspan="2" style="text-align:center;width:70px;" >ปฏิบัติการ</th>
  </tr>
  <tr>
    <th style="width:95px;">แผน</th>
    <th style="width:95px;">ผล</th>
    <th style="width:40px;">คะแนน</th>
  </tr>
<tbody>
<!--รายการแผนหลัก-->
<?php
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	
	if($list){
          foreach($list as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
 <!-- <tr style="background-color:#dfc7df; vertical-align:top;">
    <td style="text-align:center"><?php //echo $i ;?></td>
    <td nowrap="nowrap"><?php //echo icoView($r);?><?php// echo $PLongName; ?></td>
    <td style="text-align:center;"><?php// echo $PLongYear;?></td>
    <td style="text-align:center;"><?php// echo $PLongYearEnd;?></td>
    <td style="text-align:center;"><?php //echo $PLongAmount;?></td>
    <td style="text-align:center;">&nbsp;</td>
    <td style="text-align:center;">&nbsp;</td>
    <td style="text-align:center;">&nbsp;</td>
    <td style="text-align:center;">&nbsp;</td>
    <td style="width:80px;">&nbsp;</td>
    </tr>-->
  
  
  
  
<!--รายการแผนงาน--> 
<?php 
$d=1;
$dataPlan = $get->getPlanItem($PLongCode);//ltxt::print_r($dataPlan);
if($dataPlan){
	foreach($dataPlan as $r){
		foreach( $r as $k=>$v){ ${$k} = $v;}
?>    

<tr style="background-color:#c9e39c; vertical-align:top;">
    <td style="text-align:center;"><?php echo $i.".".$d; ?></td>
    <td colspan="5" >(<?php echo $LPlanCode; ?>) <?php echo $LPlanName; ?></td>
    <td>&nbsp;</td>
    </tr> 


<!--รายการตัวชี้วัด-->

<?php 
$t=1;
$dataIndicator = $get->getIndicatorItem($LPlanCode);//ltxt::print_r($dataIndicator);
if($dataIndicator){
	foreach($dataIndicator as $in){
		foreach( $in as $a=>$q){ ${$a} = $q;}
        switch($CriterionType){
        	case "quantity":
            	$indPlan = $LindQTTGPlan;
                $indResult = $LindQTTGResult;
            break;
            case "quality":
            	$indPlan = $LindQLTGPlan;
                $indResult = $LindQLTGResult;
            break;
            default:
				$indPlan = "-";
                $indResult = "-";
        }
?>    

<tr style="vertical-align:top;">
    <td>&nbsp;</td>
    <td>(<?php echo $LindCode; ?>) <a href="?mod=<?php echo LURL::dotPage('plan_ind_view'); ?>&LPlanCode=<?php echo $LPlanCode; ?>&LindId=<?php echo $LindId; ?>"><?php echo $LindName; ?></a></td>
    <td style="text-align:center;"><?php echo ($UnitID)?($get->getUnitName($UnitID)):''; ?></td>
    <td style="text-align:center;"><?php echo $indPlan; ?></td>
    <td style="text-align:center;"><?php echo $indResult; ?></td>
    <td style="text-align:center;"><span class="icon-col<?php echo $LindTGScore; ?>">&nbsp;</span></td>
    <td><?php echo icoIndEdit($in);?></td>
    </tr> 
  
<?php				
			$t++;
	}
}
?>   
<!--END รายการตัวชี้วัด-->









  
<?php				
			$d++;
	}
}
?>   
<!--END รายการแผนงาน-->  
  

  
<?php

		$i++;
		}
	}
?>
<!--END รายการแผนหลัก-->
</tbody>
</table>
<?php
if(!$list){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>

<div style="text-align:right; padding:4px; margin-top:10px;"><a href="#" class="icon-up">กลับสู่ด้านบน</a></div>
