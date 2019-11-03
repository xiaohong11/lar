<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class UserBonus extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'user_bonus';
	protected $primaryKey = 'bonus_id';
	public $timestamps = false;
	protected $fillable = array('bonus_type_id', 'bonus_sn', 'bonus_password', 'user_id', 'used_time', 'order_id', 'emailed', 'bind_time');
	protected $guarded = array();
}

?>
