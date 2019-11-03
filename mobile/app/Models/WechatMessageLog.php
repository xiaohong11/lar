<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatMessageLog extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_message_log';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'fromusername', 'createtime', 'keywords', 'msgtype', 'msgid', 'is_send');
	protected $guarded = array();
}

?>
