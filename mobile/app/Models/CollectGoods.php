<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class CollectGoods extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'collect_goods';
	protected $primaryKey = 'rec_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'goods_id', 'add_time', 'is_attention');
	protected $guarded = array();
}

?>
