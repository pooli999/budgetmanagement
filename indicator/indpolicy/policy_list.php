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
		'text' => 'ตัวชี้วัดระดับแผนงาน',
	),
));

function icoIndEdit($r){
	$label = 'บันทึกผล';
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage('policy_ind_add')."&PItemId=".$r->PItemId."&PIndId=".$r->PIndId."'",
		'ico edit',
		$label,
		$label
	));
}

?>

<script language="javascript" type="text/javascript">
function loadSCT(BgtYear){
	window.location.href='?mod=<?php echo lurl::dotPage($listPage);?>&BgtYear='+BgtYear;
}
function printDocument(){
	/*window.location.href="?mod=<?php //echo LURL::dotPage('policy_print')?>&format=raw<?php //echo $get->getQueryString(); ?>";*/
}

function saveToExcel(){
	/*window.location.href="?mod=<?php //echo LURL::dotPage('policy_excel')?>&format=raw<?php //echo $get->getQueryString(); ?>";*/
}
</script>


<div class="sysinfo">
  <div class="sysname">ตัวชี้วัดระดับแผนงาน</div>
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
        <td align="right">ปีงบประมาณ <?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?></td>
    </tr>
  </table>
</div>







<table width="100%" border="1" class="tbl-list" cellspacing="0" cellpadding="0">
  <thead>
  <tr>
    <th rowspan="2" align="center" style="width:30px;">ลำดับ</th>
    <th rowspan="2" align="center">แผนงาน สช.</th>
    <th rowspan="2" align="center" style="width:100px;">หน่วยนับ</th>
    <th colspan="3">ค่าเป้าหมาย</th>
    <th rowspan="2" align="center" style="width:70px;">ปฏิบัติการ</th>
  </tr>
  <tr>
    <th style="text-align:center; width:95px;">แผน</th>
    <th style="text-align:center; width:95px;">ผล</th>
    <th style="text-align:center; width:40px;">คะแนน</th>
    </tr>
</thead>

<?php
$item=$get->getItemList(12); //ltxt::print_r($item);
if($item){
	$t=1; 
	foreach( $item as $grp ) {
		foreach( $grp as $k=>$v){ ${$k} = $v;}
?>
              <tr style="background-color:#EEE;" valign="top">
                <td style="text-align:center"><?php echo $t; ?></td>
                <td><?php echo "(".$PItemCode.") ".$PItemName; ?></td>
                <td valign="top">&nbsp;</td>
                <td style="width:60px;" nowrap="nowrap" valign="top"  >&nbsp;</td>
                <td style="width:60px;" nowrap="nowrap" valign="top"  >&nbsp;</td>
                <td style="width:60px;" nowrap="nowrap" valign="top"  >&nbsp;</td>
                <td style="width:60px;" nowrap="nowrap" valign="top"  >&nbsp;</td>
              </tr>  
              
<!--รายการตัวชี้วัด-->
<?php 
$d=1;
$dataIndicator = $get->getIndicatorItem($PItemId);//ltxt::print_r($dataIndicator);
if($dataIndicator){
?>
<?php
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
  <td>&nbsp;</td>
  <td>(<?php echo $PIndCode; ?>) <a href="?mod=<?php echo LURL::dotPage('policy_ind_view'); ?>&amp;PItemId=<?php echo $PItemId; ?>&amp;PIndId=<?php echo $PIndId; ?>"><?php echo $PIndName; ?></a></td>
  <td style="text-align:center;"><?php echo ($UnitID)?($get->getUnitName($UnitID)):''; ?></td>
  <td style="text-align:center;"><?php echo $indPlan; ?></td>
  <td style="text-align:center;"><?php echo $indResult; ?></td>
  <td style="text-align:center;"><span class="icon-col<?php echo $PIndTGScore; ?>">&nbsp;</span></td>
    <td><?php echo icoIndEdit($in);?></td>
  </tr> 
  
<?php				
			$d++;
	}
}
?>   
<!--END รายการตัวชี้วัด-->

<?php
		$t++;
	 }
}
 ?>
             
</table>


<?php
if(!$t){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>

<br />
<br />
<br />
          
