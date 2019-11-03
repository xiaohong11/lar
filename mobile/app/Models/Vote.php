<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class Vote extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'vote';
	protected $primaryKey = 'vote_id';
	public $timestamps = false;
	protected $fillable = array('vote_name', 'start_time', 'end_time', 'can_multi', 'vote_count');
	protected $guarded = array();
}

?>
