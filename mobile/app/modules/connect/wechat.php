<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
class wechat
{
	private $wechat = '';
	private $options = array();

	public function __construct($config)
	{
		$options = array('appid' => $config['app_id'], 'appsecret' => $config['app_secret']);
		$this->wechat = new \Touch\Wechat($options);
	}

	public function redirect($callback_url, $state = 'wechat_oauth', $snsapi = 'snsapi_userinfo')
	{
		if (is_dir(APP_WECHAT_PATH) && is_wechat_browser() && isset($_COOKIE['ectouch_ru_id'])) {
			$snsapi = 'snsapi_base';
		}

		return $this->wechat->getOauthRedirect($callback_url, $state, $snsapi);
	}

	public function callback($callback_url, $code)
	{
		if (!empty($code)) {
			$token = $this->wechat->getOauthAccessToken();
			$userinfo = $this->wechat->getOauthUserinfo($token['access_token'], $token['openid']);

			//if (!empty($userinfo) && !empty($userinfo['unionid'])) {
			if (!empty($userinfo) ) {	
				include 'emoji.php';
				$userinfo['nickname'] = strip_tags(emoji_unified_to_html($userinfo['nickname']));
				$_SESSION['openid'] = $userinfo['openid'];
				$_SESSION['nickname'] = $userinfo['nickname'];
				$_SESSION['headimgurl'] = $userinfo['headimgurl'];
				
				$userinfo['unionid'] = (isset($userinfo['unionid']) && !empty($userinfo['unionid']) ? $userinfo['unionid'] : $userinfo['openid']);
					
				$data = array('openid' => $userinfo['unionid'], 'nickname' => $userinfo['nickname'], 'sex' => $userinfo['sex'], 'headimgurl' => $userinfo['headimgurl']);
				if (is_dir(APP_WECHAT_PATH) && is_wechat_browser()) {
					$this->update_wechat_unionid($userinfo);
				}

				return $data;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}

	public function update_wechat_unionid($info)
	{
		$wechat_id = dao('wechat')->where(array('status' => 1, 'default_wx' => 1))->getField('id');
		$data = array('wechat_id' => $wechat_id, 'openid' => $info['openid'], 'unionid' => $info['unionid']);

		if (!empty($info['unionid'])) {
			$where = array('openid' => $info['openid'], 'wechat_id' => $wechat_id);
			$res = dao('wechat_user')->field('ect_uid, openid, unionid')->where($where)->find();
			if (!empty($res['ect_uid']) && empty($res['unionid'])) {
				dao('wechat_user')->data($data)->where($where)->save();
			}
		}
	}
}

defined('IN_ECTOUCH') || exit('Deny Access');
$payment_lang = LANG_PATH . C('shop.lang') . '/connect/' . basename(__FILE__);

if (file_exists($payment_lang)) {
	include_once $payment_lang;
	L($_LANG);
}

if (isset($set_modules) && ($set_modules == true)) {
	$i = (isset($modules) ? count($modules) : 0);
	$modules[$i]['name'] = 'Wechat';
	$modules[$i]['type'] = 'wechat';
	$modules[$i]['className'] = 'wechat';
	$modules[$i]['author'] = 'DM299';
	$modules[$i]['qq'] = '124861234';
	$modules[$i]['email'] = '124861234@qq.com';
	$modules[$i]['website'] = 'http://mp.weixin.qq.com';
	$modules[$i]['version'] = '1.0';
	$modules[$i]['date'] = '2017-6-13';
	$modules[$i]['config'] = array(
	array('type' => 'text', 'name' => 'app_id', 'value' => ''),
	array('type' => 'text', 'name' => 'app_secret', 'value' => ''),
	array('type' => 'radio', 'name' => 'oauth_status', 'value' => '0')
	);
	return NULL;
}

?>
