<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\models;

class WechatRuleKeyword extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_rule_keywords';
	public $timestamps = false;
	protected $fillable = array('rid', 'rule_keywords');
	protected $guarded = array();
}

?>
