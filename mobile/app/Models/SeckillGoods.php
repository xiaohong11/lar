<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class SeckillGoods extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'seckill_goods';
	public $timestamps = false;
	protected $fillable = array('sec_id', 'tb_id', 'goods_id', 'sec_price', 'sec_num', 'sec_limit');
	protected $guarded = array();
}

?>
