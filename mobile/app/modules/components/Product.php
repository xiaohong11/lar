<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
return array(
	'id'      => 'mod-product',
	'module'  => 'product',
	'setting' => false,
	'data'    => array(
		'isStyleSel'       => '1',
		'showProductClass' => array('small' => false, 'big' => false, 'normal' => true),
		'showStyle'        => array(
			array('key' => '0', 'type' => 'radio', 'text' => '大图'),
			array('key' => '1', 'type' => 'radio', 'text' => '中图'),
			array('key' => '2', 'type' => 'radio', 'text' => '小图')
			),
		'isTagSel'         => array('0', '1'),
		'showTag'          => array(
			array('key' => '0', 'type' => 'checkbox', 'text' => '库存'),
			array('key' => '1', 'type' => 'checkbox', 'text' => '销量')
			),
		'showMod'          => array(
			array('key' => 'best', 'type' => 'radio', 'text' => '精品'),
			array('key' => 'new', 'type' => 'radio', 'text' => '新品'),
			array('key' => 'hot', 'type' => 'radio', 'text' => '热卖')
			),
		'isShowMod'        => 'best',
		'number'           => '10',
		'imgList'          => array()
		)
	);

?>
