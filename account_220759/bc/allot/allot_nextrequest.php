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
//ltxt::print_r($CurSCType);
?>
<script type="text/javascript">
function loadSCT(BgtYear){
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($nextRequestPage);?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"];?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}

function getfilterorg(){
	var BgtYear = $('BgtYear').value;
	var OrganizeCode = $('OrganizeCode').value;
	window.location.href='?mod=<?php echo lurl::dotPage($nextRequestPage);?>&SCTypeId=<?php echo $_REQUEST["SCTypeId"];?>&ScreenLevel=<?php echo $_REQUEST["ScreenLevel"];?>&BgtYear='+BgtYear+'&OrganizeCode='+OrganizeCode;
}


function Save(form){	

	if($('updateStatus').checked){
		  if (confirm("หากคุณยืนยันการปรับขึ้นตอนแล้ว จะไม่สามารถย้อนกลับมายังขั้นตอนเดิมได้อีก ต้องการดำเนินการต่อไปหรือไม่")) {
   			 form.submit();
 		 }
	}else{
	
		alert('กรุณาคลิกในช่องสี่เหลี่ยมด้านล่างเพื่อยืนยันการปรับขึ้นตอน');	
		$('updateStatus').focus();
	}

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
      <td style="width:51%"></td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></td>
      
    </tr>
  </table>
  
  <form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=Save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
  
   <table width="100%" border="0" cellspacing="0" cellpadding="0"  class="boxTab">
  	<tr>
  		<td style="padding-bottom:3px; padding-top:3px; width:100%">
        <span class="ico bullet"><strong>ขั้นตอนปัจจุบัน :</strong> 
		<?php 
			echo ($_REQUEST["OrganizeCode"])?$CurSCType[0]->SCTypeName:"........................";
			echo ($CurSCType[0]->ScreenLevel)?" --> ".$get->getScreenName($CurSCType[0]->ScreenLevel):"";
		?>
        </span>
        &nbsp;&nbsp;&nbsp;
  		<span class="ico bullet"><strong>ขั้นตอนถัดไป :</strong> 
		<?php  
				$nextStep = $get->getNextSCType($_REQUEST["SCTypeId"], $_REQUEST['ScreenLevel']);
				//ltxt::print_r($nextStep);
				echo ($nextStep[0]->SCTypeId)?$nextStep[0]->SCTypeName:"........................";
				echo ($nextStep[0]->ScreenLevel)?" --> ".$nextStep[0]->ScreenName:"";
		?>
        </span>
       <!--</td> <td style="padding-bottom:6px; padding-top:6px; width:60%"></td>-->
	</tr>  
  </table>
  
  <table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-list">
  <tr>
    <th style="width:5%;">ลำดับ</th>
    <th style="width:60%;">ชื่อโครงการ</th>
    <th style="width:20%;">งบประมาณ (บาท)</th>
    <th style="width:20%;" nowrap="nowrap">สถานะโครงการ</th>
  </tr>
  <?php
  		$projectList = $get->getProjectScreenType($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode'], $_REQUEST['SCTypeId'], $_REQUEST['ScreenLevel']);
	  	$statusPrj = $get->getCheckStatusProject($_REQUEST['BgtYear'], $_REQUEST['OrganizeCode'], $_REQUEST['SCTypeId'], $_REQUEST['ScreenLevel']);
		$countList = count($projectList);
		
	//ltxt::print_r($statusPrj);
  	//ltxt::print_r($projectList);
	if($projectList){
		$i=0;
		foreach($projectList as $pL){
		foreach($pL as $k=>$v){
			${$k} = $v;
		}
		$i++;
		
		$SumBGTotal=0;
		$SumBGTotal=$get->getTotalPrj($_REQUEST['BgtYear'],$_REQUEST["OrganizeCode"],0,$PrjId,$PrjDetailId,0,$_REQUEST['SCTypeId'],$_REQUEST['ScreenLevel'],0); 	
  ?>
        <tr>
          <td align="center" valign="top"><?php echo $i; ?></td>
          <td valign="top"><?php echo $PrjName; ?></td>
          <td valign="top" style="text-align:right"><?php echo number_format($SumBGTotal,2); ?></td>
          <td valign="top" nowrap="nowrap">
        <div  style="color:<?php echo $TextColor; ?>; background:url(<?php echo $Icon; ?>) left center no-repeat; padding-left:18px;"><?php echo $StatusName;?></div>  </td> 
  		</tr>
  <?php  }  ?>
  
  
 		<tr><td colspan="4"  >
        
  <?php if($projectList != ""  && ($statusPrj == $countList) ){ ?>

            <input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear']?>" />
            <input type="hidden" name="OrganizeCode" id="OrganizeCode" value="<?php echo $_REQUEST['OrganizeCode']?>" />
            <input type="hidden" name="SCTypeId" id="SCTypeId" value="<?php echo $_REQUEST['SCTypeId']?>" />
            <input type="hidden" name="ScreenLevel" id="ScreenLevel" value="<?php echo $_REQUEST['ScreenLevel']?>" />

            
            <input name="updateStatus"  id="updateStatus" type="checkbox" value="Y" /> คุณต้องการให้ระบบปรับขั้นตอนการจัดทำงบประมาณจาก <span style="color:#F00;">"<?php echo ($_REQUEST["OrganizeCode"])?$CurSCType[0]->SCTypeName:"........................";  echo ($get->getScreenName($_REQUEST['ScreenLevel']))?" --> ".$get->getScreenName($_REQUEST['ScreenLevel']):"";?>"</span> เป็น <span style="color:#F00;">"<?php  
                    echo ($nextStep[0]->SCTypeId)?$nextStep[0]->SCTypeName:"........................";
                    echo ($nextStep[0]->ScreenLevel)?" --> ".$nextStep[0]->ScreenName:"";?>"</span>
      
     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="submit" class="btnActive" name="save" id="save" value="บันทึก"  />
      <input type="button" name="button" id="button" value="ยกเลิก" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></div>
     
     

  <?php }else{?>
  				
                <div style="padding-top:10px; padding-bottom:10px" ><strong>หมายเหตุ :</strong> <span style="color:#F00"> ไม่สามารถปรับขั้นตอนการจัดทำงบประมาณได้ เนื่องจากยังมีโครงการที่ไม่ผ่านการตรวจสอบ</span></div>
 				<div style="text-align:center; padding-top:10px; padding-bottom:10px"><input type="button" name="button" id="button" value="ยกเลิก" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrganizeCode=<?php echo $_REQUEST['OrganizeCode'];?>');" /></div>
  
  
  <?php } ?>
       
       
       
        </td></tr>


  <?php
  }else{ ?>
  		<tr><td colspan="4"  style="color:#900; text-align:center" height="50">- -ไม่มีข้อมูล - -</td></tr>
  
  <?php  }   ?>
  </table>

</form>







