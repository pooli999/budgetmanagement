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
	Description		: เปลี่ยนสถานะรายการค่าใช้จ่ายเป็น แสดง หรือไม่แสดง
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
		
		$Topic = $this->getCostName($_REQUEST["CostItemId"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","เปลี่ยนสถานะข้อมูลพื้นฐานในส่วนของรายการค่าใช้จ่ายเป็น ".$Str,$_REQUEST["CostItemId"],$Topic);
		
		if($pk = $this->db->arecSave('tblbudget_init_cost_item',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}	
	
	
	/*End*/
		
	/* 
	START #F2
	Function Name: Save 
	Description		: เพิ่ม/แก้ไข รายการค่าใช้จ่าย
	Parameter		: -
	Return Value 	: -
	*/	
	function Save(){
		
		//ltxt::print_r($_POST);
		
		$checkLevel = $this->getLevel($_POST["ParentCode"]);
		$_POST["LevelId"] = $checkLevel+1;
		
		$sql = "Update tblbudget_init_cost_item set HasChild='Y' where CostItemCode = ".$_POST["ParentCode"]."";
		$this->db->Execute($sql);
		
		if($_POST["CostItemId"]==''){
			$_POST["HasChild"] = 'N';
		}else{
			$checkHasChild = $this->getHasChild($_POST["CostItemCode"]);
			//echo  "checkHasChild= ".$checkHasChild["total"];
			if($checkHasChild["total"] > 0){ $_POST["HasChild"] = 'Y';}else{$_POST["HasChild"] = 'N';}
			
		}// end CostItemId
		
/*		$checkParentHasChild = $this->getHasChild($_POST["ParentCode"]);
		echo  "checkParentHasChild= ".$checkParentHasChild["total"];
*/
			
		if($pk = $this->db->arecSave('tblbudget_init_cost_item',$_POST)){						
			
			if($_POST["CostItemId"]=='')
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","เพิ่มข้อมูลพื้นฐานในส่วนรายการค่าใช้จ่าย",$pk,$_REQUEST["CostName"]);
			else
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","แก้ไขข้อมูลข้อมูลพื้นฐานในส่วนของรายการค่าใช้จ่าย",$pk,$_REQUEST["CostName"]);

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}
				
		/*
		//ltxt::print_r($_POST);
		if($_REQUEST["CostItemId"] == ""){
			
			$_POST["HasChild"] = 'N';
			if($_POST["ParentCode"] == 0){	
		
			$maxCode = $this->getMaxCode();
			$_POST["LevelId"]  = 1;
			$_POST["CostItemCode"]  = "0".$maxCode."0000";
			//echo "CostItemCode= ".$_POST["CostItemCode"];
			
		}else{
			//echo "ParentCode= ".$_POST["ParentCode"]."<br>";
			//echo "SubParentCode= ".substr($_POST["ParentCode"],2,6);
			
			if(substr($_POST["ParentCode"],2,6) == "0000"){
				
				$_POST["LevelId"]  = 2;
				
				$maxCode = $this->getMaxCode2($_POST["ParentCode"]);
				$addCode = substr($maxCode,3,1)+1; // ตัวที่ 4 บวก1
				
				if(strlen($addCode) == 1){
					$preCode = substr($maxCode,0,3); // เอา 3 ตัวหน้า
				}else{
					$preCode = substr($maxCode,0,2); // เอาเฉพาะ 2 ตัวหน้า
				}
				
				$_POST["CostItemCode"] = $preCode.$addCode."00";

				//echo "maxCode= ".$maxCode."<br>";
				//echo "preCode= ".$preCode."<br>";
				//echo "addCode= ".$addCode."<br>";
				//echo "CostItemCode= ".$_POST["CostItemCode"]."<br>";

			}else{
				$_POST["LevelId"]  = 3;
				$maxCode = $this->getMaxCode3($_POST["ParentCode"]);
				$addCode =  $maxCode+1;
				if($maxCode != ""){
						$_POST["CostItemCode"] = "0".$addCode;
					
				}else{
					$_POST["CostItemCode"] = substr($addCode,1,5).$addCode;
				}
	
			}
			
		}
		}
		
		if($pk = $this->db->arecSave('tblbudget_init_cost_item',$_POST)){						
			
			if($_POST["CostItemId"]=='')
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","เพิ่มข้อมูลพื้นฐานในส่วนรายการค่าใช้จ่าย",$pk,$_REQUEST["CostName"]);
			else
				LogFiles::SaveLog("ระบบนโยบายแผนงาน","แก้ไขข้อมูลข้อมูลพื้นฐานในส่วนของรายการค่าใช้จ่าย",$pk,$_REQUEST["CostName"]);

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
			
		}else{
			echo ltxt::_('Error!','jalert');
		}

	*/}
	/*End*/
	
	/* 
	START #F3
	Function Name: Delete 
	Description		: ลบรายการค่าใช้จ่าย
	Parameter		: -
	Return Value 	: -
	*/	
	function Delete(){
		$Topic = $this->getCostName($_REQUEST["id"]);
		LogFiles::SaveLog("ระบบนโยบายแผนงาน","ลบข้อมูลพื้นฐานในส่วนของรายการค่าใช้จ่าย",$_REQUEST["id"],$Topic);
		
		$sql = "Update tblbudget_init_cost_item set DeleteStatus='Y' where CostItemId = ".$_REQUEST["id"]."";
		$this->db->Execute($sql);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage).'&start='.$_REQUEST["start"], 'redirect' );
	}
	/*End*/
	
	/* 
	START #F4
	Function Name: SaveOrder 
	Description		: เรียงลำดับรายการค่าใช้จ่าย
	Parameter		: -
	Return Value 	: -
	*/
/*	function SaveOrder()
	{
			$ArrOrder = explode(",",$_REQUEST["newOrder"]);
			//$i = count($ArrOrder);
			$i=1;
			foreach($ArrOrder as $id){
				if($id != ""){
					$sql = "Update tblbudget_init_source_external set Ordering='$i' where SourceExId = '".$id."'  ";
					echo "<pre>$sql</pre>";
					$this->db->Execute($sql);					
					$i++;
				}
			}	

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );
			
	}
*/	/*End*/
		
}
?>