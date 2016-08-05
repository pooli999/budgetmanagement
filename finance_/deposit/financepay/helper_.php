<?php

class sHelper
{
	var $db;
	var $debug = 1;
    var $tbl = "nh_in_partner" ;
    var $pk;
    var $NW ; // Public Network Class
    var $SEARCH;
	var $limit = 40;
	
	
	function sHelper()
	{
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
        $this->pk = $this->db->getTablePk($this->tbl);
        $this->NW = new Network();
		$this->SEARCH = new SEARCH();
	}
    // Standard Function 
    /*function getData($where=null , $order=null,$extwhere=null){      
        
        $sql = "SELECT * FROM {$this->tbl} " ;
        $sql .= $this->db->setWhere($where);
        $sql .= $extwhere ;
        $sql .= $this->db->setOrder($order);
        $this->db->setQuery($sql);
        //echo $sql;
        $datas = $this->db->loadDataSet();
        return $datas ;
        
    }*/
	
	function getListData($where=null , $order=null,$extwhere=null){      
        $limit = $this->limit;
		$start = 0;
		if(isset($where["tp.EnableStatus"])) unset($where["tp.EnableStatus"]);
		
		if($_GET["CatGroupId"]!="" && $_GET["CatGroupId"]!=1){
			$PtnCodeSet  = $this->SEARCH->getPtnHasGroup($_GET["CatGroupId"]);
			if(count($PtnCodeSet)>0) $where["{in}tp.PartnerCode"] =  implode(',',$PtnCodeSet);
			else $where["tp.PartnerCode"] = '';
		}
		
		if($_GET['start']!="") $start = $_GET['start'];
        $sql = "SELECT * FROM {$this->tbl} as tp " ;
		$sql .= $this->db->setWhere($where);
        $sql .= $extwhere ;
        $sql .= $this->db->setOrder($order);
		$sql .= " limit ".$start.",$limit";
        $this->db->setQuery($sql);
        $datas["rows"] = $this->db->loadObjectList();
		$sql = "SELECT count(tp.PartnerId) FROM {$this->tbl} as tp" ;
		$sql .= $this->db->setWhere($where);
        $sql .= $extwhere ;
		
		$this->db->setQuery($sql);
		$datas["total"] = $this->db->loadResult();
		$datas["limit"] = $limit;
        return $datas ;
        
    }
	
	function getReturnStartPage($PartnerCode){
		$limit = $this->limit;
		$where = array();
        $where["DeleteStatus"]='N';
		$order = array();
		$order["PtnFname "] = 'asc';
		$order["PositionName "] = 'asc';
		$order["Under "] = 'asc';
		$sql = "SELECT @i:=@i+1 as rowId, PartnerCode FROM {$this->tbl} " ;
		$sql .= $this->db->setWhere($where);
		$sql .= $this->db->setOrder($order);
		
		$sql = "select Q1.rowId from (".$sql.") as Q1 where Q1.PartnerCode = '".$PartnerCode."';";
		$this->db->Execute("set @i =0;");
		$this->db->setQuery($sql);
		$rowId = $this->db->loadResult();
		$start = false;
		if($rowId>$limit) $start = (ceil($rowId/$limit)-1) * $limit;	
		return $start;
	}
	
	function getData($where=null , $order=null,$extwhere=null){    
		if($_GET["start"]=="") $_GET["start"] = 0;
		if($_REQUEST["LV1CATGROUP"]==1){
			$sql = "SELECT tp.* FROM {$this->tbl} as tp " ;
			$sql .= $this->db->setWhere($where)." ".$extwhere;
		}else{
			$sql = "SELECT tp.* FROM {$this->tbl} as tp, nh_in_categorygroup_ptn as tpg_p " ;
			$sql .= $this->db->setWhere($where);
			$sql .= " and tp.PartnerCode = tpg_p.PartnerCode ".$extwhere." group by tp.PartnerId ";	
		}
		
		$datas["total"] = $this->db->loadResult("select count(Q1.".$this->pk.") from (".$sql.") as Q1");
		
		$sql .= $this->db->setOrder(array("tp.PartnerId"=>"DESC"));
		$sql .= " limit ".$_GET["start"].",".$this->db->limit;
        
        $this->db->setQuery($sql);
        $datas["rows"] = $this->db->loadObjectList();
        return $datas ;
        
    }
    
    function genUniqKey($table=null,$uniqfield=null){
        $UniqKey = LTXT::UIDKey();
        if(!$this->db->checkUIDKey($this->tbl,'PartnerCode',$UniqKey)){
            $this->genUniqKey();
        }else{
            return $UniqKey; 
        }
    }
    
    // Custom Function
    function getPrefixName($PrefixId){
        
        $where[PrefixId]=$PrefixId;
        $sql = "SELECT PrefixName FROM tblpersonal_prefix " ;
        $sql .= $this->db->setWhere($where);
        $sql .= $this->db->setOrder($order);
        $this->db->setQuery($sql);
        $datas = $this->db->loadResult();
        return $datas ;
    }
    
    function getMobile($PartnerCode){
        
        $where["EnableStatus"]='Y';
        $where["DeleteStatus"]='N';
        $where["PartnerCode"]=$PartnerCode;
		$order["MobileId"] = 'asc';
		
        $sql = "SELECT * FROM nh_in_mobile " ;
        $sql .= $this->db->setWhere($where);
        $sql .= $this->db->setOrder($order);
        $this->db->setQuery($sql);
        $datas = $this->db->loadDataSet();
        return $datas ;
    }
            
    function getPhone($PartnerCode,$DetailId){
        
        $where["EnableStatus"]='Y';
        $where["DeleteStatus"]='N';
        $where["PartnerCode"]=$PartnerCode;
        $where["DetailId"]=$DetailId;
		$order["PhoneId"] = 'asc';
        
        $sql = "SELECT * FROM nh_in_phone " ;
        $sql .= $this->db->setWhere($where);
        $sql .= $this->db->setOrder($order);
        $this->db->setQuery($sql);
        $datas["rows"] = $this->db->loadObjectList();
		$datas["total"] = count($datas["rows"]);
        return $datas ;
    }  
       
    function getFax($PartnerCode,$DetailId){
        
        $where["EnableStatus"]='Y';
        $where["DeleteStatus"]='N';
        $where["PartnerCode"]=$PartnerCode;
       	$where["DetailId"]=$DetailId;
		$order["FaxId"] = 'asc';
        
        $sql = "SELECT * FROM nh_in_Fax " ;
        $sql .= $this->db->setWhere($where);
        $sql .= $this->db->setOrder($order);
        $this->db->setQuery($sql);
        $datas["rows"] = $this->db->loadObjectList();
		$datas["total"] = count($datas["rows"]);
        return $datas ;
    }
    
    function getEmail($PartnerCode){
        
        $where["EnableStatus"]='Y';
        $where["DeleteStatus"]='N';
        $where["PartnerCode"]=$PartnerCode;
		$order["EmailId"] = 'asc';
        
        $sql = "SELECT * FROM nh_in_email " ;
        $sql .= $this->db->setWhere($where);
        $sql .= $this->db->setOrder($order);
        $this->db->setQuery($sql);
        $datas["rows"] = $this->db->loadObjectList();
		$datas["total"] = count($datas["rows"]);
        return $datas ;
    } 
       
    function getAdressGroup($where=null,$order=null){
        
        $where[EnableStatus]='Y';
        $where[DeleteStatus]='N'; 
		$order["AddressGroupId"]  = 'asc';
        $sql = "SELECT * FROM nh_in_address_group  " ;
        $sql .= $this->db->setWhere($where);
        $sql .= $this->db->setOrder($order);
        $this->db->setQuery($sql);
        $datas["rows"] = $this->db->loadObjectList();
		$datas["total"] = count($datas["rows"]);
        return $datas ;
    }
           
    function getDetail($where=null,$order=null){
        
        $where[EnableStatus]='Y';
        $where[DeleteStatus]='N';     
        $sql = "SELECT * FROM nh_in_partner_detail   " ;
        $sql .= $this->db->setWhere($where);
        $sql .= $this->db->setOrder($order);
        $this->db->setQuery($sql);
        $datas["rows"] = $this->db->loadObjectList();
		$datas["total"] = count($datas["rows"]);
        return $datas ;
    }
               
    function getCatGroupPtn($where=null,$order=null){
        
        $where["M.EnableStatus"]='Y';
        $where["M.DeleteStatus"]='N';     
        $sql = " SELECT G.CatGroupName ,M.* 
                    FROM nh_in_categorygroup_ptn M
                    INNER JOIN nh_in_categorygroup G ON (M.CatGroupCode = G.CatGroupCode) " ;
        $sql .= $this->db->setWhere($where);
        $sql .= $this->db->setOrder($order);
        $this->db->setQuery($sql);
        $this->db->limit = 999999;
        //echo $sql ;
        $datas = $this->db->loadDataSet();
        return $datas ;
    }
    
    function isExist($where=null,$order=null){
 
        $where[DeleteStatus]='N';     
        $sql = "SELECT count(*)  FROM nh_in_partner " ;
        $sql .= $this->db->setWhere($where);
        $sql .= $this->db->setOrder($order);
        $this->db->setQuery($sql);
        $datas = $this->db->loadResult();
        return $datas ; 
    }
    
     
    function SLWsGroup($select=null,$name='select',$attr='',$title='',$count=false){
        $this->NW->TreeTable = "nh_in_categorygroup"  ;
        $this->NW->TreePrefix = "CatGroup";
        $this->NW->createTree();
        $tree = $this->NW->SLTree($select,$name,$attr,$title,$count);
        return $tree ;

    }
        
   // มาอย่างหรูสุดทาย Fixed เวรกำ          
    function SLWsGroupNested($select=null,$name='select',$attr='',$title='',$node){
        $this->NW->TreeTable = "nh_in_categorygroup"  ;
        $this->NW->TreePrefix = "CatGroup";
        $node = $this->NW->getNode($node);
        $this->NW->TreeExtWhere = " AND g1.CatGroupLeft>={$node->lft} AND g1.CatGroupRight<={$node->rgt}";   
        $this->NW->createTree();
        $tree = $this->NW->SLTree($select,$name,$attr,$title);
        return $tree ;

    }
        
        
    function SLWsGroupLevel($level=10,$select=null,$name='select',$attr='',$title=''){
        $this->NW->TreeTable = "nh_in_categorygroup"  ;
        $this->NW->TreePrefix = "CatGroup";
        $this->NW->createTree();
        $tree = $this->NW->SLTreeLevel($level,$select,$name,$attr,$title);
        return $tree ;

    }
	
	function SLWSubSelect($CatGroupId ='',$tag_name, $tag_attribs='', $selected=null){
        $Tree = $this->NW->getLoopSubTree($CatGroupId)  ;
		$RootRow = $this->NW->CatGroup(array("CatGroupId"=>$CatGroupId));
		if($RootRow){
			$o = new stdClass;
			$o->value = $RootRow->CatGroupCode;
			$o->text = $RootRow->CatGroupName." (".number_format($RootRow->CatGroupCount).") ";
			if($RootRow->CatGroupSum>0) $o->text .="[".number_format($RootRow->CatGroupSum)."]";
			$ob[] = $o;
		}
		if($Tree)
        foreach( $Tree as $r ){
            $o = new stdClass;
            $o->value = $r->CatGroupCode;
            $o->text = $r->CatGroupName." (".number_format($r->CatGroupCount).") ";
			if($r->CatGroupSum>0) $o->text .="[".number_format($r->CatGroupSum)."]";
            $ob[] = $o;
        }

        return clssHTML::selectList($ob,$tag_name,$tag_attribs,'value','text',$selected);
    }
    
	function ddlAddressGroup($tag_name, $tag_attribs='', $selected=null,$title="==ทั้งหมด=="){
		$where["EnableStatus"]='Y';
        $where["DeleteStatus"]='N';     
        $sql = "select AddressGroup as text, AddressGroupId as value from nh_in_address_group " ;	
		$sql .= $this->db->setWhere($where);
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		$Op_title[] = clssHTML::makeOption('',$title);
		$data = array_merge($Op_title,$data);
		return clssHTML::selectList($data,$tag_name,$tag_attribs,'value','text',$selected);
	}
	
	function getAddressGroup($AddressGroupId){
		$sql="select AddressGroup from nh_in_address_group where AddressGroupId='".$AddressGroupId."'";
		$this->db->setQuery($sql);
		return $this->db->loadResult();
	}
	
	function getAddressGroupId($DetailId){
		$sql="select AddressGroupId from nh_in_partner_detail where DetailId='".$DetailId."'";
		$this->db->setQuery($sql);
		return $this->db->loadResult();
	}
    
   function ddlSearchGroup($selected=null,$tag_name='SearchGroup', $tag_attribs=''){
        
        $option = array(
                                    clssHTML::makeOption('','== ประเภทการค้นหา =='),
                                    clssHTML::makeOption('PtnFname','ชื่อภาคี'),
                                    clssHTML::makeOption('PtnSname','นามสกุล'),
                                    clssHTML::makeOption('CatGroupCode','หมวดหมู่ภาคี'),
                                    clssHTML::makeOption('Mobile','เฉพาะมีมือถือ'),
                                    clssHTML::makeOption('Phone','เฉพาะมีโทรศัพท์'),
                                    clssHTML::makeOption('Email','เฉพาะมีอีเมลล์')
                                
                                );
        
       return clssHTML::selectList($option,$tag_name,$tag_attribs,'value','text',$selected);    
    }
	
	function ddlContactStatus($tag_name='UseStatus',$selected=null,$tag_attribs=''){
        
        $option = array(
                                    clssHTML::makeOption('Y','เปิดใช้งาน'),
                                    clssHTML::makeOption('N','ปิดใช้งาน'),
                                    clssHTML::makeOption('W','เปิดใช้งาน งดรับ')                                
                                );
        
       return clssHTML::selectList($option,$tag_name,$tag_attribs,'value','text',$selected);    
    }
       
    function AddressDetailList($PartnerCode,$AddressGroupId='',$ActiveStatus=''){
		$where["DeleteStatus"] = 'N';
		$where["PartnerCode"] = $PartnerCode;
		if($AddressGroupId!="") $where["AddressGroupId"] = $AddressGroupId;
		if($ActiveStatus!="") $where["ActiveStatus"] = $ActiveStatus;
        $sql = "select * from nh_in_partner_detail" ;
        $sql .= $this->db->setWhere($where);
        $sql .= $this->db->setOrder(array("DetailId"=>"desc"));
        $this->db->setQuery($sql);
        $datas = $this->db->loadObjectList();
        return $datas ;
    } 
	
	function getPartnerName($PartnerId){
		$sql="select SourceId, PrefixUid, PtnFname, PtnSname, PositionName, Under from nh_in_partner where PartnerId='".$PartnerId."'";
		$this->db->setQuery($sql);
		$r = $this->db->loadSingleObject();
		
		$Prefix = $this->NW->Prefix(array("PrefixUid"=>$r->PrefixUid))->PtnPrefixTH;
		$PartnerName = $Prefix.$r->PtnFname." ".$r->PtnSname;
		if($r->SourceId == 2){
			$PartnerName = $r->PositionName." ".$r->Under;
		}
		return $PartnerName;
	}
	
	function getAddressDetail($DetailId){
		$sql="select AddressDetail from nh_in_partner_detail where DetailId='".$DetailId."'";
		$this->db->setQuery($sql);
		return $this->db->loadResult();
	}
	
	function getCatGroupCodeArr($PartnerCode){
		$sql = "select CatGroupCode from nh_in_categorygroup_ptn where PartnerCode = '".$PartnerCode."'";
		$this->db->setQuery($sql);
		$rows = $this->db->loadObjectList();
		$GroupArr = array();
		if($rows)
		foreach($rows as $r){
			$GroupArr[] = $r->CatGroupCode;
		}
		return $GroupArr;
	}
	
	function getPtnForHistory($PartnerId){
		$sql = "select PartnerCode, PrefixUid as Prefix, PtnFname, PtnSname, ExpertUid from nh_in_partner where PartnerId ='".$PartnerId."'";	
		$this->db->setQuery($sql);
		return $this->db->loadSingleObject();
	}
	
	function getCheckNameHistory($PartnerId,$Data){
		$check = false;
		$Data["Prefix"] = $Data["PrefixUid"];
		$row = $this->getPtnForHistory($PartnerId);
		if($row){
			$GroupArr = $this->getCatGroupCodeArr($row->PartnerCode);
			
			foreach($row as $k =>$v){
				if($Data[$k] != $v) $check = true;
			}
			if(!$check){
				if(count($Data["CatGroupCode2"])!=count($GroupArr)){ 
					$check = true;
				}else if(count($GroupArr)>0 || count($Data["CatGroupCode2"]>0)){
					if(is_array($Data["CatGroupCode2"])) sort($Data["CatGroupCode2"]);
					if(is_array($GroupArr)) sort($GroupArr);
					foreach($GroupArr as $CatGroupCode){
						if(!in_array($CatGroupCode,$Data["CatGroupCode2"]))	{
							$check = true;
							break;	
						}
					}
				}
			}//end if check
			
		}//end if row
		return $check;
	}
	
	function getOrgForHistory($PartnerId){
		$sql = "select PartnerCode, PositionName, Under from nh_in_partner where PartnerId ='".$PartnerId."'";	
		$this->db->setQuery($sql);
		return $this->db->loadSingleObject();
	}
	
	function getCheckOrgHistory($PartnerId,$Data){
		$check = false;
		$row = $this->getOrgForHistory($PartnerId);
		if($row){
			foreach($row as $k =>$v){
				if($Data[$k] != $v) $check = true;
			}
		}//end if row
		return $check;
	}
	
	function getOrgForDetailHistory($DetailId){
		$sql = "select PartnerCode, D_PositionName , D_Under from nh_in_partner_detail where DetailId ='".$DetailId."'";	
		$this->db->setQuery($sql);
		return $this->db->loadSingleObject();
	}
	
	function getCheckOrgDetailHistory($DetailId,$Data){
		$check = false;
		$row = $this->getOrgForDetailHistory($DetailId);
		if($row){
			foreach($row as $k =>$v){
				if($Data[$k] != $v) $check = true;
			}
		}//end if row
		return $check;
	}
	
	function getAddressForHistory($DetailId){
		$sql = "select PartnerId, PartnerCode, AddressGroupId, AddressDetail, Soi, Road, ProvinceCode, DistrictCode, SubDistrictCode, PostCode from nh_in_partner_detail where DetailId ='".$DetailId."'";	
		$this->db->setQuery($sql);
		return $this->db->loadSingleObject();
	}
	
	function getCheckAddressHistory($DetailId,$Data){
		$check = false;
		$row = $this->getAddressForHistory($DetailId);
		if($row){
			foreach($row as $k =>$v){
				if($Data[$k] != $v) $check = true;
			}
		}//end if row
		return $check;
	}
	
	function getPictureForHistory($PartnerCode){
		$sql = "select PartnerCode,Picture from nh_in_partner where PartnerCode ='".$PartnerCode."'";	
		$this->db->setQuery($sql);
		return $this->db->loadSingleObject();
	}
	
	function getCheckPictureHistory($PartnerCode,$Data){
		$check = false;
		$row = $this->getPictureForHistory($PartnerCode);
		if($row){
			foreach($row as $k =>$v){
				if($Data[$k] != $v) $check = true;
			}
		}//end if row
		return $check;
	}
	
	function getHistoryNameList($PartnerCode){
		$sql = "select *,date(CreateDate) as HistoryDate, time(CreateDate) as HistoryTime from nh_in_change_name_history where PartnerCode = '".$PartnerCode."' order by ChangeNameId desc";	
		$this->db->setQuery($sql);
		return $this->db->loadObjectList();
	}
	
	function getHistoryPictureList($PartnerCode){
		$sql = "select *,date(CreateDate) as HistoryDate, time(CreateDate) as HistoryTime from nh_in_change_picture_history where PartnerCode = '".$PartnerCode."' order by ChangePictureId desc";	
		$this->db->setQuery($sql);
		return $this->db->loadObjectList();
	}
	
	function getHistoryOrgList($PartnerCode){
		$sql = "select *,date(CreateDate) as HistoryDate, time(CreateDate) as HistoryTime from nh_in_change_org_history where PartnerCode = '".$PartnerCode."' order by ChangeOrgId desc";	
		$this->db->setQuery($sql);
		return $this->db->loadObjectList();
	}
	
	function getHistoryAddressList($DetailId,$AddressGroupId){
		$sql = "select *,date(CreateDate) as HistoryDate, time(CreateDate) as HistoryTime from nh_in_change_address_history where DetailId = '".$DetailId."' and AddressGroupId='".$AddressGroupId."' order by ChangeDetailId desc";	
		$this->db->setQuery($sql);
		return $this->db->loadObjectList();
	}
	
	function getHistoryOrgAddressList($DetailId,$AddressGroupId){
		$sql = "select *,date(CreateDate) as HistoryDate, time(CreateDate) as HistoryTime from nh_in_change_org_history where DetailId = '".$DetailId."' and AddressGroupId='".$AddressGroupId."' order by ChangeOrgId desc";	
		$this->db->setQuery($sql);
		return $this->db->loadObjectList();
	}
	
}
?>
