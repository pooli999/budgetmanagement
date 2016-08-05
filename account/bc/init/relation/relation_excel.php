<?php
header("Content-type: text/html; charset=tis-620");
header("Content-Disposition: attachment; filename=Plan".date("d-m-Y").".xls");
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

?>


<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
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





<?php
$_REQUEST["PGroupId"] = ($_REQUEST["PGroupId"])?$_REQUEST["PGroupId"]:1;
$_REQUEST["BgtYear"] = ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:date("Y")+543;
?>
<div style="text-align:center; font-weight:bold; padding:10px; font-size:16px;">
ความเชื่อมโยงระหว่างยุทธศาสตร์ชาติ/แผนงาน /เป้าหมายเชิงยุทธศาสตร์ /เป้าหมายให้บริการระดับกระทรวง /ยุทธศาสตร์กระทรวง <br/>/วิสัยทัศน์ /พันธกิจ/เป้าหมายการให้บริการระดับหน่วยงาน/ยุทธศาสตร์หน่วยงาน /ผลผลิตหน่วยงาน /กิจกรรมหลัก /แผนงาน สช.  ประจำปี <?php echo $_REQUEST["BgtYear"]; ?>
</div>




<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr  style="background-color:#FFF">
    <td style="vertical-align:top">
<?php
$item= $get->getItemList($_REQUEST["PGroupId"],$_REQUEST["BgtYear"]);//ltxt::print_r($item);
if($item){
	$nextgroup = $get->getNextGroup($_REQUEST["PGroupId"]);
	$t=1; 
	foreach( $item as $ritem ) {
		foreach( $ritem as $k=>$v){ ${$k} = $v;}
?>
 		<div><span style="font-weight:bold;"><?php echo $PGroupName;?>: </span><?php echo $PItemName;?></div>
        <div style="font-weight:bold;"><?php echo $nextgroup[0]->NextPGroupName; ?> :</div>
        		<?php
                $relationList = $get->getItemrelationList($PItemId);
				if($relationList){
					$s = 1;
				foreach( $relationList as $rRelation ) {
				?>
                <div><span class="ico bulletyellow"><?php echo $s.".";?>&nbsp;&nbsp;<?php echo $get->getPItemName($rRelation->PItemRelate);?></span></div>
        		<?php $s++; } }else{ ?>
                 <div  class="txtred" style="padding-left:20px; padding-top:3px; padding-bottom:3px; border-top: 1px solid #ccc;border-top-style: dotted;border-bottom: 1px solid #ccc;border-bottom-style: dotted;" >ไม่มีข้อมูลความเชื่อมโยง</div>
                <?php }  //end item relation?>
                <br />
        <?php } } //end item?>
        
	</td>
   </tr>
 </table>
 
 <div style="text-align:right; color:#666; margin-top:10px;">( ข้อมูลระบบ ณ วันที่ <?php echo dateFormat(date("Y-m-d")); ?> )</div> 
 

</BODY>

</HTML>


