<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class CartCombo extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'cart_combo';
	protected $primaryKey = 'rec_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'session_id', 'goods_id', 'goods_sn', 'product_id', 'group_id', 'goods_name', 'market_price', 'goods_price', 'goods_number', 'goods_attr', 'img_flie', 'is_real', 'extension_code', 'parent_id', 'rec_type', 'is_gift', 'is_shipping', 'can_handsel', 'goods_attr_id', 'warehouse_id', 'area_id', 'model_attr', 'add_time');
	protected $guarded = array();
}

?>
