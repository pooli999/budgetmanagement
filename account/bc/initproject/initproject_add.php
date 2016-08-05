<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setPathWays(array(
/*	array(
		'text' => 'จัดการข้อมูลพื้นฐาน',
		'link' => '?mod=budget.init.startup',
	),*/
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'เพิ่ม'.$MenuName
	),
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
		
/*		if(JQ('#PrjCode').val() == '' || JQ('#PrjCode').val() == ' '){
			jAlert('กรุณาระบุรหัสโครงการ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PrjCode').focus();
			});
			return false;
		}*/
	
		if(JQ('#PrjName').val() == '' || JQ('#PrjName').val() == ' '){
			jAlert('กรุณาระบุชื่อโครงการ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PrjName').focus();
			});
			return false;
		}
		
		if(JQ('#PItemCode').val() == 0){
			jAlert('กรุณาระบุแผนงาน สช.','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PItemCode').focus();
			});
			return false;
		}		
		
		if(JQ('#OrganizeCode').val() == 0){
			jAlert('กรุณาระบุหน่วยงานเจ้าของโครงการ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#OrganizeCode').focus();
			});
			return false;
		}			
		
		if(JQ('#PrjBudget').val() == '' || JQ('#PrjBudget').val() == ' '){
			jAlert('กรุณาระบุกรอบงบประมาณ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PrjBudget').focus();
			});
			return false;
		}
		
		if(!JQ('#PrjMethods1').is(':checked') && !JQ('#PrjMethods2').is(':checked')){
			jAlert('กรุณาระบุวิธีการรายงานผลการดำเนินงาน','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PrjMethods').focus();
			});
			return false;
		}
		
		if(!JQ('#PrjFeature1').is(':checked') && !JQ('#PrjFeature2').is(':checked')){
			jAlert('กรุณาระบุลักษณะโครงการ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PrjFeature').focus();
			});
			return false;
		}
					
		<?php //if($_REQUEST['id'] != ""){ ?>
		/*if(JQ('#OldPrjCode').val() != ''  && JQ('#PItemCode').val() != <?php echo $PItemCode;?>){
							
			var firmProcess  =  confirm("ปี "+JQ('#BgtYear').val()+" มีรหัสโครงการนี้อยู่แล้ว คุณต้องการให้ระบบรันรหัสโครงการใหม่ต่อจากรหัสล่าสุดหรือไม่");
			if (firmProcess){  JQ('#NewGen').val('Y');   return true ;  }else{   JQ('#NewGen').val('N');  return false ;}
						
		}*/
		<?php //} ?>
		
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
 
/* 	function loadSCT(BgtYear){
		//window.location.href='?mod=<?php echo lurl::dotPage($addPage);?>&BgtYear='+BgtYear;
	}
*/	
	
	
function loadSCT(BgtYear){
	var PItemCode = JQ('#PItemCode').val();
	var OrganizeCode = JQ('#OrganizeCode').val();

		JQ.ajax({
		   type: "POST",
		   url: "?mod=<?php echo LURL::dotPage('initproject_action');?>",		   
		   data: "action=pitemlist&BgtYear="+BgtYear,
		   success: function(msg){
				JQ("#pitembox").html(msg);
			
		   }
		});
		
		JQ.ajax({
		   type: "POST",
		   url: "?mod=<?php echo LURL::dotPage('initproject_action');?>",		   
		   data: "action=orglist&BgtYear="+BgtYear,
		   success: function(msg){
				JQ("#orgbox").html(msg);
			
		   }
		});
		
		JQ.ajax({
		   type: "POST",
		   url: "?mod=<?php echo LURL::dotPage('initproject_action');?>",		   
		   data: "action=projectlist&BgtYear="+BgtYear+"&OrganizeCode="+OrganizeCode+"&PItemCode="+PItemCode,
		   success: function(msg){
				JQ("#oldprj").html(msg);
		   }
		});		

}// end	
	
function loadPrj(){
	var PItemCode = JQ('#PItemCode').val();
	var BgtYear = JQ('#BgtYear').val();
	var OrganizeCode = JQ('#OrganizeCode').val();

		JQ.ajax({
		   type: "POST",
		   url: "?mod=<?php echo LURL::dotPage('initproject_action');?>",		   
		   data: "action=projectlist&BgtYear="+BgtYear+"&OrganizeCode="+OrganizeCode+"&PItemCode="+PItemCode,
		   success: function(msg){
				JQ("#oldprj").html(msg);
		   }
		});


		// ----- Check GenCode -----
		var PrjCode = JQ('#PrjCode').val();
		
		JQ.ajax({
				   type: "POST",
				   url: "?mod=<?php echo LURL::dotPage('initproject_action');?>",		   
				   data: "action=getoldcode&BgtYear="+BgtYear+"&PItemCode="+PItemCode+"&PrjCode="+PrjCode,
				   success: function(data) {
					   var result = data.split('---');
					   JQ('#OldPrjCode').val(result[0]);
					 // alert(result[0]);
				   }
		});	



}// end
	
function hideOldProject(){
	JQ("#oldprj").hide();
}

function showOldProject(){
	loadPrj();
	JQ("#oldprj").show();
}	

JQ(document).ready(function(){
	JQ("#oldprj").hide();
	<?php if($PrjFeature == "continue"){ ?>
	JQ("#oldprj").show(); 
	<?php } ?>
});


/*  ]]> */


function loadMainPlan(PLongCode){
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('initproject_action');?>",		   
		  data: "action=mainplanlist&PLongCode="+PLongCode,
		  success: function(msg){
			JQ("#main-plan").html(msg);
		  }
	});

}// end

function loadMainProject(LPlanCode){//alert(LPlanCode);
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('initproject_action');?>",		   
		  data: "action=mainprojectlist&LPlanCode="+LPlanCode,
		  success: function(msg){
			JQ("#main-project").html(msg);
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
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>&BgtYear=<?php echo ($BgtYear)?$BgtYear:$_REQUEST["BgtYear"];?>')" /></td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input name="PrjId" type="hidden"  id="PrjId" value="<?php echo $_REQUEST['id'];?>" />
<input name="PrjCode" type="hidden" id="PrjCode" value="<?php echo $PrjCode;?>"  />
<input name="OldPrjCode" type="hidden" id="OldPrjCode" value="" />
<input name="NewGen" type="hidden" id="NewGen" value="N" />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th>ปีงบประมาณ</th>
    <td class="require">*</td>
    <td><?php $get->getYear(($BgtYear)?$BgtYear:$_REQUEST["BgtYear"],'BgtYear');?></td>
  </tr>
  <?php if($_GET["id"] != ""){ ?> 
  <tr>
  <th>รหัสโครงการ</th>
  <td class="require">&nbsp;</td>
  <td><?php echo $PrjCode;?><!--<input name="PrjCode" type="text" id="PrjCode" value="<?php //echo $PrjCode;?>" size="20" />--></td>
</tr> 
<?php } ?> 
<tr>
  <th>ชื่อโครงการ</th>
  <td class="require">*</td>
  <td><input name="PrjName" type="text" id="PrjName" value="<?php echo $PrjName;?>" style="width:98%;" /></td>
</tr>
<tr style="vertical-align:top;">
<th>อ้างอิงแผนหลัก</th>
<td class="require" style="vertical-align:top;">*</td>
<td>
<?php 
if($LPrjCode){
	$LPlanCode = $get->getLPlanCode($LPrjCode);
	$PLongCode = $get->getPLongCode($LPlanCode);
}
?>
<div style="padding-bottom:3px;"><?php echo $get->getMainList($PLongCode);?></div>
<div id="main-plan" style="padding-bottom:3px;"><?php echo $get->getMainPlanList($PLongCode,$LPlanCode);?></div>
<div id="main-project"><?php echo $get->getMainProjectList($LPlanCode,$LPrjCode);?></div>
</td>
</tr>
<tr>
  <th>ภายใต้แผนงาน สช.</th>
  <td><span class="require">*</span></td>
  <td id="pitembox"><?php echo $get->getPlanItemList(($BgtYear)?$BgtYear:$_REQUEST["BgtYear"],$PItemCode,'onchange="loadPrj()" style="width:80%"','PItemCode');?></td>
</tr>
<tr>
  <th>หน่วยงานเจ้าของโครงการ</th>
  <td class="require">*</td>
  <td id="orgbox"><?php echo $get->getOrgShortNameList(($BgtYear)?$BgtYear:$_REQUEST["BgtYear"],$OrganizeCode,'onchange="loadPrj()" style="width:80%"','OrganizeCode');?></td>
</tr>
<tr>
   <th valign="top">ผู้รับผิดชอบโครงการ</th>
   <td class="require">&nbsp;</td>
   <td ><?php echo ePerson(array('name'=>'PersonalSelect[]','id'=>'PersonalSelect','value'=>implodeString($get->getTaskPerson($PrjId),'PersonalCode'),'selecttype'=>'multi'));?></td>
 </tr>
<tr>
  <th>กรอบงบประมาณ</th>
  <td class="require">*</td>
  <td><input name="PrjBudget" type="text" id="PrjBudget" value="<?php echo $PrjBudget;?>" size="20" class="number"  /> บาท</td>
</tr>
<tr>
  <th>วิธีการรายงานผลการดำเนินงาน</th>
  <td class="require">*</td>
  <td>
  <input name="PrjMethods" id="PrjMethods1"  type="radio" value="monthly" <?php if($PrjMethods == "monthly"){ echo 'checked="checked"'; } ?>  /> รายเดือน
  <input name="PrjMethods" id="PrjMethods2" type="radio" value="quarterly" <?php if($PrjMethods == "quarterly"){ echo 'checked="checked"'; } ?> /> รายไตรมาส
  </td>
</tr>
<tr>
  <th>ลักษณะโครงการ</th>
  <td class="require">*</td>
  <td>
  <input name="PrjFeature" id="PrjFeature1" type="radio" value="discontinuous" <?php if($PrjFeature == "discontinuous"){ echo 'checked="checked"'; } ?>   onclick="hideOldProject();" /> โครงการใหม่
  <input name="PrjFeature" id="PrjFeature2"  type="radio" value="continue" <?php if($PrjFeature == "continue"){ echo 'checked="checked"'; } ?> onclick="showOldProject();"  /> โครงการต่อเนื่อง
  <span id="oldprj">
  	<?php 
		if($PrjFeature == "continue"){
			echo $get->getProjectList(($BgtYear)?$BgtYear:$_REQUEST["BgtYear"],$PItemCode,$OrganizeCode,'OldPrjId',$OldPrjId,'style="width:60%"');
		}
	?>
  </span>
  </td>
</tr>
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










