<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
function replace_img_view($data)
{
	$data = str_replace(array('http://localhost/'), '/', $data);
	return str_replace(array('/ecmoban0309/', '/dscmall/'), '', $data);
}


?>
