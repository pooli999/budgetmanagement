<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

//ltxt::print_r($detail);	

?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	window.print();
/*  ]]> */
</script>
<style>
td{
	font-size:14px; 
}
th{
	font-size:14px; 
}
</style>
<style type="text/css" media="print">
   .print{ display:none;}
</style>


<table width="610" border="0" cellspacing="0" cellpadding="0" align="center"  bgcolor="#FFFFFF"  bordercolor="#FFFFFF">
  <tr>
    <td align="left" valign="top" >
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		  <tr>
		    <td rowspan="3" align="left" valign="top" ><img src="images/logo.png" border="0" width="59" height="51"/></td>
		    <td align="left" style="font-weight:bold; font-size:12px;">สำนักงานคณะกรรมการสุขภาพแห่งชาติ</td>
		  </tr>
			<tr>
			  <td align="left" style="font-size:10px;">ชั้น 3 อาคารสุขภาพแห่งชาติ 88/39 ถ.ติวานนท์ 14 หมู่ที่ 4 ต.ตลาดขวัญ อ.เมือง จ.นนทบุรี 11000</td>
			</tr>
			<tr>
			  <td align="left" style="font-size:10px;">โทร: 66 2832 9000 โทรสาร: 66 2832 9001 www.nationalhealth.or.th </td>
			</tr>
	  </table>
    </td>
    <td align="right" ><div style="font-weight:bold; font-size:12px;">แบบ สช.บ.007</div><div style="font-weight:bold; font-size:17px;">สัญญายืมเงิน</div></td>
  </tr>
    <tr>
    <td colspan="3" height="18"></td>
  </tr>
  <tr>
    <td colspan="3"  style="text-align:right; padding-bottom:6px">(สัญญาเลขที่ <?php echo $ContractNo; ?>)</td>
  </tr>
</table>
<table width="610" border="1" cellspacing="0" cellpadding="3"  align="center"  >
  <tr>
    <td colspan="2" style="vertical-align:bottom" >
          <div style="padding-bottom:5px">วันที่ <?php echo ShowDateLong($DocDate);?></div>
          <div style="padding-bottom:5px">เรียน <?php echo $DocTo; ?></div>
    </td>
    <td colspan="2" style="vertical-align:bottom">
                <div style="padding-bottom:5px">วันครบกำหนด <?php echo ShowDate($ContractDueDate);?></div>
                <div style="padding-bottom:5px">ติดตามครั้งที่ 1 .........................</div>
                <div style="padding-bottom:5px">ติดตามครั้งที่ 2 .........................</div>    
    </td>
  </tr>
  <tr>
    <td colspan="4">
    	<div style="padding-bottom:5px">ข้าพเจ้า <?php echo fn_getFullNameByUserId($CreateBy);?> ตำแหน่ง <?php echo $_SESSION['Session_Position'];?></div>
    	<div style="padding-bottom:5px; line-height:160%">มีความประสงค์จะขอยืมเงินทดรองจ่ายเพื่อ <?php echo $Detail; ?></div>
      	<div style="padding-bottom:5px">ตามบันทึกอนุมัติที่ <?php echo $ContractNo; ?> ลงวันที่ <?php echo ShowDate($ContractDate);?> ดังรายละเอียดต่อไปนี้</div>
    </td>
  </tr>
  <?php 
		$costList = $get->getCostItemList($DocCode);
		 if($costList){
				foreach($costList as $rc){
					foreach( $rc as $k=>$v){ ${$k} = $v;}
  ?>
  <tr>
    <td colspan="2" style="text-align:left; vertical-align:top"><?php echo $DetailCost; ?></td>
    <td width="150" style="text-align:right; vertical-align:top"><?php echo number_format($get->getSumCostBorrow($DocCode,$PrjActCode,$CostItemCode,0),2); ?></td>
    <td width="44" style="text-align:left; vertical-align:top">บาท</td>
  </tr>
  <?php } }?>
  <tr>
    <td colspan="2"  style="text-align:right">ตัวอักษร (<?php echo JThaiBaht::_($get->getSumCostBorrow($DocCode,$PrjActCode,0,0)); ?>) รวมเงิน (บาท)</td>
    <td style="text-align:right;"><?php echo number_format($get->getSumCostBorrow($DocCode,$PrjActCode,0,0),2); ?></td>
    <td style="text-align:left;">บาท</td>
  </tr>
  <tr>
    <td colspan="4">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="67%" style="text-align:left; padding-bottom:3px; padding-top:20px">ลงลายมือชื่อ........................................................................ ผู้ยืม</td>
            <td width="33%" style="text-align:left; padding-bottom:3px; padding-top:20px">วันที่ .........................................</td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td width="203" style="text-align:center; vertical-align:bottom; padding-top:30px">
    <div style="padding-bottom:5px;">ลงชื่อ ...............................</div>
    <div style="padding-bottom:5px">(<?php echo fn_getFullNameByPersonalCode($ContractCheckBy);?>)</div>
    <div style="padding-bottom:5px">ผู้ตรวจสอบ<br>&nbsp;</div><br />
	<div style="padding-bottom:5px">วันที่ ........../........../..........</div>
    </td>
    <td width="203" style="text-align:center; vertical-align:bottom; padding-top:30px">
    <div style="padding-bottom:5px; ">ลงชื่อ ...............................</div>
    <div style="padding-bottom:5px">(...............................)</div>
    <div style="padding-bottom:5px">ผู้อนุมัติ<br>&nbsp;</div><br />
	<div style="padding-bottom:5px">วันที่ ........../........../..........</div>
    </td>
    <td style="text-align:center; vertical-align:bottom; padding-top:30px" colspan="2">
    <div style="padding-bottom:5px;">ลงชื่อ ...............................</div>
    <div style="padding-bottom:5px">(...............................)</div>
    <div style="padding-bottom:5px;">ได้รับเงินยืมถูกต้อง<br>ตามสัญญายืมเงินแล้ว</div><br />
	<div style="padding-bottom:5px">วันที่ ........../........../..........</div>
    </td>
  </tr>
</table>








<div style="padding-top:50px; text-align:center;">
  <input name="print" type="button" value="พิมพ์เอกสาร"  onclick="window.print();" class="print" style="color:#009"  />
<input name="print" type="button" value="ปิดหน้าต่าง"  onclick="window.close();" class="print" style="color:#000"  />
</div>
