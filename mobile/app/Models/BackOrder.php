<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class BackOrder extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'back_order';
	protected $primaryKey = 'back_id';
	public $timestamps = false;
	protected $fillable = array('delivery_sn', 'order_sn', 'order_id', 'invoice_no', 'add_time', 'shipping_id', 'shipping_name', 'user_id', 'action_user', 'consignee', 'address', 'country', 'province', 'city', 'district', 'sign_building', 'email', 'zipcode', 'tel', 'mobile', 'best_time', 'postscript', 'how_oos', 'insure_fee', 'shipping_fee', 'update_time', 'suppliers_id', 'status', 'return_time', 'agency_id');
	protected $guarded = array();
}

?>
