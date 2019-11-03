<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
function baseCustomSetup($barcode, $get)
{
	$font_dir = '..' . DIRECTORY_SEPARATOR . 'font';

	if (isset($get['thickness'])) {
		$barcode->setThickness(max(9, min(90, intval($get['thickness']))));
	}

	$font = 0;
	if (($get['font_family'] !== '0') && (1 <= intval($get['font_size']))) {
		$font = new BCGFontFile($font_dir . '/' . $get['font_family'], intval($get['font_size']));
	}

	$barcode->setFont($font);
}


?>
