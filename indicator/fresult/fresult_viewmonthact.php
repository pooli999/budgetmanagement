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

		if(!$_REQUEST['BgtYear']){
			$_REQUEST['BgtYear'] = date("Y")+543;
		}
		
		$defaultpage = date("m");
		//echo "defaultpage= ".$defaultpage;
		if($_REQUEST["pageid"]  == ""){
			$_REQUEST["pageid"] = $defaultpage;
			
		}
	
if($_REQUEST['PrjId']){
	$dataPrj=$get->getProjectDetail($_REQUEST['BgtYear'], $_REQUEST['OrgCode'], 0, 0, $_REQUEST['PrjId'],$_REQUEST['PrjDetailId'],$_REQUEST['PrjActId']);
	//ltxt::print_r($dataPrj);
	foreach( $dataPrj as $row ) {
		foreach( $row as $k=>$v){ 
			${$k} = $v;
		}
	}
}	

?>
<script  type="text/javascript">

function toPage(pageid){
window.location.href='?mod=<?php echo lurl::dotPage($viewMonthActPage);?>&PrjId=<?php echo $_REQUEST["PrjId"];?>&PrjActId=<?php echo $_REQUEST["PrjActId"];?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"];?>&PrjActCode=<?php echo $_REQUEST["PrjActCode"];?>&OrgCode=<?php echo $_REQUEST["OrgCode"];?>&BgtYear=<?php echo $_REQUEST["BgtYear"];?>&pageid='+pageid;
}
	
</script>

<script>
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
  <div class="sysname">แสดงรายละเอียด</div>
</div>

<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td align="right">
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrgCode=<?php echo $_REQUEST['OrgCode'];?>');" />
      </td>
    </tr>
  </table>  
</div>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th style="width:20%; text-align:left">ปีงบประมาณ</th>
    <td  style="width:80%; text-align:left;"><?php echo $BgtYear;?></td>
  </tr>
  <tr>
    <th style="text-align:left">ชื่อโครงการ</th>
    <td  style="text-align:left;"><?php echo $PrjName;?></td>
  </tr>
  <tr>
    <th style="text-align:left">เจ้าของโครงการ</th>
    <td  style="text-align:left;"><?php echo $get->getOrgName($BgtYear, $OrganizeCode);?></td>
  </tr>
  <tr>
    <th style="text-align:left">วิธีการรายงานผล</th>
    <td  style="text-align:left;"><?php if($PrjMethods == "quarterly"){echo "รายไตรมาส";}else{echo "รายเดือน";} ?></td>
  </tr>    
  <tr>
    <th style="text-align:left">ชื่อกิจกรรม</th>
    <td  style="text-align:left;"><?php echo $get->getPrjActName($_REQUEST["PrjActId"]); ?></td>
  </tr>
  <tr>
    <th style="text-align:left">หน่วยงานปฏิบัติงาน</th>
    <td  style="text-align:left;"><?php echo $get->getOrgName($BgtYear, $OrganizeCodeAct);?></td>
  </tr>   
  <tr>
    <th style="text-align:left">ระยะเวลากิจกรรม</th>
    <td  style="text-align:left;"><?php echo dateformat($StartDate)?><b> ถึง </b><?php echo dateformat($EndDate)?></td>
  </tr> 
  <tr>
  <td colspan="2" valign="top">
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
<thead>
  <tr>
    <td style="width:40px;">ลำดับ</td>
    <td style="text-align:center;">ชื่อตัวชี้วัดกิจกรรม</td>
        <td style="width:120px; text-align:center;">ค่าเป้าหมาย</td>
        <td style="width:100px; text-align:center;">หน่วยนับ</td>
    </tr>
    </thead>
	<?php
    $indicatorSelect = $get->getIndicatorActSelect($_REQUEST["PrjActId"]);
   // ltxt::print_r($indicatorSelect);
     if($indicatorSelect){
         $count = 1;
            foreach($indicatorSelect as $r){
                foreach( $r as $k=>$v){ ${$k} = $v;}
    ?>    
    <tr>
      <td style="text-align:center;"><?php echo $count; ?></td>
      <td><?php echo $IndicatorName;?></td>
    <td style="text-align:center;"><?php echo $Value;?></td>
    <td><?php echo $UnitName;?></td>
	</tr>    
	<?php				
                $count++;
            }
        }else{
	?>		
    <tr>
    <td colspan="4" style="height:30; text-align:center; vertical-align:middle"><span style="color:#999;">-ไม่ระบุ-</span></td>
    </tr>
	<?php		
		}
    ?>     
	</table>  
    

  </td>
  </tr>         
</table>


 
<?php $month = array(10=>"ตุลาคม",11=>"พฤศจิกายน",12=>"ธันวาคม",1=>"มกราคม",2=>"กุมภาพันธ์",3=>"มีนาคม",4=>"เมษายน",5=>"พฤษภาคม",6=>"มิถุนายน",7=>"กรกฏาคม",8=>"สิงหาคม",9=>"กันยายน"); ?>

<?php 
$i=0;
foreach ($month as $key => $value) { ?>
<div class="title-result-month"><?php echo $value; ?></div>
<?php
	 $detail = $get->getResultDetail($_REQUEST['PrjDetailId'],$_REQUEST['PrjActCode'],$key);
	 if($detail){
		 foreach($detail as $drow){
			foreach($drow as $k=>$v){
				${$k} = $v;
			}
 ?>   
<div style="padding:5px; background-color:#eee8c5;"> 
<table width="100%" border="0" cellspacing="0" cellpadding="6" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th style="text-align:left; width:20%">% ความก้าวหน้า</th>
    <td style="text-align:left; "><?php echo ($Progress)?$Progress:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
  </tr>
  <tr>
    <th valign="top" style="text-align:left">ผลการดำเนินการ</th>
    <td  style="text-align:left; "><?php echo (trim($Result))?$Result:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
  </tr>
  <tr>
    <th valign="top" style="text-align:left">ปัญหา/อุปสรรค</th>
    <td  style="text-align:left; "><?php echo (trim($Problem))?$Problem:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
  </tr>
  <tr>
    <th valign="top" style="text-align:left">ปัจจัยสนับสนุน</th>
    <td  style="text-align:left; "><?php echo (trim($Factor))?$Factor:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
  </tr>
  <tr>
    <th style="text-align:left">เอกสารแนบที่เกียวข้อง</th>
    <td  style="text-align:left; ">
	<?php  
            
		$MultiDocId = $get->getLinkFiles($ResultId); 
        FilesManager::LinkFilesView(array(
                'ActiveObj' => 'MultiDocId'.$i,
                'ViewType' => 'multi',
                'ActiveId' => $MultiDocId
              //  'imgWidth' => $imgWidth,
               // 'imgHeight' => $imgHeight
            ));
        
        ?> 
    </td>
  </tr>
  <tr>
    <th valign="top" style="text-align:left">หมายเหตุ</th>
    <td  style="text-align:left;"><?php echo (trim($Comment))?$Comment:'<span style="color:#999;">-ไม่ระบุ-</span>';?></td>
  </tr>
</table> 
</div>   
    
 <?php 
			 }
		 }else{
			 echo '<div style="padding:3px; background-color:#EEE; text-align:center; color:#999;">- ยังไม่มีการกรอกข้อมูลเข้าสู่ระบบ -</div>';
		 }
		 $i++;
	}
?>

     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="button" class="btnRed" name="save" id="save" value="ปรับปรุงข้อมูล"  onclick="goPage('?mod=<?php echo lurl::dotPage($addMonthPage);?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrgCode=<?php echo $_REQUEST['OrgCode'];?>&PrjDetailId=<?php echo $_REQUEST['PrjDetailId'];?>&PrjActId=<?php echo $_REQUEST['PrjActId'];?>&PrjId=<?php echo $_REQUEST['PrjId'];?>&PrjActCode=<?php echo $PrjActCode;?>&pageid=<?php echo $_REQUEST["pageid"];?>');"  />
      
       <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>&OrgCode=<?php echo $_REQUEST['OrgCode'];?>');" />
    </div>
      














