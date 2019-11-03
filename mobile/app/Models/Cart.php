<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Cart extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'cart';
	protected $primaryKey = 'rec_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'session_id', 'goods_id', 'goods_sn', 'product_id', 'group_id', 'goods_name', 'market_price', 'goods_price', 'goods_number', 'goods_attr', 'is_real', 'extension_code', 'parent_id', 'rec_type', 'is_gift', 'is_shipping', 'can_handsel', 'model_attr', 'goods_attr_id', 'ru_id', 'shopping_fee', 'warehouse_id', 'area_id', 'add_time', 'stages_qishu', 'store_id', 'freight', 'tid', 'shipping_fee', 'store_mobile', 'take_time', 'is_checked');
	protected $guarded = array();
}

?>
