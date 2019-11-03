<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ExchangeGoods extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'exchange_goods';
	protected $primaryKey = 'eid';
	public $timestamps = false;
	protected $fillable = array('goods_id', 'review_status', 'review_content', 'user_id', 'exchange_integral', 'is_exchange', 'is_hot', 'is_best');
	protected $guarded = array();
}

?>
