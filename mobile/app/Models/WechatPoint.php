<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatPoint extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_point';
	public $timestamps = false;
	protected $fillable = array('log_id', 'wechat_id', 'openid', 'keywords', 'createtime');
	protected $guarded = array();
}

?>
