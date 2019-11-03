<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class GoodsChangeLog extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'goods_change_log';
	protected $primaryKey = 'log_id';
	public $timestamps = false;
	protected $fillable = array('goods_id', 'shop_price', 'shipping_fee', 'promote_price', 'member_price', 'volume_price', 'give_integral', 'rank_integral', 'goods_weight', 'is_on_sale', 'user_id', 'handle_time', 'old_record');
	protected $guarded = array();
}

?>
