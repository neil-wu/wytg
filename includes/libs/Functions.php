<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

function __autoload($class){
	$classDir=array('libs','model','controller');
	foreach($classDir as $dir){
		$is_class=false;
		$class=strpos($class,'_class') ? str_replace('_class','',$class) : $class;
	    if(file_exists(WY_ROOT.'/includes/'.$dir.'/'.$class.'.php')){
		    require_once WY_ROOT.'/includes/'.$dir.'/'.$class.'.php';
			$is_class=true;
			break;
		}
	}

    if($is_class==false){
	    echo $class.' load fail';
		exit;
	}
}

function _P($param,$t='string'){
    $value=isset($_POST[$param]) ? $_POST[$param] : false;
	return makeSafe($value,$t);
}

function _G($param,$t='string'){
    $value=isset($_GET[$param]) ? $_GET[$param] : false;
	return makeSafe($value,$t);
}

function _C($param,$t='string'){
    $value=isset($_COOKIE[$param]) ? $_COOKIE[$param] : false;
	return makeSafe($value,$t);
}

function _S($param,$t='string'){
    $value=isset($_SERVER[$param]) ? $_SERVER[$param] : false;
	return makeSafe($value,$t);
}

function _R($param,$t='string'){
    $value=isset($_REQUEST[$param]) ? $_REQUEST[$param] : false;
	return makeSafe($value,$t);
}

function makeSafe($value,$t='string'){
	$value=trim($value);    
    if($t=='int'){
	    return intval($value);
	} elseif($t=='float'){
	    return is_numeric($value) ? $value : 0;
	} else {
		$value=strip_tags($value);
	    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()){
		   return $value;
		} else {
		    if(function_exists('addslashes')){
			    return addslashes($value);
			} else {
			    return mysql_real_escape_string($value);
			}
		}
	}
}

function subString($strings,$start,$length){
	if (function_exists('mb_substr')) {
		return mb_substr($strings, $start, $length, 'utf8');
	}
	$str = substr($strings, $start, $length);
	$char = 0;
	for ($i = 0; $i < strlen($str); $i++){
		if (ord($str[$i]) >= 128)
		$char++;
	}
	$str2 = substr($strings, $start, $length+1);
	$str3 = substr($strings, $start, $length+2);
	if ($char % 3 == 1){
		if ($length <= strlen($strings)){
			$str3 = $str3 .= '...';
		}
		return $str3;
	}
	if ($char%3 == 2){
		if ($length <= strlen($strings)){
			$str2 = $str2 .= '...';
		}
		return $str2;
	}
	if ($char%3 == 0){
		if ($length <= strlen($strings)){
			$str = $str .= '...';
		}
		return $str;
	}
}

function getRandomString($len){
    $chars = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',"A", "B", "C", "D", "E", "F", "G","H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R","S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2","3", "4", "5", "6", "7", "8", "9");
    $charsLen = count($chars) - 1;
    shuffle($chars);
    $output = "";
    for ($i=0; $i<$len; $i++){
        $output .= $chars[mt_rand(0, $charsLen)];
    }
	//$output=substr(md5(md5(uniqid()).md5(microtime()).md5($output)),0,$len);
    $output=substr($output,0,$len);
    return $output;
}

function isMail($email){
    return preg_match('/^([0-9a-zA-Z_-])+@([0-9a-zA-Z_-])+((\.[0-9a-zA-Z_-]{2,3}){1,2})$/',$email);
}

function isDate($date,$format='Y-m-d'){
	$unixtime=strtotime($date);
	if(!is_numeric($unixtime)) return false;
	$checkdate=date($format , $unixtime);
	if($checkdate !=$date) return false;
	return true;
}

function sendMail($to,$title,$message,$from=''){
	$config=WoodyApp::model('config')->get_config();
    if(!$config) return false;
	$config_email=$from=='' ? $config['email'] : $from;
	$config_authkey=$config['authkey'];
	$config_smtp=$config['smtp'];
	$config_sitename=$config['sitename'];

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465; 
    $mail->CharSet = "UTF-8";
    $mail->Username = $config_email; 
    $mail->Password = $config_authkey; 
    $mail->Host = $config_smtp; 
    $mail->IsHTML(true); 
    $mail->From = $config_email;
    $mail->FromName = $config_sitename; 
    $mail->Subject = $title; 
    $mail->Body =$message;
    $mail->AddAddress($to, $to); 
    $mail->Send();
}

function GetHttpStatusCode($url){ 
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_HEADER,1);
    curl_setopt($curl,CURLOPT_NOBODY,1);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl,CURLOPT_TIMEOUT,5);
    curl_exec($curl);
    $rtn= curl_getinfo($curl,CURLINFO_HTTP_CODE);
    curl_close($curl);
    return  $rtn;
}

function msgBox($msg){
    echo "<script>alert('".$msg."');window.history.back(-1)</script>";
	exit;
}

function Redirect($url,$msg=''){
    if($msg) echo "<script>alert('".$msg."');</script>";
	echo "<script>window.location.href='".$url."'</script>";
	exit;
}

function getpagelist($url,$currentpage,$totalpage,$totalsize,$pagesize='',$buchang=4,$mpage=10){
	$p='';
	$totalpage=$totalpage ? $totalpage : 1;
	//如果$mpage >= $totalpage
	if($mpage>=$totalpage){
		for($i=1;$i<=$totalpage;$i++){
			if($currentpage==$i){
				$p.='<li class="current">'.$i.'</li> ';
			} else {
				$p.='<li><a href="'.$url.$i.'">'.$i.'</a></li> ';
			}
		}
	} else {
				
				if($currentpage>=$buchang+2){
					$p.='<li><a href='.$url.'1>1</a></li><li>...</li>';
					if($currentpage+$buchang<$totalpage){
						//左边页码显示
						for($li=$currentpage-$buchang;$li<$currentpage;$li++){
							$p.='<li><a href='.$url.$li.'>'.$li.'</a></li> ';
							}
						//右边页码显示
						for($ri=$currentpage;$ri<=$currentpage+$buchang && $ri<=$totalpage;$ri++){
							if($currentpage==$ri){
								$p.='<li class="current">'.$ri.'</li> ';
							} else {
								$p.='<li><a href='.$url.$ri.'>'.$ri.'</a></li> ';
							}
							}
						} else {
							for($i2=$totalpage-$buchang*2;$i2<=$totalpage;$i2++){
								if($currentpage==$i2){
									$p.='<li class="current">'.$i2.'</li> ';
								} else {
									$p.='<li><a href='.$url.$i2.'>'.$i2.'</a></li> ';
								}
								}
							}
					} else {
						for($i=1;$i<=$mpage;$i++){
							if($currentpage==$i){
								$p.='<li class="current">'.$i.'</li> ';
							} else {
								$p.='<li><a href='.$url.$i.'>'.$i.'</a></li> ';
							}
						}
					}

				//如果$mpage<$totalpage，显示出$mpage的页码，后面出现省略号
				if($currentpage+$buchang<$totalpage){
					$p.='<li>...</li><li><a href='.$url.$totalpage.'>'.$totalpage.'</a></li>';
				}
		}
	if($currentpage>1){
	    $f='<li><a href="'.$url.($currentpage-1).'">&laquo;</a></li>';
	} else {
	    $f='<li class="current">&laquo;</li>';
	}

	if($currentpage<$totalpage){
	    $e='<li><a href="'.$url.($currentpage+1).'">&raquo;</a></li>';
	} else {
	    $e='<li class="current">&raquo;</li>';
	}

	$pagesize=$pagesize!='' ? '，'.$pagesize.'条/页' : '';
	$page_options='';
	for($i=1;$i<=$totalpage;$i++){
		$selected=$i==$currentpage ? 'selected' : '';
	    $page_options.='<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
	}

	$pagelist=$totalpage>1 ? $f.$p.$e : '';

	$pagelist.=$pagesize && $totalpage>1 ? '<li>转到第<select style="vertical-align:middle" data-role="none" name="page_options" onchange="page_jump(\''.$url.'\')">'.$page_options.'</select> 页</li>' : '';

	return '<div class="page"><ul class="pagelist"><li style="font-size:12px">'.$totalsize.'条记录'.$pagesize.'，'.$currentpage.'/'.$totalpage.'页</li>'.$pagelist.'</ul></div><div></div>';
}

function exportFile($filename,$content){
	$ua=_S('HTTP_USER_AGENT');
	$ext=substr($filename,-4);
	$encoded_filename=urlencode($filename);
	$encoded_filename=str_replace("+", "%20", $encoded_filename);

	header('Pragam:no-cache');
	header('Expires:0');
	header('Content-Type: application/octet-stream');
    //header('Content-Type:application/force-download');
	if($ext=='.xls'){
		header("Content-type:application/vnd.ms-excel;charset=UTF-8");
	}

	if (preg_match("/MSIE/", $ua)) {
		header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');

	} else {
		header('Content-Disposition: attachment; filename="' . $filename . '"');
	}
	echo mb_convert_encoding($content,'gbk','utf-8');exit;
}

function isMobile(){
     // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
	//如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
	if (isset ($_SERVER['HTTP_VIA'])) {
	    //找不到为flase,否则为true
	    return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
	}
     //判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array (
		   'nokia',
		   'sony',
		   'ericsson',
		   'mot',
		   'samsung',
		   'htc',
		   'sgh',
		   'lg',
		   'sharp',
		   'sie-',
		   'philips',
		   'panasonic',
		   'alcatel',
		   'lenovo',
		   'iphone',
		   'ipod',
		   'blackberry',
		   'meizu',
		   'android',
		   'netfront',
		   'symbian',
		   'ucweb',
		   'windowsce',
		   'palm',
		   'operamini',
		   'operamobi',
		   'openwave',
		   'nexusone',
		   'cldc',
		   'midp',
		   'wap',
		   'mobile',
			'ios'
        );
		// 从HTTP_USER_AGENT中查找手机浏览器的关键字
		if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
			return true;
		}
    }
	//协议法，因为有可能不准确，放到最后判断
	if (isset ($_SERVER['HTTP_ACCEPT'])) {
		// 如果只支持wml并且不支持html那一定是移动设备
		// 如果支持wml和html但是wml在html之前则是移动设备
		if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
			return true;
		}
	}
    return false;
}

function loadFile($file,$align='',$alt='',$title=''){
	$config=WoodyApp::model('config')->get_config();
	$path='/static/'.$file;
	$fileArr=pathinfo($path);
	$extName='';
	if(array_key_exists('extension',$fileArr)){
		$extName=$fileArr['extension'];
	}

	if(file_exists(WY_ROOT.$path)){
		$path=$config && $config['staticurl'] ? 'http://'.$config['staticurl'].$path : $path;
		switch($extName){
		    case 'js':
				echo '<script src="'.$path.'" type="text/javascript"></script>';
			    break;
			case 'css':
				echo '<link href="'.$path.'" rel="stylesheet" type="text/css">';
			    break;
			case 'gif':
			case 'jpg':
			case 'png':
			case 'bmp':
			case 'jpeg':
				echo '<img src="'.$path.'" align="'.$align.'" alt="'.$alt.'" title="'.$title.'">';
			    break;
			default:
				echo '<!-- '.$file.' 加载失败！-->';
		}		
	}
}
?>