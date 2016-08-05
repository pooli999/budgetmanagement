<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบรายงานผลและตัวชี้วัด',
	),
	array(
		'text' => 'ตัวชี้วัดระดับโครงการ',
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));


function icoEdit($r){
	$label = 'บันทึกผล';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage('project_ind_add')."&PrjIndId=".$r->PrjIndId." '",
		'ico edit',
		$label,
		$label
	));
}


?>

<script>
function loadSCT(BgtYear){
	window.location.href='?mod=<?php echo lurl::dotPage("project_list");?>&BgtYear='+BgtYear;
}
</script>

<div class="sysinfo">
  <div class="sysname">ตัวชี้วัดระดับโครงการ</div>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td>&nbsp;</td>
      <td align="right">ปีงบประมาณ <?php echo $get->getYearProject(ltxt::getVar('BgtYear'),'BgtYear');?></td>
    </tr>
  </table>  
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;">
  <tr>
    <th rowspan="2" style="width:30px;">ลำดับ</th>
    <th rowspan="2" >โครงการ/ตัวชี้วัด</th>
    <th rowspan="2" style="width:100px;" >หน่วยนับ</th>
    <th colspan="3" class="tbl-list">ค่าเป้าหมาย</th>
    <th rowspan="2" style="width:70px;">ปฎิบัติการ</th>
  </tr>
  <tr>
    <th class="tbl-list" style="text-align:center; width:95px;">แผน</th>
    <th class="tbl-list" style="text-align:center; width:95px;">ผล</th>
    <th class="tbl-list" style="text-align:center; width:40px;">คะแนน</th>
  </tr>
  
<?php
$p=1;
$project = $get->getProject();//ltxt::print_r($project);
foreach($project as $detailprj){
	foreach($detailprj as $k=>$v){
		${$k} = $v;
	}
?>
  
  
          <tr style="vertical-align:top; background-color:#EEE;">
          <td style="text-align:center;"><?php echo $p; ?></td>
          <td>(<?php echo $PrjCode; ?>) <?php echo $PrjName; ?></td>
          <td>&nbsp;</td>
          <td style="text-align:center;">&nbsp;</td>
          <td style="text-align:center;">&nbsp;</td>
          <td style="text-align:center;">&nbsp;</td>
          <td style="text-align:center; width:25px;">&nbsp;</td>
    </tr>
  
  
  
  
  <?php 
  $i=1;
    $indicatorSelect = $get->getIndicatorSelect($PrjDetailId);//ltxt::print_r($indicatorSelect);
     if($indicatorSelect){
            foreach($indicatorSelect as $r){
                foreach( $r as $k=>$v){ ${$k} = $v;}
         		switch($CriterionType){
				case "quantity":
					$indPlan = $QTTGPlan;
					$indResult = $QTTGResult;
				break;
				case "quality":
					$indPlan = $QLTGPlan;
					$indResult = $QLTGResult;
				break;
				default:
					$indPlan = "-";
					$indResult = "-";
			}
    ?>
        <tr style="vertical-align:top;">
          <td style="text-align:center;">&nbsp;</td>
          <td> (<?php echo $IndicatorCode; ?>) <a href="?mod=<?php echo LURL::dotPage('project_ind_view'); ?>&amp;PrjIndId=<?php echo $PrjIndId; ?>&amp;BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&amp;OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&amp;PrjId=<?php echo $_REQUEST["PrjId"]; ?>&amp;PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>&amp;SCTypeId=<?php echo $_REQUEST["SCTypeId"]; ?>&amp;ScreenLevel=<?php echo $_REQUEST["ScreenLevel"]; ?>"><?php echo $IndicatorName;?></a></td>
          <td style="text-align:center;"><?php echo $UnitName;?></td>
          <td style="text-align:center;"><?php echo $indPlan; ?></td>
          <td style="text-align:center;"><?php echo $indResult; ?></td>
          <td style="text-align:center;"><span class="icon-col<?php echo $TGScore; ?>">&nbsp;</span></td>
          <td style="text-align:center;"><?php echo icoEdit($r); ?></td>
    </tr>
        <?php		
				$i++;		
            }
        }
	?>
    
    
 <?php
	$p++;
}
?>  
<?php if($p==1){ ?>
<tr>
	<td colspan="7" style="background-color:#EEE; padding:20px; text-align:center; color:#999;">-ไม่พบรายการข้อมูล-</td>
</tr>
<?php } ?> 
    
</table>

<br /><br /><br />








