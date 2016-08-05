<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$dataPrj=$get->getProjectView($_REQUEST['PrjDetailId']);
//ltxt::print_r($dataPrj);
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
		'text' => "ความก้าวหน้าระดับโครงการ",
	),
));


$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));



function icoPrjResult($PrjDetailId,$MonthNo){
	$label = 'รายงานผล';
	global $addMonthPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage("result_projectmonthadd")."&PrjDetailId=".$PrjDetailId."&MonthNo=".$MonthNo."'",
		'ico edit',
		$label,
		$label
	));
}

function icoResult($Progress,$PrjActId,$MonthNo){
	$label = $Progress;
	global $addMonthPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addMonthPage)."&PrjActId=".$PrjActId."&MonthNo=".$MonthNo."'",
		'',
		$label,
		$label
	));
}

function icoEdit($r){
	$label = 'บันทึกผล';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage('result_ind_add')."&PrjIndId=".$r->PrjIndId." '",
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
	window.location.href='?mod=<?php echo lurl::dotPage("result_projectmonth");?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"];?>&MonthNo='+MonthNo+'#History';
}

/*function showDetail(){
	if(document.getElementById('body-cate').style.display == ""){
		document.getElementById('body-cate').style.display="none";
		document.getElementById('a-cate').className='icon-decre txt-normal';
		document.getElementById('a-cate').className='icon-incre txt-normal';
		document.getElementById('a-cate').innerText="แสดงรายละเอียดกิจกรรม";
	}else{
		document.getElementById('body-cate').style.display="";
		document.getElementById('a-cate').className='icon-incre txt-normal';
		document.getElementById('a-cate').className='icon-decre txt-normal';
		document.getElementById('a-cate').innerText="ซ่อนรายละเอียดกิจกรรม";
	}
}	
*/	

function showDetail(act){ 
	if(act == 'show'){
		document.getElementById('body-cate').innerHTML='<span class="icon-load">กรุณารอสักครู่ ระบบกำลังทำการรวบรวมข้อมูล</span>';
		
		/*var url = '?mod=<?php //echo LURL::dotPage('result_action');?>&action=getIncDetail&PrjDetailId=<?php //echo $_REQUEST["PrjDetailId"]; ?>'; 
		$('body-cate').set('load',{method: 'post'});
		$('body-cate').load(url);*/
		
		JQ.ajax({
		   type: "POST",
		   url: "?mod=<?php echo LURL::dotPage('result_action');?>",		   
		   data: "action=getincdetail&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>",
		   success: function(msg){
				JQ("#body-cate").html(msg);
		   }
		});
		
		document.getElementById('detail-hide').style.display="";
		document.getElementById('detail-show').style.display="none";
		
		
		
		
		
	}else{
		$('body-cate').innerText="";
		document.getElementById('detail-hide').style.display="none";
		document.getElementById('detail-show').style.display="";
	}
}

</script>



<div class="sysinfo">
  <div class="sysname">รายงานความก้าวหน้างาน</div>
  <div class="sysdetail">&nbsp;</div>
</div>







<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="font-size:18px; color:#990000; font-weight:bold;">ข้อมูลระดับโครงการ</td>
      <td style="text-align:right; padding-right:5px;"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&amp;start=<?php echo $_REQUEST['start'];?>&amp;BgtYear=<?php echo $_REQUEST['BgtYear'];?>');" /></td>
    </tr>
  </table>  
</div>



<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $_REQUEST['PrjId'];?>" />
<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId'];?>" />
<input type="hidden" name="PrjActCode" id="PrjActCode" value="<?php echo $_REQUEST['PrjActCode'];?>" />
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId'];?>" />
<input type="hidden" name="OrgCode" id="OrgCode" value="<?php echo $_REQUEST['OrgCode'];?>" />
<input type="hidden" name="MonthNo" id="MonthNo" value="<?php echo $_REQUEST['pageid'];?>" />
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>" />


<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th style="text-align:left">ชื่อโครงการ</th>
    <td  style="text-align:left;"><b><?php echo $PrjName;?></b></td>
  </tr>
  <tr>
    <th style="width:20%; text-align:left">ปีงบประมาณ</th>
    <td  style="width:80%; text-align:left;"><?php echo $BgtYear;?></td>
  </tr>
  <tr>
    <th style="text-align:left">เจ้าของโครงการ</th>
    <td  style="text-align:left;"><?php echo $get->getOrgName($BgtYear, $OrganizeCode);?></td>
  </tr>
  <tr>
    <th style="text-align:left">วิธีการรายงานผล</th>
    <td  style="text-align:left;"><?php if($PrjMethods == "quarterly"){echo "รายไตรมาส";}else{echo "รายเดือน";} ?></td>
  </tr>
  <tr>
    <th style="text-align:left">ระยะเวลาโครงการ</th>
    <td  style="text-align:left;"><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td>
  </tr> 
</table>




<table width="100%" border="0" cellspacing="1" cellpadding="6" class="tbl-list" >
  <tr>
  <th colspan="2" style="text-align:left;">ผลการดำเนินงานโครงการ</th>
  </tr>
  <tr>
  <td colspan="2" style="background-color:#EEE; vertical-align:top;">

  
  
  <!--/////////////////////////////////////////////////////////////////////////////-->
  
<?php if($PrjMethods == "monthly"){ ?>
<?php
$PrjProgressAmass10 = $get->getPrjProgressAmass($PrjCode,10);
$PrjProgressAmass11 = $get->getPrjProgressAmass($PrjCode,11);
$PrjProgressAmass12 = $get->getPrjProgressAmass($PrjCode,12);
	
$PrjProgressAmass1 = $get->getPrjProgressAmass($PrjCode,1);
$PrjProgressAmass2 = $get->getPrjProgressAmass($PrjCode,2);
$PrjProgressAmass3 = $get->getPrjProgressAmass($PrjCode,3);
	
$PrjProgressAmass4 = $get->getPrjProgressAmass($PrjCode,4);
$PrjProgressAmass5 = $get->getPrjProgressAmass($PrjCode,5);
$PrjProgressAmass6 = $get->getPrjProgressAmass($PrjCode,6);
	
$PrjProgressAmass7 = $get->getPrjProgressAmass($PrjCode,7);
$PrjProgressAmass8 = $get->getPrjProgressAmass($PrjCode,8);
$PrjProgressAmass9 = $get->getPrjProgressAmass($PrjCode,9);
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
  <thead>
    <tr>
      <td style="width:100px; text-align:center;">เดือน</td>
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
$detail10 = $get->getPrjResultDetail($PrjCode,10);//ltxt::print_r($detail10);
foreach($detail10 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;">ตุลาคม</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass10)?$PrjProgressAmass10:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'PrjMultiDocId10',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
        


        
      </td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,10); ?></td>
      </tr> 


<?php
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail11 = $get->getPrjResultDetail($PrjCode,11);//ltxt::print_r($detail11);
foreach($detail11 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
      
       <tr style="vertical-align:top;">
      <td style="text-align:center;">พฤศจิกายน</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass11)?$PrjProgressAmass11:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'PrjMultiDocId11',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,11); ?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail12 = $get->getPrjResultDetail($PrjCode,12);//ltxt::print_r($detail12);
foreach($detail12 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
      
       <tr style="vertical-align:top;">
      <td style="text-align:center;">ธันวาคม</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass12)?$PrjProgressAmass12:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'PrjMultiDocId12',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,12); ?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail1 = $get->getPrjResultDetail($PrjCode,1);//ltxt::print_r($detail);
foreach($detail1 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
          <td style="text-align:center;">มกราคม</td>
          <td style="text-align:center;"><?php echo ($PrjProgressAmass1)?$PrjProgressAmass1:"-";?></td>
          <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
          <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
          <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
          <td>
          <?php  
                
            $MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => 'PrjMultiDocId1',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
          </td>
          <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
          <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,1); ?></td>
        </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail2 = $get->getPrjResultDetail($PrjCode,2);//ltxt::print_r($detail);
foreach($detail2 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">กุมภาพันธ์</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass2)?$PrjProgressAmass2:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'PrjMultiDocId2',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,2); ?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail3 = $get->getPrjResultDetail($PrjCode,3);//ltxt::print_r($detail);
foreach($detail3 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">มีนาคม</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass3)?$PrjProgressAmass3:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'PrjMultiDocId3',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,3); ?></td>
      </tr> 
 
 
<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail4 = $get->getPrjResultDetail($PrjCode,4);//ltxt::print_r($detail);
foreach($detail4 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">เมษายน</td>
          <td style="text-align:center;"><?php echo ($PrjProgressAmass4)?$PrjProgressAmass4:"-";?></td>
          <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
          <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
          <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
          <td>
          <?php  
                
            $MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => 'PrjMultiDocId4',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
          </td>
          <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
          <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,4); ?></td>
        </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail5 = $get->getPrjResultDetail($PrjCode,5);//ltxt::print_r($detail);
foreach($detail5 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">พฤษภาคม</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass5)?$PrjProgressAmass5:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'PrjMultiDocId5',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,5); ?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail6 = $get->getPrjResultDetail($PrjCode,6);//ltxt::print_r($detail);
foreach($detail6 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
      <td style="text-align:center;">มิถุนายน</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass6)?$PrjProgressAmass6:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'PrjMultiDocId6',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,6); ?></td>
      </tr> 


<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail7 = $get->getPrjResultDetail($PrjCode,7);//ltxt::print_r($detail);
foreach($detail7 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
         <td style="text-align:center;">กรกฏาคม</td>
         <td style="text-align:center;"><?php echo ($PrjProgressAmass7)?$PrjProgressAmass7:"-";?></td>
          <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
          <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
          <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
          <td>
          <?php  
                
            $MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => 'PrjMultiDocId7',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
          </td>
          <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
          <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,7); ?></td>
        </tr>
       
 
 
 <?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail8 = $get->getPrjResultDetail($PrjCode,8);//ltxt::print_r($detail);
foreach($detail8 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
      
       <tr style="vertical-align:top;">
         <td style="text-align:center;">สิงหาคม</td>
         <td style="text-align:center;"><?php echo ($PrjProgressAmass8)?$PrjProgressAmass8:"-";?></td>
          <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
          <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
          <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
          <td>
          <?php  
                
            $MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => 'PrjMultiDocId8',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
          </td>
          <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
          <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,8); ?></td>
        </tr>
       
<?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail9 = $get->getPrjResultDetail($PrjCode,9);//ltxt::print_r($detail);
foreach($detail9 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       

       <tr style="vertical-align:top;">
         <td style="text-align:center;">กันยายน</td>
         <td style="text-align:center;"><?php echo ($PrjProgressAmass9)?$PrjProgressAmass9:"-";?></td>
         <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
         <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
         <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
         <td>
           <?php  
                
            $MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => 'PrjMultiDocId9',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
          </td>
         <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
         <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,9); ?></td>
        </tr> 
     </table>

<?php } ?>
<?php if($PrjMethods == "quarterly"){ ?>
<?php
$PrjProgressAmass12 = $get->getPrjProgressAmass($PrjCode,12);
$PrjProgressAmass3 = $get->getPrjProgressAmass($PrjCode,3);
$PrjProgressAmass6 = $get->getPrjProgressAmass($PrjCode,6);
$PrjProgressAmass9 = $get->getPrjProgressAmass($PrjCode,9);
?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
  <thead>
    <tr>
      <td style="width:100px; text-align:center;">ไตรมาสที่</td>
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
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail12 = $get->getPrjResultDetail($PrjCode,12);//ltxt::print_r($detail12);
foreach($detail12 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>    
      
       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส1</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass12)?$PrjProgressAmass12:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'PrjMultiDocId11',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,12); ?></td>
      </tr> 


       <?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment); 
$detail3 = $get->getPrjResultDetail($PrjCode,3);//ltxt::print_r($detail);
foreach($detail3 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส2</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass3)?$PrjProgressAmass3:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'PrjMultiDocId3',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,3); ?></td>
      </tr> 
 
 
       <?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment);
$detail6 = $get->getPrjResultDetail($PrjCode,6);//ltxt::print_r($detail);
foreach($detail6 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       
       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส3</td>
      <td style="text-align:center;"><?php echo ($PrjProgressAmass6)?$PrjProgressAmass6:"-";?></td>
      <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
      <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
      <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
      <td>
	  <?php  
            
		$MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'PrjMultiDocId6',
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?>    
      </td>
      <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
      <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,6); ?></td>
      </tr> 


       <?php 
unset($Progress,$PercentMass,$ProgressAmass,$PrjResult,$PrjProblem,$PrjFactor,$PrjResultId,$PrjComment); 
$detail9 = $get->getPrjResultDetail($PrjCode,9);//ltxt::print_r($detail);
foreach($detail9 as $drow){
	foreach($drow as $k=>$v){
		${$k} = $v;
	}
}
?>       

       <tr style="vertical-align:top;">
         <td style="text-align:center;">ไตรมาส4</td>
         <td style="text-align:center;"><?php echo ($PrjProgressAmass9)?$PrjProgressAmass9:"-";?></td>
         <td><?php echo ($PrjResult)?$PrjResult:'-';?></td>
         <td><?php echo ($PrjProblem)?$PrjProblem:'-';?></td>
         <td><?php echo ($PrjFactor)?$PrjFactor:'-';?></td>
         <td>
           <?php  
                
            $MultiDocId = $get->getPrjLinkFiles($PrjResultId); 
            FilesManager::LinkFilesView(array(
                    'ActiveObj' => 'PrjMultiDocId9',
                    'ViewType' => 'multi',
                    'ActiveId' => $MultiDocId
                  //  'imgWidth' => $imgWidth,
                   // 'imgHeight' => $imgHeight
                ));
            
            ?>    
           </td>
         <td><?php echo ($PrjComment)?$PrjComment:'-';?></td>
         <td style="text-align:center;"><?php echo icoPrjResult($PrjDetailId,9); ?></td>
        </tr> 
     </table>

<?php 
	$d++;
} 
?>

  <!--/////////////////////////////////////////////////////////////////////////////-->
  
  
    
    
   </td>
  </tr>
</table>






<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list" >
  <tr>
  <th colspan="2" style="text-align:left;">ผลการดำเนินงานจำแนกตามกิจกรรมในโครงการ</th>
  </tr>
  <tr>
  <td colspan="2" style="background-color:#EEE; vertical-align:top;">


  <!--/////////////////////////////////////////////////////////////////////////////-->

<?php if($PrjMethods == "monthly"){ ?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl-history-check">
  <thead>
    <tr>
      <td rowspan="2" style="width:30px;">ลำดับ</td>
      <td rowspan="2" style="text-align:center;">ชื่อกิจกรรมในโครงการ</td>
      <td rowspan="2" style="width:80px; text-align:center;">%ค่าน้ำหนัก</td>
      <td colspan="12" style="text-align:center;">%ดำเนินงานกิจกรรม</td>
      </tr>
    <tr>
      <td style="width:55px; text-align:center;">ต.ค</td>
      <td style="width:55px; text-align:center;">พ.ย</td>
      <td style="width:55px; text-align:center;">ธ.ค</td>
      <td style="width:55px; text-align:center;">ม.ค</td>
      <td style="width:55px; text-align:center;">ก.พ</td>
      <td style="width:55px; text-align:center;">มี.ค</td>
      <td style="width:55px; text-align:center;">เม.ย</td>
      <td style="width:55px; text-align:center;">พ.ค</td>
      <td style="width:55px; text-align:center;">มิ.ย</td>
      <td style="width:55px; text-align:center;">ก.ค</td>
      <td style="width:55px; text-align:center;">ส.ค</td>
      <td style="width:55px; text-align:center;">ก.ย</td>
      </tr>
    </thead>
<?php   
$selectAct = $get->getProjectDetailActRecordSet($PrjDetailId);//ltxt::print_r($selectAct);
foreach($selectAct as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;} 
	$totalPercentMass	= $totalPercentMass+$PercentMass;
	
	$prog10 = $get->getResultDetail($PrjActCode,10);
	$prog11 = $get->getResultDetail($PrjActCode,11);
	$prog12 = $get->getResultDetail($PrjActCode,12);
	
	$prog1 = $get->getResultDetail($PrjActCode,1);
	$prog2 = $get->getResultDetail($PrjActCode,2);
	$prog3 = $get->getResultDetail($PrjActCode,3);
	
	$prog4 = $get->getResultDetail($PrjActCode,4);
	$prog5 = $get->getResultDetail($PrjActCode,5);
	$prog6 = $get->getResultDetail($PrjActCode,6);
	
	$prog7 = $get->getResultDetail($PrjActCode,7);
	$prog8 = $get->getResultDetail($PrjActCode,8);
	$prog9 = $get->getResultDetail($PrjActCode,9);
	
	$totalProgressAmass10= $totalProgressAmass10+$prog10[0]->ProgressAmass;
	$totalProgressAmass11= $totalProgressAmass11+$prog11[0]->ProgressAmass;
	$totalProgressAmass12= $totalProgressAmass12+$prog12[0]->ProgressAmass;
	
	$totalProgressAmass1= $totalProgressAmass1+$prog1[0]->ProgressAmass;
	$totalProgressAmass2= $totalProgressAmass2+$prog2[0]->ProgressAmass;
	$totalProgressAmass3= $totalProgressAmass3+$prog3[0]->ProgressAmass;
	
	$totalProgressAmass4 = $totalProgressAmass4+$prog4[0]->ProgressAmass;
	$totalProgressAmass5 = $totalProgressAmass5+$prog5[0]->ProgressAmass;
	$totalProgressAmass6 = $totalProgressAmass6+$prog6[0]->ProgressAmass;
	
	$totalProgressAmass7 = $totalProgressAmass7+$prog7[0]->ProgressAmass;
	$totalProgressAmass8 = $totalProgressAmass8+$prog8[0]->ProgressAmass;
	$totalProgressAmass9 = $totalProgressAmass9+$prog9[0]->ProgressAmass;

?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo ($n+1); ?></td>
      <td><?php echo $PrjActName;?></td>
      <td style="text-align:right;"><?php echo ($PercentMass)?(number_format($PercentMass,2)):"-";?></td>
      <td style="text-align:right;"><?php echo ($prog10[0]->Progress)?(icoResult($prog10[0]->Progress,$PrjActId,10)):(icoResult('รายงานผล',$PrjActId,10)); ?></td>
      <td style="text-align:right;"><?php echo ($prog11[0]->Progress)?(icoResult($prog11[0]->Progress,$PrjActId,11)):(icoResult('รายงานผล',$PrjActId,11)); ?></td>
      <td style="text-align:right;"><?php echo ($prog12[0]->Progress)?(icoResult($prog12[0]->Progress,$PrjActId,12)):(icoResult('รายงานผล',$PrjActId,12)); ?></td>
      <td style="text-align:right;"><?php echo ($prog1[0]->Progress)?(icoResult($prog1[0]->Progress,$PrjActId,1)):(icoResult('รายงานผล',$PrjActId,1)); ?></td>
      <td style="text-align:right;"><?php echo ($prog2[0]->Progress)?(icoResult($prog2[0]->Progress,$PrjActId,2)):(icoResult('รายงานผล',$PrjActId,2)); ?></td>
      <td style="text-align:right;"><?php echo ($prog3[0]->Progress)?(icoResult($prog3[0]->Progress,$PrjActId,3)):(icoResult('รายงานผล',$PrjActId,3)); ?></td>
      <td style="text-align:right;"><?php echo ($prog4[0]->Progress)?(icoResult($prog4[0]->Progress,$PrjActId,4)):(icoResult('รายงานผล',$PrjActId,4)); ?></td>
      <td style="text-align:right;"><?php echo ($prog5[0]->Progress)?(icoResult($prog5[0]->Progress,$PrjActId,5)):(icoResult('รายงานผล',$PrjActId,5)); ?></td>
      <td style="text-align:right;"><?php echo ($prog6[0]->Progress)?(icoResult($prog6[0]->Progress,$PrjActId,6)):(icoResult('รายงานผล',$PrjActId,6)); ?></td>
      <td style="text-align:right;"><?php echo ($prog7[0]->Progress)?(icoResult($prog7[0]->Progress,$PrjActId,7)):(icoResult('รายงานผล',$PrjActId,7)); ?></td>
      <td style="text-align:right;"><?php echo ($prog8[0]->Progress)?(icoResult($prog8[0]->Progress,$PrjActId,8)):(icoResult('รายงานผล',$PrjActId,8)); ?></td>
      <td style="text-align:right;"><?php echo ($prog9[0]->Progress)?(icoResult($prog9[0]->Progress,$PrjActId,9)):(icoResult('รายงานผล',$PrjActId,9)); ?></td>
      </tr> 
      
      
      
      
      
<?php	
	$n++;			
}
?>    

  
      <!--%ความก้าวหน้าโครงการ-->
      <tr style="vertical-align:top; color:#990000;">
      <td style="text-align:right;">&nbsp;</td>
      <td style="text-align:right;">%ความก้าวหน้าโครงการ</td>
      <td style="text-align:right;"><?php echo number_format($totalPercentMass,2); ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass10)?(number_format($totalProgressAmass10,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass11)?(number_format($totalProgressAmass11,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass12)?(number_format($totalProgressAmass12,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass1)?(number_format($totalProgressAmass1,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass2)?(number_format($totalProgressAmass2,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass3)?(number_format($totalProgressAmass3,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass4)?(number_format($totalProgressAmass4,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass5)?(number_format($totalProgressAmass5,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass6)?(number_format($totalProgressAmass6,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass7)?(number_format($totalProgressAmass7,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass8)?(number_format($totalProgressAmass8,2)):'-'; ?></td>
      <td style="text-align:right;"><?php echo ($totalProgressAmass9)?(number_format($totalProgressAmass9,2)):'-'; ?></td>
      </tr> 
      <!--END %ความก้าวหน้าโครงการ-->

     </table>

<?php } ?>
<?php if($PrjMethods == "quarterly"){ ?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl-history-check">
  <thead>
    <tr>
      <td rowspan="2" style="width:30px;">ลำดับ</td>
      <td rowspan="2" style="text-align:center;">ชื่อกิจกรรมในโครงการ</td>
      <td rowspan="2" style="width:80px; text-align:center;">%ค่าน้ำหนัก</td>
      <td colspan="4" style="text-align:center;">%ดำเนินงานกิจกรรม</td>
      </tr>
    <tr>
      <td style="width:100px; text-align:center;">ไตรมาส1</td>
      <td style="width:100px; text-align:center;">ไตรมาส2</td>
      <td style="width:100px; text-align:center;">ไตรมาส3</td>
      <td style="width:100px; text-align:center;">ไตรมาส4</td>
      </tr>
    </thead>
<?php   
$selectAct = $get->getProjectDetailActRecordSet($PrjDetailId);//ltxt::print_r($selectAct);
foreach($selectAct as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;} 
	$totalPercentMass	= $totalPercentMass+$PercentMass;
	
	$prog12 = $get->getResultDetail($PrjActCode,12);
	$prog3 = $get->getResultDetail($PrjActCode,3);
	$prog6 = $get->getResultDetail($PrjActCode,6);
	$prog9 = $get->getResultDetail($PrjActCode,9);
	
	$totalProgressAmass12= $totalProgressAmass12+$prog12[0]->ProgressAmass;
	$totalProgressAmass3= $totalProgressAmass3+$prog3[0]->ProgressAmass;
	$totalProgressAmass6 = $totalProgressAmass6+$prog6[0]->ProgressAmass;
	$totalProgressAmass9 = $totalProgressAmass9+$prog9[0]->ProgressAmass;

?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo ($n+1); ?></td>
      <td><?php echo $PrjActName;?></td>
      <td style="text-align:right;"><?php echo ($PercentMass)?(number_format($PercentMass,2)):"-";?></td>
      <td style="text-align:right;"><?php echo ($prog12[0]->Progress)?(icoResult($prog12[0]->Progress,$PrjActId,12)):(icoResult('รายงานผล',$PrjActId,12)); ?></td>
      <td style="text-align:right;"><?php echo ($prog3[0]->Progress)?(icoResult($prog3[0]->Progress,$PrjActId,3)):(icoResult('รายงานผล',$PrjActId,3)); ?></td>
      <td style="text-align:right;"><?php echo ($prog6[0]->Progress)?(icoResult($prog6[0]->Progress,$PrjActId,6)):(icoResult('รายงานผล',$PrjActId,6)); ?></td>
      <td style="text-align:right;"><?php echo ($prog9[0]->Progress)?(icoResult($prog9[0]->Progress,$PrjActId,9)):(icoResult('รายงานผล',$PrjActId,9)); ?></td>
      </tr> 
      
      
      
      
      
<?php	
	$n++;			
}
?>    

  
      <!--%ความก้าวหน้าโครงการ-->
<!--      <tr style="vertical-align:top; color:#990000;">
      <td style="text-align:right;">&nbsp;</td>
      <td style="text-align:right;">%ความก้าวหน้าโครงการ</td>
      <td style="text-align:right;"><?php //echo number_format($totalPercentMass,2); ?></td>
      <td style="text-align:right;"><?php //echo ($totalProgressAmass12)?(number_format($totalProgressAmass12,2)):'-'; ?></td>
      <td style="text-align:right;"><?php //echo ($totalProgressAmass3)?(number_format($totalProgressAmass3,2)):'-'; ?></td>
      <td style="text-align:right;"><?php //echo ($totalProgressAmass6)?(number_format($totalProgressAmass6,2)):'-'; ?></td>
      <td style="text-align:right;"><?php //echo ($totalProgressAmass9)?(number_format($totalProgressAmass9,2)):'-'; ?></td>
      </tr> 
-->      <!--END %ความก้าวหน้าโครงการ-->

     </table>

<?php } ?>

  <!--/////////////////////////////////////////////////////////////////////////////-->
<div style="text-align:right;">  
   <span id="detail-show" style="padding:3px;"><a href="javascript:void(0)" onclick="showDetail('show');" class="icon-incre txt-normal">แสดงรายละเอียดกิจกรรม</a></span>
   <span id="detail-hide" style="display:none; padding:3px;"><a href="javascript:void(0)" onclick="showDetail('hide');" class="icon-decre txt-normal">ซ่อนรายละเอียดกิจกรรม</a></span>
</div>
   </td>
  </tr>
</table>






<!--///////////////////////////////////////////////////////////////////////////////-->
<div id="body-cate"><?php //$get->getIncDetail(); ?></div>

<!--//////////////////////////////////////////////////////////////////////////////-->


 <!--///////////////////////////////////////////////////////////////////////////////////////////////////////////-->   
<?php 
$indicatorSelect = $get->getIndicatorSelect($_REQUEST["PrjDetailId"]);//ltxt::print_r($indicatorSelect);
if($indicatorSelect){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list" >
  <tr>
  <th style="text-align:left;">ตัวชี้วัดโครงการ</th>
  </tr>
  <tr>
  <td style="background-color:#EEE; vertical-align:top;">



<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl-history-check">
  <thead>
  <tr>
    <td rowspan="2" style="width:30px;">ลำดับ</td>
    <td rowspan="2" style="width:120px;">รหัส</td>
    <td rowspan="2" >ตัวชี้วัด</td>
    <td rowspan="2" style="width:100px;" >หน่วยนับ</td>
    <td colspan="3" class="tbl-list">ค่าเป้าหมาย</td>
    <td rowspan="2" style="width:70px;">ปฎิบัติการ</td>
  </tr>
  <tr>
    <td style="text-align:center; width:95px;">แผน</td>
    <td style="text-align:center; width:95px;">ผล</td>
    <td style="text-align:center; width:40px;">คะแนน</td>
  </tr>    
  </thead>
  <?php 
  $ind=1;
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
          <td style="text-align:center;"><?php echo $ind; ?></td>
          <td style="text-align:center;"><?php echo $IndicatorCode; ?></td>
          <td>
          <a href="javascript:void(0)" style="color:#003399" onclick="window.open('?mod=<?php echo LURL::dotPage('result_ind'); ?>&format=raw&PrjIndId=<?php echo $PrjIndId; ?>',null,'scrollbars=yes,height=500,width=1200,toolbar=yes,menubar=yes,status=yes');">
		  <?php echo $IndicatorName;?>
          </a>
          </td>
          <td style="text-align:center;"><?php echo $UnitName;?></td>
          <td style="text-align:center;"><?php echo $indPlan; ?></td>
          <td style="text-align:center;"><?php echo $indResult; ?></td>
          <td style="text-align:center;"><span class="icon-col<?php echo $TGScore; ?>">&nbsp;</span></td>
          <td style="text-align:center;"><?php echo icoEdit($r); ?></td>
    </tr>
        <?php		
				$ind++;		
            }
	?>
</table>




</td>
</tr>
</table>

<?php
}
?>
 <!--///////////////////////////////////////////////////////////////////////////////////////////////////////////-->

      
</form>

<div style="text-align:right; padding:4px; margin-top:10px;"><a href="#" class="icon-up">กลับสู่ด้านบน</a></div>
