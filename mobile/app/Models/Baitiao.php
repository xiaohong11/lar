<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Baitiao extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'baitiao';
	protected $primaryKey = 'baitiao_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'amount', 'repay_term', 'over_repay_trem', 'add_time');
	protected $guarded = array();
}

?>
