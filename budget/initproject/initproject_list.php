<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
/*	array(
		'text' => 'จัดการข้อมูลพื้นฐาน',
		'link' => '?mod=budget.init.startup',
	),*/
	
	array(
		'text' => $MenuName,
	),
));

$this->DOC->setStyles(array(
	VSROOT.'modules/backoffice/budget/style_budget.css',
	VSROOT.'modules/backoffice/finance/style_finance.css'
));

/*function icoActive($r){
	global $actionPage;
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&PrjId='.$r->PrjId."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST["BgtYear"].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}*/



function icoActive($r){
	global $actionPage;
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&PrjId='.$r->PrjId.'&BgtYear='.$r->BgtYear.'&start='.$_REQUEST['start'].'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}

function icoEdit($r){
	$label = 'แก้ไข';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->PrjId."&start=".$_REQUEST["start"]."'",
		'ico edit',
		$label,
		$label
	));
}

function icoAddPerson($r){
	$label = 'ผู้รายงานผล';
	global $addPersonPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPersonPage)."&id=".$r->PrjId."&start=".$_REQUEST["start"]."'",
		'ico add',
		$label,
		$label
	));
}

function icoView($r){
	$label = "|-- ".$r->PrjCode."&nbsp;&nbsp;".$r->PrjName;
	global $viewPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($viewPage)."&id=".$r->PrjId."&start=".$_REQUEST["start"]."'",
		'ico view noicon',
		$label,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&id=".$r->PrjId."&start=".$_REQUEST["start"]."&BgtYear=".$_REQUEST["BgtYear"]."')",  
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

	function loadSCT(BgtYear){
		window.location.href='?mod=<?php echo lurl::dotPage($listPage);?>&BgtYear='+BgtYear;
	}
	
	
	
	JQ("#edit_name").live('click',function(){  
		JQ( "#dialog-edit_name" ).dialog( "open" );
	 })
	  JQ(function(){ 
		     JQ( "#dialog-edit_name" ).dialog({
			  resizable: false,
			  autoOpen: false,
			  height:250,
			  width:400,
			  modal: true,
			  buttons: {
				"ปิด": function() {
				  JQ( this ).dialog( "close" );
				}
			  }
			});
	   })
	   JQ("#edit_ws").live('click',function(){  
		JQ( "#dialog-edit_ws" ).dialog( "open" );
	 })
	  JQ(function(){ 
		     JQ( "#dialog-edit_ws" ).dialog({
			  resizable: false,
			  autoOpen: false,
			  height:250,
			  width:400,
			  modal: true,
			  buttons: {
				"ปิด": function() {
				  JQ( this ).dialog( "close" );
				}
			  }
			});
			
			 JQ( "#dialog-copy_project" ).dialog({
			  resizable: false,
			  autoOpen: false,
			  height:200,
			  width:800,
			  modal: true,
			  buttons: {
				"ตกลง": function() {
				  JQ( this ).dialog( "close" );
				},"ปิด": function() {
				  JQ( this ).dialog( "close" );
				}
			  }
			});
			JQ("#btn_copy").live('click',function(){  
				JQ( "#dialog-copy_project" ).dialog( "open" );
			 })
	   })
	   
	   
			

/* ]]> */

function printDocument(){
	window.location.href="?mod=<?php echo LURL::dotPage('initproject_print')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToWord(){
	window.location.href="?mod=<?php echo LURL::dotPage('initproject_word')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

function saveToExcel(){
	window.location.href="?mod=<?php echo LURL::dotPage('initproject_excel')?>&format=raw<?php echo $get->getQueryString(); ?>";
}

</script>

<script type="text/javascript" language="javascript" id="js">
/* <![CDATA[ */
/*JQ(document).ready(function() {
	
	JQ("table").tablesorter({
		headers: {
			3: {sorter: false},
			5: {sorter: false}
		}
	});
	
});
*/
function swap(id,el,img){
		var Obj = document.getElementById(id);
		var Img = document.getElementById(img);
		if(Obj.style.display=='none'){
			Obj.style.display='';
			el.src='images/bullet/minimize.gif';
			if(Img) Img.src='images/bullet/minimize.gif';
		}else{
			Obj.style.display='none';
			el.src='images/bullet/maximize.gif';
			if(Img) Img.src='images/bullet/maximize.gif';
		}
}	

/* ]]> */
</script>




<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbl-button">
  <tr>
    <td>
     <a href="javascript:printDocument();" class="icon-printer">พิมพ์</a>&nbsp;
     <a href="javascript:saveToWord()" class="icon-word">ส่งออกเป็น Word</a>&nbsp;
    <a href="javascript:saveToExcel();" class="icon-excel">ส่งออกเป็น Excel</a>&nbsp;
	
    </td>
  </tr>
</table>




<div class="boxfilter2" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td>
      	<input type="button" name="button4" id="button4" value="  เพิ่มรายการ  " class="add" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>&BgtYear=<?php echo $_REQUEST["BgtYear"];?>');" />
        <!--<input type="button" name="button5" id="button5" value="  คัดลอกโครงการ  " class="btn"  />-->
      	<input type="button" name="button5" id="button5" value="  รีเฟรช  " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>');" />
      </td>
        <td align="right">ปีงบประมาณ : <?php echo $get->getYearProject(ltxt::getVar('BgtYear'),'BgtYear');?></td>
    </tr>
  </table>
</div>


<table width="100%" border="0" class="tbl-list tablesorter"  cellspacing="1" cellpadding="0" style="margin-top:0px;">
<thead>
  <tr>
    <th align="center" >แผนงาน/โครงการ</th>
    <th align="center" style="width:120px;">เจ้าของโครงการ</th>    
    <th align="center" style="width:150px;">กรอบงบประมาณ</th>
    <th align="center" style="width:80px;">%ค่าน้ำหนัก</th>    
    <th align="center" style="width:95px;">สถานะ</th>
    <th colspan="5" style="text-align:center;" >ปฏิบัติการ</th>
    </tr>
</thead>
<tbody>
<?php
	//ltxt::print_r($list);

	$i=($_REQUEST["start"]=='') ? 1: $_REQUEST["start"]+1;
	if($list){
          foreach($list as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}
?>
  <tr>
    <td valign="top" style="background-color:#EEE; font-weight: bold" onClick="swap('td-<?php echo $i;?>',this,'np<?php echo $i; ?>')">
        <img id="np<?php echo $i;?>" src="images/bullet/minimize.gif" align="absmiddle" style="border:none; background-color:#EEE;" width="16" highg="16"   />
        <?php  if($PItemCode != ""){ echo "[ ".$PItemCode." ] "; } echo $PItemName;?>    </td>
    <td style="background-color:#EEE; font-weight: bold; text-align:center;">-</td>
    <td style="background-color:#EEE; font-weight: bold;">&nbsp;</td>
    <td style="background-color:#EEE; font-weight: bold; text-align:center;"><?php echo $get->getSumPrjMass($PItemCode); ?></td>
    <td style="background-color:#EEE; font-weight: bold;">&nbsp;</td>
    <td colspan="2" style="background-color:#EEE; font-weight: bold"><a href="?mod=<?php echo LURL::dotPage('initproject_mass'); ?>&BgtYear=<?php echo $BgtYear; ?>&PItemCode=<?php echo $PItemCode; ?>" class="ico edit">ค่าน้ำหนักโครงการ</a></td>
    <td style="background-color:#EEE; font-weight: bold"><a id = "btn_copy" href="#" class="icon-copy">&nbsp;คัดลอกโครงการ</a></td>
    <td colspan="2" style="background-color:#EEE; font-weight: bold"><a href="?mod=<?php echo LURL::dotPage('initproject_order'); ?>&BgtYear=<?php echo $BgtYear; ?>&PItemCode=<?php echo $PItemCode; ?>" class="ico edit">เรียงโครงการ</a></td>
    </tr>
  	<tbody id="td-<?php echo $i;?>">	
  		  <?php
          	$listProject = $get->getProject($PItemCode,$BgtYear);
			//ltxt::print_r($listProject);
			if($listProject){
          		foreach($listProject as $listP) {
					foreach( $listP as $k=>$v){ ${$k} = $v;}
		  ?>
          <tr>
            <td valign="top" style="padding-left:15px" ><?php echo icoView($listP);?></td>
            <td valign="top"  align="center"><?php echo $get->getOrgShortName($BgtYear, $OrganizeCode);?></td>
            <td align="right" valign="top" ><?php echo number_format($PrjBudget,2);?></td>
            <td align="center" valign="top" ><?php echo ($PrjMass)?$PrjMass:"-"; ?></td>
            <td align="center" valign="top" ><?php echo icoActive($listP);?></td>
            <td style="width:86px;" nowrap="nowrap" valign="top"  ><?php echo icoAddPerson($listP);?></td>
             <td style="width:56px;" nowrap="nowrap" valign="top"  ><a class="ico edit" id = "edit_ws">WS</a></td>
             <td style="width:56px;" nowrap="nowrap" valign="top"  ><a class="ico edit" id = "edit_name">WS ผู้รับผิดชอบ</a></td>
             <td style="width:56px;" nowrap="nowrap" valign="top"  ><?php echo icoEdit($listP);?></td>
            <td style="width:56px;" valign="top"  nowrap="nowrap" ><?php echo icoDelete($listP);?></td>
          </tr>  
          <?php } }else{ ?>
           <tr>
            <td colspan="10" class="nullDataList">-ไม่มีรายการในฐานข้อมูล-</td>
            </tr>
  		  <?php } ?>	
  </tbody>
<?php

		$i++;
		}
	}
?>
</tbody>
</table>
<?php
if(!$list){
	echo '<div class="nullDataList">ไม่มีข้อมูล</div>';	
}
?>
<!--<div class="cms-box-navpage">
<?php //echo NavPage(array('total'=>$list['total'],'limit'=>$RowPerPage,'start'=>$_REQUEST["start"]));?>
</div>
-->      
<div id="dialog-edit_ws"  title="Workspace ที่เกี่ยวข้อง">
<table width="350" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td colspan="2"><select name="select" id="select" onchange="sort(this.value)" >
               <option value="" selected="selected">-</option>
               <option value="Vote DESC" >WorkSpace A</option>
               <option value="Vote ASC" >WorkSpace B</option>
               <option value="Vote DESC" >WorkSpace C</option>
             </select>
             &nbsp;
             <input type="button" class="btnActive" name="save2" id="save2" value="เพิ่ม" /></td>
         </tr>
         <tr>
           <td width="86%">1. WorkSpace A </td>
           <td width="14%" align="right"><input type="button" class="btnActive" name="save2" id="save2" value=" ลบ " /></td>
         </tr>
         <tr>
           <td>2. WorkSpace B </td>
           <td align="right"><input type="button" class="btnActive" name="save2" id="save2" value=" ลบ " /></td>
         </tr>
  </table>
</div>
<div id="dialog-edit_name"  title="WorkSpace ชื่อผู้รับผิดชอบ ">
			ชื่อผู้รับผิดชอบ : <select name="select" id="select" onchange="sort(this.value)" >
               <option value="" selected="selected">-</option>
               <option value="Vote DESC" >ชื่อผู้รับผิดชอบ 1</option>
               <option value="Vote ASC" >ชื่อผู้รับผิดชอบ 2 </option>
               <option value="Vote DESC" >ชื่อผู้รับผิดชอบ 3</option>
             </select>
            <br />
            <br />
            <table width="350" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td colspan="2"><select name="select" id="select" onchange="sort(this.value)" >
               <option value="" selected="selected">-</option>
               <option value="Vote DESC" >WorkSpace A</option>
               <option value="Vote ASC" >WorkSpace B</option>
               <option value="Vote DESC" >WorkSpace C</option>
             </select>
             &nbsp;
             <input type="button" class="btnActive" name="save2" id="save2" value="เพิ่ม" /></td>
         </tr>
         <tr>
           <td width="86%">1. WorkSpace A </td>
           <td width="14%" align="right"><input type="button" class="btnActive" name="save2" id="save2" value=" ลบ " /></td>
         </tr>
         <tr>
           <td>2. WorkSpace B </td>
           <td align="right"><input type="button" class="btnActive" name="save2" id="save2" value=" ลบ " /></td>
         </tr>
     </table>
</div>
<div id="dialog-copy_project"  title="คัดลอกโครงการปีที่ผ่านมา "><br>
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td colspan="2">แผนงานธรรมนูญสุขภาพ </td>
         </tr>
         <tr>
           <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="checkbox" value="checkbox" /> 
           55P02A  โครงการจัดสมัชชาสุขภาพแห่งชาติ<br />
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="checkbox" name="checkbox2" value="checkbox" />
55P02B  โครงการขับเคลื่อนมติสมัชชาสุขภาพแห่งชาติ<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="checkbox3" value="checkbox" />
55P02C  โครงการสนับสนุนสมัชชาสุขภาพเฉพาะพื้นที่และสมัชชาสุขภาพเฉพาะประเด็น ปีงบประมาณ ๒๕๕๖</td>
         </tr>
  </table>
</div>