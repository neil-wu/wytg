<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT')) exit;
class cards extends checkUser{

	function __construct(){
		parent::__construct();
	}
    function display(){
        $data=array();
        $goodid=_G('goodid');
        $status=_G('status');
        $state=isset($_GET['state']) ? _G('state','int') : -1;
        $fdate=_G('fdate');
        $tdate=_G('tdate');
        $kwd=_G('kwd');
        
        $page=_G('p','int');
        $page=$page ? $page : 1;
        $pagesize=20;
        $offset=($page-1)*$pagesize;
        
        $cons='userid='.$_SESSION['login_userid'];
        
        if($goodid && preg_match('/\d+/',$goodid)){
            $cons.=$cons ? ' and ' : '';
            $cons.="tb_goodid='".$goodid."'";
        }
        
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
            $cons="tb_orderid like '%".$kwd."%' or buyer_nick like '%".$kwd."%'";
        }
        
        $search=array(
            'goodid'=>$goodid,
            'state'=>$state,
            'fdate'=>$fdate,
            'tdate'=>$tdate,
            'kwd'=>$kwd,
        );
        
        if($totalsize=$this->model('cards')->count('cards',$cons)){
            $data=$this->model('cards')->get_cards($pagesize,$offset,$cons);
        }

        $totalpage=ceil($totalsize / $pagesize);
        $s_params='';
        foreach($search as $key=>$val){
            $s_params.=$s_params ? '&' : '';
            $s_params.=$key.'='.$val;
        }
        $pagelist=getpagelist('/cards?'.$s_params.'&p=',$page,$totalpage,$totalsize,$pagesize);
        
        $goods=$this->model('goods')->get_goods(false,false,'userid='.$_SESSION['login_userid']);
        
        $this->assign('title','卡密列表');
        $this->assign('data',$data);
        $this->assign('goods',$goods);
        $this->assign('search',$search);
        $this->assign('pagelist',$pagelist);
        $this->getView('cards.php')->Output();
    }
    
    function add(){
        $tb_goodid=isset($this->router[3]) && preg_match('/\d+/',$this->router['3']) ? $this->router[3] : '';
        $cons='userid='.$_SESSION['login_userid'];
        $goodList=$this->model('goods')->get_goods(false,false,$cons);
        $this->assign('title','上传卡密');
        $this->assign('goodList',$goodList);
        $this->assign('goodid',$tb_goodid);
        $this->getView('cardsadd.php')->Output();
    }
    
    function addsave(){
		$tb_goodid=_P('goodid','int');
		$msg='';
		$importfrom=_P('importfrom','int');
		$is_check_repeat=_P('is_check_repeat','int');
		$goods=array();
		if($importfrom==1){
			$file=$_FILES['f'];
			$file_type=$file['type'];
			if($file_type<>'text/plain'){
				$msg='仅支持TXT格式的文件上传';
			}
			
			$file_size=$file['size'];
			if($file_size<=0 || $file_size>100000){
				$msg='上传的文件最大支持100KB';
			}
			
			$file_error=$file['error'];
			$file_tmp=$file['tmp_name'];
			if($file_error<>0){
				$msg='上传出现意外错误，请稍候重试...';
			}
			
			$goods=file($file_tmp);
			if(count($goods)==0 || count($goods)>500){
				$msg='文本导入卡密最多500张(500行)';
			}

		} else if($importfrom=2){
			$content=_P('content');
			$goods=$content ? explode("\r\n",$content) : array();
			if(count($goods)==0 || count($goods)>500){
				$msg='输入框添加卡密最多500张(500行)';
			}
		}

		if($msg){
			$this->assign('url','/cards?goodid='.$tb_goodid);
			$this->assign('msg',$msg);
            $this->assign('img','error');
			$this->getView('wy_messager.php')->outPut();exit;
		}

		$allowQuantity=1000;
		$goodsInvent=$this->model('cards')->count('cards',"tb_goodid=$tb_goodid AND is_state=0");	
		$importQuantity=count($goods);
		$totalQuantity=$goodsInvent+$importQuantity;
		$lastQuantity=$allowQuantity-$goodsInvent;
		$lastQuantity=$lastQuantity<0 ? 0 : $lastQuantity;

		if($totalQuantity>$allowQuantity){
			if($lastQuantity>0){
				$msg='<span class="red">系统允许单个商品库存量('.$allowQuantity.')张,此商品还可以添加('.$lastQuantity.')张,请重新调整添加!</span>';
			} else {
				$msg='<span class="red">当前商品库存量已超过系统允许库存量('.$allowQuantity.')张,无法继续添加!</span>';			
			}

			$this->assign('url','/cards?goodid='.$tb_goodid);
			$this->assign('msg',$msg);
            $this->assign('img','error');
			$this->getView('wy_messager.php')->outPut();exit;
		}

		$quantity=0;
		foreach($goods as $val){
			$trimval=trim($val);
			$nbsp='';

			if(substr_count($trimval," ")>1){
				for($i=1;$i<=substr_count($trimval," ");$i++){
					$nbsp .=" ";
				}
				$trimval=str_replace($nbsp, ' ' , $trimval);
				$nbsp='';
			}
			if(strpos($trimval," ")){
				$arr_cards=explode(' ',$trimval);
				$cardnum=$arr_cards[0];
				$cardpwd=$arr_cards[1];
			} else {
				$cardnum=$trimval;
				$cardpwd='';
			}

			if($cardnum!=''){
				$cardnum=Options::encrypt($cardnum);
				if($cardpwd!=''){
				    $cardpwd=Options::encrypt($cardpwd);
				}
				$flag=false;
				if($is_check_repeat){
					$cons="userid=".$_SESSION['login_userid']." AND tb_goodid=".$tb_goodid." AND cardnum='".$cardnum."'";
					$cons=$cardpwd!='' ? $cons." AND cardpwd='".$cardpwd."'" : $cons;
					$flag=$this->model('cards')->count('cards',$cons);
				}

				if(!$flag){
                    $data=array(
                        'userid'=>$_SESSION['login_userid'],
                        'tb_goodid'=>$tb_goodid,
                        'cardnum'=>$cardnum,
                        'cardpwd'=>$cardpwd,
                        'addtime'=>time(),
                        'selltime'=>time(),
                    );
					$this->model('cards')->insert('cards',$data);
					$quantity+=1;
				}
			}
		}
		
		if($importfrom==1){
			$msg='<span class="green">您的卡密导入任务已提交，您可以离开本页面，完成后见系统消息。</span>';
		} else {
			$msg='<span class="green">共'.count($goods).'张卡密，成功添加'.$quantity.'张卡密！</span>';
		}

		$this->assign('url','/cards?goodid='.$tb_goodid);
		$this->assign('msg',$msg);
		$this->getView('wy_messager.php')->outPut();
    }
}
?>