<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
define('IN_ECS', true);
require dirname(__FILE__) . '/includes/init.php';
require ROOT_PATH . '/includes/lib_area.php';
assign_template();

if ($_REQUEST['act'] == 'service') {
	$user_id = $_SESSION['user_id'];
	$IM_menu = $ecs->url() . '/online.php?act=service_menu';
	$goods_id = (isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0);
	$seller_id = (isset($_REQUEST['ru_id']) ? intval($_REQUEST['ru_id']) : -1);

	if ($GLOBALS['_CFG']['customer_service'] == 0) {
		$ru_id = 0;
	}
	else if (-1 < $seller_id) {
		$ru_id = $seller_id;
	}
	else {
		$goods = get_goods_info($goods_id, 0, 0, array('g.user_id'));
		$ru_id = $goods['user_id'];
	}

	if (is_dir(ROOT_PATH . 'kefu')) {
		$smarty->assign('kefu', 1);
		$Loaction = $ecs->url() . 'user_chat.php?act=service&ru_id=' . $ru_id . '&goods_id=' . $goods_id;
		ecs_header('Location: ' . $Loaction . "\n");
		exit();
	}

	$sql = 'SELECT kf_appkey,kf_secretkey,kf_touid, kf_logo, kf_welcomeMsg FROM ' . $ecs->table('seller_shopinfo') . ' WHERE ru_id = \'' . $ru_id . '\' LIMIT 1';
	$basic_info = $db->getRow($sql);
	IM($basic_info['kf_appkey'], $basic_info['kf_secretkey']);
	if (empty($basic_info['kf_logo']) || ($basic_info['kf_logo'] == 'http://')) {
		$basic_info['kf_logo'] = 'http://dsc-kf.oss-cn-shanghai.aliyuncs.com/dsc_kf/p16812444.jpg';
	}

	if ($user_id) {
		$user_info = user_info($_SESSION['user_id']);
		$user_info['user_id'] = 'dsc' . $_SESSION['user_id'];

		if (empty($user_info['user_picture'])) {
			$user_logo = 'http://dsc-kf.oss-cn-shanghai.aliyuncs.com/dsc_kf/dsc_kf_user_logo.jpg';
		}
		else {
			$user_logo = $ecs->get_domain() . '/' . $user_info['user_picture'];
		}
	}
	else {
		$user_info['user_id'] = $_SESSION['user_ni_id'];
		$user_logo = 'http://dsc-kf.oss-cn-shanghai.aliyuncs.com/dsc_kf/dsc_kf_user_logo.jpg';
	}

	$smarty->assign('user_id', $user_info['user_id']);
	$smarty->assign('user_logo', $user_logo);
	$smarty->assign('kf_appkey', $basic_info['kf_appkey']);
	$smarty->assign('kf_touid', $basic_info['kf_touid']);
	$smarty->assign('kf_logo', $basic_info['kf_logo']);
	$smarty->assign('kf_welcomeMsg', $basic_info['kf_welcomeMsg']);
	$smarty->assign('IM_menu', $IM_menu);
	$smarty->assign('goods_id', $goods_id);
	$smarty->display('chats.dwt');
}

if ($_REQUEST['act'] == 'service_menu') {
	$smarty->display('chats_menu.dwt');
}

if ($_REQUEST['act'] == 'history') {
	$request = json_decode($_POST['q'], true);
	$itemId = $request['itemsId'][0];
	$url = $ecs->url();
	echo $current_url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	exit();
	$goods = goods_info($itemId);
	echo "    {\r\n    \"code\": \"200\",\r\n    \"desc\": \"powered by 大商创\",\r\n    \"itemDetail\": [\r\n            {\r\n                \"userid\": \"" . $request['userid'] . "\",\r\n                \"itemid\": \"" . $itemId . "\",\r\n                \"itemname\": \"" . $goods['goods_name'] . "\",\r\n                \"itempic\": \"" . $url . $goods['goods_thumb'] . "\",\r\n                \"itemprice\": \"" . $goods['shop_price'] . "\",\r\n                \"itemurl\": \"" . $current_url . "\",\r\n                \"extra\": {}\r\n            }\r\n        ]\r\n    }";
}

?>
