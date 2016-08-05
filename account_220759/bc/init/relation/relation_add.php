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
	),
));


$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));

?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	function loadSCT(BgtYear){
		window.location.href='?mod=<?php echo lurl::dotPage($addPage);?>&BgtYear='+BgtYear;
	}
	
	function toPage(PGroupId){
		var BgtYear = jQuery('#BgtYear').val();
		window.location.href='?mod=<?php echo lurl::dotPage($addPage);?>&PGroupId='+PGroupId+'&BgtYear='+BgtYear;
	}
	
	
	JQ(document).ready(function(){
		<?php if($_REQUEST["MesAlert"] == "complete"){ ?>
			changeData(<?php echo $_REQUEST["PGroupId"];?>,<?php echo $_REQUEST["PItemId"];?>,<?php echo $_REQUEST["NextPGroupId"];?>,'<?php echo $_REQUEST["BgtYear"];?>');
		<?php }else{ ?>
			JQ("#topicitem").hide();
			JQ("#pitem").hide();
	   <?php } ?>
	});
		
	function changeData(PGroupId,PItemId,NextPGroupId,BgtYear){	
		 //JQ("#pitem").show();
		 			 	
		JQ.ajax({
		   type: "POST",
		   url: "?mod=<?php echo LURL::dotPage($actionPage);?>",		   
		   data: "action=showtopic&PGroupId="+PGroupId+"&PItemId="+PItemId,
		   success: function(msg){
				JQ("#topicitem").html(msg);
		   }
		});
		
		JQ.ajax({
		   type: "POST",
		   url: "?mod=<?php echo LURL::dotPage($actionPage);?>",		   
		   data: "action=getpitembygroup&PGroupId="+PGroupId+"&PItemId="+PItemId+"&NextPGroupId="+NextPGroupId+"&BgtYear="+BgtYear,
		   success: function(msg){
				JQ("#pitem").html(msg);
		   }
		});		
		
		JQ("#topicitem").show();
		JQ("#pitem").show();
				
		JQ('#PItemId').val(PItemId);
		JQ('#PGroupId').val(PGroupId);
		JQ('#NextPGroupId').val(NextPGroupId);

	}
		
function Save(form){	
	form.submit();
}
	
<?php if($_REQUEST["MesAlert"] == "complete"){ ?>	
alert('บันทึกข้อมูลเรียบร้อยแล้ว');
<?php } ?>	
	
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
      
      <input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>');" />
      </td>
      <td align="right"></td>
    </tr>
  </table>
</div>

<div class="title-bar">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="text-align:left">รายการความสัมพันธ์นโยบายแผนงาน ประจำปีงบประมาณ <u><?php echo ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:date("Y")+543; ?></u></td>
    <td style="text-align:right">ปีงบประมาณ : <?php echo $get->getYear(ltxt::getVar('BgtYear'),'BgtYear');?></td>
  </tr>
</table>
</div>


<table  border="0" cellspacing="1" cellpadding="5" style="background-color:#fff; border-bottom:0px">
  <tr  style="height:30px">
	<?php
		$i = 0;
        $gruopList = $get->getGroupList();
        //ltxt::print_r($gruopList);
        foreach($gruopList as $drow){
            foreach($drow as $k=>$v){
                ${$k} = $v;
            }
			
			$i++;
			$defaultpage = $gruopList[0]->PGroupId;
			//echo "defaultpage= ".$defaultpage;
			if($_REQUEST["PGroupId"]  == ""){
				$_REQUEST["PGroupId"] = $defaultpage;
			}			
    
    ?>
	<td  style="vertical-align:center" class="<?php if($_REQUEST["PGroupId"] == $PGroupId){echo "tabselect";}else{ echo "tabdefault";}?>" ><a href="javascript:void(0)" onclick="toPage('<?php echo $PGroupId;?>');"  ><?php echo $i;?>. <?php echo $PGroupName;?></a></td>
  <?php } ?>
  </tr>
</table>



<table width="100%" border="0" cellspacing="3" cellpadding="3" style="background-color:#990000">
  <tr  style="background-color:#FFF">
    <td style="height:400px; vertical-align:top">
    <form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&action=save" onSubmit="Save(this);return false;" enctype="multipart/form-data">
		 <?php
          foreach($gruopList as $drow2){
             foreach($drow2 as $k=>$v){ ${$k} = $v; }
				if($_REQUEST["PGroupId"] == $PGroupId){
					
					$nextgroup = $get->getNextGroup($PGroupId);
					//ltxt::print_r($nextgroup);
					foreach($nextgroup as $nextg){
            			foreach($nextg as $k=>$v){ ${$k} = $v; }
					}

					
					
         ?>
        <div class="title-grey2" style="vertical-align:bottom"><span class="txtred">รายการ<?php echo $PGroupName;?> <span style="font-weight:normal">[ คลิกที่รายการ เมื่อต้องการกำหนดความสัมพันธ์ ]</span></span> </div>
        
        
        <?php
         $item= $get->getItemList($PGroupId,$_REQUEST["BgtYear"]);
		 //ltxt::print_r($item);
		 if($item){
			$t=1; 
            foreach( $item as $ritem ) {
               foreach( $ritem as $k=>$v){ ${$k} = $v;}
		?>
        <div  style="padding:3px"><a class="ico bulletyellow"  href="javascript:void(0)" onclick="changeData('<?php echo $_REQUEST["PGroupId"];?>','<?php echo $PItemId;?>','<?php echo $NextPGroupId;?>','<?php echo $_REQUEST["BgtYear"];?>');"><?php echo $PItemName; ?></a></div>
        <?php } } //end item?>
        
        
       <div class="title-grey2" style="vertical-align:bottom">กำหนดความสัมพันธ์ ระหว่าง  <span class="txtred"><?php echo $PGroupName;?></span> กับ <span class="txtred"><?php echo $NextPGroupName;?></span></div>
       
    <!--<div id="relation" style="display:none" >  -->

       <div id="topicitem" style="padding:4px">
       </div>
         
       <div id="pitem"  style="padding:4px"></div>
  <!-- </div> -->   
		<?php }  } // end group?>
        
<input type="hidden" name="PItemId" id="PItemId" />
<input type="hidden" name="PGroupId" id="PGroupId" />
<input type="hidden" name="NextPGroupId" id="NextPGroupId"  />
<input type="hidden" name="BgtYear" id="BgtYear" value="<?php echo ($_REQUEST["BgtYear"])?$_REQUEST["BgtYear"]:date("Y")+543; ?>" />
                
<div style="text-align:center; margin:10px;">
<input type="submit" class="btnRed" name="save" id="save" value="บันทึก"  />
<input type="button" class="btn" name="Cancel" id="Cancel" value="ยกเลิก" onClick="window.location.href='?mod=<?php echo LURL::dotPage($listPage); ?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>'" /> 
</div>

</form>       

	</td>
   </tr>
 </table>

