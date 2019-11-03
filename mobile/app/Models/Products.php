<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Products extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'products';
	protected $primaryKey = 'product_id';
	public $timestamps = false;
	protected $fillable = array('goods_id', 'goods_attr', 'product_sn', 'bar_code', 'product_number', 'product_price', 'product_market_price', 'product_warn_number', 'admin_id');
	protected $guarded = array();
}

?>
