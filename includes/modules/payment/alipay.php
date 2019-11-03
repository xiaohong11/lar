<?php

class alipay
{
	public function __construct()
	{
		$this->alipay();
	}

	public function alipay()
	{
	}

	public function get_code($order, $payment)
	{
		if (!defined('EC_CHARSET')) {
			$charset = 'utf-8';
		}
		else {
			$charset = EC_CHARSET;
		}

		$real_method = $payment['alipay_pay_method'];

		switch ($real_method) {
		case '0':
			$service = 'trade_create_by_buyer';
			break;

		case '1':
			$service = 'create_partner_trade_by_buyer';
			break;

		case '2':
			$service = 'create_direct_pay_by_user';
			break;
		}

		$extend_param = 'isv^sh22';
		$parameter = array('extend_param' => $extend_param, 'service' => $service, 'partner' => $payment['alipay_partner'], '_input_charset' => $charset, 'notify_url' => notify_url(basename(__FILE__, '.php')), 'return_url' => return_url(basename(__FILE__, '.php')), 'subject' => $order['order_sn'], 'out_trade_no' => $order['order_sn'] . $order['log_id'], 'price' => $order['order_amount'], 'quantity' => 1, 'payment_type' => 1, 'logistics_type' => 'EXPRESS', 'logistics_fee' => 0, 'logistics_payment' => 'BUYER_PAY_AFTER_RECEIVE', 'seller_email' => $payment['alipay_account']);
		ksort($parameter);
		reset($parameter);
		$param = '';
		$sign = '';

		foreach ($parameter as $key => $val) {
			$param .= $key . '=' . urlencode($val) . '&';
			$sign .= $key . '=' . $val . '&';
		}

		$param = substr($param, 0, -1);
		$sign = substr($sign, 0, -1) . $payment['alipay_key'];
		$button = '<div class="alipay" style="text-align:center"><input type="button" onclick="window.open(\'https://mapi.alipay.com/gateway.do?' . $param . '&sign=' . md5($sign) . '&sign_type=MD5\')" value="' . $GLOBALS['_LANG']['pay_button'] . '" /></div>';
		return $button;
	}

	public function respond()
	{
		if (!empty($_POST)) {
			foreach ($_POST as $key => $data) {
				$_GET[$key] = $data;
			}
		}

		$payment = get_payment($_GET['code']);
		$seller_email = rawurldecode($_GET['seller_email']);
		$_GET['subject'] = isset($_GET['subject']) && !empty($_GET['subject']) ? addslashes_deep($_GET['subject']) : '';
		$_GET['out_trade_no'] = isset($_GET['out_trade_no']) && !empty($_GET['out_trade_no']) ? addslashes_deep($_GET['out_trade_no']) : '';
		$order_sn = str_replace($_GET['subject'], '', $_GET['out_trade_no']);
		$order_sn = trim(addslashes($order_sn));
		ksort($_GET);
		reset($_GET);
		$sign = '';

		foreach ($_GET as $key => $val) {
			if (($key != 'sign') && ($key != 'sign_type') && ($key != 'code')) {
				$sign .= $key . '=' . $val . '&';
			}
		}

		$sign = substr($sign, 0, -1) . $payment['alipay_key'];

		if (md5($sign) != $_GET['sign']) {
			return false;
		}

		if (!check_money($order_sn, $_GET['total_fee'])) {
			return false;
		}

		if ($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
			order_paid($order_sn, 2);
			return true;
		}
		else if ($_GET['trade_status'] == 'TRADE_FINISHED') {
			order_paid($order_sn);
			return true;
		}
		else if ($_GET['trade_status'] == 'TRADE_SUCCESS') {
			order_paid($order_sn, 2);
			return true;
		}
		else {
			return false;
		}
	}

	public function notify()
	{
		if (!empty($_POST)) {
			foreach ($_POST as $key => $data) {
				$_GET[$key] = $data;
			}
		}

		$payment = get_payment($_GET['code']);
		$seller_email = rawurldecode($_GET['seller_email']);
		$_GET['subject'] = isset($_GET['subject']) && !empty($_GET['subject']) ? addslashes_deep($_GET['subject']) : '';
		$_GET['out_trade_no'] = isset($_GET['out_trade_no']) && !empty($_GET['out_trade_no']) ? addslashes_deep($_GET['out_trade_no']) : '';
		$order_sn = str_replace($_GET['subject'], '', $_GET['out_trade_no']);
		$order_sn = trim(addslashes($order_sn));
		$sign = $this->getSignVeryfy($_GET);
		$sign = $this->md5Sign($sign, $payment['alipay_key']);

		if ($sign != $_GET['sign']) {
			return false;
		}

		if (!check_money($order_sn, $_GET['total_fee'])) {
			return false;
		}

		if ($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
			order_paid($order_sn, 2);
			return true;
		}
		else if ($_GET['trade_status'] == 'TRADE_FINISHED') {
			order_paid($order_sn);
			return true;
		}
		else if ($_GET['trade_status'] == 'TRADE_SUCCESS') {
			order_paid($order_sn, 2);
			return true;
		}
		else {
			return false;
		}
	}

	public function getSignVeryfy($para_temp)
	{
		$para_filter = $this->paraFilter($para_temp);
		$para_sort = $this->argSort($para_filter);
		$prestr = $this->createLinkstring($para_sort);
		return $prestr;
	}

	public function paraFilter($para)
	{
		$para_filter = array();

		while (list($key, $val) = each($para)) {
			if (($key == 'sign') || ($key == 'sign_type') || ($val == '')) {
				continue;
			}
			else {
				$para_filter[$key] = $para[$key];
			}
		}

		return $para_filter;
	}

	public function createLinkstring($para)
	{
		$arg = '';

		while (list($key, $val) = each($para)) {
			if (($key != 'sign') && ($key != 'sign_type') && ($key != 'code')) {
				$arg .= $key . '=' . $val . '&';
			}
		}

		$arg = substr($arg, 0, count($arg) - 2);

		if (get_magic_quotes_gpc()) {
			$arg = stripslashes($arg);
		}

		return $arg;
	}

	public function argSort($para)
	{
		ksort($para);
		reset($para);
		return $para;
	}

	public function md5Sign($prestr, $key)
	{
		$prestr = $prestr . $key;
		return md5($prestr);
	}
}

if (!defined('IN_ECS')) {
	exit('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' . $GLOBALS['_CFG']['lang'] . '/payment/alipay.php';

if (file_exists($payment_lang)) {
	global $_LANG;
	include_once $payment_lang;
}

if (isset($set_modules) && ($set_modules == true)) {
	$i = (isset($modules) ? count($modules) : 0);
	$modules[$i]['code'] = basename(__FILE__, '.php');
	$modules[$i]['desc'] = 'alipay_desc';
	$modules[$i]['is_cod'] = '0';
	$modules[$i]['is_online'] = '1';
	$modules[$i]['author'] = 'ECMOBAN TEAM';
	$modules[$i]['website'] = 'http://www.alipay.com';
	$modules[$i]['version'] = '1.0.2';
	$modules[$i]['config'] = array(
	array('name' => 'alipay_account', 'type' => 'text', 'value' => ''),
	array('name' => 'alipay_key', 'type' => 'text', 'value' => ''),
	array('name' => 'alipay_partner', 'type' => 'text', 'value' => ''),
	array('name' => 'alipay_pay_method', 'type' => 'select', 'value' => '')
	);
	return NULL;
}

?>
