<?php
/**
 * Created by PhpStorm.
 * User: wzb
 * Date: 2016/5/2
 * Time: 21:57
 */


$filename   = $_FILES['myFile']['name'];
$type       = $_FILES['myFile']['type'];
$tmp_name   = $_FILES['myFile']['tmp_name'];
$size       = $_FILES['myFile']['size'];
$error      = $_FILES['myFile']['error'];
$mydir      = str_replace('/\\/','/',__DIR__);
$root       = substr($mydir,0,-3);
$file_path  = $root.'Upload/';


//将服务器上的临时文件移动到指定目录
//移动成功返回true,否则返回false
//move_uploaded_file($tmp_name,$file_path.$filename);

//通过copy
copy($tmp_name,$file_path.$filename);


