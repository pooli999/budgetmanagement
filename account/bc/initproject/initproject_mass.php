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
	VSROOT.'modules/backoffice/finance/style_finance.css'
));

//ltxt::print_r($_GET);

		if(!$_REQUEST['BgtYear']){
			$_REQUEST['BgtYear'] = date("Y")+543;
		}
		
		$defaultpage = date("m");
		//echo "defaultpage= ".$defaultpage;
		if($_REQUEST["pageid"]  == ""){
			$_REQUEST["pageid"] = $defaultpage;
			
		}
	
if($_REQUEST['PrjId']){
	$dataPrj=$get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST['OrgCode'], 0, 0, $_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId']);
	//ltxt::print_r($dataPrj);
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
	/*if(JQ('#Progress').val()==""){
		alert("กรุณากรอก % ความก้าวหน้า");
		JQ('Progress').focus();
		return false
	}*/
	
	return true;
}

	
</script>


<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>

<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td align="right">
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn"  onClick="history.back(-1);" />
      </td>
    </tr>
  </table>  
</div>



<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=savemass" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="PItemCode" id="PItemCode" value="<?php echo $_REQUEST['PItemCode'];?>" />
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>" />


<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th style="width:20%; text-align:left">ปีงบประมาณ</th>
    <td  style="width:80%; text-align:left;"><?php echo $_REQUEST["BgtYear"]; ?></td>
  </tr>
  <tr>
    <th style="text-align:left">ชื่อแผนงาน สช.</th>
    <td  style="text-align:left;"><b>(<?php echo $_REQUEST["PItemCode"]; ?>) <?php echo $get->getPItemName($_REQUEST["PItemCode"]); ?></b></td>
  </tr> 
  <tr>
    <td colspan="2" valign="top">
    
    
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
      <thead>
        <tr>
          <td style="width:40px;">ลำดับ</td>
          <td style="text-align:center;">ชื่อโครงการ</td>
          <td style="width:150px; text-align:center;">%น้ำหนักโครงการ</td>
          </tr>
      </thead>
      
      
<?php
$i=1;
$listProject = $get->getProject($_REQUEST["PItemCode"],$_REQUEST["BgtYear"]);
if($listProject){
	foreach($listProject as $listP) {
		foreach( $listP as $k=>$v){ ${$k} = $v;}
?>      
      <tr style="vertical-align:top;">
        <td style="text-align:center;"><?php echo $i; ?></td>
        <td><?php echo $PrjName; ?></td>
        <td style="text-align:center;">
        <input type="hidden" name="PrjId[]" value="<?php echo $PrjId; ?>"  />
        <input type="text" style="width:98%; text-align:center;" value="<?php echo $PrjMass; ?>" name="PrjMass[]" />
        </td>
      </tr>
<?php 
		$i++;
	}
}else{ ?>
      <tr style="vertical-align:top;">
        <td colspan="3" style="text-align:center; color:#999;">-ไม่มีรายการในฐานข้อมูล-</td>
      </tr>
<?php } ?>

    </table>
    
    
    
    
    
    </td>
  </tr>         
</table>







     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="submit" class="btnActive" name="save" id="save" value="บันทึก"  />
      <input type="button" name="button" id="button" value="ยกเลิก" class="btn"  onClick="history.back(-1);" /></div>
      
</form>

