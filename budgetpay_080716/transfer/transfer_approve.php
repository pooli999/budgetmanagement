<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),	
	array(
		'text' => "รายละเอียด".$MenuName,
	),
));

?>

<script language="javascript" type="text/javascript">
function ValidateForm(f){
		return true;
}
function Save(f){
	 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
	 var redirec_url = '?mod=front.eform.general.general_list';
	 toSubmit(f,'approve',action_url,redirec_url);
}

function Confirm(f){
	if(ValidateForm(f)){
		var firm_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		toConfirm(f,'appconfirm',firm_url);
	}
	
}
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียด<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>

<?php include("modules/backoffice/finance/form/transfer/view.php"); ?>
<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="DocCode" id="DocCode" value="<?php echo $DocCode; ?>" />
<input type="hidden" name="Topic" id="Topic" value="<?php echo $Topic; ?>" />

<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $BgtYearTo; ?>" />
<input type="hidden" name="TferDate" id="TferDate" value="<?php echo $DocDate; ?>" />
<input type="hidden" name="PrjActCodeFrom" id="PrjActCodeFrom" value="<?php echo $PrjActCode; ?>" />
<input type="hidden" name="PrjActCodeTo" id="PrjActCodeTo" value="<?php echo $PrjActCodeTo; ?>" />
<input type="hidden" name="SourceType" id="SourceType" value="<?php echo $SourceType; ?>" />
<input type="hidden" name="SourceExId" id="SourceExId" value="<?php echo $SourceExId; ?>" />
<input type="hidden" name="Budget" id="Budget" value="<?php echo $Budget; ?>" />
<input type="hidden" name="TferBy" id="TferBy" value="<?php echo $PersonalCode; ?>" />
<input type="hidden" name="CancelStatus" id="CancelStatus" value="N" />
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view"> 
    <tr>
    <td colspan="2" ><div class="title-bar">บันทึกโอนเงินงบประมาณ  :</div></td>
  </tr> 
   <tr>
    <th>ผลการโอนเงิน  :</th>
    <td>
      <input name="DocStatusId" type="radio" value="12" checked="checked" /> โอนเงินตามที่ได้รับอนุมัติ
      <input name="DocStatusId" type="radio" value="11" /> <span style="color:#990000">ตีกลับเอกสาร</span>
    </td>
  </tr>   
  <tr>
    <th style="vertical-align:top;">หมายเหตุ  :</th>
    <td><textarea name="Comment"  style="width:99%; height:100px;"></textarea></td>
  </tr> 
  <tr>
 <th colspan="2">ไฟล์เอกสารแนบ  :</th>
</tr>
<tr>
 <td colspan="2">
 <?php
		FilesManager::LinkFiles(
		array(
			"MaxUploadSize"=> 1,
			"imgWidth"		=>120,
			'imgHeight'		=> 100,
			'UploadType'	=> "multi",
			'FileTypeAllow'	=> "*",
			'ActiveObj'	=> "MultiDocId",
			'ActiveId'	=> "",
			'Category'	=> "ระบบนโยบายแผนงาน",
			'SubCategory'	=> "แผนปฏิบัติงานประจำปี",		
			'System'		=> "backoffice",
			'Module'		=> "project"
		));
		
?>
  
        
 </td>
 </tr> 
 <tr>
    <th>ผู้บันทึกโอนเงิน  :</th>
    <td><?php echo $_SESSION["Session_FullName"]; ?> (<?php echo dateformat(date('Y-m-d'));?>)
    </td>
  </tr>   
    </table>

<div style="text-align:center; padding:10px">
    <input type="button" class="btnActive" name="save" id="save" value="ตรวจทาน" onclick="Confirm('adminForm');"  />
      <input type="button" name="button3" id="button3" value=" ยกเลิก " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>')" />
</div>

</form>
</div>
<div id="detailView" style=" display:none"></div>
