<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
return array(
	'id'      => 'mod-announcement',
	'module'  => 'announcement',
	'setting' => false,
	'data'    => array(
		'isAnnouncement'    => array(
			array(
				'key'        => '0',
				'type'       => 'radio',
				'text'       => '新闻模式',
				'picSizeKey' => array(0)
				),
			array(
				'key'        => '1',
				'type'       => 'radio',
				'text'       => '快报模式',
				'picSizeKey' => array('0', '1')
				)
			),
		'icon'              => elixir('img/new-icon.png'),
		'isAnnouncementSel' => '0',
		'isAnnounRight'     => true,
		'isAnnounText'      => true,
		'AnnounText'        => '[双12]全场五折，全国包邮，只限今日，欢迎快速抢购',
		'announOption'      => array('paginationClickable' => true, 'direction' => 'vertical', 'loop' => true, 'autoplay' => 4000, 'speed' => 400, 'freeMode' => true, 'noSwiping' => true),
		'contList'          => array(
			array('text' => '诺基亚手机广告欣赏')
			)
		)
	);

?>
