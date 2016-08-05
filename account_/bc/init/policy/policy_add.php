<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setPathWays(array(
	array(
		'text' => 'จัดการข้อมูลพื้นฐาน',
		'link' => '?mod=budget.init.startup',
	),
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'เพิ่ม'.$MenuName
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));
?>
<script language="javascript" type="text/javascript">

/* <![CDATA[ */

function ValidateForm(f){
	
		if(JQ('#BgtYear').val() == 0){
			jAlert('กรุณาระบุปีงบประมาณ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#BgtYear').focus();
			});
			return false;
		}

		if(JQ('#PItemName').val() == '' || JQ('#PItemName').val() == ' '){
			jAlert('กรุณาระบุชื่อนโยบายแผนงาน','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PGroupName').focus();
			});
			return false;
		}

		<?php if($_REQUEST['id'] != ""){ ?>
		if(JQ('#OldPItemCode').val() != '' && JQ('#BgtYear').val() != <?php echo $BgtYear;?>){
							
			var firmProcess  =  confirm("ปี "+JQ('#BgtYear').val()+" มีรหัสแผนงานนนี้อยู่แล้ว คุณต้องการให้ระบบรันรหัสแผนงานใหม่ต่อจากรหัสล่าสุดหรือไม่");
			if (firmProcess){  JQ('#NewGen').val('Y');   return true ;  }else{   JQ('#NewGen').val('N');  return false ;}
						
		}
		<?php } ?>
		
		return true;
}


function Save(f){
	if(ValidateForm(f)){	
		 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		 var redirec_url = '?mod=<?php echo LURL::dotPage($listPage);?>';
		 toSubmit(f,'save',action_url,redirec_url);
	}
}

/*function Confirm(f){
	if(ValidateForm(f)){		
		var firm_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		toConfirm(f,'confirm',firm_url);
	}
	
}*/
 
 	function loadSCT(BgtYear){
		var PItemCode = JQ('#PItemCode').val();
		
		JQ.ajax({
				   type: "POST",
				   url: "?mod=<?php echo LURL::dotPage('policy_action');?>",		   
				   data: "action=getoldcode&BgtYear="+BgtYear+"&PItemCode="+PItemCode,
				   success: function(data) {
					   var result = data.split('---');
					   JQ('#OldPItemCode').val(result[0]);
					 // alert(result[0]);
					 
					 
				   }
		});	

	
	}

/*  ]]> */



function loadMainPlan(PLongCode){
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('policy_action');?>",		   
		  data: "action=mainplanlist&PLongCode="+PLongCode,
		  success: function(msg){
			JQ("#main-plan").html(msg);
		  }
	});

}// end

</script>
<div class="sysinfo">
  <div class="sysname">เพิ่มรายการ<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไข<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td style="padding:3px; font-weight:bold; font-size:16px;"><?php echo $get->getPGroupName(($PGroupId)?$PGroupId:$_REQUEST["PGroupId"]);?></td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>&BgtYear=<?php echo $_REQUEST["BgtYear"];?>')" /></td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input name="PItemId" type="hidden"  id="PItemId" value="<?php echo $_REQUEST['id'];?>" />
<input name="PGroupId" type="hidden"  id="PGroupId" value="<?php echo ($PGroupId)?$PGroupId:$_REQUEST["PGroupId"];?>" />
<input name="PItemCode" type="hidden" id="PItemCode" value="<?php echo $PItemCode;?>"  />
<input name="OldPItemCode" type="hidden" id="OldPItemCode" value="" />
<input name="NewGen" type="hidden" id="NewGen" value="N" />

<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#EEEEEE">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th>ปีงบประมาณ</th>
    <td class="require"><?php if(!$PItemId){ echo '*'; } ?></td>
    <td>
	<?php 
		if($PItemId){ 
			 echo $BgtYear;
			 echo '<input name="BgtYear" type="hidden" id="BgtYear" value="'.$BgtYear.'"  />';
		}else{
			$get->getYear(($BgtYear)?$BgtYear:$_REQUEST["BgtYear"],'BgtYear');
		}
	?>
    </td>
  </tr>
  
<?php if($_GET["id"] != ""){ ?> 
<tr>
<th>รหัส<?php echo $get->getPGroupName(($PGroupId)?$PGroupId:$_REQUEST["PGroupId"]);?></th>
<td class="require">&nbsp;</td>
<td><?php echo $PItemCode;?></td>
</tr>
<?php } ?>

<tr>
<th style="vertical-align:top;">ชื่อ<?php echo $get->getPGroupName(($PGroupId)?$PGroupId:$_REQUEST["PGroupId"]);?></th>
<td class="require" style="vertical-align:top;">*</td>
<td><textarea name="PItemName" id="PItemName" style="width:98%; height:100px;"><?php echo $PItemName;?></textarea></td>
</tr>

<?php if($PGroupId == 12){ ?>
<tr>
  <th>วิธีการรายงานผลตัวชี้วัด</th>
  <td class="require">*</td>
  <td>
  <input name="Methods" id="Methods1"  type="radio" value="monthly" <?php if($Methods == "monthly"){ echo 'checked="checked"'; } ?>  /> รายเดือน
  <input name="Methods" id="Methods2" type="radio" value="quarterly" <?php if($Methods == "quarterly"){ echo 'checked="checked"'; } ?> /> รายไตรมาส
  </td>
</tr>
<tr>
<th>อ้างอิงแผนหลัก</th>
<td class="require" style="vertical-align:top;">*</td>
<td>
<?php 
if($LPlanCode){
	$PLongCode = $get->getPLongCode($LPlanCode);
}
?>
<span><?php echo $get->getMainList($PLongCode);?></span>
<span id="main-plan"><?php echo $get->getMainPlanList($PLongCode,$LPlanCode);?></span>
</td>
</tr>



<!--เป้าประสงค์ของแผนงาน-->


<tr>
<th colspan="3">เป้าประสงค์ของแผนงาน</th>
</tr>
<tr>
<td colspan="3">


<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
    <thead>
        <tr>
            <td style="width:92%; text-align:center">ชื่อเป้าประสงค์</td>
            <td style="width:8%; text-align:center">ปฏิบัติการ</td>
        </tr>
     </thead>
	</table>
    
<?php 
$dataPlan = $get->getPurposeItem($PItemCode);//ltxt::print_r($dataPlan);
 if($dataPlan){
     $count = 1;
        foreach($dataPlan as $r){
            foreach( $r as $k=>$v){ ${$k} = $v;}
	 
?>    
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl<?php echo $count; ?>">
    <tr style="vertical-align:top;">
    <td style="width:92%; text-align:center"><textarea style="width:99%; height:35px;" name="PurposeName[]"><?php echo $PurposeName; ?></textarea></td>
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
				   url: '?mod=<?php echo LURL::dotPage('policy_add_purpose');?>&format=raw&num=' + CountItem,
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
				   url: '?mod=<?php echo LURL::dotPage('policy_add_purpose');?>&format=raw&num=' + CountItem,
				   success: function(data){
					   CountItem = CountItem + 1;
					  JQ('#ListItems').append(data);
				   }
			 });	
}
</script>    
    
    <div align="right">
    <a href="javascript:void(0);" onclick="AddItem();" class="ico add">เพิ่มเป้าประสงค์</a>
    </div>





</td>
</tr>


<!--END เป้าประสงค์ของแผนงาน-->



<?php } ?>
 <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td>
<input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="history.back(-1);" />    </td>
  </tr>
</table>
</form>
</div>
<div id="detailView" style=" display:none"></div>










