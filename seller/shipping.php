<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
function get_site_root_url()
{
	return 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/' . SELLER_PATH . '/shipping.php', '', PHP_SELF);
}

function is_print_bg_default($print_bg)
{
	$_bg = basename($print_bg);
	$_bg_array = explode('.', $_bg);

	if (count($_bg_array) != 2) {
		return false;
	}

	if (strpos('|' . $_bg_array[0], 'dly_') != 1) {
		return false;
	}

	$_bg_array[0] = ltrim($_bg_array[0], 'dly_');
	$list = explode('|', SHIP_LIST);

	if (in_array($_bg_array[0], $list)) {
		return true;
	}

	return false;
}

function shipping_date_list()
{
	$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('shipping_date');
	$res = $GLOBALS['db']->getAll($sql);
	$arr = array();

	foreach ($res as $row) {
		$arr[] = $row;
	}

	return $arr;
}

define('IN_ECS', true);
require dirname(__FILE__) . '/includes/init.php';
$exc = new exchange($ecs->table('shipping'), $db, 'shipping_code', 'shipping_name');
$smarty->assign('menus', $_SESSION['menus']);
$smarty->assign('action_type', 'warehouse');
$adminru = get_admin_ru_id();
$smarty->assign('menu_select', array('action' => '11_system', 'current' => '03_shipping_list'));

if ($_REQUEST['act'] == 'list') {
	$smarty->assign('primary_cat', $_LANG['11_system']);
	$sql = ' select ru_id, shipping_id from ' . $GLOBALS['ecs']->table('seller_shopinfo') . ' where ru_id=\'' . $adminru['ru_id'] . '\' ';
	$seller_shopinfo = $GLOBALS['db']->getRow($sql);
	$modules = read_modules('../includes/modules/shipping');

	for ($i = 0; $i < count($modules); $i++) {
		$lang_file = ROOT_PATH . 'languages/' . $_CFG['lang'] . '/shipping/' . $modules[$i]['code'] . '.php';

		if (file_exists($lang_file)) {
			include_once $lang_file;
		}

		$sql = 'SELECT shipping_id, shipping_name, shipping_desc, insure, support_cod,shipping_order FROM ' . $ecs->table('shipping') . ' WHERE shipping_code=\'' . $modules[$i]['code'] . '\' ORDER BY shipping_order';
		$row = $db->GetRow($sql);

		if ($row) {
			$modules[$i]['id'] = $row['shipping_id'];
			$modules[$i]['name'] = $row['shipping_name'];
			$modules[$i]['desc'] = $row['shipping_desc'];
			$modules[$i]['insure_fee'] = $row['insure'];
			$modules[$i]['cod'] = $row['support_cod'];
			$modules[$i]['shipping_order'] = $row['shipping_order'];
			$modules[$i]['install'] = 1;
			if (isset($modules[$i]['insure']) && ($modules[$i]['insure'] === false)) {
				$modules[$i]['is_insure'] = 0;
			}
			else {
				$modules[$i]['is_insure'] = 1;
			}
		}
		else {
			$modules[$i]['name'] = $_LANG[$modules[$i]['code']];
			$modules[$i]['desc'] = $_LANG[$modules[$i]['desc']];
			$modules[$i]['insure_fee'] = empty($modules[$i]['insure']) ? 0 : $modules[$i]['insure'];
			$modules[$i]['cod'] = $modules[$i]['cod'];
			$modules[$i]['install'] = 0;
		}
	}

	if (!$seller_shopinfo && $adminru['ru_id']) {
		$modules = array();
	}

	$smarty->assign('current', 'shipping');
	$smarty->assign('ru_id', $adminru['ru_id']);
	$smarty->assign('seller_shopinfo', $seller_shopinfo);
	$smarty->assign('ur_here', $_LANG['03_shipping_list']);
	$smarty->assign('modules', $modules);
	assign_query_info();
	$smarty->display('shipping_list.dwt');
}
else if ($_REQUEST['act'] == 'date_list') {
	admin_priv('shipping_date_list');
	$smarty->assign('ur_here', '配送时间列表');
	$smarty->assign('action_link', array('href' => 'shipping.php?act=date_add', 'text' => '添加配送时间'));
	$shipping_date = shipping_date_list();
	$smarty->assign('shipping_date', $shipping_date);
	$smarty->assign('current', 'shipping');
	assign_query_info();
	$smarty->display('shipping_date_list.dwt');
}
else if ($_REQUEST['act'] == 'date_add') {
	admin_priv('shipping_date_message');
	$smarty->assign('ur_here', '添加配送时间');
	$smarty->assign('action_link', array('href' => 'shipping.php?act=date_list', 'text' => '配送时间列表'));
	$smarty->assign('act', 'date_insert');
	assign_query_info();
	$smarty->assign('current', 'shipping');
	$smarty->display('shipping_date_info.dwt');
}
else if ($_REQUEST['act'] == 'date_insert') {
	admin_priv('shipping_date_message');
	$shipping_date_start = (empty($_POST['shipping_date_start']) ? '0:00' : $_POST['shipping_date_start']);
	$shipping_date_end = (empty($_POST['shipping_date_end']) ? '0:00' : $_POST['shipping_date_end']);
	$later_day = (empty($_POST['later_day']) ? '0' : $_POST['later_day']);
	$sql = 'INSERT INTO ' . $ecs->table('shipping_date') . '(start_date, end_date, select_day)VALUES(\'' . $shipping_date_start . '\', \'' . $shipping_date_end . '\', ' . $later_day . ')';
	$db->query($sql);
	$id = $db->insert_id();

	if (!empty($id)) {
		$link[0]['text'] = '返回继续添加';
		$link[0]['href'] = 'shipping.php?act=date_add';
		$link[1]['text'] = '配送时间列表页';
		$link[1]['href'] = 'shipping.php?act=date_list';
		sys_msg('添加成功', 0, $link);
	}
	else {
		$link[0]['text'] = '返回重新添加';
		$link[0]['href'] = 'javascript:history.back(-1)';
		$link[1]['text'] = '配送时间列表页';
		$link[1]['href'] = 'shipping.php?act=date_list';
		sys_msg('添加成功', 0, $link);
	}
}
else if ($_REQUEST['act'] == 'date_edit') {
	admin_priv('shipping_date_message');
	$shipping_id = (empty($_REQUEST['sid']) ? '0' : $_REQUEST['sid']);

	if (empty($shipping_id)) {
		ecs_header("location: shipping.php?act=date_list\n");
		exit();
	}

	$sql = 'SELECT * FROM ' . $ecs->table('shipping_date') . ' WHERE shipping_date_id=\'' . $shipping_id . '\'';
	$shipping_date = $db->getRow($sql);
	$smarty->assign('ur_here', '编辑配送时间');
	$smarty->assign('action_link', array('href' => 'shipping.php?act=date_list', 'text' => '配送时间列表'));
	$smarty->assign('act', 'date_update');
	$smarty->assign('id', $shipping_id);
	$smarty->assign('shipping_date', $shipping_date);
	assign_query_info();
	$smarty->assign('current', 'shipping');
	$smarty->display('shipping_date_info.dwt');
}
else if ($_REQUEST['act'] == 'date_update') {
	admin_priv('shipping_date_message');
	$shipping_date_start = (empty($_POST['shipping_date_start']) ? '0:00' : $_POST['shipping_date_start']);
	$shipping_date_end = (empty($_POST['shipping_date_end']) ? '0:00' : $_POST['shipping_date_end']);
	$later_day = (empty($_POST['later_day']) ? '0' : $_POST['later_day']);
	$shipping_id = (empty($_POST['id']) ? '0' : $_POST['id']);

	if (empty($shipping_id)) {
		ecs_header("location: shipping.php?act=date_list\n");
		exit();
	}

	$sql = 'UPDATE ' . $ecs->table('shipping_date') . ' SET start_date=\'' . $shipping_date_start . '\', end_date=\'' . $shipping_date_end . '\', select_day=\'' . $later_day . '\' WHERE shipping_date_id=\'' . $shipping_id . '\'';

	if ($db->query($sql)) {
		$link[0]['text'] = '配送时间列表页';
		$link[0]['href'] = 'shipping.php?act=date_list';
		sys_msg('编辑成功', 0, $link);
	}
	else {
		$link[0]['text'] = '返回重新编辑';
		$link[0]['href'] = 'javascript:history.back(-1)';
		$link[1]['text'] = '配送时间列表页';
		$link[1]['href'] = 'shipping.php?act=date_list';
		sys_msg('添加成功', 0, $link);
	}
}
else if ($_REQUEST['act'] == 'date_remove') {
	admin_priv('shipping_date_message');
	$shipping_id = (empty($_REQUEST['sid']) ? '0' : $_REQUEST['sid']);

	if (empty($shipping_id)) {
		ecs_header("location: shipping.php?act=date_list\n");
		exit();
	}

	$sql = 'DELETE FROM ' . $ecs->table('shipping_date') . ' WHERE shipping_date_id=\'' . $shipping_id . '\'';

	if ($db->query($sql)) {
		$link[0]['text'] = '配送时间列表页';
		$link[0]['href'] = 'shipping.php?act=date_list';
		sys_msg('删除成功', 0, $link);
	}
	else {
		$link[0]['text'] = '配送时间列表页';
		$link[0]['href'] = 'shipping.php?act=date_list';
		sys_msg('删除失败', 0, $link);
	}
}
else if ($_REQUEST['act'] == 'install') {
	admin_priv('ship_manage');
	$set_modules = true;
	include_once ROOT_PATH . 'includes/modules/shipping/' . $_GET['code'] . '.php';
	$sql = 'SELECT shipping_id FROM ' . $ecs->table('shipping') . ' WHERE shipping_code = \'' . $_GET['code'] . '\'';
	$id = $db->GetOne($sql);

	if (0 < $id) {
		$db->query('UPDATE ' . $ecs->table('shipping') . ' SET enabled = 1 WHERE shipping_code = \'' . $_GET['code'] . '\' LIMIT 1');
	}
	else {
		$insure = (empty($modules[0]['insure']) ? 0 : $modules[0]['insure']);
		$sql = 'INSERT INTO ' . $ecs->table('shipping') . ' (' . 'shipping_code, shipping_name, shipping_desc, insure, support_cod, enabled, print_bg, config_lable, print_model' . ') VALUES (' . '\'' . addslashes($modules[0]['code']) . '\', \'' . addslashes($_LANG[$modules[0]['code']]) . '\', \'' . addslashes($_LANG[$modules[0]['desc']]) . '\', \'' . $insure . '\', \'' . intval($modules[0]['cod']) . '\', 1, \'' . addslashes($modules[0]['print_bg']) . '\', \'' . addslashes($modules[0]['config_lable']) . '\', \'' . $modules[0]['print_model'] . '\')';
		$db->query($sql);
		$id = $db->insert_Id();
	}

	admin_log(addslashes($_LANG[$modules[0]['code']]), 'install', 'shipping');
	$lnk[] = array('text' => $_LANG['add_shipping_area'], 'href' => 'shipping_area.php?act=add&shipping=' . $id);
	$lnk[] = array('text' => $_LANG['go_back'], 'href' => 'shipping.php?act=list');
	sys_msg(sprintf($_LANG['install_succeess'], $_LANG[$modules[0]['code']]), 0, $lnk);
}
else if ($_REQUEST['act'] == 'uninstall') {
	global $ecs;
	global $_LANG;
	admin_priv('ship_manage');
	$row = $db->GetRow('SELECT shipping_id, shipping_name, print_bg FROM ' . $ecs->table('shipping') . ' WHERE shipping_code=\'' . $_GET['code'] . '\'');
	$shipping_id = $row['shipping_id'];
	$shipping_name = $row['shipping_name'];

	if ($row) {
		$all = $db->getCol('SELECT shipping_area_id FROM ' . $ecs->table('shipping_area') . ' WHERE shipping_id=\'' . $shipping_id . '\'');
		$in = db_create_in(join(',', $all));
		$db->query('DELETE FROM ' . $ecs->table('area_region') . ' WHERE shipping_area_id ' . $in);
		$db->query('DELETE FROM ' . $ecs->table('shipping_area') . ' WHERE shipping_id=\'' . $shipping_id . '\'');
		$db->query('DELETE FROM ' . $ecs->table('shipping') . ' WHERE shipping_id=\'' . $shipping_id . '\'');
		if (($row['print_bg'] != '') && !is_print_bg_default($row['print_bg'])) {
			@unlink(ROOT_PATH . $row['print_bg']);
		}

		admin_log(addslashes($shipping_name), 'uninstall', 'shipping');
		$lnk[] = array('text' => $_LANG['go_back'], 'href' => 'shipping.php?act=list');
		sys_msg(sprintf($_LANG['uninstall_success'], $shipping_name), 0, $lnk);
	}
}
else if ($_REQUEST['act'] == 'print_index') {
	admin_priv('ship_manage');
	$shipping_id = (!empty($_GET['shipping']) ? intval($_GET['shipping']) : 0);
	$sql = 'SELECT * FROM ' . $ecs->table('shipping') . ' WHERE shipping_id = \'' . $shipping_id . '\' LIMIT 0,1';
	$row = $db->GetRow($sql);

	if ($row) {
		$sql = 'SELECT * FROM ' . $ecs->table('shipping_tpl') . ' WHERE shipping_id=\'' . $shipping_id . '\' and ru_id=\'' . $adminru['ru_id'] . '\'';
		$ship_tpl = $db->GetRow($sql);
		$ship_tpl['shipping_print'] = !empty($ship_tpl['shipping_print']) ? $ship_tpl['shipping_print'] : '';
		$ship_tpl['print_bg'] = empty($ship_tpl['print_bg']) ? '' : get_site_root_url() . $ship_tpl['print_bg'];
	}

	$smarty->assign('shipping', $ship_tpl);
	$smarty->assign('shipping_id', $shipping_id);
	$smarty->assign('current', 'shipping');
	$smarty->display('print_index.dwt');
}
else if ($_REQUEST['act'] == 'recovery_default_template') {
	admin_priv('ship_manage');
	$shipping_id = (!empty($_POST['shipping']) ? intval($_POST['shipping']) : 0);
	$sql = 'SELECT shipping_code FROM ' . $ecs->table('shipping') . ' WHERE shipping_id = \'' . $shipping_id . '\'';
	$code = $db->GetOne($sql);
	$set_modules = true;
	include_once ROOT_PATH . 'includes/modules/shipping/' . $code . '.php';
	$db->query('UPDATE ' . $ecs->table('shipping_tpl') . ' SET print_bg = \'' . addslashes($modules[0]['print_bg']) . '\',  config_lable = \'' . addslashes($modules[0]['config_lable']) . '\' WHERE shipping_id = \'' . $shipping_id . '\' and ru_id=\'' . $adminru['ru_id'] . '\' LIMIT 1');
	$url = 'shipping.php?act=edit_print_template&shipping=' . $shipping_id;
	ecs_header('Location: ' . $url . "\n");
}
else if ($_REQUEST['act'] == 'print_upload') {
	admin_priv('ship_manage');
	$allow_suffix = array('jpg', 'png', 'jpeg');
	$shipping_id = (!empty($_POST['shipping']) ? intval($_POST['shipping']) : 0);

	if (!empty($_FILES['bg']['name'])) {
		if (!get_file_suffix($_FILES['bg']['name'], $allow_suffix)) {
			echo '<script language="javascript">';
			echo 'parent.alert("' . sprintf($_LANG['js_languages']['upload_falid'], implode('，', $allow_suffix)) . '");';
			echo '</script>';
			exit();
		}

		$name = date('Ymd');

		for ($i = 0; $i < 6; $i++) {
			$name .= chr(mt_rand(97, 122));
		}

		$name .= '.' . end(explode('.', $_FILES['bg']['name']));
		$target = ROOT_PATH . '/images/receipt/' . $name;

		if (move_upload_file($_FILES['bg']['tmp_name'], $target)) {
			$src = '/images/receipt/' . $name;
		}
	}

	$sql = 'UPDATE ' . $ecs->table('shipping_tpl') . ' SET print_bg = \'' . $src . '\' WHERE shipping_id = \'' . $shipping_id . '\' and ru_id=\'' . $adminru['ru_id'] . '\'';
	$res = $db->query($sql);

	if ($res) {
		echo '<script language="javascript">';
		echo 'parent.call_flash("bg_add", "' . get_site_root_url() . $src . '");';
		echo '</script>';
	}
}
else if ($_REQUEST['act'] == 'print_del') {
	check_authz_json('ship_manage');
	$shipping_id = (!empty($_GET['shipping']) ? intval($_GET['shipping']) : 0);
	$shipping_id = json_str_iconv($shipping_id);
	$sql = 'SELECT print_bg FROM ' . $ecs->table('shipping') . ' WHERE shipping_id = \'' . $shipping_id . '\' LIMIT 0,1';
	$row = $db->GetRow($sql);

	if ($row) {
		if (($row['print_bg'] != '') && !is_print_bg_default($row['print_bg'])) {
			@unlink(ROOT_PATH . $row['print_bg']);
		}

		$sql = 'UPDATE ' . $ecs->table('shipping_tpl') . ' SET print_bg = \'\' WHERE shipping_id = \'' . $shipping_id . '\' and ru_id=\'' . $adminru['ru_id'] . '\'';
		$res = $db->query($sql);
	}
	else {
		make_json_error($_LANG['js_languages']['upload_del_falid']);
	}

	make_json_result($shipping_id);
}
else if ($_REQUEST['act'] == 'edit_print_template') {
	admin_priv('ship_manage');
	$smarty->assign('primary_cat', $_LANG['11_system']);
	$shipping_id = (!empty($_GET['shipping']) ? intval($_GET['shipping']) : 0);
	$sql = 'SELECT * FROM ' . $ecs->table('shipping') . ' WHERE shipping_id=' . $shipping_id;
	$row = $db->GetRow($sql);

	if ($row) {
		$sql = 'SELECT * FROM ' . $ecs->table('shipping_tpl') . ' WHERE shipping_id=\'' . $shipping_id . '\' and ru_id=\'' . $adminru['ru_id'] . '\'';
		$ship_tpl = $db->GetRow($sql);

		if (!$ship_tpl) {
			$sql = 'INSERT INTO ' . $ecs->table('shipping_tpl') . ' (shipping_id, ru_id, print_bg, update_time) VALUES (\'' . $shipping_id . '\',\'' . $adminru['ru_id'] . '\',\'\',' . gmtime() . ')';
			$db->query($sql);
		}

		$ship_tpl['shipping_print'] = !empty($ship_tpl['shipping_print']) ? $ship_tpl['shipping_print'] : '';
		$ship_tpl['print_bg'] = !empty($ship_tpl['print_bg']) ? $ship_tpl['print_bg'] : '';
		$ship_tpl['print_model'] = empty($ship_tpl['print_model']) ? 1 : $ship_tpl['print_model'];
		$smarty->assign('shipping', $ship_tpl);
	}
	else {
		$lnk[] = array('text' => $_LANG['go_back'], 'href' => 'shipping.php?act=list');
		sys_msg($_LANG['no_shipping_install'], 0, $lnk);
	}

	$smarty->assign('ur_here', $_LANG['03_shipping_list'] . ' - ' . $row['shipping_name'] . ' - ' . $_LANG['shipping_print_template']);
	$smarty->assign('action_link', array('text' => $_LANG['03_shipping_list'], 'href' => 'shipping.php?act=list', 'class' => 'icon-reply'));
	$smarty->assign('shipping_id', $shipping_id);
	assign_query_info();
	$smarty->assign('current', 'shipping');
	$smarty->display('shipping_template.dwt');
}
else if ($_REQUEST['act'] == 'do_edit_print_template') {
	admin_priv('ship_manage');
	$print_model = (!empty($_POST['print_model']) ? intval($_POST['print_model']) : 0);
	$shipping_id = (!empty($_REQUEST['shipping']) ? intval($_REQUEST['shipping']) : 0);
	$_POST['config_lable'] = !empty($_POST['config_lable']) ? $_POST['config_lable'] : '';

	if ($print_model == 2) {
		$db->query('UPDATE ' . $ecs->table('shipping_tpl') . ' SET config_lable = \'' . $_POST['config_lable'] . '\', print_model = \'' . $print_model . '\' WHERE shipping_id = \'' . $shipping_id . '\' and ru_id=\'' . $adminru['ru_id'] . '\'');
	}
	else if ($print_model == 1) {
		$template = (!empty($_POST['shipping_print']) ? $_POST['shipping_print'] : '');
		$db->query('UPDATE ' . $ecs->table('shipping_tpl') . ' SET shipping_print = \'' . $template . '\', print_model = \'' . $print_model . '\' WHERE shipping_id = \'' . $shipping_id . '\' and ru_id=\'' . $adminru['ru_id'] . '\'');
	}

	admin_log(addslashes($_POST['shipping_name']), 'edit', 'shipping');
	$lnk[] = array('text' => $_LANG['go_back'], 'href' => 'shipping.php?act=list');
	sys_msg($_LANG['edit_template_success'], 0, $lnk);
}
else if ($_REQUEST['act'] == 'edit_name') {
	check_authz_json('ship_manage');
	$id = json_str_iconv(trim($_POST['id']));
	$val = json_str_iconv(trim($_POST['val']));

	if (empty($val)) {
		make_json_error($_LANG['no_shipping_name']);
	}

	if (!$exc->is_only('shipping_name', $val, $id)) {
		make_json_error($_LANG['repeat_shipping_name']);
	}

	$exc->edit('shipping_name = \'' . $val . '\'', $id);
	make_json_result(stripcslashes($val));
}
else if ($_REQUEST['act'] == 'edit_desc') {
	check_authz_json('ship_manage');
	$id = json_str_iconv(trim($_POST['id']));
	$val = json_str_iconv(trim($_POST['val']));
	$exc->edit('shipping_desc = \'' . $val . '\'', $id);
	make_json_result(stripcslashes($val));
}
else if ($_REQUEST['act'] == 'edit_insure') {
	check_authz_json('ship_manage');
	$id = json_str_iconv(trim($_POST['id']));
	$val = json_str_iconv(trim($_POST['val']));

	if (empty($val)) {
		$val = 0;
	}
	else {
		$val = make_semiangle($val);

		if (strpos($val, '%') === false) {
			$val = floatval($val);
		}
		else {
			$val = floatval($val) . '%';
		}
	}

	$set_modules = true;
	include_once ROOT_PATH . 'includes/modules/shipping/' . $id . '.php';
	if (isset($modules[0]['insure']) && ($modules[0]['insure'] === false)) {
		make_json_error($_LANG['not_support_insure']);
	}

	$exc->edit('insure = \'' . $val . '\'', $id);
	make_json_result(stripcslashes($val));
}
else if ($_REQUEST['act'] == 'shipping_priv') {
	check_authz_json('ship_manage');
	make_json_result('');
}
else if ($_REQUEST['act'] == 'edit_order') {
	check_authz_json('ship_manage');
	$code = json_str_iconv(trim($_POST['id']));
	$order = intval($_POST['val']);
	$exc->edit('shipping_order = \'' . $order . '\'', $code);
	make_json_result(stripcslashes($order));
}

?>
