<?php   
$dataPrj=$this->getProjectView($_REQUEST['PrjDetailId']);
foreach( $dataPrj as $row ) {
	foreach( $row as $k=>$v){ 
		${$k} = $v;
	}
}

$p=1;
$selectAct = $this->getProjectDetailActRecordSet($PrjDetailId);//ltxt::print_r($selectAct);
foreach($selectAct as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;} 
?>    
<div style="padding:3px; background-color:#CCC;"><u>กิจกรรมที่ <?php echo $p; ?></u>  <?php echo $PrjActName;?></div>


 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->  
 <?php if($PrjMethods == "monthly"){ ?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check2">
  <thead>
    <tr>
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
$detail10 = $this->getResultDetail($PrjActCode,10);//ltxt::print_r($detail10);
foreach($detail10 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;">ตุลาคม</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $this->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => $PrjActCode.'MultiDocId10',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
        


        
      </td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


<?php
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail11 = $this->getResultDetail($PrjActCode,11);//ltxt::print_r($detail11);
foreach($detail11 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
      
       <tr style="vertical-align:top;">
      <td style="text-align:center;">พฤศจิกายน</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $this->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => $PrjActCode.'MultiDocId11',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail12 = $this->getResultDetail($PrjActCode,12);//ltxt::print_r($detail12);
foreach($detail12 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
      
       <tr style="vertical-align:top;">
      <td style="text-align:center;">ธันวาคม</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $this->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => $PrjActCode.'MultiDocId11',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail1 = $this->getResultDetail($PrjActCode,1);//ltxt::print_r($detail);
foreach($detail1 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
          <td style="text-align:center;">มกราคม</td>
          <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
          <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
          <td><?php echo ($Result)?$Result:'-';?></td>
          <td><?php echo ($Problem)?$Problem:'-';?></td>
          <td><?php echo ($Factor)?$Factor:'-';?></td>
          <td>
          <?php  
                
            $MultiDocId = $this->getLinkFiles($ResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => $PrjActCode.'MultiDocId1',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
          </td>
          <td><?php echo ($Comment)?$Comment:'-';?></td>
        </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail2 = $this->getResultDetail($PrjActCode,2);//ltxt::print_r($detail);
foreach($detail2 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">กุมภาพันธ์</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $this->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => $PrjActCode.'MultiDocId2',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail3 = $this->getResultDetail($PrjActCode,3);//ltxt::print_r($detail);
foreach($detail3 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">มีนาคม</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $this->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => $PrjActCode.'MultiDocId3',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 

 
 
<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail4 = $this->getResultDetail($PrjActCode,4);//ltxt::print_r($detail);
foreach($detail4 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">เมษายน</td>
          <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
          <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
          <td><?php echo ($Result)?$Result:'-';?></td>
          <td><?php echo ($Problem)?$Problem:'-';?></td>
          <td><?php echo ($Factor)?$Factor:'-';?></td>
          <td>
          <?php  
                
            $MultiDocId = $this->getLinkFiles($ResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => $PrjActCode.'MultiDocId4',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
          </td>
          <td><?php echo ($Comment)?$Comment:'-';?></td>
        </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail5 = $this->getResultDetail($PrjActCode,5);//ltxt::print_r($detail);
foreach($detail5 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">พฤษภาคม</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $this->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => $PrjActCode.'MultiDocId5',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail6 = $this->getResultDetail($PrjActCode,6);//ltxt::print_r($detail);
foreach($detail6 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">มิถุนายน</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $this->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => $PrjActCode.'MultiDocId6',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail7 = $this->getResultDetail($PrjActCode,7);//ltxt::print_r($detail);
foreach($detail7 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
         <td style="text-align:center;">กรกฏาคม</td>
         <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
          <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
          <td><?php echo ($Result)?$Result:'-';?></td>
          <td><?php echo ($Problem)?$Problem:'-';?></td>
          <td><?php echo ($Factor)?$Factor:'-';?></td>
          <td>
          <?php  
                
            $MultiDocId = $this->getLinkFiles($ResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => $PrjActCode.'MultiDocId7',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
          </td>
          <td><?php echo ($Comment)?$Comment:'-';?></td>
        </tr>
       
 
 
 <?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail8 = $this->getResultDetail($PrjActCode,8);//ltxt::print_r($detail);
foreach($detail8 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
      
       <tr style="vertical-align:top;">
         <td style="text-align:center;">สิงหาคม</td>
         <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
          <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
          <td><?php echo ($Result)?$Result:'-';?></td>
          <td><?php echo ($Problem)?$Problem:'-';?></td>
          <td><?php echo ($Factor)?$Factor:'-';?></td>
          <td>
          <?php  
                
            $MultiDocId = $this->getLinkFiles($ResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => $PrjActCode.'MultiDocId8',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
          </td>
          <td><?php echo ($Comment)?$Comment:'-';?></td>
        </tr>
       
<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail9 = $this->getResultDetail($PrjActCode,9);//ltxt::print_r($detail);
foreach($detail9 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       

       <tr style="vertical-align:top;">
         <td style="text-align:center;">กันยายน</td>
         <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
         <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
         <td><?php echo ($Result)?$Result:'-';?></td>
         <td><?php echo ($Problem)?$Problem:'-';?></td>
         <td><?php echo ($Factor)?$Factor:'-';?></td>
         <td>
           <?php  
                
            $MultiDocId = $this->getLinkFiles($ResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => $PrjActCode.'MultiDocId9',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
          </td>
         <td><?php echo ($Comment)?$Comment:'-';?></td>
        </tr> 
     </table>

<?php } ?>
<?php if($PrjMethods == "quarterly"){ ?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check2">
  <thead>
    <tr>
      <td style="width:100px; text-align:center;">ไตรมาสที่</td>
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
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail12 = $this->getResultDetail($PrjActCode,12);//ltxt::print_r($detail12);
foreach($detail12 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
      
       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส1</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $this->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => $PrjActCode.'MultiDocId11',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


       <?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment); 
$detail3 = $this->getResultDetail($PrjActCode,3);//ltxt::print_r($detail);
foreach($detail3 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส2</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $this->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => $PrjActCode.'MultiDocId3',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 
 
 
       <?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail6 = $this->getResultDetail($PrjActCode,6);//ltxt::print_r($detail);
foreach($detail6 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส3</td>
      <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
      <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
      <td><?php echo ($Result)?$Result:'-';?></td>
      <td><?php echo ($Problem)?$Problem:'-';?></td>
      <td><?php echo ($Factor)?$Factor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $this->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => $PrjActCode.'MultiDocId6',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      </tr> 


       <?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment); 
$detail9 = $this->getResultDetail($PrjActCode,9);//ltxt::print_r($detail);
foreach($detail9 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       

       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส4</td>
         <td style="text-align:center;"><?php echo ($Progress)?$Progress:"-";?></td>
         <td style="text-align:center;"><?php echo ($ProgressAmass)?$ProgressAmass:"-";?></td>
         <td><?php echo ($Result)?$Result:'-';?></td>
         <td><?php echo ($Problem)?$Problem:'-';?></td>
         <td><?php echo ($Factor)?$Factor:'-';?></td>
         <td>
           <?php  
                
            $MultiDocId = $this->getLinkFiles($ResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => $PrjActCode.'MultiDocId9',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
           </td>
         <td><?php echo ($Comment)?$Comment:'-';?></td>
        </tr> 
     </table>

<?php } ?>
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////--> 



<?php	
	$p++;			
}
?>  