<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
?>
<HTML>
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
<style media="print">
.btnback {
	display:none;
	vertical-align:top;
}
</style>
<style>
body {
	 font-family:TH SarabunPSK; 
	 font-size: 14px; 
	 margin:20px;
}
.tbl-list {
	border-collapse:collapse;
	font-family:TH SarabunPSK; 
	font-size: 14px; 
}
.tbl-list th {
	border:1px solid #999;
	padding-left:3px;
	padding-right:3px;
}
.tbl-list td {
	border:1px solid #999;
	padding-left:3px;
	padding-right:3px;
}
.sum-total {
	text-align:right;
}
</style>
</HEAD>
<BODY>


<div style="text-align:center; font-weight:bold; padding:10px; font-size:16px;">
ยุทธศาสตร์ชาติ/แผนงาน /เป้าหมายเชิงยุทธศาสตร์ /เป้าหมายให้บริการระดับกระทรวง /ยุทธศาสตร์กระทรวง <br/>/วิสัยทัศน์ /พันธกิจ/เป้าหมายการให้บริการระดับหน่วยงาน/ยุทธศาสตร์หน่วยงาน /ผลผลิตหน่วยงาน /กิจกรรมหลัก /แผนงาน สช.  
ประจำปี <?php echo ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:(date("Y")+543); ?>
</div>


<table width="100%" border="0" class="tbl-list" cellspacing="0" cellpadding="0">
<?php
	$no = 1;
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	
	if($list){
          foreach($list as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
  <tr>
    <td style="font-weight:bold;"><?php echo $no." ) ".$PGroupName;?></td>
    </tr>
  	<tbody id="td-<?php echo $i;?>">		
<?php
$item=$get->getItemList($PGroupId); //ltxt::print_r($item);
if($item){
	$t=1; 
	foreach( $item as $grp ) {
		foreach( $grp as $k=>$v){ ${$k} = $v;}
?>
              <tr style="vertical-align:top;"><!-- onmouseover="this.bgColor='#fffbcc'" onmouseout="this.bgColor='#FFFFFF'" #ded4d7-->
                <td valign="top"><?php echo "[".$PItemCode."] ".$PItemName; ?></td>
              </tr>  
              
              
              
<?php if($PGroupId == 12){ ?>

<!--รายการตัวชี้วัด-->
<?php 
$t=1;
$dataPurpose = $get->getPurposeItem($PItemCode);//ltxt::print_r($dataIndicator);
if($dataPurpose){
	foreach($dataPurpose as $pp){
		foreach( $pp as $e=>$w){ ${$e} = $w;}
?>    

<tr>
  <td style="text-indent:10px;" >|- <?php echo $PurposeName; ?></td>
    </tr> 
  
<?php				
			$t++;
	}
}
?>   
<!--END รายการตัวชี้วัด-->


<?php } ?>              
              
              
              
<!--รายการตัวชี้วัด-->
<?php 
$t=1;
$dataIndicator = $get->getIndicatorItem($PItemId);//ltxt::print_r($dataIndicator);
if($dataIndicator){
	foreach($dataIndicator as $in){
		foreach( $in as $a=>$q){ ${$a} = $q;}
?>    

<tr>
  <td style="text-indent:10px;" >
    |- (<?php echo $PIndCode; ?>)  <?php echo $PIndName; ?></td>
    </tr> 
  
<?php				
			$t++;
	}
}
?>   
<!--END รายการตัวชี้วัด-->

              
              
              
              
              
              
              
              
              
              
              
              
              
              
<?php
		$t++;
	 }
}else{
 ?>
                <tr>
                <td style="color:#990000; height:50px; vertical-align:middle">- - ไม่มีข้อมูล - -</td>
                </tr>
<?php } ?>
             
             
             
</tbody>
<?php

				$i++;
				$no++;
			}
	}
?>

</table>

<div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div> 

<div style="text-align:center; margin-top:20px;">
  <input class="btnback" type="button" name="back" value="ย้อนกลับ" onClick="window.history.go(-1);" />
</div>

<script>
	window.print();
</script>

</BODY>

</HTML>