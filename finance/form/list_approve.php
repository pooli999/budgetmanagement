<?php 
include("helper.php");
$get = new sHelper();

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));


$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบงบประมาณการเงิน',
	),
	array(
		'text' => 'อนุมัติเอกสารการเงิน',
	),
));


function icoEdit($r){
	$label = "บันทึกผลอนุมัติ";
	$Form = strtolower($r->FormCode);
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=finance.form.".$Form.".approve&FormCode=".$r->FormCode."&DocCode=".$r->DocCode."'",
		'ico edit',
		$label,
		$label
	));
}// end




?>

<div class="sysinfo">
<div class="sysname">อนุมัติเอกสารการเงิน</div>
<div class="sysdetail">&nbsp;</div>
</div>


<div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="tbl-summary">
	<tr style="vertical-align:top;">
    
    
     	  <td style="width:180px; padding-right:5px;">
<div style="background-color:#FCC; padding:5px; font-weight:bold;">สรุปตามสถานะเอกสาร</div>  


<!--xxxxx-->  
<table style="width:100%;"  border="0" cellspacing="0" cellpadding="0" class="tbl-item" >
  <tr style="vertical-align:top; font-weight:bold;">
    <td style="text-align:left;">เอกสารทั้งหมด</td>
    <td style="width:40px; text-align:right;"><?php echo $get->getCountItem(); ?></td>
    </tr>
<?php
$state = $get->getStatusList();//ltxt::print_r($list);
foreach($state as $r ) {
	foreach( $r as $k=>$v){ ${$k} = $v;}
	$total = $get->getCountItem($DocStatusId);
?> 
  <tr style="vertical-align:top;">
    <td style="text-align:left;"><div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div></td>
    <td style="text-align:right;"><?php echo ($total)?$total:"-"; ?></td>
    </tr>
<?php
}
?>  
</table>
<!--xxxxxx-->
      
      </td>    
  
    
    
    
    
   	  <td>
      	  
      	  
  <!--รายการเอกสารล่าสุด 10 รายการของคุณ-->
  <div style="background-color:#9CC; padding:5px; font-weight:bold; border-bottom:1px solid #FFF;">รายการเอกสารทั้งหมด</div>


<table style="width:100%;"  border="0" cellspacing="1" cellpadding="0" class="tbl-list" >
  <tr>
    <th style="width:40px;">ลำดับ</th>
    <th style="width:70px;">รหัสเอกสาร</th>
    <th style="width:80px;">วันที่เอกสาร</th>	
    <th style="width:80px;">เลขที่ สช.น</th>
    <th>ชื่อเรื่อง</th>
    <th style="width:150px;">ชื่อผู้อนุมัติ</th>
    <th style="width:100px;">ปฏิบัติการ</th>
  </tr>
<?php
$list = $get->getApproveDataList(30);//ltxt::print_r($list);
$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
if($list['total'] > 0){
          foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?> 
  <tr style="vertical-align:top;" title="<?php echo $FormCode; ?> <?php echo $FormName; ?> : <?php echo $Topic; ?>">
    <td style="text-align:center;"><?php echo $i; ?></td>
    <td style="text-align:center;"><?php echo $FormCode; ?></td>
    <td style="text-align:center;"><?php echo ShowDate($DocDate); ?></td>	
    <td style="text-align:center;"><?php echo ltxt::highlight_phrase($DocCode,$_REQUEST['DocCode']);?></td>
    <td style="text-align:left;"><?php echo $Title;?></td>
    <td><?php echo ($ApproveBy)?($get->fn_getFullNameByPersonalCode($ApproveBy)):'<span style="color:#999;">-ไม่ระบุ-</span>'; ?></td>
    <td style="text-align:center;"><?php if($DocStatusId == 3){ echo icoEdit($r); } ?></td>
    </tr>
<?php

		$i++;
		}
	}else{
?>  
 <tr>
 <td colspan="7"><div class="nullDataList" style="color:#990000;">ไม่มีข้อมูล</div></td>
 </tr> 
<?php } ?> 
</table>



<?php if($list['total'] > 0){ ?>
<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>$list['total'],'limit'=>30,'start'=>$_REQUEST["start"]));?>
</div>
<?php } ?>







  <!--END รายการเอกสารล่าสุด 10 รายการของคุณ-->
      	  
      	  
      </td>
      




    
      
    </tr>
 </table>
 
 </div>
 
 
 <br /><br /><br />




