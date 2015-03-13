<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

class Wy_Model{
    private $db;
	private $tableName;

	function __construct(){
	    $this->db=Mysql::getInstance();
	}

	function insert($table,$data){
	    $filed=array();
		$value=array();
		foreach($data as $key=>$val){
		    $filed[]=$key;
			$value[]="'$val'";
		}

		$fileds=implode(',',$filed);
		$values=implode(',',$value);

		$this->query("INSERT INTO ".$this->table($table)." ($fileds) VALUES($values)");
		return $this->insert_id();
	}

	function update($table,$data,$cons=''){
		$cons=$cons ? 'WHERE '.$cons : '';
	    $item=array();
		foreach($data as $key=>$val){
		    $item[]="$key='$val'";
		}

		$items=implode(',',$item);

		$this->query("UPDATE ".$this->table($table)." SET $items $cons");
		return $this->affected_rows();
	}

	function delete($table,$cons=''){
		$cons=$cons ? 'WHERE '.$cons : '';
	    $this->query("DELETE FROM ".$this->table($table)." $cons");
		return $this->affected_rows();
	}

	function count($table,$cons=''){
		$cons=$cons ? 'WHERE '.$cons : '';
	    $result=$this->query("SELECT COUNT(*) FROM ".$this->table($table)." $cons");
		$row=$this->fetch_array($result);
		return $row[0];
	}

	function fetch_all($table,$limit='',$offset='',$cons='',$order=''){
		$cons=$cons ? 'WHERE '.$cons : '';
		$cons.=$order ? ' '.$order : '';
		if($offset){
		    $cons.=' LIMIT '.$offset;
			if($limit){
			    $cons.=','.$limit;
			}
		} else {
		    if($limit){
			    $cons.=' LIMIT '.$limit;
			}
		}

		$data=array();
	    $result=$this->query("SELECT * FROM ".$this->table($table)." $cons");
		while($row=$this->fetch_array($result)){
		    $data[]=$row;
		}
		return $data;
	}

	function fetch_one($table,$cons='',$column='*'){
		$cons=$cons ? 'WHERE '.$cons : '';
	    $result=$this->query("SELECT ".$column." FROM ".$this->table($table)." ".$cons." LIMIT 1");
		return $this->fetch_array($result);
	}

	function query($sql){
	    return $this->db->query($sql);
	}

	function fetch_array($result){
	    return $this->db->fetch_array($result);
	}

	function fetch_row($result){
	    return $this->db->fetch_row($result);
	}

	function num_rows($result){
	    return $this->db->num_rows($result);
	}

	function insert_id(){
	    return $this->db->insert_id();
	}

	function affected_rows(){
	    return $this->db->affected_rows();
	}

	function table($table){
	    return DB_PREFIX.$table;
	}

	function model($class){
	    return WoodyApp::model($class);
	}
}
?>