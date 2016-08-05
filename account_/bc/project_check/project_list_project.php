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


$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$CurSCName=$get->getSCRName($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 
$countScreenLevel = $get->countScreenLevel($_REQUEST['BgtYear'],$_REQUEST['SCTypeId']);
$NameByScreen=$get->getNameByScreen($_REQUEST['BgtYear'],$CurSCType[0]->ScreenLevel,$CurSCType[0]->SCTypeId,$countScreenLevel); 

// ดึงรายการหน่วยงาน
$orgList = $get->getOrgList(($_REQUEST['BgtYear'])?$_REQUEST['BgtYear']:(date("Y")+543));
// นับหน่วยงาน
$countList = count($orgList);
//ltxt::print_r($orgList);

function icoView($r){
	$label = $r->PrjName;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&PrjCode=".$r->PrjCode."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&BgtYear=".$_REQUEST['BgtYear']."&OrganizeCode=".$_REQUEST['OrganizeCode']."&SCTypeId=".$_REQUEST['SCTypeId']."&ScreenLevel=".$_REQUEST['ScreenLevel']."'",
		'ico view noicon',
		$label,
		$label
	));
}


?>
<style>
.parentrow{
	background-color:#eee;
}
</style>
<script>
function showHide(i){
	if(JQ('#t-'+i).is(':hidden')===true){
		/*JQ('#tbody-'+i).show('slow');*/
		JQ('#t-'+i).show();
		JQ('#a'+i).addClass('icon-decre');
		JQ('#a'+i).removeClass('icon-incre');
		/*JQ('#a'+i).html('ย่อ');*/
	}else{
		/*JQ('#tbody-'+i).hide('slow');*/
		JQ('#t-'+i).hide();
		JQ('#a'+i).removeClass('icon-decre');
		JQ('#a'+i).addClass('icon-incre');
		/*JQ('#a'+i).html('ขยาย');*/
	}
}

function getfilterorg(){
	var BgtYear = $('BgtYear').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($ListView);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode+'&SCTypeId=<?php echo $_REQUEST['SCTypeId'];?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel'];?>';
}

function loadSCT(BgtYear){
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($ListView);?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode+'&SCTypeId=<?php echo $_REQUEST['SCTypeId'];?>&ScreenLevel=<?php echo $_REQUEST['ScreenLevel'];?>';
}

function printDocument(){
	window.location.href="?mod=<?php echo LURL::dotPage('project_list_project_print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}


function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('project_list_project_excel')?>&format=raw<?php echo $get->getQueryString(); ?>";
}
</script>
<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการโครงการตามขั้นตอนการจัดทำงบประมาณในส่วนของ<?php echo $MenuName;?> </div>
</div>

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


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbl-button">
  <tr>
    <td>
     <a href="javascript:printDocument();" class="icon-printer">พิมพ์</a>&nbsp;
    <a href="javascript:saveToExcel();" class="icon-excel">ส่งออกเป็น Excel</a>
    </td>
  </tr>
</table>



<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td >
      <b>ปีงบประมาณ : <?php echo $get->getYearProject(ltxt::getVar('BgtYear'),'BgtYear');?></b>
      <b>หน่วยงาน : <span id="org-list"><?php echo $get->getOrganizeCode($_REQUEST["OrganizeCode"],ltxt::getVar('OrganizeCode'));?></span></b>
      </td>
       <td align="right">
         <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></td>
    </tr>
  </table>
</div>


<?php 
$amount = count($orgList);
$t_width = 30+500+120+90+(80*$amount); 
?>
<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list" style="width:<?php echo $t_width; ?>px;">
  <tr>
    <th rowspan="2" style="width:30px;">ลำดับ</th>
    <th rowspan="2" style="width:500px;">โครงการ / กิจกรรม</th>
    <th rowspan="2" style="width:120px; text-align:right">งบโครงการ (บาท)</th>
    <th rowspan="2" style="width:90px;"">เจ้าของโครงการ<br />
      /ผู้ปฏิบัติงาน</th>
    <th rowspan="2" style="width:90px;"">&nbsp;</th>
    <th colspan="<?php echo $countList; ?>">จำแนกงบประมาณตามสำนัก / กอง ที่ปฎิบัติงาน</th>
  </tr>
  <tr>
  <?php 
	foreach($orgList as $rlist){
		foreach($rlist as $k=>$v){ ${$k} = $v;}
  ?>
  	<th  style="width:80px; vertical-align:top; text-align:center;" title="<?php echo $OrgName; ?>"><?php  $OrgShortName = $get->getOrgShortName($BgtYear, $OrganizeCode);  echo ($OrgShortName)? $OrgShortName:'ไม่มีชื่อย่อ' ?></th>
  <?php } ?>
  </tr>  
  <?php 
	$i=($_REQUEST["start"])?$_REQUEST["start"]:0;
  	$detail = $get->getProjectScreenType(($_REQUEST['BgtYear'])?$_REQUEST['BgtYear']:(date("Y")+543),$_REQUEST["OrganizeCode"],$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel']);
	//ltxt::print_r($detail);

	$SumBGTotal = 0;

	foreach($detail as $detailprj){
	foreach($detailprj as $k=>$v){
		${$k} = $v;
	}
		$SumBGTotal=0;
		$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0); 
		
		$SumTotal	= $SumTotal+$SumBGTotal;
		
		//$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0);
		$SumAllBGTotal = $SumAllBGTotal + $SumBGTotal; 
		
		//$SumCostAct=$get->getTotalPrjInternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"]);
		//$SumCostActEx=$get->getTotalPrjExternalX4($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0)
				
?>
  <tr style="background-color:#eee; vertical-align:top;">
    <td  style=" text-align:center;"><?php echo $i+1; ?>.</td>
    <td  style="color:#00C">
    <!--<a class="ico excel" href="?mod=budget.project.project_popup_act_excel&format=row&PrjDetailId=<?php //echo $PrjDetailId; ?>&PrjCode=<?php //echo $PrjCode; ?>"></a>-->
    <a href="javascript:void(0)" onclick="showHide('<?php echo $PrjCode; ?>');" id="a<?php echo $PrjCode; ?>" class="icon-incre">&nbsp;</a>
	(<?php echo $PrjCode; ?>)&nbsp;<?php echo icoView($detailprj);?></td>
    <td style="text-align:right;"><?php echo number_format($SumBGTotal,2); ?></td>
    <td style="text-align:center;"><?php echo $get->getOrgShortName($BgtYear,$OrganizeCodePrj); //getOrgShortName($BgtYear=0, $OrganizeCode=0) ?></td>
    <td style="text-align:center;"><?php echo $OrganizeCode; ?></td>
    <?php 
	foreach($orgList as $rlist2){
  ?>    
    <td style="text-align:right;">
	<?php 
	$SumCostPrj=$get->getTotalPrjAct($_REQUEST["BgtYear"],$rlist2->OrganizeCode,0,$PrjId,$PrjDetailId,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0);
	echo ($SumCostPrj > 0)?number_format($SumCostPrj,2):"-"; 
	$totalOrg[$rlist2->OrganizeCode] = $totalOrg[$rlist2->OrganizeCode]+$SumCostPrj;
	?>     
    </td>
  <?php } ?>
  </tr>
  <tbody id="t-<?php echo $PrjCode; ?>" style="display:none;">
  <?php
 		$d=1;
  		$detailact = $get->getActivity($PrjDetailId); //ltxt::print_r($detailact);
			foreach($detailact as $prjactdetail){
				foreach($prjactdetail as $k=>$v){
					${$k} = $v;
							}
						$SumAct=$get->getTotalPrj($_REQUEST["BgtYear"],$_REQUEST["OrganizeCode"],0,0,0,$PrjActId,0,0,0);//ltxt::print_r($SumAct);
 ?>																
    <tr style="vertical-align:top;">
      <td style="text-align:center;"><?php echo $i+1; ?>.<?php echo $d; ?> </td>
    <td>[<?php echo $PrjActCode; ?>]&nbsp;<?php echo $PrjActName; ?></td>
    <td style="text-align:right"><?php echo number_format($SumAct,2); ?></td>
    <td style="text-align:center"><?php echo $get->getOrgShortName($BgtYear,$OrganizeCode);?></td>
    <td style="text-align:center">&nbsp;</td>
    <?php 
	foreach($orgList as $rlist3){
  ?>    
    <td style="text-align:right;">
	<?php 
	$SumCostAct=$get->getTotalPrjAct($_REQUEST["BgtYear"],$rlist3->OrganizeCode,0,$PrjId,$PrjDetailId,$PrjActId,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0);
	echo ($SumCostAct > 0)?number_format($SumCostAct,2):"-"; 
	?>    
    </td>
  <?php } ?>
  </tr>
<?php
$d++;
}
?>  
</tbody>
<?php
$i++;
 }
?>  


 <?php if($i==0){  ?> 
<tr>
  <td style="text-align:center; color:#990000; height:50px">&nbsp;</td>
	<td colspan="<?php echo (3+$countList); ?>" style="text-align:center; color:#990000; height:50px">- - ไม่มีข้อมูล - -</td>
</tr>  
 <?php } ?> 
 
 <tr style="vertical-align:top;">
      <th colspan="2" style="text-align:right;">รวมทั้งสิ้น</th>
    <th style="text-align:right"><?php echo number_format($SumTotal,2); ?></th>
    <th style="text-align:center">-</th>
    <th style="text-align:center">&nbsp;</th>
    <?php 
	foreach($orgList as $rlist3){
  ?>    
    <th style="text-align:right;">
	<?php //echo number_format($get->getTotalPrjAct($_REQUEST["BgtYear"],$rlist3->OrganizeCode,0,0,0,0,$_REQUEST["SCTypeId"],$_REQUEST["ScreenLevel"],0),2); ?>
    <?php echo ($totalOrg[$rlist3->OrganizeCode] > 0)?number_format($totalOrg[$rlist3->OrganizeCode],2):"-";  ?>
    </th>
  <?php } ?>
  </tr>
 
 
</table>

<!--<div class="cms-box-navpage" style="margin-bottom:5px;"> <?php //echo NavPage(array('total'=>$detail['total']));?> </div>-->
<br />
<br />
<br />

