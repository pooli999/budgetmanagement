<?php 
include("config.php");
//include("project_action.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
	$format = ltxt::getVar('format');
	if($format == 'raw'){ $get>getImport() ;}

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


function icoDelete($n){
		$label = 'ลบทิ้ง';
		vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
			"javascript:if(confirm('ยืนยันการลบรายการ')) removeElement('h-ct',".$n.")",
			'ico delete',
			$label,
			$label
		));
}

function icoDeleteE($n,$id){
$label = 'ลบทิ้ง';
vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
"javascript:removeElementE('h-ctold',".$n.",".$id.")",
'ico delete',
$label,
$label
));
}
	
?>
<script>
function loadSCT(BgtYear){
	var BgtYear = JQ('#BgtYear').val();
	JQ('#plan').load('?mod=<?php echo lurl::dotPage("ajaxdata");?>&section=getPlanItemList&format=raw&BgtYear=' + BgtYear);
}


function loadPrj(PItemCode){
	var BgtYear = JQ('#BgtYear').val();
	var PItemCode = JQ('#PItemCode').val();
	var OrganizeCode = JQ('#OrganizeCode').val();
	JQ('#prj').load('?mod=<?php echo lurl::dotPage("ajaxdata");?>&section=getProjectList&format=raw&BgtYear=' + BgtYear+'&PItemCode='+ PItemCode+'&OrganizeCode='+ OrganizeCode);
}

function loadAct(){
	var n = JQ('#h-ct_index').val();
	JQ('#act').load('?mod=<?php echo lurl::dotPage("ajaxdata");?>&section=getRecordActivity&format=raw&n='+ n);
}


function Save(form){	
	if(validateSubmit()){
		form.submit();
	}
}

function validateSubmit(){
	if($('ttt').value==0){
		alert("กรุณาระบุปีงบประมาณ");
		$('plan').focus();
		return false;
	}
	return true ; 
}

</script>


<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage('project_action');?>&action=Save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>">
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST["SCTypeId"]; ?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST["ScreenLevel"]; ?>" />


<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
 <tr>
   <th style="width:120px;">ปีงบประมาณ</th>
   <td class="require">*</td>
   <td><span class="td-descr">
     <?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?>
   </span></td>
 </tr>
 <tr>
   <th>ภายใต้แผนงาน</th>
   <td class="require">*</td>
   <td><div id="plan"><?php echo $get->getPlanItemList(($BgtYear)?$BgtYear:(date("Y")+543),$PItemCode);?>&nbsp;</div></td>
 </tr>
 <tr>
    <th>ชื่อโครงการ</th>
    <td class="require">*</td>
    <td><div id="prj"><?php echo $get->getProjectList($PItemCode);?>&nbsp;</div>
    </td>
  </tr>
  <tr>
    <th>ระยะเวลาการดำเนินโครงการ</th>
    <td class="require">*</td>
    <td><?php 
	  	echo InputCalendar(array(
			'name' => 'StartDate',
			'value' => $StartDate,
			'size' => '10'
		));
	  ?> ถึง 
     <?php
		echo InputCalendar(array(
			'name' => 'EndDate',
			'value' => $EndDate,
			'size' => '10'
		));

		?></td>
  </tr>
   <tr>
   <th valign="top">หน่วยงานที่รับผิดชอบ</th>
   <td class="require">&nbsp;</td>
   <td><?php echo $get->getOrgName($BgtYear, $OrganizeCode);?></td>
 </tr>
   <tr>
     <th valign="top"><span class="txt-bold">ฝ่ายงานที่เกี่ยวข้อง</span></th>
     <td class="require">&nbsp;</td>
     <td><table width="100%" border="0" cellspacing="0" cellpadding="0"><!--text-decoration:underline;-->
       <tr>
         <td style="border-bottom:none; text-decoration:underline;">หน่วยงาน : </td>
         <td style="border-bottom:none;">&nbsp;</td>
         <td style="border-bottom:none; text-decoration:underline;"><br /><br />บุคลากรที่เลือก : </td>
       </tr>
       <tr>
         <td width="45%" valign="top" style="border-bottom:none; padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td style="border-bottom:none;"><div id="SrcDepartList">
<?php /*?>               <?php
		$BgtYear		= ($_REQUEST['BgtYear'])?$_REQUEST['BgtYear']:(date("Y")+543);
		$PrjOrg		= $_REQUEST['PrjOrg']?$_REQUEST['PrjOrg']:$ParentOrgId;
		$PrjOrgId		= $_REQUEST['PrjOrgId']?$_REQUEST['PrjOrgId']:$ParentOrganizeCode;echo $PrjOrgId;
		//$organize 	= $Helper->getOrganizeOperationMultiple($BgtYear,$PrjOrg,$PrjOrgId, 0, 1);	
		?>
<?php */?>
			</div></td>
           	</tr>
           	<tr>
            <td bgcolor="#D5FC78" style="border-bottom:none;"><input type="button" name="dAllLeft" id="dAllLeft" value="เลือกทั้งหมด" onClick="D1.SelectAll();" /></td>
           	</tr>
         	</table></td>
         	<td width="10%" style="border-bottom:none;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
           	<tr>
            <td style="border-bottom:none;"><input type="button" name="dRight" id="dRight" class="btn" value="นำเข้า &gt;&gt;" style="width:100%" /></td>
           	</tr>
           	<tr>
            <td style="border-bottom:none;"><input type="button" name="dLeft" id="dLeft" class="btn" value="&lt;&lt; เอาออก" style="width:100%" /></td>
           	</tr>
         	</table></td>
         	<td width="45%" valign="top" style="border-bottom:none; padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
           	<tr>
             <td style="border-bottom:none;"><div>
        <?php
		//$Helper->getDepartResponsible($_REQUEST["PrjID"], $BgtYear, $year_num=1);
		?>
             </div></td>
           	</tr>
           	<tr>
             <td style="border-bottom:none;"><input type="button" name="dAllRight" id="dAllRight" value="เลือกทั้งหมด" onClick="D2.SelectAll();" /></td>
           	</tr>
         	</table></td>
   		  </tr>
     		</table>
            </table>
<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">การติดต่อ</th>
  </tr> 
    </table>
<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th style="width:193px;">หมายเลขโทรศัพท์</th>
    <td width="25" class="require">*</td>
    <td><input name="Telephone" type="text" id="Telephone" value="<?php echo $Telephone;?>" style="width:300px;" /></td>
  </tr>
  <tr>
    <th style="width:120px;">โทรสาร</th>
    <td class="require">*</td>
    <td><input name="Fax" type="text" id="Fax" value="<?php echo $Fax;?>" style="width:300px;" /></td>
  </tr>
  <tr>
    <th style="width:120px;">อีเมล์</th>
    <td class="require">*</td>
    <td><input name="Email" type="text" id="Email" value="<?php echo $Email;?>" style="width:300px;" /></td>
  </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">วัตถุประสงค์</th>
  </tr> 
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <td colspan="3"> <?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'Purpose','id' => 'Purpose', 'value' => $Purpose,'height'=>'100'));?></td>
  </tr> 
   </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">ตัวชี้วัดความสำเร็จโครงการ</th>
  </tr> 
   </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <td colspan="3"> <?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'Indicator','id' => 'Indicator', 'value' => $Indicator,'height'=>'100'));?></td>
  </tr>
   </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">ผลงาน (Output)</th>
  </tr> 
   </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <td colspan="3"> <?php JFCKeditor::Create(array('ToolbarSets' => 'Mini','name' => 'Outputs','id' => 'Outputs', 'value' => $Outputs,'height'=>'100'));?></td>
  </tr> 
   </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
   <tr>
    <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">ปริมาณงาน / ตัวชี้วัด</th>
  </tr> 
   </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
  <tr>
  <td colspan="3">
  	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
  <th colspan="2" style="width:410px; text-align:center;">ชื่อตัวชี้วัดโครงการ</th>
    <th width="300" style="width:120px; text-align:center;">ค่าเป้าหมาย</th>
    <th width="120" style="width:120px; text-align:center;">หน่วยนับ</th>
    <th style="width:50px; text-align:center;">ลบทิ้ง</th>
  </tr>
  <tr>
    <td colspan="5" style="text-align:left;">
    
    <div id="MoreFile2Store" class="hide">
    <div>
 	<select name="IndId[]" style="width:520px">
    <option value=<?php echo $get->getIndProjectList($IndId); ?></option></select>
    <input type="text" name="Value[]"  size="5" id="Value" style="width:180px" />
    <select name="UnitId[]" style="width:190px">
    <option value=<?php echo $get->getUnit($UnitId); ?></option>
    </select>
    <a href="javascript:void(0)" onclick="if(JQ('#MoreFile2 div').length > 1) JQ(this).parent('div').remove()" class="ico delete">ลบทิ้ง</a>
    </div>
</div>
    <div id="MoreFile2">
<?php 
  $indicator = $get->getIndicator($PrjDetailId);
  foreach($indicator as $row){
  	foreach($row as $k=>$v){
		${$k} = $v;
	}
  ?>
    <div>
 	<select name="IndId[]" style="width:520px">
    <option value=<?php echo $get->getIndProjectList($IndId); ?></option></select>
    <input type="text" name="Value[]"  size="5" id="Value" value="<?php echo $Value;?>" style="text-align:right; width:180px" />
    <select name="UnitId[]" style="width:190px" >
    <option value=<?php echo $get->getUnit($UnitId); ?></option>
    </select>
    <a href="javascript:void(0)" onclick="if(JQ('#MoreFile2 div').length > 1) JQ(this).parent('div').remove()" class="ico delete">ลบทิ้ง</a>
    </div>
 <?php
  }
?>
    
    </div>

    <br />
    <div style="padding-top:3px; width:1000px; text-align:right">
    <span class="hint" style="display:inline-block; width:auto; text-align:right;"></span>
    <input name="new" type="button" value="เพิ่มรายการ" onclick="CreateElementStroe('MoreFile2','MoreFile2Store')" />
    </div> 
  </tr>
  </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
	<td width="2"></tr>
   <tr>
    <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">กลวิธี / ขั้นตอนการดำเนินงาน / กิจกรรมโครงการ</th>
  </tr> 
   </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
<thead style="font-weight:bold; color:#666;">
<tr>
<td style="text-align: center; width:130px; background-color:#eeeeee;">วันเริ่มต้นกิจกรรม</td>
<td style="text-align: center; width:130px; background-color:#eeeeee;">วันสิ้นสุดกิจกรรม</td>
<td style="text-align: center; width: 600px; background-color:#eeeeee;">รายการกิจกรรม</td>
<td style="text-align: center; width:300px; background-color:#eeeeee;">หน่วยงานปฎิบัติงาน</td>
<td style="text-align: center; width:150px;background-color:#eeeeee;">ลบทิ้ง</td>
</tr>
</thead>
</table>

<?php 
if($PrjDetailId){
$t=0;
$task = $get->getProjectDetailActRecordSet($PrjDetailId);
foreach($task as $RTask){
	foreach($RTask as $k=>$v){
		${$k} = $v;
	}
?>
<div id="div<?php echo $t; ?>">
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
<tr>
<td width="141" style="text-align: center; width:120px; vertical-align:top;"><?php
echo InputCalendar_text(array(
'name' => 'PrjActStart['.$t.']',
'id' => 'PrjActStart'.$t,
'value' => $StartDate,
'size' => '10'
)); 
?></td>
<td width="141" style="text-align: center; width:120px; vertical-align:top;">
<?php
echo InputCalendar_text(array(
'name' => 'PrjActEnd['.$t.']',
'id' => 'PrjActEnd'.$t,
'value' => $EndDate,
'size' => '10'
)); 
?></td>
<td width="600">
<input type="text" name="PrjActName[<?php echo $t; ?>]" id="PrjActName[<?php echo $t; ?>]" value="<?php echo $PrjActName; ?>" style="width:400px;" />
<input type="hidden" name="PrjActId[<?php echo $t; ?>]" id="PrjActId[<?php echo $t; ?>]" value="<?php echo $PrjActId; ?>" /></td>
<td width="230"><?php echo $get->getOrganizeCode($_REQUEST["OrganizeCode"],$OrganizeCode);?></td>
<td width="210"><?php echo icoDeleteE($t,$PrjActId);?>&nbsp;</td>
</tr>
</table>
</div>
<?php
$t++;
}
?>
</div>
<?php }?>

<div id="act">
</div>
<script>
function loadAct()
{
	var inc = parseInt(JQ('#h-ct_index').val()) + 1;
	JQ('#h-ct_index').val(inc);
	JQ.ajax({
		   type: "POST",
		   dataType: 'html',
		   url: '?mod=<?php echo LURL::dotPage('ajaxdata');?>',
		   data: 'section=getRecordActivity&n=' + JQ('#h-ct_index').val() ,
		   success: function(data){
			   //JQ('#act').html(data);
			   JQ('#act').append(data);
		   }
	 });
}

JQ(document).ready(function(){
	//loadAct();
});
</script>


<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#EEEEEE">
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td style="text-align:right;">
<input type="hidden" name="h-ct_index" id="h-ct_index" value="0"  />
<input name="new" type="button" value="เพิ่มกิจกรรม" onclick="loadAct(); //CreateElementStroe('act','act_store')" /></td>
</tr>
</table>
    </td>
  </tr> 
   <tr>
    <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">แนบไฟล์เอกสารโครงการ</th>
  </tr> 
   <tr>
    <th colspan="3">อัพโหลดไฟล์จากเครื่องของคุณ | ระบุไฟล์จากระบบ E - Document</th>
  </tr> 
  <tr>
    <th colspan="3" style="padding-top:10px; border-top:5px solid #ccc; background-color:#D5FC78;">รายการตรวจสอบโครงการ</th>
  </tr> 
   <tr>
    <th colspan="3">
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
        <tr>
          <th style="text-align: center; width:100px;">ลำดับ</th>
          <th style="text-align: center; width:250px;">วันที่ตรวจสอบ</th>
          <th style="text-align: center; width:330px;">ผลการตรวจสอบ</th>
          <th style="text-align: center; width:420px;">หมายเหตุ</th>
          <th style="text-align: center; width:153px;">ผู้ตรวจสอบ</th>
        </tr>
<?php
$i=0;
$Prjchk = $get->getProjectDetailCheckRecordSet($PrjDetailId);
foreach($Prjchk as $RPrjchk){
	foreach($RPrjchk as $k=>$v){
		${$k} = $v;
	}
?>

        <tr>
          <td><?php echo ($i+1); ?></td>
          <td><?php echo $CreateDate;?>&nbsp;</td>
          <td><?php echo $Result;?>&nbsp;</td>
          <td><?php echo $Comment;?>&nbsp;</td>
          <td><?php echo $CreateBy;?>&nbsp;</td>
        </tr>
<?php
$i++;
}
?>
<?php if($i==0){ ?>
<tr>
	<td colspan="5" style="text-align:center; vertical-align:top; color:#900 ">- - ไม่มีข้อมูล - -</td>
</tr>
<?php } ?>

      </table></th>
  </tr> 
</table>
<div style="text-align:center; margin-top:10px; margin-bottom:30px;">
<input type="submit" class="btnActive" name="save" id="save" value="บันทึก"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ListEditPage); ?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"]; ?>&PrjId=<?php echo $PrjId; ?>'" />    </td>
</div>
</form>

<div style="text-align:center; margin-top:10px; margin-bottom:30px;">
<input type="submit" class="btnActive" name="save" id="save" value="คัดลอกโครงการ"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="window.location.href='?mod=<?php echo LURL::dotPage($ListEditPage); ?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"]; ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>'" />    </td>
</div>