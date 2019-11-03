<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
function get_data_list($type = 0)
{
	$leftJoin = '';
	$where = 1;
	$adminru = get_admin_ru_id();
	$where .= ' and (select count(*) from ' . $GLOBALS['ecs']->table('order_info') . ' as oi2 where oi2.main_order_id = o.order_id) = 0 ';

	if ($type != 0) {
		$result = get_filter();

		if ($result === false) {
			$filter['keyword'] = !isset($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
			if (!empty($_GET['is_ajax']) && ($_GET['is_ajax'] == 1)) {
				$_REQUEST['keyword'] = json_str_iconv($_REQUEST['keyword']);
			}

			$filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'goods_number' : trim($_REQUEST['sort_by']);
			$filter['time_type'] = !empty($_REQUEST['time_type']) ? intval($_REQUEST['time_type']) : 0;
			$filter['date_start_time'] = !empty($_REQUEST['date_start_time']) ? trim($_REQUEST['date_start_time']) : '';
			$filter['date_end_time'] = !empty($_REQUEST['date_end_time']) ? trim($_REQUEST['date_end_time']) : '';
			$filter['cat_name'] = !empty($_REQUEST['cat_name']) ? trim($_REQUEST['cat_name']) : '';
			$filter['order_status'] = !empty($_REQUEST['order_status']) ? explode(',', $_REQUEST['order_status']) : '';
			$filter['shipping_status'] = !empty($_REQUEST['shipping_status']) ? explode(',', $_REQUEST['shipping_status']) : '';

			if (!empty($filter['cat_name'])) {
				$sql = 'SELECT cat_id FROM ' . $GLOBALS['ecs']->table('category') . ' WHERE cat_name = \'' . $filter['cat_name'] . '\'';
				$cat_id = $GLOBALS['db']->getOne($sql);
				$where .= ' AND g.cat_id = \'' . $cat_id . '\'';
			}

			if (($filter['date_start_time'] == '') && ($filter['date_end_time'] == '')) {
				$start_time = local_mktime(0, 0, 0, date('m'), 1, date('Y'));
				$end_time = (local_mktime(0, 0, 0, date('m'), date('t'), date('Y')) + (24 * 60 * 60)) - 1;
			}
			else {
				$start_time = local_strtotime($filter['date_start_time']);
				$end_time = local_strtotime($filter['date_end_time']);
			}

			$filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);
			if (isset($_REQUEST['page_size']) && (0 < intval($_REQUEST['page_size']))) {
				$filter['page_size'] = intval($_REQUEST['page_size']);
			}
			else {
				if (isset($_COOKIE['ECSCP']['page_size']) && (0 < intval($_COOKIE['ECSCP']['page_size']))) {
					$filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
				}
				else {
					$filter['page_size'] = 15;
				}
			}

			if ($filter['time_type'] == 1) {
				$where .= ' AND o.add_time >= \'' . $start_time . '\' AND o.add_time <= \'' . $end_time . '\'';
			}
			else {
				$where .= ' AND o.shipping_time >= \'' . $start_time . '\' AND o.shipping_time <= \'' . $end_time . '\'';
			}

			if (!empty($filter['order_status'])) {
				$order_status = implode(',', $filter['order_status']);
				$where .= ' AND o.order_status in(' . $order_status . ')';
			}

			if (!empty($filter['shipping_status'])) {
				$shipping_status = implode(',', $filter['shipping_status']);
				$where .= ' AND o.shipping_status in(' . $shipping_status . ')';
			}

			if (0 < $adminru['ru_id']) {
				$where .= ' AND og.ru_id = \'' . $adminru['ru_id'] . '\'';
			}

			$sql = 'SELECT og.goods_id, og.order_id, og.goods_id, og.goods_name, og.ru_id, og.goods_sn, og.goods_price, o.add_time, ' . '(' . order_amount_field('o.') . ') AS total_fee, og.goods_number ' . ' FROM ' . $GLOBALS['ecs']->table('order_goods') . ' AS og ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('order_info') . ' AS o ' . ' ON o.order_id = og.order_id ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ' . ' ON g.goods_id = og.goods_id ' . ' WHERE ' . $where . ' GROUP BY og.goods_id ORDER BY og.goods_id DESC';
			set_filter($filter, $sql);
		}
		else {
			$sql = $result['sql'];
			$filter = $result['filter'];
		}
	}

	$data_list = $GLOBALS['db']->getAll($sql);
	$filter['record_count'] = count($data_list);
	$filter['page_count'] = 0 < $filter['record_count'] ? ceil($filter['record_count'] / $filter['page_size']) : 1;

	if ($type != 0) {
		for ($i = 0; $i < count($data_list); $i++) {
			$data_list[$i]['shop_name'] = get_shop_name($data_list[$i]['ru_id'], 1);
			$order = get_order_goods_info($where, $data_list[$i]['goods_id']);
			$data_list[$i]['goods_number'] = $order['goods_number'];
			$data_list[$i]['total_fee'] = $order['goods_number'] * $order['goods_price'];
			$data_list[$i]['cat_name'] = $GLOBALS['db']->getOne('SELECT c.cat_name FROM ' . $GLOBALS['ecs']->table('category') . ' AS c, ' . $GLOBALS['ecs']->table('goods') . ' AS g' . ' WHERE c.cat_id = g.cat_id AND g.goods_id = \'' . $data_list[$i]['goods_id'] . '\' ');
			$data_list[$i]['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $data_list[$i]['add_time']);
		}

		if ($filter['sort_by'] == 'goods_number') {
			$data_list = get_array_sort($data_list, 'goods_number', 'DESC');
		}

		$arr = array('data_list' => $data_list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
		return $arr;
	}
}

function get_order_goods_info($where = '', $goods_id)
{
	$sql = 'SELECT SUM(' . order_amount_field('o.') . ') AS total_fee, SUM(og.goods_number) AS goods_number , og.goods_price ' . ' FROM ' . $GLOBALS['ecs']->table('order_goods') . ' AS og ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('order_info') . ' AS o ' . ' ON o.order_id = og.order_id AND og.goods_id ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ' . ' ON g.goods_id = og.goods_id ' . ' WHERE ' . $where . ' AND og.goods_id = \'' . $goods_id . '\'';
	return $GLOBALS['db']->getRow($sql);
}

function order_amount_field($alias = '', $ru_id = 0)
{
	return '   ' . $alias . 'goods_amount + ' . $alias . 'tax + ' . $alias . 'shipping_fee' . ' + ' . $alias . 'insure_fee + ' . $alias . 'pay_fee + ' . $alias . 'pack_fee' . ' + ' . $alias . 'card_fee ';
}

function get_status_list($type = 'all')
{
	global $_LANG;
	$list = array();
	if (($type == 'all') || ($type == 'order')) {
		$pre = ($type == 'all' ? 'os_' : '');

		foreach ($_LANG['os'] as $key => $value) {
			$list[$pre . $key] = $value;
		}
	}

	if (($type == 'all') || ($type == 'shipping')) {
		$pre = ($type == 'all' ? 'ss_' : '');

		foreach ($_LANG['ss'] as $key => $value) {
			$list[$pre . $key] = $value;
		}
	}

	if (($type == 'all') || ($type == 'payment')) {
		$pre = ($type == 'all' ? 'ps_' : '');

		foreach ($_LANG['ps'] as $key => $value) {
			$list[$pre . $key] = $value;
		}
	}

	return $list;
}

define('IN_ECS', true);
require dirname(__FILE__) . '/includes/init.php';
require_once ROOT_PATH . 'languages/' . $_CFG['lang'] . '/' . ADMIN_PATH . '/statistic.php';
$smarty->assign('menus', $_SESSION['menus']);
$smarty->assign('lang', $_LANG);
admin_priv('sale_order_stats');
if (empty($_REQUEST['act']) || !in_array($_REQUEST['act'], array('list', 'download', 'query'))) {
	$_REQUEST['act'] = 'list';
}

$smarty->assign('primary_cat', $_LANG['06_stats']);

if ($_REQUEST['act'] == 'list') {
	$smarty->assign('current', 'sale_general_list');
	$start_time = local_mktime(0, 0, 0, date('m'), 1, date('Y'));
	$end_time = (local_mktime(0, 0, 0, date('m'), date('t'), date('Y')) + (24 * 60 * 60)) - 1;
	$start_time = local_date($GLOBALS['_CFG']['time_format'], $start_time);
	$end_time = local_date($GLOBALS['_CFG']['time_format'], $end_time);
	$smarty->assign('start_time', $start_time);
	$smarty->assign('end_time', $end_time);
	$smarty->assign('os_list', get_status_list('order'));
	$smarty->assign('ss_list', get_status_list('shipping'));
	$data = get_data_list(1);
	$page_count_arr = seller_page($data, $_REQUEST['page']);
	$smarty->assign('page_count_arr', $page_count_arr);
	$smarty->assign('data_list', $data['data_list']);
	$smarty->assign('filter', $data['filter']);
	$smarty->assign('record_count', $data['record_count']);
	$smarty->assign('page_count', $data['page_count']);
	$smarty->assign('date_start_time', $data['start_time']);
	$smarty->assign('date_end_time', $data['end_time']);
	$smarty->assign('full_page', 1);
	$smarty->assign('sort_order_time', '<img src="images/sort_desc.gif">');
	$smarty->assign('action_link', array('text' => $_LANG['down_sales_stats'], 'href' => 'sale_general.php?act=download&start_time=' . $start_time . '&end_time=' . $end_time, 'class' => 'icon-download-alt'));
	$smarty->assign('ur_here', $_LANG['report_sell']);
	assign_query_info();
	$smarty->display('sale_general.dwt');
}
else if ($_REQUEST['act'] == 'query') {
	$data = get_data_list(1);
	$page_count_arr = seller_page($data, $_REQUEST['page']);
	$smarty->assign('page_count_arr', $page_count_arr);
	$smarty->assign('data_list', $data['data_list']);
	$smarty->assign('filter', $data['filter']);
	$smarty->assign('record_count', $data['record_count']);
	$smarty->assign('page_count', $data['page_count']);
	$sort_flag = sort_flag($data['filter']);
	$smarty->assign($sort_flag['tag'], $sort_flag['img']);
	make_json_result($smarty->fetch('sale_general.dwt'), '', array('filter' => $data['filter'], 'page_count' => $data['page_count']));
}
else if ($_REQUEST['act'] == 'download') {
	$data = get_data_list(1);
	$data_list = $data['data_list'];
	$filename = str_replace(' ', '-', local_date($GLOBALS['_CFG']['time_format'], gmtime())) . '_' . rand(0, 1000);
	header('Content-type: application/vnd.ms-excel; charset=utf-8');
	header('Content-Disposition: attachment; filename=' . $filename . '.xls');
	echo ecs_iconv(EC_CHARSET, 'GB2312', $filename . $_LANG['sales_statistics']) . "\t\n";
	echo ecs_iconv(EC_CHARSET, 'GB2312', '商家名称') . '	';
	echo ecs_iconv(EC_CHARSET, 'GB2312', '商品名称') . '	';
	echo ecs_iconv(EC_CHARSET, 'GB2312', '货号') . '	';
	echo ecs_iconv(EC_CHARSET, 'GB2312', '分类') . '	';
	echo ecs_iconv(EC_CHARSET, 'GB2312', '数量') . '	';
	echo ecs_iconv(EC_CHARSET, 'GB2312', '单价') . '	';
	echo ecs_iconv(EC_CHARSET, 'GB2312', '总金额') . '	';
	echo ecs_iconv(EC_CHARSET, 'GB2312', '售出日期') . "\t\n";

	foreach ($data_list as $data) {
		echo ecs_iconv(EC_CHARSET, 'GB2312', $data['shop_name']) . '	';
		echo ecs_iconv(EC_CHARSET, 'GB2312', $data['goods_name']) . '	';
		echo ecs_iconv(EC_CHARSET, 'GB2312', $data['goods_sn']) . '	';
		echo ecs_iconv(EC_CHARSET, 'GB2312', $data['cat_name']) . '	';
		echo ecs_iconv(EC_CHARSET, 'GB2312', $data['goods_number']) . '	';
		echo ecs_iconv(EC_CHARSET, 'GB2312', $data['goods_price']) . '	';
		echo ecs_iconv(EC_CHARSET, 'GB2312', $data['total_fee']) . '	';
		echo ecs_iconv(EC_CHARSET, 'GB2312', $data['add_time']) . '	';
		echo "\n";
	}
}

?>
