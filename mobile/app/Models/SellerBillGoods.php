<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class SellerBillGoods extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'seller_bill_goods';
	public $timestamps = false;
	protected $fillable = array('rec_id', 'order_id', 'goods_id', 'cat_id', 'proportion', 'goods_price', 'goods_number', 'goods_attr', 'drp_money');
	protected $guarded = array();
}

?>
