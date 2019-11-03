<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
namespace app\http\wechat\controllers;

class RedpackAdmin extends Marketing
{
	private $marketing_type = 'redpack';

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		$list = dao('wechat_marketing')->field('id, name, marketing_type, command, starttime, endtime, support, status')->where(array('marketing_type' => $this->marketing_type, 'wechat_id' => $this->wechat_id))->order('id DESC')->select();

		if ($list[0]['id']) {
			foreach ($list as $k => $v) {
				$list[$k]['starttime'] = date('Y-m-d H:i:s', $v['starttime']);
				$list[$k]['endtime'] = date('Y-m-d H:i:s', $v['endtime']);
				$config = $this->get_market_config($v['id'], $v['marketing_type']);
				$list[$k]['hb_type'] = $config['hb_type'] == 1 ? L('group_redpack') : L('normal_redpack');

				if ($v['status'] == 0) {
					$list[$k]['status'] = L('no_start');
				}
				else if ($v['status'] == 1) {
					$list[$k]['status'] = L('start');
				}
				else if ($v['status'] == 2) {
					$list[$k]['status'] = L('over');
				}
			}
		}
		else {
			$list = array();
		}

		$this->assign('list', $list);
		$this->display();
	}

	public function actionEdit()
	{
		if (IS_POST) {
			$id = I('post.id');
			$data = I('post.data');
			$config = I('post.config');
			if (empty($data['name']) && (32 <= strlen($data['name']))) {
				$this->message('活动名称必填，并且须少于32个字符', NULL, 2);
			}

			if (($config['base_money'] < 1) || (200 < $config['base_money'])) {
				$this->message('红包金额必须在1元~200元之间，请重新填写', NULL, 2);
			}

			if (empty($config['nick_name']) && (16 <= strlen($config['nick_name']))) {
				$this->message('提供方名称必填，并且须少于16个字符', NULL, 2);
			}

			if (empty($config['send_name']) && (32 <= strlen($config['send_name']))) {
				$this->message('红包发送方名称必填，并且须少于32个字符', NULL, 2);
			}

			$data['wechat_id'] = $this->wechat_id;
			$data['marketing_type'] = I('post.marketing_type');
			$data['starttime'] = strtotime($data['starttime']);
			$data['endtime'] = strtotime($data['endtime']);
			$nowtime = time();

			if ($nowtime < $data['starttime']) {
				$data['status'] = 0;
			}
			else {
				if (($data['starttime'] < $nowtime) && ($nowtime < $data['endtime'])) {
					$data['status'] = 1;
				}
				else if ($data['endtime'] < $nowtime) {
					$data['status'] = 2;
				}
			}

			$background_path = I('post.background_path');
			$background_path = edit_upload_image($background_path);

			if ($_FILES['background']['name']) {
				$type = array('image/jpeg', 'image/png');
				if ($_FILES['background']['type'] && !in_array($_FILES['background']['type'], $type)) {
					$this->message(L('not_file_type'), NULL, 2);
				}

				$result = $this->upload('data/attached/redpack', true);

				if (0 < $result['error']) {
					$this->message($result['message'], NULL, 2);
				}

				if ($_FILES['background']['name'] && $result['url']) {
					$data['background'] = $result['url'];
				}
			}
			else {
				$data['background'] = $background_path;
			}

			$form = new \Touch\Form();

			if (!$form->isEmpty($data['background'], 1)) {
				$this->message(L('please_upload'), NULL, 2);
			}

			if ($config) {
				file_write('index.html', '');
				$data['config'] = serialize($config);
			}

			if ($id) {
				if ($data['background'] && ($background_path != $data['background'])) {
					$background_path = (strpos($background_path, 'no_image') == false ? $background_path : '');
					$this->remove($background_path);
				}

				$where = array('id' => $id, 'wechat_id' => $this->wechat_id, 'marketing_type' => $data['marketing_type']);
				dao('wechat_marketing')->data($data)->where($where)->save();
				$this->message(L('market_edit') . L('success'), url('index'));
			}
			else {
				$data['addtime'] = time();
				dao('wechat_marketing')->data($data)->add();
				$this->message(L('market_add') . L('success'), url('index'));
			}
		}

		$id = I('get.id', 0, 'intval');
		$nowtime = time();

		if ($id) {
			$info = dao('wechat_marketing')->field('id, name, keywords, command, logo, background, starttime, endtime, config, description, support')->where(array('id' => $id, 'marketing_type' => $this->marketing_type, 'wechat_id' => $this->wechat_id))->find();

			if ($info) {
				$info['starttime'] = isset($info['starttime']) ? date('Y-m-d H:i:s', $info['starttime']) : date('Y-m-d H:i:s', $nowtime);
				$info['endtime'] = isset($info['endtime']) ? date('Y-m-d H:i:s', $info['endtime']) : date('Y-m-d H:i:s', strtotime('+1 months', $nowtime));
				$info['config'] = unserialize($info['config']);
				$info['background'] = get_wechat_image_path($info['background']);
			}
		}
		else {
			$info['starttime'] = date('Y-m-d H:i:s', $nowtime);
			$info['endtime'] = date('Y-m-d H:i:s', strtotime('+1 months', $nowtime));
			$last_id = dao('wechat_marketing')->where(array('wechat_id' => $this->wechat_id))->order('id desc')->getField('id');
			$id = (!empty($last_id) ? $last_id + 1 : 1);
		}

		$info['url'] = __HOST__ . url('wechat/redpack/activity', array('market_id' => $id));
		$this->assign('info', $info);
		$key = dao('wechat_marketing')->where(array('marketing_type' => $this->marketing_type, 'wechat_id' => $this->wechat_id))->count();
		$key = (!empty($key) ? $key + 1 : 1);
		$this->assign('key', $key);
		$this->display();
	}

	public function actionDel()
	{
		$id = I('get.id');

		if (!$id) {
			$this->message(L('empty'), NULL, 2);
		}

		dao('wechat_marketing')->where(array('id' => $id, 'wechat_id' => $this->wechat_id))->delete();
		$this->message(L('market_delete') . L('success'), url('index'));
	}

	public function actionShake()
	{
		$market_id = I('get.market_id', 0, 'intval');

		if (!$market_id) {
			$this->message('活动ID' . L('empty'), NULL, 2);
		}

		$filter = array('market_id' => $market_id);
		$offset = $this->pageLimit(url('shake', $filter), $this->page_num);
		$condition = array('wechat_id' => $this->wechat_id, 'market_id' => $market_id);
		$total = dao('wechat_redpack_advertice')->where($condition)->count();
		$list = dao('wechat_redpack_advertice')->where($$condition)->order('id desc')->limit($offset)->select();

		foreach ($list as $key => $value) {
			$list[$key]['icon'] = get_wechat_image_path($value['icon']);
		}

		$url = __HOST__ . url('redpack/activity', $filter);
		$this->assign('url', $url);
		$condition['marketing_type'] = $this->marketing_type;
		$act_name = dao('wechat_marketing')->where($condition)->getField('name');
		$this->assign('act_name', $act_name);
		$this->assign('page', $this->pageShow($total));
		$this->assign('market_id', $market_id);
		$this->assign('advertices', $list);
		$this->display();
	}

	public function actionShakeEdit()
	{
		if (IS_POST) {
			$id = I('post.id', 0, 'intval');
			$data = I('post.advertice');
			$icon_path = I('post.icon_path');
			$form = new \Touch\Form();

			if (!$form->isEmpty($data['content'], 1)) {
				$this->message(L('advertice_content') . L('empty'), NULL, 2);
			}

			if (substr($data['url'], 0, 4) !== 'http') {
				$this->message(L('link_err'), NULL, 2);
			}

			$icon_path = edit_upload_image($icon_path);
			$file = $_FILES['icon'];

			if ($file['name']) {
				$type = array('image/jpeg', 'image/png');

				if (!in_array($file['type'], $type)) {
					$this->message(L('not_file_type'), NULL, 2);
				}

				$result = $this->upload('data/attached/redpack', true);

				if (0 < $result['error']) {
					$this->message($result['message'], NULL, 2);
				}

				$data['icon'] = $result['url'];
				$data['file_name'] = $file['name'];
				$data['size'] = $file['size'];
			}
			else {
				$data['icon'] = $icon_path;
			}

			if (!$form->isEmpty($data['icon'], 1)) {
				$this->message(L('please_upload'), NULL, 2);
			}

			if ($id) {
				if ($data['icon'] && ($icon_path != $data['icon'])) {
					$icon_path = (strpos($icon_path, 'no_image') == false ? $icon_path : '');
					$this->remove($icon_path);
				}

				$where = array('id' => $id, 'wechat_id' => $this->wechat_id);
				dao('wechat_redpack_advertice')->data($data)->where($where)->save();
				$this->message(L('wechat_editor') . L('success'), url('shake', array('market_id' => $data['market_id'])));
			}
			else {
				$data['wechat_id'] = $this->wechat_id;
				dao('wechat_redpack_advertice')->data($data)->add();
				$this->message(L('add') . L('success'), url('shake', array('market_id' => $data['market_id'])));
			}
		}

		$advertices_id = I('get.id', 0, 'intval');
		$market_id = I('get.market_id', 0, 'intval');

		if (empty($market_id)) {
			$this->message('活动ID' . L('empty'), NULL, 2);
		}

		if ($advertices_id) {
			$where = array('wechat_id' => $this->wechat_id, 'id' => $advertices_id);
			$info = dao('wechat_redpack_advertice')->where($where)->find();
			$info['icon'] = get_wechat_image_path($info['icon']);
			$info['act_name'] = dao('wechat_marketing')->where(array('market_id' => $market_id, 'wechat_id' => $this->wechat_id))->getField('name');
			$this->assign('info', $info);
		}

		$this->assign('market_id', $market_id);
		$this->display();
	}

	public function actionShakeDelete()
	{
		$id = I('get.id', 0, 'intval');
		$market_id = I('get.market_id', 0, 'intval');

		if (empty($id)) {
			$this->message(L('empty'), NULL, 2);
		}

		$where = array('id' => $id, 'wechat_id' => $this->wechat_id);
		dao('wechat_redpack_advertice')->where($where)->delete();
		$url = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url('shake', array('market_id' => $market_id)));
		$this->message(L('drop') . L('success'), $url);
	}

	public function actionLogList()
	{
		$market_id = I('get.market_id', 0, 'intval');

		if (empty($market_id)) {
			$this->message(L('empty'), NULL, 2);
		}

		$filter = array('market_id' => $market_id);
		$offset = $this->pageLimit(url('log_list', $filter), $this->page_num);
		$where = array('wechat_id' => $this->wechat_id, 'market_id' => $market_id);
		$total = dao('wechat_redpack_log')->where($where)->count();
		$list = dao('wechat_redpack_log')->where($where)->order('id desc')->limit($offset)->select();

		foreach ($list as $key => $value) {
			$list[$key]['nickname'] = dao('wechat_user')->where(array('wechat_id' => $this->wechat_id, 'openid' => $value['openid']))->getField('nickname');
			$list[$key]['time'] = date('Y-m-d H:i:s', $value['time']);
		}

		$this->assign('page', $this->pageShow($total));
		$this->assign('market_id', $market_id);
		$this->assign('redpacks', $list);
		$this->display();
	}

	public function actionLogEdit()
	{
		if (IS_POST) {
			$id = I('post.id', 0, 'intval');
			$market_id = I('post.market_id', 0, 'intval');
			$data = I('post.redpack');
			$data['time'] = strtotime($data['time']);

			if ($id) {
				$where = array('id' => $id, 'wechat_id' => $this->wechat_id);
				$data['market_id'] = $market_id;
				dao('wechat_redpack_log')->data($data)->where($where)->save();
				exit(json_encode(array('status' => 1, 'msg' => L('wechat_editor') . L('success'))));
			}
			else {
				$data['wechat_id'] = $this->wechat_id;
				$data['market_id'] = $market_id;
				dao('wechat_redpack_log')->data($data)->add();
				exit(json_encode(array('status' => 1, 'msg' => L('add') . L('success'))));
			}
		}

		$redpack_id = I('get.id', 0);

		if ($redpack_id) {
			$where = array('wechat_id' => $this->wechat_id, 'id' => $redpack_id);
			$info = dao('wechat_redpack_log')->where($where)->find();
			$info['time'] = date('Y-m-d H:i:s', $info['time']);
			$this->assign('info', $info);
		}

		$this->display();
	}

	public function actionLogInfo()
	{
		$id = I('get.id', 0, 'intval');
		$market_id = I('get.market_id', '', 'intval');
		if ($id && $market_id) {
			$where = array('wechat_id' => $this->wechat_id, 'id' => $id, 'market_id' => $market_id);
			$info = dao('wechat_redpack_log')->where($where)->find();
			if ($info && ($info['hassub'] == 1)) {
				$condition = array('id' => $market_id, 'wechat_id' => $this->wechat_id);
				$data = dao('wechat_marketing')->field('config')->where($condition)->find();
				$config = unserialize($data['config']);
				$configure = array('appid' => $info['wxappid'], 'partnerkey' => $config['partnerkey']);
				$WxHongbao = new \Touch\WxHongbao($configure);
				$WxHongbao->setParameter('nonce_str', $WxHongbao->create_noncestr());
				$WxHongbao->setParameter('mch_billno', $info['mch_billno']);
				$WxHongbao->setParameter('mch_id', $info['mch_id']);
				$WxHongbao->setParameter('appid', $info['wxappid']);
				$WxHongbao->setParameter('bill_type', 'MCHT');
				$responseObj = $WxHongbao->query_redpack();
				$return_code = $responseObj->return_code;
				$result_code = $responseObj->result_code;

				if ($return_code == 'SUCCESS') {
					if ($result_code == 'SUCCESS') {
						$info['status'] = $responseObj->status;
						$info['total_num'] = $responseObj->total_num;
						$info['hb_type'] = $responseObj->hb_type;
						$info['openid'] = $responseObj->openid;
						$info['send_time'] = $responseObj->send_time;
						$info['rcv_time'] = $responseObj->rcv_time;
					}
					else {
						exit(json_encode(array('status' => 0, 'msg' => $responseObj->return_msg)));
					}
				}
				else {
					exit(json_encode(array('status' => 0, 'msg' => $responseObj->return_msg)));
				}

				$this->assign('info', $info);
			}
			else {
				exit(json_encode(array('status' => 0, 'msg' => '未领取的红包无法查询')));
			}
		}

		$this->display();
	}

	public function actionLogDelete()
	{
		$id = I('get.id', 0, 'intval');
		$market_id = I('get.market_id', '', 'intval');
		$all = I('get.op', '', 'trim');

		if ($id) {
			$where = array('id' => $id, 'wechat_id' => $this->wechat_id);
			dao('wechat_redpack_log')->where($where)->delete();
		}

		if ($all == 'deleteall') {
			$where = array('wechat_id' => $this->wechat_id, 'market_id' => $market_id);
			dao('wechat_redpack_log')->where($where)->delete();
		}

		$url = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url('log_list', array('market_id' => $market_id)));
		$this->message(L('drop') . L('success'), $url);
	}

	public function actionShareSetting()
	{
		if (IS_POST) {
			$id = I('post.id', 0, 'intval');
			$data = I('post.data', '', 'trim');
			$icon_path = I('post.icon_path');
			$form = new \Touch\Form();

			if (!$form->isEmpty($data['title'], 1)) {
				$this->message(L('share_title') . L('empty'), NULL, 2);
			}

			if (!$form->isEmpty($data['description'], 1)) {
				$this->message(L('share_description') . L('empty'), NULL, 2);
			}

			if (!empty($data['link']) && (substr($data['link'], 0, 4) !== 'http')) {
				$this->message(L('link_err'), NULL, 2);
			}

			$icon_path = edit_upload_image($icon_path);
			$file = $_FILES['icon'];

			if ($file['name']) {
				$type = array('image/jpeg', 'image/png');

				if (!in_array($file['type'], $type)) {
					$this->message(L('not_file_type'), NULL, 2);
				}

				$result = $this->upload('data/attached/redpack', true);

				if (0 < $result['error']) {
					$this->message($result['message'], NULL, 2);
				}

				$data['icon'] = $result['url'];
				$data['file_name'] = $file['name'];
				$data['size'] = $file['size'];
			}
			else {
				$data['icon'] = $icon_path;
			}

			if (!$form->isEmpty($data['icon'], 1)) {
				$this->message(L('please_upload'), NULL, 2);
			}

			if ($id) {
				if ($icon_path != $data['icon']) {
					$icon_path = (strpos($icon_path, 'no_image') == false ? $icon_path : '');
					$this->remove($icon_path);
				}

				$where = array('id' => $id, 'wechat_id' => $this->wechat_id);
				dao('wechat_redpack_share')->data($data)->where($where)->save();
				$this->message(L('wechat_editor') . L('success'), url('share_setting'));
			}
			else {
				$data['wechat_id'] = $this->wechat_id;
				dao('wechat_redpack_share')->data($data)->add();
				$this->message(L('add') . L('success'), url('share_setting'));
			}
		}

		$info = dao('wechat_redpack_share')->where(array('wechat_id' => $this->wechat_id))->find();
		$info['icon'] = get_wechat_image_path($info['icon']);
		$url = __HOST__ . url('redpack/activity', array('op' => 'display'));
		$this->assign('url', $url);
		$this->assign('info', $info);
		$this->display();
	}

	public function get_market_config($id, $marketing_type)
	{
		$info = dao('wechat_marketing')->field('config')->where(array('id' => $id, 'marketing_type' => $this->marketing_type, 'wechat_id' => $this->wechat_id))->find();
		$result = unserialize($info['config']);
		return $result;
	}
}

?>
