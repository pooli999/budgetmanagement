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





/*function icoActive($r){
	global $actionPage;
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&CostItemId='.$r->CostItemId.'&start='.$_REQUEST['start'].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}*/


/*function icoActive($r){
	global $actionPage;
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&CostItemId='.$r->CostItemId.'&start='.$_REQUEST['start'].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}
*/


function icoActive($r){
	global $actionPage;
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&CostItemId='.$r->CostItemId."&start=".$_REQUEST["start"].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}




function icoEdit($r){
	$label = 'แก้ไข';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->CostItemId."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}


function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&id=".$r->CostItemId."&start=".$_REQUEST["start"]."')",
		'ico delete',
		$label,
		$label
	));
}



?>

<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	
/*	function Search(){
		var tsearch=JQ('#tsearch').val();
		window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&tsearch="+ tsearch;
	}
	
	function toggleSub(id){
		JQ("a#icoClass_"+id).toggleClass("minimize");
		JQ("tr.hideRow_"+id).toggle();
	}
	
	function sortItem(){
	window.location.href='?mod=<?php echo lurl::dotPage($sortPage);?>';
	}*/
	
	function loadPage(){
		var CostTypeId=JQ('#CostTypeId').val();
		window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&CostTypeId="+ CostTypeId;
	}	
	
	function showHide(i){
		if(JQ('#body-cate'+i).is(':hidden')===true){
			JQ('#body-cate'+i).show('slow');
			JQ('#a-cate'+i).addClass('icon-decre');
			JQ('#a-cate'+i).removeClass('icon-incre');
			JQ('#a-cate'+i).html(' ');
		}else{
			JQ('#body-cate'+i).hide('slow');
			JQ('#a-cate'+i).removeClass('icon-decre');
			JQ('#a-cate'+i).addClass('icon-incre');
			JQ('#a-cate'+i).html(' ');
		}
	}	

/* ]]> */


function printDocument(){
	window.location.href="?mod=<?php echo LURL::dotPage('pay_print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('pay_excel')?>&format=raw<?php echo $get->getQueryString(); ?>";
}
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbl-button">
  <tr>
    <td>
     <a href="javascript:printDocument();" class="icon-printer">พิมพ์</a>&nbsp;
    <a href="javascript:saveToExcel();" class="icon-excel">ส่งออกเป็น Excel</a>
    </td>
  </tr>
</table>



<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td>
      	<input type="button" name="button4" id="button4" value="เพิ่มรายการ" class="add" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>');" />
       <!-- <input type="button" name="button5" id="button5" value="  เรียงลำดับข้อมูล  " class="btnRed" onclick="goPage('?mod=<?php echo lurl::dotPage($sortPage);?>');" />-->
      	<input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" />
        <!--<input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').show();JQ('#boxFilter').hide();" />-->
        
        </td>

          <td align="right">
			<strong>หมวดเงิน :</strong> <?php $get->getCostTypeFilter($_REQUEST["CostTypeId"],'CostTypeId','onchange="loadPage()" style="width:150px;"','ทั้งหมด'); ?>          
      </td>
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
/*JQ(document).ready(function() {
	
	JQ("table").tablesorter({
		headers: {
			0: {sorter: false},
			4: {sorter: false}
		}
	});
	
});*/
/* ]]> */
</script>



<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl-cost" style="border-collapse:collapse;">
  <tr>
    <th align="center" >รายการค่าใช้จ่าย</th>
    <th align="center" style="width:95px;">สถานะ</th>
    <th colspan="2" style="text-align:center;" >ปฏิบัติการ</th>
    </tr>

<?php
	// หมวดเงินงบประมาณ
	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	if($list["rows"]){
          foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
  <tr class="cate">
    <td colspan="4" valign="top" style="background-color:#CCC; font-weight:bold;"  >
    <a href="javascript:void(0)" id="a-cate<?php echo $i; ?>" onclick="showHide(<?php echo $i; ?>);" class="icon-decre txt-normal"></a><?php echo $CostTypeName;?>
    </td>
  </tr>
  
  
  
  <tbody id="body-cate<?php echo $i; ?>">
		   <?php
           //วน loop รายการงบรายจ่าย ระดับที่ 1
          $NumLevel1 = 1; 
          $BGLevel1 = $get->getCostItemRecordSet($CostTypeId);
		 // ltxt::print_r($BGLevel1);
          foreach($BGLevel1 as $BGLevel1Row){ 
            foreach($BGLevel1Row as $c=>$d){
                ${$c} = $d;
            }
          ?>
           <tr style="background-color:#E2E2E2; ">
              <td valign="top" style="padding-left:22px" >|-- <?php echo "[".$CostItemCode."] ".$CostName; ?></td>
              <td align="center" valign="top" ><?php echo icoActive($BGLevel1Row);?></td>
              <td style="width:60px;" nowrap="nowrap" valign="top"  ><?php echo icoEdit($BGLevel1Row);?></td>
              <td style="width:60px;" valign="top"  nowrap="nowrap" ><?php echo icoDelete($BGLevel1Row);?></td>
          </tr> 
          
				   <?php
				   //วน loop รายการงบรายจ่าย ระดับที่ 2
                  $NumLevel2 = 1; 
                  $BGLevel2 = $get->getCostItemRecordSet($CostTypeId,2,$CostItemCode);
				  //ltxt::print_r($BGLevel2);
                  foreach($BGLevel2 as $BGLevel2Row){ 
                    foreach($BGLevel2Row as $e=>$f){
                        ${$e} = $f;
                    }
                  ?>          
                   <tr style="background-color:#F2F2F2; ">
                      <td valign="top" style="padding-left:36px" >|-- <?php echo "[".$CostItemCode."] ".$CostName; ?></td>
                      <td align="center" valign="top" ><?php echo icoActive($BGLevel2Row);?></td>
                      <td style="width:60px;" nowrap="nowrap" valign="top"  ><?php echo icoEdit($BGLevel2Row);?></td>
                      <td style="width:60px;" valign="top"  nowrap="nowrap" ><?php echo icoDelete($BGLevel2Row);?></td>
                  </tr>  
                  
						   <?php
						  //วน loop รายการงบรายจ่าย ระดับที่ 3
                          $NumLevel3 = 1; 
                          $BGLevel3 = $get->getCostItemRecordSet($CostTypeId,3,$CostItemCode);
						  // ltxt::print_r($BGLevel3);
                          foreach($BGLevel3 as $BGLevel3Row){ 
                            foreach($BGLevel3Row as $g=>$h){
                                ${$g} = $h;
                            }                        
                          ?>
                           <tr >
                              <td valign="top" style="padding-left:50px" >|-- <?php echo "[".$CostItemCode."] ".$CostName; ?></td>
                              <td align="center" valign="top" ><?php echo icoActive($BGLevel3Row);?></td>
                              <td style="width:60px;" nowrap="nowrap" valign="top"  ><?php echo icoEdit($BGLevel3Row);?></td>
                              <td style="width:60px;" valign="top"  nowrap="nowrap" ><?php echo icoDelete($BGLevel3Row);?></td>
                          </tr>                  
							<?php
                                    $NumLevel3++;
                                    }
                            ?>                    
 
					<?php
                            $NumLevel2++;
                            }
                    ?>  
           
			<?php
                    $NumLevel1++;
                    }
            ?>  

  </tbody>
<?php

		$i++;
		}
	}
?>

</table>



<!--<div class="cms-box-navpage">
  <?php //echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>-->
          
