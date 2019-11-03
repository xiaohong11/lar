<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
$path = 'uploads/';

if (!empty($_FILES)) {
	echo '<pre>';
	print_r($_FILES);
	echo '</pre>';
	exit();
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$fileTypes = array('jpg', 'jpeg', 'gif', 'png');
	$fileName = iconv('UTF-8', 'GB2312', $_FILES['Filedata']['name']);
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	$files = $_POST['typeCode'];

	if (!is_dir($path)) {
		mkdir($path);
	}

	if (move_uploaded_file($tempFile, $path . $fileName)) {
		echo $fileName;
	}
	else {
		echo $fileName . '上传失败！';
	}
}

?>
