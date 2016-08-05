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
	VSROOT.'modules/backoffice/budget/style_budget.css'
));

/*function icoCancel($r){
	$label = 'ยกเลิก';
	$text = 'ยกเลิก';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:if(confirm('ยกเลิกกิจกรรม ".$r->PrjActName." ')) self.location='?mod=".LURL::dotPage($actionPage)."&action=cancelact&PrjActId=".$r->PrjActId."&BgtYear=".$_REQUEST['BgtYear']."&BgtYear=".$_REQUEST['BgtYear']."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']."&start=".$_REQUEST["start"]."'",
		'ico cancel',
		$label,
		$text
	));
}
*/

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 
?>

<script language="javascript" type="text/javascript">
//var __debug = true;

/* <![CDATA[ */

function ValidateForm(f){
/*	if(JQ('#BgtYear').val()==0){
			jAlert('กรุณาระบุปีงบประมาณ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#BgtYear').focus();
			});
		return false;
	}			
*/
	if(JQ('#PItemCode').val()==0){
			jAlert('กรุณาระบุแผนงาน','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PItemCode').focus();
			});
		return false;
	}	
	
	if(JQ('#PrjId').val()==0){
			jAlert('กรุณาระบุโครงการ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PrjId').focus();
			});
		return false;
	}	
	
	if(JQ('#StartDate').val()==0){
			jAlert('กรุณาระบุวันเริ่มต้นการดำเนินโครงการ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#StartDate').focus();
			});
		return false;
	}	
	
	if(JQ('#EndDate').val()==0){
			jAlert('กรุณาระบุวันสิ้นสุดการดำเนินโครงการ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#EndDate').focus();
			});
		return false;
	}	
		
	var checkprj = false;
	JQ("textarea[name^='PrjActName']").each(function(){
		//alert($(this).val());		
		if(JQ(this).val() == ""){ checkprj = false; }else{ checkprj = true; }

	});
	if(!checkprj){ 
		jAlert('กรุณาระบุกิจกรรม','ระบบตรวจสอบข้อมูล');
		return false;
	}

	return true;
}

function Save(f){
	if(ValidateForm(f)){	
		 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		 var redirec_url = '?mod=<?php echo LURL::dotPage($ListEditPage);?>';
		 toSubmit(f,'save',action_url,redirec_url);
	}
}


/*function loadSCT(BgtYear){
		JQ.ajax({
		   type: "POST",
		   url: "?mod=<?php echo LURL::dotPage('project_action');?>",		   
		   data: "action=pitemlist&BgtYear="+BgtYear,
		   success: function(msg){
				JQ("#plan").html(msg);
		   }
		});	
		
}	*/

function loadPrj(PItemCode){
		//var BgtYear = JQ('#BgtYear').val();
		JQ.ajax({
		   type: "POST",
		   url: "?mod=<?php echo LURL::dotPage('project_action');?>",		   
		   data: "action=projectlist&PItemCode="+PItemCode+"&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"]; ?>",
		   success: function(msg){
				JQ("#prj").html(msg);
		   }
		});
}	

function loadPerson(PrjId){

		JQ.ajax({
		   type: "POST",
		   url: "?mod=<?php echo LURL::dotPage('project_action');?>",		   
		   data: "action=personlist&PrjId="+PrjId,
		   success: function(msg){
				JQ("#showPerson").html(msg);
		   }
		});
		
		JQ("#showPerson").show();
	
}

function ChangeStatus(PrjActId){
		//alert(PrjActId);
		JQ.ajax({
		   type: "POST",
		   url: "?mod=<?php echo LURL::dotPage('project_action');?>",		   
		   data: "action= changetocancel&PrjActId="+PrjActId,
		   success: function(msg){
				JQ("#txtStatus"+PrjActId).html(msg);
		   }
		});
}// function


JQ(document).ready(function(){
	JQ("#showPerson").hide();	
	<?php if($_GET["PrjDetailId"] != ""){ ?>
	JQ("#showPerson").show();
	<?php } ?>
});



/*  ]]> */

</script>


 <table width="100%" cellpadding="0" cellspacing="0" class="page-title-user">
 	<tr>
    	<td class="div-title-plan">&nbsp;</td>
        <td>
       <div class="font1">จัดทำแผนปฏิบัติงานประจำปี</div>
        </td>
    </tr>
 </table>


<div class="sysinfo">
  <div class="sysname" style="font-size:16px;"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>
</div>


<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
      <b>ปีงบประมาณ : </b><?php echo $_REQUEST["BgtYear"]?>
      <b>หน่วยงาน : </b><?php echo $get->getOrgName($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode']);?>
      </td>
      <td align="right">
		<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="history.back(-1);" />     
      </td>
    </tr>
  </table>  
</div>


<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="OrgId" id="OrgId" value="<?php echo $OrgId;?>">
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>">

<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST["SCTypeId"]; ?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST["ScreenLevel"]; ?>" />
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST["PrjDetailId"]; ?>" />
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo ($BgtYear)?$BgtYear:$_REQUEST["BgtYear"];?>">
<input type="hidden" name="StatusId" id="StatusId" value="<?php echo $StatusId; ?>" />

<div style="padding-bottom:5px;padding-top:5px; font-size:14px;" class="hint">กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย <span class="require">*</span> ให้ครบถ้วน</div>

<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
 <tr>
   <th >ปีงบประมาณ</th>
   <td class="require">&nbsp;</td>
   <td><?php echo ($BgtYear)?$BgtYear:$_REQUEST["BgtYear"];  //$get->getYear(($BgtYear)?$BgtYear:$_REQUEST["BgtYear"],'BgtYear');?></td>
 </tr>
 <tr>
   <th>ภายใต้แผนงาน</th>
   <td class="require"><?php if(!$_REQUEST["PrjDetailId"]){ echo '*'; } ?></td>
   <td id="plan">
   <?php 
   if(!$_REQUEST["PrjDetailId"]){
	   echo $get->getPlanItemList(($BgtYear)?$BgtYear:$_REQUEST["BgtYear"],($OrganizeCode)?$OrganizeCode:$_REQUEST["OrganizeCode"],12,$PItemCode,'PItemCode');
   }else{
	   echo '[ '.$PItemCode.' ]&nbsp;'.$get->getPItemCode($PItemCode);
	   echo '<input type="hidden" name="PItemCode" id="PItemCode" value="'.$PItemCode.'" />';
   }
   ?>
   </td>
 </tr> 
  <tr>
    <th>ชื่อโครงการ</th>
    <td class="require"><?php if(!$_REQUEST["PrjDetailId"]){ echo '*'; } ?></td>
    <td id="prj">
	<?php 
	   if(!$_REQUEST["PrjDetailId"]){
		   echo $get->getProjectList(($BgtYear)?$BgtYear:$_REQUEST["BgtYear"],$PItemCode,($OrganizeCode)?$OrganizeCode:$_REQUEST["OrganizeCode"],'PrjId',$PrjId,'onchange="loadPerson(this.value)" style="width:70%"');
	   }else{
		   echo '[ '.$PrjCode.' ]&nbsp;'.$PrjName;
		   echo '<input type="hidden" name="PrjId" id="PrjId" value="'.$PrjId.'" />';
	   }
	?>
  </tr>
    <tr>
    <th>ระยะเวลาการดำเนินโครงการ</th>
    <td class="require">*</td>
    <td>
	<?php 
		if($StartDate=="") $StartDate = date('Y-m-d');
	  	echo InputCalendar_text(array(
			'name' => 'StartDate',
			'value' => $StartDate
		));
		?>
        <strong>ถึง</strong>    
        <?php 
		if($EndDate=="") $EndDate = date('Y-m-d');
	  	echo InputCalendar_text(array(
			'name' => 'EndDate',
			'value' => $EndDate
		));
		?>
</td>
  </tr>
     <tr>
   <th valign="top">หน่วยงานที่รับผิดชอบ</th>
   <td class="require">&nbsp;</td>
   <td><?php echo $get->getOrgName($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode']);?></td>
 </tr>
 <tbody id="showPerson">
<!--<tr>
   <th valign="top">ผู้รับผิดชอบโครงการ</th>
   <td class="require">&nbsp;</td>
   <td >-->
   <?php 
   //echo ePerson(array('name'=>'PersonalSelect[]','id'=>'PersonalSelect','value'=>implodeString($get->getTaskPerson($_GET["PrjDetailId"]),'PersonalCode'),'selecttype'=>'multi'));
   echo $get->getPersonList($PrjId);
   ?>
<!--   </td>
 </tr>-->
 </tbody>
  <tr>
 <td colspan="3" style="padding:0px;"><div class="boxfilter2"><div class="icon-topic">หลักการ</div></div></td>
 </tr> 
   <tr>
    <td colspan="3"> <?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'Principles','id' => 'Principles', 'value' => $Principles,'height'=>'250'));?></td>
  </tr>
<tr>
 <td colspan="3" style="padding:0px;"><div class="boxfilter2"><div class="icon-topic">วัตถุประสงค์</div></div></td>
 </tr> 
 <tr>
   <td colspan="3"> <?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'Purpose','id' => 'Purpose', 'value' => $Purpose,'height'=>'250'));?></td>
</tr> 
<tr>
 <td colspan="3" style="padding:0px;"><div class="boxfilter2"><div class="icon-topic">ผลที่คาดว่าจะได้รับ</div></div></td>
 </tr> 
 <tr>
   <td colspan="3"> <?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'Outputs','id' => 'Outputs', 'value' => $Outputs,'height'=>'250'));?></td>
</tr>




<!--<tr>
 <td colspan="3" style="padding:0px;"><div class="boxfilter2"><div class="icon-topic">ตัวชี้วัดความสำเร็จโครงการ</div></div></td>
 </tr> 
<tr>
<td colspan="3">
  	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
    <thead>
        <tr>
            <td style="width:40%; text-align:center">ชื่อตัวชี้วัดโครงการ</td>
            <td style="width:20%; text-align:center">ประเภทตัวชี้วัด</td>
            <td style="width:15%; text-align:center">ค่าเป้าหมาย</td>
            <td style="width:15%; text-align:center">หน่วยนับ</td>
            <td style="width:10%; text-align:center">ลบทิ้ง</td>
        </tr>
     </thead>
	</table>
    
<?php 
/*$indicatorSelect = $get->getIndicatorSelect($PrjDetailId);
//ltxt::print_r($indicatorSelect);
 if($indicatorSelect){
     $count = 1;
        foreach($indicatorSelect as $r){
            foreach( $r as $k=>$v){ ${$k} = $v;}
*/	 
?>    
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl<?php //echo $count; ?>">
    <tr>
    <td style="width:40%; text-align:center"><input type="text" name="IndicatorName[]"  id="IndicatorName" value="<?php //echo $IndicatorName;?>" style="width:95%" /></td>
    <td style="width:20%; text-align:center"><?php //echo $get->getIndTypeNameList($IndTypeId);?></td>
    <td style="width:15%; text-align:center"><input type="text" name="TargetPlan[]"  id="TargetPlan" value="<?php //echo $TargetPlan;?>" style="width:95%" /></td>
    <td style="width:15%; text-align:center"><?php //echo $get->getUnitList($UnitID);?></td>
    <td style="width:10%; text-align:center">
    <a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php //echo $count; ?>').remove(); CountItem--;}" class="ico delete" >ลบทิ้ง</a>
    </td>
    </tr>
 </table>  
				
<?php				
	/*		$count++;
		}
	}*/
?> 
   
<?php //if(!empty($indicatorSelect)){ $CItem = $count; }else{ $CItem = 1; } ?>

<div id="ListItems"></div>

<script>
//var CountItem = <?php //echo $CItem; ?>;

<?php //if(empty($indicatorSelect)){  ?>

/*JQ(document).ready(function(){
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php //echo LURL::dotPage('project_addrowind');?>&format=raw&num=' + CountItem,
				   success: function(data){
					   CountItem = CountItem + 1;
					  JQ('#ListItems').append(data);
				   }
			 });	

});
*/<?php //} ?>

/*function AddItem()
{
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php //echo LURL::dotPage('project_addrowind');?>&format=raw&num=' + CountItem,
				   success: function(data){
					   CountItem = CountItem + 1;
					  JQ('#ListItems').append(data);
				   }
			 });	
}
*/</script>    
    
    <div align="right">
    <a href="javascript:void(0);" onclick="AddItem();" class="ico add">เพิ่มตัวชี้วัด..</a>
    </div>
    
</td>
</tr>-->







<tr>
 <td colspan="3" style="padding:0px;"><div class="boxfilter2"><div class="icon-topic">กลวิธี / ขั้นตอนการดำเนินงาน / กิจกรรมโครงการ</div></div></td>
 </tr>
<tr>
<td colspan="3">
  	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
    <thead>
        <tr>
            <td style="width:120px; text-align:center">วันเริ่มต้นกิจกรรม</td>
            <td style="width:120px; text-align:center">วันสิ้นสุดกิจกรรม</td>
            <td style="text-align:center">รายการกิจกรรม</td>
            <td style="width:120px; text-align:center">ประเภทกิจกรรม</td>
            <td style="width:70px; text-align:center">%น้ำหนัก</td>
            <td style="width:120px; text-align:center">หน่วยงานปฎิบัติงาน</td>
            <td style="width:120px; text-align:center" >ปฏิบัติการ</td>
        </tr>
     </thead>
	</table>
<?php 
//$indicatorSelect = $get->getIndicatorSelect($PrjDetailId);
$selectAct = $get->getProjectDetailActRecordSet($PrjDetailId);
//ltxt::print_r($selectAct);
 if($selectAct){
     $countA = 1;
        foreach($selectAct as $r){
            foreach( $r as $k=>$v){ ${$k} = $v;} 
				$PrjActStart = $StartDate;
				$PrjActEnd = $EndDate;
?>    

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tblact<?php echo $countA; ?>">
    <tr style="vertical-align:top;">
      	<td style="width:120px; text-align:center;">
		<?php 
			if($PrjActStart == ""){$PrjActStart = date('Y-m-d');}
			echo InputCalendar_text(array(
				'id' => 'PrjActStart'.$countA,
				'name' => 'PrjActStart[]',
				'value' => $PrjActStart
			));
		?>        
        </td>
        <td style="width:120px; text-align:center">
		<?php 
			if($PrjActEnd == ""){$PrjActEnd = date('Y-m-d');}
			echo InputCalendar_text(array(
				'id' => 'PrjActEnd'.$countA,
				'name' => 'PrjActEnd[]',
				'value' => $PrjActEnd
			));
		?>         
        </td>       
        <td style="text-align:center">
        <textarea name="PrjActName[]" id="PrjActName" style="width:98%; height:30px;"><?php echo $PrjActName;?></textarea>
        <!--<input type="text" name="PrjActName[]" id="PrjActName" value="<?php //echo $PrjActName;?>"  style="width:200px;"/>-->
        <input type="hidden" name="PrjActId[]" id="PrjActId" value="<?php echo $PrjActId; ?>" />
        <input type="hidden" name="PrjActCode[]" id="PrjActCode" value="<?php echo $PrjActCode; ?>" />
        </td>
        <td style="width:120px; text-align:center"><?php echo $get->getTypeActNameList($TypeActCode);?></td>
        <td style="width:70px; text-align:center" ><input type="text" name="PercentMass[]"  id="PercentMass[]" value="<?php echo $PercentMass;?>" style="width:95%" class="number" /></td>
        <td style="width:120px; text-align:center" ><?php echo $get->getOrgShortNameList(($BgtYear)?$BgtYear:$_REQUEST["BgtYear"],$OrganizeCode);?></td>
        
        
        <td style="text-align:left; width:120px;">
        <?php if($StatusId == 5){ ?>
        <div style="width:100px; text-align:left; color:green" class="ico enabled">ยกเลิกกิจกรรม</div>        
        <?php }else{ ?>		
        <div id="txtStatus<?php echo $PrjActId;?>">
        <a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tblact<?php echo $countA; ?>').remove(); CountItemA--;}" class="ico delete" >ลบทิ้ง</a>
        &nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="if(confirm('คุณต้องการยกเลิกข้อมูลรายการนี้หรือไม่')){ ChangeStatus(<?php echo $PrjActId;?>); }" class="ico cancel" >ยกเลิก</a>
        </div>
		<?php } ?>
        </td>     
        
        
                  
    </tr>
 </table>

<?php				
			$countA++;
		}
	}
?>     

<?php if(!empty($selectAct)){ $CItemA = $countA; }else{ $CItemA = 1; } ?>

<div id="ListItemsAct"></div>

<script>
var CountItemA = <?php echo $CItemA; ?>;
<?php if(empty($selectAct)){  ?>
JQ(document).ready(function(){
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('project_addrowact');?>&format=raw&numA=' + CountItemA + '&BgtYear=<?php echo $_REQUEST["BgtYear"];?>',
				   success: function(data){
					   CountItemA = CountItemA + 1;
					  JQ('#ListItemsAct').append(data);
				   }
			 });	

});
<?php } ?>

function AddItemAct()
{
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('project_addrowact');?>&format=raw&numA=' + CountItemA + '&BgtYear=<?php echo $_REQUEST["BgtYear"];?>',
				   success: function(data){
					   CountItemA = CountItemA + 1;
					  JQ('#ListItemsAct').append(data);
				   }
			 });	
}
</script>    
    
    <div align="right">
    <a href="javascript:void(0);" onclick="AddItemAct();" class="ico add">เพิ่มกิจกรรม..</a>
    </div>    
    
</td>
</tr>
<tr>
 <td colspan="3" style="padding:0px;"><div class="boxfilter2"><div class="icon-topic">ไฟล์เอกสารโครงการ</div></div></td>
</tr>
<tr>
 <td colspan="3">
 <?php
				
		$MultiDocId =	$get->getLinkFiles($PrjDetailId);	
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
			'SubCategory'	=> "แผนปฏิบัติงานประจำปี",		
			'System'		=> "backoffice",
			'Module'		=> "project"
		));
		
?>
  
        
 </td>
 </tr>
<tr>
 <td colspan="3" style="padding:0px;"><div class="boxfilter2"><div class="icon-topic">รายการตรวจสอบโครงการ</div></div></td>
</tr>
 <tr>
 <td colspan="3">
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
 	<thead>
        <tr>
          <td style="text-align: center; width:5%;">ลำดับ</td>
          <td style="text-align: center; width:20%;">วันที่ตรวจสอบ</td>
          <td style="text-align: center; width:30%;">ผลการตรวจสอบ</td>
          <td style="text-align: center; width:25%;">หมายเหตุ</td>
          <td style="text-align: center; width:20%;">ผู้ตรวจสอบ</td>
        </tr>
    </thead>
<?php
$d=0;
$DCheck = $get->getListCheck($PrjDetailId);
if($DCheck){
foreach($DCheck as $RCProject){
	foreach($RCProject as $k=>$v){
		${$k} = $v;
	}
?>
        <tr>
          <td style="text-align:center"><?php echo ($d+1); ?></td>
          <td><?php echo dateformat($CreateDate)?>&nbsp;</td>
          <td>
			<?php
            switch($Result){
                case "Y":
                    echo "<span class='ico approve'>ผ่านการตรวจสอบ</span>";
                break;
                case "N";
                    echo "<span class='ico redo'>ตีกลับ</span>";
                break;
                default:
                    echo "<span class='ico wait'>รอตรวจสอบ</span>";
                break;
            }
            ?>&nbsp;
          </td>
          <td><?php echo $Comment;?>&nbsp;</td>
          <td><?php echo fn_getFullNameByUserId($CreateBy);?>&nbsp;</td>
        </tr>
<?php
$d++;
}
}else{
?>
<tr>
	<td colspan="5" style="text-align:center; vertical-align:top; color:#900 ">- -ไม่มีข้อมูล - -</td>
</tr>
<?php } ?>
</table>
 
 </td>
 </tr>
 <tr>
 <th>&nbsp;</th>
 <td>&nbsp;</td>
 <td >
<input type="button" class="btnRed" name="save" id="save" value="บันทึก" onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="history.back(-1);" /> 
 </td>
 </tr>
 
</table>

</form>
</div>
<div id="detailView" style=" display:none"></div>

