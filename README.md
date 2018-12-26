# download demo use php
this is a demo . use php write some down code. 

前端表单
```
<form action="apiUpload.php" method="post" enctype="multipart/form-data">
	<div class="input-group" id="search">
		<input type="hidden" name="MAX_FILE_SIZE" value="3145728">
		<input type="file" name="myFile[]" required multiple="multiple" class="form-control" id="my-file"  accept="application/x-zip-compressed,application/gzip,image/jpeg,image/jpg,image/gif,image/png">
		<span class="input-group-btn">
			<button class="btn btn-success" type="submit" id="sub-phone"><span class="glyphicon glyphicon-open"></span></button>
		</span>
	</div>
</form>
```
调用
```
require_once './App/Upload.class.php'; // 引入扩展
$files = getFiles();


foreach($files as $fileInfo){
    $upload = new Upload($fileInfo);
    $res = $upload->uploadFile();
    $uploadFiles[] = $res;
}
$uploadFiles = array_values(array_filter($uploadFiles));


```

支持多文件上传



















