<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Single extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'single';
	protected $primaryKey = 'single_id';
	public $timestamps = false;
	protected $fillable = array('order_id', 'single_name', 'single_description', 'single_like', 'user_name', 'is_audit', 'order_sn', 'addtime', 'goods_name', 'goods_id', 'user_id', 'order_time', 'comment_id', 'single_ip', 'cat_id', 'integ', 'single_browse_num', 'cover');
	protected $guarded = array();
}

?>
