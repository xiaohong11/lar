<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class TeamLog extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'team_log';
	protected $primaryKey = 'team_id';
	public $timestamps = false;
	protected $fillable = array('goods_id', 'start_time', 'status', 'is_show');
	protected $guarded = array();
}

?>
