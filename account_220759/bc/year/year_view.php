<?php 
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));

//ltxt::print_r($detail);

?>

<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr class="td-descr">
      <td style=" text-align:right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>');" /></td>
    </tr>
  </table>
</div>

<?php

	$SumBGTotal=$get->getTotalPrj($BgtYear);
	$SumPay = 0;
	$SumStatement = 0;
	$TotalBG = $SumBGTotal - $SumPay;
	$TotalBGStatement = $SumBGTotal - $SumPay - $SumStatement;


?>

<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-view">
  <tr>
    <th>ปีงบประมาณ :</th>
    <td><?php echo $BgtYear; ?></td>
  </tr>
  <tr>
    <th>สถานะ :</th>
    <td><?php if($CloseStatus == "Y"){echo '<span class="ico red">ปิดปีงบประมาณ</span>';}else{ echo '<span class="ico green">เปิดปีงบประมาณ</span>';}; ?></td>
  </tr>  
  <tr>
    <th colspan="2">ข้อมูลหน่วยงาน :</th>
  </tr>   
  <tr>
    <td  colspan="2" valign="top">
    
        <table width="100%" border="1" cellspacing="0" cellpadding="0"  class="tbl-view" style="background-color:#eee">
        			<tr  style="height:26px; ">
                    	<th style="width:2%; text-align:left">ลำดับ</th>
                        <th  style="width:25%; text-align:center">หน่วยงาน</th>
                    	<th  style="width:33%; text-align:center">ขั้นตอนปัจจุบัน</th>

                    </tr>
<?php
$j = 0; //ltxt::print_r($datas);
$datas = $get->dataSetView();
if($datas){														
	foreach($datas as $row){
		foreach($row as $k=>$v){ ${$k} = $v; }
?>
                      <tr  style="height:26px;">
                        <td style="border-bottom: 0px; text-align:center"><?php echo ($j+1); ?></td>
                        <td style="border-bottom: 0px;">
                           <?php echo $OrgName; ?>
                        </td>
                        <td style="border-bottom: 0px;"><?php echo ($ScreenLevel)?$get->getScreenName($BgtYear,$ScreenLevel):"-"; ?></td>
                      </tr>
<?php 
		$j++;             
	}// level = 1
} // foreach      
?>    
        </table>
    
    
    </td>
  </tr> 
 <tr>
    <th>&nbsp;</th>
    <td>
    <?php if($CloseStatus == "N"){ ?>
    <input type="button" name="edit" id="edit" value="ปรับปรุงข้อมูล" class="btnRed"  onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>&id=<?php echo $BgtYear;?>');" />
    <input type="button" name="close" id="close" value="ปิดปีงบประมาณ" class="btn"  onclick="goPage('?mod=<?php echo lurl::dotPage($closePage);?>&start=<?php echo $_REQUEST['start'];?>&id=<?php echo $BgtYear;?>');" />
    <?php } ?>
    <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>');" />
    
    </td>
  </tr>
</table>



