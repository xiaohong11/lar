<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatExtend extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_extend';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'name', 'keywords', 'command', 'config', 'type', 'enable', 'author', 'website');
	protected $guarded = array();
}

?>
