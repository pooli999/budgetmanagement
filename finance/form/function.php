<?php       
include("config.php");
include("helper.php");
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
	
	function changeStatus()
	{
		if($_REQUEST['EnableStatus'] == 1){
			$_REQUEST['EnableStatus']='Y'; $Str = 'แสดง';
		}else{
			$_REQUEST['EnableStatus']='N'; $Str = 'ไม่แสดง';
		}
		
		$Status = "เปลี่ยนสถานะเป็น".$Str;
		LogFiles::SaveLog("แบบฟอร์มอิเล็กทรอนิกส์","เปลี่ยนแบบฟอร์มเอกสารขออนุมัติเบิกเงินยืมทดรองจ่าย",$_REQUEST["EFormId"],$Status);
		
		if($pk = $this->db->arecSave('tblintra_eform_advance',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}
	//  End Not Remove  //
	
	function saveDocCode(){ 
		$this->db->debug(2);
		ltxt::print_r($_POST);
		if(!$_POST["DocCode"]){
			$_POST["DocCode"] 			= $this->genDocCode();
			$_POST["AutoNo"] 			= $this->getMaxNo();
			$_POST["DocDate"] 			= $_POST["CreateDate"];
			$_POST["DocStatusId"]			= "1";
			$_POST["Topic"] 				= $this->getTopicDefault($_POST["FormCode"]);
			$_POST["Title"] 				= $_POST["Topic"];
		}
		$_POST["BgtYear"] 			= $_POST["BgtYearCheckIn"];
		$_POST["PItemCode"] 		= $_POST["PItemCodeCheckIn"];
		$_POST["PrjDetailId"] 		= $_POST["PrjDetailIdCheckIn"];
		$_POST["PrjId"] 				= $this->getPrjId($_POST["PrjDetailIdCheckIn"]);
		$_POST["PrjActCode"] 		= $_POST["PrjActCodeCheckIn"];
		$_POST["SourceExId"] 		= $_POST["SourceExIdCheckIn"];
		$_POST["UseStatus"]			= "Y";
		$_POST["UseBy"]				= "1";//1 = เป็น เลชที่ สช.น ที่นำไปใช้ในเอกสารของระบบ E-Form , 2= เป็น เลชที่ สช.น ที่นำไปใช้ในเอกสารของระบบสารบรรณ , 3 = เป็น เลชที่ สช.น ที่นำไปใช้ในเอกสารของแบบฟอร์มดาวน์โหลด
		$_POST["EnableStatus"]		= "Y";
		$_POST["DeleteStatus"]		= "N";
		$_POST["FormCode"] 		= $_POST["FormCode"];
		$_POST["CheckIn"] = "Y";
		$_POST["CheckInBy"] = $_SESSION["Session_PersonalCode"];
		$this->db->arecSave('tblfinance_doccode',$_POST);
		$Form = strtolower($_POST["FormCode"]);
		LTXT::_( '?mod=front.form.'.$Form.'.add&FormCode='.$_POST["FormCode"].'&DocCode='.$_POST["DocCode"], 'redirect' );
	}
	
	function saveDocCodeChain(){ 
		$this->db->debug(2);
		ltxt::print_r($_REQUEST);
		$_REQUEST["DocCode"] 		= $this->genDocCode();
		$_REQUEST["DocCodeRefer"] 		= $_REQUEST["DocCodeRefer"];
		$_REQUEST["AutoNo"] 			= $this->getMaxNo();
		$_REQUEST["DocDate"] 			= $_REQUEST["CreateDate"];
		$_REQUEST["DocStatusId"]		= "1";
		$_REQUEST["Topic"] 				= $this->getTopicDefault($_REQUEST["FormCode"]);
		$_REQUEST["Title"] 				= $_REQUEST["Topic"];
		$HData = $this->getHoldDataDetail($_REQUEST["DocCodeRefer"]);
		foreach($HData as $r ) {
			foreach( $r as $k=>$v){ ${$k} = $v;}
		}
		$_REQUEST["BgtYear"] 			= $BgtYear;
		$_REQUEST["PItemCode"] 		= $PItemCode;
		$_REQUEST["PrjDetailId"] 		= $PrjDetailId;
		$_REQUEST["PrjId"] 				= $PrjId;
		$_REQUEST["PrjActCode"] 		= $PrjActCode;
		$_REQUEST["SourceExId"] 		= $SourceExId;
		$_REQUEST["RQOrgRoundCode"] 	= $RQOrgRoundCode;
		$_REQUEST["RQOrganizeCode"] 		= $RQOrganizeCode;
		$_REQUEST["RQPersonalCode"] 		= $RQPersonalCode;
		$_REQUEST["RQPositionId"] 			= $RQPositionId;
		$_REQUEST["UseStatus"]		= "Y";
		$_REQUEST["UseBy"]				= "1";//1 = เป็น เลชที่ สช.น ที่นำไปใช้ในเอกสารของระบบ E-Form , 2= เป็น เลชที่ สช.น ที่นำไปใช้ในเอกสารของระบบสารบรรณ , 3 = เป็น เลชที่ สช.น ที่นำไปใช้ในเอกสารของแบบฟอร์มดาวน์โหลด
		$_REQUEST["EnableStatus"]	= "Y";
		$_REQUEST["DeleteStatus"]	= "N";
		$_REQUEST["FormCode"] 		= $_REQUEST["FormCode"];
		$_REQUEST["CheckIn"] 			= "Y";
		$_REQUEST["CheckInBy"] 		= $_SESSION["Session_PersonalCode"];
		$this->db->arecSave('tblfinance_doccode',$_REQUEST);
		
		//check in เอกสารหลักการ
		$sql = "Update tblfinance_doccode set CheckIn='Y' , CheckInBy='".$_SESSION["Session_PersonalCode"]."'  where DocCode = '".$_REQUEST["DocCodeRefer"]."'  ";
		$this->db->Execute($sql);
		
		$Form = strtolower($_REQUEST["FormCode"]);
		LTXT::_( '?mod=front.form.'.$Form.'.add&FormCode='.$_REQUEST["FormCode"].'&DocCodeRefer='.$_REQUEST["DocCodeRefer"].'&DocCode='.$_REQUEST["DocCode"], 'redirect' );
	}
	
	
	function saveDocCodeBill(){ 
		$this->db->debug(2);
		ltxt::print_r($_REQUEST);
		$_REQUEST["DocCode"] 		= $this->genDocCode();
		$_REQUEST["DocCodeRefer"] 		= $_REQUEST["DocCodeRefer"];
		$_REQUEST["AutoNo"] 			= $this->getMaxNo();
		$_REQUEST["DocDate"] 			= $_REQUEST["CreateDate"];
		$_REQUEST["DocStatusId"]		= "1";
		$_REQUEST["Topic"] 				= $this->getTopicDefault($_REQUEST["FormCode"]);
		$_REQUEST["Title"] 				= $_REQUEST["Topic"];
		$HData = $this->getChainDataDetail($_REQUEST["DocCodeRefer"]);
		foreach($HData as $r ) {
			foreach( $r as $k=>$v){ ${$k} = $v;}
		}
		$_REQUEST["BgtYear"] 			= $BgtYear;
		$_REQUEST["PItemCode"] 		= $PItemCode;
		$_REQUEST["PrjDetailId"] 		= $PrjDetailId;
		$_REQUEST["PrjId"] 				= $PrjId;
		$_REQUEST["PrjActCode"] 		= $PrjActCode;
		$_REQUEST["SourceExId"] 		= $SourceExId;
		$_REQUEST["RQOrgRoundCode"] 	= $RQOrgRoundCode;
		$_REQUEST["RQOrganizeCode"] 		= $RQOrganizeCode;
		$_REQUEST["RQPersonalCode"] 		= $RQPersonalCode;
		$_REQUEST["RQPositionId"] 			= $RQPositionId;
		$_REQUEST["UseStatus"]		= "Y";
		$_REQUEST["UseBy"]				= "1";//1 = เป็น เลชที่ สช.น ที่นำไปใช้ในเอกสารของระบบ E-Form , 2= เป็น เลชที่ สช.น ที่นำไปใช้ในเอกสารของระบบสารบรรณ , 3 = เป็น เลชที่ สช.น ที่นำไปใช้ในเอกสารของแบบฟอร์มดาวน์โหลด
		$_REQUEST["EnableStatus"]	= "Y";
		$_REQUEST["DeleteStatus"]	= "N";
		$_REQUEST["FormCode"] 		= $_REQUEST["FormCode"];
		$_REQUEST["CheckIn"] 			= "Y";
		$_REQUEST["CheckInBy"] 		= $_SESSION["Session_PersonalCode"];
		$this->db->arecSave('tblfinance_doccode',$_REQUEST);
		
		//check in เอกสารหลักการ
		$sql = "Update tblfinance_doccode set CheckIn='Y' , CheckInBy='".$_SESSION["Session_PersonalCode"]."'  where DocCode = '".$_REQUEST["DocCodeRefer"]."'  ";
		$this->db->Execute($sql);
		
		$Form = strtolower($_REQUEST["FormCode"]);
		LTXT::_( '?mod=front.form.'.$Form.'.add&FormCode='.$_REQUEST["FormCode"].'&DocCodeRefer='.$_REQUEST["DocCodeRefer"].'&DocCode='.$_REQUEST["DocCode"], 'redirect' );
	}
	
	
	
}// end class
?>