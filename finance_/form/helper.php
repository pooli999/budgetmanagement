<?php
class sHelper
{
	var $db;
	var $debug = 0;
	function sHelper(){
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
	}
	
	function getGroupDocument(){
		$where = array();
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT * "
			 ."\n FROM tblfinance_init_document "
			 ."\n ".$where_r
			 ."\n order by DocumentId ASC "
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";	 
		$datas = $this->db->loadObjectList();
		return $datas;		
	}
	
	function getFormDocument($DocumentCode){
		$where = array();
		$where[] = "DocumentCode='".$DocumentCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT * "
			 ."\n FROM tblfinance_init_form "
			 ."\n ".$where_r
			 ."\n order by FormCode ASC "
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";	 
		$datas = $this->db->loadObjectList();
		return $datas;		
	}
	
	function getDataList($limit=20){
		$where = array();
		$where[] = "t1.DocStatusId in(2)";
		//$where[] = "t1.DocStatusId not in(1,13)";
		//$where[] = "((t1.RQPersonalCode = '".$_SESSION["Session_PersonalCode"]."') or (t1.CreateBy = '".$_SESSION["Session_UserId"]."' ) )";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.*,t2.StatusName,t2.TextColor,t2.Icon,t3.DocumentCode,t3.FormName "
			 ."\n FROM tblfinance_doccode as t1 "
			 ."\n left Join tblfinance_init_status AS t2 ON t2.DocStatusId = t1.DocStatusId "
			 ."\n left Join tblfinance_init_form AS t3 ON t3.FormCode = t1.FormCode "
			 ."\n ".$where_r
			 ."\n order by t1.DocDate desc ,t1.DocCode desc "
			 ;
		//echo $sql;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";	 
		$this->db->limit = $limit;
		$datas = $this->db->loadDataSet();
		return $datas;		
	}
	
	function getApproveDataList($limit=20){
		$where = array();
		$where[] = "t1.DocStatusId in(3)";
		//$where[] = "t1.DocStatusId not in(1,13)";
		//$where[] = "((t1.RQPersonalCode = '".$_SESSION["Session_PersonalCode"]."') or (t1.CreateBy = '".$_SESSION["Session_UserId"]."' ) )";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.*,t2.StatusName,t2.TextColor,t2.Icon,t3.DocumentCode,t3.FormName "
			 ."\n FROM tblfinance_doccode as t1 "
			 ."\n left Join tblfinance_init_status AS t2 ON t2.DocStatusId = t1.DocStatusId "
			 ."\n left Join tblfinance_init_form AS t3 ON t3.FormCode = t1.FormCode "
			 ."\n ".$where_r
			 ."\n order by t1.DocDate desc ,t1.DocCode desc "
			 ;
			 echo $sql;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";	 
		$this->db->limit = $limit;
		$datas = $this->db->loadDataSet();
		return $datas;		
	}
	
	function getHRDataList($limit=20){
		$where = array();
		$where[] = "t1.DocStatusId not in(1,13)";
		$where[] = "t1.FormCode in('FH007')";
		$where[] = "((t1.RQPersonalCode = '".$_SESSION["Session_PersonalCode"]."') or (t1.CreateBy = '".$_SESSION["Session_UserId"]."' ) )";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.*,t2.StatusName,t2.TextColor,t2.Icon,t3.DocumentCode,t3.FormName,tp.CKDate,tp.CKPersonalCode,tp.PayNo "
			 ."\n FROM tblfinance_doccode as t1 "
			 ."\n left join tblfinance_form_pay as tp on tp.DocCode=t1.DocCode "
			 ."\n left Join tblfinance_init_status AS t2 ON t2.DocStatusId = t1.DocStatusId "
			 ."\n left Join tblfinance_init_form AS t3 ON t3.FormCode = t1.FormCode "
			 ."\n ".$where_r
			 ."\n order by t1.DocDate desc ,t1.DocCode desc "
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";	 
		$this->db->limit = $limit;
		$datas = $this->db->loadDataSet();
		return $datas;		
	}
	
	function getLastDataList($limit=20){
		$where = array();
		$where[] = "t1.DocStatusId not in(13)";
		$where[] = "((t1.RQPersonalCode = '".$_SESSION["Session_PersonalCode"]."') or (t1.CreateBy = '".$_SESSION["Session_UserId"]."' ) )";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.*,t2.StatusName,t2.TextColor,t2.Icon,t3.DocumentCode,t3.FormName "
			 ."\n FROM tblfinance_doccode as t1 "
			 ."\n left Join tblfinance_init_status AS t2 ON t2.DocStatusId = t1.DocStatusId "
			 ."\n left Join tblfinance_init_form AS t3 ON t3.FormCode = t1.FormCode "
			 ."\n ".$where_r
			 ."\n order by t1.DocDate desc ,t1.DocCode desc "
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";	 
		$this->db->limit = $limit;
		$datas = $this->db->loadDataSet();
		return $datas;		
	}
	
	function getCountItem($DocStatusId=0){
		$where = array();
		$where[] = "t1.DocStatusId not in(13)";
		if($DocStatusId){
			$where[] = "t1.DocStatusId in(".$DocStatusId.")";
		}
		$where[] = "((t1.RQPersonalCode = '".$_SESSION["Session_PersonalCode"]."') or (t1.CreateBy = '".$_SESSION["Session_UserId"]."' ) )";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT count(*)as total "
			 ."\n FROM tblfinance_doccode as t1 "
			 ."\n left Join tblfinance_init_status AS t2 ON t2.DocStatusId = t1.DocStatusId "
			 ."\n left Join tblfinance_init_form AS t3 ON t3.FormCode = t1.FormCode "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";	 
		$datas = $this->db->loadResult();//echo $datas;
		return $datas;		
	}
	
	function getStatusList(){
		$where = array();
		$where[] = "t1.DocStatusId not in(13)";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.* "
			 ."\n FROM tblfinance_init_status as t1 "
			 ."\n ".$where_r
			 ."\n order by t1.Ordering"
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";	 
		$this->db->limit = $limit;
		$datas = $this->db->loadObjectList();
		return $datas;		
	}
	
	function getStatus(){
		$where = array();
		$where[] = "DocStatusId not in(13)";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT * "
			 ."\n FROM tblfinance_init_status "
			 ."\n ".$where_r
			 ."\n order by DocStatusId ASC "
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";	 
		$datas = $this->db->loadObjectList();
		return $datas;		
	}
	
	function getYearProject($selected=0,$tag_name='BgtYearCheckIn',$tag_attribs='onchange="loadPlan(this.value)"',$label='ทั้งหมด'){
		$where = array();
		$selected = ($selected)?$selected:$_REQUEST["BgtYearCheckIn"];
		$where[] = "BgtYear <> ' '";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT distinct(BgtYear)as value , BgtYear as text "
			 ."\n FROM tblbudget_project "
			 ."\n ".$where_r
			 ."\n order by BgtYear desc"
			 ;		 
		//echo "<pre>$sql</pre>";	 
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	
	function getPlanItemList($selected=0,$tag_name='PItemCodeCheckIn',$tag_attribs='style="width:99%;" onchange="loadPrj(this.value)"',$label='ทั้งหมด'){
		$where = array();
		$selected = ($selected)?$selected:$_REQUEST["PItemCodeCheckIn"];
		$where[] = "t1.BgtYear='".$_REQUEST["BgtYearCheckIn"]."'";
		$where[] = "t1.PGroupId='12'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT distinct(t1.PItemCode)as value , t1.PItemName as text "
			 ."\n FROM tblbudget_init_plan_item as t1 "
			 ."\n ".$where_r
			 ."\n order by t1.PItemCode ASC "
			  //."\n order by CONVERT(`PItemName` USING TIS620) ASC "
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
		
	}
	
	function getProjectListSearch($selected=0,$tag_name='PrjDetailIdCheckIn',$tag_attribs='style="width:99%;" onchange="loadPrjAct(this.value)"',$label='ทั้งหมด'){
		$where = array();
		$where[] = "t1.ActiveStatus='Y'";
		$where[] = "t4.BgtYear='".$_REQUEST["BgtYearCheckIn"]."'";
		$selected = ($selected)?$selected:$_REQUEST["PrjDetailIdCheckIn"];
		$where[] = "t4.PItemCode='".$_REQUEST["PItemCodeCheckIn"]."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		
		$sql="SELECT distinct(t1.PrjDetailId)as value , t4.PrjName as text "
				."\n FROM "
				."\n tblbudget_project_detail AS t1 "
				."\n Left Join tblbudget_project AS t4 ON  t4.PrjId = t1.PrjId "
				."\n ".$where_r
				."\n order by t4.PItemCode "
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	
	}
	
	function getProjectActListSearch($selected=0,$tag_name='PrjActCodeCheckIn',$tag_attribs='style="width:99%;"',$label='ทั้งหมด'){
		$where = array();
		$where[] = "t1.PrjDetailId='".$_REQUEST["PrjDetailIdCheckIn"]."'";
		$where[] = "t4.ActiveStatus='Y'";
		$selected = ($selected)?$selected:$_REQUEST["PrjActCodeCheckIn"];
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT distinct(t1.PrjActCode)as value , t1.PrjActName as text "
				."\n FROM "
				."\n tblbudget_project_activity AS t1 "
				."\n Left Join tblbudget_project_detail AS t4 ON  t4.PrjDetailId = t1.PrjDetailId "
				."\n ".$where_r
				."\n order by t1.PrjActCode "
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	
	}
	
	/*function getSourceListSearch($selected=0,$tag_name='SourceExId',$tag_attribs=' ',$label='ทั้งหมด'){
		$where = array();
		$where[] = "t1.PrjActId='".$_REQUEST["PrjActId"]."'";
		$selected = ($selected)?$selected:$_REQUEST["SourceExId"];
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT distinct(t1.SourceExId)as value , t4.SourceExName as text "
				."\n FROM "
				."\n tblbudget_project_activity_cost_external AS t1 "
				."\n Left Join tblbudget_init_source_external AS t4 ON  t4.SourceExId = t1.SourceExId "
				."\n ".$where_r
				."\n order by t4.Ordering "
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	
	}*/
	
	function getSourceListSearch($selected=0,$tag_name='SourceExIdCheckIn',$tag_attribs=' ',$label='ทั้งหมด'){
		$selected = ($selected)?$selected:$_REQUEST["SourceExIdCheckIn"];
		$where = array();
		$where[] = "t1.EnableStatus = 'Y'";
		$where[] = "t1.DeleteStatus <> 'Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.SourceExId as value , t1.SourceExName as text "
				."\n FROM "
				."\n tblbudget_init_source_external AS t1 "
				."\n ".$where_r
				."\n order by t1.Ordering "
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$title[] = clssHTML::makeOption(0,$label);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	
	}
	
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
	
	function getSumPlan($CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0,$MonthNo=0){
		$where = array();
		$where[] = "t2.ActiveStatus='Y'";
		if($_REQUEST["PrjActCodeCheckIn"]){
			$where[] = "t3.PrjActCode='".$_REQUEST["PrjActCodeCheckIn"]."'";
		}
		if($_REQUEST["SourceExIdCheckIn"]){
			$where[] = "t4.SourceExId='".$_REQUEST["SourceExIdCheckIn"]."'";
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
	
	function getSumTferIn($CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0){
		$where = array();
		$where[] = "t2.ActiveStatus='Y'";
		if($_REQUEST["DocCode"]){
			$where[] = "t8.DocCode <> '".$_REQUEST["DocCode"]."'";
		}
		if($_REQUEST["PrjActCodeCheckIn"]){
			$where[] = "t3.PrjActCode='".$_REQUEST["PrjActCodeCheckIn"]."'";
		}
		if($_REQUEST["SourceExIdCheckIn"]){
			$where[] = "t8.SourceExId='".$_REQUEST["SourceExIdCheckIn"]."'";
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
	
	function getSumTferOut($CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0){
		$where = array();
		$where[] = "t2.ActiveStatus='Y'";
		if($_REQUEST["DocCode"]){
			$where[] = "t8.DocCode <> '".$_REQUEST["DocCode"]."'";
		}
		if($_REQUEST["PrjActCodeCheckIn"]){
			$where[] = "t3.PrjActCode='".$_REQUEST["PrjActCodeCheckIn"]."'";
		}
		if($_REQUEST["SourceExIdCheckIn"]){
			$where[] = "t8.SourceExId='".$_REQUEST["SourceExIdCheckIn"]."'";
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
	
	function getSumHold($CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0){
		$where = array();
		$where[] = "t2.ActiveStatus='Y'";
		if($_REQUEST["DocCode"]){
			$where[] = "t8.DocCode <> '".$_REQUEST["DocCode"]."'";
		}
		if($_REQUEST["PrjActCodeCheckIn"]){
			$where[] = "t3.PrjActCode='".$_REQUEST["PrjActCodeCheckIn"]."'";
		}
		if($_REQUEST["SourceExIdCheckIn"]){
			$where[] = "t8.SourceExId='".$_REQUEST["SourceExIdCheckIn"]."'";
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
		$sql="SELECT sum(t8.SumBGHold)as total "
."\n FROM "
."\n tblfinance_bg_hold as t8 "
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
	
	function getSumChain($CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0){
		$where = array();
		$where[] = "t2.ActiveStatus='Y'";
		if($_REQUEST["DocCode"]){
			$where[] = "t8.DocCode <> '".$_REQUEST["DocCode"]."'";
		}
		if($_REQUEST["PrjActCodeCheckIn"]){
			$where[] = "t3.PrjActCode='".$_REQUEST["PrjActCodeCheckIn"]."'";
		}
		if($_REQUEST["SourceExIdCheckIn"]){
			$where[] = "t8.SourceExId='".$_REQUEST["SourceExIdCheckIn"]."'";
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
	
	function getSumPay($CostTypeId=0,$LevelId=0,$ParentCode=0,$HasChild="",$CostItemCode=0){
		$where = array();
		$where[] = "t2.ActiveStatus='Y'";
		if($_REQUEST["DocCode"]){
			$where[] = "t8.DocCode <> '".$_REQUEST["DocCode"]."'";
		}
		if($_REQUEST["PrjActCodeCheckIn"]){
			$where[] = "t3.PrjActCode='".$_REQUEST["PrjActCodeCheckIn"]."'";
		}
		if($_REQUEST["SourceExIdCheckIn"]){
			$where[] = "t8.SourceExId='".$_REQUEST["SourceExIdCheckIn"]."'";
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
	
	function getMaxNo(){
		$sql = "SELECT MAX(AutoNo) as MaxNo  FROM tblfinance_doccode  "; //echo $sql;
		$this->db->setQuery($sql);
		$Data = $this->db->loadResult();
		$nextAutoNo = $Data+1;
		return $nextAutoNo;
	}
	
	function genDocCode(){
		$nextAutoNo = $this->getMaxNo() ;
		//$RunYear = substr(date("Y")+543,2,2);
		$RunYear = date("Y")+543;
		$RunNo = sprintf("%04s",$nextAutoNo);
		$Code = $RunNo."/".$RunYear;
		return $Code;
	}
	
	function getTopicDefault($FormCode){
		$where = array();
		$where[] = "FormCode='".$FormCode."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select TopicDefault "
				."\n from tblfinance_init_form "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);echo "<pre>".$sql."</pre>";
		$datas = $this->db->loadResult();
		return $datas;
	}
	
	function getPrjId($PrjDetailId){
		$where = array();
		$where[] = "PrjDetailId='".$PrjDetailId."'";
		if($where){
			$where_r = "\n where ".implode(" and ",$where);
		}
		$sql="select PrjId "
				."\n from tblbudget_project_detail "
				."\n".$where_r
				;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	
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
	
	/* Function Name: getOrgShortNameListApprove 
	Description: เป็นฟังก์ชันสำหรับดึงหน่วยงานผู้ขออนุมัติตามปีงบประมาณ
	Parameter: 
			@BgtYearApprove = ปีงบประมาณ
			@selected 		= ค่า selected ของ list box 
			@tag_attribs 	= attribute ของ list box 
			@tag_name 	= ชื่อ list box 
			@lebel 			= lebel ของ option ตัวแรก
	Return Value : List Box */	
	function getOrgShortNameListApprove($RQOrgRoundCode=0,$selected=0,$tag_name='RQOrganizeCode',$tag_attribs='onchange="loadPersonList(this.value)" style="width:80%"',$lebel='เลือก'){
				$RQOrgRoundCode = ($RQOrgRoundCode)?$RQOrgRoundCode:$_REQUEST["RQOrgRoundCode"];
				if($selected == ''){
					$selected = $_SESSION['Session_OrgCode'];
				}
				jimport('packages.utility.utl_grouptree');
				$Tree = $this->getTree($RQOrgRoundCode);
				$t = $Tree->getTree(false);
				
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
				}
				
				echo clssHTML::selectList( $row, $tag_name, $tag_attribs,'value','text', $selected );

	}
	// END	
	
	function getPersonList($RQOrgRoundCode=0,$RQOrganizeCode=0,$selected=0,$tag_name='RQPersonalCode',$tag_attribs='onchange="loadPositionList(this.value);" style="width:200px"',$lebel='เลือก'){
		$where = array();	
		$RQOrgRoundCode = ($RQOrgRoundCode)?$RQOrgRoundCode:$_REQUEST["RQOrgRoundCode"];
		$where[] = " t3.OrgRoundCode='".$RQOrgRoundCode."'";
		$RQOrganizeCode = ($RQOrganizeCode)?$RQOrganizeCode:$_REQUEST["RQOrganizeCode"];
		$where[] = " t1.OrganizeCode='".$RQOrganizeCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT DISTINCT t2.PersonalCode as value , concat(t2.FirstName,' ',t2.LastName) as text "
			 ."\n FROM tblstructure_operation_personal AS t1 "
			 ."\n Inner Join tblpersonal AS t2 ON t2.PersonalCode = t1.PersonalCode "
			 ."\n Inner Join tblstructure_operation AS t3 ON t3.OrganizeCode = t1.OrganizeCode "
			 ."\n ".$where_r
			 ."\n order by concat(t2.FirstName,' ',t2.LastName) ASC  "
			 ;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}
	
	function getPositionByPersonalCode($PersonalCode=0){
		$where = array();
		$where[] = " PersonalCode='".$PersonalCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT PositionId "
			 ."\n FROM tblpersonal_position "
			 ."\n ".$where_r
			 ;	
		//echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	
	function getPositionList($RQPersonalCode=0,$selected=0,$tag_name='RQPositionId',$tag_attribs='style="width:200px"',$lebel='เลือก'){
		$RQPersonalCode = ($RQPersonalCode)?$RQPersonalCode:$_REQUEST["RQPersonalCode"];
		$where = array();
		if($RQPersonalCode){
			$selectedP =  $this->getPositionByPersonalCode($RQPersonalCode);
			if($selected == ''){
				$selected = $selectedP;
			}	
		}
		$where[] = "EnableStatus='Y'";
		$where[] = "DeleteStatus='N'";		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT PositionId as value , Position as text "
			 ."\n FROM tblposition "
			 ."\n ".$where_r
			 ."\n order by CONVERT(`Position` USING TIS620) ASC "
			 ;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";
		$title[] = clssHTML::makeOption(0,$lebel);
		$datas = $this->db->loadObjectList();
		$datas = array_merge($title,$datas);
		echo clssHTML::selectList( $datas, $tag_name, $tag_attribs,'value','text', $selected );
	}
	
		/* START #F56 */
	/* Function Name: getScreenName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อหน่วยงาน */
	/* Parameter: */
			/* @OrganizeCode	= รหัสหน่วยงาน */
	/* Return Value : Single(loadResult) */
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
	
		/* START #F67 */
	/* Function Name: getPrjActName */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อตำแหน่ง */
	/* Parameter: */
			/* @PositionId	= รหัสตำแหน่ง */
	/* Return Value : Single(loadResult) */
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
	
	function getFormDetail($FormCode){
		$where = array();
		$where[] = "t1.FormCode='".$FormCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.FormName,t1.FormDetail,t1.DocumentCode,t1.FormCode,t1.BGColor "
				."\n FROM "
				."\n tblfinance_init_form as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadObjectList();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	
	function getDocCodeDetail($DocCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.*,t2.FormName,t2.FormDetail,t2.DocumentCode,t2.BGColor "
				."\n FROM "
				."\n tblfinance_doccode as t1 "
				."\n left join tblfinance_init_form as t2 on t2.FormCode=t1.FormCode "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadObjectList();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	
	function ItemCheckIn($PrjActCode,$SourceExId){
		$where = array();
		$where[] = "t1.PrjActCode='".$PrjActCode."'";
		$where[] = "t1.SourceExId='".$SourceExId."'";
		$where[] = "t1.CheckIn='Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.CheckIn,t1.CheckInBy,t1.DocCode "
				."\n FROM "
				."\n tblfinance_doccode as t1 "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>".$sql."</pre>";	
		$datas = $this->db->loadObjectList();//echo "<pre>".$datas."</pre>";	
		return $datas;
	}
	
	function getHoldDataList($limit=20){
		$where = array();
		$where[] = "t1.DocStatusId not in(13)";
		if(strtolower($_REQUEST["GForm"]) == "ff"){
			$where[] = "t1.FormCode in('FF007A','FF007B','FF008A','FF008B','FF009A','FF009B')";
		}
		if(strtolower($_REQUEST["GForm"]) == "fh"){
			$where[] = "t1.FormCode in('FH002')";
		}
		$where[] = "((t1.RQPersonalCode = '".$_SESSION["Session_PersonalCode"]."') or (t1.CreateBy = '".$_SESSION["Session_UserId"]."' ) )";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.*,t1.FormCode as FormCodeRefer,t2.StatusName,t2.TextColor,t2.Icon,t3.DocumentCode,t3.FormName "
			 ."\n FROM tblfinance_form_chain as t1 "
			 ."\n left Join tblfinance_init_status AS t2 ON t2.DocStatusId = t1.DocStatusId "
			 ."\n left Join tblfinance_init_form AS t3 ON t3.FormCode = t1.FormCode "
			 ."\n ".$where_r
			 ."\n order by t1.DocDate desc ,t1.DocCode desc "
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";	 
		$this->db->limit = $limit;
		$datas = $this->db->loadDataSet();
		return $datas;		
	}
	
	function getHoldDataDetail($DocCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.*,t2.StatusName,t2.TextColor,t2.Icon,t3.DocumentCode,t3.FormName "
			 ."\n FROM tblfinance_form_hold as t1 "
			 ."\n left Join tblfinance_init_status AS t2 ON t2.DocStatusId = t1.DocStatusId "
			 ."\n left Join tblfinance_init_form AS t3 ON t3.FormCode = t1.FormCode "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";	 
		$datas = $this->db->loadObjectList();
		return $datas;		
	}
	
	function getChainDataDetail($DocCode){
		$where = array();
		$where[] = "t1.DocCode='".$DocCode."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT t1.*,t2.StatusName,t2.TextColor,t2.Icon,t3.DocumentCode,t3.FormName "
			 ."\n FROM tblfinance_form_chain as t1 "
			 ."\n left Join tblfinance_init_status AS t2 ON t2.DocStatusId = t1.DocStatusId "
			 ."\n left Join tblfinance_init_form AS t3 ON t3.FormCode = t1.FormCode "
			 ."\n ".$where_r
			 ;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";	 
		$datas = $this->db->loadObjectList();
		return $datas;		
	}


	
	
	
}
?>
