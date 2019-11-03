<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ZcProgress extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'zc_progress';
	public $timestamps = false;
	protected $fillable = array('pid', 'progress', 'add_time', 'img');
	protected $guarded = array();
}

?>
