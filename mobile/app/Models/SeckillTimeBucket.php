<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class SeckillTimeBucket extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'seckill_time_bucket';
	public $timestamps = false;
	protected $fillable = array('begin_time', 'end_time', 'title');
	protected $guarded = array();
}

?>
