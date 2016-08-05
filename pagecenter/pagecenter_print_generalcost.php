<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
//ltxt::print_r($detail);	
?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	//window.print();
/*  ]]> */
</script>
<style>
	td{
		font-family:"TH SarabunPSK";
		font-size:16pt; 
		line-height:100%;
	}

</style>

<style type="text/css" media="print">
   .print{ display:none;}
</style>

<table width="800" border="0" cellspacing="1" cellpadding="0"   align="center">
  <tr><td colspan="2" align="left" style="padding-bottom:10px"><u>สรุปรายการประมาณการค่าใช้จ่าย :</u></td></tr>
<?php 		
$groupList = $get->getCostGroupGeneral('tblintra_eform_formal_general_cost','DocCode','CostId',$DocCode);
//ltxt::print_r($groupList);
if($groupList){
	$i=1;
	foreach($groupList as $rg){
 ?>

          <tr>
            <td style="text-align:left; width:70%; vertical-align:top; "><?php echo $i.". ".$get->getCostItemName($rg->CostItemCode); ?></td>
            <td style="text-align:right; width:30%; vertical-align:top;padding-left:10px; "><!--<strong><?php //echo number_format($get->getSumCostGeneral('tblintra_eform_formal_general_cost','DocCode',$DocCode,$PrjActCode,$rg->CostItemCode,0),2); ?> บาท</strong>-->&nbsp;</td>
          </tr>

		   <?php  		
		   		$costList = $get->getCostItemListGeneral('tblintra_eform_formal_general_cost','DocCode','CostId',$DocCode,$rg->CostItemCode);
				//ltxt::print_r($costList);
				foreach($costList as $rc){
					foreach( $rc as $k=>$v){ ${$k} = $v;}				
 		   ?>
              <tr>
                <td style="text-align:left; width:70%; vertical-align:top; padding-left:17px "><?php echo "- ".$DetailCost; ?></td>
                <td style="text-align:right; width:30%; vertical-align:top;padding-left:10px; "><?php echo number_format($SumCost,2);?> บาท</td>
              </tr>      
          <?php } ?>  
          
                      <tr>
                        <td style="text-align:right; vertical-align:top;">รวมทั้งสิ้น</td>
                        <td style="text-align:right; vertical-align:top;padding-left:10px"><span class="textcolor"><?php echo number_format($get->getSumCostGeneral('tblintra_eform_formal_general_cost','DocCode',$DocCode,$PrjActCode,$rg->CostItemCode,0),2); ?></span> บาท</td>
                      </tr>            
            
<?php $i++; } ?>
		<tr><td colspan="3" height="5"></td></tr>	
          <tr >
          <td style="text-align:right;">(<?php echo JThaiBaht::_($get->getSumCostGeneral('tblintra_eform_formal_general_cost','DocCode',$DocCode,$PrjActCode,0,0)); ?>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รวมทุกหมวดงบประมาณ</td>
          <td style="text-align:right;padding-left:10px; "><?php echo number_format($get->getSumCostGeneral('tblintra_eform_formal_general_cost','DocCode',$DocCode,$PrjActCode,0,0),2); ?> บาท</td>
          </tr>
<?php 
}else{ 
echo '<tr><td align="center" height="300" style="color:#f00;">- - ไม่มีรายการชี้แจง - -</td></tr>';
} 
?>
</table>

<?php if($groupList){ ?>
<br />
<div style="padding-top:30px; text-align:center;">
  <input name="print" type="button" value="พิมพ์เอกสาร"  onclick="window.print();" class="print" style="color:#009"  />
<input name="print" type="button" value="ปิดหน้าต่าง"  onclick="window.close();" class="print" style="color:#000"  />
</div>
<?php } ?>
