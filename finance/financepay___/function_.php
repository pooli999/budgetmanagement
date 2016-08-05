<?php       
include("config.php");
include("helper.php");
class sFunction extends sHelper{
	
	/* 
	Line by Line
	Name			: Save
	Description		: บันทึก รายการข้อมูลที่อยู่ภาคีเครือข่าย
	Parameter		: -
	Return Value 	: -
	*/
    function Save(){
        
       $this->Upload("PicturePath",$_POST[CFileName]);

       // isset($_POST[EnableStatus])?$_POST[EnableStatus]="Y":$_POST[EnableStatus]="N";
        $_POST[PtnFname]?$_POST[PtnFname] = trim($_POST[PtnFname]):null ;
        $_POST[PtnSname]?$_POST[PtnSname] = trim($_POST[PtnSname]):null ;
        $_POST[DataSource] = 'Excel';   
		if($_POST[EnableStatus]=="") $_POST[EnableStatus] = 'N';  
        
		if($_POST["SourceId"]=='2'){
			unset($_POST[PositionName]);
			unset($_POST[Under]);
		}
		
		if($pk = $this->db->arecSave($this->tbl,$_POST)){
			
			$Topic = $_POST[PtnFname]." ".$_POST[PtnSname];
			
			if($_POST["SourceId"] == '2'){
				$Topic = $_POST[PositionName]." ".$_POST[Under];
			}
			
			if($_POST[$this->pk]=="") $label = 'เพิ่ม'; else $label = 'แก้ไข';
			LogFiles::SaveLog("ระบบเครือข่าย(ในประเทศ)",$label."ข้อมูลภาคีเครือข่าย",$pk,$Topic);
			return true;}else{return  false ;}
        
    }
    
	
	/* 
	Line by Line
	Name			: Upload
	Description		: อัพโหลดไฟล์
	Parameter		: File(ค่าinput File จากฟอร์ม), deleteFile(ชื่อไฟล์ที่ต้องการลบ)
	Return Value 	: $_POST
	*/     
    function Upload($File,$del_file_name=''){
     $Upload = new CI_Upload();
     $Upload->upload_path = $GLOBALS[PathUpload] ;
     $Upload->encrypt_name = true;
     $Upload->allowed_types = array("*");
     if($Upload->do_upload($File)){
         echo $Upload->upload_path.$del_file_name;
         if(is_file($Upload->upload_path.$del_file_name)){unlink($Upload->upload_path.$del_file_name);}
          $_POST[Picture] = $Upload->file_name;   
     }
      
    }
    
	/* 
	Line by Line
	Name			: Enable
	Description		: เปลี่ยนสถานะการแสดงรายการข้อมูลภาคีเครือข่าย
	Parameter		: id(ไอดีของตาราง nh_in_expert), status(สถานะการแสดง)
	Return Value 	: -
	*/
    function Enable($id,$status){
         if($this->db->Enable($this->tbl,$status,$id,"EnableStatus")){
			 $this->db->Execute("update nh_in_categorygroup_ptn set EnableStatus='".$status."' where PartnerCode='".$this->NW->Partner(array("PartnerId"=>$id))->PartnerCode."'");
			 
			 $Topic = $this->getPartnerName($id);
			if(strtolower($status)=="y") $label = 'แสดง'; else $label = 'ไม่แสดง';
			LogFiles::SaveLog("ระบบเครือข่าย(ในประเทศ)","เปลี่ยนสถานะข้อมูลความชำนาญการเป็น".$label,$id,$Topic);
			 return true;
		}else{
			return false;
		}
    }
	
	/* 
	Line by Line
	Name			: ActiveDetail
	Description		: ตั้งเป็นที่อยู่หลัก รายการข้อมูลที่อยู่ภาคีเครือข่าย
	Parameter		: id(ไอดีของตาราง nh_in_partner), PartnerId(ไอดีของตาราง nh_in_partner_detail),status(สถานะการแสดง)
	Return Value 	: -
	*/
	function ActiveDetail($id,$PartnerId,$status){
		$AddressGroupId = $this->getAddressGroupId($id);
		if($AddressGroupId){
			$this->db->Execute("update nh_in_partner_detail set ActiveStatus='N' where AddressGroupId='".$AddressGroupId."' and PartnerCode='".$this->NW->Partner(array("PartnerId"=>$PartnerId))->PartnerCode."'");
			$this->db->Execute("update nh_in_partner_detail set ActiveStatus='Y' where AddressGroupId='".$AddressGroupId."' and DetailId='".$id."'");
			
			$Topic = $this->getAddressDetail($id);
			 LogFiles::SaveLog("ระบบเครือข่าย(ในประเทศ)","ตั้งเป็นที่อยู่หลัก ที่อยู่ภาคีเครือข่าย",$id,$Topic);
		}
    }
    
	
	/* 
	Line by Line
	Name			: Delete
	Description		: ลบรายการข้อมูลภาคีเครือข่าย
	Parameter		: id(ไอดีของตาราง nh_in_partner)
	Return Value 	: -
	*/
    function Delete($id){
         if($this->db->Publish($this->tbl,"Y",$id,'DeleteStatus')){
			 $this->db->Execute("update nh_in_categorygroup_ptn set DeleteStatus='Y' where PartnerCode='".$this->NW->Partner(array("PartnerId"=>$id))->PartnerCode."'");
			 $Topic = $this->getPartnerName($id);
			 LogFiles::SaveLog("ระบบเครือข่าย(ในประเทศ)","ลบข้อมูลภาคีเครือข่าย",$id,$Topic);
			 return true;
		}else{
			return false;
		}
    }
	
	/* 
	Line by Line
	Name			: Delete
	Description		: ลบรายการข้อมูลที่อยู่ภาคีเครือข่าย
	Parameter		: id(ไอดีของตาราง nh_in_partner_detail)
	Return Value 	: -
	*/
	function DeleteSub($id){
         if($this->db->Publish("nh_in_partner_detail","Y",$id,'DeleteStatus')){
			 
			 $Topic = $this->getAddressDetail($id);
			 LogFiles::SaveLog("ระบบเครือข่าย(ในประเทศ)","ลบข้อมูลที่อยู่ภาคีเครือข่าย",$id,$Topic);
			 return true;
		}else{
			return false;
		}
    }
        
    function DeleteChild($table,$id){
         if($this->db->Publish($table,"Y",$id,'DeleteStatus')){return true;}else{return false;}
    }
    
    // Custom Function
    
    function saveCatGroup($PartnerCode){ //     
        $this->db->Execute("DELETE FROM nh_in_categorygroup_ptn WHERE PartnerCode = '{$PartnerCode}' ; " );       
        for($i=0;$i<count($_POST[CatGroupCode2]);$i++ ){
                     
             $data[CatGroupCode] = $_POST[CatGroupCode2][$i];

             $data[PartnerCode] = $PartnerCode;
             $data[CreateBy] = $_POST[CreateBy];
             $data[UpdateBy] = $_POST[UpdateBy];
             $data[UpdateBy] = $_POST[UpdateBy];
             $data[UpdateDate] = $_POST[UpdateDate];
             
             if(trim($data[CatGroupCode]) != '' && trim($data[PartnerCode]) != ''){
                 
                 $this->db->arecSave("nh_in_categorygroup_ptn",$data) ;   
             } 
             
            
        }
            
    }    
    
    function saveMobie(){ // มือถือ   

        for($i=0;$i<count($_POST[MobileId]);$i++ ){
            
             $data[MobileId] = $_POST[MobileId][$i];
             $data[Mobile] = $_POST[Mobile][$i];
             $data[UseStatus] = $_POST[UseStatus][$i];
             $data[PartnerCode] = $_POST[PartnerCode];
             $data[CreateBy] = $_POST[CreateBy];
             $data[UpdateBy] = $_POST[UpdateBy];
             $data[UpdateBy] = $_POST[UpdateBy];
             $data[UpdateDate] = $_POST[UpdateDate];
             
             //$data[UseStatus]=='Y'?null:$data[UseStatus]='N';
             
             if(trim($data[Mobile]) != '' && trim($data[PartnerCode]) != ''){
                 $this->db->arecSave("nh_in_mobile",$data) ;   
             } 
             
            
        }
            
    }  
      
       
    function saveEmail(){   // อีเมลล์

        for($i=0;$i<count($_POST[EmailId]);$i++ ){
            
             $data[EmailId] = $_POST[EmailId][$i];
             $data[Email] = $_POST[Email][$i];
             $data[UseStatus] = $_POST[MailUseStatus][$i];
             $data[PartnerCode] = $_POST[PartnerCode];
             $data[CreateBy] = $_POST[CreateBy];
             $data[UpdateBy] = $_POST[UpdateBy];
             $data[UpdateBy] = $_POST[UpdateBy];
             $data[UpdateDate] = $_POST[UpdateDate];
             //$data[UseStatus]=='Y'?null:$data[UseStatus]='N'; 
             
             if(trim($data[Email]) != '' && trim($data[PartnerCode]) != ''){
                 $this->db->arecSave("nh_in_email",$data) ;   
             }       
        }
     
    }
    
         
    function saveDetail(){   // รายละเอียด
    
        $AGroup = $this->getAdressGroup()  ;
        
        foreach($AGroup[rows] as $rows){
            foreach($rows as $k=>$v){${$k}=$v;}
            if(trim($_POST[AddressDetail_.$AddressGroupId])!=""){
				$data = array();
                $data[PartnerId] = $_POST[PartnerId];  
                $data[PartnerCode] = $_POST[PartnerCode];  
                $data[AddressGroupId] = $AddressGroupId;  
                
                $data[DetailId] = $_POST[DetailId_.$AddressGroupId];  
				if($_POST[SourceId]=='1'){
					$data[D_Under] = $_POST[D_Under_.$AddressGroupId];  
					$data[D_PositionName] = $_POST[D_PositionName_.$AddressGroupId];  
				}
                $data[AddressDetail] = $_POST[AddressDetail_.$AddressGroupId];  
                $data[Soi] = $_POST[Soi_.$AddressGroupId];  
                $data[Road] = $_POST[Road_.$AddressGroupId];  
                $data[ProvinceCode] = $_POST[ProvinceCode_.$AddressGroupId];  
                $data[GeoId] = $_POST[GeoId_.$AddressGroupId];  
                $data[DistrictCode] = $_POST[DistrictCode_.$AddressGroupId];  
                $data[SubDistrictCode] = $_POST[SubDistrictCode_.$AddressGroupId];  
                $data[PostCode] = $_POST[PostCode_.$AddressGroupId];  
                $data[ReturnDocStatus] = $_POST[ReturnDocStatus_.$AddressGroupId];  
                $data[ReturnCause] = $_POST[ReturnCause_.$AddressGroupId];  
                $data[ActiveStatus] = 'Y';  
                if($_POST[DetailId] = $this->db->arecSave("nh_in_partner_detail",$data)){
                
                    // โทรศัพท์
                    unset($data) ;
                   for($i=0;$i<count($_POST[PhoneId_.$AddressGroupId]);$i++ ){
                         $data[PhoneId] = $_POST[PhoneId_.$AddressGroupId][$i];
                         $data[Phone] = $_POST[Phone_.$AddressGroupId][$i];    
                         $data[Extend] = $_POST[ExtendPhone_.$AddressGroupId][$i];
                         $data[UseStatus] = $_POST[PhoneUseStatus_.$AddressGroupId][$i]; 
						 $data[AddressGroupId] = $_POST[AddressGroupId_.$AddressGroupId];   
                         $data[PartnerCode] = $_POST[PartnerCode];
                         $data[DetailId] = $_POST[DetailId];
                         $data[CreateBy] = $_POST[CreateBy];
                         $data[UpdateBy] = $_POST[UpdateBy];
                         $data[UpdateBy] = $_POST[UpdateBy];
                         $data[UpdateDate] = $_POST[UpdateDate];
                         
                         
                        //$data[UseStatus]=='Y'?null:$data[UseStatus]='N';    
                         
                         if(trim($data[Phone]) != '' && trim($data[PartnerCode]) != ''){
                             $this->db->arecSave("nh_in_phone",$data) ;   
                         } 

                   }
                   
                   // โทรสาร
                   unset($data) ;
                   for($i=0;$i<count($_POST[FaxId_.$AddressGroupId]);$i++ ){
                         $data[FaxId] = $_POST[FaxId_.$AddressGroupId][$i];
                         $data[Fax] = $_POST[Fax_.$AddressGroupId][$i];
                         $data[Extend] = $_POST[ExtendFax_.$AddressGroupId][$i];
                         $data[UseStatus] = $_POST[FaxUseStatus_.$AddressGroupId][$i];
						 $data[AddressGroupId] = $_POST[AddressGroupId_.$AddressGroupId];
                         $data[PartnerCode] = $_POST[PartnerCode];
                         
                         $data[DetailId] = $_POST[DetailId];
                         $data[CreateBy] = $_POST[CreateBy];
                         $data[UpdateBy] = $_POST[UpdateBy];
                         $data[UpdateBy] = $_POST[UpdateBy];
                         $data[UpdateDate] = $_POST[UpdateDate];
                       //   ltxt::print_r($_POST);
                         //$data[UseStatus]=='Y'?null:$data[UseStatus]='N';    
                         
                         if(trim($data[Fax]) != '' && trim($data[PartnerCode]) != ''){
                             $this->db->arecSave("nh_in_fax",$data) ;   
                         } 
                         
                        
                    } 
                    

                } 
                
			}
        }// Loop
     
    }
	
	
	/* 
	Line by Line
	Name			: saveSubDetail
	Description		: บันทึก รายการข้อมูลที่อยู่ภาคีเครือข่าย
	Parameter		: -
	Return Value 	: -
	*/
	function saveSubDetail(){ 
		if($_POST["ActiveStatus"]=="") $_POST["ActiveStatus"] = "N";
		$_POST["PartnerCode"] = $this->NW->Partner(array("PartnerId"=>$_POST["PartnerId"]))->PartnerCode;
		
		$addHistory = array();
		$addHistory["UpdateDate"] = $_POST["UpdateDate"];
        $addHistory["UpdateBy"] = $_POST["UpdateBy"];
        $addHistory["CreateDate"] = $_POST["CreateDate"];
        $addHistory["CreateBy"] = $_POST["CreateBy"];
		
		if($_POST["SourceId"]==1 && $this->getCheckOrgDetailHistory($_POST["DetailId"],$_POST)){
			$row = $this->getOrgForDetailHistory($_POST["DetailId"]);
			$History = array();
			if($row)
			foreach($row as $k=>$v){
				if($k=='D_PositionName' || $k=='D_Under') $k = str_replace('D_','',$k);
				$History[$k] = $v;
			}
			$History["DetailId"] = $_POST["DetailId"];
			$History["AddressGroupId"] = $_POST["AddressGroupId"];
			$History = array_merge($History,$addHistory);
			$this->saveHistoryOrg($History); 
		}
		
		if($this->getCheckAddressHistory($_POST["DetailId"],$_POST)){
			$row = $this->getAddressForHistory($_POST["DetailId"]);
			$History = array();
			if($row)
			foreach($row as $k=>$v){
				$History[$k] = $v;
			}
			$History["DetailId"] = $_POST["DetailId"];
			$History = array_merge($History,$addHistory);
			$this->saveHistoryAddress($History); 
		}
		
		$where = array();
		$where[] = "AddressGroupId='".$_POST["AddressGroupId"]."'";
		$where[] = "PartnerCode='".$_POST["PartnerCode"]."'";
		$where[] = "DeleteStatus='N'";
		if($where) $where_r = " where ".implode(" and ",$where);
		
		$count = $this->db->loadResult("select count(DetailId) from nh_in_partner_detail ".$where_r);
		if($count==0) $_POST["ActiveStatus"] = 'Y';
		else $_POST["ActiveStatus"] = 'N';
		
		if($pk = $this->db->arecSave("nh_in_partner_detail")){
			
			
			if($_POST["DetailId"]=="") $label = 'เพิ่ม'; else $label = 'แก้ไข';
			LogFiles::SaveLog("ระบบเครือข่าย(ในประเทศ)",$label."ข้อมูลที่อยู่ภาคีเครือข่าย",$pk,$_POST["AddressDetail"]);
			
			//Phone
			if($_POST["PhoneId"])
			for($i=0;$i<count($_POST["PhoneId"]);$i++ ){
				$data = array();
				$data["PhoneId"] 		= $_POST["PhoneId"][$i];
				$data["Phone"] 			= $_POST["Phone"][$i];    
				$data["Extend"] 			= $_POST["ExtendPhone"][$i];
				$data["UseStatus"] 	= $_POST["PhoneUseStatus"][$i];    
				$data["PartnerCode"] 	= $_POST["PartnerCode"];
				$data["DetailId"] 		= $pk;
				$data["AddressGroupId"] 		= $_POST["AddressGroupId"];
				$data["CreateBy"] 		= $_POST["CreateBy"];
				$data["UpdateBy"] 		= $_POST["UpdateBy"];
				$data["UpdateBy"] 		= $_POST["UpdateBy"];
				$data["UpdateDate"] 	= $_POST["UpdateDate"];
                         
                //$data["UseStatus"]=='Y'?null:$data["UseStatus"]='N';    
                         
				if(trim($data["Phone"]) != '' && trim($data["PartnerCode"]) != ''){
					$this->db->arecSave("nh_in_phone",$data) ;   
				} 

			}
			
			// โทรสาร
			if($_POST["FaxId"])
			for($i=0;$i<count($_POST["FaxId"]);$i++ ){
				$data = array();
				$data["FaxId"] 			= $_POST["FaxId"][$i];
				$data["Fax"] 				= $_POST["Fax"][$i];
				$data["Extend"] 			= $_POST["ExtendFax"][$i];
				$data["UseStatus"] 	= $_POST["FaxUseStatus"][$i];
				$data["PartnerCode"] = $_POST["PartnerCode"];
				$data["DetailId"] 		= $pk;
				$data["AddressGroupId"] 		= $_POST["AddressGroupId"];
				$data["CreateBy"] 		= $_POST["CreateBy"];
				$data["UpdateBy"] 		= $_POST["UpdateBy"];
				$data["UpdateBy"] 		= $_POST["UpdateBy"];
				$data["UpdateDate"] 	= $_POST["UpdateDate"];
				//$data["UseStatus"]=='Y'?null:$data["UseStatus"]='N';    
                         
				if(trim($data["Fax"]) != '' && trim($data["PartnerCode"]) != ''){
					$this->db->arecSave("nh_in_fax",$data) ;   
				} 
			} 
			
		}
		
		
		
    }
	
    function saveHistoryPicture($History){ //  บันทึกประวัติการเปลี่ยนชื่อนามสกุล ภาคึ    
        if($this->db->arecSave('nh_in_change_picture_history',$History)){return true;}else{return false;}
    }
	 
    function saveHistoryName($History){ //  บันทึกประวัติการเปลี่ยนชื่อนามสกุล ภาคึ    
        if($this->db->arecSave('nh_in_change_name_history',$History)){return true;}else{return false;}
    }

    function saveHistoryOrg($History){ //  บันทึกประวัติการเปลี่ยนสังกัด ตำแหน่ง หมวดหมู่ ภาคึ    
        if($this->db->arecSave('nh_in_change_org_history',$History)){return true;}else{return false;}
    }
         
    function saveHistoryAddress($History){ //  บันทึกประวัติการเปลี่ยนที่อยู่ที่ติดต่อ ภาคึ    
    
        if($this->db->arecSave('nh_in_change_address_history',$History)){return true;}else{return false;}

    }

}
?>
