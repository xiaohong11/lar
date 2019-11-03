<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
function getStoreIdByGoodsId($id)
{
	$sql = 'SELECT store_id FROM ' . $GLOBALS['ecs']->table('store_goods') . ' WHERE goods_id = ' . $id;
	$res = $GLOBALS['db']->getRow($sql);
	return $res['store_id'];
}


?>
