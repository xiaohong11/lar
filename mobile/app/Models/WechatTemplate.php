<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatTemplate extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_template';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'template_id', 'code', 'content', 'template', 'title', 'add_time', 'status');
	protected $guarded = array();
}

?>
