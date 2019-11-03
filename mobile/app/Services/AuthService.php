<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\services;

class AuthService
{
	private $loginType;
	private $request;

	public function loginMiddleWare(array $request)
	{
		$this->request = $request;
		$result = $this->wxLogin();
		if (isset($result['token']) && isset($result['openid'])) {
			return $result;
		}

		return false;
	}

	private function wxLogin()
	{
		$this->loginType = 'wx';
		$request = $this->request;
		unset($response);
		$response = new \stdClass();
		$response->isOk = true;
		$response->data['openid'] = $request['code'];
		if ($response->isOk && isset($response->data['openid'])) {
			$attributes['openid'] = $response->data['openid'];
		}
		else {
			return false;
		}

		$result = \app\models\WechatUser::select('*')->leftjoin('users as u', 'ect_uid', '=', 'user_id')->where('openid', $attributes['openid'])->first();

		if (gettype($result) == 'NULL') {
			$result = '';
		}
		else {
			$result = $result->toArray();
		}

		if (empty($result)) {
			$username = 'wxmp' . strtolower(mb_substr($attributes['openid'], 0, 8));
			$res = \app\models\Users::where(array('user_name' => $username))->first();

			if (!empty($res)) {
				$username .= rand(100, 999);
			}

			$newUser = array('username' => $username, 'password' => $username, 'email' => $username . '@default.com');
			$result = $this->createUser($newUser);

			if ($result['error_code'] == 0) {
				$attributes['ect_uid'] = $result['user']['user_id'];
				$result = $this->createWeixinUser(array_merge($attributes, $this->request));
			}
		}

		if (!isset($result['user_id'])) {
			$result['user_id'] = $result['ect_uid'];
		}

		$token = \app\api\foundation\Token::encode(array('uid' => $result['user_id']));
		return array('token' => $token, 'openid' => $attributes['openid']);
	}

	public function webLogin()
	{
	}

	private function createUser($newUser)
	{
		if (!\app\models\Users::where(array('user_name' => $newUser['username']))->where(array('email' => $newUser['email']))->first()) {
			$data = array('user_name' => $newUser['username'], 'email' => $newUser['email'], 'password' => $this->generatePassword($newUser['password']), 'reg_time' => time(), 'user_rank' => 1, 'sex' => 0, 'alias' => $newUser['username'], 'mobile_phone' => '', 'rank_points' => 0);
			$model = new \app\models\Users();
			$model->fill($data);

			if ($model->save()) {
				$token = \app\api\foundation\Token::encode(array('uid' => $model->user_id));
				return array('error_code' => 0, 'token' => $token, 'user' => $model->toArray());
			}
			else {
				return array('error_code' => 1, 'msg' => '创建用户失败');
			}
		}
		else {
			return array('error_code' => 1, 'msg' => '用户已存在');
		}
	}

	public function generatePassword($password, $salt = false)
	{
		if ($salt) {
			return md5(md5($password) . $salt);
		}

		return md5($password);
	}

	private function createWeixinUser(array $attributes)
	{
		extract($attributes);
		$weuser = new \app\models\WechatUser();
		$weuser->wechat_id = 1;
		$weuser->subscribe = 0;
		$weuser->openid = empty($openid) ? '' : $openid;
		$weuser->nickname = empty($nickname) ? '' : $nickname;
		$weuser->sex = empty($gender) ? '' : $gender;
		$weuser->city = empty($city) ? '' : $city;
		$weuser->country = empty($country) ? '' : $country;
		$weuser->province = empty($province) ? '' : $province;
		$weuser->language = empty($language) ? '' : $language;
		$weuser->headimgurl = empty($avatarurl) ? '' : $avatarurl;
		$weuser->subscribe_time = 0;
		$weuser->remark = '';
		$weuser->privilege = '';
		$weuser->unionid = '';
		$weuser->groupid = 0;
		$weuser->ect_uid = $ect_uid;
		$weuser->bein_kefu = 0;
		$weuser->parent_id = 0;

		if ($weuser->save()) {
			return $weuser->toArray();
		}

		return false;
	}

	public function authorization()
	{
		$token = $_SERVER[strtoupper('HTTP_X_' . config('name') . '_Authorization')];

		if (empty($token)) {
			return array('error' => 1, 'msg' => strtolower('header parameter `x-' . config('name') . '-authorization` is required'));
		}

		if ($payload = \app\api\foundation\Token::decode($token)) {
			if (is_object($payload) && property_exists($payload, 'uid')) {
				return $payload->uid;
			}
		}

		if ($payload == 10002) {
			return array('error' => 1, 'msg' => 'token-expired');
		}

		return array('error' => 1, 'msg' => 'token-illegal');
	}
}


?>
