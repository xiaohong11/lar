<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class CouponsUser extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'coupons_user';
	protected $primaryKey = 'uc_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'cou_id', 'is_use', 'uc_sn', 'order_id', 'is_use_time');
	protected $guarded = array();
}

?>
