<?php
/**
 * Created by PhpStorm.
 * User: wzb
 * Date: 2016/5/4
 * Time: 15:26
 */
header('content-type:text/html;charset=utf-8');
require_once './App/Upload.class.php';
$files = getFiles();


foreach($files as $fileInfo){
    $upload = new Upload($fileInfo);
    $res = $upload->uploadFile();
    $uploadFiles[] = $res;
}
$uploadFiles = array_values(array_filter($uploadFiles));
header("Refresh:3;url=index.php");
p('跳转中...');
p($uploadFiles);


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



function p($str){
    echo '<pre>';
    print_r($str);
    echo '</pre>';
}