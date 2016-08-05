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

?>
<script>
function loadSCT(BgtYear){
	window.location.href='?mod=<?php echo lurl::dotPage("costmonth_list");?>&BgtYear='+BgtYear;
}

function loadPage(){
	var BgtYear = $('BgtYear').value;
	var PItemCode = $('PItemCode').value;
	/*var PrjCode = $('PrjCode').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage("costmonth_list");?>&BgtYear='+BgtYear+'&PItemCode='+PItemCode+'&PrjCode='+PrjCode+'&OrganizeCode='+OrganizeCode;*/
	window.location.href='?mod=<?php echo lurl::dotPage("costmonth_list");?>&search=yes&BgtYear='+BgtYear+'&PItemCode='+PItemCode;
}

function saveToWord(){
	window.location.href="?mod=<?php echo LURL::dotPage('costmonth_list_word')?>&format=raw&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&PItemCode=<?php echo $_REQUEST["PItemCode"]; ?>";
}

function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('costmonth_list_excel')?>&format=raw&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>&PItemCode=<?php echo $_REQUEST["PItemCode"]; ?>";
}

function loadPrj(PItemCode){
		JQ.ajax({
		   type: "POST",
		   url: "?mod=<?php echo LURL::dotPage('costmonth_action');?>",		   
		   data: "action=projectlist&PItemCode="+PItemCode+"&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>",
		   success: function(msg){
				JQ("#prj").html(msg);
		   }
		});
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


<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#eeebac;">
  <tr>
    <td style="padding:5px;">
    <a href="javascript:saveToWord()" class="icon-word">ส่งออกเป็น Word</a>
      <a href="javascript:saveToExcel()" class="icon-excel">ส่งออกเป็น Excel</a>
    </td>
  </tr>
</table>



<form id="adminForm" name="adminForm" method="post" enctype="multipart/form-data" >
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th >ปีงบประมาณ</th>
    <td><?php echo $get->getYearProject(ltxt::getVar('BgtYear'),'BgtYear');?></td>
  </tr>
  <tr>
    <th>ภายใต้แผนงาน</th>
    <td id="plan"><?php echo $get->getPlanItemList($_REQUEST["BgtYear"],12,$_REQUEST["PItemCode"]); ?></td>
  </tr>
<!--  <tr>
    <th>ชื่อโครงการ</th>
    <td id="prj"><?php //echo $get->getProjectList($_REQUEST["BgtYear"]); ?></td>
  </tr>
  <tr>
    <th valign="top">หน่วยงานที่รับผิดชอบ</th>
    <td><span id="org-list"><?php //echo $get->getOrganizeCode($_REQUEST["BgtYear"]);?></span></td>
  </tr>
-->    <tr>
    <th valign="top">&nbsp;</th>
    <td><input type="button" class="btn" name="Cancel" id="Cancel" value="แสดงข้อมูล" onClick="่javascript:loadPage();" /></td>
  </tr>
  </table>
</form> 


<?php if($_REQUEST["search"]=="yes"){ ?>
<?php include("modules/backoffice/budget/report/costmonth/view.php"); ?>
<?php } ?>

