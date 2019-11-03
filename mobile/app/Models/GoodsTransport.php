<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class GoodsTransport extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'goods_transport';
	protected $primaryKey = 'tid';
	public $timestamps = false;
	protected $fillable = array('ru_id', 'type', 'freight_type', 'title', 'update_time');
	protected $guarded = array();
}

?>
