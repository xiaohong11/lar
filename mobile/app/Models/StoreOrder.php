<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class StoreOrder extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'store_order';
	public $timestamps = false;
	protected $fillable = array('order_id', 'store_id', 'ru_id', 'is_grab_order', 'grab_store_list', 'pick_code', 'take_time');
	protected $guarded = array();
}

?>
