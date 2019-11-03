<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class SessionsData extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'sessions_data';
	protected $primaryKey = 'sesskey';
	public $timestamps = false;
	protected $fillable = array('expiry', 'data');
	protected $guarded = array();
}

?>
