<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
namespace app\http\wechat\controllers;

class Marketing extends \app\http\base\controllers\Backend
{
	protected $weObj = '';
	protected $wechat_id = 0;
	protected $page_num = 0;

	public function __construct()
	{
		parent::__construct();
		L(require MODULE_PATH . 'language/' . C('shop.lang') . '/wechat.php');
		$this->assign('lang', array_change_key_case(L()));
		$this->wechat_id = dao('wechat')->where(array('default_wx' => 1))->getField('id');
		$this->page_num = 10;
		$this->assign('page_num', $this->page_num);
	}

	public function actionIndex()
	{
		$markets = array(
			array('name' => L('wechat_dzp'), 'keywords' => 'dzp', 'url' => url('dzpadmin/index')),
			array('name' => L('wechat_zjd'), 'keywords' => 'zjd', 'url' => url('zjdadmin/index')),
			array('name' => L('wechat_ggk'), 'keywords' => 'ggk', 'url' => url('ggkadmin/index')),
			array('name' => L('wechat_wall'), 'keywords' => 'wall', 'url' => url('walladmin/wall_index')),
			array('name' => L('wechat_redpack'), 'keywords' => 'redpack', 'url' => url('redpackadmin/index'))
			);
		$this->assign('list', $markets);
		$this->display();
	}

	public function get_config()
	{
		$where['id'] = $this->wechat_id;
		$wechat = dao('wechat')->field('token, appid, appsecret, type, status')->where($where)->find();

		if (empty($wechat)) {
			$wechat = array();
		}

		if (empty($wechat['status'])) {
			$this->message(L('open_wechat'), url('index'), 2);
			exit();
		}

		$config = array();
		$config['token'] = $wechat['token'];
		$config['appid'] = $wechat['appid'];
		$config['appsecret'] = $wechat['appsecret'];
		$this->weObj = new \Touch\Wechat($config);
	}
}

?>
