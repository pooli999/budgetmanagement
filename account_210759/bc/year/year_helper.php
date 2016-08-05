<?php

class sHelper
{
	var $dpublic;
	var $db;
	var $debug = 0;
	function sHelper()
	{
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
		$this->dpublic	= new BGPublic();
	}

	function getData($table,$field,$value){
		$sql="select * from ".$table." where ".$field." = ".$value."";
		$this->db->setQuery($sql);
		$row = $this->db->loadObjectList();
		return $row;
	}

	function getYear($Year,$ObjYear){
		return $this->dpublic->getYear($Year,$ObjYear);
	}
		
	function getYearList($BgtYear){
		return $this->dpublic->getYearList($BgtYear);
	}

	function getTotalPrj($BgtYear=0,$OrganizeCode=0,$PItemCode=0,$PrjId=0,$PrjDetailId=0,$PrjActId=0,$SCTypeId=0,$ScreenLevel=0,$SourceExId=0){
		return $this->dpublic->getTotalPrj($BgtYear,$OrganizeCode,$PItemCode,$PrjId,$PrjDetailId,$PrjActId,$SCTypeId,$ScreenLevel,$SourceExId);
	}
	
	/*function dataSet( &$datas ){
		$Tree = $this->getTree();
		$datas = $Tree->getTree(false);
	}	*/
	
	function dataSet( &$datas ){
		$where = array();
		$BgtYear = ($_REQUEST["id"])?$_REQUEST["id"]:$_REQUEST["BgtYear"];
		$where[] = "t1.OrgYear='".$BgtYear."'";
		$where[] = "t1.OrganizeCode <>'ROOT'";
		$where[] = "t1.DeleteStatus <>'Y'";
		$where[] = "t1.EnableStatus ='Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
		$sql="SELECT t1.*,concat(OrgName,' (',OrgShortName,')')as OrgName,t2.SCTypeId,t2.ScreenLevel  "
				."\n FROM "
				."\n tblorganize AS t1  "
				."\n left join tblbudget_init_year_org as t2 on t2.OrgId=t1.OrgId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;	
	}	
	
	function dataSetView( ){
		$where = array();
		$where[] = "t1.OrgYear='".$_REQUEST["id"]."'";
		$where[] = "t1.OrganizeCode <>'ROOT'";
		$where[] = "t1.DeleteStatus <>'Y'";
		$where[] = "t1.EnableStatus ='Y'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
		$sql="SELECT t1.*,concat(OrgName,' (',OrgShortName,')')as OrgName,t2.SCTypeId,t2.ScreenLevel  "
				."\n FROM "
				."\n tblorganize AS t1  "
				."\n right join tblbudget_init_year_org as t2 on t2.OrgId=t1.OrgId "
				."\n ".$where_r
				;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$datas = $this->db->loadObjectList();
		return $datas;	
	}	
	
	function getSCTypeId($BgtYear,$ScreenLevel){
		$where = array();
		$where[] = "t1.BgtYear='".$BgtYear."'";
		$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
		$sql="SELECT t1.SCTypeId "
				."\n FROM "
				."\n tblbudget_init_screen_item AS t1  "
				."\n ".$where_r
		;
		$this->db->setQuery($sql);//echo "<pre>$sql</pre>";
		$datas = $this->db->loadResult();//echo $datas;
		return $datas;	
	}	
	
	function getScreenName($BgtYear,$ScreenLevel){
		$where = array();
		$where[] = "t1.BgtYear='".$BgtYear."'";
		$where[] = "t1.ScreenLevel='".$ScreenLevel."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
		$sql="SELECT t1.ScreenName"
		."\n FROM "
		."\n tblbudget_init_screen_item AS t1  "
		."\n ".$where_r
		;
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	
	function getOrganizeName($OrganizeCode=0){
		return $this->dpublic->getOrganizeName($OrganizeCode);
	}
	
	function getCheckOrg($OrganizeCode,$BgtYear){
		$sql="select * from tblbudget_init_year_org where OrganizeCode='$OrganizeCode' and BgtYear='$BgtYear' ";
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;	
	}
	
	function getCheckYear(){
		$sql="select BgtYear as CheckYear from tblbudget_init_year ";
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;	
	}
	
/*	function getCheckYear($BgtYear){
		$sql="select BgtYear as CheckYear from tblbudget_init_year where BgtYear='$BgtYear' ";
		echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;	
	}	*/
		
	function getMaxRound($Year){
		$sql="select max(Round) as max from tblstructure_operation_round where Year='$Year' and EnableStatus='Y' and DeleteStatus='N' ";
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;	
	}
	
	/* START #F1 */
	/* Function Name: getTree */
	/* Description: เป็นฟังก์ชันสำหรับดึงหน่วยงานออกมาเป็นแต่ละระดับ  */
	/* Parameter: */
			/* @BgtYear	= ปีงบประมาณ */
	/* Return Value : Array(loadObjectList) */
			function getTree(){
				//$maxRound = $this->getMaxRound($_REQUEST["BgtYear"]?$_REQUEST["BgtYear"]:(date('Y')+543));
				//'OrgYear' =>$_REQUEST["BgtYear"]?$_REQUEST["BgtYear"]:(date('Y')+543),
				
				$maxRound = $this->getMaxRound($_REQUEST["BgtYear"]?$_REQUEST["BgtYear"]:$_GET["id"]);
				
				jimport('packages.utility.utl_grouptree');
				$Tree = new JGroupTree(array(
					'dbo'  => $this->db,
					'table' => 'tblstructure_operation',
					'prefix' => 'Org',
					'root' => 'Root',
					//'debug' => 2,
					'where'=>array(
						'OrgYear' =>$_REQUEST["BgtYear"]?$_REQUEST["BgtYear"]:$_GET["id"],
						'OrgRound' =>$maxRound,
						'DeleteStatus' => 'N'
					)
				));
				$Tree->rebuildTree(0,0);
				return $Tree;
			}	
	
	/* END */	
	
	/* START #F2 */
	/* Function Name: getDetail */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายละเอียดปีงบประมาณ  */
	/* Parameter: */
			/* @BgtYear	= ปีงบประมาณ */
	/* Return Value : Array(loadObjectList) */
	function getDetail(&$detail){
		$sql = "SELECT * FROM tblbudget_init_year where BgtYear=".$_GET['id'];
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$detail = $this->db->loadObjectList(); 
		return $detail;
	}	
	/* END */	

	
	/* START #F3 */
	/* Function Name: getCheckOrganizeCode */
	/* Description: เป็นฟังก์ชันสำหรับดึงข้อมูลหน่วยงานที่เลือกตามปีงบประมาณ  */
	/* Parameter: */
			/* @OrganizeCode	= รหัสหน่วยงาน */
			/* @BgtYear	= ปี */
	/* Return Value : Array(loadObjectList) */
	function getCheckOrganizeCode($BgtYear=0){		
		
		$where = array();
		
		//if($OrganizeCode){
			//$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		//}
		
		//if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		//}
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}		
						
		$sql="SELECT t1.*"
		."\n FROM "
		."\n tblbudget_init_year_org AS t1  "
		."\n ".$where_r
		;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadObjectList();
		return $datas;

	}
	/* END */	

	/* START #F4 */
	/* Function Name: getSCTypeCurOrg */
	/* Description: เป็นฟังก์ชันสำหรับดึงชื่อขั้นตอนการจัดทำงบประมาณปัจจุบันของแต่ละหน่วยงาน  */
	/* Parameter: */
			/* @SCTypeId = รหัสขั้นตอนการจัดทำงบประมาณ */
	/* Return Value : Single(loadResult) */
	function getSCTypeCurOrg($SCTypeId=0){
		
		$where = array();
		$where[] = "SCTypeId='".$SCTypeId."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT SCTypeName"
				."\n FROM tblbudget_init_screen_type "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	/* END */
	
	function getCountOrg($BgtYear){
		
		$where = array();
		$where[] = "BgtYear='".$BgtYear."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT count(*)"
				."\n FROM tblbudget_init_year_org "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
		
	}
	


	
}
?>
