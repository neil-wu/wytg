<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT')) exit;
class Cache {
	private $cache_path;
	private static $instance=null;
	private $db;
	
	public function __construct(){
		$this->cache_path=WY_ROOT.'/cache/';
		$this->db=Mysql::getInstance();
	}
		
	static function getInstance(){
		if(self::$instance==null){
			self::$instance=new Cache();
	    }
		return self::$instance;
	}

	private function fileName($key){
		if(!file_exists($this->cache_path)) mkdir($this->cache_path);
		return $this->cache_path.md5($key.WY_CACHE_TOKEN).'.php';
	}

	public function put($key, $data,$cons=''){		
		$values = serialize($data);
		$filename = $this->fileName($key);
		$file = fopen($filename, 'w');
	    if ($file){
	        fwrite($file, $values);
	        fclose($file);
	    }
	    else return false;
	}

	public function get($key){
		$filename = $this->fileName($key);
		if (!file_exists($filename) || !is_readable($filename)){
			return false;
		}
			$file = fopen($filename, "r");
	        if ($file){
	            $data = fread($file, filesize($filename));
	            fclose($file);
	            return unserialize($data);
	        }
	        else return false;
 	}

    function updateCache($cacheName='',$cons=''){
        if(is_string($cacheName)){
    	  $data=array();
    	  $data=$this->$cacheName($cons);
    	  $this->put($cacheName,$data,$cons);
    	}

    	if(is_array($cacheName)){
    	    foreach($cacheName as $method){
    		    $data=array();
    		    $data=$this->$method();
    			$this->put($method,$data,$cons);
    		}
    	}
    }
}
?>