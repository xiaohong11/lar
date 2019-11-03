<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class DrpAffiliateLog extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'drp_affiliate_log';
	protected $primaryKey = 'log_id';
	public $timestamps = false;
	protected $fillable = array('order_id', 'time', 'user_id', 'user_name', 'money', 'point', 'separate_type');
	protected $guarded = array();
}

?>
