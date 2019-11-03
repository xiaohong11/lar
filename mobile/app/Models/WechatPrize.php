<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatPrize extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_prize';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'openid', 'prize_name', 'issue_status', 'winner', 'dateline', 'prize_type', 'activity_type', 'market_id');
	protected $guarded = array();
}

?>
