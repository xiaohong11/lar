<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\http\console\controllers;

class View extends \app\http\base\controllers\Frontend
{
	public function __construct()
	{
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Allow-Headers: X-HTTP-Method-Override, Content-Type, x-requested-with, Authorization');
		$this->load_helper(array('function', 'ecmoban'));
		$this->init_params();
	}

	public function actionIndex()
	{
		$sql = 'SELECT id, type , title , pic  FROM ' . $GLOBALS['ecs']->table('touch_page_view') . ' WHERE ru_id = 0 AND default = 1 ';
		$view = $GLOBALS['db']->getRow($sql);
		return $view;
	}

	public function actionArticle()
	{
		if (IS_POST) {
			$cid = input('cat_id', 0, 'intval');
			$num = input('num', 0);

			if ($num == 0) {
				$limit = array();
			}
			else {
				$limit = $num;
			}

			if ($cid == 0) {
				$where = array();
			}
			else {
				$where = array('cat_id' => $cid);
			}

			$article_msg = dao('article')->field('article_id,title,add_time')->where($where)->limit($num)->select();

			foreach ($article_msg as $key => $value) {
				$article_msg[$key]['title'] = $value['title'];
				$article_msg[$key]['url'] = url('article/index/detail', array('id' => $value['article_id']));
				$article_msg[$key]['date'] = local_date('Y-m-d H:i:s', $value['add_time']);
			}

			$this->response(array('error' => 0, 'article_msg' => $article_msg, 'cat_id' => $cid));
		}
	}

	public function actionDefault()
	{
		if (IS_POST) {
			$type = input('type');
			$id = input('id');
			$ru_id = input('ru_id');

			if ($ru_id) {
				$index = dao('touch_page_view')->where(array('ru_id' => $ru_id, 'type' => $type))->getField('id');
				$this->response(array('index' => $index));
			}
			else {
				$index = dao('touch_page_view')->where(array('ru_id' => 0, 'type' => 'index', 'default' => 1))->getField('id');

				if ($index) {
					$this->response(array('index' => $index));
				}
				else {
					$index = unserialize(str_replace('<?php exit("no access");', '', file_get_contents(ROOT_PATH . 'storage/app/diy/index.php')));

					foreach ($index as $key => $value) {
						$index[$key]['moreLink'] = replace_img_view($value['moreLink']);
						$index[$key]['icon'] = replace_img_view($value['icon']);

						if (isset($value['data']['icon'])) {
							$index[$key]['data']['icon'] = replace_img_view($value['data']['icon']);
						}

						if (isset($value['data']['moreLink'])) {
							$index[$key]['data']['moreLink'] = replace_img_view($value['data']['moreLink']);
						}

						foreach ($value['data']['imgList'] as $ke => $val) {
							if (isset($val['img'])) {
								$index[$key]['data']['imgList'][$ke]['img'] = replace_img_view($val['img']);
							}

							if (isset($val['link'])) {
								$index[$key]['data']['imgList'][$ke]['link'] = replace_img_view($val['link']);
							}
						}

						foreach ($value['data']['contList'] as $ke => $val) {
							if (isset($val['url'])) {
								$index[$key]['data']['contList'][$ke]['url'] = replace_img_view($val['url']);
							}
						}
					}

					if (!empty($index)) {
						$keep = array('ru_id' => 0, 'type' => 'old', 'page_id' => 0, 'title' => 'old_index', 'data' => json_encode($index), 'default' => 3, 'review_status' => 3, 'is_show' => 1);
						$this->response(array('type' => 'old', 'index' => $keep['data']));
					}
					else {
						$data = str_replace('<?php exit("no access");', '', file_get_contents(ROOT_PATH . 'storage/app/diy/default.php'));
						$keep = array('ru_id' => 0, 'type' => 'index', 'title' => '首页', 'data' => $data, 'default' => 1);
						dao('touch_page_view')->add($keep);
						$index = dao('touch_page_view')->where(array('ru_id' => 0, 'type' => 'index', 'default' => 1))->getField('id');
						$this->response(array('index' => $index));
					}
				}
			}
		}
	}

	public function actionProduct()
	{
		if (IS_POST) {
			$number = input('number', 10);
			$user_id = input('ru_id', 0, 'intval');
			$type = input('type');
			$warehouse_id = $this->region_id;
			$area_id = $this->area_info['region_id'];
			$where = '';

			switch ($type) {
			case 'new':
				$where .= 'WHERE  g.is_new = \'1\' AND g.user_id = ' . $user_id . ' ';
				break;

			case 'best':
				$where .= 'WHERE  g.is_best = \'1\' AND g.user_id = ' . $user_id . ' ';
				break;

			case 'hot':
				$where .= 'WHERE  g.is_hot = \'1\' AND g.user_id = ' . $user_id . ' ';
				break;

			case 'promote':
				$where .= 'WHERE  g.is_promote = \'1\' AND g.user_id = ' . $user_id . ' ';
				break;

			default:
				$where .= 'WHERE g.user_id = ' . $user_id;
			}

			$shop_price = 'wg.warehouse_price, wg.warehouse_promote_price, wag.region_price, wag.region_promote_price, g.model_price, g.model_attr, ';
			$leftJoin = ' left join ' . $GLOBALS['ecs']->table('warehouse_goods') . ' as wg on g.goods_id = wg.goods_id and wg.region_id = \'' . $warehouse_id . '\' ';
			$leftJoin .= ' left join ' . $GLOBALS['ecs']->table('warehouse_area_goods') . ' as wag on g.goods_id = wag.goods_id and wag.region_id = \'' . $area_id . '\' ';

			if ($GLOBALS['_CFG']['open_area_goods'] == 1) {
				$leftJoin .= ' left join ' . $GLOBALS['ecs']->table('link_area_goods') . ' as lag on g.goods_id = lag.goods_id ';
				$where .= ' WHERE lag.region_id = \'' . $area_id . '\' ';
			}

			$sql = 'SELECT g.goods_id, g.user_id, g.goods_name, g.goods_number, ' . $shop_price . ' g.goods_name_style, g.comments_number,g.sales_volume,g.market_price, g.is_new, g.is_best, g.is_hot, ' . ' IF(g.model_price < 1, g.goods_number, IF(g.model_price < 2, wg.region_number, wag.region_number)) AS goods_number, ' . ' IF(g.model_price < 1, g.shop_price, IF(g.model_price < 2, wg.warehouse_price, wag.region_price)) AS org_price, g.model_price, ' . 'IFNULL(mp.user_price, IF(g.model_price < 1, g.shop_price, IF(g.model_price < 2, wg.warehouse_price, wag.region_price)) * \'' . $_SESSION['discount'] . '\') AS shop_price, ' . 'IF(g.model_price < 1, g.promote_price, IF(g.model_price < 2, wg.warehouse_promote_price, wag.region_promote_price)) as promote_price, g.goods_type, ' . 'g.promote_start_date, g.promote_end_date, g.is_promote, g.goods_brief, g.goods_thumb , g.goods_img, g.cat_id ' . 'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' . $leftJoin . 'LEFT JOIN ' . $GLOBALS['ecs']->table('member_price') . ' AS mp ' . 'ON mp.goods_id = g.goods_id AND mp.user_rank = \'' . $_SESSION['user_rank'] . '\' ' . $where . ' ORDER BY g.sort_order ASC , g.goods_id DESC LIMIT ' . $number;
			$goods_list = $GLOBALS['db']->getAll($sql);
			$time = gmtime();

			foreach ($goods_list as $key => $val) {
				$product[$key]['title'] = $val['goods_name'];
				$product[$key]['stock'] = $val['goods_number'];
				$product[$key]['sale'] = $val['sales_volume'];

				if (0 < $val['promote_price']) {
					$promote_price = bargain_price($val['promote_price'], $val['promote_start_date'], $val['promote_end_date']);
				}
				else {
					$promote_price = 0;
				}

				$price_other = array('market_price' => $val['market_price'], 'org_price' => $val['org_price'], 'shop_price' => $val['shop_price'], 'promote_price' => $promote_price);
				$price_info = get_goods_one_attr_price($val['goods_id'], $warehouse_id, $area_id, $price_other);
				$val = (!empty($val) ? array_merge($val, $price_info) : $val);
				$promote_price = $val['promote_price'];
				$product[$key]['marketPrice'] = $val['market_price'];
				$product[$key]['img'] = get_image_path($val['goods_img']);
				$product[$key]['url'] = url('goods/index/index', array('id' => $val['goods_id'], 'u' => $_SESSION['user_id']));
				if (($val['promote_start_date'] < $time) && ($time < $val['promote_end_date']) && ($val['is_promote'] == 1) && ($val['model_price'] == 1)) {
					$product[$key]['price'] = price_format($val['warehouse_promote_price']);
				}
				else {
					if (($val['promote_start_date'] < $time) && ($time < $val['promote_end_date']) && ($val['is_promote'] == 1) && ($val['model_price'] == 0)) {
						$product[$key]['price'] = price_format($val['promote_price']);
					}
					else {
						$product[$key]['price'] = price_format($val['shop_price']);
					}
				}

				if (empty($val['promote_start_date']) || empty($val['promote_end_date'])) {
					$product[$key]['price'] = price_format($val['shop_price']);
				}
			}

			$this->response(array('error' => 0, 'product' => $product, 'type' => $type));
		}
	}

	public function actionStore()
	{
		if (IS_POST) {
			$number = input('number', 10);
			$childrenNumber = input('childrenNumber', 3, 'intval');
			$sql = 'SELECT ms.user_id as shop_id,ms.user_id, ms.rz_shopName, ss.logo_thumb, ss.street_thumb ' . ' FROM ' . $GLOBALS['ecs']->table('merchants_shop_information') . ' AS ms ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('seller_shopinfo') . ' AS ss ' . ' ON ms.user_id = ss.ru_id ' . ' order by ms.sort_order desc,ms.shop_id asc limit  0, ' . $number;
	
			$store = $GLOBALS['db']->getAll($sql);

			foreach ($store as $key => $value) {
				$sql = 'SELECT goods_name, goods_thumb ' . ' FROM ' . $GLOBALS['ecs']->table('goods') . ' WHERE user_id = \'' . $value['user_id'] . '\' ' . ' limit 0, ' . $childrenNumber;
				$goods = $GLOBALS['db']->getAll($sql);
				$store[$key]['goods'] = $goods;
				$store[$key]['total'] = count($goods);
			}

			$this->response(array('error' => 0, 'store' => $store, 'page' => $currentPage, 'total' => count($store)));
		}
	}

	public function actionStoreIn()
	{
		if (IS_POST) {
			$ru_id = input('ru_id');
			$time = gmtime();
			$sql = 'SELECT ms.shop_id, ms.user_id, ms.rz_shopName, ss.logo_thumb, ss.street_thumb ' . ' FROM ' . $GLOBALS['ecs']->table('merchants_shop_information') . ' AS ms ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('seller_shopinfo') . ' AS ss ' . ' ON ms.user_id = ss.ru_id ' . ' WHERE ms.user_id = ' . $ru_id . ' ';
			
			$store = $GLOBALS['db']->getAll($sql);

			foreach ($store as $key => $value) {
				$sql = 'SELECT goods_name, goods_thumb, shop_price ' . ' FROM ' . $GLOBALS['ecs']->table('goods') . ' WHERE user_id = \'' . $value['user_id'] . '\' ';
				$goods = $GLOBALS['db']->getAll($sql);
				$new = dao('goods')->where(array('is_new' => 1, 'user_id' => $value['user_id']))->count();
				$promote = dao('goods')->where(array('is_promote' => 1, 'user_id' => $value['user_id']))->count();
				$store[$key]['total'] = count($goods);
				$store[$key]['new'] = $new;
				$store[$key]['promote'] = $promote;
				$sql = 'SELECT count(user_id) as a FROM {pre}collect_store WHERE ru_id = ' . $value['user_id'];
				$follow = $this->db->getOne($sql);
				$store[$key]['count_gaze'] = empty($follow) ? 0 : 1;
				$sql = 'SELECT count(ru_id) as a FROM {pre}collect_store WHERE ru_id = ' . $value['user_id'];
				$like_num = $this->db->getOne($sql);
				$store[$key]['like_num'] = empty($like_num) ? 0 : $like_num;
			}

			$this->response(array('store' => $store));
		}
	}

	public function actionStoreDown()
	{
		if (IS_POST) {
			$ru_id = input('ru_id');
			$time = gmtime();
			$sql = 'SELECT ms.shop_id, ms.user_id, ms.rz_shopName,ss.kf_qq, ss.kf_ww ' . ' FROM ' . $GLOBALS['ecs']->table('merchants_shop_information') . ' AS ms ' . ' LEFT JOIN ' . $GLOBALS['ecs']->table('seller_shopinfo') . ' AS ss ' . ' ON ms.user_id = ss.ru_id  ' . ' WHERE ms.user_id = ' . $ru_id . '  ';
			$store = $GLOBALS['db']->getAll($sql);

			foreach ($store as $key => $value) {
				$store[$key]['shop_category'] = get_user_store_category($value['user_id']);
				$store[$key]['shop_about'] = url('store/index/shop_about', array('ru_id' => $value['user_id']));
			}

			$this->response(array('store' => $store));
		}
	}

	public function actionStoreBonus()
	{
		if (IS_POST) {
			$ru_id = input('ru_id');
			$sql = 'SELECT * FROM {pre}coupons WHERE (`cou_type` = 3 OR `cou_type` = 4 ) AND `cou_end_time` > ' . $time . ' AND (( instr(`cou_ok_user`, ' . $_SESSION['user_rank'] . ') ) or (`cou_ok_user`=0)) AND review_status = 3 AND ru_id=\'' . $ru_id . '\' ';
			$info = $this->db->getAll($sql);

			foreach ($info as $key => $val) {
				$info[$key]['cou_man'] = intval($val['cou_man']);
				$info[$key]['cou_money'] = intval($val['cou_money']);
			}

			$bonus = $info;
			$this->response(array('store' => $bonus));
		}
	}

	public function actionAddCollect()
	{
		$time = gmtime();
		$shopid = input('ru_id', 0, 'intval');
		if (!empty($shopid) && (0 < $_SESSION['user_id'])) {
			$status = dao('collect_store')->field('user_id, rec_id')->where(array('ru_id' => $shopid, 'user_id' => $_SESSION['user_id']))->find();

			if (0 < count($status)) {
				dao('collect_store')->where(array('rec_id' => $status['rec_id']))->delete();
				exit(json_encode(array('error' => 2, 'msg' => L('cancel_attention'))));
			}
			else {
				dao('collect_store')->data(array('user_id' => $_SESSION['user_id'], 'ru_id' => $shopid, 'add_time' => $time, 'is_attention' => '1'))->add();
				exit(json_encode(array('error' => 1, 'msg' => L('attentioned'))));
			}
		}
		else {
			exit(json_encode(array('error' => 0, 'msg' => L('please_login'))));
		}
	}

	public function actionView()
	{
		if (IS_POST) {
			$default = input('default');
			$id = input('id');
			$type = input('type');
			$ru_id = input('ru_id', 0, 'intval');
			$number = input('number', 10);
			$page_id = input('page_id', 0, 'intval');

			if ($id) {
				$view = dao('touch_page_view')->field('type, thumb_pic, data, default')->where(array('id' => $id))->find();
			}
			else if ($default < 2) {
				if ($number == 0) {
					$view = dao('touch_page_view')->field('id , type ,  title ,  pic ,thumb_pic , default ')->where(array('default' => $default, 'ru_id' => $ru_id, 'page_id' => $page_id))->order('update_at DESC')->select();
				}
				else if (0 < $number) {
					$view = dao('touch_page_view')->field('id , type ,  title ,  pic ,thumb_pic , default ')->where(array('default' => $default, 'ru_id' => $ru_id, 'page_id' => $page_id))->order('update_at DESC')->limit($number)->select();
				}
			}
			else if ($default == 3) {
				if ($number == 0) {
					$view = dao('touch_page_view')->field('id , type ,  title ,  pic ,thumb_pic , default ')->order('update_at DESC')->select();
				}
				else if (0 < $number) {
					$view = dao('touch_page_view')->field('id , type ,  title ,  pic ,thumb_pic , default ')->where(array('ru_id' => $ru_id))->order('update_at DESC')->limit($number)->select();
				}
			}
			else {
				$view = dao('touch_page_view')->field('id , type ,  title , data,  pic ,thumb_pic , default ')->where(array('ru_id' => $ru_id, 'type' => $type))->order('update_at DESC')->select();
			}

			$this->response(array('error' => 0, 'view' => $view));
		}
	}

	public function actionSearch()
	{
		if (IS_POST) {
			$title = input('title');
			$ru_id = input('ru_id', 0, 'intval');
			$default = input('default', 0, 'intval');
			$view = dao('touch_page_view')->field('id, pic, title, default, type')->where(array('title' => $title, 'ru_id' => $ru_id, 'default' => $default))->order('update_at DESC')->select();
			$this->response(array('error' => 0, 'view' => $view));
		}
	}

	private function init_params()
	{
		if (!isset($_COOKIE['province'])) {
			$area_array = get_ip_area_name();

			if ($area_array['county_level'] == 2) {
				$date = array('region_id', 'parent_id', 'region_name');
				$where = 'region_name = \'' . $area_array['area_name'] . '\' AND region_type = 2';
				$city_info = get_table_date('region', $where, $date, 1);
				$date = array('region_id', 'region_name');
				$where = 'region_id = \'' . $city_info[0]['parent_id'] . '\'';
				$province_info = get_table_date('region', $where, $date);
				$where = 'parent_id = \'' . $city_info[0]['region_id'] . '\' order by region_id asc limit 0, 1';
				$district_info = get_table_date('region', $where, $date, 1);
			}
			else if ($area_array['county_level'] == 1) {
				$area_name = $area_array['area_name'];
				$date = array('region_id', 'region_name');
				$where = 'region_name = \'' . $area_name . '\'';
				$province_info = get_table_date('region', $where, $date);
				$where = 'parent_id = \'' . $province_info['region_id'] . '\' order by region_id asc limit 0, 1';
				$city_info = get_table_date('region', $where, $date, 1);
				$where = 'parent_id = \'' . $city_info[0]['region_id'] . '\' order by region_id asc limit 0, 1';
				$district_info = get_table_date('region', $where, $date, 1);
			}
		}

		$order_area = get_user_order_area($this->user_id);
		$user_area = get_user_area_reg($this->user_id);
		if ($order_area['province'] && (0 < $this->user_id)) {
			$this->province_id = $order_area['province'];
			$this->city_id = $order_area['city'];
			$this->district_id = $order_area['district'];
		}
		else {
			if (0 < $user_area['province']) {
				$this->province_id = $user_area['province'];
				cookie('province', $user_area['province']);
				$this->region_id = get_province_id_warehouse($this->province_id);
			}
			else {
				$sql = 'select region_name from ' . $this->ecs->table('region_warehouse') . ' where regionId = \'' . $province_info['region_id'] . '\'';
				$warehouse_name = $this->db->getOne($sql);
				$this->province_id = $province_info['region_id'];
				$cangku_name = $warehouse_name;
				$this->region_id = get_warehouse_name_id(0, $cangku_name);
			}

			if (0 < $user_area['city']) {
				$this->city_id = $user_area['city'];
				cookie('city', $user_area['city']);
			}
			else {
				$this->city_id = $city_info[0]['region_id'];
			}

			if (0 < $user_area['district']) {
				$this->district_id = $user_area['district'];
				cookie('district', $user_area['district']);
			}
			else {
				$this->district_id = $district_info[0]['region_id'];
			}
		}

		$this->province_id = isset($_COOKIE['province']) ? $_COOKIE['province'] : $this->province_id;
		$child_num = get_region_child_num($this->province_id);

		if (0 < $child_num) {
			$this->city_id = isset($_COOKIE['city']) ? $_COOKIE['city'] : $this->city_id;
		}
		else {
			$this->city_id = '';
		}

		$child_num = get_region_child_num($this->city_id);

		if (0 < $child_num) {
			$this->district_id = isset($_COOKIE['district']) ? $_COOKIE['district'] : $this->district_id;
		}
		else {
			$this->district_id = '';
		}

		$this->region_id = !isset($_COOKIE['region_id']) ? $this->region_id : $_COOKIE['region_id'];
		$goods_warehouse = get_warehouse_goods_region($this->province_id);

		if ($goods_warehouse) {
			$this->regionId = $goods_warehouse['region_id'];
			if ($_COOKIE['region_id'] && $_COOKIE['regionid']) {
				$gw = 0;
			}
			else {
				$gw = 1;
			}
		}

		if ($gw) {
			$this->region_id = $this->regionId;
			cookie('area_region', $this->region_id);
		}

		cookie('goodsId', $this->goods_id);
		$sellerInfo = get_seller_info_area();

		if (empty($this->province_id)) {
			$this->province_id = $sellerInfo['province'];
			$this->city_id = $sellerInfo['city'];
			$this->district_id = 0;
			cookie('province', $this->province_id);
			cookie('city', $this->city_id);
			cookie('district', $this->district_id);
			$goods_warehouse = get_warehouse_goods_region($this->province_id);
			$this->region_id = $goods_warehouse['region_id'];
		}

		$this->area_info = get_area_info($this->province_id);
	}
}

?>
