<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

class Options{
	public static function getAdmMainMenu(){
	     return array(
			 0=>'用户管理',
			 1=>'订单管理',
			 2=>'商品管理',
			 3=>'文章管理',
			 4=>'管理账户'
		 );
	}

	public static function getAdmSubMenu(){
	    return array(
		    array('0','users','用户信息'),
			array('0','userlogs','登录日志'),
            array('0','msgtpl','发信模板'),
			array('1','orders','订单管理'),
			array('2','goods','商品管理'),
            array('2','cards','卡密信息'),
			array('3','newsclass','文章分类'),
			array('3','news','文章列表'),
			array('4','adminpwd','修改密码'),
			array('4','adminlist','管理员列表'),
			array('4','adminlogs','登录日志'),
			array('6','set','系统设置'),
			array('6','index','系统首页'),
		);
	}
    
    public static function getUserStatus(){
        return array(
            0=>'正常',
            1=>'试用',
            2=>'过期',
            3=>'终止',
        );
    }

	public static function getTitleColor(){
	    return array('000000','009f0b','ff0000','d3009f','5d0046','0020aa','990000','666600','ff6600','5c6166','6ecff5','d95c5c','a1cf64','564f8a','00b5ad','66cccc');
	}

	public static function getCurrentWeek(){
		$weekArray=array('日','一','二','三','四','五','六');
	    return date('Y').'年'.date('m').'月'.date('d').'日 星期'.$weekArray[date('w')];
	}

	public static function getPageInfo(){
		return array(
			'paytype'=>'付款方式',
			'tariff'=>'资费标准',
			'settlement'=>'结算模式',
			'useful'=>'使用流程',
			'faq'=>'常见问题',
			'contact'=>'联系我们',
			'statement'=>'免责声明',
			'about'=>'关于我们',
			'partners'=>'合作伙伴',
			'qualification'=>'公司资质'
		);
	}

	public static function getStaticPage(){
	    return array('qualification','paytype','tariff','settlement','useful','faq','contact','about','statement','partners');
	}

	public static function get_dwzs(){
	    return array('weibo'=>'微博短网址','baidu'=>'百度短网址','qq'=>'腾讯短网址');
	}

	public static function dwz($url){
		$config=WoodyApp::model('config')->get_config();
		$t=$config['dwz'];

		if($t=='weibo'){
			$res=HttpClient::quickPost('https://api.weibo.com/2/short_url/shorten.json',array('source'=>'2474783709','url_long'=>$url));
			$r=json_decode($res,true);
			if(!isset($r['error_code'])){
				return $r['urls'][0]['url_short'];
			}
		} 
		
		if($t=='qq'){
			/*$res=HttpClient::quickPost('http://open.t.qq.com/api/short_url/shorten',array('format'=>'json','long_url'=>$url,'appid'=>'801058005','openid'=>'C77F7ECA221A2FB09E3B9DFC3718C16E','openkey'=>'D71C4445DA7B99C1851FDD6C06E303C6','clientip'=>_S('REMOTE_ADDR'),'reqtime'=>time(),'pf'=>'php-sdk2.0beta','wbversion'=>1));
            $r=json_decode($res,true);
			if($r['errcode']==0){
			    return 'http://url.cn/'.$r['data']['short_url'];
            }*/
                
                $url='http://share.v.t.qq.com/index.php?c=share&a=index&title='.time().'&url='.$url;
                $content=file_get_contents($url);
                preg_match('/http:\/\/url.cn\/[a-zA-Z0-9]+/',$content,$match);
                if(isset($match[0])){
                    return $match[0];
                }
		} 
		
		if($t=='baidu'){
			$res=HttpClient::quickPost('http://dwz.cn/create.php',array('url'=>$url));
			$r=json_decode($res,true);
			if($r['status']==0){
				return $r['tinyurl'];
			}
		}

		return $url;
	}

	static function cipher($t){
        if(function_exists('mcrypt_module_open')){
    		switch($t){
    		    case 1: $t=MCRYPT_DES;break;
    			//case 2: $t=MCRYPT_3DES;break;
    			case 3: $t=MCRYPT_RIJNDAEL_128;break;
    			case 4: $t=MCRYPT_GOST;break;
    		}
        }
	    return function_exists('mcrypt_module_open') ? mcrypt_module_open($t,'','ecb','') : false;
	}

	static function encrypt($text,$t=3){
		if(!$cipher=self::cipher($t)){
		    return $text;
		}
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($cipher), MCRYPT_DEV_URANDOM);
        mcrypt_generic_init($cipher, WY_CACHE_TOKEN, $iv);
        $encrypted_text = mcrypt_generic($cipher, $text);
		mcrypt_generic_deinit($cipher);
        mcrypt_module_close($cipher);
		return base64_encode($encrypted_text);
	}

	static function decrypt($encrypted_text,$t=3){
		if(!$cipher=self::cipher($t)){
		    return $encrypted_text;
		}
		$encrypted_text=base64_decode($encrypted_text);
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($cipher), MCRYPT_DEV_URANDOM);
        mcrypt_generic_init($cipher, WY_CACHE_TOKEN, $iv);
        $text = mdecrypt_generic($cipher, $encrypted_text);
		mcrypt_generic_deinit($cipher);
        mcrypt_module_close($cipher);
		return $text;
	}
}
?>