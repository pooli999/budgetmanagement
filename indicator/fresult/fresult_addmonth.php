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

if($_REQUEST['PrjActId']){
	$dataPrj=$get->getProjectDetail($_REQUEST['PrjActId']);//ltxt::print_r($dataPrj);
	foreach( $dataPrj as $row ) {
		foreach( $row as $k=>$v){ 
			${$k} = $v;
		}
	}
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
	//window.location.href='?mod=<?php //echo lurl::dotPage($addMonthPage);?>&PrjId=<?php //echo $_REQUEST["PrjId"];?>&PrjActId=<?php //echo $_REQUEST["PrjActId"];?>&PrjDetailId=<?php //echo $_REQUEST["PrjDetailId"];?>&PrjActCode=<?php //echo $_REQUEST["PrjActCode"];?>&OrgCode=<?php //echo $_REQUEST["OrgCode"];?>&BgtYear=<?php //echo $_REQUEST["BgtYear"];?>&pageid='+pageid;
	window.location.href='?mod=<?php echo lurl::dotPage($addMonthPage);?>&PrjActId=<?php echo $_REQUEST["PrjActId"];?>&MonthNo='+MonthNo+'#History';
}

function CalProgressAmass(){
	var Progress = document.getElementById('Progress').value;
	var PercentMass = document.getElementById('PercentMass').value;
	var ProgressAmass = (PercentMass*Progress)/100;
	document.getElementById('ProgressAmass').value =ProgressAmass;
}
</script>

 <table width="100%" cellpadding="0" cellspacing="0" class="page-title-user">
 	<tr>
    	<td class="div-title-result">&nbsp;</td>
        <td>
       <div class="font1">ติดตามผลการดำเนินงานโครงการ</div>
        </td>
    </tr>
 </table>


<div class="sysinfo">
  <div class="sysname">กรอกข้อมูลผลการดำเนินงาน</div>
</div>


<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td align="right">
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $BgtYear;?>');" />
      </td>
    </tr>
  </table>  
</div>



<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId'];?>" />
<input type="hidden" name="PrjActCode" id="PrjActCode" value="<?php echo $PrjActCode;?>" />
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $BgtYear;?>" />




<?php include("modules/backoffice/budget/result/view.php"); ?>
<?php
$dataPrj=$get->getProjectDetail($_REQUEST['PrjActId']);//ltxt::print_r($dataPrj);
foreach( $dataPrj as $row ) {
	foreach( $row as $k=>$v){ 
		${$k} = $v;
	}
}
?>

<a name="History" id="History">&nbsp;</a>    
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
<tr>
  	<th colspan="2" valign="top">บันทึกผลการดำเนินงานรายเดือน/ไตรมาส</th>
</tr>
<tr>
  <td colspan="2" valign="top">

<?php
$_REQUEST["MonthNo"] = ($_REQUEST["MonthNo"])?$_REQUEST["MonthNo"]:(date("m")); 
unset($Progress); 
unset($ProgressAmass);
unset($Result);
unset($Problem);
unset($Factor);
unset($ResultId);
unset($Comment);
$result = $get->getResultDetail($PrjActCode,$_REQUEST['MonthNo']);//ltxt::print_r($detail);
foreach($result as $r_result){
	foreach($r_result as $w=>$q){
		${$w} = $q;
	}
}
?>
<input type="hidden" name="ResultId" id="ResultId" value="<?php echo $ResultId;?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="6" class="tbl-list" >
<?php if($PrjMethods == "monthly"){ ?>
  <tr>
    <th style="text-align:left; width:20%">ประจำเดือน</th>
    <td class="require" >*</td>
    <td>
    <select name="MonthNo" id="MonthNo" style="width:150px;" onchange="toPage(this.value);">
    	<option value="0">ระบุ</option>
        <option value="10" <?php if($_REQUEST["MonthNo"] == 10){ ?> selected="selected" <?php } ?>>ตุลาคม</option>
        <option value="11" <?php if($_REQUEST["MonthNo"] == 11){ ?> selected="selected" <?php } ?>>พฤศจิกายน</option>
        <option value="12" <?php if($_REQUEST["MonthNo"] == 12){ ?> selected="selected" <?php } ?>>ธันวาคม</option>
        <option value="1" <?php if($_REQUEST["MonthNo"] == 1){ ?> selected="selected" <?php } ?>>มกราคม</option>
        <option value="2" <?php if($_REQUEST["MonthNo"] == 2){ ?> selected="selected" <?php } ?>>กุมภาพันธ์</option>
        <option value="3" <?php if($_REQUEST["MonthNo"] == 3){ ?> selected="selected" <?php } ?>>มีนาคม</option>
        <option value="4" <?php if($_REQUEST["MonthNo"] == 4){ ?> selected="selected" <?php } ?>>เมษายน</option>
        <option value="5" <?php if($_REQUEST["MonthNo"] == 5){ ?> selected="selected" <?php } ?>>พฤษภาคม</option>
        <option value="6" <?php if($_REQUEST["MonthNo"] == 6){ ?> selected="selected" <?php } ?>>มิถุนายน</option>
        <option value="7" <?php if($_REQUEST["MonthNo"] == 7){ ?> selected="selected" <?php } ?>>กรกฎาคม</option>
        <option value="8" <?php if($_REQUEST["MonthNo"] == 8){ ?> selected="selected" <?php } ?>>สิงหาคม</option>
        <option value="9" <?php if($_REQUEST["MonthNo"] == 9){ ?> selected="selected" <?php } ?>>กันยายน</option>
    </select>
    </td>
  </tr>
<?php } ?>
<?php if($PrjMethods == "quarterly"){ ?>
    <tr>
    <th style="text-align:left;">ประจำไตรมาส</th>
    <td class="require" >*</td>
    <td>
    <select name="MonthNo" id="MonthNo" style="width:150px;" onchange="toPage(this.value);">
    	<option value="0">ระบุ</option>
        <option value="12" <?php if($_REQUEST["MonthNo"] == 12){ ?> selected="selected" <?php } ?>>ไตรมาสที่ 1</option>
        <option value="3" <?php if($_REQUEST["MonthNo"] == 3){ ?> selected="selected" <?php } ?>>ไตรมาสที่ 2</option>
        <option value="6" <?php if($_REQUEST["MonthNo"] == 6){ ?> selected="selected" <?php } ?>>ไตรมาสที่ 3</option>
        <option value="9" <?php if($_REQUEST["MonthNo"] == 9){ ?> selected="selected" <?php } ?>>ไตรมาสที่ 4</option>
    </select>
    </td>
  </tr>
<?php } ?>

  <tr>
    <th style="text-align:left;">% ดำเนินงาน</th>
    <td class="require" >*</td>
    <td>
    <input type="text" name="Progress" id="Progress" value="<?php echo $Progress;?>" onkeyup="CalProgressAmass()" onKeyPress="return validChars(event,1)" style="width:150px; text-align:center;" /> <span class="hint">(เป็นตัวเลขเท่านั้น)</span></td>
  </tr>
      <tr>
    <th style="text-align:left">% ค่าน้ำหนักกิจกรรม</th>
    <td>&nbsp;</td>
    <td  style="text-align:left;"><input type="text" name="PercentMass" id="PercentMass" value="<?php echo $PercentMass;?>" readonly="readonly"  style="width:150px; text-align:center;" /> <b>%ของโครงการ</b></td>
  </tr> 
    <tr>
    <th style="text-align:left; width:20%">% ความก้าวหน้า</th>
    <td>&nbsp;</td>
    <td><input type="text" name="ProgressAmass" id="ProgressAmass" value="<?php echo ($ProgressAmass)?$ProgressAmass:"0.0";?>" readonly="readonly"  style="width:150px; text-align:center;" /> <b>%</b> <span class="hint">(ได้จากผลคูณของ % ดำเนินงาน และ % ค่าน้ำหนักกิจกรรม)</span></td>
  </tr>
  <tr>
    <th valign="top" style="text-align:left">ผลการดำเนินการ</th>
    <td >&nbsp;</td>
    <td  style="text-align:left; font-weight:bold"><textarea name="Result" id="Result" rows="5"  style=" width:100%"><?php echo $Result;?></textarea></td>
  </tr>
  <tr>
    <th valign="top" style="text-align:left">ปัญหา/อุปสรรค</th>
    <td >&nbsp;</td>
    <td  style="text-align:left; font-weight:bold"><textarea name="Problem" id="Problem" rows="5"  style=" width:100%"><?php echo $Problem;?></textarea></td>
  </tr>
  <tr>
    <th valign="top" style="text-align:left">ปัจจัยสนับสนุน</th>
    <td >&nbsp;</td>
    <td  style="text-align:left; font-weight:bold"><textarea name="Factor" id="Factor" rows="5"  style=" width:100%"><?php echo $Factor;?></textarea></td>
  </tr>
  <tr>
    <th style="text-align:left">เอกสารแนบที่เกียวข้อง</th>
    <td >&nbsp;</td>
    <td  style="text-align:left; font-weight:bold">
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
    <td >&nbsp;</td>
    <td  style="text-align:left; font-weight:bold"><textarea name="Comment" id="Comment" rows="5"  style=" width:100%"><?php echo $Comment;?></textarea></td>
  </tr>
</table>    
    
    
  </td>
  </tr>         
</table>
    
    




     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="submit" class="btnActive" name="save" id="save" value="บันทึก"  />
      <input type="button" name="button" id="button" value="ยกเลิก" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $BgtYear;?>');" />
      </div>
      
</form>

