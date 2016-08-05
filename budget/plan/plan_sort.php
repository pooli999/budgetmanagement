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
		'text' => 'เรียงลำดับ'.$MenuName,
	),
));

?>
<div class="sysinfo">
  <div class="sysname">เรียงลำดับ<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับเรียงลำดับ<?php echo $MenuName;?> </div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
  </tr>
</table>
<style type="text/css">
	.orderbox ul { list-style-type: none; margin: 0; padding: 0; margin-bottom: 5px; }
	.orderbox li { margin: 3px; padding: 3px; width: 95%px; border:1px solid #eee; background-color:#fff; cursor:n-resize; }
</style>    

<script type="text/javascript">
var __debug = true;

	JQ(function() {
		JQ("#sortable").sortable({
			revert: true
		});
		JQ("#draggable").draggable({
			connectToSortable: '#sortable',
			helper: 'clone',
			revert: 'invalid'
		});
		JQ("ul, li").disableSelection();
	});
	
	function SaveOrder()
	{

		var nOrder = '';
		JQ('#sortable > li').each(function(){
				nOrder += this.id + ',';
		});
		//alert(nOrder);
		JQ('#newOrder').val(nOrder);
		JQ('#adminForm').submit();

		
	}
	

	
</script>
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>&start=<?php echo $_REQUEST["start"];?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="saveorder" />
<input type="hidden" name="newOrder" id="newOrder" value="" />
</form>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
   <tr>
        <th valign="top">&nbsp;</th>
        <td class="hint">* Drag(คลิกเม้าท์ค้างไว้) ที่ชื่อหัวข้อ เพื่อเลื่อนขึ้นหรือเลื่อนลง</td>
   </tr>
   <tr>
    <th valign="top">รายการ  :</th>
    <td>
    <div class="orderbox">
        <ul id="sortable">
            <?php 
            $i=0;
           foreach($data as $row){
			   foreach( $row as $k=>$v){${$k} = $v;}
                echo '<li class="ui-state-default" id="'.$PLongId.'" >'.$PLongName.'</li>';
                $i++;
             } 
            ?>
        </ul>  
    </div> 
    </td>
  </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="button" name="button4" id="button4" value="บันทึกลำดับ" class="btnRed" onclick="SaveOrder()"  />
        <input name="cancel" type="button" value="ย้อนกลับ" class="btn cancle" onclick="history.back(-1);" /></td>
      </tr>
    </table>









