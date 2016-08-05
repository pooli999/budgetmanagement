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
	Function Name: changeStatus 
	Description		: เปลี่ยนสถานะขั้นตอนการกลั่นกรองงบประมาณเป็น แสดง หรือไม่แสดง
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
		
		$Topic = $this->getPrjName($_REQUEST["PrjId"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","เปลี่ยนสถานะโครงการตามแผนงานหลักเป็น ".$Str,$_REQUEST["PrjId"],$Topic);
		
		if($pk = $this->db->arecSave('tblbudget_project',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&BgtYear='.$_REQUEST["BgtYear"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}	/*End*/


	/* 
	Function Name: getGenPrjCode 
	Description		: รัน Auto PrjCode 
	Parameter		: -
	Return Value 	: -
	*/	
	function getGenPrjCode($BgtYear,$PItemCode){

			$PITem = $this->getPItemCode($PItemCode);
			$OldPrjCode = $this->getOldPrjCode($BgtYear,$PItemCode);
			//echo "OldPrjCode=".$OldPrjCode;
			
			if(!empty($OldPrjCode)){
				$subCode = substr($OldPrjCode,5,1);
				$nextChar = chr(ord($subCode) + 1); 
			}else{
				$nextChar = "A";
			}
			
		$Code = $PITem.$nextChar;	//echo "Code=".$Code;
		return $Code;
	}
	
	/*End*/

	/* 
	Function Name: Save 
	Description		: เพิ่ม/แก้ไข ขั้นตอนการกลั่นกรองงบประมาณ
	Parameter		: -
	Return Value 	: -
	*/	
	function Save(){
		//ltxt::print_r($_POST);
		
		if(($_POST["PrjId"] != "" && $_POST["NewGen"] == "Y") || $_POST["PrjId"] == ""){
			
			$genPrjCode = $this->getGenPrjCode($_POST["BgtYear"],$_POST["PItemCode"]);	
			$_POST["PrjCode"] = $genPrjCode;
			//echo "genPrjCode=".$genPrjCode;
		
		}

		if($pk = $this->db->arecSave('tblbudget_project',$_POST)){		
		
/*			$actSelect = $this->getProjectDetailActRecordSet($pk);
			 foreach($actSelect as $r){
				 $checkPrjActId = $r->PrjActId;
				 echo "checkPrjActId=".$checkPrjActId;
				 if(@in_array($checkPrjActId,$_POST["PrjActId"])){
					// 
				 }else{
					$sqldelact = "DELETE FROM tblbudget_project_activity where PrjActId = ".$checkPrjActId."  ";
					$this->db->Execute($sqldelact);
			
				 }
			 }
		
			$ArrPerson = explode(",",$_POST["MultiCode_PersonalSelect"]);
*/
		
		
			// Add Person
			$ArrPerson = explode(",",$_POST["MultiCode_PersonalSelect"]);
			//ltxt::print_r($ArrPerson);
			$sql = "DELETE FROM tblbudget_project_person where PrjId = '".$_POST["PrjId"]."'  ";
			$this->db->Execute($sql);
			foreach($ArrPerson as $valp){
				if($valp != 0){
					$DataPersonal["PrjId"] 			= $_POST["PrjId"];
					$DataPersonal["PersonalCode"] 		= $valp;
					$DataPersonal["CreateBy"] 				= $_POST["CreateBy"];
					$DataPersonal["CreateDate"] 			= $_POST["CreateDate"];		
					$this->db->arecSave('tblbudget_project_person',$DataPersonal);
				}
			}		
			
			if($_POST["PrjId"]=='')
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","เพิ่มโครงการตามแผนงานหลัก",$pk,$_REQUEST["PrjName"]);
			else
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","แก้ไขโครงการตามแผนงานหลัก",$pk,$_REQUEST["PrjName"]);

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&BgtYear='.$_REQUEST["BgtYear"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}

	}
	/*End*/
	
	/* 
	START #F2
	Function Name: SavePerson 
	Description		: เพิ่ม/แก้ไข รายชื่อผู้รายงานผล
	Parameter		: -
	Return Value 	: -
	*/	
	function SavePerson(){
			
	//	ltxt::print_r($_POST);
			
			$taskPerson = $this->getTaskPerson($_POST["PrjId"]);
			//ltxt::print_r($taskPerson);
			$i=0;
			foreach($taskPerson as $v){
					//echo 'PersonalCode='.$_POST["PersonalCode"][$i];
					if($_POST["PersonalCode"][$i] == $v->PersonalCode){  $ResultStatus = "Y"; }else{ $ResultStatus = "N"; }
					$DataPersonal["PersonId"] = $_POST["PersonId"][$i];
					$DataPersonal["ResultStatus"] = $ResultStatus;
					$pk = $this->db->arecSave('tblbudget_project_person',$DataPersonal);
					
					if($_POST["PersonId"][$i]=='')
						LogFiles::SaveLog("ระบบนโยบายแผนงาน","เพิ่มรายชื่อผู้รายงานผล",$pk,$_REQUEST["PersonalCode"][$i]);
					else
						LogFiles::SaveLog("ระบบนโยบายแผนงาน","แก้ไขรายชื่อผู้รายงานผล",$pk,$_REQUEST["PersonalCode"][$i]);
					
				$i++;
			}			
		
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&BgtYear='.$_REQUEST["BgtYear"], 'redirect' );
		
	}
	/*End*/
	
	
	/* 
	START #F3
	Function Name: Delete 
	Description		: ลบขั้นตอนการกลั่นกรองงบประมาณ
	Parameter		: -
	Return Value 	: -
	*/	
	function Delete(){
		
		$Topic = $this->getPrjName($_REQUEST["id"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","ลบโครงการตามแผนงานหลัก",$_REQUEST["id"],$Topic);
		
		$sql = "Update tblbudget_project set DeleteStatus='Y' where PrjId = ".$_REQUEST["id"]."";
		$this->db->Execute($sql);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&BgtYear='.$_REQUEST["BgtYear"], 'redirect' );
	}
	/*End*/
	
	/* 
	START #F4
	Function Name: SaveOrder 
	Description		: เรียงลำดับขั้นตอนการกลั่นกรองงบประมาณ
	Parameter		: -
	Return Value 	: -
	*/
/*	function SaveOrder()
	{
			if($_REQUEST["BgtYear"] == ""){$_REQUEST["BgtYear"] = date("Y")+543;}
			$ArrOrder = explode(",",$_REQUEST["newOrder"]);
			//$i = count($ArrOrder);
			$i=1;
			foreach($ArrOrder as $id){
				if($id != ""){
					$sql = "Update tblbudget_project set Ordering='$i', ScreenLevel='$i'  where PrjId = '".$id."'  and  BgtYear= '".$_REQUEST["BgtYear"]."'  ";
					//echo "<pre>$sql</pre>";
					$this->db->Execute($sql);					
					$i++;
				}
			}	

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&BgtYear='.$_REQUEST["BgtYear"], 'redirect' );
			
	}*/
	/*End*/
	
	function SaveMass(){
		ltxt::print_r($_POST);
		$this->db->debug(2);
		for($i=0;$i<count($_POST["PrjId"]);$i++){
			$data["PrjId"]		= $_POST["PrjId"][$i];
			$data["PrjMass"] = $_POST["PrjMass"][$i];
			$this->db->arecSave('tblbudget_project',$data);
		}
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"].'&BgtYear='.$_POST["BgtYear"], 'redirect' );
	}
		
}
?>