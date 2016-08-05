<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css'
));

$this->DOC->setPathWays(array(
	
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

		if(JQ('#PLongCode').val() == '' || JQ('#PLongCode').val() == ' '){
			jAlert('กรุณาระบุรหัสแผนงานต่อเนื่อง','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PLongCode').focus();
			});
			return false;
		}
			
		if(JQ('#PLongName').val() == '' || JQ('#PLongName').val() == ' '){
			jAlert('กรุณาระบุชื่อแผนงานต่อเนื่อง','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PLongName').focus();
			});
			return false;
		}
		
		if(JQ('#PLongYear').val() == 0){
			jAlert('กรุณาระบุปีที่ตั้งแผนงาน','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PLongYear').focus();
			});
			return false;
		}		
		
		if(JQ('#PLongAmount').val() == '' || JQ('#PLongAmount').val() == ' '){
			jAlert('กรุณาระบุจำนวนปีต่อเนื่อง','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PLongAmount').focus();
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

</script>
<div class="sysinfo">
  <div class="sysname">เพิ่มข้อมูลแผนงานต่อเนื่อง</div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไขแผนงานต่อเนื่อง</div>
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
<input name="PLongId" type="hidden"  id="PLongId" value="<?php echo $_REQUEST['id'];?>" />
<input name="PLongCode" type="hidden"  id="PLongCode" value="<?php echo $PLongCode;?>" />
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
<!--<tr>
<th>รหัสแผนงานต่อเนื่อง</th>
<td class="require">*</td>
<td><input name="PLongCode" type="text" id="PLongCode" value="<?php //echo $PLongCode;?>"  style="width:10%" /></td>
</tr>
--><tr>
<th>ชื่อแผนหลัก</th>
<td class="require">*</td>
<td><input name="PLongName" type="text" id="PLongName" value="<?php echo $PLongName;?>"  style="width:98%" /></td>
</tr>
<tr>
<th valign="top">รายละเอียด</th>
<td class="require"></td>
<td><textarea name="PLongDetail" id="PLongDetail" style="width:98%; height:100px" ><?php echo $PLongDetail;?></textarea></td>
</tr>
<tr>
<th>ปีที่ตั้งแผนหลัก</th>
<td class="require">*</td>
<td>
      <select name="PLongYear" id="PLongYear" >
      <option value="0" selected="selected">-เลือกปี-</option>
      <?php
	  $Min = date("Y")-10;
	  $Max = date("Y")+10;
	  
	  for($i=$Min;$i<=$Max;$i++){
	  ?>
        <option value="<?php echo $i+543;?>" <?php if($PLongYear == $i+543){ echo 'selected="selected"';} ?>  ><?php echo ($i+543);?></option>
        <?php } ?>
      </select>
      ต่อเนื่อง <input name="PLongAmount" type="text" id="PLongAmount" value="<?php echo $PLongAmount;?>"  style="width:5%" onKeyPress="return validChars(event,1)" /> ปี
</td>
</tr>
<tr>
<th colspan="3">ตัวชี้วัดภายใต้แผนหลัก 5 ปี</th>
</tr>
<tr>
<td colspan="3">

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
    <thead>
        <tr>
            <td style="width:15%; text-align:center">รหัสตัวชี้วัด</td>
            <td style="width:77%; text-align:center">ชื่อตัวชี้วัด</td>
        </tr>
     </thead>
	</table>
    
<?php 
/*$dataInd = $get->getIndItem($PLongCode);//ltxt::print_r($dataPlan);
 if($dataInd){
     $countInd = 1;
        foreach($dataInd as $dataIndRow){
            foreach( $dataIndRow as $kp=>$kq){ ${$kp} = $kq;}*/
	 
?>    
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">001</td>
    <td align="left" style="width:77%; text-align:left"> 	มีการนำสาระสำคัญในธรรมนูญว่าด้วยระบบสุขภาพแห่งชาติฯ ไปใช้ในการจัดทำแผนปฏิบัติราชการ และแผนประจำปีของหน่วยงานยุทธศาสตร์ </td>
    </tr>
 </table>
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">002</td>
    <td style="width:77%; text-align:left"> 	มีการจัดทำธรรมนูญสุขภาพพื้นที่ หรือนำสาระของธรรมนูญว่าด้วยระบบสุขภาพแห่งชาติฯ ไปประกอบการจัดทำแผนพัฒนาสุขภาพในระดับพื้นที่และมีการดำเนินการตามแผน อย่างน้อย ๑๐๐ แห่ง</td>
    </tr>
 </table>  
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">003</td>
    <td style="width:77%; text-align:left">มีธรรมนูญว่าด้วยระบบสุขภาพแห่งชาติ ฉบับที่สอง</td>
    </tr>
 </table>  
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">004</td>
    <td style="width:77%; text-align:left"> 	มีข้อเสนอนโยบายสาธารณะเพื่อสุขภาพที่คณะรัฐมนตรีให้ความเห็นชอบ และมีการนำไปสู่การปฏิบัติ อย่างน้อย ๒๕ เรื่อง</td>
    </tr>
 </table>    
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">005</td>
    <td style="width:77%; text-align:left"> 	 	มีรายงานสถานการณ์ระบบสุขภาพแห่งชาติที่สะท้อนสถานการณ์ในภาพรวม และประเด็นสำคัญ อย่างน้อย ๑๕ ฉบับ</td>
    </tr>
 </table> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">006</td>
    <td style="width:77%; text-align:left"> 	มีการขับเคลื่อนมติและข้อเสนอเชิงนโยบายจากสมัชชาสุขภาพแห่งชาติจนเกิดผลการปฏิบัติอย่างน้อย ๕๐ เรื่อง</td>
    </tr>
 </table> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">007</td>
    <td style="width:77%; text-align:left"> 	 	มีการใช้สมัชชาสุขภาพเฉพาะพื้นที่ในการพัฒนานโยบายสาธารณะเพื่อสุขภาพและมีการดำเนินการตามข้อเสนอเชิงนโยบาย ในทุกจังหวัดทั่วประเทศ</td>
    </tr>
 </table> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">008</td>
    <td style="width:77%; text-align:left"> 	มีการใช้สมัชชาสุขภาพเฉพาะประเด็นในการพัฒนานโยบายสาธารณะเพื่อสุขภาพและมีการดำเนินการตามข้อเสนอเชิงนโยบายในเรื่องต่างๆ อย่างน้อย ๕๐ เรื่อง</td>
    </tr>
 </table> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">009</td>
    <td style="width:77%; text-align:left"> 	มีการใช้สมัชชาสุขภาพเฉพาะพื้นที่ และสมัชชาสุขภาพเฉพาะประเด็นในการพัฒนานโยบายสาธารณะที่หนุนเสริมการปฏิรูปประเทศไทยอย่างต่อเนื่อง</td>
    </tr>
 </table> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">010</td>
    <td style="width:77%; text-align:left"> 	 	เกิดระบบและกลไกที่เชื่อมโยงทุกภาคส่วนของสังคมในการร่วมกันพัฒนา เอชไอเอ ให้เป็นเครื่องมือสำคัญในการกำหนดทิศทางการพัฒนา</td>
    </tr>
 </table> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">011</td>
    <td style="width:77%; text-align:left"> 	มีการทำงานกับกลุ่มประเทศอาเซียน ประเทศในภูมิภาคเอเชียตะวันออกเฉียงใต้ และเครือข่ายระหว่างประเทศ เพื่อพัฒนาและใช้ เอชไอเอ ร่วมกัน</td>
    </tr>
 </table> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">012</td>
    <td style="width:77%; text-align:left"> 	ชุมชนท้องถิ่นมีการนำเครื่องมือ เอชไอเอ ไปใช้ เพิ่มขึ้น อย่างน้อย ๒๕๐ พื้นที่</td>
    </tr>
 </table> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">013</td>
    <td style="width:77%; text-align:left"> 	หลักเกณฑ์และวิธีการทำ เอชไอเอสามารถนำไปปฏิบัติได้อย่างสอดคล้องกับบริบทของสังคมไทย</td>
    </tr>
 </table> 
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">014</td>
    <td style="width:77%; text-align:left"> 	 	หน่วยงาน องค์กร และภาคีต่างๆ มีการทำ เอชไอเอ ในหลายระดับ</td>
    </tr>
 </table> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">015</td>
    <td style="width:77%; text-align:left"> 	 	มีการตัดสินใจเลือกทางเลือกเชิงนโยบายต่างๆ ที่เป็นผลดีต่อสุขภาพของประชาชน โดยการใช้ผลการทำ เอชไอเอ เป็นข้อมูลประกอบอย่างสำคัญ</td>
    </tr>
 </table> 
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl-ind<?php echo $countInd; ?>">
    <tr>
    <td style="width:15%; text-align:center">016</td>
    <td style="width:77%; text-align:left"> 	องค์กรวิชาชีพ สถานพยาบาล และภาคีเครือข่ายต่างๆ ที่เกี่ยวข้อง มีการรับรู้ เข้าใจ เรื่องสิทธิและหน้าที่ด้านสุขภาพตาม พ.ร.บ. สุขภาพแห่งชาติ อย่างน้อยร้อยละ ๓๐ </td>
    </tr>
 </table> 
<?php				
			/*$countInd++;
		}
	}*/
?> 
   
<?php if(!empty($dataInd)){ $SCItem = $countInd; }else{ $SCItem = 1; } ?>

<!--<div id="ListItemsInd"></div>-->

<script>
var CountIndItem = <?php echo $SCItem; ?>;

<?php if(empty($dataInd)){  ?>

JQ(document).ready(function(){
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('plan_addrow_ind');?>&format=raw&num=' + CountIndItem,
				   success: function(data){
					   CountIndItem = CountIndItem + 1;
					  JQ('#ListItemsInd').append(data);
				   }
			 });	

});
<?php } ?>

function AddItemInd(){
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('plan_addrow_ind');?>&format=raw&num=' + CountIndItem,
				   success: function(data){
					   CountIndItem = CountIndItem + 1;
					  JQ('#ListItemsInd').append(data);
				   }
			 });	
}
</script>    
    
<!--    <div align="right">
    <a href="javascript:void(0);" onclick="AddItemInd();" class="ico add">เพิ่มตัวชี้วัด</a>
    </div>-->
      
      
      
      
      
      
      
      
      
      
      



</td>
</tr>



























<tr>
<th colspan="3">ข้อมูลแผนงานภายใต้แผนหลัก</th>
</tr>
<tr>
<td colspan="3">



      
      
      
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-history-check">
    <thead>
        <tr>
            <td style="width:15%; text-align:center">รหัสแผนงาน</td>
            <td style="width:77%; text-align:center">ชื่อแผนงาน</td>
            <td style="width:8%; text-align:center">ปฏิบัติการ</td>
        </tr>
     </thead>
	</table>
    
<?php 
$dataPlan = $get->getPlanItem($PLongCode);//ltxt::print_r($dataPlan);
 if($dataPlan){
     $count = 1;
        foreach($dataPlan as $r){
            foreach( $r as $k=>$v){ ${$k} = $v;}
	 
?>    
  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbl-list"  id="tbl<?php echo $count; ?>">
    <tr>
    <td style="width:15%; text-align:center">
    <input type="text" style="width:99%; text-align:center;" value="<?php echo $LPlanCode; ?>"  name="LPlanCode[]" />
    <input type="hidden" value="<?php echo $LPlanCode; ?>"  name="LPlanCode_Old[]" />
    </td>
    <td style="width:77%; text-align:center"><input type="text" style="width:99%;" value="<?php echo $LPlanName; ?>" name="LPlanName[]" /></td>
    <td style="width:8%; text-align:center"><a href="javascript:void(0);" onclick="if(confirm('คุณต้องการลบข้อมูลรายการนี้หรือไม่')){JQ('#tbl<?php echo $count; ?>').remove(); CountItem--;}" class="ico delete" >ลบทิ้ง</a></td>
    </tr>
 </table>  
				
<?php				
			$count++;
		}
	}
?> 
   
<?php if(!empty($dataPlan)){ $CItem = $count; }else{ $CItem = 1; } ?>

<div id="ListItems"></div>

<script>
var CountItem = <?php echo $CItem; ?>;

<?php if(empty($dataPlan)){  ?>

JQ(document).ready(function(){
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('plan_addrow');?>&format=raw&num=' + CountItem,
				   success: function(data){
					   CountItem = CountItem + 1;
					  JQ('#ListItems').append(data);
				   }
			 });	

});
<?php } ?>

function AddItem()
{
			JQ.ajax({
				   type: "POST",
				   dataType: 'html',
				   url: '?mod=<?php echo LURL::dotPage('plan_addrow');?>&format=raw&num=' + CountItem,
				   success: function(data){
					   CountItem = CountItem + 1;
					  JQ('#ListItems').append(data);
				   }
			 });	
}
</script>    
    
    <div align="right">
    <a href="javascript:void(0);" onclick="AddItem();" class="ico add">เพิ่มแผนงาน</a>
    </div>
      
      
      
      
      
      
      
      
      
      
      



</td>
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