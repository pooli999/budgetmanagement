<?php
class sHelper
{
	var $db;
	var $debug = 0;
	function sHelper()
	{
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
	}
	
	function getQueryString(){
		$expStr = explode("&",$_SERVER['QUERY_STRING']);
		unset($expStr[0]);
		$impStr = implode("&",$expStr);
		if($impStr){
			$impStr = "&".$impStr;
		}
		return $impStr;
	}
	
	/* START */
	/* Function Name: getScreenName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยงาน */
	function getOrganizeName($OrganizeCode=0){
		$where = array();
		
		$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.OrgName"
		."\n FROM "
		."\n tblstructure_operation AS t1  "
		."\n ".$where_r
		;
	
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */		

	/* START */
	/* Function Name: getPrjActName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อตำแหน่ง */
	function getPositionName($PositionId=0){
				
		$where = array();
		
		$where[] = "t1.PositionId='".$PositionId."'";
						
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.Position"
		."\n FROM "
		."\n tblposition AS t1  "
		."\n ".$where_r
		;
	
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */	

	/* START */
	/* Function Name: getCostItemList */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายของเอกสาร */
	function getCostItemList($DocCode=0){
		$where = array();
		$where[] = "DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
		$sql="SELECT * "
		."\n FROM "
		."\n tblfinance_form_paybr_cost"
		."\n ".$where_r
		."\n order by EFormCostId asc"
		;
		$this->db->setQuery($sql);//echo "<pre>$sql;</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */	
	
	/* START */
	/* Function Name: getOtherCostItemList */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายของเอกสาร */
	function getOtherCostItemList($DocCode=0){
		$where = array();
		$where[] = "DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
		$sql="SELECT * "
		."\n FROM "
		."\n tblfinance_form_paybr_cost_other"
		."\n ".$where_r
		."\n order by OtherEFormCostId asc"
		;
		$this->db->setQuery($sql);//echo "<pre>$sql;</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */
	
	/* START */
	/* Function Name: getCostItemName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อรายการค่าใช้จ่าย */
		function getCostItemName($CostItemCode=0){
		$where = array();
		$where[] = "CostItemCode = '".$CostItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select CostName "
				."\n from tblbudget_init_cost_item "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);
		$data = $this->db->loadResult();
		return $data;
		}
	/* END */
	
	/* START */
	/* Function Name: getFile */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อไฟล์แนบของเอกสาร */
	function getFile($DocCode){
		$where 	  = array();
		$where[] ="DocCode='".$DocCode."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select FileDocId from tblfinance_form_paybr_file ".$where_r; 
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadResultArray();
		$datas = implode(",",$data);//ltxt::print_r($datas);
		return $datas;
	}	
	/* END */	
	
	/* START */
	/* Function Name: getOrgRoundCode */
	/* Description: เป็นฟังก์ชันสำหรับดึงคำสั่งของโครงสร้างการปฏิบัติจริงของหน่วยงาน */
	function getOrgRoundCode($selected=0,$tag_name='RQOrgRoundCode',$tag_attribs='onchange="loadOrgIdList(this.value)"',$lebel='เลือก'){
		//$selected = ($selected)?$selected:(date("Y")+543);
		$where = array();
		$where[] = "EnableStatus = 'Y'";
		$where[] = "DeleteStatus <> 'Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT RoundCode as value , RoundCode as text "
			 ."\n FROM tblstructure_operation_round "
			 ."\n ".$where_r
			 ."\n order by RoundCode desc"
			 ;		 
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}
	/* END */	
	
	/* START */
	/* Function Name: getOrgYearFromOrgRoundCode */
	/* Description: เป็นฟังก์ชันสำหรับดึงปีของหน่วยงานตามโครงสร้างการปฏิบัติงานจริง */
	function getOrgYearFromOrgRoundCode($OrgRoundCode){
		$where = array();
		$where[] = "EnableStatus = 'Y'";
		$where[] = "DeleteStatus <> 'Y'";
		$where[] = "RoundCode = '".$OrgRoundCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT Year "
			 ."\n FROM tblstructure_operation_round "
			 ."\n ".$where_r
			 ;		 
		$this->db->setQuery($sql);
		return $this->db->loadResult();
	}
	/* END */	
	
	/* START */
	/* Function Name: getOrgRoundFromOrgRoundCode */
	/* Description: เป็นฟังก์ชันสำหรับคำสั่งของหน่วยงานตามโครงสร้างการปฏิบัติงานจริง */
	function getOrgRoundFromOrgRoundCode($OrgRoundCode){
		$where = array();
		$where[] = "EnableStatus = 'Y'";
		$where[] = "DeleteStatus <> 'Y'";
		$where[] = "RoundCode = '".$OrgRoundCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT Round "
			 ."\n FROM tblstructure_operation_round "
			 ."\n ".$where_r
			 ;		 
		$this->db->setQuery($sql);
		return $this->db->loadResult();
	}
	/* END */	
	
	/* START */
	/* Function Name: getTree */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายชื่อหน่วยงานตามโครงสร้างการปฏิบัติงานจริง */
	function getTree($OrgRoundCode){
				$OrgYear = $this->getOrgYearFromOrgRoundCode($OrgRoundCode);
				$OrgRound = $this->getOrgRoundFromOrgRoundCode($OrgRoundCode);
				jimport('packages.utility.utl_grouptree');
				$Tree = new JGroupTree(array(
					'dbo'  => $this->db,
					'table' => 'tblstructure_operation',
					'prefix' => 'Org',
					'root' => 'Root',
					//'debug' => 2,
					'where'=>array(
						'OrgYear' => $OrgYear,
						'OrgRound' => $OrgRound,
						'EnableStatus' => 'Y',
						'DeleteStatus' => 'N'
					)
				));
				
				return $Tree;
	}	
	/* END */	
	
	/* START */
	/* Function Name: getOrgList */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายชื่อหน่วยงานตามโครงสร้างการปฏิบัติงานจริง */	
	function getOrgList($OrgRoundCode=0,$selected=0,$tag_name='OrganizeCode',$tag_attribs='onchange="loadPersonList(this.value)"',$lebel='เลือก'){

				/*$selected = $GLOBALS["OrgApprove"];
				if($selected == ''){
					$selected = $_SESSION['Session_OrgCode'];
				}*/
				$OrgRoundCode = ($OrgRoundCode)?$OrgRoundCode:$_REQUEST["OrgRoundCode"];
				jimport('packages.utility.utl_grouptree');
				$Operation = $this->getTree($OrgRoundCode);//ltxt::print_r($Tree);
				$t = $Operation->getTree(false);
				
				$x->value =0;
				$x->text = $lebel;
				$row[] = $x;
				
				foreach( $t as $r ){
					$x = new stdClass;
					$x->value = $r->OrganizeCode;
					if($r->Level > 1){
						$x->text = str_repeat('&nbsp;',$r->Level)."|".str_repeat('-',$r->Level)."&nbsp;".$r->OrgName;
					}else{
						$x->text = $r->OrgName;
					}
					$row[] = $x;
				}//ltxt::print_r($row);
				echo clssHTML::selectList( $row, $tag_name, $tag_attribs,'value','text', $selected );
	}
	/* END */
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	/* START */
	/* Function Name: getPItemName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อแผนงานประจำปี */
	function getPItemName($BgtYear,$PItemCode){
	
		$where = array();
		$where[] = "BgtYear='".$BgtYear."'";
		$where[] = "PItemCode='".$PItemCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select PItemName "
				."\n from tblbudget_init_plan_item "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */	
	
	/* START */
	/* Function Name: getPrjDetailName */
	/* Description: เป็นฟังก์ชันสำหรับชื่อโครงการตามแผนปฏิบัติงาน */	
	function getPrjDetailName($PrjDetailId){
	
		$where = array();
		$where[] = "t1.PrjDetailId='".$PrjDetailId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select t2.PrjName "
				."\n from tblbudget_project_detail as t1 "
				."\n left join tblbudget_project as t2 on t2.PrjId=t1.PrjId "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	
	}
	/* END */	
	
	/* START */
	/* Function Name: getPrjActName */
	/* Description: เป็นฟังก์ชันสำหรับกิจกรรมในโครงการ */	
	function getPrjActName($PrjActCode){
		$where = array();
		$where[] = "t1.PrjActCode='".$PrjActCode."'";
		$where[] = "t2.ActiveStatus='Y'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select t1.PrjActName "
				."\n from tblbudget_project_activity as t1 "
				."\n left join tblbudget_project_detail as t2 on t2.PrjDetailId=t1.PrjDetailId "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSourceExName */
	/* Description: เป็นฟังก์ชันสำหรับชื่อแหล่งที่มาของงบประมาณ */	
	function getSourceExName($SourceExId){
		$where = array();
		$where[] = "t1.SourceExId='".$SourceExId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select t1.SourceExName "
				."\n from tblbudget_init_source_external as t1 "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	/* START */
	/* Function Name: getImpParentCode */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อรายการค่าใช้จ่าย */
	function getImpParentCode($CostItemCode){
		$where = array();
		$where[] = "ParentCode='".$CostItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select CostItemCode "
				."\n from tblbudget_init_cost_item "
				."\n ".$where_r
				."\n or ParentCode in( "
					."\n select CostItemCode "
				   	."\n from tblbudget_init_cost_item "
				  	."\n ".$where_r
				."\n ) "
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";		
		$data = $this->db->loadResultArray();
		$datas = implode(",",$data);
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getCostTypeRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลหมวดงบประมาณ */	
	function getCostTypeRecordSet($CostTypeId=0){
		
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		$CostTypeId = ($_REQUEST["CostTypeId"])?$_REQUEST["CostTypeId"]:$CostTypeId;
		if($CostTypeId){
			$where[] = "CostTypeId = '".$CostTypeId."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT CostTypeId,CostTypeName,Ordering "
			 ."\n FROM tblbudget_init_cost_type "
			 ."\n ".$where_r
			 ."\n order by Ordering"
			 ;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;
		
	}
	/* END */	
	
	/* START */
	/* Function Name: getCostItemRecordSet */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลรายการค่าใช้จ่าย */	
	function getCostItemRecordSet($CostTypeId=0,$LevelId=1,$ParentCode=0,$HasChild=0,$CostItemCode=0){
		$where = array();
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus<>'Y'";
		$where[] = "CostTypeId='".$CostTypeId."'";
		$where[] = "LevelId='".$LevelId."'";
		if($ParentCode){
			$where[] = "ParentCode='".$ParentCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT CostItemId, CostItemCode, CostName, LevelId, ParentCode, HasChild, CostTypeId "
			 ."\n FROM tblbudget_init_cost_item "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql); //echo "<pre>".$sql."</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumPlan */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมยอดงบตามแผน */	
	function getSumPlan($PrjActCode,$SourceExId,$CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0,$MonthNo=0){
		$where = array();
		$where[] = "t2.ActiveStatus='Y'";
		if($PrjActCode){
			$where[] = "t3.PrjActCode='".$PrjActCode."'";
		}
		if($SourceExId){
			$where[] = "t4.SourceExId='".$SourceExId."'";
		}
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t4.CostItemCode in(".$CostItemCode.")";
		}
		$CostTypeId = ($CostTypeId)?$CostTypeId:$_REQUEST["CostTypeId"];
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if($MonthNo){
			$where[] = "t8.MonthNo='".$MonthNo."'";
		}	
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.Budget)as total "
				."\n FROM "
				."\n tblbudget_project_activity_cost_external_month as t8 "
				."\n Inner Join tblbudget_project_activity_cost_external AS t4 ON t4.CostExtId = t8.CostExtId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjActId = t4.PrjActId "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t6.CostItemCode = t4.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t7.CostTypeId = t6.CostTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumTferIn */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดรวมของงบประมาณรับโอน */	
	function getSumTferIn($PrjActCode,$SourceExId,$CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0){
		$where = array();
		$where[] = "t2.ActiveStatus='Y'";
		if($_REQUEST["DocCode"]){
			$where[] = "t8.DocCode <> '".$_REQUEST["DocCode"]."'";
		}
		if($PrjActCode){
			$where[] = "t3.PrjActCode='".$PrjActCode."'";
		}
		if($SourceExId){
			$where[] = "t8.SourceExId='".$SourceExId."'";
		}
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t8.CostItemCodeTo in(".$CostItemCode.")";
		}
		$CostTypeId = ($CostTypeId)?$CostTypeId:$_REQUEST["CostTypeId"];
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.SumBGTfer)as total "

				."\n FROM "

				."\n tblfinance_bg_transfer as t8 "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjActCode = t8.PrjActCodeTo "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t6.CostItemCode = t8.CostItemCodeTo "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t7.CostTypeId = t6.CostTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumTferOut */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดงบประมาณโอนออก */	
	function getSumTferOut($PrjActCode,$SourceExId,$CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0){
		$where = array();
		$where[] = "t2.ActiveStatus='Y'";
		if($_REQUEST["DocCode"]){
			$where[] = "t8.DocCode <> '".$_REQUEST["DocCode"]."'";
		}
		if($PrjActCode){
			$where[] = "t3.PrjActCode='".$PrjActCode."'";
		}
		if($SourceExId){
			$where[] = "t8.SourceExId='".$SourceExId."'";
		}
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t8.CostItemCodeFrom in(".$CostItemCode.")";
		}
		$CostTypeId = ($CostTypeId)?$CostTypeId:$_REQUEST["CostTypeId"];
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.SumBGTfer)as total "

				."\n FROM "

				."\n tblfinance_bg_transfer as t8 "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjActCode = t8.PrjActCodeFrom "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t6.CostItemCode = t8.CostItemCodeFrom "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t7.CostTypeId = t6.CostTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumHold */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดงบประมาณหลักการ */	
	function getSumHold($PrjActCode,$SourceExId,$CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0){
		$where = array();
		$where[] = "t2.ActiveStatus='Y'";
		if($_REQUEST["DocCode"]){
			$where[] = "t8.DocCode <> '".$_REQUEST["DocCode"]."'";
		}
		if($PrjActCode){
			$where[] = "t3.PrjActCode='".$PrjActCode."'";
		}
		if($SourceExId){
			$where[] = "t8.SourceExId='".$SourceExId."'";
		}
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t8.CostItemCode in(".$CostItemCode.")";
		}
		$CostTypeId = ($CostTypeId)?$CostTypeId:$_REQUEST["CostTypeId"];
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.SumBGChain)as total "

."\n FROM "

."\n tblfinance_bg_chain as t8 "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjActCode = t8.PrjActCode "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t6.CostItemCode = t8.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t7.CostTypeId = t6.CostTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumChain */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมยอดงบประมาณผูกพัน */	
	function getSumChain($PrjActCode,$SourceExId,$CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0){
		$where = array();
		$where[] = "t2.ActiveStatus='Y'";
		if($_REQUEST["DocCode"]){
			$where[] = "t8.DocCode <> '".$_REQUEST["DocCode"]."'";
		}
		if($PrjActCode){
			$where[] = "t3.PrjActCode='".$PrjActCode."'";
		}
		if($SourceExId){
			$where[] = "t8.SourceExId='".$SourceExId."'";
		}
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t8.CostItemCode in(".$CostItemCode.")";
		}
		$CostTypeId = ($CostTypeId)?$CostTypeId:$_REQUEST["CostTypeId"];
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.SumRemain)as total "
				."\n FROM "
				."\n tblfinance_bg_pay as t8 "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjActCode = t8.PrjActCode "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t6.CostItemCode = t8.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t7.CostTypeId = t6.CostTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumPay */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดงบประมาณเบิกจ่าย */	
	function getSumPay($PrjActCode,$SourceExId,$CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0){
		$where = array();
		$where[] = "t2.ActiveStatus='Y'";
		if($_REQUEST["DocCode"]){
			$where[] = "t8.DocCode <> '".$_REQUEST["DocCode"]."'";
		}
		if($PrjActCode){
			$where[] = "t3.PrjActCode='".$PrjActCode."'";
		}
		if($SourceExId){
			$where[] = "t8.SourceExId='".$SourceExId."'";
		}
		switch($LevelId){
			case 1:
			case 2:
				if($HasChild=="Y"){
					$CostItemCode = $this->getImpParentCode($CostItemCode);//echo "xx=>".$CostItemCode;
				}
				break;
		}
		if($CostItemCode){
			$where[] = "t8.CostItemCode in(".$CostItemCode.")";
		}
		$CostTypeId = ($CostTypeId)?$CostTypeId:$_REQUEST["CostTypeId"];
		if($CostTypeId){
			$where[] = "t7.CostTypeId='".$CostTypeId."'";
		}	
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t8.SumBGPay)as total "
."\n FROM "
."\n tblfinance_bg_pay as t8 "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjActCode = t8.PrjActCode "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjDetailId = t3.PrjDetailId "
				."\n Inner Join tblbudget_init_cost_item AS t6 ON t6.CostItemCode = t8.CostItemCode "
				."\n Inner Join tblbudget_init_cost_type AS t7 ON t7.CostTypeId = t6.CostTypeId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getCostItemCodeList */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลรายการค่าใช้จ่าย */	
	function getCostItemCodeList($DocCode,$selected=0,$tag_name='CostItemCode[]',$tag_attribs='style="width:99%;"',$label='เลือก'){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT distinct(t1.CostItemCode)as value , t2.CostName as text "
				."\n FROM "
				."\n tblfinance_form_chain_cost AS t1 "
				."\n left join tblbudget_init_cost_item as t2 on t2.CostItemCode=t1.CostItemCode "
				."\n ".$where_r
				."\n order by t1.CostItemCode "
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	
	}
	/* END */	
	
	/* START */
	/* Function Name: getOtherCostItemCodeList */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลรายการค่าใช้จ่าย */	
	function getOtherCostItemCodeList($DocCode,$selected=0,$tag_name='OtherCostItemCode[]',$tag_attribs='style="width:99%;"',$label='เลือก'){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT distinct(t1.CostItemCode)as value , t2.CostName as text "
				."\n FROM "
				."\n tblfinance_form_chain_cost AS t1 "
				."\n left join tblbudget_init_cost_item as t2 on t2.CostItemCode=t1.CostItemCode "
				."\n ".$where_r
				."\n order by t1.CostItemCode "
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	
	}
	/* END */	
	
	/* START */
	/* Function Name: fn_getFullNameByPersonalCode */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลชื่อบุคลากร */
	function fn_getFullNameByPersonalCode($Code){
		$sql = "SELECT
				CONCAT(tblpersonal_prefix.PrefixName,
				tblpersonal.FirstName,' ',
				tblpersonal.LastName) as FullName 
				FROM
				tblpersonal 
				Inner Join tblpersonal_prefix ON tblpersonal.PrefixId = tblpersonal_prefix.PrefixId 
				WHERE tblpersonal.PersonalCode='$Code' ";
		
		$this->db->setQuery($sql);
		$Data = $this->db->loadResult();
		return $Data;
	}
	/* END */	
	
	/* START */
	/* Function Name: getDocCodeDetail */
	/* Description: เป็นฟังก์ชันสำหรับข้อมูลเอกสาร */	
	function getDocCodeDetail($DocCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.*,t2.FormName,t2.FormDetail,t2.DocumentCode,t2.BGColor,t2.TopicDefault,t3.StatusName,t3.TextColor,t3.Icon "
				."\n FROM "
				."\n tblfinance_doccode as t1 "
				."\n left join tblfinance_init_form as t2 on t2.FormCode=t1.FormCode "
				."\n left Join tblfinance_init_status AS t3 ON t3.DocStatusId = t1.DocStatusId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadObjectList();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getFormDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลแบบฟอร์ม */	
	function getFormDetail($DocCode){
		$where = array();
		$where[] = "tm.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT tm.*,t1.*,t2.FormCodeAlias,t2.FormName,t2.FormDetail,t2.DocumentCode,t2.TopicDefault,t2.BGColor,t3.StatusName,t3.TextColor,t3.Icon "
				."\n FROM "
				."\n tblfinance_form_paybr as tm "
				."\n left join tblfinance_doccode as t1 on t1.DocCode=tm.DocCode "
				."\n left join tblfinance_init_form as t2 on t2.FormCode=t1.FormCode "
				."\n left Join tblfinance_init_status AS t3 ON t3.DocStatusId = t1.DocStatusId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadObjectList();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getChainFormDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลแบบฟอร์ม */	
	function getChainFormDetail($DocCode){
		$where = array();
		$where[] = "tm.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT tm.*,t1.*,t2.FormCodeAlias,t2.FormName,t2.FormDetail,t2.DocumentCode,t2.TopicDefault,t2.BGColor,t3.StatusName,t3.TextColor,t3.Icon "
				."\n FROM "
				."\n tblfinance_form_chain as tm "
				."\n left join tblfinance_doccode as t1 on t1.DocCode=tm.DocCode "
				."\n left join tblfinance_init_form as t2 on t2.FormCode=t1.FormCode "
				."\n left Join tblfinance_init_status AS t3 ON t3.DocStatusId = t1.DocStatusId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadObjectList();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getImpCostItemCodeHold */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อรายการค่าใช้จ่าย */	
	function getImpCostItemCodeChain($DocCode){
		$where 	  = array();
		$where[] ="DocCode='".$DocCode."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select distinct(CostItemCode)as CostItemCode from tblfinance_form_chain_cost ".$where_r; 
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
	}	
	/* END */	
	
	/* START */
	/* Function Name: getImpCostItemCode */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อรายการค่าใช้จ่าย */	
	function getImpCostItemCode($DocCode){
		$where 	  = array();
		$where[] ="DocCode='".$DocCode."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select distinct(CostItemCode)as CostItemCode from tblfinance_form_paybr_cost ".$where_r; 
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
	}	
	/* END */	
	
	/* START */
	/* Function Name: getImpOtherCostItemCode */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อรายการค่าใช้จ่าย */	
	function getImpOtherCostItemCode($DocCode){
		$where 	  = array();
		$where[] ="DocCode='".$DocCode."'";
		
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		
		$sql = "select distinct(CostItemCode)as CostItemCode from tblfinance_form_paybr_cost_other ".$where_r; 
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
	}	
	/* END */	
	
	/* START */
	/* Function Name: getCostDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลรายการค่าใช้จ่ายของเอกสาร */	
	function getCostDetail($DocCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.* "
				."\n FROM "
				."\n tblfinance_form_paybr_cost as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadObjectList();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getOtherCostDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลรายการค่าใช้จ่ายของเอกสาร */	
	function getOtherCostDetail($DocCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.* "
				."\n FROM "
				."\n tblfinance_form_paybr_cost_other as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadObjectList();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getCostDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลรายการค่าใช้จ่ายของเอกสาร */	
	function getHoldCostDetail($DocCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.* "
				."\n FROM "
				."\n tblfinance_form_chain_cost as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadObjectList();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */
	
	
	/* START */
	/* Function Name: getSumSumCostHold */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดงบรายการค่าใช้จ่ายของเอกสาร */	
	function getSumSumCostHold($DocCode,$CostItemCode=0){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.SumBGChain) "
				."\n FROM "
				."\n tblfinance_bg_chain as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumSumChain */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดงบรายการค่าใช้จ่ายของเอกสาร */	
	function getSumSumChain($DocCodeRefer,$CostItemCode,$notDocCode){
		$where = array();
		if($notDocCode){
			$where[] = "t1.DocCode not in('".$notDocCode."')";
		}
		$where[] = "t1.DocCodeRefer='".$DocCodeRefer."'";
		$where[] = "t1.CostItemCode='".$CostItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.SumCost) "
				."\n FROM "
				."\n tblfinance_bg_pay as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumSumRemain */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดงบรายการค่าใช้จ่ายของเอกสาร */	
	function getSumSumRemain($DocCode,$CostItemCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		$where[] = "t1.CostItemCode='".$CostItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.SumRemain) "
				."\n FROM "
				."\n tblfinance_form_chain_cost as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumBorrowBudget */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดรวมของงบยืมเงินทดรอง */	
	function getSumBorrowBudget($DocCode,$CostItemCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		$where[] = "t1.CostItemCode='".$CostItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.BorrowBudget) "
				."\n FROM "
				."\n tblfinance_form_paybr_cost as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumBillingBudget */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดงบวางบิลเบิกจ่าย */	
	function getSumBillingBudget($DocCode,$CostItemCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		$where[] = "t1.CostItemCode='".$CostItemCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.BillingBudget) "
				."\n FROM "
				."\n tblfinance_form_paybr_cost as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getPersonalName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อบุคลากร */	
	function getPersonalName($UserID){
		$where = array();
		$where[] = "u.UserID='".$UserID."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select concat(p.FirstName, ' ', p.LastName) as FullName "
				."\n from authen_users u "
				."\n inner join tblpersonal p on u.PersonalCode = p.PersonalCode "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		return $this->db->loadResult();
	}
	/* END */	
	
	/* START */
	/* Function Name: getDocName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อไฟล์เอกสารแนบ */	
	function getDocName($DocId){
		$where = array();
		$where[] = "DocId='".$DocId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select DocName "
				."\n from tblintra_edoc_center "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		return $this->db->loadResult();
	}
	/* END */	
	
	/* START */
	/* Function Name: getAttachList */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลเอกสารแนบ */	
	function getAttachList($DocCode=0){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
		$sql="SELECT t1.*,t2.AttachName "
		."\n FROM "
		."\n tblfinance_form_paybr_attach as t1 "
		."\n left join tblfinance_init_attach as t2 on t2.AttachCode=t1.AttachCode "
		."\n ".$where_r
		."\n order by t2.Ordering asc"
		;
		$this->db->setQuery($sql);//echo "<pre>$sql;</pre>";
		$datas = $this->db->loadObjectList();//ltxt::print_r($datas);
		return $datas;
	
	}
	/* END */	
	
	/* START */
	/* Function Name: getFormId */
	/* Description: เป็นฟังก์ชันสำหรับดึง ID ของเอกสาร */	
	function getFormId($DocCode){
		$where = array();
		$where[] = "DocCode='".$DocCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select EFormId "
				."\n from tblfinance_form_paybr "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		return $this->db->loadResult();
	}
	/* END */	
	
	/* START */
	/* Function Name: getMapAttachList */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายการค่าใช้จ่ายของเอกสาร */
	function getMapAttachList($FormCode=0){
		$where = array();
		$where[] = "t1.FormCode='".$FormCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
		$sql="SELECT t2.AttachCode, t2.AttachName, t2.AttachDetail, t1.Priority "
		."\n FROM "
		."\n tblfinance_init_form_attach as t1 "
		."\n left join tblfinance_init_attach as t2 on t2.AttachCode=t1.AttachCode "
		."\n ".$where_r
		."\n order by t1.Priority, t2.AttachName asc"
		;
		$this->db->setQuery($sql);//echo "<pre>$sql;</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;
	
	}
	/* END */	
	
	/* START */
	/* Function Name: getAttachName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อเอกสารแนบ */	
	function getAttachName($AttachCode){
		$where = array();
		$where[] = "AttachCode='".$AttachCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select AttachName "
				."\n from tblfinance_init_attach "
				."\n".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>$sql;</pre>";
		return $this->db->loadResult();
	}
	/* END */	
	
	/* START */
	/* Function Name: getAttachName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อเอกสารแนบ */	
	function getAttachTrue($DocCode,$AttachCode){
		$where = array();
		$where[] = "DocCode='".$DocCode."'";
		$where[] = "AttachCode='".$AttachCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select count(AttachCode) "
				."\n from tblfinance_form_paybr_attach "
				."\n".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>$sql;</pre>";
		return $this->db->loadResult();
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumHoldChain */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดงบรายการค่าใช้จ่ายของเอกสาร */	
	function getSumHoldChain($DocCodeRefer,$CostItemCode=0){
		$where = array();
		$where[] = "t1.DocCodeRefer='".$DocCodeRefer."'";
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.SumCost) "
				."\n FROM "
				."\n tblfinance_bg_pay as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START  */
	/* Function Name: getMasterCountryName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อประเทศ */
	function getMasterCountryName($CountryCode){
		$where = array();
		$where[] = "CountryCode='".$CountryCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT Country "
			 ."\n FROM tblmaster_country "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);//echo $sql;
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */
	
	/* START  */
	/* Function Name: getCheckInBy */
	/* Description: เป็นฟังก์ชันสำหรับตรวจสอบข้อมูลการ CheckIn เอกสาร */
	function getCheckInBy($DocCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		$where[] = "t1.CheckIn='Y'";
		$where[] = "t1.CheckInBy <>'".$_SESSION["Session_PersonalCode"]."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT CheckInBy "
			 ."\n FROM tblfinance_doccode as t1 "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadResult();//echo $data;
		return $data;
	}
	/* END */
	
	/* START  */
	/* Function Name: getCheckInByRefer */
	/* Description: เป็นฟังก์ชันสำหรับตรวจสอบข้อมูลการ CheckIn เอกสารหลักการ */
	function getCheckInByRefer($DocCodeRefer){
		$where = array();
		$where[] = "t1.DocCodeRefer='".$DocCodeRefer."'";
		$where[] = "t1.CheckIn='Y'";
		$where[] = "t1.CheckInBy <>'".$_SESSION["Session_PersonalCode"]."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT DocCode as DocCodeCheckIn,CheckInBy "
			 ."\n FROM tblfinance_doccode as t1 "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadObjectList();
		return $data;
	}
	/* END */
	

	
	/* START  */
	/* Function Name: getCheckInStatus */
	/* Description: เป็นฟังก์ชันสำหรับตรวจสอบข้อมูลการ CheckIn */
	function getCheckInStatus($DocCode,$DocCodeRefer){
		$message = "";
		//ตรวจสอบว่ามีการ check in เอกสารนีหรือไม่?
		$CheckInBy = $this->getCheckInBy($DocCode);
		if($CheckInBy){
			$message = "ไม่สามารถปรับปรุงเอกสารได้ เนื่องจาก เอกสารนี้กำลังถูก Check In โดย ".$this->fn_getFullNameByPersonalCode($CheckInBy);
		}else{
			//ตรวจสอบว่ามีการ check in ทะเบียนคุมงบประมาณของกิจกรรมนีหรือไม่?
			$data = $this->getCheckInByRefer($DocCodeRefer);
			if($data[0]->CheckInBy != ""){
				$message = "ไม่สามารถปรับปรุงเอกสารได้ เนื่องจาก เอกสารหลักการที่ขออนุมัติใช้เงิน สช.น เลขที่ ".$DocCodeRefer." กำลังถูก Check In ด้วยเอกสาร สช.น เลขที่ ".$data[0]->DocCodeCheckIn." โดย ".$this->fn_getFullNameByPersonalCode($data[0]->CheckInBy);
			}
		}
		return $message;
	}
	/* END */
	
	
	
	/* START  */
	/* Function Name: getCheckInBy */
	/* Description: เป็นฟังก์ชันสำหรับตรวจสอบข้อมูลการ CheckIn เอกสาร */
	function getDocCodeRefer($DocCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT DocCodeRefer "
			 ."\n FROM tblfinance_doccode as t1 "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadResult();
		return $data;
	}
	/* END */
	
	/* START  */
	/* Function Name: getDataDocCodeRefer */
	/* Description: เป็นฟังก์ชันสำหรับตรวจสอบข้อมูลการ CheckIn เอกสารหลักการ */
	function getDataDocCodeRefer($DocCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.* "
			 ."\n FROM tblfinance_form_chain as t1 "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$data = $this->db->loadObjectList();
		return $data;
	}
	/* END */
	
	/* START */
	/* Function Name: getSumSumCost */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดงบขออนุมัติ */	
	function getSumSumCost($DocCode,$CostItemCode=0){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.SumCost) "
				."\n FROM "
				."\n tblfinance_form_paybr_cost as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumSumCostChain */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดงบขออนุมัติ */	
	function getSumSumCostChain($DocCode,$CostItemCode=0){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.SumCost) "
				."\n FROM "
				."\n tblfinance_form_chain_cost as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getOtherSumSumCost */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดงบขออนุมัติ */	
	function getOtherSumSumCost($DocCode,$CostItemCode=0){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.OtherSumCost) "
				."\n FROM "
				."\n tblfinance_form_paybr_cost_other as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumSumClear */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดเคลียร์ค่าใช้จ่ายเงินยืมทดรอง */	
	function getSumSumClear($DocCodeRefer,$CostItemCode=0,$notDocCode=0){
		$where = array();
		$where[] = "t2.FormCode='FF007'";
		$where[] = "t2.DocCodeRefer='".$DocCodeRefer."'";
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if($notDocCode){
			$where[] = "t1.DocCode not in('".$notDocCode."')";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.SumCost) "
				."\n FROM "
				."\n tblfinance_form_paybr_cost as t1 "
				."\n left join tblfinance_form_paybr as t2 on t2.DocCode=t1.DocCode "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumSumBilling */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดวางบิลเบิกจ่าย */	
	function getSumSumBilling($DocCodeRefer,$CostItemCode=0,$notDocCode=0){
		$where = array();
		$where[] = "t2.FormCode='FF008'";
		$where[] = "t2.DocCodeRefer='".$DocCodeRefer."'";
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if($notDocCode){
			$where[] = "t1.DocCode not in('".$notDocCode."')";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.SumCost) "
				."\n FROM "
				."\n tblfinance_form_paybr_cost as t1 "
				."\n left join tblfinance_form_paybr as t2 on t2.DocCode=t1.DocCode "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	
	/* START */
	/* Function Name: getSumClearCash */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดเคลียร์ค่าใช้จ่าย */	
	function getSumClearCash($DocCode,$CostItemCode=0,$notDocCode=0){
		$where = array();
		$where[] = "t1.FormCode in('FF010','FF011','FF012','FH005')";
		$where[] = "t1.DocCode='".$DocCode."'";
		if($notDocCode){
			$where[] = "t1.DocCode not in('".$notDocCode."')";
		}
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.SumCost) "
				."\n FROM "
				."\n tblfinance_form_paybr_cost as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */
	
	/* START */
	/* Function Name: getSumClearPay */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดเคลียร์ค่าใช้จ่าย */	
	function getSumClearPay($DocCode,$CostItemCode=0,$notDocCode=0){
		$where = array();
		$where[] = "t1.FormCode in('FF010','FF011','FF012','FH005')";
		$where[] = "t1.DocCode='".$DocCode."'";
		if($notDocCode){
			$where[] = "t1.DocCode not in('".$notDocCode."')";
		}
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.SumCost) "
				."\n FROM "
				."\n tblfinance_form_paybr_cost as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */
	
	/* START */
	/* Function Name: getSumSumBill */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดวางบิลเบิกจ่าย */	
	function getSumSumBill($DocCode,$CostItemCode=0,$notDocCode=0){
		$where = array();
		$where[] = "t1.FormCode in('FF013','FF014','FF015','FH006')";
		$where[] = "t1.DocCode='".$DocCode."'";
		if($notDocCode){
			$where[] = "t1.DocCode not in('".$notDocCode."')";
		}
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.SumCost) "
				."\n FROM "
				."\n tblfinance_form_paybr_cost as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getSumSumCostClear */
	/* Description: เป็นฟังก์ชันสำหรับดึงผลรวมของยอดวางบิลเบิกจ่าย */	
	function getSumSumCostClear($DocCodeRefer,$CostItemCode=0,$notDocCode=0){
		$where = array();
		$where[] = "t2.DocCodeRefer='".$DocCodeRefer."'";
		if($CostItemCode){
			$where[] = "t1.CostItemCode='".$CostItemCode."'";
		}
		if($notDocCode){
			$where[] = "t1.DocCode not in('".$notDocCode."')";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(t1.SumCost) "
				."\n FROM "
				."\n tblfinance_form_paybr_cost as t1 "
				."\n left join tblfinance_form_paybr as t2 on t2.DocCode=t1.DocCode "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getBorrowCode */
	/* Description: เป็นฟังก์ชันสำหรับดึงเลขที่สัญญายืมเงิน */	
	function getBorrowCode($DocCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT BorrowCode "
				."\n FROM "
				."\n tblfinance_bg_borrow as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */
	
	/* START */
	/* Function Name: getItemClear */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลแบบฟอร์ม */	
	function getItemClear($BorrowCode,$notDocCode=0){
		$where = array();
		$where[] = "t1.BorrowCode='".$BorrowCode."'";
		if($notDocCode){
			$where[] = "t1.DocCode not in('".$notDocCode."')";
		}
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.* "
				."\n FROM "
				."\n tblfinance_form_paybr as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadObjectList();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */	
	
	/* START */
	/* Function Name: getCurClearNo */
	/* Description: เป็นฟังก์ชันสำหรับดึงครั้งล่าสุดที่เคลียร์เงินยืมทดรอง */	
	function getCurClearNo($DocCodeRefer){
		$where = array();
		$where[] = "t1.DocCodeRefer='".$DocCodeRefer."'";
		$where[] = "t1.DocStatusId not in(8,13) ";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT max(ClearNo) "
				."\n FROM "
				."\n tblfinance_form_paybr as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return ($datas+1);
	}
	/* END */
	
	/* START */
	/* Function Name: getSumBGBorrow */
	/* Description: เป็นฟังก์ชันสำหรับรวมยอดยืมเงินทดรอง */	
	function getSumBGBorrow($DocCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT TotalBorrow "
				."\n FROM "
				."\n tblfinance_form_chain as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */
	
	/* START */
	/* Function Name: getSumBGClearReturn */
	/* Description: เป็นฟังก์ชันสำหรับรวมยอดคืนเงินสด/เงินโอน */	
	function getSumBGClearReturn($DocCodeRefer){
		$where = array();
		$where[] = "t1.DocCodeRefer='".$DocCodeRefer."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(ReturnCost) "
				."\n FROM "
				."\n tblfinance_form_paybr as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */
	
	/* START */
	/* Function Name: getSumBGClearPay */
	/* Description: เป็นฟังก์ชันสำหรับรวมยอดเคลียร์ค่าใช้จ่าย */	
	function getSumBGClearPay($DocCodeRefer){
		$where = array();
		$where[] = "t1.DocCodeRefer='".$DocCodeRefer."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT sum(TotalCost) "
				."\n FROM "
				."\n tblfinance_form_paybr as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadResult();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	/* END */
	




	
	
}// end class
?>
