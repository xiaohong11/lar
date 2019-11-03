<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ImService extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'im_service';
	public $timestamps = false;
	protected $fillable = array('user_id', 'user_name', 'nick_name', 'post_desc', 'login_time', 'chat_status', 'status');
	protected $guarded = array();

	public function AdminUser()
	{
		return $this->belongsTo('App\\Models\\AdminUser', 'user_id', 'user_id');
	}
}

?>
