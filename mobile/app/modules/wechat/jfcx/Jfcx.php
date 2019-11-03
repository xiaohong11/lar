<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\modules\wechat\jfcx;

class Jfcx extends \app\http\wechat\controllers\Plugin
{
	protected $plugin_name = '';
	protected $cfg = array();

	public function __construct($cfg = array())
	{
		parent::__construct();
		$this->plugin_name = strtolower(basename(__FILE__, '.php'));
		$this->cfg = $cfg;
	}

	public function install()
	{
		$this->plugin_display('install', $this->cfg);
	}

	public function returnData($fromusername, $info)
	{
		$articles = array('type' => 'text', 'content' => '暂无积分信息');
		$uid = dao('wechat_user')->where(array('openid' => $fromusername))->getField('ect_uid');

		if (!empty($uid)) {
			$data = dao('users')->field('rank_points, pay_points, user_money')->where(array('user_id' => $uid))->find();

			if (!empty($data)) {
				$data['user_money'] = strip_tags(price_format($data['user_money'], false));
				$articles['content'] = '余额：' . $data['user_money'] . "\r\n" . ' 等级积分：' . $data['rank_points'] . "\r\n" . ' 消费积分：' . $data['pay_points'];
				$this->updatePoint($fromusername, $info);
			}
		}

		return $articles;
	}

	public function updatePoint($fromusername, $info)
	{
		if (!empty($info)) {
			$config = array();
			$config = unserialize($info['config']);
			if (isset($config['point_status']) && ($config['point_status'] == 1)) {
				$where = 'openid = "' . $fromusername . '" and keywords = "' . $info['command'] . '" and createtime > (UNIX_TIMESTAMP(NOW())- ' . $config['point_interval'] . ')';
				$sql = 'SELECT count(*) as num FROM {pre}wechat_point WHERE ' . $where . 'ORDER BY createtime DESC';
				$num = $GLOBALS['db']->query($sql);

				if ($num[0]['num'] < $config['point_num']) {
					$this->do_point($fromusername, $info, $config['point_value']);
				}
			}
		}
	}

	public function executeAction()
	{
	}
}

?>
