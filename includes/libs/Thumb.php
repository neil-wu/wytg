<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

class Thumb{
	//源文件
    private $srcImage;
	//缩略图宽度
	private $thuWidth;
	//缩略图高度
	private $thuHeight;
	//缩略图保存路径
	private $thuPath;
	//源图像宽度
	private $srcWidth;
	//源图片高度
	private $srcHeight;
	//图像文件名称
	private $fileName;

	function __construct($srcImage){
		$uploadSet=Options::getUploadSet();
	    $this->srcImage=$srcImage;
		$this->thuWidth=$uploadSet['thumbWidth'];
		$this->thuHeight=$uploadSet['thumbHeight'];
		$this->thuPath=WY_ROOT.$uploadSet['thuPath'];
		$this->srcWdith=0;
		$this->srcHeight=0;
		$this->fileName='';
	}

	function getImageSize(){
	    $img=getimagesize($this->srcImage);
		if($img){
			$this->srcWidth=$img[0];
			$this->srcHeight=$img[1];
		}
	}

	function setThumbSize(){
	    if($this->srcWidth <= $this->thuWidth && $this->srcHeight <= $this->thuHeight){
		    $this->thuWidth=$this->srcWidth;
			$this->thuHeight=$this->srcHeight;
		} else if($this->srcWidth > $this->thuWidth && $this->srcHeight <= $this->thuHeight) {
			$this->thuHeight=$this->srcHeight;
		    $prop=$this->thuWidth / $this->thuHeight;
			$this->thuWidth=ceil($this->thuHeight * $prop);
		} else if($this->srcWidth <= $this->thuWidth && $this->srcHeight > $this->thuHeight) {
			$this->thuWidth=$this->srcWidth;
			$this->thuHeight=$this->srcHeight;
		} else {
		    $prop=$this->srcWidth / $this->thuWidth;
			$this->thuHeight=ceil($this->srcHeight / $prop);
		}
	}

	function getFileName(){
		if(file_exists($this->srcImage)){
	        $this->fileName=basename($this->srcImage);
		}
	}

	function getExtName(){
		if($this->fileName){
			$ext=explode('.',$this->fileName);
			$this->ext=$ext[1]=='jpg' ? 'jpeg' : $ext[1]; 
		}
	}

	function createSource(){
		if($this->fileName){
			$fn='imagecreatefrom'.$this->ext;
			return $fn($this->srcImage);
		} else {
		    return false;
		}
	}

	function createThumb(){		
		$this->getImageSize();		
		$this->setThumbSize();
		$this->getFileName();
		$this->getExtName();
	    $im=$this->createSource();
		if($im){			
		    $newimg=imagecreatetruecolor($this->thuWidth,$this->thuHeight);
			imagecopyresampled($newimg,$im,0,0,0,0,$this->thuWidth,$this->thuHeight,$this->srcWidth,$this->srcHeight);
			$fn='image'.$this->ext;
			$fn($newimg,$this->thuPath.$this->fileName);
		}
	}
}
?>