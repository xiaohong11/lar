<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class UsersReal extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'users_real';
	protected $primaryKey = 'real_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'real_name', 'bank_mobile', 'bank_name', 'bank_card', 'self_num', 'add_time', 'review_content', 'review_status', 'review_time', 'user_type', 'front_of_id_card', 'reverse_of_id_card');
	protected $guarded = array();
}

?>
