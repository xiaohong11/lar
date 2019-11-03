<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ShippingPoint extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'shipping_point';
	public $timestamps = false;
	protected $fillable = array('shipping_area_id', 'name', 'user_name', 'mobile', 'address', 'img_url', 'anchor', 'line');
	protected $guarded = array();
}

?>
