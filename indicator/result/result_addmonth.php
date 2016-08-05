<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

if($_REQUEST['PrjActId']){
	$dataPrj=$get->getProjectDetail($_REQUEST['PrjActId']);//ltxt::print_r($dataPrj);
	foreach( $dataPrj as $row ) {
		foreach( $row as $k=>$v){ 
			${$k} = $v;
		}
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
		'text' => 'บันทึกความก้าวหน้าระดับกิจกรรม',
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));




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
	//window.location.href='?mod=<?php //echo lurl::dotPage($addMonthPage);?>&PrjId=<?php //echo $_REQUEST["PrjId"];?>&PrjActId=<?php //echo $_REQUEST["PrjActId"];?>&PrjDetailId=<?php //echo $_REQUEST["PrjDetailId"];?>&PrjActCode=<?php //echo $_REQUEST["PrjActCode"];?>&OrgCode=<?php //echo $_REQUEST["OrgCode"];?>&BgtYear=<?php //echo $_REQUEST["BgtYear"];?>&pageid='+pageid;
	window.location.href='?mod=<?php echo lurl::dotPage($addMonthPage);?>&PrjActId=<?php echo $_REQUEST["PrjActId"];?>&MonthNo='+MonthNo+'#History';
}

function CalProgressAmass(){
	var Progress = document.getElementById('Progress').value;
	var PercentMass = document.getElementById('PercentMass').value;
	var ProgressAmass = (PercentMass*Progress)/100;
	document.getElementById('ProgressAmass').value =ProgressAmass;
}

function showDetail(){
	if(document.getElementById('body-cate').style.display == ""){
		document.getElementById('body-cate').style.display="none";
		document.getElementById('a-cate').className='icon-decre txt-normal';
		document.getElementById('a-cate').className='icon-incre txt-normal';
		document.getElementById('a-cate').innerText="แสดงรายละเอียด";
	}else{
		document.getElementById('body-cate').style.display="";
		document.getElementById('a-cate').className='icon-incre txt-normal';
		document.getElementById('a-cate').className='icon-decre txt-normal';
		document.getElementById('a-cate').innerText="ซ่อนรายละเอียด";
	}
}	

</script>
<style type="text/css">
<!--
.style1 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>


<div class="sysinfo">
  <div class="sysname">รายงานความก้าวหน้างาน</div>
  <div class="sysdetail">&nbsp;</div>
</div>



<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="font-size:18px; color:#990000; font-weight:bold;">ข้อมูลระดับกิจกรรม</td>
      <td>&nbsp;</td>
    </tr>
  </table>  
</div>



<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId'];?>" />
<input type="hidden" name="PrjActCode" id="PrjActCode" value="<?php echo $PrjActCode;?>" />
<input type="hidden" name="PrjCode" id="PrjCode" value="<?php echo $PrjCode;?>" />
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $BgtYear;?>" />
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $PrjDetailId;?>" />




<?php
$dataPrj=$get->getProjectDetail($_REQUEST['PrjActId']);//ltxt::print_r($dataPrj);
foreach( $dataPrj as $row ) {
	foreach( $row as $k=>$v){ 
		${$k} = $v;
	}
}
?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
<input type="hidden" name="ResultId" id="ResultId" value="<?php echo $ResultId;?>" />
<input type="hidden" name="MonthNo" id="MonthNo" value="<?php echo $_REQUEST["MonthNo"];?>" />
  <tr>
    <th>ชื่อกิจกรรม</th>
    <td style="font-weight:bold;"><?php echo $get->getPrjActName($_REQUEST["PrjActId"]); ?></td>
  </tr>
  <tr>
    <th style="width:20%;">ปีงบประมาณ</th>
    <td><?php echo $BgtYear;?></td>
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
    <td><?php echo $get->getOrgName($BgtYear, $OrganizeCodeAct);?></td>
  </tr>   
  <tr>
    <th>ระยะเวลากิจกรรม</th>
    <td><?php echo dateformat($StartDate);?><b> ถึง </b><?php echo dateformat($EndDate);?></td>
  </tr> 
  
  
  
  
<tr>
    <th>&nbsp;</th>
    <td><a href="javascript:void(0)" id="a-cate" onclick="showDetail();" class="icon-decre txt-normal">ซ่อนรายละเอียด</a></td>
  </tr> 
<tbody id="body-cate">
<tr>
    <td colspan="2" style=" vertical-align:top; background-color:#EEE; padding:10px;">

<div>    
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->  
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
      </tr> 


<?php
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
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
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
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
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
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
        </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
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
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
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
      </tr> 
 
 
<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
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
        </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
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
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
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
      </tr> 


<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
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
        </tr>
       
 
 
 <?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
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
        </tr>
       
<?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
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
      </tr>
    </thead>
       <?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
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
      </tr> 


       <?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment); 
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
      </tr> 
 
 
       <?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);
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
      </tr> 


       <?php 
unset($Progress,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment); 
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
        </tr> 
     </table>

<?php } ?>
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////--> 
</div>
    </td>
</tr>
</tbody>
  
  
  
  
<?php
$result = $get->getResultDetail($PrjActCode,$_REQUEST['MonthNo']);//ltxt::print_r($result);
foreach($result as $r_result){
	foreach($r_result as $w=>$q){
		${$w} = $q;
	}
}
?>
<?php if($PrjMethods == "monthly"){ ?>
  <tr>
    <th colspan="2" style="background-color:#FCC; padding:5px;">ประจำเดือน <?php echo $get->getMonthNameTH($_REQUEST["MonthNo"]); ?></th>
  </tr>
<?php } ?>
<?php if($PrjMethods == "quarterly"){ ?>
  <tr>
    <th colspan="2" style="background-color:#FCC; padding:5px;">
  
  <?php
switch($_REQUEST["MonthNo"]){
	case "12":
		echo "ประจำไตรมาสที่ 1";
	break;
	case "3":
		echo "ประจำไตรมาสที่ 2";
	break;
	case "6":
		echo "ประจำไตรมาสที่ 3";
	break;
	case "9":
		echo "ประจำไตรมาสที่ 4";
	break;
}
?>    	
    </th>
<?php } ?>
  <tr>
    <th style="text-align:left;">% ดำเนินงาน</th>
    <td>
      <input type="text" name="Progress" id="Progress" value="<?php echo $Progress;?>" onkeyup="CalProgressAmass()" onKeyPress="return validChars(event,1)" style="width:150px; text-align:center;" /> <span class="hint">(เป็นช่องสำหรับกรอก % สะสมของการดำเนินงาน)</span>     </td>
  </tr>
      <tr>
    <th style="text-align:left">% ค่าน้ำหนักกิจกรรม</th>
    <td  style="text-align:left;"><input type="text" name="PercentMass" id="PercentMass" value="<?php echo $PercentMass;?>" readonly="readonly"  style="width:150px; text-align:center; background-color:#EEE;" /> <b>%ของโครงการ</b></td>
  </tr> 
    <tr>
    <th style="text-align:left;">% ความก้าวหน้า</th>
    <td><input type="text" name="ProgressAmass" id="ProgressAmass" value="<?php echo ($ProgressAmass)?$ProgressAmass:"0.0";?>" readonly="readonly"  style="width:150px; text-align:center; background-color:#EEE; color:#990000; font-weight:bold;" /> <b>%ของโครงการ</b> <span class="hint">(ได้จากผลคูณของ % ดำเนินงาน และ % ค่าน้ำหนักกิจกรรม)</span></td>
  </tr>
  <tr>
    <th valign="top" style="text-align:left">ผลการดำเนินการ</th>
    <td  style="text-align:left; font-weight:bold"><textarea name="Result" id="Result" rows="5"  style=" width:99%"><?php echo $Result;?></textarea></td>
  </tr>
  <tr>
    <th valign="top" style="text-align:left">ปัญหา/อุปสรรค</th>
    <td  style="text-align:left; font-weight:bold"><textarea name="Problem" id="Problem" rows="5"  style=" width:99%"><?php echo $Problem;?></textarea></td>
  </tr>
  <tr>
    <th valign="top" style="text-align:left">ปัจจัยสนับสนุน</th>
    <td  style="text-align:left; font-weight:bold"><textarea name="Factor" id="Factor" rows="5"  style=" width:99%"><?php echo $Factor;?></textarea></td>
  </tr>
  <tr style="vertical-align:top;">
    <th style="text-align:left">เอกสารแนบที่เกียวข้อง</th>
    <td  style="text-align:left;">
      <?php
				
		$MultiDocId =	$get->getLinkFiles($ResultId);	
		FilesManager::LinkFiles(
		array(
			"MaxUploadSize"=> 1,
			"imgWidth"		=>120,
			'imgHeight'		=> 100,
			'UploadType'	=> "multi",
			'FileTypeAllow'	=> "*",
			'ActiveObj'	=> "MultiDocId",
			'ActiveId'	=> $MultiDocId,
			'Category'	=> "ระบบนโยบายแผนงาน",
			'SubCategory'	=> "รายงานผลการปฏิบัติงาน",
			'System'		=> "backoffice",
			'Module'		=> "result"
		));
		
		?>    
    </td>
  </tr>
  <tr>
    <th valign="top" style="text-align:left">หมายเหตุ</th>
    <td  style="text-align:left; font-weight:bold"><textarea name="Comment" id="Comment" rows="5"  style=" width:99%"><?php echo $Comment;?></textarea></td>
  </tr>
</table>
<br>
<div class="title-bar">รายงานผลตัวชี้วัดกิจกรรม<br></div>
<br>
<span class="style1">1 . สนับสนุนการขับเคลื่อนธรรมนูญสุขภาพแห่งชาติ พ.ศ.2552 </span>
<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">แผนการดำเนินการ/ค่าเป้าหมายรายเดือน-ไตรมาส</div>
<table class="tbl-list" width="100%" cellspacing="0" cellpadding="0" border="1" style="margin-top:0px;">
<thead>
<tr>
<th align="center" style="width:70px;" rowspan="2"> </th>
<th align="center" rowspan="2">
ค่าเป้าหมาย
<br>
<span style="font-weight:normal;">(ตำบล)</span>
</th>
<th align="center" colspan="3">ไตรมาสที่ 1</th>
<th align="center" colspan="3">ไตรมาสที่ 2</th>
<th align="center" colspan="3">ไตรมาสที่ 3</th>
<th align="center" colspan="3">ไตรมาสที่ 4</th>
</tr>
<tr>
<th align="center" style="width:75px">ต.ค</th>
<th align="center" style="width:75px">พ.ย</th>
<th align="center" style="width:75px">ธ.ค</th>
<th align="center" style="width:75px">ม.ค</th>
<th align="center" style="width:75px">ก.พ</th>
<th align="center" style="width:75px">มี.ค</th>
<th align="center" style="width:75px">เม.ย</th>
<th align="center" style="width:75px">พ.ค</th>
<th align="center" style="width:75px">มิ.ย</th>
<th align="center" style="width:75px">ก.ค</th>
<th align="center" style="width:75px">ส.ค</th>
<th align="center" style="width:75px">ก.ย</th>
</tr>
</thead>
<tbody>
<!--<tr>
<td align="center">ตามแผน</td>
<td align="center">100.00</td>
<td align="center">10.00</td>
<td align="center">20.00</td>
<td align="center">30.00</td>
<td align="center">40.00</td>
<td align="center">50.00</td>
<td align="center">60.00</td>
<td align="center">70.00</td>
<td align="center">80.00</td>
<td align="center">90.00</td>
<td align="center">95.00</td>
<td align="center">97.00</td>
<td align="center">100.00</td>
</tr>-->
<tr>
<td align="center">
ตามผล</td>
<td align="center">89.00</td>
<td align="center">
9.00
</td>
<td align="center">
<input id="QTMTargetResult_11" type="text" value="11.00" name="QTMTargetResult[11]" style="width:85%; text-align:center;">
</td>
<td align="center">
35.00
</td>
<td align="center">
39.00
</td>
<td align="center">
55.00
</td>
<td align="center">
59.00
</td>
<td align="center">
78.00
</td>
<td align="center">
81.00
</td>
<td align="center">
89.00
</td>
<td align="center">
90.00
</td>
<td align="center">
92.00
</td>
<td align="center">
99.00
</td>
</tr>
</tbody>
</table>
<br>
<span class="style1">2 . การสนับสนุนการจัดทำธรรมนูญในระดับพื้นที่</span>
<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">แผนการดำเนินการ/ค่าเป้าหมายรายเดือน-ไตรมาส</div>
<table class="tbl-list" width="100%" cellspacing="0" cellpadding="0" border="1" style="margin-top:0px;">
<thead>
<tr>
<th align="center" style="width:70px;" rowspan="2"> </th>
<th align="center" rowspan="2">
ค่าเป้าหมาย
<br>
<span style="font-weight:normal;">(ตำบล)</span>
</th>
<th align="center" colspan="3">ไตรมาสที่ 1</th>
<th align="center" colspan="3">ไตรมาสที่ 2</th>
<th align="center" colspan="3">ไตรมาสที่ 3</th>
<th align="center" colspan="3">ไตรมาสที่ 4</th>
</tr>
<tr>
<th align="center" style="width:75px">ต.ค</th>
<th align="center" style="width:75px">พ.ย</th>
<th align="center" style="width:75px">ธ.ค</th>
<th align="center" style="width:75px">ม.ค</th>
<th align="center" style="width:75px">ก.พ</th>
<th align="center" style="width:75px">มี.ค</th>
<th align="center" style="width:75px">เม.ย</th>
<th align="center" style="width:75px">พ.ค</th>
<th align="center" style="width:75px">มิ.ย</th>
<th align="center" style="width:75px">ก.ค</th>
<th align="center" style="width:75px">ส.ค</th>
<th align="center" style="width:75px">ก.ย</th>
</tr>
</thead>
<tbody>
<!--<tr>
<td align="center">ตามแผน</td>
<td align="center">100.00</td>
<td align="center">10.00</td>
<td align="center">20.00</td>
<td align="center">30.00</td>
<td align="center">40.00</td>
<td align="center">50.00</td>
<td align="center">60.00</td>
<td align="center">70.00</td>
<td align="center">80.00</td>
<td align="center">90.00</td>
<td align="center">95.00</td>
<td align="center">97.00</td>
<td align="center">100.00</td>
</tr>-->
<tr>
<td align="center">
ตามผล</td>
<td align="center">89.00</td>
<td align="center">
9.00
</td>
<td align="center">
<input id="QTMTargetResult_11" type="text" value="11.00" name="QTMTargetResult[11]" style="width:85%; text-align:center;">
</td>
<td align="center">
35.00
</td>
<td align="center"> 39.00 </td>
<td align="center">55.00</td>
<td align="center">59.00</td>
<td align="center">78.00</td>
<td align="center">81.00</td>
<td align="center">89.00</td>
<td align="center">90.00 </td>
<td align="center">92.00</td>
<td align="center">99.00</td>
</tr>
</tbody>
</table>
<br>
<span class="style1">3 . การปรับปรุงธรรมนูญสุขภาพแห่งชาติ (เดิม การยกร่างธรรมนูญสุขภาพแห่งชาติ ฉบับที่ 2) </span>
<div style="padding:3px; background-color:#dfc7df; font-weight:bold;">แผนการดำเนินการ/ค่าเป้าหมายรายเดือน-ไตรมาส</div>
<table class="tbl-list" width="100%" cellspacing="0" cellpadding="0" border="1" style="margin-top:0px;">
<thead>
<tr>
<th align="center" style="width:70px;" rowspan="2"> </th>
<th align="center" rowspan="2">
ค่าเป้าหมาย
<br>
<span style="font-weight:normal;">(ตำบล)</span>
</th>
<th align="center" colspan="3">ไตรมาสที่ 1</th>
<th align="center" colspan="3">ไตรมาสที่ 2</th>
<th align="center" colspan="3">ไตรมาสที่ 3</th>
<th align="center" colspan="3">ไตรมาสที่ 4</th>
</tr>
<tr>
<th align="center" style="width:75px">ต.ค</th>
<th align="center" style="width:75px">พ.ย</th>
<th align="center" style="width:75px">ธ.ค</th>
<th align="center" style="width:75px">ม.ค</th>
<th align="center" style="width:75px">ก.พ</th>
<th align="center" style="width:75px">มี.ค</th>
<th align="center" style="width:75px">เม.ย</th>
<th align="center" style="width:75px">พ.ค</th>
<th align="center" style="width:75px">มิ.ย</th>
<th align="center" style="width:75px">ก.ค</th>
<th align="center" style="width:75px">ส.ค</th>
<th align="center" style="width:75px">ก.ย</th>
</tr>
</thead>
<tbody>
<!--<tr>
<td align="center">ตามแผน</td>
<td align="center">100.00</td>
<td align="center">10.00</td>
<td align="center">20.00</td>
<td align="center">30.00</td>
<td align="center">40.00</td>
<td align="center">50.00</td>
<td align="center">60.00</td>
<td align="center">70.00</td>
<td align="center">80.00</td>
<td align="center">90.00</td>
<td align="center">95.00</td>
<td align="center">97.00</td>
<td align="center">100.00</td>
</tr>-->
<tr>
<td align="center">
ตามผล</td>
<td align="center">89.00</td>
<td align="center">
9.00
</td>
<td align="center">
<input id="QTMTargetResult_11" type="text" value="11.00" name="QTMTargetResult[11]" style="width:85%; text-align:center;">
</td>
<td align="center">
35.00
</td>
<td align="center"> 39.00 </td>
<td align="center">55.00</td>
<td align="center">59.00</td>
<td align="center">78.00</td>
<td align="center">81.00</td>
<td align="center">89.00</td>
<td align="center">90.00 </td>
<td align="center">92.00</td>
<td align="center">99.00</td>
</tr>
</tbody>
</table>
      
    




     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="submit" class="btnActive" name="save" id="save" value="บันทึก"  />
      <input type="button" name="button" id="button" value="ยกเลิก" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage("result_projectmonth");?>&PrjDetailId=<?php echo $PrjDetailId;?>');" />
  </div>
   
</form>

<br />
<br />
<br />