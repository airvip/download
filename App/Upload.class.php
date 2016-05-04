<?php

/**
 * Created by PhpStorm.
 * User: wzb
 * Date: 2016/5/4
 * Time: 13:54
 */
//namespace App;
class Upload
{
    protected $maxSize;
    protected $allowMime;
    protected $allowExt;
    protected $uploadPath;
    protected $imgFlag;
    protected $fileInfo;
    protected $error;
    protected $ext;
    static private $_rootPath;
    public function __construct($fileInfo = '' ,$uploadPath = 'Uploads',$imgFlag=false,$maxSize=3145728,$allowExt=array('jpeg','jpg','gif','png','gzip','zip'),$allowMime=array('image/jpeg','image/png','image/gif','application/octet-stream','application/x-zip-compressed','application/gzip')){
        self::$_rootPath  = substr(str_replace('\\','/',__DIR__),0,-3);
        $this->maxSize   = $maxSize;
        $this->allowMime = $allowMime;
        $this->allowExt  = $allowExt;
        $this->uploadPath= self::$_rootPath.$uploadPath.'/';
        $this->imgFlag  = $imgFlag;
        $this->fileInfo = $fileInfo;
    }

    /**
     * 调用上传方法
     * @return string
     */
    public function uploadFile(){
        if($this->checkError()&$this->checkSize()&&$this->checkExt()&&$this->checkMime()&&$this->checkTrueImg()&&$this->checkHttpPost()){
            $this->checkUploadPath();
            $this->uniName = $this->getUniName();
            $this->destination = $this->uploadPath.$this->uniName.'.'.$this->ext;
            if(move_uploaded_file($this->fileInfo['tmp_name'],$this->destination)){
                return $this->destination;
            }else{
                $this->error = '文件移动失败';
                $this->showError();
            }
        }else{
            $this->showError();
        }
    }

    /**
     * 检测是否有错误
     * @return bool
     */
    protected function checkError(){
        if(!is_null($this->fileInfo)){
            if($this->fileInfo['error'] != 0){
                switch($this->fileInfo['error']){
                    case 1:
                        $this->error =  '上传文件超过了PHP配置文件中upload_max_filesize选项值';
                        break;
                    case 2:
                        $this->error = '超过了表单MAX_FILE_SIZE限制的大小';
                        break;
                    case 3:
                        $this->error = '文件部分被上传';
                        break;
                    case 4:
                        $this->error = '没有选择上传文件';
                        break;
                    case 6:
                        $this->error = '没有找到临时目录';
                        break;
                    case 7:
                        $this->error = '文件不可写';
                    case 8:
                        $this->error = '由于PHP的扩展程序中断文件上传';
                }
                return false;
            }else{
                return true;
            }
        }else{
            $this->error = '文件上传出错';
            return false;
        }
    }

    /**
     * 检测大小是否符合
     * @return bool
     */
    protected function checkSize(){
        if($this->fileInfo['size'] > $this->maxSize){
            $this->error = '文件上传过大';
            return false;
        }
        return true;
    }


    /**
     * 检测扩展名
     * @return bool
     */
    protected function checkExt(){
        $this->ext = strtolower(pathinfo($this->fileInfo['name'],PATHINFO_EXTENSION));
        if(!in_array($this->ext,$this->allowExt)){
            $this->error = '非法的扩展名';
            return false;
        }
        return true;
    }
    /**
     * 检测类型
     * @return bool
     */
    protected function checkMime(){
        if(!in_array($this->fileInfo['type'],$this->allowMime)){
            $this->error = '不允许的文件类型';
            return false;
        }
        return true;
    }
    /**
     * 检测是否为真实图片
     * @return bool
     */
    protected function checkTrueImg(){
        if($this->imgFlag){
            if(!@getimagesize($this->fileInfo['tmp_name'])){
                $this->error = '不是真正的图片类型';
                return false;
            }
        }
        return true;
    }

    /**
     * 监测文件是否为http_post上传
     * @return bool
     */
    protected function checkHttpPost(){
        if(!is_uploaded_file($this->fileInfo['tmp_name'])){
            $this->error = '不是通过HTTP_POST上传';
            return false;
        }
        return true;
    }

    /**
     * 检测是否有上传目录
     * 没有就创建
     */
    protected function checkUploadPath(){
        if(!file_exists($this->uploadPath)){
            mkdir($this->uploadPath,0777,true);
            chmod($this->uploadPath,0777);
        }
    }

    /**
     * 产生唯一文件名
     * @return string
     */
    protected function getUniName(){
        return md5(uniqid(microtime(true),true));
    }

    /**
     * 返回错误信息
     * @return string
     */
    protected function showError(){
        return $this->error;
    }


}