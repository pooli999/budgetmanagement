<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setPathWays(array(
	array(
		'text' => 'จัดการข้อมูลพื้นฐาน',
		'link' => '?mod=budget.init.startup',
	),
	
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'เพิ่ม'.$MenuName
	),
));


?>
<script language="javascript" type="text/javascript">

/* <![CDATA[ */

function ValidateForm(f){
	
		if(JQ('#BankId').val() == '' || JQ('#Branch').val() == '' || JQ('#BookbankTypeId').val() == '' || JQ('#BookbankNumber').val() == ''){
			jAlert('กรุณาระบุขเอมูลที่จำเป็น(ดาวแดง)','ระบบตรวจสอบข้อมูล',function(){
				JQ('#BankName').focus();
			});
			return false;
		}

		return true;
}


function Save(f){
	if(ValidateForm(f)){	
		 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		 var redirec_url = '?mod=<?php echo LURL::dotPage($listPage);?>';
		 toSubmit(f,'save',action_url,redirec_url);
	}
}

/*function Confirm(f){
	if(ValidateForm(f)){		
		var firm_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		toConfirm(f,'confirm',firm_url);
	}
	
}*/
 

/*  ]]> */

function loadBBNumber(){//alert(LPlanCode);
	bankid = JQ("#BankId").val();
	typeid = JQ("#BookbankTypeId").val();
	JQ.ajax({
		  type: "GET",
		  url: "?mod=<?php echo LURL::dotPage('deposit_action');?>",		   
		  data: "action=loadBBNumber&bankid="+bankid+"&typeid="+typeid,
		  success: function(msg){
			JQ("#bbNumber").html(msg);
		  }
	});

}// end

function loadIncomeDetail(rowi){
	IncomeId = JQ("#IncomeId"+rowi).val();
	JQ.ajax({
		  type: "POST",
		  url: "?mod=<?php echo LURL::dotPage('deposit_action');?>",		   
		  data: "action=loadincomedetail&IncomeId="+IncomeId,
		  success: function(result){
		  		if(result){
					rt = result.ReceiveType;
					if(rt==1){
						receiveType = "เงินสด";
					}
					if(rt==3){
						receiveType = "เช็ค";
					}
					JQ("#ReceiveType"+rowi).html(receiveType);
					
					JQ("#Payname"+rowi).html(result.PayName);
					
					ict = result.IncomeType;
					if(ict==1){
						IncomeType = "เงินประกันสัญญา";
					}
					if(ict==2){
						IncomeType = "คืนเงินข้อตกลง";
					}
					if(ict==3){
						IncomeType = "ดอกเบี้ยรับ";
					}
					JQ("#IncomeType"+rowi).html(IncomeType);
					
					
					JQ("#IncomeValue"+rowi).html(result.IncomeValue);
					JQ("#IncomeValue"+rowi).val(result.IncomeValue);
				}else{
					JQ("#ReceiveType"+rowi).html("");
					JQ("#Payname"+rowi).html("");
					JQ("#IncomeType"+rowi).html("");
					JQ("#IncomeValue"+rowi).html("");
					JQ("#IncomeValue"+rowi).val(0);

				}
				calsumInc();
		  },
		  dataType: "json"
	});

}// end

function calsumInc(){
		tin=0;
		JQ('[name=Inval]').each(function() {
			incv = JQ(this).val();
			if(incv==""){
				incv = 0;
			}
			tin = tin+parseFloat(incv);
		});
		JQ("#DepositValue").val (tin);		
}
</script>
<div class="sysinfo">
  <div class="sysname"><? if ($_REQUEST["id"] == ""){?>เพิ่มรายการ<? }else{?>แก้ไขรายการ<? }?><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไข<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input name="DepositId" type="hidden"  id="Id" value="<?php echo $_REQUEST['id'];?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<tr>
  <td colspan="3"><div style="padding:10px; border:1px solid #999; background-color:#EEE;">
    <div style="padding-bottom:10px; font-weight:bold; font-size:12pt;">ฝากเข้าบัญชี :</div>
    <div>
      <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
        <tr>
          <th>ธนาคาร</th>
          <td class="require">*</td>
          <td><?php 
  		$tag_attribs = 'onchange="loadBBNumber();" style="width:300px"';
		echo $get->getBankNameSelect("BankId",$tag_attribs,$BankId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></td>
        </tr>
        <tr>
          <th>ประเภท</th>
          <td class="require">*</td>
          <td><?php 
  		$tag_attribs = 'onchange="loadBBNumber();" style="width:300px"';
		echo $get->getBookbankType("BookbankTypeId",$tag_attribs,$BookbankTypeId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></td>
        </tr>
        
        <tr>
          <th>เลขที่บัญชี</th>
          <td class="require">*</td>
          <td><div id="bbNumber"><?php 
  		$tag_attribs = 'onchange="" style="width:300px"';
		echo $get->getBookbankNumber("BookbankId",$tag_attribs,$BookbankId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></div></td>
        </tr>
        <tr>
          <th>วันที่ฝาก</th>
          <td class="require">*</td>
          <td><div id="DeDate"><?php
		if($DepositDate==""){
			$DepositDate = date('Y-m-d');
		}
	  	echo InputCalendar_text(array(
			'id'=> 'DepositDate',
			'name' => 'DepositDate',
			'value' => $DepositDate
		));
		?>  </div></td>
        </tr>
      </table>
    </div>
  </div></td>
  </tr>
<tr>
  <td colspan="3"><div style="padding:10px; border:1px solid #999; background-color:#EEE;">
    <div style="padding-bottom:10px; font-weight:bold; font-size:12pt;">รายการฝาก :</div>
<table  width="100%" border="1" cellspacing="1" cellpadding="0" class="tbl-list-sub">
<thead>
  		<tr>
    		<td style="width:10%; text-align:center">รหัส</td>
            <td style="width:15%; text-align:center">ประเภท</td>
            <td style="width:30%; text-align:center">ได้รับเงินจาก</td>
            <td style="width:25%; text-align:center">ประเภทรายรับ</td>
            <td style="width:12%; text-align:center">จำนวนเงิน (บาท) </td>
            <td style="width:8%; text-align:center">ปฏิบัติการ</td>
  		</tr>
        </thead>
	</table>
	
<?php 
//$IncomeList = $get->getIncomeItemList($_REQUEST["DepositId"]);//ltxt::print_r($costList);
// if($costList){
//     $countc = 1;
//	 $totalSumVal=0;
//        foreach($costList as $rc){
//            foreach( $rc as $k=>$v){ ${$k} = $v;}
//			$totalSumVal 			=  $totalSumVal+$SumCost;
			
$IncomeList = $get->getIncomeItemList($_REQUEST["id"]);
//ltxt::print_r($selectAct);
 $counti = 1;
 if($IncomeList){
        foreach($IncomeList as $r){
            foreach( $r as $k=>$v){ ${$k} = $v;} 
				$totalSumInc =  $totalSumInc+$IncomeValue;
?> 	 
	<table  width="100%" border="1" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl<?php echo $counti; ?>">
  		<tr>
        <td style="width:10%; text-align:center"><?php 
  		$tag_attribs = 'onchange="loadIncomeDetail($counti);" style="width:60px"';
		echo $get->getIncomeId("IncomeId$counti",$tag_attribs,$IncomeId,"เลือก");//$tag_name,$tag_attribs,$selected,$lebel
	?></td>
		<td style=" width:15%;text-align:center"><div id="ReceiveType<?php echo $counti; ?>"></div></td>
		<td style=" width:30%;text-align:center"><div id="Payname<?php echo $counti; ?>"></div></td>
        <td style=" width:25%;text-align:center"><div id="IncomeType<?php echo $counti; ?>"></div></td>
  		<td style="width:12%; text-align:center"><div id="IncomeValue<?php echo $counti; ?>" name="Inval"></div></td>
        <td style="width:8%; text-align:center "><a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php echo $counti; ?>').remove(); calsumInc(); }" class="ico delete" >ลบทิ้ง</a></td>
	  </tr>
	</table>
<script language="javascript" type="text/javascript">
	loadIncomeDetail(<?php echo $counti;?>);
</script>   	
<?php				
			$counti++;
		}
		$counti--;
	}
?> 	
	
<?php if(!empty($IncomeList)){ $CItemi = $counti; }else{ $CItemi = 1; } ?>

<div id="ListItemsIn"></div>

<script>
var CountItemi = <?php echo $CItemi; ?>;

<?php if(empty($IncomeList)){  ?>

JQ(document).ready(function(){
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('add_income');?>&format=raw&numi=' + CountItemi,
				   success: function(data){
				   		JQ('#IncomeSize').val(CountItemi);
					   CountItemi = CountItemi + 1;
					  JQ('#ListItemsIn').append(data);
				   }
			 });	
});
<?php } ?>

function AddItemInc()
{
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('add_income');?>&format=raw&numi=' + (CountItemi+1),
				   success: function(data){
				   		CountItemi = CountItemi + 1;
					  JQ('#IncomeSize').val(CountItemi);
					  JQ('#ListItemsIn').append(data);
				   }
			 });	
}
</script>    

<table  width="100%" border="1" cellspacing="1" cellpadding="0" class="tbl-list">
  		<tr>
            <td style="width:80%; text-align:right; font-weight:bold" colspan="5">รวมเป็นค่าใช้จ่ายทั้งสิ้น</td>
            <td style="width:12%; text-align:center">
            <input type="text" name="DepositValue"  id="DepositValue"  rel="DepositValue" value="<?php echo number_format($totalSumInc, 2); ?>"   style="width:95%; text-align:right" readonly="readonly" /><input name="IncomeSize" type="hidden"  id="IncomeSize" value=<?php echo  $counti;?> />
            </td>
			<td style="width:8%; text-align:left; font-weight:bold">บาท</td>
  		</tr>
	</table>    
    
    <div align="right" style="padding-top:4px; padding-bottom:4px" >
    <a href="javascript:void(0);" onclick="AddItemInc();" class="ico add">เพิ่มรายการ...  </a>
    </div>
  </div></td>
  </tr>
 <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td>
<input type="button" class="btnRed" name="save" id="save" value=" บันทึก " onclick="Save('adminForm');"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="history.back(-1);" />    </td>
  </tr>
</table>
</form>
</div>
<div id="detailView" style=" display:none"></div>










