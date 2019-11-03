<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class VoteLog extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'vote_log';
	protected $primaryKey = 'log_id';
	public $timestamps = false;
	protected $fillable = array('vote_id', 'ip_address', 'vote_time');
	protected $guarded = array();
}

?>
