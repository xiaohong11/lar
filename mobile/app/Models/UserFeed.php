<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class UserFeed extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'user_feed';
	protected $primaryKey = 'feed_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'value_id', 'goods_id', 'feed_type', 'is_feed');
	protected $guarded = array();
}

?>
