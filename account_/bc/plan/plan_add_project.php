<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css'
));

$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'เพิ่ม'.$MenuName
	),
));


?>

<?php 
$datas = $get->getPlanDetail($_REQUEST["LPlanCode"]);//ltxt::print_r($dataPlan);
foreach($datas as $r){
	foreach( $r as $k=>$v){ ${$k} = $v;}
}
?>    

<script language="javascript" type="text/javascript">

/* <![CDATA[ */

function ValidateForm(f){

		/*if(JQ('#PLongCode').val() == '' || JQ('#PLongCode').val() == ' '){
			jAlert('กรุณาระบุรหัสแผนงานต่อเนื่อง','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PLongCode').focus();
			});
			return false;
		}
			
		if(JQ('#PLongName').val() == '' || JQ('#PLongName').val() == ' '){
			jAlert('กรุณาระบุชื่อแผนงานต่อเนื่อง','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PLongName').focus();
			});
			return false;
		}
		
		if(JQ('#PLongYear').val() == 0){
			jAlert('กรุณาระบุปีที่ตั้งแผนงาน','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PLongYear').focus();
			});
			return false;
		}		
		
		if(JQ('#PLongAmount').val() == '' || JQ('#PLongAmount').val() == ' '){
			jAlert('กรุณาระบุจำนวนปีต่อเนื่อง','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PLongAmount').focus();
			});
			return false;
		}			*/

		return true;
}


function Save(f){
	if(ValidateForm(f)){	
		 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		 var redirec_url = '?mod=<?php echo LURL::dotPage($listPage);?>';
		 toSubmit(f,'saveproject',action_url,redirec_url);
	}
}

/*function Confirm(f){
	if(ValidateForm(f)){		
		var firm_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		toConfirm(f,'confirm',firm_url);
	}
	
}*/
 

/*  ]]> */

</script>
<div class="sysinfo">
  <div class="sysname">เพิ่มข้อมูลโครงการ</div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไขโครงการ</div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input name="LPlanCode" type="hidden"  id="LPlanCode" value="<?php echo $_REQUEST['LPlanCode'];?>" />
<input name="PLongCode" type="hidden"  id="PLongCode" value="<?php echo $PLongCode;?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>








<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
<tr>
<th>ชื่อแผนหลัก</th>
<td><?php echo $PLongName;?></td>
</tr>
<tr style="vertical-align:top;">
<th valign="top">รายละเอียด</th>
<td><?php echo ($PLongDetail)?$PLongDetail:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
</tr>
<tr>
<th>ปีที่ตั้งแผนหลัก</th>
<td><?php echo $PLongYear;?><b>-</b><?php echo $PLongYearEnd;?>&nbsp;(ต่อเนื่อง <?php echo $PLongAmount;?> ปี)</td>
</tr>
<tr>
<th>ชื่อแผนงาน</th>
<td style="font-weight:bold;">(<?php echo $LPlanCode;?>) <?php echo $LPlanName;?></td>
</tr>
<tr>
<th colspan="3">ข้อมูลโครงการภายใต้แผนงาน</th>
</tr>
<tr>
<td colspan="3">










<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
    <thead>
        <tr>
            <td style="width:15%; text-align:center">รหัสโครงการ</td>
            <td style="width:77%; text-align:center">ชื่อโครงการ</td>
            <td style="width:8%; text-align:center">ปฏิบัติการ</td>
        </tr>
     </thead>
	</table>
    
<?php 
$dataPlan = $get->getProjectItem($LPlanCode);//ltxt::print_r($dataPlan);
 if($dataPlan){
     $count = 1;
        foreach($dataPlan as $r){
            foreach( $r as $k=>$v){ ${$k} = $v;}
	 
?>    
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl<?php echo $count; ?>">
    <tr>
    <td style="width:15%; text-align:center"><input type="text" style="width:99%; text-align:center;" value="<?php echo $LPrjCode; ?>"  name="LPrjCode[]" /></td>
    <td style="width:77%; text-align:center"><input type="text" style="width:99%;" value="<?php echo $LPrjName; ?>" name="LPrjName[]" /></td>
    <td style="width:8%; text-align:center"><a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php echo $count; ?>').remove(); CountItem--;}" class="ico delete" >ลบทิ้ง</a></td>
    </tr>
 </table>  
				
<?php				
			$count++;
		}
	}
?> 
   
<?php if(!empty($dataPlan)){ $CItem = $count; }else{ $CItem = 1; } ?>

<div id="ListItems"></div>

<script>
var CountItem = <?php echo $CItem; ?>;

<?php if(empty($dataPlan)){  ?>

JQ(document).ready(function(){
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('plan_project_addrow');?>&format=raw&num=' + CountItem,
				   success: function(data){
					   CountItem = CountItem + 1;
					  JQ('#ListItems').append(data);
				   }
			 });	

});
<?php } ?>

function AddItem()
{
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('plan_project_addrow');?>&format=raw&num=' + CountItem,
				   success: function(data){
					   CountItem = CountItem + 1;
					  JQ('#ListItems').append(data);
				   }
			 });	
}
</script>    
    
    <div align="right">
    <a href="javascript:void(0);" onclick="AddItem();" class="ico add">เพิ่มโครงการ</a>
    </div>


















</td>
</tr>



</table>





<div style="padding:10px; text-align:center;">
<input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="history.back(-1);" />
</div>













</form>
</div>
<div id="detailView" style=" display:none"></div>
