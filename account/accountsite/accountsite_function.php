<?php
include("config.php");
include($KeyPage."_helper.php");
class sFunction extends sHelper{
	var $RedirectPage;
	var $PathUpload;
	//  Not Remove  //
	function RedirectPage($RPage)
	{
		$this->RedirectPage = $RPage;
	}

	function setUploadPath($Path)
	{
		$this->PathUpload = $Path;
	}

	function Reload($redirect_page)
	{
		LTXT::_( $redirect_page, 'redirect' );
	}

	/*
	START #F1
	Function Name: changeStatus
	Description		: เปลี่ยนสถานะประเภทกิจกรรมเป็น แสดง หรือไม่แสดง
	Parameter		: -
	Return Value 	: -
	*/

	function changeStatus()
	{
		$param = "&start=".$_REQUEST["start"]."&tsearch=".$_REQUEST["tsearch"]."&search=".$_REQUEST["search"]."&AcSeriesId=".$_REQUEST["AcSeriesId"];
		//$Topic = $this->getPartnerName($_REQUEST["id"]);
		$Topic = "";
		LogFiles::SaveLog("จัดการผังบัญชี","เปลี่ยนสถานะข้อมูลผังบัญชี",$_REQUEST["id"],$Topic);

		$sql = "Update ac_chart set EnableStatus='".$_REQUEST["EnableStatus"]."' where AcChartId = ".$_REQUEST["id"]."";
//echo $sql;
		$this->db->Execute($sql);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).$param, 'redirect' );

	}
	/*End*/

	/*
	START #F2
	Function Name: Save
	Description		: เพิ่ม/แก้ไข ผังบัญชี
	Parameter		: -
	Return Value 	: -
	*/
	function Save(){
		if($pk = $this->db->arecSave('ac_chart',$_POST)){
			if($_POST["AcChartId"]=='')
				LogFiles::SaveLog("ระบบบัญชี","เพิ่มข้อมูลธผังบัญชี",$pk,$_REQUEST["AcChartCode"]." ".$_REQUEST["ThaiName"]);
			else
				LogFiles::SaveLog("ระบบบัญชี","แก้ไขข้อมูลผังบัญชี",$pk,$_REQUEST["AcChartCode"]." ".$_REQUEST["ThaiName"]);

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&AcSeriesId='.$_REQUEST["AcSeriesId"].'&AcSeriesName='.$_REQUEST["AcSeriesName"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}

	}
	/*End*/

	/*
	START #F3
	Function Name: Delete
	Description		: ลบประเภทผังบัญชี
	Parameter		: -
	Return Value 	: -
	*/
	function Delete(){

		$AcName = $this->getAcName($_REQUEST["id"]);
		LogFiles::SaveLog("ระบบบัญชี","ลบข้อมูลผังบัญชี",$_REQUEST["id"],$AcName);

		$sql = "Update ac_chart set DeleteStatus='Y' where AcChartId = ".$_REQUEST["id"];
		echo $sql;
		$this->db->Execute($sql);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&AcSeriesId='.$_REQUEST["AcSeriesId"].'&AcSeriesName='.$_REQUEST["AcSeriesName"], 'redirect' );
	}
	/*End*/

	/*
	START #F4
	Function Name: SaveOrder
	Description		: เรียงลำดับประเภทกิจกรรม
	Parameter		: -
	Return Value 	: -
	*/
	function SaveOrder()
	{
			$ArrOrder = explode(",",$_REQUEST["newOrder"]);
			//$i = count($ArrOrder);
			$i=1;
			foreach($ArrOrder as $id){
				if($id != ""){
					$sql = "Update tblbudget_finance_bank set Ordering='$i' where BankId = '".$id."'  ";
					echo "<pre>$sql</pre>";
					$this->db->Execute($sql);
					$i++;
				}
			}

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );

	}
	/*End*/

}
?>
