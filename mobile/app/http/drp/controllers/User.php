<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
namespace app\http\drp\controllers;

class User extends \app\http\base\controllers\Frontend
{
	public $weObj;
	private $wechat;
	protected $user_id;
	protected $action;
	protected $back_act = '';
	private $drp;

	public function __construct()
	{
		parent::__construct();
		$this->user_id = $_SESSION['user_id'];
		$this->action = ACTION_NAME;
		$this->con = CONTROLLER_NAME;
		$this->app = MODULE_NAME;
		if (($this->app == 'drp') && ($this->con == 'user') && ($this->action == 'index')) {
		}
		else if ($this->app == 'drp') {
			$filter = 1;
			$this->assign('filter', $filter);
		}

		$this->checkLogin();
		$this->drp = get_drp($this->user_id);
		$this->transfer_goods();
		$info = get_user_default($this->user_id);
		$this->assign('drp', $this->drp);
		$this->assign('custom', C(custom));
		$this->assign('customs', C(customs));
		$this->custom = C(custom);
		$this->assign('info', $info);
		$this->cat_id = I('request.id', 0, 'intval');
		$this->keywords = I('request.keyword');
	}

	private function checkLogin()
	{
		if (!$this->user_id) {
			$url = urlencode(__HOST__ . $_SERVER['REQUEST_URI']);

			if (IS_POST) {
				$url = urlencode($_SERVER['HTTP_REFERER']);
			}

			ecs_header('Location: ' . url('user/login/index', array('back_act' => $url)));
			exit();
		}

		$drp_audit_status = drp_audit_status($this->user_id);

		if (!$drp_audit_status) {
			show_message('请等待管理员审核 ', '返回首页', url('/'), 'warning');
		}
	}

	public function actionTransferred()
	{
		if (IS_POST) {
			$amount = (isset($_POST['amount']) ? floatval($_POST['amount']) : 0);

			if ($amount < $this->drp['draw_money_value']) {
				show_message(L('amount_gt_zero'), L('back_page_up'), '', 'warning');
			}
			else if ($amount <= $this->drp['shop_money']) {
				$info = sprintf(L('transferred_to_balance'), $this->drp['username'], $amount, 0);
				drp_log_account_change($this->user_id, 0 - $amount, 0, 0, 0, $info, ACT_TRANSFERRED);
				show_message(L('drp_money_submit'), L('back_drp_center'), url('index'), 'success');
			}
			else {
				show_message(L('transferred_error'), L('back_drp_center'), '', 'warning');
			}
		}
		else {
			$this->assign('draw_money_format', price_format($this->drp['draw_money_value'], false));
			$this->assign('draw_money_value', $this->drp['draw_money_value']);
			$this->assign('shop_money', $this->drp['shop_money']);
			$this->assign('surplus_amount', price_format($this->drp['shop_money'], false));
			$this->assign('page_title', L('transferred_title'));
			$this->display();
		}
	}

	public function actionIndex()
	{
		$sql = 'SELECT shop_money FROM ' . $GLOBALS['ecs']->table('drp_shop') . ' WHERE user_id = \'' . $this->user_id . '\'';
		$surplus_amount = $GLOBALS['db']->getOne($sql);
		$totals = $this->get_drp_money(0);
		$today_total = $this->get_drp_money(1);
		$total_amount = $this->get_drp_money(2);
		$this->assign('surplus_amount', $surplus_amount);
		$this->assign('draw_money_value', $this->drp['draw_money_value']);
		$this->assign('select_url', url('drp/index/category'));
		$this->assign('url', url('drp/shop/index', array('id' => $this->drp['drp_id'], 'u' => $_SESSION['user_id'])));
		$sql = 'SELECT value FROM {pre}drp_config WHERE code=\'withdraw\'';
		$withdraw = $this->db->getOne($sql);
		$this->assign('withdraw', $this->htmlOut($withdraw));
		$this->assign('totals', $totals[0]['totals'] ? $totals[0]['totals'] : 0);
		$this->assign('today_total', $today_total[0]['totals'] ? $today_total[0]['totals'] : 0);
		$this->assign('total_amount', $total_amount[0]['totals'] ? $total_amount[0]['totals'] : 0);
		$this->assign('page_title', $this->custom . '中心');
		$drp_affiliate = get_drp_affiliate_config();
		$this->assign('day', $drp_affiliate['config']['day']);
		$category = $this->get_drp_goods(1);
		$type = drp_type($_SESSION['user_id']);
		$goodsid = drp_type_goods($this->user_id, $type);

		foreach ($goodsid as $key => $vo) {
			$goodsid[$key] = $vo['goods_id'];
		}

		foreach ($category as $k => $v) {
			if (in_array($v['goods_id'], $goodsid)) {
				$category[$k]['is_drp'] = 1;
			}
			else {
				$category[$k]['is_drp'] = 0;
			}

			$category[$k]['type'] = $type;
		}

		$type = drp_type($_SESSION['user_id']);
		$this->assign('category', array_slice($category, 0, 5));
		$this->assign('uid', $this->user_id);
		$this->assign('type', $type);
		$this->display();
	}

	private function get_drp_money($type)
	{
		if ($type === 0) {
			$where = '';
		}
		else if ($type === 1) {
			$where = ' AND time >= ' . mktime(0, 0, 0);
		}
		else {
			$sql = 'SELECT sum(goods_price) as totals FROM ' . $GLOBALS['ecs']->table('order_goods') . ' o' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('drp_affiliate_log') . ' a ON o.order_id = a.order_id' . ' WHERE a.separate_type != -1 and a.user_id = ' . $_SESSION['user_id'];
			return $GLOBALS['db']->query($sql);
		}

		$sql = 'SELECT sum(money) as totals FROM ' . $GLOBALS['ecs']->table('drp_affiliate_log') . ' WHERE separate_type != -1 AND user_id = ' . $_SESSION['user_id'] . $where;
		return $GLOBALS['db']->query($sql);
	}

	private function doinsertlog()
	{
		$sql = 'SELECT order_id FROM ' . $GLOBALS['ecs']->table('drp_log') . ' ORDER BY log_id DESC';
		$last_oid = $GLOBALS['db']->getOne($sql);
		$last_oid = ($last_oid ? $last_oid : 0);
		$sqladd = '';
		$sqladd .= ' AND (select count(*) from ' . $GLOBALS['ecs']->table('order_info') . ' as oi2 where oi2.main_order_id = o.order_id) = 0 ';
		$sqladd .= ' AND (select sum(drp_money) from ' . $GLOBALS['ecs']->table('order_goods') . ' as og2 where og2.order_id = o.order_id) > 0 ';
		$sql = 'SELECT o.order_id FROM {pre}order_info  ' . ' o' . ' LEFT JOIN' . $GLOBALS['ecs']->table('users') . ' u ON o.user_id = u.user_id' . ' WHERE o.user_id > 0 AND (u.parent_id > 0 AND o.drp_is_separate = 0 OR o.drp_is_separate > 0) AND o.pay_status = ' . PS_PAYED . ' ' . $sqladd . ' ' . ' and o.order_id > ' . $last_oid;
		$up_oid = $GLOBALS['db']->getAll($sql);
		$drp_affiliate = get_drp_affiliate_config();

		if (empty($row['drp_is_separate'])) {
			if ($row['dis_commission']) {
				$drp_affiliate['config']['level_point_all'] = (double) $drp_affiliate['config']['level_point_all'];
				$drp_affiliate['config']['level_money_all'] = (double) $row['dis_commission'];
			}
			else {
				$drp_affiliate['config']['level_point_all'] = (double) $drp_affiliate['config']['level_point_all'];
				$drp_affiliate['config']['level_money_all'] = (double) $drp_affiliate['config']['level_money_all'];
			}

			if ($drp_affiliate['config']['level_point_all']) {
				$drp_affiliate['config']['level_point_all'] /= 100;
			}

			if ($drp_affiliate['config']['level_money_all']) {
				$drp_affiliate['config']['level_money_all'] /= 100;
			}

			if ($up_oid) {
				foreach ($up_oid as $kk => $vv) {
					$sql = "SELECT o.order_sn, o.drp_is_separate, o.user_id, SUM(og.drp_money) as drp_money\r\n                    FROM " . $GLOBALS['ecs']->table('order_info') . ' o' . ' RIGHT JOIN' . $GLOBALS['ecs']->table('order_goods') . ' og ON o.order_id = og.order_id' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('users') . ' u ON o.user_id = u.user_id' . ' WHERE o.order_id = \'' . $vv['order_id'] . '\' ';
					$row = $GLOBALS['db']->getRow($sql);
					$is = $row['drp_is_separate'];
					$money = $row['drp_money'];
					$integral = integral_to_give(array('order_id' => $vv['order_id'], 'extension_code' => ''));
					$point = round($drp_affiliate['config']['level_point_all'] * intval($integral['rank_points']), 0);
					$num = count($drp_affiliate['item']);

					for ($i = 0; $i < $num; $i++) {
						$drp_affiliate['item'][$i]['level_point'] = (double) $drp_affiliate['item'][$i]['level_point'];
						$drp_affiliate['item'][$i]['level_money'] = (double) $drp_affiliate['item'][$i]['level_money'];

						if ($drp_affiliate['item'][$i]['level_point']) {
							$perp = $drp_affiliate['item'][$i]['level_point'] / 100;
						}

						if ($drp_affiliate['item'][$i]['level_money']) {
							$per = $drp_affiliate['item'][$i]['level_money'] / 100;
						}
						else {
							break;
						}

						$setmoney = round($money * $per, 2);
						$setpoint = round($point * $perp, 0);
						$row = $GLOBALS['db']->getRow('SELECT o.parent_id as user_id,u.user_name FROM ' . $GLOBALS['ecs']->table('users') . ' o' . ' LEFT JOIN' . $GLOBALS['ecs']->table('users') . ' u ON o.parent_id = u.user_id' . ' WHERE o.user_id = \'' . $row['user_id'] . '\'');
						if ((0 < $setmoney) && (0 < $row['user_id'])) {
							$this->writeDrpLog($vv['order_id'], $row['user_id'], $row['user_name'], $setmoney, $setpoint, $i, $is, 0);
						}
					}
				}
			}
		}

		$sql = 'SELECT d.order_id FROM {pre}drp_log as d ' . ' LEFT JOIN {pre}order_info as o ON d.order_id = o.order_id ' . ' WHERE  d.is_separate != o.drp_is_separate AND o.pay_status = ' . PS_PAYED . ' ';
		$up_oid = $GLOBALS['db']->getAll($sql);

		if ($up_oid) {
			foreach ($up_oid as $kk => $vv) {
				$sql = "SELECT o.order_sn, o.drp_is_separate, o.user_id, SUM(og.drp_money) as drp_money\r\n                    FROM " . $GLOBALS['ecs']->table('order_info') . ' o' . ' RIGHT JOIN' . $GLOBALS['ecs']->table('order_goods') . ' og ON o.order_id = og.order_id' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('users') . ' u ON o.user_id = u.user_id' . ' WHERE o.order_id = \'' . $vv['order_id'] . '\' ';
				$row = $GLOBALS['db']->getRow($sql);
				$is = $row['drp_is_separate'];
				$num = count($drp_affiliate['item']);

				for ($i = 0; $i < $num; $i++) {
					$row = $GLOBALS['db']->getRow('SELECT o.parent_id as user_id,u.user_name FROM ' . $GLOBALS['ecs']->table('users') . ' o' . ' LEFT JOIN' . $GLOBALS['ecs']->table('users') . ' u ON o.parent_id = u.user_id' . ' WHERE o.user_id = \'' . $row['user_id'] . '\'');
					$this->upDrpLog($vv['order_id'], $is);
				}
			}
		}
	}

	public function actionDrplog()
	{
		$this->doinsertlog();
		$page = I('post.page', 1, 'intval');
		$size = '10';
		$status = I('status', 2, 'intval');

		if ($status == 2) {
			$where = '';
		}
		else {
			$where = ' AND a.is_separate = ' . $status . '';
		}

		if (IS_AJAX) {
			$sql = 'SELECT o.order_sn, a.time,a.user_id,a.time,a.money,a.point,a.separate_type,IFNULL(w.nickname,u.user_name),a.is_separate FROM ' . $GLOBALS['ecs']->table('drp_log') . ' a' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('order_info') . ' o ON o.order_id = a.order_id' . ' LEFT JOIN' . $GLOBALS['ecs']->table('users') . ' u ON o.user_id = u.user_id' . ' LEFT JOIN' . $GLOBALS['ecs']->table('wechat_user') . ' w ON w.ect_uid = u.user_id' . ' WHERE a.user_id = ' . $_SESSION['user_id'] . ' AND o.pay_status = 2 AND a.is_separate in (0,1)' . ' ' . $where . ' ' . ' ORDER BY o.order_id DESC';
			$resall = $GLOBALS['db']->query($sql);
			$countall = count($resall);
			$res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);

			foreach ($res as $k => $v) {
				$res[$k]['time'] = date('Y-m-d ', $v['time'] + date('Z'));
				$res[$k]['is_separate'] = $v['is_separate'] == '1' ? '已分成' : '等待处理';
			}

			exit(json_encode(array('list' => $res, 'totalPage' => ceil($countall / $size))));
		}

		$this->assign('page_title', L('brokerage_list'));
		$this->display();
	}

	public function actionCategory()
	{
		$category = drp_get_child_tree(0);
		$this->assign('cat_id', $this->cat_id);
		$this->assign('category', $category);
		$this->assign('page_title', $this->custom . '分类');
		$this->display();
	}

	public function actionDrpchildcategory()
	{
		if (IS_AJAX) {
			if (empty($this->cat_id)) {
				exit(json_encode(array('code' => 1, 'message' => '请选择分类')));
			}

			$type = drp_type($_SESSION['user_id']);

			if (APP_DEBUG) {
				$category = drp_get_child_tree($this->cat_id);
			}
			else {
				$category = cache('categorys' . $this->cat_id);

				if ($category === false) {
					$category = drp_get_child_tree($this->cat_id);
					cache('category' . $this->cat_id, $category);
				}
			}

			exit(json_encode(array('category' => $category, 'type' => $type)));
		}
	}

	public function actionAjaxeditcategory()
	{
		$cat_id = I('cat_id');
		$type = I('type');
		$cat_id = explode(',', $cat_id);

		if (IS_POST) {
			foreach ($cat_id as $key) {
				if ($type == 1) {
					$sql = 'SELECT cat_id FROM ' . $GLOBALS['ecs']->table('drp_type') . ' WHERE user_id = ' . $this->user_id . ' and cat_id = ' . $key;
					$res = $GLOBALS['db']->getOne($sql);

					if (empty($res)) {
						$data['cat_id'] = $key;
						$data['user_id'] = $this->user_id;
						$data['type'] = 1;
						$data['add_time'] = gmtime();
						$this->model->table('drp_type')->data($data)->add();
					}
				}
				else if ($type == 2) {
					$sql = 'DELETE FROM {pre}drp_type WHERE user_id = ' . $this->user_id . ' and cat_id = ' . $key . ' ';
					$this->db->query($sql);
				}
				else {
					$sql = 'SELECT cat_id FROM ' . $GLOBALS['ecs']->table('drp_type') . ' WHERE user_id = ' . $this->user_id . ' and cat_id = ' . $key;
					$res = $GLOBALS['db']->getOne($sql);

					if (empty($res)) {
						$data['cat_id'] = $key;
						$data['user_id'] = $this->user_id;
						$data['type'] = 1;
						$data['add_time'] = gmtime();
						$this->model->table('drp_type')->data($data)->add();
					}
					else {
						$sql = 'DELETE FROM {pre}drp_type WHERE user_id = ' . $this->user_id . ' and cat_id = ' . $key . ' ';
						$this->db->query($sql);
					}
				}
			}

			echo json_encode(array('status' => 1));
		}
	}

	public function actionDrpgoodslist()
	{
		if (0 < $this->cat_id) {
			$where .= ' and ' . get_children($this->cat_id);
		}

		$page = I('page', 1);
		$size = 10;
		$ischeck = get_drp_config_commission();

		if (IS_AJAX) {
			$sql = 'select g.* from {pre}goods as g where g.is_on_sale = 1 AND is_distribution = 1 AND dis_commission >0 AND g.is_alone_sale = 1 AND g.is_delete = 0  ' . $where . ' ORDER BY g.goods_id desc ';
			$res = $GLOBALS['db']->getAll($sql);
			$total = (is_array($res) ? count($res) : 0);
			$drp_goods_list = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);
			$type = drp_type($_SESSION['user_id']);
			$goodsid = drp_type_goods($this->user_id, $type);

			foreach ($goodsid as $key => $vo) {
				$goodsid[$key] = $vo['goods_id'];
			}

			$goods_list = array();

			foreach ($drp_goods_list as $key => $row) {
				if (in_array($row['goods_id'], $goodsid)) {
					$goods_list[$key]['is_drp'] = 1;
				}
				else {
					$goods_list[$key]['is_drp'] = 0;
				}

				$goods_list[$key]['goods_id'] = $row['goods_id'];
				$goods_list[$key]['goods_name'] = $row['goods_name'];
				$goods_list[$key]['commission'] = $ischeck;
				$goods_list[$key]['dis_commission'] = $row['dis_commission'];
				$goods_list[$key]['goods_thumb'] = get_image_path($row['goods_thumb']);
				$goods_list[$key]['shop_price'] = price_format($row['shop_price']);
				$goods_list[$key]['url'] = url('goods/index/index', array('id' => $row['goods_id'], 'u' => $_SESSION['user_id']));
			}

			exit(json_encode(array('list' => $goods_list, 'totalPage' => ceil($total / $size))));
		}

		$this->assign('category', $this->cat_id);
		$this->assign('keywords', $this->keywords);
		$this->assign('page_title', $this->custom . '中心');
		$this->display();
	}

	public function actionDrpgoods()
	{
		$page = I('page', 1);
		$size = 10;
		$type = drp_type($_SESSION['user_id']);

		if ($type == 2) {
			$goodsid = drp_type_goods($this->user_id, $type);

			foreach ($goodsid as $key) {
				$goods_id .= $key['goods_id'] . ',';
			}

			$goods_id = substr($goods_id, 0, -1);
			$where = ' AND goods_id ' . db_create_in($goods_id);
		}
		else if ($type == 1) {
			$catid = drp_type_cat($_SESSION['user_id'], $type);

			foreach ($catid as $key) {
				$cat_id .= $key['cat_id'] . ',';
			}

			$cat_id = substr($cat_id, 0, -1);
			$where = ' AND cat_id ' . db_create_in($cat_id);
		}
		else {
			$where = '';
		}

		$ischeck = get_drp_config_commission();

		if (IS_AJAX) {
			$sql = 'select * from {pre}goods where is_on_sale = 1 AND is_distribution = 1 AND dis_commission >0 AND is_alone_sale = 1 AND is_delete = 0 ' . $where . ' ORDER BY goods_id desc ';
			$ress = $GLOBALS['db']->getAll($sql);
			$total = (is_array($ress) ? count($ress) : 0);
			$drp_goods_list = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);
			$goods_list = array();

			foreach ($drp_goods_list as $key => $row) {
				if (in_array($row['goods_id'], $res)) {
					$goods_list[$key]['is_drp'] = 1;
				}

				$goods_list[$key]['goods_id'] = $row['goods_id'];
				$goods_list[$key]['goods_name'] = $row['goods_name'];
				$goods_list[$key]['commission'] = $ischeck;
				$goods_list[$key]['dis_commission'] = $row['dis_commission'];
				$goods_list[$key]['goods_thumb'] = get_image_path($row['goods_thumb']);
				$goods_list[$key]['shop_price'] = price_format($row['shop_price']);
				$goods_list[$key]['url'] = url('goods/index/index', array('id' => $row['goods_id'], 'u' => $_SESSION['user_id']));
			}

			exit(json_encode(array('list' => $goods_list, 'totalPage' => ceil($total / $size), 'type' => $type)));
		}

		$this->assign('page_title', '我的' . $this->custom);
		$this->display();
	}

	public function get_drp_goods($type = '')
	{
		if (!empty($type)) {
			$where = ' and is_best = 1';
		}

		$sql = 'select * from {pre}goods where is_on_sale = 1  AND dis_commission>0 and is_distribution=1 AND is_alone_sale = 1 AND is_delete = 0 ' . $where . ' ORDER BY goods_id desc ';
		$res = $GLOBALS['db']->getAll($sql);
		$goods_list = array();
		$ischeck = get_drp_config_commission();

		foreach ($res as $key => $row) {
			$goods_list[$key]['goods_id'] = $row['goods_id'];
			$goods_list[$key]['goods_name'] = $row['goods_name'];
			$goods_list[$key]['commission'] = $ischeck;
			$goods_list[$key]['dis_commission'] = $row['dis_commission'];
			$goods_list[$key]['goods_thumb'] = get_image_path($row['goods_thumb']);
			$goods_list[$key]['shop_price'] = price_format($row['shop_price']);
			$goods_list[$key]['url'] = url('goods/index/index', array('id' => $row['goods_id'], 'u' => $_SESSION['user_id']));
		}

		return $goods_list;
	}

	public function actionAjaxeditcat()
	{
		$goods_id = I('cat_id');

		if (IS_POST) {
			$sql = 'SELECT id FROM ' . $GLOBALS['ecs']->table('drp_type') . ' WHERE user_id = ' . $this->user_id . ' and goods_id = ' . $goods_id;
			$res = $GLOBALS['db']->getOne($sql);

			if (empty($res)) {
				$data['goods_id'] = $goods_id;
				$data['user_id'] = $this->user_id;
				$data['type'] = 2;
				$data['add_time'] = gmtime();
				$this->model->table('drp_type')->data($data)->add();
			}
			else {
				$sql = 'DELETE FROM {pre}drp_type WHERE user_id = ' . $this->user_id . ' and goods_id = ' . $goods_id . ' ';
				$this->db->query($sql);
			}

			echo json_encode(array('status' => 1));
		}
	}

	public function actionUserCard()
	{
		if (!isset($_GET['u'])) {
			$this->redirect('drp/user/user_card', array('u' => $_SESSION['user_id']));
		}

		$user_id = I('request.u');
		$info = get_drp($user_id);
		$this->assign('info', $info);

		if (strtolower(substr($info['headimgurl'], 0, 4)) == 'http') {
			$info['headimgurl'] = $info['headimgurl'];
		}
		else {
			$info['headimgurl'] = __HOST__ . $info['headimgurl'];
		}

		$url = __HOST__ . url('shop/index', array('id' => $info['drp_id'], 'u' => $user_id));
		$file = dirname(ROOT_PATH) . '/data/attached/qrcode/';
		$bgImg = $file . 'drp_bg.png';
		$avatar = $file . 'drp_' . $user_id . '_avatar.png';
		$qrcode = $file . 'drp_' . $user_id . '_qrcode.png';
		$outImg = $file . 'drp_' . $user_id . '.png';
		$generate = false;

		if (file_exists($outImg)) {
			$lastmtime = filemtime($outImg) + (3600 * 24 * 20);

			if ($lastmtime <= time()) {
				$generate = true;
			}
		}
		else {
			$generate = true;
		}

		if ($generate) {
			$this->actionGetConfig();
			$qrcodeInfo = $this->weObj->getQRCode($user_id, 0, 2592000);
			$errorCorrectionLevel = 'L';
			$matrixPointSize = 8;
			\Touch\QRcode::png($qrcodeInfo['url'], $qrcode, $errorCorrectionLevel, $matrixPointSize, 2);
			$img = new \Think\Image();
			$img->open($bgImg)->water($qrcode, array(186, 320), 100)->save($outImg);
			$headimg = \Touch\Http::doGet($info['headimgurl']);
			file_put_contents($avatar, $headimg);
			//$img->open($avatar)->thumb(100, 100)->save($avatar);
			//$img->open($outImg)->water($avatar, array(100, 24), 100)->text($info['nickname'], dirname(ROOT_PATH) . '/data/attached/fonts/msyh.ttf', 17, '#EC5151', array(280, 27))->save($outImg);
		}

		$this->assign('ewm', rtrim(dirname(__ROOT__), '/') . '/data/attached/qrcode/drp_' . $user_id . '.png');
		$this->assign('page_title', L('user_card'));
		$description = (!empty($info['shop_name']) ? $info['shop_name'] . '诚邀您的加入，快来吧！' : config('shop.shop_name'));
		$page_img = (!empty($info['headimgurl']) ? $info['headimgurl'] : '');
		$this->assign('description', $description);
		$this->assign('page_img', $page_img);
		$this->display();
	}

	public function actionTeam()
	{
		if (IS_AJAX) {
			$uid = (I('user_id') ? I('user_id') : $this->user_id);
			$page = I('page', 1) - 1;
			$size = 10;
			$offset = $page * $size;
			$limit = ' LIMIT ' . $offset . ',' . $size;
			$sql = "SELECT s.status, s.audit, u.user_id, IFNULL(w.nickname,u.user_name) as name, w.headimgurl, FROM_UNIXTIME(u.reg_time, '%Y-%m-%d') as time,\r\n                    IFNULL((select sum(log.money) as money from {pre}drp_affiliate_log as log left join {pre}order_info as o\r\n                     on log.order_id=o.order_id where log.separate_type != -1 and o.user_id=u.user_id and log.user_id=" . $uid . "),0) as money\r\n                    FROM {pre}users as u\r\n                    LEFT JOIN  {pre}wechat_user as w ON u.user_id=w.ect_uid\r\n                    LEFT JOIN  {pre}drp_shop as s ON u.user_id=s.user_id\r\n                    WHERE s.status=1 and s.audit=1 and  u.parent_id='" . $uid . "'\r\n                    ORDER BY u.reg_time desc" . $limit;
			$next = $this->db->getAll($sql);
			$sql = "SELECT COUNT(*) AS num\r\n                    FROM {pre}users as u\r\n                    LEFT JOIN  {pre}wechat_user as w ON u.user_id=w.ect_uid\r\n                    LEFT JOIN  {pre}drp_shop as s ON u.user_id=s.user_id\r\n                    WHERE s.status=1 and s.audit=1 and  u.parent_id='" . $uid . "'\r\n                    ORDER BY u.reg_time desc";
			$count = $this->db->getOne($sql);
			$count ? $count : 0;
			exit(json_encode(array('info' => $next, 'uid' => $uid, 'totalPage' => ceil($count / $size))));
		}

		$this->assign('page_title', L('my_team'));
		$this->assign('next_id', I('user_id', ''));
		$this->display();
	}

	public function actionTeamDetail()
	{
		$uid = I('uid', '');

		if (empty($uid)) {
			$this->redirect('drp/user/index');
		}

		$sql = "SELECT u.user_id,u.parent_id, IFNULL(w.nickname,u.user_name) as name, w.headimgurl, FROM_UNIXTIME(u.reg_time, '%Y-%m-%d') as time,\r\n                IFNULL((select sum(sl.money) from {pre}drp_affiliate_log as sl\r\n                        left join {pre}order_info as so on sl.order_id=so.order_id\r\n                        where so.user_id='" . $uid . "' and sl.separate_type != -1 and sl.user_id=u.parent_id),0) as sum_money,\r\n                IFNULL((select sum(nl.money) from {pre}drp_affiliate_log as nl\r\n                        left join {pre}order_info as no on nl.order_id=no.order_id\r\n                        where  nl.time>'" . mktime(0, 0, 0) . '\' and no.user_id=\'' . $uid . "' and nl.separate_type != -1 and nl.user_id=u.parent_id),0) as now_money,\r\n                       (select count(h.user_id) from {pre}users as h LEFT JOIN {pre}drp_shop as s on s.user_id=h.user_id where s.status=1 and s.audit=1 and parent_id='" . $uid . "' ) as next_num\r\n                FROM {pre}users as u\r\n                LEFT JOIN  {pre}wechat_user as w ON u.user_id=w.ect_uid\r\n                WHERE u.user_id='" . $uid . '\'';
		$this->assign('info', $this->db->getRow($sql));
		$shopid = dao('drp_shop')->where(array('user_id' => $uid, 'status' => 1, 'audit' => 1))->getField('id');
		$this->assign('shopid', $shopid);
		$this->assign('page_title', L('team_detail'));
		$this->display();
	}
//禁止倒卖 jinmengwangluo   QQ群256172550
	public function actionNew()
	{
		$drp_article = read_static_cache('drp_article');

		if (!$drp_article) {
			$sql = 'SELECT a.title,a.content FROM ' . $GLOBALS['ecs']->table('article') . ' a' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('article_cat') . ' o ON o.cat_id = a.cat_id' . ' WHERE a.is_open = 1 and o.cat_id = 1000  order by a.add_time desc ';
			$drp_article = $this->db->query($sql);

			foreach ($drp_article as $k => $v) {
				$drp_article[$k]['order'] = $k + 1;
			}

			write_static_cache('drp_article', $drp_article);
		}

		$this->assign('drp_article', $drp_article);
		$this->assign('page_title', L('must_be_read'));
		$this->display();
	}

	public function actionRankList()
	{
		$uid = (I('uid') ? I('uid') : $this->user_id);
		$all = cache('ranklist' . $uid);

		if (!$all) {
			$sql = "SELECT d.user_id, w.nickname, w.headimgurl, u.user_name,\r\n                        IFNULL((select sum(money) from {pre}drp_affiliate_log where user_id=d.user_id and separate_type != -1),0) as money,\r\n                        IFNULL((select count(user_id) from {pre}users where parent_id=d.user_id ),0) as user_num\r\n                        FROM {pre}drp_shop as d\r\n                        LEFT JOIN {pre}users as u ON d.user_id=u.user_id\r\n                        LEFT JOIN {pre}wechat_user as w ON d.user_id=w.ect_uid\r\n                        LEFT JOIN {pre}drp_affiliate_log as log ON log.user_id=d.user_id\r\n                        where d.audit=1 and d.status=1\r\n                        GROUP BY d.user_id\r\n                        ORDER BY money desc,user_num desc";
			$all = $this->model->query($sql);

			if ($all) {
				foreach ($all as $key => $val) {
					if ($key === 0) {
						$all[$key]['img'] = elixir('img/fx-one.png');
					}
					else if ($key === 1) {
						$all[$key]['img'] = elixir('img/fx-two.png');
					}
					else if ($key === 2) {
						$all[$key]['img'] = elixir('img/fx-stree.png');
					}
					else {
						$all[$key]['span'] = $key + 1;
					}
				}

				cache('ranklist' . $uid, $all);
			}
		}

		if (IS_AJAX) {
			$page = I('page', 1, 'intval') - 1;
			$list = array_slice($all, $page * 6, 6);
			exit(json_encode(array('list' => $list, 'totalPage' => ceil(count($all) / 6))));
		}

		$rank = copy_array_column($all, 'user_id');
		$rank = array_search($uid, $rank);
		$rank = ($rank === false ? '--' : $rank + 1);
		$this->assign('rank', $rank);
		$this->assign('page_title', L('distribution_Ranking'));
		$this->display();
	}

	private function actionGetConfig()
	{
		$where['default_wx'] = 1;
		$wechat = $this->model->table('wechat')->field('token, appid, appsecret, type, status')->where($where)->find();

		if (!empty($wechat)) {
			$config = array();
			$config['token'] = $wechat['token'];
			$config['appid'] = $wechat['appid'];
			$config['appsecret'] = $wechat['appsecret'];
			$this->weObj = new \Touch\Wechat($config);
		}
	}

	public function actionShopConfig()
	{
		$sql = 'SELECT * FROM {pre}drp_shop WHERE user_id=' . $this->user_id;
		$drp_info = $this->db->getRow($sql);
		$info = array();
		$info['shop_name'] = $drp_info['shop_name'];
		$info['real_name'] = $drp_info['real_name'];
		$info['qq'] = $drp_info['qq'];

		if (empty($drp_info['shop_img'])) {
			$info['shop_img'] = elixir('img/user-shop.png');
		}
		else {
			$info['shop_img'] = get_image_path($drp_info['shop_img']);
		}

		$info['mobile'] = $drp_info['mobile'];
		$info['type'] = $drp_info['type'];
		$this->assign('info', $info);

		if (IS_POST) {
			$data['shop_name'] = I('shop_name');
			$data['real_name'] = I('real_name');
			$data['mobile'] = I('mobile');
			$data['qq'] = I('qq');
			$data['type'] = I('type');

			if (empty($data['mobile'])) {
				show_message(L('mobile_notnull'));
			}

			if (is_mobile($data['mobile']) == false) {
				show_message(L('mobile_format_error'));
			}

			if (empty($data['shop_name'])) {
				show_message(L('mgs_shop_name_notnull'));
			}

			if (empty($data['real_name'])) {
				show_message(L('msg_name_notnull'));
			}

			if (empty($data['mobile'])) {
				show_message(L('mobile_not_null'));
			}

			if (!empty($_FILES['shop_img']['name'])) {
				$result = $this->upload('data/attached/drp_logo', true);

				if (0 < $result['error']) {
					show_message($result['message']);
				}

				$data['shop_img'] = $result['url'];
			}

			$where['user_id'] = $_SESSION['user_id'];
			$this->model->table('drp_shop')->data($data)->where($where)->save();
			show_message(L('edit_success'), $this->custom . '中心', url('drp/user/index'), 'success');
		}

		$this->assign('page_title', L('shop_set'));
		$this->display();
	}

	public function actionOrder()
	{
		$this->doinsertlog();
		$page = I('post.page', 1, 'intval');
		$size = '5';
		$status = I('status', 2, 'intval');

		if ($status == 2) {
			$where = '';
		}
		else {
			$where = ' AND o.drp_is_separate = ' . $status . '';
		}

		if (IS_AJAX) {
			$sql = 'SELECT o.*, a.money, IFNULL(w.nickname,u.user_name) as user_name, a.point, a.drp_level FROM ' . $GLOBALS['ecs']->table('drp_log') . ' a' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('order_info') . ' o ON o.order_id = a.order_id' . ' LEFT JOIN' . $GLOBALS['ecs']->table('users') . ' u ON o.user_id = u.user_id' . ' LEFT JOIN' . $GLOBALS['ecs']->table('wechat_user') . ' w ON w.ect_uid = u.user_id' . ' WHERE a.user_id = ' . $_SESSION['user_id'] . ' AND o.pay_status = 2 AND a.is_separate in (0,1)' . ' ' . $where . ' ' . ' ORDER BY order_id DESC';
			$resall = $GLOBALS['db']->query($sql);
			$countall = count($resall);
			$res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);

			if ($res) {
				$drp_affiliate = get_drp_affiliate_config();

				foreach ($res as $key => $value) {
					$goods_list = $this->getOrderGoods($value['order_id']);
					$total_goods_price = 0;
					$this_order_drpmoney = 0;

					foreach ($goods_list as $key => $val) {
						$level_per = (double) $drp_affiliate['item'][$value['drp_level']]['level_money'] * ($val['drp_money'] / $val['goods_number'] / $val['goods_price']);
						$goods_list[$key]['price'] = $val['goods_price'];
						$goods_list[$key]['goods_price'] = price_format($val['goods_price'], false);
						$goods_list[$key]['subtotal'] = price_format($value['total_fee'], false);
						$goods_list[$key]['goods_number'] = $val['goods_number'];
						$goods_list[$key]['goods_thumb'] = get_image_path($val['goods_thumb']);
						$goods_list[$key]['url'] = url('goods/index/index', array('id' => $val['goods_id']));
						$goods_list[$key]['this_good_drpmoney'] = round(($val['goods_price'] * $level_per) / 100, 2);
						$this_order_drpmoney += $goods_list[$key]['this_good_drpmoney'] * $val['goods_number'];
						$total_goods_price += $val['goods_price'];
						$goods_list[$key]['this_good_per'] = round($level_per, 2) . '%';
					}

					$orders[] = array('user_name' => $value['user_name'], 'order_sn' => $value['order_sn'], 'order_time' => local_date($GLOBALS['_CFG']['time_format'], $value['add_time']), 'url' => url('drp/user/order_detail', array('order_id' => $value['order_id'])), 'is_separate' => $value['drp_is_separate'], 'goods' => $goods_list, 'goods_count' => $goods_list ? count($goods_list) : 0, 'total_orders_drpmoney' => price_format($this_order_drpmoney, false), 'this_good_per' => round($level_per, 2) . '%');
				}
			}

			exit(json_encode(array('orders' => $orders, 'totalPage' => ceil($countall / $size))));
		}

		$this->assign('page_title', L('distribution_order'));
		$this->display();
	}

	private function writeDrpLog($oid, $uid, $username, $money, $point, $i, $is, $separate_by)
	{
		$time = gmtime();
		$sql = 'INSERT INTO ' . $GLOBALS['ecs']->table('drp_log') . '( order_id, user_id, user_name, time, money, point, drp_level,is_separate, separate_type)' . ' VALUES ( \'' . $oid . '\', \'' . $uid . '\', \'' . $username . '\', \'' . $time . '\', \'' . $money . '\', \'' . $point . '\',\'' . $i . '\',\'' . $is . '\', ' . $separate_by . ')';

		if ($oid) {
			$GLOBALS['db']->query($sql);
		}
	}

	private function upDrpLog($oid, $is)
	{
		$time = gmtime();
		$sql = 'UPDATE {pre}drp_log SET `is_separate` = ' . $is . ' WHERE order_id = ' . $oid . ' ';

		if ($oid) {
			$GLOBALS['db']->query($sql);
		}
	}

	public function actionOrderdetail()
	{
		$oid = (int) $_REQUEST['order_id'];
		$sql = 'SELECT o.*, a.money, IFNULL(w.nickname,u.user_name) as user_name, a.point, a.drp_level FROM ' . $GLOBALS['ecs']->table('drp_log') . ' a' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('order_info') . ' o ON o.order_id = a.order_id' . ' LEFT JOIN' . $GLOBALS['ecs']->table('users') . ' u ON o.user_id = u.user_id' . ' LEFT JOIN' . $GLOBALS['ecs']->table('wechat_user') . ' w ON w.ect_uid = u.user_id' . ' WHERE a.user_id = ' . $_SESSION['user_id'] . '  AND o.order_id = ' . $oid . ' AND o.pay_status = 2';
		$res = $GLOBALS['db']->getRow($sql);

		if (!$res) {
			ecs_header('Location: ' . url('drp/user/index'));
		}

		$goods_list = $this->getOrderGoods($res['order_id']);
		$drp_affiliate = get_drp_affiliate_config();
		$this_order_drpmoney = 0;

		foreach ($goods_list as $key => $val) {
			$level_per = (double) $drp_affiliate['item'][$res['drp_level']]['level_money'] * ($val['drp_money'] / $val['goods_number'] / $val['goods_price']);
			$goods_list[$key]['price'] = $val['goods_price'];
			$goods_list[$key]['goods_number'] = $val['goods_number'];
			$goods_list[$key]['goods_thumb'] = get_image_path($val['goods_thumb']);
			$goods_list[$key]['goods_url'] = url('goods/index/index', array('id' => $val['goods_id']));
			$goods_list[$key]['this_good_drpmoney'] = round(($val['goods_price'] * $level_per) / 100, 2);
			$this_order_drpmoney += $goods_list[$key]['this_good_drpmoney'] * $val['goods_number'];
			$goods_list[$key]['this_good_per'] = round($level_per, 2) . '%';
			$goods_list[$key]['goods_price'] = price_format($val['goods_price'], false);
		}

		$orders = array('user_name' => $res['user_name'], 'order_sn' => $res['order_sn'], 'order_time' => date('Y-m-d  H:i:s', $res['add_time'] + date('Z')), 'is_separate' => $res['drp_is_separate'], 'goods' => $goods_list, 'goods_count' => $goods_list ? count($goods_list) : 0, 'total_orders_drpmoney' => price_format($this_order_drpmoney, false), 'this_good_per' => round($level_per, 2) . '%');
		$this->assign('order', $orders);
		$this->assign('page_title', L('distribution_order_list'));
		$this->display();
	}
//禁止倒卖 jinmengwangluo   QQ群256172550
	private function getOrderGoods($order_id = 0)
	{
		if (0 < $order_id) {
			$sql = 'select og.rec_id,og.goods_id,og.goods_name,og.goods_attr,og.goods_number,og.goods_price, og.drp_money, g.goods_thumb from {pre}order_goods as og ' . 'join {pre}goods as g on og.goods_id = g.goods_id  where og.order_id=' . $order_id . ' and og.is_distribution = 1 and og.drp_money > 0';
			$goodsArr = $GLOBALS['db']->query($sql);
			return $goodsArr;
		}
	}

	private function htmlOut($str)
	{
		if (function_exists('htmlspecialchars_decode')) {
			$str = htmlspecialchars_decode($str);
		}
		else {
			$str = html_entity_decode($str);
		}

		$str = stripslashes($str);
		return $str;
	}

	private function transfer_goods($str)
	{
		$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('drp_shop') . ' WHERE user_id = ' . $this->user_id;
		$drp_shop = $GLOBALS['db']->getRow($sql);

		if (!empty($drp_shop['goods_id'])) {
			$catid = substr($drp_shop['goods_id'], 0, -1);
			$catid = explode(',', $catid);

			foreach ($catid as $key) {
				$sql = 'SELECT goods_id FROM ' . $GLOBALS['ecs']->table('drp_type') . ' WHERE user_id = ' . $this->user_id . ' and goods_id =' . $key . ' ';
				$goods = $GLOBALS['db']->getOne($sql);

				if (empty($goods)) {
					$data['goods_id'] = $key;
					$data['user_id'] = $this->user_id;
					$data['type'] = 2;
					$data['add_time'] = gmtime();
					$this->model->table('drp_type')->data($data)->add();
				}
			}

			$sql = 'UPDATE {pre}drp_shop' . ' SET goods_id = \'\' ' . ' WHERE user_id = ' . $this->user_id . ' ';
			$this->model->query($sql);
		}
	}
}

?>
