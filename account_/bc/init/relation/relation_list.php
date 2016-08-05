<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css'
));
$this->DOC->setPathWays(array(
	array(
		'text' => 'จัดการข้อมูลพื้นฐาน',
		'link' => '?mod=budget.init.startup',
	),
	
	array(
		'text' => $MenuName,
	),
));




?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */

	function loadSCT(BgtYear){
		window.location.href='?mod=<?php echo lurl::dotPage($listPage);?>&BgtYear='+BgtYear;
	}
	
	function toPage(PGroupId){
		var BgtYear = jQuery('#BgtYear').val();
		window.location.href='?mod=<?php echo lurl::dotPage($listPage);?>&PGroupId='+PGroupId+'&BgtYear='+BgtYear;
	}
	
/* ]]> */

function printDocument(){
	window.location.href="?mod=<?php echo LURL::dotPage('relation_print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('relation_excel')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

</script>


<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>
<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td>
      <input type="button" name="button4" id="button4" value="กำหนดความสัมพันธ์" class="add" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>&BgtYear=<?php echo $_REQUEST["BgtYear"]; ?>');" />
      <input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" />
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
  
<div style="text-align:right; padding-top:10px; padding-right:10px;">
<a href="javascript:printDocument();" class="icon-printer">พิมพ์</a>&nbsp;
<a href="javascript:saveToExcel();" class="icon-excel">ส่งออกเป็น Excel</a>
</div>  
    
    
    
    
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
		<div class="title-white" style="vertical-align:bottom;">ความสัมพันธ์ระหว่าง  <span class="txtred"><?php echo $PGroupName;?></span> กับ <span class="txtred"><?php echo $NextPGroupName;?></span></div>
       

        <?php
         $item= $get->getItemList($PGroupId,$_REQUEST["BgtYear"]);
		 //ltxt::print_r($item);
		 if($item){
			$t=1; 
            foreach( $item as $ritem ) {
               foreach( $ritem as $k=>$v){ ${$k} = $v;}
		?>
 		<div class="title-grey"><span class="ico bullet"><?php echo $PItemName;?></span></div>
        <div style="padding-left:20px; padding-top:4px; padding-bottom:4px"><u><?php echo $NextPGroupName;?> :</u></div>
        		<?php
                $relationList = $get->getItemrelationList($PItemId);
				if($relationList){
					$s = 1;
				foreach( $relationList as $rRelation ) {
				?>
                <div style="padding-left:20px; padding-bottom:12px;"><span class="ico bulletyellow"><?php echo $s.".";?>&nbsp;&nbsp;<?php echo $get->getPItemName($rRelation->PItemRelate);?></span></div>
        		<?php $s++; } }else{ ?>
                 <div  class="txtred" style="padding-left:20px; padding-top:3px; padding-bottom:3px; border-top: 1px solid #ccc;border-top-style: dotted;border-bottom: 1px solid #ccc;border-bottom-style: dotted;" >ไม่มีข้อมูลความเชื่อมโยง</div>
                <?php }  //end item relation?>
                <br />
        <?php } } //end item?>
        
		<?php }  }?>

        
        
	</td>
   </tr>
 </table>


