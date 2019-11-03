<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\modules\wechat\ddcx;

class Ddcx extends \app\http\wechat\controllers\Plugin
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
		$this->load_helper(array('order'));
		$articles = array('type' => 'text', 'content' => '暂无订单信息');
		$uid = dao('wechat_user')->where(array('openid' => $fromusername))->getField('ect_uid');

		if (!empty($uid)) {
			$order_id_arr = $GLOBALS['db']->query('SELECT o.order_id FROM {pre}order_info o WHERE o.user_id = \'' . $uid . '\' AND (SELECT count(*) FROM {pre}order_info oi WHERE o.order_id = oi.main_order_id ) = 0 ORDER BY o.add_time DESC');
			if (isset($order_id_arr[0]) && !empty($order_id_arr[0]['order_id'])) {
				$order_id = $order_id_arr[0]['order_id'];
				$order = order_info($order_id);
				$order_goods = order_goods($order_id);
				$goods = '';

				if (!empty($order_goods)) {
					foreach ($order_goods as $key => $val) {
						if ($key == 0) {
							$goods .= $val['goods_name'] . '(' . $val['goods_attr'] . ')(' . $val['goods_number'] . ')';
						}
					}
				}

				if (file_exists(LANG_PATH . C('shop.lang') . '/user.php')) {
					L(require LANG_PATH . C('shop.lang') . '/user.php');
				}

				$os = L('os');
				$ps = L('ps');
				$ss = L('ss');
				$order['order_status'] = $os[$order['order_status']];
				$order['pay_status'] = $ps[$order['pay_status']];
				$order['shipping_status'] = $ss[$order['shipping_status']];
				$articles = array();
				$articles['type'] = 'news';
				$articles['content'][0]['Title'] = '订单号：' . $order['order_sn'];
				$articles['content'][0]['Description'] = '商品信息：' . $goods . "\r\n" . '总金额：' . $order['total_fee'] . "\r\n" . '支付状态：' . $order['order_status'] . $order['pay_status'] . $order['shipping_status'] . "\r\n" . '快递公司：' . $order['shipping_name'] . "\r\n" . '物流单号：' . $order['invoice_no'];
				$articles['content'][0]['Url'] = __HOST__ . url('user/order/detail', array('order_id' => $order['order_id']));
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
