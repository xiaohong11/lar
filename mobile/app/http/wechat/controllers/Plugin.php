<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
namespace app\http\wechat\controllers;

abstract class Plugin extends \app\http\base\controllers\Foundation
{
	protected $_data = array();

	abstract protected function returnData($fromusername, $info);

	abstract protected function updatePoint($fromusername, $info);

	abstract protected function executeAction();

	public function do_point($fromusername, $info, $rank_points = 0, $pay_points = 0)
	{
		$time = gmtime();
		$user_id = dao('wechat_user')->where(array('openid' => $fromusername))->getField('ect_uid');

		if ($user_id) {
			$sql = 'UPDATE {pre}users SET rank_points = rank_points + ' . intval($rank_points) . ' WHERE user_id = ' . $user_id;
			$GLOBALS['db']->query($sql);
			$sql = 'UPDATE {pre}users SET pay_points = pay_points + ' . intval($pay_points) . ' WHERE user_id = ' . $user_id;
			$GLOBALS['db']->query($sql);
			$data['user_id'] = $user_id;
			$data['user_money'] = 0;
			$data['frozen_money'] = 0;
			$data['rank_points'] = intval($rank_points);
			$data['pay_points'] = intval($pay_points);
			$data['change_time'] = $time;
			$data['change_desc'] = $info['name'] . '积分赠送';
			$data['change_type'] = ACT_OTHER;
			$log_id = dao('account_log')->data($data)->add();
			$data1['log_id'] = $log_id;
			$data1['openid'] = $fromusername;
			$data1['keywords'] = $info['command'];
			$data1['createtime'] = $time;
			$log_id = dao('wechat_point')->data($data1)->add();
		}
	}

	public function do_takeout_point($fromusername, $info, $point_value)
	{
		$time = gmtime();
		$user_id = dao('wechat_user')->where(array('openid' => $fromusername))->getField('ect_uid');

		if ($user_id) {
			$usable_points = dao('users')->where(array('user_id' => $user_id))->getField('pay_points');

			if (intval($point_value) <= intval($usable_points)) {
				$sql = 'UPDATE {pre}users SET pay_points = pay_points - ' . intval($point_value) . ' WHERE user_id = ' . $user_id;
				$GLOBALS['db']->query($sql);
				$data['user_id'] = $user_id;
				$data['user_money'] = 0;
				$data['frozen_money'] = 0;
				$data['rank_points'] = 0;
				$data['pay_points'] = $point_value;
				$data['change_time'] = $time;
				$data['change_desc'] = $info['name'] . '积分扣除';
				$data['change_type'] = ACT_OTHER;
				$log_id = dao('account_log')->data($data)->add();
				$data1['log_id'] = $log_id;
				$data1['openid'] = $fromusername;
				$data1['keywords'] = $info['command'];
				$data1['createtime'] = $time;
				$log_id = dao('wechat_point')->data($data1)->add();
				return true;
			}
			else {
				return false;
			}
		}
	}

	public function plugin_display($tpl = '', $config = array())
	{
		L(require MODULE_PATH . 'language/' . C('shop.lang') . '/wechat.php');
		$this->_data['lang'] = array_change_key_case(L());
		$this->_data['config'] = $config;
		$this->assign($this->_data);

		if (0 < $_SESSION['seller_id']) {
			$tpl = 'app/modules/wechatseller/' . $this->plugin_name . '/views/' . $tpl . C('TMPL_TEMPLATE_SUFFIX');
		}
		else {
			$tpl = 'app/modules/wechat/' . $this->plugin_name . '/views/' . $tpl . C('TMPL_TEMPLATE_SUFFIX');
		}

		$this->template_content = $this->fetch(ROOT_PATH . $tpl);
		$this->assign('template_content', $this->template_content);
		$this->display('wechat@wechat.layout');
	}

	public function get_rand($proArr)
	{
		$result = '';
		$proSum = array_sum($proArr);

		foreach ($proArr as $key => $proCur) {
			$randNum = mt_rand(1, $proSum);

			if ($randNum <= $proCur) {
				$result = $key;
				break;
			}
			else {
				$proSum -= $proCur;
			}
		}

		unset($proArr);
		return $result;
	}

	public function __get($name)
	{
		return isset($this->_data[$name]) ? $this->_data[$name] : null;
	}

	public function __set($name, $value)
	{
		$this->_data[$name] = $value;
	}
}

?>
