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

$datas = $get->getActivityDetail($_REQUEST["PrjDetailId"],$_REQUEST["PrjActId"]);//ltxt::print_r($datas);
foreach($datas as $actdatas){
	foreach($actdatas as $k=>$v){
		${$k} = $v;
	}
}

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

?>

<script language="javascript" type="text/javascript">
/* <![CDATA[ */

function ValidateForm(f){
/*	var checkprj = false;
	JQ("input[name^='PartnerCode']").each(function(){
		//alert($(this).val());		
		if(JQ(this).val() == ""){ checkprj = false; }else{ checkprj = true; }

	});
			
	if(!checkprj){ 
		jAlert('กรุณาระบุภาคีเครือข่าย','ระบบตรวจสอบข้อมูล');
		return false;
	}

*/	return true;
			
}

function Save(f){
	if(ValidateForm(f)){	
		 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		 var redirec_url = '?mod=<?php echo LURL::dotPage($partyListPage);?>';
		 toSubmit(f,'saveparty',action_url,redirec_url);
	}
}

/*function loadSubGroup(){
}*/

function getSubGroup(pid,id){
	var param = '&action=subgroup&pid=' + pid +'&id=' + id;
	JQ.ajax({
		type: "POST",
		url: '?mod=<?php echo LURL::dotPage($actionPage);?>',
		data: param,
		success: function(res){ 
			JQ('#CatGroupCode'+id).html(res);
		}
	});
}

function getPerson(pcode,id){
		var param = '&action=loadperson&pcode=' + pcode +'&id=' + id;
		JQ.ajax({
			type: "POST",
			url: '?mod=<?php echo LURL::dotPage($actionPage);?>',
			data: param,
			success: function(res){ 
				JQ('#PartnerCode'+id).html(res);
			}
		});
	}


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


<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />


<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>">
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST["SCTypeId"]; ?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST["ScreenLevel"]; ?>" />

<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST["PrjDetailId"]; ?>" />
<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $_REQUEST["PrjId"]; ?>" />

 <?php
$datas = $get->getActivityDetail($_REQUEST["$PrjDetailId"],$_REQUEST["PrjActId"]);
foreach($datas as $actdatas){
	foreach($actdatas as $k=>$v){
		${$k} = $v;
	}
}
?>
<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right">
      	<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="history.back(-1);" />
      </td>
    </tr>
  </table>  
</div>


<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $PrjActId; ?>" />


<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" >
         <tr>
       <th >ปีงบประมาณ</th>
       <td><?php echo $BgtYear;?></td>
     </tr>
     <tr>
       <th>ภายใต้แผนงาน</th>
       <td id="plan">(<?php echo $PItemCode; ?>)&nbsp;<?php echo $get->getPItemCode($PItemCode);?></td>
     </tr> 
      <tr>
        <th>ชื่อโครงการ</th>
        <td id="prj">(<?php echo $PrjCode; ?>)&nbsp;<?php echo $PrjName;?></td>
      </tr>
        <tr>
        <th>ระยะเวลาการดำเนินโครงการ</th>
        <td><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td>
      </tr>
         <tr>
       <th valign="top">หน่วยงานที่รับผิดชอบ</th>
       <td><?php echo $get->getOrgName($BgtYear, $OrganizeCode);?></td>
     </tr>
    <tr>
        <th valign="top">ผู้รับผิดชอบโครงการ</th>
       <td >
       <?php 
        $TaskPerson = $get->getTaskPerson($PrjId); 
		if(!$TaskPerson){ echo '<span style="color:#999;">-ไม่ระบุ-</span>'; }
       echo "<ul>";
       foreach($TaskPerson as $rRName){
            foreach($rRName as $k=>$v){
                ${$k} = $v;
            }
            echo "<li>";
            echo $Name;
            if($ResultStatus == 'Y'){echo " (ผู้รายงาน)";}
            echo "</li>";
       }
       echo "</ul>";
        
       ?>
       </td>
     </tr>
     <tr>
     <th>ชื่อกิจกรรม</th>
      <td style="text-align:left; font-weight:bold; color:#990000;"><?php echo $PrjActName?></td> 
    </tr>
     <tr>
      <th>ระยะเวลากิจกรรม</th>
      <td><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td> 
    </tr>
    
    <?php
/*		$SumBGTotal=0;
		if($_REQUEST["SCTypeId"] == 2  ){
		 	$SumBGTotal=$get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
		}else{
			$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],0,0); 	
		}	*/	
		
		// งบโครงการ
		 $SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);		
		
		
		 $SumTotalPrjInternalX4=$get->getTotalPrjInternalX4($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$_REQUEST["PrjId"],$_REQUEST["PrjDetailId"],0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);		
		
		
		$sumScreenInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllotExternal = $get->getBGTotalExternal($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$PrjDetailId);
		$sumAllot = $sumScreenInternal + $sumAllotExternal;		
	?>
     <?php //if(in_array($_REQUEST["SCTypeId"],array(3,4))){ ?> 
     <!--<tr>   
      <th style="text-align:left">งบประมาณแผ่นดิน</th>
      <td ><div class="txtright txtbold"><?php //echo number_format($SumTotalPrjInternalX4,2); ?>&nbsp;บาท</div></td>
    </tr>      
    <?php //} ?>  
   <?php //if(in_array($_REQUEST["SCTypeId"],array(2,3,4))){ ?> 
   <tr>
      <th style="text-align:left">
	  	<?php 
				//switch ($_REQUEST["SCTypeId"]) {
					//case 2:
					//	echo "งบกลั่นกรอง";
					//break;				
					//case 3:
					//	echo "งบจัดสรร";
					//break;
					//case 4:
						//echo "งบปรับระหว่างปี";
					//break;								
				//}		
		?>
      </th>
      <td ><div class="txtred txtright txtbold"><?php //echo number_format($sumScreenInternal,2); ?>&nbsp;บาท</div></td>
    </tr>
    <?php //} ?>  
        <tr>
      <th style="text-align:left">งบประมาณโครงการ</th>
      <td ><div class="txtblue txtright txtbold"><?php //echo number_format($SumBGTotal,2); ?>&nbsp;บาท</div></td>
    </tr> -->
    </table>


	<div class="boxfilter2"><div class="icon-topic">รายชือภาคีเครือข่ายที่เกี่ยวข้อง</div></div>
  	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
    <tr>
      	<th style="width:30%; text-align:center">หมวดหมู่หลัก </th>
        <th style="width:30%; text-align:center">หมวดหมู่ย่อย</th>
        <th style="width:30%; text-align:center">ภาคีเครือข่าย</th>
        <th style="width:10%; text-align:center">ลบทิ้ง</th>
    </tr>
	</table>
    
<?php 
$partySelect = $get->getPartySelect($PrjActId);
//ltxt::print_r($partySelect);
 if($partySelect){
     $count = 1;
        foreach($partySelect as $r){
            foreach( $r as $k=>$v){ ${$k} = $v;}
	 
?>    
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl<?php echo $count; ?>">
    <tr>
    <td style="width:30%; text-align:center">
                    <?php
					$Network = $get->getNetworkParent();
					?>
                  <select style="width:250px;" name="CatGroupId[]" id="CatGroupId<?php echo $count; ?>" onchange="getSubGroup(this.value,'<?php echo $count; ?>');">
                  		<option value="-1">เลือก</option>
                    	<?php
						foreach($Network as $rg){
						?>
                    	<option value="<?php echo $rg->CatGroupId;?>" <?php if($CatGroupId == $rg->CatGroupId){ echo 'selected="selected"'; } ?> ><?php echo $rg->CatGroupName;?></option>
                        <?php
						}
						?>
                    </select>    
    
    </td>
    <td style="width:30%; text-align:center">
    				<?php $List = $get->getSubNetwork($CatGroupId);?>
                    <select style="width:250px;" name="CatGroupCode[]" id="CatGroupCode<?php echo $count; ?>"  onchange="getPerson(this.value,'<?php echo $count; ?>');">
                    	<option value="-1">เลือก</option>
                        <?php 
						if($List){
							foreach($List as $rs){
                      ?>  
                        <option value="<?php echo $rs->CatGroupCode;?>" <?php if($CatGroupCode == $rs->CatGroupCode){ echo 'selected="selected"'; } ?> ><?php echo $rs->CatGroupName;?></option>
								<?php
                                $SubList = $get->getSubNetwork($rs->CatGroupId);
                                if($SubList){
                                    foreach($SubList as $rs2){
                                ?>
                                <option value="<?php echo $rs2->CatGroupCode;?>" <?php if($CatGroupCode == $rs2->CatGroupCode){ echo 'selected="selected"'; } ?> ><?php echo "|--".$rs2->CatGroupName;?></option>
					   					<?php
										$SubList2 = $get->getSubNetwork($rs2->CatGroupId);
										if($SubList2){
											foreach($SubList2 as $rs3){
										?>
                                		<option value="<?php echo $rs3->CatGroupCode;?>" <?php if($CatGroupCode == $rs3->CatGroupCode){ echo 'selected="selected"'; } ?> ><?php echo "&nbsp;&nbsp;&nbsp;|--".$rs3->CatGroupName;?></option>
					   							<?php
												$SubList3 = $get->getSubNetwork($rs3->CatGroupId);
												if($SubList3){
													foreach($SubList3 as $rs4){
												?>
                                				<option value="<?php echo $rs4->CatGroupCode;?>" <?php if($CatGroupCode == $rs4->CatGroupCode){ echo 'selected="selected"'; } ?> ><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--".$rs4->CatGroupName;?></option>
					   <?php
														}
													}// end SubList3			   
					   
											}
										}// end SubList2					   
					   
									}
								}// end SubList		
											   
							}
						}// end List
					   ?> 

                    </select>
    </td>
    <td style="width:30%; text-align:center">
   					<?php $personList = $get->getPartyPerson($CatGroupCode); ?>
                    <select style="width:250px;" name="PartnerCode[]" id="PartnerCode<?php echo $count; ?>" >
                    	<option value="-1">เลือก</option>
                    	<?php
						foreach($personList as $rp){
							if($rp->PtnFullName){ $PartnerName = $rp->PtnFullName; }else{ $PartnerName = $rp->PositionName.$rp->Under;  }
						?>
                    	<option value="<?php echo $rp->PartnerCode;?>" <?php if($PartnerCode == $rp->PartnerCode){ echo 'selected="selected"'; } ?> ><?php echo $PartnerName;?></option>
                        <?php
						}
						?> 
                   </select>   
    </td>
    <td style="width:10%; text-align:center"><a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php echo $count; ?>').remove(); } " class="ico delete" >ลบทิ้ง</a></td><!--CountItem--;-->
    </tr>
 </table>  
				
<?php				
			$count++;
		}
	}
?> 
   
<?php if(!empty($partySelect)){ $CItem = $count; }else{ $CItem = 1; } ?>

<div id="ListItems"></div>

<script>
var CountItem = <?php echo $CItem; ?>;

<?php if(empty($partySelect)){  ?>

JQ(document).ready(function(){
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('project_partrow');?>&format=raw&num=' + CountItem,
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
				   url: '?mod=<?php echo LURL::dotPage('project_partrow');?>&format=raw&num=' + CountItem,
				   success: function(data){
					   CountItem = CountItem + 1;
					  JQ('#ListItems').append(data);
				   }
			 });	
}
</script>    
    
    <div align="right" style="padding-top:5px">
    <a href="javascript:void(0);" onclick="AddItem();" class="ico add">เพิ่มรายการ..</a>
    </div>
    


<div style="text-align:center; margin-top:10px; ">
<input type="button" class="btnRed" name="save" id="save" value="บันทึก" onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="history.back(-1);" /> 
</div>

</form>
</div>
<div id="detailView" style=" display:none"></div>

