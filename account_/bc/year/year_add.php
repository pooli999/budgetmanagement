<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	
	array(
		'text' => $MenuName,
	),
));


//ltxt::print_r($detail);

?>

<script  type="text/javascript">
	function check_uncheck_all(checkname, field)
	{
		for (i = 0; i < checkname.length; i++) {
			checkname[i].checked = field.checked? true:false
		}
	}

/*    JQ(document).ready(function(){
		JQ("#checkAll").click( function(){
		var checkedValue = JQ(this).attr("checked");
		JQ("input.checked").attr("checked", checkedValue); });

    });*/

function Save(form){	
	if(validateSubmit()){
		form.submit();
	}
}

function validateSubmit(){
	<?php if($_GET["id"] == ""){?>
		if(JQ('#BgtYear').val()==0){
			alert("กรุณาระบุปีงบประมาณ");
			JQ('BgtYear').focus();
			return false
		}
		
		<?php if(!$datas){?>
			alert("ไม่มีโครงสร้างหน่วยงานในปีนี้");
			JQ('BgtYear').focus();
			return false		
		<?php } ?>
		
		<?php if($datas){?>

				var sum =0;
				JQ('input[rel=OrganizeCode]').each(function(){
					 if(JQ(this).is(':checked')){
						 num = parseInt(1);
						 if( !isNaN(num)) sum = sum + num; 
					 }
				 });
				 
		if(sum == 0){
			alert("กรุณาเลือกหน่วยงานอย่างน้อย 1 หน่วยงาน");
			return false
		}
		

		<?php } ?>		
		
	<?php } ?>
	
	
	
	
		return true;
}

function loadPage(BgtYear){
	window.location.href='?mod=<?php echo lurl::dotPage($addPage);?>&BgtYear='+BgtYear;
}

</script>

<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
<input type="hidden" name="BgtYearId" id="BgtYearId" value="<?php echo $BgtYearId;?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="2" class="tbl-view">
  <tr>
    <th>ปีงบประมาณ :</th>
    <td>
      <?php if($_GET["id"] != "" ){ ?>
      <input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo $BgtYear;?>" />
      <?php      
				echo "<strong>".$BgtYear."</strong>";
		   }else{
			  $getYear = $get->getCheckYear();
		  ?>    
      <select name="BgtYear" id="BgtYear" onchange="loadPage(this.value);">
        <option  value="0">- เลือกปี -</option>
        <?php
             $Max = date("Y")+543+5;
              $Min = $Max-15;

              for($i=$Min;$i<=$Max;$i++){
				   $year = 0;
				   foreach($getYear as $r){
						if($i == $r->CheckYear){
							$year = $year+1;
						}
					}// for each
					
					if($year == 0){
			  
              ?>
        <option value="<?php echo $i;?>" <?php if($i == $_REQUEST["BgtYear"]){echo 'selected="selected"';} ?> ><?php echo $i;?></option>
        <?php
					}

			  }
              ?>
        </select> <span class="hint">(ปีงบประมาณใดที่มีแล้วจะไม่แสดงให้เลือกอีก)</span>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <th valign="top" colspan="2">ข้อมูลหน่วยงาน <span class="require">*</span> :</th>
	</tr>
  <tr>
    <td colspan="2">
    
        <table width="100%" border="1" cellspacing="0" cellpadding="0"  class="tbl-view" style="background-color:#eee">
        			<tr  style="height:26px; ">
                    	<th style="width:2%; text-align:left">&nbsp;</th>
                        <th  style="width:25%; text-align:center">หน่วยงาน</th>
                    	<th  style="width:33%; text-align:center">ขั้นตอนปัจจุบัน</th>

                    </tr>
<?php
$j = 0; //ltxt::print_r($datas);
if($datas){														
	foreach($datas as $row){
		foreach($row as $k=>$v){ ${$k} = $v; }
?>
                      <tr  style="height:26px;">
                        <td style="border-bottom: 0px; text-align:center">
                            <input type="hidden" name="OrgId[<?php echo $j;?>]" id="OrgId" value="<?php echo $OrgId;?>" />
                            <input name="OrganizeCode[<?php echo $j;?>]" id="OrganizeCode" rel="OrganizeCode" type="checkbox" value="<?php echo $OrganizeCode;?>"  class="checked"  <?php if($ScreenLevel){ ?>  checked="checked" disabled="disabled"<?php } ?>  />           
                        </td>
                        <td style="border-bottom: 0px;">
                           <?php echo $OrgName; ?>
                        </td>
                        <td style="border-bottom: 0px;"><?php echo ($ScreenLevel)?$get->getScreenName($BgtYear,$ScreenLevel):"-"; ?></td>
                      </tr>
<?php 
		$j++;             
	}// level = 1
} // foreach      
?>    
        </table>    
    </td>
  </tr>  
  <tr>
    <th>&nbsp;</th>
    <td><input type="submit" class="btnRed" name="save" id="save" value="บันทึก"  />
      <input type="button" name="button" id="button" value="ยกเลิก" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($mainPage);?>&start=<?php echo $_REQUEST['start'];?>&BgtYear=<?php echo $_REQUEST['BgtYear'];?>');" /></td>
  </tr>
</table>

</form>

