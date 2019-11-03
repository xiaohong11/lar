<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MerchantsPercent extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'merchants_percent';
	protected $primaryKey = 'percent_id';
	public $timestamps = false;
	protected $fillable = array('percent_value', 'sort_order', 'add_time');
	protected $guarded = array();
}

?>
