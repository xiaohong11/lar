<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\modules\wechat\wlcx;

class Wlcx extends \app\http\wechat\controllers\Plugin
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
		$articles = array('type' => 'text', 'content' => '暂无物流信息');
		$uid = dao('wechat_user')->where(array('openid' => $fromusername))->getField('ect_uid');

		if (!empty($uid)) {
			$order_arr = $GLOBALS['db']->query('SELECT o.order_id, o.order_sn, o.invoice_no, o.shipping_name, o.shipping_id, o.shipping_status FROM {pre}order_info o WHERE o.user_id = \'' . $uid . '\' AND (SELECT count(*) FROM {pre}order_info oi WHERE o.order_id = oi.main_order_id ) = 0 ORDER BY o.add_time DESC LIMIT 1');

			if (!empty($order_arr)) {
				if (0 < $order_arr[0]['shipping_status']) {
					$articles = array();
					$articles['type'] = 'news';
					$articles['content'][0]['Title'] = '物流信息';
					$articles['content'][0]['Description'] = '快递公司：' . $order_arr[0]['shipping_name'] . "\r\n" . '物流单号：' . $order_arr[0]['invoice_no'];
					$articles['content'][0]['Url'] = __HOST__ . url('user/order/order_tracking', array('order_id' => $order_arr[0]['order_id']));
				}
			}

			$this->updatePoint($fromusername, $info);
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
