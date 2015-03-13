<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

class Mysql{
	private static $instance=null;
	
	function __construct(){
		try{
			$db=@mysql_connect(DBSERVER.':'.DBPORT,DBUSER,DBPASS);
			$this->db=$db;
			@mysql_select_db(DBNAME,$this->db) or die('mysql select db error!');
			@mysql_query("SET NAMES utf8");
		} catch (Exception $e){
			echo "mysql connect error!".$e->getMessage();
			exit;
		}
    }
		
	static function getInstance(){
		if(self::$instance==null){
		    self::$instance=new Mysql();
		}
		return self::$instance;
    }
		
	function close(){
		return mysql_close($this->db);
    }
		
	function query($sql){
		if(WY_SQL_LOG){
		    $starttime=microtime(true);
		}
		try{
		    $result=@mysql_query($sql,$this->db);
		} catch (Exception $e){
		    echo 'ErrSql：'.$sql.'<br />ErrNo：'.$e->getMesage();exit;
		}
		if(WY_SQL_LOG){
		    $this->write_log($sql,microtime(true)-$starttime);
		}
		return $result;
    }
		
	function fetch_array($query){
		return mysql_fetch_array($query);
	}
		
	function fetch_row($query){
		return mysql_fetch_row($query);
	}
	
	function num_rows($query){
		return mysql_num_rows($query);
	}
		
	function insert_id(){
		return mysql_insert_id();
	}

	function affected_rows(){
	    return mysql_affected_rows();
	}
		
	function write_log($sql,$time){
		$content=_S('PHP_SELF')."\n".$sql."\n".($time)."\n".date('Y-m-d H:i:s')."\n"._S('REMOTE_ADDR')."\n\n";
		$dir_log=WY_ROOT.'/log/';
		if(!file_exists($dir_log)) @mkdir($dir_log , 0777 , true);
		$date=getdate(date('U'));
		$filename="log_".$date['year'].$date['mon'].$date['mday'].".txt";
		$fp=@fopen($dir_log.$filename , 'ab');
		@fwrite($fp,$content);
		@fclose($fp);
    }
}