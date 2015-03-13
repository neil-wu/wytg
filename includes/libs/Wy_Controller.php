<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

class Wy_Controller{
	public $db;
    function __construct(){
		$this->data=array();
		$this->db=Mysql::getInstance();
		$this->tpl=WY_ROOT.'/view/tpl/default/';
        $this->config=$this->model('config')->get_config();

		global $router;
		$this->router=$router;
	}

	function model($model){
	    return WoodyApp::model($model);
	}

	function display(){
		$this->assign('img','');
		$this->assign('url',_S('HTTP_REFERER'));
		$this->assign('msg','');
	    $this->getView('wy_messager.php')->outPut();exit;
	}

	function assign($key,$val){
	    $this->data[$key]=$val;
		return $this->data;
	}

	function getView($file){
		if($this->data){
		    extract($this->data);
		}
		if(is_array($file)){
		    foreach($file as $f){
				if(!file_exists($this->tpl.$f)){
					$f='wy_messager.php';
				}
				require $this->tpl.$f;
			}
		} else {
			if(!file_exists($this->tpl.$file)){
				$file='wy_messager.php';
			}
			require $this->tpl.$file;
		}
	    
		return $this;
	}

	function outPut(){
		$content=ob_get_contents();		
        ob_get_clean();
        echo $content;
		if(ob_get_level()){ob_end_flush();}
	}
}
?>