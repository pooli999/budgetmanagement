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

		if($_REQUEST['EnableStatus'] == 1){
			$_REQUEST['EnableStatus']='Y'; $Str = 'แสดง';
		}else{
			$_REQUEST['EnableStatus']='N'; $Str = 'ไม่แสดง';
		}
		$Topic = $this->getBookbankNumber($_REQUEST["BookbankId"]);

		LogFiles::SaveLog("ระบบการเงิน","เปลี่ยนสถานะเลขที่บัญชีธนาคารเป็น ".$Str,$_REQUEST["BookbankId"],$Topic);
		
		if($pk = $this->db->arecSave('tblbudget_finance_bookbank',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');	
		}
		echo $pk;
	}
	/*End*/
		
	/* 
	START #F2
	Function Name: Save 
	Description		: เพิ่ม/แก้ไข เลขที่บัญชีธนาคาร
	Parameter		: -
	Return Value 	: -
	*/	
	function Save(){
		if($pk = $this->db->arecSave('tblfinance_payment',$_POST)){	
			if($_POST["PaymentId"]=='')
				LogFiles::SaveLog("ระบบนการเงิน","เพิ่มข้อมูลการเงินจ่ายเงินและออกเช็ค",$pk,$_REQUEST["BookbankNumber"]);
			else
				LogFiles::SaveLog("ระบบนการเงิน","แก้ไขข้อมูลการเงินจ่ายเงินและออกเช็ค",$pk,$_REQUEST["BookbankNumber"]);
				
				//----------------
					//บันทึกรหัส eform 
					$sql = "DELETE FROM tblfinance_payment_list where PaymentId = ".$pk;
					$this->db->Execute($sql);
					$sql = "DELETE FROM tblfinance_payment_list_detail where PaymentId = ".$pk;
					$this->db->Execute($sql);
					$DataComp = array();
					for($a=0;$a <= $_POST["MaxDocCode"];$a++){ 
						if($_POST["DocCode".$a] != ""){
							$DataComp["PaymentId"] = $pk;
							$DataComp["DocCode"] = $_POST["DocCode".$a];
							$PaymentListId = $this->db->arecSave('tblfinance_payment_list',$DataComp);
							$sql = "Update tblfinance_doccode set PaymentStatus='Y' where DocCode = '".$_POST["DocCode".$a]."'"; // อัพเดทสาถนะจ่ายนเงินแล้ว
							$this->db->Execute($sql);
							LogFiles::SaveLog("ระบบการเงิน","ข้อมูลการเงินจ่ายเงินและออกเช็ค->รหัส Eform ",$PaymentListId,"เลช ชน ".$pk." รหัส".$_POST["DocCode".$a]);
							//บันทึก รายการค่าใช้จ่าย eform
							for($c=0;$c < $_POST["MaxDocCode"];$c++){ 
								$Datadetail = array();
								$Datadetail["PaymentListDetailId"] = "";
								$Datadetail["PaymentId"] = $pk;
								$Datadetail["PaymentListId"] = $PaymentListId;
								$Datadetail["DocCode"] = $_POST["DocCode".$a];
								$Datadetail["CostItemCode"] = $_POST["CostItemCode".$a."_".$c];
								$Datadetail["CastValue"] = $_POST["CastValue".$a."_".$c];
								$this->db->arecSave('tblfinance_payment_list_detail',$Datadetail);
							}
						}
					}
					//-----------------
					//บันทึกบริษัท
					$sql = "DELETE FROM tblfinance_payment_comp where PaymentId = ".$pk;
					$this->db->Execute($sql);
					$sql = "DELETE FROM tblfinance_payment_methods where PaymentId = ".$pk;
					$this->db->Execute($sql);
					$DataComp = array();
					for($a=0;$a<= $_POST["comp_line"];$a++){ 
						if($_POST["PartnerCode".$a] != ""){
							$DataComp["PaymentId"] = $pk;
							$DataComp["PartnerCode"] = $_POST["PartnerCode".$a];
							$DataComp["CashValue"] = $_POST["CashValue".$a];
							$DataComp["Tax"] = $_POST["Tax".$a];
							$DataComp["TaxW"] = $_POST["TaxW".$a];
							$PaymentCompId = $this->db->arecSave('tblfinance_payment_comp',$DataComp);
							// บันทึกข้อมูลที่อยู่
							$Dataparter = array();
							$Dataparter["DetailId"] = $_POST["DetailId".$a];
							$Dataparter["AddressDetail"] = $_POST["AddressDetail".$a];
							$Dataparter["PartnerCode"] = $_POST["PartnerCode".$a];
							$Dataparter["AddressGroupId"] = $_POST["AddressGroupId".$a];
							$Dataparter["Soi"] = $_POST["Soi".$a];
							$Dataparter["Road"] = $_POST["Road".$a];
							$Dataparter["ProvinceCode"] = $_POST["ProvinceCode".$a];
							$Dataparter["DistrictCode"] = $_POST["DistrictCode".$a];
							$Dataparter["SubDistrictCode"] = $_POST["SubDistrictCode".$a];
							$Dataparter["PostCode"] = $_POST["PostCode".$a];
							$this->db->arecSave('nh_in_partner_detail',$Dataparter);
							
							//บันทึกรูปแบบการจ่ายเงิน
								$DataMethods = array();
									for($b=0;$b < $_POST["bookbank_line".$a];$b++){ 
										if($_POST["BookbankId".$a."_".$b] != ""){
											$DataMethods["PaymentId"] = $pk;
											$DataMethods["PaymentCompId"] = $PaymentCompId;
											$DataMethods["PaymentType"] = $_POST["PaymentType".$a."_".$b];
											$DataMethods["BankId"] = $_POST["BankId".$a."_".$b];
											$DataMethods["BookbankId"] = $_POST["BookbankId".$a."_".$b];
											$DataMethods["PaymentNumber"] = $_POST["PaymentNumber".$a."_".$b];
											$DataMethods["PaymentValue"] = $_POST["PaymentValue".$a."_".$b];
											$PaymentMethodsId = $this->db->arecSave('tblfinance_payment_methods',$DataMethods);
										}
									}
							//-----------------
							LogFiles::SaveLog("ระบบการเงิน","ข้อมูลการเงินจ่ายเงินและออกเช็ค->รายการการเงินจ่ายเงินและออกเช็ค",$PaymentCompId,"รหัสจ่ายบริษัท ".$pk." รหัสบริษัท".$_POST["PartnerCode"])." เงินสด".$_POST["CashValue".$a];
						}
					}
				//-----------------
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}

	}
	/*End*/
	
	/* 
	START #F3
	Function Name: Delete 
	Description		: ลบประเภทกิจกรรม
	Parameter		: -
	Return Value 	: -
	*/	
	function Delete(){
		
		$Topic = "";
		LogFiles::SaveLog("ระบบการเงิน","ลบข้อมูลการเงินจ่ายเงินและออกเช็ค",$_REQUEST["id"],$Topic);
		// อัพเดท eform ให้เป็นสถานะยังไม่จ่ายเงิน
			$sql="select * from tblfinance_payment_list where PaymentId = ".$_REQUEST["id"];
			$this->db->setQuery($sql);
			$this->db->limit = $limit;
			$list2 = $this->db->loadDataSet();
			if($list2["rows"]){
			  foreach($list2["rows"] as $r1 ) {
					foreach( $r1 as $k=>$v){ ${$k} = $v;}
						$sql = "Update tblfinance_doccode set PaymentStatus='N' where DocCode = '".$r1->DocCode."'";
						$this->db->Execute($sql);
					}
				}
		//------------------------------------------------------
		$sql = "Update tblfinance_payment set DeleteStatus='Y' where PaymentId = ".$_REQUEST["id"]."";
		$this->db->Execute($sql);
		$sql = "Update tblfinance_payment_comp set DeleteStatus='Y' where PaymentId = ".$_REQUEST["id"]."";
		$this->db->Execute($sql);
		$sql = "Update tblfinance_payment_list set DeleteStatus='Y' where PaymentId = ".$_REQUEST["id"]."";
		$this->db->Execute($sql);
		$sql = "Update  tblfinance_payment_methods set DeleteStatus='Y' where PaymentId = ".$_REQUEST["id"]."";
		$this->db->Execute($sql);
		
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
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
					$sql = "Update tblbudget_finance_bookbank set Ordering='$i' where BookbankId = '".$id."'  ";
				//	echo "<pre>$sql</pre>";
					$this->db->Execute($sql);					
					$i++;
				}
			}	
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );
	}
	/*End*/
		
}
?>