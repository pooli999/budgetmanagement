<?php 
include("config.php");
//include("project_action.php");
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


if($_REQUEST['PrjId']){
	$dataPrj=$get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode'], $_REQUEST['SCTypeId'], $_REQUEST['ScreenLevel'],$_REQUEST['PrjId'],$_REQUEST['PrjDetailId']);
	foreach( $dataPrj as $row ) {
		foreach( $row as $k=>$v){ 
			${$k} = $v;
		}
	}
}


$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

//นับระดับการกลั่นกรองงบ
$maxScreenLevel = $get->getMaxLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
//ltxt::print_r($maxScreenLevel);

?>
<script language="javascript" type="text/javascript">

/* <![CDATA[ */

function showHide(i){
	if(JQ('#body-cate'+i).is(':hidden')===true){
		JQ('#body-cate'+i).show('slow');
		JQ('#a-cate'+i).addClass('icon-decre');
		JQ('#a-cate'+i).removeClass('icon-incre');
		JQ('#a-cate'+i).html('ย่อ');
	}else{
		JQ('#body-cate'+i).hide('slow');
		JQ('#a-cate'+i).removeClass('icon-decre');
		JQ('#a-cate'+i).addClass('icon-incre');
		JQ('#a-cate'+i).html('ขยาย');
	}
}

function showHideMonth(i){
	if(JQ('#body-catemonth'+i).is(':hidden')===true){
		JQ('#body-catemonth'+i).show('slow');
		JQ('#a-catemonth'+i).addClass('icon-decre');
		JQ('#a-catemonth'+i).removeClass('icon-incre');
		JQ('#a-catemonth'+i).html('ย่อ');
	}else{
		JQ('#body-catemonth'+i).hide('slow');
		JQ('#a-catemonth'+i).removeClass('icon-decre');
		JQ('#a-catemonth'+i).addClass('icon-incre');
		JQ('#a-catemonth'+i).html('ขยาย');
	}
}

function extogglemonth(i){
	if(JQ('#exmonth'+i).is(':hidden')===true){
		JQ('#exmonth'+i).show('fade');
		JQ('#a-exmonth'+i).addClass('icon-decre');
		JQ('#a-exmonth'+i).removeClass('icon-incre');
		JQ('#a-exmonth'+i).html('ย่อ');
	}else{
		JQ('#exmonth'+i).hide('fade');
		JQ('#a-exmonth'+i).removeClass('icon-decre');
		JQ('#a-exmonth'+i).addClass('icon-incre');
		JQ('#a-exmonth'+i).html('ขยาย');
	}
	
}


function extoggle(i){
	if(JQ('#ex'+i).is(':hidden')===true){
		JQ('#ex'+i).show('fade');
		JQ('#a-ex'+i).addClass('icon-decre');
		JQ('#a-ex'+i).removeClass('icon-incre');
		JQ('#a-ex'+i).html('ย่อ');
	}else{
		JQ('#ex'+i).hide('fade');
		JQ('#a-ex'+i).removeClass('icon-decre');
		JQ('#a-ex'+i).addClass('icon-incre');
		JQ('#a-ex'+i).html('ขยาย');
	}
	
}




function ValidateForm(f){
	
		if(!JQ('#Result1').is(':checked') && !JQ('#Result2').is(':checked')){
			jAlert('กรุณาระบุผลการตรวจสอบ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#Result').focus();
			});
			return false;
		}

		return true;
}


function Save(f){
	if(ValidateForm(f)){	
		 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		 var redirec_url = '?mod=<?php echo LURL::dotPage($ListEdit);?>';
		 toSubmit(f,'saveapprove',action_url,redirec_url);
	}
}

</script>

 <table width="100%" cellpadding="0" cellspacing="0" class="page-title">
 	<tr>
    	<td class="div-title-check">&nbsp;</td>
        <td>
       <div class="font1">ตรวจสอบแผนปฏิบัติงานประจำปี</div>
        </td>
    </tr>
 </table>


<div class="sysinfo">
  <div class="sysname"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>
</div>


<?php $curProcess = $get->getCurProcess($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"]);//ดึงข้อมูลขั้นตอนปัจจุบันของหน่วยงาน?>
<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right">
		<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="history.back(-1);" />     
      </td>
    </tr>
  </table>  
</div>

<?php include("modules/backoffice/budget/project_check/view.php"); ?>



<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />

<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $PrjId; ?>" />
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId']; ?>" />
<input type="hidden" name="ChkId" id="ChkId" value="<?php echo $ChkId; ?>" />
<input type="hidden" name="ChkNo" id="ChkNo" value="<?php echo $ChkNo; ?>" />
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>">
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST["SCTypeId"]; ?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST["ScreenLevel"]; ?>" />


<div class="boxfilter2"><div class="icon-topic">บันทึกผลการตรวจสอบแผนปฎิบัติงานประจำปี (เจ้าหน้าที่ฝ่ายแผน สย.)</div></div>
<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
 <tr>
   <th>ผลการตรวจสอบ</th>
   <td>
 <input name="Result" type="radio" value="Y" class="Result" id="Result1" /> ผ่านการตรวจสอบ
<input name="Result" type="radio" value="N" class="Result" id="Result2" /> 
<span class="txt-red">ไม่ผ่านการตรวจสอบ(ตีกลับข้อมูล)</span>
     </td>
 </tr>
 <tr>
   <th valign="top">หมายเหตุ</th>
   <td><textarea name="Comment" id="Comment" style="width:300px; height:100px;"></textarea></td>
 </tr>

 <tr>
   <th valign="top">&nbsp;</th>
   <td>
    <input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
	<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="history.back(-1);" />  
   </td>
 </tr> 
</table>


</form>
</div>
<div id="detailView" style=" display:none"></div>
