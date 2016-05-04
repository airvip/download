<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./public/img/ico_48.ico">
    <meta name="keywords" content="手机号查询,个人博客" />
    <meta name="description" content="阿尔维奇的技术博客，手机号查询与AirBlog均为王振北的作品"/>

    <link rel="stylesheet" type="text/css" href="./public/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./public/pluge/sweet-alert/sweetalert.css">
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <title>文件上传</title>
    <style>
        #search{margin-top: 1rem;}
        #find-phone{display: none;}
        #find-phone-footer{position: fixed;bottom:30px;text-align: center;}
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h4 class="text-center">文件上传</h4>
            <form action="apiUpload.php" method="post" enctype="multipart/form-data">
                <div class="input-group" id="search">
                    <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                    <input type="file" name="myFile[]" required multiple="multiple" class="form-control" id="my-file"  accept="application/x-zip-compressed,application/gzip,image/jpeg,image/jpg,image/gif,image/png">
                    <span class="input-group-btn">
                        <button class="btn btn-success" type="submit" id="sub-phone"><span class="glyphicon glyphicon-open"></span></button>
                    </span>
                </div>
            </form>
            <h4 class="text-center">该上传类支持jpg,jpeg,zip,png,gif格式上传,最大3M，支持单文件多文件，多文件file的属性name=xxx[]</h4>
            <p class="text-center">
                <a class="btn btn-success btn-xs" href="https://github.com/airvip/download.git">
                    <span class="glyphicon glyphicon-eye-open"></span>
                    源码查看
                </a>
            </p>


            <footer id="find-phone-footer">
                友情链接:
                <a class="btn btn-success btn-xs" href="http://www.dear521.com/" target="_blank">AirBlog</a>
                <a class="btn btn-success btn-xs" href="http://mobile.diff.wang/" target="_blank">手机号查询</a>
            </footer>
        </div>
    </div>
</div>



<script src="./public/js/jquery-2.1.1.min.js"></script>
<script src="./public/pluge/sweet-alert/sweet-alert.min.js"></script>
<!--<script src="./public/js/mobile.js"></script>-->
<script>
    $(function(){

    });
</script>

</body>
</html>