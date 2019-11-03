<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatRuleKeywords extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_rule_keywords';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'rid', 'rule_keywords');
	protected $guarded = array();
}

?>
