<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class VirtualCard extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'virtual_card';
	protected $primaryKey = 'card_id';
	public $timestamps = false;
	protected $fillable = array('goods_id', 'card_sn', 'card_password', 'add_date', 'end_date', 'is_saled', 'order_sn', 'crc32');
	protected $guarded = array();
}

?>
