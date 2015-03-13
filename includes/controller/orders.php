<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT')) exit;
class orders extends checkUser{

	function __construct(){
		parent::__construct();
	}
    function display(){
        
        $goodid=_G('goodid');
        $status=_G('status');
        $state=isset($_GET['state']) ? _G('state','int') : -1;
        $fdate=_G('fdate');
        $tdate=_G('tdate');
        $kwd=_G('kwd');
        
        $data=array();
        $page=_G('p','int');
        $page=$page ? $page : 1;
        $pagesize=20;
        $offset=($page-1)*$pagesize;
        $cons='userid='.$_SESSION['login_userid'];
        
        if($goodid && preg_match('/\d+/',$goodid)){
            $cons.=$cons ? ' and ' : '';
            $cons.="tb_goodid='".$goodid."'";
        }
        
        if($status){
            $cons.=$cons ? ' and ' : '';
            $cons.="tb_status='".$status."'";
        }
        
        if($state>=0){
            $cons.=$cons ? ' and ' : '';
            $cons.='is_state='.$state;
        }
        
        if($fdate){
            $cons.=$cons ? ' and ' : '';
            $cons.='tb_addtime>='.strtotime($fdate);
        }
        
        if($tdate){
            $cons.=$cons ? ' and ' : '';
            $cons.='tb_addtime<='.strtotime($tdate.' 23:59:59');
        }
        if($kwd){
            $cons.=$cons ? ' and ' : '';
            $cons="tb_orderid like '%".$kwd."%' or buyer_nick like '%".$kwd."%'";
        }
        
        $search=array(
            'goodid'=>$goodid,
            'status'=>$status,
            'state'=>$state,
            'fdate'=>$fdate,
            'tdate'=>$tdate,
            'kwd'=>$kwd,
        );
        
        if($totalsize=$this->model('orders')->count('orders',$cons)){
            $data=$this->model('orders')->get_orders($pagesize,$offset,$cons);
        }
        
        $totalpage=ceil($totalsize / $pagesize);
        $s_params='';
        foreach($search as $key=>$val){
            $s_params.=$s_params ? '&' : '';
            $s_params.=$key.'='.$val;
        }
        $pagelist=getpagelist('/orders?'.$s_params.'&p=',$page,$totalpage,$totalsize,$pagesize);
        
        $goods=$this->model('goods')->get_goods(false,false,'userid='.$_SESSION['login_userid']);
        
        $this->assign('title','订单列表');
        $this->assign('data',$data);
        $this->assign('goods',$goods);
        $this->assign('search',$search);
        $this->assign('pagelist',$pagelist);
        $this->getView('orders.php')->Output();
    }
    
    function send(){
        $orderid=_P('orderid');
        $send=new gate();
        $send->sendGoods($orderid);
        return true;
    }
}
?>