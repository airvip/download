<?php
/**
 * Created by PhpStorm.
 * User: wzb
 * Date: 2016/5/2
 * Time: 21:57
 */
header('content-type:text/html;charset=utf-8');
$files = getFiles();
foreach($files as $fileInfo){

    $res = uploadFile($fileInfo);
    $uploadFiles[] = @$res['dest'];
}
$uploadFiles = array_values(array_filter($uploadFiles));

p($uploadFiles);


function uploadFile($fileInfo,$des_dir='Upload',$flag = false, $allow_mime = array('jpeg','jpg','gif','png','gzip','zip'),$max_size = 3145728){

    //判断错误号
    if( $fileInfo['error'] === UPLOAD_ERR_OK){
        //判断文件大小
        if($fileInfo['size']>$max_size){
            $res['mes'] ='上传文件过大';
        }
        //判断类型
        $ext    = getExt($fileInfo['name']);
        if(!is_array($allow_mime)){
            $res['mes'] ='文件上传允许类型为数组';
        }
        if(!in_array($ext,$allow_mime)){
            $res['mes'] = $fileInfo['name'].'非法文件类型';
        }
        //当flag为真时，增强检测为图片
        if($flag){
            if(!getimagesize($fileInfo['tmp_name'])){
                $res['mes'] = $fileInfo['name'].'不是真正的图片类型';
            }
        }
        //判断是否为http post方式上传的
        if(!is_uploaded_file($fileInfo['tmp_name'])){
            $res['mes'] = $fileInfo['name'].'文件不是通过http post方式上传';
        }
        if(@$res)return $res;
        $file_path       = substr(str_replace('\\','/',__DIR__),0,-3).$des_dir.'/';
        $uniName     = getUniName();
        $destination    = $file_path.$uniName.'.'.$ext;
        if(!file_exists($file_path)){
            mkdir($file_path,0777,true);
            chmod($file_path,0777);
        }
        //移动临时文件到指定目录文件
        if(!@move_uploaded_file($fileInfo['tmp_name'],$destination)){
            $res['mes'] = $fileInfo['name']."文件移动失败";
        }
        $res['mes']  = $fileInfo['name']."上传成功";
        $res['dest'] = $destination;
        return $res;
    }else{
        switch( $fileInfo['error']){
            case 1:
                $res['mes'] =  '上传文件超过了PHP配置文件中upload_max_filesize选项值';
                break;
            case 2:
                $res['mes'] = '超过了表单MAX_FILE_SIZE限制的大小';
                break;
            case 3:
                $res['mes'] = '文件部分被上传';
                break;
            case 4:
                $res['mes'] = '没有选择上传文件';
                break;
            case 6:
                $res['mes'] = '没有找到临时目录';
                break;
            case 7:
            case 8:
            $res['mes'] = '系统错误';
        }
    }
    return $res;
}

/**
 * @param $filename
 * @return string 返回文件后缀名
 */
function getExt($filename){
    return strtolower(pathinfo($filename,PATHINFO_EXTENSION));
}

/**
 * @return string 获取唯一文件名
 */
function getUniName(){
    return md5(uniqid(microtime(true),true));
}

/**
 * @return mixed 获取上传文件
 */
function getFiles(){
    $i = 0;
    foreach($_FILES as $file){
        if(is_string($file['name'])){
            $files[$i] = $file;
            $i++;
        }elseif(is_array($file['name'])){
            foreach($file['name'] as $k=>$v){
                $files[$i]['name'] = $file['name'][$k];
                $files[$i]['type'] = $file['type'][$k];
                $files[$i]['tmp_name'] = $file['tmp_name'][$k];
                $files[$i]['error'] = $file['error'][$k];
                $files[$i]['size'] = $file['size'][$k];
                $i++;
            }
        }
    }
    return $files;
}



/*
function uploadFile($fileInfo,$des_dir='Upload',$flag = false, $allow_mime = array('jpeg','jpg','gif','png','gzip','zip'),$max_size = 3145728){
    //上传的文件名
    $filename   = $fileInfo['name'];
    //上传文件的mime类型
        $type       = $fileInfo['type'];
    //上传到服务器上的临时文件
        $tmp_name   = $fileInfo['tmp_name'];
    //上传文件的大小
        $size       = $fileInfo['size'];
    //上传文件的错误号
        $error      = $fileInfo['error'];
    //是否开启检测为真实图片类型，默认不监测
    //$flag       = false;
    //判断错误号
    if($error != 0){
        switch($error){
            case 1:
                exit( '上传文件超过了PHP配置文件中upload_max_filesize选项值');
            case 2:
                exit('超过了表单MAX_FILE_SIZE限制的大小');
            case 3:
                exit('文件部分被上传');
            case 4:
                exit( '没有选择上传文件');
            case 6:
                exit('没有找到临时目录');
            case 7:
            case 8:
                exit('系统错误');
        }
    }
//允许上传最大值
//    $max_size = 3145728;
//判断文件大小
    if($size>$max_size){
        exit('上传文件过大');
    }

//$ext  = strtolower(end(explode('.',$fileInfo['name'])));
    //判断类型
    $ext    = strtolower(pathinfo($fileInfo['name'],PATHINFO_EXTENSION));
//定义允许数组
//    $allow_mime = array('jpeg','jpg','gif','png','gzip','zip');
    if(!is_array($allow_mime)){
        exit('文件上传允许类型为数组');
    }
    if(!in_array($ext,$allow_mime)){
        exit('非法文件类型');
    }
//当flag为真时，增强检测为图片
    if($flag){
        if(!getimagesize($tmp_name)){
            exit('不是真正的图片类型');
        }
    }

//判断是否为http post方式上传的
    if(!is_uploaded_file($tmp_name)){
        exit('文件不是通过http post方式上传');
    }

    $mydir      = str_replace('\\','/',__DIR__);
    $root       = substr($mydir,0,-3);
    $file_path  = $root.$des_dir.'/';
    if(!file_exists($file_path)){
        mkdir($file_path,0777,true);
        chmod($file_path,0777);
    }
//唯一文件名
    $uniName    = $file_path.md5(uniqid(microtime(true),true)).'.'.$ext;
    if(!@move_uploaded_file($tmp_name,$uniName)){
        exit("文件{$filename}上传失败") ;
    }
    return array(
        'newName' => $uniName,
        'size'     => $size,
        'type'     => $type
    );
    echo "文件{$filename}上传成功，名字变更为{$uniName}";
}




//将服务器上的临时文件移动到指定目录
//移动成功返回true,否则返回false
//move_uploaded_file($tmp_name,$file_path.$filename);

//通过copy
//copy($tmp_name,$file_path.$filename);
*/

function p($var = ''){
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}