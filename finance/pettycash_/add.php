  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
<?php
include("config.php");
include("helper.php");
include("data.php");

$this->DOC->setPathWays(array(
	array(
		'text' => getMenuItem(lurl::dotPage($startupPage))->MenuName,
		'link' => '?mod='.lurl::dotPage($startupPage)
	),
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'เพิ่มข้อมูล'.$MenuName
	),
));
?>
    <script>
  $(function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 100000,
	 step: 5000,
      values: [ 10000, 90000 ],
      slide: function( event, ui ) {
      //  $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		$( "#a_min" ).val(ui.values[ 0 ]);
	 	 $( "#a_max" ).val(ui.values[ 1 ]);
      }
    });
    //$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +" - $" + $( "#slider-range" ).slider( "values", 1 ) );
	  
  });
  </script>
<div class="sysinfo">
  <div class="sysname">เพิ่มรายการข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไขข้อมูล<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
  </tr>
</table>
<div id="import-box">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="PersonalId" id="PersonalId" value="<?php echo $_GET['id']?>" />
<fieldset  >
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
    <tr>
      <th height="25">กำหนดเงินสดย่อย </th>
      <td  class="require">&nbsp;</td>
      <td>
	  <p>
<!--  <label for="amount">Price range:</label>
  <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">-->
	</p>
	 
	<div id="slider-range"></div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  width="10%">0</td>
    <td width="90%"></td>
    <td width="10%" align="right">100,000</td>
  </tr>
</table>	  </td>
      <td align="center" valign="top"></td>
    </tr>
    <tr>
      <th width="150" height="25" align="right">&nbsp;</th>
      <td width="8"  class="require">&nbsp;</td>
      <td><label for="select"></label>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>จุดแจ้งเตือน:
              <input id = "a_min" type="text" name="textfield2" />
บาท </td>
            <td width="36%" align="right">เพดานเงินสดย่อย:
              <input id = "a_max" type="text" name="textfield" />
บาท</td>
          </tr>
        </table></td>
      <td width="163" align="center" valign="top"></td>
    </tr>
    <tr>
      <th>&nbsp;</th>
      <td>&nbsp;</td>
      <td colspan="2"><input type="button" name="button42" id="button42" value="บันทึก" class="btnActive" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&amp;id=<?php echo $_REQUEST['id'];?>');">
        <input name="cancel2" type="button" value="ยกเลิก" class="btn cancle" onclick="history.back(-1);" /></td>
    </tr>
</table>
  </fieldset>
</form>
</div>
