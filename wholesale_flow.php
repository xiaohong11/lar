<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
define('IN_ECS', true);
require dirname(__FILE__) . '/includes/init.php';
require ROOT_PATH . 'includes/lib_area.php';
require ROOT_PATH . 'includes/lib_order.php';
require ROOT_PATH . 'includes/lib_wholesale.php';
require_once ROOT_PATH . 'languages/' . $_CFG['lang'] . '/user.php';
require_once ROOT_PATH . 'languages/' . $_CFG['lang'] . '/shopping_flow.php';
$area_info = get_area_info($province_id);
$area_id = $area_info['region_id'];
$where = 'regionId = \'' . $province_id . '\'';
$date = array('parent_id');
$region_id = get_table_date('region_warehouse', $where, $date, 2);
if (isset($_COOKIE['region_id']) && !(empty($_COOKIE['region_id']))) 
{
	$region_id = $_COOKIE['region_id'];
}
$smarty->assign('keywords', htmlspecialchars($_CFG['shop_keywords']));
$smarty->assign('description', htmlspecialchars($_CFG['shop_desc']));
if (!(isset($_REQUEST['step']))) 
{
	$_REQUEST['step'] = 'cart';
}
if (!(empty($_SESSION['user_id']))) 
{
	$sess_id = ' user_id = \'' . $_SESSION['user_id'] . '\' ';
	$a_sess = ' a.user_id = \'' . $_SESSION['user_id'] . '\' ';
	$b_sess = ' b.user_id = \'' . $_SESSION['user_id'] . '\' ';
	$c_sess = ' c.user_id = \'' . $_SESSION['user_id'] . '\' ';
	$sess = '';
}
else 
{
	$sess_id = ' session_id = \'' . real_cart_mac_ip() . '\' ';
	$a_sess = ' a.session_id = \'' . real_cart_mac_ip() . '\' ';
	$b_sess = ' b.session_id = \'' . real_cart_mac_ip() . '\' ';
	$c_sess = ' c.session_id = \'' . real_cart_mac_ip() . '\' ';
	$sess = real_cart_mac_ip();
}
assign_template();
$position = assign_ur_here(0, $_LANG['shopping_flow']);
$smarty->assign('page_title', $position['title']);
$smarty->assign('ur_here', $position['ur_here']);
$smarty->assign('helps', get_shop_help());
$smarty->assign('lang', $_LANG);
$smarty->assign('show_marketprice', $_CFG['show_marketprice']);
if (defined('THEME_EXTENSION')) 
{
	$business_cate = get_business_category_tree();
	$smarty->assign('business_cate', $business_cate);
}
$smarty->assign('data_dir', DATA_DIR);
$smarty->assign('user_id', $_SESSION['user_id']);
if ($_REQUEST['step'] == 'add_to_cart') 
{
	include_once 'includes/cls_json.php';
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$goods_id = (empty($_REQUEST['goods_id']) ? 0 : intval($_REQUEST['goods_id']));
	$goods_type = get_table_date('wholesale', 'goods_id=\'' . $goods_id . '\'', array('goods_type'), 2);
	if (0 < $goods_type) 
	{
		$attr_array = (empty($_REQUEST['attr_array']) ? array() : $_REQUEST['attr_array']);
		$num_array = (empty($_REQUEST['num_array']) ? array() : $_REQUEST['num_array']);
		$total_number = array_sum($num_array);
	}
	else 
	{
		$goods_number = (empty($_REQUEST['goods_number']) ? 0 : intval($_REQUEST['goods_number']));
		$total_number = $goods_number;
	}
	$price_info = calculate_goods_price($goods_id, $total_number);
	$goods_info = get_table_date('goods', 'goods_id=\'' . $goods_id . '\'', array('goods_name, goods_sn, user_id'));
	$common_data = array();
	$common_data['user_id'] = $_SESSION['user_id'];
	$common_data['session_id'] = $sess;
	$common_data['goods_id'] = $goods_id;
	$common_data['goods_sn'] = $goods_info['goods_sn'];
	$common_data['goods_name'] = $goods_info['goods_name'];
	$common_data['market_price'] = $price_info['market_price'];
	$common_data['goods_price'] = $price_info['unit_price'];
	$common_data['goods_number'] = 0;
	$common_data['goods_attr_id'] = '';
	$common_data['ru_id'] = $goods_info['user_id'];
	$common_data['add_time'] = gmtime();
	if (0 < $goods_type) 
	{
		foreach ($attr_array as $key => $val ) 
		{
			$attr = explode(',', $val);
			$data = $common_data;
			$gooda_attr = get_goods_attr_array($val);
			foreach ($gooda_attr as $v ) 
			{
				$data['goods_attr'] .= $v['attr_name'] . ':' . $v['attr_value'] . "\n";
			}
			$data['goods_attr_id'] = $val;
			$data['goods_number'] = $num_array[$key];
			$set = get_find_in_set($attr, 'goods_attr_id', ',');
			$sql = ' SELECT rec_id FROM ' . $GLOBALS['ecs']->table('wholesale_cart') . ' WHERE ' . $sess_id . ' AND goods_id = \'' . $goods_id . '\' ' . $set . ' ';
			$rec_id = $GLOBALS['db']->getOne($sql);
			if (!(empty($rec_id))) 
			{
				$db->autoExecute($ecs->table('wholesale_cart'), $data, 'UPDATE', 'rec_id=\'' . $rec_id . '\'');
			}
			else 
			{
				$db->autoExecute($ecs->table('wholesale_cart'), $data, 'INSERT');
			}
		}
	}
	else 
	{
		$data = $common_data;
		$data['goods_number'] = $goods_number;
		$sql = ' SELECT rec_id FROM ' . $GLOBALS['ecs']->table('wholesale_cart') . ' WHERE ' . $sess_id . ' AND goods_id = \'' . $goods_id . '\' ';
		$rec_id = $GLOBALS['db']->getOne($sql);
		if (!(empty($rec_id))) 
		{
			$db->autoExecute($ecs->table('wholesale_cart'), $data, 'UPDATE', 'rec_id=\'' . $rec_id . '\'');
		}
		else 
		{
			$db->autoExecute($ecs->table('wholesale_cart'), $data, 'INSERT');
		}
	}
	calculate_cart_goods_price($goods_id);
	$result['content'] = insert_wholesale_cart_info();
	exit($json->encode($result));
}
else if ($_REQUEST['step'] == 'done') 
{
	$common_data['consignee'] = (empty($_REQUEST['consignee']) ? '' : trim($_REQUEST['consignee']));
	$common_data['mobile'] = (empty($_REQUEST['mobile']) ? '' : trim($_REQUEST['mobile']));
	$common_data['address'] = (empty($_REQUEST['address']) ? '' : trim($_REQUEST['address']));
	$common_data['inv_type'] = (empty($_REQUEST['inv_type']) ? 0 : intval($_REQUEST['inv_type']));
	$common_data['pay_id'] = (empty($_REQUEST['pay_id']) ? 0 : intval($_REQUEST['pay_id']));
	$common_data['postscript'] = (empty($_REQUEST['postscript']) ? '' : trim($_REQUEST['postscript']));
	$common_data['inv_payee'] = (empty($_REQUEST['inv_payee']) ? '' : trim($_REQUEST['inv_payee']));
	$common_data['tax_id'] = (empty($_REQUEST['tax_id']) ? '' : trim($_REQUEST['tax_id']));
	$main_order = $common_data;
	$main_order['order_sn'] = get_order_sn();
	$main_order['main_order_id'] = 0;
	$main_order['user_id'] = $_SESSION['user_id'];
	$main_order['add_time'] = gmtime();
	$main_order['order_amount'] = 0;
	$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('wholesale_order_info'), $main_order, 'INSERT');
	$main_order_id = $GLOBALS['db']->insert_id();
	$rec_ids = (empty($_REQUEST['rec_ids']) ? '' : implode(',', $_REQUEST['rec_ids']));
	$where = ' WHERE user_id = \'' . $_SESSION['user_id'] . '\' AND rec_id IN (' . $rec_ids . ') ';
	if (empty($rec_ids)) 
	{
	}
	$sql = ' SELECT DISTINCT ru_id FROM ' . $GLOBALS['ecs']->table('wholesale_cart') . $where;
	$ru_ids = $GLOBALS['db']->getCol($sql);
	foreach ($ru_ids as $key => $val ) 
	{
		$child_order = $common_data;
		$child_order['order_sn'] = get_order_sn();
		$child_order['main_order_id'] = $main_order_id;
		$child_order['user_id'] = $_SESSION['user_id'];
		$child_order['add_time'] = gmtime();
		$child_order['order_amount'] = 0;
		$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('wholesale_order_info'), $child_order, 'INSERT');
		$child_order_id = $GLOBALS['db']->insert_id();
		$sql = ' SELECT goods_id, goods_name, goods_sn, goods_number, goods_price, goods_attr, goods_attr_id, ru_id FROM ' . $GLOBALS['ecs']->table('wholesale_cart') . $where . ' AND ru_id = \'' . $val . '\' ';
		$cart_goods = $GLOBALS['db']->getAll($sql);
		foreach ($cart_goods as $k => $v ) 
		{
			$v['order_id'] = $child_order_id;
			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('wholesale_order_goods'), $v, 'INSERT');
			$child_order['order_amount'] += $v['goods_price'] * $v['goods_number'];
		}
		$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('wholesale_order_info'), $child_order, 'update', 'order_id =\'' . $child_order_id . '\'');
		$main_order['order_amount'] += $child_order['order_amount'];
	}
	$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('wholesale_order_info'), $main_order, 'update', 'order_id =\'' . $main_order_id . '\'');
	$sql = ' DELETE FROM ' . $GLOBALS['ecs']->table('wholesale_cart') . $where;
	$GLOBALS['db']->query($sql);
	show_message($_LANG['wholesale_flow_prompt'], $_LANG['wholesale_back_home'], 'wholesale.php', 'info');
}
else if ($_REQUEST['step'] == 'remove') 
{
	require_once ROOT_PATH . 'includes/cls_json.php';
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$goods_id = (empty($_REQUEST['goods_id']) ? 0 : intval($_REQUEST['goods_id']));
	if (!(empty($goods_id))) 
	{
		$sess_id .= ' AND goods_id = \'' . $goods_id . '\' ';
		$sql = ' DELETE FROM ' . $GLOBALS['ecs']->table('wholesale_cart') . ' WHERE ' . $sess_id . ' ';
		$GLOBALS['db']->query($sql);
	}
	exit($json->encode($result));
}
else if ($_REQUEST['step'] == 'batch_remove') 
{
	require_once ROOT_PATH . 'includes/cls_json.php';
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$goods_id = (empty($_REQUEST['goods_id']) ? '' : trim($_REQUEST['goods_id']));
	if (!(empty($goods_id))) 
	{
		$sess_id .= ' AND goods_id IN (' . $goods_id . ') ';
		$sql = ' DELETE FROM ' . $GLOBALS['ecs']->table('wholesale_cart') . ' WHERE ' . $sess_id . ' ';
		$GLOBALS['db']->query($sql);
	}
	exit($json->encode($result));
}
else if ($_REQUEST['step'] == 'ajax_update_cart') 
{
	require_once ROOT_PATH . 'includes/cls_json.php';
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$rec_ids = (empty($_REQUEST['rec_ids']) ? array() : $_REQUEST['rec_ids']);
	$rec_ids = implode(',', $rec_ids);
	$cart_goods = wholesale_cart_goods(0, $rec_ids);
	$goods_list = array();
	foreach ($cart_goods as $key => $val ) 
	{
		foreach ($val['goods_list'] as $k => $g ) 
		{
			$smarty->assign('goods', $g);
			$g['volume_price_lbi'] = $smarty->fetch('library/wholesale_cart_volume_price.lbi');
			$goods_list[$g['goods_id']] = $g;
		}
	}
	$result['goods_list'] = $goods_list;
	$cart_info = wholesale_cart_info(0, $rec_ids);
	$result['cart_info'] = $cart_info;
	exit($json->encode($result));
}
else if ($_REQUEST['step'] == 'update_rec_num') 
{
	require_once ROOT_PATH . 'includes/cls_json.php';
	$json = new JSON();
	$result = array('error' => 0, 'message' => '', 'content' => '');
	$rec_id = (empty($_REQUEST['rec_id']) ? 0 : intval($_REQUEST['rec_id']));
	$rec_num = (empty($_REQUEST['rec_num']) ? 0 : intval($_REQUEST['rec_num']));
	$cart_info = get_table_date('wholesale_cart', 'rec_id=\'' . $rec_id . '\'', array('goods_id', 'goods_attr_id'));
	if (empty($cart_info['goods_attr_id'])) 
	{
		$goods_number = get_table_date('wholesale', 'goods_id=\'' . $cart_info['goods_id'] . '\'', array('goods_number'), 2);
	}
	else 
	{
		$set = get_find_in_set(explode(',', $cart_info['goods_attr_id']));
		$goods_number = get_table_date('wholesale_products', 'goods_id=\'' . $cart_info['goods_id'] . '\' ' . $set, array('product_number'), 2);
	}
	$result['goods_number'] = $goods_number;
	if ($goods_number < $rec_num) 
	{
		$result['error'] = 1;
		$result['message'] = '该商品库存只有' . $goods_number . '个';
		$rec_num = $goods_number;
	}
	$sql = ' UPDATE ' . $GLOBALS['ecs']->table('wholesale_cart') . ' SET goods_number = \'' . $rec_num . '\' WHERE rec_id = \'' . $rec_id . '\' ';
	$GLOBALS['db']->query($sql);
	exit($json->encode($result));
}
else if ($_REQUEST['step'] == 'update_cart') 
{
}
else if ($_REQUEST['step'] == 'clear') 
{
	$sql = 'DELETE FROM ' . $ecs->table('wholesale_cart') . ' WHERE ' . $sess_id;
	$db->query($sql);
	ecs_header('Location:./' . "\n");
}
else 
{
	$goods_id = (empty($_REQUEST['goods_id']) ? 0 : trim($_REQUEST['goods_id']));
	$rec_ids = (empty($_REQUEST['rec_ids']) ? '' : trim($_REQUEST['rec_ids']));
	$goods_data = wholesale_cart_goods($goods_id, $rec_ids);
	$smarty->assign('goods_data', $goods_data);
	$cart_info = wholesale_cart_info($goods_id, $rec_ids);
	$smarty->assign('cart_info', $cart_info);
}
$history_goods = get_history_goods(0, $region_id, $area_id);
$smarty->assign('history_goods', $history_goods);
$smarty->assign('historyGoods_count', count($history_goods));
$smarty->assign('currency_format', $_CFG['currency_format']);
$smarty->assign('integral_scale', price_format($_CFG['integral_scale']));
$smarty->assign('step', $_REQUEST['step']);
assign_dynamic('shopping_flow');
$smarty->display('wholesale_flow.dwt');
?>