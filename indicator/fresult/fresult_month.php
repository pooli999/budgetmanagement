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

//ltxt::print_r($_GET);

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
function Save(form){	
	if(validateSubmit()){
		form.submit();
	}
}

function validateSubmit(){
	//% ความก้าวหน้า
	if(JQ('#Progress').val()==""){
		alert("กรุณากรอก % ความก้าวหน้า");
		JQ('Progress').focus();
		return false
	}
	
	return true;
}

function toPage(pageid){
window.location.href='?mod=<?php echo lurl::dotPage($resultMonthPage);?>&PrjId=<?php echo $_REQUEST["PrjId"];?>&PrjActId=<?php echo $_REQUEST["PrjActId"];?>&PrjDetailId=<?php echo $_REQUEST["PrjDetailId"];?>&PrjActCode=<?php echo $_REQUEST["PrjActCode"];?>&OrgCode=<?php echo $_REQUEST["OrgCode"];?>&BgtYear=<?php echo $_REQUEST["BgtYear"];?>&pageid='+pageid;
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

<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>

<div class="boxfilter2" id="boxFilter">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td align="right">
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>');" />
      </td>
    </tr>
  </table>  
</div>



<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="PrjId" id="PrjId" value="<?php echo $_REQUEST['PrjId'];?>" />
<input type="hidden" name="PrjActId" id="PrjActId" value="<?php echo $_REQUEST['PrjActId'];?>" />
<input type="hidden" name="PrjActCode" id="PrjActCode" value="<?php echo $_REQUEST['PrjActCode'];?>" />
<input type="hidden" name="PrjDetailId" id="PrjDetailId" value="<?php echo $_REQUEST['PrjDetailId'];?>" />
<input type="hidden" name="OrgCode" id="OrgCode" value="<?php echo $_REQUEST['OrgCode'];?>" />
<input type="hidden" name="MonthNo" id="MonthNo" value="<?php echo $_REQUEST['pageid'];?>" />
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $_REQUEST['BgtYear'];?>" />


<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-view" style="margin-bottom:0px;">
  <tr>
    <th style="width:20%; text-align:left">ปีงบประมาณ</th>
    <td  style="width:80%; text-align:left;">2556</td>
  </tr>
  <tr>
    <th style="text-align:left">ชื่อแผนงาน สช.</th>
    <td  style="text-align:left;"><b>แผนงานธรรมนูญสุขภาพ</b></td>
  </tr> 
  <tr>
    <td colspan="2" valign="top">
      <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
        <thead>
          <tr>
            <td style="width:40px;">ลำดับ</td>
            <td style="text-align:center;">ชื่อตัวชี้วัดแผนงาน สช.</td>
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


<?php 
	$detail = $get->getResultDetail($_REQUEST['PrjDetailId'],$_REQUEST['PrjActCode'],$_REQUEST['pageid']);
	//ltxt::print_r($detail);
	foreach($detail as $drow){
		foreach($drow as $k=>$v){
			${$k} = $v;
		}
	}
?>



<div style="height:3px"></div>
<table  border="0" cellspacing="1" cellpadding="5" style="background-color:#fff; border-bottom:0px">
  <tr  style="height:30px">
	<td  class="<?php if($_REQUEST["pageid"] == "10"){echo "tabselect";}else{ echo "tabdefault";}?>" ><a href="javascript:void(0)" onclick="toPage('10');"  >ต.ค</a></td>
    <td class="<?php if($_REQUEST["pageid"] == "11"){echo "tabselect";}else{ echo "tabdefault";}?>"><a href="javascript:void(0)" onclick="toPage('11');" >พ.ย</a></td>
    <td class="<?php if($_REQUEST["pageid"] == "12"){echo "tabselect";}else{ echo "tabdefault";}?>"><a href="javascript:void(0)" onclick="toPage('12');">ธ.ค</a></td>
    <td class="<?php if($_REQUEST["pageid"] == "1"){echo "tabselect";}else{ echo "tabdefault";}?>"><a href="javascript:void(0)" onclick="toPage('1');" >ม.ค</a></td>
    <td class="<?php if($_REQUEST["pageid"] == "2"){echo "tabselect";}else{ echo "tabdefault";}?>"><a href="javascript:void(0)" onclick="toPage('2');" >ก.พ</a></td>
    <td class="<?php if($_REQUEST["pageid"] == "3"){echo "tabselect";}else{ echo "tabdefault";}?>"><a href="javascript:void(0)" onclick="toPage('3');" >มี.ค</a></td>
    <td class="<?php if($_REQUEST["pageid"] == "4"){echo "tabselect";}else{ echo "tabdefault";}?>"><a href="javascript:void(0)" onclick="toPage('4');" >เม.ย</a></td>
    <td class="<?php if($_REQUEST["pageid"] == "5"){echo "tabselect";}else{ echo "tabdefault";}?>"><a href="javascript:void(0)" onclick="toPage('5');" >พ.ค</a></td>
    <td class="<?php if($_REQUEST["pageid"] == "6"){echo "tabselect";}else{ echo "tabdefault";}?>"><a href="javascript:void(0)" onclick="toPage('6');" >มิ.ย</a></td>
    <td class="<?php if($_REQUEST["pageid"] == "7"){echo "tabselect";}else{ echo "tabdefault";}?>"><a href="javascript:void(0)" onclick="toPage('7');" >ก.ค</a></td>
    <td class="<?php if($_REQUEST["pageid"] == "8"){echo "tabselect";}else{ echo "tabdefault";}?>"><a href="javascript:void(0)" onclick="toPage('8');" >ส.ค</a></td>
    <td class="<?php if($_REQUEST["pageid"] == "9"){echo "tabselect";}else{ echo "tabdefault";}?>"><a href="javascript:void(0)" onclick="toPage('9');" >ก.ย</a></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="3" cellpadding="3" style="background-color:#990000">
  <tr  style="background-color:#FFF">
    <td>
    
<table width="100%" border="0" cellspacing="1" cellpadding="6" class="tbl-list" >
<!--  <tr>
    <th style="text-align:left; width:20%">% ค่าน้ำหนักของโครงการ</th>
    <td>30.00<b>%</b></td>
  </tr>
  <tr>
    <th style="text-align:left; width:20%">% ความก้าวหน้าโครงการ</th>
    <td>38.5<b>%</b><span class="hint">(ได้จากผลรวมความก้าวหน้าของกิจกรรมในโครงการ คูณด้วย %ค่าน้ำหนักของโครงการ)</span></td>
  </tr>-->
  <tr>
  <th colspan="2" style="text-align:left;">ข้อมูลผลการดำเนินงานจำแนกตามโครงการ</th>
  </tr>
  <tr>
  <td colspan="2" style="background-color:#EEE;">
  
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
  <thead>
    <tr>
      <td style="width:40px;">ลำดับ</td>
      <td style="text-align:center;">ชื่อโครงการ</td>
      <td style="width:80px; text-align:center;">%ค่าน้ำหนัก</td>
      <td style="width:100px; text-align:center;">%ก้าวหน้าโครงการ</td>
      <td style="width:100px; text-align:center;">%ก้าวหน้าแผนงาน</td>
      </tr>
    </thead>
    
    <tr style="vertical-align:top;">
      <td style="text-align:center;">1</td>
      <td><a href="#">โครงการขับเคลื่อน ติดตาม ประเมินผลและทบทวนธรรมนูญว่าด้วยระบบสุขภาพแห่งชาติ พ.ศ. 2552</a> </td>
      <td style="text-align:center;">70</td>
      <td style="text-align:center;">38.5</td>
      <td style="text-align:center;">26.95</td>
      </tr> 
      
       <tr style="vertical-align:top;">
      <td style="text-align:center;">2</td>
      <td><a href="#">โครงการพัฒนานโยบายสาธารณะเพื่อสุขภาพแบบครบวงจร</a></td>
      <td style="text-align:center;">30</td>
      <td style="text-align:center;">60.5</td>
      <td style="text-align:center;">18.15</td>
      </tr> 
      


     <tr style="vertical-align:top; font-weight:bold;">
      <td colspan="2" style="text-align:right;">%แผนงาน</td>
      <td style="text-align:center;">100</td>
      <td style="text-align:center;">-</td>
      <td style="text-align:center; background-color:#FFFF99;">45.10</td>
      </tr>
      
    </table>
 
 
 </td>
 </tr>
 </table> 
  
    
    
    
    
    
    </td>
  </tr>
  
  
  
  
  
  
</table>




     <div style="text-align:center; padding-top:10px; padding-bottom:10px">
      <input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>');" />
      </div>
      
</form>

