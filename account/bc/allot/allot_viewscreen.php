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
		'text' => 'รายละเอียด',
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));

			//นับระดับการกลั่นกรองงบ
			$maxScreenLevel = $get->getMaxLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
			//echo "maxScreenLevel=".$maxScreenLevel."<br>";

			if(($_REQUEST['SCTypeId'] == 2 || $_REQUEST['SCTypeId'] == 4 ) && $_REQUEST['ScreenLevel'] == 1){
				$SCTypeIdbg = $_REQUEST['SCTypeId']-1;
				$ScreenLevelbg = 0;
				//echo "SCTypeIdbg=".$SCTypeIdbg."<br>";
				//echo "ScreenLevelbg=".$ScreenLevelbg."<br>";
				
			}else if(($_REQUEST['SCTypeId'] == 2 || $_REQUEST['SCTypeId'] == 4 ) && $_REQUEST['ScreenLevel'] > 1 && $_REQUEST['ScreenLevel'] <= $maxScreenLevel){
				$SCTypeIdbg = $_REQUEST['SCTypeId'];
				$ScreenLevelbg = $_REQUEST['ScreenLevel']-1;	
				//echo "SCTypeIdbg=".$SCTypeIdbg."<br>";
				//echo "ScreenLevelbg=".$ScreenLevelbg."<br>";
						
			}else if($_REQUEST['SCTypeId'] == 3){
				$SCTypeIdbg = $_REQUEST['SCTypeId']-1;
				//นับระดับการกลั่นกรองงบ
				$maxScreenLevel = $get->getMaxLevel($_REQUEST['BgtYear'],$SCTypeIdbg);
				$ScreenLevelbg = $maxScreenLevel;	
			}	

// ดึงรายละเอียดโครงการ
if($_REQUEST['PrjId']){
	$dataPrj=$get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode'], $_REQUEST['SCTypeId'], $_REQUEST['ScreenLevel'],$_REQUEST['PrjId']);
	if(empty($dataPrj)){$dataPrj=$get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode'], $_REQUEST['SCTypeId'], $_REQUEST['ScreenLevel'],$_REQUEST['PrjId']);}//ltxt::print_r($dataPrj);
	foreach($dataPrj as $row ) {
		foreach( $row as $k=>$v){ 
			${$k} = $v;
		}
	}
}

// ดึง PrjDetailId ในระดับการกลั่นกรองปัจจุบัน
//$prjDetail = $get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST["OrganizeCode"], $_REQUEST["SCTypeId"], $_REQUEST["ScreenLevel"], $PrjId);
//ltxt::print_r($prjDetail);

$allot = $get->getAllotDetail($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],$_REQUEST["PrjDetailId"]);

$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

//นับระดับการกลั่นกรองงบ
//$maxScreenLevel = $get->getMaxLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);

?>
<script type="text/javascript">
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

function printDocument(PrjDetailId){
	window.location.href="?mod=<?php echo LURL::dotPage('allot_view_print')?>&format=raw&PrjDetailId="+PrjDetailId;
}

function saveToWord(PrjDetailId){
	window.location.href="?mod=<?php echo LURL::dotPage('allot_view_word')?>&format=raw&PrjDetailId="+PrjDetailId;
}

function saveToExcel(PrjDetailId){
	window.location.href="?mod=<?php echo LURL::dotPage('allot_view_excel')?>&format=raw&PrjDetailId="+PrjDetailId;
}




</script>

 <table width="100%" cellpadding="0" cellspacing="0" class="page-title">
 	<tr>
    	<td class="div-title-allot">&nbsp;</td>
        <td>
       <div class="font1">กลั่นกรองจัดสรรงบประมาณ</div>
        </td>
    </tr>
 </table>


<div class="sysinfo">
  <div class="sysname"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>
</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbl-button">
  <tr>
    <td>
     <a href="javascript:printDocument('<?php echo $PrjDetailId ?>');" class="icon-printer">พิมพ์</a>&nbsp;
     <a href="javascript:saveToWord('<?php echo $PrjDetailId ?>')" class="icon-word">ส่งออกเป็น Word</a>&nbsp;
    <a href="javascript:saveToExcel('<?php echo $PrjDetailId ?>');" class="icon-excel">ส่งออกเป็น Excel</a>
    </td>
  </tr>
</table>


<?php $curProcess = $get->getCurProcess($_REQUEST["BgtYear"],$OrganizeCode); //ดึงข้อมูลขั้นตอนปัจจุบันของหน่วยงาน?>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right"><input type="button" class="btn" name="Cancel" id="Cancel" value="  ย้อนกลับ  " onClick="history.back(-1);" /></td>
    </tr>
  </table>
</div>



<?php include("modules/backoffice/budget/allot/view.php"); ?>

<div style="text-align:center; padding:10px">
<?php if($StatusProject==4 && ($curProcess[0]->ScreenLevel==$ScreenLevel)){ ?>
<input type="button" class="btnRed" name="save" id="save" value="  บันทึกกลั่นกรองงบ  " onClick="window.location.href='?mod=<?php echo LURL::dotPage($editAllotPage); ?>&PrjId=<?php echo $PrjId; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>&BgtYear=<?php echo $BgtYear; ?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode']; ?>&SCTypeId=<?php echo $SCTypeId; ?>&ScreenLevel=<?php echo $ScreenLevel; ?>&start=<?php echo $_REQUEST["start"]; ?>'" />
<?php }?>
 <input type="button" class="btn" name="Cancel" id="Cancel" value="  ย้อนกลับ  " onClick="history.back(-1);" /> 
<!--<input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listProjectViewPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>&SCTypeId=<?php echo $_REQUEST['SCTypeId'];?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel'];?>');" />-->
</div>
