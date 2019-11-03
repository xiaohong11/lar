<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class AuctionLog extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'auction_log';
	protected $primaryKey = 'log_id';
	public $timestamps = false;
	protected $fillable = array('act_id', 'bid_user', 'bid_price', 'bid_time');
	protected $guarded = array();
}

?>
