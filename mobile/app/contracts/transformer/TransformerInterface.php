<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\contracts\transformer;

interface TransformerInterface
{
	public function transformCollection(array $map);

	public function transform(array $map);
}


?>
