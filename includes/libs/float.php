<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

if($t==1):
?>
document.write('<div id="imgshow" style="position:absolute">')
document.write('<a href="<?php echo $url ?>" target="_blank"><img src="<?php echo $imgurl ?>a001.gif" border="0"></a>')
document.write('</div>')
 
var x = 50,y = 60 
var xin = true, yin = true 
var step = 0.5 
var delay = 10 
var obj=document.getElementById("imgshow") 
function imgshow() { 
var L=T=0
var R= document.body.clientWidth-obj.offsetWidth 
var B = document.body.clientHeight-obj.offsetHeight 
obj.style.left = x + document.body.scrollLeft 
obj.style.top = y + document.body.scrollTop 
x = x + step*(xin?1:-1) 
if (x < L) { xin = true; x = L} 
if (x > R){ xin = false; x = R} 
y = y + step*(yin?1:-1) 
if (y < T) { yin = true; y = T } 
if (y > B) { yin = false; y = B } 
} 
var itl= setInterval("imgshow()", delay) 
obj.onmouseover=function(){clearInterval(itl)} 
obj.onmouseout=function(){itl=setInterval("imgshow()", delay)}

<?php elseif($t==2): ?>

var showad = true;
var Toppx = 60;
var AdDivW = 221;
var AdDivH = 269;
var PageWidth = 800;
var MinScreenW = 1024;
var ClosebuttonHtml = '<div align="right" style="position: absolute;top:0px;right:0px;margin:2px;padding:2px;z-index:2000;"><a href="JavaScript:;" onclick="hidead()" style="color:red;text-decoration:none;font-size:12px;">关闭</a></div>'

var AdContentHtml = '<div align="center"><a target=_blank href=<?php echo $url ?>><img src="<?php echo $imgurl ?>a002.gif"></a></div>';

document.write ('<div id="LeftDiv" style="position: absolute;z-index:1000;width:'+AdDivW+'px;height:'+AdDivH+'px;top:-1000px;word-break:break-all;display:none;">'+ClosebuttonHtml+'<div>'+AdContentHtml+'</div></div>');

document.write ('<div id="RightDiv" style="position: absolute;z-index:1000;width:'+AdDivW+'px;height:'+AdDivH+'px;top:-1000px;word-break:break-all;display:none;">'+ClosebuttonHtml+'<div>'+AdContentHtml+'</div></div>');

function scall(){
 if(!showad){return;}
 if (window.screen.width<MinScreenW){
	  showad = false;
	  document.getElementById("LeftDiv").style.display="none";
	  document.getElementById("RightDiv").style.display="none";
	  return;
 }
 
 var Borderpx = ((window.screen.width-PageWidth)/2-AdDivW)/2;
 document.getElementById("LeftDiv").style.display="block";
 document.getElementById("LeftDiv").style.top=document.body.scrollTop+Toppx;
 document.getElementById("LeftDiv").style.left=document.body.scrollLeft+Borderpx;
 document.getElementById("RightDiv").style.display="block";
 document.getElementById("RightDiv").style.top=document.body.scrollTop+Toppx;
 document.getElementById("RightDiv").style.left=document.body.scrollLeft+document.body.clientWidth-document.getElementById("RightDiv").offsetWidth-Borderpx;
}

function hidead(){
	showad = false;
	document.getElementById("LeftDiv").style.display="none";
	document.getElementById("RightDiv").style.display="none";
}
window.onscroll=scall;
window.onresize=scall;
window.onload=scall;
<?php endif; ?>