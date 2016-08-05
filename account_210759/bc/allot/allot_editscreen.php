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



// ดึงรายละเอียดโครงการ
if($_REQUEST['PrjId']){
	$dataPrj=$get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode'], $SCTypeIdbg, $ScreenLevelbg,$_REQUEST['PrjId']);
	if(empty($dataPrj)){$dataPrj=$get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode'], $_REQUEST['SCTypeId'], $_REQUEST['ScreenLevel'],$_REQUEST['PrjId']);}
	//ltxt::print_r($dataPrj);
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


/*
function CalCostSum(CostItemCode){

var Obj2 = JQ('#BGAllot'+CostItemCode);
var Value2 = Obj2.val();
//alert(Value2);

				var sum =0;
				
				 JQ('input[rel=RelBGAllot]').each(function(){
						 num = parseFloat(JQ(this).val());
						 if( !isNaN(num)) sum = sum + num; 
				 });
				 
				 JQ('#SumBGAllot').val(sum);
					
}

*/
function SaveScreen(form){	

	if(JQ('#BGInternal').val() >= parseFloat(1)){
   			 form.submit();
	}else{
	
		alert('กรุณาตรวจสอบงบกลั่นกรองต้องมากกว่าศูนย์');	
		JQ('#BGInternal').focus();
	}

}

</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับกลั่นกรอง/จัดสรรงบประมาณ ในส่วนของขั้นตอน<?php echo $MenuName;?> </div>
</div>

<?php $curProcess = $get->getCurProcess($_REQUEST["BgtYear"],$OrganizeCode); //ดึงข้อมูลขั้นตอนปัจจุบันของหน่วยงาน?>
<div class="topic-step"><?php echo $get->getNameByScreen($_REQUEST["BgtYear"],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"]);?></div>

<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr >
      <td>&nbsp;</td>
      <td align="right">
		<input type="button" class="btn" name="Cancel" id="Cancel" value="ย้อนกลับ" onClick="history.back(-1);" />     
      </td>
    </tr>
  </table>  
</div>

<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=savescreen" onSubmit="SaveScreen(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>" />
<input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode'];?>" />
<input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST['SCTypeId'];?>" />
<input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST['ScreenLevel'];?>" />
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId']; ?>" />
<input type="hidden" name="AllotId" id="AllotId" value="<?php echo $allot[0]->AllotId; ?>" />

<!--
<input type="hidden" name="NextSCTypeId" id="NextSCTypeId" value="<?php //echo $_REQUEST['NextSCTypeId']?>" />
<input type="hidden" name="NextScreenLevel" id="NextScreenLevel" value="<?php //echo $_REQUEST['NextScreenLevel']?>" />
-->


<?php include("modules/backoffice/budget/allot/allot_view.php"); ?>



<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view" style="margin-bottom:0px;">
<tr>
<td colspan="2" valign="top">
 
   <div class="boxfilter2"><div class="icon-topic">
	  	<?php 
				switch ($_REQUEST["SCTypeId"]) {
					case 1:
						echo "รายจ่ายประจำขั้นต่ำ";
					break;				
					case 2:
						echo "กลั่นกรองงบประมาณ";
					break;
					case 3:
						echo "จัดสรร/ปรับปรุงงบประมาณ";
					break;								
				}		
		?>
 </div></div>
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list">
    <tr>
        <th style="text-align: center; width:5%;">ลำดับ</th>
        <th style="text-align: center; width:45%;">แหล่งงบประมาณ</th>
        <th align="right" style="text-align: right; width:25%;">งบขอจัดตั้ง (บาท)</th>
        <th align="right" style="text-align: right; width:25%;">
	  	<?php 
				switch ($_REQUEST["SCTypeId"]) {
					case 2:
						echo "งบกลั่นกรอง";
					break;				
					case 3:
						echo "งบจัดสรร";
					break;
					case 4:
						echo "งบปรับระหว่างปี";
					break;								
				}		
		?>        
         (บาท)
         </th>
    </tr>
    <tr>
        <td style="text-align:center">1.</td>
        <td>งบประมาณแผ่นดิน</td>
        <td style="text-align:right"><?php echo ($sumBGTopicIn > 0)?number_format($sumBGTopicIn,2):"-"; ?></td>
        <td style="text-align:right">
		<?php			
			$TotalAllotBGInternal = $get->getBGTotalInternal($_REQUEST['BgtYear'],$_REQUEST['OrganizeCode'],$_REQUEST["ScreenLevel"],$_REQUEST["SCTypeId"],$_REQUEST['PrjDetailId'],$allot[0]->AllotId);   
	    ?>    
    	<input name="BGInternal"  id="BGInternal" type="text"  value="<?php echo number_format($TotalAllotBGInternal,2,'.',''); ?>" rel="RelBGAllot"  onKeyPress="return validChars(event,2)"  class="number-sum"  style="font-weight:bold; width:150px"  onkeyup="CalCostSum('1')"/>        
        </td>
    </tr>        
    
</table>
  
</td>
</tr>


 <tr>
 <th>&nbsp;</th>
 <td >
	<input type="submit" class="btnRed" name="save" id="save" value="บันทึก"  />
<!--<input type="button" name="button" id="button" value="ยกเลิก" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listProjectPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>&SCTypeId=<?php echo $_REQUEST['SCTypeId'];?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel'];?>');" />
--> 
	<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="history.back(-1);" />  
</td>
 </tr>
 
</table>


</form>



