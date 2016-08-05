<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$dataPrj=$get->getProjectDetail($_REQUEST['PrjActId']);//ltxt::print_r($dataPrj);
foreach( $dataPrj as $row ) {
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
		'text' => "ความก้าวหน้าระดับกิจกรรม",
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));


function icoResult($PrjActId,$MonthNo){
	$label = 'ปรับปรุง';
	global $addMonthPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addMonthPage)."&PrjActId=".$PrjActId."&MonthNo=".$MonthNo."'",
		'ico edit',
		$label,
		$label
	));
}

?>



<script  type="text/javascript">
function Save(form){	
	if(validateSubmit()){
		form.submit();
	}
}

function validateSubmit(){
	//% ความก้าวหน้า
	if(JQ('#Progress').val()==""){
		alert("กรุณากรอก % ความก้าวหน้า");
		JQ('Progress').focus();
		return false
	}
	
	return true;
}

function toPage(MonthNo){
	window.location.href='?mod=<?php echo lurl::dotPage($addMonthPage);?>&PrjActId=<?php echo $_REQUEST["PrjActId"];?>&MonthNo='+MonthNo;
}

	
</script>

<div class="sysinfo">
  <div class="sysname">รายงานความก้าวหน้างาน</div>
  <div class="sysdetail">&nbsp;</div>
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#eeebac;">
  <tr>
    <td style="padding:5px;">
    <a href="javascript:saveToWord()" class="ico print">พิมพ์</a>&nbsp;
    <a href="javascript:saveToWord()" class="icon-word">ส่งออกเป็น Word</a>
    </td>
    <td style="text-align:right; padding-right:5px;">&nbsp;</td>
  </tr>
</table>




<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="font-size:18px; color:#990000; font-weight:bold;">ข้อมูลระดับกิจกรรม</td>
      <td  style="text-align:right; padding-right:5px;">
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage("result_main");?>&BgtYear=<?php echo $BgtYear;?>');" />
      </td>
    </tr>
  </table>  
</div>



<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId'];?>" />
<input type="hidden" name="PrjActCode" id="PrjActCode" value="<?php echo $PrjActCode;?>" />
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $BgtYear;?>" />



<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th>ชื่อกิจกรรม</th>
    <td style="font-weight:bold;"><?php echo $get->getPrjActName($_REQUEST["PrjActId"]); ?></td>
  </tr>
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
    <th>หน่วยงานปฏิบัติงาน</th>
    <td><?php echo $get->getOrgName($BgtYear,$OrganizeCodeAct);?></td>
  </tr>   
  <tr>
    <th>ระยะเวลากิจกรรม</th>
    <td><?php echo dateformat($StartDate);?><b> ถึง </b><?php echo dateformat($EndDate);?></td>
  </tr> 
    <tr>
    <th>ค่าน้ำหนักกิจกรรม</th>
    <td><?php echo $PercentMass;?> %ของโครงการ</td>
  </tr> 
<tr>
  	<th colspan="2" valign="top">ผลการดำเนินงานรายเดือน/ไตรมาส</th>
</tr>
<tr>
  <td colspan="2" valign="top">

<?php if($PrjMethods == "monthly"){ ?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
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
      <td style="width:80px; text-align:center;">ปฏิบัติการ</td>
      </tr>
    </thead>
<?php 
$detail10 = $get->getResultDetail($PrjActCode,10);//ltxt::print_r($detail10);
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
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      <td style="text-align:center;"><?php echo icoResult($PrjActId,10); ?></td>
      </tr> 


<?php
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail11 = $get->getResultDetail($PrjActCode,11);//ltxt::print_r($detail11);
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
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      <td style="text-align:center;"><?php echo icoResult($PrjActId,11); ?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail12 = $get->getResultDetail($PrjActCode,12);//ltxt::print_r($detail12);
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
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      <td style="text-align:center;"><?php echo icoResult($PrjActId,12); ?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail1 = $get->getResultDetail($PrjActCode,1);//ltxt::print_r($detail);
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
          <td><?php echo ($Comment)?$Comment:'-';?></td>
          <td style="text-align:center;"><?php echo icoResult($PrjActId,1); ?></td>
        </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail2 = $get->getResultDetail($PrjActCode,2);//ltxt::print_r($detail);
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
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      <td style="text-align:center;"><?php echo icoResult($PrjActId,2); ?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail3 = $get->getResultDetail($PrjActCode,3);//ltxt::print_r($detail);
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
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      <td style="text-align:center;"><?php echo icoResult($PrjActId,3); ?></td>
      </tr> 
 
 
<?php 
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail4 = $get->getResultDetail($PrjActCode,4);//ltxt::print_r($detail);
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
          <td><?php echo ($Comment)?$Comment:'-';?></td>
          <td style="text-align:center;"><?php echo icoResult($PrjActId,4); ?></td>
        </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail5 = $get->getResultDetail($PrjActCode,5);//ltxt::print_r($detail);
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
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      <td style="text-align:center;"><?php echo icoResult($PrjActId,5); ?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail6 = $get->getResultDetail($PrjActCode,6);//ltxt::print_r($detail);
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
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      <td style="text-align:center;"><?php echo icoResult($PrjActId,6); ?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail7 = $get->getResultDetail($PrjActCode,7);//ltxt::print_r($detail);
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
          <td><?php echo ($Comment)?$Comment:'-';?></td>
          <td style="text-align:center;"><?php echo icoResult($PrjActId,7); ?></td>
        </tr>
       
 
 
 <?php 
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail8 = $get->getResultDetail($PrjActCode,8);//ltxt::print_r($detail);
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
          <td><?php echo ($Comment)?$Comment:'-';?></td>
          <td style="text-align:center;"><?php echo icoResult($PrjActId,8); ?></td>
        </tr>
       
<?php 
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail9 = $get->getResultDetail($PrjActCode,9);//ltxt::print_r($detail);
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
         <td><?php echo ($Comment)?$Comment:'-';?></td>
         <td style="text-align:center;"><?php echo icoResult($PrjActId,9); ?></td>
        </tr> 
     </table>

<?php } ?>
<?php if($PrjMethods == "quarterly"){ ?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
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
      <td style="width:80px; text-align:center;">ปฏิบัติการ</td>
      </tr>
    </thead>
       <?php 
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail12 = $get->getResultDetail($PrjActCode,12);//ltxt::print_r($detail12);
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
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      <td style="text-align:center;"><?php echo icoResult($PrjActId,12); ?></td>
      </tr> 


       <?php 
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment); 
$detail3 = $get->getResultDetail($PrjActCode,3);//ltxt::print_r($detail);
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
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      <td style="text-align:center;"><?php echo icoResult($PrjActId,3); ?></td>
      </tr> 
 
 
       <?php 
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
$detail6 = $get->getResultDetail($PrjActCode,6);//ltxt::print_r($detail);
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
      <td><?php echo ($Comment)?$Comment:'-';?></td>
      <td style="text-align:center;"><?php echo icoResult($PrjActId,6); ?></td>
      </tr> 


       <?php 
unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment); 
$detail9 = $get->getResultDetail($PrjActCode,9);//ltxt::print_r($detail);
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
         <td><?php echo ($Comment)?$Comment:'-';?></td>
         <td style="text-align:center;"><?php echo icoResult($PrjActId,9); ?></td>
        </tr> 
     </table>

<?php } ?>

    
    
  </td>
  </tr>         
</table>


      
</form>

<br />
<br />
<br />