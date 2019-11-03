<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Payment extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'payment';
	protected $primaryKey = 'pay_id';
	public $timestamps = false;
	protected $fillable = array('pay_code', 'pay_name', 'pay_fee', 'pay_desc', 'pay_order', 'pay_config', 'enabled', 'is_cod', 'is_online');
	protected $guarded = array();
}

?>
