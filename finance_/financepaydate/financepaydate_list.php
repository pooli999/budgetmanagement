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
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&BankId='.$r->BankId."&start=".$_REQUEST["start"].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}

function icoEdit($r){
	$label = 'แก้ไข';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->BankId."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoView($r){
	$label = $r->BankName;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&id=".$r->BankId."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&id=".$r->BankId."&start=".$_REQUEST["start"]."')",
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
	function Save(f,smode){
		JQ("#smode").val(smode);
		if(ValidateForm(f)){
			 var action_url = '?mod=finance.financepaydate.financepaydate_action';
			 var redirec_url = '?mod=finance.financepaydate.financepaydate_list';
			 toSubmit(f,'save',action_url,redirec_url);
		}
	}
	function ValidateForm(f){
		if (JQ("#smode").val() == "pay"){
			if(JQ('#data1').val() == ''){
				jAlert('กรุณาเลือกรายการ','ระบบตรวจสอบข้อมูล',function(){
						
				});
				return false;
			}										
		}else{
			return true;
		}
		
			var r = confirm("ต้องการทำรายการใช่หรือไม่");
			if (r == true) {
				return true;
			} else {
				return false;
			}
	}
	function Search(){
		var tsearch=JQ('#tsearch').val();
		window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&tsearch="+ tsearch;
	}
	
	function toggleSub(id){
		JQ("a#icoClass_"+id).toggleClass("minimize");
		JQ("tr.hideRow_"+id).toggle();
	}
	
	function sortItem(){
	window.location.href='?mod=<?php echo lurl::dotPage($sortPage);?>';
	}
	function changepaydate(PaymentId,ddate){ // ปุ่มแก้ไข การจ่ายเงิน
		JQ("#smode").val("changepaydate");
		var str = ddate;
		var res = str.split("-");
		tmp1 = parseFloat(res[0])+543;
		ans = res[2]+"/"+res[1]+"/"+tmp1;
		JQ("#ChequePayDate1").val(ans);
		
		JQ("#c_pid1").val(PaymentId);
		JQ( "#divPayDate" ).dialog( "open" );	
	}
/* ]]> */
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูลdd<?php echo $MenuName;?></div>
</div>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td><!--<input type="button" name="button5" id="button5" value="  เรียงลำดับข้อมูล  " class="btnRed" onclick="goPage('?mod=<?php //echo lurl::dotPage($sortPage);?>');" />-->
      	<input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" />
      <!--  <input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();" />-->
        </td>

          <td align="right"></td>
    </tr>
  </table>
</div>
<form name="searchForm" id="SearchForm" method="post">
<div id="boxSearch" class="boxsearch" style="display:none;">
  <table  border="0" align="center" cellpadding="0" cellspacing="5" >
    <tr>
      <td  align="left"><strong>คำค้น : </strong></td>
      <td align="left"><input name="tsearch" id="tsearch" type="text" class="input-search" size="30" value="<?php echo $_REQUEST['tsearch']?>" />
        <input id="search2" name="search2" type="button" value="  ค้นหา  " class="btnRed"   onclick="Search();" />
        <input type="button" name="button5" id="button2" class="btn" value=" ยกเลิก " onclick="JQ('#boxSearch').hide();JQ('#boxFilter').show();" /></td>
    </tr>
  </table>
  
</div></form>
<div class="cms-box-search">

  <?php 
if($_REQUEST['tsearch']){?>
ผลการค้นหา <span style="color:#FF6600; font-weight:bold;">&quot;<?php echo $_REQUEST['tsearch'];?>&quot;</span> พบจำนวน <span style="color:#FF6600; font-weight:bold;"><?php echo $list['total'];?></span> รายการ 
<?php }?>
</div>
<script type="text/javascript" language="javascript" id="js">
/* <![CDATA[ */
JQ(document).ready(function() {
	 //----------------Datepicker--------------------------
		var d = new Date();
		var toDay = d.getDate() + '/'
		+ (d.getMonth() + 1) + '/'
		+ (d.getFullYear()+543);
		JQ(".datepicker-th").datepicker({ dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
		
		//showButtonPanel: true,
		dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
		monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
		monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
		style="z-index: 12";
		JQ('.datepicker-th').css('background-image','url(images/calendar.png)');
		JQ('.datepicker-th').css('background-repeat','no-repeat');
		JQ('.datepicker-th').css('background-position','right');
		JQ('.datepicker-th').css('width','105px');
		JQ('.datepicker-th').css('border','none');
		JQ('.datepicker-th').css('padding-left','1px');
		JQ('.datepicker-th').css('cursor','pointer');
	//-----------------------------------------------------------
	JQ("table").tablesorter({
		headers: {
			0: {sorter: false},
			3: {sorter: false},
			4: {sorter: false}
		}
	});
	JQ('input[name="CboPayId"]').click(function() {
		str1 = "";
		JQ('input[name="CboPayId"]:checked').each(function(){ // หาว่าตัวไหน checked บ้าง ถ้า checked ให้ส่งข้อมูล
			str1 = str1+this.value+"||";
		});
		str1 = str1.substring(0, str1.length-2); 
		JQ("#data1").val(str1);
	});
	JQ('input[name="CboSendId"]').click(function() {
		str1 = "";
		JQ('input[name="CboSendId"]:checked').each(function(){ // หาว่าตัวไหน checked บ้าง ถ้า checked ให้ส่งข้อมูล
			str1 = str1+this.value+"||";
		});
		str1 = str1.substring(0, str1.length-2); 
		JQ("#data2").val(str1);
		
		str1 = "";
		JQ('input[name="CboSendId"]:not(:checked)').each(function(){ // หาว่าตัวไหน checked บ้าง ถ้า checked ให้ส่งข้อมูล
			str1 = str1+this.value+"||";
		});
		str1 = str1.substring(0, str1.length-2); 
		JQ("#data2_c").val(str1);
	});
	JQ( "#divPayDate" ).dialog({ // dialog หลัก 
	  resizable: false,
			  autoOpen: false,
			  height:150,
			  width:300,
			  modal: true,
			  buttons: {
				"บันทึก": function() {
				if (JQ("#ChequePayDate1").val() != ""){
					var action_url = '?mod=finance.financepaydate.financepaydate_action';
					var redirec_url = '?mod=finance.financepaydate.financepaydate_list';
					toSubmit("adminForm1",'save',action_url,redirec_url);
					JQ( this ).dialog( "close" );
				}else{
					alert("ระบุวันที่จ่ายเงิน");	
				}
				  
				},
				"ปิด": function() {
				  JQ( this ).dialog( "close" );
				}
			  }
	});
});
/* ]]> */
</script>
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>&action=save" enctype="multipart/form-data" >
<table width="100%" border="0" class="tbl-list tablesorter"  cellspacing="0">
<thead>
    <tr>
    <th class="no" style="width:10px">รหัส</th>
    <th align="center" style="width:120px">PV
      <input name="data1" type="hidden" id="data1" value="" />
      <input name="data2" type="hidden" id="data2" value="" />
       <input name="data2_c" type="hidden" id="data2_c" value="" />
      <input name="smode" type="hidden" id="smode" value="" /></th>
    <th align="center">เลขที่ สช.น</th>
    <th align="center" style="width:100px;">เลขที่เช็ค<?
	//echo str_replace("/","-",date("Y/m/d"));
	
	?></th>
    <th align="center" style="width:120px;">จำนวนเงิน (บาท)</th>
    <th align="center" style="width:100px;">วันที่ทำเช็ค</th>
    <th style="text-align:center;width:100px;" ><input id="savepay" class="btnRed" type="button" onclick="Save('adminForm','pay');" value=" จ่ายเงิน " name="save"></th>
    <th style="text-align:center;width:100px;" ><input id="savesend" class="btnRed" type="button" onclick="Save('adminForm','send');" value=" ส่งไปบัญชี " name="save2" /></th>
    <th style="text-align:center;width:100px;" >&nbsp;</th>
    <th style="text-align:center;width:100px;" >&nbsp;</th>
    </tr>
</thead>
<tbody>
<?php
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	
	if($list["rows"]){
          foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
 <tr>
    <td valign="top" class="center" ><?php echo $PaymentId ;?></td>
    <td valign="top" class="center">&nbsp;</td>
    <td align="left" valign="top" ><?php 

		$tList3 = $get->getDataList3($PaymentId);//ltxt::print_r($costList);
		if($tList3["rows"]){
		$iv = 0;
		$iv_txt="";
				  foreach($tList3["rows"] as $r1 ) {
						foreach( $r1 as $k1=>$v1){ ${$k1} = $v1;}
							if ($iv != 0){
								$iv_txt = " , ";
							}
							echo $iv_txt.$r1->DocCode;
		?>
			
		<?php				
				$iv++;
				}
			}
		?></td>
    <td align="center" valign="top" ><?=$r->PaymentNumber?></td>
    <td align="center" valign="top" ><?=$r->pvalue?></td>
    <td align="center" valign="top" ><?=$r->ChequeMakeDate?></td>
    <td align="center" valign="top" nowrap="nowrap" style="width:60px;"  >
    <? if ($r->ChequePayDate == "0000-00-00"){?>
    <input type="checkbox" name="CboPayId" value="<?php echo $PaymentId ;?>" />
    <? }else{?>
    	<a class="ico edit" title="แก้ไข"  onclick="changepaydate(<?php echo $PaymentId ;?>,'<?=$r->ChequePayDate?>')">
    	<?=$r->ChequePayDate?>
        </a>
    <? }?>    </td>
    <td align="center" valign="top" nowrap="nowrap" style="width:60px;"  >
      <input name="CboSendId" type="checkbox"  value="<?php echo $PaymentId ;?>" <?php if ($SendStatus == "Y"){?>checked="checked"<? }?> /></td>
    <td align="center" valign="top" nowrap="nowrap" style="width:60px;"  ><a class="ico print" title="แก้ไข" href="/report/pay/voucher.php?PaymentId=<?php echo $PaymentId ;?>"  target="_blank">ใบสำคัญจ่าย</a></td>
    <td align="center" valign="top" nowrap="nowrap" style="width:60px;"  ><a class="ico print" title="แก้ไข" href="/report/pay/tavi50.php?PaymentId=<?php echo $PaymentId ;?>"  target="_blank">ใบหักภาษี ณที่จ่าย</a></td>
    </tr>
<?php

		$i++;
		}
	}
?>
</tbody>
</table>
</form>
<div id = "divPayDate">
<form id="adminForm1" name="adminForm1" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>&action=save" enctype="multipart/form-data" >
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
    <tr class="detailUnder">
      <th width="150">วันที่จ่ายเช็ค :</th>
      <td>
        <input id = "ChequePayDate1" name="ChequePayDate1" type="text" class="datepicker-th" />
        <span style="width:120px">
        <input name="c_pid1" type="hidden" id="c_pid1" value="" />
        </span></td>
     </tr>
</table>           
</form>
</div>

<?php
if(!$list["rows"]){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>
<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>
          
