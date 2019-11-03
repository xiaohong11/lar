<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class CommentSeller extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'comment_seller';
	protected $primaryKey = 'sid';
	public $timestamps = false;
	protected $fillable = array('user_id', 'ru_id', 'order_id', 'desc_rank', 'service_rank', 'delivery_rank', 'sender_rank', 'add_time');
	protected $guarded = array();
}

?>
