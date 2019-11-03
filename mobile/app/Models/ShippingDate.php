<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ShippingDate extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'shipping_date';
	protected $primaryKey = 'shipping_date_id';
	public $timestamps = false;
	protected $fillable = array('start_date', 'end_date', 'select_day', 'select_date');
	protected $guarded = array();
}

?>
