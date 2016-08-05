<?php
header("Content-type: text/html; charset=tis-620");
header("Content-Disposition: attachment; filename=Plan".date("d-m-Y").".xls");
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

?>


<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
<style>
body {
	 font-family:TH SarabunPSK; 
	 font-size: 14px; 
	 margin:20px;
}
.tbl-list {
	border-collapse:collapse;
	font-family:TH SarabunPSK; 
	font-size: 14px; 
}
.tbl-list th {
	border:1px solid #999;
	padding-left:3px;
	padding-right:3px;
}
.tbl-list td {
	border:1px solid #999;
	padding-left:3px;
	padding-right:3px;
}
.sum-total {
	text-align:right;
}
</style>
</HEAD>
<BODY>


<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;">
  <tr>
    <th align="center" >รายการค่าใช้จ่าย</th>
    </tr>

<?php
	// หมวดเงินงบประมาณ
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	if($list["rows"]){
          foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
  <tr class="cate">
    <td valign="top" style=" font-weight:bold;"  ><?php echo $CostTypeName;?></td>
  </tr>
  <tbody id="body-cate<?php echo $i; ?>">
		   <?php
           //วน loop รายการงบรายจ่าย ระดับที่ 1
          $NumLevel1 = 1; 
          $BGLevel1 = $get->getCostItemRecordSet($CostTypeId);
		 // ltxt::print_r($BGLevel1);
          foreach($BGLevel1 as $BGLevel1Row){ 
            foreach($BGLevel1Row as $c=>$d){
                ${$c} = $d;
            }
          ?>
           <tr>
              <td valign="top" style="padding-left:22px" >|-- <?php echo "[".$CostItemCode."] ".$CostName; ?></td>
          </tr> 
          
				   <?php
				   //วน loop รายการงบรายจ่าย ระดับที่ 2
                  $NumLevel2 = 1; 
                  $BGLevel2 = $get->getCostItemRecordSet($CostTypeId,2,$CostItemCode);
				  //ltxt::print_r($BGLevel2);
                  foreach($BGLevel2 as $BGLevel2Row){ 
                    foreach($BGLevel2Row as $e=>$f){
                        ${$e} = $f;
                    }
                  ?>          
                   <tr>
                      <td valign="top" style="padding-left:36px" >|-- <?php echo "[".$CostItemCode."] ".$CostName; ?></td>
                  </tr>  
                  
						   <?php
						  //วน loop รายการงบรายจ่าย ระดับที่ 3
                          $NumLevel3 = 1; 
                          $BGLevel3 = $get->getCostItemRecordSet($CostTypeId,3,$CostItemCode);
						  // ltxt::print_r($BGLevel3);
                          foreach($BGLevel3 as $BGLevel3Row){ 
                            foreach($BGLevel3Row as $g=>$h){
                                ${$g} = $h;
                            }                        
                          ?>
                           <tr >
                              <td valign="top" style="padding-left:50px" >|-- <?php echo "[".$CostItemCode."] ".$CostName; ?></td>
                          </tr>                  
							<?php
                                    $NumLevel3++;
                                    }
                            ?>                    
 
					<?php
                            $NumLevel2++;
                            }
                    ?>  
           
			<?php
                    $NumLevel1++;
                    }
            ?>  

  </tbody>
<?php

		$i++;
		}
	}
?>

</table>

<div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div> 

</BODY>

</HTML>


