<?php
//Դ��������:ecshop2012���� δ�������ֹ���� һ������ֹͣ�κη���
function get_admin_ru_id_seller()
{
	$self = explode('/', substr(PHP_SELF, 1));
	$count = count($self);

	if (1 < $count) {
		$real_path = $self[$count - 2];

		if ($real_path == 'mobile') {
			$admin_id = $_SESSION['seller_id'];
		}

		if (isset($admin_id)) {
			$sql = 'select ru_id from ' . $GLOBALS['ecs']->table('admin_user') . ' where user_id = \'' . $admin_id . '\'';
			return $GLOBALS['db']->getRow($sql);
		}
	}
}

function set_seller_menu()
{
	define('IN_ECS', true);
	define('MOBILE_WECHAT', ROOT_PATH . 'app/http/wechat');
	include_once dirname(ROOT_PATH) . '/seller/' . 'includes/inc_priv.php';
	include_once dirname(ROOT_PATH) . '/seller/' . 'includes/inc_menu.php';
	require dirname(ROOT_PATH) . '/' . 'languages/' . C('shop.lang') . '/admin/common_merchants.php';

	foreach ($modules as $key => $value) {
		ksort($modules[$key]);
	}

	ksort($modules);
	$action_list = explode(',', $_SESSION['seller_action_list']);
	$action_menu = array();

	foreach ($purview as $key => $val) {
		if (is_array($val)) {
			foreach ($val as $k => $v) {
				if (in_array($v, $action_list)) {
					$action_menu[$key] = $v;
				}
			}
		}
		else if (in_array($val, $action_list)) {
			$action_menu[$key] = $val;
		}
	}

	foreach ($modules as $key => $val) {
		foreach ($val as $k => $v) {
			if (!array_key_exists($k, $action_menu)) {
				unset($modules[$key][$k]);
			}
		}

		if (empty($modules[$key])) {
			unset($modules[$key]);
		}
	}

	$menu = array();
	$i = 0;

	foreach ($modules as $key => $val) {
		if ($key == '22_wechat') {
			$menu[$i] = array(
	'action'   => $key,
	'label'    => get_menu_url(reset($val), $_LANG[$key]),
	'url'      => get_wechat_menu_url(reset($val)),
	'children' => array()
	);

			foreach ($val as $k => $v) {
				$menu[$i]['children'][] = array('action' => $k, 'label' => get_menu_url($v, $_LANG[$k]), 'url' => get_wechat_menu_url($v), 'status' => get_user_menu_status($k));
			}
		}
		else {
			$menu[$i] = array(
	'action'   => $key,
	'label'    => get_menu_url(reset($val), $_LANG[$key]),
	'url'      => get_menu_url(reset($val)),
	'children' => array()
	);

			foreach ($val as $k => $v) {
				$menu[$i]['children'][] = array('action' => $k, 'label' => get_menu_url($v, $_LANG[$k]), 'url' => get_menu_url($v), 'status' => get_user_menu_status($k));
			}
		}

		$i++;
	}

	unset($modules);
	unset($purview);
	return $menu;
}

function get_menu_url($url = '', $name = '')
{
	if ($url) {
		$url = '../seller/' . $url;
		$url_arr = explode('?', $url);
		if (!$url_arr[0] || !is_file($url_arr[0])) {
			$url = '#';

			if ($name) {
				$name = '<span style="text-decoration: line-through; color:#ccc; ">' . $name . '</span>';
			}
		}
	}

	if ($name) {
		return $name;
	}
	else {
		return $url;
	}
}

function get_wechat_menu_url($url = '', $name = '')
{
	if ($url) {
		$url_arr = explode('?', $url);
		if (!$url_arr[0] || !is_file($url_arr[0])) {
			$url = '#';

			if ($name) {
				$name = '<span style="text-decoration: line-through; color:#ccc; ">' . $name . '</span>';
			}
		}
	}

	if ($name) {
		return $name;
	}
	else {
		return $url;
	}
}

function get_user_menu_status($action = '')
{
	$user_menu_arr = get_user_menu_list();
	if ($user_menu_arr && in_array($action, $user_menu_arr)) {
		return 1;
	}
	else {
		return 0;
	}
}

function get_user_menu_list()
{
	$adminru = get_admin_ru_id_seller();

	if (0 < $adminru['ru_id']) {
		$sql = ' SELECT user_menu FROM ' . $GLOBALS['ecs']->table('seller_shopinfo') . ' WHERE ru_id = \'' . $adminru['ru_id'] . '\' ';
		$user_menu_str = $GLOBALS['db']->getOne($sql);

		if ($user_menu_str) {
			$user_menu_arr = explode(',', $user_menu_str);
			return $user_menu_arr;
		}
	}

	return false;
}

function get_select_menu()
{
	$left_menu = array(
		'22_wechat' => array('01_wechat_admin' => 'm=wechat&c=seller&a=modify', '02_mass_message' => 'm=wechat&c=seller&a=mass_message', '02_mass_message_01' => 'm=wechat&c=seller&a=mass_list', '03_auto_reply' => 'm=wechat&c=seller&a=reply_subscribe', '03_auto_reply_01' => 'm=wechat&c=seller&a=reply_msg', '03_auto_reply_02' => 'm=wechat&c=seller&a=reply_keywords', '04_menu' => 'm=wechat&c=seller&a=menu_list', '04_menu_01' => 'm=wechat&c=seller&a=menu_edit', '05_fans' => 'm=wechat&c=seller&a=subscribe_list', '05_fans_01' => 'm=wechat&c=seller&a=custom_message_list', '05_fans_02' => 'm=wechat&c=seller&a=subscribe_search', '06_media' => 'm=wechat&c=seller&a=article', '06_media_01' => 'm=wechat&c=seller&a=article_edit', '06_media_02' => 'm=wechat&c=seller&a=article_edit_news', '06_media_03' => 'm=wechat&c=seller&a=picture', '06_media_04' => 'm=wechat&c=seller&a=voice', '06_media_05' => 'm=wechat&c=seller&a=video', '06_media_06' => 'm=wechat&c=seller&a=video_edit', '07_qrcode' => 'm=wechat&c=seller&a=qrcode_list', '07_qrcode_01' => 'm=wechat&c=seller&a=qrcode_edit', '09_extend' => 'm=wechat&c=sellerextend&a=index')
		);
	$url = (isset($_SERVER['QUERY_STRING']) ? trim($_SERVER['QUERY_STRING']) : '');
	$sellerextend = strstr($url, 'sellerextend');

	if ($sellerextend) {
		$url = 'm=wechat&c=sellerextend&a=index';
	}
	else {
		$info = get_url_query($url);
		$url = match_url($url, $info['a']);
	}

	$menu_arr = get_menu_arr($url, $left_menu);
	return $menu_arr;
}

function match_url($url = '', $fuction_a = '', $prefix = 'm=wechat&c=seller&a=')
{
	$is_match = strstr($url, $fuction_a);

	if ($is_match) {
		$url = $prefix . $fuction_a;
	}

	return $url;
}

function get_menu_arr($url = '', $list = array())
{
	static $menu_arr = array();
	static $menu_key;

	foreach ($list as $key => $val) {
		if (is_array($val)) {
			$menu_key = $key;
			get_menu_arr($url, $val);
		}
		else if ($val == $url) {
			$menu_arr['action'] = $menu_key;
			$menu_arr['current'] = $key;
			$key_2 = substr($key, 0, -3);
			$menu_arr['current_2'] = $key_2;
		}
	}

	return $menu_arr;
}
/*
function get_url_query($url = '')
{
	$info = parse_url($url);

	if (isset($info['path'])) {
		parse_str($info['path'], $params);
	}
	else if (isset($info['query'])) {
		parse_str($info['query'], $params);
	}

	return $params;
}
*/
function edit_upload_image($url = '', $no_path = 'app/modules')
{
	if (strpos($url, $no_path)) {
		$prex_patch = __HOST__ . __ROOT__;
	}
	else {
		$prex_patch = __HOST__ . __STATIC__;
	}

	$prex_patch = rtrim($prex_patch, '/') . '/';
	$url = str_replace($prex_patch, '', $url);
	return $url;
}

function add_url_suffix($url = '', $vars = '')
{
	$info = parse_url($url);
	$path = (!empty($info['path']) ? $info['path'] : '');

	if (is_string($vars)) {
		parse_str($vars, $vars);
	}
	else if (!is_array($vars)) {
		$vars = array();
	}

	if (isset($info['query'])) {
		$info['query'] = htmlspecialchars_decode($info['query']);
		parse_str($info['query'], $params);
		$vars = array_merge($params, $vars);
	}

	$depr = '?';

	if (!empty($vars)) {
		$vars = http_build_query($vars);
		$path .= $depr . $vars;
	}

	$url = $info['host'] . $path;

	if (!preg_match('/^(http|https):/', $url)) {
		$url = (is_ssl() ? 'https://' : 'http://') . $url;
	}

	return strtolower($url);
}

function file_write($filename, $content = '')
{
	$fp = fopen(ROOT_PATH . 'storage/app/certs/' . $filename, 'w+');
	flock($fp, LOCK_EX);
	fwrite($fp, $content);
	flock($fp, LOCK_UN);
	fclose($fp);
}

function new_html_in($str)
{
	$str = htmlspecialchars($str);

	if (get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}

	return $str;
}

function get_status($starttime, $endtime)
{
	$nowtime = gmtime();

	if ($nowtime < $starttime) {
		$result = 0;
	}
	else {
		if (($starttime < $nowtime) && ($nowtime < $endtime)) {
			$result = 1;
		}
		else if ($endtime < $nowtime) {
			$result = 2;
		}
	}

	return $result;
}


?>
