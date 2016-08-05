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

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));

//ltxt::print_r($detail);

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
		
		if(JQ('#PrjCode').val() == '' || JQ('#PrjCode').val() == ' '){
			jAlert('กรุณาระบุรหัสโครงการ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PrjCode').focus();
			});
			return false;
		}
	
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
		

		return true;
}


function Save(f){
	if(ValidateForm(f)){	
		 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		 var redirec_url = '?mod=<?php echo LURL::dotPage($listPage);?>';
		 toSubmit(f,'saveperson',action_url,redirec_url);
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
		
}	
	
	function check_uncheck_all(checkname, field)
	{
		for (i = 0; i < checkname.length; i++) {
			checkname[i].checked = field.checked? true:false
		}
	}	
	

/*  ]]> */

</script>
<div class="sysinfo">
  <div class="sysname">เพิ่มรายการ<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไข<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>&BgtYear=<?php echo $BgtYear;?>')" /></td>
  </tr>
</table>





<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input name="PrjId" type="hidden"  id="PrjId" value="<?php echo $PrjId;?>" />
<input name="BgtYear" type="hidden"  id="BgtYear" value="<?php echo $BgtYear;?>" />



<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th>ปีงบประมาณ</th>
    <td><?php echo $BgtYear; ?></td>
  </tr>
<tr>
  <th>รหัสโครงการ</th>
  <td><?php echo $PrjCode; ?></td>
</tr>  
<tr>
  <th>ชื่อโครงการ</th>
  <td><?php echo $PrjName;?></td>
</tr>
<tr>
  <th>ภายใต้แผนงาน สช.</th>
  <td id="pitembox"><?php echo $get->getPItemName($PItemCode); ?></td>
</tr>
<tr>
  <th>หน่วยงานเจ้าของโครงการ</th>
  <td id="orgbox"><?php  echo  $get->getOrgShortName($BgtYear,$OrganizeCode);  ?></td>
</tr>
<tr>
   <th valign="top">ผู้รับผิดชอบโครงการ</th>
   <td >
   <?php 
   	$TaskPerson = $get->getTaskPerson($PrjId); 
   echo "<ul>";
   foreach($TaskPerson as $rRName){
   		foreach($rRName as $k=>$v){
			${$k} = $v;
		}
		echo "<li>".$Name."</li>";
   }
   echo "</ul>";
	
   ?>
   </td>
 </tr>

<tr>
  <th>กรอบงบประมาณ</th>
  <td style="font-weight:bold"><div style="width:100px; text-align:right; float:left"><?php echo number_format($PrjBudget,2);?></div>&nbsp;บาท</td>
</tr>
<tr>
  <th>งบกลั่นกรองระดับสำนักงบประมาณ</th>
  <td style="font-weight:bold"><div style="width:100px; text-align:right; float:left"><?php echo number_format($get->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,0,0,2,1,0),2);?></div>&nbsp;บาท</td>
</tr>
<tr>
  <th>งบกลั่นกรองระดับอนุกรรมาธิการ</th>
  <td style="font-weight:bold"><div style="width:100px; text-align:right; float:left"><?php echo number_format($get->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,0,0,2,2,0),2);?></div>&nbsp;บาท</td>
</tr>
<tr>
  <th>งบจัดสรร</th>
  <td style="font-weight:bold"><div style="width:100px; text-align:right; float:left"><?php echo number_format($get->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,0,0,3,0,0),2);?></div>&nbsp;บาท</td>
</tr>
<tr>
  <th>งบปรับกลางปี</th>
  <td style="font-weight:bold"><div style="width:100px; text-align:right; float:left"><?php echo number_format($get->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,0,0,4,0,0),2);?></div>&nbsp;บาท</td>
</tr>
<tr>
  <th>วิธีการรายงานผลการดำเนินงาน</th>
  <td>
<?php if($PrjMethods == "monthly"){ echo 'รายเดือน'; } ?>
<?php if($PrjMethods == "quarterly"){ echo 'รายไตรมาส'; } ?>
  </td>
</tr>   
<tr>
  <th>วิธีการรายงานผลการดำเนินงาน</th>
  <td>
<?php if($PrjFeature == "continue"){ echo 'โครงการต่อเนื่อง'; } ?>
<?php if($PrjFeature == "discontinuous"){ echo 'โครงการไม่ต่อเนื่อง'; } ?>
  </td>
</tr>      
 <tr>
 <td colspan="2" style="padding:0px;"><div class="boxfilter-sub">รายชื่อผู้รายงานผล</div></td>
 </tr> 
 <tr>
    <td colspan="2">
    
      <table width="50%" border="0" cellspacing="1" cellpadding="0" class="tbl-view">
      <tr>
        <td style="width:2%; text-align:left"><input name="chk_all" type="checkbox" id="chk_all" onClick="check_uncheck_all(document.adminForm.PersonalCode,this)" class="checkbox-default" /></td>
        <th style="width:5%; text-align:center">ลำดับ</th>
        <th style="width:43%; text-align:center">ชื่อ - นามสกุล</th>
      </tr>
      <?php
      $taskPerson = $get->getTaskPerson($PrjId);
	 // ltxt::print_r($taskPerson);
	  	if($taskPerson){
		  $i=0;	
          foreach($taskPerson as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
	  ?>
      <tr>
        <td style="text-align:left"><input name="PersonalCode[<?php echo $i; ?>]" type="checkbox" id="PersonalCode"  value="<?php echo $PersonalCode;?>" <?php if($ResultStatus == "Y"){ echo 'checked="checked"'; } ?> />
        <input name="PersonId[]" type="hidden"  id="PersonId" value="<?php echo $PersonId;?>" />
        </td>
        <td style="text-align:center"><?php echo $i+1; ?></td>
        <td style="text-align:left"><?php echo $Name;?></td>
      </tr>
      <?php
	  		$i++;
		  }
		}else{
	  ?>
      <tr>
      	<td colspan="3" style="height:200px; vertical-align:middle; text-align:center; color:#F00">- ไม่มีรายชื่อผู้รับผิดชอบโครงการ -</td>
      </tr>
  	 <?php } ?>    
    </table>
    
    </td>
  </tr>
 <tr>
    <th>&nbsp;</th>
    <td>
<input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="history.back(-1);" />    </td>
  </tr>
</table>
</form>
</div>
<div id="detailView" style=" display:none"></div>










