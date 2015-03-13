<?php
/*
*****************************************************************************
# WYTG Copyright(C)2014 WoodyApp
# WYTG is licensed under the GPL license. http://opensource.org/licenses/gpl-2.0.php
# Email:yang0@outlook.com QQ:859926053
*****************************************************************************
*/

class Upload{
    private $fileinfo;
	private $filesize;
	private $filetype;
	private $savepath;

	function __construct($fileinfo){
	    $this->fileinfo=$fileinfo;
		$uploadSet=Options::getUploadSet();
		$this->filesize=$uploadSet['allowSize'];
		$this->filetype=$uploadSet['allowType'];
		$this->savepath=WY_ROOT.$uploadSet['uploadPath'];
	}

	function saveFile(){
	    if(!$this->getFileType()){
		    return array('err','图片文件格式错误！');
		}

		if(!$this->getFileSize()){
		    return array('err','图片文件太大了！');
		}

		$this->getSavePath();

		if(!$filename=$this->getFileName()){
		    return array('err','图片文件上传失败！');
		}

		return array('ok',$filename);
	}

	function getFileType(){
		return in_array($this->fileinfo['type'],$this->filetype) ? true : false;
	}

	function getFileSize(){
		return $this->fileinfo['size']<=$this->filesize ? true : false;
	}

	function getSavePath(){
	    if(!file_exists($this->savepath)){
		    mkdir($this->savepath);
		}
	}

	function getFileName(){
		$upname=explode('.',$this->fileinfo['name']);
		$newname=md5(getRandomString(32)).'.'.$upname[1];
		$newpath=$this->savepath.$newname;
	    if(!move_uploaded_file($this->fileinfo['tmp_name'],$newpath)){
		    return false;
		} else {
			//生成缩略图
			$thumb=new Thumb($newpath);
			$thumb->createThumb();
		    return $newname;
		}
	}
}
?>