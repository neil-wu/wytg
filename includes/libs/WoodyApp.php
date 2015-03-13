<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

class WoodyApp{
	private static $instance=null;
	private static $models=array();

    function __construct(){
		$this->tpl=WY_ROOT.'/includes/libs/';
	}

	static function getInstance(){
	    if(self::$instance==null){
		    self::$instance=new WoodyApp();
		}
		return self::$instance;
	}

	function run(){
		global $router;

		$router=$this->router();
		$c_path=WY_ROOT.'/includes/controller/'.$router[1].'.php';
		if(!file_exists($c_path)){
			echo '<html><head><title>404 Not Found</title></head><body>HTTP/1.1 404 Not Found</body></html>';exit;
		}

		require_once($c_path);

		$ob=new $router[1]();
		$method=method_exists($ob,$router[2]) ? $router[2] : 'display';
		$ob->$method();
	}	

	static function model($model_class=null){
	    if($model_class==null){
		    $model_class='Wy_Model';
		} else {
		    if(!strpos($model_class,'_class')){
			    $model_class.='_class';
			}
		}

		if(!isset(self::$models[$model_class])){
		    $model=new $model_class();
			self::$models[$model_class]=$model;
		}

		return self::$models[$model_class];
	}

	function router(){

		$router=array();

	    if(_S('REQUEST_URI')){
		     $request_uri=_S('REQUEST_URI');
		}

	    if(_S('REDIRECT_URL')){
		     $request_uri=_S('REDIRECT_URL');
		}

		if(_S('HTTP_X_REWRITE_URL')){
		    $request_uri=_S('HTTP_X_REWRITE_URL');
		}

		if(strpos($request_uri,'?')){
		    $request_uri_arr=explode('?',$request_uri);
			$request_uri=$request_uri_arr[0];
		}

		if($request_uri!='/'){
		    $request_uri_arr=explode('/',$request_uri);
            foreach($request_uri_arr as $part){
                $router[]=$part;
            }
			$router[1]=isset($request_uri_arr[1]) ? $request_uri_arr[1] : 'main';
			$router[2]=isset($request_uri_arr[2]) ? $request_uri_arr[2] : 'display';

		} else {
			$router[1]='main';
			$router[2]='display';
		}

		return $router;
	}
}
?>