<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
include("javascript.php");
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

?>

<script language="javascript" type="text/javascript">
	/*
	<div id="dialog-company"  title="จ่ายเงิน"> // div เพิ่มบริษัท
	<div id = "divCodeId"></div><!--ตารางรายการสชนที่เลือก--> // div ส้รางตาราง สชน ที่เลือก
	<div id = "divPaymentPartnerCode"></div> // div ส้รางตาราง บริษัทที่เลือก
	function edit_Payment(PaymentId){ // ปุ่มแก้ไข การจ่ายเงิน
	JQ("#CashValue").live('click',function(){  // กดจำนวนเงินแล้วหาชื่อที่อยู่ภาคี
	JQ("#btn_company").live('click',function(){ // ปุ่ม จ่ายเงินที่หน้าหลัก 
	JQ( "#dialog-company" ).dialog({ // dialog หลัก 
	JQ("#btn_info").live('click',function(){ // ปุ่มเพิ่มบริษัท
	JQ( "#dialog-info" ).dialog({ // dialog หลัก เพิ่มบริษัท เลือกผู้จ่ายเงิน
	function create_tblCodeId(){ // สร้างตาราง แสดงรายการ สชน ที่เลือก
	function create_tblComp(){ // สร้างตาราง แสดงรายการ บริษัท
	function edit_comp(zz){ // function ใส่ข้อมูลที่หน้าแก้ไขบริษัท
	*/
	
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
 	/*var test=new Array();
    for(var i=0;i<2;i++){
        test[i]=new Array();
        for(var j=0;j<5;j++){
            test[i][j] = "" + (i+10) + "," + (j+20);
            document.write("test["+i+"]["+j+"] = "+test[i][j]+"<br/>");
        }
    }*/
	
/* <![CDATA[ */
var comp_line = 0;
var arr_tbl_comp_col1 = []; // arry เก็บคอลัมภ์ PaymentCompId
var arr_tbl_comp_col2 = []; // arry เก็บคอลัมภ์ CompID
var arr_tbl_comp_col3 = []; // arry เก็บคอลัมภ์ CashValue
var arr_tbl_comp_col4 = []; // arry เก็บคอลัมภ์ Tax
var arr_tbl_comp_col5 = []; // arry เก็บคอลัมภ์ TaxW
var arr_tbl_comp_col6 = []; // arry เก็บคอลัมภ์ ชื่อบริษัท
var arr_tbl_comp_col7 = []; // arry เก็บคอลัมภ์ เลขผู้เสียภาษี
var arr_tbl_comp_col8 = []; // arry เก็บคอลัมภ์ AddressDetail
var arr_tbl_comp_col16 = []; // arry เก็บคอลัมภ์ Soi
var arr_tbl_comp_col17 = []; // arry เก็บคอลัมภ์ Road
var arr_tbl_comp_col18 = []; // arry เก็บคอลัมภ์ ProvinceCode
var arr_tbl_comp_col19 = []; // arry เก็บคอลัมภ์ DistrictCode
var arr_tbl_comp_col20 = []; // arry เก็บคอลัมภ์ SubDistrictCode
var arr_tbl_comp_col21 = []; // arry เก็บคอลัมภ์ PostCode
var arr_tbl_comp_col22 = []; // arry เก็บคอลัมภ์ AddressGroupId
var arr_tbl_comp_col23 = []; // arry เก็บคอลัมภ์ DetailId
var arr_tbl_comp_col24 = []; // arry เก็บคอลัมภ์ DetailId


var arr_bookbank_line = []; // arry จำนวนวิธีการจ่ายเงินเริ่มจาก1

var arr_tbl_comp_col9 = []; // arry เก็บคอลัมภ์ PaymentType
var arr_tbl_comp_col10 = []; // arry เก็บคอลัมภ์ BankId
var arr_tbl_comp_col11 = []; // arry เก็บคอลัมภ์ BankName
var arr_tbl_comp_col12 = []; // arry เก็บคอลัมภ์ BookbankId
var arr_tbl_comp_col13 = []; // arry เก็บคอลัมภ์ BookbankNumber
var arr_tbl_comp_col14= []; // arry เก็บคอลัมภ์ PaymentNumber
var arr_tbl_comp_col15= []; // arry เก็บคอลัมภ์ PaymentValue


var list_line = 0;
var arr_tbl_list_col1 = []; // arry เก็บคอลัมภ์ รหัส	CodeId
var arr_tbl_list_col2 = []; // arry เก็บคอลัมภ์ รหัสเอกสาร FormCode
var arr_tbl_list_col3 = []; // arry เก็บคอลัมภ์ วันที่เอกสาร DocDate
var arr_tbl_list_col4 = []; // arry เก็บคอลัมภ์ เลขที่สชน	DocCode
var arr_tbl_list_col5 = []; // arry เก็บคอลัมภ์ ชื่อเรื่อง Topic
var arr_tbl_list_col6 = []; // arry เก็บคอลัมภ์ จำนวนเงิน Budget

var bookbank_line = 0;
var arr_tbl_bookbank_col1 = []; // arry เก็บคอลัมภ์ รหัส	PaymentType
var arr_tbl_bookbank_col2 = []; // arry เก็บคอลัมภ์ รหัสเอกสาร BankId
var arr_tbl_bookbank_col3 = []; // arry เก็บคอลัมภ์ วันที่เอกสาร ชื่อ ธนาคาร
var arr_tbl_bookbank_col4 = []; // arry เก็บคอลัมภ์ เลขที่สชน	BookbankId
var arr_tbl_bookbank_col5 = []; // arry เก็บคอลัมภ์ ชื่อเรื่อง เลขที่บัญชี
var arr_tbl_bookbank_col6 = []; // arry เก็บคอลัมภ์  PaymentNumber
var arr_tbl_bookbank_col7 = []; // arry เก็บคอลัมภ์  PaymentValue

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
function del_Payment(PaymentId){ // ปุ่มลบการจ่ายเงิน
	if(confirm('ต้องการลบข้อมูลรายการนี้หรือไม่ ? กรุณายืนยัน')){
		url = '?mod=finance.financepay.financepay_action&action=delete&id='+PaymentId+'&start=';
		window.location.href= url;
	}
}
function edit_Payment(PaymentId){ // ปุ่มแก้ไข การจ่ายเงิน
		JQ("#btn_info").hide();
		JQ("#divCodeId").html("");
		JQ("#divPaymentPartnerCode").html("");
		JQ("#div_bookbank").html("");
		JQ("#eNetwork_Label_PartnerCode").html("");
		JQ("#AddressDetail").val("");
		JQ("#Soi").val("");
		JQ("#Road").val("");
		JQ("#ProvinceCode").val("");
		JQ("#DistrictCode").val("");
		JQ("#SubDistrictCode").val("");
		JQ("#PostCode").val("");
		JQ("#TaxIdent").val("");
		JQ("#Tax").val("");
		JQ("#TaxW").val("");
		JQ("#CashValue").val("");
		
		JQ(".ele_data").val("");// clear ค่า hidden ต่างๆ
		list_line = 0;
		arr_tbl_comp_col1.length = 0;
		arr_tbl_comp_col2.length = 0;
		arr_tbl_comp_col3.length = 0;
		arr_tbl_comp_col4.length = 0;
		arr_tbl_comp_col5.length = 0;
		arr_tbl_comp_col6.length = 0;
		arr_tbl_comp_col7.length = 0;
		arr_tbl_comp_col8.length = 0;
		arr_tbl_comp_col16.length = 0;
		arr_tbl_comp_col17.length = 0;
		arr_tbl_comp_col18.length = 0;
		arr_tbl_comp_col19.length = 0;
		arr_tbl_comp_col20.length = 0;
		arr_tbl_comp_col21.length = 0;
		arr_tbl_comp_col22.length = 0;
		arr_tbl_comp_col23.length = 0;
		arr_tbl_comp_col24.length = 0;
		arr_bookbank_line.length = 0;
		comp_line = 0;
		arr_tbl_comp_col9.length = 0;
		arr_tbl_comp_col10.length = 0;
		arr_tbl_comp_col11.length = 0;
		arr_tbl_comp_col12.length = 0;
		arr_tbl_comp_col13.length = 0;
		arr_tbl_comp_col14.length = 0;
		arr_tbl_comp_col15.length = 0;
		list_line = 0;
		arr_tbl_list_col1.length = 0;
		arr_tbl_list_col2.length = 0;
		arr_tbl_list_col3.length = 0;
		arr_tbl_list_col4.length = 0;
		arr_tbl_list_col5.length = 0;
		arr_tbl_list_col6.length = 0;
		bookbank_line = 0;
		arr_tbl_bookbank_col1.length = 0;
		arr_tbl_bookbank_col2.length = 0;
		arr_tbl_bookbank_col3.length = 0;
		arr_tbl_bookbank_col4.length = 0;
		arr_tbl_bookbank_col5.length = 0;
		arr_tbl_bookbank_col6.length = 0;
		arr_tbl_bookbank_col7.length = 0;
		comp_line = 0;
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('financepay_action');?>",		   
		  async: false,
		  data: "action=Payment&PaymentId="+PaymentId,
		  success: function(result){
				if(result){
					JQ("#PaymentId").val(result.rows[0]["PaymentId"]);
					debug_cl = 0;
					//alert("result1="+result.total);
					for (comp_line = 0;comp_line < result.total;comp_line++){
						//TaxIdent = result.rows[comp_line]["TaxIdent"];
						//if (TaxIdent == null){TaxIdent = "-";}
						//txt_AddressDetail = result.rows[comp_line]["AddressDetail"]+" ซอย "+result.rows[comp_line]["Soi"]+" ถนน "+result.rows[comp_line]["Road"]+" แขวง  "+result.rows[comp_line]["DistrictCode"]+" เขต "+result.rows[comp_line]["SubDistrictCode"]+" จังหวัด "+result.rows[comp_line]["ProvinceCode"];
						JQ("#AddressDetail").val(result.rows[comp_line]["AddressDetail"]);
						JQ("#Soi").val(result.rows[comp_line]["Soi"]);
						JQ("#Road").val(result.rows[comp_line]["Road"]);
						JQ("#ProvinceCode").val(result.rows[comp_line]["ProvinceCode"]);
						JQ("#DistrictCode").val(result.rows[comp_line]["DistrictCode"]);
						JQ("#SubDistrictCode").val(result.rows[comp_line]["SubDistrictCode"]);
						JQ("#PostCode").val(result.rows[comp_line]["PostCode"]);
						JQ("#TaxIdent").val(result.rows[comp_line]["TaxIdent"]);
						txt_ans = result.rows[comp_line]["PtnPrefixTH"]+result.rows[comp_line]["PtnFname"]+" "+result.rows[0]["PtnSname"];
						arr_tbl_comp_col1[comp_line]=result.rows[comp_line]["PaymentCompId"];// arry เก็บคอลัมภ์ PaymenProvinceCodetCompId
						arr_tbl_comp_col2[comp_line]=result.rows[comp_line]["PartnerCode"];// arry เก็บคอลัมภ์ PartnerCode
						arr_tbl_comp_col3[comp_line]=result.rows[comp_line]["CashValue"];// arry เก็บคอลัมภ์ CashValue
						arr_tbl_comp_col4[comp_line]=result.rows[comp_line]["Tax"];// arry เก็บคอลัมภ์ Tax
						arr_tbl_comp_col5[comp_line]=result.rows[comp_line]["TaxW"];// arry เก็บคอลัมภ์ TaxW
						arr_tbl_comp_col6[comp_line]=txt_ans;// arry เก็บคอลัมภ์ ชื่อบริษัท
						arr_tbl_comp_col7[comp_line]=result.rows[comp_line]["TaxIdent"];// arry เก็บคอลัมภ์  เลขผู้เสียภาษี
						arr_tbl_comp_col8[comp_line]=result.rows[comp_line]["AddressDetail"];// arry เก็บคอลัมภ์ ที่อยู่
						arr_tbl_comp_col16[comp_line]=result.rows[comp_line]["Soi"];// arry Soi
						arr_tbl_comp_col17[comp_line]=result.rows[comp_line]["Road"];// arry Road
						arr_tbl_comp_col18[comp_line]=result.rows[comp_line]["ProvinceCode"];// arry ProvinceCode
						arr_tbl_comp_col19[comp_line]=result.rows[comp_line]["DistrictCode"];// arry DistrictCode
						arr_tbl_comp_col20[comp_line]=result.rows[comp_line]["SubDistrictCode"];// arry SubDistrictCode
						arr_tbl_comp_col21[comp_line]=result.rows[comp_line]["PostCode"];// arry SubDistrictCode
						arr_tbl_comp_col22[comp_line]=result.rows[comp_line]["AddressGroupId"];// arry SubDistrictCode
						arr_tbl_comp_col23[comp_line]=result.rows[comp_line]["DetailId"];// arry SubDistrictCode
						arr_tbl_comp_col24[comp_line]=result.rows[comp_line]["ChequeOrCash"];// arry SubDistrictCode
						// ---------ดึงข้อมูล วิธีการจ่ายเงิน-----------
									//alert("debug_cl="+debug_cl);
									JQ.ajax({
									  type: "POST",
									  async: false,
									  url: "?mod=<?php echo LURL::dotPage('financepay_action');?>",	
									  data: "action=PaymentMethods&PaymentCompId="+arr_tbl_comp_col1[debug_cl],
									  success: function(result1){
											//alert("comp_line_loopล่าง1="+comp_line);
											if(result1){
												//alert("tv="+result1.total+"debug_cl="+debug_cl);
												arr_bookbank_line[debug_cl]=result1.total;//  arry จำนวนวฺธีการ
												//alert("comp_line_loopล่าง2="+comp_line);
												//alert("arr_bookbank_line"+comp_line+"="+arr_bookbank_line[comp_line]);
												//alert(result1.total);
												for (list_m = 0;list_m < result1.total;list_m++){
													arr_tbl_comp_col9.push([]);
													arr_tbl_comp_col10.push([]);
													arr_tbl_comp_col11.push([]);
													arr_tbl_comp_col12.push([]);
													arr_tbl_comp_col13.push([]);
													arr_tbl_comp_col14.push([]);
													arr_tbl_comp_col15.push([]);
													arr_tbl_comp_col9[comp_line].push(result1.rows[list_m]["PaymentType"]);//  arry เก็บคอลัมภ์ ชื่อเรื่อง PaymentType
													arr_tbl_comp_col10[comp_line].push(result1.rows[list_m]["BankId"]);//  arry เก็บคอลัมภ์ ชื่อเรื่อง BankId
													arr_tbl_comp_col11[comp_line].push(result1.rows[list_m]["BankName"]);//  arry เก็บคอลัมภ์ ชื่อเรื่อง BankName
													arr_tbl_comp_col12[comp_line].push(result1.rows[list_m]["BookbankId"]);//  arry เก็บคอลัมภ์ ชื่อเรื่อง BookbankId
													arr_tbl_comp_col13[comp_line].push(result1.rows[list_m]["BookbankNumber"]);//  arry เก็บคอลัมภ์ จำนวนเงิน BookbankNumber
													arr_tbl_comp_col14[comp_line].push(result1.rows[list_m]["PaymentNumber"]);//  arry เก็บคอลัมภ์ ชื่อเรื่อง PaymentNumber
													arr_tbl_comp_col15[comp_line].push(result1.rows[list_m]["PaymentValue"]);//  arry เก็บคอลัมภ์ จำนวนเงิน PaymentValue*/
													/*arr_tbl_comp_col9[debug_cl,list_m]=result1.rows[list_m]["PaymentType"];//  arry เก็บคอลัมภ์ รหัสเอกสาร FormCode
													arr_tbl_comp_col10[debug_cl,list_m]=result1.rows[list_m]["BankId"];//  arry เก็บคอลัมภ์ วันที่เอกสาร DocDate
													arr_tbl_comp_col11[debug_cl,list_m]=result1.rows[list_m]["BankName"];//  arry เก็บคอลัมภ์ เลขที่สชน	DocCode
													arr_tbl_comp_col12[debug_cl,list_m]=result1.rows[list_m]["BookbankId"];//  arry เก็บคอลัมภ์ ชื่อเรื่อง Topic
													arr_tbl_comp_col13[debug_cl,list_m]=result1.rows[list_m]["BookbankNumber"];//  arry เก็บคอลัมภ์ จำนวนเงิน Budget
													arr_tbl_comp_col14[debug_cl,list_m]=result1.rows[list_m]["PaymentNumber"];//  arry เก็บคอลัมภ์ ชื่อเรื่อง Topic
													arr_tbl_comp_col15[debug_cl,list_m]=result1.rows[list_m]["PaymentValue"];//  arry เก็บคอลัมภ์ จำนวนเงิน Budget*/
												}
												
											//	create_tblComp();
											}else{
											
											}
											debug_cl++;
									  },
									  dataType: "json"
								});
								
						//-----------------------------------------------
						
					}	
					create_tblComp();
					JQ( "#dialog-company" ).dialog( "open" );	
				}else{
				}
		  },
		  dataType: "json"
	});
	/*---------------ดึงข้อมูล รหัส eform-------------------*/
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('financepay_action');?>",	
		  data: "action=PaymentList&PaymentId="+PaymentId,
		  success: function(result){
				if(result){
					for (list_line = 0;list_line < result.total;list_line++){
						arr_tbl_list_col1[list_line]=result.rows[list_line]["CodeId"];//  arry เก็บคอลัมภ์ รหัส	CodeId
						arr_tbl_list_col2[list_line]=result.rows[list_line]["FormCode"];//  arry เก็บคอลัมภ์ รหัสเอกสาร FormCode
						arr_tbl_list_col3[list_line]=result.rows[list_line]["DocDate"];//  arry เก็บคอลัมภ์ วันที่เอกสาร DocDate
						arr_tbl_list_col4[list_line]=result.rows[list_line]["DocCode"];//  arry เก็บคอลัมภ์ เลขที่สชน	DocCode
						arr_tbl_list_col5[list_line]=result.rows[list_line]["Topic"];//  arry เก็บคอลัมภ์ ชื่อเรื่อง Topic
						arr_tbl_list_col6[list_line]=result.rows[list_line]["Budget"];//  arry เก็บคอลัมภ์ จำนวนเงิน Budget
						
					}
					JQ("#list_line").val(list_line);
					create_tblCodeId();
				}else{
				
				}
		  },
		  dataType: "json"
	});
	
}
JQ(document).ready(function() {
	 
	  /*	var arr_tbl_comp_col14 = [];
		arr_tbl_comp_col14.push([]);
		arr_tbl_comp_col14[0].push("aa");
		arr_tbl_comp_col14[0].push("bb");
		arr_tbl_comp_col14[0].push("cc");
		arr_tbl_comp_col14.push([]);
		arr_tbl_comp_col14[1].push("ee");
		arr_tbl_comp_col14[1].push("ff");
		arr_tbl_comp_col14[1].push("gg");
		//arr_tbl_comp_col14.length = 0;
		alert(arr_tbl_comp_col14[0][0]+arr_tbl_comp_col14[0][1]+arr_tbl_comp_col14[0][2]+arr_tbl_comp_col14[1][0]+arr_tbl_comp_col14[1][1]+arr_tbl_comp_col14[1][2]);*/

	create_tblComp();
	create_tblbookbank();
	JQ("table").tablesorter({
		headers: {
			0: {sorter: false},
			3: {sorter: false},
			4: {sorter: false}
		}
	});
	JQ( "#dialog-company" ).dialog({ // dialog หลัก 
	  resizable: false,
			  autoOpen: false,
			  height:700,
			  width:1080,
			  modal: true,
			  buttons: {
				"บันทึก": function() {
				  Save('adminForm');
				  JQ( this ).dialog( "close" );
				  
				},
				"ปิด": function() {
				  JQ( this ).dialog( "close" );
				}
			  }
	});
	
	JQ( "#dialog-info" ).dialog({ // dialog หลัก เพิ่มบริษัท เลือกผู้จ่ายเงิน
		  resizable: false,
			  autoOpen: false,
			  height:700,
			  width:1080,
			  modal: true,
			  buttons: {
				"เพิ่ม/แก้ไข": function() {
					//alert(JQ('#eNetwork_Label_PartnerCode').html());
					stringValue = JQ('#eNetwork_Label_PartnerCode').html();
					apos =stringValue.search("<a"); //lo w
					txt_ans = stringValue.substring (0,apos); //lo w
					if (JQ( "#chk_mode" ).val() == ""){
						ir = comp_line;
					}else{
						ir = JQ("#chk_mode").val();
					}
					//alert(ir);
					arr_tbl_comp_col1[ir]=JQ("#PaymentCompId").val();// arry เก็บคอลัมภ์ PaymentCompId
					arr_tbl_comp_col2[ir]=JQ("#PartnerCode").val();// arry เก็บคอลัมภ์ PartnerCode
					arr_tbl_comp_col3[ir]=JQ("#CashValue").val();// arry เก็บคอลัมภ์ CashValue
					arr_tbl_comp_col4[ir]=JQ("#Tax").val();// arry เก็บคอลัมภ์ Tax
					arr_tbl_comp_col5[ir]=JQ("#TaxW").val();// arry เก็บคอลัมภ์ TaxW
					arr_tbl_comp_col6[ir]=txt_ans;// arry เก็บคอลัมภ์ ชื่อบริษัท
					arr_tbl_comp_col7[ir]=JQ("#TaxIdent").val();// arry เก็บคอลัมภ์  เลขผู้เสียภาษี
					arr_tbl_comp_col8[ir]=JQ("#AddressDetail").val();// arry เก็บคอลัมภ์ ที่อยู่
					arr_tbl_comp_col16[ir]=JQ("#Soi").val();// arry Soi
					arr_tbl_comp_col17[ir]=JQ("#Road").val();// arry Road
					arr_tbl_comp_col18[ir]=JQ("#ProvinceCode").val();// arry ProvinceCode
					arr_tbl_comp_col19[ir]=JQ("#DistrictCode").val();// arry DistrictCode
					arr_tbl_comp_col20[ir]=JQ("#SubDistrictCode").val();// arry SubDistrictCode
					arr_tbl_comp_col21[ir]=JQ("#PostCode").val();// arry SubDistrictCode
					arr_tbl_comp_col22[ir]=JQ("#AddressGroupId").val();// arry SubDistrictCode
					arr_tbl_comp_col23[ir]=JQ("#DetailId").val();// arry SubDistrictCode
					arr_tbl_comp_col24[ir]=JQ("#ChequeOrCash").val();// arry SubDistrictCode
					arr_bookbank_line[ir]=JQ("#hdd_bookbank_line").val();// arry hdd_bookbank_line
					//alert("bookbank_line="+bookbank_line);
					/*alert("test_00="+arr_tbl_comp_col14[0,0]);
					alert("test_01="+arr_tbl_comp_col14[0,1]);
					alert("test_10="+arr_tbl_comp_col14[1,0]);
					alert("test_11="+arr_tbl_comp_col14[1,1]);*/
					for (qq = 0;qq < JQ("#hdd_bookbank_line").val();qq++){
						arr_tbl_comp_col9.push([]);
						arr_tbl_comp_col10.push([]);
						arr_tbl_comp_col11.push([]);
						arr_tbl_comp_col12.push([]);
						arr_tbl_comp_col13.push([]);
						arr_tbl_comp_col14.push([]);
						arr_tbl_comp_col15.push([]);
						arr_tbl_comp_col9[ir][qq] = JQ("#PaymentType"+qq).val();
						arr_tbl_comp_col10[ir][qq] = JQ("#BankId"+qq).val();
						arr_tbl_comp_col11[ir][qq] = JQ("#BankName"+qq).val();
						arr_tbl_comp_col12[ir][qq] = JQ("#BookbankId"+qq).val();
						arr_tbl_comp_col13[ir][qq] = JQ("#BookbankNumber"+qq).val();
						arr_tbl_comp_col14[ir][qq] = JQ("#PaymentNumber"+qq).val();
						arr_tbl_comp_col15[ir][qq] = JQ("#PaymentValue"+qq).val();
						//alert("ir = "+ir+" PaymentNumber"+arr_tbl_comp_col14[ir][qq]);
					}
					
					if (JQ( "#chk_mode" ).val() == ""){
						comp_line++;
					}
					create_tblComp();
					JQ( this ).dialog( "close" );
					JQ("#btn_info").hide();
				},
				"ปิด": function() {
				  JQ( this ).dialog( "close" );
				}
			  }
			  
	});
	JQ( "#dialog-bank" ).dialog({
			  resizable: false,
			  autoOpen: false,
			  height:300,
			  width:600,
			  modal: true,
			  buttons: {
				"เพิ่ม/แก้ไข": function() {
					if (JQ( "#chk_mode1" ).val() == ""){
						ir = bookbank_line;
					}else{
						ir = JQ("#chk_mode1").val();
					}
					arr_tbl_bookbank_col1[ir]=JQ("#PaymentType").val();// arry เก็บคอลัมภ์ รหัส	PaymentType
					arr_tbl_bookbank_col2[ir]=JQ("#BankId").val();// arry เก็บคอลัมภ์ รหัสเอกสาร BankId
					arr_tbl_bookbank_col3[ir]=JQ("#BankId option:selected").text();// arry เก็บคอลัมภ์ วันที่เอกสาร ชื่อ ธนาคาร
					arr_tbl_bookbank_col4[ir]=JQ("#BookbankId").val();// arry เก็บคอลัมภ์ เลขที่สชน	BookbankId
					arr_tbl_bookbank_col5[ir]=JQ("#BookbankId option:selected").text();// arry เก็บคอลัมภ์ ชื่อเรื่อง เลขที่บัญชี
					arr_tbl_bookbank_col6[ir]=JQ("#PaymentNumber").val();// arry เก็บคอลัมภ์  PaymentNumber
					arr_tbl_bookbank_col7[ir]=JQ("#PaymentValue").val();// arry เก็บคอลัมภ์  PaymentValue

					if (JQ( "#chk_mode1" ).val() == ""){
						bookbank_line++;
					}
					JQ("#btn_bank").hide();
					create_tblbookbank();
					JQ( this ).dialog( "close" );
				},
				"ปิด": function() {
				  JQ( this ).dialog( "close" );
				}
			
			  }
		});
	JQ('input[name="optb"]').click(function() {
		JQ("#AddressGroupId").val(this.value);
		
		PartnerCode = JQ("#PartnerCode").val();// รหัสภาคี
		JQ.ajax({
			  type: "POST",
			  url: "?mod=<?php echo LURL::dotPage('financepay_action');?>",		   
			  data: "action=loadcomp&PartnerCode="+PartnerCode+"&AddressGroupId="+this.value,
			  success: function(result){
					if(result){
						
						JQ("#AddressDetail").val(result.AddressDetail);
						JQ("#DetailId").val(result.DetailId);
						JQ("#Soi").val(result.Soi);
						JQ("#Road").val(result.Road);
						JQ("#ProvinceCode").val(result.ProvinceCode);
						JQ("#DetailId").val(result.DetailId);
						//---------------อำเภอ/เขต------------------------
						actionURL1="?mod=finance.financepay.financepay_action";
						action1="ddldistrict";
						name1="DistrictCode";
						sel1 = result.ProvinceCode;
						selectid = result.DistrictCode;
						JQ.post(actionURL1,{action:action1,id:sel1,name:name1,DistrictCode:selectid},function(html){
								JQ("select:[name="+name1+"]").parent().html(html);
						});
						//---------------ตำบล/แขวง :------------------------
						actionURL2="?mod=finance.financepay.financepay_action";
						action2="ddlsubdistrict"; // ชื่อ case ใน file action
						name2="SubDistrictCode"; // ชื่อ element
						sel2 = result.DistrictCode; // เงื่อนไข
						selectid2 = result.SubDistrictCode; // ให้เลือกรายการไหน
						JQ.post(actionURL2,{action:action2,id:sel2,name:name2,SubDistrictCode:selectid2},function(html){
								JQ("select:[name="+name2+"]").parent().html(html);
						});
						
						JQ("#PostCode").val(result.PostCode);
						JQ("#TaxIdent").val(result.TaxIdent);

					}else{
						JQ("#AddressDetail").val("");
						JQ("#Soi").val("");
						JQ("#Road").val("");
						JQ("#ProvinceCode").val("");
						JQ("#DistrictCode").val("");
						JQ("#SubDistrictCode").val("");
						JQ("#PostCode").val("");
						JQ("#TaxIdent").val("");
					}
			  },
			  dataType: "json"
		});
	 })
	 JQ("#opta1").live('click',function(){
	 	JQ("#PaymentType").val("1");	
	  })
	  JQ("#opta2").live('click',function(){
	 	JQ("#PaymentType").val("2");	
	  })
	JQ("#btn_company").live('click',function(){ // ปุ่ม จ่ายเงินที่หน้าหลัก 
		// arr สร้างตาราง eform
		JQ("#btn_info").show();
		JQ("#btn_bank").show();
		JQ("#divCodeId").html("");
		JQ("#divPaymentPartnerCode").html("");
		JQ("#div_bookbank").html("");
		JQ("#eNetwork_Label_PartnerCode").html("");
		JQ("#AddressDetail").val("");
		JQ("#TaxIdent").val("");
		JQ("#Tax").val("");
		JQ("#TaxW").val("");
		JQ("#CashValue").val("");
		
		JQ(".ele_data").val("");// clear ค่า hidden ต่างๆ
		list_line = 0;
		arr_tbl_comp_col1.length = 0;
		arr_tbl_comp_col2.length = 0;
		arr_tbl_comp_col3.length = 0;
		arr_tbl_comp_col4.length = 0;
		arr_tbl_comp_col5.length = 0;
		arr_tbl_comp_col6.length = 0;
		arr_tbl_comp_col7.length = 0;
		arr_tbl_comp_col8.length = 0;
		arr_tbl_comp_col16.length = 0;
		arr_tbl_comp_col17.length = 0;
		arr_tbl_comp_col18.length = 0;
		arr_tbl_comp_col19.length = 0;
		arr_tbl_comp_col20.length = 0;
		arr_tbl_comp_col21.length = 0;
		arr_tbl_comp_col22.length = 0;
		arr_tbl_comp_col23.length = 0;
		arr_tbl_comp_col24.length = 0;
		arr_bookbank_line.length = 0;
		comp_line = 0;
		arr_tbl_comp_col9.length = 0;
		arr_tbl_comp_col10.length = 0;
		arr_tbl_comp_col11.length = 0;
		arr_tbl_comp_col12.length = 0;
		arr_tbl_comp_col13.length = 0;
		arr_tbl_comp_col14.length = 0;
		arr_tbl_comp_col15.length = 0;
		list_line = 0;
		arr_tbl_list_col1.length = 0;
		arr_tbl_list_col2.length = 0;
		arr_tbl_list_col3.length = 0;
		arr_tbl_list_col4.length = 0;
		arr_tbl_list_col5.length = 0;
		arr_tbl_list_col6.length = 0;
		bookbank_line = 0;
		arr_tbl_bookbank_col1.length = 0;
		arr_tbl_bookbank_col2.length = 0;
		arr_tbl_bookbank_col3.length = 0;
		arr_tbl_bookbank_col4.length = 0;
		arr_tbl_bookbank_col5.length = 0;
		arr_tbl_bookbank_col6.length = 0;
		arr_tbl_bookbank_col7.length = 0;
		//-------------------------
		create_tblCodeId(); // function สร้างตาราง eform
		create_tblComp();
		JQ( "#dialog-company" ).dialog( "open" );			
	 })
	JQ("#btn_info").live('click',function(){ // ปุ่มเพิ่มบริษัท
		
		bookbank_line = 0;
		arr_tbl_bookbank_col1.length = 0;
		arr_tbl_bookbank_col2.length = 0;
		arr_tbl_bookbank_col3.length = 0;
		arr_tbl_bookbank_col4.length = 0;
		arr_tbl_bookbank_col5.length = 0;
		arr_tbl_bookbank_col6.length = 0;
		arr_tbl_bookbank_col7.length = 0;
		create_tblbookbank();
		JQ("#AddressDetail").val("");
		JQ("#Soi").val("");
		JQ("#Road").val("");
		JQ("#ProvinceCode").val("");
		JQ("#DistrictCode").val("");
		JQ("#SubDistrictCode").val("");
		JQ("#PostCode").val("");
		JQ("#TaxIdent").val("");
		JQ("#eNetwork_Label_PartnerCode").html("");
		JQ("#AddressDetail").text("");
		JQ("#TaxIdent").val("");
		JQ("#Tax").val("");
		JQ("#TaxW").val("");
		JQ("#CashValue").val("");
		
		JQ( "#dialog-info" ).dialog( "open" );
		JQ( "#chk_mode" ).val( "" );
	 })
	  JQ("#btn_bank").live('click',function(){  
	  	JQ("#PaymentType").val("");
		JQ("#BankId").val("");
		JQ("#BookbankId").val("");
		JQ("#PaymentNumber").val("");
		JQ("#PaymentValue").val("");
		JQ("#opta1").attr('checked', false);
		JQ("#opta2").attr('checked', false);
		JQ( "#dialog-bank" ).dialog( "open" );
		JQ("#chk_mode1").val("");
	 })
	 /*JQ("#addPhoneRow").live('click',function(){
		JQ("tbody #phone").append(JQ("tbody #phone > tr:last").clone());
		var PhoneNum = JQ("tbody #phone > tr:last").find("[name=PhoneNum]");
		PhoneNum.html(parseInt(PhoneNum.html())+1);
		JQ("tbody #phone > tr:last").find("[name='PhoneId[]'],[name='Phone[]']").val('');
		JQ("tbody #phone > tr:last").find("[name='Phone[]']").mask("9 9999 9999");
		//JQ("tbody #phone > tr:last").find("[name^='PhoneUseStatus']").attr('name',"PhoneUseStatus["+(parseInt(PhoneNum.html())-1)+"]");
		JQ("tbody #phone > tr:last").find(".delete").attr('name','deleteRow[]');
	});*/
});

function create_tblCodeId(){ // สร้างตาราง แสดงรายการ สชน ที่เลือก
		str_tbl = "";
		
		max_val = 0 // จำนวนเงินรวม
			DocCode = 0;
			if (JQ("#PaymentId").val() == ""){ //เพิ่ม+
				JQ('[name=CboCodeId]:checked').each(function() {	// วนสร้าง ตามจำนวนที่เลือก
							
							str_tbl = str_tbl+'<fieldset>';
							str_tbl = str_tbl+'<legend><strong>เลขที่ สช.น '+JQ('#tr'+JQ(this).val()+' td').eq(3).text()+'</strong></legend>';
							
							str_tbl = str_tbl+'<input name="DocCode'+DocCode+'" type="hidden" id="DocCode'+DocCode+'" value = "'+JQ('#tr'+JQ(this).val()+' td').eq(3).text()+'"/>';
								str_tbl = str_tbl+'<table width="100%" border="0" class="tbl-list tablesorter"cellspacing="0">';
								str_tbl = str_tbl+'<thead>';
								str_tbl = str_tbl+'<tr>';
									str_tbl = str_tbl+'<th  align="center" class="no" style="width:300px">รายการ</th>';
									str_tbl = str_tbl+'<th  align="center" >คำอธิบาย</th>';
									str_tbl = str_tbl+'<th  align="center"style="width:170px;" >จำนวนเงินคงเหลือ (บาท)</th>';
									str_tbl = str_tbl+'<th  align="center" style="width:120px;">จำนวนเงิน  (บาท)</th>';
								str_tbl = str_tbl+'</tr>';
								str_tbl = str_tbl+'</thead>';
								str_tbl = str_tbl+'<tbody>';
								// ---------ดึงข้อมูล ค่าใช้จ่าย eform-----------
								JQ.ajax({
								  type: "POST",
								  async: false,
								  url: "?mod=<?php echo LURL::dotPage('financepay_action');?>",	
								  data: "action=findeformdetail&doccode="+JQ('#tr'+JQ(this).val()+' td').eq(3).text()+"&formcode="+JQ('#tr'+JQ(this).val()+' td').eq(1).text(),
								  success: function(result3){
										if(result3){
											for (list_d = 0;list_d < result3.total;list_d++){
												str_tbl = str_tbl+'<tr class="active-row">';
												str_tbl = str_tbl+'<td valign="top" class="left">'+result3.rows[list_d]["itemname"]+'<input name="CostItemCode'+DocCode+'_'+list_d+'" type="hidden" id="CostItemCode'+DocCode+'_'+list_d+'" value = "'+result3.rows[list_d]["CostItemCode"]+'"/></td>';
												str_tbl = str_tbl+'<td align="left" valign="top" class="left">'+result3.rows[list_d]["DetailCost"]+'</td>';
												str_tbl = str_tbl+'<td align="center" valign="top" class="center">'+result3.rows[list_d]["SumCost"]+'</td>';
												str_tbl = str_tbl+'<td align="left" valign="top" class="center"><input name="CastValue'+DocCode+'_'+list_d+'" type="text" id="CastValue'+DocCode+'_'+list_d+'" value = ""/></td>';
												str_tbl = str_tbl+'</tr>';
											}
											}else{
											
											}
									  },
									  dataType: "json"
								});
							//-----------------------------------------------
							
							str_tbl = str_tbl+'</table>';
							str_tbl = str_tbl+'<input name="maxitemdetail" type="hidden" id="maxitemdetail" value = "'+list_d+'"/>';
							str_tbl = str_tbl+'</fieldset>';
							
							DocCode++;
				 });
			}else{ // แก้ไข
				for (xx = 0;xx < JQ("#list_line").val();xx++){
							str_tbl = str_tbl+'<fieldset>';
							str_tbl = str_tbl+'<legend><strong>เลขที่ สช.น '+arr_tbl_list_col3[xx]+'</strong></legend>';
			
							str_tbl = str_tbl+'<input name="DocCode'+DocCode+'" type="hidden" id="DocCode'+DocCode+'" value = "'+arr_tbl_list_col4[xx]+'"/>';
							
								str_tbl = str_tbl+'<table width="100%" border="0" class="tbl-list tablesorter"cellspacing="0">';
								str_tbl = str_tbl+'<thead>';
								str_tbl = str_tbl+'<tr>';
									str_tbl = str_tbl+'<th  align="center" class="no" style="width:300px">รายการ</th>';
									str_tbl = str_tbl+'<th  align="center" >คำอธิบาย</th>';
									str_tbl = str_tbl+'<th  align="center"style="width:170px;" >จำนวนเงินคงเหลือ (บาท)</th>';
									str_tbl = str_tbl+'<th  align="center" style="width:120px;">จำนวนเงิน  (บาท)</th>';
								str_tbl = str_tbl+'</tr>';
								str_tbl = str_tbl+'</thead>';
								str_tbl = str_tbl+'<tbody>';
								// ---------ดึงข้อมูล ค่าใช้จ่าย eform-----------
								JQ.ajax({
								  type: "POST",
								  async: false,
								  url: "?mod=<?php echo LURL::dotPage('financepay_action');?>",	
								  data: "action=findeformdetail&doccode="+arr_tbl_list_col4[xx]+"&formcode="+arr_tbl_list_col2[xx],
								  success: function(result3){
										if(result3){
											for (list_d = 0;list_d < result3.total;list_d++){
												str_tbl = str_tbl+'<tr class="active-row">';
												str_tbl = str_tbl+'<td valign="top" class="left">'+result3.rows[list_d]["itemname"]+'<input name="CostItemCode'+DocCode+'_'+list_d+'" type="hidden" id="CostItemCode'+DocCode+'_'+list_d+'" value = "'+result3.rows[list_d]["CostItemCode"]+'"/></td>';
												str_tbl = str_tbl+'<td align="left" valign="top" class="left">'+result3.rows[list_d]["DetailCost"]+'</td>';
												str_tbl = str_tbl+'<td align="center" valign="top" class="center">'+result3.rows[list_d]["SumCost"]+'</td>';
												// ---------ดึงข้อมูล จำนวนเงินที่จ่าย-----------
												JQ.ajax({
												  type: "POST",
												  async: false,
												  url: "?mod=<?php echo LURL::dotPage('financepay_action');?>",	
												  data: "action=findeformdetailvalue&doccode="+arr_tbl_list_col4[xx]+"&formcode="+arr_tbl_list_col2[xx]+"&costitemcode="+result3.rows[list_d]["CostItemCode"],
												  success: function(result4){
														if(result4){
																str_tbl = str_tbl+'<td align="left" valign="top" class="center"><input name="CastValue'+DocCode+'_'+list_d+'" type="text" id="CastValue'+DocCode+'_'+list_d+'" value = "'+result4.rows[0]["CastValue"]+'"/></td>';
															}else{
															
															}
													  },
													  dataType: "json"
												});
												
											//-----------------------------------------------
												str_tbl = str_tbl+'</tr>';
											}
											}else{
											
											}
									  },
									  dataType: "json"
								});
								
							//-----------------------------------------------
							
							str_tbl = str_tbl+'</table>';
							str_tbl = str_tbl+'<input name="maxitemdetail" type="hidden" id="maxitemdetail" value = "'+list_d+'"/>';
							str_tbl = str_tbl+'</fieldset>';
							/*str_tbl = str_tbl+'<tr class="active-row">';
							str_tbl = str_tbl+'<td valign="top" class="center"><input name="DocCode'+DocCode+'" type="hidden" id="DocCode'+DocCode+'" value = "'+arr_tbl_list_col4[xx]+'"/>'+arr_tbl_list_col1[xx]+'</td>';
							str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+arr_tbl_list_col2[xx]+'</td>';
							str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+arr_tbl_list_col3[xx]+'</td>';
							str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+arr_tbl_list_col4[xx]+'</td>';
							str_tbl = str_tbl+'<td align="left" valign="top" class="left">'+arr_tbl_list_col5[xx]+'</td>';
							c_ans = parseFloat(arr_tbl_list_col6[xx]);
							c_ans = addCommas(c_ans.toFixed(2))
							
							str_tbl = str_tbl+'<td align="right" valign="top" class="right">'+c_ans+'</td>';
							str_tbl = str_tbl+'</tr>';
							//alert(arr_tbl_list_col6[xx]);
							 t1 = arr_tbl_list_col6[xx];
							 v_ans = t1.replace(",","");
							max_val = max_val+parseFloat(v_ans);*/
							DocCode++;
				}
			}
	 		DocCode = DocCode-1
			/*str_tbl = str_tbl+'<tr class="active-row">';
			str_tbl = str_tbl+'<td valign="top" class="center"><input name="MaxDocCode" type="hidden" id="MaxDocCode" value = "'+DocCode+'"/></td>';
			str_tbl = str_tbl+'<td align="left" valign="top" class="center"></td>';
			str_tbl = str_tbl+'<td align="left" valign="top" class="center"></td>';
			str_tbl = str_tbl+'<td align="left" valign="top" class="center"></td>';
			str_tbl = str_tbl+'<td align="left" valign="top" class="right">จำนวนเงินรวม</td>';
			str_tbl = str_tbl+'<td align="right" valign="top" class="right">'+addCommas(max_val.toFixed(2))+'</td>';
			str_tbl = str_tbl+'</tr>';
	 str_tbl = str_tbl+'</tbody>';
	 str_tbl = str_tbl+'</table>';*/
	 str_tbl = str_tbl+'<input name="MaxDocCode" type="hidden" id="MaxDocCode" value = "'+DocCode+'"/>';
	 JQ("#divCodeId").html(str_tbl);
}
function create_tblComp(){ // สร้างตาราง แสดงรายการ บริษัท
		max_txtcash = 0 // จำนวนเงินรวม
		line_zz = 0;
			str_tbl = '<table width="100%" border="0" class="tbl-list tablesorter" cellspacing="0">';
			str_tbl = str_tbl+'<thead>';
			str_tbl = str_tbl+'<tr>';
				str_tbl = str_tbl+'<th  align="center" class="no" style="width:40px">ลำดับ</th>';
				str_tbl = str_tbl+'<th  align="center" style="width:150px;">ชื่อผู้รับเงิน</th>';
				str_tbl = str_tbl+' <th  align="center" style="width:150px;">เลขประจำตัวผู้เสียภาษี</th>';
				str_tbl = str_tbl+'<th  align="center">ที่อยู่</th>';
				str_tbl = str_tbl+'<th align="center" style="width:100px;">จำนวนเงิน (บาท) </th>';
				str_tbl = str_tbl+'<th align="center" style="width:120px;">ปฏิบัติการ</th>';
			str_tbl = str_tbl+'</tr>';
			str_tbl = str_tbl+'</thead>';
		//	alert("สร้างตาราง comp_line = "+comp_line);
			if (comp_line >0){
				for (zz = 0;zz<comp_line;zz++){
					line_zz = zz+1;
					str_tbl = str_tbl+'<tr class="active-row">';
					str_tbl = str_tbl+'<td valign="top" class="center">'+line_zz;
						str_tbl = str_tbl+'<input name="PaymentCompId'+zz+'" type="hidden" id="PaymentCompId'+zz+'" value = "'+arr_tbl_comp_col1[zz]+'"/>';
						str_tbl = str_tbl+'<input name="PartnerCode'+zz+'" type="hidden" id="PartnerCode'+zz+'" value = "'+arr_tbl_comp_col2[zz]+'"/>';
						str_tbl = str_tbl+'<input name="CashValue'+zz+'" type="hidden" id="CashValue'+zz+'" value = "'+arr_tbl_comp_col3[zz]+'"/>';
						str_tbl = str_tbl+'<input name="Tax'+zz+'" type="hidden" id="Tax'+zz+'" value = "'+arr_tbl_comp_col4[zz]+'"/>';
						str_tbl = str_tbl+'<input name="TaxW'+zz+'" type="hidden" id="TaxW'+zz+'" value = "'+arr_tbl_comp_col5[zz]+'"/>';
						
						str_tbl = str_tbl+'<input name="TaxIdent'+zz+'" type="hidden" id="TaxIdent'+zz+'" value = "'+arr_tbl_comp_col7[zz]+'"/>';
						str_tbl = str_tbl+'<input name="PostCode'+zz+'" type="hidden" id="PostCode'+zz+'" value = "'+arr_tbl_comp_col21[zz]+'"/>';
						str_tbl = str_tbl+'<input name="AddressGroupId'+zz+'" type="hidden" id="AddressGroupId'+zz+'" value = "'+arr_tbl_comp_col22[zz]+'"/>';
						str_tbl = str_tbl+'<input name="DetailId'+zz+'" type="hidden" id="DetailId'+zz+'" value = "'+arr_tbl_comp_col23[zz]+'"/>';
						str_tbl = str_tbl+'<input name="ChequeOrCash'+zz+'" type="hidden" id="ChequeOrCash'+zz+'" value = "'+arr_tbl_comp_col24[zz]+'"/>';
						str_tbl = str_tbl+'<input name="AddressDetail'+zz+'" type="hidden" id="AddressDetail'+zz+'" value = "'+arr_tbl_comp_col8[zz]+'"/>';
						str_tbl = str_tbl+'<input name="Soi'+zz+'" type="hidden" id="Soi'+zz+'" value = "'+arr_tbl_comp_col16[zz]+'"/>';
						str_tbl = str_tbl+'<input name="Road'+zz+'" type="hidden" id="Road'+zz+'" value = "'+arr_tbl_comp_col17[zz]+'"/>';
						str_tbl = str_tbl+'<input name="ProvinceCode'+zz+'" type="hidden" id="ProvinceCode'+zz+'" value = "'+arr_tbl_comp_col18[zz]+'"/>';
						str_tbl = str_tbl+'<input name="DistrictCode'+zz+'" type="hidden" id="DistrictCode'+zz+'" value = "'+arr_tbl_comp_col19[zz]+'"/>';
						str_tbl = str_tbl+'<input name="SubDistrictCode'+zz+'" type="hidden" id="SubDistrictCode'+zz+'" value = "'+arr_tbl_comp_col20[zz]+'"/>';
						
						
						str_tbl = str_tbl+'<input name="bookbank_line'+zz+'" type="hidden" id="bookbank_line'+zz+'" value = "'+arr_bookbank_line[zz]+'"/>';
			//			alert("สร้างตาราง bookbank_line="+zz+"="+arr_bookbank_line[zz]);
						//alert("zz="+zz);
						
						for (aa = 0;aa<arr_bookbank_line[zz];aa++){
							//alert("zzinloop="+zz);
							//alert("arr="+arr_tbl_comp_col14[zz][aa])
							
							str_tbl = str_tbl+'<input name="PaymentType'+zz+'_'+aa+'" type="hidden" id="PaymentType'+zz+'_'+aa+'" value = "'+arr_tbl_comp_col9[zz][aa]+'"/>';
							str_tbl = str_tbl+'<input name="BankId'+zz+'_'+aa+'" type="hidden" id="BankId'+zz+'_'+aa+'" value = "'+arr_tbl_comp_col10[zz][aa]+'"/>';
							str_tbl = str_tbl+'<input name="BankName'+zz+'_'+aa+'" type="hidden" id="BankName'+zz+'_'+aa+'" value = "'+arr_tbl_comp_col11[zz][aa]+'"/>';
							str_tbl = str_tbl+'<input name="BookbankId'+zz+'_'+aa+'" type="hidden" id="BookbankId'+zz+'_'+aa+'" value = "'+arr_tbl_comp_col12[zz][aa]+'"/>';
							str_tbl = str_tbl+'<input name="BookbankNumber'+zz+'_'+aa+'" type="hidden" id="BookbankNumber'+zz+'_'+aa+'" value = "'+arr_tbl_comp_col13[zz][aa]+'"/>';
							str_tbl = str_tbl+'<input name="PaymentNumber'+zz+'_'+aa+'" type="hidden" id="PaymentNumber'+zz+'_'+aa+'" value = "'+arr_tbl_comp_col14[zz][aa]+'"/>';
							str_tbl = str_tbl+'<input name="PaymentValue'+zz+'_'+aa+'" type="hidden" id="PaymentValue'+zz+'_'+aa+'" value = "'+arr_tbl_comp_col15[zz][aa]+'"/>';
						}
						
					str_tbl = str_tbl+'</td>';
					str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+arr_tbl_comp_col6[zz]+'</td>';// ชื่อบริษัท
					str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+arr_tbl_comp_col7[zz]+'</td>';// เลขผู้เสียภาษี
					str_tbl = str_tbl+'<td align="left" valign="top" class="left">'+arr_tbl_comp_col8[zz]+'</td>'; //ที่อยู่
				//	alert(arr_tbl_comp_col3[zz]);txtcash
					txtcash = parseFloat(arr_tbl_comp_col3[zz]);
					max_txtcash = parseFloat(max_txtcash)+txtcash;
					txtcash = addCommas(txtcash.toFixed(2));
					str_tbl = str_tbl+'<td align="right" valign="top" class="right">'+txtcash+'</td>';// เงินสด
					str_tbl = str_tbl+'<td align="center" valign="top" class="center">';
						str_tbl = str_tbl+'<a class="ico edit" title="แก้ไข" onclick="edit_comp('+zz+')"><span>แก้ไข</span></a>&nbsp;';
						str_tbl = str_tbl+'<a class="ico delete" title="ลบทิ้ง" onclick="del_comp('+zz+')"><span>ลบทิ้ง</span></a>';
					str_tbl = str_tbl+'</td>';
					str_tbl = str_tbl+'</tr>';
				}
			}else{
				str_tbl = str_tbl+'<tr class="active-row">';
				str_tbl = str_tbl+'<td colspan="6" align="left" valign="top" class="center">ไม่พบข้อมูล</td>'; //ที่อยู่
				str_tbl = str_tbl+'</td>';
				str_tbl = str_tbl+'</tr>';
			}
			
			str_tbl = str_tbl+'<tr class="active-row">';
			str_tbl = str_tbl+' <td height="22" valign="top" class="center">&nbsp;</td>';
			str_tbl = str_tbl+'<td align="left" valign="top" class="center">&nbsp;</td>';
			str_tbl = str_tbl+' <td align="left" valign="top" class="center">&nbsp;</td>';
			str_tbl = str_tbl+' <td  valign="top" class="right">จำนวนเงินรวม</td>';
			str_tbl = str_tbl+' <td align="right" valign="top" class="right">'+addCommas(max_txtcash.toFixed(2));+'</td>';
			str_tbl = str_tbl+'<td align="center" valign="top" class="center">&nbsp;</td>';
			str_tbl = str_tbl+'</tr>';

			str_tbl = str_tbl+'</table>';
			 JQ("#divPaymentPartnerCode").html(str_tbl);
}
function create_tblbookbank(){ // สร้างตาราง แสดงรายการ 
		JQ("#hdd_bookbank_line").val(bookbank_line); // จำนวนวิธีการจ่ายเงิน
		 if (bookbank_line >0){
		 	JQ("#btn_bank").hide();
		 }
		line_zz = 0;
		str_tbl = '<table width="100%" border="0" cellspacing="0">';
               str_tbl = str_tbl+'<thead>';
                 str_tbl = str_tbl+'<tr>';
                   str_tbl = str_tbl+'<th  align="center" class="no" style="width:40px">ลำดับ</th>';
                   str_tbl = str_tbl+'<th  align="center" style="width:200px;">รูปแบบการจ่ายเงิน</th>';
                   str_tbl = str_tbl+'<th  align="center" style="width:200px;">ธนาคาร</th>';
                   str_tbl = str_tbl+'<th  align="center">Payment<br />Number</th>';
                   str_tbl = str_tbl+'<th  align="center"style="width:150px;" >จำนวนเงิน<br />(บาท)</th>';
                   str_tbl = str_tbl+'<th align="center"  width="" style="width:100px;">ปฏิบัติการ</th>';
                 str_tbl = str_tbl+'</tr>';
               str_tbl = str_tbl+'</thead>';
               str_tbl = str_tbl+'<tbody>';
			   if (bookbank_line >0){
			   		txt_PaymentType = "";
					for (zz = 0;zz<bookbank_line;zz++){
						line_zz = zz+1;
						 str_tbl = str_tbl+'<tr class="active-row">';
						  str_tbl = str_tbl+' <td valign="top" class="center">'+line_zz;
						  str_tbl = str_tbl+'<input name="PaymentType'+zz+'" type="hidden" id="PaymentType'+zz+'" value = "'+arr_tbl_bookbank_col1[zz]+'"/>';
						  str_tbl = str_tbl+'<input name="BankId'+zz+'" type="hidden" id="BankId'+zz+'" value = "'+arr_tbl_bookbank_col2[zz]+'"/>';
						  str_tbl = str_tbl+'<input name="BankName'+zz+'" type="hidden" id="BankName'+zz+'" value = "'+arr_tbl_bookbank_col3[zz]+'"/>';
						  str_tbl = str_tbl+'<input name="BookbankId'+zz+'" type="hidden" id="BookbankId'+zz+'" value = "'+arr_tbl_bookbank_col4[zz]+'"/>';
						  str_tbl = str_tbl+'<input name="BookbankNumber'+zz+'" type="hidden" id="BookbankNumber'+zz+'" value = "'+arr_tbl_bookbank_col5[zz]+'"/>';
						  str_tbl = str_tbl+'<input name="PaymentNumber'+zz+'" type="hidden" id="PaymentNumber'+zz+'" value = "'+arr_tbl_bookbank_col6[zz]+'"/>';
						  str_tbl = str_tbl+'<input name="PaymentValue'+zz+'" type="hidden" id="PaymentValue'+zz+'" value = "'+arr_tbl_bookbank_col7[zz]+'"/>';
						  str_tbl = str_tbl+'</td>';
						  if(arr_tbl_bookbank_col1[zz] == 1){
						  	txt_PaymentType = "เงินโอน";
						  }else{
						  	txt_PaymentType = "เช็ค";
						  }
						  
						  	str_tbl = str_tbl+' <td  valign="top" class="center">'+txt_PaymentType+'</td>';
						  	str_tbl = str_tbl+'<td  valign="top" class="center">'+arr_tbl_bookbank_col3[zz]+' '+arr_tbl_bookbank_col5[zz]+' </td>';
						  	str_tbl = str_tbl+'<td  valign="top" class="center">'+arr_tbl_bookbank_col6[zz]+'</td>';
						  	str_tbl = str_tbl+'<td  valign="top" class="center">'+arr_tbl_bookbank_col7[zz]+'</td>';
						  	str_tbl = str_tbl+'<td align="center"  valign="top" nowrap="nowrap">';
						  	str_tbl = str_tbl+'<a class="ico edit" title="แก้ไข" onclick="edit_bookbank('+zz+')"><span>แก้ไข</span></a>&nbsp;';
							str_tbl = str_tbl+'<a class="ico delete" title="ลบทิ้ง" onclick="del_bookbank('+zz+')"><span>ลบทิ้ง</span></a>';
							str_tbl = str_tbl+'</td>';
							 str_tbl = str_tbl+'</tr>';
					 }
				}else{
					str_tbl = str_tbl+'<tr class="active-row">';
					  str_tbl = str_tbl+' <td colspan="6" valign="top" class="center">ไม่พบข้อมูล</td>';
					str_tbl = str_tbl+'</tr>';
				}
               str_tbl = str_tbl+'</tbody>';
           str_tbl = str_tbl+'</table>';
		   JQ("#div_bookbank").html(str_tbl);
}
function edit_comp(zz){ // function ใส่ข้อมูลที่หน้าแก้ไขบริษัท
		arr_tbl_bookbank_col1.length = 0;
		arr_tbl_bookbank_col2.length = 0;
		arr_tbl_bookbank_col3.length = 0;
		arr_tbl_bookbank_col4.length = 0;
		arr_tbl_bookbank_col5.length = 0;
		arr_tbl_bookbank_col6.length = 0;
		arr_tbl_bookbank_col7.length = 0;
		create_tblbookbank();
		JQ("#chk_mode").val(zz);
		JQ("#PaymentCompId").val(arr_tbl_comp_col1[zz]);
		JQ("#PartnerCode").val(arr_tbl_comp_col2[zz]);
		JQ("#CashValue").val(arr_tbl_comp_col3[zz])
		JQ("#Tax").val(arr_tbl_comp_col4[zz])
		JQ("#TaxW").val(arr_tbl_comp_col5[zz])
		
		JQ("#eNetwork_Label_PartnerCode").html(arr_tbl_comp_col6[zz]+'<a class="ico deleteitem" onclick="eNetwork_DelPerson_PartnerCode()" href="javascript:void(0)">ลบทิ้ง</a>')
		
		JQ("#TaxIdent").val(arr_tbl_comp_col7[zz]);
		JQ("#PostCode").val(arr_tbl_comp_col21[zz]);
		JQ("#AddressGroupId").val(arr_tbl_comp_col22[zz]);
		JQ("#DetailId").val(arr_tbl_comp_col23[zz]);
		JQ("#ChequeOrCash").val(arr_tbl_comp_col24[zz]);
		JQ("#AddressDetail").val(arr_tbl_comp_col8[zz]);
		
		JQ("#Soi").val(arr_tbl_comp_col16[zz]);
		JQ("#Road").val(arr_tbl_comp_col17[zz]);
		JQ("#ProvinceCode").val(arr_tbl_comp_col18[zz]);
		JQ("#DistrictCode").val(arr_tbl_comp_col19[zz]);
		JQ("#SubDistrictCode").val(arr_tbl_comp_col20[zz]);
	
		//-------------------สร้าง ตาราง วิธีการจ่ายเงิน--------------------			
			//bookbank_line = arr_bookbank_line[zz];
			bookbank_line = JQ("#bookbank_line"+zz).val();
			for (bb = 0;bb < bookbank_line;bb++){
				/*arr_tbl_bookbank_col1[ir]=arr_tbl_comp_col9[zz,bb];// arry เก็บคอลัมภ์ รหัส	PaymentType
				arr_tbl_bookbank_col2[ir]=arr_tbl_comp_col9[zz,bb];// arry เก็บคอลัมภ์ รหัสเอกสาร BankId
				arr_tbl_bookbank_col3[ir]=arr_tbl_comp_col9[zz,bb];// arry เก็บคอลัมภ์ วันที่เอกสาร ชื่อ ธนาคาร
				arr_tbl_bookbank_col4[ir]=arr_tbl_comp_col9[zz,bb];// arry เก็บคอลัมภ์ เลขที่สชน	BookbankId
				arr_tbl_bookbank_col5[ir]=arr_tbl_comp_col9[zz,bb];// arry เก็บคอลัมภ์ ชื่อเรื่อง เลขที่บัญชี
				arr_tbl_bookbank_col6[ir]=arr_tbl_comp_col9[zz,bb];// arry เก็บคอลัมภ์  PaymentNumber
				arr_tbl_bookbank_col7[ir]=arr_tbl_comp_col9[zz,bb];// arry เก็บคอลัมภ์  PaymentValue*/
				arr_tbl_bookbank_col1[bb]=JQ("#PaymentType"+zz+"_"+bb).val();// arry เก็บคอลัมภ์ รหัส	PaymentType
				arr_tbl_bookbank_col2[bb]=JQ("#BankId"+zz+"_"+bb).val();// arry เก็บคอลัมภ์ รหัสเอกสาร BankId
				arr_tbl_bookbank_col3[bb]=JQ("#BankName"+zz+"_"+bb).val();// arry เก็บคอลัมภ์ วันที่เอกสาร ชื่อ ธนาคาร
				arr_tbl_bookbank_col4[bb]=JQ("#BookbankId"+zz+"_"+bb).val();// arry เก็บคอลัมภ์ เลขที่สชน	BookbankId
				arr_tbl_bookbank_col5[bb]=JQ("#BookbankNumber"+zz+"_"+bb).val();// arry เก็บคอลัมภ์ ชื่อเรื่อง เลขที่บัญชี
				arr_tbl_bookbank_col6[bb]=JQ("#PaymentNumber"+zz+"_"+bb).val();// arry เก็บคอลัมภ์  PaymentNumber
				arr_tbl_bookbank_col7[bb]=JQ("#PaymentValue"+zz+"_"+bb).val();// arry เก็บคอลัมภ์  PaymentValue
			}
			create_tblbookbank();
		//----------------------------------------------------------------------
		JQ( "#dialog-info" ).dialog( "open" );
}
function del_comp(zz){
		comp_line = comp_line-1;
					if (comp_line != 0){
						for (xx = zz;xx<=comp_line;xx++){
							arr_tbl_comp_col1[xx]=arr_tbl_comp_col1[xx+1];// arry เก็บคอลัมภ์ PaymentCompId
							arr_tbl_comp_col2[xx]=arr_tbl_comp_col2[xx+1];// arry เก็บคอลัมภ์ PartnerCode
							arr_tbl_comp_col3[xx]=arr_tbl_comp_col3[xx+1];// arry เก็บคอลัมภ์ CashValue
							arr_tbl_comp_col4[xx]=arr_tbl_comp_col4[xx+1];// arry เก็บคอลัมภ์ Tax
							arr_tbl_comp_col5[xx]=arr_tbl_comp_col5[xx+1]// arry เก็บคอลัมภ์ TaxW
							arr_tbl_comp_col6[xx]=arr_tbl_comp_col6[xx+1];// arry เก็บคอลัมภ์ ชื่อบริษัท
							arr_tbl_comp_col7[xx]=arr_tbl_comp_col7[xx+1];// arry เก็บคอลัมภ์  เลขผู้เสียภาษี
							arr_tbl_comp_col8[xx]=arr_tbl_comp_col8[xx+1];// arry เก็บคอลัมภ์ ที่อยู่
							
							arr_tbl_comp_col16[xx]=arr_tbl_comp_col16[xx+1];// arry เก็บคอลัมภ์ Soi
							arr_tbl_comp_col17[xx]=arr_tbl_comp_col17[xx+1];// arry เก็บคอลัมภ์ Road
							arr_tbl_comp_col18[xx]=arr_tbl_comp_col18[xx+1];// arry เก็บคอลัมภ์ ProvinceCode
							arr_tbl_comp_col19[xx]=arr_tbl_comp_col19[xx+1];// arry เก็บคอลัมภ์ ที่อยู่
							arr_tbl_comp_col20[xx]=arr_tbl_comp_col20[xx+1];// arry เก็บคอลัมภ์ ที่อยู่
							arr_tbl_comp_col21[xx]=arr_tbl_comp_col21[xx+1];// arry เก็บคอลัมภ์ ที่อยู่
							arr_tbl_comp_col22[xx]=arr_tbl_comp_col22[xx+1];// arry เก็บคอลัมภ์ ที่อยู่
							arr_tbl_comp_col23[xx]=arr_tbl_comp_col23[xx+1];// arry เก็บคอลัมภ์ ที่อยู่
							arr_tbl_comp_col24[xx]=arr_tbl_comp_col24[xx+1];// arry เก็บคอลัมภ์ ที่อยู่
						}	
					}else{
						arr_tbl_comp_col1.length = 0;
						arr_tbl_comp_col2.length = 0;
						arr_tbl_comp_col3.length = 0;
						arr_tbl_comp_col4.length = 0;
						arr_tbl_comp_col5.length = 0;
						arr_tbl_comp_col6.length = 0;
						arr_tbl_comp_col7.length = 0;
						arr_tbl_comp_col8.length = 0;
						
						arr_tbl_comp_col16.length = 0;
						arr_tbl_comp_col17.length = 0;
						arr_tbl_comp_col18.length = 0;
						arr_tbl_comp_col19.length = 0;
						arr_tbl_comp_col20.length = 0;
						arr_tbl_comp_col21.length = 0;
						arr_tbl_comp_col22.length = 0;
						arr_tbl_comp_col23.length = 0;
						arr_tbl_comp_col24.length = 0;
					}
					
					create_tblComp();
}

function edit_bookbank(zz){ // function ใส่ข้อมูลหน้า bookbank
		
		JQ("#chk_mode1").val(zz);
		JQ("#PaymentType").val(arr_tbl_bookbank_col1[zz]);
		JQ("#BankId").val(arr_tbl_bookbank_col2[zz]);
		loadBBNumber(arr_tbl_bookbank_col4[zz]);
		
		JQ("#PaymentNumber").val(arr_tbl_bookbank_col6[zz])
		JQ("#PaymentValue").val(arr_tbl_bookbank_col7[zz])
	//	alert(arr_tbl_bookbank_col1[zz]);
		if (arr_tbl_bookbank_col1[zz] == "1"){
			//alert("1");
			JQ("#opta1").attr('checked', true);
			JQ("#opta2").attr('checked', false);
		}else{
		//	alert("2");
			JQ("#opta1").attr('checked', false);
			JQ("#opta2").attr('checked', true);
		}
		JQ( "#dialog-bank" ).dialog( "open" );
		//JQ("#BookbankId").val(arr_tbl_bookbank_col4[zz])
}
function del_bookbank(zz){ // function ลบข้อมูลหน้า bookbank
		bookbank_line = bookbank_line-1;
		if (bookbank_line != 0){
			for (xx = zz;xx<=bookbank_line;xx++){
				arr_tbl_bookbank_col1[xx]=arr_tbl_bookbank_col1[xx+1];// arry เก็บคอลัมภ์ PaymentType
				arr_tbl_bookbank_col2[xx]=arr_tbl_bookbank_col2[xx+1];// arry เก็บคอลัมภ์ BankId
				arr_tbl_bookbank_col3[xx]=arr_tbl_bookbank_col3[xx+1];// arry เก็บคอลัมภ์ ชื่อ ธนาคาร
				arr_tbl_bookbank_col4[xx]=arr_tbl_bookbank_col4[xx+1];// arry เก็บคอลัมภ์ BookbankId
				arr_tbl_bookbank_col5[xx]=arr_tbl_bookbank_col5[xx+1]// arry เก็บคอลัมภ์  เลขที่บัญชี
				arr_tbl_bookbank_col6[xx]=arr_tbl_bookbank_col6[xx+1];// arry เก็บคอลัมภ์ PaymentNumber
				arr_tbl_bookbank_col7[xx]=arr_tbl_bookbank_col7[xx+1];// arry เก็บคอลัมภ์  PaymentValue
			}	
		}else{
			arr_tbl_bookbank_col1.length = 0;
			arr_tbl_bookbank_col2.length = 0;
			arr_tbl_bookbank_col3.length = 0;
			arr_tbl_bookbank_col4.length = 0;
			arr_tbl_bookbank_col5.length = 0;
			arr_tbl_bookbank_col6.length = 0;
			arr_tbl_bookbank_col7.length = 0;
		}
		create_tblbookbank();
}
/* ]]> */

function ValidateForm(f){
	/*if(JQ('#BankName').val() == '' || JQ('#BankName').val() == ' '){
			jAlert('กรุณาระบุชื่อธนาคาร','ระบบตรวจสอบข้อมูล',function(){
				JQ('#BankName').focus();
			});
			return false;
		}*/

		return true;
}

function Save(f){
	if(ValidateForm(f)){	
		JQ("#comp_line").val(comp_line);
		 var action_url = '?mod=finance.financepay.financepay_action';
		 var redirec_url = '?mod=finance.financepay.financepay_list';
		 toSubmit(f,'save',action_url,redirec_url);
	}
}
function loadBBNumber(sel1){
	//sel คือ ค่า select ใช้ตอนแก้ไข
	bankid = JQ("#BankId").val();
	typeid = "";
	JQ.ajax({
		  type: "GET",
		  url: "?mod=<?php echo LURL::dotPage('financepay_action');?>",		   
		  data: "action=loadBBNumber&bankid="+bankid+"&sel1="+sel1,
		  success: function(msg){
			JQ("#bbNumber").html(msg);
		  }
	});

}// end
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
		?> 	
</td>
    <td align="center" valign="top" ><?=$r->CreateDate?></td>
    <td align="center" valign="top" nowrap="nowrap" style="width:60px;"  >
	<a class="ico edit" title="แก้ไข"  onclick="edit_Payment(<?php echo $PaymentId ;?>)">
		<span>แก้ไข</span>
	</a>
	</td>
    <td align="center" valign="top" nowrap="nowrap" style="width:60px;"  >
	<a class="ico delete" title="ลบทิ้ง" onclick="del_Payment(<?php echo $PaymentId ;?>)">
		<span>ลบทิ้ง</span>
	</a>
	</td>
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
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input name="PaymentId" type="hidden" id="PaymentId" class = "ele_data"/>
<input name="PaymentCompId" type="hidden" id="PaymentCompId" class = "ele_data"/>
<input type="hidden" name="action" id="action" value="" class = "ele_data"/>
<input type="hidden" name="comp_line" id="comp_line" value="" class = "ele_data"/>
<input type="hidden" name="list_line" id="list_line" value="" class = "ele_data"/>
	<div id = "divCodeId"></div><!--ตารางรายการสชนที่เลือก-->
  <br>
  <input id="btn_info" name="search23" type="button" value="เพิ่มบริษัท" class="btnActive"  />
   <div id = "divPaymentPartnerCode"></div><!--ตารางบริษัทที่เพิ่ม-->
</form>
  <br>
</div>
<div id="dialog-info"  title="รายละเอียดการจ่ายเงิน">
  <table width="100%" border="0" cellspacing="0">
  	 <tr>
  	   <td class="left">
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td colspan="6">
				<fieldset>
				<legend><strong>รายละเอียดผู้รับเงิน</strong></legend>
					<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
						<tr class="detailUnder">
						  <th width="21%">ชื่อผู้รับเงิน :</th>
						  <td width="1%">&nbsp;</td>
						  <td colspan="4"><?php echo eNetwork(array('name'=>'PartnerCode[]','id'=>'PartnerCode','value'=>'','selecttype'=>'one'));?>  </td>
                                   </tr>
						<tr class="detailUnder">
                          <th>&nbsp;</th>
						  <td>&nbsp;</td>
						  <td colspan="4"><!--<input name="opta" class = "a1" type="radio" value="1" id = "opta1" <?// if ($ReceiveType == "1"){?>checked="checked"<? //}?>/><label class = "a1">เงินสด</label>
							<input name="opta" class = "a2" type="radio" value="2" id = "opta2" <? //if ($ReceiveType == "2"){?>checked="checked"<?// }?>/><label class = "a2">เงินโอน</label>-->
                              <input name="optb" class = "b1" type="radio" value="1" id = "optb1" />
						    ที่บ้าน
						    <input name="optb" class = "b2" type="radio" value="2" id = "optb2" />
						    ที่ทำงาน
						    <input name="optb" class = "b3" type="radio" value="3" id = "optb3" />
						    อื่นๆ
						    <input name="AddressGroupId" type="hidden" id="AddressGroupId" value="<?php //echo $AddressGroupId;?>"/>  
						    <input name="DetailId" type="hidden" id="DetailId" value="<?php //echo DetailId;?>"/>                        </td>
				  </tr>
						<tr>
						  <th style="vertical-align:top;">ที่อยู่ :</th>
						  <td>&nbsp;</td>
						  <td colspan="4">
						  <div style="color:#900">กรุณากรอกข้อมูลที่อยู่ เพื่อระบบสามารถบันทึกรายการส่วนนี้</div>
						  <input type="hidden" name="DetailId" id="DetailId" value="<?php //echo $r->DetailId?>" />
							<input type="hidden" name="AddressGroupId" id="AddressGroupId" value="<?php //echo $AddressGroupId?>" />
							<textarea id="AddressDetail" name="AddressDetail" style="width:99%; height:50px;" ><?php //echo $r->AddressDetail;?></textarea></td>
						</tr>
						<tr>
						  <th>ซอย :</th>
						  <td class="require">&nbsp;</td>
						  <td colspan="4">
							<input name="Soi" type="text" id="Soi" size="45" value="<?php //echo $r->Soi?>" /> <span style="color:#900;">ไม่ต้องกรอกคำว่าซอย เช่น "สุจริต 1"</span></td>
						</tr>
						<tr>
						  <th>ถนน :</th>
						  <td>&nbsp;</td>
						  <td colspan="4"><input name="Road" type="text" id="Road" size="45" value="<?php //echo $r->Road?>" /> <span style="color:#900;">ไม่ต้องกรอกคำว่าถนน เช่น "ประชาราษฎร์บำเพ็ญ"</span></td>
						</tr>
						<tbody id="geo">
					  
						  <tr>
							<th>จังหวัด :</th>
							<td>&nbsp;</td>
							<td width="22%">
								<div id="province"><?php echo DDL::Province($ProvinceCode,$GeoId,"ProvinceCode",'style="width:150px;"','== ทั้งหมด ==')?></div></td>
						    <th width="17%">อำเภอ/เขต :</th>
						    <td width="1%">&nbsp;</td>
						    <td width="38%"><div id="district"><?php echo DDL::District($DistrictCode,'-99999',"DistrictCode",'style="width:150px;"','== ทั้งหมด ==')?></div></td>
						  </tr>
						  <tr>
							<th>ตำบล/แขวง :</th>
							<td>&nbsp;</td>
							<td><div id="subdistrict"><?php echo DDL::SubDistrict($SubDistrictCode,'-99999',"SubDistrictCode",'style="width:150px;"','== ทั้งหมด ==')?></div></td>
						    <th>รหัสไปรณีย์ :</th>
						    <td>&nbsp;</td>
						    <td><input name="PostCode" type="text" id="PostCode" value="<?php //echo $r->PostCode?>" size="10" maxlength="5" /></td>
						  </tr>
						</tbody>
						<!--<tr>
						  <th valign="top">โทรศัพท์ :</th>
						  <td>&nbsp;</td>
						  <td colspan="4"><table width="99%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<th scope="col" style="width:10px; text-align:center">ลำดับ</th>
								<th class="left" style=" width:300px" >หมายเลขโทรศัพท์</th>
								<th scope="col" style="width:100px; text-align:center">ลบทิ้ง</th>
							  </tr>-->
							  <!--<tbody id="phone">
								<?
								/*$Phone_i = 1;
								$Phone = $get->getPhone($PartnerCode,$r->DetailId);
								$stdClass = new stdClass ;
								$stdClass->UseStatus='Y' ;
								$stdClass->Phone=null ;
								$Phone[total]==0?array_push($Phone[rows],$stdClass):null;
									foreach($Phone["rows"] as $rs){*/
							?>
								<tr>
								  <td align="center" style="text-align:center"><span name="PhoneNum">
									<?php //echo $Phone_i++?>1
									</span>.
								</td>
								  <td align="center">
								  <input name="Phone[]" type="text" id="Phone[]" size="30" value="<?php //echo $rs->Phone?>" />
									ต่อ
								  <input name="ExtendPhone[]" type="text" id="ExtendPhone[]" size="10" value="<?php //echo $rs->Extend?>" />
								  
								  <input type="hidden" name="PhoneId[]" id="PhoneId[]" value="<?php //echo $rs->PhoneId;unset($PhoneId)?>" />
								  </td>
								  <td style="text-align:center"><span class="ico delete" style="width:35px; padding-left:20px" <?php //if($_GET["id"]!="") echo 'name="deleteRow[]"';?> table="nh_in_phone" ><a href="" onclick="return false;">ลบทิ้ง</a></span></td>
								</tr>
								<?
								//	}
							?>
							  </tbody> 
							  <tr> -->
								<script type="text/javascript">
								
								
								
								/*JQ("[name='deleteRow_<?php //echo $AddressGroupId?>[]']").live('click',function(){
										JQ(this).parent().parent().remove();
								});*/
								
							</script>
								<!--<td style="text-align:center">&nbsp;</td>
								<td style="text-align:center">&nbsp;</td>
								<td style="text-align:center"><input type="button" class="add" name="addPhoneRow" id="addPhoneRow" value="เพิ่มรายการ" /></td>
							  </tr>
							</table></td>
						</tr>-->
						<tr>
						  <th valign="top">เลขประจำตัวผู้เสียภาษี :</th>
						  <td>&nbsp;</td>
						  <td colspan="4"><input id="TaxIdent" name="TaxIdent" type="text"  size="25" value="<?php //echo $r->TaxIdent?>" /></td>
					  </tr>
				  </table>
				  </fieldset>
			    </td>
			  </tr>
	    </table>
		<fieldset>
		<legend><strong>วิธีการจ่ายชำระเงิน</strong></legend>
	   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-view">
         <tr>
           <th width="21%">ภาษีมูลค่าเพิ่ม
		   <input name="chk_mode" type="hidden" id="chk_mode"/><!--ใช้เช็ค mode ว่า เพิ่มหรือแก้ไข บริษัท value คือ id ที่เลือก-->
             <input name="chk_mode1" type="hidden" id="chk_mode1"/><!--ใช้เช็ค mode ว่า เพิ่มหรือแก้ไข bookbank value คือ id ที่เลือก-->
			 <input name="hdd_bookbank_line" type="hidden" id="hdd_bookbank_line"/><!--จำนวนวิธีการจ่ายเงิน เริ่มจาก1-->
            <!--ค่าว่าง เพิ่ม ถ้ามีค่าเป็นตัวเลขเป็นแก้ไข--></th>
           <td width="1%">&nbsp;</td>
           <td width="23%"><select name="Tax" id="Tax">
             <option value="" selected="selected">-</option>
             <option value="7">7</option>
             <option value="10" >10</option>
           </select>
%</td>
           <th width="17%">ภาษีหัก ณ ที่จ่าย</th>
           <td width="1%">&nbsp;</td>
           <td width="37%" style="text-align:left"><select name="TaxW" id="TaxW">
             <option selected="selected" >-</option>
             <option value="1">1</option>
             <option value="3">3</option>
             <option value="5">5</option>
           </select>
%</td>
         </tr>
         <tr>
           <th >รูปแบบการจ่ายเงิน</th>
           <td><!--<input name="TaxW" type="text" id="TaxW" size="5" maxlength="5" />--></td>
           <td colspan="4" style="text-align:left"><input name="optc" class = "a1" type="radio" value="1" id = "radio" />
           เงินโอน/เช็ค
             <input name="optc" class = "a1" type="radio" value="2" id = "radio2" />
เงินสด 
  <input name="CashValue" id = "CashValue" type="text" />
บาท
<input name="ChequeOrCash" type="hidden" id="ChequeOrCash" value=""/></td>
          </tr>
         <tr>
           <td colspan="6">
		   <input id="btn_bank" name="search232" type="button" value="เพิ่มข้อมูล เงินโอน/เช็ค" class="btnActive" />
		  </br> <div id = "div_bookbank"></div><!--ตารางวิธีการจ่ายเงิน--></td>
         </tr>
       </table>
	    </fieldset>
	   </td>
    </tr>
  </table>
 
</div>

<div id="dialog-bank"  title="เงินโอน/เช็ค">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-view">
    <tr>
      <td>รูปแบบการจ่ายเงิน</td>
      <td><input name="opta" class = "a1" type="radio" value="1" id = "opta1" />
        เงินโอน
          <input name="opta" class = "a2" type="radio" value="2" id = "opta2" />
        เช็ค
        <input name="PaymentType" type="hidden" id="PaymentType" value=""/></td>
    </tr>
    <tr>
      <td width="35%">ธนาคาร</td>
      <td width="65%"><?php 
  		$tag_attribs = 'onchange="loadBBNumber();" style="width:180px"';
		echo $get->getBankNameSelect("BankId",$tag_attribs,$BankId,"-");//$tag_name,$tag_attribs,$selected,$lebel
	?>
      </td>
    </tr>
	 <tr>
      <td>&nbsp;&nbsp;&nbsp;เลขที่บัญชี</td>
      <td> <div id="bbNumber"><?php
  		$tag_attribs = 'onchange="" style="width:180px"';
		echo $get->getBookbankNumber("BookbankId",$tag_attribs,$BookbankId,"-",$BankId);//$tag_name,$tag_attribs,$selected,$lebel
	?></div> </td>
    </tr>
    <tr>
      <td>Payment Number /เลขที่เช็ค </td>
      <td><input name="PaymentNumber" type="text" id="PaymentNumber" /></td>
    </tr>
    <tr>
      <td>จำนวนเงิน</td>
      <td><input name="PaymentValue" type="text" id="PaymentValue" />
        บาท</td>
    </tr>
  </table>
  
</div>