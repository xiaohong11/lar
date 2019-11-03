<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class WechatWallMsg extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'wechat_wall_msg';
	public $timestamps = false;
	protected $fillable = array('wechat_id', 'wall_id', 'user_id', 'content', 'addtime', 'checktime', 'status');
	protected $guarded = array();
}

?>
