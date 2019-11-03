<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class ZcFocus extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'zc_focus';
	protected $primaryKey = 'rec_id';
	public $timestamps = false;
	protected $fillable = array('user_id', 'pid', 'add_time');
	protected $guarded = array();
}

?>
