<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if(!defined('WY_ROOT')) exit;
class TB extends Wy_Controller{
    
    static $apiUrl='http://gw.api.taobao.com/router/rest';
    static $app_key='23077119';
    static $app_secret='8220d20b620d05c4ba50beb128f2aff9';
    
	function __construct(){
		parent::__construct();
	}
    
    static function API($method,$data=array()){
        $params=array(
            'method'=>$method,
            'timestamp'=>date('Y-m-d H:i:s'),
            'format'=>'json',
            'app_key'=>self::$app_key,
            'v'=>'2.0',
            'sign_method'=>'md5',
            'session'=>$_SESSION['top_session'],
        );
        
        $params=array_merge($params,$data);

        $params['sign']=self::makeSign($params);

        $result=HttpClient::quickPost(self::$apiUrl,$params);
        $data=json_decode($result,true);

        if(isset($data['error_response'])){
            return false;
        }
        
        switch($method){
            case 'taobao.item.get':
            return $data['item_get_response']['item'];
            break;
            
            case 'taobao.items.onsale.get':
            return $data['items_onsale_get_response']['items']['item'];
            break;
                
            case 'taobao.user.seller.get':
            return $data['user_seller_get_response']['user'];
            break;
            
            case 'taobao.trades.sold.get':
            return $data['trades_sold_get_response']['total_results'] ? $data['trades_sold_get_response']['trades']['trade'] : array();
            break;
            
            case 'taobao.trade.fullinfo.get':
            return $data['trade_fullinfo_get_response']['trade'];
            break;
            
            case 'taobao.logistics.online.send':
            return $data['delivery_confirm_send_response']['shipping']['is_success'];
            break;
            
            case 'taobao.shop.get':
            return $data['shop_get_response']['shop'];
            break;
            
            case 'taobao.weike.subscinfo.get':
            return $data['weike_subscinfo_get_response']['result']['subsc_info_list']['subsc_info'];
            break;
            
            case 'taobao.vas.subscribe.get':
            return $data['vas_subscribe_get_response']['article_user_subscribes']['article_user_subscribe'];
            break;
        }
    }
    
    static function makeSign($params){
        $str='';
        ksort($params);
        foreach($params as $key=>$val){
            $str.=$key.$val;
        }
        $str=self::$app_secret.$str.self::$app_secret;
        return strtoupper(md5($str));
    }
    
    static function STATUS($status){
        $tb_status=self::GetStatus();
        
        if(in_array($status,$tb_status)){
            return $tb_status[$status];
        }
        
        return false;
    }
    
    static function GetStatus(){
        return array(
            'TRADE_NO_CREATE_PAY'=>'没有创建支付宝交易',
            'WAIT_BUYER_PAY'=>'等待买家付款',
            'WAIT_SELLER_SEND_GOODS'=>'等待卖家发货',
            'SELLER_CONSIGNED_PART'=>'卖家部分发货',
            'WAIT_BUYER_CONFIRM_GOODS'=>'等待买家确认收货',
            'TRADE_BUYER_SIGNED'=>'买家已签收',
            'TRADE_FINISHED'=>'交易成功',
            'TRADE_CLOSED'=>'交易关闭',
            'TRADE_CLOSED_BY_TAOBAO'=>'交易被淘宝关闭',
        );
    }
    
    public static function IM($num){
        return 'http://amos1.taobao.com/msg.ww?v=1&uid='.$num.'&s=1';
    }
    
    public static function IMG($num){
        return '<img border="0" src="http://amos1.taobao.com/online.ww?v=1&uid='.$num.'&s=2" align="absmiddle" alt="点击这里给我发消息" />&nbsp;';
    }
    
    public static function FW(){
        return 'http://fuwu.taobao.com/';
    }
}
?>