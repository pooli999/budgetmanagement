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
/* <![CDATA[ */
var comp_line = 0;
var arr_tbl_comp_col1 = []; // arry เก็บคอลัมภ์ PaymentCompId
var arr_tbl_comp_col2 = []; // arry เก็บคอลัมภ์ CompID
var arr_tbl_comp_col3 = []; // arry เก็บคอลัมภ์ CashValue
var arr_tbl_comp_col4 = []; // arry เก็บคอลัมภ์ Tax
var arr_tbl_comp_col5 = []; // arry เก็บคอลัมภ์ TaxW
var arr_tbl_comp_col6 = []; // arry เก็บคอลัมภ์ ชื่อบริษัท
var arr_tbl_comp_col7 = []; // arry เก็บคอลัมภ์ เลขผู้เสียภาษี
var arr_tbl_comp_col8 = []; // arry เก็บคอลัมภ์ ที่อยู่
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
function edit_Payment(PaymentId){ // ปุ่มแก้ไข การจ่ายเงิน
	JQ("#div_bookbank").html("");
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
						TaxIdent = result.rows[comp_line]["TaxIdent"];
						if (TaxIdent == null){TaxIdent = "-";}
						txt_AddressDetail = result.rows[comp_line]["AddressDetail"]+" ซอย "+result.rows[comp_line]["Soi"]+" ถนน "+result.rows[comp_line]["Road"]+" แขวง  "+result.rows[comp_line]["DistrictCode"]+" เขต "+result.rows[comp_line]["SubDistrictCode"]+" จังหวัด "+result.rows[comp_line]["ProvinceCode"];
						if (txt_AddressDetail == ""){txt_AddressDetail = "-";}
						txt_ans = result.rows[comp_line]["PtnPrefixTH"]+result.rows[comp_line]["PtnFname"]+" "+result.rows[0]["PtnSname"];
						arr_tbl_comp_col1[comp_line]=result.rows[comp_line]["PaymentCompId"];// arry เก็บคอลัมภ์ PaymenProvinceCodetCompId
						arr_tbl_comp_col2[comp_line]=result.rows[comp_line]["PartnerCode"];// arry เก็บคอลัมภ์ PartnerCode
						arr_tbl_comp_col3[comp_line]=result.rows[comp_line]["CashValue"];// arry เก็บคอลัมภ์ CashValue
						arr_tbl_comp_col4[comp_line]=result.rows[comp_line]["Tax"];// arry เก็บคอลัมภ์ Tax
						arr_tbl_comp_col5[comp_line]=result.rows[comp_line]["TaxW"];// arry เก็บคอลัมภ์ TaxW
						arr_tbl_comp_col6[comp_line]=txt_ans;// arry เก็บคอลัมภ์ ชื่อบริษัท
						arr_tbl_comp_col7[comp_line]=TaxIdent;// arry เก็บคอลัมภ์  เลขผู้เสียภาษี
						arr_tbl_comp_col8[comp_line]=txt_AddressDetail;// arry เก็บคอลัมภ์ ที่อยู่
				
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
												
												for (list_m = 0;list_m < result1.total;list_m++){
													
													arr_tbl_comp_col9[debug_cl,list_m]=result1.rows[list_m]["PaymentType"];//  arry เก็บคอลัมภ์ รหัสเอกสาร FormCode
													arr_tbl_comp_col10[debug_cl,list_m]=result1.rows[list_m]["BankId"];//  arry เก็บคอลัมภ์ วันที่เอกสาร DocDate
													arr_tbl_comp_col11[debug_cl,list_m]=result1.rows[list_m]["BankName"];//  arry เก็บคอลัมภ์ เลขที่สชน	DocCode
													arr_tbl_comp_col12[debug_cl,list_m]=result1.rows[list_m]["BookbankId"];//  arry เก็บคอลัมภ์ ชื่อเรื่อง Topic
													arr_tbl_comp_col13[debug_cl,list_m]=result1.rows[list_m]["BookbankNumber"];//  arry เก็บคอลัมภ์ จำนวนเงิน Budget
													arr_tbl_comp_col14[debug_cl,list_m]=result1.rows[list_m]["PaymentNumber"];//  arry เก็บคอลัมภ์ ชื่อเรื่อง Topic
													arr_tbl_comp_col15[debug_cl,list_m]=result1.rows[list_m]["PaymentValue"];//  arry เก็บคอลัมภ์ จำนวนเงิน Budget
												//	alert("BankName"+list_m+"="+arr_tbl_comp_col11[comp_line,list_m]);
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
			  height:600,
			  width:900,
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
			  height:600,
			  width:800,
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
					arr_tbl_comp_col1[ir]=JQ("#PaymentCompId").val();// arry เก็บคอลัมภ์ PaymentCompId
					arr_tbl_comp_col2[ir]=JQ("#PartnerCode").val();// arry เก็บคอลัมภ์ PartnerCode
					arr_tbl_comp_col3[ir]=JQ("#CashValue").val();// arry เก็บคอลัมภ์ CashValue
					arr_tbl_comp_col4[ir]=JQ("#Tax").val();// arry เก็บคอลัมภ์ Tax
					arr_tbl_comp_col5[ir]=JQ("#TaxW").val();// arry เก็บคอลัมภ์ TaxW
					arr_tbl_comp_col6[ir]=txt_ans;// arry เก็บคอลัมภ์ ชื่อบริษัท
					arr_tbl_comp_col7[ir]=JQ("#TaxIdent").text();// arry เก็บคอลัมภ์  เลขผู้เสียภาษี
					arr_tbl_comp_col8[ir]=JQ("#AddressDetail").text();// arry เก็บคอลัมภ์ ที่อยู่
					arr_bookbank_line[ir]=JQ("#hdd_bookbank_line").val();// arry เก็บคอลัมภ์ จำนวนวิธีจ่ายเงิน เริ่มจาก1
					//alert("bookbank_line="+bookbank_line);
					for (zz = 0;zz < JQ("#hdd_bookbank_line").val();zz++){
						arr_tbl_comp_col9[ir,zz] = JQ("#PaymentType"+zz).val();
						arr_tbl_comp_col10[ir,zz] = JQ("#BankId"+zz).val();
						arr_tbl_comp_col11[ir,zz] = JQ("#BankName"+zz).val();
						arr_tbl_comp_col12[ir,zz] = JQ("#BookbankId"+zz).val();
						arr_tbl_comp_col13[ir,zz] = JQ("#BookbankNumber"+zz).val();
						arr_tbl_comp_col14[ir,zz] = JQ("#PaymentNumber"+zz).val();
						arr_tbl_comp_col15[ir,zz] = JQ("#PaymentValue"+zz).val();
					}
					
					if (JQ( "#chk_mode" ).val() == ""){
						comp_line++;
					}
					create_tblComp();
					JQ( this ).dialog( "close" );
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
					
					create_tblbookbank();
					JQ( this ).dialog( "close" );
				},
				"ปิด": function() {
				  JQ( this ).dialog( "close" );
				}
			
			  }
		});
	JQ("#CashValue").live('click',function(){  // กดจำนวนเงินแล้วหาชื่อที่อยู่ภาคี
		PartnerCode = JQ("#PartnerCode").val();// รหัสภาคี
		JQ.ajax({
			  type: "POST",
			  url: "?mod=<?php echo LURL::dotPage('financepay_action');?>",		   
			  data: "action=loadcomp&PartnerCode="+PartnerCode,
			  success: function(result){
					if(result){
						if (result.TaxIdent == ""){txtTaxIdent = "-";}else{txtTaxIdent=result.TaxIdent}
						JQ("#TaxIdent").text(txtTaxIdent);
						txt_AddressDetail = result.AddressDetail+" ซอย "+result.Soi+" ถนน "+result.Road+" แขวง  "+result.DistrictCode+" เขต "+result.SubDistrictCode+" จังหวัด "+result.ProvinceCode 	;
						if (txt_AddressDetail == ""){txt_AddressDetail = "-";}
						JQ("#AddressDetail").text(txt_AddressDetail);
					}else{
					
					}
			  },
			  dataType: "json"
		});
	 })
	JQ("#btn_company").live('click',function(){ // ปุ่ม จ่ายเงินที่หน้าหลัก 
		// arr สร้างตาราง eform
		JQ("#divCodeId").html("");
		JQ("#divPaymentPartnerCode").html("");
		JQ("#div_bookbank").html("");
		JQ(".ele_data").val("");// clear ค่า hidden ต่างๆ
		list_line = 0;
		arr_tbl_comp_col1.length = 0;
		arr_tbl_comp_col2.length = 0;
		arr_tbl_comp_col3.length = 0;
		arr_tbl_comp_col4.length = 0;
		arr_tbl_comp_col5.length = 0;
		arr_tbl_comp_col6.length = 0;
		//-------------------------
		create_tblCodeId(); // function สร้างตาราง eform
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
		JQ( "#dialog-info" ).dialog( "open" );
		JQ( "#chk_mode" ).val( "" );
	 })
	  JQ("#btn_bank").live('click',function(){  
		JQ( "#dialog-bank" ).dialog( "open" );
		JQ("#chk_mode1").val("");
	 })
	 
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
			DocCode = 0;
			if (JQ("#PaymentId").val() == ""){ //เพิ่ม+
				JQ('[name=CboCodeId]:checked').each(function() {	// วนสร้าง ตามจำนวนที่เลือก
							str_tbl = str_tbl+'<tr class="active-row">';
							str_tbl = str_tbl+'<td valign="top" class="center"><input name="DocCode'+DocCode+'" type="text" id="DocCode'+DocCode+'" value = "'+JQ('#tr'+JQ(this).val()+' td').eq(3).text()+'"/>'+JQ('#tr'+JQ(this).val()+' td').eq(0).text()+'</td>';
							str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+JQ('#tr'+JQ(this).val()+' td').eq(1).text()+'</td>';
							str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+JQ('#tr'+JQ(this).val()+' td').eq(2).text()+'</td>';
							str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+JQ('#tr'+JQ(this).val()+' td').eq(3).text()+'</td>';
							str_tbl = str_tbl+'<td align="left" valign="top" class="left">'+JQ('#tr'+JQ(this).val()+' td').eq(4).text()+'</td>';
							str_tbl = str_tbl+'<td align="right" valign="top" class="right">'+JQ('#tr'+JQ(this).val()+' td').eq(5).text()+'</td>';
							str_tbl = str_tbl+'</tr>';
							 t1 = JQ('#tr'+JQ(this).val()+' td').eq(5).text();
							 v_ans = t1.replace(",","");
							max_val = max_val+parseFloat(v_ans);
							DocCode++;
				 });
			}else{ // แก้ไข
				for (xx = 0;xx < JQ("#list_line").val();xx++){
							str_tbl = str_tbl+'<tr class="active-row">';
							str_tbl = str_tbl+'<td valign="top" class="center"><input name="DocCode'+DocCode+'" type="text" id="DocCode'+DocCode+'" value = "'+arr_tbl_list_col4[xx]+'"/>'+arr_tbl_list_col1[xx]+'</td>';
							str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+arr_tbl_list_col2[xx]+'</td>';
							str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+arr_tbl_list_col3[xx]+'</td>';
							str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+arr_tbl_list_col4[xx]+'</td>';
							str_tbl = str_tbl+'<td align="left" valign="top" class="left">'+arr_tbl_list_col5[xx]+'</td>';
							str_tbl = str_tbl+'<td align="right" valign="top" class="right">'+arr_tbl_list_col6[xx]+'</td>';
							str_tbl = str_tbl+'</tr>';
							//alert(arr_tbl_list_col6[xx]);
							 t1 = arr_tbl_list_col6[xx];
							 v_ans = t1.replace(",","");
							max_val = max_val+parseFloat(v_ans);
							DocCode++;
				}
			}
	 		DocCode = DocCode-1
			 str_tbl = str_tbl+'<tr class="active-row">';
			str_tbl = str_tbl+'<td valign="top" class="center"><input name="MaxDocCode" type="text" id="MaxDocCode" value = "'+DocCode+'"/></td>';
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
function create_tblComp(){ // สร้างตาราง แสดงรายการ บริษัท
		max_txtcash = 0 // จำนวนเงินรวม
		line_zz = 0;
			str_tbl = '<table width="100%" border="0" class="tbl-list tablesorter" cellspacing="0">';
			str_tbl = str_tbl+'<thead>';
			str_tbl = str_tbl+'<tr>';
				str_tbl = str_tbl+'<th  align="center" class="no" style="width:40px">ลำดับ</th>';
				str_tbl = str_tbl+'<th  align="center" style="width:150px;">ชื่อผู้รับเงิน</th>';
				str_tbl = str_tbl+' <th  align="center" style="width:170px;">เลขประจำตัวผู้เสียภาษี</th>';
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
						
						str_tbl = str_tbl+'<input name="bookbank_line'+zz+'" type="hidden" id="bookbank_line'+zz+'" value = "'+arr_bookbank_line[zz]+'"/>';
			//			alert("สร้างตาราง bookbank_line="+zz+"="+arr_bookbank_line[zz]);
						alert("zz="+zz);
						for (aa = 0;aa<arr_bookbank_line[zz];aa++){
							
							str_tbl = str_tbl+'<input name="PaymentType'+zz+'_'+aa+'" type="hidden" id="PaymentType'+zz+'_'+aa+'" value = "'+arr_tbl_comp_col9[zz,aa]+'"/>';
							str_tbl = str_tbl+'<input name="BankId'+zz+'_'+aa+'" type="hidden" id="BankId'+zz+'_'+aa+'" value = "'+arr_tbl_comp_col10[zz,aa]+'"/>';
							str_tbl = str_tbl+'<input name="BankName'+zz+'_'+aa+'" type="hidden" id="BankName'+zz+'_'+aa+'" value = "'+arr_tbl_comp_col11[zz,aa]+'"/>';
							str_tbl = str_tbl+'<input name="BookbankId'+zz+'_'+aa+'" type="hidden" id="BookbankId'+zz+'_'+aa+'" value = "'+arr_tbl_comp_col12[zz,aa]+'"/>';
							str_tbl = str_tbl+'<input name="BookbankNumber'+zz+'_'+aa+'" type="hidden" id="BookbankNumber'+zz+'_'+aa+'" value = "'+arr_tbl_comp_col13[zz,aa]+'"/>';
							str_tbl = str_tbl+'<input name="PaymentNumber'+zz+'_'+aa+'" type="hidden" id="PaymentNumber'+zz+'_'+aa+'" value = "'+arr_tbl_comp_col14[zz,aa]+'"/>';
							str_tbl = str_tbl+'<input name="PaymentValue'+zz+'_'+aa+'" type="hidden" id="PaymentValue'+zz+'_'+aa+'" value = "'+arr_tbl_comp_col15[zz,aa]+'"/>';
						}
						
					str_tbl = str_tbl+'</td>';
					str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+arr_tbl_comp_col6[zz]+'</td>';// ชื่อบริษัท
					str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+arr_tbl_comp_col7[zz]+'</td>';// เลขผู้เสียภาษี
					str_tbl = str_tbl+'<td align="left" valign="top" class="center">'+arr_tbl_comp_col8[zz]+'</td>'; //ที่อยู่
				//	alert(arr_tbl_comp_col3[zz]);txtcash
					txtcash = parseFloat(arr_tbl_comp_col3[zz]);
					max_txtcash = parseFloat(max_txtcash)+txtcash;
					txtcash = addCommas(txtcash.toFixed(2));
					str_tbl = str_tbl+'<td align="right" valign="top" class="right">'+txtcash+'</td>';// เงินสด
					str_tbl = str_tbl+'<td align="center" valign="top" class="center">';
						str_tbl = str_tbl+'<a class="ico edit" title="แก้ไข" onclick="edit_comp('+zz+')"><span>แก้ไข</span></a>';
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
						  	str_tbl = str_tbl+'<a class="ico edit" title="แก้ไข" onclick="edit_bookbank('+zz+')"><span>แก้ไข</span></a>';
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
		
		JQ("#TaxIdent").text(arr_tbl_comp_col7[zz]);
		JQ("#AddressDetail").text(arr_tbl_comp_col8[zz])
	
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
					}
					
					create_tblComp();
}

function edit_bookbank(zz){ // function ใส่ข้อมูลหน้า bookbank
		JQ("#chk_mode1").val(zz);
		JQ("#PaymentType").val(arr_tbl_bookbank_col1 [zz]);
		JQ("#BankId").val(arr_tbl_bookbank_col2 [zz]);
		JQ("#BookbankId").val(arr_tbl_bookbank_col4 [zz])
		JQ("#PaymentNumber").val(arr_tbl_bookbank_col6[zz])
		JQ("#PaymentValue").val(arr_tbl_bookbank_col7	[zz])
		JQ( "#dialog-bank" ).dialog( "open" );
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
<input name="PaymentId" type="text" id="PaymentId" class = "ele_data"/>
<input name="PaymentCompId" type="text" id="PaymentCompId" class = "ele_data"/>
<input type="text" name="action" id="action" value="" class = "ele_data"/>
<input type="text" name="comp_line" id="comp_line" value="" class = "ele_data"/>
<input type="text" name="list_line" id="list_line" value="" class = "ele_data"/>
	<div id = "divCodeId"></div><!--ตารางรายการสชนที่เลือก-->
  <br>
  <input id="btn_info" name="search23" type="button" value="เพิ่มบริษัท" class="btnActive"  />
   <div id = "divPaymentPartnerCode"></div><!--ตารางบริษัทที่เพิ่ม-->
</form>
  <br>
</div>

<div id="dialog-info"  title="รายละเอียดการจ่ายเงิน">
  <table width="100%" border="0" cellspacing="0" class="tbl-list tablesorter">
  	 <tr>
        <td class="left">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list tablesorter">
			  <tr>
				<td width="11%">ชื่อผู้รับเงิน</td>
				<td width="35%">
			    <?php echo eNetwork(array('name'=>'PartnerCode[]','id'=>'PartnerCode','value'=>'','selecttype'=>'one'));?></td>
			    <td width="16%">เลขประจำตัวผู้เสียภาษี</td>
			    <td width="38%">
				<label id = "TaxIdent" name = "TaxIdent"></label>
				</td>
			  </tr>
			  <tr>
				<td>ที่อยู่</td>
				<td><label id = "AddressDetail" name = "AddressDetail"></label></td>
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
           <td height="30" colspan="2" bgcolor="#999999" style="color:#CCCCCC"><span class="style2">วิธีการจ่ายชำระเงิน</span> 
		   <input name="chk_mode" type="text" id="chk_mode"/><!--ใช้เช็ค mode ว่า เพิ่มหรือแก้ไข บริษัท value คือ id ที่เลือก-->
             <input name="chk_mode1" type="text" id="chk_mode1"/><!--ใช้เช็ค mode ว่า เพิ่มหรือแก้ไข bookbank value คือ id ที่เลือก-->
			 <input name="hdd_bookbank_line" type="text" id="hdd_bookbank_line"/><!--จำนวนวิธีการจ่ายเงิน เริ่มจาก1-->
            <!--ค่าว่าง เพิ่ม ถ้ามีค่าเป็นตัวเลขเป็นแก้ไข--></td>
         </tr>
         <tr>
           <td width="21%">ภาษีหัก ณ ที่จ่าย</td>
           <td><input name="TaxW" type="text" id="TaxW" size="5" maxlength="5" />
           %
			
			</td>
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
           <td colspan="2">
		   
		   <div id = "div_bookbank"></div><!--ตารางวิธีการจ่ายเงิน-->
		   </td>
         </tr>
       </table></td>
    </tr>
  </table>
</div>

<div id="dialog-bank"  title="เงินโอน/เช็ค">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-list tablesorter">
    <tr>
      <td>รูปแบบการจ่ายเงิน</td>
      <td><input name="opta" class = "a1" type="radio" value="1" id = "opta1" <? if ($ReceiveType == "1"){?>checked="checked"<? }?>/>
        เงินโอน
          <input name="opta" class = "a2" type="radio" value="2" id = "opta2" <? if ($ReceiveType == "2"){?>checked="checked"<? }?>/>
        เช็ค
        <input name="PaymentType" type="hidden" id="PaymentType" value="1"/></td>
    </tr>
    <tr>
      <td width="35%">ธนาคาร/เลขที่บัญชี</td>
      <td width="65%"><select name="BankId" id="BankId">
          <option selected="selected">-</option>
          <option value="7">กรุงเทพ</option>
        </select>
        /
        <select name="BookbankId" id="BookbankId">
  <option selected="selected">-</option>
  <option value="1">1234-8775-47</option>
  <option value="45">7854-8524-77</option>
</select></td>
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