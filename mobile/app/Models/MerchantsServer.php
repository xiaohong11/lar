<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class MerchantsServer extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'merchants_server';
	protected $primaryKey = 'server_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'suppliers_desc', 'suppliers_percent', 'commission_model', 'bill_freeze_day', 'cycle', 'day_number', 'bill_time');
	protected $guarded = array();
}

?>
