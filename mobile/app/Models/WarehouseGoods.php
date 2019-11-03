<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\models;

class WarehouseGoods extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'warehouse_goods';
	protected $primaryKey = 'w_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'goods_id', 'region_id', 'region_sn', 'region_number', 'warehouse_price', 'warehouse_promote_price', 'add_time', 'last_update', 'give_integral', 'rank_integral', 'pay_integral');
	protected $guarded = array();
}

?>
