<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatMenu extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_menu';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'pid', 'name', 'type', 'key', 'url', 'sort', 'status');
	protected $guarded = array();
}

?>
