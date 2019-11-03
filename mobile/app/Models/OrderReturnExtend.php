<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class OrderReturnExtend extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'order_return_extend';
	public $timestamps = false;
	protected $fillable = array('ret_id', 'return_number');
	protected $guarded = array();
}

?>
