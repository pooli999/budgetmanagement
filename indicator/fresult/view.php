<?php
$dataPrj=$get->getProjectDetail($_REQUEST['PrjActId']);//ltxt::print_r($dataPrj);
foreach( $dataPrj as $row ) {
	foreach( $row as $k=>$v){ 
		${$k} = $v;
	}
}

?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th style="width:20%;">ปีงบประมาณ</th>
    <td  style="width:80%;"><?php echo $BgtYear;?></td>
  </tr>
  <tr>
    <th>ชื่อโครงการ</th>
    <td><?php echo $PrjName;?></td>
  </tr>
  <tr>
    <th>เจ้าของโครงการ</th>
    <td><?php echo $get->getOrgName($BgtYear, $OrganizeCode);?></td>
  </tr>
  <tr>
    <th>วิธีการรายงานผล</th>
    <td><?php if($PrjMethods == "quarterly"){echo "รายไตรมาส";}else{echo "รายเดือน";} ?></td>
  </tr>    
  <tr>
    <th>ชื่อกิจกรรม</th>
    <td style="font-weight:bold;"><?php echo $get->getPrjActName($_REQUEST["PrjActId"]); ?></td>
  </tr>
  <tr>
    <th>หน่วยงานปฏิบัติงาน</th>
    <td><?php echo $get->getOrgName($BgtYear, $OrganizeCodeAct);?></td>
  </tr>   
  <tr>
    <th>ระยะเวลากิจกรรม</th>
    <td><?php echo dateformat($StartDate);?><b> ถึง </b><?php echo dateformat($EndDate);?></td>
  </tr> 
    <tr>
    <th>%ค่าน้ำหนักกิจกรรม</th>
    <td><?php echo $PercentMass;?></td>
  </tr> 
  <tr>
  	<th colspan="2" valign="top">ตัวชี้วัดของกิจกรรมในโครงการ</th>
  </tr>

  <tr>
  <td colspan="2" valign="top">
  
  
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
<thead>
  <tr>
    <td style="width:40px;">ลำดับ</td>
    <td style="text-align:center;">ชื่อตัวชี้วัดกิจกรรม</td>
        <td style="width:120px; text-align:center;">ค่าเป้าหมาย</td>
        <td style="width:100px; text-align:center;">หน่วยนับ</td>
    </tr>
    </thead>
	<?php
    $indicatorSelect = $get->getIndicatorActSelect($_REQUEST["PrjActId"]);//ltxt::print_r($indicatorSelect);
     if($indicatorSelect){
         $count = 1;
            foreach($indicatorSelect as $r){
                foreach( $r as $k=>$v){ ${$k} = $v;}
    ?>    
    <tr>
      <td style="text-align:center;"><?php echo $count; ?></td>
      <td><?php echo $IndicatorName;?></td>
    <td style="text-align:center;"><?php echo $Value;?></td>
    <td><?php echo $UnitName;?></td>
	</tr>    
	<?php				
                $count++;
            }
        }else{
	?>		
    <tr>
    <td colspan="4" style="height:30; text-align:center; vertical-align:middle"><span style="color:#999;">-ไม่ระบุ-</span></td>
    </tr>
	<?php		
		}
    ?>     
	</table>  
    

<tr>
  	<th colspan="2" valign="top">ผลการดำเนินงานรายเดือน/ไตรมาส</th>
</tr>
<tr>
  <td colspan="2" valign="top">

<?php 
	$detail = $get->getResultDetail($PrjActCode,$_REQUEST['MonthNo']);//ltxt::print_r($detail);
	foreach($detail as $drow){
		foreach($drow as $k=>$v){
			${$k} = $v;
		}
	}
?>













<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
  <thead>
    <tr>
      <td style="width:100px; text-align:center;">ไตรมาสที่</td>
      <td style="width:100px; text-align:center;">เดือน</td>
      <td style="width:80px; text-align:center;">%ดำเนินงาน</td>
      <td style="width:100px; text-align:center;">%ก้าวหน้าโครงการ</td>
      <td style="width:100px; text-align:center;">ผลดำเนินการ</td>
      <td style="width:100px; text-align:center;">ปัญหา/อุปสรรค</td>
      <td style="width:100px; text-align:center;">ปัจจัยสนับสนุน</td>
      <td style="text-align:center;">เอกสารแนบ</td>
      <td style="width:100px; text-align:center;">หมายเหตุ</td>
      </tr>
    </thead>
<?php 
$detail11 = $get->getResultDetail($PrjActCode,10);
foreach($detail11 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
    <tr style="vertical-align:top;">
      <td rowspan="3" style="text-align:center;">ไตรมาส 1</td>
      <td style="text-align:center;">ตุลาคม</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Problem)?$Problem:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Factor)?$Factor:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'MultiDocId10',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      </tr> 


<?php
unset($Progress); 
unset($PercentMass);
unset($ProgressAmass);
unset($Result);
unset($Problem);
unset($Factor);
unset($ResultId);
unset($Comment);
$detail12 = $get->getResultDetail($PrjActCode,11);//ltxt::print_r($detail);
foreach($detail12 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
      
       <tr style="vertical-align:top;">
      <td style="text-align:center;">พฤศจิกายน</td>
      <td style="text-align:center;"><?php echo ($PercentMass)?$PercentMass:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Problem)?$Problem:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Factor)?$Factor:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'MultiDocId11',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      </tr> 


<?php 
unset($Progress); 
unset($PercentMass);
unset($ProgressAmass);
unset($Result);
unset($Problem);
unset($Factor);
unset($ResultId);
unset($Comment);
$detail12 = $get->getResultDetail($PrjActCode,12);//ltxt::print_r($detail);
foreach($detail12 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
      
       <tr style="vertical-align:top;">
      <td style="text-align:center;">ธันวาคม</td>
      <td style="text-align:center;"><?php echo ($PercentMass)?$PercentMass:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Problem)?$Problem:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Factor)?$Factor:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'MultiDocId11',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      </tr> 


<?php 
unset($Progress); 
unset($PercentMass);
unset($ProgressAmass);
unset($Result);
unset($Problem);
unset($Factor);
unset($ResultId);
unset($Comment);
$detail1 = $get->getResultDetail($PrjActCode,1);//ltxt::print_r($detail);
foreach($detail1 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
          <td rowspan="3" style="text-align:center;">ไตรมาส 2</td>
          <td style="text-align:center;">มกราคม</td>
          <td style="text-align:center;"><?php echo ($PercentMass)?$PercentMass:"-";?></td>
          <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
          <td><?php echo ($Result)?$Result:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
          <td><?php echo ($Problem)?$Problem:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
          <td><?php echo ($Factor)?$Factor:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
          <td>
          <?php  
                
            $MultiDocId = $get->getLinkFiles($ResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => 'MultiDocId1',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
          </td>
          <td><?php echo ($Comment)?$Comment:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      </tr> 


<?php 
unset($Progress); 
unset($PercentMass);
unset($ProgressAmass);
unset($Result);
unset($Problem);
unset($Factor);
unset($ResultId);
unset($Comment);
$detail2 = $get->getResultDetail($PrjActCode,2);//ltxt::print_r($detail);
foreach($detail2 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">กุมภาพันธ์</td>
      <td style="text-align:center;"><?php echo ($PercentMass)?$PercentMass:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Problem)?$Problem:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Factor)?$Factor:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'MultiDocId2',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      </tr> 


<?php 
unset($Progress); 
unset($PercentMass);
unset($ProgressAmass);
unset($Result);
unset($Problem);
unset($Factor);
unset($ResultId);
unset($Comment);
$detail3 = $get->getResultDetail($PrjActCode,3);//ltxt::print_r($detail);
foreach($detail3 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">มีนาคม</td>
      <td style="text-align:center;"><?php echo ($PercentMass)?$PercentMass:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Problem)?$Problem:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Factor)?$Factor:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'MultiDocId3',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      </tr> 
 
 
<?php 
unset($Progress); 
unset($PercentMass);
unset($ProgressAmass);
unset($Result);
unset($Problem);
unset($Factor);
unset($ResultId);
unset($Comment);
$detail4 = $get->getResultDetail($PrjActCode,4);//ltxt::print_r($detail);
foreach($detail4 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td rowspan="3" style="text-align:center;">ไตรมาส 3</td>
      <td style="text-align:center;">เมษายน</td>
          <td style="text-align:center;"><?php echo ($PercentMass)?$PercentMass:"-";?></td>
          <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
          <td><?php echo ($Result)?$Result:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
          <td><?php echo ($Problem)?$Problem:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
          <td><?php echo ($Factor)?$Factor:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
          <td>
          <?php  
                
            $MultiDocId = $get->getLinkFiles($ResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => 'MultiDocId4',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
          </td>
          <td><?php echo ($Comment)?$Comment:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>

      </tr> 


<?php 
unset($Progress); 
unset($PercentMass);
unset($ProgressAmass);
unset($Result);
unset($Problem);
unset($Factor);
unset($ResultId);
unset($Comment);
$detail5 = $get->getResultDetail($PrjActCode,5);//ltxt::print_r($detail);
foreach($detail5 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">พฤษภาคม</td>
      <td style="text-align:center;"><?php echo ($PercentMass)?$PercentMass:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Problem)?$Problem:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Factor)?$Factor:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'MultiDocId5',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      </tr> 


<?php 
unset($Progress); 
unset($PercentMass);
unset($ProgressAmass);
unset($Result);
unset($Problem);
unset($Factor);
unset($ResultId);
unset($Comment);
$detail6 = $get->getResultDetail($PrjActCode,6);//ltxt::print_r($detail);
foreach($detail6 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">มิถุนายน</td>
      <td style="text-align:center;"><?php echo ($PercentMass)?$PercentMass:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Problem)?$Problem:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td><?php echo ($Factor)?$Factor:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'MultiDocId6',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
      </tr> 


<?php 
unset($Progress); 
unset($PercentMass);
unset($ProgressAmass);
unset($Result);
unset($Problem);
unset($Factor);
unset($ResultId);
unset($Comment);
$detail7 = $get->getResultDetail($PrjActCode,7);//ltxt::print_r($detail);
foreach($detail7 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
         <td rowspan="3" style="text-align:center;">ไตรมาส 4</td>
         <td style="text-align:center;">กรกฏาคม</td>
         <td style="text-align:center;"><?php echo ($PercentMass)?$PercentMass:"-";?></td>
          <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
          <td><?php echo ($Result)?$Result:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
          <td><?php echo ($Problem)?$Problem:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
          <td><?php echo ($Factor)?$Factor:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
          <td>
          <?php  
                
            $MultiDocId = $get->getLinkFiles($ResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => 'MultiDocId7',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
          </td>
          <td><?php echo ($Comment)?$Comment:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
       </tr>
       
 
 
 <?php 
 unset($Progress); 
unset($PercentMass);
unset($ProgressAmass);
unset($Result);
unset($Problem);
unset($Factor);
unset($ResultId);
unset($Comment);
$detail8 = $get->getResultDetail($PrjActCode,8);//ltxt::print_r($detail);
foreach($detail8 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
      
       <tr style="vertical-align:top;">
         <td style="text-align:center;">สิงหาคม</td>
         <td style="text-align:center;"><?php echo ($PercentMass)?$PercentMass:"-";?></td>
          <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
          <td><?php echo ($Result)?$Result:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
          <td><?php echo ($Problem)?$Problem:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
          <td><?php echo ($Factor)?$Factor:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
          <td>
          <?php  
                
            $MultiDocId = $get->getLinkFiles($ResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => 'MultiDocId8',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
          </td>
          <td><?php echo ($Comment)?$Comment:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
       </tr>
       
<?php 
unset($Progress); 
unset($PercentMass);
unset($ProgressAmass);
unset($Result);
unset($Problem);
unset($Factor);
unset($ResultId);
unset($Comment);
$detail9 = $get->getResultDetail($PrjActCode,9);//ltxt::print_r($detail);
foreach($detail9 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       

       <tr style="vertical-align:top;">
         <td style="text-align:center;">กันยายน</td>
         <td style="text-align:center;"><?php echo ($PercentMass)?$PercentMass:"-";?></td>
         <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
         <td><?php echo ($Result)?$Result:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
         <td><?php echo ($Problem)?$Problem:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
         <td><?php echo ($Factor)?$Factor:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
         <td>
           <?php  
                
            $MultiDocId = $get->getLinkFiles($ResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => 'MultiDocId9',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
           </td>
         <td><?php echo ($Comment)?$Comment:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
       </tr> 
     </table>


















    
    
    
  </td>
  </tr>         
</table>
