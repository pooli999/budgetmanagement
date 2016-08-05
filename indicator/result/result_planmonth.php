<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$planDetail = $get->getPlanDetail($_REQUEST["PItemCode"]);//ltxt::print_r($planDetail);
foreach( $planDetail as $row ) {
	foreach( $row as $k=>$v){ 
		${$k} = $v;
	}
}

$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบรายงานผลและตัวชี้วัด',
	),
	array(
		'text' => 'รายงานความก้าวหน้างาน',
		'link' => '?mod='.lurl::dotPage("result_main").'&BgtYear='.$BgtYear
	),
	array(
		'text' => "ความก้าวหน้าระดับแผนงาน สช.",
	),
));

function icoIndEdit($r){
	$label = 'บันทึกผล';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage('result_plan_ind_add')."&PItemId=".$r->PItemId."&PIndId=".$r->PIndId."'",
		'ico edit',
		$label,
		$label
	));
}


$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));




?>
<script  type="text/javascript">
function toPage(MonthNo){
	window.location.href='?mod=<?php echo lurl::dotPage("result_planmonth");?>&PItemCode=<?php echo $_REQUEST["PItemCode"];?>&MonthNo='+MonthNo+'#History';
}

	
</script>


<div class="sysinfo">
  <div class="sysname">รายงานความก้าวหน้างาน</div>
  <div class="sysdetail">&nbsp;</div>
</div>





<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="font-size:18px; color:#990000; font-weight:bold;">ข้อมูลระดับแผนงาน</td>
      <td style="text-align:right; padding-right:5px;">
        <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&amp;BgtYear=<?php echo $BgtYear;?>');" />
      </td>
    </tr>
  </table>  
</div>




<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $_REQUEST['PrjId'];?>" />
<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId'];?>" />
<input type="hidden" name="PrjActCode" id="PrjActCode" value="<?php echo $_REQUEST['PrjActCode'];?>" />
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId'];?>" />
<input type="hidden" name="OrgCode" id="OrgCode" value="<?php echo $_REQUEST['OrgCode'];?>" />
<input type="hidden" name="MonthNo" id="MonthNo" value="<?php echo $_REQUEST['pageid'];?>" />
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>" />




<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
<th style="vertical-align:top;">ชื่อแผนงาน</th>
<td style="font-weight:bold;">(<?php echo $PItemCode;?>) <?php echo $PItemName;?></td>
</tr>   
<tr>
<th>ปีงบประมาณ</th>
    <td><?php echo $BgtYear;?></td>
  </tr>
<tr>
  <th>วิธีการรายงานผลตัวชี้วัด</th>
  <td>
<?php if($Methods == "monthly"){ echo 'รายเดือน'; } ?>
<?php if($Methods == "quarterly"){ echo 'รายไตรมาส'; } ?>
  </td>
</tr>   
<tr>
<th>ภายใต้แผนหลัก</th>
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
    
    
    
    </td>
</tr>









  <tr>
  <th colspan="2" style="text-align:left;">ผลการดำเนินงานจำแนกตามโครงการภายใต้แผนงาน</th>
  </tr>
  <tr>
  <td colspan="2" style="background-color:#EEE; vertical-align:top;">
  
  <!--/////////////////////////////////////////////////////////////////////////////-->
  
<?php if($Methods == "monthly"){ ?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl-history-check">
  <thead>
    <tr>
      <td rowspan="2" style="width:40px;">ลำดับ</td>
      <td rowspan="2" style="text-align:center;">ชื่อโครงการ</td>
      <td rowspan="2" style="width:80px; text-align:center;">%ค่าน้ำหนัก</td>
      <td colspan="12" style="text-align:center;">%ดำเนินงานโครงการ</td>
      </tr>
    <tr>
      <td style="width:55px; text-align:center;">ต.ค</td>
      <td style="width:55px; text-align:center;">พ.ย</td>
      <td style="width:55px; text-align:center;">ธ.ค</td>
      <td style="width:55px; text-align:center;">ม.ค</td>
      <td style="width:55px; text-align:center;">ก.พ</td>
      <td style="width:55px; text-align:center;">มี.ค</td>
      <td style="width:55px; text-align:center;">เม.ย</td>
      <td style="width:55px; text-align:center;">พ.ค</td>
      <td style="width:55px; text-align:center;">มิ.ย</td>
      <td style="width:55px; text-align:center;">ก.ค</td>
      <td style="width:55px; text-align:center;">ส.ค</td>
      <td style="width:55px; text-align:center;">ก.ย</td>
      </tr>
    </thead>
<?php   
$n=0;
$selectAct = $get->getProjectList($_REQUEST["PItemCode"]);//ltxt::print_r($selectAct);
foreach($selectAct as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;} 
	$totalPercentMass	= $totalPercentMass+$PrjMass;
	
	$prog10 = $get->getPrjResultDetail($PrjCode,10);
	$prog11 = $get->getPrjResultDetail($PrjCode,11);
	$prog12 = $get->getPrjResultDetail($PrjCode,12);
	
	$prog1 = $get->getPrjResultDetail($PrjCode,1);
	$prog2 = $get->getPrjResultDetail($PrjCode,2);
	$prog3 = $get->getPrjResultDetail($PrjCode,3);
	
	$prog4 = $get->getPrjResultDetail($PrjCode,4);
	$prog5 = $get->getPrjResultDetail($PrjCode,5);
	$prog6 = $get->getPrjResultDetail($PrjCode,6);
	
	$prog7 = $get->getPrjResultDetail($PrjCode,7);
	$prog8 = $get->getPrjResultDetail($PrjCode,8);
	$prog9 = $get->getPrjResultDetail($PrjCode,9);
	
	$totalProgressAmass10= $totalProgressAmass10+$prog10[0]->PrjProgressAmass;
	$totalProgressAmass11= $totalProgressAmass11+$prog11[0]->PrjProgressAmass;
	$totalProgressAmass12= $totalProgressAmass12+$prog12[0]->PrjProgressAmass;
	
	$totalProgressAmass1= $totalProgressAmass1+$prog1[0]->PrjProgressAmass;
	$totalProgressAmass2= $totalProgressAmass2+$prog2[0]->PrjProgressAmass;
	$totalProgressAmass3= $totalProgressAmass3+$prog3[0]->PrjProgressAmass;
	
	$totalProgressAmass4 = $totalProgressAmass4+$prog4[0]->PrjProgressAmass;
	$totalProgressAmass5 = $totalProgressAmass5+$prog5[0]->PrjProgressAmass;
	$totalProgressAmass6 = $totalProgressAmass6+$prog6[0]->PrjProgressAmass;
	
	$totalProgressAmass7 = $totalProgressAmass7+$prog7[0]->PrjProgressAmass;
	$totalProgressAmass8 = $totalProgressAmass8+$prog8[0]->PrjProgressAmass;
	$totalProgressAmass9 = $totalProgressAmass9+$prog9[0]->PrjProgressAmass;

?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo ($n+1); ?></td>
      <td><a href="?mod=<?php echo LURL::dotPage("result_projectmonth"); ?>&PrjDetailId=<?php echo $PrjDetailId; ?>"><?php echo $PrjName;?></a></td>
      <td style="text-align:right;"><?php echo ($PrjMass)?(number_format($PrjMass,2)):"-";?></td>
      <td style="text-align:right;"><?php echo ($prog10[0]->PrjProgressAmass)?$prog10[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog10[0]->PrjProgressAmass)?$prog10[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog12[0]->PrjProgressAmass)?$prog12[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog1[0]->PrjProgressAmass)?$prog1[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog2[0]->PrjProgressAmass)?$prog2[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog3[0]->PrjProgressAmass)?$prog3[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog4[0]->PrjProgressAmass)?$prog4[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog5[0]->PrjProgressAmass)?$prog5[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog6[0]->PrjProgressAmass)?$prog6[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog7[0]->PrjProgressAmass)?$prog7[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog8[0]->PrjProgressAmass)?$prog8[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog9[0]->PrjProgressAmass)?$prog9[0]->PrjProgressAmass:'-'; ?></td>
      </tr> 
      
      
      
      
      
<?php	
	$n++;			
}
?>    

  
      <!--%ความก้าวหน้าโครงการ-->
      <tr style="vertical-align:top; color:#990000;">
      <td style="text-align:right;">&nbsp;</td>
      <td style="text-align:right;">%ความก้าวหน้าแผนงาน</td>
      <td style="text-align:right;"><?php echo number_format($totalPercentMass,2); ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass10)?(number_format($totalProgressAmass10,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass11)?(number_format($totalProgressAmass11,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass12)?(number_format($totalProgressAmass12,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass1)?(number_format($totalProgressAmass1,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass2)?(number_format($totalProgressAmass2,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass3)?(number_format($totalProgressAmass3,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass4)?(number_format($totalProgressAmass4,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass5)?(number_format($totalProgressAmass5,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass6)?(number_format($totalProgressAmass6,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass7)?(number_format($totalProgressAmass7,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass8)?(number_format($totalProgressAmass8,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass9)?(number_format($totalProgressAmass9,2)):'-'; ?></td>
      </tr> 
      <!--END %ความก้าวหน้าโครงการ-->

     </table>

<?php } ?>
<?php if($Methods == "quarterly"){ ?>

<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl-history-check">
  <thead>
    <tr>
      <td rowspan="2" style="width:40px;">ลำดับ</td>
      <td rowspan="2" style="text-align:center;">ชื่อโครงการ</td>
      <td rowspan="2" style="width:80px; text-align:center;">%ค่าน้ำหนัก</td>
      <td colspan="4" style="text-align:center;">%ดำเนินงานโครงการ</td>
      </tr>
    <tr>
      <td style="width:100px; text-align:center;">ไตรมาส1</td>
      <td style="width:100px; text-align:center;">ไตรมาส2</td>
      <td style="width:100px; text-align:center;">ไตรมาส3</td>
      <td style="width:100px; text-align:center;">ไตรมาส4</td>
      </tr>
    </thead>
<?php   
$n=0;
$selectAct = $get->getProjectList($_REQUEST["PItemCode"]);//ltxt::print_r($selectAct);
foreach($selectAct as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;} 
	$totalPercentMass	= $totalPercentMass+$PrjMass;
	
	$prog10 = $get->getPrjResultDetail($PrjCode,10);
	$prog11 = $get->getPrjResultDetail($PrjCode,11);
	$prog12 = $get->getPrjResultDetail($PrjCode,12);
	
	$prog1 = $get->getPrjResultDetail($PrjCode,1);
	$prog2 = $get->getPrjResultDetail($PrjCode,2);
	$prog3 = $get->getPrjResultDetail($PrjCode,3);
	
	$prog4 = $get->getPrjResultDetail($PrjCode,4);
	$prog5 = $get->getPrjResultDetail($PrjCode,5);
	$prog6 = $get->getPrjResultDetail($PrjCode,6);
	
	$prog7 = $get->getPrjResultDetail($PrjCode,7);
	$prog8 = $get->getPrjResultDetail($PrjCode,8);
	$prog9 = $get->getPrjResultDetail($PrjCode,9);
	
	$totalProgressAmass10= $totalProgressAmass10+$prog10[0]->PrjProgressAmass;
	$totalProgressAmass11= $totalProgressAmass11+$prog11[0]->PrjProgressAmass;
	$totalProgressAmass12= $totalProgressAmass12+$prog12[0]->PrjProgressAmass;
	
	$totalProgressAmass1= $totalProgressAmass1+$prog1[0]->PrjProgressAmass;
	$totalProgressAmass2= $totalProgressAmass2+$prog2[0]->PrjProgressAmass;
	$totalProgressAmass3= $totalProgressAmass3+$prog3[0]->PrjProgressAmass;
	
	$totalProgressAmass4 = $totalProgressAmass4+$prog4[0]->PrjProgressAmass;
	$totalProgressAmass5 = $totalProgressAmass5+$prog5[0]->PrjProgressAmass;
	$totalProgressAmass6 = $totalProgressAmass6+$prog6[0]->PrjProgressAmass;
	
	$totalProgressAmass7 = $totalProgressAmass7+$prog7[0]->PrjProgressAmass;
	$totalProgressAmass8 = $totalProgressAmass8+$prog8[0]->PrjProgressAmass;
	$totalProgressAmass9 = $totalProgressAmass9+$prog9[0]->PrjProgressAmass;

?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo ($n+1); ?></td>
      <td><a href="?mod=<?php echo LURL::dotPage("result_projectmonth"); ?>&PrjDetailId=<?php echo $PrjDetailId; ?>"><?php echo $PrjName;?></a></td>
      <td style="text-align:right;"><?php echo ($PrjMass)?(number_format($PrjMass,2)):"-";?></td>
      <td style="text-align:right;"><?php echo ($prog12[0]->PrjProgressAmass)?$prog12[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog3[0]->PrjProgressAmass)?$prog3[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog6[0]->PrjProgressAmass)?$prog6[0]->PrjProgressAmass:'-'; ?></td>
      <td style="text-align:right;"><?php echo ($prog9[0]->PrjProgressAmass)?$prog9[0]->PrjProgressAmass:'-'; ?></td>
      </tr> 
      
      
      
      
      
<?php	
	$n++;			
}
?>    

  
      <!--%ความก้าวหน้าโครงการ-->
      <tr style="vertical-align:top; color:#990000;">
      <td style="text-align:right;">&nbsp;</td>
      <td style="text-align:right;">%ความก้าวหน้าแผนงาน สช.</td>
      <td style="text-align:right;"><?php echo number_format($totalPercentMass,2); ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass12)?(number_format($totalProgressAmass12,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass3)?(number_format($totalProgressAmass3,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass6)?(number_format($totalProgressAmass6,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass9)?(number_format($totalProgressAmass9,2)):'-'; ?></td>
      </tr> 
      <!--END %ความก้าวหน้าโครงการ-->

     </table>

<?php } ?>

  <!--/////////////////////////////////////////////////////////////////////////////-->
    
    </td>
  </tr>
</table>

 <!--///////////////////////////////////////////////////////////////////////////////////////////////////////////-->   
<?php 
$dataIndicator = $get->getIndicatorItem($PItemId);//ltxt::print_r($dataIndicator);
if($dataIndicator){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list" >
  <tr>
  <th style="text-align:left;">ตัวชี้วัดแผนงาน</th>
  </tr>
  <tr>
  <td style="background-color:#EEE; vertical-align:top;">



<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl-history-check">
  <thead>
  <tr>
    <td rowspan="2" style="width:30px;">ลำดับ</td>
    <td rowspan="2" style="width:100px;">รหัส</td>
    <td rowspan="2" >ตัวชี้วัด</td>
    <td rowspan="2" style="width:100px;" >หน่วยนับ</td>
    <td colspan="3" class="tbl-list">ค่าเป้าหมาย</td>
    <td rowspan="2" style="width:70px;">ปฎิบัติการ</td>
  </tr>
  <tr>
    <td style="text-align:center; width:95px;">แผน</td>
    <td style="text-align:center; width:95px;">ผล</td>
    <td style="text-align:center; width:40px;">คะแนน</td>
  </tr>    
  </thead>
  <?php 
  $ind=1;
foreach($dataIndicator as $in){
		foreach( $in as $a=>$q){ ${$a} = $q;}
		 switch($CriterionType){
        	case "quantity":
            	$indPlan = $PIndQTTGPlan;
                $indResult = $PIndQTTGResult;
            break;
            case "quality":
            	$indPlan = $PIndQLTGPlan;
                $indResult = $PIndQLTGResult;
            break;
            default:
				$indPlan = "-";
                $indResult = "-";
        }
    ?>
        <tr style="vertical-align:top;">
          <td style="text-align:center;"><?php echo $ind; ?></td>
          <td style="text-align:center;"><?php echo $PIndCode; ?></td>
          <td>
          <a href="javascript:void(0)" style="color:#003399" onclick="window.open('?mod=<?php echo LURL::dotPage('result_plan_ind'); ?>&format=raw&PItemId=<?php echo $PItemId; ?>&PIndId=<?php echo $PIndId; ?>',null,'scrollbars=yes,height=500,width=1200,toolbar=yes,menubar=yes,status=yes');">
		  <?php echo $PIndName;?>
          </a>
          </td>
          <td style="text-align:center;"><?php echo $UnitName;?></td>
          <td style="text-align:center;"><?php echo $indPlan; ?></td>
          <td style="text-align:center;"><?php echo $indResult; ?></td>
          <td style="text-align:center;"><span class="icon-col<?php echo $PIndTGScore; ?>">&nbsp;</span></td>
          <td style="text-align:center;"><?php echo icoIndEdit($in); ?></td>
    </tr>
        <?php		
				$ind++;		
            }
	?>
</table>




</td>
</tr>
</table>

<?php
}
?>
 <!--///////////////////////////////////////////////////////////////////////////////////////////////////////////-->

      
</form>

<div style="text-align:right; padding:4px; margin-top:10px;"><a href="#" class="icon-up">กลับสู่ด้านบน</a></div>
