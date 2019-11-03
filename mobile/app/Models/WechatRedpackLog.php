<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatRedpackLog extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_redpack_log';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'market_id', 'hb_type', 'openid', 'hassub', 'money', 'time', 'mch_billno', 'mch_id', 'wxappid', 'bill_type');
	protected $guarded = array();
}

?>
