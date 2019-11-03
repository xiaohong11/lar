<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class GoodsTransportExpress extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'goods_transport_express';
	public $timestamps = false;
	protected $fillable = array('tid', 'ru_id', 'admin_id', 'shipping_id', 'shipping_fee');
	protected $guarded = array();
}

?>
