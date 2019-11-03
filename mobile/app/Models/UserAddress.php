<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class UserAddress extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'user_address';
	protected $primaryKey = 'address_id';
	public $timestamps = false;
	protected $fillable = array('address_name', 'user_id', 'consignee', 'email', 'country', 'province', 'city', 'district', 'street', 'address', 'zipcode', 'tel', 'mobile', 'sign_building', 'best_time', 'audit');
	protected $guarded = array();
}

?>
