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
		$this->dpublic		= new BGPublic();
	}

	function getData($table,$field,$value){
		$sql="select * from ".$table." where ".$field." = ".$value."";
		$this->db->setQuery($sql);
		$row = $this->db->loadObjectList();
		return $row;
	}
	
	function getSCTypeRecordSet(){
		return $this->dpublic->getSCTypeRecordSet();
	}
	
	function test(){
		$sql = "select * "
				."\n from tblbudget_init_cost_item"
				;
		$this->db->setQuery($sql);echo $sql;
		$data = $this->db->loadObjectList();
		return $data;
	}

	
}
?>
