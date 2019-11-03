<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
function get_accountlist($user_id, $account_type = '')
{
	$where = ' WHERE user_id = \'' . $user_id . '\' ';

	if (in_array($account_type, array('user_money', 'frozen_money', 'rank_points', 'pay_points'))) {
		$where .= ' AND ' . $account_type . ' <> 0 ';
	}

	$filter = array('user_id' => $user_id, 'account_type' => $account_type);
	$sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('account_log') . $where;
	$filter['record_count'] = $GLOBALS['db']->getOne($sql);
	$filter = page_and_size($filter);
	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('account_log') . $where . ' ORDER BY log_id DESC';
	$res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);
	$arr = array();

	while ($row = $GLOBALS['db']->fetchRow($res)) {
		$row['change_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['change_time']);
		$arr[] = $row;
	}

	return array('account' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

define('IN_ECS', true);
require dirname(__FILE__) . '/includes/init.php';
include_once ROOT_PATH . 'includes/lib_order.php';

if ($_REQUEST['act'] == 'list') {
	$user_id = (empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']));

	if ($user_id <= 0) {
		sys_msg('invalid param');
	}

	$user = user_info($user_id);

	if (empty($user)) {
		sys_msg($_LANG['user_not_exist']);
	}

	$smarty->assign('user', $user);
	if (empty($_REQUEST['account_type']) || !in_array($_REQUEST['account_type'], array('user_money', 'frozen_money', 'rank_points', 'pay_points'))) {
		$account_type = '';
	}
	else {
		$account_type = $_REQUEST['account_type'];
	}

	$smarty->assign('account_type', $account_type);
	$smarty->assign('ur_here', $_LANG['account_list']);
	$smarty->assign('action_link', array('text' => $_LANG['add_account'], 'href' => 'account_log.php?act=add&user_id=' . $user_id));

	if (0 < $user_id) {
		$smarty->assign('action_link2', array('href' => 'users.php?act=list', 'text' => '会员列表'));
	}

	$smarty->assign('full_page', 1);
	$smarty->assign('user_id', $user_id);
	$smarty->assign('form_action', 'account_log');
	$account_list = get_accountlist($user_id, $account_type);
	$smarty->assign('account_list', $account_list['account']);
	$smarty->assign('filter', $account_list['filter']);
	$smarty->assign('record_count', $account_list['record_count']);
	$smarty->assign('page_count', $account_list['page_count']);
	assign_query_info();
	$smarty->display('user_list_edit.dwt');
}
else if ($_REQUEST['act'] == 'query') {
	$user_id = (empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']));

	if ($user_id <= 0) {
		sys_msg('invalid param');
	}

	$user = user_info($user_id);

	if (empty($user)) {
		sys_msg($_LANG['user_not_exist']);
	}

	$smarty->assign('user', $user);
	if (empty($_REQUEST['account_type']) || !in_array($_REQUEST['account_type'], array('user_money', 'frozen_money', 'rank_points', 'pay_points'))) {
		$account_type = '';
	}
	else {
		$account_type = $_REQUEST['account_type'];
	}

	$smarty->assign('ur_here', $_LANG['account_list']);
	$smarty->assign('account_type', $account_type);
	$smarty->assign('user_id', $user_id);
	$smarty->assign('form_action', 'account_log');
	$account_list = get_accountlist($user_id, $account_type);
	$smarty->assign('account_list', $account_list['account']);
	$smarty->assign('filter', $account_list['filter']);
	$smarty->assign('record_count', $account_list['record_count']);
	$smarty->assign('page_count', $account_list['page_count']);
	make_json_result($smarty->fetch('user_list_edit.dwt'), '', array('filter' => $account_list['filter'], 'page_count' => $account_list['page_count']));
}
else if ($_REQUEST['act'] == 'add') {
	admin_priv('account_manage');
	$user_id = (empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']));

	if ($user_id <= 0) {
		sys_msg('invalid param');
	}

	$user = user_info($user_id);

	if (empty($user)) {
		sys_msg($_LANG['user_not_exist']);
	}

	$smarty->assign('user', $user);
	$sc_rand = rand(1000, 9999);
	$sc_guid = sc_guid();
	$account_cookie = MD5($sc_guid . '-' . $sc_rand);
	setcookie('account_cookie', $account_cookie, gmtime() + (3600 * 24 * 30), $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
	$smarty->assign('sc_guid', $sc_guid);
	$smarty->assign('sc_rand', $sc_rand);
	$smarty->assign('ur_here', $_LANG['add_account']);
	$smarty->assign('action_link', array('href' => 'account_log.php?act=list&user_id=' . $user_id, 'text' => $_LANG['account_list']));
	assign_query_info();
	$smarty->display('account_info.dwt');
}
else {
	if (($_REQUEST['act'] == 'insert') || ($_REQUEST['act'] == 'update')) {
		admin_priv('account_manage');
		$user_id = (empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']));
		$links = array(
			array('href' => 'account_log.php?act=list&user_id=' . $user_id, 'text' => $_LANG['account_list']),
			array('href' => 'account_log.php?act=add&user_id=' . $user_id, 'text' => $_LANG['add_account'])
			);
		$sc_rand = (isset($_POST['sc_rand']) && !empty($_POST['sc_rand']) ? trim($_POST['sc_rand']) : '');
		$sc_guid = (isset($_POST['sc_guid']) && !empty($_POST['sc_guid']) ? trim($_POST['sc_guid']) : '');
		$account_cookie = MD5($sc_guid . '-' . $sc_rand);
		if (!empty($sc_guid) && !empty($sc_rand) && isset($_COOKIE['account_cookie'])) {
			if (!empty($_COOKIE['account_cookie'])) {
				if (!($_COOKIE['account_cookie'] == $account_cookie)) {
					sys_msg($_LANG['repeat_submit'], 0, $links);
				}
			}
			else {
				sys_msg($_LANG['log_account_change_no'], 0, $links);
			}

			$token = trim($_POST['token']);

			if ($token != $_CFG['token']) {
				sys_msg($_LANG['no_account_change'], 1);
			}

			if ($user_id <= 0) {
				sys_msg('invalid param');
			}

			$user = user_info($user_id);

			if (empty($user)) {
				sys_msg($_LANG['user_not_exist']);
			}

			$money_status = intval($_POST['money_status']);
			$add_sub_user_money = floatval($_POST['add_sub_user_money']);
			$add_sub_frozen_money = floatval($_POST['add_sub_frozen_money']);
			$change_desc = sub_str($_POST['change_desc'], 255, false);
			$user_money = (isset($_POST['user_money']) && !empty($_POST['user_money']) ? $add_sub_user_money * abs(floatval($_POST['user_money'])) : 0);
			$frozen_money = (isset($_POST['frozen_money']) && !empty($_POST['frozen_money']) ? $add_sub_frozen_money * abs(floatval($_POST['frozen_money'])) : 0);
			$rank_points = floatval($_POST['add_sub_rank_points']) * abs(floatval($_POST['rank_points']));
			$pay_points = floatval($_POST['add_sub_pay_points']) * abs(floatval($_POST['pay_points']));
			if (($user_money == 0) && ($frozen_money == 0) && ($rank_points == 0) && ($pay_points == 0)) {
				sys_msg($_LANG['no_account_change']);
			}

			if ($money_status == 1) {
				if (0 < $frozen_money) {
					$user_money = '-' . $frozen_money;
				}
				else {
					if (!empty($frozen_money) && !(strpos($frozen_money, '-') === false)) {
						$user_money = substr($frozen_money, 1);
					}
				}
			}

			$sql = 'SELECT user_money, frozen_money, rank_points, pay_points FROM ' . $ecs->table('users') . ' WHERE user_id = \'' . $user_id . '\'';//ci cheng xu ban quan shu yu shang chuang ，po jie cheng xu chu zi yu jin meng wang luo ！
			$user_info = $db->getRow($sql);

			if ($user_info) {
				$user_money = get_return_money($user_money, $user_info['user_money']);
				$frozen_money = get_return_money($frozen_money, $user_info['frozen_money']);
				$rank_points = get_return_money($rank_points, $user_info['rank_points']);
				$pay_points = get_return_money($pay_points, $user_info['pay_points']);

				if ($money_status == 1) {
					if ($frozen_money == 0) {
						$user_money = 0;
					}
				}
			}

			log_account_change($user_id, $user_money, $frozen_money, $rank_points, $pay_points, '【' . $_LANG['terrace_handle'] . '】' . $change_desc, ACT_ADJUSTING);
			setcookie('account_cookie', '', gmtime() + (3600 * 24 * 30), $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
		}

		sys_msg($_LANG['log_account_change_ok'], 0, $links);
	}
}

?>
