<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Feedback extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'feedback';
	protected $primaryKey = 'msg_id';
	public $timestamps = false;
	protected $fillable = array('parent_id', 'user_id', 'user_name', 'user_email', 'msg_title', 'msg_type', 'msg_status', 'msg_content', 'msg_time', 'message_img', 'order_id', 'msg_area');
	protected $guarded = array();
}

?>
