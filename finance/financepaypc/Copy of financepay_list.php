<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => 'ระบบการเงิน',
		'link' => '?mod=budget.init.startup',
	),
	
	array(
		'text' => $MenuName,
	),
));

function icoActive($r){
	global $actionPage;
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&BookbankId='.$r->BookbankId."&start=".$_REQUEST["start"].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}

function icoEdit($r){
	$label = 'แก้ไข';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->BookbankId."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoView($r){
	$label = $r->BankName;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&id=".$r->BookbankId."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&id=".$r->BookbankId."&start=".$_REQUEST["start"]."')",
		'ico delete',
		$label,
		$label
	));
}

/*function icoView($r){
	$label = 'ดูรายละเอียด';
	global $viewPage;
	vprintf('<a href="%s" onclick="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:void(0)",
		"toggleSub('".$r."')",
		'ico search',
		$label,
		$label
	));
}*/

?>

<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	function Search(){
		var PersonalCode=JQ('#PersonalCode').val();
		var PName=JQ('#PersonalCode option:selected').text();
		window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&PersonalCode="+ PersonalCode+"&PName="+PName;
	}
	
	function toggleSub(id){
		JQ("a#icoClass_"+id).toggleClass("minimize");
		JQ("tr.hideRow_"+id).toggle();
	}
	
	function sortItem(){
	window.location.href='?mod=<?php echo lurl::dotPage($sortPage);?>';
	}

/* ]]> */
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td>
      	  <!--<input type="button" name="button4" id="button4" value="เพิ่มรายการ" class="add" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>');" />
      <input type="button" name="button5" id="button5" value="  เรียงลำดับข้อมูล  " class="btnRed" onclick="goPage('?mod=<?php //echo lurl::dotPage($sortPage);?>');" />
	  <input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();" />
	  -->
      	<input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" />
      </td>

          <td align="right">
		  	<form name="searchForm" id="SearchForm" method="post">
				  <table  border="0" align="right" cellpadding="0" cellspacing="5" >
					<tr>
					  <td  align="right"><strong>ชื่อผู้ปฏิบัติงาน : </strong></td>
					  <td align="right">
						<?php 
							$PersonalCode = $_GET["PersonalCode"];
							$tag_attribs = 'onchange="" style="width:300px"';
							echo $get->getPersonalCode("PersonalCode",$tag_attribs,$PersonalCode,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
						?><input id="search2" name="search2" type="button" value="  ค้นหา  " class="btnRed"   onclick="Search();" />
					  </td>
					</tr>
				  </table>
			</form>
		  </td>
    </tr>
  </table>
</div>

<div class="cms-box-search">

  <?php 
if($_REQUEST['PersonalCode']){?>
ผลการค้นหา <span style="color:#FF6600; font-weight:bold;">&quot;<?php echo $_REQUEST['PName'];?>&quot;</span> พบจำนวน <span style="color:#FF6600; font-weight:bold;"><?php echo $list['total'];?></span> รายการ 
<?php }?>
</div>
<script type="text/javascript" language="javascript" id="js">
/* <![CDATA[ */
function addCommas(nStr){
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

JQ(document).ready(function() {
	JQ("table").tablesorter({
		headers: {
			0: {sorter: false},
			3: {sorter: false},
			4: {sorter: false}
		}
	});
	JQ("#CashValue").live('click',function(){ 
		CompID = JQ("#CompID").val();// รหัสภาคี
		JQ.ajax({
			  type: "POST",
			  url: "?mod=<?php echo LURL::dotPage('financepay_action');?>",		   
			  data: "action=loadcomp&CompID="+CompID,
			  success: function(result){
					if(result){
					
						//JQ("#TaxIdent").val(result.TaxIdent);
						JQ("#TaxIdent").val(result.TaxIdent );
						JQ("#AddressDetail_1").val(result.PtnFname);
					}else{
					
					}
			  },
			  dataType: "json"
		});
		
	 })
	JQ("#btn_company").live('click',function(){  
		create_tblCodeId();
		JQ( "#dialog-company" ).dialog( "open" );			
	 })
	JQ( "#dialog-company" ).dialog({
			  resizable: false,
			  autoOpen: false,
			  height:600,
			  width:900,
			  modal: true,
			  buttons: {
				"บันทึก": function() {
				  JQ( this ).dialog( "close" );
				},
				"ปิด": function() {
				  JQ( this ).dialog( "close" );
				}
			  }
	});
	JQ("#btn_info").live('click',function(){ 
		JQ( "#dialog-info" ).dialog( "open" );
	 })
	 JQ( "#dialog-info" ).dialog({
			  resizable: false,
			  autoOpen: false,
			  height:600,
			  width:800,
			  modal: true,
			  buttons: {
				"เพิ่ม": function() {
				  JQ( this ).dialog( "close" );
				},
				"ปิด": function() {
				  JQ( this ).dialog( "close" );
				}
			  }
		});

});

function create_tblCodeId(){ // สร้างตาราง แสดงรายการ สชน ที่เลือก
		max_val = 0 // จำนวนเงินรวม
		str_tbl = '<table width="100%" border="0" class="tbl-list tablesorter"cellspacing="0">';
			str_tbl = str_tbl+'<thead>';
			str_tbl = str_tbl+'<tr>';
				str_tbl = str_tbl+'<th  align="center" class="no" style="width:40px">รหัส</th>';
				str_tbl = str_tbl+'<th  align="center" style="width:150px;">รหัสเอกสาร</th>';
				str_tbl = str_tbl+'<th  align="center"style="width:150px;" >วันที่เอกสาร</th>';
				str_tbl = str_tbl+'<th  align="center" style="width:150px;">เลขที่ สช.น</th>';
				str_tbl = str_tbl+'<th  align="center" >ชื่อเรื่อง</th>';
				str_tbl = str_tbl+' <th align="center" style="width:150px;">จำนวนเงิน (บาท) </th>';
			str_tbl = str_tbl+'</tr>';
			str_tbl = str_tbl+'</thead>';
			str_tbl = str_tbl+'<tbody>';
	JQ('[name=CboCodeId]:checked').each(function() {	// วนสร้าง ตามจำนวนที่เลือก
		   		str_tbl = str_tbl+'<tr class="active-row">';
				str_tbl = str_tbl+'<td valign="top" class="center">'+JQ('#tr'+JQ(this).val()+' td').eq(0).text()+'</td>';
				str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+JQ('#tr'+JQ(this).val()+' td').eq(1).text()+'</td>';
				str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+JQ('#tr'+JQ(this).val()+' td').eq(2).text()+'</td>';
				str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+JQ('#tr'+JQ(this).val()+' td').eq(3).text()+'</td>';
				str_tbl = str_tbl+'<td align="left" valign="top" class="left">'+JQ('#tr'+JQ(this).val()+' td').eq(4).text()+'</td>';
				str_tbl = str_tbl+'<td align="right" valign="top" class="right">'+JQ('#tr'+JQ(this).val()+' td').eq(5).text()+'</td>';
				str_tbl = str_tbl+'</tr>';
				 t1 = JQ('#tr'+JQ(this).val()+' td').eq(5).text();
				 v_ans = t1.replace(",","");
				max_val = max_val+parseFloat(v_ans);
	 });
			 str_tbl = str_tbl+'<tr class="active-row">';
			str_tbl = str_tbl+'<td valign="top" class="center"></td>';
			str_tbl = str_tbl+'<td align="left" valign="top" class="center"></td>';
			str_tbl = str_tbl+'<td align="left" valign="top" class="center"></td>';
			str_tbl = str_tbl+'<td align="left" valign="top" class="center"></td>';
			str_tbl = str_tbl+'<td align="left" valign="top" class="right">จำนวนเงินรวม</td>';
			str_tbl = str_tbl+'<td align="right" valign="top" class="right">'+addCommas(max_val.toFixed(2))+'</td>';
			str_tbl = str_tbl+'</tr>';
	 str_tbl = str_tbl+'</tbody>';
	 str_tbl = str_tbl+'</table>';
	 JQ("#divCodeId").html(str_tbl);
}
/* ]]> */

</script>

<table width="100%" border="0" class="tbl-list tablesorter"  cellspacing="0">
<thead>
  <tr>
    <th class="no" style="width:10px">รหัส</th>
    <th align="center" style="width:100px">รหัสเอกสาร</th>
    <th align="center" style="width:150px">วันที่เอกสาร</th>
    <th align="center"  style="width:100px">เลขที่ สช.น </th>
    <th align="center">ชื่อเรื่อง</th>
    <th align="center" style="width:150px;">จำนวนเงิน (บาท)</th>
    <th style="text-align:center;width:100px;" >ปฏิบัติการ</th>
    </tr>
</thead>
<tbody>

<?php
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	if($list["rows"]){
          foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
  <tr id = "tr<?php echo $CodeId ;?>">
    <td valign="top" class="center" ><?php echo $CodeId ;?></td>
    <td valign="top" class="center"><?
	echo $FormCode;
	?></td>
    <td valign="top" class="center"><?
	echo $DocDate;
	?></td>
    <td valign="top" class="center"><?php
	// echo icoView($r);
	 echo $DocCode;
	 ?></td>
    <td align="left" valign="top" ><?
	echo $Topic;
	?></td>
    <td align="right" valign="top" ><?php echo number_format($Budget,2)?></td>
    <td align="center" valign="top" nowrap="nowrap" style="width:60px;"  ><input type="checkbox" name="CboCodeId" value="<?php echo $CodeId ;?>" /></td>
    </tr>
  
<?php
		$i++;
		}
	}
?>
</tbody>
<tr>
    <td valign="top" class="center" >&nbsp;</td>
    <td valign="top" class="center">&nbsp;</td>
    <td valign="top" class="center">&nbsp;</td>
    <td valign="top" class="center">&nbsp;</td>
    <td align="left" valign="top" >&nbsp;</td>
    <td align="right" valign="top" >&nbsp;</td>
    <td align="center" valign="top" nowrap="nowrap" style="width:60px;"  ><input id="btn_company" name="search22" type="button" value="  จ่ายเงิน  " class="btnActive" /></td>
  </tr>
</table>
<?php
if(!$list["rows"]){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>
<!--<div class="cms-box-navpage">-->
<?php //echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
<!--</div>-->
          

<!--
ตาราง ส่วน 2
-->
<table width="100%" border="0" class="tbl-list tablesorter"  cellspacing="0">
<thead>
  <tr>
    <th class="no" style="width:10px">รหัส</th>
    <th align="center" style="width:200px">PV</th>
    <th align="center">เลขที่ สช.น</th>
    <th align="center" style="width:200px;">วันที่จ่าย</th>
    <th colspan="2" style="text-align:center;width:100px;" >ปฏิบัติการ</th>
    </tr>
</thead>
<tbody>

<?php 
$i=($_REQUEST["start1"]=='') ? 1: $_REQUEST["start1"]+1;
$tList2 = $get->getDataList2();//ltxt::print_r($costList);
if($tList2["rows"]){
          foreach($tList2["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
  <tr>
    <td valign="top" class="center" ><?php echo $PaymentId ;?></td>
    <td valign="top" class="center">&nbsp;</td>
    <td align="left" valign="top" ><?
	//echo $Topic;
	?></td>
    <td align="center" valign="top" ><?= $CreateBy?></td>
    <td align="center" valign="top" nowrap="nowrap" style="width:60px;"  ><?php echo icoEdit($r);?></td>
    <td align="center" valign="top" nowrap="nowrap" style="width:60px;"  ><?php echo icoDelete($r);?></td>
  </tr>
<?php				
			$i++;
		}
	}
?> 	
</tbody>
</table>
<?php
if(!$tList2["rows"]){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';
}
?>
<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>$tList2['total'],'limit'=>20,'start'=>$_REQUEST["start"]));?></div>







<div id="dialog-company"  title="จ่ายเงิน">
	<div id = "divCodeId"></div><!--ตารางรายการสชนที่เลือก-->
  
  <br>
  <input id="btn_info" name="search23" type="button" value="เพิ่มบริษัท" class="btnActive"  />
  <br>
  <div id = "divPaymentCompId"></div><!--ตารางบริษัทที่เพิ่ม-->
  <table width="100%" border="0" class="tbl-list tablesorter" cellspacing="0">
    <thead>
      <tr>
        <th  align="center" class="no" style="width:40px">ลำดับ</th>
        <th  align="center" style="width:150px;">ชื่อผู้รับเงิน</th>
		 <th  align="center" style="width:170px;">เลขประจำตัวผู้เสียภาษี</th>
        <th  align="center">ที่อยู่</th>
        <th align="center" style="width:100px;">จำนวนเงิน (บาท) </th>
        <th align="center" style="width:120px;">ปฏิบัติการ</th>
      </tr>
    </thead>
    <tbody>
      <tr class="active-row">
        <td valign="top" class="center">1</td>
        <td align="left" valign="top" class="center">FF008</td>
        <td align="left" valign="top" class="center">8 ม.ค. 59 </td>
        <td align="left" valign="top" class="center">0015/2560</td>
        <td align="right" valign="top" class="right">50,000</td>
        <td align="center" valign="top" class="center"><?php echo icoEdit($r);?>&nbsp;<?php echo icoDelete($r);?></td>
      </tr>
      <tr class="active-row">
        <td height="22" valign="top" class="center">2</td>
        <td align="left" valign="top" class="center">FF009</td>
        <td align="left" valign="top" class="center">1 ม.ค. 59</td>
        <td align="left" valign="top" class="center">0016/2560</td>
        <td align="right" valign="top" class="right">12,000</td>
        <td align="center" valign="top" class="center"><?php echo icoEdit($r);?>&nbsp;<?php echo icoDelete($r);?></td>
      </tr>
      <tr class="active-row">
        <td height="22" valign="top" class="center">&nbsp;</td>
        <td align="left" valign="top" class="center">&nbsp;</td>
        <td align="left" valign="top" class="center">&nbsp;</td>
        <td  valign="top" class="right">จำนวนเงินรวม</td>
        <td align="right" valign="top" class="right">62,000</td>
        <td align="center" valign="top" class="center">&nbsp;</td>
      </tr>
      <?php if($i==1){?>
      <?php } ?>
    </tbody>
  </table>
</div>


<div id="dialog-info"  title="รายละเอียดการจ่ายเงิน">
  <table width="100%" border="0" cellspacing="0" class="tbl-list tablesorter">
  	 <tr>
        <td class="left">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list tablesorter">
			  <tr>
			    <td height="30" colspan="4" bgcolor="#999999" class="style2">จ่าย</td>
		      </tr>
			  <tr>
				<td width="11%">ชื่อผู้รับเงิน</td>
				<td width="35%">
			    <?php echo eNetwork(array('name'=>'CompID[]','id'=>'CompID','value'=>'','selecttype'=>'one'));?></td>
			    <td width="16%">เลขประจำตัวผู้เสียภาษี</td>
			    <td width="38%"><input name="TaxIdent" type="text" id="TaxIdent" /></td>
			  </tr>
			  <tr>
				<td>ที่อยู่</td>
				<td><textarea name="AddressDetail_1" cols="40" rows="4" id="AddressDetail_1"></textarea></td>
			    <td>ภาษีมูลค่าเพิ่ม</td>
			    <td><select name="Tax" id="Tax">
			        <option selected="selected">7</option>
			        <option>10</option>
		          </select>
			      %</td>
			  </tr>
	    </table>
		</td>
    </tr>
  	 <tr class="active-row">
  	   <td class="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td height="30" colspan="2" bgcolor="#999999" style="color:#CCCCCC"><span class="style2">วิธีการจ่ายชำระเงิน</span></td>
         </tr>
         <tr>
           <td width="21%">ภาษีหัก ณ ที่จ่าย</td>
           <td><input name="TaxW" type="text" id="TaxW" size="5" maxlength="5" />
           %</td>
          </tr>

         <tr>
           <td>เงินสด</td>
           <td align="left"><input name="CashValue" id = "CashValue" type="text" />
           บาท</td>
         </tr>
         <tr>
           <td>เงินโอน/เช็ค </td>
           <td align="right"><input id="btn_bank" name="search232" type="button" value="เพิ่มข้อมูล เงินโอน/เช็ค" class="btnActive" /></td>
         </tr>
         <tr>
           <td colspan="2"><table width="100%" border="0" cellspacing="0">
               <thead>
                 <tr>
                   <th  align="center" class="no" style="width:40px">ลำดับ</th>
                   <th  align="center" style="width:200px;">รูปแบบการจ่ายเงิน</th>
                   <th  align="center" style="width:200px;">ธนาคาร</th>
                   <th  align="center">Payment<br />
                     Number</th>
                   <th  align="center"style="width:150px;" >จำนวนเงิน<br />
                     (บาท)</th>
                   <th align="center"  width="" style="width:100px;">ปฏิบัติการ</th>
                 </tr>
               </thead>
               <tbody>
                 <?php

?>
                 <tr class="active-row">
                   <td valign="top" class="center"><?php echo $i ;?>12</td>
                   <td  valign="top" class="center">เช็ค</td>
                   <td  valign="top" class="center">ธ.กรุงไทย 059-0-99819-7 </td>
                   <td  valign="top" class="center">60670464</td>
                   <td  valign="top" class="center">30,000</td>
                   <td align="center"  valign="top" nowrap="nowrap"  ><?php echo icoEdit($r);?>&nbsp;<?php echo icoDelete($r);?></td>
                 </tr>
                 <tr class="active-row">
                   <td height="22" valign="top" class="center">13</td>
                   <td align="left" valign="top" class="center">เงินโอน</td>
                   <td align="left" valign="top" class="center">ธ.กรุงไทย 487-0-21549-7 </td>
                   <td align="left" valign="top" class="center">48545556</td>
                   <td align="left" valign="top" class="center">20,000</td>
                   <td align="center"  valign="top" nowrap="nowrap"  ><?php echo icoEdit($r);?>&nbsp;<?php echo icoDelete($r);?></td>
                 </tr>
                 <?php if($i==1){?>
                 <?php } ?>
               </tbody>
           </table></td>
         </tr>
       </table></td>
    </tr>
  </table>
</div>