<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT')) exit;
class goods extends checkUser{

	function __construct(){
		parent::__construct();
	}
    function display(){
        $goodid=_G('goodid');
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
       
        if($state>=0){
            $cons.=$cons ? ' and ' : '';
            $cons.='is_state='.$state;
        }
        
        if($fdate){
            $cons.=$cons ? ' and ' : '';
            $cons.='addtime>='.strtotime($fdate);
        }
        
        if($tdate){
            $cons.=$cons ? ' and ' : '';
            $cons.='addtime<='.strtotime($tdate.' 23:59:59');
        }
        
        if($kwd){
            $cons.=$cons ? ' and ' : '';
            $cons="tb_title like '%".$kwd."%'";
        }
        
        $search=array(
            'goodid'=>$goodid,
            'state'=>$state,
            'fdate'=>$fdate,
            'tdate'=>$tdate,
            'kwd'=>$kwd,
        );
        
        if($totalsize=$this->model('goods')->count('goods',$cons)){
            $data=$this->model('goods')->get_goods($pagesize,$offset,$cons);
        }
        $totalpage=ceil($totalsize / $pagesize);
        $s_params='';
        foreach($search as $key=>$val){
            $s_params.=$s_params ? '&' : '';
            $s_params.=$key.'='.$val;
        }
        $pagelist=getpagelist('/goods?'.$s_params.'&p=',$page,$totalpage,$totalsize,$pagesize);
        
        $this->assign('title','商品列表');
        $this->assign('data',$data);
        $this->assign('search',$search);
        $this->assign('pagelist',$pagelist);
        $this->getView('goods.php')->Output();
    }
    
    function add(){
  
        $data=TB::API('taobao.items.onsale.get',array(
            'fields'=>' approve_status,num_iid,title,nick,type,cid,pic_url,num,props,valid_thru,list_time,price,has_discount,has_invoice,has_warranty,has_showcase,modified,delist_time,postage_id,seller_cids,outer_id',
            'page_size'=>50,
        ));

        $tplinfo=$this->model('users')->get_msgtpl(false,false,'is_state=0 and userid='.$_SESSION['login_userid']);

        $this->assign('title','商品配置');
        $this->assign('data',$data);
        $this->assign('tplinfo',$tplinfo);
        $this->getView('goodsadd.php')->Output();
    }
    
    function addsave(){
        $tb_goodid=_P('goodid');
        $is_card=_P('is_card','int');
        $remark=_P('remark');
        $gettype=$_POST['gettype'];
        $tplid=_P('tplid','int');
        $is_state=_P('is_state','int');
    
        if(!$tb_goodid || !preg_match('/\d+/',$tb_goodid)){
    		$this->assign('msg','参数错误，请返回重试。');
    		$this->assign('url',_S('HTTP_REFERER'));
            $this->assign('img','error');
    		$this->getView('wy_messager.php')->outPut();exit;
        }
    
        if($goodinfo=$this->model('goods')->get_goods_by_goodid($tb_goodid)){
    		$this->assign('msg','商品已经存在，不能重复添加。');
    		$this->assign('url',_S('HTTP_REFERER'));
            $this->assign('img','error');
    		$this->getView('wy_messager.php')->outPut();exit;
        }

        $info=TB::API('taobao.item.get',array(
            'fields'=>'title,price,num,pic_url',
            'num_iid'=>$tb_goodid,
        ));
            
        $data=array(
            'userid'=>$_SESSION['login_userid'],
            'tb_goodid'=>$tb_goodid,
            'is_card'=>$is_card,
            'tb_title'=>$info['title'],
            'tb_price'=>$info['price'],
            'tb_num'=>$info['num'],
            'tb_img'=>$info['pic_url'],
            'is_state'=>$is_state,
            'remark'=>$remark,
            'gettype'=>implode(',',$gettype),
            'tplid'=>$tplid,
            'addtime'=>time(),
        );

        $this->model('goods')->insert('goods',$data);
        
    	$this->assign('msg','商品配置保存成功。');
    	$this->assign('url','/goods');
        $this->assign('img','success');
    	$this->getView('wy_messager.php')->outPut();
    }
    
    function edit(){

        $tb_goodid=isset($this->router[3]) && preg_match('/\d+/',$this->router['3']) ? $this->router[3] : '';
        if(!$tb_goodid){
    		$this->assign('msg','参数错误，请返回重试。');
    		$this->assign('url',_S('HTTP_REFERER'));
            $this->assign('img','error');
    		$this->getView('wy_messager.php')->outPut();exit;
        }
        
        $goodinfo=$this->model('goods')->get_goods_by_goodid($tb_goodid);
        
        $tplinfo=$this->model('users')->get_msgtpl(false,false,'is_state=0 and userid='.$_SESSION['login_userid']);

        $this->assign('title','商品配置');
        $this->assign('tb_goodid',$tb_goodid);
        $this->assign('goodinfo',$goodinfo);
        $this->assign('tplinfo',$tplinfo);
        $this->getView('goodsedit.php')->Output();
    }
    
    function editsave(){
        $tb_goodid=_P('goodid');
        $is_card=_P('is_card','int');
        $remark=_P('remark');
        $gettype=$_POST['gettype'];
        $tplid=_P('tplid','int');
        $is_state=_P('is_state','int');
    
        if(!$tb_goodid || !preg_match('/\d+/',$tb_goodid)){
    		$this->assign('msg','参数错误，请返回重试。');
    		$this->assign('url',_S('HTTP_REFERER'));
            $this->assign('img','error');
    		$this->getView('wy_messager.php')->outPut();exit;
        }

        $info=TB::API('taobao.item.get',array(
            'fields'=>'title,price,num,pic_url',
            'num_iid'=>$tb_goodid,
        ));
    
        $data=array(
            'userid'=>$_SESSION['login_userid'],
            'tb_goodid'=>$tb_goodid,
            'tb_title'=>$info['title'],
            'tb_price'=>$info['price'],
            'tb_num'=>$info['num'],
            'tb_img'=>$info['pic_url'],
            'is_card'=>$is_card,
            'remark'=>$remark,
            'is_state'=>$is_state,
            'gettype'=>implode(',',$gettype),
            'tplid'=>$tplid,
        );
    
        $this->model('goods')->update('goods',$data,"userid=".$_SESSION['login_userid']." and tb_goodid='".$tb_goodid."'");
    
    	$this->assign('msg','商品配置保存成功。');
    	$this->assign('url','/goods');
        $this->assign('img','success');
    	$this->getView('wy_messager.php')->outPut();
    }
    
    function del(){
        $tb_goodid=isset($this->router[3]) && preg_match('/\d+/',$this->router['3']) ? $this->router[3] : '';
        if(!$tb_goodid){
    		$this->assign('msg','参数错误，请返回重试。');
    		$this->assign('url',_S('HTTP_REFERER'));
            $this->assign('img','error');
    		$this->getView('wy_messager.php')->outPut();exit;
        }
        
        $this->model('goods')->delete('goods','userid='.$_SESSION['login_userid'].' and tb_goodid='.$tb_goodid);
    	$this->assign('msg','商品删除成功。');
    	$this->assign('url','/goods');
        $this->assign('img','success');
    	$this->getView('wy_messager.php')->outPut();
    }
    
    function delall(){
        $listid=isset($_POST['listid']) ? $_POST['listid'] : false;
        if(!$listid){
    		$this->assign('msg','请选择要删除的记录。');
    		$this->assign('url',_S('HTTP_REFERER'));
            $this->assign('img','error');
    		$this->getView('wy_messager.php')->outPut();exit;
        }
        
        $ids='';
        foreach($listid as $key=>$val){
            $ids.=$ids ? ',' : '';
            $ids.=intval($val);
        }
        
        $this->model('goods')->delete('goods','id in('.$ids.') and userid='.$_SESSION['login_userid']);
    	$this->assign('msg','商品删除成功。');
    	$this->assign('url','/goods');
        $this->assign('img','success');
    	$this->getView('wy_messager.php')->outPut();
    }
}
?>