<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class BaitiaoLog extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'baitiao_log';
	protected $primaryKey = 'log_id';
	public $timestamps = false;
	protected $fillable = array('baitiao_id', 'user_id', 'use_date', 'repay_date', 'order_id', 'repayed_date', 'is_repay', 'is_stages', 'stages_total', 'stages_one_price', 'yes_num', 'is_refund');
	protected $guarded = array();
}

?>
