<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
	),
));

$OrgCode = $_SESSION['Session_OrgCode'];

//echo "Session_PersonalCode=".$_SESSION['Session_PersonalCode'] ;
//echo "OrgCode=".$OrgCode;

function icoAdd($r,$PrjId){
	$label = 'บันทึกผล';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&PrjId=".$PrjId."&PrjActId=".$r->PrjActId."&PrjActCode=".$r->PrjActCode."&PrjDetailId=".$r->PrjDetailId."&OrgCode=".$_SESSION['Session_OrgCode']."&BgtYear=".$_REQUEST['BgtYear']."  '",
		'ico edit',
		$label,
		$label
	));
}

function icoResult($PrjId){
	$label = 'บันทึกผล';
	global $resultPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($resultPage)."&PrjId=".$PrjId."'",
		'ico edit',
		$label,
		$label
	));
}

function icoResultMonth($PrjId){
	$label = 'บันทึกผล';
	global $resultMonthPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($resultMonthPage)."&PrjId=".$PrjId."'",
		'ico edit',
		$label,
		$label
	));
}


function icoAddMonth($r,$PrjId){
	$label = 'บันทึกผล';
	global $addMonthPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addMonthPage)."&PrjActId=".$r->PrjActId."  '",
		'ico edit',
		$label,
		$label
	));
}

function icoView($r){
	$label = $r->PrjActName;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage("fresult_view")."&PrjActId=".$r->PrjActId."  '",
		'',
		$label,
		$label
	));
}

function icoViewMonth($r,$PrjId,$PrjActName){
	$label = $PrjActName;
	global $viewMonthActPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewMonthActPage)."&PrjId=".$PrjId."&PrjActId=".$r->PrjActId."&PrjActCode=".$r->PrjActCode."&PrjDetailId=".$r->PrjDetailId."&OrgCode=".$_SESSION['Session_OrgCode']."&BgtYear=".$_REQUEST['BgtYear']."  '",
		'',
		$label,
		$label
	));
}

/*
function icoViewPrj($r){
	$label = $r->PrjName;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&PrjId=".$r->PrjId."&PrjDetailId=".$r->PrjDetailId."&OrgCode=".$_SESSION['Session_OrgCode']."&BgtYear=".$_REQUEST['BgtYear']."  '",
		'',
		$label,
		$label
	));
}
*/

?>

<script type="text/javascript">

function loadSCT(){
	var BgtYear = $('BgtYear').value;
	window.location.href='?mod=<?php echo lurl::dotPage($mainPage);?>&BgtYear='+BgtYear;
}

function swap(id,el,img){
		var Obj = document.getElementById(id);
		var Img = document.getElementById(img);
		if(Obj.style.display=='none'){
			Obj.style.display='';
			el.src='images/bullet/minimize.gif';
			if(Img) Img.src='images/bullet/minimize.gif';
		}else{
			Obj.style.display='none';
			el.src='images/bullet/maximize.gif';
			if(Img) Img.src='images/bullet/maximize.gif';
		}
}	

</script>

 <table width="100%" cellpadding="0" cellspacing="0" class="page-title-user">
 	<tr>
    	<td class="div-title-result">&nbsp;</td>
        <td>
       <div class="font1">ติดตามผลการดำเนินงานโครงการ</div>
        </td>
    </tr>
 </table>


<div class="sysinfo">
  <div class="sysname">แสดงรายการงาน/กิจกรรม/โครงการ</div>
</div>

<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr class="td-descr">
      <td align="right" style="width:16%"><b>ปีงบประมาณ : <?php echo $get->getYearProject(ltxt::getVar('BgtYear'),'BgtYear');?></b></th>      
    </tr>
  </table>
</div>





<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list" >
  
  <tr>
    <th style="width:18px;">&nbsp;</th>
    <th style="width:40px;">ลำดับ</th>
    <th>โครงการ/กิจกรรม</th>
    <th style="width:120px;">เจ้าของ/ผู้ปฏิบัติงาน</th>
    <th style="width:90px;">ความถี่รายงาน</th>
    <th style="width:90px;">%ค่าน้ำหนัก</th>
    <th style="width:90px;">%ดำเนินงาน</th>
    <th style="width:90px;">%ความก้าวหน้า</th>
  </tr>
  
  
  
  
<?php
$p=1;
$plan = array();
$get->getDataList($plan,$RowPerPage);
foreach($plan as $dataplan){
	foreach($dataplan as $m=>$d){
		${$m} = $d;
	}
	 $detail = $get->getProjectSCType($_REQUEST['BgtYear'],$_SESSION['Session_PersonalCode'],$PItemCode);//ltxt::print_r($detail);
?>
  <tr style="vertical-align:top; background-color:#c9e39c; font-weight:bold;">
    
	<td>&nbsp;</td>
  	<td align="center"><?php echo $p; ?></td>
    <td><a href="?mod=<?php echo LURL::dotPage("fresult_planmonth"); ?>&PItemCode=<?php echo $PItemCode; ?>"><?php echo $PItemName; ?></a></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  
  
  
  
  
  
  

  
  <?php
  $i=1;
  //$detail = $get->getProjectSCType($_REQUEST['BgtYear'],$OrgCode);
 
 
 if($detail){
  foreach($detail as $detailprj){
	foreach($detailprj as $k=>$v){
		${$k} = $v;
	}
	$detailact = $get->getActivity($PrjDetailId,0,0,0,$_REQUEST['BgtYear']);
	
	$OrganizeCodePrj = $OrganizeCode;
	$TotalBGPrj = $get->getTotalPrj($_REQUEST['BgtYear'],$OrgCode,0,$PrjId,$PrjDetailId,0,$SCTypeId,$ScreenLevel,0); 
	$TotalBGPay = 0;
	$RemainBG = $TotalBGPrj - $TotalBGPay;

  ?>
  <tr style="vertical-align:top; background-color:#EEE;">
    
<?php if($detailact){ ?>
    <td style="text-align:center;" onClick="swap('td-<?php echo $p.$i;?>',this,'np<?php echo $p.$i; ?>')">
    <img id="np<?php echo $p.$i;?>" src="images/bullet/minimize.gif" align="absmiddle" style="border:none; background-color:#EEE;" width="16" highg="16"   />
    </td>
<?php }else{ ?>
	<td>&nbsp;</td>
<?php } ?>

    
    <td align="center"><?php echo $p.".".$i; ?></td>
    <td><a href="?mod=<?php echo LURL::dotPage($resultMonthPage); ?>&PrjDetailId=<?php echo $PrjDetailId; ?>"><?php echo $PrjName; //echo icoViewPrj($detailprj);style="color:#1E40A9" ?></a></td>
    <td style="text-align:center"><?php echo $get->getOrgShortName($_REQUEST['BgtYear'], $OrganizeCodePrj);?></td>
    <td align="center">
      <?php if($PrjMethods == "monthly"){ echo 'รายเดือน'; } ?>
      <?php if($PrjMethods == "quarterly"){ echo 'รายไตรมาส'; } ?>
    </td>
    <td align="center"><?php echo ($PrjMass == '0.0')?"-":$PrjMass; ?></td>
    <td align="center">-</td>
    <td style="text-align:center;">
      <?php 
		$personResult = $get->getPersonResult($_SESSION['Session_PersonalCode'],$PrjId);
		//if($personResult > 0){
			//if($PrjMethods == "quarterly"){echo icoResult($PrjId);}else{echo icoResultMonth($PrjId); } 
		//}
	?>
    </td>
  </tr>
  
  
  
  <tbody id="td-<?php echo $p.$i;?>">
  
  			<?php
				$j=1;
              	//$detailact = $get->getActivity($PrjDetailId,$_REQUEST['BgtYear'],$OrganizeCode); 
				//$detailact = $get->getActivity($PrjDetailId); 
				
				//ltxt::print_r($detailact);
				foreach($detailact as $prjactdetail){
					foreach($prjactdetail as $k=>$v){
						${$k} = $v;
					}
				
				$OrganizeCodeAct = $OrganizeCode;
				$TotalBGAct = $get->getTotalPrj($_REQUEST['BgtYear'],$OrgCode,0,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,0); 
				$TotalBGPayAct = 0;
				$RemainBGAct = $TotalBGAct - $TotalBGPayAct;
				
				$maxMonth = $get->getMaxMonth($PrjActCode);
				$Progress = $get->getSumActProgress($PrjActCode,$maxMonth);
				$ProgressAmass = $get->getSumActProgressAmass($PrjActCode,$maxMonth);
				$curMonth = $get->getMonthShortNameTH($maxMonth);
					
			?>	
  
  <tr style="vertical-align:top;">
    <td style="text-align:center;">&nbsp;</td>
    <td style="text-align:center;">&nbsp;</td>
    <td><?php echo $p; ?>.<?php echo $i; ?>.<?php echo $j; ?> <?php echo icoView($prjactdetail); ?></td>
    <td style="text-align:center;"><?php echo $get->getOrgShortName($_REQUEST['BgtYear'], $OrganizeCodeAct);?></td>
    <td style="text-align:center;"><?php echo ($curMonth)?$curMonth:"-"; ?></td>
    <td style="text-align:center;"><?php echo ($PercentMass == '0.0')?"-":$PercentMass; ?></td>
    <td style="text-align:center;"><?php echo ($Progress == '0.0')?"-":$Progress; ?></td>
    <td style="text-align:center;"><?php echo ($ProgressAmass == '0.0')?"-":$ProgressAmass; ?></td>
    </tr>
 
  <?php 
					$j++;
			  }
			  
?>

</tbody> 

<?php
			  
  		$i++;
  }
 ?>
 

  
 <?php 
 	}else{
  ?>
  <tr><td colspan="8"  style="text-align:center; height:50px; color:#900">- - ไม่มีข้อมูล - -</td></tr>
<?php 
	} 
	
	$p++;
}//end foreach แผนงาน
?>
</table>

<br />
<br />
<br />
