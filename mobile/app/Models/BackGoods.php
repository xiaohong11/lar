<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class BackGoods extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'back_goods';
	protected $primaryKey = 'rec_id';
	public $timestamps = false;
	protected $fillable = array('back_id', 'goods_id', 'product_id', 'product_sn', 'goods_name', 'brand_name', 'goods_sn', 'is_real', 'send_number', 'goods_attr');
	protected $guarded = array();
}

?>
