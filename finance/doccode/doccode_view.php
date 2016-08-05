<?php
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),	
	array(
		'text' => "รายละเอียด".$MenuName,
	),
));

//ltxt::print_r($_GET);
?>

<script language="javascript" type="text/javascript">
/* <![CDATA[ */
	JQ(document).ready(function(){
	
		JQ("#exd").show();
		
		JQ('#exd').show('fade');
		JQ('#a-exd').addClass('icon-decre');
		JQ('#a-exd').removeClass('icon-incre');
		JQ('#a-exd').html('ซ่อนรายละเอียด');
	
	});	
/* ]]> */
</script>

<div class="sysinfo">
  <div class="sysname">รายละเอียดแบบฟอร์ม</div>
  <div class="sysdetail">สำหรับแสดงรายละเอียด<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter2">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>')" /></td>
  </tr>
</table>

<?php
switch($_REQUEST["FormCode"]){
	case 'FF001':
	case 'FF002':
			$inc_page = "modules/backoffice/finance/form/advances/view.php";
			break;	
	case 'FF003':
			$inc_page = "modules/backoffice/finance/form/clear/view.php";
			break;	
	case 'FF004':
			$inc_page = "modules/backoffice/finance/form/advances_pay/view.php";
			break;	
	case 'FF005':		
	case 'FF006':
			$inc_page = "modules/backoffice/finance/form/meeting/view.php";
			break;		
	case 'FF007':
			$inc_page = "modules/backoffice/finance/form/meeting_pay/view.php";
			break;				
	case 'FF008':
			$inc_page = "modules/backoffice/finance/form/general/view.php";
			break;
	case 'FF009':
			$inc_page = "modules/backoffice/finance/form/general_pay/view.php";
			break;
	case 'FF011':
			$inc_page = "modules/backoffice/finance/form/training/view.php";
			break;		
	case 'FF012':
			$inc_page = "modules/backoffice/finance/form/pay/view.php";
			break;									
	case 'FP001':
			$inc_page = "modules/backoffice/finance/form/mat/view.php";
			break;			
	case 'FP002':
			$inc_page = "modules/backoffice/finance/form/mat/view.php";
			break;
	case 'FP005':
			$inc_page = "modules/backoffice/finance/form/mat_pay/view.php";
			break;				
	case 'FP003':
	case 'FP004':
			$inc_page = "modules/backoffice/finance/form/urgent/view.php";
			break;				
	case 'FH005':
			$inc_page = "modules/backoffice/finance/form/ot/view.php";
			break;				
	case 'FH006':
			$inc_page = "modules/backoffice/finance/form/ot_pay/view.php";
			break;	
	case 'FB001':
			$inc_page = "modules/backoffice/finance/form/transfer/view.php";
			break;				
	case 'FC001':
			$inc_page = "modules/backoffice/finance/form/mou/view.php";
			break;				
	case 'FC002':
			$inc_page = "modules/backoffice/finance/form/mou_pay/view.php";
			break;				

}

/*switch($_REQUEST["FormCode"]){
	case 1:
	case 2:
	case 3:
			$inc_page = "modules/backoffice/finance/form/general/view.php";
			break;
	case 4:
			$inc_page = "modules/backoffice/finance/form/pay/view.php";
			break;
	case 5:
	case 6:
			$inc_page = "modules/backoffice/finance/form/meeting/view.php";
			break;
	case 7:
			$inc_page = "modules/backoffice/finance/form/ot/view.php";
			break;
	case 8:
			$inc_page = "modules/backoffice/finance/form/transfer/view.php";
			break;
	case 9:
			$inc_page = "modules/backoffice/finance/form/training/view.php";
			break;
	case 10:
	case 11:
			$inc_page = "modules/backoffice/finance/form/advances/view.php";
			break;
	case 12:
	case 13:
			$inc_page = "modules/backoffice/finance/form/clear/view.php";
			break;
	case 14:
	case 15:
			$inc_page = "modules/backoffice/finance/form/urgent/view.php";
			break;
	case 16:
	case 17:
			$inc_page = "modules/backoffice/finance/form/mat/view.php";
			break;
	case 18:
			$inc_page = "modules/backoffice/finance/form/general_pay/view.php";
			break;
	case 19:
			$inc_page = "modules/backoffice/finance/form/meeting_pay/view.php";
			break;
	case 20:
			$inc_page = "modules/backoffice/finance/form/advances_pay/view.php";
			break;
	case 21:
			$inc_page = "modules/backoffice/finance/form/ot_pay/view.php";
			break;
	case 22:
			$inc_page = "modules/backoffice/finance/form/mat_pay/view.php";
			break;
}
*/

include($inc_page);
?>


<div style="text-align:center; padding:10px">
    <input type="button" name="button3" id="button3" value=" ย้อนกลับ " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>&start=<?php echo $_REQUEST["start"];?>&BgtYear=<?php echo $BgtYear; ?>')" />
</div>
