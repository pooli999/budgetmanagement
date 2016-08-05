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

	function getYear($selected=0,$tag_name='BgtYear',$tag_attribs='onchange="loadSCT(this.value)"',$lebel='เลือก'){
		return $this->dpublic->getYear($selected,$tag_name,$tag_attribs,$lebel);
	}

	function getSCTypeName($SCTypeId=0){
		return $this->dpublic->getSCTypeName($SCTypeId);
	}
	
	function countScreenLevel($BgtYear=0){
		return $this->dpublic->countScreenLevel($BgtYear);
	}
	
	function getScreenRecordSet($BgtYear=0){
		return $this->dpublic->getScreenRecordSet($BgtYear);
	}	
	
	/* Function Name: getOrganize */
	/* Description: เป็นฟังก์ชันสำหรับดึงรายหน่วยงานในปีงบประมาณ ที่เลือก */
	function getOrganize($BgtYear=0){
		$where = array();
		$where[] = "BgtYear = '".$BgtYear."'";
				if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql = "select * "
				."\n from tblbudget_init_year_org "
				."\n ".$where_r
				;
		//echo $sql;
		$this->db->setQuery($sql);
		$data = $this->db->loadObjectList();
		return $data;
	}
	/* END */

	/* Function Name: getNameByScreen */
	/* Description: เป็นฟังก์ชันสำหรับดึงขั้นตอนการจัดทำงบประมาณปัจจุบันของแต่ละหน่วยงาน  */
	/* Parameter: */
			/* @BgtYear			= ปีงบประมาณ */
			/* @OrganizeCode 	= รหัสหน่วยงาน */
	/* Return Value : Array(loadObjectList) */
	function getNameByScreen($BgtYear=0,$ScreenLevel=0,$SCTypeId=0,$countScreenLevel){
		
		
		
		if($SCTypeId == 1){
			$Level = $ScreenLevel +1;
		}else if($SCTypeId == 2){
			if($ScreenLevel != $countScreenLevel){  $Level = $ScreenLevel +1; }else{  $txtTopic = "ผู้บริหาร สช.";  }
		}
		
		
		$where = array();
		$where[] = "BgtYear='".$BgtYear."'";
		$where[] = "ScreenLevel='".$Level."'";
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n ScreenName "
				."\n FROM "
				."\n tblbudget_init_screen_item  "
				."\n ".$where_r
				;
		//echo "<pre>$sql</pre>";
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		
		if($SCTypeId == 2 && $ScreenLevel == $countScreenLevel){  return $txtTopic;  }else{ return $datas; } 
		
	}
	/* END */

	/* Function Name: getTotalPrjInternalX4 */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินงบประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjInternalX4($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$StatusId=''){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($StatusId == ""){
			$where[] = "t2.ActiveStatus='Y' ";
		}else{
			$where[] = "t2.StatusId != 5 ";
		}
		
		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t4.SumCost)as total "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjId = t1.PrjId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjDetailId = t2.PrjDetailId "
				."\n Inner Join tblbudget_project_activity_cost_internal AS t4 ON t4.PrjActId = t3.PrjActId "
				."\n ".$where_r
				;
				
		//echo "<pre>IN <br>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}
	/* END */
	
	/* Function Name: getTotalPrjExternalX4 */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินนอกประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getTotalPrjExternalX4($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$StatusId=''){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		
		if($StatusId == ""){
			$where[] = "t2.ActiveStatus='Y' ";
		}else{
			$where[] = "t2.StatusId != 5 ";
		}

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n sum(t4.SumCost)as total "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjId = t1.PrjId "
				."\n Inner Join tblbudget_project_activity AS t3 ON t3.PrjDetailId = t2.PrjDetailId "
				."\n Inner Join tblbudget_project_activity_cost_external AS t4 ON t4.PrjActId = t3.PrjActId "
				."\n ".$where_r
				;
		//echo "<pre>EX<br>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}

	/* END */
	
	/* Function Name: getTotalPrj */
	/* Description: เป็นฟังก์ชันสำหรับดึงยอดงบประมาณโครงการ ตาราง X4ช่อง(เงินงบประมาณ+เงินนอกประมาณ) */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */	

	function getTotalPrj($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$StatusId=''){
		//$BgtYear = ($BgtYear)?$BgtYear:(date("Y")+543);
		$BGInt		= $this->getTotalPrjInternalX4($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$StatusId);
		$BGExt		= $this->getTotalPrjExternalX4($BgtYear,$OrganizeCode,$SCTypeId,$ScreenLevel,$StatusId);
		$BGTotal	= $BGInt+$BGExt;
		return $BGTotal;
	}
	/* END */	

	/* Function Name: getCountPrj */
	/* Description: เป็นฟังก์ชันสำหรับดึงนับจำนวนโครงการตามสถานะ */
	/* Parameter: */
			/* @XXXX	= - */
	/* Return Value : Field */
	function getCountPrj($BgtYear=0,$OrganizeCode=0,$SCTypeId=0,$ScreenLevel=0,$StatusId=0){
		
		$where = array();
		if($BgtYear){
			$where[] = "t1.BgtYear='".$BgtYear."'";
		}
		if($OrganizeCode){
			$where[] = "t1.OrganizeCode='".$OrganizeCode."'";
		}
		if($SCTypeId){
			$where[] = "t2.SCTypeId='".$SCTypeId."'";
		}
		if($ScreenLevel){
			$where[] = "t2.ScreenLevel='".$ScreenLevel."'";
		}
		if($StatusId){
			$where[] = "t2.StatusId='".$StatusId."'";
		}	
		
		$where[] = "t2.ActiveStatus='Y' ";

		if(count($where)) {
			$where_r = "WHERE ". implode( " AND ", $where );
		}
		$sql="SELECT "
				."\n count(t1.PrjId) as num "
				."\n FROM "
				."\n tblbudget_project AS t1 "
				."\n Inner Join tblbudget_project_detail AS t2 ON t2.PrjId = t1.PrjId "
				."\n ".$where_r
				;
	//	echo "<pre>".$sql."</pre>";		
		$this->db->setQuery($sql);
		$datas = $this->db->loadResult();
		return $datas;
	}



}//end class
?>
