<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/
if(!defined('WY_ROOT')) exit; ?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>系统管理中心</title>
<?php
loadFile('adm/css/style.css');
loadFile('common/boxy.css');
loadFile('common/jquery.min.js');
loadFile('common/jquery.boxy.js');
loadFile('common/calendar.js');
loadFile('common/plugin-cookie.js');
loadFile('adm/js/common.js');
?>
<!--[if IE]>
<style>
.btn1, .btn2, .btn3, .btn4{padding:0}
.user_status{width:80px;margin-left:-60px;margin-top:25px}
</style>
<![endif]-->

<script>
$(function(){
    $('#showAdminInfo').click(function(){
	    $('#adminfo').show();
		$('.h01').addClass('current');
	});
	
	$('#adminfo').mouseleave(function(){
	    $('#adminfo').show();
		$('.h01').addClass('current');  
	});

	$(document).mouseup(function(){
	    $('#adminfo').hide();
		$('.h01').removeClass('current');
	});

	$('#sh').click(function(){
	    if($(this).hasClass('h')){
		    $('#container > .wy_left').show();
			$(this).removeClass('h');
			$(this).addClass('s');
			$('#container > .wy_right').css({'padding-left':'180px'});
			$.cookie('nav_status','0');
		} else {
		    $('#container > .wy_left').hide();
			$(this).removeClass('s');
			$(this).addClass('h');
			$('#container > .wy_right').css({'padding-left':'0'});
			$.cookie('nav_status','1');
		}
	});

	if($.cookie('nav_status')=='1'){
		$('#container > .wy_left').hide();
		$('#sh').removeClass('s');
		$('#sh').addClass('h');
		$('#container > .wy_right').css({'padding-left':'0'});
	} else {
		$('#container > .wy_left').show();
		$('#sh').removeClass('h');
		$('#sh').addClass('s');
		$('#container > .wy_right').css({'padding-left':'180px'});
	};

	$('#nav ul span').each(function(){
		$(this).click(function(){
			var index=$('#nav ul span').index(this);
			if($(this).hasClass('checked')){
				$(this).siblings().show();
				$(this).removeClass('checked');
				$.cookie('mainMenu'+index,'0');
			} else {
				$(this).siblings().hide();
				$(this).addClass('checked');
				$.cookie('mainMenu'+index,'1');
			}
		});
	});

	$('#nav ul span').each(function(){
	    if($.cookie('mainMenu'+$('#nav ul span').index(this))=='1'){
		    $(this).siblings().hide();
			$(this).addClass('checked');
		} else {
		    $(this).siblings().show();
			$(this).removeClass('checked');
		}
	});
});
</script>
</head>

<body>
<div id="retMsg" class="actived"></div>
<div id="wrapper">
	<div id="header">
		<div class="wy_left"><a href="./" title="控制面板首页"></a></div>
		<div class="wy_right">
			<ul>
				<li><a class="h07" href="/" title="返回主站" target="_blank"></a></li>
				<li><a class="h01" href="javascript:;" id="showAdminInfo"></a>
				    <div id="adminfo">
					    <p>欢迎 <strong><?php echo $_SESSION['login_adminname'] ?></strong></p>
						<p>上次登录时间：<?php echo $_SESSION['login_adminlogtime'] ?></p>
						<p>上次登录IP：<?php echo $_SESSION['login_adminlogip'] ?></p>
						<p><input type="button" class="btn1" value="修改密码" onclick="window.location.href='adminPwd.php'"> <input type="button" class="btn2" value="登录日志" onclick="window.location.href='adminLogs.php?username=<?php echo $_SESSION['login_adminname'] ?>'"></p>
					</div></li>
				<li><a class="h02" href="set.php" title="系统设置"></a></li>
				<li><a class="h06" href="login.php?action=logout"></a></li>
			</ul>
		</div>
	</div>

	<div id="container">
		<div class="wy_left">
			<div id="current_date"><?php echo Options::getCurrentWeek(); ?></div>
			<div id="nav">
			<?php $admMainMenu=Options::getAdmMainMenu(); foreach($admMainMenu as $mainKey=>$mainMenu): ?>
			<ul><span>&rsaquo; <?php echo $mainMenu ?></span>
			<?php $admSubMenu=Options::getAdmSubMenu(); foreach($admSubMenu as $subKey=>$subMenu): ?>
			<?php if($subMenu[0]==$mainKey): ?>
			<li<?php echo $basename==$subMenu[1].'.php' ? ' class="current"' : '' ?>><a href="<?php echo $subMenu[1] ?>.php"><?php echo $subMenu[2] ?></a></li>
			<?php endif; ?>
			<?php endforeach; ?>
			</ul>
			<?php endforeach; ?>
			</div>
		</div>
		<div class="wy_right">
			<div id="main">
				<div id="main_title">
				    <div class="wy_left font14">&rsaquo; 
                        <?php					    
					    foreach($admSubMenu as $subKey=>$subMenu){
						    if($basename==$subMenu[1].'.php'){
							    echo $subMenu[2];break;
							}
						}
					?></div>
					<div class="wy_right"><a href="javascript:;" class="s" id="sh"></a></div>
				</div>
