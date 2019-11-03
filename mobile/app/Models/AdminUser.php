<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class AdminUser extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'admin_user';
	protected $primaryKey = 'user_id';
	public $timestamps = false;
	protected $fillable = array('user_name', 'parent_id', 'ru_id', 'email', 'password', 'ec_salt', 'add_time', 'last_login', 'last_ip', 'action_list', 'nav_list', 'lang_type', 'agency_id', 'suppliers_id', 'todolist', 'role_id', 'major_brand', 'admin_user_img');
	protected $guarded = array();

	public function Service()
	{
		return $this->hasOne('App\\Models\\ImService', 'user_id', 'user_id');
	}
}

?>
