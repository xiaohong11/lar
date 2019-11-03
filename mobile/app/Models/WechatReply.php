<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatReply extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_reply';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'type', 'content', 'media_id', 'rule_name', 'add_time', 'reply_type');
	protected $guarded = array();
}

?>
