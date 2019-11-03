<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatShareCount extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_share_count';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'openid', 'share_type', 'link', 'share_time');
	protected $guarded = array();
}

?>
