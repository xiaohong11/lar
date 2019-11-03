<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Comment extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'comment';
	protected $primaryKey = 'comment_id';
	public $timestamps = false;
	protected $fillable = array('comment_type', 'id_value', 'email', 'user_name', 'content', 'comment_rank', 'comment_server', 'comment_delivery', 'add_time', 'ip_address', 'status', 'parent_id', 'user_id', 'ru_id', 'single_id', 'order_id', 'rec_id', 'goods_tag', 'useful', 'useful_user', 'use_ip', 'dis_id', 'like_num', 'dis_browse_num');
	protected $guarded = array();

	public function user()
	{
		return $this->hasOne('App\\Models\\Users', 'user_id', 'user_id');
	}
}

?>
