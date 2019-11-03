<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
namespace app\http\wechat\controllers;

class WallAdmin extends Marketing
{
	private $marketing_type = 'wall';

	public function __construct()
	{
		parent::__construct();
	}

	public function actionWallIndex()
	{
		$list = dao('wechat_marketing')->field('id, name, marketing_type, command, starttime, endtime, support, status')->where(array('marketing_type' => $this->marketing_type, 'wechat_id' => $this->wechat_id))->order('id DESC')->select();

		if ($list[0]['id']) {
			foreach ($list as $k => $v) {
				$list[$k]['starttime'] = date('Y-m-d H:i:s', $v['starttime']);
				$list[$k]['endtime'] = date('Y-m-d H:i:s', $v['endtime']);
				$res = $this->get_user_msg_count($v['id']);
				$list[$k]['user_count'] = $res['user_count'];
				$list[$k]['msg_count'] = $res['msg_count'];

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

	public function actionWallEdit()
	{
		if (IS_POST) {
			$id = I('post.id');
			$data = I('post.data');
			$config = I('post.config');
			$form = new \Touch\Form();

			if (!$form->isEmpty($data['name'], 1)) {
				$this->message(L('market_name') . L('empty'), NULL, 2);
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

			$logo_path = I('post.logo_path');
			$background_path = I('post.background_path');
			$logo_path = edit_upload_image($logo_path);
			$background_path = edit_upload_image($background_path);
			if ($_FILES['logo']['name'] || $_FILES['background']['name']) {
				$type = array('image/jpeg', 'image/png');
				if (($_FILES['logo']['type'] && !in_array($_FILES['logo']['type'], $type)) || ($_FILES['background']['type'] && !in_array($_FILES['background']['type'], $type))) {
					$this->message(L('not_file_type'), NULL, 2);
				}

				$result = $this->upload('data/attached/wall', false, 5);

				if (0 < $result['error']) {
					$this->message($result['message'], NULL, 2);
				}

				if ($_FILES['logo']['name'] && $result['url']['logo']['url']) {
					$data['logo'] = $result['url']['logo']['url'];
				}

				if ($_FILES['background']['name'] && $result['url']['background']['url']) {
					$data['background'] = $result['url']['background']['url'];
				}
			}
			else {
				$data['logo'] = $logo_path;
				$data['background'] = $background_path;
			}

			if (!$form->isEmpty($data['logo'], 1)) {
				$this->message(L('please_upload'), NULL, 2);
			}

			if (!$form->isEmpty($data['background'], 1)) {
				$this->message(L('please_upload'), NULL, 2);
			}

			if ($config) {
				if (is_array($config['prize_level']) && is_array($config['prize_count']) && is_array($config['prize_name'])) {
					foreach ($config['prize_level'] as $key => $val) {
						$prize_arr[] = array('prize_level' => $val, 'prize_name' => $config['prize_name'][$key], 'prize_count' => $config['prize_count'][$key]);
					}
				}

				$data['config'] = serialize($prize_arr);
			}

			if ($id) {
				if ($data['logo'] && ($logo_path != $data['logo'])) {
					$logo_path = (strpos($logo_path, 'no_image') == false ? $logo_path : '');
					$this->remove($logo_path);
				}

				if ($data['background'] && ($background_path != $data['background'])) {
					$background_path = (strpos($background_path, 'no_image') == false ? $background_path : '');
					$this->remove($background_path);
				}

				$where = array('id' => $id, 'wechat_id' => $this->wechat_id);
				dao('wechat_marketing')->data($data)->where($where)->save();
				$this->message(L('market_edit') . L('success'), url('wall_index'));
			}
			else {
				$data['addtime'] = time();
				dao('wechat_marketing')->data($data)->add();
				$this->message(L('market_add') . L('success'), url('wall_index'));
			}
		}

		$id = I('get.id', 0, 'intval');
		$nowtime = time();

		if ($id) {
			$info = dao('wechat_marketing')->field('id, name, keywords, command, logo, background, starttime, endtime, config, description, support')->where(array('id' => $id, 'marketing_type' => $this->marketing_type, 'wechat_id' => $this->wechat_id))->find();

			if ($info) {
				$info['starttime'] = isset($info['starttime']) ? date('Y-m-d H:i:s', $info['starttime']) : date('Y-m-d H:i:s', $nowtime);
				$info['endtime'] = isset($info['endtime']) ? date('Y-m-d H:i:s', $info['endtime']) : date('Y-m-d H:i:s', strtotime('+1 months', $nowtime));
				$info['prize_arr'] = unserialize($info['config']);
				$info['logo'] = get_wechat_image_path($info['logo']);
				$info['background'] = get_wechat_image_path($info['background']);
			}
		}
		else {
			$info['starttime'] = date('Y-m-d H:i:s', $nowtime);
			$info['endtime'] = date('Y-m-d H:i:s', strtotime('+1 months', $nowtime));
			$last_id = dao('wechat_marketing')->where(array('wechat_id' => $this->wechat_id))->order('id desc')->getField('id');
			$id = (!empty($last_id) ? $last_id + 1 : 1);
		}

		$info['url'] = __HOST__ . url('wechat/wall/wall_user_wechat', array('wall_id' => $id));
		$this->assign('info', $info);
		$key = dao('wechat_marketing')->where(array('marketing_type' => $this->marketing_type, 'wechat_id' => $this->wechat_id))->count();
		$key = (!empty($key) ? $key + 1 : 1);
		$this->assign('key', $key);
		$this->display();
	}

	public function actionWallDel()
	{
		$id = I('get.id');

		if (!$id) {
			$this->message(L('empty'), NULL, 2);
		}

		dao('wechat_marketing')->where(array('id' => $id, 'wechat_id' => $this->wechat_id))->delete();
		$this->message(L('market_delete') . L('success'), url('wall_index'));
	}

	public function actionWallUser()
	{
		$id = I('get.id');

		if (!$id) {
			$this->message(L('empty'), NULL, 2);
		}

		$filter['id'] = $id;
		$offset = $this->pageLimit(url('wall_user', $filter), $this->page_num);
		$total = dao('wechat_wall_user')->where(array('wall_id' => $id, 'wechat_id' => $this->wechat_id))->count();
		$this->assign('page', $this->pageShow($total));
		$sql = 'SELECT id, nickname, sex, headimg, status, addtime FROM {pre}wechat_wall_user WHERE wechat_id = \'' . $this->wechat_id . '\'  ORDER BY addtime DESC limit ' . $offset;
		$list = $this->model->query($sql);

		if ($list[0]['id']) {
			foreach ($list as $k => $v) {
				if ($v['sex'] == 0) {
					$list[$k]['sex'] = '女';
				}
				else if ($v['sex'] == 1) {
					$list[$k]['sex'] = '男';
				}
				else {
					$list[$k]['sex'] = '保密';
				}

				if ($v['status'] == 1) {
					$list[$k]['status'] = L('is_checked');
					$list[$k]['handler'] = '';
				}
				else {
					$list[$k]['status'] = L('no_check');
					$list[$k]['handler'] = '<a class="button btn-primary" href="' . url('wall_check', array('wall_id' => $id, 'user_id' => $v['id'])) . '">' . L('check') . '</a>';
				}

				$list[$k]['nocheck'] = dao('wechat_wall_msg')->where(array('status' => 0, 'user_id' => $v['id']))->count();
				$list[$k]['addtime'] = $v['addtime'] ? date('Y-m-d H:i:s', $v['addtime']) : '';
			}
		}
		else {
			$list = array();
		}

		$this->assign('wall_id', $id);
		$this->assign('list', $list);
		$this->display();
	}

	public function actionWallPrize()
	{
		$id = I('get.id');

		if (!$id) {
			$this->message(L('empty'), NULL, 2);
		}

		$filter['id'] = $id;
		$offset = $this->pageLimit(url('wall_prize', $filter), $this->page_num);
		$sql = 'SELECT count(*) as count FROM {pre}wechat_prize p LEFT JOIN {pre}wechat_user u ON p.openid = u.openid WHERE p.activity_type = \'wall\' AND p.wechat_id = \'' . $this->wechat_id . '\' ORDER BY dateline desc';
		$count = $this->model->query($sql);
		$total = $count[0]['count'];
		$this->assign('page', $this->pageShow($total));
		$sql = 'SELECT p.id, p.prize_name, p.issue_status, p.winner, p.dateline, p.openid, u.nickname FROM {pre}wechat_prize p LEFT JOIN {pre}wechat_user u ON p.openid = u.openid WHERE p.activity_type = \'wall\' AND p.wechat_id = \'' . $this->wechat_id . '\' ORDER BY dateline desc limit ' . $offset;
		$list = $this->model->query($sql);

		if ($list) {
			foreach ($list as $k => $v) {
				$list[$k]['dateline'] = $v['dateline'] ? date('Y-m-d H:i:s', $v['dateline']) : '';
				$list[$k]['winner'] = unserialize($v['winner']);

				if ($v['issue_status'] == 1) {
					$list[$k]['issue_status'] = L('is_sended');
					$list[$k]['handler'] = '<a href="' . url('winner_issue', array('id' => $v['id'], 'cancel' => 1)) . '" class="button btn-primary">' . L('cancle_send') . '</a>';
				}
				else {
					$list[$k]['issue_status'] = L('no_send');
					$list[$k]['handler'] = '<a href="' . url('winner_issue', array('id' => $v['id'])) . '" class="button btn-primary">' . L('send') . '</a>';
				}
			}
		}

		$this->assign('wall_id', $id);
		$this->assign('list', $list);
		$this->display();
	}

	public function actionWallMsgcheck()
	{
		$wall_id = I('get.id');

		if (empty($wall_id)) {
			$this->message(L('empty'), NULL, 2);
		}

		$status = I('get.status');
		$where = '';

		if (empty($status)) {
			$where = ' AND m.status = 0';
		}

		$sql = 'SELECT COUNT(*) as num FROM {pre}wechat_wall_msg m LEFT JOIN {pre}wechat_wall_user u ON m.user_id = u.id LEFT JOIN {pre}wechat_marketing mk ON u.wall_id = mk.id WHERE mk.id = ' . $wall_id . $where;
		$num = $this->model->query($sql);
		$filter['id'] = $wall_id;
		$filter['status'] = $status;
		$offset = $this->pageLimit(url('wall_msg_check', $filter), $this->page_num);
		$total = $num[0]['num'];
		$this->assign('page', $this->pageShow($total));
		$sql = 'SELECT m.id, m.user_id, m.content, m.addtime, m.checktime, m.status, u.nickname FROM {pre}wechat_wall_msg m LEFT JOIN {pre}wechat_wall_user u ON m.user_id = u.id LEFT JOIN {pre}wechat_marketing mk ON u.wall_id = mk.id WHERE mk.id = ' . $wall_id . $where . ' ORDER BY m.addtime ASC LIMIT ' . $offset;
		$list = $this->model->query($sql);

		if ($list) {
			foreach ($list as $k => $v) {
				if ($v['status'] == 1) {
					$list[$k]['status'] = L('is_checked');
					$list[$k]['handler'] = '';
				}
				else {
					$list[$k]['status'] = L('no_check');
					$list[$k]['handler'] = '<a class="button btn-primary" href="' . url('wall_check', array('wall_id' => $wall_id, 'msg_id' => $v['id'], 'user_id' => $v['user_id'], 'status' => $status)) . '">' . L('check') . '</a>';
				}

				$list[$k]['addtime'] = $v['addtime'] ? date('Y-m-d H:i:s', $v['addtime']) : '';
				$list[$k]['checktime'] = $v['checktime'] ? date('Y-m-d H:i:s', $v['checktime']) : '';
			}
		}

		$this->assign('status', $status);
		$this->assign('wall_id', $wall_id);
		$this->assign('list', $list);
		$this->display('');
	}

	public function actionWallMsg()
	{
		$wall_id = I('get.wall_id');
		$user_id = I('get.user_id');
		if (empty($wall_id) || empty($user_id)) {
			$this->message(L('empty'), NULL, 2);
		}

		$filter['wall_id'] = $wall_id;
		$filter['user_id'] = $user_id;
		$offset = $this->pageLimit(url('wall_msg', $filter), $this->page_num);
		$total = dao('wechat_wall_msg')->where(array('user_id' => $user_id))->count();
		$this->assign('page', $this->pageShow($total));
		$list = dao('wechat_wall_msg')->field('id, content, addtime, checktime, status')->where(array('user_id' => $user_id))->order('addtime asc, checktime asc')->limit($offset)->select();

		if ($list) {
			foreach ($list as $k => $v) {
				if ($v['status'] == 1) {
					$list[$k]['status'] = L('is_checked');
					$list[$k]['handler'] = '';
				}
				else {
					$list[$k]['status'] = L('no_check');
					$list[$k]['handler'] = '<a class="button btn-primary" href="' . url('wall_check', array('wall_id' => $wall_id, 'msg_id' => $v['id'], 'user_id' => $user_id)) . '">' . L('check') . '</a>';
				}

				$list[$k]['addtime'] = $v['addtime'] ? date('Y-m-d H:i:s', $v['addtime']) : '';
				$list[$k]['checktime'] = $v['checktime'] ? date('Y-m-d H:i:s', $v['checktime']) : '';
			}
		}

		$this->assign('wall_id', $wall_id);
		$this->assign('user_id', $user_id);
		$this->assign('list', $list);
		$this->display();
	}

	public function actionWallCheck()
	{
		$wall_id = I('get.wall_id');
		$user_id = I('get.user_id');
		$msg_id = I('get.msg_id');
		if (empty($user_id) || empty($wall_id)) {
			$this->message(L('empty'), NULL, 2);
		}

		$checktime = time();
		if (!empty($wall_id) && !empty($user_id) && empty($msg_id)) {
			dao('wechat_wall_user')->data(array('status' => 1, 'checktime' => $checktime))->where(array('wall_id' => $wall_id, 'id' => $user_id, 'status' => 0))->save();
			$this->redirect(url('wall_user', array('id' => $wall_id)));
		}

		if (!empty($user_id) && !empty($msg_id)) {
			dao('wechat_wall_msg')->data(array('status' => 1, 'checktime' => $checktime))->where(array('user_id' => $user_id, 'id' => $msg_id, 'status' => 0))->save();
			dao('wechat_wall_user')->data(array('status' => 1, 'checktime' => $checktime))->where(array('id' => $user_id, 'status' => 0))->save();

			if (isset($_GET['status'])) {
				$status = I('get.status');
				$this->redirect(url('wall_msg_check', array('id' => $wall_id, 'status' => $status)));
			}

			$this->redirect(url('wall_msg', array('wall_id' => $wall_id, 'user_id' => $user_id)));
		}

		$this->redirect(url('wall_index'));
	}

	public function actionWallDataDel()
	{
		$wall_id = I('get.wall_id');
		$user_id = I('get.user_id');
		$msg_id = I('get.msg_id');
		if (empty($user_id) || empty($wall_id)) {
			$this->message(L('empty'), NULL, 2);
		}

		if (!empty($wall_id) && !empty($user_id) && empty($msg_id)) {
			dao('wechat_wall_user')->where(array('wall_id' => $wall_id, 'id' => $user_id))->delete();
			dao('wechat_wall_msg')->where(array('user_id' => $user_id))->delete();
			$this->redirect(url('wall_user', array('id' => $wall_id)));
		}

		if (!empty($user_id) && !empty($msg_id)) {
			dao('wechat_wall_msg')->where(array('user_id' => $user_id, 'id' => $msg_id))->delete();

			if (isset($_GET['status'])) {
				$status = I('get.status');
				$this->redirect(url('wall_msg_check', array('id' => $wall_id, 'status' => $status)));
			}

			$this->redirect(url('wall_msg', array('wall_id' => $wall_id, 'user_id' => $user_id)));
		}

		$this->redirect(url('wall_index'));
	}

	public function actionTowall()
	{
		$wall_id = I('get.id');

		if (empty($wall_id)) {
			exit(json_encode(array('status' => 0, 'msg' => L('empty'))));
		}

		$url = __HOST__ . url('wechat/wall/wall_user_wechat', array('wall_id' => $wall_id));
		$wall = dao('wechat_marketing')->field('qrcode')->where(array('id' => $wall_id, 'marketing_type' => $this->marketing_type, 'wechat_id' => $this->wechat_id))->find();
		$errorCorrectionLevel = 'M';
		$matrixPointSize = 7;
		$path = dirname(ROOT_PATH) . '/data/attached/wall/';
		$water_logo = ROOT_PATH . 'public/img/shop_app_icon.png';
		$water_logo_out = $path . 'water_logo' . $wall_id . '.png';
		$filename = $path . $errorCorrectionLevel . $matrixPointSize . $wall_id . '.png';

		if (!is_dir($path)) {
			@mkdir($path);
		}

		\Touch\QRcode::png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
		$img = new \Think\Image();
		$img->open($water_logo)->thumb(80, 80)->save($water_logo_out);
		$img->open($filename)->water($water_logo_out, 5, 100)->save($filename);
		$qrcode_url = __HOST__ . __STATIC__ . '/data/attached/wall/' . basename($filename) . '?t=' . time();
		$this->assign('qrcode_url', $qrcode_url);
		$this->display();
	}

	private function get_user_msg_count($wall_id)
	{
		$sql = 'SELECT count(DISTINCT u.id) as user_count, count(m.id) as msg_count FROM {pre}wechat_wall_user u LEFT JOIN {pre}wechat_wall_msg m ON u.id = m.user_id WHERE u.wall_id = \'' . $wall_id . '\' AND u.wechat_id = \'' . $this->wechat_id . '\' ';
		$res = $this->model->query($sql);
		return $res[0];
	}
}

?>
