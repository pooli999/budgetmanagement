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


/*echo "BgtYear=".$_REQUEST["BgtYear"];
echo "OrganizeCode=".$_REQUEST["OrganizeCode"];
echo "SCTypeId=".$_REQUEST["SCTypeId"];
echo "ScreenLevel=".$_REQUEST["ScreenLevel"];*/


// ดึงชื่อขั้นตอน
$CurSCType=$get->getSCTypeCurOrg($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"]); 

?>
<script type="text/javascript">
function loadSCT(BgtYear){
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($listRequestPage);?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"];?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}

function getfilterorg(){
	var BgtYear = $('BgtYear').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($listRequestPage);?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"];?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}
</script>

<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>


<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
    <tr>
      <td style="width:16%"><b>ปีงบประมาณ : <?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?></b></th>
      <td style="width:33%"><b>หน่วยงาน : <span id="org-list"><?php echo $get->getOrganizeCode($_REQUEST["OrganizeCode"],ltxt::getVar('OrganizeCode'));?></span></b></td>
      <td style="width:51%"><b>ขั้นตอนปัจจุบัน : </b>
	  <?php 
			echo ($_REQUEST["OrganizeCode"])?$CurSCType[0]->SCTypeName:"........................";
			echo ($CurSCType[0]->ScreenLevel)?" --> ".$get->getScreenName($CurSCType[0]->ScreenLevel):"";
	  ?>
      </td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></td>
      
    </tr>
  </table>
  
  <table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
  <tr>
    <th style="width:5%;">ลำดับ</th>
    <th style="width:15%;">รหัสโครงการ</th>
    <th style="width:40%;">ชื่อโครงการ</th>
    <th style="width:20%;">งบประมาณ (บาท)</th>
    <th style="width:20%;" nowrap="nowrap">สถานะโครงการ</th>
  </tr>
  <?php
  	$projectList = $get->getProjectScreenType($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode'], $_REQUEST['SCTypeId'], $_REQUEST['ScreenLevel']);
  	//ltxt::print_r($projectList);
	if($projectList){
		$i=0;
		foreach($projectList as $pL){
		foreach($pL as $k=>$v){
			${$k} = $v;
		}
		$i++;
		
		$SumBGTotal=0;
		$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],$PItemCode,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0)
		//$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],0,$PrjId,0,0,$SCTypeId,0,0); 

  ?>
        <tr>
          <td align="center" valign="top"><?php echo $i; ?></td>
          <td><?php echo $PrjCode?></td>
          <td><a href="?mod=<?php echo LURL::dotPage($viewProjectPage); ?>&PrjId=<?php echo $PrjId; ?>&BgtYear=<?php echo $_REQUEST['BgtYear'] ?>&OrganizeCode=<?php echo $_REQUEST["OrganizeCode"]; ?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"]; ?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"]; ?>&PrjDetailId=<?php echo $PrjDetailId; ?>">
		  <?php echo $PrjName; ?>
          </a>
          </td>
          <td align="right"><?php echo number_format($SumBGTotal,2); ?></td>
          <td nowrap="nowrap">
        <div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div>  </td> 
  		</tr>
  <?php  } }else{ ?>
  		<tr><td colspan="4"  style="color:#900; text-align:center" height="50">- -ไม่มีข้อมูล - -</td></tr>
  
  <?php  }   ?>
  </table>
  <div style="text-align:center; padding-top:10px">
  <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></div>
  











