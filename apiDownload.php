<?php
/**
 * Created by PhpStorm.
 * User: wzb
 * Date: 2016/5/4
 * Time: 16:20
 */
$filename = $_GET['fileanme'];
header('content-desposition:attachment;filename='.basename($filename));
header('content-length:'.filesize($filename));
readfile($filename);