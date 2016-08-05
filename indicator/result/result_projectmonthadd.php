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
		'text' => 'บันทึกความก้าวหน้าระดับโครงการ',
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css',
	VSROOT.'modules/backoffice/budgetpay/style_budgetpay.css'
));



function icoPrjResult($PrjDetailId,$MonthNo){
	$label = 'ปรับปรุง';
	global $addMonthPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage("result_projectmonthadd")."&PrjDetailId=".$PrjDetailId."&MonthNo=".$MonthNo."'",
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

	
function showDetail(){
	if(document.getElementById('body-cate').style.display == ""){
		document.getElementById('body-cate').style.display="none";
		document.getElementById('a-cate').className='icon-decre txt-normal';
		document.getElementById('a-cate').className='icon-incre txt-normal';
		document.getElementById('a-cate').innerText="แสดงผลการดำเนินงานของกิจกรรมภายใต้โครงการ";
	}else{
		document.getElementById('body-cate').style.display="";
		document.getElementById('a-cate').className='icon-incre txt-normal';
		document.getElementById('a-cate').className='icon-decre txt-normal';
		document.getElementById('a-cate').innerText="ซ่อนผลการดำเนินงานของกิจกรรมภายใต้โครงการ";
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
      <td style="text-align:right; padding-right:5px;">&nbsp;</td>
    </tr>
  </table>  
</div>



<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=saveprj" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $_REQUEST['PrjId'];?>" />
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId'];?>" />
<input type="hidden" name="PrjCode" id="PrjCode" value="<?php echo $PrjCode;?>" />
<input type="hidden" name="OrgCode" id="OrgCode" value="<?php echo $_REQUEST['OrgCode'];?>" />
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>" />


<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
<?php
$result = $get->getPrjResultDetail($PrjCode,$_REQUEST['MonthNo']);//ltxt::print_r($result);
foreach($result as $r_result){
	foreach($r_result as $w=>$q){
		${$w} = $q;
	}
}
?>
<input type="hidden" name="PrjResultId" id="PrjResultId" value="<?php echo $PrjResultId;?>" />
<input type="hidden" name="MonthNo" id="MonthNo" value="<?php echo $_REQUEST["MonthNo"];?>" />
<?php if($PrjMethods == "monthly"){ ?>
  <tr>
    <th style="text-align:left; width:20%">ประจำเดือน</th>
    <td style="font-weight:bold;"><?php echo $get->getMonthNameTH($_REQUEST["MonthNo"]); ?></td>
  </tr>
<?php } ?>
<?php if($PrjMethods == "quarterly"){ ?>
    <tr>
    <th style="text-align:left;">ประจำไตรมาส</th>
    <td style="font-weight:bold;">
  <?php
switch($_REQUEST["MonthNo"]){
	case "12":
		echo "ไตรมาสที่ 1";
	break;
	case "3":
		echo "ไตรมาสที่ 2";
	break;
	case "6":
		echo "ไตรมาสที่ 3";
	break;
	case "9":
		echo "ไตรมาสที่ 4";
	break;
}
?>    
    </td>
  </tr>
<?php } ?>
  <tr>
    <th style="text-align:left">ชื่อโครงการ</th>
    <td  style="text-align:left;"><b><?php echo $PrjName;?></b></td>
  </tr>
  <tr>
    <th style="width:20%; text-align:left">ปีงบประมาณ</th>
    <td  style="text-align:left;"><?php echo $BgtYear;?></td>
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
      <tr>
    <th>ค่าน้ำหนักโครงการ</th>
    <td><?php echo $PrjMass;?> เปอร์เซ็นต์(%) ของแผนงาน</td>
  </tr> 
      <tr>
    <th>ผลการดำเนินงานกิจกรรม</th>
    <td><a href="javascript:void(0)" id="a-cate" onclick="showDetail();" class="icon-decre txt-normal">ซ่อนผลการดำเนินงานของกิจกรรมภายใต้โครงการ</a></td>
  </tr> 
<tbody id="body-cate">
<tr>
    <td colspan="2" style=" vertical-align:top; background-color:#EEE; padding:10px;">

<div>    
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////-->  
 <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl-history-check" style="background-color:#FFF;">
  <thead>
    <tr>
      <td style="width:40px;">ลำดับ</td>
      <td style="text-align:center;">ชื่อกิจกรรมในโครงการ</td>
      <td style="width:80px; text-align:center;">%ค่าน้ำหนัก</td>
      <td style="width:80px; text-align:center;">%ดำเนินงาน</td>
      <td style="width:100px; text-align:center;">%ก้าวหน้าโครงการ</td>
      <td style="width:100px; text-align:center;">ผลดำเนินการ</td>
      <td style="width:100px; text-align:center;">ปัญหา/อุปสรรค</td>
      <td style="width:100px; text-align:center;">ปัจจัยสนับสนุน</td>
      <td style="width:200px; text-align:center;">เอกสารแนบ</td>
      <td style="width:100px; text-align:center;">หมายเหตุ</td>
      </tr>
    </thead>
<?php   
$selectAct = $get->getProjectDetailActRecordSet($PrjDetailId);//ltxt::print_r($selectAct);
foreach($selectAct as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;} 
	$detail = $get->getResultDetail($PrjActCode,$_REQUEST["MonthNo"]);//ltxt::print_r($detail);
	foreach($detail as $drow){
		foreach($drow as $k=>$v){
			${$k} = $v;
		}
	}
	$totalPercentMass		= $totalPercentMass+$PercentMass;
	$totalProgressAmass	= $totalProgressAmass+$ProgressAmass;

?>    
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo ($n+1); ?></td>
      <td><?php echo $PrjActName;?></td>
      <td style="text-align:center;"><?php echo ($PercentMass)?$PercentMass:"-";?></td>
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
	$n++;		
	unset($Progress,$PercentMass,$ProgressAmass,$Result,$Problem,$Factor,$ResultId,$Comment);	
}
?>      

     <tr style="vertical-align:top; font-weight:bold;">
      <td colspan="2" style="text-align:right;">รวมทั้งสิ้น</td>
      <td style="text-align:center;"><?php echo ($totalPercentMass)?$totalPercentMass:"-";?></td>
      <td style="text-align:center;">-</td>
      <td style="text-align:center; background-color:#FFFF99;"><?php echo ($totalProgressAmass)?$totalProgressAmass:"-";?></td>
      <td colspan="5">&nbsp;</td>
      </tr>
      
    </table>
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////--> 
</div>
    </td>
</tr>
</tbody>


  <tr>
    <th valign="top">ความก้าวโครงการ</th>
    <td><?php echo ($totalProgressAmass)?$totalProgressAmass:"-";?> เปอร์เซ็นต์(%) <span class="hint">(ได้มาจากผลรวมของ % ความก้าวหน้ากิจกรรมภายใต้โครงการ)</span></td>
  </tr>
  <tr>
    <th valign="top" style="text-align:left">ผลการดำเนินการ</th>
    <td><textarea name="PrjResult" id="PrjResult" rows="5"  style=" width:99%"><?php echo $PrjResult;?></textarea></td>
  </tr>
  <tr>
    <th valign="top" style="text-align:left">ปัญหา/อุปสรรค</th>
    <td><textarea name="PrjProblem" id="PrjProblem" rows="5"  style=" width:99%"><?php echo $PrjProblem;?></textarea></td>
  </tr>
  <tr>
    <th valign="top" style="text-align:left">ปัจจัยสนับสนุน</th>
    <td><textarea name="PrjFactor" id="PrjFactor" rows="5"  style=" width:99%"><?php echo $PrjFactor;?></textarea></td>
  </tr>
  <tr style="vertical-align:top;">
    <th style="text-align:left">เอกสารแนบที่เกียวข้อง</th>
    <td  style="text-align:left;">
      <?php
				
		$MultiDocId =	$get->getPrjLinkFiles($PrjResultId);	
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
    <td><textarea name="PrjComment" id="PrjComment" rows="5"  style=" width:99%"><?php echo $PrjComment;?></textarea></td>
  </tr>
</table>    
      
    




     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="submit" class="btnActive" name="save" id="save" value="บันทึก"  />
      <input type="button" name="button" id="button" value="ยกเลิก" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage("result_projectmonth");?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"];?>');" />
      </div>
      
</form>

<br />
<br />
<br />